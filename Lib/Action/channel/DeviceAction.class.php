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
				a.province, a.city, a.address, a.device_type,
				CASE a.status WHEN 'normal' THEN '正常' WHEN 'abnormal' THEN '不正常' WHEN 'not_use' THEN '未运行' END STATUS,
				FROM_UNIXTIME( a.begin_time, '%Y-%m-%d' ) begin_time,
				FROM_UNIXTIME( a.deploy_time, '%Y-%m-%d' ) deploy_time,
				a.repair_user, a.repair_user_tel, a.description, a.isDelete,
				b.place_name
				FROM qd_device a
				LEFT JOIN qd_place b ON a.place_id = b.place_id
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

	//查询设备日志信息
	public function deviceLogSelect(){
		$option_id   = trim(I('device_id'));
		$option_name = "device";
		$common = new Common();
		$data = $common->logByOptionId($option_id, $option_name);
		$this->ajaxReturn($data,'json');
	}

     //根据设备ID查询设备详细信息
     public function deviceDetailSelect(){
	    $model = new Model();
		$device_id = $_GET['device_id'];
		$where = " WHERE a.device_id = $device_id";
		$sql = "
				SELECT
				a.device_id,a.device_no,a.MAC,a.place_id,a.channel_id,
				a.agent_id,a.province_id,a.city_id,a.address,a.status,
				a.device_type,a.isDelete,a.sim_card,a.phone_number,
				FROM_UNIXTIME( a.begin_time, '%Y-%m-%d' ) begin_time,
				FROM_UNIXTIME( a.deploy_time, '%Y-%m-%d' ) deploy_time,
				FROM_UNIXTIME( a.first_open_time, '%Y-%m-%d' ) first_open_time,
				b.place_name
				FROM qd_device a
				LEFT JOIN qd_place b ON a.place_id = b.place_id
				$where
				";
		$dataDevice = $model->query($sql);
 		//分拆mac地址
		$device_mac_array = explode("-", $dataDevice[0]['MAC']);
		$dataDevice[0]['MAC1'] = $device_mac_array[0];
		$dataDevice[0]['MAC2'] = $device_mac_array[1];
		$dataDevice[0]['MAC3'] = $device_mac_array[2];
		$dataDevice[0]['MAC4'] = $device_mac_array[3];
		$dataDevice[0]['MAC5'] = $device_mac_array[4];
		$dataDevice[0]['MAC6'] = $device_mac_array[5];		
		//格式化开关机时间
		$dataDevice[0]['power_on_time'] = $dataDevice[0]['power_on_time']?date("H:i:s", strtotime(date("Y-m-d"))+$dataDevice[0]['power_on_time']):"";			
		$dataDevice[0]['power_off_time'] = $dataDevice[0]['power_off_time']?date("H:i:s", strtotime(date("Y-m-d"))+$dataDevice[0]['power_off_time']):"";		
		//获取加油站图片
		$imageDetail = $model->query("select image_id, image_path, image_description from qd_device_image where device_id='$device_id'");
		$dataDevice[0]['image_id_0'] = $imageDetail[0]['image_id'];
		$dataDevice[0]['image_path_0'] = $imageDetail[0]['image_path'];
		$dataDevice[0]['image_id_1'] = $imageDetail[1]['image_id'];
		$dataDevice[0]['image_path_1'] = $imageDetail[1]['image_path'];
		$dataDevice[0]['image_id_2'] = $imageDetail[2]['image_id'];
		$dataDevice[0]['image_path_2'] = $imageDetail[2]['image_path'];
		
		$data = $dataDevice[0];
		$this->ajaxReturn($data,'json');
	}

	//上传图片
	public function uploadImage(){
		$upload = new UploadAction();
		$image_path = $upload->upload();
		//$this->ajaxReturn($image_path, 'json');
		echo $image_path;
	}

    //添加设备信                 
	public function deviceAdd(){
		$userinfo = getUserInfo();
		$common = new Common();
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
		$power_on_time = trim(I('add_power_on_time_sel'));
		$power_off_time = trim(I('add_power_off_time_sel'));
		$image_path_0 = trim(I('add_image_path_0'));
		$image_path_1 = trim(I('add_image_path_1'));
		$image_path_2 = trim(I('add_image_path_2'));		 
		$add_sim_card_text=trim(I('add_sim_card_text')); //SIM卡
		$add_phone_number_text=trim(I('add_phone_number_text'));//手机号码
		$add_first_open_time = strtotime(trim(I('add_first_open_time'))); //首次获取日期
		$msg = C('add_device_success');
		$model = new Model();
		$device = new Model("QdDevice");
		$device_image = new Model("QdDeviceImage");
		$place_id = getPlaceIDFromPlaceName($place_name);
		$channel_id = getChannelIDFromPlaceID($place_id);
		$agent_id = getAgentIDFromChannelID($channel_id);
		/* modify 2014-7-25 */
		$device_no_count = $model->query("select count(*) as count from qd_device where device_no='$device_no' and isDelete= '0'");
		$mac_count = $model->query("select count(*) as count from qd_device where MAC='$mac' and isDelete= '0'");
		$place_area = $model->query("select province_id, city_id from qd_place where place_id='$place_id' and isDelete= '0'");
		/* modify end */
		$is_purview = $common->agentPurview($userinfo['agentsid'], $agent_id);
		//获取省市id
		/*$sql = " select * from bi_area ";
		$que = $model->query($sql);
		foreach($que as $k=>$v){
			if(substr_count($province,$v['area_name']) >= 1){
				$province_id = $v['area_id'];
			}
			if(substr_count($city,$v['area_name']) >= 1){
				$city_id = $v['area_id'];
			}
		}
		*/
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
		else if(empty($place_area[0]['province_id']))
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
			$data['province_id'] = $place_area[0]['province_id'];
			$data['city_id'] = $place_area[0]['city_id'];
		/*	$data['province_id']=$province_id[0]['area_id'];
			$data['city_id']=$city_id[0]['area_id'];*/
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
			$data['power_on_time'] = $power_on_time;
			$data['power_off_time'] = $power_off_time;
			$data['repair_user_tel'] = $repair_user_tel;
			$data['description'] = $description;
			$data['channel_id'] = $channel_id;
			$data['agent_id'] = $agent_id;
			$data['isDelete'] = 0;			
			if($add_sim_card_text){
				$data['sim_card'] = $add_sim_card_text; // SIM卡
			}
			if($add_phone_number_text){
				$data['phone_number'] = $add_phone_number_text; //移动电话
			}
			if($add_first_open_time){
				$data['first_open_time']=$add_first_open_time;//首次启用日期
			}
			$is_set = $device->add($data);// hm
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
		$common = new Common();
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
		$power_on_time = trim(I('change_power_on_time_sel'));
		$power_off_time = trim(I('change_power_off_time_sel'));
		$image_path_0 = trim(I('change_image_path_0'));
		$image_path_1 = trim(I('change_image_path_1'));
		$image_path_2 = trim(I('change_image_path_2'));		
		//----hm----
		$simcard = trim(I('simcard'));// SIM卡 
		$phonenumber = trim(I('phonenumber')); //手机号码
		$qysj = strtotime(trim(I('qysj')));//首次开启时间		
		$msg = C('change_device_success');
		$log_description = '';
		$log_photo_change_num = 0;	
		$place_id = getPlaceIDFromPlaceName($place_name);
		$channel_id = getChannelIDFromPlaceID($place_id);
		$agent_id = getAgentIDFromChannelID($channel_id);
		$model = new Model();
		$device = new Model("QdDevice");
		$device_no_count = $model->query("select count(*) as count from qd_device where device_no='$device_no' and isDelete= '0'");
		$mac_count = $model->query("select count(*) as count from qd_device where MAC='$mac' and isDelete= '0'");
		$place_area = $model->query("select province_id, city_id from qd_place where place_id='$place_id'");
		//$src_device_info = $model->table('qd_device')->where("device_id='%d'", $device_id)->select(); //记录原来的设备信息
		$src_device_info = $model->table('qd_device')->where("device_id='{$device_id}' and isDelete= '0'" )->select();
		$is_purview = $common->agentPurview($userinfo['agentsid'], $agent_id);
		
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
		else if(empty($place_area[0]['province_id']))
		{
			$msg = C('place_not_exist');
			$this->ajaxReturn($msg,'json');
			return;
		}
		else
		{
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
			$src_device_log_info = $model->table('qd_device')->where("device_id='%d'", $device_id)->select();  //查询修改前的信息，用于日志对比
			$src_device_log_info[0]['device_place_name'] = getPlaceNameFromPlaceID($src_device_log_info[0]['place_id']);
			unset($src_device_log_info[0]['place_id']);
			unset($src_device_log_info[0]['channel_id']);
			unset($src_device_log_info[0]['agent_id']);
			$src_device_log_info[0]['device_begin_time'] = date('Y-m-d', $src_device_log_info[0]['begin_time']);
			unset($src_device_log_info[0]['begin_time']);
			$src_device_log_info[0]['deploy_time'] = date('Y-m-d', $src_device_log_info[0]['deploy_time']);
			$src_device_log_info[0]['power_on_time'] = date('H:i:s', $src_device_log_info[0]['power_on_time']);
			$src_device_log_info[0]['power_off_time'] = date('H:i:s', $src_device_log_info[0]['power_off_time']);
			$data = array();
			$data['device_no'] = $device_no;
			$data['MAC'] = $mac;
			$data['place_id'] = $place_id;
			$data['channel_id'] = $channel_id;
			$data['agent_id'] = $agent_id;
			$data['province_id'] = $place_area[0]['province_id'];
			$data['city_id'] = $place_area[0]['city_id'];
			$data['power_on_time'] = $power_on_time;
			$data['power_off_time'] = $power_off_time;
			/*$data['province_id']=$province_id;
			$data['city_id']=$city_id;*/
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
			$tmp_status= $model->query("select status from qd_device where device_id='$device_id'");
			if(('not_use' == $status) && ($tmp_status[0]['status'] != $status))
			{
				changeDeviceLogTime($device_id, '', time());
			}
			$data['device_type'] = $device_type;
			$data['address'] = $address;
			$data['repair_user'] = $repair_user;
			$data['repair_user_tel'] = $repair_user_tel;
			$data['description'] = $description;
			//hm修
			if($simcard){
				$data['sim_card'] = $simcard; // SIM卡
			}
			if($phonenumber){
				$data['phone_number'] = $phonenumber; //移动电话
			}
			if($qysj){
				$data['first_open_time']=$qysj;//首次启用日期
			}
			$is_set = $device->where("device_id  =$device_id")->save($data);
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
		}
		if($msg == C('change_device_success'))
		{
			if($place_id != $src_place_id)
			{
				changeNum('device', $src_place_id, $device_id, 'minus');
				changeNum('device', $place_id, $device_id, 'add');
			}
			$dst_device_log_info = $model->table('qd_device')->where("device_id='%d'", $device_id)->select();  //查询修改后的信息，用于日志对比
			$dst_device_log_info[0]['device_place_name'] = getPlaceNameFromPlaceID($dst_device_log_info[0]['place_id']);
			unset($dst_device_log_info[0]['place_id']);
			$dst_device_log_info[0]['device_begin_time'] = date('Y-m-d', $dst_device_log_info[0]['begin_time']);
			unset($dst_device_log_info[0]['begin_time']);
			$dst_device_log_info[0]['deploy_time'] = date('Y-m-d', $dst_device_log_info[0]['deploy_time']);
			$dst_device_log_info[0]['power_on_time'] = date('H:i:s', $dst_device_log_info[0]['power_on_time']);
			$dst_device_log_info[0]['power_off_time'] = date('H:i:s', $dst_device_log_info[0]['power_off_time']);

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
	    $model = new Model();
		$device = new Model("QdDevice");
		$msg = C('delete_device_success');
		$place_id = getPlaceIDFromDeviceID($device_id);
		$is_set = $device->where("device_id='$device_id'")->delete();
		if($is_set <= 0)
		{
			$msg = C('delete_device_failed');
		}
		if($msg == C('delete_device_success'))
		{
			changeNum('device', $place_id, $device_id, 'minus');
			addOptionLog('device', $device_id, 'del', '');
		}
		$this->ajaxReturn($msg,'json');
		//$this->deviceSelect();
	}

	//撤销设备
	public function deviceRepeal(){
		$device_id = trim(I('device_id'));

	    $model = new Model();
		$device = new Model("QdDevice");
		$msg = C('repeal_device_success');
		$is_set = $device->where("device_id='$device_id'")->setField('isDelete', 1);
		if($is_set <= 0)
		{
			$msg = C('repeal_device_failed');
		}
		if($msg == C('repeal_device_success'))
		{
			$place_id = getPlaceIDFromDeviceID($device_id);
			changeNum('device', $place_id, $device_id, 'minus');
			addOptionLog('device', $device_id, 'del', '');
		}
		$this->ajaxReturn($msg,'json');
		//$this->deviceSelect();
	}
	//撤销设备
	public function placeDeviceRepeal($device_id){
	    $model = new Model();
		$device = new Model("QdDevice");
		$msg = C('repeal_device_success');
		$is_set = $device->where("device_id='$device_id'")->setField('isDelete', 1);
		if($is_set <= 0)
		{
			$msg = C('repeal_device_failed');
		}
		if($msg == C('repeal_device_success'))
		{
			$place_id = getPlaceIDFromDeviceID($device_id);
			changeNum('device', $place_id, $device_id, 'minus');
			addOptionLog('device', $device_id, 'del', '');
		}
		//$this->ajaxReturn($msg,'json');
		//$this->deviceSelect();
	}

	//恢复已经删除的设备信息
	public function deviceRecover()
	{
		$device_id = trim(I('get.device_id'));
		$device = new Model("QdDevice");
		$is_set = $device->where("device_id='$device_id'")->setField('isDelete', 0);
		$place_id = getPlaceIDFromDeviceID($device_id);
		changeNum('device', $place_id, $device_id, 'add');
		addOptionLog('device', $device_id, 'add', '');
		//$this->deviceSelect();
	}
}
?>