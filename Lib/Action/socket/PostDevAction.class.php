<?php
class PostDevAction extends Action {
	function dev_monitor(){
		$model  = new Model('QdDevice2');
		//回报日志路径
		$logUrl = "Runtime/Temp/dev_monitor/";
		$logFile = $logUrl.date("Y-m-d")."dev_monitor.log";
		//本次回报时间
		$nowTime = time();
		//回报json
		$devMonitorJson = trim($_POST['dev_monitor_json']);
		//转换成数组
		$devMonitorArr = (Array)json_decode($devMonitorJson);
		//输出log开始时间
		file_put_contents($logFile, date("Y-m-d H:i:s",$nowTime)."\r\n",FILE_APPEND);
		//沥遍获取每一个机器信息
		foreach ($devMonitorArr as $k=>$dev_monitor){
			$dev_monitor = (Array)$dev_monitor;
			$data = array();
			//沥遍获取机器每个传回属性值
			foreach($dev_monitor as $dev_k=>$dev_v){
				switch($dev_k){
					case "station_system":
						$data['station_sytem']      = $dev_v;
						$data['station_sytem_time'] = $nowTime;
						break;
					case "poweron_time":
						$data['monitor_power_on_time'] = $dev_v;
						break;
					case "poweroff_time":
						$data['monitor_power_off_time'] = $dev_v;
						break;
				}
			}
			if($data){
				$data['monitor_no_return'] = 0;
				$dev_mac = $dev_monitor['dev_mac'];
				//存在mac有值dev_no为空的情况，这里dev_no不做处理
				$dev_no = $dev_monitor['dev_no'];
				$model->where("MAC = '$dev_mac'")->save($data);
			}
			file_put_contents($logFile, json_encode($dev_monitor)."\r\n",FILE_APPEND);
		}
		file_put_contents($logFile,"\r\n",FILE_APPEND);
		//$arr[] = array('dev_no'=>'ABCDEFG','dev_mac'=>'11-22-33-44-55-66','station_system'=>1,'poweron_time'=>111111111,'poweroff_time'=>22222222);
		//echo json_encode($arr);return;
		//[{"dev_no":"ABCDEFG","dev_mac":"11-22-33-44-55-66","station_system":1,"poweron_time":111111111,"poweroff_time":22222222},{"dev_no":"HIJKLM","dev_mac":"66-55-44-33-22-11","station_system":0,"poweron_time":333333333,"poweroff_time":44444444}]
	}
}