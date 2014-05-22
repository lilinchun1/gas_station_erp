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
		$cnname = I('cnname_txt');
		$org = I('org_txt');
		$username = I('username_txt');
		$state = I('state_sel');
		//$page_show_number = 30;       //每页显示的数量
		C('page_show_number')?$page_show_number=C('page_show_number'):$page_show_number=30;  //每页显示的数量
		$where = '1=1 ';
		if(!empty($cnname))
		{
			$where .= " and a.cnname='$cnname'";
		}
		if(!empty($org))
		{
			$where .= " and a.orgid='$org'";
		}
		if(!empty($username))
		{
			$where .= " and a.username='$username'";
		}
		if(!empty($state))
		{
			$where .= " and a.state='$state'";
		}

		$count = $Model->table('bi_user a')->where($where)->count();
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		$list = $Model->table('bi_user a')->where($where)->order('a.id desc')->limit($Page->firstRow.','. $Page->listRows)->select();
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
			$list[$i]['begin_time'] = getDateFromTime($list[$i]['begin_time']);
			$list[$i]['end_time'] = getDateFromTime($list[$i]['end_time']);
		}
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('user_select_number',$count); //查询结果集的数量
		$this->index();
	}

	//添加用户
	public function add_user(){
		$cnname = trim(I('add_cnname_txt'));
		$telphone = trim(I('add_telphone_txt'));
		$username = trim(I('add_user_name_txt'));
		$orgid = trim(I('add_org_txt'));
		$memo = trim(I('add_memo_txt'));
		$roleid = trim(I('add_role_txt'));
		$areaid = trim(I('add_area_txt'));
		$msg =	C('add_user_success');
		$Model = new Model();
		$user = M("user");
		$user_role = M("user_role");
		$user_area = M("user_area");

		$data['cnname'] = $cnname;
		$data['telphone'] = $telphone;
		$data['username'] = $username;
		$data['orgid'] = $orgid;
		$data['memo'] = $memo;
		$is_set = $user->add($data);
		$tmp_user_id = $user->query('select last_insert_id() as id');

		$data_role['userid'] = $tmp_user_id[0]['id'];
		$date_role['roleid'] = $roleid;
		$is_set = $user_role->add($data_role);

		$data_area['userid'] = $tmp_user_id[0]['id'];
		$date_area['areaid'] = $areaid;
		$is_set = $user_area->add($data_area);
	}

     //编辑用户
     public function edit_user(){
		$userid = trim(I('modify_userid_txt'));
		$cnname = trim(I('modify_cnname_txt'));
		$telphone = trim(I('modify_telphone_txt'));
		$username = trim(I('modify_user_name_txt'));
		$orgid = trim(I('modify_org_txt'));
		$memo = trim(I('modify_memo_txt'));
		$roleid = trim(I('modify_role_txt'));
		$areaid = trim(I('modify_area_txt'));
		$msg =	C('modify_user_success');
		$Model = new Model();
		$user = M("user");
		$user_role = M("user_role");
		$user_area = M("user_area");

		$data['cnname'] = $cnname;
		$data['telphone'] = $telphone;
		$data['username'] = $username;
		$data['orgid'] = $orgid;
		$data['memo'] = $memo;
		$is_set = $user->where("id=%d", $userid)->save($data);

		$data_role['userid'] = $userid;
		$date_role['roleid'] = $roleid;
		$is_set = $data_role->where("id=%d", $userid)->save($data);

		$data_area['userid'] = $userid;
		$date_area['areaid'] = $areaid;
		$is_set = $data_area->where("id=%d", $userid)->save($data);
	}

    //删除用户
	public function delete_user(){
		$id = trim(I('delete_user_id_txt'));
		$msg =	C('delete_user_success');
		$Model = new Model();
		$user = M("user");
		$user_role = M("user_role");
		$user_area = M("user_area");

		$is_delete = $user->where("id=%d", $id)->delete();
		$is_delete = $user_role->where("userid=%d", $id)->delete();
		$is_delete = $user_area->where("userid=%d", $id)->delete();
	}

	//重置密码
	public function reset_password(){
		$userid = trim(I('reset_userid_txt'));
		$password = trim(I('reset_password_txt'));
		$msg =	C('reset_password_success');
		$Model = new Model();
		$user = M("user");

		$data['password'] = $password;
		$is_set = $user->where("id=%d", $userid)->save($data);
	}

    //修改用户状态，激活/失效
	public function modify_user_state(){
		$userid = trim(I('modify_userid_txt'));
		$msg =	C('modify_user_state_success');
		$Model = new Model();
		$user = M("user");

		$user_info = $Model->query("select * from bi_user where userid=" . $userid);
		if($user_info[0]['state'] == 1){
			$data['state'] = 0;
		}else{
			$data['state'] = 1;
		}
		$is_set = $user->where("id=%d", $userid)->save($data);
	}

}
?>