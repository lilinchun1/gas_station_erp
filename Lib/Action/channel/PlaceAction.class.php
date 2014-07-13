<?php
import( "@.MyClass.Page" );//导入分页类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}
//网点类
class PlaceAction extends Action {
	public function index(){
		$userinfo = getUserInfo();
		$this->username = $userinfo['realname']; //登录的用户名
		/*$this->is_channel_user = in_array("渠道部", $userinfo['group']); //等于1为渠道部用户
		$this->agentsid = $userinfo['agentsid']; //agentsid为空则为总公司
		$this->is_have_user_purview = in_array($userinfo['grade'], array(1,2,3));
		$first_place_type = getAllChannelType();
		$this->assign('first_place_type', $first_place_type);*/
		$this->assign('nowUrl', "channel/Place/index");
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->display(':place_index');
	}

	//查询网点信息
	public function placeSelect(){
		$userinfo = getUserInfo();
	    $Model = new Model();
		$place_no = trim(I('place_no_txt'));
		$place_name = trim(I('place_name_txt'));
		$place_state = trim(I('place_state_sel'));
		$channel_name = trim(I('channel_name_txt'));
		$province = trim(I('select_province'));
		$city = trim(I('select_city'));
		$test_end_time_1 = trim(I('select_test_end_time_1'));
		$test_end_time_2 = trim(I('select_test_end_time_2'));
		$del_flag_txt = trim(I('select_del_flag_txt'));
		$is_place_select_show = 1;
		//$page_show_number = 30;       //每页显示的数量
		C('page_show_number')?$page_show_number=C('page_show_number'):$page_show_number=30;  //每页显示的数量
		$where = "a.isDelete='$del_flag_txt'";
		if(!empty($place_no))
		{
			$where .= " and a.place_no='$place_no'";
		}
		if(!empty($place_name))
		{
			$where .= " and a.place_name='$place_name'";
		}
		if(!empty($place_state))
		{
			$where .= " and a.status='$place_state'";
		}
		if(!empty($test_end_time_1))
		{
			$where .= " and a.test_end_time>='$test_end_time_1'";
		}
		if(!empty($test_end_time_2))
		{
			$where .= " and a.test_end_time<='$test_end_time_2'";
		}
		if(!empty($channel_name))
		{
			$channel_id = getChannelIDFromChannelName($channel_name);
			$where .= " and a.channel_id=" . $channel_id;
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

		if((!empty($userinfo['orgid'])) && (1 != $userinfo['orgid']))
		{
			$sub_agent_id = getSubAgentStringFromFatherAgent($userinfo['orgid']);
			$where .= " and (a.agent_id='{$userinfo['orgid']}' or a.agent_id in $sub_agent_id)"; //权限限制
		}

		$count = $Model->table('qd_place a')->where($where)->count();
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		//$Page->url = 'Agent/agentSelect/p/';
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		$list = $Model->table('qd_place a')->where($where)->order('a.place_id desc')->limit($Page->firstRow.','. $Page->listRows)->select();
		if($list=="")
		{
			$listCount = 0;
			$is_place_select_show = 2;
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
			$list[$i]['end_time'] = getDateFromTime($list[$i]['end_time']);
			$list[$i]['test_begin_time'] = getDateFromTime($list[$i]['test_begin_time']);
			$list[$i]['test_end_time'] = getDateFromTime($list[$i]['test_end_time']);
			$list[$i]['channel_name'] = getChannelNameFromChannelID($list[$i]['channel_id']);
			$list[$i]['place_type_name'] = getTypeNameFromID($list[$i]['place_type_id']);
			if('test' == $list[$i]['status'])
			{
				$list[$i]['status'] = "测试期";
			}
			else if('use' == $list[$i]['status'])
			{
				$list[$i]['status'] = "启用";
			}
			$list[$i]['region'] =  $list[$i]['region'];
			$place_image_info = $Model->query("select image_id, image_path, image_description from qd_place_image where place_id='" .					$list[$i]['place_id'] . "'");
			if(empty($place_image_info[0]['image_path']))
			{
				$list[$i]['place_image_0'] = null;
			}
			else
			{
				$list[$i]['place_image_0'] = C('image_url') . $place_image_info[0]['image_path'];
			}
	
			if(empty($place_image_info[1]['image_path']))
			{
				$list[$i]['place_image_1'] = null;
			}
			else
			{
				$list[$i]['place_image_1'] = C('image_url') . $place_image_info[1]['image_path'];
			}

			if(empty($place_image_info[2]['image_path']))
			{
				$list[$i]['place_image_2'] = null;
			}
			else
			{
				$list[$i]['place_image_2'] = C('image_url') . $place_image_info[2]['image_path'];
			}

			$list[$i]['placeRadioID'] = 'placeRadio' . $i; //用于详情点击的ID
			$list[$i]['placeDetailID'] = 'placeDetail' . $i; //用于选择的ID
			$list[$i]['placeRecoverID'] = 'placeRecover' . $i; //用于恢复的ID
		}

		$this->assign('isDeleteResult',$del_flag_txt);
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('is_place_select_show',$is_place_select_show); //是否显示结果集
		$this->assign('place_select_number',$count);  //查询结果集的数量
		$this->index();
	}

	//查询网点日志信息
	public function placeLogSelect(){
		$Model = new Model();
		$place_id = trim(I('place_id'));;
		$place_log = $Model->query("select a.logs_id, a.userid, a.timestamp, a.option_type from qd_logs_option a where a.option_id='$place_id' and 
			a.option_name='place'");
		$data = null;
		foreach($place_log as $key=>$val){
			if(0 == $val['userid']){
				$data[$key]['user'] = "根用户";
			}else{
				$tmp_username = $Model->query("select a.username from bi_user a where a.uid=" . $val['userid']);
				$data[$key]['user'] = $tmp_username[0]['username'];
			}
			$data[$key]['time'] = date('Y-m-d', $val['timestamp']);
			if('add' == $val['option_type']){
				$data[$key]['info'] = "添加";
			}
			elseif('del' == $val['option_type']){
				$data[$key]['info'] = "撤销";
			}
			elseif('change' == $val['option_type']){
				$tmp_descrption = $Model->query("select a.option_descrption from qd_logs_option_description a where a.option_log_id=" . $val['logs_id']);
				$data[$key]['info'] = $tmp_descrption[0]['option_descrption'];
			}
		}
		$this->ajaxReturn($data,'json');
	}

     //根据网点ID查询网点详细信息
     public function placeDetailSelect(){
	    $Model = new Model();
		$place_id = I('get.place_id');
		$where = "a.place_id='$place_id'";
		$dataPlace = $Model->table('qd_place a')->where($where)->select();// 查询满足要求的总记录数
		$imageDetail = $Model->query("select image_id, image_path, image_description from qd_place_image where place_id='$place_id'");
		$dataPlace[0]['channel_name'] = getChannelNameFromChannelID($dataPlace[0]['channel_id']);
		$first_place_type_id = $Model->query("select channel_type_father_id from qd_channel_type where channel_type_id=" . $dataPlace[0]['place_type_id']);
		$dataPlace[0]['first_place_type_id'] = $first_place_type_id[0]['channel_type_father_id'];
		$dataPlace[0]['image_id_0'] = $imageDetail[0]['image_id'];
		$dataPlace[0]['image_path_0'] = $imageDetail[0]['image_path'];
		$dataPlace[0]['image_id_1'] = $imageDetail[1]['image_id'];
		$dataPlace[0]['image_path_1'] = $imageDetail[1]['image_path'];
		$dataPlace[0]['image_id_2'] = $imageDetail[2]['image_id'];
		$dataPlace[0]['image_path_2'] = $imageDetail[2]['image_path'];
		$dataPlace[0]['begin_time'] = getDateFromTime($dataPlace[0]['begin_time']);
		$dataPlace[0]['end_time'] = getDateFromTime($dataPlace[0]['end_time']);
		$dataPlace[0]['test_begin_time'] = getDateFromTime($dataPlace[0]['test_begin_time']);
		$dataPlace[0]['test_end_time'] = getDateFromTime($dataPlace[0]['test_end_time']);

		$dataPlace[0]['power_on_hour_time'] = intval($dataPlace[0]['power_on_time']/100);
		$dataPlace[0]['power_on_minute_time'] = $dataPlace[0]['power_on_time']%100;
		$dataPlace[0]['power_off_hour_time'] = intval($dataPlace[0]['power_off_time']/100);
		$dataPlace[0]['power_off_minute_time'] = $dataPlace[0]['power_off_time']%100;
		$dataPlace[0]['power_on_hour_duration'] = intval($dataPlace[0]['power_on_duration']/100);
		$dataPlace[0]['power_on_minute_duration'] = $dataPlace[0]['power_on_duration']%100;
		//p($dataPlace[0]['date']);

		$data = $dataPlace[0];
		$this->ajaxReturn($data,'json');
	}

    //网点名称模糊查询
	public function placenameBlurrySelect(){
	    //$Model = new Model();
		$place_name = trim(I('place_name'));
		$place = M('place');
		$map['place_name'] =array('like', '%' . $place_name . '%');
		$placeInfo = $place->where($map)->distinct(true)->field('place_name')->select();
		for($i=0; $i< count($placeInfo); $i++)
		{
			$place_name_arr[$i]['title'] = $placeInfo[$i]['place_name'];
		}
		$this->ajaxReturn($place_name_arr,'json');
	}

	//网点编号模糊查询
	public function placenoBlurrySelect(){
	    //$Model = new Model();
		$place_no = trim(I('place_no'));
		$place = M('place');
		$map['place_no'] =array('like', '%' . $place_no . '%');
		$placeInfo = $place->where($map)->distinct(true)->field('place_no')->select();
		for($i=0; $i< count($placeInfo); $i++)
		{
			$place_no_arr[$i]['title'] = $placeInfo[$i]['place_no'];
		}
		$this->ajaxReturn($place_no_arr,'json');
	}

	//上传图片
	public function uploadImage(){
		$upload = new UploadAction();
		$image_path = $upload->upload();
		//$this->ajaxReturn($image_path, 'xml');
		echo $image_path;
	}

    //添加网点信息
	public function placeAdd(){
		$userinfo = getUserInfo();
		$place_no = trim(I('add_place_no_txt'));
		$place_name = trim(I('add_place_name_txt'));
		$province = trim(I('add_select_province'));
		$city = trim(I('add_select_city'));
		$region = trim(I('add_region_txt'));
		$place_tel = trim(I('add_place_tel_txt'));
		$contacts = trim(I('add_contacts_txt'));
		$contacts_tel = trim(I('add_contacts_tel_txt'));
		$status = trim(I('add_status_sel'));
		$test_begin_time = strtotime(trim(I('add_test_begin_time_sel')));
		$test_end_time = strtotime(trim(I('add_test_end_time_sel')));
		$channel_name = trim(I('add_channel_name_txt'));
		$place_first_type_id = trim(I('add_place_first_type_sel'));
		$place_second_type_id = trim(I('add_place_second_type_sel'));
		$begin_time = strtotime(trim(I('add_begin_time_sel')));
		$end_time = strtotime(trim(I('add_end_time_sel')));
		$contract_number = trim(I('add_contract_number_txt'));
		$sigh_time = strtotime(trim(I('add_sigh_time_sel')));
		$image_description = trim(I('add_image_description_txt'));
		$image_path_0 = trim(I('add_image_path_0'));
		$image_path_1 = trim(I('add_image_path_1'));
		$image_path_2 = trim(I('add_image_path_2'));
		$power_on_hour_time = trim(I('add_power_on_hour_time_sel'));
		$power_on_minute_time = trim(I('add_power_on_minute_time_sel'));
		$power_off_hour_time = trim(I('add_power_off_hour_time_sel'));
		$power_off_minute_time = trim(I('add_power_off_minute_time_sel'));
		$power_on_hour_duration = trim(I('add_power_on_hour_duration_sel'));
		$power_on_minute_duration = trim(I('add_power_on_minute_duration_sel'));
		$msg = C('add_place_success');

		$Model = new Model();
		$place = M("place");
		$place_image = M("place_image");
		$place_no_count = $Model->query("select count(*) as count from qd_place where place_no='$place_no'");
		$place_name_count = $Model->query("select count(*) as count from qd_place where place_name='$place_name'");
		$channel_id = getChannelIDFromChannelName($channel_name);
		$agent_id = getAgentIDFromChannelID($channel_id);
		$channel_count = $Model->query("select count(*) as count from qd_channel where channel_id='$channel_id'");
		$is_purview = judgeAgentPurview($userinfo['agentsid'], $agent_id);
		if(!$is_purview)
		{
			$msg = C('no_purview');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if($place_no_count[0]['count'] > 0)
		{
			$msg = C('place_no_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if($place_name_count[0]['count'] > 0)
		{
			$msg = C('place_name_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if($channel_count[0]['count'] != 1)
		{
			$msg = C('channel_not_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else
		{
			$data['place_no'] = $place_no;
			$data['place_name'] = $place_name;
			$data['province'] = $province;
			$data['city'] = $city;
			$data['region'] = $region;
			$data['place_tel'] = $place_tel;
			$data['contacts'] = $contacts;
			$data['contacts_tel'] = $contacts_tel;
			$data['status'] = $status;
			if('test' == $status)
			{
				if(0 != $test_begin_time)
				{
					$data['test_begin_time'] = $test_begin_time;
				}
				if(0 != $test_end_time)
				{
					$data['test_end_time'] = $test_end_time;
				}
			}
			$data['device_num'] = 0;
			$data['channel_id'] = $channel_id;
			if(empty($place_second_type_id))
			{
				$data['place_type_id'] = $place_first_type_id;
			}
			else
			{
				$data['place_type_id'] = $place_second_type_id;
			}
			if(0 != $begin_time)
			{
				$data['begin_time'] = $begin_time;
			}
			if(0 != $end_time)
			{
				$data['end_time'] = $end_time;
			}
			$data['agent_id'] = $agent_id;
			$data['contract_number'] = $contract_number;
			$data['sigh_time'] = $sigh_time;
			$data['isDelete'] = 0;
			$power_on_time =$power_on_hour_time . $power_on_minute_time;
			$power_off_time =$power_off_hour_time . $power_off_minute_time;
			$power_on_duration = $power_on_hour_duration . $power_on_minute_duration;
			$data['power_on_time'] = $power_on_time;
			$data['power_off_time'] = $power_off_time;
			$data['power_on_duration'] = $power_on_duration;
			$is_set = $place->add($data);
			if($is_set)
			{
				$tmp_place_id = $place->query('select last_insert_id() as id');
				$place_id = $tmp_place_id[0]['id'];
				$image['place_id'] = $place_id;
				$image['image_path'] = $image_path_0;
				$is_set = $place_image->add($image);

				$image['place_id'] = $place_id;
				$image['image_path'] = $image_path_1;
				$is_set = $place_image->add($image);

				$image['place_id'] = $place_id;
				$image['image_path'] = $image_path_2;
				$is_set = $place_image->add($image);
			}
			else
			{
				$msg = C('add_place_failed');
			}
		}
		if(C('add_place_success') == $msg)
		{
			changeNum('place', $channel_id, $place_id, 'add');
			addOptionLog('place', $place_id, 'add', '');
		}
		$this->ajaxReturn($msg,'json');
	}

    //修改网点信息
	public function placeSave(){
		$userinfo = getUserInfo();
		$place_id = trim(I('change_place_id_txt'));
		$place_no = trim(I('change_place_no_txt'));
		$place_name = trim(I('change_place_name_txt'));
		$province = trim(I('change_select_province'));
		$city = trim(I('change_select_city'));
		$region = trim(I('change_region_txt'));
		$place_tel = trim(I('change_place_tel_txt'));
		$contacts = trim(I('change_contacts_txt'));
		$contacts_tel = trim(I('change_contacts_tel_txt'));
		$status = I('change_status_sel');
		$test_begin_time = strtotime(I('change_test_begin_time_sel'));
		$test_end_time = strtotime(I('change_test_end_time_sel'));
		$channel_name = trim(I('change_channel_name_txt'));
		$place_first_type_id = trim(I('change_place_first_type_sel'));
		$place_second_type_id = trim(I('change_place_second_type_sel'));
		$begin_time = strtotime(trim(I('change_begin_time_sel')));
		$end_time = strtotime(trim(I('change_end_time_sel')));
		$contract_number = trim(I('change_contract_number_txt'));
		$sigh_time = strtotime(trim(I('change_sigh_time_sel')));
		$image_description = trim(I('change_image_description_txt'));
		$image_id_0 = trim(I('change_image_id_0'));
		$image_id_1 = trim(I('change_image_id_1'));
		$image_id_2 = trim(I('change_image_id_2'));
		$image_path_0 = trim(I('change_image_path_0'));
		$image_path_1 = trim(I('change_image_path_1'));
		$image_path_2 = trim(I('change_image_path_2'));
		$power_on_hour_time = trim(I('change_power_on_hour_time_sel'));
		$power_on_minute_time = trim(I('change_power_on_minute_time_sel'));
		$power_off_hour_time = trim(I('change_power_off_hour_time_sel'));
		$power_off_minute_time = trim(I('change_power_off_minute_time_sel'));
		$power_on_hour_duration = trim(I('change_power_on_hour_duration_sel'));
		$power_on_minute_duration = trim(I('change_power_on_minute_duration_sel'));
		$msg = C('change_place_success');
		$log_description = '';
		$log_photo_change_num = 0;

		$Model = new Model();
		$place = M("place");
		$channel_id = getChannelIDFromChannelName($channel_name);
		$agent_id = getAgentIDFromChannelID($channel_id);
		$place_no_count = $place->query("select count(*) as count from qd_place where place_no='$place_no'");
		$place_name_count = $place->query("select count(*) as count from qd_place where place_name='$place_name'");
		$channel_count = $Model->query("select count(*) as count from qd_channel where channel_id='$channel_id'");
		$src_channel_id = getChannelIDFromPlaceID($place_id);
		$src_agent_id = getAgentIDFromChannelID($src_channel_id);
		$src_image_path_0 = getPlacePhotoPathFromID($image_id_0);
		$src_image_path_1 = getPlacePhotoPathFromID($image_id_1);
		$src_image_path_2 = getPlacePhotoPathFromID($image_id_2);
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
		$src_place_info = $Model->table('qd_place')->where("place_id='%d'", $place_id)->select(); //记录原来的网点信息
		$src_place_log_info = $Model->table('qd_place')->where("place_id='%d'", $place_id)->select();  //查询修改前的信息，用于日志对比
		$src_place_log_info[0]['place_begin_time'] = getDateFromTime($src_place_log_info[0]['begin_time']);
		unset($src_place_log_info[0]['begin_time']);
		$src_place_log_info[0]['place_end_time'] = getDateFromTime($src_place_log_info[0]['end_time']);
		unset($src_place_log_info[0]['end_time']);
		$src_place_log_info[0]['test_begin_time'] = getDateFromTime($src_place_log_info[0]['test_begin_time']);
		$src_place_log_info[0]['test_end_time'] = getDateFromTime($src_place_log_info[0]['test_end_time']);

		$src_place_log_info[0]['place_channel_name'] = getChannelNameFromChannelID($src_place_log_info[0]['channel_id']);
		unset($src_place_log_info[0]['channel_id']);
		$src_place_log_info[0]['place_type_name'] = getTypeNameFromID($src_place_log_info[0]['place_type_id']);
		unset($src_place_log_info[0]['place_type_id']);
		unset($src_place_log_info[0]['agent_id']);
		/*
		$src_place_log_info[0]['power_on_time'] = intval($src_place_log_info[0]['power_on_time']/100) . '时' .
			$src_place_log_info[0]['power_on_time']%100 . "分";
		$src_place_log_info[0]['power_off_time'] = intval($src_place_log_info[0]['power_off_time']/100) . '时' .
			$src_place_log_info[0]['power_off_time']%100 . "分";
		$src_place_log_info[0]['power_on_duration'] = intval($src_place_log_info[0]['power_on_duration']/100) . '时' .
			$src_place_log_info[0]['power_on_duration']%100 . "分";
			*/
		$is_purview = judgeAgentPurview($userinfo['agentsid'], $agent_id);
		if(!$is_purview)
		{
			$msg = C('no_purview');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if(($src_place_info[0]['place_no'] != $place_no) && ($place_id_count[0]['count'] > 0))
		{
			$msg = C('change_place_no_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if(($src_place_info[0]['place_name'] != $place_name) && ($place_name_count[0]['count'] > 0))
		{
			$msg = C('change_place_name_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if($channel_count[0]['count'] != 1)
		{
			$msg = C('channel_not_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else
		{
			$data['place_no'] = $place_no;
			$data['place_name'] = $place_name;
			$data['province'] = $province;
			$data['city'] = $city;
			$data['region'] = $region;
			$data['place_tel'] = $place_tel;
			$data['contacts'] = $contacts;
			$data['contacts_tel'] = $contacts_tel;
			$data['status'] = $status;
			if('test' == $status)
			{
				if(0 != $test_begin_time)
				{
					$data['test_begin_time'] = $test_begin_time;
				}
				else
				{
					$data['test_begin_time'] = null;
				}
				if(0 != $test_end_time)
				{
					$data['test_end_time'] = $test_end_time;
				}
				else
				{
					$data['test_end_time'] = null;
				}
			}
			$data['channel_id'] = $channel_id;
			$data['agent_id'] = $agent_id;
			if(empty($place_second_type_id))
			{
				$data['place_type_id'] = $place_first_type_id;
			}
			else
			{
				$data['place_type_id'] = $place_second_type_id;
			}
			if(0 != $begin_time)
			{
				$data['begin_time'] = $begin_time;
			}
			else
			{
				$data['begin_time'] = null;
			}
			if(0 != $end_time)
			{
				$data['end_time'] = $end_time;
			}
			else
			{
				$data['end_time'] = null;
			}
			$data['contract_number'] = $contract_number;
			$data['sigh_time'] = $sigh_time;
			$power_on_time =$power_on_hour_time . $power_on_minute_time;
			$power_off_time =$power_off_hour_time . $power_off_minute_time;
			$power_on_duration = $power_on_hour_duration . $power_on_minute_duration;
			$data['power_on_time'] = $power_on_time;
			$data['power_off_time'] = $power_off_time;
			$data['power_on_duration'] = $power_on_duration;
			$is_set = $place->where("place_id='%d'", $place_id)->save($data);
		
			$place_image = M("place_image");
			$image['image_path'] = $image_path_0;
			$is_image_0 = $place_image->where("image_id=" . $image_id_0)->save($image);

			$image['image_path'] = $image_path_1;
			$is_image_1 = $place_image->where("image_id=" . $image_id_1)->save($image);

			$image['image_path'] = $image_path_2;
			$is_image_2 = $place_image->where("image_id=" . $image_id_2)->save($image);
			if(!($is_set) && !($is_image_0) && !($is_image_1) && !($is_image_2))
			{
				$msg = C('change_place_failed');
			}
		}
		if($msg == C('change_place_success'))
		{
			if($channel_id != $src_channel_id)
			{
				changeID('place', $channel_id, $place_id);
				changeNum('place', $src_channel_id, $place_id, 'minus');
				changeNum('place', $channel_id, $place_id, 'add');
			}
			$dst_place_log_info = $Model->table('qd_place')->where("place_id='%d'", $place_id)->select();  //查询修改后的信息，用于日志对比
			$dst_place_log_info[0]['place_begin_time'] = getDateFromTime($dst_place_log_info[0]['begin_time']);
			unset($dst_place_log_info[0]['begin_time']);
			$dst_place_log_info[0]['place_end_time'] = getDateFromTime($dst_place_log_info[0]['end_time']);
			unset($dst_place_log_info[0]['end_time']);
			$dst_place_log_info[0]['test_begin_time'] = getDateFromTime($dst_place_log_info[0]['test_begin_time']);
			$dst_place_log_info[0]['test_end_time'] = getDateFromTime($dst_place_log_info[0]['test_end_time']);

			$dst_place_log_info[0]['place_channel_name'] = getChannelNameFromChannelID($dst_place_log_info[0]['channel_id']);
			unset($dst_place_log_info[0]['channel_id']);
			$dst_place_log_info[0]['place_type_name'] = getTypeNameFromID($dst_place_log_info[0]['place_type_id']);
			unset($dst_place_log_info[0]['place_type_id']);
			/*
			$dst_place_log_info[0]['power_on_time'] = intval($dst_place_log_info[0]['power_on_time']/100) . '时' .
				$dst_place_log_info[0]['power_on_time']%100 . "分";
			$dst_place_log_info[0]['power_off_time'] = intval($dst_place_log_info[0]['power_off_time']/100) . '时' .
				$dst_place_log_info[0]['power_off_time']%100 . "分";
			$dst_place_log_info[0]['power_on_duration'] = intval($dst_place_log_info[0]['power_on_duration']/100) . '时' .
				$dst_place_log_info[0]['power_on_duration']%100 . "分";
				*/
			$log_description = getChangeLogDescription($src_place_log_info[0], $dst_place_log_info[0]);  //获取修改的详细记录
			if(0 != $log_photo_change_num)
			{
				$log_description .= "修改内容: " . "变更了" . $log_photo_change_num . "张图片;<br>";
			}
			
			addOptionLog('place', $place_id, 'change', $log_description);
		}
		$this->ajaxReturn($msg,'json');
	}

    //删除网点
	public function placeDelete(){
		$place_id = trim(I('place_id'));
	    $Model = new Model();
		$place = M("place");
		$msg = C('delete_place_success');
		$device_info = $Model->query("select device_id from qd_device where place_id=" . $place_id);
		$channel_id = getChannelIDFromPlaceID($place_id);
		if(!empty($device_info[0]['device_id'])){
			$msg = C('place_have_device');
		}else{
			$is_set = $place->where("place_id='$place_id'")->delete();
			if($is_set <= 0)
			{
				$msg = C('delete_place_failed');
			}
			if(C('delete_place_success') == $msg)
			{
				changeNum('place', $channel_id, $place_id, 'minus');
				addOptionLog('place', $place_id, 'del', '');
			}
		}
		$this->ajaxReturn($msg,'json');
		//$this->placeSelect();
	}

	 //撤销网点
	public function placeRepeal(){
		$place_id = trim(I('place_id'));

	    $Model = new Model();
		$place = M("place","qd_");
		$device = M("device","qd_");
		$msg = C('repeal_place_success');
		$is_set = $place->where("place_id='$place_id'")->setField('isDelete', 1);
		if($is_set <= 0)
		{
			$msg = C('repeal_place_failed');
		}
		if(C('repeal_place_success') == $msg)
		{
			$channel_id = getChannelIDFromPlaceID($place_id);
			$device_info = $Model->query("select device_id from qd_device where place_id=" . $place_id);
			foreach($device_info as $key=>$val){
				$is_set = $device->where("device_id=" . $val['device_id'])->setField('isDelete', 1);
				addOptionLog('device', $val['device_id'], 'del', '');
			}

			changeNum('place', $channel_id, $place_id, 'minus');
			addOptionLog('place', $place_id, 'del', '');
		}
		$this->ajaxReturn($msg,'json');
		//$this->placeSelect();
	}

	//恢复已经删除的网点信息
	public function placeRecover()
	{
		$place_id = trim(I('get.place_id'));
		$Model = new Model();
		$place = M("place");
		$is_set = $place->where("place_id='$place_id'")->setField('isDelete', 0);
		$channel_id = getChannelIDFromPlaceID($place_id);
		changeNum('place', $channel_id, $place_id, 'add');
		addOptionLog('place', $place_id, 'add', '');
		//$this->placeSelect();
	}
}
?>