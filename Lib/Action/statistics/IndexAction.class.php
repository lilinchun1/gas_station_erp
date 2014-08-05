<?php
import( "@.MyClass.Page" );//导入分页类
class IndexAction extends Action {
	//区域顶级父id值
	public $top_pid = 0;
	public $userinfo;
	static $page_show_number = 15;
	static $ajax_page = 5;
	
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
		echo I('get.select_province');
		//$this->_export();
		//$this->_getCompany();
		$this->assign('nowUrl', "statistics/Index/index");
		$this->display(':statistics_index');
	}
	
	/**
	 * user_statistics 用户接入分析
	 * @param
	 * @return mixed
	 */
	function user_statistics(){
		$this->_getCompany();
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
	
	function installed_daily_doseach(){
		$where = "";
		$select_province = I("get.select_province");
		$select_city = I("get.select_city");
		$contract_end_time_1 = I("get.contract_end_time_1");
		$contract_end_time_2 = I("get.contract_end_time_2");
		if(!empty($select_province)){
			$where .=" province_name='".$select_province."'";
		}
		if (!empty($select_city)){
			$where .=" and city_name='".$select_city."'";
		}
		
		if (!empty($contract_end_time_1)){
			$where .=" and reg_date >='".strtotime($contract_end_time_1)."'";
		}
		if (!empty($contract_end_time_2)){
			$where .=" and reg_date <'".(strtotime($contract_end_time_2)+24*3600)."'";
		}
		
		
		$Model = M("statistics_report_all");
		if( I('get.p') == ''){
			$page_number = 1;
		}else{
			$page_number = I('get.p');
		}
		$count = $Model->where($where)->count();

		$Page  = new Page($count, $this->page_show_number);// 实例化分页类 传入总记录数
		$show  = $Page->show();// 分页显示输出
		$list = $Model->where($where)->order('reg_date DESC')->limit($Page->firstRow.','. $Page->listRows)->select();
		//echo $Model->getLastSql();
		//var_dump($list) ;
		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('place_select_number',$count);  //查询结果集的数量
		$this->assign('nowUrl', "statistics/Index/installed_daily");
		$this->display(':installed_daily');
	}
	
	
	public function installed_daily_json(){
		$pageinfo = array();
		$where = "";
		$pageinfo = M("statistics_install_detaill_day")->where($where)->select();
		$pageinfo['pageNum'];
		$pageinfo['countPageNum'];
		$pageinfo['showDevNum'];
		$pageinfo['channelName'];
		$pageinfo['address'];
		$pageinfo['devMac'];
		$pageinfo['devNo'];
		$pageinfo['devNoBeginTime'];
		echo json_encode($pageinfo);
	}

	
	
/**处理用**/	
	private function _getCompany(){
		$Model = new Model();
		$sql = "select * from qd_agent a where a.isDelete=0 ";
		$userinfo = getUserInfo();
		if((!empty($userinfo['orgid'])) && (1 != $userinfo['orgid'])){
			$sub_agent_id = getSubAgentStringFromFatherAgent($userinfo['orgid']);
			$sql .= " and (a.agent_id='{$userinfo['orgid']}' or a.agent_id in $sub_agent_id)"; //权限限制
		}
		$company_info = $Model->query($sql);
		
		$this->assign('company_info', $company_info);
	}
	
	private function _province(){
		
	}
	
	
}