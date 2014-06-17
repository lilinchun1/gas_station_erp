<?php
/*
 * POST提交验证
 */
function submit_verify($post_name) {
	if ($_POST[$post_name]) {
		return true;
	} else {
		return false;
	}
}

/*
 * 判断是否登录
 *		$option = redirect 跳转/ return 返回
 */
function check_login($option='redirect') {
	if ($_SESSION['userinfo']['uid'] && $_SESSION['userinfo']['grade']) {
		$user_db = D('User');
		$user = $user_db->getUser($_SESSION['userinfo']['uid']);
		return $user;
	} else {
		if ($option=='return') {
			return false;
		} else {
			header('Content-type: text/html; charset=utf-8');
			redirect(U('Login/login'), 3, C('no_login'));
		}
	}
}

/*
 * 返回代理商 参数为空，返回全部
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


// 验证并获取跟用户信息
function getRoot($username, $password) {
	$userinfo = array();
	if ($username == C('ROOT_USER') && $password == C('ROOT_PWSD')) {
		$userinfo = array(
			'uid' => 'root',
			'username' => $username,
			//'password' => $password,
			'agentsid' => 0,
			'grade' => 1,
		);
	}
	return $userinfo;
}

//根据整型日期获得字符串日期
function getDateFromTime($time) {
	$date = null;
	if(!empty($time))
	{
		$date = date('Y-m-d', $time);
	}

	return $date;
}

//根据用户id获取用户角色
function getRoleNameFromUID($uid) {
	$Model = new Model();
	$role_id  =  $Model->query("select roleid from bi_user_role where userid=" . $uid);
	$role_name = null;
	foreach($role_id as $key=>$val){
		$tmp_role_name =  $Model->query("select rolename from bi_role where roleid=" . $val['roleid']);
		$role_name .= $tmp_role_name[0]['rolename'] . ",";
	}
	if(!empty($role_id[0]['roleid'])){
		$role_name = substr($role_name, 0, -1);
	}

	return $role_name;
}

//根据网点图片ID得到图片路径
function getDevicePhotoPathFromID($device_photo_id) {
	$Model = new Model();
	$device_photo_path  =  $Model->query("select image_path from qd_device_image where image_id=" . $device_photo_id);

	return $device_photo_path[0]['image_path'];
}

//根据网点图片ID得到图片路径
function getPlacePhotoPathFromID($place_photo_id) {
	$Model = new Model();
	$place_photo_path  =  $Model->query("select image_path from qd_place_image where image_id=" . $place_photo_id);

	return $place_photo_path[0]['image_path'];
}

//根据类型得到所有属性
function getTypeAttrString($first_type_id) {
	$Model = new Model();
	$second_type_id  =  $Model->query("select channel_type_id from qd_channel_type where channel_type_father_id=" . $first_type_id);
	//$second_type_id_array = array();
	foreach($second_type_id as $key=>$val)
	{
		$second_type_id_array[] = $val['channel_type_id'];
	}
	$second_type_id_string = " ('" . implode("','", $second_type_id_array) . "')";

	return $second_type_id_string;
}

//修改对应表的ID
function changeID($option_name='', $up_option_id='', $option_id='')
{
	$Model = new Model();
	if('channel' == $option_name)
	{
		$agent_id = $up_option_id;
		$channel_id = $option_id;
		$Model->execute("update qd_place set agent_id=" . $agent_id . " where channel_id=" . $channel_id);
		$Model->execute("update qd_device set agent_id=" . $agent_id . " where channel_id=" . $channel_id);
	}
	if('place' == $option_name)
	{
		$channel_id = $up_option_id;
		$place_id = $option_id;
		$tmp_agent_id = $Model->query("select agent_id from qd_channel where channel_id='$channel_id'");
		$agent_id= $tmp_agent_id[0]['agent_id'];
		$Model->execute("update qd_device set channel_id='$channel_id' where place_id='$place_id'");
		$Model->execute("update qd_device set agent_id='$agent_id' where place_id='$place_id'");
	}
}


//减少或增加对应表的数量
function changeNum($option_name='', $up_option_id='', $option_id='', $option='')
{
	$Model = new Model();
	if('agent' == $option_name)
	{
		$father_agent_id = $up_option_id;
		$agent_id = $option_id;
		$tmp_channel_num = $Model->query("select channel_num from qd_agent where agent_id=" . $agent_id);
		$channel_num = $tmp_channel_num[0]['channel_num'];
		$tmp_place_num = $Model->query("select place_num from qd_agent where agent_id=" . $agent_id);
		$place_num = $tmp_place_num[0]['place_num'];
		$tmp_device_num = $Model->query("select device_num from qd_agent where agent_id=" . $agent_id);
		$device_num = $tmp_device_num[0]['device_num'];
		if($option == 'add')
		{
			$Model->execute("update qd_agent set sub_agent_num=sub_agent_num+1 where agent_id=" . $father_agent_id);
			$Model->execute("update qd_agent set channel_num=channel_num+" . $channel_num . " where agent_id=" . $father_agent_id);
			$Model->execute("update qd_agent set place_num=place_num+" . $place_num . " where agent_id=" . $father_agent_id);
			$Model->execute("update qd_agent set device_num=device_num+" . $device_num . " where agent_id=" . $father_agent_id);
		}
		if($option == 'minus')
		{
			$Model->execute("update qd_agent set sub_agent_num=sub_agent_num-1 where agent_id=" . $father_agent_id);
			$Model->execute("update qd_agent set channel_num=channel_num-" . $channel_num . " where agent_id=" . $father_agent_id);
			$Model->execute("update qd_agent set place_num=place_num-" . $place_num . " where agent_id=" . $father_agent_id);
			$Model->execute("update qd_agent set device_num=device_num-" . $device_num . " where agent_id=" . $father_agent_id);
		}
	}
	else if('channel' == $option_name)
	{
		$agent_id = $up_option_id;
		$channel_id = $option_id;
		$agent_info = $Model->query("select father_agentid, agent_level from qd_agent where agent_id=" . $agent_id);
		$tmp_place_num = $Model->query("select place_num from qd_channel where channel_id=" . $channel_id);
		$place_num = $tmp_place_num[0]['place_num'];
		$tmp_device_num = $Model->query("select device_num from qd_channel where channel_id=" . $channel_id);
		$device_num = $tmp_device_num[0]['device_num'];
		if($option == 'add')
		{
			$Model->execute("update qd_agent set channel_num=channel_num+1 where agent_id=" . $agent_id);
			$Model->execute("update qd_agent set place_num=place_num+" . $place_num . " where agent_id=" . $agent_id);
			$Model->execute("update qd_agent set device_num=device_num+" . $device_num . " where agent_id=" . $agent_id);
			if('2' == $agent_info[0]['agent_level'])
			{
				$Model->execute("update qd_agent set channel_num=channel_num+1 where agent_id=" . $agent_info[0]['father_agentid']);
				$Model->execute("update qd_agent set place_num=place_num+" . $place_num . " where agent_id=" . $agent_info[0]['father_agentid']);
				$Model->execute("update qd_agent set device_num=device_num+" . $device_num . " where agent_id=" . $agent_info[0]['father_agentid']);
			}
		}
		if($option == 'minus')
		{
			$Model->execute("update qd_agent set channel_num=channel_num-1 where agent_id=" . $agent_id);
			$Model->execute("update qd_agent set place_num=place_num-" . $place_num . " where agent_id=" . $agent_id);
			$Model->execute("update qd_agent set device_num=device_num-" . $device_num . " where agent_id=" . $agent_id);
			if('2' == $agent_info[0]['agent_level'])
			{
				$Model->execute("update qd_agent set channel_num=channel_num-1 where agent_id=" . $agent_info[0]['father_agentid']);
				$Model->execute("update qd_agent set place_num=place_num-" . $place_num . " where agent_id=" . $agent_info[0]['father_agentid']);
				$Model->execute("update qd_agent set device_num=device_num-" . $device_num . " where agent_id=" . $agent_info[0]['father_agentid']);
			}
		}
	}
	else if('place' == $option_name)
	{
		$channel_id = $up_option_id;
		$place_id = $option_id;
		$agent_id = getAgentIDFromChannelID($channel_id);
		$agent_info = $Model->query("select father_agentid, agent_level from qd_agent where agent_id=" . $agent_id);
		$tmp_device_num = $Model->query("select device_num from qd_place where place_id=" . $place_id);
		$device_num = $tmp_device_num[0]['device_num'];
		if($option == 'add')
		{
			$Model->execute("update qd_channel set place_num=place_num+1 where channel_id=" . $channel_id);
			$Model->execute("update qd_agent set place_num=place_num+1 where agent_id=" . $agent_id);
			$Model->execute("update qd_channel set device_num=device_num+" . $device_num . " where channel_id=" . $channel_id);
			$Model->execute("update qd_agent set device_num=device_num+" . $device_num . " where agent_id=" . $agent_id);
			if('2' == $agent_info[0]['agent_level'])
			{
				$Model->execute("update qd_agent set place_num=place_num+1 where agent_id=" . $agent_info[0]['father_agentid']);
				$Model->execute("update qd_agent set device_num=device_num+" . $device_num . " where agent_id=" . $agent_info[0]['father_agentid']);
			}
		}
		if($option == 'minus')
		{
			$Model->execute("update qd_channel set place_num=place_num-1 where channel_id=" . $channel_id);
			$Model->execute("update qd_agent set place_num=place_num-1 where agent_id=" . $agent_id);
			$Model->execute("update qd_channel set device_num=device_num-" . $device_num . " where channel_id=" . $channel_id);
			$Model->execute("update qd_agent set device_num=device_num-" . $device_num . " where agent_id=" . $agent_id);
			if('2' == $agent_info[0]['agent_level'])
			{
				$Model->execute("update qd_agent set place_num=place_num-1 where agent_id=" . $agent_info[0]['father_agentid']);
				$Model->execute("update qd_agent set device_num=device_num-" . $device_num . " where agent_id=" . $agent_info[0]['father_agentid']);
			}
		}
	}
	else if('device' == $option_name)
	{
		$place_id = $up_option_id;
		$channel_id = getChannelIDFromPlaceID($place_id);
		$agent_id = getAgentIDFromChannelID($channel_id);
		$agent_info = $Model->query("select father_agentid, agent_level from qd_agent where agent_id=" . $agent_id);
		if($option == 'add')
		{
			$Model->execute("update qd_place set device_num=device_num+1 where place_id='$place_id'");
			$Model->execute("update qd_channel set device_num=device_num+1 where channel_id=" . $channel_id);
			$Model->execute("update qd_agent set device_num=device_num+1 where agent_id=" . $agent_id);
			if('2' == $agent_info[0]['agent_level'])
			{
				$Model->execute("update qd_agent set device_num=device_num+1 where agent_id=" . $agent_info[0]['father_agentid']);
			}
		}
		if($option == 'minus')
		{
			$Model->execute("update qd_place set device_num=device_num-1 where place_id='$place_id'");
			$Model->execute("update qd_channel set device_num=device_num-1 where channel_id=" . $channel_id);
			$Model->execute("update qd_agent set device_num=device_num-1 where agent_id=" . $agent_id);
			if('2' == $agent_info[0]['agent_level'])
			{
				$Model->execute("update qd_agent set device_num=device_num-1 where agent_id=" . $agent_info[0]['father_agentid']);
			}
		}
	}
}

//判断代理商权限
function judgeAgentPurview($user_agent_id='', $option_agent_id='') {
	if(empty($user_agent_id))
	{
		return true;
	}

	$is_have_purview = false;
	$Model = new Model();
	$agent_user_info = $Model->query("select father_agentid, agent_level from qd_agent where agent_id=" . $user_agent_id);
	$agent_option_info = $Model->query("select father_agentid, agent_level from qd_agent where agent_id=" . $option_agent_id);
	if('2' == $agent_user_info[0]['agent_level'])
	{
		if('2' == $agent_option_info[0]['agent_level'])
		{
			if($user_agent_id == $option_agent_id)
			{
				$is_have_purview = true;
			}
		}
	}
	else
	{
		if('2' == $agent_option_info[0]['agent_level'])
		{
			if($user_agent_id == $agent_option_info[0]['father_agentid'])
			{
				$is_have_purview = true;
			}
		}
		else
		{
			if($user_agent_id == $option_agent_id)
			{
				$is_have_purview = true;
			}
		}
	}

	return $is_have_purview;
}

//根据代理商合同编号返回代理商ID
function getAgentIDFromAgentContract($contract_number='') {
	$Model = new Model();
	$agent_id  = $Model->query("select agent_id from qd_agent where contract_number='$contract_number'");
	return $agent_id[0]['agent_id'];
}

//根据渠道合同编号返回渠道ID
function getChannelIDFromChannelContract($contract_number='') {
	$Model = new Model();
	$channel_id  = $Model->query("select channel_id from qd_channel where contract_number='$contract_number'");
	return $channel_id[0]['channel_id'];
}

//根据设备MAC地址返回设备ID
function getDeviceIDFromDeviceMAC($MAC='') {
	$Model = new Model();
	$device_id  = $Model->query("select device_id from qd_device where MAC='$MAC'");
	return $device_id[0]['device_id'];
}

//根据设备编号返回设备ID
function getDeviceIDFromDeviceNO($device_no='') {
	$Model = new Model();
	$device_id  = $Model->query("select device_id from qd_device where device_no='$device_no'");
	return $device_id[0]['device_id'];
}

//根据设备ID返回设备编号
function getDeviceNOFromDeviceID($device_id='') {
	$Model = new Model();
	$device_no  = $Model->query("select device_no from qd_device where device_id='$device_id'");
	return $device_no[0]['device_no'];
}

//根据渠道ID返回所属代理商ID
function getAgentIDFromChannelID($channel_id='') {
	$Model = new Model();
	$agent_id  = $Model->query("select agent_id from qd_channel where channel_id='$channel_id'");
	return $agent_id[0]['agent_id'];
}

//根据网点ID返回所属渠道ID
function getChannelIDFromPlaceID($place_id='') {
	$Model = new Model();
	$channel_id  = $Model->query("select channel_id from qd_place where place_id='$place_id'");
	return $channel_id[0]['channel_id'];
}

//根据设备ID返回所属网点ID
function getPlaceIDFromDeviceID($device_id='') {
	$Model = new Model();
	$place_id  = $Model->query("select place_id from qd_device where device_id='$device_id'");
	return $place_id[0]['place_id'];
}

//根据代理商名字返回代理商ID
function getAgentIDFromAgentName($agent_name='') {
	$Model = new Model();
	$agent_id  = $Model->query("select agent_id from qd_agent where agent_name='$agent_name'");
	return $agent_id[0]['agent_id'];
}

//根据代理商ID返回代理商名字
function getAgentNameFromAgentID($agent_id='') {
	$Model = new Model();
	$agent_name  = $Model->query("select agent_name from qd_agent where agent_id=" . $agent_id);
	return $agent_name[0]['agent_name'];
}

//根据渠道商名字返回渠道商ID
function getChannelIDFromChannelName($channel_name='') {
	$Model = new Model();
	$channel_id  = $Model->query("select channel_id from qd_channel where channel_name='$channel_name'");
	return $channel_id[0]['channel_id'];
}

//根据渠道商ID返回渠道商名字
function getChannelNameFromChannelID($channel_id='') {
	$Model = new Model();
	$channel_name  = $Model->query("select channel_name from qd_channel where channel_id=" . $channel_id);
	return $channel_name[0]['channel_name'];
}

//根据网点名字返回网点ID
function getPlaceIDFromPlaceName($place_name='') {
	$Model = new Model();
	$place_id  = $Model->query("select place_id from qd_place where place_name='$place_name'");
	return $place_id[0]['place_id'];
}

//根据网点编号返回网点ID
function getPlaceIDFromPlaceNO($place_no='') {
	$Model = new Model();
	$place_id  = $Model->query("select place_id from qd_place where place_no='$place_no'");
	return $place_id[0]['place_id'];
}

//根据网点ID返回网点名字
function getPlaceNameFromPlaceID($place_id='') {
	$Model = new Model();
	$place_name  = $Model->query("select place_name from qd_place where place_id='$place_id'");
	return $place_name[0]['place_name'];
}


//得到所有渠道1级类型
function getAllChannelType() {
	$Model = new Model();
	$first_channel_type  = $Model->query("select channel_type_id, channel_type_name from qd_channel_type where channel_type_father_id='0'");
	return $first_channel_type;
}

//得到所有代理商
function getAllAgent() {
	$Model = new Model();
	$all_agent  = $Model->query("select agent_id, agent_name from qd_agent where isDelete='0'");
	return $all_agent;
}

//根据渠道ID查询渠道类型ID
function getChannelTypeIDFromChannelID($channel_id='') {
	$Model = new Model();
	$channel_type_id  = $Model->query("select a.channel_type_id from qd_channel_type_link a where a.channel_id=" . $channel_id);
	return $channel_type_id[0]['channel_type_id'];
}

//根据渠道ID查询渠道类型
function getChannelTypeFromID($channel_id='') {
	$Model = new Model();
	$first_channel_type  = $Model->query("select a.channel_type_father_id, a.channel_type_name from qd_channel_type a, qd_channel_type_link b where							a.channel_type_id=b.channel_type_id and b.channel_id=" . $channel_id);
	if('0' != $first_channel_type[0]['channel_type_father_id'])
	{
		$first_channel_type_father  = $Model->query("select channel_type_name from qd_channel_type where channel_type_id=" .									$first_channel_type[0]['channel_type_father_id']);
		$first_channel_type[0]['channel_type_name'] = $first_channel_type_father[0]['channel_type_name'] . ' ' . $first_channel_type[0]['channel_type_name'];
	}
	return $first_channel_type[0]['channel_type_name'];
}

//根据类型ID查询类型名字
function getTypeNameFromID($type_id='') {
	$Model = new Model();
	$place_type  = $Model->query("select a.channel_type_father_id, a.channel_type_name from qd_channel_type a where a.channel_type_id=" . $type_id);
	if('0' != $place_type[0]['channel_type_father_id'])
	{
		$place_type_father  = $Model->query("select channel_type_name from qd_channel_type where channel_type_id=" .									$place_type[0]['channel_type_father_id']);
		$place_type[0]['channel_type_name'] = $place_type_father[0]['channel_type_name'] . ' ' . $place_type[0]['channel_type_name'];
	}
	return $place_type[0]['channel_type_name'];
}

//添加日志信息
function addOptionLog($optin_name='', $option_id='', $option_type='', $option_descrption=''){
	$Model = new Model();
	$logs_option = M("logs_option");
	$logs_option_description = M("logs_option_description");

	$option_time = time();
	$data['option_name'] = $optin_name;
	$data['option_id'] = $option_id;
	$data['option_type'] = $option_type;
	$data['timestamp'] = $option_time;
	$is_set = $logs_option->add($data);
	$tmp_logs_id = $Model->query('select last_insert_id() as id');
	if(('change' == $option_type) && ($is_set) )
	{
		$descrption['option_log_id'] = $tmp_logs_id[0]['id'];
		$descrption['option_descrption'] = $option_descrption;
		$is_set_descrption = $logs_option_description->add($descrption);
	}
	return;
}

//添加设备日志信息
function addDeviceLog($agent_id='', $channel_id='', $place_id='', $device_id='', $begin_time='', $end_time=''){
	$Model = new Model();
	$logs_device = M("logs_device");

	$data['agent_id'] = $agent_id;
	$data['channel_id'] = $channel_id;
	$data['place_id'] = $place_id;
	$data['device_id'] = $device_id;
	$data['begin_time'] = $begin_time;
	$data['end_time'] = $end_time;
	$is_set = $logs_device->add($data);
	return;
}

function changeDeviceLogTime($device_id='', $begin_time='', $end_time=''){
	$Model = new Model();
	$logs_device = M("logs_device");

	$Model->execute("update qd_logs_device set end_time=" . $end_time . " where device_id=" . $device_id);
	return;
}

function getChangeLogDescription($src_log_info, $dst_log_info){
	$log_description = '';
	$property = "属性";
	foreach($src_log_info as $key=>$val)
	{
		if($val != $dst_log_info[$key])
		{
			if(C($key))
			{
				$property = C($key);
			}
			if(!empty($val))
			{
				$src_property_info = C($val);
				$src_property_info = empty($src_property_info)?$val:$src_property_info;
			}
			else
			{
				$src_property_info = '空';
			}
			if(!empty($dst_log_info[$key]))
			{
				$dst_property_info = C($dst_log_info[$key]);
				$dst_property_info = empty($dst_property_info)?$dst_log_info[$key]:$dst_property_info;
			}
			else
			{
				$dst_property_info = '空';
			}

			$log_description .= "修改内容: " . $property . "由" . $src_property_info . "变更为:" . $dst_property_info . ";<br>";
		}
	}
	return $log_description;
}
?>