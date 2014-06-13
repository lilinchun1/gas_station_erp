<?php
/*
 * 渠道管理类
 */
class LoginAction extends Action {
    public function index(){
		$this->display(':login_index');
	}

	 public function default_index(){
		$this->display(':default_index');
	}

	// 用户登录
	public function login() {
		if (submit_verify('USER_LOGIN')) {
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			$userinfo = array();
			$vercode = $_SESSION['verify'];
			session('vercode',null);
			// 验证码
			if($vercode != md5($_POST['verify'])) {
				$msg = C('verification_code_error');
				if ($_POST['is_ajax']) {
					$this->ajaxReturn(array('login'=>6002, 'emsg'=>'verification_code_error','msg'=>$msg));
				} else {
					$this->error($msg);
				}
			}
			// 查看是否是根用户
			$userinfo = getRoot($username, $password);
			if (!$userinfo) {
				$userm = M('user');
				// 检查是否有该用户
				$uinfo = $userm->where("username='$username' && del_flag=0")->find();
				if (!empty($uinfo)) {
					// 检查用户密码是否错误
					$userinfo = $userm->where("username='$username' && password='$password' && del_flag=0")->find();
				} else {
					$msg = C('no_have_this_username');
				}
			}

			if (!empty($userinfo)) {
				unset($userinfo['password']);
				session('userinfo',$userinfo);
				$emsg = 'login_success';
				$msg = C($emsg);
				if ($_POST['is_ajax']) {
					// 设置最后登录时间
					if ($userinfo['uid'] != 'root') {
						$data['lastlogintime'] = time();
						$userm->where("uid={$userinfo['uid']}")->save($data);
					}
					$this->ajaxReturn(array('login'=>2001, 'emsg'=>'login_success', 'msg'=>$msg));
				} else {
					$this->redirect('Login/login', '',3, $msg);
				}
			} else {
				empty($msg) ? $msg = C('login_failed') : 1;
				if ($_POST['is_ajax']) {
					$this->ajaxReturn(array('login'=>6001, 'emsg'=>'login_failed','msg'=>$msg));
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
		session_unset();
		session_destroy();
		$this->index();
	}

	// 生成验证码
	public function change_password() {
		$old_password = I('old_password_txt');
		$new_password = I('new_password_txt');
		$re_new_password = I('re_new_password_txt');
		$user_id = $_SESSION['userinfo']['uid'];
		$Model = new Model();
		$user = M("user");
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