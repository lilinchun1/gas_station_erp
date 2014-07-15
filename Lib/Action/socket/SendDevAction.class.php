<?php
class SendDevAction extends Action {
	//socket发送序号
	public static $sendNum = 1000000;
	//所有机器各部分问题集合，机器编号做索引
	public static $devInfoArr = array();
	
	//设定延迟超出时间 15*60
	private $powerMoreTime = 900;
	//设定延迟早于时间 30*60
	private $powerLessTime = 1800;
	//间隔时间60*60
	private $callTime = 3600;

	public function index() {
		set_time_limit ( 0 );
		//发送端口号
		$port = 14527;
		//发送IP
		$host = '203.195.129.181';
		//创建一个socket
		$socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP );
		//连接对方机器
		$connect = socket_connect ( $socket, $host, $port );
		
		//初次发送参数
		$auth_method = 1; // 1 - MD5。2-99 - 保留未用。
		//用户名
		$account = "guest";
		//密码
		$password = md5 ( "qwe123" );
		//发送绑定请求
		$bind_rc = "BIND_RC:".$this->getNewSendNum().",auth_method:$auth_method,account:$account,password:$password;";
		echo $bind_rc,"<br/>";
		socket_write ( $socket, $bind_rc, strlen ( $bind_rc ) );
		//接收处理字符串
		$getStrArr = $this->getRespArr($socket,131072);
		//获取随机数
		$random_number = $this->getAttributeVal($getStrArr,"random_number");
		

		// 发送继续握手，附带随机验证码
		$bind_sr = "BIND_SR:".$this->getNewSendNum().",auth_method:$auth_method,account:$account,password:$password,random_number:$random_number;";
		echo $bind_sr,"<br/>";
		socket_write ( $socket, $bind_sr, strlen ( $bind_sr ) );
		//获取返回各属性值数组
		$getStrArr = $this->getRespArr($socket,131072);
		//获取绑定状态
		$bind_status = $this->getAttributeVal($getStrArr,"bind_status");
		//绑定失败
		if($bind_status){
			socket_close ( $socket );
			return;
		}
		
		
		$model = new Model();
		$dev_monitor = new Model("DevMonitor");
		while(true){
			$sql_dev = "
					SELECT * FROM qd_device a
					WHERE a.isDelete = 0
					";
					/*
					LEFT JOIN rule_send b ON b.target_num LIKE CONCAT('3-',a.channel_id,',') AND b.rule_status = 2
					LEFT JOIN app_upgrade c ON c.target_num LIKE CONCAT('3-',a.channel_id,',') AND c.status = 1
					*/
			$que_dev = $model->query($sql_dev);
			//信息创建时间
			$createTime = time();
			foreach ($que_dev as $k=>$v){
				//发送机器状态请求
				$dev_status = "DEV_STATUS:".$this->getNewSendNum().",dev_uid:".$v['device_no'].",dev_mac:".$v['MAC'].",above_screen,touch_screen,conn_line_1,conn_line_2,conn_line_3,boot_time_length,boot_times,vol,cpu_usage,cpu,mem_usage,mem,disk_usage,disk,wifi,station_3g,wifi_conn_num,station_3g_flow,wifi_send_flow,wifi_recv_flow,conn_line_1_send,conn_line_1_recv,conn_line_2_send,conn_line_2_recv,conn_line_3_send,conn_line_3_recv,station_system,station_client,poweron_time,poweroff_time;";
				echo $dev_status,"<br/>";
				socket_write ( $socket, $dev_status, strlen ( $dev_status ) );
				//获取返回各属性值数组
				$getStrArr = $this->getRespArr($socket,131072);
				//获取连接数
				$link_num = $this->getAttributeVal($getStrArr,"DEV_STATUS_R");
				//获取开机时长
				$boot_time_length = $this->getAttributeVal($getStrArr,"boot_time_length");
				//蓝屏、系统崩溃、死机
				$station_system = $this->getAttributeVal($getStrArr,"station_system");
				//开机时间
				$poweron_time = $this->getAttributeVal($getStrArr,"poweron_time");
				//关机时间
				$poweroff_time = $this->getAttributeVal($getStrArr,"poweroff_time");
				/*
				//上屏程序版本
				$adpg_ver = "1";
				$adpg_info = "ADPG_INFO:".$this->getNewSendNum().",dev_uid:".$v['device_no'].",dev_mac:".$v['MAC'].",adpg_ver:$adpg_ver;";
				socket_write ( $socket, $adpg_info, strlen ( $adpg_info ) );
				//获取返回各属性值数组
				$getStrArr = $this->getRespArr($socket,131072);
				//实际上屏广告版本号
				$adpg_ver_x = $this->getAttributeVal($getStrArr,"adpg_ver_x");
				
				//中屏程序版本
				$sapg_ver = "1";
				$adpg_info = "SAPG_INFO:".$this->getNewSendNum().",dev_uid:".$v['device_no'].",dev_mac:".$v['MAC'].",sapg_ver:$sapg_ver;";
				socket_write ( $socket, $adpg_info, strlen ( $adpg_info ) );
				//获取返回各属性值数组
				$getStrArr = $this->getRespArr($socket,131072);
				//实际中屏程序版本号
				$sapg_ver_x = $this->getAttributeVal($getStrArr,"sapg_ver_x");
				*/
				
				//判断各项问题，插入数据库
				$data = array();
				$data['dev_mac'] = $v['MAC'];
				$data['dev_no']  = $v['device_no'];
				$data['createtime'] = $createTime;
				//默认0是全正常，无需存储
				$hasTrouble = 0;
				
				//判断系统是否正常在线，下线
				//现在时间
				$nowTime = time();
				//当天0点时间
				$dateTime = strtotime(date("Y-m-d"));
				//差值
				$dValue = $nowTime - $dateTime;
				//如果在正常开机允许延迟时间后和正常关机允许提前时间前关机则算不正常不在线
				if($dValue >= ($v['power_on_time'] + $this->powerMoreTime) && $dValue <= ($v['power_off_time'] - $this->powerLessTime)){
					if($station_system && $station_system != 0){
						$data['on_line'] = 1;
						$hasTrouble++;
					}
				//如果在指定时间外还在开机则也返回故障
				}else if($dValue <= ($v['power_on_time'] - $this->powerLessTime) || $dValue >= ($v['power_off_time'] + $this->powerMoreTime)){
					if($station_system == 0){
						$data['on_line'] = 1;
						$hasTrouble++;
					}
				}
				
				
				//判断是否正常开机
				if(($poweron_time - $dateTime) < ($v['power_on_time'] - $this->powerLessTime) || ($poweron_time - $dateTime) > ($v['power_on_time'] + $this->powerMoreTime)){
					$data['start_time'] = 1;
					$hasTrouble++;
				}
				
				
				//判断是否正常关机
				if(($poweroff_time - $dateTime) < ($v['power_off_time'] - $this->powerLessTime) || ($poweroff_time - $dateTime) > ($v['power_off_time'] + $this->powerMoreTime)){
					$data['shutdown_time'] = 1;
					$hasTrouble++;
				}
				
				//只存储有故障机器
				if($hasTrouble){
					$dev_monitor->add($data);
				}
			}
			sleep($this->callTime);
		}
		/*
		//心跳包
		$enquire_link = "ENQUIRE_LINK:".$this->getNewSendNum().";";
		socket_write ( $socket, $enquire_link, strlen ( $enquire_link ) );
		//获取返回各属性值数组
		$getStrArr = $this->getRespArr($socket,131072);
		//获取返回心跳包值
		$enquire_link_resp = $this->getAttributeVal($getStrArr,"ENQUIRE_LINK_RESP");
		if($enquire_link_resp != self::$sendNum){
			return;
		}
		*/
		socket_close ( $socket );
	}
	
	//获取发送序号
	function getNewSendNum(){
		self::$sendNum++;
		return self::$sendNum;
	}
	
	
	
	//给定字符串数组，获取指定属性的值
	function getAttributeVal($getStrArr,$attribute){
		foreach($getStrArr as $k=>$v){
			$attributeArr = explode(":",$v);
			if($attributeArr[0] == $attribute){
				return ltrim($v,"$attribute:");
			}
		}
		return null;
	}
	//获取返回的字符串数组
	function getRespArr($socket,$length){
		$resp = socket_read ( $socket, $length );
		echo $resp,"<br/><br/>";
		$resp = rtrim($resp,";");
		return explode(",",$resp);
	}
	
	//接收
	function js(){
		// 设置一些基本的变量
		$host = "192.168.0.63";
		$port = 7659;
		// 设置超时时间
		set_time_limit(0);
		// 创建一个Socket
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could notcreate socket\n");
		//绑定Socket到端口
		$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
		// 开始监听链接
		$result = socket_listen($socket, 3) or die("Could not set upsocket listener\n");
		// accept incoming connections
		// 另一个Socket来处理通信
		$socket2 = socket_accept($socket) or die("Could not acceptincoming connection\n");
		
		$model = new Model();
		while(true){
			$input = socket_read($socket2, 1024) or die("Could not readinput\n");
			// 输出输入字符串
			echo $input;
			$model->query("insert into test(test)values('$input')");
			socket_write ( $socket2, $input, strlen ( $input ) );
		}
		
		
		
		// 获得客户端的输入
		//$input = socket_read($socket2, 1024) or die("Could not readinput\n");
		// 输出输入字符串
		//echo $input = $input;
		//将输入结果写入ok.php，这句是我加的
		//echo $input;exit;
		//fputs(fopen('ok.php','a+'),"$input");
		
		//处理客户端输入并返回结果
		
		//$output = strrev($input) ."\n";
		socket_write ( $socket2, $input, strlen ( $input ) );
		// 关闭sockets
		//socket_close($socket2);
		//socket_close($socket);
	}
}