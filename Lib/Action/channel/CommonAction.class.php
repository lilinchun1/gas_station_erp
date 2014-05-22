<?php
class CommonAction extends Action {
    public function _initialize()
	{
		if(!isset($_SESSION['userinfo']['uid']))
		{
			$login_url = C('DOMAIN') . "user/index.php?m=login&a=login&redirect=" . urlencode('/channel/index.php');
			redirect($login_url);
			return;
		}
		if('root' == $_SESSION['userinfo']['uid'])
		{
			$this->error('没有权限');
			return;
		}
	}
}
?>