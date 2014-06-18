<?php
return array(
	//'配置项'=>'配置值'
	// 添加数据库配置信息
	'SHOW_PAGE_TRACE' => true, // 显示页面Trace信息
	'URL_MODEL' => 1,
	'URL_HTML_SUFFIX'=>'', // 多个用 | 分割,
	'SESSION_AUTO_START' =>true,
	//'LOAD_EXT_CONFIG' => 'message,property',
	'APP_GROUP_LIST'=>'configuration,channel,management,socket',
	'DEFAULT_GROUP'=>'configuration',
	'ROOT_USER' => 'admin', // 根用户用户名
	'ROOT_PWSD' => 'admin', // 根用户密码
	'ROOT_USER_REALNAME' => '根用户', // 根用户用户名
	'DEFAULT_CHARSET' => 'utf-8',
	'OUTPUT_CHARSET' => 'utf-8',
<<<<<<< .mine
	'DOMAIN' => 'http://127.0.0.1/',
	'LOAD_EXT_CONFIG' => 'configuration_message,channel_message',
=======
	'DOMAIN' => 'http://192.168.0.10/',
	'LOAD_EXT_CONFIG' => 'configuration_message,channel_message,channel_property',
>>>>>>> .r2869
	//'LAYOUT_ON'=>true,
	//'LAYOUT_NAME'=>'layout',
	'VAR_FILTERS'=>'htmlspecialchars'
);
?>