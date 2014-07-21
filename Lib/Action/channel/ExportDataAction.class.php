<?php
//导数据类
class ExportDataAction extends Action {
	//导出数据
	public function exportData(){
		$this->agentDataExport();
		$this->channelDataExport();
		$this->placeDataExport();
		$this->deviceDataExport();
		$this->calUpdateData();
		echo "导入成功";
	}

	public function addData(){
		$Model = new Model();
		$device_image = M("device_image");
		$deviceList = $Model->query("select * from qd_device");
		foreach($deviceList as $key=>$val)
		{
			$image['device_id'] = $val['device_id'];
			$image['image_path'] = '';
			$is_set = $device_image->add($image);
			$is_set = $device_image->add($image);
		}
	}

	//导出代理商数据
	public function agentDataExport(){
		$Model = new Model();
		$agent = M("agent");
		$agent_area = M("agent_area");
		$sql = 'select * from `360`.`qd_agent`';
		$agentList = $Model->query($sql);
		foreach($agentList as $key=>$val)
		{
			$data['agent_type'] = 'area';
			$data['agent_id'] = $val['agentid'];
			$data['agent_name'] = $val['agentname'];
			$data['companyAddr'] = $val['companyAddr'];
			//$data['contract_number'] = $val[''];
			$data['legal'] = $val['legal'];
			$data['tel'] = $val['tel'];
			$data['legal_tel'] = $val['tel'];
			$data['agent_level'] = 1;
			$data['sub_agent_num'] = 0;
			$data['channel_num'] = 0;
			$data['place_num'] = 0;
			$data['device_num'] = 0;
			$data['begin_time'] = 0;
			$data['end_time'] = 0;
			$data['forever_type'] = 0;
			$data['isDelete'] = 0;
			$is_set = $agent->add($data);

			$area['agent_id'] = $val['agentid'];
			$area['province'] = $val['province'];
			$area['city'] = $val['city'];
			$is_set = $agent_area->add($area);
		}
	}

	//导出渠道商数据
	public function channelDataExport(){
		$Model = new Model();
		$channel = M("channel");
		//$channel_area = M("channel_area");
		$channel_type_link = M("channel_type_link");
		$sql = 'select * from `360`.`qd_place`';
		$channelList = $Model->query($sql);
		foreach($channelList as $key=>$val)
		{
			$tmp_channel_count = $Model->query("select count(*) as count from qd_channel where channel_name='%s'", $val['channel']);
			if($tmp_channel_count[0]['count'] > 0)
			{
				continue;
			}
			$data['channel_name'] = $val['channel'];
			$agent_id = getAgentIDFromAgentName($val['agentname']);
			$data['agent_id'] = $agent_id;
			$data['contacts'] = 0;
			$data['contacts_tel'] = 0;
			$data['channel_tel'] = 0;
			$data['channel_address'] = 0;
			$data['contract_number'] = 0;
			$data['place_num'] = 0;
			$data['device_num'] = 0;
			$data['begin_time'] = 0;
			$data['end_time'] = 0;
			$data['forever_type'] = 0;
			$data['isDelete'] = 0;
			$is_set = $channel->add($data);

			$tmp_channel_id = $channel->query("select last_insert_id() as id");
			$channel_id = $tmp_channel_id[0]['id'];
			$area['channel_id'] = $channel_id;
			$agent_info = $Model->query("select province, city from `360`.`qd_agent` where agentid='$agent_id'");
			$area['province'] = $agent_info[0]['province'];
			$area['city'] = $agent_info[0]['city'];
			//$is_set = $channel_area->add($area);

			$type_link['channel_id'] = $channel_id;
			$tmp_channel_type_id = $Model->query("select channel_type_id from qd_channel_type where channel_type_name='%s'", $val['type']);
			$channel_type_id = $tmp_channel_type_id[0]['channel_type_id'];
			empty($channel_type_id) ? $type_link['channel_type_id']=0 : $type_link['channel_type_id'] = $channel_type_id;
			$is_set = $channel_type_link->add($type_link);
		}
	}

	//导出网点数据
	public function placeDataExport(){
		$Model = new Model();
		$place = M("place");
		$place_image = M("place_image");
		$sql = 'select * from `360`.`qd_place`';
		$placeList = $Model->query($sql);
		foreach($placeList as $key=>$val)
		{
			$data['place_id'] = $val['pid'];
			$data['place_no'] = $val['placeid'];
			$data['place_name'] = $val['placename'];
			$data['province'] = $val['province'];
			$data['city'] = $val['city'];
			$data['region'] = $val['region'];
			//$data['place_tel'] = $val['place_tel'];
			$data['contacts'] = 0;
			$data['contacts_tel'] = 0;
			$data['status'] = $val['status'];
			//$data['test_begin_time'] = $val['test_begin_time'];
			//$data['test_end_time'] = $val['test_end_time'];
			$channel_id = getChannelIDFromChannelName($val['channel']);
			$data['channel_id'] = $channel_id;
			$agent_id = getAgentIDFromChannelID($channel_id);
			$data['agent_id'] = $agent_id;
			//$data['place_type_id'] = 0;
			$data['device_num'] = 0;
			$data['begin_time'] = $val['begin_time'];
			$data['end_time'] = $val['repeal_time'];
			$data['sigh_time'] = $val['sigh_time'];
			$data['isDelete'] = 0;
			$tmp_place_type_id = $Model->query("select channel_type_id from qd_channel_type where channel_type_name='%s'", $val['type']);
			$place_type_id = $tmp_place_type_id[0]['channel_type_id'];
			empty($place_type_id) ? $data['place_type_id']=0 : $data['place_type_id'] = $place_type_id;
			$is_set = $place->add($data);

			$image['place_id'] = $val['pid'];
			$image['image_path'] = str_replace("http://admin.jienuo-service.net/", "", $val['image1']);
			$is_set = $place_image->add($image);

			$image['place_id'] = $val['pid'];
			$image['image_path'] = str_replace("http://admin.jienuo-service.net/", "", $val['image2']);
			$is_set = $place_image->add($image);

			$image['place_id'] = $val['pid'];
			$image['image_path'] = str_replace("http://admin.jienuo-service.net/", "", $val['image3']);
			$is_set = $place_image->add($image);
		}
	}

	//导出设备数据
	public function deviceDataExport(){
		$Model = new Model();
		$device = M("device");
		$device_image = M("device_image");
		$sql = 'select * from `360`.`qd_device`';
		$deviceList = $Model->query($sql);
		foreach($deviceList as $key=>$val)
		{
			$data['device_id'] = $val['did'];
			$data['device_no'] = $val['deviceno'];
			$data['MAC'] = $val['MAC'];
			$place_id = getPlaceIDFromPlaceNO($val['placeid']);
			$data['place_id'] = $place_id;
			$channel_id = getChannelIDFromPlaceID($place_id);
			$data['channel_id'] = $channel_id;
			$agent_id = getAgentIDFromChannelID($channel_id);
			$data['agent_id'] = $agent_id;
			$place_info = $Model->query("select province, city from `360`.`qd_place` where pid='$place_id'");
			$data['province'] = $place_info[0]['province'];
			$data['city'] = $place_info[0]['city'];
			$data['address'] = $val['pLocation'];
			$data['status'] = $val['status'];
			$data['device_type'] = $val['deviceType'];
			$data['begin_time'] = $val['begin_time'];
			$data['deploy_time'] = $val['deploy_time'];
			$data['description'] = $val['description'];
			$data['isDelete'] = 0;
			$is_set = $device->add($data);

			$image['device_id'] = $val['did'];
			$image['image_path'] = str_replace("http://admin.jienuo-service.net/", "", $val['device_image']);
			$is_set = $device_image->add($image);
		}
	}

	//计算更新相关数据
	public function calUpdateData(){
		$Model = new Model();
		$agent = M("agent");
		$channel = M("channel");
		$place = M("place");
		$agentList = $Model->query("select * from qd_agent");
		$channelList = $Model->query("select * from qd_channel");
		$placeList = $Model->query("select * from qd_place");
		foreach($agentList as $key=>$val)
		{
			$tmp_channel_num = $Model->query("select count(*) as channel_num from qd_channel where agent_id=" . $val['agent_id']);
			$channel_num = $tmp_channel_num[0]['channel_num'];
			$data['channel_num'] = $channel_num;
			$tmp_place_num = $Model->query("select count(*) as place_num from qd_place where agent_id=" . $val['agent_id']);
			$place_num = $tmp_place_num[0]['place_num'];
			$data['place_num'] = $place_num;
			$tmp_device_num = $Model->query("select count(*) as device_num from qd_device where agent_id=" . $val['agent_id']);
			$device_num = $tmp_device_num[0]['device_num'];
			$data['device_num'] = $device_num;
			$agent->where("agent_id=" . $val['agent_id'])->save($data);
		}
		foreach($channelList as $key=>$val)
		{
			$tmp_place_num = $Model->query("select count(*) as place_num from qd_place where channel_id=" . $val['channel_id']);
			$place_num = $tmp_place_num[0]['place_num'];
			$data['place_num'] = $place_num;
			$tmp_device_num = $Model->query("select count(*) as device_num from qd_device where channel_id=" . $val['channel_id']);
			$device_num = $tmp_device_num[0]['device_num'];
			$data['device_num'] = $device_num;
			$channel->where("channel_id=" . $val['channel_id'])->save($data);
		}
		foreach($placeList as $key=>$val)
		{
			$tmp_device_num = $Model->query("select count(*) as device_num from qd_device where place_id=" . $val['place_id']);
			$device_num = $tmp_device_num[0]['device_num'];
			$data['device_num'] = $device_num;
			$place->where("place_id=" . $val['place_id'])->save($data);
		}
	}

}
?>