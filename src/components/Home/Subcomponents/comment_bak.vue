<template>
  <div class="cmt-container">
    <h3>发表评论</h3>
    <hr>
    <textarea placeholder="请输入要评论的内容 (做多吐槽120字) ..." v-model="msg"></textarea>

    <div style="margin:5px 0;text-align:right;">
      <el-button type="primary" size="large" @click="postComment">发表评论</el-button>
    </div>

    <!-- 评论列表 -->
    <div class="cmt-list">
      
      <div v-for="(item, i) in comments" :key="item.cmt_time" style="margin:15px 0;">
        <div style="float:left;width:8%;text-align:center;">
          <img src="http://localhost/myblog/src/img/Home/default.jpg" alt="" > <br>
          第{{i+1}}楼
        </div>
        <div style="float:left;width:92%;">
          <div class="out-div">
            <div class="arrow" ></div>   
            <span>{{item.cmt_content === 'undefined' ? '此用户很懒，嘛都没说': item.cmt_content}}</span>
            <div style="padding-top:10px;">
              用户：<span style="color:#6FC299">{{ item.cmt_user }}</span>&nbsp;&nbsp;发表时间：{{ item.cmt_time}}
            </div> 
          </div>
        </div>
        <div style="clear:both;"></div>
      </div>

      <div style="text-align:center;margin:10px 0;" v-show="showmore">
        <el-button type="danger" size="large" plain @click="getMore" style="width:50%;">加载更多</el-button>
      </div>
    </div>  
  </div>
</template>

<script>

export default {
  data() {
    return {
      pageIndex: 1, // 默认展示第一页数据
      comments: [], // 所有的评论数据
      art_id:this.id,
      msg: "", // 评论输入的内容
      showmore:false,
    };
  },
  created() {
    this.getComments();
  },
  methods: {
    getComments(flag='init') {
      // 获取评论
      this.$http
        .post("myblog/php/server.php?p=Home&c=SinglePage&a=getComment", {"art_id" : this.$route.params.art_id, "pageindex": this.pageIndex})
        .then(result => {
          if (result.body.statu === 0) {
            // 每当获取新评论数据的时候，不要把老数据清空覆盖，而是应该以老数据，拼接上新数据
            this.comments = this.comments.concat(result.body.Info);
            this.showmore = result.body.Info.length == 0 ? false : true;
          }else if(result.body.statu === 2 && flag == 'more'){
            this.$message({
              message: result.body.Info,
              type: 'warning'
            });
          }else {
            this.$message.error('获取评论信息失败!!!');
          }
        });
    },
    getMore() {
      // 加载更多
      this.pageIndex++;
      this.getComments('more');
    },
    postComment() {
      // 校验是否为空内容
      if (this.msg.trim().length === 0) {
        return this.$message.error('评论内容不能为空!!!');
      }

      // 发表评论
      // 参数1： 请求的URL地址
      // 参数2： 提交给服务器的数据对象 { content: this.msg }
      // 参数3： 定义提交时候，表单中数据的格式  { emulateJSON:true }
      this.$http
        .post("myblog/php/server.php?p=Home&c=SinglePage&a=postComment", {
          art_id: this.$route.params.art_id,
          content: this.msg.trim()
        })
        .then(function(result) {
          if (result.body.statu === 0 && result.body.flag == "Success") {
            var cmt = result.body.Info
            this.comments.unshift(cmt);
            this.msg = "";
          }else if(result.body.statu === 0 && result.body.flag == "Failed"){
            this.$confirm('您的账号未登录，不能进行评论, 是否登录账号?', '提示', {
              confirmButtonText: '确定',
              cancelButtonText: '取消',
              type: 'warning'
            }).then(() => {
              // 账号未登录,跳转到登录界面
              let intervalId = window.setTimeout(() => {
                this.$router.push({path : '/Home/Login',query:{redirect: location.hostname}})
              }, 1000)
            }).catch(() => {
              this.$message({
                type: 'info',
                message: '已取消登录'
              });          
            });
          }
        });
    }
  },
  props: ["id"]
};
</script>

<style lang="scss" scoped>
.cmt-container {
  h3 {
    font-size: 18px;
  }
  textarea {
    display:block;
    font-size: 14px;
    padding:10px;
    height: 85px;
    width: 100%;
    margin: 0;
  }

  .cmt-list {
    margin: 15px 0;

    .out-div {    
        display: inline-block;
        font-size:16px;
        color: #303133;   
        min-height: 30px;
        line-height:30px; 
        position: relative;  
        width: 100%;    
        text-align: left;  
        padding:10px; 
        border-radius: 5px;     
        vertical-align: top;   
        background-color: rgb(245,245,245);
        border:1px solid rgb(245,245,245);   
    }   
    .arrow {   
        width: 0px;   
        height: 0px;   
        border-top: 8px solid transparent;   
        border-right: 8px solid;   
        border-bottom: 8px solid transparent;   
        position: absolute;   
        margin-left: -18px;   
        margin-top: 15px;   
        border-right-color: rgb(245,245,245);   
    }




    .cmt-item {
      font-size: 13px;
      .cmt-title {
        line-height: 30px;
        background-color: #ccc;
      }
      .cmt-body {
        line-height: 35px;
        text-indent: 2em;
      }
    }
  }
}
</style>
