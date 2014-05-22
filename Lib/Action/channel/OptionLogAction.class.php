<?php
import( "@.MyClass.Page" );//导入分页类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}
//操作日志类
class OptionLogAction extends CommonAction {
	public function index(){
		$userinfo = getUserInfo();
		$this->is_channel_user = in_array("渠道部", $userinfo['group']); //等于1为渠道部用户
		$this->agentsid = $userinfo['agentsid']; //agentsid为空则为总公司
		$this->username = $userinfo['username']; //登录的用户名
		$this->is_have_user_purview = in_array($userinfo['grade'], array(1,2,3));
		$this->display('channel:option_log_index');
	}

	//查询日志信息
	public function optionLogSelect(){
	    $Model = new Model();
		$option_object = trim(I('select_option_object_sel'));
		$option_object_name = trim(I('select_option_object_name_txt'));
		$option_object_id = trim(I('select_option_object_id_txt'));
		$option_type = trim(I('select_option_type_sel'));
		$begin_time = strtotime(trim(I('select_begin_time_sel')));
		$end_time = strtotime(trim(I('select_end_time_sel')));
		$is_log_select_show = 1;
		//$page_show_number = 30;       //每页显示的数量
		C('page_show_number')?$page_show_number=C('page_show_number'):$page_show_number=30;  //每页显示的数量
		$where = '1=1';
		if(!empty($option_object))
		{
			$where .= " and a.option_name='$option_object'";
		}
		if(!empty($option_object_name))
		{
			switch($option_object){
				case 'agent':
						$option_object_name_id = getAgentIDFromAgentName($option_object_name);
						$where .= " and a.option_id='$option_object_name_id'";
						break;
				case 'channel':
						$option_object_name_id = getChannelIDFromChannelName($option_object_name);
						$where .= " and a.option_id='$option_object_name_id'";
						break;
				case 'place':
						$option_object_name_id = getPlaceIDFromPlaceName($option_object_name);
						$where .= " and a.option_id='$option_object_name_id'";
						break;
				case 'device':
						$option_object_name_id = getDeviceIDFromDeviceMAC($option_object_name);
						$where .= " and a.option_id='$option_object_name_id'";
						break;
			}
		}
		if(!empty($option_object_id))
		{
			switch($option_object){
				case 'agent':
						$option_object_id = getAgentIDFromAgentContract($option_object_id);
						$where .= " and a.option_id='$option_object_id'";
						break;
				case 'channel':
						$option_object_id = getChannelIDFromChannelContract($option_object_id);
						$where .= " and a.option_id='$option_object_id'";
						break;
				case 'place':
						$option_object_id = getPlaceIDFromPlaceNO($option_object_id);
						$where .= " and a.option_id='$option_object_id'";
						break;
				case 'device':
						$option_object_id = getDeviceIDFromDeviceNO($option_object_id);
						$where .= " and a.option_id='$option_object_id'";
						break;
			}
		}
		if(!empty($option_type))
		{
			$where .= " and a.option_type='$option_type'";
		}
		if(!empty($begin_time))
		{
			$where .= " and a.timestamp>='$begin_time'";
		}
		if(!empty($end_time))
		{
			$where .= " and a.timestamp<='$end_time'";
		}
		$count = $Model->table('qd_logs_option a')->where($where)->count();
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		$list = $Model->table('qd_logs_option a')->where($where)->order('a.logs_id desc')->limit($Page->firstRow.','. $Page->listRows)->select();
		if($list=="")
		{
			$listCount = 0;
			$is_log_select_show = 2;
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
			if(!empty($list[$i]['timestamp']))
			{
				$list[$i]['option_time'] = date('Y-m-d H:i:s', $list[$i]['timestamp']);
			}
			if('change' == $list[$i]['option_type'])
			{
				$option_descrption = $Model->query("select option_descrption from qd_logs_option_description where option_log_id='" .					$list[$i]['logs_id'] . "'");
				$list[$i]['option_description'] = $option_descrption[0]['option_descrption'];
				$list[$i]['option_type_name'] = "修改";
			}
			else if('add' == $list[$i]['option_type'])
			{
				$list[$i]['option_type_name'] = "添加";
			}	
			else
			{
				$list[$i]['option_type_name'] = "删除";
			}

			switch($list[$i]['option_name']){
				case 'agent':
						$list[$i]['option_name_info'] = getAgentNameFromAgentID($list[$i]['option_id']);
						$list[$i]['option_name'] = '代理商';
						$list[$i]['option_type_name'] = $list[$i]['option_type_name'] . '代理商';
						break;
				case 'channel':
						$list[$i]['option_name_info'] = getChannelNameFromChannelID($list[$i]['option_id']);
						$list[$i]['option_name'] = '渠道商';
						$list[$i]['option_type_name'] = $list[$i]['option_type_name'] . '渠道商';
						break;
				case 'place':
						$list[$i]['option_name_info'] = getPlaceNameFromPlaceID($list[$i]['option_id']);
						$list[$i]['option_name'] = '网点';
						$list[$i]['option_type_name'] = $list[$i]['option_type_name'] . '网点';
						break;
				case 'device':
						$list[$i]['option_name_info'] = getDeviceNOFromDeviceID($list[$i]['option_id']);
						$list[$i]['option_name'] = '设备';
						$list[$i]['option_type_name'] = $list[$i]['option_type_name'] . '设备';
						break;
			}

			$list[$i]['optionRadioID'] = 'optionRadio' . $i; //用于详情点击的ID
			$list[$i]['optionDetailID'] = 'optionDetail' . $i; //用于选择的ID
			$list[$i]['optionRecoverID'] = 'optionRecover' . $i; //用于恢复的ID
		}

		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('is_log_select_show',$is_log_select_show); //是否显示结果集
		$this->assign('log_select_number',$count);  //查询结果集的数量
		$this->index();
	}
}
?>