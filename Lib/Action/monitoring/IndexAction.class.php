<?php
import ( "@.Action.socket.SendDevAction" );
class IndexAction extends Action {
	public $uid = 0;
	function __construct(){
		parent::__construct();
		echo SendDevAction::$sendNum;exit;
		
		
		
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
		echo 
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