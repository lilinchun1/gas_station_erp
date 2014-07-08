<?php
import ( "@.MyClass.Spreadsheet_Excel_Reader" );
class IndexAction extends Action {
	public $uid = 0;
	//区域顶级父id值
	public $top_pid = 0;
	function __construct(){
		parent::__construct();
		//获取用户信息
		$userinfo = getUserInfo();
		$this->uid = $userinfo['uid'];
		//获取可查看菜单路径
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->assign('username', $userinfo['realname']);
	}

	/**
	 * InstalledAnalysis index安装量分析
	 * @param 
	 * @return mixed
	 */
	function index() {
		$this->display(':statistics_index');
	}
	
}