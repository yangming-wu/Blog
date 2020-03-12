<?php

/**
 * 前台的平台控制器
 */
class PlatformController extends Controller {
	/**
	 * 判断后台管理员是否登录防止用户翻墙
	 */
	protected function checkLogin() {

		// 先列出需要登录验证的动作列表
		$no_need = array(
			// 控制器名	=> 该控制器下需要验证的动作列表
			'SinglePage'	=>	array('postComment','check'),
		);
		if(isset($no_need[CONTROLLER]) && in_array(ACTION, $no_need[CONTROLLER])) {
			// 说明当前控制器下的当前方法需要验证
			@session_start();
			if(!isset($_SESSION['Member'])) {
				// 说明还没有登录,跳转到登录页面
				header('content-type:text/json; charset=utf-8');
				$flag = array("statu" => 0, "flag" => "Failed", "info" => "您的账号未登录,请登录账号");
				$json = json_encode($flag);
				exit($json);
			}
		}
		return ;
	}
	/**
	 * 构造方法
	 */
	public function __construct() {
		// 先显式的调用父类构造方法
		parent::__construct();
		// 判断后台管理员是否登录防止用户翻墙
		$this->checkLogin();
	}
}