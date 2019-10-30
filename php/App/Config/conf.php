<?php

return array(
	'db'	=>	array( // 数据库信息组
		'host'	=>	'localhost',
		'port'	=>	'3306',
		'user'	=>	'wym',
		'pass'	=>	'wym9278',
		'charset'=>	'utf8',
		'dbname' => 'blog'
	),
	'App'	=>	array( // 应用程序组
		'default_platform'=>'Back',
		'dao'	=>	'mysql',// 这里可以是pdo或mysql
	),
	'Home'	=>	array( // 前台组
		'default_controller'=>'Index',
		'default_action'	=>'index'
	),
	'Back'	=>	array(	// 后台组
		'default_controller'=>'Admin',
		'default_action'	=>'login'
	),
	'Captcha'=>	array( // 验证码信息组
		'width'	=>	102,
		'height'=>	40,
		'pixelnum'=> 0.02,//干扰点密度 0.02
		'linenum' => 0,// 干扰线数量 5
		'stringnum'=> 4, // 验证码字符个数
	),
	'Page'	=>	array( // 分页信息组
		'rowsPerPage'=>3,//每页显示的记录数
		'maxNum'=>5  // 页面上能显示的最多有多少个页面
	),
	// 其他
);

