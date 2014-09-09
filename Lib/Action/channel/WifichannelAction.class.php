<?php
class WifichannelAction extends Action {
	public function index(){}
	
	
	//获取渠道类型
	public function getAllChannelType(){
		$model = new Model();
		//sql语句
		$sql=" select channel_type_id,channel_type_name from qd_channel_type  where channel_type_father_id=0 ";
		//执行查询
		$all_agent_info =$model->query($sql);
		//接收json
		$result=json_encode($all_agent_info);
		//获取变量
		$callback=$_GET['callback'];
		//返回数据
		echo $callback."($result)";
		//$this->ajaxReturn($all_agent_info, 'json');
	}	 	
	public function getAllChannelTypeSub(){
		$model = new Model();
		
		$channel_type_father_id=$_GET['father_id'];
		//sql语句
		$sql=" select channel_type_id,channel_type_name from qd_channel_type  where channel_type_father_id= '$channel_type_father_id' ";
		//执行查询
		$all_agent_info_sub =$model->query($sql);
		//接收json
		$result=json_encode($all_agent_info_sub);
		//获取变量
		$callback=$_GET['callback'];
		//返回数据
		echo $callback."($result)";
		
		//$this->ajaxReturn($all_agent_info_sub, 'json');
		
		
	}	
	//获取省份
	public function getAllProvince(){
		$model = new Model();
		//sql语句
		$sql="select area_id,area_name from bi_area where pid=0";
		//执行查询
		$province=$model->query($sql);
		//接收json
		$result=json_encode($province);
		//获取变量
		$callback=$_GET["callback"];
		//返回数据
		echo $callback."($result)";
		
		//$this->ajaxReturn($province,'json');
		
	}
	//获取市级
	public function getAllCity(){		
		$model = new Model();
		
		$city_id=$_GET['city'];
		//sql语句
		$sql="select area_id,area_name from bi_area where pid='$city_id'";
		//执行查询
		$city=$model->query($sql);
		//接收json
		$result=json_encode($city);
		//获取变量
		$callback=$_GET["callback"];
		//返回数据
		echo $callback."($result)";
		//$this->ajaxReturn($city,'json');
	}
	//根据省市和渠道类型查询数据s
	public function getAllchannel(){
		$model = new Model();
		//每页几条
		$perpage=$_GET['perpage'];
		//当前页数
		$nowindex=($_GET['nowindex']-1)*$perpage;
		$province=$_GET['province'];
		$city=$_GET['city'];
		$first_type=$_GET['first_type'];
		$second_type=$_GET['second_type'];
		$where =" where a.isDelete = 0 ";
		if(!empty($province) && ('all' != $province))
		{
			if(!empty($city) && ('all' != $city))
			{	
				$where .= " and b.province_id=$province and b.city_id=$city ";
			}
			else
			{
				$where .= " and b.province_id=$province ";
			}
		}
			
		if(!empty($first_type) && ('all' !=$first_type))
		{
			if(!empty($second_type) && ('all'!=$second_type) )
			{	
				$where .= " and d.channel_type_id='$second_type'";
			}
			else
			{
				$where .= " and (d.channel_type_id='$first_type' or d.channel_type_father_id='$first_type')";
			}
		}
		
		//sql语句
		$sql=" select a.device_id,b.channel_name,d.channel_type_name,e.agent_name,b.channel_address from qd_device a LEFT JOIN qd_channel b on b.channel_id=a.channel_id LEFT JOIN qd_channel_type_link c on b.channel_id=c.channel_id LEFT JOIN qd_channel_type d on c.channel_type_id=d.channel_type_id LEFT JOIN qd_agent e on e.agent_id=b.agent_id  $where  ORDER BY a.device_id  LIMIT $nowindex,$perpage  ";
		//执行查询
		$channel=$model->query($sql);
		//sql语句
		$countSql=" select count(*) pagCount from qd_device a LEFT JOIN qd_channel b on b.channel_id=a.channel_id LEFT JOIN qd_channel_type_link c on b.channel_id=c.channel_id LEFT JOIN qd_channel_type d on c.channel_type_id=d.channel_type_id LEFT JOIN qd_agent e on e.agent_id=b.agent_id  $where ";
		//执行查询，总条数
		$total=$model->query($countSql);
				
		$arr=array('total'=>$total[0]['pagCount'],'channel'=>$channel);
		//接收json
		$result=json_encode($arr);
		//获取变量
		$callback=$_GET["callback"];
		//返回数据
		echo $callback."($result)";
		/*if($arr['total']){
			echo $callback."($result)";
		}else{
			echo "false";	
		}
		*/
			
	}


}
?>