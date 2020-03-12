<?php

/**
 * 前台bg_article表操作模型
 */

 class CommentModel extends Model {

  /**
   * 获取一级评论
   */
  public function getfirstComments($art_id,$pageindex){
    $offset = ($pageindex - 1) * 5;
    $sql = "select * from bg_comment where art_id=$art_id and cmt_pid=0 order by cmt_time desc limit $offset,5";
    return $this->dao->fetchAll($sql);
  }

  /**
  * 获取当前评论下的子评论
  */
  public function getSubCateByPid($pid) {
    $sql = "select * from bg_comment where cmt_pid=$pid order by cmt_time ASC ";
    return $this->dao->fetchAll($sql);
  }




  /**
   * 提交评论 
   */
  public function submitCmt($pid,$art_id,$cmt_user,$replyer,$content,$cmt_time){
    $sql = "insert into bg_comment values(null,$pid,$art_id,'$cmt_user','$replyer','$content',$cmt_time)";
    return $this->dao->my_query($sql);
  }

  /**
   * 获取一级评论总数
   */
  public function getCmtNums($art_id){
    $sql = "select count(*) from bg_comment where art_id=$art_id and cmt_pid=0";
    return $this->dao->fetchColumn($sql);
  }

  /**
   * 获取文章的评论总数
   */
  public function getAllCmtNums($art_id){
    $sql = "select count(*) from bg_comment where art_id=$art_id";
    return $this->dao->fetchColumn($sql);
  }

  /**
   * 获取评论id
   */
  public function getCmtId($art_id,$cmt_user,$content,$cmt_time){
    $sql = "select cmt_id from bg_comment where art_id=$art_id and cmt_user='$cmt_user' and cmt_content='$content' and cmt_time=$cmt_time";
    return $this->dao->fetchColumn($sql);
  }

 }

?>