<?php
import ( "@.MyClass.Spreadsheet_Excel_Reader" );
class IndexAction extends Action {
	//区域顶级父id值
	public $top_pid = 0;
	public $userinfo;
	function __construct(){
		parent::__construct();
		//获取用户信息
		$this->userinfo = getUserInfo();
		//获取可查看菜单路径
		$this->assign('urlStr', $this->userinfo['urlstr']);
		$this->assign('username', $this->userinfo['realname']);
	}

	/**
	 * InstalledAnalysis index安装量分析
	 * @param 
	 * @return mixed
	 */
	function index() {
		//供菜单给当前页面加样式
		$this->assign('nowUrl', "statistics/Index/index");
		$this->display(':statistics_index');
	}
	/**
	 * user_statistics 用户接入分析
	 * @param
	 * @return mixed
	 */
	function user_statistics(){
		$this->assign('nowUrl', "statistics/Index/user_statistics");
		$this->display(':user_statistics');
	}
	/**
	 * user_behavior 用户行为分析
	 * @param
	 * @return mixed
	 */
	function user_behavior(){
		$this->assign('nowUrl', "statistics/Index/user_behavior");
		$this->display(':user_behavior');
	}
	/**
	 * app_installed app安装量分析
	 * @param
	 * @return mixed
	 */
	function app_installed(){
		$this->assign('nowUrl', "statistics/Index/app_installed");
		$this->display(':app_installed');
	}
	/**
	 * app_analysis app分析
	 * @param
	 * @return mixed
	 */
	function app_analysis(){
		$this->assign('nowUrl', "statistics/Index/app_analysis");
		$this->display(':app_analysis');
	}
	/**
	 * installed_daily 安装量日报
	 * @param
	 * @return mixed
	 */
	function installed_daily(){
		$this->assign('nowUrl', "statistics/Index/installed_daily");
		$this->display(':installed_daily');
	}
	
}