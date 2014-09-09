<?php
import ( "@.MyClass.Spreadsheet_Excel_Reader" );
import ( "@.Action.socket.SendDevAction" );
import( "@.MyClass.Page" );//导入分页类
import( "@.MyClass.Common" );//导入公共类
class IndexAction extends Action {
	private $uploaded_url = "Runtime/Temp";
	private $smartapp_uploaded_url    = "DevAppDownLoad/SmartApp/";
	private $videoplayer_uploaded_url = "DevAppDownLoad/VideoPlayer/";
	private $updateapp_uploaded_url   = "DevAppDownLoad/UpdateApp/";
	private $smartguard_uploaded_url  = "DevAppDownLoad/SmartGuard/";
	
	//当前代理商及下属所有子代理商id列表
	public $agentIdStr = "";

	//区域顶级父id值
	public $top_pid = 0;
	public $userinfo = null;
	function __construct(){
		parent::__construct();
		//设置网页等待时间无限
		set_time_limit ( 0 );
		//获取用户信息
		$this->userinfo = getUserInfo();
		
		//迭代出当前登录代理商及下属所有子代理商
		$model = new Model();
		if($this->userinfo['orgid']){
			$common = new Common();
			$this->agentIdStr = $common->getAgentIdAndChildId($this->userinfo['orgid']);
		}

		//获取可查看菜单路径
		$this->assign('urlStr', $this->userinfo['urlstr']);
		$this->assign('username', $this->userinfo['realname']);
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
			$sql = "SELECT COUNT(*) count FROM app_rule WHERE rule_no = '$rule_no'";
			$que = $appRule->query($sql);
			if($que[0]['count']){
				$this->redirect('Index/importingApp', array('cate_id'=>2), 3,' 已存在该期刊号~');
			}
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
			$where .= " and a.rule_no like '%$rule_no_sel%' ";
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
		
		//每页显示数量
		$page_show_number = C('page_show_number')?C('page_show_number'):10;
		
		$sel = " select a.*,b.realname from app_rule a
		left join bi_user b on a.createuserid = b.uid
		$where group by a.rule_no order by a.createtime desc";
		$que = $appRule->query($sel);
		$count = count($que);
		$Page  = new Page($count, $page_show_number);
		$show  = $Page->show();// 分页显示输出
		$sel .= " limit ".$Page->firstRow.','.$Page->listRows;
		$que = $appRule->query($sel);
		
		
		foreach ($que as $k=>$v){
			$que[$k]['createtime'] = date("Y-m-d",$v['createtime']);
		}
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('issueArr', $que);
		//供菜单给当前页面加样式
		$this->assign('nowUrl', "'/gas_station_erp/index.php/management/Index/importingApp'");
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
							'createuserid'=>$this->userinfo['uid'],
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
							'createuserid'=>$this->userinfo['uid'],
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
		$appRuleSend = new Model ( "AppRuleSend" );
		if ($_POST ['add_udp'] == "1") { //新增
			$rule_no    = $_POST['rule_no'];
			$start_time = strtotime($_POST['start_time']);
			$target_num = $_POST['target_num'];
			$que = $appRuleSend->add ( array (
					'rule_no'       => $rule_no,
					'target_num'    => $target_num,
					'start_time'    => $start_time,
					'createuserid'  => $this->userinfo['uid'],
					'rule_status'   => 1,
					'createtime'    => time()
			) );
			//echo $appRuleSend->getLastSql();exit;
		}else if($_POST ['add_udp'] == "2"){ //编辑
			$send_id    = $_POST['send_id'];
			$rule_no    = $_POST['rule_no'];
			$start_time = strtotime($_POST['start_time']);
			$target_num = $_POST['target_num'];
			//echo $target_num;exit;
			$data = null;
			$data['rule_no'] = $rule_no;
			$data['start_time'] = $start_time;
			$data['target_num'] = $target_num;
			$que = $appRuleSend->where("id = '$send_id'")->save($data);
		}else if($_POST ['del_fb_zf'] == "1"){//删除
			$send_id    = $_POST['change_send_id'];
			$appRuleSend->query("DELETE FROM app_rule_send WHERE id = '$send_id'");
		}else if($_POST ['del_fb_zf'] == "2"){//发布
			$send_id    = $_POST['change_send_id'];
			$data = null;
			$data['rule_status'] = 2;
			$data['release_time'] = strtotime(date("Y-m-d"));
			$que = $appRuleSend->where("id = '$send_id'")->save($data);
			
			$appRule = new Model ( "AppRule" );
			$rule_no = $_POST['rule_no_hid'];
			$data = null;
			$data['rule_status'] = 2;
			$appRule->where("rule_no = '$rule_no'")->save($data);
			//rule_status
		}else if($_POST ['del_fb_zf'] == "3"){//作废
			$send_id    = $_POST['change_send_id'];
			$data = null;
			$data['rule_status'] = 3;
			$que = $appRuleSend->where("id = '$send_id'")->save($data);
		}
		
		
		
		//权限控制，只允许同代理商员工访问
		$userIdSql = "select uid from bi_user where orgid = ".$this->userinfo['orgid'];
		$userIdQue = $appRuleSend->query($userIdSql);
		$userIdStr = "";
		foreach ($userIdQue as $k=>$v){
			$userIdStr .= $v['uid'].",";
		}
		$userIdStr = rtrim($userIdStr,",");
		
		$where = " where 1";
		if($userIdStr){
			$where .= " and createuserid in ($userIdStr) ";
		}
		
		if($_POST['rule_no_sel']){
			$rule_no_sel = $_POST['rule_no_sel'];
			$where .= " and rule_no like '%$rule_no_sel%' ";
		}
		
		if($_POST['createuser_sel']){
			$createuser_sel = $_POST['createuser_sel'];
			$str = "select uid from bi_user where realname like '%$createuser_sel%'";
			$que = $appRuleSend->query($str);
			$createuserid = $que[0]['uid'];
			$where .= " and createuserid = '$createuserid' ";
		}
		
		
		if($_POST['release_time_sel']){
			$release_time_sel = strtotime($_POST['release_time_sel']);
			$where .= " and release_time = '$release_time_sel' ";
		}
		
		//每页显示数量
		$page_show_number = C('page_show_number')?C('page_show_number'):10;
		
		$sel = " select * from app_rule_send $where order by release_time desc";
		$que = $appRuleSend->query($sel);
		
		$count = count($que);
		$Page  = new Page($count, $page_show_number);
		$show  = $Page->show();// 分页显示输出
		$sel .= " limit ".$Page->firstRow.','.$Page->listRows;
		$que = $appRuleSend->query($sel);
		
		
		foreach ($que as $k=>$v){
			$que[$k]['createtime'] = date("Y-m-d",$v['createtime']);
			$que[$k]['release_time'] = $v['release_time']?date("Y-m-d",$v['release_time']):"";
			$que[$k]['start_time'] = date("Y-m-d",$v['start_time']);
		}
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('issueArr', $que);
		//供菜单给当前页面加样式
		$this->assign('nowUrl', "'/gas_station_erp/index.php/management/Index/addRuleTarget'");
		$this->display(':addRuleTarget');
	}
	
	
	
	
	
	/**
	 * verup版本升级列表
	 * @param
	 * @return mixed
	 */
	function verup(){//$this->userinfo['orgid'];
		$model = new Model();
		//权限控制，只允许同代理商员工访问
		$userIdSql = "select uid from bi_user where orgid = ".$this->userinfo['orgid'];
		$userIdQue = $model->query($userIdSql);
		$userIdStr = "";
		foreach ($userIdQue as $k=>$v){
			$userIdStr .= $v['uid'].",";
		}
		$userIdStr = rtrim($userIdStr,",");
		
		$where = " where 1";
		if($userIdStr){
			$where .= " and add_user_id in ($userIdStr) ";
		}
		if($_POST['smartApp']){
			$where .= " and smart_app = '$_POST[smartApp]' ";
		}
		if($_POST['videoPlayer']){
			$where .= " and video_player = '$_POST[videoPlayer]' ";
		}
		if($_POST['updateApp']){
			$where .= " and update_app = '$_POST[updateApp]' ";
		}
		if($_POST['smartGuard']){
			$where .= " and smart_guard = '$_POST[smartGuard]' ";
		}
		
		//每页显示数量
		$page_show_number = C('page_show_number')?C('page_show_number'):10;
		
		
		$sql = " select * from app_dev_update $where ";
		$que = $model->query($sql);
		$count = count($que);
		$Page  = new Page($count, $page_show_number);
		$show  = $Page->show();// 分页显示输出
		$sql .= " limit ".$Page->firstRow.','.$Page->listRows;
		$que = $model->query($sql);
		
		//沥遍改变时间格式
		foreach($que as $k=>$v){
			$v['status_date']?$que[$k]['status_date'] = date("Y-m-d",$v['status_date']):$que[$k]['status_date'] = "";
		}
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('app_dev_update_arr', $que);
		//供菜单给当前页面加样式
		$this->assign('nowUrl', "'/gas_station_erp/index.php/management/Index/verup'");
		$this->display(':verup');
	}
//------------------------------------------------------------------------------更新信息------------------------------------------------------------------------------------
	 function  verupUpda(){
	 	$model = new Model();
	
		
		$hy_province = trim($_REQUEST['select_province']);		
		$hy_city = trim($_REQUEST['select_city']);		
		$hy_place_name=trim($_REQUEST['yichang_place_name']);
		$hy_address=trim($_REQUEST['yichang_address']);
		$hy_devMac=trim($_REQUEST['yichang_devMac']);		
		$hy_select=trim($_REQUEST['channelselect']);
		$hy_id=trim($_REQUEST['select_id']);
		
		$where = "where d.update_id = $hy_id ";		
		/*
		$hy_select_up;
		
		if('更新成功'==$hy_select){
			$hy_select_up=1;
		}else if('更新失败'==$hy_select){
			$hy_select_up=2;
		}
		*/
		
		if(!empty($hy_province) && ('省份' != $hy_province))
		{
			if(!empty($hy_city) && ('地级市' != $hy_city))
			{
				$where .= "  and a.province_id='$hy_province' and a.city_id='$hy_city' ";
			}
			else
			{
				$where .= " and a.province_id='$hy_province' ";
			}
		}
		
		if(!empty($hy_place_name))
		{
			$where .= " and c.channel_name='$hy_place_name' ";
		}
		if(!empty($hy_address))
		{
			$where .= " and b.place_name='$hy_address'";
		}
		if(!empty($hy_devMac))
		{
			$where .= " and  d.dev_mac='$hy_devMac'";
		}
		if(!empty($hy_select) && ('更新成功'==$hy_select))
		{
			$where .= " and  d.smart_app= 1 ";
		}else if( !empty($hy_select) && '更新失败'==$hy_select) {
			$where .= " and  d.smart_app= 2 ";
		}
		
		$pag_sql="
			SELECT e.area_name province,f.area_name city,c.channel_name,b.place_name,a.device_no,d.dev_mac,d.smart_app,d.video_player,d.update_app,d.smart_guard
			FROM qd_device a 
			LEFT JOIN qd_place b  ON a.place_id=b.place_id
			LEFT JOIN qd_channel c ON b.channel_id=c.channel_id
			LEFT JOIN app_update_status d ON a.device_no=d.dev_no
			LEFT JOIN bi_area e ON a.province_id = e.area_id
			LEFT JOIN bi_area f ON a.city_id = f.area_id
			$where
		";
		$inrs=$model->query($pag_sql);
		foreach($inrs as $k=>$item){
			//smart_app
			if($item['smart_app']==1){
			   	$inrs[$k]['smart_app']="更新成功";
			}else if($item['smart_app']==2){
				$inrs[$k]['smart_app']="更新失败";
			}else {
				$inrs[$k]['smart_app']="等待中";
			}
			//video_player
			if($item['video_player']==1){
			   	$inrs[$k]['video_player']="更新成功";
			}else if($item['video_player']==2){
				$inrs[$k]['video_player']="更新失败";
			}else {
				$inrs[$k]['video_player']="等待中";
			}
			//update_app
			if($item['update_app']==1){
			   	$inrs[$k]['update_app']="更新成功";
			}else if($item['update_app']==2){
				$inrs[$k]['update_app']="更新失败";
			}else {
				$inrs[$k]['update_app']="等待中";
			}
			//smart_guard
			if($item['smart_guard']==1){
			   	$inrs[$k]['smart_guard']="更新成功";
			}else if($item['smart_guard']==2){
				$inrs[$k]['smart_guard']="更新失败";
			}else {
				$inrs[$k]['smart_guard']="等待中";
			}
		}
		//$this->assign('cou',$hy_count);
		echo json_encode($inrs);
		
}
		
		
	// 所属网点  ----------hm
	public function devicsswdblurry(){
	    $model = new Model();
		$yichang_address = trim(I('yichang_address'));
		$sql = "select * from qd_place where place_name like '%$yichang_address%'";
		$deviceInfo = $model->query($sql);
		for($i=0; $i< count($deviceInfo); $i++)
		{
			$sswd_text_arr[$i]['title'] = $deviceInfo[$i]['place_name'];
		}
		$this->ajaxReturn($sswd_text_arr,'json');
	}	
	
		
	/**
	 * verup_add_udp 版本升级添加，修改
	 * @param
	 * @return mixed
	 */
	function verup_add_udp(){
		$app_dev_update = new Model("AppDevUpdate");
		$smartAppNo     = $_POST['smartAppNo'];
		$videoPlayerNo  = $_POST['videoPlayerNo'];
		$updateAppNo    = $_POST['updateAppNo'];
		$smartGuardNo   = $_POST['smartGuardNo'];
		$target_num     = $_POST['target_num'];
		$updateId       = $_POST['updateId'];
		//echo $updateId;exit;

		$date = array();
		if($_FILES["smartApp"]['name']){
			$date['smart_app'] = $smartAppNo;
			$smart_app_downloaded = $this->smartapp_uploaded_url."$smartAppNo";
			$date['smart_app_downloaded'] = $smart_app_downloaded;
			//不存在则创建
			if(!is_dir($smart_app_downloaded)){
				mkdir($smart_app_downloaded);
				chmod($smart_app_downloaded, 0777);
			}else{
				@unlink($smart_app_downloaded.'/'.C("SmartAppName"));
			}
			move_uploaded_file($_FILES["smartApp"]["tmp_name"], $smart_app_downloaded.'/'.C("SmartAppName"));
		}
		if($_FILES["videoPlayer"]['name']){
			$date['video_player'] = $videoPlayerNo;
			$video_player_downloaded = $this->videoplayer_uploaded_url."$videoPlayerNo";
			$date['video_player_downloaded'] = $video_player_downloaded;
			//不存在则创建
			if(!is_dir($video_player_downloaded)){
				mkdir($video_player_downloaded);
				chmod($video_player_downloaded, 0777);
			}else{
				@unlink($video_player_downloaded.'/'.C("VideoPlayerName"));
			}
			move_uploaded_file($_FILES["videoPlayer"]["tmp_name"], $video_player_downloaded.'/'.C("VideoPlayerName"));
		}
		if($_FILES["updateApp"]['name']){
			$date['update_app'] = $updateAppNo;
			$update_app_downloaded = $this->updateapp_uploaded_url."$updateAppNo";
			$date['update_app_downloaded'] = $update_app_downloaded;
			//不存在则创建
			if(!is_dir($update_app_downloaded)){
				mkdir($update_app_downloaded);
				chmod($update_app_downloaded, 0777);
			}else{
				@unlink($update_app_downloaded.'/'.C("UpdateAppName"));
			}
			move_uploaded_file($_FILES["updateApp"]["tmp_name"], $update_app_downloaded.'/'.C("UpdateAppName"));
		}
		if($_FILES["smartGuard"]['name']){
			$date['smart_guard'] = $smartGuardNo;
			$smart_guard_downloaded = $this->smartguard_uploaded_url."$smartGuardNo";
			$date['smart_guard_downloaded'] = $smart_guard_downloaded;
			//不存在则创建
			if(!is_dir($smart_guard_downloaded)){
				mkdir($smart_guard_downloaded);
				chmod($smart_guard_downloaded, 0777);
			}else{
				@unlink($smart_guard_downloaded.'/'.C("SmartGuardName"));
			}
			move_uploaded_file($_FILES["smartGuard"]["tmp_name"], $smart_guard_downloaded.'/'.C("SmartGuardName"));
		}
		$date['target_num'] = $target_num;
		//如果有修改id则修改
		if($updateId){
			$date['update_date'] = time();
			$app_dev_update->where("id = $updateId")->save($date);
		//否则是添加
		}else{
			$date['add_user_id'] = $this->userinfo['uid'];
			$date['create_date'] = time();
			$app_dev_update->add($date);
		}
		//echo $app_dev_update->getLastSql();exit;
		$this->redirect('Index/verup', array('cate_id'=>2), 0,' 页面跳转中 ~');
	}
	
	/**
	 * verup_udp 版本升级删除
	 * @param
	 * @return mixed
	 */
	function verup_del(){
		$updateId       = $_POST['updateId_hid'];
		$model = new Model();
		$model->query("delete from app_dev_update where id = $updateId");
		$this->redirect('Index/verup', array('cate_id'=>2), 0,' 页面跳转中 ~');
	}
	
	/**
	 * verup_use 版本升级更新
	 * @param
	 * @return mixed
	 */
	function verup_use(){
		$app_dev_update = new Model("AppDevUpdate");
		$updateId       = $_POST['updateId_hid'];
		$app_dev_update_list = $app_dev_update->where("id = '$updateId'")->select();
		$channel_id_str = $app_dev_update_list[0]['target_num'];
		$channel_id_str = trim($channel_id_str,',');
		$channel_id_arr = explode(",",$channel_id_str);
		$channel_id_str = "";
		foreach($channel_id_arr as $k=>$v){
			$channel_id_str .= "'$v',";
		}
		//渠道id字符串
		$channel_id_str=trim($channel_id_str,',');
		$sendDev = new SendDevAction();
		//日志文件
		if($app_dev_update_list[0]['smart_app']){
			$file = $this->smartapp_uploaded_url.$app_dev_update_list[0]['smart_app'].'/'.C("SmartAppName");
			$down_url = C("web_url")."gas_station_erp/".$file;
			$save_path = "D:\SmartApp\SmartApp.exe";
			$file_md5 = md5_file($file);
			$sendDev->updateApp($channel_id_str, $down_url, $save_path, $file_md5,$updateId,C("SmartAppName"));
		}

		if($app_dev_update_list[0]['video_player']){
			$file = $this->videoplayer_uploaded_url.$app_dev_update_list[0]['video_player'].'/'.C("VideoPlayerName");
			$down_url = C("web_url")."gas_station_erp/".$file;
			$save_path = "D:\VideoPlayer\VideoPlayer.exe";
			$file_md5 = md5_file($file);
			$sendDev->updateApp($channel_id_str, $down_url, $save_path, $file_md5,$updateId,C("VideoPlayerName"));
		}
		
		if($app_dev_update_list[0]['update_app']){
			$file = $this->updateapp_uploaded_url.$app_dev_update_list[0]['update_app'].'/'.C("UpdateAppName");
			$down_url = C("web_url")."gas_station_erp/".$file;
			$save_path = "D:\UpdateApp\UpdateApp.exe";
			$file_md5 = md5_file($file);
			$sendDev->updateApp($channel_id_str, $down_url, $save_path, $file_md5,$updateId,C("UpdateAppName"));
		}
		
		if($app_dev_update_list[0]['smart_guard']){
			$file = $this->smartguard_uploaded_url.$app_dev_update_list[0]['smart_guard'].'/'.C("SmartGuardName");
			$down_url = C("web_url")."gas_station_erp/".$file;
			$save_path = "D:\SmartGuard\SmartGuard.exe";
			$file_md5 = md5_file($file);
			$sendDev->updateApp($channel_id_str, $down_url, $save_path, $file_md5,$updateId,C("SmartGuardName"));
		}
		
		$date = array();
		$date['status'] = 1;
		$date['status_date'] = time();
		$date['update_user_id'] = $this->$userinfo['uid'] == "root"?0:$this->$userinfo['uid'];
		$app_dev_update->where("id = $updateId")->save($date);
		
		$this->redirect('Index/verup', array('cate_id'=>2), 5,' 更新完毕，页面跳转中 ~');
	}

	/**
	 * getAppRule 自动补全对应函数
	 * @param
	 * @return mixed
	 */
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
		$cityArr = array();
		$model = new Model();
		
		$where = " where 1 ";
		if($this->agentIdStr){
			$where .= " and a.agent_id in (".$this->agentIdStr.")";
		}
		
		$sql_channel = "
				SELECT a.channel_id area_id,a.channel_name area_name,a.city_id pid
				FROM qd_channel a
				$where
				and a.isDelete = 0
			";
		$this->que_channel = $model->query($sql_channel);

		$sql_area = "
				SELECT * FROM bi_area
				WHERE area_id IN (
								SELECT a.province_id
								FROM
								qd_channel a
								$where
								GROUP BY a.province_id
								)
				OR area_id IN (
								SELECT a.city_id
								FROM
								qd_channel a
								$where
								GROUP BY a.city_id
								)
				
				";
		$que_area = $model->query($sql_area);
		
		$this->getProvinceCity($que_area, $this->top_pid);
		
		echo json_encode($this->areaArr);
	}
	
	public $areaArr = array();
	public $lv;
	//沥遍排序获取区域数组
	function getProvinceCity($arr,$parentId){
		//同父级区域的数量
		//$length = 0;
		foreach($arr as $k=>$v){
			if($v['pid'] == $parentId){
				//$length++;
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
					if($v['area_id'] == $cv['pid']){
						$this->areaArr[count($this->areaArr)]['value'] = $cv['area_name'];
						$this->areaArr[count($this->areaArr)-1]['id'] = "3-".$cv['area_id'];
						$this->areaArr[count($this->areaArr)-1]['pid'] = "2-".$cv['pid'];
						$this->areaArr[count($this->areaArr)-1]['small_pid'] = $cv['area_id'];
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
	/**
	 * getRuleAreaId根据刊例号获取发布区域
	 * @param
	 * @return mixed
	 */
	function getAreaIdByRule(){
		$model = new Model();
		
		$send_id = $_POST['send_id'];
		$sql = "select target_num from app_rule_send where id = '$send_id'";
		$que = $model->query($sql);
		echo json_encode($que[0]['target_num']);
	}
	
	/**
	 * getAreaIdByUpdate根据更新id获取区域
	 * @param
	 * @return mixed
	 */
	function getAreaIdByUpdate(){
		$model = new Model();
		$id = $_POST['updateId'];
		$sql = "select target_num from app_dev_update where id = '$id'";
		$que = $model->query($sql);
		echo json_encode($que[0]['target_num']);
	}
}