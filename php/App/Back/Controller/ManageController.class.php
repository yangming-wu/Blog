<?php

/**
 * 后台管理平台控制器
 */
class ManageController extends PlatformController {
	/**
	 * 首页动作
	 */
	public function indexAction() {
		$json = array("statu" => 0, "flag" => "Success", "info" => '登录成功!');
		$this->returnData($json);
	}
}

?>