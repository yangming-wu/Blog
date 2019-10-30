<template>
  <div class="addArt-container">
    <div class="panel panel-success">
      <div class="panel-heading"><strong>添加文章</strong></div>
      <div class="panel-body">
        <div>
          <form class="form-inline" role="form">
            <div class="line"> 
              <label class="labelStyle" for="name">文章标题</label>
              <input type="text" class="input form-control" id="art_title" name="art_title" size="50" placeholder="请填写文章标题..."  v-model="ArtInfo.title" />
            </div>

            <!-- 文件上传 -->
            <div class="line">
              <label class="labelStyle" for="name" style="float:left;width:4.5%;line-height:35px;">缩略图</label>
            
              <div style="float:left;width:50%;">
                <el-upload  action="http://localhost/myblog/php/server.php?p=Back&c=Article&a=uploadThumb"
                    :name="uploadThumb"
                    :show-file-list="false"
                    :on-success="handleAvatarSuccess"
                    :on-error="handleAvatarError"
                >
                <el-button size="small" type="primary">点击上传图片</el-button>    
              </el-upload>
              
              </div>
              <div style="clear:both;"></div>
            </div>

            <div class="line"> 
              <label class="labelStyle" for="name">文章作者</label>
              <input type="text" class="input form-control" id="art_author" name="art_author" size="50" placeholder="请填写文章作者..."  v-model="ArtInfo.author" />
            </div>

            <div class="line"> 
              <label class="labelStyle" for="name">所属类别</label>
              <select class="form-control selectStyle" ref="Option">
                <option value="0">主类别</option>
                <option v-for="item in cateInfo"  :key="item.cate_id" :selected="item.selected" :value="item.cate_id">{{item.cate_name | formatCate_name(item.level) }}</option>
              </select>
            </div>

            <!-- 文章描述 -->
            <div class="line">
              <div style="float:left;"><label for="name" class="labelStyle">文章描述</label></div>
              <div style="float:left;width:90%;"><a-textarea name="name" placeholder="请填写文章描述..."  rows="4"  style="width:100%;margin-left:14px;" v-model="ArtInfo.art_desc" /></div>
              <div style="clear:both;"></div>
            </div>

            <!-- 文章内容 -->
            <div class="line">
              <div style="float:left;">
                <label for="name" class="labelStyle">文章内容</label>
              </div>

              <div id="addArt-container" style="width:90%;float:left;margin-left:14px;">
                <textarea id="editor" rows="10" cols="80"  >
                </textarea>
              </div>

              <div style="clear:both;"></div>
            </div> 

            <div class="line"> 
              <el-button type="primary" size="small" style="margin-left:70px;" @click="dealAdd">提交</el-button>
            </div>

          </form>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  export default{
    name:'addArt-container',
    data(){
      return {
        editor:"",
        cateInfo:[],
        uploadThumb:"thumb",
        ArtInfo:{
          title: "", //文章标题
          cate_id: "", // 分类id
          content: "", // 文章内容部分
          art_desc: "", // 文章描述
          author: "", // 文章作者
          thumb: "", // 缩略图
        }

      }
    },
    created(){
      this.getCategory()
    },
    mounted() {
      window.CKEDITOR.replace("editor", {height: "300px", width: "100%", toolbar: "Full"});
      this.editor = window.CKEDITOR.instances.editor;
    },
    methods:{

      getCategory(){ // 1. 页面加载获取分类信息
        this.$http.post("myblog/php/server.php?p=Back&c=Article&a=add",{}).then(result => { 
          if(result.body.statu == 0){
            this.cateInfo = result.body.Info
          }else{
            this.$message.error('发生未知错误,获取分类信息失败!!!');
          }
        })
      },
      dealAdd(){  // 2. 添加文章
        this.ArtInfo.cate_id = this.$refs.Option.value
        this.ArtInfo.content = this.editor.getData()
        this.$http.post("myblog/php/server.php?p=Back&c=Article&a=dealAdd",this.ArtInfo).then(result => {
          if(result.body.statu == 0){
            this.$message({
                type: 'success',
                message: result.body.Info
            });
          }else{
            this.$message.error('发生未知错误,添加文章失败!!!'); 
          }
        })
      },
      handleAvatarSuccess(res, file){ // 缩略图上传成功的回调函数
      console.log(res)
        if(res.statu == 0){
          this.$message({
            showClose: true,
            message: res.Info,
            type: 'success',
            offset: 150,
            duration : 1000
          });
          this.ArtInfo.thumb = res.filename
          console.log(this.ArtInfo.thumb)
          return true
        }else{
          this.$message.error(res.Info);
        }
      },
      handleAvatarError(err, file){ // 缩略图上传失败的回调函数
        this.$message.error(err.Info);
      }
    },
    filters:{ // 定义私有过滤器
      formatCate_name(input,level){
        level = parseInt(level)
        return "-".repeat(5*level) + " " + input;
      }
    }

  }
</script>

<style>
  .el-upload__input {
    display: none !important;
  }
</style>

<style lang="scss" scoped>
  .addArt-container{
    // margin:0;

    .labelStyle{
      font-size:14px;
    }

    .line{
      margin-top:20px;
      margin-bottom:20px;
    }

    .input{
      width:90%;
      height:35px;
      padding:5px;
      margin-left:10px;
    }

    .selectStyle{
      width:30%;
      height:35px;
      margin-left:10px;
    }
  }

</style>
