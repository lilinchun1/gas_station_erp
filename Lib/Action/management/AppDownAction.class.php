<?php
class AppDownAction extends Action {
	private $smartapp_uploaded_url    = "DevAppDownLoad/SmartApp/";
	private $smartguard_uploaded_url  = "DevAppDownLoad/SmartGuard/";
	private $updateapp_uploaded_url   = "DevAppDownLoad/UpdateApp/";
	private $videoplayer_uploaded_url = "DevAppDownLoad/VideoPlayer/";
	
	
	/**
	 * appDown 下载
	 */
	function index(){
		echo php_sapi_name();
		//phpinfo();
	}
	
	/**
	 * appDown 下载
	 */
	function appDown(){
		$file_dir = "";
		$file_name = "";
		$appType = $_GET['appType'];
		$version = $_GET['version'];
		//根据要下载的APP类型锁定下载文件夹路径及文件名
		switch($appType){
			case "SmartApp":$file_dir = $this->smartapp_uploaded_url.$version.'/';
				$file_name = C("SmartAppName");;
				break;
			case "VideoPlayer":$file_dir = $this->videoplayer_uploaded_url.$version.'/';
				$file_name = C("VideoPlayerName");
				break;
			case "UpdateApp":$file_dir = $this->updateapp_uploaded_url.$version.'/';
				$file_name = C("UpdateAppName");
				break;
			case "SmartGuard":$file_dir = $this->smartguard_uploaded_url.$version.'/';
				$file_name = C("SmartGuardName");
				break;
		}
		//echo md5_file($file_dir . $file_name);exit;
		if (!file_exists($file_dir . $file_name)) { //检查文件是否存在
			echo $file_dir;exit;
			echo "文件找不到";
			exit;
		} else {
			// 输入文件标签
			Header("Content-type: application/octet-stream"); //指定以下输出的字符将以下载文件形式保存在客户端
			Header("Accept-Ranges: bytes");//指定下载的文件大小单位
			Header("Accept-Length: " . filesize($file_dir . $file_name));//指定下载的文件大小
			Header("Content-Disposition: attachment; filename=" . $file_name); //指定下载的文件名.扩展名
			$file = fopen($file_dir . $file_name, "r"); // 打开文件
			// 输出文件内容，除了下载文件编码之外该页面不能有任何其他输出
			echo fread($file, filesize($file_dir . $file_name));
			fclose($file);
			exit; //防止读取下面的其他输出
		}
	}
}