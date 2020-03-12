<?php

  /**
   * 前台首页控制器
   */

  class IndexController extends Controller {

    public function IndexAction (){

      // 判断用户是否登录
      @session_start();
      if(!isset($_SESSION['Member'])) {
        // 说明还没有登录,跳转到登录页面
        $login = "Failed";
        $user = '';
      }else{
        $login = "Success";
        $user = $_SESSION['Member']['user_name'];
      }
      // 获取所有分类信息
      $category = Factory::M('CategoryModel');
      // 1. 获取所有的1级分类
      $cateInfo = $category->getFirstCate();

      $result = Array();
      // 2. 获取当前类别下的第一层子类别
      foreach ($cateInfo as $row){
        $result[$row['cate_name']] = Array();
        $childCate = $category->getSubCateByPid($row['cate_id']);
        foreach ($childCate as $child){
          array_push($result[$row['cate_name']], $child);
        }
      }

		  // 返回数据
		  $this->returnData(array("statu" => 0, "flag" => $login,"Category" => $result, 'user' => $user));
    }

    /**
     * 前台首页
     */

    public function StartAction(){

      // 1. 获取热门文章
      $Article = Factory::M('ArticleModel');
      $hotArt = $Article->getHotArt();

      // 2. 获取推荐文章
      $recommentArt = $Article->getRecommentArt();
      $recommentArtNum = count($recommentArt);
      for($i=0; $i < $recommentArtNum; $i ++){
        $recommentArt[$i]["addtime"] = date("Y-m-d h:i:s",$recommentArt[$i]["addtime"]);
        $recommentArt[$i]["thumb"] = "http://localhost/myblog/php/Uploads/thumb/" . $recommentArt[$i]["thumb"];
      }

      $this->returnData(array("statu" => 0, "data" => array("HotArt" => $hotArt, "Recomment" => $recommentArt)));
    }


  }

?>