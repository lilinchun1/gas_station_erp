<?php
return array(
	//'配置项'=>'配置值'
	// 添加数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '192.168.0.60', // 服务器地址
    'DB_NAME'   => 'jnbizs', // 数据库名
    'DB_USER'   => 'zyl19880817', // 用户名
    'DB_PWD'    => '82676970', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'bi_', // 数据库表前缀
	'SHOW_PAGE_TRACE' => true, // 显示页面Trace信息
	'URL_MODEL' => 1,
	'URL_HTML_SUFFIX'=>'', // 多个用 | 分割,
	'SESSION_AUTO_START' =>true,
	//'LOAD_EXT_CONFIG' => 'message,property',
	'APP_GROUP_LIST'=>'configuration,channel',
	'DEFAULT_GROUP'=>'configuration',
	'__PUBLIC__' => '__ROOT__/Public/',
	'page_show_number' => 30,  //每页显示数量
	'DEFAULT_CHARSET' => 'utf-8',
	'OUTPUT_CHARSET' => 'utf-8',
	//'LAYOUT_ON'=>true,
	//'LAYOUT_NAME'=>'layout',
	'VAR_FILTERS'=>'htmlspecialchars'
);
?>