<?php
/*
 * POST�ύ��֤
 */
function submit_verify($post_name) {
	if ($_POST[$post_name]) {
		return true;
	} else {
		return false;
	}
}

/*
 * ���ش����� ����Ϊ�գ�����ȫ��
 */
function getAgents($agentid=0, $agentname='') {
	$db = new model();
	$wheresql = 'isdelete=0';
	if ($agentid) {
		is_int($agentid) ? $wheresql .= ' and agent_id='.$agentid : false;
		is_array($agentid) ? $wheresql .= ' and agent_id in ('. implode(',', $agentid) .')' : false;
	}
	$agentname ? $wheresql .= ' and agent_name="'.$agentname.'"' : false;

	$sql = 'SELECT agent_id as agentsid, agent_name as agentsname from jienuo.qd_agent where '.$wheresql.' order by agentsid asc';
	$list = $db->query($sql);
	$list2 = array();
	foreach ($list as $l) {
		$list2[$l['agentsid']] = $l;
	}
	return $list2;
}

//����û�id��ȡ�û���ɫ
function getRoleNameFromUID($uid) {
	$model = new Model();
	$where = " where 1 ";
	if($uid){
		$where .= " and a.userid = $uid";
	}
	$sql = "
			SELECT b.rolename FROM bi_user_role a
			LEFT JOIN bi_role b ON a.roleid = b.roleid
			$where
			";
	$que = $model->query($sql);
	$role_name = "";
	foreach($que as $k=>$v){
		$role_name .= $v['rolename'] . ",";
	}
	$role_name = trim($role_name,',');
	return $role_name;
}

//��ݴ��������ַ��ش�����ID
function getAgentIDFromAgentName($agent_name='') {
	$Model = new Model();
	$agent_id  = $Model->query("select agent_id from qd_agent where agent_name='$agent_name' AND isDelete = 0");
	return $agent_id[0]['agent_id'];
}
?>