<?php
/*
 * 用户操作模型
 */
class UserModel extends Model {
	protected $tableName = 'bi_user';
	protected $tablePrefix  = '';
	protected $db  = '';
	// 获取用户信息
	//		$uid,获取那个uid的用户信息， $isdel如果用户被删除，是否返回信息 1为不返回，0为返回
	public function getUser($uid, $del_not_return=1) {
		C('DB_NAME') ? $dbname = C('DB_NAME') : $dbname='jnbizs';		// 注意此处数据库，未来可能出现问题，目前没有好解决办法
		$user = array('uid'=>0, 'orgid'=>0, 'grade'=>0);
		if ($uid != 'root') {
			$where = $del_not_return ? ' and del_flag=0' : '';
			$userinfo = $this->query('select * from `'.$dbname.'`.bi_user where uid='.$uid . $where);

			$user = $userinfo[0];
			$user_role_info = $this->query("select l.roleid,g.rolename from `$dbname`.bi_user_role l left join `$dbname`.bi_role g on l.roleid=g.roleid where l.userid=$uid");
			foreach ($user_role_info as $key=>$val) {
				$user['role'][$key]['rolename'] = $val['rolename'];
				$user['role'][$key]['roleid'] = $val['roleid'];
			}
			//array('agentsid'=>$userinfo[0]['agentsid'], 'grade'=>$userinfo[0]['grade'], 'username'=>$userinfo[0]['username'], 'realname'=>$userinfo[0]['realname'], 'agentsname'=>$userinfo[0]['agentsname']);
		} else {
			$user = array('uid'=>0, 'orgid'=>'', 'role'=>0, 'grade'=>1, 'username'=>'admin', 'realname'=>'根用户');
		}
		return $user;
	}
}
?>