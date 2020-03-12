<?php

  /**
   * 单页文章
   */
  class SinglePageController extends PlatformController{

    /**
     * 获取页面信息
     */
    public function IndexAction(){

      $art_id = $_POST['art_id'];
      $Article = Factory::M('ArticleModel');
      $res =  $Article->updateReplyNums($art_id);
      if($res){
        $ArticleInfo = $Article->getPageInfoById($art_id);
        if($ArticleInfo){
          $ArticleInfo["addtime"] = date("Y-m-d h:i:s",$ArticleInfo["addtime"]); # 格式化时间
          $ArticleInfo["thumb"] = "/php/Uploads/thumb/" . $ArticleInfo["thumb"]; # 缩略图
          $this->returnData(array("statu" => 0, "Info" => $ArticleInfo));
        }else{
          $this->returnData(array("statu" => 1, "Info" => "未知错误,内容获取失败!!!"));
        }
      }else{
        $this->returnData(array("statu" => 1, "Info" => "未知错误,内容获取失败!!!"));
      }
    }

    /**
     * 获取文章评论
     */
    public function getCommentAction(){
      $art_id = $_POST['art_id'];
      $pageindex = $_POST['pageindex'];

      $Comment = Factory::M('CommentModel');

      // 实例化模型
		  $admin = Factory::M('AdminModel');

      // 获取评论总数
      $allNums = $Comment->getCmtNums($art_id);
      if($pageindex > ceil($allNums/5) && $allNums/5 != 0){
        $this->returnData(array("statu" => 2, "Info" => "没有更多评论,人家是有底线的~"));
      }

      // 获取所有的一级评论
      $cmt_info = $Comment->getfirstComments($art_id,$pageindex);
      $commentNum = count($cmt_info);
      if($cmt_info || $commentNum == 0){
        for($i=0; $i < $commentNum; $i ++){
          $cmt_info[$i]["cmt_time"] = date("Y-m-d h:i:s",$cmt_info[$i]["cmt_time"]);
          // 获取用户头像
          $img = $admin->getImgByUser($cmt_info[$i]["cmt_user"]);
          $cmt_info[$i]["cmt_user_img"] = $img ? 'http://localhost/myblog/php/Uploads/User/' . $img : 'http://localhost/myblog/php/Uploads/User/default.jpg';
          $cmt_info[$i]["isSelected"] = false;

          // 获取所有评论的子评论
          $childCmt = $Comment->getSubCateByPid($cmt_info[$i]['cmt_id']);
          for($j=0; $j < count($childCmt); $j++){
            $childCmt[$j]["cmt_time"] = date("Y-m-d h:i:s",$childCmt[$j]["cmt_time"]);
            $subimg = $admin->getImgByUser($childCmt[$j]["cmt_user"]);
            $childCmt[$j]["cmt_user_img"] = $subimg ? 'http://localhost/myblog/php/Uploads/User/' . $subimg : 'http://localhost/myblog/php/Uploads/User/default.jpg';
            $childCmt[$j]["isSelected"] = false;
          }
          $cmt_info[$i]["replyers"] = $childCmt;
        }
        $this->returnData(array("statu" => 0, "Info" => $cmt_info)); 
      }else{
        $this->returnData(array("statu" => 1, "Info" => "未知错误,评论获取失败!!!"));  
      }

    }

    /**
     * 提交评论
     */
    public function postCommentAction(){
      $art_id = $_POST["art_id"];
      $cmt_time = time();
      $content = $_POST["content"];

      // 获取用户名
      @session_start();
      $cmt_user = $_SESSION['Member']['user_name'];
      $cmt_user_img = $_SESSION['Member']['user_image'];

      $replyer = isset($_POST['replyer']) ? $_POST['replyer'] : $cmt_user;
      $pid = isset($_POST['pid']) ? $_POST['pid']: 0;

      // 提交评论
      $Comment = Factory::M('CommentModel');
      $result = $Comment->submitCmt($pid,$art_id,$cmt_user,$replyer,$content,$cmt_time);
      if($result){
        // 获取评论 id
        $cmt_id = $Comment->getCmtId($art_id,$cmt_user,$content,$cmt_time);
        $info = array(
          "cmt_id" => $cmt_id,
          "cmt_user" => $cmt_user,
          'replyer' => $replyer,
          "cmt_user_img" => "http://localhost/myblog/php/Uploads/User/" . $cmt_user_img, 
          "cmt_time" => date("Y-m-d h:i:s",$cmt_time),
          'cmt_content' => $content,
          'replyers' => array()
        );
        // 更新文章表单评论数
        $allNums = $Comment->getAllCmtNums($art_id);
        $Article = Factory::M('ArticleModel');
        $res = $Article->updateCmtNums($art_id,$allNums);
        if($res){
          $this->returnData(array("statu" => 0, "flag" => "Success", "Info" => $info));
        }else{
          $this->returnData(array("statu" => 1, "flag" => "Success", "Info" => "未知错误,更新评论数失败!!!"));
        }
      }else{
        $this->returnData(array("statu" => 1, "flag" => "Success", "Info" => "未知错误,提交评论失败!!!"));
      }
    }

    /**
     * 验证用户是否登录
     */
    public function checkAction(){
      $this->returnData(array("statu" => 0, "flag" => "Success"));
    }

  }

?>