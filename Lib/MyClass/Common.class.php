<?php
class Common{
	//当前代理商及下属所有子代理商id列表
	public $agentIdStr;
	//数据库模型
	private $model;
	
	function __construct(){
		$this->model = new Model();
	}
	// 根据代理商得到下属代理商字符串
	function getAgentIdAndChildId($father_agent_id) {
		$father_agent_id = $father_agent_id?$father_agent_id:0;
		//初始化
		$this->agentIdStr = '';
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
		$agentIdStr = $this->getAgentIdAndChildId($father_agent_id);
		//获取当前登录代理商及下属所有子代理商所属所有地区id
		$sqlArea = "SELECT * FROM qd_agent_area WHERE agent_id IN ($agentIdStr) GROUP BY area_id;";
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
			$agentIdStr = $this->getAgentIdAndChildId($father_agent_id);
			$where = " WHERE 1 AND a.agent_id IN($agentIdStr)";
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
	
	/**
	 * agentPurview判断参数1代理商是否有权操作参数2代理商
	 * @param
	 * @return mixed
	 */
	function agentPurview($user_agent_id='', $option_agent_id='') {
		if(!$user_agent_id)
		{
			return true;
		}
		$is_have_purview = false;
		$agentIdStr = $this->getAgentIdAndChildId($user_agent_id);
		$agentIdArr=explode(",",$agentIdStr);
		if(in_array($option_agent_id, $agentIdArr)){
			$is_have_purview = true;
		}
		return $is_have_purview;
	}
}