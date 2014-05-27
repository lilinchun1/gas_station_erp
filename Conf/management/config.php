<?php
return array (
		// '配置项'=>'配置值'
		'DB_TYPE' => 'mysql', // 数据库类型
		'DB_HOST' => 'localhost', // 服务器地址
		'DB_NAME' => 'jnbizs', // 数据库名
		'DB_USER' => 'root', // 用户名
		'DB_PWD' => '', // 密码
		'DB_PORT' => 3306, // 端口
		'DB_PREFIX' => '', // 数据库表前缀
		'LOAD_EXT_CONFIG' => 'language',
		'ROOT_USER' => 'admin', // 根用户用户名
		'ROOT_PWSD' => 'jienuoadmin', // 根用户密码
		'ROOT_USER_REALNAME' => '根用户', // 根用户用户名
		'DEFAULT_CHARSET' => 'utf-8',
		'OUTPUT_CHARSET' => 'utf-8',
		
		'TMPL_PARSE_STRING' => array ( // 添加输出替换
				'PUBLIC_URL' => __ROOT__."/Public",//公共文件存放路径包括上传，js，css存放路径
				'INDEX_URL' =>  __ROOT__."/statistics/index.php",//入口文件路径
				'USER_URL' =>  __ROOT__."/user/index.php?m=user&a=showlist"//入口文件路径
		) ,
		'URL_CASE_INSENSITIVE' =>true,
		'URL_MODEL' => 1,
		'URL_HTML_SUFFIX'=>'',
		'ONE_PAGE_APP_NUMS_ON_SCREEN'=>20,		// 客户端终端一页要显示多少个APP， 用于导入分析位置
);
//"mysql://root:@192.168.0.63:3306/jn"
?>