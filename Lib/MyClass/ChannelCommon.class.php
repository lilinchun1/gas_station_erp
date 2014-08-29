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
	//获取省市的信息
	function getArea(){
		$sql_are = " select area_id,area_name,pid from bi_area ";	
		$que_are = $this->model->query($sql_are);
		return $que_are;
	}
	
		//获取省份
	public function getAllProvince(){
		$model = new Model();
		//sql语句
		$sql="select area_id,area_name from bi_area where pid=0";
		//执行查询
		$province=$model->query($sql);
		return $province;
		
	}
	//获取市级
	public function getAllCity($province_id){		
		$model = new Model();
		//sql语句
		$sql="select area_id,area_name from bi_area where pid='$province_id'";
		//执行查询
		$city=$model->query($sql);
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