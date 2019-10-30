<template>

  <div class="Sidebar-Container">

    <!-- 我的名片 -->
    <div style="height:220px;margin-bottom:15px;line-height:85px;background-color:#585757;padding:0 20px;">
      <!-- 名片信息 -->
      <div class="idcard">
        <div class="name">我的名片</div>
        <div class="line">
          <i class="fa fa-user-circle-o fa-lg" aria-hidden="true"> 姓名: 吴杨名</i>
        </div>
        <div class="line">
          <i class="fa fa-desktop fa-lg" aria-hidden="true"> 职业: 生物信息工程师</i>
        </div>
        <div class="line">
          <i class="fa fa-twitter-square fa-lg" aria-hidden="true"> 现居: 广东省-广州市</i>
        </div>
      </div>

      <!-- 链接图标 -->
      <ul class="link-list">
        <!-- QQ链接 -->
        <li @mouseover="showSign='QQ'" @mouseout="showSign=''">
          <img class="tubiao" src="http://localhost/myblog/src/img/Home/QQ.png" alt="">
          <!-- 标签 -->
          <ul class="submenu" v-show="showSign == 'QQ'">
            <div class="out-div">
              <div class="arrow" ></div>
              <span> 腾讯QQ </span>   
            </div>
          </ul>
        </li>

        <!-- 微信链接 -->
        <li @mouseover="showSign='weixin'" @mouseout="showSign=''">
          <img class="tubiao" src="http://localhost/myblog/src/img/Home/Weixin.png" alt="" >
          
          <!-- 微信二维码 -->
          <ul class="weixin" v-show="showSign == 'weixin'">
            <div class="out-div">
              <div class="arrow" ></div>
              <img src="http://localhost/myblog/src/img/Home/00-wx.jpg" alt="">   
            </div>
          </ul>
        </li>
        
        <!-- 邮箱链接 -->
        <li  @mouseover="showSign='Email'" @mouseout="showSign=''">
          <a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=1073509605@qq.com" target="_blank">
          <img class="tubiao" src="http://localhost/myblog/src/img/Home/Email.png" alt="">
          </a>
          <!-- 标签 -->
          <ul class="submenu" v-show="showSign == 'Email'">
            <div class="out-div">
              <div class="arrow" ></div>
              <span> QQ邮箱 </span>   
            </div>
          </ul>
        </li>

        <!-- GitHub链接 -->
        <li @mouseover="showSign='GitHub'" @mouseout="showSign=''">
          <a href="https://github.com/yangming-wu" target="_blank">
            <img class="tubiao" src="http://localhost/myblog/src/img/Home/GitHub.png" alt="">
          </a>
          <!-- 标签 -->
          <ul class="submenu" v-show="showSign == 'GitHub'">
            <div class="out-div">
              <div class="arrow" ></div>
              <span> GitHub </span>   
            </div>
          </ul>
        </li>

      </ul>

    </div>

    <!-- 清除浮动 -->
    <div style="clear:both;"> </div>

    <!-- 日历组件 -->
    <div style="margin-bottom:15px;background-color:white;height:330px;">
      <calendar></calendar>
    </div>

    <!-- 清除浮动 -->
    <div style="clear:both;"> </div>

    <!-- 友情链接 -->
    <div class="blog-link" style="min-height:200px;margin-bottom:15px;background-color:white;padding:0 20px;">
      <div class="friend">友情链接</div>

      <div class="link">我的链接1</div>
      <div class="link">我的链接2</div>
      <div class="link">我的链接3</div>
      
      <div class="link">我的链接1</div>
      <div class="link">我的链接2</div>
      <div class="link">我的链接3</div>

      <div class="link">我的链接1</div>
      <div class="link">我的链接2</div>
      <div class="link">我的链接3</div>

      <div class="link">我的链接1</div>
      <div class="link">我的链接2</div>
      <div class="link">我的链接3</div>

      <div class="link">我的链接1</div>
      <div class="link">我的链接2</div>
      <div class="link">我的链接3</div>

      <div class="link">我的链接1</div>
      <div class="link">我的链接2</div>
      <div class="link">我的链接3</div>

    </div>

  </div>

</template>

<script>
import calendar from './calendar.vue'

export default {
  
  data(){
    return {
      showSign : '', // 用于控制侧边栏上方链接图标弹出框的显示
      
    }
  },
  created(){

  },
  methods:{
    

  },
  components:{
    'calendar':calendar
  }


}
</script>

<style lang="scss" scoped>
  .Sidebar-Container{

    .idcard{
      height:150px;

      .name{
        padding-top:15px;
        font-size:20px;
        color:#89919A;
        line-height:40px;
      }

      .line{
        padding-left:15px;
        height:20px;
        line-height:20px;
        margin:15px 0;
        font-size:10px;
        color:white;
        letter-spacing:2px;
        font-family:Source Han Sans CN !important;
      }

    }
    
    .blog-link{
      text-align:center;
      .friend{
        padding-top:10px;
        font-size:16px;
        line-height:40px;
        text-align:left;
        border-bottom:1px solid #6FC299;
      }

      .link{
        display:inline-block;
        width:45%;
        text-align:center;
        height:40px;
        line-height:40px;
        font-size:14px;
        color: #F56C6C;
        margin:5px 5px;
        border-bottom:1px solid #E4E7ED;
        opacity: 0.8;
        cursor: pointer;
      }

      .link:hover{
        opacity: 1;
        background-color: #E4E7ED 
      }



    }


    .link-list{
      list-style: none;

      .tubiao{
        border-radius: 25%;
        border:1px solid #2A2A2A;
        opacity: 0.8;
        transform: scale(0.8);
      }

      .tubiao:hover{
        opacity: 1;
      }
      
    }

    .link-list li{
      float: left;
      margin-right:10px;
      position: relative;

      .weixin{
        z-index: 99;
        position: absolute;
        top:70px;
        left:-80px;
        .out-div {    
            display: inline-block;
            font-size:12px;
            color:#FFFFFF;   
            height: 200px;   
            width: 200px;  
            text-align: center;   
            border-radius: 5px;     
            vertical-align: center;
            padding-top:10px;   
            background-color: #E35A48;
            border:1px solid  #E35A48;
            opacity: 0.8;
    
          .arrow {   
              width: 0px;   
              height: 0px;   
              border-left: 8px solid transparent;   
              border-bottom: 8px solid;   
              border-right: 8px solid transparent;   
              position: absolute;   
              margin-left: 100px;   
              margin-top: -19px;   
              border-bottom-color: #E35A48; 
          }
        } 
      }

      .submenu{
        z-index: 99;
        position: absolute;
        top:-42px;
        left:-12px;
        .out-div {    
            display: inline-block;
            font-size:12px;
            color:#FFFFFF;   
            height: 30px;
            line-height:30px;   
            width: 80px;    
            text-align: center;   
            border-radius: 5px;     
            vertical-align: center;   
            background-color: #3B9C86;
            border:1px solid #3B9C86;
    
          .arrow {   
              width: 0px;   
              height: 0px;   
              border-left: 8px solid transparent;   
              border-top: 8px solid;   
              border-right: 8px solid transparent;   
              position: absolute;   
              margin-left: 32px;   
              margin-top: 29px;   
              border-top-color: #3B9C86; 
          }
        } 
      }
    }

    
      
  }  

</style>