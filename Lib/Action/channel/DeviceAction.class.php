<?php
import( "@.MyClass.Page" );//导入分页类
import( "@.MyClass.Common" );//导入公共类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}
//设备类
class DeviceAction extends Action {
	public function index(){
		$userinfo = getUserInfo();
		//登录的用户名
		$this->username = $userinfo['realname'];
		$this->assign('nowUrl', "channel/Device/index");
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->display(':device_index');
	}

	//查询设备信息						
	public function deviceSelect(){
		$userinfo = getUserInfo();
	    $model    = new Model();
	    $province             = trim(I('select_province'));
	    $city                 = trim(I('select_city'));
	    $device_no            = trim(I('device_no_txt'));//加油站编号
	    $MAC                  = trim(I('mac_txt'));
	    $status               = trim(I('select_device_status'));
	    $channel_name         = trim(I('channel_name_txt'));
	    $sswd                 = trim(I('sswd')); //所属网点
	    $sim_text             = trim(I('sim_text')); //SIM 卡
		$firstopentime1       = strtotime(trim(I('firstopentime1'))); //首次启用日期
		$firstopentime2       = strtotime(trim(I('firstopentime2'))); //首次启用日期
		$del_flag_txt         = trim(I('select_del_flag_txt'))?trim(I('select_del_flag_txt')):0; 

		$where = " WHERE a.isDelete = $del_flag_txt ";
		if($province){
			if($city){
				$where .= " and a.province_id = $province and a.city_id = $city ";
			}
			else{
				$where .= " and a.province_id = $province ";
			}
		}
		if($device_no){
			$where .= " and a.device_no = '$device_no' ";
		}
		if($MAC){
			$where .= " and a.MAC = '$MAC' ";
		}
		if($status){
			$where .= " and a.status = '$status' ";
		}
		if($channel_name){
			$channel_id = getChannelIDFromChannelName($channel_name);
			$where .= " and b.channel_id = $channel_id";
		}
		if($sswd){
			$where .= " and b.place_name='$sswd' ";
		}
		if($sim_text){
			$where .= " and a.sim_card='$sim_text' ";
		}
		
		if($firstopentime1){
			$where .= " and a.first_open_time >= '$firstopentime1' ";
			
		}
		if($firstopentime2){
			$where .= " and a.first_open_time <= '$firstopentime2' ";
		}
		
		if(trim($userinfo['orgid'])){
			$common = new Common();
			$sub_agent_id = $common->getAgentIdAndChildId(trim($userinfo['orgid']));
			$where .= " and a.agent_id in ($sub_agent_id)"; //权限限制
		}
		$sql = "
				SELECT a.device_id, a.device_no, a.MAC, a.place_id, a.channel_id, a.agent_id,
				c.area_name province, c.area_name city, a.address, a.device_type,
				CASE a.status WHEN 'normal' THEN '正常' WHEN 'abnormal' THEN '不正常' WHEN 'not_use' THEN '未运行' END STATUS,
				FROM_UNIXTIME( a.begin_time, '%Y-%m-%d' ) begin_time,
				FROM_UNIXTIME( a.deploy_time, '%Y-%m-%d' ) deploy_time,
				a.repair_user, a.repair_user_tel, a.description, a.isDelete,
				b.place_name
				FROM qd_device a
				LEFT JOIN qd_place b ON a.place_id = b.place_id
				LEFT JOIN bi_area c ON a.province_id = c.area_id
				LEFT JOIN bi_area d ON a.city_id = c.area_id
				$where
				ORDER BY a.agent_id,a.channel_id,a.place_id
				";
		//echo $sql;exit;
		$que = $model->query($sql);
		$count = count($que);
		
		$showQue  = array();
		$pageNum  = $_GET['p']?$_GET['p']:1;
		//每页显示的数量
		$page_show_number = C('page_show_number') ? C('page_show_number') : 30;
		$beginNum = ($pageNum - 1) * $page_show_number;
		$endNum   = $beginNum + $page_show_number - 1;
		
		for($i = $beginNum;$i<=$endNum;$i++){
			if($que[$i]){
				$showQue[$i] =  $que[$i];
				//获取图片路径，最多三个
				$img_sql = "select image_id, image_path, image_description from qd_device_image where device_id= " . $showQue[$i]['device_id'];
				$img_que = $model->query($img_sql);
				if($img_que[0]['image_path']){
					$showQue[$i]['device_image_0'] = C('image_url') . $img_que[0]['image_path'];
				}
				if($img_que[1]['image_path']){
					$showQue[$i]['device_image_1'] = C('image_url') . $img_que[1]['image_path'];
				}
				if($img_que[2]['image_path']){
					$showQue[$i]['device_image_2'] = C('image_url') . $img_que[2]['image_path'];
				}
			}
		}
		//如果无数据改变显示模式
		$is_device_select_show = $showQue?1:2;

		//echo json_encode($showQue);exit;
		$Page = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		$show = $Page->show();// 分页显示输出

		$this->assign('isDeleteResult',$del_flag_txt);
		$this->assign('list',$showQue);
		$this->assign('page',$show);//赋值分页输出
		$this->assign('is_device_select_show',$is_device_select_show); //是否显示结果集
		$this->assign('device_select_number',$count); //查询结果集的数量
		$this->assign('sswd',$sswd);// 网店值返回页面
		$this->index();
	}

	//根据设备ID查询设备详细信息
	public function deviceDetailSelect(){
	    $model      = new Model();
		$device_id  = $_GET['device_id'];
		$dataDevice = $this->getDeviceById($device_id);
 		//分拆mac地址
		$device_mac_array = explode("-", $dataDevice['MAC']);
		$dataDevice['MAC1'] = $device_mac_array[0];
		$dataDevice['MAC2'] = $device_mac_array[1];
		$dataDevice['MAC3'] = $device_mac_array[2];
		$dataDevice['MAC4'] = $device_mac_array[3];
		$dataDevice['MAC5'] = $device_mac_array[4];
		$dataDevice['MAC6'] = $device_mac_array[5];		
		//获取加油站图片
		$imageDetail = $model->query("select image_id, image_path, image_description from qd_device_image where device_id='$device_id'");
		$dataDevice['image_id_0']   = $imageDetail[0]['image_id'];
		$dataDevice['image_path_0'] = $imageDetail[0]['image_path'];
		$dataDevice['image_id_1']   = $imageDetail[1]['image_id'];
		$dataDevice['image_path_1'] = $imageDetail[1]['image_path'];
		$dataDevice['image_id_2']   = $imageDetail[2]['image_id'];
		$dataDevice['image_path_2'] = $imageDetail[2]['image_path'];
		
		$this->ajaxReturn($dataDevice,'json');
	}

	//上传图片
	public function uploadImage(){
		$upload = new UploadAction();
		$image_path = $upload->upload();
		echo $image_path;
	}

    //添加设备信                 
	public function deviceAdd(){
		$userinfo = getUserInfo();
		$common   = new Common();
		$device_no             = trim(I('add_device_no_txt'));
		$mac                   = trim(I('add_mac_txt'));
		$place_name            = trim(I('add_place_name_txt'));
		$deploy_time           = strtotime(trim(I('add_deploy_time_sel')));
		$begin_time            = strtotime(trim(I('add_begin_time_sel')));
		$status                = trim(I('add_status_sel'));
		$device_type           = I('add_device_type_txt');//终端型号
		$address               = trim(I('add_address_txt'));
		$power_on_time         = trim(I('add_power_on_time_sel'));
		$power_off_time        = trim(I('add_power_off_time_sel'));
		$image_path_0          = trim(I('add_image_path_0'));
		$image_path_1          = trim(I('add_image_path_1'));
		$image_path_2          = trim(I('add_image_path_2'));		 
		$add_sim_card_text     = trim(I('add_sim_card_text')); //SIM卡
		$add_phone_number_text = trim(I('add_phone_number_text'));//手机号码
		$add_first_open_time   = strtotime(trim(I('add_first_open_time'))); //首次获取日期
		
		$msg          = C('add_device_success');
		$model        = new Model();
		$device       = new Model("QdDevice");
		$device_image = new Model("QdDeviceImage");
		
		
		//获取并验证网点是否存在
		$place_id   = getPlaceIDFromPlaceName($place_name);
		if(!$place_id){
			$msg = C('place_not_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		//获取渠道id
		$channel_id = getChannelIDFromPlaceID($place_id);
		//获取代理商id
		$agent_id   = getAgentIDFromChannelID($channel_id);
		//验证权限
		$is_purview = $common->agentPurview($userinfo['agentsid'], $agent_id);
		if(!$is_purview){
			$msg = C('no_purview');
			$this->ajaxReturn($msg,'json');
			return;
		}
		
		//验证机器编号是否有重复
		$no_count_sql = "select count(*) count from qd_device where device_no='$device_no' and isDelete= '0'";
		$device_no_count = $model->query($no_count_sql);
		if($device_no_count[0]['count'] > 0){
			$msg = C('device_no_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		//验证机器mac是否有重复
		$mac_count_sql = "select count(*) count from qd_device where MAC='$mac' and isDelete= '0'";
		$mac_count = $model->query($mac_count_sql);
		if($mac_count[0]['count'] > 0){
			$msg = C('mac_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		//获取上级网点的省市id
		$area_id_sql = "select province_id, city_id from qd_place where place_id='$place_id' and isDelete= '0'";
		$place_area = $model->query($area_id_sql);
		
		$data['device_no']      = $device_no;
		$data['MAC']            = $mac;
		$data['place_id']       = $place_id;
		$data['channel_id']     = $channel_id;
		$data['agent_id']       = $agent_id;
		$data['province_id']    = $place_area[0]['province_id'];
		$data['city_id']        = $place_area[0]['city_id'];
		$data['status']         = $status;
		$data['device_type']    = $device_type;
		$data['address']        = $address;
		$data['power_on_time']  = $power_on_time;
		$data['power_off_time'] = $power_off_time;
		$data['isDelete']       = 0;
		$begin_time?$data['begin_time']               = $begin_time:1;
		$deploy_time?$data['deploy_time']             = $deploy_time:1;
		$add_sim_card_text?$data['sim_card']          = $add_sim_card_text:1;
		$add_phone_number_text?$data['phone_number']  = $add_phone_number_text:1;
		$add_first_open_time?$data['first_open_time'] = $add_first_open_time:1;

		$device_id = $device->add($data);
		//保存图片
		if($device_id){
			$image['device_id']  = $device_id;
			$image['image_path'] = $image_path_0;
			$device_image->add($image);
			$image['device_id']  = $device_id;
			$image['image_path'] = $image_path_1;
			$device_image->add($image);
			$image['device_id']  = $device_id;
			$image['image_path'] = $image_path_2;
			$device_image->add($image);
		}
		else{
			$msg = C('add_device_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
		//写入日志
		addOptionLog('device', $device_id, 'add', '');
		addDeviceLog($agent_id, $channel_id, $place_id, $device_id, $begin_time, '');
		$this->ajaxReturn($msg,'json');
	}

    //修改设备信息
	public function deviceSave(){
		$userinfo = getUserInfo();
		$common   = new Common();
		$device_id      = trim(I('change_device_id_txt'));
		$device_no      = trim(I('change_device_no_txt'));
		$mac            = trim(I('change_mac_txt'));
		$place_name     = trim(I('change_place_name_txt'));
		$deploy_time    = strtotime(trim(I('change_deploy_time_sel')));
		$begin_time     = strtotime(trim(I('change_begin_time_sel')));
		$status         = trim(I('change_status_sel'));
		$device_type    = I('change_device_type_txt');
		$address        = trim(I('change_address_txt'));
		$image_id_0     = trim(I('change_image_id_0'));
		$image_id_1     = trim(I('change_image_id_1'));
		$image_id_2     = trim(I('change_image_id_2'));
		$power_on_time  = trim(I('change_power_on_time_sel'));
		$power_off_time = trim(I('change_power_off_time_sel'));
		$image_path_0   = trim(I('change_image_path_0'));
		$image_path_1   = trim(I('change_image_path_1'));
		$image_path_2   = trim(I('change_image_path_2'));		
		$simcard        = trim(I('simcard'));// SIM卡 
		$phonenumber    = trim(I('phonenumber')); //手机号码
		$qysj = strtotime(trim(I('qysj')));//首次开启时间		
		$msg = C('change_device_success');
		//操作日志
		$log_description = '';
		
		//验证网点是否存在
		$place_id   = getPlaceIDFromPlaceName($place_name);
		if(!$place_id){
			$msg = C('place_not_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		$channel_id = getChannelIDFromPlaceID($place_id);
		//权限判断
		$agent_id   = getAgentIDFromChannelID($channel_id);
		$is_purview = $common->agentPurview($userinfo['agentsid'], $agent_id);
		if(!$is_purview){
			$msg = C('no_purview');
			$this->ajaxReturn($msg,'json');
			return;
		}
		
		$model  = new Model();
		$device = new Model("QdDevice");
		//验证编号是否有重复
		$no_count_sql = "SELECT COUNT(*) AS count FROM qd_device WHERE device_no = '$device_no' AND device_id <> $device_id AND isDelete= '0'";
		$device_no_count = $model->query($no_count_sql);
		if($device_no_count[0]['count'] > 0){
			$msg = C('change_device_no_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
		
		//验证mac地址是否有重复
		$mac_count_sql = "SELECT COUNT(*) AS count FROM qd_device WHERE MAC= '$mac' AND device_id <> $device_id AND isDelete= '0'";
		$mac_count = $model->query($mac_count_sql);
		if($mac_count[0]['count'] > 0){
			$msg = C('change_mac_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
		
		//获取上级渠道省市id
		$area_sql = "SELECT province_id, city_id FROM qd_place WHERE place_id = $place_id";
		$place_area = $model->query($area_sql);
		
		//查询修改前的信息，用于日志对比
		$src_device_log_info = $this->getDeviceById($device_id);
		//注释掉部分日志信息
		unset($src_device_log_info['place_id']);
		unset($src_device_log_info['channel_id']);
		unset($src_device_log_info['agent_id']);
		//如果是第一次停用要记录日志
		(('not_use' == $status) && ($src_device_log_info['status'] != $status))?changeDeviceLogTime($device_id, '', time()):1;
		//开始修改
		$data = array();
		$data['device_no']      = $device_no;
		$data['MAC']            = $mac;
		$data['place_id']       = $place_id;
		$data['channel_id']     = $channel_id;
		$data['agent_id']       = $agent_id;
		$data['province_id']    = $place_area[0]['province_id'];
		$data['city_id']        = $place_area[0]['city_id'];
		$data['power_on_time']  = $power_on_time;
		$data['power_off_time'] = $power_off_time;
		$data['device_type']    = $device_type;
		$data['address']        = $address;
		$data['status']         = $status;
		$begin_time?$data['begin_time']    = $begin_time:1;
		$deploy_time?$data['deploy_time']  = $deploy_time:1;
		$simcard?$data['sim_card']         = $simcard:1;
		$phonenumber?$data['phone_number'] = $phonenumber:1;
		$qysj?$data['first_open_time']     = $qysj:1;//首次启用日期
		//执行修改
		$device->where("device_id  = $device_id")->save($data);
		//修改图片路径
		$device_image = new Model("QdDeviceImage");
		if($image_path_0){
			$image['image_path'] = $image_path_0;
			$is_image_0 = $device_image->where("image_id=" . $image_id_0)->save($image);
		}			
		if($image_path_1){
			$image['image_path'] = $image_path_1;
			$is_image_1 = $device_image->where("image_id=" . $image_id_1)->save($image);
		}			
		if($image_path_2){
			$image['image_path'] = $image_path_2;
			$is_image_2 = $device_image->where("image_id=" . $image_id_2)->save($image);
		}
		//获取修改后加油站信息
		$dst_device_log_info = $this->getDeviceById($device_id);  //查询修改后的信息，用于日志对比
		unset($dst_device_log_info[0]['place_id']);
		unset($dst_device_log_info[0]['begin_time']);
		//对比获取日志
		$log_description = getChangeLogDescription($src_device_log_info, $dst_device_log_info);  //获取修改的详细记录
		//写入日志
		addOptionLog('device', $device_id, 'change', $log_description);
		$this->ajaxReturn($msg,'json');
	}
	
	//根据加油站id获取加油站相关信息
	function getDeviceById($dev_id){
		$model = new Model();
		$sql = "
				SELECT a.device_id,a.device_no,a.MAC,a.address,a.status,a.device_type,
				a.description,a.isDelete,a.sim_card,a.phone_number,
				a.province_id,a.city_id,
				a.place_id,a.channel_id,a.agent_id,
				FROM_UNIXTIME( a.begin_time, '%Y-%m-%d' ) begin_time,
				FROM_UNIXTIME( a.deploy_time, '%Y-%m-%d' ) deploy_time,
				IF(a.power_on_time IS NOT NULL,FROM_UNIXTIME( UNIX_TIMESTAMP(UTC_DATE()) + a.power_on_time, '%H:%i:%s' ),'') power_on_time,
				IF(a.power_off_time IS NOT NULL,FROM_UNIXTIME( UNIX_TIMESTAMP(UTC_DATE()) + a.power_off_time, '%H:%i:%s' ),'') power_off_time,
				IF(a.first_open_time <> 0,FROM_UNIXTIME( a.first_open_time, '%Y-%m-%d' ),'') first_open_time,
				b.place_name
				FROM qd_device a
				LEFT JOIN qd_place b ON a.place_id = b.place_id
				WHERE a.device_id = $dev_id
				";
		$que = $model->query($sql);
		return $que[0];
	}

    //删除设备
	public function deviceDelete(){
		$device_id = trim(I('device_id'));
		$device    = new Model("QdDevice");
		$msg       = C('delete_device_success');
		$is_set = $device->where("device_id='$device_id'")->delete();
		if($is_set <= 0){
			$msg = C('delete_device_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
		//记录日志
		addOptionLog('device', $device_id, 'del', '');
		$this->ajaxReturn($msg,'json');
	}

	//撤销设备
	public function deviceRepeal(){
		$device_id = trim(I('device_id'));
	    $model     = new Model();
		$device    = new Model("QdDevice");
		$msg = C('repeal_device_success');
		$is_set = $device->where("device_id='$device_id'")->setField('isDelete', 1);
		if($is_set <= 0)
		{
			$msg = C('repeal_device_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
		//记录日志
		addOptionLog('device', $device_id, 'del', '');
		$this->ajaxReturn($msg,'json');
	}

	//恢复已经删除的设备信息
	public function deviceRecover(){
		$device_id = trim($_GET['device_id']);
		
		$device = new Model("QdDevice");
		$is_set = $device->where("device_id='$device_id'")->setField('isDelete', 0);
		//记录相关日志
		addOptionLog('device', $device_id, 'add', '');
	}
}
?>