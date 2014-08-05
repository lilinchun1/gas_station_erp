<?php
class apiAction extends Action{
	public $userinfo;
/* 	function __construct(){
		parent::__construct();
		//获取用户信息
		$url =$_GET['_URL_'];
		$apiarr = array("user_statistics");
		if (!in_array($url[2], $apiarr)){
			$this->userinfo = getUserInfo();
			//获取可查看菜单路径
			$this->assign('urlStr', $this->userinfo['urlstr']);
			$this->assign('username', $this->userinfo['realname']);
		}
	}  
	
 	public function index(){
		$data = array(
				array("id" => '1', 'cc' => 'aaa'),
				array("id" => '2', 'cc' => 'bbb')
		);
		httpopen("http://serv.c/gas_station_erp/index.php/statistics/api/requestapi",$data);
	}
	
	public function requestapi(){
		handledata();
	} */
	
	
	public function index(){
		/*
		 * dervicetalbe  机器手机信息
		 * successtalbe  成功
		 * failtalbe 失败
		 * 
		 * */
		
		$pextalbe = date('Ym');
		$teltalbe = "statistics_install_tel_info_".$pextalbe;
		$successtable = "statistics_install_succ_".$pextalbe;
		$failtable = "statistics_install_fail_".$pextalbe;
		$mob_id = 0;
		$dev_id = 0;
		$dev_mac = 0;
		$mobile = array();
		$idata = array();
		$reg_date = time();
		
		/* 
		 * table info
		 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`appid` varchar(255) NOT NULL COMMENT 'app_store表ID带-ios-android后缀',
		`app_no` varchar(255) NOT NULL COMMENT 'APP ID不带-ios-android后缀',
		`appname` varchar(250) DEFAULT NULL COMMENT 'APP名称',
		`system` enum('ios','android') DEFAULT NULL,
		`install_time` int(10) unsigned DEFAULT NULL COMMENT '安装时间戳',
		`install_duration` smallint(5) unsigned NOT NULL COMMENT '安装时长(秒)',
		`mobileid` varchar(255) DEFAULT NULL COMMENT '安装手机ID(mobile表id)',
		`devicemac` char(17) NOT NULL COMMENT '链接的终端机设备MAC(渠道表获取)',
		`issueid` varchar(30) NOT NULL COMMENT '期刊ID',
		`sort` tinyint(3) unsigned NOT NULL COMMENT '所在分类',
		`install_mode` tinyint(3) unsigned DEFAULT NULL COMMENT '安装方式(1默认安装2搜索3点击)',
		`page` tinyint(3) unsigned NOT NULL COMMENT '在栏目的页数',
		`several` smallint(5) unsigned NOT NULL COMMENT '在该页的第几个',
		`status` tinyint(3) unsigned NOT NULL COMMENT '安装状态0成功',
		*
		*return data
		用GET传递
		devicemac       = 链接终端机的MAC地址&	//-------------------	// MAC所有字母为大写
		mobilemac       = 手机MAC地址&	// MAC所有字母为大写
		mobileid        = 手机唯一ID号码&
		mobilesystem    = 手机OS&        //(ios/android/other)
		mobiletype      = 手机机型&	//(iPhone4s/Note1/Note2 ....)重点，要求去掉空格例如Note 1改为Note1
		linktime        = 连接时间戳&
		unlinktime      = 断开连接时间戳&
		osversion       = 手机系统版本(string)&	//(6/4.1 ....)
		issueid         = 期刊号
		company         = 公司厂商& // (sumsun/HTC ...)
		connect_success = 通信是否成功(bool)&	// 1成功0失败
		is_root         = 是否越狱(bool)&	// 1越狱0未越狱
		open_usb        = 是否打开USB调试(bool)	// 1打开0未开
		smartversion	= 1.0.0.0		// 程序版本号
		
		//以下皆为数组，一次连接内所有安装的应用信息
		用POST传递
		appid[0]        = 应用id
		appname[0]      = 应用名称
		installtime[0]  = 安装时间戳
		duration[0]     = 安装时长(秒)
		status[0]       = 安装状态0成功/其他失败状态
		sort[0]         = 分类(1未知，3游戏，4应用，5图书)
		install_mode[0] = 安装方式(1默认安装2搜索3点击4特权页点击)
		page[0]         = 在栏目的页数
		several[0]      = 在该页的第几个
		**/
		
		//手机信息
		$mobile['mobilemac'] 	= I("get.mobilemac");
		$mobile['mobileid'] 	= I("get.mobileid");
		$mobile['mobilesystem'] = I("get.mobilesystem");
		$mobile['mobiletype'] 	= trim(I("get.mobiletype"));
		$mobile['linktime'] 	= I("get.linktime");
		$mobile['osversion'] 	= I("get.osversion");
		$mobile['issueid'] 		= I("get.issueid");
		$mobile['company'] 		= I("get.company");
		$mobile['connect_success'] = I("get.connect_success");
		$mobile['is_root'] 		= I("get.is_root");
		$mobile['open_usb'] 	= I("get.open_usb");
		$mobile['smartversion'] = I("get.smartversion");
		$mobile['reg_date']		= $reg_date;
		
		//加油站mac地址
		$dev_mac = I("get.devicemac");
		
		//软件信息
		$appinfo = $_POST;
		
		//手机ID
		$mob_id = M($teltalbe)->field("mob_id")->where("mobileid = '".$mobile['mobileid']."'")->find();
		if (empty($mob_id) || $mob_id < 1){
			$mob_id = M($teltalbe)->add($mobile);
		}else{
			M($teltalbe)->setInc("linked_num", "mobileid = '".$mobile['mobileid']."'", 1);
		}
		
		//加油站ID
		$dev_id = M("qd_device")->field("device_id")->where("MAC = '".$idata['devicemac']."'")->find();
		if (empty($dev_id) || $dev_id < 1){
			$dev_id = 0;
		}
		
		$idata['dev_id'] = $dev_id;
		$idata['mob_id'] = $mob_id;	
		$idata['reg_date'] = $reg_date;
		$idata['devicemac'] = $dev_mac;
		
		foreach ($appinfo as $k => $v){
			$idata['appid'] 		= $v['appid'];
			$idata['appname'] 		= $v['appname'];
			$idata['installtime'] 	= $v['installtime'];
			$idata['duration']		= $v['duration'];
			$idata['status'] 		= $v['status'];
			$idata['sort'] 			= $v['sort'];
			$idata['install_mode'] 	= $v['install_mode'];
			$idata['page'] 			= $v['page'];
			$idata['several'] 		= $v['several'];
			
			if ($v['status'] > 0){
				M($failtable)->add($idata);
			}else{
				M($successtable)->add($idata);
			}
		}

		
	}
}