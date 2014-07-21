<?php
class SendDevAction extends Action {
	private $fJuBing = null;
	
	//用于发送接收的socket
	private $socket;
	//连接socket
	private $connect;
	//对方服务器ip
	private $host = "211.155.82.229";
	//服务器端口
	private $port = 14527;
	
	//socket发送序号
	public static $sendNum = 1000000;
	//所有机器各部分问题集合，机器编号做索引
	public static $devInfoArr = array();
	
	function __construct(){
		parent::__construct();
		//创建一个socket
		$this->socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP );
		//连接对方机器
		$this->connect = socket_connect ( $this->socket, $this->host, $this->port );
		//设置网页等待时间无限
		set_time_limit ( 0 );
		//第一次握手，如果失败则返回不再执行
		if(!$this->firstHandshake()){
			return;
		}
		
		//日志部分
		$file = date("Y-m-d").".log";
		$url = "Runtime/Temp/socket_log/";
		if(!is_dir($url)){
			mkdir($url);
			chmod($url, 0777);
		}
		$this->fJuBing = fopen($url.$file, 'a'); //创建指定文件写操作的句柄
	}

	public function getDevInfo() {
		$model = new Model();
		$dev_monitor = new Model("DevMonitor");
		$sql_dev = "SELECT * FROM qd_device WHERE isDelete = 0";
				/*
				LEFT JOIN rule_send b ON b.target_num LIKE CONCAT('3-',a.channel_id,',') AND b.rule_status = 2
				LEFT JOIN app_upgrade c ON c.target_num LIKE CONCAT('3-',a.channel_id,',') AND c.status = 1
				*/
		$que_dev = $model->query($sql_dev);
		//信息创建时间
		$createTime = time();
		//查看所有机器是否都没有问题
		$hasWrongDev = 0;
		//获取上次监控批次和本次监控批次
		$sql_monitor_no = "SELECT MAX(monitor_no) monitor_no FROM dev_monitor";
		$que_monitor_no = $model->query($sql_monitor_no);
		$last_monitor_no = $que_monitor_no[0]['monitor_no']?$que_monitor_no[0]['monitor_no']:0;
		$monitor_no = $last_monitor_no + 1;
		
		foreach ($que_dev as $k=>$v){
			//发送机器状态请求
			$dev_status = "DEV_STATUS:".$this->getNewSendNum().",dev_uid:".$v['device_no'].",dev_mac:".$v['MAC'].",above_screen,touch_screen,conn_line_1,conn_line_2,conn_line_3,boot_time_length,boot_times,vol,cpu_usage,cpu,mem_usage,mem,disk_usage,disk,wifi,station_3g,wifi_conn_num,station_3g_flow,wifi_send_flow,wifi_recv_flow,conn_line_1_send,conn_line_1_recv,conn_line_2_send,conn_line_2_recv,conn_line_3_send,conn_line_3_recv,station_system,station_client,poweron_time,poweroff_time;";
			//发送信息并获取返回各属性值数组
			$getStrArr = $this->sendRespStrGetRespArr($dev_status,4096);
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
			
			//判断各项问题，插入数据库
			$data = array();
			$data['dev_mac'] = $v['MAC'];
			$data['dev_no']  = $v['device_no'];
			$data['createtime'] = $createTime;
			$data['monitor_no'] = $monitor_no;
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
			//要区分开关机时间是否跨天
			if($v['power_off_time']>=$v['power_on_time']){
				if($dValue >= $v['power_on_time'] && $dValue <= $v['power_off_time']){
					if($station_system != 0){
						$data['on_line'] = 1;
						$hasTrouble++;
					}
					//如果在指定时间外还在开机则也返回故障
				}else if($dValue <= $v['power_on_time'] || $dValue >= $v['power_off_time']){
					if($station_system == 0){
						$data['on_line'] = 1;
						$hasTrouble++;
					}
				}
			}else{
				if($dValue <= $v['power_off_time'] || $dValue >= $v['power_on_time']){
					if($station_system != 0){
						$data['on_line'] = 1;
						$hasTrouble++;
					}
				}else if($dValue >= $v['power_off_time'] && $dValue <= $v['power_on_time']){
					if($station_system == 0){
						$data['on_line'] = 1;
						$hasTrouble++;
					}
					//如果在指定时间外还在开机则也返回故障
				}
			}
			
			//只有当在线或者正常关机时判断开机是否正常
			if(($station_system == 0 || $station_system == 1) && $poweron_time){
				//判断是否正常开机
				if(($poweron_time - $dateTime) < $v['power_on_time'] || ($poweron_time - $dateTime) > $v['power_on_time']){
					$data['start_time'] = 1;
					$hasTrouble++;
				}
			}
			
			//只有正常关机，并且存在关机时间时，判断关机是否正常
			if($station_system == 1 && $poweroff_time){
				//判断是否正常关机
				if(($poweroff_time - $dateTime) < $v['power_off_time']  || ($poweroff_time - $dateTime) > $v['power_off_time'] ){
					$data['shutdown_time'] = 1;
					$hasTrouble++;
				}
			}
			
			
			//只存储有故障机器
			if($hasTrouble){
				//如果上次错误中有此机器则报错时间仍维持上次时间，否则本次时间
				$sql = "SELECT wrong_begin_time FROM dev_monitor WHERE monitor_no = $last_monitor_no AND dev_no = '$v[device_no]'";
				$que = $model->query($sql);
				if($que){
					$data['wrong_begin_time'] = $que[0]['wrong_begin_time'];
				}else{
					$data['wrong_begin_time'] = $createTime;
				}
				
				$dev_monitor->add($data);
				$hasWrongDev++;
			}
		}
		if($hasWrongDev == 0){
			$data = array();
			$data['all_ok'] = 1;
			$data['monitor_no'] = $monitor_no;
			$data['createtime'] = $createTime;
			$dev_monitor->add($data);
		}
		fclose($this->fJuBing);
		socket_close ( $this->connect );
		socket_close ( $this->socket );
		//循环刷新
		echo "<script type='text/javascript'> var iID=setTimeout(function(){location.reload();},1000*10*60);</script>";
	}
	
	//发送更新请求
	function updateApp($channel_id_str,$down_url,$save_path,$file_md5){
		$model = new Model();
		$where = "where 1";
		//如果$channel_id_str不存在值则推送全部机器
		if($channel_id_str){
			$where .= " and CONCAT('3-',channel_id) IN ($channel_id_str) ";
		}
		$sql_dev = "SELECT MAC,device_no FROM qd_device $where";
		//$sql_dev = "SELECT MAC,device_no FROM qd_device WHERE CONCAT('3-',channel_id) IN ('3-22','3-2')";
		$que_dev = $model->query($sql_dev);
		foreach ($que_dev as $k=>$v){
			//发送机器状态请求
			$online_handle = "ONLINE_HANDLE:".$this->getNewSendNum().",dev_uid:".$v['device_no'].",dev_mac:".$v['MAC'].",command:update,web_url:$down_url,path:$save_path,md5:$file_md5;";
			//发送信息并获取返回各属性值数组
			$getStrArr = $this->sendRespStrGetRespArr($online_handle,4096);
			//获取连接数
			//$link_num = $this->getAttributeVal($getStrArr,"DEV_STATUS_R");
		}
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
	//socket第一次握手
	function firstHandshake(){
		//初次发送参数
		$auth_method = 1; // 1 - MD5。2-99 - 保留未用。
		//用户名
		$account = "guest";
		//密码
		$password = md5 ( "qwe123" );
		//发送绑定请求
		$bind_rc = "BIND_RC:".$this->getNewSendNum().",auth_method:$auth_method,account:$account,password:$password;";
		$getStrArr = $this->sendRespStrGetRespArr($bind_rc,4096);
		//获取随机数
		$random_number = $this->getAttributeVal($getStrArr,"random_number");
		
		
		//发送继续握手，附带随机验证码
		$bind_sr = "BIND_SR:".$this->getNewSendNum().",auth_method:$auth_method,account:$account,password:$password,random_number:$random_number;";
		$getStrArr = $this->sendRespStrGetRespArr($bind_sr,4096);
		//获取绑定状态
		$bind_status = $this->getAttributeVal($getStrArr,"bind_status");
		//绑定失败
		if($bind_status){
			socket_close ( $this->socket );
			return false;
			//$this->redirect('SendDev/getDevArr', array('cate_id'=>2), 2,' 页面跳转中 ~');
		}
		return true;
	}
	
	
	//发送信息
	function sendRespStrGetRespArr($sendStr,$getStrLength){
		//发送字符串
		socket_write ( $this->socket, $sendStr, strlen ( $sendStr ) );
		echo $sendStr,"<br/>";
		fwrite($$this->fJuBing, $sendStr.'\r\n');
		//接收
		$resp = socket_read ( $this->socket, $getStrLength );
		echo $resp,"<br/><br/>";
		fwrite($this->fJuBing, $resp.'\r\n');
		$resp = rtrim($resp,";");
		
		
		
		return explode(",",$resp);
	}
}