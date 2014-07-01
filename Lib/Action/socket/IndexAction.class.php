<?php
import ( "@.MyClass.Spreadsheet_Excel_Reader" );
class IndexAction extends Action {
	private $uploaded_url = "Runtime/Temp";
	public function index() {
		// error_reporting(E_ALL);
		set_time_limit ( 0 );
		$port = 7659;
		$host = '192.168.0.63';
		
		$socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP );
		echo "Attempting to connect to '$host' on port '$port'...";
		$result = socket_connect ( $socket, $host, $port );
		
		$sendNum = 10000001;
		$auth_method = 1; // 1 - MD5。2-99 - 保留未用。
		$passWord = md5 ( "admin" );
		// 发送
		$setString = "BIND_RC:$sendNum;auth_method:$auth_method;account:guest;password:$passWord;\0";
		socket_write ( $socket, $setString, strlen ( $setString ) );
		// 接收
		$out = socket_read ( $socket, 8192 );
		$array = explode ( ";", $out );
		
		
		
		if ($out == "bind_rc_resp,10000023;random_number,987654;") {
			echo "1OK";
			// 发送
			$setString2 = "bind_sr,10000024;auth_method,1;account,guest;password,200820e3227815ed1756a6b531e7e0d2;random_number,987654;\0";
			socket_write ( $socket, $setString, strlen ( $setString ) );
			// 接收
			$out = socket_read ( $socket, 8192 );
			if ($out == "bind_sr_resp,10000024;bind_status,0;") {
				echo "2OK!";
			} else {
				echo $out;
			}
		} else {
			echo $out;
			$setString2 = "bind_sr,10000024;auth_method,1;account,guest;password,200820e3227815ed1756a6b531e7e0d2;random_number,641310;\0";
			socket_write ( $socket, $setString, strlen ( $setString ) );
			$out = socket_read ( $socket, 8192 );
			echo "=================";
			echo $out;
		}
		echo "closeing socket..";
		// socket_close ( $socket );
		echo "ok .\n\n";
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