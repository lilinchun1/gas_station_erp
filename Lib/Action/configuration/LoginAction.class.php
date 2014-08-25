<?php
/*
 * 渠道管理类
 */
class LoginAction extends Action {
	//登录页
    public function index(){
		$this->display(':login_index');
	}

	//登录之后的默认页
	 public function default_index(){
		$userinfo = getUserInfo();
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->assign('username', $userinfo['realname']);
		$this->display(':default_index');
	}

	// 用户登录
	public function login() {
		if (submit_verify('USER_LOGIN')) {
			$return_num = 0;
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			$userinfo = array();
			$vercode = $_SESSION['verify'];
			session('vercode',null);
			// 验证码检查
			if($vercode != md5($_POST['verify'])) {
				$msg = C('verification_code_error');//验证码错误提示
				if ($_POST['is_ajax']) {
					$return_num = 6002;
					$this->ajaxReturn(array('login'=>$return_num, 'emsg'=>'verification_code_error','msg'=>$msg));
				} else {
					$this->error($msg);
				}
			}
			// 查看是否是根用户
			$userinfo = getRoot($username, $password);
			if (!$userinfo) {
				$userm = new Model("BiUser");
				// 检查是否有该用户
				$uinfo = $userm->where("username='$username' and del_flag=0")->find();
				if (!empty($uinfo)) {
					// 检查用户密码是否错误
					$userinfo = $userm->where("username='$username' and password='$password' and del_flag=0")->find();
					if($userinfo['uid']){
						//获取权限信息
						$userinfo['urlstr'] = ableUrlStr($userinfo['uid']);
					}
				} else {
					$uinfo = $userm->where("username='$username' and del_flag=1")->find();
					if($uinfo){
						$msg = "用户已失效";
					}else{
						$msg = C('no_have_this_username');
					}
				}
			}

			if (!empty($userinfo)) {
				unset($userinfo['password']);
				session('userinfo',$userinfo);
				$emsg = 'login_success';//登陆成功信息提示
				$msg = C($emsg);
				if ($_POST['is_ajax']) {
					// 设置最后登录时间
					if ($userinfo['uid'] != 'root') {//根用户不能修改
						$data['lastlogintime'] = time();
						$userm->where("uid={$userinfo['uid']}")->save($data);
					}
					$return_num = 2001;
					$this->ajaxReturn(array('login'=>$return_num, 'emsg'=>'login_success', 'msg'=>$msg));
				} else {
					$this->redirect('Login/login', '',3, $msg);
				}
			} else {
				empty($msg) ? $msg = C('login_failed') : 1;
				if($msg == C('no_have_this_username')){
					$return_num = 6000;
				}else if($msg == "用户已失效"){
					$return_num = 6003;
				}else{
					$msg == "密码错误";
					$return_num = 6001;
				}
				if ($_POST['is_ajax']) {
					$this->ajaxReturn(array('login'=>$return_num, 'emsg'=>'login_failed','msg'=>$msg));
				} else {
					$this->redirect('Login/login', '',3, $msg);
				}
			}
		} else {
			$this->display(':login_index');
		}
	}


	// 退出登录
	public function logout() {
		session('userinfo',null);
		session_unset();
		session_destroy();
		$this->index();
	}

	// 修改密码
	public function change_password() {
		$old_password = I('old_password_txt');
		$new_password = I('new_password_txt');
		$re_new_password = I('re_new_password_txt');
		$user_id = $_SESSION['userinfo']['uid'];
		$Model = new Model();
		$user = new Model("BiUser");
		$msg = C("change_password_success");
		$uinfo = $user->where("uid='$user_id' && password='$old_password'")->find();
		if(!empty($uinfo)){
			if($new_password != $re_new_password){
				$msg = C("new_password_not_same");
			}else{
				$data['password'] = $new_password;
				$is_set = $user->where("uid=%d", $user_id)->save($data);
			}
		}else{
			$msg = C("old_password_error");
		}
		$this->ajaxReturn($msg,'json');
	}

	// 生成验证码
	public function verify() {
		import('ORG.Util.Image');
	    Image::buildImageVerify();
	}
}
?>