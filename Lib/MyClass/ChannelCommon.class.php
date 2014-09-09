<?php
import( "@.MyClass.Common" );//导入公共类
class ChannelCommon{
	
	//当前代理商及下属所有子代理商id列表
	public $agentIdStr = "";
	//数据库模型
	private $model;
	
	function __construct(){
		$this->model = new Model();
	}
	
	//根据给定的代理商id列表获取省份，列表格式 1,2,3,4
	public function getAllProvince($agent_id = null){
		$common        = new Common();
		$ableAreaIdStr = $common->getAreaIdAndProvinceStr($agent_id);
		$model         = new Model();
		//sql语句
		$sql="
			SELECT area_id,area_name FROM bi_area
			WHERE pid=0
			AND area_id IN ( $ableAreaIdStr )
			";
		//执行查询
		$province=$model->query($sql);
		return $province;
	}
	//根据给定的代理商id列表获取市级
	public function getAllCity($province_id,$agent_id = null){
		$common        = new Common();
		$ableAreaIdStr = $common->getAreaIdAndProvinceStr($agent_id);
		$model = new Model();
		//sql语句
		$sql="
			SELECT area_id,area_name FROM bi_area WHERE pid='$province_id'
			AND area_id IN ( $ableAreaIdStr )
		";
		//执行查询
		$city=$model->query($sql);
		//如果没有下级则是直辖市，返回自身做下级市
		if(!$city){
			$sql="select area_id,area_name from bi_area where area_id='$province_id'";
			$city=$model->query($sql);
		}
		return $city;
	}
	
	//自动补全 
	public function getAlltype($likeType,$typeKey){
		$model  = new Model();
		$common = new Common();
		$userinfo = getUserInfo();
		$agentIdStr = $common->getAgentIdAndChildId($userinfo['orgid']);
		//echo json_encode($userinfo);exit;
		if($likeType=="channel_name"){
			//渠道商名字模糊查询
			$sql = "SELECT channel_name title FROM qd_channel WHERE agent_id IN($agentIdStr) AND channel_name LIKE '%$typeKey%' AND isDelete = 0";
			$type_json=$model->query($sql);			
			return $type_json;
		}else if ($likeType=="contract_number"){
			//渠道商合同编号模糊查询
			$sql="SELECT contract_number title FROM qd_channel WHERE agent_id IN($agentIdStr) AND contract_number LIKE '%$typeKey%' AND isDelete = 0";
			$type_json=$model->query($sql);			
			return $type_json;
		}else if($likeType=="place_name"){
			//网点模糊查询
			$sql = "SELECT place_name title FROM qd_place WHERE agent_id IN($agentIdStr) AND place_name LIKE '%$typeKey%' AND isDelete = 0";
			$type_json = $model->query($sql);			
			return $type_json;			
		}else if($likeType=="sim_card"){
			//SIM 模糊查询
			$sql="SELECT sim_card title FROM qd_device WHERE agent_id IN($agentIdStr) AND sim_card LIKE '%$typeKey%' AND isDelete = 0";
			$type_json=$model->query($sql);			
			return $type_json;
		}else if($likeType=="device_mac"){
			//mac地址模糊查询
			$sql="SELECT MAC title FROM qd_device WHERE agent_id IN($agentIdStr) AND MAC LIKE '%$typeKey%' AND isDelete = 0";
			$type_json=$model->query($sql);		
			return $type_json;
		}else if($likeType=="device_address"){
			//设备地址查询
			$sql="SELECT address title FROM qd_device WHERE agent_id IN($agentIdStr) AND address LIKE '%$typeKey%' AND isDelete = 0";
			$type_json=$model->query($sql);
			return $type_json;
		}else if($likeType=="device_no"){
			//设备编号模糊查询
			$sql="SELECT device_no title FROM qd_device WHERE agent_id IN($agentIdStr) AND device_no LIKE '%$typeKey%' AND isDelete = 0";
			$type_json=$model->query($sql);
			return $type_json;
		}else if($likeType=="place_no"){
			//网点编号模糊查询
			$sql="SELECT place_no title FROM qd_place WHERE agent_id IN($agentIdStr) AND place_no LIKE '%$typeKey%' AND isDelete = 0";
			$type_json=$model->query($sql);
			return $type_json;
		}else if($likeType=="realname"){
			//姓名模糊查询
			$sql="SELECT realname title FROM bi_user WHERE orgid IN($agentIdStr) AND realname LIKE '%$typeKey%' AND del_flag = 0";
			$type_json=$model->query($sql);
			return $type_json;
		}else if($likeType=="username"){
			//账号模糊查询
			$sql="SELECT username title FROM bi_user WHERE orgid IN($agentIdStr) AND username LIKE '%$typeKey%' AND del_flag = 0";
			$type_json=$model->query($sql);
			return $type_json;
		}else if($likeType=="agent_name"){
			//组织机构模糊查询
			$sql="SELECT agent_name title FROM qd_agent WHERE agent_id IN($agentIdStr) AND agent_name LIKE '%$typeKey%' AND isDelete = 0";
			$type_json=$model->query($sql);
			return $type_json;
		}else if($likeType=="role_name"){			
			//角色模糊查询
			$sql = "SELECT rolename title FROM bi_role WHERE role_agent_id IN($agentIdStr) AND rolename LIKE '%$typeKey%' AND del_flag = 0";
			$type_json=$model->query($sql);
			return $type_json;
		}
	}
}