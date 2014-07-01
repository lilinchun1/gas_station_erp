<?php
import( "@.MyClass.Page" );//导入分页类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}

//角色类
class RoleAction extends Action {
	public function index(){
		$userinfo = getUserInfo();
		$this->username = $userinfo['realname']; //登录的用户名
		$this->assign('nowUrl', "configuration/Role/show_role");
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->display(':role_index');
	}

	//查询角色信息
	public function show_role(){
	    $model = new Model();
	    $userinfo = getUserInfo();
	    
		$orgid = $userinfo['orgid'];
		//echo json_encode($orgid);exit;
		$role_name = trim(I('role_name_txt'));
		//$page_show_number = 30;       //每页显示的数量
		C('page_show_number')?$page_show_number=C('page_show_number'):$page_show_number=30;  //每页显示的数量
		$where = ' where 1=1 ';
		if(!empty($role_name))
		{
			$where .= " and a.rolename='$role_name'";
		}
		if($orgid){
			$where .= " and a.role_agent_id=$orgid";
			$where_count = " where role_agent_id=$orgid ";
		}

		$que_count = $model->query("select count(*) count from bi_role $where_count");
		$count = $que_count[0]['count'];
		//echo $count;exit;
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		//$list = $model->table('bi_role a')->order('a.roleid desc')->limit($Page->firstRow.','. $Page->listRows)->select();
		$sql = "
				SELECT * FROM bi_role a
				LEFT JOIN qd_agent b ON a.role_agent_id = b.agent_id
				$where
				order by a.roleid desc
				limit $Page->firstRow,$Page->listRows
				";
		//echo $sql;exit;
		$list = $model->query($sql);
		//echo json_encode($list);exit;
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
			if(0 == $list[$i]['adduserid']){
				$list[$i]['addusername'] = "根用户";
			}else{
				$tmp_user_name = $model->query("select username from bi_user where uid=" . $list[$i]['adduserid']);
				$list[$i]['addusername'] = $tmp_user_name[0]['username'];
			}
			$list[$i]['roleRadioID'] = 'roleRadio' . $i; //用于详情点击的ID
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
		$role_agent_id = trim(I('role_agent_id'));
		$adduserid = $_SESSION['userinfo']['uid'];
		$adddate= strtotime(date('Y-m-d'));
		$msg =	C('add_role_success');
		$model = new Model();
		$role = M("role");
		$role_menu = M("role_menu");

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
		$tmp_role_id = $role->query('select last_insert_id() as id');
		$menu_id_array = explode(",", $menu_id);
		foreach($menu_id_array as $key=>$val){
			$data_menu['role_id'] = $tmp_role_id[0]['id'];
			$data_menu['menu_id'] = $val;
			$is_menu = $role_menu->add($data_menu);
		}

		$this->ajaxReturn($msg,'json');
	}

	//根据角色ID查询角色详细信息
    public function roleDetailSelect(){
	    $model = new Model();
		$role_id = I('get.role_id');
		//p($_GET['agent_id']);
		$where = "a.roleid=" . $role_id;
		$dataRole = $model->table('bi_role a')->where($where)->select();// 查询满足要求的总记录数
		$dataRole[0]['adddate'] = getDateFromTime($dataRole[0]['adddate']);
		$dataRole[0]['modifydate'] = getDateFromTime($dataRole[0]['modifydate']);

		$menu_id = $model->query("select menu_id from bi_role_menu where role_id=" . $role_id);
		$menu = null;
		$reverse_menu_id = array_reverse($menu_id);
		foreach($menu_id as $key=>$val){
			$menu_name = $model->query("select menuname from bi_menu where menu_id=" . $val['menu_id']);
			$menu .= $menu_name[0]['menuname'] . ",";
		}
		foreach($reverse_menu_id as $key=>$val){
			$menu_id_string .= $val['menu_id'] . ",";
		}
		if(!empty($menu_id[0]['menu_id'])){
			$menu = substr($menu, 0, -1);
			$menu_id_string = substr($menu_id_string, 0, -1);
		}
		$dataRole[0]['menuname'] = $menu;
		$dataRole[0]['menuid'] = $menu_id_string;

		$data = $dataRole[0];
		$this->ajaxReturn($data,'json');
	}

	//角色名字模糊查询
	public function rolenameBlurrySelect(){
	    //$model = new Model();
		$role_name = trim(I('role_name'));
		$role = M('role');
		$map['rolename'] =array('like', '%' . $role_name . '%');
		$roleInfo = $role->where($map)->distinct(true)->field('rolename')->select();
		for($i=0; $i< count($roleInfo); $i++)
		{
			$role_name_arr[$i]['title'] = $roleInfo[$i]['rolename'];
		}
		$this->ajaxReturn($role_name_arr,'json');
	}

    //编辑角色信息
	public function edit_role(){
		$role_id = trim(I('modify_role_id_txt'));
		$rolename = trim(I('modify_role_name_txt'));
		$role_agent_id = trim(I('role_agent_id'));
		$memo = trim(I('modify_memo_txt'));
		$menu_id = trim(I('modify_menu_id_txt'));
		$modifyuserid = $_SESSION['userinfo']['uid'];
		$modifydate= strtotime(date('Y-m-d'));
		$msg =	C('modify_role_success');
		$model = new Model();
		$role = M("role");
		$role_menu = M("role_menu");

		$data['rolename'] = $rolename;
		$data['role_agent_id'] = $role_agent_id;
		$data['memo'] = $memo;
		$data['modifyuserid'] = $modifyuserid;
		$data['modifydate'] = $modifydate;
		$is_set = $role->where("roleid=%d", $role_id)->save($data);
		if(!$is_set){
			//$msg = C("modify_role_failed");
		}

		$is_delete = $role_menu->where("role_id=%d", $role_id)->delete();
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
		$role = M("role");
		$role_menu = M("role_menu");

		$is_delete = $role->where("roleid=%d", $id)->delete();
		if(!$is_delete){
			$msg = C("delete_role_failed");
		}
		$is_delete = $role_menu->where("role_id=%d", $id)->delete();
		if(!$is_delete){
			$msg = C("delete_role_failed");
		}

		$this->ajaxReturn($msg,'json');
	}

    //根据角色查看权限
	public function select_purview(){
		$id = trim(I('purview_role_id_txt'));
		$model = new Model();
		$role_menu_info = $model->query("select b.menu_id, b.menuname, b.url, b.pid from 
			bi_role_menu a, bi_menu b where a.menu_id=b.menu_id and a.role_id=" . $id);
		$data = null;
		/*
		foreach($role_menu_info as $key=>$val){
			$data[$key]['id'] = $val['menu_id'];
			$data[$key]['value'] = $val['menuname'];
			$data[$key]['parent'] = $val['pid'];
		}
		*/
		foreach($role_menu_info as $key=>$val){
			$data .= $val['menuname'] . ",";
		}
		if(!empty($role_menu_info[0]['menuname'])){
			$data = substr($data, 0, -1);
		}
		
		$this->ajaxReturn($data, 'json');
	}

	//查看所有权限
	public function select_all_purview(){
		$model = new Model();
		$menu_info = $model->query("select menu_id, menuname, url, pid from bi_menu");
		$data = null;
		foreach($menu_info as $key=>$val){
			$data[$key]['id'] = $val['menu_id'];
			$data[$key]['value'] = $val['menuname'];
			$data[$key]['parent'] = $val['pid'];
		}
		
		$this->ajaxReturn($data, 'json');
	}
	
	public function getAgentArr(){
		$userinfo = getUserInfo();
		$orgid = $userinfo['orgid'];
		if($orgid){
			$where = " and agent_id = $orgid ";
		}
		$sql = "SELECT agent_name,agent_id,father_agentid FROM qd_agent WHERE isDelete = 0 $where ORDER BY father_agentid,agent_id";
		$model = new Model();
		$que = $que1 = $model->query($sql);
		$this->eharr($que, $que[0]['father_agentid']);
		echo json_encode($this->AgentArr);
	}
	
	
	public $AgentArr = array();
	public $lv = 0;
	function eharr($arr,$pid){
		foreach($arr as $k=>$v){
			if($v['father_agentid'] == $pid){
				$v['lv'] = $this->lv;
				$this->lv++;
				$this->AgentArr[] = $v;
				$this->eharr($arr, $v['agent_id']);
			}
		}
		$this->lv--;
	}
	
	
	function getRoleByAgentId(){
		$role_agent_id = $_POST['role_agent_id'];
		$model = new Model();
		$sql = " SELECT * FROM bi_role WHERE role_agent_id = $role_agent_id ";
		$que = $model->query($sql);
		echo json_encode($que);
	}
}
?>