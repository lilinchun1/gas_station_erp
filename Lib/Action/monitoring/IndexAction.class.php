<?php
import( "@.MyClass.Page" );//导入分页类
class IndexAction extends Action {
	private $userinfo = null;
	//当前代理商及下属所有子代理商id列表
	public $agentIdStr = "";
	//当前登陆者可访问的所有地区id列表
	private $ableAreaIdStr = "";
	//最新更新批号
	private $monitor_no;
	function __construct(){
		parent::__construct();
		//设置网页等待时间无限
		set_time_limit ( 0 );
		$model = new Model();
		//获取用户信息
		$this->userinfo = getUserInfo();
		if($this->userinfo['orgid']){
			//迭代出当前登录代理商及下属所有子代理商
			$sql_agent = "SELECT * FROM qd_agent";
			$que_agent = $model->query($sql_agent);
			$this->getAllChildAgent($que_agent,$this->userinfo['orgid']);
			$this->agentIdStr .= $this->userinfo['orgid'];
			$this->agentIdStr = trim($this->agentIdStr,',');
			//获取当前登录代理商及下属所有子代理商所属所有地区id
			$sqlArea = "SELECT * FROM qd_agent_area WHERE agent_id IN (".$this->agentIdStr.") GROUP BY area_id;";
			$queArea = $model->query($sqlArea);
			foreach ($queArea as $k=>$v){
				$this->ableAreaIdStr .= $v['area_id'].",";
			}
			$this->ableAreaIdStr = trim($this->ableAreaIdStr,',');
		}
		
		//获取最近通信保存批号
		$monitorNoSql = "SELECT MAX(monitor_no) monitor_no FROM dev_monitor";
		$monitorNoQue = $model->query($monitorNoSql);
		$this->monitor_no = $monitorNoQue[0]['monitor_no'];
		
		//获取可查看菜单路径
		$this->assign('urlStr', $this->userinfo['urlstr']);
		$this->assign('username', $this->userinfo['realname']);
	}
	
	/**
	 * station监控平台
	 * @param
	 * @return mixed
	 */
	function station(){
		$model = new Model();
		//添加区域查询条件
		$and = " and b.isDelete = 0 ";
		$whereRightDev = " where 1 ";
		$andNoTimeOrUnfind = "";
		$order = " ORDER BY dev_mac,dev_no ";
		//每页显示数量
		$showNum = 5;
		
		
		//当前页数
		$pageNum = $_REQUEST['pageNum']?$_REQUEST['pageNum']:1;
		//显示的类型，0显示有问题机器，1显示正常机器，2显示未知机器
		$showModel = $_REQUEST['showModel']?$_REQUEST['showModel']:0;
		//选中的地区id
		$areaId = $_REQUEST['areaId'];
		//地区等级0全国，1省级，2市级
		$level = $_REQUEST['level'];
		if($areaId){
			$sqlArea = "SELECT area_name FROM bi_area WHERE area_id = $areaId";
			$queArea = $model->query($sqlArea);
			if($level ==1){
				$and .= " and b.province like '%".$queArea[0]['area_name']."%'";
			}else if($level ==2){
				$and .= " and b.city like '%".$queArea[0]['area_name']."%'";
			}
		}
		
		//公共查询部分
		$channelName = trim($_REQUEST['channelName']);
		if($channelName){
			$and .= " AND channel_name = '$channelName' ";
		}
		$place_name = trim($_REQUEST['place_name']);
		if($place_name){
			$and .= " AND place_name = '$place_name' ";
		}
		if($this->agentIdStr){
			$and .= " AND e.agent_id in (".$this->agentIdStr.") ";
		}
		
		
		//无返回或无开机时间查询部分
		$address = trim($_REQUEST['address']);
		if($address){
			$andNoTimeOrUnfind .= " AND b.address = '$address' ";
		}
		$devMac = trim($_REQUEST['devMac']);
		if($devMac){
			$andNoTimeOrUnfind .= " AND a.dev_mac = '$devMac' ";
		}
		$devNo = trim($_REQUEST['devNo']);
		if($devNo){
			$andNoTimeOrUnfind .= " AND a.dev_no = '$devNo' ";
		}
		//判断显示未设开机时间还是未找到记录
		$devNoBeginTime = trim($_REQUEST['devNoBeginTime']);
		//查找未找到数据的机器
		if($devNoBeginTime ==1){
			$andNoTimeOrUnfind .=" and a.unfind = 1";
		//查找未设开机时间的机器
		}else if($devNoBeginTime ==2){
			$andNoTimeOrUnfind .=" and a.dev_no_begin_time = 1";
		}
			
		//硬件有问题机器数组
		$devBreakArr = array();
		//硬件有问题数组的索引，沥遍完既是硬件数量，其他选择要另设变量以做索引
		$devBreakNum = 0;
		//根据分页获取相应硬件有问题数组
		$devPageBreakArr = array();
		
		//未获取到信息的机器数组
		$devUnfindArr = array();
		//未获取信息机器数组的索引，沥遍完既是硬件数量，其他选择要另设变量以做索引
		$devUnfindNum = 0;
		//根据分页获取相应硬件数组
		$devPageUnfindArr = array();
		
		//无问题的机器数组
		$devRightArr = array();
		//未获取信息机器数组的索引，沥遍完既是硬件数量，其他选择要另设变量以做索引
		$devRightNum = 0;
		//根据分页获取相应硬件数组
		$devPageRightArr = array();
		
		//要显示的内容
		$showDevPageArr = array();
		//要显示的数量
		$showDevNum = 0;
		//最近一次是否全部没有问题
		$allOkSql = "select all_ok from dev_monitor where monitor_no = ".$this->monitor_no;
		$allOkQue = $model->query($allOkSql);
		$all_ok   = $allOkQue[0]['all_ok'];
		
		//有问题机器编号集合，包括没取到信息的机器
		$badDevNoStr = "";
		if($all_ok == 0){
			//分页起始条数和结束条数
			$beginNum = ($pageNum - 1) * $showNum;
			$endNum = $pageNum * $showNum - 1;

			//最近一次所有有问题机器
			$allBreakSql = "
			SELECT a.*,b.province,b.city,b.address,c.place_name,d.channel_name
			FROM dev_monitor a
			LEFT JOIN qd_device b ON a.dev_no = b.device_no
			LEFT JOIN qd_place c ON b.place_id = c.place_id
			LEFT JOIN qd_channel d ON b.channel_id = d.channel_id
			LEFT JOIN qd_agent e ON b.agent_id = e.agent_id
			WHERE monitor_no = ".$this->monitor_no." $and $andNoTimeOrUnfind
			ORDER BY a.wrong_begin_time
			";
			//echo $allBreakSql;exit;
			$allBreakQue = $model->query($allBreakSql);
			
			foreach($allBreakQue as $k=>$v){
				//错误延续时间
				$continueTime = time()-$v['wrong_begin_time'];
				$hour = (int)($continueTime/3600);
				$min = (int)(($continueTime%3600)/60);
				$v['continueTime'] = $hour."小时".$min."分钟";
				//转换错误开始时间
				$v['wrong_begin_time'] = date("Y-m-d H:i:s",$v['wrong_begin_time']);
				//机器有问题
				$badDevNoStr .= "'".$v['dev_no']."',";
				if($v['on_line'] == 1){
					//转换最近开机时间
					$v['start_time'] = date("Y-m-d H:i:s",$v['start_time']);
					//转换最近关机时间
					$v['shutdown_time'] = date("Y-m-d H:i:s",$v['shutdown_time']);
					$devBreakArr[$devBreakNum] = $v;
					if($devBreakNum>=$beginNum && $devBreakNum<=$endNum){
						$devPageBreakArr[] = $v;
					}
					$devBreakNum++;
				}
				//机器未返回数据，机器未设开机时间也算入
				if($v['unfind'] == 1 || $v['dev_no_begin_time'] == 1){
					$devUnfindArr[$devUnfindNum] = $v;
					if($devUnfindNum>=$beginNum && $devUnfindNum<=$endNum){
						$devPageUnfindArr[] = $v;
					}
					$devUnfindNum++;
				}
			}
			$badDevNoStr = trim($badDevNoStr,',');
		}
		
		$whereRightDev .= $badDevNoStr?" and device_no NOT IN ($badDevNoStr) ":'';
		//查找所有无问题机器
		$sqlRightDev = "
		SELECT b.MAC dev_mac, b.device_no dev_no, b.province, b.city,b.address,
		0 continueTime,0 wrong_begin_time,0 on_line,0 start_time,0 shutdown_time,
		c.place_name,d.channel_name
		FROM qd_device b
		LEFT JOIN qd_place c ON b.place_id = c.place_id
		LEFT JOIN qd_channel d ON b.channel_id = d.channel_id
		LEFT JOIN qd_agent e ON b.agent_id = e.agent_id
		$whereRightDev $and $order";
		$devRightArr = $model->query($sqlRightDev);
		$devRightNum = count($devRightArr);
		for($i=$beginNum;$i<=$endNum;$i++){
			if($devRightArr[$i]){
				$devPageRightArr[] = $devRightArr[$i];
			}
		}
		
		
		switch($showModel){
			case 0:
				$showDevPageArr = $devPageBreakArr;
				$showDevNum = $devBreakNum;
				break;
			case 1:
				$showDevPageArr = $devPageRightArr;
				$showDevNum = $devRightNum;
				break;
			case 2:
				$showDevPageArr = $devPageUnfindArr;
				$showDevNum = $devUnfindNum;
				break;
		}
		//总页数
		$countPageNum = $showDevNum%$showNum?(int)($showDevNum/$showNum)+1:$showDevNum/$showNum;
		
		$this->assign('devBreakNum',$devBreakNum);
		$this->assign('devRightNum',$devRightNum);
		$this->assign('devUnfindNum',$devUnfindNum);
		$this->assign('showDevPageArr',$showDevPageArr);
		
		//分页
		$this->assign('pageNum',$pageNum);
		$this->assign('countPageNum',$countPageNum);
		//地域
		$this->assign('areaId',$areaId);
		$this->assign('level',$level);
		
		$this->assign('showModel',$showModel);
		$this->assign('channelName',$channelName);
		$this->assign('place_name',$place_name);
		$this->assign('address',$address);
		$this->assign('devMac',$devMac);
		$this->assign('devNo',$devNo);
		
		if($showModel == 2){
			$date['showDevPageArr'] = $showDevPageArr;
			$date['pageNum'] = $pageNum;
			$date['countPageNum'] = $countPageNum;
			$date['showDevNum'] = $showDevNum;
			$date['channelName'] = $channelName;
			$date['place_name'] = $place_name;
			$date['address'] = $address;
			$date['devMac'] = $devMac;
			$date['devNo'] = $devNo;
			$date['devNoBeginTime'] = $devNoBeginTime;
			echo json_encode($date);
		}else{
			$this->assign('nowUrl', "monitoring/Index/station");
			$this->display(':station_index');
		}
	}
	//ajax获取省市信息
	function getProvinceCity(){
		$model = new Model();
		$showModel = $_REQUEST['showModel']?$_REQUEST['showModel']:0;
		$dev_count_arr = $this->getRightOrWrongNum($showModel);
		//echo json_encode($dev_count_arr);exit;
		$where = " where 1 ";
		if($this->ableAreaIdStr){
			$where .= " and a.agent_id IN (".$this->agentIdStr.") ";
		}
		$sql = "
				SELECT b.area_id,b.area_name,b.pid,b.level,0 count
				FROM qd_agent_area a
				LEFT JOIN bi_area b ON a.area_id = b.area_id
				$where
				GROUP BY a.area_id
				";
		$que = $model->query($sql);
		foreach ($que as $k=>$v){
			foreach($dev_count_arr as $countK=>$countV){
				if(substr_count($countV['province'],$v['area_name'])>0 || substr_count($countV['city'],$v['area_name'])>0){
					$que[$k]['count'] += $countV['count'];
				}
			}
			$que[$k]['area_name'] .= "(".$que[$k]['count'].")";
		}
		//如果存在省级则加上全国
		if(!$this->userinfo['orgid'] || $this->userinfo['orgid'] == 1){
			$que[] = array('area_id'=>0,'area_name'=>'全国','pid'=>0,'level'=>0);
		}
		echo json_encode($que);
	}
	
	function getRightOrWrongNum($showModel){
		$model = new Model();
		$sql = "";
		if($showModel == 0){
			$sql = "
				SELECT b.province,b.city,COUNT(*) count FROM dev_monitor a
				LEFT JOIN qd_device b ON a.dev_no = b.device_no
				WHERE
				a.monitor_no = ".$this->monitor_no."
				AND a.unfind <> 1 AND a.dev_no_begin_time <>1
				GROUP BY b.province,b.city
				ORDER BY b.province,b.city
				";
		}else if($showModel == 1){
			$sql = "
				SELECT province,city,COUNT(*) count FROM qd_device
				WHERE device_no NOT IN(SELECT dev_no FROM dev_monitor WHERE monitor_no = ".$this->monitor_no.")
				and isDelete = 0
				GROUP BY province,city
				ORDER BY province,city
				";
		}
		
		$que = $model->query($sql);
		return $que;
	}
	
	
	

	/**
	 * alert预警设置
	 * @param 
	 * @return mixed
	 */
	function alert(){
		$this->display(':alert_index');
	}
	
	/**
	 * record异常记录
	 * @param
	 * @return mixed
	 */
	function record(){
		$this->display(':record_index');
	}
	
	/**
	 * getAllChildAgent获取所有子代理商id
	 * @param
	 * @return mixed
	 */
	function getAllChildAgent($agentArr,$pid){
		foreach ($agentArr as $k=>$v){
			if($v['father_agentid'] == $pid){
				$this->agentIdStr .= $v['agent_id'].',';
				$this->getAllChildAgent($agentArr,$v['agent_id']);
			}
		}
	}
}