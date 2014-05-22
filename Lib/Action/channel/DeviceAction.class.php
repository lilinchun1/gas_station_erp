<?php
import( "@.MyClass.Page" );//导入分页类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}
//设备类
class DeviceAction extends CommonAction {
	public function index(){
		$userinfo = getUserInfo();
		$this->is_channel_user = in_array("渠道部", $userinfo['group']); //等于1为渠道部用户
		$this->agentsid = $userinfo['agentsid']; //agentsid为空则为总公司
		$this->username = $userinfo['username']; //登录的用户名
		$this->is_have_user_purview = in_array($userinfo['grade'], array(1,2,3));
		$first_place_type = getAllChannelType();
		$this->assign('first_place_type', $first_place_type);
		$this->display('channel:device_index');
	}

	//查询设备信息
	public function deviceSelect(){
		$userinfo = getUserInfo();
	    $Model = new Model();
		$place_no = trim(I('place_no_txt'));
		$place_name = trim(I('place_name_txt'));
		$device_no = trim(I('device_no_txt'));
		$MAC = trim(I('mac_txt'));
		$place_first_type_id = trim(I('place_first_type_sel'));
		$place_second_type_id = trim(I('place_second_type_sel'));
		$province = trim(I('select_province'));
		$city = trim(I('select_city'));
		$is_device_select_show = 1;
		//$page_show_number = 30;       //每页显示的数量
		C('page_show_number')?$page_show_number=C('page_show_number'):$page_show_number=30;  //每页显示的数量
		$where = '1=1';
		if(!empty($place_no))
		{
			$where .= " and b.place_no='$place_no'";
		}
		if(!empty($place_name))
		{
			$where .= " and b.place_name='$place_name'";
		}
		if(!empty($device_no))
		{
			$where .= " and a.device_no='$device_no'";
		}
		if(!empty($MAC))
		{
			$where .= " and a.MAC='$MAC'";
		}
		if(!empty($place_first_type_id))
		{
			if(!empty($place_second_type_id))
			{
				$where .= " and b.place_type_id=" . $place_second_type_id;
			}
			else
			{
				$where .= " and b.place_type_id in " . getTypeAttrString($place_first_type_id);
			}
		}
		if(!empty($province) && ('省份' != $province))
		{
			if(!empty($city) && ('地级市' != $city))
			{
				$where .= " and a.province='$province' and a.city='$city'";
			}
			else
			{
				$where .= " and a.province='$province'";
			}
		}
		if(!empty($userinfo['agentsid']))
		{
			$sub_agent_id = getSubAgentStringFromFatherAgent($userinfo['agentsid']);
			$where .= " and (a.agent_id='{$userinfo['agentsid']}' or a.agent_id in $sub_agent_id)"; //权限限制
		}
		$count = $Model->table('qd_device a')->join('qd_place b on a.place_id=b.place_id')->where($where)->count();
		//$tmp_count = $Model->query("select count(*) as count from qd_device a left join qd_place b on a.place_no=b.place_no" . $where);
		//$count = $tmp_count[0]['count'];
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		$list = $Model->table('qd_device a')->join('qd_place b on a.place_id=b.place_id')->where($where)->order('a.device_id												desc')->limit($Page->firstRow.','. $Page->listRows)->
					field('a.device_id, a.device_no, a.MAC, a.place_id, a.channel_id, a.agent_id, a.province, a.city, a.address, a.status, a.device_type,
					a.begin_time, a.deploy_time, a.repair_user, a.repair_user_tel, a.description, a.isDelete')->select();
		//$list = $Model->query("select * from qd_device a left join qd_place b on a.place_no=b.place_no" . $where . " order by a.device_no desc" . " limit " . //$Page->firstRow . ',' . $Page->listRows);
		if($list=="")
		{
			$listCount = 0;
			$is_device_select_show = 2;
		}
		else
		{
			$listCount = count($list);
		}
		if( I('get.p') == '')
		{
			$page_number = 1;
		}
		else
		{
			$page_number = I('get.p');
		}
		for($i=0; $i< $listCount; $i++)
		{
			$list[$i]['number'] = ($page_number-1) * $page_show_number + $i + 1;
			$list[$i]['begin_time'] = getDateFromTime($list[$i]['begin_time']);
			$list[$i]['deploy_time'] = getDateFromTime($list[$i]['deploy_time']);
			$list[$i]['place_name'] = getPlaceNameFromPlaceID($list[$i]['place_id']);
			$list[$i]['address'] = $list[$i]['province'] . $list[$i]['city'] . $list[$i]['address'];
			$device_image_info = $Model->query("select image_id, image_path, image_description from qd_device_image where device_id='" .					$list[$i]['device_id'] . "'");
			if(empty($device_image_info[0]['image_path']))
			{
				$list[$i]['device_image_0'] = null;
			}
			else
			{
				$list[$i]['device_image_0'] = C('image_url') . $device_image_info[0]['image_path'];
			}

			if(empty($device_image_info[1]['image_path']))
			{
				$list[$i]['device_image_1'] = null;
			}
			else
			{
				$list[$i]['device_image_1'] = C('image_url') . $device_image_info[1]['image_path'];
			}

			if(empty($device_image_info[2]['image_path']))
			{
				$list[$i]['device_image_2'] = null;
			}
			else
			{
				$list[$i]['device_image_2'] = C('image_url') . $device_image_info[2]['image_path'];
			}

			if('normal' == $list[$i]['status'])
			{
				$list[$i]['status'] = "正常";
			}
			elseif('abnormal' == $list[$i]['status'])
			{
				$list[$i]['status'] = "异常";
			}
			elseif('not_use' == $list[$i]['status'])
			{
				$list[$i]['status'] = "未运行";
			}
			$list[$i]['deviceRadioID'] = 'deviceRadio' . $i; //用于详情点击的ID
			$list[$i]['deviceDetailID'] = 'deviceDetail' . $i; //用于选择的ID
			$list[$i]['deviceRecoverID'] = 'deviceRecover' . $i; //用于恢复的ID
		}

		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('is_device_select_show',$is_device_select_show); //是否显示结果集
		$this->assign('device_select_number',$count); //查询结果集的数量
		$this->index();
	}

     //根据设备ID查询设备详细信息
     public function deviceDetailSelect(){
	    $Model = new Model();
		$device_id = I('get.device_id');
		$where = "a.device_id='$device_id'";
		$dataDevice = $Model->table('qd_device a')->where($where)->select();// 查询满足要求的总记录数
		$imageDetail = $Model->query("select image_id, image_path, image_description from qd_device_image where device_id='$device_id'");
		$dataDevice[0]['image_id_0'] = $imageDetail[0]['image_id'];
		$dataDevice[0]['image_path_0'] = $imageDetail[0]['image_path'];
		$dataDevice[0]['image_id_1'] = $imageDetail[1]['image_id'];
		$dataDevice[0]['image_path_1'] = $imageDetail[1]['image_path'];
		$dataDevice[0]['image_id_2'] = $imageDetail[2]['image_id'];
		$dataDevice[0]['image_path_2'] = $imageDetail[2]['image_path'];
		$dataDevice[0]['begin_time'] = getDateFromTime($dataDevice[0]['begin_time']);
		$dataDevice[0]['deploy_time'] = getDateFromTime($dataDevice[0]['deploy_time']);
		$dataDevice[0]['place_name'] = getPlaceNameFromPlaceID($dataDevice[0]['place_id']);

		$data = $dataDevice[0];
		$this->ajaxReturn($data,'json');
	}

    //设备编号模糊查询
	public function devicenoBlurrySelect(){
	    //$Model = new Model();
		$device_no = trim(I('device_no'));
		$device = M('device');
		$map['device_no'] =array('like', '%' . $device_no . '%');
		$deviceInfo = $device->where($map)->distinct(true)->field('device_no')->select();
		for($i=0; $i< count($deviceInfo); $i++)
		{
			$device_no_arr[$i]['title'] = $deviceInfo[$i]['device_no'];
		}
		$this->ajaxReturn($device_no_arr,'json');
	}

	//mac地址模糊查询
	public function devicemacBlurrySelect(){
	    //$Model = new Model();
		$device_mac = trim(I('device_mac'));
		$device = M('device');
		$map['MAC'] =array('like', '%' . $device_mac . '%');
		$deviceInfo = $device->where($map)->distinct(true)->field('MAC')->select();
		for($i=0; $i< count($deviceInfo); $i++)
		{
			$device_mac_arr[$i]['title'] = $deviceInfo[$i]['MAC'];
		}
		$this->ajaxReturn($device_mac_arr,'json');
	}

	//上传图片
	public function uploadImage(){
		$upload = new UploadAction();
		$image_path = $upload->upload();
		//$this->ajaxReturn($image_path, 'json');
		echo $image_path;
	}

    //添加设备信息
	public function deviceAdd(){
		$userinfo = getUserInfo();
		$device_no = trim(I('add_device_no_txt'));
		$mac = trim(I('add_mac_txt'));
		$place_name = trim(I('add_place_name_txt'));
		$province = trim(I('add_select_province'));
		$city = trim(I('add_select_city'));
		$deploy_time = strtotime(trim(I('add_deploy_time_sel')));
		$begin_time = strtotime(trim(I('add_begin_time_sel')));
		$status = trim(I('add_status_sel'));
		$device_type = I('add_device_type_txt');
		$address = trim(I('add_address_txt'));
		$repair_user = trim(I('add_repair_user_txt'));
		$repair_user_tel = trim(I('add_repair_user_tel_txt'));
		$description = trim(I('add_description_txt'));
		$image_path_0 = trim(I('add_image_path_0'));
		$image_path_1 = trim(I('add_image_path_1'));
		$image_path_2 = trim(I('add_image_path_2'));
		$msg = C('add_device_success');

		$Model = new Model();
		$device = M("device");
		$device_image = M("device_image");
		$place_id = getPlaceIDFromPlaceName($place_name);
		$channel_id = getChannelIDFromPlaceID($place_id);
		$agent_id = getAgentIDFromChannelID($channel_id);
		$device_no_count = $Model->query("select count(*) as count from qd_device where device_no='$device_no'");
		$mac_count = $Model->query("select count(*) as count from qd_device where MAC='$mac'");
		$place_count = $Model->query("select count(*) as count from qd_place where place_id='$place_id' and province='$province' and city='$city'");
		$is_purview = judgeAgentPurview($userinfo['agentsid'], $agent_id);
		if(!$is_purview)
		{
			$msg = C('no_purview');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if($device_no_count[0]['count'] > 0)
		{
			$msg = C('device_no_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if($mac_count[0]['count'] > 0)
		{
			$msg = C('mac_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if($place_count[0]['count'] != 1)
		{
			$msg = C('place_not_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else
		{
			$data['device_no'] = $device_no;
			$data['MAC'] = $mac;
			$data['place_id'] = $place_id;
			$data['province'] = $province;
			$data['city'] = $city;
			if(0 != $begin_time)
			{
				$data['begin_time'] = $begin_time;
			}
			if(0 != $deploy_time)
			{
				$data['deploy_time'] = $deploy_time;
			}
			$data['status'] = $status;
			$data['device_type'] = $device_type;
			$data['address'] = $address;
			$data['repair_user'] = $repair_user;
			$data['repair_user_tel'] = $repair_user_tel;
			$data['description'] = $description;
			$data['channel_id'] = $channel_id;
			$data['agent_id'] = $agent_id;
			$data['isDelete'] = 0;
			$is_set = $device->add($data);
			if($is_set)
			{
				$tmp_device_id = $device->query('select last_insert_id() as id');
				$device_id = $tmp_device_id[0]['id'];
				$image['device_id'] = $device_id;
				$image['image_path'] = $image_path_0;
				$is_set = $device_image->add($image);

				$image['device_id'] = $device_id;
				$image['image_path'] = $image_path_1;
				$is_set = $device_image->add($image);

				$image['device_id'] = $device_id;
				$image['image_path'] = $image_path_2;
				$is_set = $device_image->add($image);
			}
			else
			{
				$msg = C('add_device_failed');
			}
		}
		if($msg == C('add_device_success'))
		{
			changeNum('device', $place_id, $device_id, 'add');
			addOptionLog('device', $device_id, 'add', '');
			addDeviceLog($agent_id, $channel_id, $place_id, $device_id, $begin_time, '');
		}
		$this->ajaxReturn($msg,'json');
	}

    //修改设备信息
	public function deviceSave(){
		$userinfo = getUserInfo();
		$device_id = trim(I('change_device_id_txt'));
		$device_no = trim(I('change_device_no_txt'));
		$mac = trim(I('change_mac_txt'));
		$place_name = trim(I('change_place_name_txt'));
		$province = trim(I('change_select_province'));
		$city = trim(I('change_select_city'));
		$deploy_time = strtotime(trim(I('change_deploy_time_sel')));
		$begin_time = strtotime(trim(I('change_begin_time_sel')));
		$status = trim(I('change_status_sel'));
		$device_type = I('change_device_type_txt');
		$address = trim(I('change_address_txt'));
		$repair_user = trim(I('change_repair_user_txt'));
		$repair_user_tel = trim(I('change_repair_user_tel_txt'));
		$description = trim(I('change_description_txt'));
		$image_id_0 = trim(I('change_image_id_0'));
		$image_id_1 = trim(I('change_image_id_1'));
		$image_id_2 = trim(I('change_image_id_2'));
		$image_path_0 = trim(I('change_image_path_0'));
		$image_path_1 = trim(I('change_image_path_1'));
		$image_path_2 = trim(I('change_image_path_2'));
		$msg = C('change_device_success');
		$log_description = '';
		$log_photo_change_num = 0;
		$place_id = getPlaceIDFromPlaceName($place_name);
		$channel_id = getChannelIDFromPlaceID($place_id);
		$agent_id = getAgentIDFromChannelID($channel_id);
		$Model = new Model();
		$device = M("device");
		$device_no_count = $Model->query("select count(*) as count from qd_device where device_no='$device_no'");
		$mac_count = $Model->query("select count(*) as count from qd_device where MAC='$mac'");
		$place_count = $Model->query("select count(*) as count from qd_place where place_id='$place_id' and province='$province' and city='$city'");
		$src_device_info = $Model->table('qd_device')->where("device_id='%d'", $device_id)->select(); //记录原来的设备信息
		$is_purview = judgeAgentPurview($userinfo['agentsid'], $agent_id);
		if(!$is_purview)
		{
			$msg = C('no_purview');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if(($src_device_info[0]['device_no'] != $device_no) && ($device_no_count[0]['count'] > 0))
		{
			$msg = C('change_device_no_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if(($src_device_info[0]['MAC'] != $mac) && ($mac_count[0]['count'] > 0))
		{
			$msg = C('change_mac_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if($place_count[0]['count'] != 1)
		{
			$msg = C('place_not_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else
		{
			$src_place_id = getPlaceIDFromDeviceID($device_id);
			$src_channel_id = getChannelIDFromPlaceID($src_place_id);
			$src_agent_id = getAgentIDFromChannelID($src_channel_id);
			$src_image_path_0 = getDevicePhotoPathFromID($image_id_0);
			$src_image_path_1 = getDevicePhotoPathFromID($image_id_1);
			$src_image_path_2 = getDevicePhotoPathFromID($image_id_2);
			if($image_path_0 != $src_image_path_0)
			{
				$log_photo_change_num += 1;
			}
			if($image_path_1 != $src_image_path_1)
			{
				$log_photo_change_num += 1;
			}
			if($image_path_2 != $src_image_path_2)
			{
				$log_photo_change_num += 1;
			}
			$src_device_log_info = $Model->table('qd_device')->where("device_id='%d'", $device_id)->select();  //查询修改前的信息，用于日志对比
			$src_device_log_info[0]['device_place_name'] = getPlaceNameFromPlaceID($src_device_log_info[0]['place_id']);
			unset($src_device_log_info[0]['place_id']);
			unset($src_device_log_info[0]['channel_id']);
			unset($src_device_log_info[0]['agent_id']);
			$src_device_log_info[0]['device_begin_time'] = getDateFromTime($src_device_log_info[0]['begin_time']);
			unset($src_device_log_info[0]['begin_time']);
			$src_device_log_info[0]['deploy_time'] = getDateFromTime($src_device_log_info[0]['deploy_time']);

			$data['device_no'] = $device_no;
			$data['MAC'] = $mac;
			$data['place_id'] = $place_id;
			$data['channel_id'] = $channel_id;
			$data['agent_id'] = $agent_id;
			$data['province'] = $province;
			$data['city'] = $city;
			if(0 != $begin_time)
			{
				$data['begin_time'] = $begin_time;
			}
			else
			{
				$data['begin_time'] = null;
			}
			if(0 != $deploy_time)
			{
				$data['deploy_time'] = $deploy_time;
			}
			else
			{
				$data['deploy_time'] = null;
			}
			$data['status'] = $status;
			$tmp_status= $Model->query("select status from qd_device where device_id='$device_id'");
			if(('not_use' == $status) && ($tmp_status[0]['status'] != $status))
			{
				changeDeviceLogTime($device_id, '', time());
			}
			$data['device_type'] = $device_type;
			$data['address'] = $address;
			$data['repair_user'] = $repair_user;
			$data['repair_user_tel'] = $repair_user_tel;
			$data['description'] = $description;
			$is_set = $device->where("device_id='%d'", $device_id)->save($data);
		
			$device_image = M("device_image");
			$image['image_path'] = $image_path_0;
			$is_image_0 = $device_image->where("image_id=" . $image_id_0)->save($image);

			$image['image_path'] = $image_path_1;
			$is_image_1 = $device_image->where("image_id=" . $image_id_1)->save($image);

			$image['image_path'] = $image_path_2;
			$is_image_2 = $device_image->where("image_id=" . $image_id_2)->save($image);

			if(!($is_set) && !($is_image_0) && !($is_image_1) && !($is_image_2))
			{
				$msg = C('change_device_failed');
			}
		}

		if($msg == C('change_device_success'))
		{
			if($place_id != $src_place_id)
			{
				changeNum('device', $src_place_id, $device_id, 'minus');
				changeNum('device', $place_id, $device_id, 'add');
			}
			$dst_device_log_info = $Model->table('qd_device')->where("device_id='%d'", $device_id)->select();  //查询修改后的信息，用于日志对比
			$dst_device_log_info[0]['device_place_name'] = getPlaceNameFromPlaceID($dst_device_log_info[0]['place_id']);
			unset($dst_device_log_info[0]['place_id']);
			$dst_device_log_info[0]['device_begin_time'] = getDateFromTime($dst_device_log_info[0]['begin_time']);
			unset($dst_device_log_info[0]['begin_time']);
			$dst_device_log_info[0]['deploy_time'] = getDateFromTime($dst_device_log_info[0]['deploy_time']);

			$log_description = getChangeLogDescription($src_device_log_info[0], $dst_device_log_info[0]);  //获取修改的详细记录
			if(0 != $log_photo_change_num)
			{
				$log_description .= "修改内容: " . "变更了" . $log_photo_change_num . "张图片;<br>";
			}
			addOptionLog('device', $device_id, 'change', $log_description);
		}
		$this->ajaxReturn($msg,'json');
	}

    //删除设备
	public function deviceDelete(){
		$device_id = trim(I('device_id'));

	    $Model = new Model();
		$device = M("device");
		$msg = C('delete_device_success');
		$is_set = $device->where("device_id='$device_id'")->setField('isDelete', 1);
		if($is_set <= 0)
		{
			$this->msg = C('delete_device_failed');
		}

		if($msg == C('delete_device_success'))
		{
			$place_id = getPlaceIDFromDeviceID($device_id);
			changeNum('device', $place_id, $device_id, 'minus');
			addOptionLog('device', $device_id, 'del', '');
		}
		$this->ajaxReturn($msg,'json');
		//$this->deviceSelect();
	}

	//恢复已经删除的设备信息
	public function deviceRecover()
	{
		$device_id = trim(I('get.device_id'));
		$Model = new Model();
		$device = M("device");
		$is_set = $device->where("device_id='$device_id'")->setField('isDelete', 0);
		$place_id = getPlaceIDFromDeviceID($device_id);
		changeNum('device', $place_id, $device_id, 'add');
		addOptionLog('device', $device_id, 'add', '');
		//$this->deviceSelect();
	}
}
?>