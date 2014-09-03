<?php
class SendDevAction extends Action {
	//加油站状态请求log文件
	private $logDevFile = "";
	//APP更新log文件
	private $logUdpFile = "";
	//日志字符串
	private $logStr = "";
	//创建时间戳
	private $createTime;
	//延迟时间5分钟
	private $delayTime = 300; 
	//判断时间范围（机器指定开机时间前后时间）15分钟
	private $areaTime = 900;
	//用于发送接收的socket
	private $socket;
	//连接socket
	private $connect;
	//对方服务器ip
	private $host = "211.155.82.229";//"203.195.129.181";//"211.155.82.229"
	//服务器端口
	private $port = 14527;
	
	//socket发送序号
	public static $sendNum = 1000000;
	
	//没有机器返回字符串
	private $noDevReturnStr = "sorry, this terminal isn't recorded";
	
	function __construct(){
		parent::__construct();
		//创建一个socket
		$this->socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP );
		//连接对方机器
		$this->connect = socket_connect ( $this->socket, $this->host, $this->port );
		//设置网页等待时间无限
		set_time_limit ( 0 );
		//信息创建时间
		$this->createTime = time();
		//第一次握手，如果失败则返回不再执行
		if(!$this->firstHandshake()){
			echo "握手失败";exit;
		}
		
		//日志部分
		$fileDev = date("Y-m-d")."Dev.log";
		$fileUdp = date("Y-m-d")."Udp.log";
		$url = "Runtime/Temp/socket_log/";
		$this->logDevFile = $url.$fileDev;
		$this->logUdpFile = $url.$fileUdp;
	}

	//请求加油站信息
	public function getDevInfo() {
		$model = new Model();
		$dev_monitor = new Model("DevMonitor");
		//事务开始
		$model->startTrans();
		$rollback = 0;
		$sql_dev = "SELECT * FROM qd_device WHERE isDelete = 0";

		$que_dev = $model->query($sql_dev);
		//标识所有机器是否都没有问题
		$hasWrongDev = 0;
		//获取上次监控批次和本次监控批次
		$sql_last_monitor_no = "SELECT MAX(monitor_no) monitor_no FROM dev_monitor";
		$que_last_monitor_no = $model->query($sql_last_monitor_no);
		$last_monitor_no = $que_last_monitor_no[0]['monitor_no']?$que_last_monitor_no[0]['monitor_no']:0;
		$monitor_no = $last_monitor_no + 1;
		
		//上次问题记录(有些需要延续)
		$sql_last_monitor = "SELECT * FROM dev_monitor WHERE monitor_no = $last_monitor_no";
		$que_last_monitor = $model->query($sql_last_monitor);
		
		foreach ($que_dev as $k=>$v){
			//上次请求该设备错误信息
			$dev_last_monitor = array();
			foreach($que_last_monitor as $last_k=>$last_v){
				if($last_v['dev_no'] == $v['device_no']){
					$dev_last_monitor = $last_v;
					break;
				}
			}
			
			
			
			//判断各项问题，插入数据库
			$data = array();
			$data['dev_mac'] = $v['MAC'];
			$data['dev_no']  = $v['device_no'];
			$data['createtime'] = $this->createTime;
			$data['monitor_no'] = $monitor_no;
			//默认0是各项属性全正常，无需存储
			$hasTrouble = 0;
			
			//发送机器状态请求
			$dev_status = "DEV_STATUS:".$this->getNewSendNum().",dev_uid:".$v['device_no'].",dev_mac:".$v['MAC'].",station_system,poweron_time,poweroff_time;";
			//发送信息并获取返回各属性值数组
			$getStrArr = $this->sendRespStrGetRespArr($dev_status,4096);
			//返回1则未返回数据
			if($getStrArr == 2){
				$rollback++;
				break;
			}
			
			//如果$getStrArr返回空或false则此设备不存在，进行下次循环
			if(!$getStrArr){
				$data['unfind'] = 1;
				$hasTrouble++;
			//机器未设开机时间的，进行下次循环
			}else if(!$v['power_on_time']){
				$data['dev_no_begin_time'] = 1;
				$hasTrouble++;
			}else{
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
					
					
				//判断系统是否正常在线，下线
				//现在时间
				$nowTime = time();
				//当天0点时间
				$dateTime = strtotime(date("Y-m-d"));
				//差值
				$dValue = $nowTime - $dateTime;
				//如果在正常开机允许延迟时间后和正常关机允许提前时间前关机则算不正常不在线
				//要区分开关机时间是否跨天
				//是否在线不判断开关机延迟情况。开关机是否正常则判断
				if($v['power_off_time']>=$v['power_on_time']){
					if($dValue >= $v['power_on_time'] && $dValue <= $v['power_off_time']){
						if($station_system != 0){
							$data['on_line'] = 1;
							$data['start_time'] = $poweron_time;
							$data['shutdown_time'] = $poweroff_time;
							$hasTrouble++;
						}
						//如果在指定时间外还在开机则也返回故障
					}else if($dValue <= $v['power_on_time'] || $dValue >= $v['power_off_time']){
						if($station_system == 0){
							$data['on_line'] = 1;
							$data['start_time'] = $poweron_time;
							$data['shutdown_time'] = $poweroff_time;
							$hasTrouble++;
						}
					}
				}else{
					if($dValue <= $v['power_off_time'] || $dValue >= $v['power_on_time']){
						if($station_system != 0){
							$data['on_line'] = 1;
							$data['start_time'] = $poweron_time;
							$data['shutdown_time'] = $poweroff_time;
							$hasTrouble++;
						}
					}else if($dValue >= $v['power_off_time'] && $dValue <= $v['power_on_time']){
						if($station_system == 0){
							$data['on_line'] = 1;
							$data['start_time'] = $poweron_time;
							$data['shutdown_time'] = $poweroff_time;
							$hasTrouble++;
						}
						//如果在指定时间外还在开机则也返回故障
					}
				}
			}
			
			
			
			//只存储有故障机器
			if($hasTrouble){
				//如果上次错误中有此机器则报错时间仍维持上次时间，否则本次时间
				if($dev_last_monitor){
					$data['wrong_begin_time'] = $dev_last_monitor['wrong_begin_time'];
				}else{
					$data['wrong_begin_time'] = $this->createTime;
				}
				$dev_monitor->add($data);
				$hasWrongDev++;
			}
		}
		if($hasWrongDev == 0){
			$data = array();
			$data['all_ok'] = 1;
			$data['monitor_no'] = $monitor_no;
			$data['createtime'] = $this->createTime;
			$dev_monitor->add($data);
		}
		
		//删除本次七天之前的数据
		$sevDaySql = " SELECT monitor_no FROM dev_monitor WHERE createtime < NOW()-3600*24*7 LIMIT 1 ";
		$sevDayMonitorNoQue = $model->query($sevDaySql);
		$sql_del = "DELETE FROM `dev_monitor` WHERE monitor_no <= " . $sevDayMonitorNoQue[0]['monitor_no'];
		$model->query($sql_del);

		if($rollback){
			$model->rollback();
		}else{
			$model->commit();
		}
		
		file_put_contents($this->logDevFile, $this->logStr,FILE_APPEND);
		socket_close ( $this->connect );
		socket_close ( $this->socket );
		//循环刷新
		echo "<script type='text/javascript'> var iID=setTimeout(function(){location.reload();},1000*10*60);</script>";
	}
	
	//发送更新请求
	function updateApp($channel_id_str,$down_url,$save_path,$file_md5,$updateId,$appType){
		$model = new Model();
		$appUpdateStatus = new Model("AppUpdateStatus");
		$where = "where 1";
		//如果$channel_id_str不存在值则推送全部机器
		if($channel_id_str){
			$where .= " and CONCAT('3-',channel_id) IN ($channel_id_str) ";
		}
		$sql_dev = "SELECT MAC,device_no FROM qd_device $where";
		$que_dev = $model->query($sql_dev);
		
		$sql_status = "SELECT * FROM app_update_status WHERE update_id = $updateId";
		$que_status = $model->query($sql_status);
		//$sql_dev = "SELECT MAC,device_no FROM qd_device WHERE CONCAT('3-',channel_id) IN ('3-22','3-2')";
		
		foreach ($que_dev as $k=>$v){
			//发送机器状态请求
			$online_handle = "ONLINE_HANDLE:".$this->getNewSendNum().",dev_uid:".$v['device_no'].",dev_mac:".$v['MAC'].",command:update,web_url:$down_url,path:$save_path,md5:$file_md5;";
			//发送信息并获取返回各属性值数组
			$getStrArr = $this->sendRespStrGetRespArr($online_handle,4096);

			//获取更新状态
			$result = $this->getAttributeVal($getStrArr,"result");
			$status = $result == 0?1:2;
			$data = array();
			//填入对呀字段更新成功状态及时间
			switch($appType){
				case C("SmartAppName"):
					$data['smart_app'] = $status;
					$data['smart_app_time'] = time();
					break;
				case C("VideoPlayerName"):
					$data['video_player'] = $status;
					$data['video_player_time'] = time();
					break;
				case C("UpdateAppName"):
					$data['update_app'] = $status;
					$data['update_app_time'] = time();
					break;
				case C("SmartGuardName"):
					$data['smart_guard'] = $status;
					$data['smart_guard_time'] = time();
					break;
			}
			
			//数据库中是否已有该加油站信息0没有，否则有
			$hasStatus = 0;
			foreach ($que_status as $statusK=>$statusV){
				if($statusV['dev_no'] == $v['device_no']){
					$appUpdateStatus->where("update_id = '$updateId'")->save($data);
					$hasStatus++;
					break;
				}
			}
			//没有则添加
			if($hasStatus == 0){
				$data['update_id'] = $updateId;
				$data['dev_mac'] = $v['MAC'];
				$data['dev_no'] = $v['device_no'];
				$appUpdateStatus->add($data);
			}
		}
		file_put_contents($this->logUdpFile, $this->logStr,FILE_APPEND);
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
		$this->logStr .= "\r\n\r\n".date("Y-m-d H:i:s",$this->createTime)."\r\n";
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
	
	
	//发送接收信息返回数组
	function sendRespStrGetRespArr($sendStr,$getStrLength,$sendNum = 1,$getNum = 1){
		//发送字符串
		socket_write ( $this->socket, $sendStr, strlen ( $sendStr ) );
		echo $sendStr,"<br/>";
		$this->logStr .= $sendStr."\r\n";
		//接收
		$resp = socket_read ( $this->socket, $getStrLength );
		echo $resp,"<br/><br/>";
		$this->logStr .= $resp."\r\n\r\n";
		$resp = rtrim($resp,";");
		if(!trim($resp)){
			return 2;
		}
		if(substr_count($resp,$this->noDevReturnStr) > 0){
			return false;
		}
		return explode(",",$resp);
	}
}