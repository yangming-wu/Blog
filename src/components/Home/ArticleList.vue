<template>

  <div class="ArtList-Container">

    <!-- 布局 -->
    <a-row type="flex" justify="center" align="top">

      <a-col :span="2"></a-col>

      <!-- content-left -->
      <a-col :span="15">
        
        <!-- 推荐文章 -->
        <div class="Articelcard" v-for="(item,index) in data" :key="index">
          <!-- 文章标题 -->
          <div style="font-size:16px;line-height:20px;margin:25px 0;">            
            <span style="display:inline-block;"><link-label :label="item.cate_name"></link-label></span>
            <router-link tag="span" :to="'/Home/Article/' + item.cate_name + '/' + item.art_id">
              <span style="display:inline-block;color:#39BB98;font-size:24px;vertical-align:bottom;cursor:pointer;padding-bottom:3px;box-sizing:border-box;">{{item.title}}</span>
            </router-link>
          </div>

          <!-- 内容部分 -->
          <div class="Art-content">

            <span>
              <img :src="item.thumb" alt="缩略图" >
            </span>

            <span style="padding:0 15px;font-size:16px;line-height:30px;color:#909399;">
              {{item.art_desc|formatArt_desc}}
            </span>
          </div>

          <!-- 文章统计 -->
          <div style="text-align:right;font-size:16px;color:#909399;padding-right:15px;">
            <span style="display:inline-block;margin-right:15px;">
              <i class="fa fa-user fa-lg" aria-hidden="true"></i> {{item.author}}
            </span>
            <span style="display:inline-block;margin-right:15px;">
              <i class="fa fa-clock-o fa-lg" aria-hidden="true"></i> {{item.addtime}}
            </span>
            <span style="display:inline-block;margin-right:15px;">
              <i class="fa fa-eye fa-lg" aria-hidden="true"></i> {{item.reply_nums}}浏览
            </span>
            <span style="display:inline-block;margin-right:15px;">
              <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> <span style="color:#39BB98;"> {{item.comments}}评论</span>
            </span>
            <!-- <span style="display:inline-block;margin-right:15px;cursor:pointer;">
              <i class="fa fa-heart-o fa-lg" style="color:#FD8C84;"></i> <span style="color:#FD8C84;"> {{item.hits}}喜欢</span>
            </span> -->

            <span style="cursor:pointer;position: relative;display:inline-block;margin-right:15px;" >
              <link-heart :art_id="item.art_id" :hits="item.hits" @func="show"></link-heart>
              <span :class="['add',showHeart == item.art_id ? 'addshow' : '']">+1</span>
            </span>

          </div>

        </div>



      </a-col>

      <!-- content-right -->
      <a-col :span="5" style="padding-left:20px;padding-top:20px;"> 
        <side-bar></side-bar> 
      </a-col>

      <a-col :span="2"></a-col>
      
    </a-row>
  </div>


</template>

<script>
import Sidebar from "./Subcomponents/Sidebar.vue"
import label from "./Subcomponents/label.vue"
import heart from "./Subcomponents/heart.vue"

export default {

  data(){
    return {
      cate_name:this.$route.params.cate_name,
      data : [],
      showHeart:''
    }
  },
  created(){
    this.initArticleList()
  },
  methods:{
    initArticleList(){
      this.$http.post("myblog/php/server.php?p=Home&c=ArticleList&a=Index",{'cate_name':this.cate_name}).then((result) => {
        if(result.body.statu == 0){
          this.data = result.body.ArticleList
        }else{
          this.$message.error("未知错误,获取信息失败!!!");
        }
      })
    },
    fetchData(newVal, oldVa){
      this.cate_name = newVal.params.cate_name
      this.initArticleList()
    },
    show(articleId){
      this.showHeart = articleId
    }
  },
  components:{
    "side-bar":Sidebar,
    "link-label":label,
    "link-heart":heart,
  },
  watch:{
     $route: "fetchData"
  },
  filters:{ // 定义私有过滤器
    formatArt_desc(input){
      if(input.length <= 150){
        return input + "..."
      }
      return input.substring(0,150) + "..."
    }
  }

}
</script>

<style lang="scss" scoped>
  .ArtList-Container{
    min-height:608px;

    .Articelcard{
      width:100%;
      height:275px;
      margin:20px 0;
      padding:10px;
      background-color: white;

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




      .Articelcard-inline{
        display: flex;
        justify-content: space-between;
        margin:15px;

        .sign{
          width:20px;
          color:white;
          display:inline-block;
          text-align:center;
          margin-right:10px;
        }
      }

      .Art-content{
        display: flex;
        justify-content: space-between;
      }
    }
  }


</style>