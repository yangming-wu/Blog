<?php

  /**
   * 前台分类文章列表控制器
   */
  class ArticleListController extends Controller {

    /**
     * 分类文章首页
     */
    public function IndexAction(){
      $cate_name = $_POST['cate_name'];
      
      $category = Factory::M('CategoryModel');
      $result = $category->getIdByCateName($cate_name);
      $cate_ids = array();
      if($result){
        $cate_id = $result['cate_id'];
        array_push($cate_ids,$cate_id);
        // 获取所有的sub id
        $sub_cate_ids = $category->getSubCateByPid($cate_id);
        foreach ($sub_cate_ids as $item){
          array_push($cate_ids,$item['cate_id']);
        }

      }else{
        $this->returnData(array("statu" => 1, "ArticleList" => '', 'Info'=>'未知错误,信息获取失败!!!'));
      }

      // 实例化bg_Article表模型对象
      $Article = Factory::M('ArticleModel');
      $ArticleList = $Article->getArtByIds($cate_ids);

      $ArtListNum = count($ArticleList);
      for($i=0; $i < $ArtListNum; $i ++){
        $ArticleList[$i]["addtime"] = date("Y-m-d H:i:s",$ArticleList[$i]["addtime"]);
        $ArticleList[$i]["thumb"] = "http://localhost/myblog/php/Uploads/thumb/" . $ArticleList[$i]["thumb"];
      }

      $this->returnData(array("statu" => 0, "ArticleList" => $ArticleList, 'Info'=>'信息获取成功!!!'));
    }


    /**
     * 点击喜欢 +1
     */
    public function addHeartAction(){
      $art_id = $_POST['art_id'];

      $Article = Factory::M('ArticleModel');
      $result = $Article->updateHits($art_id);
      if($result){
        $this->returnData(array("statu" => 0, 'Info'=>'点赞成功!!!'));
      }else{
        $this->returnData(array("statu" => 1, 'Info'=>'点赞失败!!!'));
      }
    }


  }

?>