<?php
import( "@.MyClass.Page" );//导入分页类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}

//职员用户类
class UserAction extends CommonAction {
	public function index(){
		$this->display(':user_index');
	}

	//展示用户
	public function show_user(){
		$Model = new Model();
		$realname = I('realname_txt');
		$org_name = I('org_name_txt');
		$username = I('username_txt');
		//$page_show_number = 30;       //每页显示的数量
		C('page_show_number')?$page_show_number=C('page_show_number'):$page_show_number=30;  //每页显示的数量
		$where = '1=1 ';
		if(!empty($realname))
		{
			$where .= " and a.realname='$realname'";
		}
		if(!empty($org_name))
		{
			$orgid = getAgentIDFromAgentName($org_name);
			$where .= " and a.orgid='$orgid'";
		}
		if(!empty($username))
		{
			$where .= " and a.username='$username'";
		}

		$count = $Model->table('bi_user a')->where($where)->count();
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		$list = $Model->table('bi_user a')->where($where)->order('a.uid desc')->limit($Page->firstRow.','. $Page->listRows)->select();
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
			$list[$i]['orgname'] = getAgentNameFromAgentID($list[$i]['orgid']);
			$list[$i]['adddate'] = getDateFromTime($list[$i]['adddate']);
			$list[$i]['rolename'] = getRoleNameFromUID($list[$i]['uid']);
			if(1 == $list[$i]['sex']){
				$list[$i]['sex'] = "男";
			}elseif(0 == $list[$i]['sex']){
				$list[$i]['sex'] = "女";
			}
			if(1 == $list[$i]['del_flag']){
				$list[$i]['del_flag'] = "失效";
			}elseif(0 == $list[$i]['del_flag']){
				$list[$i]['del_flag'] = "激活";
			}
		}
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('user_select_number',$count); //查询结果集的数量
		$this->index();
	}

	//添加用户
	public function add_user(){
		$username = trim(I('add_user_name_txt'));
		$password = C('initial_password');
		$telphone = trim(I('add_telphone_txt'));
		$email = trim(I('add_email_txt'));
		$realname = trim(I('add_realname_txt'));
		$adduserid = $_SEESION['userinfo']['uid'];
		$adddate = C('initial_password');
		$sex = trim(I('add_sex_txt'));
		$orgid = trim(I('add_org_txt'));
		//$memo = trim(I('add_memo_txt'));
		$del_flag = 0;
		$roleid = trim(I('add_role_txt'));
		$msg =	C('add_user_success');
		$Model = new Model();
		$user = M("user");
		$user_role = M("user_role");

		$data['username'] = $username;
		$data['password'] = $password;
		$data['telphone'] = $telphone;
		$data['email'] = $email;
		$data['realname'] = $realname;
		$data['adduserid'] = $adduserid;
		$data['adddate'] = $adddate;
		$data['sex'] = $sex;
		$data['orgid'] = $orgid;
		$data['del_flag'] = $del_flag;
		$is_set = $user->add($data);
		if(!$is_set){
			$msg = C("add_user_failed");
		}
		$tmp_user_id = $user->query('select last_insert_id() as id');

		$roleid_array = explode(",", $roleid);
		foreach($roleid_array as $key=>$val){
			$data_role['userid'] = $tmp_user_id[0]['id'];
			$data_role['roleid'] = $val;
			$is_set = $user_role->add($data_role);
		}

		$this->ajaxReturn($msg,'json');
	}

     //编辑用户
     public function edit_user(){
		$userid = trim(I('modify_userid_txt'));
		$username = trim(I('modify_user_name_txt'));
		$telphone = trim(I('modify_telphone_txt'));
		$email = trim(I('modify_email_txt'));
		$realname = trim(I('modify_realname_txt'));
		$modifyuserid = trim(I('modify_modifyuserid_txt'));
		$modifydate = trim(I('modify_modifydate_txt'));
		$sex = trim(I('modify_sex_txt'));
		$orgid = trim(I('modify_org_txt'));
		//$memo = trim(I('modify_memo_txt'));
		$roleid = trim(I('modify_role_txt'));
		$msg =	C('modify_user_success');
		$Model = new Model();
		$user = M("user");
		$user_role = M("user_role");

		$data['username'] = $username;
		$data['telphone'] = $telphone;
		$data['email'] = $email;
		$data['realname'] = $realname;
		$data['modifyuserid'] = $modifyuserid;
		$data['modifydate'] = $modifydate;
		$data['sex'] = $sex;
		$data['orgid'] = $orgid;
		$is_set = $user->where("uid=%d", $userid)->save($data);
		if(!$is_set){
			$msg = C("modify_user_failed");
		}

		$is_delete = $user_role->where("userid=%d", $userid)->delete();
		$roleid_array = explode(",", $roleid);
		foreach($roleid_array as $key=>$val){
			$data_role['userid'] = $userid;
			$data_role['roleid'] = $val;
			$is_set = $user_role->add($data_role);
		}

		$this->ajaxReturn($msg,'json');
	}

    //删除用户
	public function delete_user(){
		$id = trim(I('delete_user_id_txt'));
		$msg =	C('delete_user_success');
		$Model = new Model();
		$user = M("user");
		$user_role = M("user_role");

		$is_delete = $user->where("uid=%d", $id)->delete();
		if(!$is_delete){
			$msg = C("delete_user_failed");
		}
		$is_delete = $user_role->where("userid=%d", $id)->delete();
		if(!$is_delete){
			$msg = C("delete_user_failed");
		}

		$this->ajaxReturn($msg,'json');
	}

	//重置密码
	public function reset_password(){
		$userid = trim(I('reset_userid_txt'));
		$msg =	C('reset_password_success');
		$Model = new Model();
		$user = M("user");

		$data['password'] = C('initial_password');
		$is_set = $user->where("uid=%d", $userid)->save($data);
		if(!$is_set){
			$msg = C("reset_password_failed");
		}

		$this->ajaxReturn($msg,'json');
	}

    //修改用户状态，激活/失效
	public function modify_user_state(){
		$userid = trim(I('modify_userid_txt'));
		$msg =	C('modify_user_state_success');
		$Model = new Model();
		$user = M("user");

		$user_info = $Model->query("select * from bi_user where uid=" . $userid);
		if($user_info[0]['del_flag'] == 1){
			$data['del_flag'] = 0;
		}else{
			$data['del_flag'] = 1;
		}
		$is_set = $user->where("uid=%d", $userid)->save($data);
		if(!$is_set){
			$msg = C("modify_user_state_failed");
		}

		$this->ajaxReturn($msg,'json');
	}

}
?>