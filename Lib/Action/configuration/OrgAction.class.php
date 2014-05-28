<?php
import( "@.MyClass.Page" );//导入分页类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}

//组织结构类
class OrgAction extends CommonAction {
	public function index(){
		$this->display(':org_index');
	}

	//树形结构测试
	public function tree_test(){
		$this->display(':tree_test');
	}

	//导入区域数据
	public function export_area(){
		$Model = new Model();
		$province = M("province");
		$city = M("city");
		$area = M("area");
		$province_info = $Model->query("select * from bi_province");
		$city_info = $Model->query("select * from bi_city");
		foreach($province_info as $p_key=>$p_val){
			$data['area_name'] = $p_val['prov_name'];
			$data['pid'] = 0;
			$is_set = $area->add($data);
		}
		foreach($city_info as $key=>$val){
			$data['area_name'] = $val['city_name'];
			$data['pid'] = $val['prov_id'];
			$is_set = $area->add($data);
		}
	}

	//展示组织结构
	public function show_org_tree(){
		$Model = new Model();
		$company_info = $Model->query("select * from qd_agent where isDelete=0");
		$data = null;
		foreach($company_info as $key=>$val){
			$data[$key]['id'] = $val['agent_id'];
			$data[$key]['value'] = $val['agent_name'];
			$data[$key]['parent'] = $val['father_agentid'];
		}
		
		$this->ajaxReturn($data, 'json');
	}

	//展示区域树形结构
	public function show_area_tree(){
		$Model = new Model();
		$province_info = $Model->query("select * from bi_province");
		$data = null;
		foreach($province_info as $p_key=>$p_val){
			if(0 == $p_key){
				$data .= '"' . "0" . '"' . ":" . '"' . $p_val['prov_id'] . ":" . $p_val['prov_name'] . ",";
				//$data .= "0" . ":" . $p_val['prov_id'] . ":" . $p_val['prov_name'] . ",";
			}else{
				$data .= $p_val['prov_id'] . ":" . $p_val['prov_name'] . ",";
			}
		}
		$data = substr($data, 0 , -1);
		$data = $data . '",';
		foreach($province_info as $p_key=>$p_val){
			/*
			$data[$key]['id'] = $val['area_id'];
			$data[$key]['value'] = $val['area_name'];
			$data[$key]['parent'] = $val['pid'];
			*/
			$city_info = $Model->query("select * from bi_area where pid=" . $p_val['prov_id']);
			foreach($city_info as $c_key=>$c_val){
				if(!empty($c_val['area_id'])){
					if(0 == $c_key){
						$data .= '"' . $c_val['pid'] . '"' . ":" . '"' . $c_val['area_id'] . ":" . $c_val['area_name'] . ",";
						//$data .= $c_val['pid'] . ":" . $c_val['area_id'] . ":" . $c_val['area_name'] . ",";
					}
					else{
						$data .= $c_val['area_id'] . ":" . $c_val['area_name'] . ",";
					}
				}
			}
			if(!empty($city_info[0]['area_id'])){
				$data = substr($data, 0 , -1);
				$data = $data . '",';
			}
		}
		$data = substr($data, 0 , -1);

		//echo $data;
		$this->ajaxReturn($data, 'json');
	}

	//获取所有省
	public function get_province(){
		$Model = new Model();
		$province_info = $Model->query("select * from bi_province");
		$data = null;
		foreach($province_info as $key=>$val){
			$data[$key]['id'] = $val['prov_id'];
			$data[$key]['value'] = $val['prov_name'];
		}
		
		$this->ajaxReturn($data, 'json');
	}

	//获取某省下所有市
	public function get_city(){
		$Model = new Model();
		$prov_id = I('prov_id');
		$city_info = $Model->query("select * from bi_area where pid=" . $prov_id);
		$data = null;
		foreach($city_info as $key=>$val){
			$data[$key]['id'] = $val['area_id'];
			$data[$key]['value'] = $val['area_name'];
		}
		
		$this->ajaxReturn($data, 'json');
	}

	//添加组织结构
	public function add_org(){
		$agent_name = trim(I('add_agent_name_txt'));
		$companyAddr = trim(I('add_companyAddr_txt'));
		$agent_type = trim(I('add_agent_type_sel'));
		$contract_number = trim(I('add_contract_number_txt'));
		$legal = trim(I('add_legal_txt'));
		$tel = trim(I('add_tel_txt'));
		$legal_tel = trim(I('add_legal_tel_txt'));
		$agent_level = trim(I('add_agent_level_sel'));
		$father_agentid = trim(I('add_father_agentid_sel'));
		$begin_time = strtotime(trim(I('add_begin_time_sel')));
		$end_time = strtotime(trim(I('add_end_time_sel')));
		$org_area = trim(I('add_org_area'));
		$add_forever_check = trim(I('add_forever_check'));
		$msg =	C('add_agents_success');

		$Model = new Model();
	
		$agent = M("agent","qd_");
		$agent_area = M("agent_area", "qd_");
		$data['agent_name'] = $agent_name;
		$data['agent_type'] = $agent_type;
		$data['companyAddr'] = $companyAddr;
		$data['contract_number'] = $contract_number;
		$data['legal'] = $legal;
		$data['tel'] = $tel;
		$data['legal_tel'] = $legal_tel;
		$data['agent_level'] = $agent_level;
		if($agent_level == '2')
		{
			$data['father_agentid'] = $father_agentid;
		}
		$data['sub_agent_num'] = 0;
		$data['place_num'] = 0;
		$data['channel_num'] = 0;
		$data['device_num'] = 0;
		$data['forever_type'] = $add_forever_check;
		if(0 != $begin_time)
		{
			$data['begin_time'] = $begin_time;
		}
		if(0 != $end_time)
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
				$is_set = $agent_area->add($area);
			}
		}
		else
		{
			$msg = C("add_agent_failed");
		}
		if(C('add_agents_success') == $msg)
		{
			if($agent_level == '2')
			{
				//changeNum('agent', $father_agentid, $agent_id, 'add');
			}
			//addOptionLog('agent', $agent_id, 'add', '');
		}
		$this->ajaxReturn($msg,'json');
	}

	//根据代理商ID查询代理商详细信息
     public function orgDetailSelect(){
	    $Model = new Model();
		$agent_id = I('get.agent_id');
		//p($_GET['agent_id']);
		$where = "a.agent_id=" . $agent_id;
		$dataAgent = $Model->table('qd_agent a')->where($where)->select();// 查询满足要求的总记录数
		$dataAgent[0]['begin_time'] = getDateFromTime($dataAgent[0]['begin_time']);
		$dataAgent[0]['end_time'] = getDateFromTime($dataAgent[0]['end_time']);
		if(0 == $dataAgent[0]['father_agentid']){
			$dataAgent[0]['father_agent_name'] = '';
		}else{
			$tmp_father_agentname = $Model->query("select agent_name from qd_agent where agent_id=" . $dataAgent[0]['father_agentid']);
			$dataAgent[0]['father_agent_name'] = $tmp_father_agentname[0]['agent_name'];
		}

		$area_id = $Model->query("select area_id from qd_agent_area where agent_id=" . $agent_id);
		$area = null;
		foreach($area_id as $key=>$val){
			$area_name = $Model->query("select area_name from bi_area where area_id=" . $val['area_id']);
			$area .= $area_name[0]['area_name'] . ",";
		}
		if(!empty($area_id[0]['area_id'])){
			$area = substr($area, 0, -1);
		}
		$dataAgent[0]['area_name'] = $area;

		$data = $dataAgent[0];
		$this->ajaxReturn($data,'json');
	}

     //编辑组织结构
     public function edit_org(){
		$agent_name = trim(I('change_agent_name_txt'));
		$agent_id = trim(I('change_agent_id_txt'));
		$companyAddr = trim(I('change_companyAddr_txt'));
		$agent_type = trim(I('change_agent_type_sel'));
		$contract_number = trim(I('change_contract_number_txt'));
		$legal = trim(I('change_legal_txt'));
		$tel = trim(I('change_tel_txt'));
		$legal_tel = trim(I('change_legal_tel_txt'));
		$agent_level = trim(I('change_agent_level_sel'));
		$father_agentid = trim(I('change_father_agentid_sel'));
		$begin_time = strtotime(trim(I('change_begin_time_sel')));
		$end_time = strtotime(trim(I('change_end_time_sel')));
		$dst_area = trim(I('change_dst_area'));
		$change_forever_check = trim(I('change_forever_check'));
		$msg = C("change_agent_success");
		$log_description = '';

		$Model = new Model();
		$agent = M("agent","qd_");
		$agent_area = M("agent_area","qd_");

		$result = $agent->query("select ifnull(agent_id,0) as agent_id from qd_agent where agent_name='$agent_name'");
		$src_agent_log_info = $agent->where("agent_id=" . $agent_id)->select();  //查询修改前的信息，用于日志对比
		$src_father_agent_id = $src_agent_log_info[0]['father_agentid'];
		$src_agent_log_info[0]['father_agentname'] = getAgentNameFromAgentID($src_agent_log_info[0]['father_agentid']);
		unset($src_agent_log_info[0]['father_agentid']);
		if('1' == $src_agent_log_info[0]['forever_type'])
		{
			$src_agent_log_info[0]['forever_type'] = "是";
		}
		else
		{
			$src_agent_log_info[0]['forever_type'] = "否";
		}
		$src_agent_log_info[0]['begin_time'] = getDateFromTime($src_agent_log_info[0]['begin_time']);
		$src_agent_log_info[0]['end_time'] = getDateFromTime($src_agent_log_info[0]['end_time']);
		if(($result[0]['agent_id'] != $agent_id) && ($result[0]['agent_id'] != 0))
		{
			$msg = C("change_agent_name_failed");
		}
		else
		{
			$data['agent_name'] = $agent_name;
			$data['companyAddr'] = $companyAddr;
			$data['agent_type'] = $agent_type;
			$data['contract_number'] = $contract_number;
			$data['legal'] = $legal;
			$data['tel'] = $tel;
			$data['legal_tel'] = $legal_tel;
			$data['agent_level'] = $agent_level;
			if('' == $father_agentid)
			{
				$father_agentid = '0';
			}
			if($agent_id == $father_agentid)
			{
				$msg = C('change_agent_belongself');
				$this->ajaxReturn($msg,'json');
				return;
			}
			$data['father_agentid'] = $father_agentid;
			$data['forever_type'] = $change_forever_check;
			if(0 != $begin_time)
			{
				$data['begin_time'] = $begin_time;
			}
			else
			{
				$data['begin_time'] = null;
			}
			if(0 != $end_time)
			{
				$data['end_time'] = $end_time;
			}
			else
			{
				$data['end_time'] = null;
			}
			$is_set = $agent->where("agent_id=%d", $agent_id)->save($data);
		
			$is_set = $agent_area->where("agent_id=%d", $agent_id)->delete();
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
		if(C('change_agent_success') == $msg)
		{
			if($src_father_agent_id != $father_agentid)
			{
				changeNum('agent', $src_father_agent_id, $agent_id, 'minus');
				changeNum('agent', $father_agentid, $agent_id, 'add');
			}
			$dst_agent_log_info = $agent->where("agent_id=" . $agent_id)->select();  //查询修改后的信息，用于日志对比
			$dst_agent_log_info[0]['father_agentname'] = getAgentNameFromAgentID($dst_agent_log_info[0]['father_agentid']);
			unset($dst_agent_log_info[0]['father_agentid']);
			if('1' == $dst_agent_log_info[0]['forever_type'])
			{
				$dst_agent_log_info[0]['forever_type'] = "是";
			}
			else
			{
				$dst_agent_log_info[0]['forever_type'] = "否";
			}
			$dst_agent_log_info[0]['begin_time'] = getDateFromTime($dst_agent_log_info[0]['begin_time']);
			$dst_agent_log_info[0]['end_time'] = getDateFromTime($dst_agent_log_info[0]['end_time']);
			$log_description = getChangeLogDescription($src_agent_log_info[0], $dst_agent_log_info[0]);  //获取修改的详细记录

			//addOptionLog('agent', $agent_id, 'change', $log_description);
		}
		$this->ajaxReturn($msg,'json');
	}

    //删除组织结构
	public function delete_org(){
		$agent_id = trim(I('get.agent_id'));
	    $Model = new Model();
		$agent = M("agent","qd_");
		$agent_area = M("agent_area","qd_");
		$msg = C("delete_agent_success");

		$is_set = $agent->where("agent_id=" . $agent_id)->setField('isDelete', 1);
		if($is_set <= 0)
		{
			$msg = C("delete_agent_failed");
		}
		/*
		$isDelete = $agent_area->where("agent_id=" . $agent_id)->delete();
		if($isDelete <= 0){
			$msg = C("delete_agent_failed");
		}
		*/
		//$this->msg = $msg;
		//$this->agentSelect();
		if($msg == C("delete_agent_success"))
		{
			$agent_info = $Model->query("select father_agentid, agent_level from qd_agent where agent_id=" . $agent_id);
			if('2' == $agent_info[0]['agent_level'])
			{
				//changeNum('agent', $agent_info[0]['father_agentid'], $agent_id, 'minus');
			}
			//addOptionLog('agent', $agent_id, 'del', '');
		}
		$this->ajaxReturn($msg,'json');
	}

	//上移组织结构
	public function up_org(){
		$id = trim(I('up_org_id_txt'));
		$msg =	C('up_org_success');
		$Model = new Model();
		$company = M("company");
		$company_info = $Model->query("select * from bi_company where id=" . $id);
		if($company_info[0]['order'] == 1){
			return;
		}
		$up_order = $company_info[0]['order'] - 1;
		$pid = $company_info[0]['pid'];
		$up_company_info = $Model->query("select * from bi_area where pid=%d and order=%d", $pid, $up_order);
		$data['order'] = $up_order;
		$is_set = $company->where("id=%d", $id)->save($data);
		$data['order'] = $up_order + 1;
		$is_set = $company->where("id=%d", $up_company_info[0]['id'])->save($data);
	}

	//下移组织结构
	public function down_org(){
		$id = trim(I('down_company_id_txt'));
		$msg =	C('down_org_success');
		$Model = new Model();
		$company = M("company");
		$company_info = $Model->query("select * from bi_company where id=" . $id);
		$is_bigest = $Model->query("select * from bi_company where pid=%d and order>%d", $company_info[0]['pid'], $company_info[0]['order']);
		if(!$is_bigest){
			return;
		}

		$down_order = $company_info[0]['order'] + 1;
		$pid = $company_info[0]['pid'];
		$down_company_info = $Model->query("select * from bi_company where pid=%d and order=%d", $pid, $down_order);
		$data['order'] = $down_order;
		$is_set = $company->where("id=%d", $id)->save($data);
		$data['order'] = $down_order - 1;
		$is_set = $company->where("id=%d", $down_company_info[0]['id'])->save($data);
	}

}
?>