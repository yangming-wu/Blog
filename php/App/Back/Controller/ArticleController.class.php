<?php
/**
 * 后台文章管理控制器
 */
class ArticleController extends PlatformController {
	/**
	 * 文章管理首页动作
	 */
	public function indexAction() {
		// 实例化模型,提取所有的文章信息
		$article = Factory::M('ArticleModel');
		$artInfo = $article->getArticle();
		$artInfoNum = count($artInfo);
		// 格式化时间
		for($i=0; $i<$artInfoNum; $i++){
			$artInfo[$i]["addtime"] =date("Y-m-d h:i:s",$artInfo[$i]["addtime"]);
		}
		
		$rowCount = $article->getRowCount(); // 获取总记录数

		$this->returnData(array("statu" => 0, "total" => $rowCount, "Info" => $artInfo));
	}


	/**
	 * 显示添加文章表单的动作
	 */
	public function addAction() {
		// 需要先提取文章分类信息
		$category = Factory::M('CategoryModel');
		$cateInfo = $category->getCategory();
		
		$this->returnData(array("statu" => 0, "Info" => $cateInfo));
	}


	/**
	 * 处理上传缩略图的动作
	 */
	public function uploadThumbAction() {
		// 判断是否有缩略图上传
		if($_FILES['thumb']['error'] != 4) {
			// 说明用户选择了上传文件,实例化上传类
			$upload = Factory::M('Upload');
			// 初始化相关参数
			$allow = array('image/jpeg', 'image/png', 'image/gif', 'image/jpg');
			$path = UPLOADS_DIR . 'thumb';
			// 调用uploadAction方法
			$result = $upload->uploadAction($_FILES['thumb'], $allow, $path);
			// 判断是否上传成功
			if($result) {
				// 生成缩略图
				$image = Factory::M('Image');
				$max_w = 200;
				$max_h = 123;
				$src_file = UPLOADS_DIR . 'thumb/' . $result;
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
	 * 处理提交文章表单的动作
	 */
	public function dealAddAction() {
		// 接收表单
		$art = array();
		$art['cate_id'] = $_POST['cate_id'];
		$art['title'] = $this->escapeData($_POST['title']);
		$art['content'] = addslashes($_POST['content']);
		$art['art_desc'] = $this->escapeData($_POST['art_desc']);
		$art['author'] = $this->escapeData($_POST['author']);
		$art['thumb'] = empty($_POST['thumb']) ? "default.jpg" : $_POST['thumb'];

		// 判断数据合法性
		if(empty($art['title']) || empty($art['content']) || empty($art['art_desc']) || empty($art['author'])) {
			$this->returnData(array("statu" => 1, "Info" => ":( 您填写的数据不完整"));
		}
		if(empty($art['cate_id'])) {
			$this->returnData(array("statu" => 1, "Info" => ":( 请选择文章类型!"));
		}

		// 调用模型,数据入库
		$article = Factory::M('ArticleModel');
		$result = $article->insertArt($art);
		if($result) {
			$this->returnData(array("statu" => 0, "Info" => ":) 发布文章成功!"));
		}else{
			$this->returnData(array("statu" => 1, "Info" => ":( 发生未知错误,发布文章失败!"));
		}
	}

	/**
	 * 富文本编辑器上传图片
	 */
	public function uploadImgAction(){
		// 判断是否有图片上传
		if($_FILES['upload']['error'] != 4) {
			// 说明用户选择了上传文件,实例化上传类
			$upload = Factory::M('Upload');
			// 初始化相关参数
			$allow = array('image/jpeg', 'image/png', 'image/gif', 'image/jpg');
			$path = UPLOADS_DIR . 'ckEditor';
			// 调用uploadAction方法
			$result = $upload->uploadAction($_FILES['upload'], $allow, $path);
			// 判断是否上传成功
			if($result) {
				//  上传成功
				$src_file =  'http://localhost/myblog/php/Uploads/ckEditor/' . $result;
				$this->returnData(array('uploaded' => 1, 'fileName'=>$_FILES['upload']['name'],"url" => $src_file));	
			}else {
				// 记录错误信息并跳转
				$error = Upload::$error;
				$this->returnData(array('uploaded' => 0, 'fileName'=>$_FILES['upload']['name'], "url" => "Img upload error!"));
			}
		}else {
			$this->returnData(array('uploaded' => 0, 'fileName'=>$_FILES['upload']['name'], "url" => "image file is not exists!"));
		}
	}


	/**
	 * 显示修改文章表单动作 
	 */
	public function editAction() {
		// 接收文章id号
		$art_id = $_POST['art_id'];
		// 获取当前文章的信息
		$article = Factory::M('ArticleModel');
		$artInfoById = $article->getArtInfoById($art_id);

		// 获取文章类别信息
		$category = Factory::M('CategoryModel');
		$cateInfo = $category->getCategory();

		$this->returnData(array("statu" => 0, "artInfo" => $artInfoById, "cateInfo" => $cateInfo));
	}


	/**
	 * 处理修改文章表单的动作
	 */
	public function dealEditAction() {
		// 接收表单
		$art = array();
		$art['art_id'] = $_POST['art_id'];//从隐藏域中接收文章id号
		$art['cate_id'] = $_POST['cate_id'];
		$art['title'] = $this->escapeData($_POST['title']);
		$art['content'] = addslashes($_POST['content']);
		$art['art_desc'] = $this->escapeData($_POST['art_desc']);
		$art['author'] = $this->escapeData($_POST['author']);
		$art['thumb'] = empty($_POST['thumb']) ? "default.jpg" : $_POST['thumb'];

		// 判断数据合法性
		if(empty($art['title']) || empty($art['content']) || empty($art['art_desc']) || empty($art['author'])) {
			$this->returnData(array("statu" => 1, "Info" => ":( 您填写的数据不完整"));
		}
		if(empty($art['cate_id'])) {
			$this->returnData(array("statu" => 1, "Info" => ":( 请选择文章类型!"));
		}

		// 调用模型,数据入库
		$article = Factory::M('ArticleModel');
		$result = $article->UpdateArtById($art);
		if($result) {
			$this->returnData(array("statu" => 0, "Info" => ":) 修改文章成功!"));	
		}else{
			$this->returnData(array("statu" => 1, "Info" => ":( 发生未知错误,修改文章失败!"));
		}

	}


	/**
	 * 根据id号删除文章
	 */
	public function delAction() {
		// 要获取要删除的文章的id号
		$art_id = $_POST['art_id'];
		// 实例化模型
		$article = Factory::M('ArticleModel');
		$result = $article->delArtById($art_id);
		if($result) {
			$this->returnData(array("statu" => 0, "Info" => "删除文章成功!"));
		}else {
			$this->returnData(array("statu" => 1, "Info" => ":( 发生未知错误,删除文章失败!"));
		}
	}


	/**
	 * 根据id号批量删除文章
	 */
	public function delAllAction() {
		// 调用模型
		$article = Factory::M('ArticleModel');
		$result = $article->delAllArt($_POST['art_ids']);
		if($result) {
			$this->returnData(array("statu" => 0, "Info" => "批量删除文章成功!"));
		}else {
			$this->returnData(array("statu" => 1, "Info" =>":( 发生未知错误,删除文章失败!"));
		}
	}


	/**
	 * 显示回收站动作
	 */
	public function recycleAction() {
		// 调用模型,提取所有已经被逻辑删除的文章信息
		$article = Factory::M('ArticleModel');
		$artInfo = $article->getDelArt();
	
		// 格式化时间
		$artInfoNum = count($artInfo);
		for($i=0; $i<$artInfoNum; $i++){
			$artInfo[$i]["addtime"] =date("Y-m-d h:i:s",$artInfo[$i]["addtime"]);
		}

		// 获取总记录数
		$rowCount = $article->getDelRowCount();

		$this->returnData(array("statu" => 0, "total" => $rowCount, "data" => $artInfo));
	}


	/**
	 * 根据id号实现文章还原动作
	 */
	public function recoverAction() {
		// 获取需要还原的文章的id号
		$art_id = $_POST['art_id'];
		// 调用模型
		$article = Factory::M('ArticleModel');
		$result = $article->recoverArtById($art_id);
		if($result) {
			$this->returnData(array("statu" => 0, "Info" => ":) 还原成功!"));
		}else {
			$this->returnData(array("statu" => 1, "Info" => ":( 发生未知错误,还原文章失败!"));
		}
	}


	/**
	 * 根据id号实现文章彻底删除动作
	 */
	public function realDelAction() {
		// 要获取要删除的文章的id号
		$art_id = $_POST['art_id'];
		// 实例化模型
		$article = Factory::M('ArticleModel');
		$result = $article->realDelArtById($art_id);
		if($result) {
			$this->returnData(array("statu" => 0, "Info" => ":) 删除成功!"));
		}else {
			$this->returnData(array("statu" => 1, "Info" => ":( 发生未知错误,彻底删除文章失败!"));
		}
	}


	/**
	 * 根据id号实现批量彻底删除文章动作
	 */
	public function realDelAllAction() {
		// 先判断用户是否选择了文章
		if(!isset($_POST['art_ids'])) {
			// 说明没有没有选择文章
			$this->returnData(array("statu" => 1, "Info" => ":( 请先选择要删除的文章!"));
		}
		
		// 调用模型
		$article = Factory::M('ArticleModel');
		$result = $article->realDelAllArt($_POST['art_ids']);
		if($result) {
			$this->returnData(array("statu" => 0, "Info" => ":) 批量删除成功!"));
		}else {
			$this->returnData(array("statu" => 1, "Info" => ":( 发生未知错误,彻底删除文章失败!"));
		}
	}


	/**
	 * 文章推荐的动作
	 */
	public function ifRecommendAction() {
		// 接收文章编号
		$art_id = $_POST['art_id'];
		// 接收推荐状态
		$is_recommend = $_POST['is_recommend'];
		
		// 调用模型
		$article = Factory::M('ArticleModel');
		$result = $article->updateRecommendById($art_id, $is_recommend);
		if($result) {
			$this->returnData(array("statu" => 0, "Info" => "修改推荐文章成功!"));
		}else {
			$this->returnData(array("statu" => 1, "Info" =>":( 发生未知错误,推荐文章失败!"));
		}
	}
}


