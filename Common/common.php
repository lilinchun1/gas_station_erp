<?php
function p($array) {
	dump ( $array, true, 'pre', 0 );
}

// 根据用户ID返回用户信息
function getUserInfo($uid = '') {
	$userinfo = null;
	$is_open_purview = C ( 'is_open_purview' ); // 是否开启权限 1开启
	if ('1' == $is_open_purview) {
		empty ( $uid ) ? $user_id = $_SESSION ['userinfo'] ['uid'] : $user_id = $uid;
		$user_db = D ( 'User' );
		$userinfo = $user_db->getUser ( $user_id );
	} else {
		$userinfo ['role'] = 0;
		$userinfo ['username'] = $_SESSION ['userinfo'] ['username'];
	}
	return $userinfo;
}

// 根据1级代理商得到2级代理商数组
function getSubAgentArrayFromFatherAgent($father_agent_id) {
	$Model = new Model ();
	$sub_agent_id = $Model->query ( "select agent_id from qd_agent where father_agentid=" . $father_agent_id );
	return $sub_agent_id;
}

// 根据代理商得到下属代理商字符串
function getSubAgentStringFromFatherAgent($father_agent_id) {
	$Model = new Model ();
	$sub_agent_id = $Model->query ( "select agent_id from qd_agent where father_agentid=" . $father_agent_id );
	// $second_type_id_array = array();
	foreach ( $sub_agent_id as $key => $val ) {
		$sub_agent_id_array [] = $val ['agent_id'];
		$sub_sub_agent_id = $Model->query ( "select agent_id from qd_agent where father_agentid=" . $val ['agent_id'] );
		foreach ( $sub_sub_agent_id as $sub_key => $sub_val ) {
			$sub_agent_id_array [] = $sub_val ['agent_id'];
		}
	}
	$sub_agent_id_array_string = " ('" . implode ( "','", $sub_agent_id_array ) . "')";
	
	return $sub_agent_id_array_string;
}

// 根据代理商得到上级代理商字符串
function getFatherAgentStringFromAgent($agent_id) {
	$Model = new Model ();
	$father_agent_id = $Model->query ( "select father_agentid from qd_agent where father_agentid != agent_id and agent_id=" . $agent_id );
	// $second_type_id_array = array();
	foreach ( $father_agent_id as $key => $val ) {
		$father_agent_id_array [] = $val ['father_agentid'];
		$father_father_agent_id = $Model->query ( "select father_agentid from qd_agent where agent_id=" . $val ['father_agentid'] );
		foreach ( $father_father_agent_id as $father_key => $father_val ) {
			$father_agent_id_array [] = $father_val ['father_agentid'];
			$f_father_father_agent_id = $Model->query ( "select father_agentid from qd_agent where agent_id=" . $father_val ['father_agentid'] );
			foreach ( $f_father_father_agent_id as $f_father_key => $f_father_val ) {
				$father_agent_id_array [] = $f_father_val ['father_agentid'];
			}
		}
	}
	$father_agent_id_array_string = " ('" . implode ( "','", $father_agent_id_array ) . "')";
	
	return $father_agent_id_array_string;
}

// 导入EXCEL用
function GetInt4d($data, $pos) {
	$value = ord ( $data [$pos] ) | (ord ( $data [$pos + 1] ) << 8) | (ord ( $data [$pos + 2] ) << 16) | (ord ( $data [$pos + 3] ) << 24);
	if ($value >= 4294967294) {
		$value = - 2;
	}
	return $value;
}
function getChangeLogDescription($src_log_info, $dst_log_info) {
	$log_description = '';
	$property = "属性";
	foreach ( $src_log_info as $key => $val ) {
		if ($val != $dst_log_info [$key]) {
			if (C ( $key )) {
				$property = C ( $key );
			}
			if (! empty ( $val )) {
				$src_property_info = C ( $val );
				$src_property_info = empty ( $src_property_info ) ? $val : $src_property_info;
			} else {
				$src_property_info = '空';
			}
			if (! empty ( $dst_log_info [$key] )) {
				$dst_property_info = C ( $dst_log_info [$key] );
				$dst_property_info = empty ( $dst_property_info ) ? $dst_log_info [$key] : $dst_property_info;
			} else {
				$dst_property_info = '空';
			}
			
			$log_description .= "修改内容: " . $property . "由" . $src_property_info . "变更为:" . $dst_property_info . ";<br>";
		}
	}
	return $log_description;
}
//回传指定登陆者权限所能访问url字符串
function ableUrlStr($uid) {
	$model = new Model ();
	$str = "
	SELECT c.url FROM bi_user_role a
	LEFT JOIN bi_role_menu b ON a.roleid = b.role_id
	LEFT JOIN bi_menu c ON b.menu_id = c.menu_id
	WHERE a.userid = '$uid'
	";
	$que = $model->query ( $str );
	$url_str = "";
	foreach ( $que as $k => $v ) {
		$url_str .= $v ['url'].",";
	}
	return $url_str;
}
?>