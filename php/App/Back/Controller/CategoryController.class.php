<?php

/**
 * 后台分类管理控制器
 */
class CategoryController extends PlatformController {
	
	/**
	 * 显示分类管理首页动作
	 */
	public function indexAction() {
		// 实例化模型
		$category = Factory::M('CategoryModel');
		// 获取所有的分类信息
		$cateInfo = $category->getCategory();
		// 返回数据
		$this->returnData(array("statu" => 0, "Info" => $cateInfo));
	}


	/**
	 * 显示添加分类表单动作
	 */
	public function addAction() {
		// 提取分类信息
		$category = Factory::M('CategoryModel');
		$cateInfo = $category->getCategory();
		// 返回数据
		$this->returnData(array("statu" => 0, "Info" => $cateInfo));
	}

	
	/**
	 * 处理提交的分类表单
	 */
	public function dealAddAction() {
		// 接收表单数据
		$cate = array();
		$cate['cate_name'] = $this->escapeData($_POST['cate_name']);
		$cate['cate_pid'] = $_POST['cate_pid'];
		$cate['cate_sort'] = $this->escapeData($_POST['cate_sort']);
		$cate['cate_desc'] = $this->escapeData($_POST['cate_desc']);
		// 判断数据是否合法
		if(empty($cate['cate_name']) || empty($cate['cate_sort']) || empty($cate['cate_desc'])) {
			$this->returnData(array("statu" => 1, "Info" => ":( 您填写的信息不完整!"));
		}
		if(!is_numeric($cate['cate_sort']) || (int)($cate['cate_sort']) != $cate['cate_sort'] || $cate['cate_sort'] < 1) {
			$this->returnData(array("statu" => 1, "Info" => ":( 排序编号为1-50"));
		}
		// 数据入库,需要调用模型
		$category = Factory::M('CategoryModel');
		// 调用insertCate方法
		$result = $category->insertCate($cate);
		if($result) {
			// 成功入库,立即跳转到分类首页
			$this->returnData(array("statu" => 0, "Info" => "添加分类成功!"));
		}else {
			// 入库失败
			$this->returnData(array("statu" => 1, "Info" => "发生未知错误,添加分类失败!"));
		}
	}
	/**
	 * 修改分类信息动作
	 */
	public function editAction() {
		// 获取当前分类的原始信息
		$cate_id = $_POST['cate_id'];
		// 实例化模型
		$category = Factory::M('CategoryModel');
		$cateInfoById = $category->getCateInfoById($cate_id);	
		$cateInfo = $category->getCategory();

		$this->returnData(array("statu" => 0, "Info" => array("cateInfoById"=>$cateInfoById, "cateInfo"=>$cateInfo)));
	}
	/**
	 * 处理修改分类信息动作
	 */
	public function dealEditAction() {
		// 接收表单数据
		$cate = array();
		$cate['cate_name'] = $this->escapeData($_POST['cate_name']);
		$cate['cate_pid'] = $_POST['cate_pid'];
		$cate['cate_sort'] = $this->escapeData($_POST['cate_sort']);
		$cate['cate_desc'] = $this->escapeData($_POST['cate_desc']);
		$cate['cate_id'] = $_POST['cate_id'];//从隐藏域中接收当前分类的id号
		// 判断数据是否合法
		if(empty($cate['cate_name']) || empty($cate['cate_sort']) || empty($cate['cate_desc'])) {
			$this->returnData(array("statu"=>1, "Info"=>":( 您填写的信息不完整!"));
		}
		if(!is_numeric($cate['cate_sort']) || (int)($cate['cate_sort']) != $cate['cate_sort'] || $cate['cate_sort'] < 1) {
			$this->returnData(array("statu"=>1, "Info"=>":( 排序编号为1-50"));
		}
		// 修改分类,需要调用模型
		$category = Factory::M('CategoryModel');
		// 调用updateCateById方法
		$result = $category->updateCateById($cate);
		if($result) {
			// 成功修改,立即跳转到分类首页
			$this->returnData(array("statu"=>0, "Info"=>"修改分类信息成功!"));
		}else {
			// 修改失败
			$this->returnData(array("statu"=>1, "Info"=>"未知错误,修改分类信息失败!"));
		}
	}
	/**
	 * 删除单个分类动作
	 */
	public function delAction() {
		// 获取要删除的分类的id号
		$cate_id = $_POST['cate_id'];
		// 实例化模型,执行删除操作
		$category = Factory::M('CategoryModel');
		$result = $category->delCateById($cate_id);
		// 跳转
		if($result) {
			// 删除成功,跳转到分类首页
			$this->returnData(array("statu" => 0, "Info" => "删除成功!"));
		}else {
			// 删除失败
			$this->returnData(array("statu" => 0, "Info" => "未知错误, 删除失败!"));
		}
	}


	/**
	 * 批量删除分类动作
	 */
	public function delAllAction() {
		
		// 接收需要删除的分类id号
		$cate_ids = $_POST['cate_ids'];//数组
		// 实例化模型,执行批量删除操作
		$category = Factory::M('CategoryModel');
		$result = $category->delAllCate($cate_ids);
		// 跳转
		if($result) {
			// 删除成功,跳转到分类首页
			$this->returnData(array("statu" => 0, "Info" => "删除成功!"));
		}else {
			// 删除失败
			$this->returnData(array("statu" => 0, "Info" => "未知错误, 删除失败!"));
		}
	}
}