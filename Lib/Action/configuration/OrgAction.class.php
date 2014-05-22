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

	//展示组织结构
	public function show_org(){
		$Model = new Model();
		$company = M("company");
		$company_info = $Model->query("select * from bi_company");
		$this->ajaxReturn($company_info, 'json');
	}

	//添加组织结构
	public function add_org(){
		$name = trim(I('add_org_name_txt'));
		$legal = trim(I('add_legal_txt'));
		$msg =	C('add_org_success');
		$Model = new Model();
		$company = M("company");

		$data['name'] = $name;
		$data['legal'] = $legal;
		$is_set = $company->add($data);
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