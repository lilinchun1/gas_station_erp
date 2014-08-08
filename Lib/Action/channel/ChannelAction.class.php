<?php
import( "@.MyClass.Page" );//导入分页类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}
//渠道商类
class ChannelAction extends Action {
	public function index(){
		$userinfo = getUserInfo();
		$this->username = $userinfo['realname']; //登录的用户名
		/*
		$this->is_channel_user = in_array("渠道部", $userinfo['group']); //等于1为渠道部用户
		$this->agentsid = $userinfo['agentsid']; //agentsid为空则为总公司
		$this->is_have_user_purview = in_array($userinfo['grade'], array(1,2,3));
		*/
		$first_channel_type = getAllChannelType();
		$all_agent = getAllAgent();
		$this->assign('first_channel_type', $first_channel_type);
		$this->assign('all_agent', $all_agent);
		$this->assign('nowUrl', "channel/Channel/index");
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->display(':channel_index');
	}

	//获取所有代理商
	public function getAllAgent(){
		$all_agent_info = getAllAgent();
		$this->ajaxReturn($all_agent_info, 'json');
	}

	//获取所有渠道类型
	public function getAllChannelType(){
		$all_type_info = getAllChannelType();
		$this->ajaxReturn($all_type_info, 'json');
	}

	//查询渠道商信息
	public function channelSelect(){
		$userinfo = getUserInfo();
	    $Model = new Model();
		$agent_name = trim(I('agent_name_txt'));
		//渠道类型
		$channel_first_type = trim(I('channel_first_type_sel'));
		$channel_second_type = trim(I('channel_second_type_sel'));
		//渠道城市
		$province = trim(I('select_province'));
		$city = trim(I('select_city'));
		
		$channel_name = trim(I('channel_name_txt'));		
		$contract_begin_time_1 = strtotime(trim(I('contract_begin_time_1')));
		$contract_begin_time_2 = strtotime(trim(I('contract_begin_time_2')));
		$contract_end_time_1 = strtotime(trim(I('contract_end_time_1')));
		$contract_end_time_2 = strtotime(trim(I('contract_end_time_2')));
		$del_flag_txt = trim(I('select_del_flag_txt'));
		$is_channel_select_show = 1;
		//$page_show_number = 30;       //每页显示的数量
		$page_show_number = C('page_show_number')?C('page_show_number'):30;  //每页显示的数量
		$where = "a.channel_id=b.channel_id and a.isDelete='$del_flag_txt'";
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
				$where .= " and c.channel_type_id='$channel_second_type'";
			}
			else
			{
				$where .= " and (c.channel_type_id='$channel_first_type' or c.channel_type_father_id='$channel_first_type')";
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
		
		
		if((!empty($userinfo['orgid'])) && (1 != $userinfo['orgid']))
		{
			$sub_agent_id = getSubAgentStringFromFatherAgent($userinfo['orgid']);
			$where .= " and (a.agent_id='{$userinfo['orgid']}' or a.agent_id in $sub_agent_id)"; //权限限制
		}

		$count = $Model->table('qd_channel a, qd_channel_type_link b')->join('qd_channel_type c on b.channel_type_id=c.channel_type_id')->where($where)->count();
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		//$Page->url = 'Agent/agentSelect/p/';
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		$list = $Model->table('qd_channel a, qd_channel_type_link b')->join('qd_channel_type c on b.channel_type_id=c.channel_type_id')
		->where($where)->order('a.channel_id desc')->limit($Page->firstRow.','. $Page->listRows)
		->field('a.channel_id, a.channel_name, a.agent_id, a.contacts, a.contacts_tel, a.channel_tel, a.channel_address, a.contract_number,
		a.place_num, a.device_num, a.begin_time, a.end_time, a.forever_type, a.isDelete, a.province, a.city, b.channel_type_id,
		c.channel_type_father_id, c.channel_type_name')->select();
		//echo $Model->getLastSql();exit;
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

	//查询渠道商日志信息
	public function channelLogSelect(){
		$Model = new Model();
		$channel_id = trim(I('channel_id'));;
		$channel_log = $Model->query("select a.logs_id, a.userid, a.timestamp, a.option_type from qd_logs_option a where a.option_id='$channel_id' and 
			a.option_name='channel'");
		$data = null;
		foreach($channel_log as $key=>$val){
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

     //根据渠道ID查询渠道商详细信息
     public function channelDetailSelect(){
	    $Model = new Model();
		$channel_id = I('get.channel_id');
		$where = " where 1 ";
		if($channel_id){
			$where .= " and channel_id= $channel_id";
		}
		//$dataChannel = $Model->table('qd_channel a')->where($where)->select();// 查询满足要求的总记录数
		$sql = "
				SELECT a.channel_id,channel_name,agent_id,province,city,contacts,contacts_tel,channel_tel,channel_address,
				contract_number,place_num,device_num,begin_time,end_time,forever_type,isDelete
				FROM qd_channel a
				$where
				";
		$dataChannel = $Model->query($sql);
		$dataChannel[0]['begin_time'] = getDateFromTime($dataChannel[0]['begin_time']);
		$dataChannel[0]['end_time'] = getDateFromTime($dataChannel[0]['end_time']);
		//$tmp_channel_area  = $Model->query("select province,city from qd_channel_area where channel_id='$channel_id'");
		//$dataChannel[0]['province'] = $tmp_channel_area[0]['province'];
		//$dataChannel[0]['city'] = $tmp_channel_area[0]['city'];
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
		$count = $Model->query("select count(*) as count from qd_channel a where a.channel_name='$channel_name'
		    and	a.province='$province' and a.city='$city' and  a.isDelete = '0'");
		/*$channel_delete_count = $Model->query("select count(*) as count from qd_channel where channel_name='$channel_name' and isDelete='1'");
		if($channel_delete_count[0]['count'] > 0)
		 {
			$msg = C('add_delete_channel');
			$this->ajaxReturn($msg,'json');
			return;
		} 
		else*/
		
			 if($count[0]['count'] > 0)
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
			$data['province'] = $province;
			$data['city'] = $city;
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
				/*
				$area['channel_id'] = $channel_id;
				$area['province'] = $province;
				$area['city'] = $city;
				$is_set = $channel_area->add($area);
				*/

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
				$msg = C('add_channel_failed');
				$this->ajaxReturn($msg,'json');
				return;
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
		$result = $channel->query("select ifnull(channel_id,0) as channel_id from qd_channel where channel_name='$channel_name' and isDelete='0'");
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
		//$src_channel_log_info[0]['province'] = $src_province;
		//$src_channel_log_info[0]['city'] = $src_city;
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
			$data['province'] = $dst_province;
			$data['city'] = $dst_city;
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

			//$area['channel_id'] = $channel_id;
			//$area['province'] = $dst_province;
			//$area['city'] = $dst_city;
			//$is_area = $channel_area->where("channel_id=" . $channel_id . " and province='$src_province' and city='$src_city'")->save($area);

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

			if(($is_set) || ($is_type_link)){
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
			$dst_channel_log_info[0]['begin_time'] = getDateFromTime($dst_channel_log_info[0]['begin_time']);
			$dst_channel_log_info[0]['end_time'] = getDateFromTime($dst_channel_log_info[0]['end_time']);
			//$dst_channel_log_info[0]['province'] = $dst_province;
			//$dst_channel_log_info[0]['city'] = $dst_city;
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
		$count = $Model->query("select count(*) as count from qd_channel where channel_id=" . $channel_id);
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
		//if($count[0]['count'] > 1)
		//{
			//$isDelete = $channel_area->where("channel_id=" . $channel_id . " and province='$province' and city='$city'")->delete();
			//if($isDelete <= 0){
			//	$msg = C('delete_channel_failed');
			//}
		//}

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
		$channel = M("channel","qd_");
		$place = M("place","qd_");
		$device = M("device","qd_");
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
			$place_info = $Model->query("select place_id from qd_place where channel_id=" . $channel_id);
			foreach($place_info as $key=>$val){
				$is_set = $place->where("place_id=" . $val['place_id'])->setField('isDelete', 1);
				addOptionLog('place', $val['place_id'], 'del', '');
				$device_info = $Model->query("select device_id from qd_device where place_id=" . $val['place_id']);
				foreach($device_info as $d_key=>$d_val){
					$is_set = $device->where("device_id=" . $d_val['device_id'])->setField('isDelete', 1);
					addOptionLog('device', $d_val['device_id'], 'del', '');
				}
			}
			$agent_id = getAgentIDFromChannelID($channel_id);
			changeNum('channel', $agent_id, $channel_id, 'minus');
			addOptionLog('channel', $channel_id, 'del', '');
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