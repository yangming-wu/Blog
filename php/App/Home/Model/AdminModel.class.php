<?php

/**
 * 后台bg_admin表操作模型
 */
class AdminModel extends Model {
	/**
	 * 验证管理员的合法性
	 */
	public function check($user_name, $user_pass) {
		$sql = "select * from bg_user where user_name='$user_name' and user_pass=md5('$user_pass')";
		return $this->dao->fetchRow($sql);
	}

	/**
	 * 判断用户名是否存在
	 */
	public function checkUser($user_name){
		$sql = "select count(*) from bg_user where user_name='$user_name'";
		return $this->dao->fetchColumn($sql);
	}

	/**
	 * 注册账号
	 */
	public function reigster($user_name, $user_pass,$img){
		$time = time();
		$sql = "insert into bg_user values(null,'$user_name', md5('$user_pass'),'$img',$time)";
		return $this->dao->my_query($sql);
	}

	/**
	 * 获取用户头像
	 */
	public function getImgByUser($user_name){
		$sql = "select user_image from bg_user where user_name='$user_name'";
		return $this->dao->fetchColumn($sql);
	}
	


	
}