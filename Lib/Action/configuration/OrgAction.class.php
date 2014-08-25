<?php
import( "@.MyClass.Page" );//导入分页类
import( "@.MyClass.Common" );//导入公共类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}

//组织结构类
class OrgAction extends Action {
	public function index(){
		$userinfo = getUserInfo();
		$this->username = $userinfo['realname']; //登录的用户名
		$this->assign('nowUrl', "configuration/Org/index");
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->display(':org_index');
	}

	//展示组织结构
	public function show_org_tree(){
		$Model = new Model();
		$userinfo = getUserInfo();
		$common = new Common();
		$sub_agent_id = $common->getAgentIdAndChildId(trim($userinfo['orgid']));
		$sql = " select agent_id,agent_name,father_agentid from qd_agent a where a.agent_id in ($sub_agent_id) and a.isDelete=0 ";//权限限制
		$company_info = $Model->query($sql);
		$this->ajaxReturn($company_info, 'json');
	}

	//展示组织结构区域树形结构
	public function show_org_area_tree(){
		$model = new Model();
		$common = new Common();
		$org_id = $_REQUEST['org_id'];
		//判断当前代理商是不是顶级代理商，不存在该代理商则代表要查看全国区域
		$sql_agent = "
				SELECT count(*) count FROM qd_agent WHERE agent_id = $org_id
				";
		$que_agent = $model->query($sql_agent);
		//如果不是0则为区域代理商，拥有区域查看权
		$where = " WHERE 1 ";
		if($que_agent[0]['count']){
			$area_id_str = $common->getAreaIdAndProvinceStr($org_id);
			$where .= " AND area_id IN ($area_id_str) ";
		}
		//如果$que_agent[0]['count'] 为0的话则当前代理商拥有全国区域权限
		$sql_area = "
				SELECT * FROM bi_area $where ORDER BY level,pid,area_id
				";
		$que_area = $model->query($sql_area);
		//获取所有直辖市id数组
		$onlyCityArr = $common->getAllOnlyCity();
		$hasOnlyCityArr = array();
		$area_json = '"0":"';
		$pid = null;
		foreach($que_area as $k_area =>$v_area){
			if(in_array($v_area['area_id'], $onlyCityArr)){
				$hasOnlyCityArr[] = $v_area;
			}
			//level = 1 为省级区域
			if($v_area['level'] == 1){
				$area_json .= ($v_area['area_id'].':'.$v_area['area_name']).',';
			}else{
				if($v_area['pid'] != $pid){
					$area_json = trim($area_json,',');
					$area_json .= '","'.$v_area['pid'].'":"';
					$pid = $v_area['pid'];
				}
				$area_json .= ($v_area['area_id'].':'.$v_area['area_name']).',';
			}
		}
		$area_json = trim($area_json,',');
		$area_json .= '"';
		//添加直辖市的市级
		foreach($hasOnlyCityArr as $k=>$v){
			$area_json .= ',"'.$v['area_id'].'":"'.$v['area_id'].':'.$v['area_name'].'"';
		}
		echo $area_json;
	}

	//添加组织结构
	public function add_org(){
		$agent_name = trim(I('add_agent_name_txt'));
		$companyAddr = trim(I('add_companyAddr_txt'));
		//$agent_type = trim(I('add_agent_type_sel'));
		$contract_number = trim(I('add_contract_number_txt'));
		$legal = trim(I('add_legal_txt'));
		$tel = trim(I('add_tel_txt'));
		$legal_tel = trim(I('add_legal_tel_txt'));
		//$agent_level = trim(I('add_agent_level_sel'));
		$father_agentid = trim(I('add_father_agentid_sel'));
		$begin_time = strtotime(trim(I('add_begin_time_sel')));
		$end_time = strtotime(trim(I('add_end_time_sel')));
		$org_area = trim(I('add_org_area'));
		$add_forever_check = trim(I('add_forever_check'));
		$msg =	C('add_agents_success');

		$Model = new Model();
	
		$agent = new Model("QdAgent");
		$agent_area = new Model("QdAgentArea");
		$data['agent_name'] = $agent_name;
		//$data['agent_type'] = $agent_type;
		$data['companyAddr'] = $companyAddr;
		$data['contract_number'] = $contract_number;
		$data['legal'] = $legal;
		$data['tel'] = $tel;
		$data['legal_tel'] = $legal_tel;
		//$data['agent_level'] = $agent_level;
		$data['father_agentid'] = $father_agentid;
		$data['sub_agent_num'] = 0;
		$data['place_num'] = 0;
		$data['channel_num'] = 0;
		$data['device_num'] = 0;
		$data['forever_type'] = $add_forever_check;
		if($begin_time)
		{
			$data['begin_time'] = $begin_time;
		}
		if($end_time)
		{
			$data['end_time'] = $end_time;
		}
		$data['isDelete'] = 0;
		$is_set = $agent->add($data);
		if($is_set)
		{
			$tmp_agent_id = $agent->query('select last_insert_id() as id');
			$agent_id = $tmp_agent_id[0]['id'];
			$tmp_org_array = explode(",", $org_area);
			foreach($tmp_org_array as $key=>$val){
				$area['agent_id'] = $agent_id;
				$area['area_id'] = $val;
				$agent_area->add($area);
			}
		}
		else
		{
			$msg = C("add_agent_failed");
		}
		$this->ajaxReturn($msg,'json');
	}

	//根据代理商ID查询代理商详细信息
     public function orgDetailSelect(){
	    $Model = new Model();
		$agent_id = trim($_GET['agent_id']);
		//查找指定代理商信息，及其父级代理商名称
		$sql_agent = "
				SELECT a.*,b.agent_name father_agent_name FROM qd_agent a
				LEFT JOIN qd_agent b ON a.father_agentid = b.agent_id
				WHERE a.agent_id = $agent_id
				";
		$dataAgent = $Model->query($sql_agent);
		//格式化日期格式
		$dataAgent[0]['begin_time'] = date('Y-m-d', $dataAgent[0]['begin_time']);
		$dataAgent[0]['end_time'] = date('Y-m-d', $dataAgent[0]['end_time']);
		//查找该代理商下所有区域名称
		$sql_area = "
				SELECT b.* FROM qd_agent_area a
				LEFT JOIN bi_area b ON a.area_id = b.area_id
				WHERE a.agent_id = $agent_id
				";
		$que_area = $Model->query($sql_area);
		$area = null;
		$area_id_string = null;
		//赋值代理商区域名称
		foreach($que_area as $key=>$val){
			$area           .= $val['area_name'] . ",";
			$area_id_string .= $val['area_id'] . ",";
		}
		$area           = trim($area,',');
		$area_id_string = trim($area_id_string,',');
		
		$dataAgent[0]['area_name'] = $area;
		$dataAgent[0]['area_id'] = $area_id_string;
		//获取自身及下属所有代理商id字符串
		$common = new Common();
		$sub_agent_id = $common->getAgentIdAndChildId($agent_id);
		//查找下属所有渠道数量
		$sql_channel = "SELECT COUNT(*) count FROM qd_channel WHERE agent_id IN ($sub_agent_id) and isDelete = 0";
		$que_channel = $Model->query($sql_channel);
		$dataAgent[0]['channel_num'] = $que_channel[0]['count'];
		//查找下属所有加油站数量
		$sql_dev = "SELECT COUNT(*) count FROM qd_device WHERE agent_id IN ($sub_agent_id) and isDelete = 0";
		$que_dev = $Model->query($sql_dev);
		$dataAgent[0]['device_num'] = $que_dev[0]['count'];

		$data = $dataAgent[0];
		$this->ajaxReturn($data,'json');
	}

	//编辑组织结构
	public function edit_org(){
		$agent_name = trim(I('change_agent_name_txt'));
		$agent_id = trim(I('change_agent_id_txt'));
		$companyAddr = trim(I('change_companyAddr_txt'));
		$contract_number = trim(I('change_contract_number_txt'));
		$legal = trim(I('change_legal_txt'));
		$tel = trim(I('change_tel_txt'));
		$legal_tel = trim(I('change_legal_tel_txt'));
		$begin_time = strtotime(trim(I('change_begin_time_sel')));
		$end_time = strtotime(trim(I('change_end_time_sel')));
		$dst_area = trim(I('change_dst_area'));
		$change_forever_check = trim(I('change_forever_check'));
		$msg = C("change_agent_success");
		$log_description = '';

		$Model = new Model();
		$agent = new Model("QdAgent");
		$agent_area = new Model("QdAgentArea");

		$result = $agent->query("select ifnull(agent_id,0) as agent_id from qd_agent where agent_name='$agent_name'");
		if(($result[0]['agent_id'] != $agent_id) && ($result[0]['agent_id'] != 0))
		{
			$msg = C("change_agent_name_failed");
		}
		else
		{
			$data['agent_name'] = $agent_name;
			$data['companyAddr'] = $companyAddr;
			//$data['agent_type'] = $agent_type;
			$data['contract_number'] = $contract_number;
			$data['legal'] = $legal;
			$data['tel'] = $tel;
			$data['legal_tel'] = $legal_tel;
			//$data['agent_level'] = $agent_level;
			//$data['father_agentid'] = $father_agentid;
			$data['forever_type'] = $change_forever_check;
			if($begin_time)
			{
				$data['begin_time'] = $begin_time;
			}
			if($end_time)
			{
				$data['end_time'] = $end_time;
			}
			$is_set = $agent->where("agent_id = $agent_id")->save($data);
		
			$is_set = $agent_area->where(" agent_id = $agent_id ")->delete();
			$dst_area_array = explode(",", $dst_area);
			foreach($dst_area_array as $key=>$val){
				$area['agent_id'] = $agent_id;
				$area['area_id'] = $val;
				$is_area = $agent_area->add($area);
			}
	
			if((!($is_set)) && (!($is_area))){
				$msg = C("change_agent_failed");
			}
		}
		$this->ajaxReturn($msg,'json');
	}

	//删除组织结构
	public function delete_org(){
		$agent_id = trim($_GET['agent_id']);
	    $Model = new Model();
		$agent = new Model("QdAgent");
		$msg = C("delete_agent_success");

		$common = new Common();
		$agentIdStr = $common->getAgentIdAndChildId($agent_id);
		
		$sql_dev = "
				SELECT COUNT(*) count FROM qd_device WHERE agent_id IN ($agentIdStr) AND isDelete = 0
				";
		$que_dev = $Model->query($sql_dev);
		//substr_count($agentIdStr, ',')，表示有除自身外其他代理商，即子代理商
		if($que_dev[0]['count']>0 || substr_count($agentIdStr, ',')){
			$msg = "有下级代理商或者加油站机器";

		}else{
			$is_set = $agent->where("agent_id=" . $agent_id)->setField('isDelete', 1);
			if($is_set <= 0)
			{
				$msg = C("delete_agent_failed");
			}
		}
		$this->ajaxReturn($msg,'json');
	}
}
?>