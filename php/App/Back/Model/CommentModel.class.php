<?php
/**
 * 后台评论表操作模型
 */

class CommentModel extends Model{

  /**
   * 获取一级评论信息
   */
  public function getFirstCmt($art_ids=''){
    $sql = "select a.*,c.title from bg_comment as a left join bg_article as c on a.art_id=c.art_id ";
    if($art_ids == ''){
      $sql .= "where a.cmt_pid=0 order by cmt_time desc";
    }else{
      $sql .= "where a.art_id in($art_ids) and a.cmt_pid=0 order by cmt_time desc";
    }
    return $this->dao->fetchAll($sql);
  }

  /**
   * 获取二级评论
   */
  public function getSubCmt($pid){
    $sql = "select a.*,c.title from bg_comment as a left join bg_article as c on a.art_id=c.art_id  where a.cmt_pid=$pid order by cmt_time ASC ";
    return $this->dao->fetchAll($sql);
  }

  /**
   * 根据ids批量删除评论
   */
  public function delCmtByIds($cmt_ids){
    $sql = "delete from bg_comment where cmt_id in($cmt_ids)";
    return $this->dao->my_query($sql);
  }

  /**
   * 根据id删除单条评论
   */
  public function delCmtById($cmt_id){
    $sql = "delete from bg_comment where cmt_id=$cmt_id";
    return $this->dao->my_query($sql);
  }


}

?>