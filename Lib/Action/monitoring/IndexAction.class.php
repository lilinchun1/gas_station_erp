<?php
class IndexAction extends Action {
	private $userinfo = null;
	function __construct(){
		parent::__construct();
		//获取用户信息
		$this->userinfo = getUserInfo();
		//echo json_encode($this->userinfo);exit;
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
		//每页显示数量
		$showNum = 10;
		//当前页数
		$pageNum = 1;
		//选中的地区id
		$areaId = "";
		
		$model = new Model();
		
		//根据当前用户代理商显示
		$and = "";
		$agentIdStr = "";
		if($areaId){
			$agentIdSql = "SELECT agent_id FROM qd_agent_area WHERE area_id = $areaId";
			$agentIdQue = $model->query($agentIdSql);
			foreach ($agentIdQue as $k=>$v){
				$agentIdStr .= $v['agent_id'].",";
			}
			//如果该地区下没有代理商则不显示
			if($agentIdStr == ""){
				return;
			}
		}
		if($this->userinfo['orgid']){
			//该用户所在代理商不在该地区代理商列表内时返回空
			if($agentIdStr && substr_count($agentIdStr,$this->userinfo['orgid'].",") == 0){
				return;
			//否则在该地区代理商列表内，或者没有指定地区时返回用户所在代理商
			}else{
				$and .= " and agent_id = ".$this->userinfo['orgid'];
			}
		//当用户没有所在代理商，又有指定地区代理商时返回地区代理商
		}else if($agentIdStr){
			$agentIdStr = rtrim($agentIdStr,",");
			$and .= " and agent_id in ($agentIdStr) ";
		}
		//echo $and;exit;
		//查找所有机器数量
		$countDevSql = "select count(*) all_num from qd_device where isDelete = 0 $and ";
		$countDevQue = $model->query($countDevSql);
		$allDevNum = $countDevQue[0]['all_num'];
		
		//获取最近通信保存时间
		$lastTimeSql = "SELECT MAX(createtime) last_time FROM dev_monitor";
		$lastTimeQue = $model->query($lastTimeSql);
		$lastTime = $lastTimeQue[0]['last_time'];
		
		
		//最近一次所有有问题机器
		$allBreakSql = "
				SELECT a.*,b.province,b.city,b.address FROM dev_monitor a
				LEFT JOIN qd_device b ON a.dev_mac = b.MAC
				WHERE createtime = $lastTime $and
				order by a.dev_mac,a.dev_no
		";
		$allBreakQue = $model->query($allBreakSql);
		
		
		//分页起始条数和结束条数
		$beginNum = ($pageNum - 1) * $showNum;
		$endNum = $pageNum * $showNum - 1;
		//硬件有问题机器数组
		$devBreakArr = array();
		//硬件有问题数组的索引，沥遍完既是硬件有问题数量
		$devBreakNum = 0;
		//根据分页获取相应硬件有问题数组
		$devPageBreakArr = array();
		foreach($allBreakQue as $k=>$v){
			if(($v['on_line'] == 1) || ($v['start_time'] == 1) || ($v['shutdown_time'] == 1)){
				$devBreakArr[$devBreakNum] = $v;
				if($devBreakNum>=$beginNum && $devBreakNum<=$endNum){
					$devPageBreakArr[] = $v;
				}
				$devBreakNum++;
			}
		}
		//硬件运作正常数量
		$devRightNum = $allDevNum - $devBreakNum;
		
		$this->assign('devRightNum',$devRightNum);
		$this->assign('devBreakNum',$devBreakNum);
		$this->assign('devPageBreakArr',$devPageBreakArr);
		$this->display(':station_index');
	}
	
	function getProvinceCity(){
		$model = new Model();
		$where = " 1 ";
		if($this->userinfo['orgid']){
			$where .= " and a.agent_id = 10 ";
		}
		$sql = "
				SELECT b.area_id,b.area_name,b.pid FROM qd_agent_area a
				LEFT JOIN bi_area b ON a.area_id = b.area_id
				$where
				";
		$que = $model->query($sql);
		echo json_encode($que);
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
}