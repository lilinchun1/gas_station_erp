<?php
import( "@.MyClass.Page" );//导入分页类
import( "@.MyClass.Common" );//导入公共类
class IndexAction extends Action {
	//区域顶级父id值
	public $top_pid = 0;
	public $userinfo;
	public  $page_show_number = 15;
	public $ajax_pagenum = 5;
	
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
		$select_province	 = I("get.select_province");
		$select_city 		 = I("get.select_city");
		$contract_end_time_1 = I("get.contract_end_time_1");
		$contract_end_time_2 = I("get.contract_end_time_2");
		$channel_name 		 = I("get.channel_name");
		$place_name			 = I("get.place_name");
		
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
		
		if (!empty($channel_name)){
			$where .=" and channel_name='$channel_name'";
		}
		if (!empty($place_name)){
			$where .=" and place_name='$place_name'";
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
	
	public function ajax_report(){
		$pageinfo = array();
		$select_id = I("select_id");
		$report_type = I("showModel");
		$where = "master_id='$select_id'";
		
		//判断表名
		switch ($report_type){
			case '0':
				$table_name = 'statistics_report_succ';
				break;
			case '1':
				$table_name = 'statistics_report_fail';
				$where .= " and flag = '0'"; 
				break;
			default:
				$table_name = 'statistics_report_undefine';
				break;
		}
		
		if( I('pageNum') == ''){
			$page_number = 1;
		}else{
			$page_number = I('pageNum');
		}		
		$Model = M($table_name);
		$count = ceil($Model->where($where)->count()/$this->ajax_pagenum);
		$firstRow = ($page_number - 1) * $this->ajax_pagenum;	
		//定义数组	
		$result=$Model->where($where)->order('reg_date DESC')->limit($firstRow.','. $this->ajax_pagenum)->select();
		foreach ($result as $k => $v){
			$list[$k] = $v;
			$list[$k]['reg_date'] = date("Y-m-d", $v['reg_date']);
		}
		//echo $Model->getLastSql();
		$pageinfo['showDevPageArr'] = $list;
		$pageinfo['pageNum'] = $page_number;
		$pageinfo['countPageNum'] = $count;
		$pageinfo['showDevNum'] = $this->ajax_pagenum;
		$pageinfo['select_id'] = $select_id;
		$pageinfo['showModel'] = $report_type;
		echo json_encode($pageinfo);		
	}
	
	public function change_count(){
		$Model = M("statistics_report_fail");
		$id = I("id");
		$finddata = $Model->where("id='$id'")->find();
		$master_id = $finddata['master_id'];
		if (!empty($finddata)){
			$data ['master_id']		= $master_id; 
			$data ['reg_date'] 		= $finddata['reg_date']; 
			$data ['point_address']	= $finddata['point_address'];
			$data ['point_info']  	= $finddata['point_info'];
			$data ['mac']			= $finddata['mac'];
			$data ['dev_id']		= $finddata['dev_id']; 
			$data ['all_num']		= 0;
			$data ['ios_num']		= 0;
			$data ['android_num']	= 0;
			$data ['province_name']	= $finddata['province_name'];
			$data ['city_name'] 	= $finddata['city_name'];
			$result = M("statistics_report_succ")->add($data);
			if ($result){
				$finddata = $Model->where("id='$id'")->setInc("flag");
				if ($finddata){
					$Model = M("statistics_report_all");
					$Model->where("id = '$master_id'")->setInc("succ_num");
					$Model->where("id = '$master_id'")->setDec("fail_num");
				}
			}	
		}
		true;
	}
	
	
	
/**处理用**/	
	private function _getCompany(){
		$Model = new Model();
		$sql = "select * from qd_agent a where a.isDelete=0 ";
		$userinfo = getUserInfo();
		if(trim($userinfo['orgid']))
		{
			$common = new Common();
			$sub_agent_id = $common->getAgentIdAndChildId(trim($userinfo['orgid']));
			$sql .= " and a.agent_id in ($sub_agent_id)"; //权限限制
		}
		$company_info = $Model->query($sql);
		
		$this->assign('company_info', $company_info);
	}
	
	private function _province(){
		
	}
	
	
}