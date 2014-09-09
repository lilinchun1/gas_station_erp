<?php
import( "@.MyClass.Page" );//导入分页类
import( "@.MyClass.Common" );//导入公共类
import( "@.MyClass.ChannelCommon");//导入公共类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}

//渠道商类
class ChannelAction extends Action {
	public function index(){
		$userinfo = getUserInfo();
		$this->username = $userinfo['realname']; //登录的用户名
		$model = new Model();
		$first_channel_type = getAllChannelType();
		$common = new Common();
		$agentIdStr = $common->getAgentIdAndChildId($userinfo['orgid']);
		$all_agent  = $model->query("select agent_id, agent_name from qd_agent where isDelete='0' and agent_id in ($agentIdStr)");
		$this->assign('first_channel_type', $first_channel_type);
		$this->assign('all_agent', $all_agent);
		$this->assign('nowUrl', "'/gas_station_erp/index.php/channel/Channel/index'");
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->display(':channel_index');
	}
	//自动补全
	public function getAllLike(){
		$likeType=$_GET['likeType'];
		$typeKey=$_GET['typeKey'];
		$ChannCom = new ChannelCommon();
		$lkType=$ChannCom->getAlltype($likeType,$typeKey);
		echo json_encode($lkType);
		//echo json_encode($typeKey);
	}	
	//获取所有省
	public function  getProvince(){
		$userinfo = getUserInfo();
		$ChannCom = new ChannelCommon();
		$province=$ChannCom->getAllProvince($userinfo['orgid']);
		echo json_encode($province);
	}
	//获取所有市
	public function  getCity(){
		$province_id = $_GET['province_id'];
		$userinfo    = getUserInfo();
		$channCom    = new ChannelCommon();
		$city=$channCom->getAllCity($province_id,$userinfo['orgid']);
		echo json_encode($city);
		
	}
	//获取所有渠道类型
	public function getAllChannelType(){
		$all_type_info = getAllChannelType();
		$this->ajaxReturn($all_type_info, 'json'); 
	}

	//查询渠道商信息
	public function channelSelect(){
		$userinfo = getUserInfo();
	    $model = new Model();
		$agent_name            = trim(I('agent_name_txt'));
		//渠道类型
		$channel_first_type    = trim(I('channel_first_type_sel'));
		$channel_second_type   = trim(I('channel_second_type_sel'));
		//渠道城市
		$province              = trim(I('select_province'));
		$city                  = trim(I('select_city'));
		//渠道名称
		$channel_name          = trim(I('channel_name_txt'));
		//合同开始日期
		$contract_begin_time_1 = strtotime(trim(I('contract_begin_time_1')));
		$contract_begin_time_2 = strtotime(trim(I('contract_begin_time_2')));
		//合同结束日期
		$contract_end_time_1   = strtotime(trim(I('contract_end_time_1')));
		$contract_end_time_2   = strtotime(trim(I('contract_end_time_2')));
		//显示的是使用的还是删除的
		$del_flag_txt          = trim(I('select_del_flag_txt'))?trim(I('select_del_flag_txt')):0;
		
		//每页显示的数量
		$page_show_number = C('page_show_number')?C('page_show_number'):30;  //每页显示的数量
		$where = " WHERE a.isDelete='$del_flag_txt' ";
		if($agent_name)
		{
			$agent_id = getAgentIDFromAgentName($agent_name);
			$where .= " and a.agent_id=" . $agent_id;
		}
		if($channel_name)
		{
			$where .= " and a.channel_name='$channel_name'";
		}
		if($contract_begin_time_1)
		{
			$where .= " and a.begin_time>='$contract_begin_time_1'";
		}
		if($contract_begin_time_2)
		{
			$where .= " and a.begin_time<='$contract_begin_time_2'";
		}
		if($contract_end_time_1)
		{
			$where .= " and a.end_time>='$contract_end_time_1'";
		}
		if($contract_end_time_2)
		{
			$where .= " and a.end_time<='$contract_end_time_2'";
		}
		
		if($channel_first_type){
			if($channel_second_type){
				$where .= " and c.channel_type_id='$channel_second_type'";
			}else{
				$where .= " and (c.channel_type_id='$channel_first_type' or c.channel_type_father_id='$channel_first_type')";
			}
		}
		if($province){
			if($city){
				$where .= " and a.province_id='$province' and a.city_id='$city'";
			}else{
				$where .= " and a.province_id='$province'";
			}
		}
		//echo $where;exit;
		
		if(trim($userinfo['orgid']))
		{
			$common = new Common();
			$sub_agent_id = $common->getAgentIdAndChildId(trim($userinfo['orgid']));
			$where .= " and a.agent_id in ($sub_agent_id)"; //权限限制
		}
		
		$sql = "
				SELECT
				a.channel_id, a.channel_name, a.agent_id, a.contacts, a.contacts_tel, a.channel_tel,
				CONCAT(f.area_name,g.area_name,a.channel_address) channel_address, a.contract_number,
				h.place_num, i.device_num,
				IF(a.begin_time IS NOT NULL,FROM_UNIXTIME( a.begin_time, '%Y-%m-%d' ),'') begin_time,
				IF(a.end_time IS NOT NULL,FROM_UNIXTIME( a.end_time, '%Y-%m-%d' ),'') end_time,
				a.forever_type, a.isDelete, f.area_name province, g.area_name city, b.channel_type_id,
				c.channel_type_father_id,
				IF(d.channel_type_name IS NOT NULL,CONCAT(d.channel_type_name,' ',c.channel_type_name),c.channel_type_name) channel_type_name,
				e.agent_name
				FROM qd_channel a
				LEFT JOIN qd_channel_type_link b ON a.channel_id = b.channel_id
				LEFT JOIN qd_channel_type c ON b.channel_type_id = c.channel_type_id
				LEFT JOIN qd_channel_type d ON c.channel_type_father_id = d.channel_type_id
				LEFT JOIN qd_agent e ON a.agent_id = e.agent_id
				LEFT JOIN bi_area f ON a.province_id = f.area_id
				LEFT JOIN bi_area g ON a.city_id = g.area_id
				LEFT JOIN (SELECT COUNT(place_id) place_num,channel_id FROM qd_place WHERE STATUS = 'use' AND isDelete = 0 GROUP BY channel_id) h ON a.channel_id = h.channel_id
				LEFT JOIN (SELECT COUNT(device_id) device_num,channel_id FROM qd_device WHERE isDelete = 0 GROUP BY channel_id) i ON a.channel_id = i.channel_id
				$where
				ORDER BY a.channel_id desc
		";
		$que = $model->query($sql);
		$count = count($que);

		$showQue  = array();
		$pageNum  = $_GET['p']?$_GET['p']:1;
		$beginNum = ($pageNum - 1)*$page_show_number;
		$endNum   = $beginNum + $page_show_number -1;
		for($i = $beginNum;$i<=$endNum;$i++){
			if($que[$i]){
				$showQue[$i] = $que[$i];
			}
		}
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		$show       = $Page->show();// 分页显示输出
		
		$this->assign('isDeleteResult',$del_flag_txt);
		$this->assign('list',$showQue);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('channel_select_number',$count); //查询结果集的数量
		$this->index();
	}

    //添加渠道商信息
	public function channelAdd(){
		$userinfo = getUserInfo();
		$channel_name        = trim(I('add_channel_name_txt'));
		$agent_id            = trim(I('add_agent_id_sel'));
		$contacts            = trim(I('add_contacts_txt'));
		$contacts_tel        = trim(I('add_contacts_tel_txt'));
		$channel_tel         = trim(I('add_channel_tel_txt'));
		$channel_address     = trim(I('add_channel_address_txt'));
		$contract_number     = trim(I('add_contract_number_txt'));
		$begin_time          = strtotime(trim(I('add_begin_time_sel')));
		$end_time            = strtotime(I('add_end_time_sel'));
		$channel_first_type  = trim(I('add_channel_first_type_sel'));
		$channel_second_type = trim(I('add_channel_second_type_sel'));
		$province            = trim(I('add_select_province'))?trim(I('add_select_province')):null;
		$city                = trim(I('add_select_city'))?trim(I('add_select_city')):null;
		$add_forever_check   = trim(I('add_forever_check'));
		$msg = C('add_channel_success');

		$model             = new Model();
		$channel           = new Model("QdChannel");
		$channel_type_link = new Model("QdChannelTypeLink");
		//验证是否已有渠道名
		$count_sql = "
				select count(*) as count from qd_channel a where a.channel_name='$channel_name'
				and	a.agent_id = $agent_id and a.isDelete = '0'
		";
		$count = $model->query($count_sql);
		 if($count[0]['count'] > 0)
		{
			$msg = C('channel_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		
		$data['channel_name'] = $channel_name;
		$data['agent_id'] = $agent_id;
		$data['contacts'] = $contacts;
		$data['contacts_tel'] = $contacts_tel;
		$data['channel_tel'] = $channel_tel;
		$data['channel_address'] = $channel_address;
		$data['contract_number'] = $contract_number;
		$data['province_id'] = $province;
		$data['city_id'] = $city;
		$data['forever_type'] = $add_forever_check;
		$begin_time?$$data['begin_time'] = begin_time:1;
		$end_time?$data['end_time'] = $end_time : 1;
		$data['place_num'] = 0;
		$data['device_num'] = 0;
		$data['isDelete'] = 0;
		$channel_id = $channel->add($data);
		if($channel_id)
		{
			$type_link['channel_id'] = $channel_id;
			//保存渠道类型
			$type_link['channel_type_id'] = $channel_second_type?$channel_second_type:$channel_first_type;
			$channel_type_link->add($type_link);
			//修改相关日志
			addOptionLog('channel', $channel_id, 'add', '');
			
			$this->ajaxReturn($msg,'json');
		}
		else
		{
			$msg = C('add_channel_failed');
			$this->ajaxReturn($msg,'json');
		}
	}

    //修改渠道商信息
	public function channelSave(){
		$userinfo = getUserInfo();
		$channel_name            = trim(I('change_channel_name_txt'));
		$channel_id              = trim(I('change_channel_id_txt'));
		$agent_id                = trim(I('change_agent_id_sel'));
		$contacts                = trim(I('change_contacts_txt'));
		$contacts_tel            = trim(I('change_contacts_tel_txt'));
		$channel_tel             = trim(I('change_channel_tel_txt'));
		$channel_address         = trim(I('change_channel_address_txt'));
		$contract_number         = trim(I('change_contract_number_txt'));
		$begin_time              = strtotime(trim(I('change_begin_time_sel')));
		$end_time                = strtotime(trim(I('change_end_time_sel')));
		$src_channel_first_type  = trim(I('src_channel_first_type'));
		$src_channel_second_type = trim(I('src_channel_second_type'));
		$dst_channel_first_type  = trim(I('dst_channel_first_type_sel'));
		$dst_channel_second_type = trim(I('dst_channel_second_type_sel'));
		$dst_province            = trim(I('change_dst_province'))?trim(I('change_dst_province')):null;
		$dst_city                = trim(I('change_dst_city'))?trim(I('change_dst_city')):null;
		$change_forever_check    = trim(I('change_forever_check'));
		$log_description = '';
		$model        = new Model();
		$channel      = new Model("QdChannel");

		//查询是否已有同名
		$result_sql = "
			select channel_id
			from qd_channel
			where channel_name='$channel_name' and agent_id = $agent_id and isDelete='0'
		";
		$result = $channel->query($result_sql);
		if( $result[0]['channel_id'] && ($result[0]['channel_id'] != $channel_id))
		{
			$msg = C('change_channel_name_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
		
		//获取修改前代理商id
		$src_agent_id = getAgentIDFromChannelID($channel_id);
		//日志部分 查询修改前的信息，用于日志对比
		$src_channel_log_info = $this->getChannelInfoByChannelId($channel_id);
		unset($src_channel_log_info['agent_id']);

		//执行修改
		$data = array();
		$data['channel_name'] = $channel_name;
		$data['agent_id'] = $agent_id;
		$data['contacts'] = $contacts;
		$data['contacts_tel'] = $contacts_tel;
		$data['channel_tel'] = $channel_tel;
		$data['channel_address'] = $channel_address;
		$data['contract_number'] = $contract_number;
		$data['province_id'] = $dst_province;
		$data['city_id']     = $dst_city;
		$data['forever_type'] = $change_forever_check;
		$begin_time?$data['begin_time'] = $begin_time:1;
		$end_time?$data['end_time'] = $end_time:1;
		$is_set = $channel->where("channel_id = $channel_id")->save($data);
		//渠道类型修改
		$channel_type_link = new Model("QdChannelTypeLink");
		$change_type_link['channel_type_id'] = $dst_channel_second_type?$dst_channel_second_type:$dst_channel_first_type;
		$is_type_link = $channel_type_link->where("channel_id = $channel_id")->save($change_type_link);	

		if($is_set || $is_type_link){
			$msg = C('change_channel_success');
			//如果渠道修改了所属代理商
			if($src_agent_id != $agent_id)
			{
				//修改改渠道下面网点及机器代理商id到新代理商id
				changeID('channel', $agent_id, $channel_id);
			}
			//查询修改后的信息，用于日志对比
			$dst_channel_log_info = $this->getChannelInfoByChannelId($channel_id);
			unset($dst_channel_log_info['agent_id']);
			$log_description = getChangeLogDescription($src_channel_log_info, $dst_channel_log_info);  //获取修改的详细记录
			addOptionLog('channel', $channel_id, 'change', $log_description);
		}else{
			$msg = C('change_channel_failed');
		}
		$this->ajaxReturn($msg,'json');
	}

	//根据渠道id获取渠道相关信息
	function getChannelInfoByChannelId($channel_id){
		$model = new Model();
		$sql = "
		SELECT a.channel_name,a.agent_id,a.province_id,a.city_id,a.contacts,a.contacts_tel,a.channel_address,a.contract_number,
		IF(a.forever_type = 1,'是','否') forever_type,
		FROM_UNIXTIME( a.begin_time, '%Y-%m-%d') begin_time,FROM_UNIXTIME( a.end_time, '%Y-%m-%d') end_time,
		b.agent_name channel_agent_name,
		IF(e.channel_type_name IS NOT NULL,CONCAT(e.channel_type_name,' ',d.channel_type_name),d.channel_type_name) channel_type_name,
		f.area_name province,g.area_name city
		FROM qd_channel a
		LEFT JOIN qd_agent b ON a.agent_id = b.agent_id
		LEFT JOIN qd_channel_type_link c ON a.channel_id = c.channel_id
		LEFT JOIN qd_channel_type d ON c.channel_type_id = d.channel_type_id
		LEFT JOIN qd_channel_type e ON d.channel_type_father_id = e.channel_type_id
		LEFT JOIN bi_area f ON a.province_id = f.area_id
		LEFT JOIN bi_area g ON a.city_id = g.area_id
		WHERE a.channel_id = $channel_id
		";
		$que = $model->query($sql);
		return $que[0];
	}
	
	//AJAX根据渠道ID返回详细信息
	public function channelDetailSelect(){
		$Model = new Model();
		$channel_id = trim($_GET['channel_id']);
		$dataChannel = $this->getChannelInfoByChannelId($channel_id);
		echo json_encode($dataChannel);
	}

	//根据对象id及对象名称获取日志，对象名称:device,place,channel
	function logSelect(){
		$option_id   = trim(I('option_id'));
		$option_name = trim(I('option_name'));;
		$common = new Common();
		$data = $common->logByOptionId($option_id, $option_name);
		$this->ajaxReturn($data,'json');
	}

	//终止合同
	public function channelContractDelete(){
		$channel_id = trim($_GET['channel_id']);

		$model   = new Model();
		$channel = new Model("QdChannel");
		$place   = new Model("QdPlace");
		$device  = new Model("QdDevice");
		$msg = C('delete_channel_success');

		$is_set = $channel->where("channel_id=" . $channel_id)->setField('isDelete', 1);
		if($is_set <= 0)
		{
			$msg = C('delete_channel_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}else{
			//删除下级网点及加油站
			$place_info = $model->query("select place_id from qd_place where channel_id=" . $channel_id);
			foreach($place_info as $key=>$val){
				$is_set = $place->where("place_id=" . $val['place_id'])->setField('isDelete', 1);
				addOptionLog('place', $val['place_id'], 'del', '');
				$device_info = $model->query("select device_id from qd_device where place_id=" . $val['place_id']);
				foreach($device_info as $d_key=>$d_val){
					$is_set = $device->where("device_id=" . $d_val['device_id'])->setField('isDelete', 1);
					addOptionLog('device', $d_val['device_id'], 'del', '');
				}
			}
			addOptionLog('channel', $channel_id, 'del', '');
		}

		$this->ajaxReturn($msg,'json');
	}

	//根据1级渠道商类型查询二级渠道商类型
	public function channelSecondTypeSelect(){
		$channel_type = new Model("QdChannelType");
		$channel_first_type_sel = trim(I('get.channel_first_type_sel'));
		if($channel_first_type_sel)
		{
			$channel_type_list = $channel_type->query("select channel_type_id, channel_type_name from qd_channel_type where	 channel_type_father_id='$channel_first_type_sel'");
		}
		$this->ajaxReturn($channel_type_list, 'json');
	}

	//添加渠道商类型
	public function channelTypeAdd(){
		$msg = C('add_type_success');
		$channel_type_father_id = trim(I('channel_type_father_id'));
		$channel_type_name      = trim(I('channel_type_name'));

		$Model        = new Model();
		$channel_type = new Model("QdChannelType");
		$tmp_channel_type_count = $Model->query("select count(*) as count from qd_channel_type where channel_type_name='$channel_type_name'");
		if($tmp_channel_type_count[0]['count'] > 0)
		{
			$msg = C('type_name_exist');
			$this->ajaxReturn($msg, 'json');
			return;
		}
		if($channel_type_father_id)
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
		$this->ajaxReturn($msg, 'json');
	}

    //修改渠道商类型
	public function channelTypeSave(){
		$msg = C('change_type_success');
		$first_channel_type_id = trim(I('first_channel_type_id'));
		$second_channel_type_id = trim(I('second_channel_type_id'));
		$dst_channel_type_name = trim(I('dst_channel_type_name'));

		$channel_type = new Model("QdChannelType");
		if($first_channel_type_id){
			//有二级类型id则修改的是二级类型
			if($second_channel_type_id){
				$is_set = $channel_type->where("channel_type_id='$second_channel_type_id' and channel_type_father_id='$first_channel_type_id'")->setField('channel_type_name', $dst_channel_type_name);
			//没有二级类型id则修改的是一级类型
			}else{
				$is_set = $channel_type->where("channel_type_id='$first_channel_type_id' and channel_type_father_id='0'")->setField('channel_type_name', $dst_channel_type_name);
			}
			if($is_set <= 0){
				$msg = C('type_name_exist');
				$this->ajaxReturn($msg, 'json');
				return;
			}
		}else{
			$msg = C('change_type_failed');
		}
		$this->ajaxReturn($msg, 'json');
	}

    //删除渠道商类型
	public function channelTypeDelete(){
		$msg = C('delete_type_success');
		$channel_type_id = trim(I('channel_type_id'));

		$Model = new Model();
		$channel_type = new Model("QdChannelType");
		$count_sql = "
				select count(*) as count from qd_channel_type a, qd_channel_type_link b where 
				a.channel_type_id=b.channel_type_id and (a.channel_type_id='$channel_type_id' or 
				a.channel_type_father_id='$channel_type_id')
		";
		$channel_type_count = $Model->query($count_sql);
		//如果有渠道商在用该渠道类型则不能删除
		if($channel_type_count[0]['count'] > 0)
		{
			$msg = C('delete_channel_type_exist');
			$this->ajaxReturn($msg, 'json');
			return;
		}
		$count_sql = "
				select count(*) as count from qd_channel_type a, qd_place b where 
				a.channel_type_id=b.place_type_id and (a.channel_type_id='$channel_type_id' or 
				a.channel_type_father_id='$channel_type_id')
		";
		$place_type_count = $Model->query($count_sql);
		//同样验证如有网点使用该类型也不能删除
		if($place_type_count[0]['count'] > 0)
		{
			$msg = C('delete_place_type_exist');
			$this->ajaxReturn($msg, 'json');
			return;
		}
		//开始删除该id类型及其子类型
		$is_set = $channel_type->where("channel_type_id = $channel_type_id or channel_type_father_id = $channel_type_id")->delete();
		if($is_set <= 0)
		{
			$msg = C('delete_type_failed');
			$this->ajaxReturn($msg, 'json');
			return;
		}
		$this->ajaxReturn($msg, 'json');
	}
}
?>