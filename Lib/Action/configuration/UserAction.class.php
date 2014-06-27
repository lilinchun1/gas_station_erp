<?php
import( "@.MyClass.Page" );//导入分页类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}

//职员用户类
class UserAction extends Action {
	public function index(){
		$userinfo = getUserInfo();
		$this->username = $userinfo['realname']; //登录的用户名
		$this->assign('nowUrl', "configuration/User/index");
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->display(':user_index');
	}

	//展示用户
	public function show_user(){
		$userinfo = getUserInfo();
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
		if((!empty($userinfo['orgid'])) && (1 != $userinfo['orgid']))
		{
			$sub_agent_id = getSubAgentStringFromFatherAgent($userinfo['orgid']);
			$where .= " and (a.orgid='{$userinfo['orgid']}' or a.orgid in $sub_agent_id)"; //权限限制
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
			$list[$i]['userRadioID'] = 'userRadio' . $i; //用于详情点击的ID
		}
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('user_select_number',$count); //查询结果集的数量
		$this->index();
	}

	//添加用户
	public function add_user(){
		$userinfo = getUserInfo();
		$username = trim(I('user_name_txt'));
		$password = C('initial_password');
		$telphone = trim(I('telphone_txt'));
		$email = trim(I('email_txt'));
		$realname = trim(I('realname_txt'));
		$adduserid = $userinfo['uid'];
		$adddate = strtotime(date('Y-m-d'));
		$sex = intval(trim(I('sex_txt')));
		$orgid = trim(I('org_txt'));
		//$memo = trim(I('add_memo_txt'));
		$del_flag = 0;
		$roleid = trim(I('role_txt'));
		$msg =	C('add_user_success');
		$Model = new Model();
		$user = M("user");
		$user_role = M("user_role");

		$user_id = $Model->query("select uid from bi_user where username='$username'");
		if(!empty($user_id[0]['uid'])){
			$msg = C('user_name_same');
			$this->ajaxReturn($msg,'json');
			return;
		}

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

	//根据用户ID查询用户详细信息
    public function userDetailSelect(){
	    $Model = new Model();
		$user_id = I('get.user_id');
		//p($_GET['agent_id']);
		$where = "a.uid=" . $user_id;
		$dataUser = $Model->table('bi_user a')->where($where)->select();// 查询满足要求的总记录数
		$dataUser[0]['adddate'] = getDateFromTime($dataUser[0]['adddate']);
		$dataUser[0]['modifydate'] = getDateFromTime($dataUser[0]['modifydate']);
		$dataUser[0]['orgname'] = getAgentNameFromAgentID($dataUser[0]['orgid']);

		$role_id = $Model->query("select roleid from bi_user_role where userid=" . $user_id);
		$role_id_str = "";
		foreach($role_id as $key=>$val){
			$role_id_str .= $val['roleid'].",";
		}
		$dataUser[0]['role_id_str'] = $role_id_str;

		$data = $dataUser[0];
		$this->ajaxReturn($data,'json');
	}

     //编辑用户
     public function edit_user(){
		$userinfo = getUserInfo();
		$userid = trim(I('userid_txt'));
		$username = trim(I('user_name_txt'));
		$telphone = trim(I('telphone_txt'));
		$email = trim(I('email_txt'));
		$realname = trim(I('realname_txt'));
		$modifyuserid = $userinfo['uid'];
		$modifydate = strtotime(date('Y-m-d'));
		$sex = intval(trim(I('sex_txt')));
		$orgid = trim(I('org_txt'));
		//$memo = trim(I('modify_memo_txt'));
		$roleid = trim(I('role_txt'));
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