<?php
import( "@.MyClass.Page" );//导入分页类
class IndexAction extends Action {
	private $userinfo = null;
	//当前代理商及下属所有子代理商id列表
	public $agentIdStr = "";
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
		$showNum = 5;
		//当前页数
		$pageNum = $_REQUEST['pageNum']?$_REQUEST['pageNum']:1;
		//选中的地区id
		$areaId = $_REQUEST['areaId'];
		//地区等级0全国，1省级，2市级
		$level = $_REQUEST['level'];
		
		//硬件有问题机器数组
		$devBreakArr = array();
		//硬件有问题数组的索引，沥遍完既是硬件有问题数量，其他选择要另设变量以做索引
		$devBreakNum = 0;
		//根据分页获取相应硬件有问题数组
		$devPageBreakArr = array();
		$model = new Model();
		
		//获取最近通信保存时间，和最近一次是否全部没有问题
		$monitorNoSql = "SELECT MAX(monitor_no) monitor_no FROM dev_monitor";
		$monitorNoQue = $model->query($monitorNoSql);
		$monitor_no = $monitorNoQue[0]['monitor_no'];
		
		$allOkSql = "select all_ok from dev_monitor where monitor_no = $monitor_no";
		$allOkQue = $model->query($allOkSql);
		$all_ok   = $allOkQue[0]['all_ok'];

		if($all_ok == 0){
			$and = "";
			if($areaId){
				$sqlArea = "SELECT area_name FROM bi_area WHERE area_id = $areaId";
				$queArea = $model->query($sqlArea);
				if($level ==1){
					$and .= " and province like '%".$queArea[0]['area_name']."%'";
				}else if($level ==2){
					$and .= " and city like '%".$queArea[0]['area_name']."%'";
				}
			}
			
			//最近一次所有有问题机器
			$allBreakSql = "
			SELECT a.*,b.province,b.city,b.address
			FROM dev_monitor a
			LEFT JOIN qd_device b ON a.dev_mac = b.MAC
			WHERE monitor_no = $monitor_no $and
			order by a.dev_mac,a.dev_no
			";
			//echo $allBreakSql;exit;
			$allBreakQue = $model->query($allBreakSql);
			//分页起始条数和结束条数
			$beginNum = ($pageNum - 1) * $showNum;
			$endNum = $pageNum * $showNum - 1;
			foreach($allBreakQue as $k=>$v){
				//错误延续时间
				$continueTime = time()-$v['wrong_begin_time'];
				$hour = (int)($continueTime/3600);
				$min = (int)(($continueTime%3600)/60);
				$v['continueTime'] = $hour."小时".$min."分钟";
				//转换错误开始时间
				$v['wrong_begin_time'] = date("Y-m-d H:i:s",$v['wrong_begin_time']);
				if(($v['on_line'] == 1) || ($v['start_time'] == 1) || ($v['shutdown_time'] == 1)){
					$devBreakArr[$devBreakNum] = $v;
					if($devBreakNum>=$beginNum && $devBreakNum<=$endNum){
						$devPageBreakArr[] = $v;
					}
					$devBreakNum++;
				}
			}
		}
		//查找所有机器数量
		$countDevSql = "select count(*) all_num from qd_device where isDelete = 0 $and ";
		$countDevQue = $model->query($countDevSql);
		$allDevNum = $countDevQue[0]['all_num'];
		//硬件运作正常数量
		$devRightNum = $allDevNum - $devBreakNum;
		//echo $devRightNum;exit;
		//总页数
		$countPageNum = $devBreakNum%$showNum?(int)($devBreakNum/$showNum)+1:$devBreakNum/$showNum;
		$this->assign('devRightNum',$devRightNum);
		$this->assign('devBreakNum',$devBreakNum);
		$this->assign('devPageBreakArr',$devPageBreakArr);
		$this->assign('pageNum',$pageNum);
		$this->assign('countPageNum',$countPageNum);
		$this->assign('areaId',$areaId);
		$this->assign('level',$level);
		$this->assign('nowUrl', "monitoring/Index/station");
		$this->display(':station_index');
	}
	
	function getProvinceCity(){
		$model = new Model();
		$where = " where 1 ";
		if($this->userinfo['orgid']){
			$where .= " and a.agent_id = ".$this->userinfo['orgid'];
		}
		$sql = "
				SELECT b.area_id,b.area_name,b.pid,b.level FROM qd_agent_area a
				LEFT JOIN bi_area b ON a.area_id = b.area_id
				$where
				GROUP BY a.area_id
				";
		$que = $model->query($sql);
		//如果存在省级则加上全国
		if(!$this->userinfo['orgid'] || $this->userinfo['orgid'] == 1){
			$que[] = array('area_id'=>0,'area_name'=>'全国','pid'=>0,'level'=>0);
		}
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