<?php
import( "@.MyClass.Page" );//导入分页类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}

//代理商类
class AgentAction extends CommonAction {
	public function index(){
		$userinfo = getUserInfo();
		$this->is_channel_user = in_array("渠道部", $userinfo['group']); //等于1为渠道部用户
		$this->agentsid = $userinfo['agentsid']; //agentsid为空则为总公司
		$this->username = $userinfo['username']; //登录的用户名
		$this->is_have_user_purview = in_array($userinfo['grade'], array(1,2,3));
		//print_r($userinfo);exit;
		//$this->error('没有权限');
		//echo THINK_VERSION;
		$this->display('channel:agent_index');
	}

	//查询所有1级代理商
	public function fatherAgentSelect(){
	    $Model = new Model();
		$list = $Model->query("select agent_id, agent_name from qd_agent where agent_level='1' and isDelete='0'");
		$this->ajaxReturn($list, 'json');
	}

	//查询代理商信息
	public function agentSelect(){
		$userinfo = getUserInfo();
	    $Model = new Model();
		$agent_type = I('agent_type_sel');
		$agent_name = I('agent_name_txt');
		$agent_level = I('agent_level_sel');
		$province = I('select_province');
		$city = I('select_city');
		$is_select_show = 1;
		//$page_show_number = 30;       //每页显示的数量
		C('page_show_number')?$page_show_number=C('page_show_number'):$page_show_number=30;  //每页显示的数量
		$where = 'a.agent_id=b.agent_id';
		if(!empty($agent_type))
		{
			$where .= " and a.agent_type='$agent_type'";
		}
		if('area' == $agent_type)
		{
			if('1' == $agent_level)
			{
				if("省份" != $province && !empty($province))
				{
					$where .= " and b.province='$province'";
				}
			}
			else if('2' == $agent_level)
			{
				if("省份" != $province && !empty($province))
				{
					if("地级市" != $city && !empty($city))
					{
						$where .= " and b.province='$province' and b.city='$city'";
					}
					else
					{
						$where .= " and b.province='$province'";
					}
				}
			}
			else if('all' == $agent_level)
			{
				if("省份" != $province && !empty($province))
				{
					if("地级市" != $city && !empty($city))
					{
						$where .= " and b.province='$province' and b.city='$city'";
					}
					else
					{
						$where .= " and b.province='$province'";
					}
				}
			}
			
		}
		if('trade' == $agent_type)
		{
			$where .= " and a.agent_level='1'";

			if("省份" != $province && !empty($province))
			{
				$where .= " and b.province='$province'";
			}
		}
		if(!empty($agent_name))
		{
			$where .= " and a.agent_name='$agent_name'";
		}
		if(!empty($agent_level) && ('all' != $agent_level))
		{
			$where .= " and a.agent_level='$agent_level'";
		}

		$count = $Model->table('qd_agent a, qd_agent_area b')->where($where)->count();
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		$list = $Model->table('qd_agent a, qd_agent_area b')->where($where)->order('a.agent_id desc')->limit($Page->firstRow.','. $Page->listRows)->select();
		if($list=="")
		{
			$listCount = 0;
			$is_select_show = 2;
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
			$list[$i]['agentRadioID'] = 'agentRadio' . $i; //用于详情点击的ID
			$list[$i]['agentDetailID'] = 'agentDetail' . $i; //用于选择的ID
			$list[$i]['agentRecoverID'] = 'agentRecover' . $i; //用于恢复的ID
			$father_agent_name = $Model->query("select agent_name from qd_agent where agent_id=" . $list[$i]['father_agentid']);
			$list[$i]['father_agent_name'] = $father_agent_name[0]['agent_name'];
			$list[$i]['area'] = $list[$i]['province'] . '  '. $list[$i]['city'];
			$list[$i]['is_agent_purview'] = judgeAgentPurview($userinfo['agentsid'], $list[$i]['agent_id']);
		}
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('is_select_show',$is_select_show); //是否显示结果集
		$this->assign('agent_select_number',$count); //查询结果集的数量
		$this->index();
	}

     //根据代理商ID查询代理商详细信息
     public function agentDetailSelect(){
	    $Model = new Model();
		$agent_id = I('get.agent_id');
		//p($_GET['agent_id']);
		$where = "a.agent_id=" . $agent_id;
		$dataAgent = $Model->table('qd_agent a')->where($where)->select();// 查询满足要求的总记录数
		$dataAgent[0]['begin_time'] = getDateFromTime($dataAgent[0]['begin_time']);
		$dataAgent[0]['end_time'] = getDateFromTime($dataAgent[0]['end_time']);
		//p($dataAgent[0]['date']);

		$data = $dataAgent[0];
		$this->ajaxReturn($data,'json');
	}

    //代理商名字模糊查询
	public function agentnameBlurrySelect(){
	    //$Model = new Model();
		$agent_name = trim(I('agent_name'));
		$agent = M('agent');
		$map['agent_name'] =array('like', '%' . $agent_name . '%');
		$agentInfo = $agent->where($map)->distinct(true)->field('agent_name')->select();
		for($i=0; $i< count($agentInfo); $i++)
		{
			$agent_name_arr[$i]['title'] = $agentInfo[$i]['agent_name'];
		}
		$this->ajaxReturn($agent_name_arr,'json');
	}

	//代理商合同编号模糊查询
	public function agentContractnumberBlurrySelect(){
	    //$Model = new Model();
		$contract_number = trim(I('contract_number'));
		$agent = M('agent');
		$map['contract_number'] =array('like', '%' . $contract_number . '%');
		$agentInfo = $agent->where($map)->distinct(true)->field('contract_number')->select();
		for($i=0; $i< count($agentInfo); $i++)
		{
			$agent_contract_number_arr[$i]['title'] = $agentInfo[$i]['contract_number'];
		}
		$this->ajaxReturn($agent_contract_number_arr,'json');
	}

    //添加代理商
	public function agentAdd(){
		$userinfo = getUserInfo();
		$agent_name = trim(I('add_agent_name_txt'));
		$companyAddr = trim(I('add_companyAddr_txt'));
		$agent_type = trim(I('add_agent_type_sel'));
		$contract_number = trim(I('add_contract_number_txt'));
		$legal = trim(I('add_legal_txt'));
		$tel = trim(I('add_tel_txt'));
		$legal_tel = trim(I('add_legal_tel_txt'));
		$agent_level = trim(I('add_agent_level_sel'));
		$father_agentid = trim(I('add_father_agentid_sel'));
		$begin_time = strtotime(trim(I('add_begin_time_sel')));
		$end_time = strtotime(trim(I('add_end_time_sel')));
		$province = trim(I('add_select_province'));
		$city = trim(I('add_select_city'));
		$add_forever_check = trim(I('add_forever_check'));
		$msg =	C('add_agents_success');

		$is_purview = judgeAgentPurview($userinfo['agentsid'], $father_agentid);
		if(!$is_purview)
		{
			$msg = C('no_purview');
			$this->ajaxReturn($msg,'json');
			return;
		}

		$Model = new Model();
		if('1' == $agent_level)
		{
			$agent_count = $Model->query("select count(*) as count from qd_agent a, qd_agent_area b where a.agent_name='%s' and a.agent_id=b.agent_id 
				and	b.province='%s'", $agent_name, $province);
		}
		else
		{
			$agent_count = $Model->query("select count(*) as count from qd_agent a, qd_agent_area b where a.agent_name='%s' and a.agent_id=b.agent_id 
				and	b.province='%s' and b.city='%s'", $agent_name, $province, $city);
		}
		$agent_delete_count = $Model->query("select count(*) as count from qd_agent a where a.agent_name='%s' and a.isDelete='1'", $agent_name);
		if($agent_delete_count[0]['count'] > 0)
		{
			$msg = C('add_delete_agent');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else if($agent_count[0]['count'] > 0)
		{
			$msg = C('agent_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else
		{
			$agent = M("agent");
			$agent_area = M("agent_area");
			$data['agent_name'] = $agent_name;
			$data['agent_type'] = $agent_type;
			$data['companyAddr'] = $companyAddr;
			$data['contract_number'] = $contract_number;
			$data['legal'] = $legal;
			$data['tel'] = $tel;
			$data['legal_tel'] = $legal_tel;
			$data['agent_level'] = $agent_level;
			if($agent_level == '2')
			{
				$data['father_agentid'] = $father_agentid;
			}
			$data['sub_agent_num'] = 0;
			$data['place_num'] = 0;
			$data['channel_num'] = 0;
			$data['device_num'] = 0;
			$data['forever_type'] = $add_forever_check;
			if(0 != $begin_time)
			{
				$data['begin_time'] = $begin_time;
			}
			if(0 != $end_time)
			{
				$data['end_time'] = $end_time;
			}
			$data['isDelete'] = 0;
			$is_set = $agent->add($data);
			if($is_set)
			{
				$tmp_agent_id = $agent->query('select last_insert_id() as id');
				$agent_id = $tmp_agent_id[0]['id'];
				$area['agent_id'] = $agent_id;
				$area['province'] = $province;
				if($agent_level == '2')
				{
					$area['city'] = $city;
				}
				else
				{
					$area['city'] = '';
				}
				$is_set = $agent_area->add($area);
			}
			else
			{
				$tmp_agent_id = $agent->query("select agent_id from qd_agent where agent_name='$agent_name'");
				$agent_id = $tmp_agent_id[0]['agent_id'];
				$area['agent_id'] = $agent_id;
				$area['province'] = $province;
				if($agent_level == '2')
				{
					$area['city'] = $city;
				}
				else
				{
					$area['city'] = '';
				}
				$is_set = $agent_area->add($area);
				if(!($is_set))
				{
					$msg = C("add_agent_failed");
				}
			}
		}
		if(C('add_agents_success') == $msg)
		{
			if($agent_level == '2')
			{
				changeNum('agent', $father_agentid, $agent_id, 'add');
			}
			addOptionLog('agent', $agent_id, 'add', '');
		}
		$this->ajaxReturn($msg,'json');
	}

    //修改代理商信息
	public function agentSave(){
		$userinfo = getUserInfo();
		$agent_name = trim(I('change_agent_name_txt'));
		$agent_id = trim(I('change_agent_id_txt'));
		$companyAddr = trim(I('change_companyAddr_txt'));
		$agent_type = trim(I('change_agent_type_sel'));
		$contract_number = trim(I('change_contract_number_txt'));
		$legal = trim(I('change_legal_txt'));
		$tel = trim(I('change_tel_txt'));
		$legal_tel = trim(I('change_legal_tel_txt'));
		$agent_level = trim(I('change_agent_level_sel'));
		$father_agentid = trim(I('change_father_agentid_sel'));
		$begin_time = strtotime(trim(I('change_begin_time_sel')));
		$end_time = strtotime(trim(I('change_end_time_sel')));
		$src_province = trim(I('change_src_province'));
		$src_city = trim(I('change_src_city'));
		$dst_province = trim(I('change_dst_province'));
		$dst_city = trim(I('change_dst_city'));
		$change_forever_check = trim(I('change_forever_check'));
		$msg = C("change_agent_success");
		$log_description = '';

		$is_purview = judgeAgentPurview($userinfo['agentsid'], $agent_id);
		if(!$is_purview)
		{
			$msg = C('no_purview');
			$this->ajaxReturn($msg,'json');
			return;
		}

		$Model = new Model();
		$agent = M("agent");
		if($src_city != $dst_city)
		{
			$agent_count = $Model->query("select count(*) as count from qd_agent a, qd_agent_area b where a.agent_name='%s' and a.agent_id=b.agent_id 
				and	b.province='%s' and b.city='%s'", $agent_name, $dst_province, $dst_city);
		}
		if($agent_count[0]['count'] > 0)
		{
			$msg = C('agent_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		$result = $agent->query("select ifnull(agent_id,0) as agent_id from qd_agent where agent_name='$agent_name'");
		$src_agent_log_info = $agent->where("agent_id=" . $agent_id)->select();  //查询修改前的信息，用于日志对比
		$src_father_agent_id = $src_agent_log_info[0]['father_agentid'];
		$src_agent_log_info[0]['father_agentname'] = getAgentNameFromAgentID($src_agent_log_info[0]['father_agentid']);
		unset($src_agent_log_info[0]['father_agentid']);
		if('1' == $src_agent_log_info[0]['forever_type'])
		{
			$src_agent_log_info[0]['forever_type'] = "是";
		}
		else
		{
			$src_agent_log_info[0]['forever_type'] = "否";
		}
		$src_agent_log_info[0]['begin_time'] = getDateFromTime($src_agent_log_info[0]['begin_time']);
		$src_agent_log_info[0]['end_time'] = getDateFromTime($src_agent_log_info[0]['end_time']);
		$src_agent_log_info[0]['province'] = $src_province;
		$src_agent_log_info[0]['city'] = $src_city;
		if(($result[0]['agent_id'] != $agent_id) && ($result[0]['agent_id'] != 0))
		{
			$msg = C("change_agent_name_failed");
		}
		else
		{
			$data['agent_name'] = $agent_name;
			$data['companyAddr'] = $companyAddr;
			$data['agent_type'] = $agent_type;
			$data['contract_number'] = $contract_number;
			$data['legal'] = $legal;
			$data['tel'] = $tel;
			$data['legal_tel'] = $legal_tel;
			$data['agent_level'] = $agent_level;
			if('' == $father_agentid)
			{
				$father_agentid = '0';
			}
			if($agent_id == $father_agentid)
			{
				$msg = C('change_agent_belongself');
				$this->ajaxReturn($msg,'json');
				return;
			}
			$data['father_agentid'] = $father_agentid;
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
			$is_set = $agent->where("agent_id=%d", $agent_id)->save($data);
		
			$agent_area = M("agent_area");
			$area['province'] = $dst_province;
			if($agent_level == '2')
			{
				$area['city'] = $dst_city;
			}
			else
			{
				$area['city']= '';
			}
			if('地级市' != $src_city && !empty($src_city))
			{
				$is_area = $agent_area->where("agent_id='$agent_id' and province='$src_province' and city='$src_city'")->save($area);
			}
			else
			{
				$is_area = $agent_area->where("agent_id='$agent_id' and province='$src_province'")->save($area);
			}
			if((!($is_set)) && (!($is_area))){
				$msg = C("change_agent_failed");
			}
		}
		if(C('change_agent_success') == $msg)
		{
			if($src_father_agent_id != $father_agentid)
			{
				changeNum('agent', $src_father_agent_id, $agent_id, 'minus');
				changeNum('agent', $father_agentid, $agent_id, 'add');
			}
			$dst_agent_log_info = $agent->where("agent_id=" . $agent_id)->select();  //查询修改后的信息，用于日志对比
			$dst_agent_log_info[0]['father_agentname'] = getAgentNameFromAgentID($dst_agent_log_info[0]['father_agentid']);
			unset($dst_agent_log_info[0]['father_agentid']);
			if('1' == $dst_agent_log_info[0]['forever_type'])
			{
				$dst_agent_log_info[0]['forever_type'] = "是";
			}
			else
			{
				$dst_agent_log_info[0]['forever_type'] = "否";
			}
			$dst_agent_log_info[0]['begin_time'] = getDateFromTime($dst_agent_log_info[0]['begin_time']);
			$dst_agent_log_info[0]['end_time'] = getDateFromTime($dst_agent_log_info[0]['end_time']);
			$dst_agent_log_info[0]['province'] = $dst_province;
			$dst_agent_log_info[0]['city'] = $dst_city;
			$log_description = getChangeLogDescription($src_agent_log_info[0], $dst_agent_log_info[0]);  //获取修改的详细记录

			addOptionLog('agent', $agent_id, 'change', $log_description);
		}
		$this->ajaxReturn($msg,'json');
	}

    //删除代理商
	public function agentDelete(){
		$agent_id = trim(I('get.agent_id'));
		$province = trim(I('get.province'));
		$city = trim(I('get.city'));

		$userinfo = getUserInfo();
		$is_purview = judgeAgentPurview($userinfo['agentsid'], $agent_id);
		if(!$is_purview)
		{
			$msg = C('no_purview');
			$this->ajaxReturn($msg,'json');
			return;
		}

	    $Model = new Model();
		$agent = M("agent");
		$agent_area = M("agent_area");
		$msg = C("delete_agent_success");

		$count = $Model->query("select count(*) as count from qd_agent_area where agent_id=" . $agent_id);
		if($count[0]['count'] <= 1)
		{
			$is_set = $agent->where("agent_id=" . $agent_id)->setField('isDelete', 1);
			if($is_set <= 0)
			{
				$msg = C("delete_agent_failed");
			}
		}
		if($count[0]['count'] > 1)
		{
			if("地级市" != $city && !empty($city))
			{
				$isDelete = $agent_area->where("agent_id=" . $agent_id . " and province='$province' and city='$city'")->delete();
			}
			else
			{
				$isDelete = $agent_area->where("agent_id=" . $agent_id . " and province='$province'")->delete();
			}
			if($isDelete <= 0){
				$msg = C("delete_agent_failed");
			}
		}
		//$this->msg = $msg;
		//$this->agentSelect();
		if($msg == C("delete_agent_success"))
		{
			$agent_info = $Model->query("select father_agentid, agent_level from qd_agent where agent_id=" . $agent_id);
			if('2' == $agent_info[0]['agent_level'])
			{
				changeNum('agent', $agent_info[0]['father_agentid'], $agent_id, 'minus');
			}
			addOptionLog('agent', $agent_id, 'del', '');
		}
		$this->ajaxReturn($msg,'json');
	}

	//恢复已经删除的代理商信息
	public function agentRecover()
	{
		$Model = new Model();
		$agent_id = trim(I('get.agent_id'));
		$agent = M("agent");
		$userinfo = getUserInfo();
		$is_purview = judgeAgentPurview($userinfo['agentsid'], $agent_id);
		if(!$is_purview)
		{
			$this->error('没有权限');
			return;
		}
		$is_set = $agent->where("agent_id=" . $agent_id)->setField('isDelete', 0);
		$agent_info = $Model->query("select father_agentid, agent_level from qd_agent where agent_id=" . $agent_id);
		if('2' == $agent_info[0]['agent_level'])
		{
			changeNum('agent', $agent_info[0]['father_agentid'], $agent_id, 'add');
		}
		addOptionLog('agent', $agent_id, 'add', '');
		//$this->agentSelect();
	}
}
?>