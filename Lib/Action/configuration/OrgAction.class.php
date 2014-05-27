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
		$company_info = $Model->query("select * from qd_agent");
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
		$area_info = $Model->query("select * from bi_area");
		$data = null;
		foreach($area_info as $key=>$val){
			$data[$key]['id'] = $val['area_id'];
			$data[$key]['value'] = $val['area_name'];
			$data[$key]['parent'] = $val['pid'];
		}
		
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

     //编辑组织结构
     public function edit_org(){
		$id = trim(I('modify_org_id_txt'));
		$name = trim(I('modify_org_name_txt'));
		$legal = trim(I('modify_legal_txt'));
		$msg =	C('modify_org_success');
		$Model = new Model();
		$company = M("company");

		$data['name'] = $name;
		$data['legal'] = $legal;
		$is_set = $company->where("id=%d", $id)->save($data);
	}

    //删除组织结构
	public function delete_org(){
		$id = trim(I('delete_org_id_txt'));
		$msg =	C('delete_org_success');
		$Model = new Model();
		$company = M("company");

		$is_delete = $company->where("id=%d", $id)->delete();
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