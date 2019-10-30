<template>
  <div class="Start-container">
    <el-row>
      <el-col :span="6" style="height:230px;">
        <div class="left-up">
          <div class="touxiang">
            <img src="http://localhost/myblog/src/img/thumb.jpg" alt="">
            <p style="font-size:16px;">Admin</p>
          </div>

          <div class="left-up-info">
            <p style="color:#909399;">您好，Admin，这是您第1次登录，上次登录时间为2019-09-04，上次登录的IP为192.168.0.62</p>
          </div>

        </div>
      </el-col>

      <el-col :span="17" style="height:230px;">
        <div class="right-up" >
          <div class="right-up-tip">
            <a-alert
              message="提示: 欢迎使用博客系统..."
              type="info"
              :style="{'font-size':'16px'}"
              closable
            />
          </div>

          <div class="right-up-txt">
            <p style="font-size:15px;color:#909399;">该系统前端使用Vue框架,后端使用修改的基于PHP的MVC框架,将MVC的视图层交给前端,后端负责提供数据接口...</p>
          </div>

          <div class="right-up-link">
            
            <a href="#" style="background:#409EFF;"><i class="el-icon-download"> 下载示例代码</i></a>
            <a href="#" style="background:#EBB563;"><i class="el-icon-download"> 下载框架</i></a>
            <a href="#" style="background:#909399;"><i class="el-icon-view"> 查看教程</i></a>

          </div>

        </div>
      </el-col>
    </el-row>

    <el-row>
      <el-col :span="6" >
        <a-card title="站点统计" :bordered="true" :headStyle="{'font-size':'12px','font-weight':'bold','background':'#F5F5F5'}"  style="width: 100%">
          <!-- <p class="align-inline" >
            <span><i class="el-icon-user-solid" style="font-size:14px;"> 会员</i></span>
            <span><a-badge count="25"  /></span>
          </p> -->

          <a-card-grid style="width:100%;padding:15px;" class="align-inline">
            <span><i class="el-icon-user-solid" style="font-size:14px;"> 会员</i></span>
            <span><a-badge count="25"  /></span>
          </a-card-grid>

          <a-card-grid style="width:100%;padding:15px;" class="align-inline">
            <span><i class="el-icon-document" style="font-size:14px;"> 文章</i></span>
            <span><a-badge count="888"  :overflowCount="2000"/></span>
          </a-card-grid>

          <a-card-grid style="width:100%;padding:15px;" class="align-inline">
            <span><i class="el-icon-edit" style="font-size:14px;"> 评论</i></span>
            <span><a-badge count="1000"  :overflowCount="2000" :numberStyle= "{backgroundColor: '#52c41a'} "/></span>
          </a-card-grid>

          <a-card-grid style="width:100%;padding:15px;" class="align-inline">
            <span><i class="el-icon-coin" style="font-size:14px;"> 数据库</i></span>
            <span><a-badge count="25" /></span>
          </a-card-grid>
        </a-card>
      </el-col>
      <el-col :span="17">
        <div class="right-down" >
          <table class="table" style="border:1px solid #E4E7ED;width:100%;">
            <tr><td colspan="4" style="background:#F5F5F5;font-weight:bold;">系统信息</td></tr>
            <tr><td>操作系统：</td>  <td>  </td> <td>系统开发：</td><td><a href="#" target="_blank">ICFrame框架</a></td></tr>
            <tr><td>Web服务器：</td><td></td><td>主页：</td><td><a href="#" target="_blank">#</a></td></tr>
            <tr><td>服务器IP：</td><td></td><td>演示：</td><td><a href="#" target="_blank">http://www.blog.com</a></td></tr>
            <tr><td>数据库：</td><td>MySQL</td><td>群交流：</td><td><a href="#" target="_blank">12345678</a> (点击加入)</td></tr>
          </table>
        </div>
      </el-col>
    </el-row>

  </div>
</template>


<script>
export default {

  data(){
    return {

    }
  },
  methods:{
    
  }
  
}
</script>

<style lang="scss" scoped>
  .Start-container{

    margin-top:3%;

    .el-row {
      margin-top: 20px;
      &:last-child {
      margin-top: 20px;
      }
    }
    .el-col {
      height: 270px;
      margin-left: 20px;
      border-radius: 4px;
      padding:0px;
      
      // border:1px solid #F2F9FD;
    }

    .align-inline{
      display: flex;
      justify-content: space-between;
      font-weight: bold;
      font-size: 12px;
      vertical-align : bottom;
    }

    hr{
      margin-top:10px;
      margin-bottom:10px;
    }

    .left-up{
      width:100%;
      height:100%;
      padding:0px;
      text-align: center;
      border:1px solid #DCDFE6;

      .touxiang{
        height:75%;
        padding-top:20px;

        img{
          height:120px;
          border-radius:50%;
          margin-left:auto;
          margin-right:auto;
        }
      }

      .left-up-info{
        height:25%;
        text-align: left;
        font-size: 12px;
        line-height:20px;
        padding:10px;
        background-color: #E6F2FB;
      }
    }

    .right-up{
      width:100%;
      height:100%;
      padding:15px;
      background-color:#F5F5F5;

      .right-up-tip{
        height:30%;
      }

      .right-up-txt{
        height:40%;
        line-height: 25px;
      }

      .right-up-link{
        height:30%;
        
        a{
          display:inline-block;
          margin-right:15px;
          // border:1px solid red;
          text-align:center;
          color:white;
          line-height:40px;
          border-radius:5px;
          height:40px;
          width:160px;
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

    }

    .right-down{
      font-size: 14px;

      .table td{
        border-bottom: 1px solid #E4E7ED;
        height:50px;
        font-size:14px;
        padding-left:10px;
        line-height:50px;
      }
    }

    
    
  }

</style>