<?php
return array (
		// '配置项'=>'配置值'
		'DB_TYPE' => 'mysql', // 数据库类型
		'DB_HOST' => '192.168.0.10', // 服务器地址
		'DB_NAME' => 'jnbizs', // 数据库名
		'DB_USER' => 'jienuo', // 用户名
		'DB_PWD' => 'kuaiyong', // 密码
		'DB_PORT' => 3306, // 端口
		'DB_PREFIX' => '', // 数据库表前缀
		'SHOW_PAGE_TRACE' => true, // 显示页面Trace信息
		'URL_MODEL' => 1,
		'URL_HTML_SUFFIX'=>'', // 多个用 | 分割,
		'SESSION_AUTO_START' =>true,
		'DOMAIN' => 'http://192.168.0.65/',
		'image_url' => 'http://192.168.0.65/',
		'__PUBLIC__'     => '__APP__/Public/',
		'is_open_purview' => '1', // 是否开启权限 1开启
		'page_show_number' => 30  //每页显示数量
);
//"mysql://root:@192.168.0.63:3306/jn"
?>