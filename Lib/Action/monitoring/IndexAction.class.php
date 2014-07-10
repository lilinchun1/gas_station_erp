<?php
import ( "@.Action.socket.SendDevAction" );
class IndexAction extends Action {
	public $uid = 0;
	function __construct(){
		parent::__construct();
		//SendDevAction::getNewSendNum();
		//获取用户信息
		$userinfo = getUserInfo();
		//var_dump( $userinfo);exit;
		$this->uid = $userinfo['uid'];
		//获取可查看菜单路径
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->assign('username', $userinfo['realname']);
	}
	
	/**
	 * station监控平台
	 * @param
	 * @return mixed
	 */
	function station(){
		$model = new Model();
		//获取最近保存时间
		$lastTimeSql = "
				SELECT MAX(createtime) last_time FROM dev_monitor
				";
		$lastTimeQue = $model->query($lastTimeSql);
		$lastTime = $lastTimeQue[0]['last_time'];
		//最近一次所有有问题机器
		$allBreakSql = "
				SELECT a.*,b.province,b.city,b.address FROM dev_monitor a
				LEFT JOIN qd_device b ON a.dev_mac = b.MAC
				WHERE createtime = $lastTime
		";
		$allBreakQue = $model->query($allBreakSql);
		
		//硬件有问题数量
		$devBreakNum = 0;
		//硬件有问题机器数组
		$devBreakArr = array();
		foreach($allBreakQue as $k=>$v){
			if(($v['on_line'] == 1) || ($v['start_time'] == 1) || ($v['shutdown_time'] == 1)){
				$devBreakNum++;
				$devBreakArr[] = $v;
			}
		}
		//查找所有机器数量
		$countDevSql = "select count(*) all_num from qd_device where isDelete = 0";
		$countDevQue = $model->query($countDevSql);
		$allDevNum = $countDevQue[0]['all_num'];
		//硬件运作正常数量
		$devRightNum = $allDevNum - $devBreakNum;
		
		$this->assign('devRightNum',$devRightNum);
		$this->assign('devBreakNum',$devBreakNum);
		$this->assign('devBreakArr',$devBreakArr);
		$this->display(':station_index');
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