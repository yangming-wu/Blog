<?php

class AdminController extends PlatformController {

	/**
	 * 注销登录功能
	 */
	public function logoutAction() {
		@session_start();
		// 删除相关会话数据
		unset($_SESSION['Member']);
		// 删除会话数据区
		session_destroy();
		// 跳转到登录页面
		$json = array("statu" => 0, "flag" => "Success", "info" => '注销成功!');
		$this->returnData($json);
	}

  public function checkAction() {
		// 接收表单数据
		$user_name = $this->escapeData($_POST['user']);
		$user_pass = $_POST['passwd'];
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
		if($row = $admin->check($user_name, $user_pass)) {
			// 如果合法,应该把用户信息放到session中
			@session_start(); // 确定开启session机制
			$_SESSION['Member'] = $row;
			
			// 验证成功
			$json = array("statu" => 0, "flag" => "Success", "info" => '登录成功!');
			$this->returnData($json);
		}else {
			// 验证失败
			$json = array("statu" => 1, "flag" => "Failed", "info" => '用户名或密码错误!');
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

	/**
	 * 上传用户头像
	 */
	public function uploadImgAction(){
		// 判断是否有缩略图上传
		if($_FILES['Photo']['error'] != 4) {
			// 说明用户选择了上传文件,实例化上传类
			$upload = Factory::M('Upload');
			// 初始化相关参数
			$allow = array('image/jpeg', 'image/png', 'image/gif', 'image/jpg');
			$path = UPLOADS_DIR . 'User';
			// 调用uploadAction方法
			$result = $upload->uploadAction($_FILES['Photo'], $allow, $path);
			// 判断是否上传成功
			if($result) {
				// 生成缩略图
				$image = Factory::M('Image');
				$max_w = 70;
				$max_h = 70;
				$src_file = UPLOADS_DIR . 'User/' . $result;
				if($thumb = $image->makeThumb($max_w, $max_h, $src_file, $path)) {
					$this->returnData(array("statu" => 0, "Info" => "缩略图上传成功!", "filename" => $thumb));
				}else {
					$this->returnData(array("statu" => 1, "Info" => "缩略图上传失败!"));
				}		
			}else {
				// 记录错误信息
				$error = Upload::$error;
				$this->returnData(array("statu" => 1, "Info" => ":( " . $error,  "filename" => "default.jpg"));
			}
		}else {
			$this->returnData(array("statu" => 1, "Info" => ":( 没有检测到缩略图上传", "filename" => "default.jpg"));
		}
	}

	/**
	 * 注册账号
	 */
	public function RegisterAction(){
		// 接收表单数据
		$user_name = $this->escapeData($_POST['user']);
		$user_pass = $_POST['passwd'];
		$passcode = trim($_POST['passcode']);
		$img = $this->escapeData($_POST['img']);
		$captcha = Factory::M('Captcha');

		if(!$captcha->checkCaptcha($passcode)) {
			// 验证码非法,跳转
			$json = array("statu" => 1, "flag" => "Failed", "info" => '验证码错误!');
			$this->returnData($json);
		}

		// 实例化模型
		$admin = Factory::M('AdminModel');

		// 注册前判断用户是否存在
		$nums = $admin->checkUser($user_name);
		if($nums > 0){
			$this->returnData(array("statu" => 1, "Info" => "用户名已存在, 注册失败!"));	
		}

		$res = $admin->reigster($user_name,$user_pass,$img);
		if($res){
			$this->returnData(array("statu" => 0, "Info" => "注册成功!"));	
		}else{
			$this->returnData(array("statu" => 1, "Info" => "未知错误, 注册失败!"));	
		}
	}
}


?>