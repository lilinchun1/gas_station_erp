<?php
import ( "@.MyClass.Spreadsheet_Excel_Reader" );
class IndexAction extends Action {
	private $uploaded_url = "Runtime/Temp";
	public static $sendNum = 1000000;
	public static $devInfoArr = array();
	function getNewSendNum(){
		self::$sendNum++;
		return self::$sendNum;
	}
	public function index() {
		set_time_limit ( 0 );
		$port = 7659;
		$host = '192.168.0.63';
		$socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP );
		$connect = socket_connect ( $socket, $host, $port );
		
		$auth_method = 1; // 1 - MD5。2-99 - 保留未用。
		$account = "guest";
		$password = md5 ( "admin" );
		// 发送绑定请求
		$bind_rc = "BIND_RC:".$this->getNewSendNum().",auth_method:$auth_method,account:$account,password:$password;";
		socket_write ( $socket, $bind_rc, strlen ( $bind_rc ) );
		// 接收处理字符串
		$getStrArr = $this->getRespArr($socket,131072);
		//获取随机数
		$random_number = $this->getAttributeVal($getStrArr,"random_number");
		

		// 发送继续握手，附带随机验证码
		$bind_sr = "BIND_SR:".$this->getNewSendNum().",auth_method:$auth_method,account:$account,password:$password,random_number,$random_number;";
		socket_write ( $socket, $bind_sr, strlen ( $bind_sr ) );
		//获取返回各属性值数组
		$getStrArr = $this->getRespArr($socket,131072);
		//获取绑定状态
		$bind_status = $this->getAttributeVal($getStrArr,"bind_status");
		//绑定失败
		if($bind_status != 0){
			return;
		}
		
		
		$model = new Model();
		while(true){
			$sql_dev = "SELECT device_no,MAC FROM qd_device";
			$que_dev = $model->query($sql_dev);
			foreach ($que_dev as $k=>$v){
				$dev_status = "DEV_STATUS:".$this->getNewSendNum().",dev_uid:".$v['device_no'].",dev_mac:".$v['MAC'].",above_screen,touch_screen,conn_line_1,conn_line_2,conn_line_3,boot_time_length,boot_times,vol,cpu_usage,cpu,mem_usage,mem,disk_usage,disk,wifi,station_3g,wifi_conn_num,station_3g_flow,wifi_send_flow,wifi_recv_flow,conn_line_1_send,conn_line_1_recv,conn_line_2_send,conn_line_2_recv,conn_line_3_send,conn_line_3_recv,station_system,station_client,poweron_time,poweroff_time;";
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
				
				
				
			}
			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		/*
		boot_time_length 开机时长，单位：分钟
		station_system   蓝屏、系统崩溃、死机
		poweron_time     开机时间
		poweroff_time    关机时间
		*/

		
		
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
		
		
		
		
		
		$array = explode ( ";", $bind_rc_resp );
		
		
		
		if ($bind_rc_resp == "bind_rc_resp,10000023;random_number,987654;") {
			echo "1OK";
			// 发送
			$setString2 = "bind_sr,10000024;auth_method,1;account,guest;password,200820e3227815ed1756a6b531e7e0d2;random_number,987654;\0";
			socket_write ( $socket, $setString, strlen ( $setString ) );
			// 接收
			$bind_rc_resp = socket_read ( $socket, 8192 );
			if ($bind_rc_resp == "bind_sr_resp,10000024;bind_status,0;") {
				echo "2OK!";
			} else {
				echo $bind_rc_resp;
			}
		} else {
			echo $bind_rc_resp;
			$setString2 = "bind_sr,10000024;auth_method,1;account,guest;password,200820e3227815ed1756a6b531e7e0d2;random_number,641310;\0";
			socket_write ( $socket, $setString, strlen ( $setString ) );
			$bind_rc_resp = socket_read ( $socket, 8192 );
			echo "=================";
			echo $bind_rc_resp;
		}
		echo "closeing socket..";
		// socket_close ( $socket );
		echo "ok .\n\n";
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