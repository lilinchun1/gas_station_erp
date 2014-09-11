<?php
class PostDevAction extends Action {
	function dev_monitor(){
		$model  = new Model("QdDevice2");
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
	
	
	function exportChoose(){
		$whereSql = " WHERE 1 ";
		if($_GET['export'] == 1){
			$whereSql .= " AND monitor_no = (SELECT MAX(monitor_no) FROM dev_monitor) ";
			$this->exportDo($whereSql);
		}else if($_GET['export'] == 2){
			$beginTime = strtotime(trim($_GET['beginTime']));
			$endTime   = strtotime(trim($_GET['endTime']));
			$whereSql .= "
					AND a.createtime >=$beginTime AND a.createtime <=$endTime
					GROUP BY a.dev_mac,a.dev_no,a.unfind,a.dev_no_begin_time,a.on_line
					";
			$this->exportDo($whereSql);
		}
		$this->display(':index');
	}
	
	function exportDo($whereSql){
		$model = new Model();
		$sql = "
				SELECT
				f.area_name province,g.area_name city,e.agent_name,d.channel_name,c.place_name,b.address,a.dev_mac,a.dev_no,
				IF(a.unfind = 1,'无返回数据','正常') unfind,
				IF(a.unfind = 0,IF(a.dev_no_begin_time = 1,'未设开机时间','正常'),'') dev_no_begin_time,
				IF(a.unfind = 0 AND a.dev_no_begin_time = 0,IF(a.on_line = 1,'不正常','正常'),'') on_line,
				IF(a.start_time <> 0,FROM_UNIXTIME( a.start_time),'') start_time,
				IF(a.on_line = 1 ,FROM_UNIXTIME( a.wrong_begin_time),'') wrong_begin_time,
				FROM_UNIXTIME( a.createtime) createtime
				FROM `dev_monitor` a
				LEFT JOIN qd_device b ON a.dev_no = b.device_no
				LEFT JOIN qd_place c ON b.place_id = c.place_id
				LEFT JOIN qd_channel d ON b.channel_id = d.channel_id
				LEFT JOIN qd_agent e ON b.agent_id = e.agent_id
				LEFT JOIN bi_area f ON b.province_id = f.area_id
				LEFT JOIN bi_area g ON b.city_id = g.area_id
				$whereSql
				AND b.isDelete = 0
				ORDER BY b.agent_id,b.channel_id,b.place_id,a.dev_mac,a.dev_no,a.unfind DESC,a.dev_no_begin_time DESC,a.on_line DESC
			";
		$que = $model->query($sql);
		
		$fileName = $que[0]['createtime'].".xls";
		header("Content-Type:application/vnd.ms-excel;charset=UTF-8");
		header("Content-Disposition: attachment; filename=" . $fileName);
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		
		echo iconv("utf-8", "gbk", "省") . "\t" . iconv("utf-8", "gbk", "市"). "\t"
				. iconv("utf-8", "gbk", "代理商"). "\t" . iconv("utf-8", "gbk", "渠道"). "\t"
				. iconv("utf-8", "gbk", "网点"). "\t" . iconv("utf-8", "gbk", "点位"). "\t"
				. iconv("utf-8", "gbk", "mac地址"). "\t" . iconv("utf-8", "gbk", "机器编号"). "\t"
				. iconv("utf-8", "gbk", "获取数据"). "\t" . iconv("utf-8", "gbk", "是否已设开机时间"). "\t"
				. iconv("utf-8", "gbk", "在线状态"). "\t" . iconv("utf-8", "gbk", "最近开机时间"). "\t"
				. iconv("utf-8", "gbk", "报警开始时间");
		foreach($que as $k=>$v){
			echo "\n" . iconv("utf-8", "gbk", $v['province']) . "\t" . iconv("utf-8", "gbk", $v['city']). "\t"
					. iconv("utf-8", "gbk", $v['agent_name']). "\t". iconv("utf-8", "gbk", $v['channel_name']). "\t"
					. iconv("utf-8", "gbk", $v['place_name']). "\t". iconv("utf-8", "gbk", $v['address']). "\t"
					. iconv("utf-8", "gbk", $v['dev_mac']). "\t". iconv("utf-8", "gbk", $v['dev_no']). "\t"
					. iconv("utf-8", "gbk", $v['unfind']). "\t". iconv("utf-8", "gbk", $v['dev_no_begin_time']). "\t"
					. iconv("utf-8", "gbk", $v['on_line']). "\t". iconv("utf-8", "gbk", $v['start_time']). "\t"
					. iconv("utf-8", "gbk", $v['wrong_begin_time']);
		}
		exit;
	}
}