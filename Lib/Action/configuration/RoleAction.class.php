<?php
import( "@.MyClass.Page" );//导入分页类
import( "@.MyClass.Common" );//导入公共类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}

//角色类
class RoleAction extends Action {
	public function index(){
		$userinfo = getUserInfo();
		$this->username = $userinfo['realname']; //登录的用户名
		$this->assign('nowUrl', "'/gas_station_erp/index.php/configuration/Role/show_role'");
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->display(':role_index');
	}

	//查询角色信息
	public function show_role(){
	    $model = new Model();
	    $userinfo = getUserInfo();
		$orgid = $userinfo['orgid'];
		$role_name = trim(I('role_name_txt')); 
		$org_name = trim(I('org_name_txt'));
		C('page_show_number')?$page_show_number=C('page_show_number'):$page_show_number=30;  //每页显示的数量
		$where = ' where a.rolename is not null and a.del_flag="0" and b.isDelete = "0"';
		if($role_name)
		{
			$where .= " and a.rolename='$role_name'";
		}
		if($org_name) 
		{
			$org_id = getAgentIDFromAgentName($org_name);
			if($org_id){
				$where .= " and a.role_agent_id=$org_id ";
			}
		}
		if(trim($orgid)){
			$common = new Common();
			$sub_agent_id = $common->getAgentIdAndChildId(trim($orgid));
			$where .= " and a.role_agent_id in ($sub_agent_id)";
		}
		
		$que_count = $model->query("SELECT count(*) count FROM bi_role a LEFT JOIN qd_agent b ON a.role_agent_id = b.agent_id $where ");
		$count = $que_count[0]['count'];
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		$sql = "
				SELECT a.memo,a.roleid,a.rolename,FROM_UNIXTIME( a.adddate, '%Y-%m-%d' ) adddate,IF(c.realname IS NULL,'根用户',c.realname) addusername,b.agent_name
				FROM bi_role a
				LEFT JOIN qd_agent b  ON a.role_agent_id = b.agent_id
				LEFT JOIN bi_user c ON a.adduserid = c.uid
				$where 
				ORDER BY b.agent_id,a.roleid desc
				limit $Page->firstRow,$Page->listRows
				";
		$list = $model->query($sql);
		$_GET['p']?$page_number = $_GET['p']:$page_number = 1;
		
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('role_select_number',$count); //查询结果集的数量
		$this->index();
	}

     //添加角色信息
     public function add_role(){
		$rolename = trim(I('add_role_name_txt'));
		$memo = trim(I('add_memo_txt'));
		$menu_id = trim(trim(I('add_menu_id_txt')),',');
		$role_agent_id = trim(I('role_agent_id'));
		$adduserid = $_SESSION['userinfo']['uid'];
		$adddate= strtotime(date('Y-m-d'));
		$msg =	C('add_role_success');
		$model = new Model();
		$role = new Model("BiRole");
		$role_menu = new Model("BiRoleMenu");

		$data['rolename'] = $rolename;
		$data['role_agent_id'] = $role_agent_id;
		$data['memo'] = $memo;
		$data['adduserid'] = $adduserid;
		$data['adddate'] = $adddate;
		$data['del_flag'] = 0;
		$is_set = $role->add($data);
		if(!$is_set){
			$msg = C("add_role_failed");
		}
		$tmp_role_id = $is_set;
		$menu_id_array = explode(",", $menu_id);
		foreach($menu_id_array as $key=>$val){
			$data_menu['role_id'] = $tmp_role_id;
			$data_menu['menu_id'] = $val;
			$is_menu = $role_menu->add($data_menu);
		}
		$this->ajaxReturn($msg,'json');
	}
	
	//编辑角色信息
	public function edit_role(){
		$role_id = trim(I('modify_role_id_txt'));
		$rolename = trim(I('modify_role_name_txt'));
		$role_agent_id = trim(I('role_agent_id'));
		$memo = trim(I('modify_memo_txt'));
		$menu_id = trim(trim(I('modify_menu_id_txt')),',');
		$modifyuserid = $_SESSION['userinfo']['uid'];
		$modifydate= strtotime(date('Y-m-d'));
		$msg =	C('modify_role_success');
		$model = new Model();
		$role = new Model("BiRole");
		$role_menu = new Model("BiRoleMenu");
	
		$data['rolename'] = $rolename;
		$data['role_agent_id'] = $role_agent_id;
		$data['memo'] = $memo;
		$data['modifyuserid'] = $modifyuserid;
		$data['modifydate'] = $modifydate;
		$is_set = $role->where("roleid = $role_id")->save($data);

		$is_delete = $role_menu->where("role_id = $role_id")->delete();
		$menu_id_array = explode(",", $menu_id);
		foreach($menu_id_array as $key=>$val){
			$data_menu['role_id'] = $role_id;
			$data_menu['menu_id'] = $val;
			$is_menu = $role_menu->add($data_menu);
		}
		$this->ajaxReturn($msg,'json');
	}
	
	//删除角色信息
	public function delete_role(){
		$id = trim(I('delete_role_id_txt'));
		$msg =	C('delete_role_success');
		$model = new Model();
		$role = new Model("BiRole");
		$role_menu = new Model("BiRoleMenu");
		$bi_user_role = new Model("BiUserRole");
	
		$is_delete = $role->where("roleid= $id")->delete();
		if(!$is_delete){
			$msg = C("delete_role_failed");
		}
		$is_delete = $role_menu->where("role_id= $id")->delete();
		if(!$is_delete){
			$msg = C("delete_role_failed");
		}
		$is_delete = $bi_user_role->where("roleid= $id")->delete();
		if(!$is_delete){
			$msg = C("delete_role_failed");
		}
		$this->ajaxReturn($msg,'json');
	}

	//根据角色ID查询角色详细信息
    public function roleDetailSelect(){
	    $model = new Model();
		$role_id = $_GET['role_id'];
		$dataRole = $model->table('bi_role')->where(" roleid = $role_id ")->select();// 查询满足要求的总记录数
		
		$dataRole[0]['adddate'] = date('Y-m-d', $dataRole[0]['adddate']);
		$dataRole[0]['modifydate'] = date('Y-m-d', $dataRole[0]['modifydate']);

		$menu_id = $model->query("select menu_id from bi_role_menu where role_id = $role_id");
		foreach($menu_id as $key=>$val){
			$menu_id_string .= $val['menu_id'] . ",";
		}
		$menu_id_string = trim($menu_id_string,',');

		$dataRole[0]['menuid'] = $menu_id_string;
		$data = $dataRole[0];
		$this->ajaxReturn($data,'json');
	}

	//查看所有权限
	public function select_all_purview(){
		$model = new Model();
		$userinfo = getUserInfo();
		$uid = $userinfo['uid'];
		//如果当前登录的不是管理员
		$menu_info = null;
		if($userinfo['username'] != C("ROOT_USER")){
			$sql = "
			SELECT c.menu_id id, c.menuname value, c.url, c.pid parent
			FROM bi_user_role a
			LEFT JOIN bi_role_menu b ON a.roleid = b.role_id
			LEFT JOIN bi_menu c ON b.menu_id = c.menu_id
			WHERE a.userid = $uid
			AND c.menu_id IS NOT NULL
			AND c.is_del = 0
			UNION
			SELECT menu_id id, menuname value, url, pid parent FROM bi_menu
			WHERE menu_id IN(
				SELECT c.pid
				FROM bi_user_role a
				LEFT JOIN bi_role_menu b ON a.roleid = b.role_id
				LEFT JOIN bi_menu c ON b.menu_id = c.menu_id
				WHERE a.userid = $uid
				AND c.menu_id IS NOT NULL
				AND c.is_del = 0
			)
			";
			$menu_info = $model->query($sql);
		}else{
			$menu_info = $model->query("select menu_id id, menuname value, url, pid parent from bi_menu where is_del = 0");
		}
		$this->ajaxReturn($menu_info, 'json');
	}
	//给定组织id显示该组织下角色
	function getRoleByAgentId(){
		$role_agent_id = trim($_POST['role_agent_id']);
		$model = new Model();
		$sql = " SELECT * FROM bi_role WHERE role_agent_id = $role_agent_id ";
		$que = $model->query($sql);
		echo json_encode($que);
	}
}
?>