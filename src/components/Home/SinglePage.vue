<template>
  <div class="Single-Container">

    <!-- 布局 -->
    <a-row type="flex" justify="center" align="top">

      <a-col :span="2"></a-col>

      <!-- content-left -->
      <a-col :span="15" style="background:white;" class="content">
        
        <!-- 您现在的位置 -->
        <div class="pos">
          <span style="display:inline-block;margin-right:30px;color:#909399;">您现在的位置:</span>  
          <router-link tag="span" to='/Home/start' class="sign" style="position:absolute;top:-2px;left:130px;">
            <i class="fa fa-home fa-lg"> </i>
          </router-link>
          <span style="display:inline-block;color:#909399;margin:0 5px;"> > </span> 
          <router-link tag="span" :to="'/Home/ArticleList/' + cate_name" class="sign">
            {{cate_name}}
          </router-link>

          <span style="display:inline-block;color:#909399;margin:0 5px;"> > {{data.title}}</span> 

        </div>

        <hr>

        <!-- 标题 -->
        <div class="title">
          <div style="font-size:28px;margin:10px 0;">{{data.title}}</div>
          <div style="font-size:16px;color:#909399;cursor:pointer;">
            <span style="display:inline-block;margin-right:20px;">
              <i class="fa fa-user fa-lg" aria-hidden="true"></i> {{data.author}}
            </span>
            <span style="display:inline-block;margin-right:20px;">
              <i class="fa fa-clock-o fa-lg" aria-hidden="true"></i> {{data.addtime}}
            </span>
            <span style="display:inline-block;margin-right:20px;">
              <i class="fa fa-eye fa-lg" aria-hidden="true"></i> {{data.reply_nums}}浏览
            </span>
            <span style="display:inline-block;margin-right:20px;">
              <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> <span style="color:#39BB98;"> {{data.comments}}评论</span>
            </span>

          </div>
        </div>

        <hr>

        <!-- 文章内容 -->
        <div class="art-content" v-html="data.content">
          {{data.content}}
        </div>

        <hr>

        <!-- 评论 -->
        <div class="comment">
          <comment :id="data.art_id"></comment>
        </div>
        
        <div style="height:50px;"></div>
      </a-col>

      <!-- content-right -->
      <a-col :span="5" style="padding-left:20px;"> 
        <side-bar></side-bar> 
      </a-col>

      <a-col :span="2"></a-col>
      
    </a-row>
    
  </div>
</template>


<script>
import Sidebar from "./Subcomponents/Sidebar.vue"
import comment from "./Subcomponents/comment.vue"
// import heart from "./Subcomponents/heart.vue"

export default {
  data(){
    return {
      cate_name:this.$route.params.cate_name,
      art_id:this.$route.params.art_id,
      data:[],
      showHeart:''
    }
  },
  created(){
    this.getData()
  },
  methods:{
    // 1. 页面加载,获取数据
    getData(){
      this.$http.post('myblog/php/server.php?p=Home&c=SinglePage&a=Index',{'art_id':this.art_id}).then(res => {
        if(res.body.statu == 0){
          this.data = res.body.Info
          this.data.hits = this.data.hits.toString()
        }else{
          this.$message.error('网络异常,页面内容获取失败!!!');
        }
      })
    },
    // show(articleId){
    //   this.showHeart = articleId
    // }

  },
  components:{
    "side-bar":Sidebar,
    'comment':comment,
    // "link-heart":heart,
  }
  
}
</script>

<style lang="scss" scoped>
  .Single-Container{
    .content{

      .pos{
        font-size:16px;
        padding:0 20px;
        margin:10px 0;
        position: relative;

        .sign{
          color:#6FC299;
          cursor: pointer;
          display:inline-block;
        }

      }

      .title{
        padding:0 20px;

        .add{
          color:red;
          position:absolute;
          left:30px;
          top:0;
          opacity: 0;
        }

        .addshow{
          animation: fly01 1s linear forwards;
        }

        // 定义动画
        @keyframes fly01 {
            0%{
                display:inline-block;
                opacity: 1;
            }
            100%{
                left:70px;
                top:-50px;
                opacity: 0;
            }
        }
      }

      .art-content{
        padding:0 20px;
      }

      .comment{
        padding:0 20px;
      }

    }
  }
    

</style>