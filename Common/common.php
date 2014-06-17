<?php
function p($array)
{
	dump($array, true, 'pre', 0);
}

//根据用户ID返回用户信息
function getUserInfo($uid='') {
	$userinfo = null;
	$is_open_purview = C('is_open_purview');  //是否开启权限 1开启
	if('1' == $is_open_purview)
	{
		empty($uid)?$user_id=$_SESSION['userinfo']['uid']:$user_id=$uid;
		$user_db = D('User');
		$userinfo = $user_db->getUser($user_id);
	}
	else
	{
		$userinfo['role'] = 0;
		$userinfo['username'] =  $_SESSION['userinfo']['username'];
	}
	return $userinfo;
}

//根据1级代理商得到2级代理商数组
function getSubAgentArrayFromFatherAgent($father_agent_id) {
	$Model = new Model();
	$sub_agent_id  =  $Model->query("select agent_id from qd_agent where father_agentid=" . $father_agent_id);
	return $sub_agent_id;
}

//根据代理商得到下属代理商字符串
function getSubAgentStringFromFatherAgent($father_agent_id) {
	$Model = new Model();
	$sub_agent_id  =  $Model->query("select agent_id from qd_agent where father_agentid=" . $father_agent_id);
	//$second_type_id_array = array();
	foreach($sub_agent_id as $key=>$val)
	{
		$sub_agent_id_array[] = $val['agent_id'];
		$sub_sub_agent_id  =  $Model->query("select agent_id from qd_agent where father_agentid=" . $val['agent_id']);
		foreach($sub_sub_agent_id as $sub_key=>$sub_val){
			$sub_agent_id_array[] = $sub_val['agent_id'];
		}
	}
	$sub_agent_id_array_string = " ('" . implode("','", $sub_agent_id_array) . "')";

	return $sub_agent_id_array_string;
}

//导入EXCEL用
function GetInt4d($data, $pos) {
	$value = ord ( $data [$pos] ) | (ord ( $data [$pos + 1] ) << 8) | (ord ( $data [$pos + 2] ) << 16) | (ord ( $data [$pos + 3] ) << 24);
	if ($value >= 4294967294) {
		$value = - 2;
	}
	return $value;
}
?>