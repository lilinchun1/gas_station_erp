<?php
return array(
	//'配置项'=>'配置值'
	// 添加数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => '192.168.0.74', // 服务器地址 10.0.0.227=====192.168.0.10
	'DB_NAME'   => 'jnbizs', // 数据库名
	'DB_USER'   => 'jienuo', // 用户名
	'DB_PWD'    => 'kuaiyong', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => '', // 数据库表前缀
	'SHOW_PAGE_TRACE' => true, // 显示页面Trace信息
	'URL_MODEL' => 1,
	'URL_HTML_SUFFIX'=>'', // 多个用 | 分割,
	'SESSION_AUTO_START' =>true,
	//'LOAD_EXT_CONFIG' => 'message,property',
	'APP_GROUP_LIST'=>'configuration,channel,management,socket,monitoring,statistics',
	'DEFAULT_GROUP'=>'configuration',//
	'ROOT_USER' => 'admin', // 根用户用户名
	'ROOT_PWSD' => 'admin', // 根用户密码
	'ROOT_USER_REALNAME' => '根用户', // 根用户用户名
	'DEFAULT_CHARSET' => 'utf-8',
	'OUTPUT_CHARSET' => 'utf-8',
	'LOAD_EXT_CONFIG' => 'configuration_message,channel_message,channel_property',
	//'LAYOUT_ON'=>true,
	//'LAYOUT_NAME'=>'layout',
	'VAR_FILTERS'=>'htmlspecialchars',
	'is_open_purview' => '1', // 是否开启权限 1开启
	'web_url' => 'http://admin.jienuo-service.net/', // 根目录url
	'SmartAppName' => 'SmartApp.exe', // SmartApp程序名称
	'VideoPlayerName' => 'VideoPlayer.exe', // VideoPlayer程序名称
	'UpdateAppName' => 'UpdateApp.exe', // UpdateApp程序名称
	'SmartGuardName' => 'SmartGuard.exe', // SmartGuard程序名称
	'__PUBLIC__'     => '__APP__/Public/',
);
?>