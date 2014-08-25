<?php
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
		$model = new Model();
		if($likeType=="channel_name"){
			//渠道商名字模糊查询
			$sql=" select channel_name title from qd_channel where channel_name like '%$typeKey%'  ";
			$type_json=$model->query($sql);			
			return $type_json;
		}else if ($likeType=="contract_number"){
			//渠道商合同编号模糊查询
			$sql=" select contract_number title from qd_channel where contract_number like '%$typeKey%' ";
			$type_json=$model->query($sql);			
			return $type_json;
		}else if($likeType=="place_name"){
			//网点模糊查询
			$sql = "select place_name title from qd_place where place_name like '%$typeKey%' and isDelete = 0";
			$type_json = $model->query($sql);			
			return $type_json;			
		}else if($likeType=="sim_card"){
			//SIM 模糊查询
			$sql=" select sim_card title from qd_device where sim_card like '%$typeKey%' ";
			$type_json=$model->query($sql);			
			return $type_json;
		}else if($likeType=="device_mac"){
			//mac地址模糊查询
			$sql=" select MAC title from qd_device where MAC like '%$typeKey%' ";
			$type_json=$model->query($sql);		
			return $type_json;
		}else if($likeType=="device_address"){
			//设备地址查询
			$sql=" select address title from qd_device where address like '%$typeKey%' ";
			$type_json=$model->query($sql);
			return $type_json;
		}else if($likeType=="device_no"){
			//设备编号模糊查询
			$sql=" select device_no title from qd_device where device_no like '%$typeKey%' ";
			$type_json=$model->query($sql);
			return $type_json;
		}else if($likeType=="place_no"){
			//网点编号模糊查询
			$sql=" select place_no title from qd_place where place_no like '%$typeKey%' ";
			$type_json=$model->query($sql);
			return $type_json;
		}else if($likeType=="realname"){
			//姓名模糊查询
			$sql=" select realname title from bi_user where realname like '%$typeKey%' ";
			$type_json=$model->query($sql);
			return $type_json;
		}else if($likeType=="username"){
			//账号模糊查询
			$sql=" select username title from bi_user where username like '%$typeKey%' ";
			$type_json=$model->query($sql);
			return $type_json;
		}else if($likeType=="agent_name"){
			//组织机构模糊查询
			$sql=" select agent_name title from qd_agent where agent_name like '%$typeKey%' ";
			$type_json=$model->query($sql);
			return $type_json;
		}else if($likeType=="role_name"){			
			//角色模糊查询
			$sql = "SELECT rolename title FROM bi_role WHERE rolename like '%$typeKey%' ";
			$type_json=$model->query($sql);
			return $type_json;
		}
	}
	
	// 根据代理商得到下属代理商字符串
	function getAgentIdAndChildId($father_agent_id) {
		//迭代出当前登录代理商及下属所有子代理商
		$sql_agent = "SELECT * FROM qd_agent where isDelete = 0";
		$que_agent = $this->model->query($sql_agent);
		$this->getAllChildAgent($que_agent,$father_agent_id);
		//字符串中加上自身代理商id
		$this->agentIdStr .= $father_agent_id;
		$this->agentIdStr = trim($this->agentIdStr,',');
		return $this->agentIdStr;
	}
	/**
	 * getAreaIdStr 根据给定代理商id获取其自身及下属所有子代理商区域id
	 * @param $father_agent_id 给定代理商id
	 * @return String
	 */
	function getAreaIdStr($father_agent_id){
		$this->getAgentIdAndChildId($father_agent_id);
		//获取当前登录代理商及下属所有子代理商所属所有地区id
		$sqlArea = "SELECT * FROM qd_agent_area WHERE agent_id IN (".$this->agentIdStr.") GROUP BY area_id;";
		$queArea = $this->model->query($sqlArea);
		$ableAreaIdStr = "";
		foreach ($queArea as $k=>$v){
			$ableAreaIdStr .= $v['area_id'].",";
		}
		$ableAreaIdStr = trim($ableAreaIdStr,',');
		return $ableAreaIdStr;
	}
	
	/**
	 * getAreaIdAndProvinceStr 根据给定代理商id获取其自身及下属所有子代理商区域id，包括区域所在省id
	 * @param $father_agent_id 给定代理商id
	 * @return String
	 */
	function getAreaIdAndProvinceStr($father_agent_id = null){
		$where = "";
		if($father_agent_id){
			$this->getAgentIdAndChildId($father_agent_id);
			$where = " WHERE 1 AND a.agent_id IN(".$this->agentIdStr.")";
		}
		
		$sql_area_id = "
				SELECT b.area_id
				FROM qd_agent_area a
				LEFT JOIN bi_area b ON a.area_id = b.area_id
				$where
				UNION
				SELECT area_id
				FROM bi_area
				WHERE level = 1
				AND area_id IN(
					SELECT b.pid
					FROM qd_agent_area a
					LEFT JOIN bi_area b ON a.area_id = b.area_id
					$where
				)
				";
		$que_area = $this->model->query($sql_area_id);
		//获取当前登录代理商及下属所有子代理商所属所有地区id，包括省id
		$ableAreaIdStr = "";
		foreach ($que_area as $k=>$v){
			$ableAreaIdStr .= $v['area_id'].",";
		}
		$ableAreaIdStr = trim($ableAreaIdStr,',');
		return $ableAreaIdStr;
	}
	
	/**
	 * getAllChildAgent获取所有子代理商id
	 * @param
	 * @return mixed
	 */
	function getAllChildAgent($agentArr,$pid){
		foreach ($agentArr as $k=>$v){
			if($v['father_agentid'] == $pid){
				$this->agentIdStr .= $v['agent_id'].',';
				$this->getAllChildAgent($agentArr,$v['agent_id']);
			}
		}
	}
	
	/**
	 * getAllOnlyCity获取所有直辖市id返回数组
	 * @param
	 * @return mixed
	 */
	function getAllOnlyCity(){
		$model = new Model();
		$sql = "
				SELECT a.* FROM bi_area a
				LEFT JOIN (SELECT * FROM bi_area WHERE LEVEL = 2) b ON a.area_id = b.pid
				WHERE a.level = 1
				AND b.area_id IS null
				";
		$que = $model->query($sql);
		$onlyCityArr = array();
		foreach($que as $k=>$v){
			$onlyCityArr[] = $v['area_id'];
		}
		return $onlyCityArr;
	}
}