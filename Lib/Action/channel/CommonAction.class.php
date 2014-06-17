<?php
class CommonAction extends Action {
    public function _initialize()
	{
		if(!isset($_SESSION['userinfo']['uid']))
		{
			$login_url = C('DOMAIN') . "gas_station_erp/index.php/configuration/Login/login";
			redirect($login_url);
			return;
		}
/*
		if('root' == $_SESSION['userinfo']['uid'])
		{
			//$this->error('没有权限');
			//return;
		}
*/
	}
}
?>