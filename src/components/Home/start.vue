<template>
  <div class="start-container">

  
    <!-- 布局 -->
    <a-row type="flex" justify="center" align="top">

      <a-col :span="2"></a-col>

      <!-- content-left -->
      <a-col :span="15">
        <!-- 头部轮播区域 -->
        <div style="background:white;margin-top:10px;">
          <rotation-chart></rotation-chart>
        </div>

        <!-- 热门排行榜 -->
        <div class="Articelcard" style="height:255px;">
          <span style="color:green;font-size:18px;">热门排行榜</span>
          <hr style=" border: 0; border-bottom: 1px solid green;">

          <div class="Articelcard-inline" v-for="(item,index) in data.HotArt" :key="index">
            <span style="vertical-align:bottom;">
              <span class="sign" :style="{'background-color': colorList[index]}">{{index + 1}}</span>
              <router-link tag="span" :to="'/Home/Article/' + item.cate_name + '/'+ item.art_id">
                <span style="color:#00A67C;font-size:16px;display:inline:block;cursor:pointer;">{{item.title}}</span>
              </router-link>
            </span>
            <span style="cursor:pointer;position: relative;display:inline-block;" >
              <link-heart :art_id="item.art_id" :hits="item.hits"  @func="show"></link-heart>
              <span :class="['add',showHeart == item.art_id ? 'addshow' : '']">+1</span>
            </span>
          </div>
        </div>
        
        <div style="background-color:white;height:70px;line-height:40px;font-size:16px;padding:15px;">
          <span style="display:inline-block;background:#6FC299;color:white;width:100px;text-align:center;">文章推荐</span>
        </div>


        <!-- 推荐文章 -->
        <div class="Articelcard" v-for="(item,index) in data.Recomment" :key="index" @mouseover="changeImg(item.art_id)">
          <!-- 文章标题 -->
          <div style="font-size:16px;line-height:20px;margin:5px 0;">
            <span style="display:inline-block;"><link-label :label="item.cate_name"></link-label></span>
            <router-link tag="span" :to="'/Home/Article/' + item.cate_name + '/' + item.art_id">
              <span style="display:inline-block;color:#39BB98;font-size:24px;vertical-align:bottom;cursor:pointer;padding-bottom:3px;box-sizing:border-box;">{{item.title}}</span>
            </router-link>
          </div>

          <!-- 内容部分 -->
          <div class="Art-content">

            <span>
              <img :src="item.thumb" :class="[showthumb == item.art_id ?'thumb':'']" alt="缩略图" >
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

            <span style="cursor:pointer;position: relative;display:inline-block;margin-right:15px;" >
              <link-heart :art_id="item.art_id" :hits="item.hits" @func="show"></link-heart>
              <span :class="['add',showHeart == item.art_id ? 'addshow' : '']">+1</span>
            </span>
          </div>
        </div>
      </a-col>

      <!-- content-right -->
      <a-col :span="5" style="padding-left:20px;padding-top:10px;"> 
        <side-bar></side-bar> 
      </a-col>

      <a-col :span="2"></a-col>
      
    </a-row>

  </div>
</template>

<script>
import RotationChart from "./Subcomponents/RotationChart.vue"
import Sidebar from "./Subcomponents/Sidebar.vue"
import heart from "./Subcomponents/heart.vue"
import label from "./Subcomponents/label.vue"

export default {

	data(){
		return {
      data : {
        "HotArt" : [],
        "Recomment" : [],
      },
      colorList : ['#FD8C84', '#6FC299', '#818FFC', '#999999', '#999999'],
      showHeart:'',
      showthumb:''
		}
  },
  created(){
    // 页面加载,自动获取首页数据
    this.getData()
  },
	methods:{
    
    // 1. 获取首页数据
    getData(){
      this.$http.post("myblog/php/server.php?p=Home&c=Index&a=Start").then((result) => {
        if(result.body.statu == 0){
          this.data.HotArt = result.body.data.HotArt
          this.data.Recomment = result.body.data.Recomment
        }else{
          this.$message.error('发生未知错误,页面内容获取失败!!!');
        }
      })
    },
    show(articleId){
      this.showHeart = articleId
    },
    changeImg(articleId){
      // console.log(articleId)
      this.showthumb = articleId
    }
  },
  components:{
    "rotation-chart":RotationChart,
    "side-bar":Sidebar,
    "link-heart":heart,
    "link-label":label
    
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
	
  .start-container{
		width:100%;
    height:100%;

    .ball{
      width: 15px;
      height: 15px;
      line-height:15px;
      border-radius: 50%;
      background-color: red;
      font-size: 8px;
      text-align: center;
      color:white;
      z-index: 99;
      position: absolute;
      left:1200px;
    }

    .Articelcard{
      width:100%;
      height:220px;
      margin:10px 0;
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
        margin:12px;

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

        .thumb{
          border-radius: 5px;
          animation: large 1s linear;
        }

        @keyframes large{
          0%{
            transform: scale(1);
          }
          50%{
            transform: scale(0.98);
          }
          100%{
            transform: scale(1);
          }
        }

      }


    }
		
    
    
    
  }
</style>