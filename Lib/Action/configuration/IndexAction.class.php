<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
	public $userinfo = null;
	function __construct(){
		parent::__construct();
		//获取用户信息
		$this->userinfo = getUserInfo();
	}
    public function index(){
		$this->display(':org_index');
    }
}