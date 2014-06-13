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
		$auth_method = 1;//1 - MD5。2-99  - 保留未用。
		$passWord = md5("admin");
		// 发送
		$setString = "BIND_RC:$sendNum;auth_method:$auth_method;account:guest;password:$passWord;\0";
		socket_write ( $socket, $setString, strlen ( $setString ) );
		// 接收
		$out = socket_read ( $socket, 8192 );
		$array=explode(";",$out);
		
		
		
		
		
		
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
}