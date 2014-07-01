<?php
class IndexAction extends Action {
	public $uid = 0;
	function __construct(){
		parent::__construct();
		//获取用户信息
		$userinfo = getUserInfo();
		//var_dump( $userinfo);exit;
		$this->uid = $userinfo['uid'];
		//获取可查看菜单路径
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->assign('username', $userinfo['realname']);
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
	 * station监控平台
	 * @param
	 * @return mixed
	 */
	function station(){
		$this->display(':station_index');
	}
	
}