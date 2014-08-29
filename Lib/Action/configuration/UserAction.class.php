<?php
import( "@.MyClass.Page" );//导入分页类
import( "@.MyClass.Common" );//导入公共类
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
		$model    = new Model();
		
		$realname = trim(I('realname_txt'));
		$org_name = trim(I('org_name_txt'));
		$username = trim(I('username_txt'));

		$page_show_number = C('page_show_number')?C('page_show_number'):30;  //每页显示的数量
		$where = ' where 1 ';
		if($realname)
		{
			$where .= " and a.realname='$realname'";
		}
		if($org_name)
		{
			$orgid = getAgentIDFromAgentName($org_name);
			$where .= " and a.orgid='$orgid'";
		}
		if($username)
		{
			$where .= " and a.username='$username'";
		}
		
		if(trim($userinfo['orgid']))
		{
			$common = new Common();
			$sub_agent_id = $common->getAgentIdAndChildId(trim($userinfo['orgid']));
			$where .= " and a.orgid in ($sub_agent_id)"; //权限限制
		}
		$sql = "
				SELECT a.uid,a.realname,IF(sex = 1,'男','女') sex,a.telphone,b.agent_name orgname,a.username,
				IF(del_flag = 1,'失效','激活') del_flag
				FROM bi_user a
				LEFT JOIN qd_agent b ON a.orgid = b.agent_id
				$where
				ORDER BY b.agent_id,a.uid
				";
		$que = $model->query($sql);
		$count = count($que);
		// 进行分页数据查询
		$page_number = trim($_GET['p'])?trim($_GET['p']):1;
		$showQue = array();
		$beginNum = ($page_number-1) * $page_show_number;
		$endNum = $beginNum + $page_show_number;
		foreach($que as $k=>$v){
			if($k >= $beginNum && $k < $endNum){
				$showQue[$k]             = $v;
				$showQue[$k]['rolename'] = getRoleNameFromUID($showQue[$k]['uid']);
			}
		}
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		$show       = $Page->show();// 分页显示输出
		$this->assign('list',$showQue);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('user_select_number',$count); //查询结果集的数量
		$this->index();
	}

	//添加用户
	public function add_user(){
		$userinfo  = getUserInfo();
		$username  = trim(I('user_name_txt'));
		$password  = C('initial_password');
		$telphone  = trim(I('telphone_txt'));
		$email     = trim(I('email_txt'));
		$realname  = trim(I('realname_txt'));
		$adduserid = $userinfo['uid'];
		$adddate   = time();
		$sex       = intval(trim(I('sex_txt')));
		$orgid     = trim(I('org_txt'));
		//$memo = trim(I('add_memo_txt'));
		$del_flag  = 0;
		$roleid    = trim(I('role_txt'));
		$msg       = C('add_user_success');
		
		
		$model     = new Model();
		$user      = new Model("BiUser");
		$user_role = new Model("BiUserRole");
		
		//验证是否存在该用户名
		$user_id = $model->query("select uid from bi_user where username='$username'");
		if($user_id[0]['uid']){
			$msg = C('user_name_same');
			$this->ajaxReturn($msg,'json');
			return;
		}

		$data['username']  = $username;
		$data['password']  = $password;
		$data['telphone']  = $telphone;
		$data['email']     = $email;
		$data['realname']  = $realname;
		$data['adduserid'] = $adduserid;
		$data['adddate']   = $adddate;
		$data['sex']       = $sex;
		$data['orgid']     = $orgid;
		$data['del_flag']  = $del_flag;
		$is_set = $user->add($data);
		if(!$is_set){
			$msg = C("add_user_failed");
		}
		$roleid = trim($roleid,",");
		$roleid_array = explode(",", $roleid);
		foreach($roleid_array as $key=>$val){
			$data_role['userid'] = $is_set;
			$data_role['roleid'] = $val;
			$user_role->add($data_role);
		}
		$this->ajaxReturn($msg,'json');
	}

	//根据用户ID查询用户详细信息
	public function userDetailSelect(){
	    $model    = new Model();
		$user_id  = trim($_GET['user_id']);
		$where    = "a.uid=" . $user_id;
		$dataUser = $model->table('bi_user a')->where($where)->select();// 查询满足要求的总记录数
		
		$role_id  = $model->query("select roleid from bi_user_role where userid=" . $user_id);
		$role_id_str = "";
		foreach($role_id as $key=>$val){
			//为区分，在每个角色id加上单引号
			$role_id_str .= "'".$val['roleid']."',";
		}
		//$role_id_str = trim($role_id_str,',');
		$dataUser[0]['role_id_str'] = $role_id_str;

		$data = $dataUser[0];
		$this->ajaxReturn($data,'json');
	}

	//编辑用户
	public function edit_user(){
		$userinfo     = getUserInfo();
		$userid       = trim(I('userid_txt'));
		$username     = trim(I('user_name_txt'));
		$telphone     = trim(I('telphone_txt'));
		$email        = trim(I('email_txt'));
		$realname     = trim(I('realname_txt'));
		$modifyuserid = $userinfo['uid'];
		$modifydate   = time();
		$sex          = intval(trim(I('sex_txt')));
		$orgid        = trim(I('org_txt'));
		//$memo = trim(I('modify_memo_txt'));
		$roleid       = trim(I('role_txt'));
		$roleid       = trim($roleid,',');
		$msg       = C('modify_user_success');
		$model     = new Model();
		$user      = new Model("BiUser");
		$user_role = new Model("BiUserRole");

		$data['username']     = $username;
		$data['telphone']     = $telphone;
		$data['email']        = $email;
		$data['realname']     = $realname;
		$data['modifyuserid'] = $modifyuserid;
		$data['modifydate']   = $modifydate;
		$data['sex']          = $sex;
		$data['orgid']        = $orgid;
		$is_set = $user->where(" uid = $userid ")->save($data);
		if(!$is_set){
			$msg = C("modify_user_failed");
		}

		$is_delete = $user_role->where(" userid = $userid ")->delete();
		$roleid_array = explode(",", $roleid);
		foreach($roleid_array as $key=>$val){
			$data_role['userid'] = $userid;
			$data_role['roleid'] = $val;
			$user_role->add($data_role);
		}
		$this->ajaxReturn($msg,'json');
	}

    //删除用户
	public function delete_user(){
		$id = trim(I('delete_user_id_txt'));
		$msg =	C('delete_user_success');
		$user      = new Model("BiUser");
		$user_role = new Model("BiUserRole");

		$is_delete = $user->where(" uid = $id")->delete();
		if(!$is_delete){
			$msg = C("delete_user_failed");
		}
		$is_delete = $user_role->where(" userid = $id")->delete();
		if(!$is_delete){
			$msg = C("delete_user_failed");
		}

		$this->ajaxReturn($msg,'json');
	}

	//重置密码
	public function reset_password(){
		$userid = trim(I('reset_userid_txt'));
		$msg    = C('reset_password_success');
		$user   = new Model("BiUser");

		$data['password'] = C('initial_password');
		$is_set = $user->where(" uid = $userid")->save($data);
		if(!$is_set){
			$msg = C("reset_password_failed");
		}
		$this->ajaxReturn($msg,'json');
	}

    //修改用户状态，激活/失效
	public function modify_user_state(){
		$userid = trim(I('modify_userid_txt'));
		$msg    = C('modify_user_state_success');
		$model  = new Model();
		$user   = new Model("BiUser");

		$user_info = $model->query("select * from bi_user where uid=$userid");
		if($user_info[0]['del_flag'] == 1){
			$data['del_flag'] = 0;
		}else{
			$data['del_flag'] = 1;
		}
		$is_set = $user->where("uid=$userid")->save($data);
		if(!$is_set){
			$msg = C("modify_user_state_failed");
		}

		$this->ajaxReturn($msg,'json');
	}
		


}
?>