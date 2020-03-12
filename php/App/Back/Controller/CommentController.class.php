<?php

/**
 * 后台评论管理控制器
 */

class CommentController extends PlatformController{

  /**
   * 获取评论信息
   */
  public function IndexAction(){
    $pageSize = $_POST['pageSize'];
    $pageNum = $_POST['pageNum'];
    $search = $this->escapeData($_POST['search']);

    // 实例化模型类
    $model = Factory::M('CommentModel');

    $result = array();
    if($search == ''){
      // 1. 获取所有的一级评论
      $first =  $model->getFirstCmt();

    }else{
      // 1. 获取所有一级评论
      // 实例化文章模型
      $article = Factory::M('ArticleModel');
      $res = $article->getArtId($search);
      $art_ids = array();
      foreach($res as $row){
        array_push($art_ids, $row['art_id']);
      }
      if(count($art_ids) == 0){
        $this->returnData(array("statu" => 0, 'total' => 0, "Info" => $art_ids));
      }
      $art_ids = implode(",", $art_ids);
      $first =  $model->getFirstCmt($art_ids);
    }

    // 2. 获取所有的二级评论
    for($i = 0; $i < count($first); $i++){
      // 格式化评论时间
      $first[$i]["cmt_time"] = date("Y-m-d h:i:s",$first[$i]["cmt_time"]);
      array_push($result,$first[$i]);
      $second = $model->getSubCmt($first[$i]['cmt_id']);
      for($j=0; $j < count($second); $j++){
        // 格式化评论时间
        $second[$j]["cmt_time"] = date("Y-m-d h:i:s",$second[$j]["cmt_time"]);
        array_push($result,$second[$j]);
      }
    }

    // 获取总的评论数
    $total = count($result);
    $offest = ((int)$pageNum - 1) * (int)$pageSize;
    $result = array_splice($result,$offest,$pageSize);
    $this->returnData(array("statu" => 0, 'total' => $total, "Info" => $result)); 
  }

  /**
   * 批量删除评论信息
   */
  public function delAllAction(){
    // 1. 获取需要删除的评论id
    $cmt_ids = $_POST['cmt_ids'];

    // 2. 实例化模型
    $comment = Factory::M('CommentModel');
    $res = $comment->delCmtByIds($cmt_ids);
    if($res){
      $this->returnData(array("statu" => 0,  "Info" => "删除评论成功!!!"));   
    }else{
      $this->returnData(array("statu" => 0,  "Info" => "未知错误,删除评论失败!!!"));  
    }
  }

  /**
   * 删除单条评论信息
   */
  public function delAction(){
    $cmt_id = $_POST['cmt_id'];
    $comment = Factory::M('CommentModel');
    $res = $comment->delCmtById($cmt_id);
    if($res){
      $this->returnData(array("statu" => 0,  "Info" => "删除评论成功!!!"));
    }else{
      $this->returnData(array("statu" => 0,  "Info" => "未知错误,删除评论失败!!!"));
    }
  }

}

?>