<?php

/**
 * 前台bg_article表操作模型
 */
class ArticleModel extends Model {


  /**
   * 获取热门文章 
   */
  public function getHotArt(){
    $sql = "select a.art_id,a.title,a.hits,c.cate_name from bg_article as a left join bg_category as c on  a.cate_id=c.cate_id where is_del='0' order by hits desc limit 0,5";
    return $this->dao->fetchAll($sql);
  }

  /**
   * 获取推荐文章 
   */
  public function getRecommentArt(){

    $pageNum = isset($_POST["pageNum"]) ? $_POST["pageNum"] : 1;
    $rowsPerPage = isset($_POST["pageSize"]) ? $_POST["pageNum"] : 10;
    $offset = ($pageNum - 1) * $rowsPerPage;

    $sql = "select a.art_id,a.title,a.art_desc,a.hits,a.thumb,a.author,a.reply_nums,a.addtime,a.comments,c.cate_name from bg_article as a left join bg_category as c on a.cate_id=c.cate_id where a.is_del='0' and a.is_recommend='1' order by addtime desc limit $offset,$rowsPerPage";

    return $this->dao->fetchAll($sql);
  }

  /**
   * 
   */
  public function getArtByIds($cate_ids){
    $pageNum = isset($_POST["pageNum"]) ? $_POST["pageNum"] : 1;
    $rowsPerPage = isset($_POST["pageSize"]) ? $_POST["pageNum"] : 10;
    $offset = ($pageNum - 1) * $rowsPerPage;

    $cate_ids = implode(',', $cate_ids);
    $sql = "select a.art_id,a.title,a.art_desc,a.hits,a.thumb,a.author,a.reply_nums,a.addtime,a.comments,c.cate_name from bg_article as a left join bg_category as c on a.cate_id=c.cate_id where a.is_del='0' and a.cate_id in ($cate_ids) order by addtime desc limit $offset,$rowsPerPage";
    
    return $this->dao->fetchAll($sql);
  }

  /**
   * 点击喜欢 +1
   */
  public function updateHits($art_id){
    $sql = "update bg_article set hits=hits+1 where art_id=$art_id";
    return $this->dao->my_query($sql);
  }

  /**
   * 更新评论数
   */
  public function updateCmtNums($art_id,$nums){
    $sql = "update bg_article set comments=$nums where art_id=$art_id";
    return $this->dao->my_query($sql);  
  }



  /**
   * 进入文章页面 浏览数+1
   */
  public function updateReplyNums($art_id){
    $sql = "update bg_article set reply_nums=reply_nums+1 where art_id=$art_id";
    return $this->dao->my_query($sql);
  }



  /**
   * 获取单页文章
   */
  public function getPageInfoById($art_id) {
		$sql = "select * from bg_article where art_id=$art_id";
		return $this->dao->fetchRow($sql);
	}

}


?>