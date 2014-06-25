<?php
import( "@.MyClass.Page" );//导入分页类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}

//区域类
class AreaAction extends Action {
	public function index(){
		$this->display('config:area_index');
	}

	//显示区域信息
	public function show_area(){
		$Model = new Model();
		$area = M("area");
		$area_info = $Model->query("select * from bi_area");
		$this->ajaxReturn($area_info, 'json');
	}

    //添加区域
	public function add_area(){
		$area_name = trim(I('add_area_name_txt'));
		$pid = trim(I('add_pid_txt'));
		$memo = trim(I('add_memo_txt'));
		$msg =	C('add_area_success');
		$Model = new Model();
		$area = M("area");

		$data['area_name'] = $area_name;
		$data['pid'] = $pid;
		$data['memo'] = $memo;
		$is_set = $area->add($data);
	}

	//编辑区域
	public function edit_area(){
		$id = trim(I('modify_area_id_txt'));
		$area_name = trim(I('modify_area_name_txt'));
		$memo = trim(I('modify_memo_txt'));
		$msg =	C('modify_area_success');
		$Model = new Model();
		$area = M("area");

		$data['area_name'] = $area_name;
		$data['memo'] = $memo;
		$is_set = $area->where("id=%d", $id)->save($data);
	}

	//删除区域
	public function delete_area(){
		$id = trim(I('delete_area_id_txt'));
		$msg =	C('delete_area_success');
		$Model = new Model();
		$area = M("area");

		$is_delete = $area->where("id=%d", $id)->delete();
	}

	//上移区域
	public function up_area(){
		$id = trim(I('up_area_id_txt'));
		$msg =	C('up_area_success');
		$Model = new Model();
		$area = M("area");
		$area_info = $Model->query("select * from bi_area where id=" . $id);
		if($area_info[0]['order'] == 1){
			return;
		}
		$up_order = $area_info[0]['order'] - 1;
		$pid = $area_info[0]['pid'];
		$up_area_info = $Model->query("select * from bi_area where pid=%d and order=%d", $pid, $up_order);
		$data['order'] = $up_order;
		$is_set = $area->where("id=%d", $id)->save($data);
		$data['order'] = $up_order + 1;
		$is_set = $area->where("id=%d", $up_area_info[0]['id'])->save($data);
	}

	//下移区域
	public function down_area(){
		$id = trim(I('down_area_id_txt'));
		$msg =	C('down_area_success');
		$Model = new Model();
		$area = M("area");
		$area_info = $Model->query("select * from bi_area where id=" . $id);
		$is_bigest = $Model->query("select * from bi_area where pid=%d and order>%d", $area_info[0]['pid'], $area_info[0]['order']);
		if(!$is_bigest){
			return;
		}

		$down_order = $area_info[0]['order'] + 1;
		$pid = $area_info[0]['pid'];
		$down_area_info = $Model->query("select * from bi_area where pid=%d and order=%d", $pid, $down_order);
		$data['order'] = $down_order;
		$is_set = $area->where("id=%d", $id)->save($data);
		$data['order'] = $down_order - 1;
		$is_set = $area->where("id=%d", $down_area_info[0]['id'])->save($data);
	}
}
?>