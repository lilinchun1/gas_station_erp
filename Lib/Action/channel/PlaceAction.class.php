<?php
import( "@.MyClass.Page" );//导入分页类
import( "@.MyClass.Common" );//导入公共类
foreach ($_GET as $k=>$v) {
	$_GET[$k] = urldecode($v);
}
//网点类
class PlaceAction extends Action {
	public function index(){
		$userinfo = getUserInfo();
		$this->username = $userinfo['realname']; //登录的用户名
		$this->assign('nowUrl', "'/gas_station_erp/index.php/channel/Place/index'");
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->display(':place_index');
	}

	//查询网点信息
	public function placeSelect(){
		$userinfo = getUserInfo();
	    $model = new Model();
		$place_no        = trim(I('place_no_txt'));
		$place_name      = trim(I('place_name_txt'));
		$place_state     = trim(I('place_state_sel'));
		$channel_name    = trim(I('channel_name_txt'));
		$province        = trim(I('select_province'));
		$city            = trim(I('select_city'));
		$test_end_time_1 = strtotime(trim(I('select_test_end_time_1')));
		$test_end_time_2 = strtotime(trim(I('select_test_end_time_2')));
		$del_flag_txt    = trim(I('select_del_flag_txt'))?trim(I('select_del_flag_txt')):0;
		$is_place_select_show = 1;
		//$page_show_number = 30;       //每页显示的数量
		$page_show_number = C('page_show_number') ? C('page_show_number') : 30;  //每页显示的数量
		$where = " WHERE a.isDelete = '$del_flag_txt' ";
		if($place_no){
			$where .= " and a.place_no='$place_no'";
		}
		if($place_name){
			$where .= " and a.place_name='$place_name'";
		}
		if($place_state){
			$where .= " and a.status='$place_state'";
		}
		if($test_end_time_1){
			$where .= " and a.test_end_time>='$test_end_time_1'";
		}
		if($test_end_time_2){
			$where .= " and a.test_end_time<='$test_end_time_2'";
		}
		if($channel_name){
			$channel_id = getChannelIDFromChannelName($channel_name);
			$where .= " and a.channel_id=" . $channel_id;
		}
		if($province){
			if($city){
				$where .= " and a.province_id='$province' and a.city_id='$city'";
			}else{
				$where .= " and a.province_id='$province'";
			}
		}
		
		if(trim($userinfo['orgid'])){
			$common = new Common();
			$sub_agent_id = $common->getAgentIdAndChildId(trim($userinfo['orgid']));
			$where .= " and a.agent_id in ($sub_agent_id)"; //权限限制
		}
		$sql = "
				SELECT
				a.place_id,a.isDelete,a.place_name,a.region,
				a.contacts_tel,
				CASE a.status WHEN 'test' THEN '测试期' WHEN 'use' THEN '启用' END status,
				IF(a.begin_time IS NOT NULL,FROM_UNIXTIME( a.begin_time, '%Y-%m-%d' ),'') begin_time,
				IF(a.end_time IS NOT NULL,FROM_UNIXTIME( a.end_time, '%Y-%m-%d' ),'') end_time,
				c.device_num,
				b.channel_name
				FROM qd_place a
				LEFT JOIN qd_channel b ON a.channel_id = b.channel_id
				LEFT JOIN (SELECT COUNT(device_id) device_num,place_id FROM qd_device WHERE isDelete = 0 GROUP BY place_id) c ON a.place_id = c.place_id
				$where
				ORDER BY a.place_id desc
				";
		$que = $model->query($sql);
		//当前页数
		$pageNum  = $_GET['p']?$_GET['p']:1;
		//显示开始索引
		$beginNum = ($pageNum - 1) * $page_show_number;
		$endNum   = $beginNum + $page_show_number - 1;
		//总条数
		$count    = count($que);
		$showQue = array();
		for($i = $beginNum;$i<=$endNum;$i++){
			$que[$i]?$showQue[] = $que[$i]:1;
		}
		if(!$showQue){
			$is_place_select_show = 2;
		}
		//分页类
		$Page       = new Page($count, $page_show_number);// 实例化分页类 传入总记录数
		//$Page->url = 'Agent/agentSelect/p/';
		$show       = $Page->show();// 分页显示输出
		$this->assign('isDeleteResult',$del_flag_txt);
		$this->assign('list',$showQue);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('is_place_select_show',$is_place_select_show); //是否显示结果集
		$this->assign('place_select_number',$count);  //查询结果集的数量
		$this->index();
	}

     //根据网点ID查询网点详细信息
     public function placeDetailSelect(){
	    $model = new Model();
		$place_id = trim($_GET['place_id']);
		$dataPlace = $this->getPlaceInfoByPlaceId($place_id);
		$this->ajaxReturn($dataPlace,'json');
	}

    //添加网点信息
	public function placeAdd(){
		$place_no        = trim(I('add_place_no_txt'));
		$place_name      = trim(I('add_place_name_txt'));
		$province        = trim(I('add_select_province'))?trim(I('add_select_province')):null;
		$city            = trim(I('add_select_city'))?trim(I('add_select_city')):null;
		$region          = trim(I('add_region_txt'));
		$contacts        = trim(I('add_contacts_txt'));
		$contacts_tel    = trim(I('add_contacts_tel_txt'));
		$status          = trim(I('add_status_sel'));
		$test_begin_time = strtotime(trim(I('add_test_begin_time_sel')));
		$test_end_time   = strtotime(trim(I('add_test_end_time_sel')));
		$channel_name    = trim(I('add_channel_name_txt'));
		$begin_time      = strtotime(trim(I('add_begin_time_sel')));
		$msg = C('add_place_success');

		$model       = new Model();
		$place       = new Model("QdPlace");
		//查看是否有重复网点编号，网点名称
		$que_count = $model->query("select count(*) count from qd_place where (place_no='$place_no' or place_name='$place_name') and isDelete='0'");
		//根据渠道名获取渠道id
		$channel_id = getChannelIDFromChannelName($channel_name);
		//根据渠道id获取代理商id
		$agent_id = getAgentIDFromChannelID($channel_id);

		if($que_count[0]['count'] > 0)
		{
			$msg = "已存在该网点编号或名称";
			$this->ajaxReturn($msg,'json');
			return;
		}else{
			$data['place_no']     = $place_no;
			$data['place_name']   = $place_name;
			$data['province_id']  = $province;
			$data['city_id']      = $city;
			$data['region']       = $region;
			$data['contacts']     = $contacts;
			$data['contacts_tel'] = $contacts_tel;
			$data['status'] = $status;
			//如果是测试则写入测试时间
			if('test' == $status){
				if($test_begin_time){
					$data['test_begin_time'] = $test_begin_time;
				}
				
				if($test_end_time){
					$data['test_end_time'] = $test_end_time;
				}
			}
			$data['channel_id'] = $channel_id;
			if($begin_time){
				$data['begin_time'] = $begin_time;
			}

			$data['agent_id'] = $agent_id;
			$data['isDelete'] = 0;
			$place_id = $place->add($data);
			if(!$place_id){
				$msg = C('add_place_failed');
				$this->ajaxReturn($msg,'json');
				return;
			}
		}
		//添加成功写入日志
		addOptionLog('place', $place_id, 'add', '');
		$this->ajaxReturn($msg,'json');
	}

	//修改网点信息
	public function placeSave(){
		$userinfo = getUserInfo();
		$place_id        = trim(I('change_place_id_txt'));
		$place_no        = trim(I('change_place_no_txt'));
		$place_name      = trim(I('change_place_name_txt'));
		$province        = trim(I('change_select_province'))?trim(I('change_select_province')):null;
		$city            = trim(I('change_select_city'))?trim(I('change_select_city')):null;
		$region          = trim(I('change_region_txt'));
		$contacts        = trim(I('change_contacts_txt'));
		$contacts_tel    = trim(I('change_contacts_tel_txt'));
		$status          = I('change_status_sel');
		$test_begin_time = strtotime(I('change_test_begin_time_sel'));
		$test_end_time   = strtotime(I('change_test_end_time_sel'));
		$channel_name    = trim(I('change_channel_name_txt'));
		$begin_time      = strtotime(trim(I('change_begin_time_sel')));
		$msg = C('change_place_success');
		$log_description = '';

		$model  = new Model();
		$common = new Common();
		$place  = new Model("QdPlace");
		//根据渠道名获取渠道id
		$channel_id = getChannelIDFromChannelName($channel_name);
		//根据渠道id获取代理商id
		$agent_id = getAgentIDFromChannelID($channel_id);
		//获取该网点原渠道id
		$src_channel_id   = getChannelIDFromPlaceID($place_id);
		//获取该网点原代理商id
		$src_agent_id     = getAgentIDFromChannelID($src_channel_id);
		//验证编号及名称是否重复
		$has_count   = $place->query("SELECT COUNT(*) AS count FROM qd_place WHERE (place_no='$place_no' OR place_name='$place_name') AND place_id <> $place_id AND isDelete='0'");
		if($has_count[0]['count'] > 0)
		{
			$msg = "已存在该网点编号或名称";
			$this->ajaxReturn($msg,'json');
			return;
		}
		
		//查询修改前的信息，用于日志对比
		$src_place_log_info = $this->getPlaceInfoByPlaceId($place_id);

		//开始保存
		$data['place_no']     = $place_no;
		$data['place_name']   = $place_name;
		$data['province_id']  = $province;
		$data['city_id']      = $city;
		$data['region']       = $region;
		$data['contacts']     = $contacts;
		$data['contacts_tel'] = $contacts_tel;
		$data['status']       = $status;
		
		if('test' == $status)
		{
			if($test_begin_time){
				$data['test_begin_time'] = $test_begin_time;
			}
			if($test_end_time){
				$data['test_end_time'] = $test_end_time;
			}
		}
		$data['channel_id'] = $channel_id;
		$data['agent_id']   = $agent_id;
		if($begin_time){
			$data['begin_time'] = $begin_time;
		}
		$is_set = $place->where("place_id = $place_id")->save($data);
		if(!$is_set)
		{
			$msg = C('change_place_failed');
			$this->ajaxReturn($msg,'json');
			return;
		}
		//如果更改渠道，则更改下属加油站所属代理商及渠道id
		if($channel_id != $src_channel_id){
			changeID('place', $channel_id, $place_id);
		}
		//更改下属加油站所属省市
		$dev_sql = " UPDATE qd_device SET province_id = $province , city_id = $city WHERE place_id = $place_id ";
		$model->query($dev_sql);
		//查询修改后的信息，用于日志对比
		$dst_place_log_info = $this->getPlaceInfoByPlaceId($place_id);
		
		//获取修改的详细记录
		$log_description = getChangeLogDescription($src_place_log_info, $dst_place_log_info);
		//写入日志
		addOptionLog('place', $place_id, 'change', $log_description);

		$this->ajaxReturn($msg,'json');
	}
	//根据网点id获取网点相关信息
	function getPlaceInfoByPlaceId($place_id){
		$model = new Model();
		$sql = "
			SELECT a.place_id, a.place_no, a.place_name ,a.region ,a.contacts ,a.contacts_tel ,a.status ,
			a.isDelete ,a.province_id ,a.city_id ,
			FROM_UNIXTIME( a.begin_time, '%Y-%m-%d' ) begin_time,
			FROM_UNIXTIME( a.test_begin_time, '%Y-%m-%d' ) test_begin_time,
			FROM_UNIXTIME( a.test_end_time, '%Y-%m-%d' ) test_end_time,
			b.channel_name
			FROM qd_place a
			LEFT JOIN qd_channel b ON a.channel_id = b.channel_id
			where a.place_id = $place_id
		";
		$que = $model->query($sql);
		return $que[0];
	}

	//删除网点
	public function placeDelete(){
		$place_id = trim(I('place_id'));
	    $model = new Model();
		$place = new Model("QdPlace");
		$msg   = C('delete_place_success');
		$sql   = "SELECT COUNT(device_id) count FROM qd_device a WHERE place_id = $place_id";
		$device_count = $model->query($sql);
		if($device_count[0]['count'] > 0){
			$msg = C('place_have_device');
		}else{
			//删除以及写入日志
			$is_set = $place->where("place_id='$place_id'")->delete();
			addOptionLog('place', $place_id, 'del', '');
		}
		$this->ajaxReturn($msg,'json');
	}

	//撤销网点
	public function placeRepeal(){
		$place_id = trim(I('place_id'));

	    $model  = new Model();
		$place  = new Model("QdPlace");
		$device = new Model("QdDevice");
		$msg = C('repeal_place_success');
		$is_set = $place->where("place_id='$place_id'")->setField('isDelete', 1);

		$device_info = $model->query("select device_id from qd_device where place_id=" . $place_id);
		foreach($device_info as $key=>$val){
			$is_set = $device->where("device_id=" . $val['device_id'])->setField('isDelete', 1);
			addOptionLog('device', $val['device_id'], 'del', '');
		}
		addOptionLog('place', $place_id, 'del', '');
		$this->ajaxReturn($msg,'json');
		//$this->placeSelect();
	}

	//恢复已经删除的网点信息
	public function placeRecover(){
		$place_id = trim($_GET['place_id']);
		$place = new Model("QdPlace");
		$is_set = $place->where("place_id='$place_id'")->setField('isDelete', 0);
		addOptionLog('place', $place_id, 'add', '');
	}
}
?>