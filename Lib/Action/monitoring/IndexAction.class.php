<?php
import ( "@.MyClass.Page" ); // 导入分页类
import ( "@.MyClass.Common" ); // 导入公共类
class IndexAction extends Action {
	private $userinfo = null;
	// 当前代理商及下属所有子代理商id列表
	public $agentIdStr = "";
	// 最新更新批号
	private $monitor_no;
	function __construct() {
		parent::__construct ();
		// 设置网页等待时间无限
		set_time_limit ( 0 );
		$model = new Model ();
		// 获取用户信息
		$this->userinfo = getUserInfo ();
		if ($this->userinfo ['orgid']) {
			// 获取当前登录代理商及下属所有子代理商
			$common = new Common ();
			$this->agentIdStr = $common->getAgentIdAndChildId ( $this->userinfo ['orgid'] );
		}
		
		// 获取最近通信保存批号
		$monitorNoSql = "SELECT MAX(monitor_no) monitor_no FROM dev_monitor";
		$monitorNoQue = $model->query ( $monitorNoSql );
		$this->monitor_no = $monitorNoQue [0] ['monitor_no'];
		
		// 获取可查看菜单路径
		$this->assign ( 'urlStr', $this->userinfo ['urlstr'] );
		$this->assign ( 'username', $this->userinfo ['realname'] );
	}
	
	/**
	 * station监控平台
	 * 
	 * @param        	
	 *
	 * @return mixed
	 */
	function station() {
		// 每页显示数量
		$showNum = 5;
		// 当前页数
		$pageNum     = $_REQUEST ['pageNum'] ? $_REQUEST ['pageNum'] : 1;
		// 显示的类型，0显示有问题机器，1显示正常机器，2显示未知机器
		$showModel   = $_REQUEST ['showModel'] ? $_REQUEST ['showModel'] : 0;
		// 公共查询部分
		$channelName = trim ( $_REQUEST ['channelName'] );
		$place_name  = trim ( $_REQUEST ['place_name'] );
		$device_no   = trim ( $_REQUEST ['device_no'] );
		// 地区等级0全国，1省级，2市级
		$level       = $_REQUEST ['level'];
		// 选中的地区id
		$areaId      = $_REQUEST ['areaId'];
		// 无返回或无开机时间查询部分
		$address     = trim ( $_REQUEST ['address'] );
		$devMac      = trim ( $_REQUEST ['devMac'] );
		$devNo       = trim ( $_REQUEST ['devNo'] );
		// 判断显示未设开机时间还是未找到记录
		$devNoBeginTime = trim ( $_REQUEST ['devNoBeginTime'] );

		// 要显示的内容
		$showDevPageArr = array ();
		// 要显示的数量
		$showDevNum     = 0;
		
		$model = new Model();
		// 最近一次是否全部没有问题
		$allOkSql = "select all_ok from dev_monitor where monitor_no = " . $this->monitor_no;
		$allOkQue = $model->query ( $allOkSql );
		$all_ok   = $allOkQue [0] ['all_ok'];
		
		// 分页起始条数和结束条数
		$beginNum = ($pageNum - 1) * $showNum;
		$endNum   = $pageNum * $showNum - 1;
		
		if ($all_ok == 0) {
			//查找所有有问题的机器
			$wrongDevArr = $this->getWrongDevArr($channelName, $place_name, $device_no, $level, $areaId, $address, $devMac, $devNo, $devNoBeginTime, $beginNum, $endNum);
		}
		//查找所有无问题的机器
		$rightDevArr = $this->getNotInDevArr($channelName, $place_name, $device_no, $level, $areaId,$wrongDevArr['badDevNoStr'],$beginNum,$endNum);
		
		switch ($showModel) {
			case 0 :
				$showDevPageArr = $wrongDevArr['onLine']['page'];
				$showDevNum     = $wrongDevArr['onLine']['num'];
				break;
			case 1 :
				$showDevPageArr = $rightDevArr['page'];
				$showDevNum     = $rightDevArr['num'];
				break;
			case 2 :
				if($devNoBeginTime == 1){
					$showDevPageArr = $wrongDevArr['unfind']['page'];
					$showDevNum     = $wrongDevArr['unfind']['num'];
				}else if($devNoBeginTime ==2){
					$showDevPageArr = $wrongDevArr['noTime']['page'];
					$showDevNum     = $wrongDevArr['noTime']['num'];
				}
				break;
		}
		// 总页数
		$countPageNum = $showDevNum % $showNum ? ( int ) ($showDevNum / $showNum) + 1 : $showDevNum / $showNum;
		
		$this->assign ( 'devBreakNum', $wrongDevArr['onLine']['num'] );
		$this->assign ( 'devRightNum', $rightDevArr['num'] );
		$this->assign ( 'devUnfindNum', $wrongDevArr['unfind']['num'] + $wrongDevArr['noTime']['num'] );
		$this->assign ( 'showDevPageArr', $showDevPageArr );
		
		// 分页
		$this->assign ( 'pageNum', $pageNum );
		$this->assign ( 'countPageNum', $countPageNum );
		// 地域
		$this->assign ( 'areaId', $areaId );
		$this->assign ( 'level', $level );
		
		$this->assign ( 'showModel', $showModel );
		$this->assign ( 'channelName', $channelName );
		$this->assign ( 'place_name', $place_name );
		$this->assign ( 'address', $address );
		$this->assign ( 'devMac', $devMac );
		$this->assign ( 'devNo', $devNo );
		$this->assign ( 'device_no', $device_no );
		
		if ($showModel == 2) {
			$date ['showDevPageArr'] = $showDevPageArr;
			$date ['pageNum'] = $pageNum;
			$date ['countPageNum'] = $countPageNum;
			$date ['showDevNum'] = $showDevNum;
			$date ['channelName'] = $channelName;
			$date ['place_name'] = $place_name;
			$date ['address'] = $address;
			$date ['devMac'] = $devMac;
			$date ['devNo'] = $devNo;
			$date ['devNoBeginTime'] = $devNoBeginTime;
			echo json_encode ( $date );
		} else {
			$this->assign ( 'nowUrl', "'/gas_station_erp/index.php/monitoring/Index/station'" );
			$this->display ( ':station_index' );
		}
	}
	// ajax获取省市信息
	function getProvinceCity() {
		$model = new Model ();
		$showModel = $_REQUEST ['showModel'] ? $_REQUEST ['showModel'] : 0;
		$dev_count_arr = $this->getRightOrWrongNum ( $showModel );
		// echo json_encode($dev_count_arr);exit;
		$common = new Common ();
		// 获取有权限查看的地区id
		$ableAreaIdStr = $common->getAreaIdAndProvinceStr ( $this->userinfo ['orgid'] );
		$where .= " where area_id IN ($ableAreaIdStr) ";
		$sql = "
			SELECT area_id,area_name,pid,level,0 count
			FROM bi_area a
			$where
		";
		$que = $model->query ( $sql );
		// 为省叠加数量
		foreach ( $que as $k => $v ) {
			foreach ( $dev_count_arr as $countK => $countV ) {
				if ($countV ['province_id'] == $v ['area_id'] || $countV ['city_id'] == $v ['area_id']) {
					$que [$k] ['count'] += $countV ['count'];
				}
			}
			$que [$k] ['area_name'] .= "(" . $que [$k] ['count'] . ")";
		}
		// 如果存在省级则加上全国
		if (! $this->userinfo ['orgid'] || $this->userinfo ['orgid'] == 1) {
			$que [] = array (
					'area_id' => 0,
					'area_name' => '全国',
					'pid' => 0,
					'level' => 0 
			);
		}
		echo json_encode ( $que );
	}
	// 根据区域获取正常或有问题机器数量
	function getRightOrWrongNum($showModel) {
		$model = new Model ();
		$sql = "";
		$and = "";
		if ($this->agentIdStr) {
			$and .= " AND b.agent_id in (" . $this->agentIdStr . ") ";
		}
		if ($showModel == 0) {
			$sql = "
				SELECT b.province_id, b.city_id,COUNT(*) count
				FROM dev_monitor a
				LEFT JOIN qd_device b ON a.dev_no = b.device_no
				WHERE
				a.monitor_no = " . $this->monitor_no . "
				AND a.unfind <> 1 AND a.dev_no_begin_time <>1
				AND b.isDelete = 0
				$and
				GROUP BY b.province_id,b.city_id
				ORDER BY b.province_id,b.city_id
			";
		} else if ($showModel == 1) {
			$sql = "
				SELECT b.province_id, b.city_id, COUNT(*) count
				FROM qd_device b
				WHERE b.device_no NOT IN(SELECT dev_no FROM dev_monitor WHERE monitor_no = " . $this->monitor_no . ")
				AND b.isDelete = 0
				$and
				GROUP BY b.province_id,b.city_id
				ORDER BY b.province_id,b.city_id
			";
		}
		// echo $sql;exit;
		$que = $model->query ( $sql );
		return $que;
	}
	//根据查询条件分类返回有问题机器相关数据
	function getWrongDevArr($channelName, $place_name, $device_no, $level, $areaId, $address, $devMac, $devNo, $devNoBeginTime, $beginNum = 0, $endNum = 0) {
		$and = " and b.isDelete = 0 ";
		$andNoTimeOrUnfind = "";
		// 公共查询部分
		if ($channelName) {
			$and .= " AND channel_name = '$channelName' ";
		}
		if ($place_name) {
			$and .= " AND place_name = '$place_name' ";
		}
		if ($device_no) {
			$and .= " AND b.device_no = '$device_no' ";
		}
		if ($this->agentIdStr) {
			$and .= " AND e.agent_id in (" . $this->agentIdStr . ") ";
		}
		// $level地区等级0全国，1省级，2市级
		// $areaId选中的地区id
		if ($areaId) {
			if ($level == 1) {
				$and .= " AND b.province_id = $areaId ";
			} else if ($level == 2) {
				$and .= " AND b.city_id = $areaId ";
			}
		}
		
		// 无返回或无开机时间查询部分
		if ($address) {
			$andNoTimeOrUnfind .= " AND b.address = '$address' ";
		}
		if ($devMac) {
			$andNoTimeOrUnfind .= " AND a.dev_mac = '$devMac' ";
		}
		if ($devNo) {
			$andNoTimeOrUnfind .= " AND a.dev_no = '$devNo' ";
		}
		// $devNoBeginTime判断显示未设开机时间还是未找到记录
		// 查找未找到数据的机器
		if ($devNoBeginTime == 1) {
			$andNoTimeOrUnfind .= " and a.unfind = 1";
		// 查找未设开机时间的机器
		} else if ($devNoBeginTime == 2) {
			$andNoTimeOrUnfind .= " and a.dev_no_begin_time = 1";
		}
		
		$model = new Model ();
		
		// 最近一次所有有问题机器
		$allBreakSql = "
				SELECT a.dev_mac,a.dev_no,a.on_line,
				IF(a.start_time<>0,FROM_UNIXTIME(a.start_time, '%Y-%m-%d %H:%i:%s' ),'') start_time,
				IF(a.shutdown_time<>0,FROM_UNIXTIME(a.shutdown_time, '%Y-%m-%d %H:%i:%s' ),'') shutdown_time,
				a.unfind,a.dev_no_begin_time,
				FROM_UNIXTIME(a.wrong_begin_time, '%Y-%m-%d %H:%i:%s' ) wrong_begin_time,a.monitor_no,a.createtime,a.all_ok,
				CONCAT(FLOOR((UNIX_TIMESTAMP() - a.wrong_begin_time)/3600),'小时',FLOOR(((UNIX_TIMESTAMP() - a.wrong_begin_time)%3600)/60)) continueTime,
				f.area_name province,g.area_name city,b.address,c.place_name,d.channel_name
				FROM dev_monitor a
				LEFT JOIN qd_device b ON a.dev_no = b.device_no
				LEFT JOIN qd_place c ON b.place_id = c.place_id
				LEFT JOIN qd_channel d ON b.channel_id = d.channel_id
				LEFT JOIN qd_agent e ON b.agent_id = e.agent_id
				LEFT JOIN bi_area f ON b.province_id = f.area_id
				LEFT JOIN bi_area g ON b.city_id = g.area_id
				WHERE monitor_no = " . $this->monitor_no . " $and $andNoTimeOrUnfind
				ORDER BY a.wrong_begin_time
				";
		// echo $allBreakSql;exit;
		$allBreakQue = $model->query ( $allBreakSql );
		
		
		// 硬件有问题机器数组
		$devBreakArr = array ();
		// 硬件有问题数组的索引，沥遍完既是硬件数量，其他选择要另设变量以做索引
		$devBreakNum = 0;
		// 根据分页获取相应硬件有问题数组
		$devPageBreakArr = array ();
		
		// 未获取到信息的机器数组
		$devUnfindArr = array ();
		// 未获取信息机器数组的索引，沥遍完既是硬件数量，其他选择要另设变量以做索引
		$devUnfindNum = 0;
		// 根据分页获取相应硬件数组
		$devPageUnfindArr = array ();
		
		// 未设开机时间的机器数组
		$devNoBeginTimeArr = array ();
		// 未设开机时间机器数组的索引，沥遍完既是硬件数量，其他选择要另设变量以做索引
		$devNoBeginTimeNum = 0;
		// 根据分页获取相应硬件数组
		$devPageNoBeginTimeArr = array ();
		
		//分拆放入各问题数组
		foreach ( $allBreakQue as $k => $v ) {
			// 机器有问题
			$badDevNoStr .= "'" . $v ['dev_no'] . "',";
			if ($v ['on_line'] == 1) {
				//该问题总数组
				$devBreakArr [$devBreakNum] = $v;
				//该问题当前页显示数组
				if ($devBreakNum >= $beginNum && $devBreakNum <= $endNum) {
					$devPageBreakArr [] = $v;
				}
				$devBreakNum ++;
			}
			// 机器未返回数据
			if ($v ['unfind'] == 1) {
				$devUnfindArr [$devUnfindNum] = $v;
				if ($devUnfindNum >= $beginNum && $devUnfindNum <= $endNum) {
					$devPageUnfindArr [] = $v;
				}
				$devUnfindNum ++;
			}
			
			// 机器未设开机时间
			if ($v ['dev_no_begin_time'] == 1) {
				$devNoBeginTimeArr [$devNoBeginTimeNum] = $v;
				if ($devNoBeginTimeNum >= $beginNum && $devNoBeginTimeNum <= $endNum) {
					$devPageNoBeginTimeArr [] = $v;
				}
				$devNoBeginTimeNum ++;
			}
			
		}
		$badDevNoStr = trim ( $badDevNoStr, ',' );
		$arr['badDevNoStr']     = $badDevNoStr;
		
		$arr['onLine']['count'] = $devBreakArr;
		$arr['onLine']['page']  = $devPageBreakArr;
		$arr['onLine']['num']   = $devBreakNum;
		
		$arr['unfind']['count'] = $devUnfindArr;
		$arr['unfind']['page']  = $devPageUnfindArr;
		$arr['unfind']['num']   = $devUnfindNum;
		
		$arr['noTime']['count'] = $devNoBeginTimeArr;
		$arr['noTime']['page']  = $devPageNoBeginTimeArr;
		$arr['noTime']['num']   = $devNoBeginTimeNum;
		
		return $arr;
	}
	
	//根据条件，获取在指定机器编码之外的机器信息
	function getNotInDevArr($channelName, $place_name, $device_no, $level, $areaId,$badDevNoStr,$beginNum = 0,$endNum = 0){
		$and = " and b.isDelete = 0 ";
		// 公共查询部分
		if ($channelName) {
			$and .= " AND channel_name = '$channelName' ";
		}
		if ($place_name) {
			$and .= " AND place_name = '$place_name' ";
		}
		if ($device_no) {
			$and .= " AND b.device_no = '$device_no' ";
		}
		if ($this->agentIdStr) {
			$and .= " AND e.agent_id in (" . $this->agentIdStr . ") ";
		}
		// $level地区等级0全国，1省级，2市级
		// $areaId选中的地区id
		if ($areaId) {
			if ($level == 1) {
				$and .= " AND b.province_id = $areaId ";
			} else if ($level == 2) {
				$and .= " AND b.city_id = $areaId ";
			}
		}
		$whereRightDev .= $badDevNoStr ? " where 1 and device_no NOT IN ($badDevNoStr) " : ' where 1 ';
		
		$model = new Model();
		// 查找所有无问题机器
		$sqlRightDev = "
			SELECT b.MAC dev_mac, b.device_no dev_no, f.area_name province, g.area_name city,b.address,
			0 continueTime,0 wrong_begin_time,0 on_line,0 start_time,0 shutdown_time,
			c.place_name,d.channel_name
			FROM qd_device b
			LEFT JOIN qd_place c ON b.place_id = c.place_id
			LEFT JOIN qd_channel d ON b.channel_id = d.channel_id
			LEFT JOIN qd_agent e ON b.agent_id = e.agent_id
			LEFT JOIN bi_area f ON b.province_id = f.area_id
			LEFT JOIN bi_area g ON b.city_id = g.area_id
			$whereRightDev $and
			ORDER BY dev_mac,dev_no
		";
		// 指定编码外的机器数组
		$devRightArr = $model->query ( $sqlRightDev );
		// 总数
		$devRightNum = count ( $devRightArr );
		// 根据分页获取相应数组
		$devPageRightArr = array ();
		for($i = $beginNum; $i <= $endNum; $i ++) {
			if ($devRightArr [$i]) {
				$devPageRightArr [] = $devRightArr [$i];
			}
		}
		
		$arr['count'] = $devRightArr;
		$arr['page']  = $devPageRightArr;
		$arr['num']   = $devRightNum;
		return $arr;
	}
	/**
	 * monitorExport监控导出
	 *
	 * @param
	 *
	 * @return mixed
	 */
	function monitorExport(){
		// 显示的类型，0显示有问题机器，1显示正常机器，2显示未知机器
		$showModel   = $_REQUEST ['showModel'] ? $_REQUEST ['showModel'] : 0;
		// 公共查询部分
		$channelName = trim ( $_REQUEST ['channelName'] );
		$place_name  = trim ( $_REQUEST ['place_name'] );
		$device_no   = trim ( $_REQUEST ['device_no'] );
		// 地区等级0全国，1省级，2市级
		$level       = $_REQUEST ['level'];
		// 选中的地区id
		$areaId      = $_REQUEST ['areaId'];
		// 无返回或无开机时间查询部分
		$address     = trim ( $_REQUEST ['address'] );
		$devMac      = trim ( $_REQUEST ['devMac'] );
		$devNo       = trim ( $_REQUEST ['devNo'] );
		// 判断显示未设开机时间还是未找到记录
		$devNoBeginTime = trim ( $_REQUEST ['devNoBeginTime'] );
		
		
		
		$wrongDevArr = $this->getWrongDevArr($channelName, $place_name, $device_no, $level, $areaId, $address, $devMac, $devNo, $devNoBeginTime);
		//查找所有无问题的机器
		$rightDevArr = $this->getNotInDevArr($channelName, $place_name, $device_no, $level, $areaId,$wrongDevArr['badDevNoStr']);
		//根据导出需求添加不同标题
		$title = "";
		switch ($showModel) {
			case 0 :
				$export = $wrongDevArr['onLine']['count'];
				$title = "\t" . iconv("utf-8", "gbk", "报警时间") . "\t" . iconv("utf-8", "gbk", "报警时长") . "\t" . iconv("utf-8", "gbk", "最近一次开机时间");
				break;
			case 1 :
				$export = $rightDevArr['count'];
				break;
			case 2 :
				if($devNoBeginTime == 1){
					$export = $wrongDevArr['unfind']['count'];
				}else if($devNoBeginTime ==2){
					$export = $wrongDevArr['noTime']['count'];
				}
				break;
		}
		
		
		$fileName = date("Y-m-d~H-i").".xls";
		header("Content-Type:application/vnd.ms-excel;charset=gb2312");
		header("Content-Disposition: attachment; filename=" . $fileName);
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		
		
		echo  iconv("utf-8", "gbk", "省份") . "\t" . iconv("utf-8", "gbk", "城市") . "\t" . iconv("utf-8", "gbk", "渠道名称") . "\t" . iconv("utf-8", "gbk", "网点名称") . "\t" . iconv("utf-8", "gbk", "点位名称") . "\t" . iconv("utf-8", "gbk", "MAC") . "\t" . iconv("utf-8", "gbk", "加油站编号") . $title;
		foreach($export as $k=>$v){
			//根据导出需求添加不同内容
			if($showModel == 0){
				$content = "\t" . iconv("utf-8", "gbk", $v['wrong_begin_time']) . "\t" . iconv("utf-8", "gbk", $v['continueTime']) . "\t" . iconv("utf-8", "gbk", $v['start_time']);
			}
			echo "\n" . iconv("utf-8", "gbk", $v['province']) . "\t" . iconv("utf-8", "gbk", $v['city']) . "\t" . iconv("utf-8", "gbk", $v['channel_name']) . "\t" . iconv("utf-8", "gbk", $v['place_name']) . "\t" . iconv("utf-8", "gbk", $v['address']) . "\t" . iconv("utf-8", "gbk", $v['dev_mac']) . "\t" . iconv("utf-8", "gbk", $v['dev_no']) . $content;
		}
		
	}
	
	
	
	
	/**
	 * alert预警设置
	 * 
	 * @param        	
	 *
	 * @return mixed
	 */
	function alert() {
		$this->display ( ':alert_index' );
	}
	
	/**
	 * record异常记录
	 * 
	 * @param        	
	 *
	 * @return mixed
	 */
	function record() {
		$this->display ( ':record_index' );
	}
}