<?php
import( "@.MyClass.Page" );//导入分页类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}
//渠道商类
class ChannelAction extends CommonAction {
	public function index(){
		/*$userinfo = getUserInfo();
		$this->is_channel_user = in_array("渠道部", $userinfo['group']); //等于1为渠道部用户
		$this->agentsid = $userinfo['agentsid']; //agentsid为空则为总公司
		$this->username = $userinfo['username']; //登录的用户名
		$this->is_have_user_purview = in_array($userinfo['grade'], array(1,2,3));
		$first_channel_type = getAllChannelType();
		$all_agent = getAllAgent();
		$this->assign('first_channel_type', $first_channel_type);
		$this->assign('all_agent', $all_agent);*/
		$this->display(':channel_index');
	}

	public function getAllAgent(){
		$all_agent_info = getAllAgent();
		$this->ajaxReturn($all_agent_info, 'json');
	}

	public function getAllChannelType(){
		$all_type_info = getAllChannelType();
		$this->ajaxReturn($all_type_info, 'json');
	}

	//查询渠道商信息
	public function channelSelect(){
		$userinfo = getUserInfo();
	    $Model = new Model();
		$agent_name = trim(I('agent_name_txt'));
		$channel_first_type = trim(I('channel_first_type_sel'));
		$channel_second_type = trim(I('channel_second_type_sel'));
		$channel_name = trim(I('channel_name_txt'));
		$province = trim(I('select_province'));
		$city = trim(I('select_city'));
		$contract_begin_time_1 = strtotime(trim(I('contract_begin_time_1')));
		$contract_begin_time_2 = strtotime(trim(I('contract_begin_time_2')));
		$contract_end_time_1 = strtotime(trim(I('contract_end_time_1')));
		$contract_end_time_2 = strtotime(trim(I('contract_end_time_2')));
		$del_flag_txt = trim(I('select_del_flag_txt'));
		$is_channel_select_show = 1;
		//$page_show_number = 30;       //每页显示的数量
		C('page_show_number')?$page_show_number=C('page_show_number'):$page_show_number=30;  //每页显示的数量
		$where = "a.channel_id=b.channel_id and a.channel_id=c.channel_id and a.isDelete='$del_flag_txt'";
		if(!empty($agent_name))
		{
			$agent_id = getAgentIDFromAgentName($agent_name);
			$where .= " and a.agent_id=" . $agent_id;
		}
		if(!empty($channel_name))
		{
			$where .= " and a.channel_name='$channel_name'";
		}
		if(!empty($contract_begin_time_1))
		{
			$where .= " and a.begin_time>='$contract_begin_time_1'";
		}
		if(!empty($contract_begin_time_2))
		{
			$where .= " and a.begin_time<='$contract_begin_time_2'";
		}
		if(!empty($contract_end_time_1))
		{
			$where .= " and a.end_time>='$contract_end_time_1'";
		}
		if(!empty($contract_end_time_2))
		{
			$where .= " and a.end_time<='$contract_end_time_2'";
		}
		if(!empty($channel_first_type))
		{
			if(!empty($channel_second_type))
			{
				$where .= " and d.channel_type_id='$channel_second_type'";
			}
			else
			{
				$where .= " and (d.channel_type_id='$channel_first_type' or d.channel_type_father_id='$channel_first_type')";
			}
		}
		if(!empty($province) && ('省份' != $province))
		{
			if(!empty($city) && ('地级市' != $city))
			{
				$where .= " and b.province='$province' and b.city='$city'";
			}
			else
			{
				$where .= " and b.province='$province'";
			}
		}
		/*
		if(!empty($userinfo['agentsid']))
		{
			$sub_agent_id = getSubAgentStringFromFatherAgent($userinfo['agentsid']);
			$where .= " and (a.agent_id='{$userinfo['agentsid']}' or a.agent_id in $sub_agent_id)"; //权限限制
		}
		*/
		$count = $Model->table('qd_channel a, qd_channel_area b, qd_channel_type_link c')->join('qd_channel_type d on c.channel_type_id=d.channel_type_id')->where($where)->count();
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		//$Page->url = 'Agent/agentSelect/p/';
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		$list = $Model->table('qd_channel a, qd_channel_area b, qd_channel_type_link c')->join('qd_channel_type d on c.channel_type_id=d.channel_type_id')
		->where($where)->order('a.channel_id desc')->limit($Page->firstRow.','. $Page->listRows)
		->field('a.channel_id, a.channel_name, a.agent_id, a.contacts, a.contacts_tel, a.channel_tel, a.channel_address, a.contract_number,
		a.place_num, a.device_num, a.begin_time, a.end_time, a.forever_type, a.isDelete, b.province, b.city, c.channel_type_id,
		d.channel_type_father_id, d.channel_type_name')->select();
		if($list=="")
		{
			$listCount = 0;
			$is_channel_select_show = 2;
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
			$list[$i]['channel_address'] = $list[$i]['province'] . $list[$i]['city'] . $list[$i]['channel_address'];
			$list[$i]['agent_name'] = getAgentNameFromAgentID($list[$i]['agent_id']);
			$list[$i]['channel_type_name'] = getChannelTypeFromID($list[$i]['channel_id']);
			$list[$i]['channelRadioID'] = 'channelRadio' . $i; //用于详情点击的ID
			$list[$i]['channelDetailID'] = 'channelDetail' . $i; //用于选择的ID
			$list[$i]['channelRecoverID'] = 'channelRecover' . $i; //用于恢复的ID
		}

		$this->assign('isDeleteResult',$del_flag_txt);
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('is_channel_select_show',$is_channel_select_show); //是否显示结果集
		$this->assign('channel_select_number',$count); //查询结果集的数量
		$this->index();
	}

     //根据渠道ID查询渠道商详细信息
     public function channelDetailSelect(){
	    $Model = new Model();
		$channel_id = I('get.channel_id');
		$where = "a.channel_id=" . $channel_id;
		$dataChannel = $Model->table('qd_channel a')->where($where)->select();// 查询满足要求的总记录数
		$dataChannel[0]['begin_time'] = getDateFromTime($dataChannel[0]['begin_time']);
		$dataChannel[0]['end_time'] = getDateFromTime($dataChannel[0]['end_time']);
		//p($dataChannel[0]['date']);

		$data = $dataChannel[0];
		$this->ajaxReturn($data,'json');
	}

    //渠道商名字模糊查询
	public function channelnameBlurrySelect(){
	    //$Model = new Model();
		$channel_name = trim(I('channel_name'));
		$channel = M('channel');
		$map['channel_name'] =array('like', '%' . $channel_name . '%');
		$channelInfo = $channel->where($map)->distinct(true)->field('channel_name')->select();
		for($i=0; $i< count($channelInfo); $i++)
		{
			$channel_name_arr[$i]['title'] = $channelInfo[$i]['channel_name'];
		}
		$this->ajaxReturn($channel_name_arr,'json');
	}

	//渠道商合同编号模糊查询
	public function channelContractnumberBlurrySelect(){
	    //$Model = new Model();
		$contract_number = trim(I('contract_number'));
		$channel = M('channel');
		$map['contract_number'] =array('like', '%' . $contract_number . '%');
		$channelInfo = $channel->where($map)->distinct(true)->field('contract_number')->select();
		for($i=0; $i< count($channelInfo); $i++)
		{
			$channel_contract_number_arr[$i]['title'] = $channelInfo[$i]['contract_number'];
		}
		$this->ajaxReturn($channel_contract_number_arr,'json');
	}

    //添加渠道商信息
	public function channelAdd(){
		$userinfo = getUserInfo();
		$channel_name = trim(I('add_channel_name_txt'));
		$agent_id = trim(I('add_agent_id_sel'));
		$contacts = trim(I('add_contacts_txt'));
		$contacts_tel = trim(I('add_contacts_tel_txt'));
		$channel_tel = trim(I('add_channel_tel_txt'));
		$channel_address = trim(I('add_channel_address_txt'));
		$contract_number = trim(I('add_contract_number_txt'));
		$begin_time = strtotime(trim(I('add_begin_time_sel')));
		$end_time = strtotime(I('add_end_time_sel'));
		$channel_first_type = trim(I('add_channel_first_type_sel'));
		$channel_second_type = trim(I('add_channel_second_type_sel'));
		$province = trim(I('add_select_province'));
		$city = trim(I('add_select_city'));
		$add_forever_check = trim(I('add_forever_check'));
		$msg = C('add_channel_success');

		$is_purview = judgeAgentPurview($userinfo['agentsid'], $agent_id);
		if(!$is_purview)
		{
			$msg = C('no_purview');
			$this->ajaxReturn($msg,'json');
			return;
		}

		$Model = new Model();
		$channel = M("channel");
		$channel_area = M("channel_area");
		$channel_type_link = M('channel_type_link');
		$count = $Model->query("select count(*) as count from qd_channel a, qd_channel_area b where a.channel_name='%s' and a.channel_id=b.channel_id 
		    and	b.province='%s' and b.city='%s'", $channel_name, $province, $city);
		$channel_delete_count = $Model->query("select count(*) as count from qd_channel a where a.channel_name='%s' and a.isDelete='1'", $channel_name);
		if($channel_delete_count[0]['count'] > 0)
		{
			$msg = C('add_delete_channel');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if($count[0]['count'] > 0)
		{
			$msg = C('channel_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else
		{
			$data['channel_name'] = $channel_name;
			$data['agent_id'] = $agent_id;
			$data['contacts'] = $contacts;
			$data['contacts_tel'] = $contacts_tel;
			$data['channel_tel'] = $channel_tel;
			$data['channel_address'] = $channel_address;
			$data['contract_number'] = $contract_number;
			$data['forever_type'] = $add_forever_check;
			if(0 != $begin_time)
			{
				$data['begin_time'] = $begin_time;
			}
			if(0 != $end_time)
			{
				$data['end_time'] = $end_time;
			}
			$data['place_num'] = 0;
			$data['device_num'] = 0;
			$data['isDelete'] = 0;
			$is_set = $channel->add($data);
			if($is_set)
			{
				$tmp_channel_id = $Model->query('select last_insert_id() as id');
				$channel_id = $tmp_channel_id[0]['id'];
				$area['channel_id'] = $channel_id;
				$area['province'] = $province;
				$area['city'] = $city;
				$is_set = $channel_area->add($area);

				$type_link['channel_id'] = $channel_id;
				if('' != $channel_second_type)
				{
					$type_link['channel_type_id'] = $channel_second_type;
					$is_link_ok = $channel_type_link->query("select count(*) as count from qd_channel_type_link where channel_id=" . $channel_id . " and 
				    channel_type_id=" . $channel_second_type);
				}
				else
				{
					$type_link['channel_type_id'] = $channel_first_type;
					$is_link_ok = $channel_type_link->query("select count(*) as count from qd_channel_type_link where channel_id=" . $channel_id . " and 
				    channel_type_id=" . $channel_first_type);
				}
				if(0 == $is_link_ok[0]['count'])
				{
					$channel_type_link->add($type_link);
				}
			}
			else
			{
				$tmp_channel_id = $channel->query("select channel_id from qd_channel where channel_name='$channel_name'");
				$channel_id = $tmp_channel_id[0]['channel_id'];
				$area['channel_id'] = $channel_id;
				$area['province'] = $province;
				$area['city'] = $city;
				$is_set = $channel_area->add($area);
				if($is_set)
				{
					if('' != $channel_second_type)
					{
						$type_link['channel_type_id'] = $channel_second_type;
						$is_link_ok = $channel_type_link->query("select count(*) as count from qd_channel_type_link where channel_id=" . $channel_id . " and 
							channel_type_id=" . $channel_second_type);
					}
					else
					{
						$type_link['channel_type_id'] = $channel_first_type;
						$is_link_ok = $channel_type_link->query("select count(*) as count from qd_channel_type_link where channel_id=" . $channel_id . " and 
							channel_type_id=" . $channel_first_type);
					}
					if(0 == $is_link_ok[0]['count'])
					{
						$channel_type_link->add($type_link);
					}
				}
				else
				{
					$msg = C('add_channel_failed');
					$this->ajaxReturn($msg,'json');
					return;
				}
			}

			if($msg == C('add_channel_success'))
			{
				changeNum('channel', $agent_id, $channel_id, 'add');
				addOptionLog('channel', $channel_id, 'add', '');
			}
			$this->ajaxReturn($msg,'json');
		}
	}

    //修改渠道商信息
	public function channelSave(){
		$userinfo = getUserInfo();
		$channel_name = trim(I('change_channel_name_txt'));
		$channel_id = trim(I('change_channel_id_txt'));
		$agent_id = trim(I('change_agent_id_sel'));
		$contacts = trim(I('change_contacts_txt'));
		$contacts_tel = trim(I('change_contacts_tel_txt'));
		$channel_tel = trim(I('change_channel_tel_txt'));
		$channel_address = trim(I('change_channel_address_txt'));
		$contract_number = trim(I('change_contract_number_txt'));
		$begin_time = strtotime(trim(I('change_begin_time_sel')));
		$end_time = strtotime(trim(I('change_end_time_sel')));
		$src_channel_first_type = trim(I('src_channel_first_type'));
		$src_channel_second_type = trim(I('src_channel_second_type'));
		$dst_channel_first_type = trim(I('dst_channel_first_type_sel'));
		$dst_channel_second_type = trim(I('dst_channel_second_type_sel'));
		$src_province = trim(I('change_src_province'));
		$src_city = trim(I('change_src_city'));
		$dst_province = trim(I('change_dst_province'));
		$dst_city = trim(I('change_dst_city'));
		$change_forever_check = trim(I('change_forever_check'));
		$msg = C('change_channel_success');
		$log_description = '';

		$is_purview = judgeAgentPurview($userinfo['agentsid'], $agent_id);
		if(!$is_purview)
		{
			$msg = C('no_purview');
			$this->ajaxReturn($msg,'json');
			return;
		}

		$Model = new Model();
		$channel = M("channel");
		$channel_area = M("channel_area");
		if($src_city != $dst_city)
		{
			$channel_count = $Model->query("select count(*) as count from qd_channel a, qd_channel_area b where a.channel_name='%s' 
				and a.channel_id=b.channel_id and b.province='%s' and b.city='%s'", $channel_name, $dst_province, $dst_city);
		}
		if($channel_count[0]['count'] > 0)
		{
			$msg = C('channel_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		$result = $channel->query("select ifnull(channel_id,0) as channel_id from qd_channel where channel_name='$channel_name'");
		$src_agent_id = getAgentIDFromChannelID($channel_id);
		$src_channel_log_info = $Model->table('qd_channel')->where("channel_id=" . $channel_id)->select();  //查询修改前的信息，用于日志对比
		$src_channel_log_info[0]['channel_agent_name'] = getAgentNameFromAgentID($src_channel_log_info[0]['agent_id']);
		$src_channel_log_info[0]['channel_type_name'] = getChannelTypeFromID($src_channel_log_info[0]['channel_id']);
		unset($src_channel_log_info[0]['agent_id']);
		if('1' == $src_channel_log_info[0]['forever_type'])
		{
			$src_channel_log_info[0]['forever_type'] = "是";
		}
		else
		{
			$src_channel_log_info[0]['forever_type'] = "否";
		}
		$src_channel_log_info[0]['begin_time'] = getDateFromTime($src_channel_log_info[0]['begin_time']);
		$src_channel_log_info[0]['end_time'] = getDateFromTime($src_channel_log_info[0]['end_time']);
		$src_channel_log_info[0]['province'] = $src_province;
		$src_channel_log_info[0]['city'] = $src_city;
		if(($result[0]['channel_id'] != $channel_id) && ($result[0]['channel_id'] != 0))
		{
			$msg = C('change_channel_name_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else
		{
			$data['channel_name'] = $channel_name;
			$data['agent_id'] = $agent_id;
			$data['contacts'] = $contacts;
			$data['contacts_tel'] = $contacts_tel;
			$data['channel_tel'] = $channel_tel;
			$data['channel_address'] = $channel_address;
			$data['contract_number'] = $contract_number;
			$data['forever_type'] = $change_forever_check;
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
			$is_set = $channel->where("channel_id=%d", $channel_id)->save($data);

			$area['channel_id'] = $channel_id;
			$area['province'] = $dst_province;
			$area['city'] = $dst_city;
			$is_area = $channel_area->where("channel_id=" . $channel_id . " and province='$src_province' and city='$src_city'")->save($area);

			$channel_type_link = M('channel_type_link');
			if(empty($dst_channel_second_type))
			{
				$change_type_link['channel_type_id'] = $dst_channel_first_type;
			}
			else
			{
				$change_type_link['channel_type_id'] = $dst_channel_second_type;
			}
			$is_type_link = $channel_type_link->where("channel_id='$channel_id' and channel_type_id='$src_channel_second_type'")->save($change_type_link);	

			if(($is_set) || ($is_area) || ($is_type_link)){
				$msg = C('change_channel_success');
			}else{
				$msg = C('change_channel_failed');
			}
		}
		if($msg == C('change_channel_success'))
		{
			if($src_agent_id != $agent_id)
			{
				changeID('channel', $agent_id, $channel_id);
				changeNum('channel', $src_agent_id, $channel_id, 'minus');
				changeNum('channel', $agent_id, $channel_id, 'add');
			}
			$dst_channel_log_info = $Model->table('qd_channel')->where("channel_id=" . $channel_id)->select();  //查询修改后的信息，用于日志对比
			$dst_channel_log_info[0]['channel_agent_name'] = getAgentNameFromAgentID($dst_channel_log_info[0]['agent_id']);
			$dst_channel_log_info[0]['channel_type_name'] = getChannelTypeFromID($dst_channel_log_info[0]['channel_id']);
			unset($dst_channel_log_info[0]['agent_id']);
			if('1' == $dst_channel_log_info[0]['forever_type'])
			{
				$dst_channel_log_info[0]['forever_type'] = "是";
			}
			else
			{
				$dst_channel_log_info[0]['forever_type'] = "否";
			}
			$dst_channel_log_info[0]['begin_time'] = getDateFromTime($dst_channel_log_info[0]['begin_time']);
			$dst_channel_log_info[0]['end_time'] = getDateFromTime($dst_channel_log_info[0]['end_time']);
			$dst_channel_log_info[0]['province'] = $dst_province;
			$dst_channel_log_info[0]['city'] = $dst_city;
			$log_description = getChangeLogDescription($src_channel_log_info[0], $dst_channel_log_info[0]);  //获取修改的详细记录
			addOptionLog('channel', $channel_id, 'change', $log_description);
		}
		$this->ajaxReturn($msg,'json');
	}

    //删除渠道商信息
	public function channelDelete(){
		$channel_id = trim(I('get.channel_id'));
		$province = trim(I('get.province'));
		$city = trim(I('get.city'));

	    $Model = new Model();
		$channel = M("channel");
		$channel_area = M("channel_area");
		$msg = C('delete_channel_success');
		$count = $Model->query("select count(*) as count from qd_channel_area where channel_id=" . $channel_id);
		if($count[0]['count'] <= 1)
		{
			$is_set = $channel->where("channel_id=" . $channel_id)->setField('isDelete', 1);
			if($is_set <= 0)
			{
				$msg = C('delete_channel_failed');
				$this->ajaxReturn($msg,'json');
				return;
			}
		}
		if($count[0]['count'] > 1)
		{
			$isDelete = $channel_area->where("channel_id=" . $channel_id . " and province='$province' and city='$city'")->delete();
			if($isDelete <= 0){
				$msg = C('delete_channel_failed');
			}
		}

		if($msg == C('delete_channel_success'))
		{
			$agent_id = getAgentIDFromChannelID($channel_id);
			changeNum('channel', $agent_id, $channel_id, 'minus');
			addOptionLog('channel', $channel_id, 'del', '');
		}

		$this->ajaxReturn($msg,'json');
	}

	//终止合同
	public function channelContractDelete(){
		$channel_id = trim(I('get.channel_id'));

	    $Model = new Model();
		$channel = M("channel");
		$msg = C('delete_channel_success');

		$is_set = $channel->where("channel_id=" . $channel_id)->setField('isDelete', 1);
		if($is_set <= 0)
		{
			$msg = C('delete_channel_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
	

		if($msg == C('delete_channel_success'))
		{
			//$agent_id = getAgentIDFromChannelID($channel_id);
			//changeNum('channel', $agent_id, $channel_id, 'minus');
			//addOptionLog('channel', $channel_id, 'del', '');
		}

		$this->ajaxReturn($msg,'json');
	}

	//恢复已经删除的渠道商信息
	public function channelRecover()
	{
		$channel_id = trim(I('get.channel_id'));
		$Model = new Model();
		$channel = M("channel");
		$is_set = $channel->where("channel_id=" . $channel_id)->setField('isDelete', 0);
		$agent_id = getAgentIDFromChannelID($channel_id);
		changeNum('channel', $agent_id, $channel_id, 'add');
		addOptionLog('channel', $channel_id, 'add', '');
		//$this->channelSelect();
	}

    //查询渠道商类型
	public function channelTypeSelect(){
		$channel_type = M('channel_type');
		$channel_type_list = $channel_type->query("select channel_type_id, channel_type_name from qd_channel_type where channel_type_father_id=0");
		for($i=0;$i< count($channel_type_list); $i++)
		{
			$channel_type_list[$i]['second_channel_type'] = $channel_type->query("select channel_type_id, channel_type_name from qd_channel_type
			    where channel_type_father_id=%d", $channel_type_list[$i]['channel_type_id']);
		}
		$this->ajaxReturn($channel_type_list, 'json');
	}

	//根据1级渠道商类型查询二级渠道商类型
	public function channelSecondTypeSelect(){
		$channel_type = M('channel_type');
		$channel_first_type_sel = trim(I('get.channel_first_type_sel'));
		if(!empty($channel_first_type_sel))
		{
			$channel_type_list = $channel_type->query("select channel_type_id, channel_type_name from qd_channel_type where							channel_type_father_id='$channel_first_type_sel'");
		}
		$this->ajaxReturn($channel_type_list, 'json');
	}

	//添加渠道商类型
	public function channelTypeAdd(){
		$msg = C('add_type_success');
	    $channel_type_father_id = trim(I('channel_type_father_id'));
		$channel_type_name = trim(I('channel_type_name'));

		$Model = new Model();
		$channel_type = M('channel_type');
		$tmp_channel_type_count = $Model->query("select count(*) as count from qd_channel_type where channel_type_name='$channel_type_name'");
		if($tmp_channel_type_count[0]['count'] > 0)
		{
			$msg = C('type_name_exist');
			$this->ajaxReturn($msg, 'json');
			return;
		}
		if(!empty($channel_type_father_id))
		{
			$data['channel_type_father_id'] = $channel_type_father_id;
		}
		$data['channel_type_name'] = $channel_type_name;
		$is_set = $channel_type->add($data);
		if($is_set <= 0)
		{
			$msg = C('add_type_failed');
			$this->ajaxReturn($msg, 'json');
			return;
		}

		//$tmp_channel_type_id = $Model->query('select last_insert_id() as id');
		//$channel_type_id = $tmp_channel_type_id[0]['id'];
		$this->ajaxReturn($msg, 'json');
	}

    //修改渠道商类型
	public function channelTypeSave(){
		$msg = C('change_type_success');
		$first_channel_type_id = trim(I('first_channel_type_id'));
		$second_channel_type_id = trim(I('second_channel_type_id'));
		$dst_channel_type_name = trim(I('dst_channel_type_name'));

		$channel_type = M('channel_type');
		if(!empty($first_channel_type_id))
		{
			if(!empty($second_channel_type_id))
			{
				$is_set = $channel_type->where("channel_type_id='$second_channel_type_id' and channel_type_father_id='$first_channel_type_id'")
					->setField('channel_type_name', $dst_channel_type_name);
			}
			else
			{
				$is_set = $channel_type->where("channel_type_id='$first_channel_type_id' and channel_type_father_id='0'")
					->setField('channel_type_name', $dst_channel_type_name);
			}
		}
		else
		{
			$msg = C('change_type_failed');
		}
		if($is_set <= 0)
		{
			$msg = C('type_name_exist');
			$this->ajaxReturn($msg, 'json');
			return;
		}
		$this->ajaxReturn($msg, 'json');
	}

    //删除渠道商类型
	public function channelTypeDelete(){
		$msg = C('delete_type_success');
		$channel_type_id = trim(I('channel_type_id'));

		$Model = new Model();
		$channel_type = M('channel_type');
		$channel_type_count = $Model->query("select count(*) as count from qd_channel_type a, qd_channel_type_link b where 
		  a.channel_type_id=b.channel_type_id and (a.channel_type_id='$channel_type_id' or 
		  a.channel_type_father_id='$channel_type_id')");
		if($channel_type_count[0]['count'] > 0)
		{
			$msg = C('delete_channel_type_exist');
			$this->ajaxReturn($msg, 'json');
			return;
		}
		$place_type_count = $Model->query("select count(*) as count from qd_channel_type a, qd_place b where 
		  a.channel_type_id=b.place_type_id and (a.channel_type_id='$channel_type_id' or 
		  a.channel_type_father_id='$channel_type_id')");
		if($place_type_count[0]['count'] > 0)
		{
			$msg = C('delete_place_type_exist');
			$this->ajaxReturn($msg, 'json');
			return;
		}
		$is_set = $channel_type->where("channel_type_id=" . $channel_type_id)->delete();
		if($is_set <= 0)
		{
			$msg = C('delete_type_failed');
			$this->ajaxReturn($msg, 'json');
			return;
		}
		$second_type_id  =  $channel_type->query("select channel_type_id from qd_channel_type where channel_type_father_id=" . $channel_type_id);
		foreach($second_type_id as $key=>$val)
		{
			$channel_type->where("channel_type_id=" . $val['channel_type_id'])->delete();
		}
		$this->ajaxReturn($msg, 'json');
	}
}
?>