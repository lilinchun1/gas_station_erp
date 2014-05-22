<?php
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}
//首页
class IndexAction extends Action {
    public function index(){
		//header('Content-type: text/html; charset=utf-8');
	    //echo "欢迎使用渠道管理系统, 请先登录\n";
		//$url = "http://localhost/qdAdmin/index.php/Login/login";
		//header('Location: http://localhost/qdAdmin/index.php/Login/login');
		//redirect(U('Login/login'));
		//$this->display('Index:test');
		//$src_info = array('admin'=>'11', 'place_id'=>'11', 'agentname'=>'11', 'channel_name'=>'11');
		//$dst_info = array('admin'=>'22', 'place_id'=>'22', 'agentname'=>'22', 'channel_name'=>'22');
		//$log = getChangeLogDescription($src_info, $dst_info);
		//echo $log;
		//$userinfo = getUserInfo();
		//$this->is_channel_user = in_array("渠道部", $userinfo['group']); //等于1为渠道部用户
		//$this->agentsid = $userinfo['agentsid']; //agentsid为空则为总公司
		//$this->username = $userinfo['username']; //登录的用户名
		//$this->is_have_user_purview = in_array($userinfo['grade'], array(1,2,3));
		//print_r($userinfo);exit;
		//$this->error('没有权限');
		$this->display(':channel_index');
		//echo C('channel_test');
		//channel_test();
		//$ChannelModule = D('Channel');
		//$ChannelModule->test111();
		//$data = I('get.data');
		//$this->ajaxReturn($data['1'], 'json');
		//p($data);
    }
}