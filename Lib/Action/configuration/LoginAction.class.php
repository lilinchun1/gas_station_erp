<?php
/*
 * 渠道管理类
 */
class LoginAction extends Action {
    public function index(){
		$this->display(':login_index');
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
				$userm = M('u_user');
				// 检查是否有该用户
				$uinfo = $userm->where("username='$username' && isdel=0")->find();
				if (!empty($uinfo)) {
					// 检查用户密码是否错误
					$userinfo = $userm->where("username='$username' && password='$password' && isdel=0")->find();
				} else {
					$msg = C('no_have_this_username');
				}
			}

			if (!empty($userinfo)) {
				unset($userinfo['password']);
				session('userinfo',$userinfo);
				$emsg = 'login_success';
				$msg = C($emsg);
				// 设置最后登录时间
				if ($userinfo['uid'] != 'root') {
					$data = array('lastlogintime'=>$_SERVER['REQUEST_TIME']);
					$userm->where("uid={$userinfo['uid']}")->save($data);
				}
				if ($_POST['is_ajax']) {
					$this->ajaxReturn(array('login'=>2001, 'emsg'=>'login_success', 'msg'=>$msg));
				} else {
					if ($_POST['refer'] && $userinfo['uid']!='root') {
						$refer = trim($_POST['refer']);
						redirect($refer);
					} else {
						$this->redirect('User/showlist', '',3, $msg);
					}
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
		if ($_GET['redirect']) {
			redirect('/user/index.php?m=login&a=login&redirect='.urldecode($_GET['redirect']));
		} else {
			$this->redirect('Login/login', '', 3, C('logout_success'));
		}
	}

	// 生成验证码
	public function verify() {
		import('ORG.Util.Image');
	    Image::buildImageVerify();
	}
}
?>