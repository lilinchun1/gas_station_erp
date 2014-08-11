<?php
class PostDevAction extends Action {
	function dev_monitor(){
		$model = new Model('QdDevice2');
		$url  = "Runtime/Temp/dev_monitor/";
		$file = $url.date("Y-m-d")."dev_monitor.log";
		//echo $file;
		$nowTime = time();
		$devMonitorJson = trim($_POST['dev_monitor_json']);
		$devMonitorArr = (Array)json_decode($devMonitorJson);
		
		file_put_contents($file, date("Y-m-d H:i:s")."\r\n",FILE_APPEND);
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
						$data['poweron_time'] = $dev_v;
						break;
					case "poweroff_time":
						$data['poweron_time'] = $dev_v;
						break;
				}
			}
			if($data){
				$data['monitor_no_return'] = 0;
				$dev_mac = $dev_monitor['dev_mac'];
				$dev_no = $dev_monitor['dev_no'];
				$model->where("MAC = '$dev_mac' and device_no = '$dev_no'")->save($data);
			}
			file_put_contents($file, json_encode($dev_monitor)."\r\n",FILE_APPEND);
		}
		file_put_contents($file,"\r\n",FILE_APPEND);
		//echo json_encode(array(array('dev_no'=>'ABCDEFG','dev_mac'=>'11-22-33-44-55-66','station_system'=>1),array('dev_no'=>'HIJKLM','dev_mac'=>'66-55-44-33-22-11','station_system'=>0)));return;
	}
}