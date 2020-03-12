<template>
  <div class="loginMoudle">

    <div class="loginblock">

      <h3>后台管理系统登录</h3> 
      <div class="loginline">
        <el-input placeholder="请输入用户名" prefix-icon="el-icon-user" size="medium" v-model="user"> </el-input>
      </div>

      <div class="loginline">
        <el-input placeholder="请输入密码" prefix-icon="el-icon-key" size="medium" v-model="passwd" show-password> </el-input>
      </div>

      <div class="loginline">
        <el-input placeholder="请输入右侧的验证码" v-model="passcode" >

          
          <img src="http://localhost/myblog/php/server.php?p=Back&c=Admin&a=captcha" onclick="this.src='http://localhost/myblog/php/server.php?p=Back&c=Admin&a=captcha&n='+Math.random()" width="102" height="40"  slot="suffix" >
          
        </el-input>
      </div>

      <div class="loginline">
        <el-button type="primary" style="width:100%" @click="login" >立即登录</el-button>
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
        this.$http.post('myblog/php/server.php?p=Back&c=Admin&a=check',{"user":this.user, "passwd": this.passwd, "passcode": this.passcode}).then(result => {
        // console.log(result.body)
          if (result.body.statu == 0){
            if (result.body.flag == "Success"){
                this.$message({
                showClose: true,
                message: '登录成功, 1s后跳转到首页!',
                type: 'success',
                offset: 150,
                duration : 1000
              });

              // 跳转到首页
              var intervalId = window.setTimeout(() => {
                this.$router.push({path : '/Back'})
              }, 1000)

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
    height:100%;
    background-image: url(http://localhost/myblog/src/img/login.jpg);
    background-position: center;
    background-size: 100%;

    .loginblock{
      padding: 8px;
      position: absolute;
      top : 30%;
      left : 40%;
      width : 20%;
      height : 40%;
      border-radius: 10px;
      background: #F5F5F5;

      h3{
        color: #606266;
      }

      .loginline {
        height : 12%;
        margin-top : 15px;

        .el-input{
          padding:100 !important;
        }
      }
    }



  }


</style>