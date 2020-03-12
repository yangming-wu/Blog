<template>
  <div class="loginMoudle">

    <div class="loginblock">
      <div style="font-size:24px;text-align:center;height:40px;line-height:40px;color:#EEEEEE;margin-top:15px;">
        —— 博客系统账号注册 ——
      </div>
       
      <div class="loginline">
        <el-input placeholder="请输入用户名" prefix-icon="el-icon-user" size="medium" v-model="user"> </el-input>
      </div>

      <div class="loginline">
        <el-input placeholder="请输入密码" prefix-icon="el-icon-key" size="medium" v-model="passwd" show-password> </el-input>
      </div>

      <div class="loginline">
        <el-input placeholder="再次输入密码" prefix-icon="el-icon-s-tools" size="medium" v-model="passwd2" show-password> </el-input>
      </div>

      <div class="loginline captcha">
        <el-input placeholder="请输入右侧的验证码" v-model="passcode">
          <img src="http://localhost/myblog/php/server.php?p=Home&c=Admin&a=captcha" onclick="this.src='http://localhost/myblog/php/server.php?p=Home&c=Admin&a=captcha&n='+Math.random()" width="102" height="40"  slot="suffix" >
          
        </el-input>
      </div>

      <div class="loginline" style="height:75px;">
        <el-upload
          class="upload-demo"
          ref="upload"
          name="Photo"
          :on-success="uploadSucess"
          :on-error="uploadFailed"
          :auto-upload="false"
          action="http://localhost/myblog/php/server.php?p=Home&c=Admin&a=uploadImg"
        >
          <el-button slot="trigger"  type="primary">选取头像</el-button>
          <el-button style="margin-left: 10px;" type="success" @click="submitUpload">上传到服务器</el-button>
        </el-upload>
      </div>

      <div class="loginline">
        <el-button type="primary" style="width:100%" @click="register" >注册账号</el-button>
      </div>
    </div>

  </div>
</template>

<script>
  export default {
   
    data(){
      return {
        user:'', // 用户名
        passwd:'', // 密码
        passwd2:'', // 验证密码
        passcode:'', // 验证码
        img:'default.jpg', // 用户头像
      }
    },
    methods:{
     /**
      * 账号注册
      */
      register(){
        // 1. 验证信息是否合法
        if (this.user.length < 6 ||  this.user.length > 8){
          this.$message({
            showClose: true,
            message: '警告：用户名6-8位字符!',
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

        if(this.passwd2.length == 0){
          this.$message({
            showClose: true,
            message: '警告：请再次输入密码!',
            type: 'warning',
            offset: 150
          });
          return
        }else if(this.passwd2.length != this.passwd.length){
          this.$message({
            showClose: true,
            message: '警告：验证密码和密码不一致!',
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

        // 发送后台请求
        this.$http.post('myblog/php/server.php?p=Home&c=Admin&a=Register',{"user":this.user, "passwd": this.passwd, "passcode": this.passcode, "img":this.img})
          .then(result => {
            if(result.body.statu == 0){
              if (result.body.statu == 0){
                this.$message({
                showClose: true,
                message: '注册成功, 1s后跳转到登录界面',
                type: 'success',
                offset: 150,
                duration : 1000
              });

              // 注册成功, 1s后跳转到登录界面
              let intervalId = window.setTimeout(() => {
                this.$router.push({path : '/Home/Login'})
              }, 1000)
            }else{
              this.$message.error(result.body.info);
            }
          }
        })
      },
      /**
      * 上传头像到服务器
      */
      submitUpload(){
        this.$refs.upload.submit();
      },
      /**
       * 头像上传后的钩子函数
       */
      uploadSucess(res){
        if(res.statu == 0){ // 文件上传成功
          this.img = res.filename
        }else{
          this.$message.error(res.Info);
        }
      },
      /**
       * 文件上传失败的钩子函数
       */
      uploadFailed(err){
        this.$message.error(err);
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
      height : 450px;
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
        margin-top : 10px;
        // border:1px solid red;

        .el-input{
          padding:100 !important;
        }
      }
    }
  }

</style>