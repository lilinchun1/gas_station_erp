<?php
import( "@.MyClass.Page" );//导入分页类
import( "@.MyClass.Common" );//导入公共类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}

//代理商类
class AgentAction extends Action {
	public function index(){
		$userinfo = getUserInfo();
		$this->is_channel_user = in_array("渠道部", $userinfo['group']); //等于1为渠道部用户
		$this->agentsid = $userinfo['agentsid']; //agentsid为空则为总公司
		$this->username = $userinfo['username']; //登录的用户名
		$this->is_have_user_purview = in_array($userinfo['grade'], array(1,2,3));
		//print_r($userinfo);exit;
		//$this->error('没有权限');
		//echo THINK_VERSION;
		$this->display('channel:agent_index');
	}

	//查询所有1级代理商
	public function fatherAgentSelect(){
	    $Model = new Model();
		$list = $Model->query("select agent_id, agent_name from qd_agent where agent_level='1' and isDelete='0'");
		$this->ajaxReturn($list, 'json');
	}

     //根据代理商ID查询代理商详细信息
     public function agentDetailSelect(){
	    $Model = new Model();
		$agent_id = I('get.agent_id');
		//p($_GET['agent_id']);
		$where = "a.agent_id=" . $agent_id;
		$dataAgent = $Model->table('qd_agent a')->where($where)->select();// 查询满足要求的总记录数
		$dataAgent[0]['begin_time'] = date('Y-m-d', $dataAgent[0]['begin_time']);
		$dataAgent[0]['end_time'] = date('Y-m-d', $dataAgent[0]['end_time']);
		//p($dataAgent[0]['date']);

		$data = $dataAgent[0];
		$this->ajaxReturn($data,'json');
	}

    //代理商名字模糊查询
	public function agentnameBlurrySelect(){
	    //$Model = new Model();
		$agent_name = trim(I('agent_name'));
		$agent = new Model("QdAgent");
		$map['agent_name'] =array('like', '%' . $agent_name . '%');
		$agentInfo = $agent->where($map)->distinct(true)->field('agent_name')->select();
		for($i=0; $i< count($agentInfo); $i++)
		{
			$agent_name_arr[$i]['title'] = $agentInfo[$i]['agent_name'];
		}
		$this->ajaxReturn($agent_name_arr,'json');
	}

	//代理商合同编号模糊查询
	public function agentContractnumberBlurrySelect(){
	    //$Model = new Model();
		$contract_number = trim(I('contract_number'));
		$agent = new Model("QdAgent");
		$map['contract_number'] =array('like', '%' . $contract_number . '%');
		$agentInfo = $agent->where($map)->distinct(true)->field('contract_number')->select();
		for($i=0; $i< count($agentInfo); $i++)
		{
			$agent_contract_number_arr[$i]['title'] = $agentInfo[$i]['contract_number'];
		}
		$this->ajaxReturn($agent_contract_number_arr,'json');
	}
}
?>