<?php
//�޸Ķ�Ӧ���ID
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

//�������ID��������������ID
function getAgentIDFromChannelID($channel_id='') {
	$Model = new Model();
	$agent_id  = $Model->query("select agent_id from qd_channel where channel_id='$channel_id' AND isDelete = 0");
	return $agent_id[0]['agent_id'];
}

//������ID������������ID
function getChannelIDFromPlaceID($place_id='') {
	$Model = new Model();
	$channel_id  = $Model->query("select channel_id from qd_place where place_id='$place_id' AND isDelete = 0");
	return $channel_id[0]['channel_id'];
}

//��ݴ��������ַ��ش�����ID
function getAgentIDFromAgentName($agent_name='') {
	$Model = new Model();
	$agent_id  = $Model->query("select agent_id from qd_agent where agent_name='$agent_name' AND isDelete = 0");
	return $agent_id[0]['agent_id'];
}

//������������ַ���������ID
function getChannelIDFromChannelName($channel_name='') {
	$model = new Model();
	$channel_id  = $model->query("select channel_id from qd_channel where channel_name='$channel_name' AND isDelete = 0");
	return $channel_id[0]['channel_id'];
}

//���������ַ������ID
function getPlaceIDFromPlaceName($place_name='') {
	$Model = new Model();
	$place_id  = $Model->query("select place_id from qd_place where place_name='$place_name'  AND isDelete = 0");
	return $place_id[0]['place_id'];
}

//�������ŷ������ID
function getPlaceIDFromPlaceNO($place_no='') {
	$Model = new Model();
	$place_id  = $Model->query("select place_id from qd_place where place_no='$place_no'  AND isDelete = 0");
	return $place_id[0]['place_id'];
}

//�õ���������1������
function getAllChannelType() {
	$Model = new Model();
	$first_channel_type  = $Model->query("select channel_type_id, channel_type_name from qd_channel_type where channel_type_father_id='0'");
	return $first_channel_type;
}

//�����־��Ϣ
function addOptionLog($optin_name='', $option_id='', $option_type='', $option_descrption=''){
	$Model = new Model();
	$logs_option = new Model("QdLogsOption");
	$logs_option_description = new Model("QdLogsOptionDescription");

	$option_time = time();
	$data['option_name'] = $optin_name;
	$data['option_id']   = $option_id;
	$data['option_type'] = $option_type;
	$data['userid']      = $_SESSION['userinfo']['uid'];
	$data['timestamp']   = $option_time;
	
	$tmp_logs_id = $logs_option->add($data);
	if(($option_type == 'change') && $tmp_logs_id )
	{
		$descrption['option_log_id']     = $tmp_logs_id;
		$descrption['option_descrption'] = $option_descrption;
		$is_set_descrption = $logs_option_description->add($descrption);
	}
	return;
}

//����豸��־��Ϣ
function addDeviceLog($agent_id='', $channel_id='', $place_id='', $device_id='', $begin_time='', $end_time=''){
	$Model = new Model();
	$logs_device = new Model("QdLogsDevice");

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
	$Model->execute("update qd_logs_device set end_time=" . $end_time . " where device_id=" . $device_id);
	return;
}
?>