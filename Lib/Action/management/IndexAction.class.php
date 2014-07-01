<?php
import ( "@.MyClass.Spreadsheet_Excel_Reader" );
class IndexAction extends Action {
	private $uploaded_url = "Runtime/Temp";
	public $uid = 0;
	//区域顶级父id值
	public $top_pid = 0;
	function __construct(){
		parent::__construct();
		//获取用户信息
		$userinfo = getUserInfo();
		//var_dump( $userinfo);exit;
		$this->uid = $userinfo['uid'];
		//获取可查看菜单路径
		$this->assign('urlStr', $userinfo['urlstr']);
		$this->assign('username', $userinfo['realname']);
	}
	
	/**
	 * importingApp展示刊例维护
	 * @param 
	 * @return mixed
	 */
	function importingApp() {
		//var_dump($url_str);exit;
		$appRule = new Model ( "AppRule" );
		if ($_POST ['add_udp'] == "1") { //新增
			$rule_no = $_POST['rule_no'];
			//$rule_no = $_POST['issue_sel'];
			//上传文件名由当前时间戳及扩展名组成
			$fileName = time().".".end(explode('.', $_FILES["app_file"]["name"]));
			//上传文件
			move_uploaded_file($_FILES["app_file"]["tmp_name"], "$this->uploaded_url/$fileName");
			$this->redirect('Index/doImporting', array('fileName' => $fileName,'nowPageNum'=>0,'nowLineNum'=>1,'rule_no'=>$rule_no), 0);
		}else if($_POST ['add_udp'] == "2") { //编辑
			$old_rule_no = $_POST['old_rule_no'];
			$rule_no = $_POST['rule_no'];
			//如果需要重新提交excel
			if($_FILES["app_file"]["name"]){
				//echo 2345235;exit;
				$appRule->query("DELETE FROM app_rule WHERE rule_no = '$old_rule_no'");
				$fileName = time().".".end(explode('.', $_FILES["app_file"]["name"]));
				//上传文件
				move_uploaded_file($_FILES["app_file"]["tmp_name"], "$this->uploaded_url/$fileName");
				$this->redirect('Index/doImporting', array('fileName' => $fileName,'nowPageNum'=>0,'nowLineNum'=>1,'rule_no'=>$rule_no), 0);
			}else {//如果没有重新提交文件
				$data = null;
				$data['rule_no'] = $rule_no;
				$que = $appRule->where("rule_no = '$old_rule_no'")->save($data);
			}
		}else if($_POST ['delete'] == "1"){ //删除
			$del_rule_no = $_POST['del_rule_no'];
			$appRule->query("DELETE FROM app_rule WHERE rule_no = '$del_rule_no'");
		}
		
		
		//查询
		$where = " where 1 ";
		if($_POST['rule_no_sel']){
			$rule_no_sel = $_POST['rule_no_sel'];
			$where .= " and a.rule_no = '$rule_no_sel' ";
		}
		if($_POST['createuser_sel']){
			$createuser_sel = $_POST['createuser_sel'];
			$str = "select uid from bi_user where realname like '%$createuser_sel%'";
			$que = $appRule->query($str);
			$createuserid = $que[0]['uid'];
			$where .= " and a.createuserid = '$createuserid' ";
		}
		if($_POST['createtime_sel']){
			$createtime_sel = strtotime($_POST['createtime_sel']);;
			$where .= " and a.createtime = '$createtime_sel' ";
		}
		
		$sel = " select a.*,b.realname from app_rule a
		left join bi_user b on a.createuserid = b.uid
		$where and a.rule_status = 0 group by a.rule_no order by a.createtime";
		$que = $appRule->query($sel);
		foreach ($que as $k=>$v){
			$que[$k]['createtime'] = date("Y-m-d",$v['createtime']);
		}
		
		$this->assign('issueArr', $que);
		//供菜单给当前页面加样式
		$this->assign('nowUrl', "management/Index/importingApp");
		$this->display(':index');
		
	}
	
	//执行导入app期刊
	function doImporting($fileName,$nowPageNum,$nowLineNum,$rule_no){
		//信息创建时间
		$createtime = strtotime(date("Y-m-d"));
		//刊例状态，起始为0
		$rule_status = 0;
		ini_set("max_execution_time", "1800");
		$this->show ( '正在执行导入...<br/>', 'utf-8' );
		$rollback = 0; //判断回滚
		$wrongMessage = '';
		$appRule = new Model ( "AppRule" );
		$appRule->startTrans();
		$excel_data	 = new Spreadsheet_Excel_Reader (); // 实例化一个读取excel对象
		$excel_data->setOutputEncoding ( 'utf-8' ); // 赋编码格式
		//读取文件
		$excel_data->read ("./$this->uploaded_url/$fileName");
		// 在终端机每页显示多少个
		$one_page_app_nums = 20;
		//循环解析
		for($pageNum = $nowPageNum;$pageNum<count($excel_data->sheets);$pageNum++){
			$page = $several = 1;		// 在第几页第几条
			if($pageNum == 0) {
				/*
				// 获取投放代理商, 并验证是否存在该代理商
				$agentname = $excel_data->sheets[0]['cells'][3][1];
				$agentname = trim(preg_replace('/代理商[：|:]/', '', $agentname));
				if ($agentname) {
					$agentid = getAgents(0, $agentname);
					if (!$agentid) {
						echo '<font style="color:red">',C('no_have_agent')," $agentname",'</font>';exit;
					}
				} else {
					$agentname = null;
				}
				*/
				continue;//跳过第一页
			}
			//超过三页暂不保存，
			if($pageNum>3) continue;
			// 计算所属分类
			$app_type = 0;
			switch ($pageNum) {
				case 1 : $app_type = 3; break;
				case 2 : $app_type = 4; break;
				case 3 : $app_type = 5; break;
				//case 4 : $app_type = 1; break;//第四页以后算未知分类，1也不再做默认，算未知分类
			}
	
			for($lineNum = $nowLineNum; $lineNum <= $excel_data->sheets [$pageNum] ['numRows']; $lineNum ++) {
				if($lineNum == 1) continue;//跳过每页第一行
				//导入IOS部分数据(2,3列)
				$appid_ios   = $excel_data->sheets[$pageNum]['cells'][$lineNum][2]; // 第一页，第$lineNum行，第2列
				$appname_ios = $excel_data->sheets[$pageNum]['cells'][$lineNum][3];
				//导入安卓部分数据(4,5列)
				$appid_android   = $excel_data->sheets[$pageNum]['cells'][$lineNum][4]; // 第一页，第$lineNum行，第2列
				$appname_android = $excel_data->sheets[$pageNum]['cells'][$lineNum][5];

				if(trim($appid_ios)){
					$que = $appRule->add ( array (
							'rule_no'   => $rule_no,
							'app_id'    => $appid_ios.'-ios',
							'app_name'  => $appname_ios,
							'system'    => 'ios',
							'app_type'  => $app_type,
							'numa'		=> $page,
							'numb'	    => $several,
							'createuserid'=>$this->uid,
							'createtime'=>$createtime,
							'rule_status'=>$rule_status
					) );echo $appRule->getlastsql(),"<br />\n";
					if(!$que) {$rollback++;$wrongMessage = "serialAppIssue添加错误appid：$appid_ios";}
				}
				if(trim($appid_android)){
					$que = $appRule->add ( array (
							'rule_no'   => $rule_no,
							'app_id'    => $appid_android.'-android',
							'app_name'  => $appname_android,
							'system'    => 'android',
							'app_type'  => $app_type,
							'numa'		=> $page,
							'numb'      => $several,
							'createuserid'=>$this->uid,
							'createtime'=>$createtime,
							'rule_status'=>$rule_status
					) );echo $appRule->getlastsql(),"<br />\n";
					if(!$que) {$rollback++;$wrongMessage = "serialAppIssue添加错误appid：$appid_android";}
				}
	
				if ($several == $one_page_app_nums) {
					$page++;
					$several = 1;
				} else {
					$several++;
				}
			}
				
		}
		//判断回滚
		if($rollback){
			$appRule->rollback();
			$this->show("<script type='text/javascript'>window.setTimeout('show()',6000);\n alert('导入失败，请检查导入文件，$wrongMessage');\n window.location.href='".U('Index/importingApp')."';</script>", 'utf-8' );
		}else{
			$appRule->commit();
			$this->show("<script type='text/javascript'>window.setTimeout('show()',6000);\n alert('导入成功');\n window.location.href='".U('Index/importingApp')."';</script>", 'utf-8' );
		}
	}
	
	
	
	//展示刊例发布
	function addRuleTarget(){
		$ruleSend = new Model ( "RuleSend" );
		if ($_POST ['add_udp'] == "1") { //新增
			$rule_no    = $_POST['rule_no'];
			$start_time = strtotime($_POST['start_time']);
			$target_num = $_POST['target_num'];
			$que = $ruleSend->add ( array (
					'rule_no'   => $rule_no,
					'target_num'    => $target_num,
					'start_time'  => $start_time,
					'createuserid'  => $this->uid,
					'rule_status'		=> 1,
					'createtime'		=> time()
			) );
			//echo $ruleSend->getLastSql();exit;
		}else if($_POST ['add_udp'] == "2"){ //编辑
			$send_id    = $_POST['send_id'];
			$rule_no    = $_POST['rule_no'];
			$start_time = strtotime($_POST['start_time']);
			$target_num = $_POST['target_num'];
			
			$data = null;
			$data['rule_no'] = $rule_no;
			$data['start_time'] = $start_time;
			$data['target_num'] = $target_num;
			$que = $ruleSend->where("id = '$send_id'")->save($data);
		}else if($_POST ['del_fb_zf'] == "1"){//删除
			$send_id    = $_POST['change_send_id'];
			$ruleSend->query("DELETE FROM rule_send WHERE id = '$send_id'");
		}else if($_POST ['del_fb_zf'] == "2"){//发布
			$send_id    = $_POST['change_send_id'];
			$data = null;
			$data['rule_status'] = 2;
			$data['release_time'] = time();
			$que = $ruleSend->where("id = '$send_id'")->save($data);
		}else if($_POST ['del_fb_zf'] == "3"){//作废
			$send_id    = $_POST['change_send_id'];
			$data = null;
			$data['rule_status'] = 3;
			$que = $ruleSend->where("id = '$send_id'")->save($data);
		}
		
		$where = " where 1 ";
		if($_POST['rule_no_sel']){
			$rule_no_sel = $_POST['rule_no_sel'];
			$where .= " and rule_no = '$rule_no_sel' ";
		}
		
		if($_POST['createuser_sel']){
			$createuser_sel = $_POST['createuser_sel'];
			$str = "select uid from bi_user where realname like '%$createuser_sel%'";
			$que = $ruleSend->query($str);
			$createuserid = $que[0]['uid'];
			$where .= " and createuserid = '$createuserid' ";
		}
		
		
		if($_POST['release_time_sel']){
			$release_time_sel = strtotime($_POST['release_time_sel']);;
			$where .= " and release_time = '$release_time_sel' ";
		}
		$sel = " select * from rule_send $where order by release_time desc";
		$que = $ruleSend->query($sel);
		foreach ($que as $k=>$v){
			$que[$k]['createtime'] = date("Y-m-d",$v['createtime']);
			$que[$k]['release_time'] = $v['release_time']?date("Y-m-d",$v['release_time']):"";
			$que[$k]['start_time'] = date("Y-m-d",$v['start_time']);
		}
		$this->assign('issueArr', $que);
		//供菜单给当前页面加样式
		$this->assign('nowUrl', "management/Index/addRuleTarget");
		$this->display(':addRuleTarget');
	}
	
	
	function verup(){
		//echo 4353246;
		//供菜单给当前页面加样式
		$this->assign('nowUrl', "management/Index/verup");
		$this->display(':verup');
	}

	//自动补全对应函数	
	function getAppRule(){
		$model = new Model();
		$appNameList = array();
		//return 2354;
		//现在未过滤期刊号，所有期刊都算了
		$selStr = "
				SELECT rule_no FROM app_rule GROUP BY rule_no
		";
		//echo json_encode($selStr);exit;
		$list = $model->query($selStr);
		foreach($list as $val){
			$appNameList[] = $val['rule_no'];
		}
		
		$arr = array();
		foreach($appNameList as $appName){
			$arr[] = array('title'=>$appName);
		}
		echo json_encode($arr);
	}
	
	function app_info($rule_no){
		$model = new Model();
		$sel = "SELECT * FROM app_rule WHERE rule_no = '$rule_no' ORDER BY system";
		$que = $model->query($sel);
		$iosArr = array();
		$androidArr = array();
		foreach($que as $k=>$v){
			if($v['system'] == "ios"){
				$iosArr[] = $v;
			}
			if($v['system'] == "android"){
				$androidArr[] = $v;
			}
		}
		$this->assign('iosArr', $iosArr);
		$this->assign('androidArr', $androidArr);
		$this->display(':app_info');
	}
	
	
	public $que_channel;
	//获取所有省市渠道
	function getChannelArr(){
		$provinceIdArr = array();
		$cityIdArr = array();
		$cityArr = array();
		$areaIdStr = "";
		$model = new Model();
		
		$sql_channel = "
				SELECT a.channel_id area_id,a.channel_name area_name,b.city pid FROM qd_channel a
				LEFT JOIN qd_channel_area b ON a.channel_id = b.channel_id
				";
		$this->que_channel = $model->query($sql_channel);
		
		$sql_province = "SELECT * FROM qd_channel_area GROUP BY province";
		$que_province = $model->query($sql_province);
		foreach ($que_province as $k=>$v){
			$sql_province_id = "SELECT * FROM bi_area WHERE area_name LIKE '%$v[province]%' OR CONCAT(area_name,'省') LIKE '$v[province]'";
			$que_province_id = $model->query($sql_province_id);
			$provinceIdArr[] = $que_province_id[0]['area_id'];
		}
		
		$sql_city = "SELECT * FROM qd_channel_area GROUP BY city";
		$que_city = $model->query($sql_city);
		foreach ($que_city as $k=>$v){
			$sql_city_id = "SELECT * FROM bi_area WHERE area_name LIKE '%$v[city]%' OR CONCAT(area_name,'市') LIKE '$v[city]'";
			$que_city_id = $model->query($sql_city_id);
			$cityIdArr[] = $que_city_id[0]['area_id'];
			
			foreach ($que_channel as $ck=>$cv){
				if($cv['pid'] == $v['city']){
					$que_channel[$ck]['pid'] = $que_city_id[0]['area_id'];
				}
			}
			
		}
		
		$areaIdArr = array_merge($provinceIdArr,$cityIdArr);
		
		$areaIdStr = implode(",",$areaIdArr);
		$sql_area = "
				SELECT * FROM bi_area WHERE area_id IN ($areaIdStr)
				";
		$que_area = $model->query($sql_area);
		
		//$que = array_merge($que_area,$que_channel);
		
		$this->getProvinceCity($que_area, $this->top_pid);
		
		echo json_encode($this->areaArr);
	}
	
	public $areaArr = array();
	public $lv;
	//沥遍排序获取区域数组
	function getProvinceCity($arr,$parentId){
		//同父级区域的数量
		$length = 0;
		foreach($arr as $k=>$v){
			if($v['pid'] == $parentId){
				$length++;
				//当前等级
				$this->lv++;
				$this->areaArr[count($this->areaArr)]['value'] = $v['area_name'];
				//自身等级+id
				$this->areaArr[count($this->areaArr)-1]['id'] = $this->lv."-".$v['area_id'];
				//父级等级+id如果是省级则父级为$this->top_pid) 即0
				$parentLvId = "";
				if($parentId == $this->top_pid){//如果父id为0
					$parentLvId = "0";
				}else{
					$parentLvId = ($this->lv-1)."-".$parentId;
				}
				$this->areaArr[count($this->areaArr)-1]['pid'] = $parentLvId;
				$this->areaArr[count($this->areaArr)-1]['small_pid'] = $parentId;
				
				foreach ($this->que_channel as $ck=>$cv){
					if($v['area_name']."市" == $cv['pid']){
						$this->areaArr[count($this->areaArr)]['value'] = $cv['area_name'];
						$this->areaArr[count($this->areaArr)-1]['id'] = "3-".$v['area_id'];
						$this->areaArr[count($this->areaArr)-1]['pid'] = "2-".$v['area_id'];
						$this->areaArr[count($this->areaArr)-1]['small_pid'] = $v['area_id'];
					}
				}
				
				
				
				
				
				$this->getProvinceCity($arr, $v['area_id']);
			}
			
		}
		/*
		//赋同父级区域的数量
		foreach ($this->areaArr as $k=>$v){
			//因为从沥遍的函数返回已经减1，这里的$this->lv为父级的等级
			if($v['small_pid'] == $parentId){
				$this->areaArr[$k]['length'] = $length;
			}
		}
		*/
		$this->lv--;
	}
	
	
}