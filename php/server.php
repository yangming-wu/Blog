<?php

/**
 * 引入项目初始化框架类
 */

// 允许跨域访问
// 制定允许其他域名访问
header("Access-Control-Allow-Origin:*");
// 响应类型
header('Access-Control-Allow-Methods:POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with, content-type');

include './Frame/Frame.class.php';
// 调用run方法
Frame::run();

?>