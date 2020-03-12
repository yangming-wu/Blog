<?php

class AdminController extends PlatformController {

	/**
	 * 注销登录功能
	 */
	public function logoutAction() {
		@session_start();
		// 删除相关会话数据
		unset($_SESSION['adminInfo']);
		// 删除会话数据区
		session_destroy();
		// 跳转到登录页面
		$json = array("statu" => 0, "flag" => "Success", "info" => '注销成功!');
		$this->returnData($json);
	}

  public function checkAction() {
		// 接收表单数据
		$admin_name = $this->escapeData($_POST['user']);
		$admin_pass = $_POST['passwd'];
		$passcode = trim($_POST['passcode']);
		$captcha = Factory::M('Captcha');

		if(!$captcha->checkCaptcha($passcode)) {
			// 验证码非法,跳转
			$json = array("statu" => 0, "flag" => "Failed", "info" => '验证码错误!');
			$this->returnData($json);
		}
		// 从数据库中验证管理员的合法性
		// 实例化模型
		$admin = Factory::M('AdminModel');
		if($row = $admin->check($admin_name, $admin_pass)) {
			// 如果合法,应该把用户信息放到session中
			@session_start(); // 确定开启session机制
			$_SESSION['adminInfo'] = $row;

			// 更新当前管理员信息
			$admin->updateAdminInfo($row['admin_id']);
			
			// 验证成功
			$json = array("statu" => 0, "flag" => "Success", "info" => '登录成功!');
			$this->returnData($json);
		}else {
			// 验证失败
			$json = array("statu" => 0, "flag" => "Failed", "info" => '用户名或密码错误!');
			$this->returnData($json);
		}
  }
  
	/**
	 * 生成验证码图片的动作
	 */
	public function captchaAction() {
		// 实例化验证码类
		$captcha = Factory::M('Captcha');
		$captcha->generate();
	}

}


?>