<?php
import( "@.MyClass.Page" );//导入分页类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}

//角色类
class RoleAction extends CommonAction {
	public function index(){
		$this->display(':role_index');
	}

	//查询角色信息
	public function show_role(){
	    $Model = new Model();
		$role_name = trim(I('role_name_txt'));
		//$page_show_number = 30;       //每页显示的数量
		C('page_show_number')?$page_show_number=C('page_show_number'):$page_show_number=30;  //每页显示的数量
		$where = '1=1 ';
		if(!empty($role_name))
		{
			$where .= " and a.rolename='$role_name'";
		}

		$count = $Model->table('bi_role a')->where($where)->count();
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		$list = $Model->table('bi_role a')->where($where)->order('a.roleid desc')->limit($Page->firstRow.','. $Page->listRows)->select();
		if($list=="")
		{
			$listCount = 0;
		}
		else
		{
			$listCount = count($list);
		}
		if( I('get.p') == '')
		{
			$page_number = 1;
		}
		else
		{
			$page_number = I('get.p');
		}
		for($i=0; $i< $listCount; $i++)
		{
			$list[$i]['number'] = ($page_number-1) * $page_show_number + $i + 1;
			$list[$i]['adddate'] = getDateFromTime($list[$i]['adddate']);
			$tmp_user_name = $Model->query("select username from bi_user where uid=" . $list[$i]['adduserid']);
			$list[$i]['addusername'] = $tmp_user_name[0]['username'];
		}
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('role_select_number',$count); //查询结果集的数量
		$this->index();
	}

     //添加角色信息
     public function add_role(){
		$rolename = trim(I('add_role_name_txt'));
		$memo = trim(I('add_memo_txt'));
		$menu_id = trim(I('add_menu_id_txt'));
		$adduserid = $_SESSION['userinfo']['uid'];
		$adddate= strtotime(date('Y-m-d'));
		$msg =	C('add_role_success');
		$Model = new Model();
		$role = M("role");
		$role_menu = M("role_menu");

		$data['rolename'] = $rolename;
		$data['memo'] = $memo;
		$data['adduserid'] = $adduserid;
		$data['adddate'] = $adddate;
		$data['del_flag'] = 0;
		$is_set = $role->add($data);
		$tmp_role_id = $role->query('select last_insert_id() as id');
		$menu_id_array = explode(",", $menu_id);
		foreach($menu_id_array as $key=>$val){
			$data_menu['role_id'] = $tmp_role_id[0]['id'];
			$data_menu['menu_id'] = $val;
			$is_set = $role_menu->add($data_menu);
		}

		$this->ajaxReturn($msg,'json');
	}

    //编辑角色信息
	public function edit_role(){
		$role_id = trim(I('modify_role_id_txt'));
		$rolename = trim(I('modify_role_name_txt'));
		$memo = trim(I('modify_memo_txt'));
		$menu_id = trim(I('modify_menu_id_txt'));
		$modifyuserid = $_SESSION['userinfo']['uid'];
		$modifydate= strtotime(date('Y-m-d'));
		$msg =	C('modify_role_success');
		$Model = new Model();
		$role = M("role");
		$role_menu = M("role_menu");

		$data['rolename'] = $rolename;
		$data['memo'] = $memo;
		$data['modifyuserid'] = $modifyuserid;
		$data['modifydate'] = $modifydate;
		$is_set = $role->where("roleid=%d", $role_id)->save($data);

		$is_delete = $role_menu->where("role_id=%d", $role_id)->delete();
		$menu_id_array = explode(",", $menu_id);
		foreach($menu_id_array as $key=>$val){
			$data_menu['role_id'] = $role_id;
			$data_menu['menu_id'] = $val;
			$is_set = $role_menu->add($data_menu);
		}

		$this->ajaxReturn($msg,'json');
	}

	//删除角色信息
	public function delete_role(){
		$id = trim(I('delete_role_id_txt'));
		$msg =	C('delete_role_success');
		$Model = new Model();
		$role = M("role");
		$role_menu = M("role_menu");

		$is_delete = $role->where("roleid=%d", $id)->delete();
		$is_delete = $role_menu->where("role_id=%d", $id)->delete();

		$this->ajaxReturn($msg,'json');
	}

    //查看权限
	public function select_purview(){
		$id = trim(I('purview_role_id_txt'));
		$Model = new Model();
		$role_menu_info = $Model->query("select b.menu_id, b.menuname, b.url, b.pid from 
			bi_role_menu a, bi_menu b where a.menu_id=b.menu_id and a.role_id=" . $id);
		$data = null;
		foreach($role_menu_info as $key=>$val){
			$data[$key]['id'] = $val['menu_id'];
			$data[$key]['value'] = $val['menuname'];
			$data[$key]['parent'] = $val['pid'];
		}
		
		$this->ajaxReturn($data, 'json');
	}

	//查看权限
	public function select_all_purview(){
		$Model = new Model();
		$menu_info = $Model->query("select menu_id, menuname, url, pid from bi_menu");
		$data = null;
		foreach($menu_info as $key=>$val){
			$data[$key]['id'] = $val['menu_id'];
			$data[$key]['value'] = $val['menuname'];
			$data[$key]['parent'] = $val['pid'];
		}
		
		$this->ajaxReturn($data, 'json');
	}

}
?>