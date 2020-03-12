<template>
  <div class="loginMoudle">

    <div class="loginblock">
      <div style="font-size:24px;text-align:center;height:50px;line-height:50px;color:#EEEEEE;margin-top:15px;">
        —— 博客系统登录 ——
      </div>
       
      <div class="loginline">
        <el-input placeholder="请输入用户名" prefix-icon="el-icon-user" size="medium" v-model="user"> </el-input>
      </div>

      <div class="loginline">
        <el-input placeholder="请输入密码" prefix-icon="el-icon-key" size="medium" v-model="passwd" show-password> </el-input>
      </div>

      <div class="loginline captcha">
        <el-input placeholder="请输入右侧的验证码" v-model="passcode">
          <img src="http://localhost/myblog/php/server.php?p=Home&c=Admin&a=captcha" onclick="this.src='http://localhost/myblog/php/server.php?p=Home&c=Admin&a=captcha&n='+Math.random()" width="102" height="40"  slot="suffix" >
          
        </el-input>
      </div>

      <div class="loginline">
        <el-button type="primary" style="width:100%" @click="login" >立即登录</el-button>
      </div>

      <div style="margin-top:10px;">
        <router-link tag="a" to="/Home/Passwd" class="link">忘记密码?</router-link>
        <router-link tag="a" to="/Home/Register" class="link">注册账号</router-link>
      </div>

    </div>

  </div>
</template>

<script>
  export default {
    data () {
      return {
          user : "", // 用户名
          passwd : "", // 密码
          passcode : "",  // 验证码
      }
    },
    methods : {
      login() {

        // 1. 验证信息是否合法
        if (this.user.length < 5){
          this.$message({
            showClose: true,
            message: '警告：用户名不能少于5位!',
            type: 'warning',
            offset: 150
          });
          return
        }else if(/[^\d\w_]+/.test(this.user)) {
          this.$message({
            showClose: true,
            message: '警告：用户名只能包含数字、下划线、字母!',
            type: 'warning',
            offset: 150
          });
          return
        }

        if (this.passwd.length == 0){
          this.$message({
            showClose: true,
            message: '警告：密码不能为空!',
            type: 'warning',
            offset: 150
          });
          return
        }

        if (this.passcode.length == 0){
          this.$message({
            showClose: true,
            message: '警告：验证码不能为空!',
            type: 'warning',
            offset: 150
          });
          return
        }

        // 2. 提交信息到后台验证
        this.$http.post('myblog/php/server.php?p=Home&c=Admin&a=check',{"user":this.user, "passwd": this.passwd, "passcode": this.passcode}).then(result => {
        // console.log(result.body)
          if (result.body.statu == 0){
            if (result.body.flag == "Success"){
                this.$message({
                showClose: true,
                message: '登录成功, 1s后跳转',
                type: 'success',
                offset: 150,
                duration : 1000
              });

              // 登录成功后,利用Vue-router进行跳转
              let hostName = this.$route.query.redirect;  // 获取域名
              var intervalId = null
              
              if (hostName === 'localhost') {   // 判断如果域名是你项目域名，说明是从本网站内部跳转过来的，
                intervalId = window.setTimeout(() => {
                  this.$router.go(-1) // 登录成功后，返回上次进入的页面；
                }, 1000)  
              }else{
                // 跳转到首页
                intervalId = window.setTimeout(() => {
                  this.$router.push({path : '/Home/start'})
                }, 1000)
              }
            }else{
              this.$message({
                showClose: true,
                message: result.body.info,
                type: 'error',
                offset: 150
              });
              return
            }
          }else{
            this.$message({
              showClose: true,
              message: '错误：登录失败!',
              type: 'error',
              offset: 150
            });
            return
          }
        })

      }
    }
  }
</script>

<style lang="scss" scoped>
  .loginMoudle {
    width:100%;
    min-height:100%;
    background-image:url(http://localhost/myblog/src/img/login.jpg);
    background-position: center;
    background-size: 100%;

    .captcha{
      position: relative;

      img{
        position:absolute;
        right:-4.7px;
        top:2.5px;
      }
    }

    .loginblock{
      padding: 8px 20px;
      position: absolute;
      top : 20%;
      left : 40%;
      width : 350px;
      height : 400px;
      border-radius: 10px;
      background-color: rgba(0,0,0,0.3);
      z-index: 1001;
      animation: fly 1s linear forwards;

      @keyframes fly {
        from{
          top : 40%;
          transform: scale(0); 
        }

        to{
          top : 20%;
          transform: scale(1);
        }

      }


      h3{
        color: #606266;
      }

      .loginline {
        height : 45px;
        line-height: 45px;
        margin-top : 15px;
        // border:1px solid red;

        .el-input{
          padding:100 !important;
        }
      }

      .link{
        display: inline-block;
        margin:0 10px;
        cursor: pointer;
        font-size:16px;
        text-decoration: none;
        color:#EEEEEE;
      }

      .link:hover{
        text-decoration: none;
        color:#F56C6C;
      }



    }
  }

</style>
