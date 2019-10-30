<template>

  <div class="BackIndex-container">

    <a-layout  id="components-layout-demo-custom-trigger" style="height:101%">

      <a-layout-sider :trigger="null" collapsible v-model="collapsed" >
        <div class="logo">
            <i class="el-icon-s-home" @click="linkStart"> 开始 </i>
        </div>

          <a-menu theme="dark" mode="inline" >

            <a-menu-item key="1" :class="['a-menu-item-side', isactive ? 'bgcolor' : '']">
              <a-icon type="rest" style="font-size:20px;" />
              <a href="#" @click.prevent="jump('/Back/Category')">分类管理</a>
            </a-menu-item>

            <a-menu-item key="2" :class="['a-menu-item-side', isactive ? 'bgcolor' : '']">
              <a-icon type="file-word"  style="font-size:20px;"/>
              <a href="#" @click.prevent="jump('/Back/Article')">文章管理</a>
            </a-menu-item>

            <a-menu-item key="3" :class="['a-menu-item-side', isactive ? 'bgcolor' : '']"> 
              <a-icon type="like"  style="font-size:20px;" />
              <a href="#" @click.prevent="jump('/Back/comment')">评论管理</a>
            </a-menu-item>

            <a-menu-item key="4" :class="['a-menu-item-side', isactive ? 'bgcolor' : '']">
              <a-icon type="user"  style="font-size:20px;" />
              <a href="#" @click.prevent="jump('/Back/master')">站长管理</a>
            </a-menu-item>

            <a-menu-item key="5" :class="['a-menu-item-side', isactive ? 'bgcolor' : '']">
              <a-icon type="qq" style="font-size:20px;" />
              <a href="#" @click.prevent="jump('/Back/Links')">友情链接</a>
            </a-menu-item>

          </a-menu>

      </a-layout-sider>

      <a-layout >

        <a-layout-header style="background: #001529; padding: 0">

          <div class="header-container">

            <span>
              <!-- <a-icon class="trigger" :type="collapsed ? 'menu-unfold' : 'menu-fold'" @click="()=> collapsed = !collapsed" /> -->
            </span>

            <span style="padding-right:20px;">
              <a id="a-left" href="#" @click.prevent="linkHome">
                前往首页
              </a>
              

              <a id="a-right" href="#">注销登录</a>
            </span>

          </div>
        </a-layout-header>

        <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '700px' }">
          
          <!-- 路由嵌套 -->
          <router-view></router-view>
        </a-layout-content>

      </a-layout>

    </a-layout>
  </div>
</template>

<script>
export default {
  data(){
    return {
      collapsed: false,
      activeKeys:['0'],
      isactive : false,
    }
  },
  created(){
    // 页面加载,验证是否登录, 已登录默认去到Start页面, 未登录跳转到登录页面
    // this.$router.push({path : '/Back/Start'})
    
  },
  methods:{
    linkHome(){// 跳转到前台首页
      this.$router.push({path : '/Home/Start'})
    },
    linkStart(){
      this.$router.push({path : '/Back/Start'})
      this.isactive = true
    },
    jump(url){
      this.$router.push({path : url})
      this.isactive = false
    }
  }
}
</script>

<style lang="scss" scoped>

  .bgcolor{
    background-color: #001529 !important;
  }

  .BackIndex-container{

    width:100%;
    overflow-y:hidden;
    height:auto;

    #components-layout-demo-custom-trigger .trigger {
      font-size: 24px;
      line-height: 80px;
      padding: 0 24px;
      cursor: pointer;
      transition: color .3s;
    }

    #components-layout-demo-custom-trigger .trigger:hover {
      color: #1890ff;
    }

    #components-layout-demo-custom-trigger .a-menu-item-side{
      font-size: 15px;
    }

    #components-layout-demo-custom-trigger .header-container{
      display: flex;
      justify-content: space-between;
    }

    #components-layout-demo-custom-trigger .logo {
      font-size: 16px;
      text-align: center;
      width:100px;
      height: 34px;
      line-height:34px;
      background: rgba(255,255,255,.3); 
      margin: 20px;
      color:white;
      cursor:pointer;
    }

    #components-layout-demo-custom-trigger .logo:hover{
      background: rgba(255,255,255,.5);
    }

    a {
      color:white;
      font-size: 16px;
      display: inline-block;
      margin-right: 15px;
    }

    #a-left:hover{
      color:#67C23A;
    }

    #a-right:hover{
      color:#F56C6C;
    }

    a:link{
        text-decoration: none;
    }

    a:visited{
      text-decoration: none;
    }

    a:active{
      text-decoration: none;
      
    }

  }
</style>