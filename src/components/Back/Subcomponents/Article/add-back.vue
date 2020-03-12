<template>
  <div class="addArt-container">
    <div class="panel panel-success">
      <div class="panel-heading"><strong>添加文章</strong></div>
      <div class="panel-body">
        <div>
          <form class="form-inline" role="form">
            <div class="line"> 
              <label class="labelStyle" for="name">文章标题</label>
              <input type="text" class="input form-control" id="art_title" name="art_title" size="50" placeholder="请填写文章标题..."  />
            </div>

            <!-- 文件上传 -->
            <!-- <div class="line"> -->
              <!-- <label class="labelStyle" for="name">缩略图</label> -->
              <!-- <el-upload  action="http://localhost/bios/php/server.php?p=Back&c=SampleInfo&a=upload"
                  :name="uploadfile"
                  :show-file-list="false"
                  :before-upload="checkuploadfile"
                  :on-success="handleAvatarSuccess"
                  :on-error="handleAvatarError"
              >
              <el-button size="small" type="primary">点击上传数据</el-button> -->
              <!-- <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div> -->
              <!-- </el-upload> -->
            <!-- </div> -->

            <div class="line"> 
              <label class="labelStyle" for="name">文章作者</label>
              <input type="text" class="input form-control" id="art_author" name="art_author" size="50" placeholder="请填写文章作者..."  />
            </div>

            <div class="line"> 
              <label class="labelStyle" for="name">所属类别</label>
              <select class="form-control selectStyle" ref="Option">
                <option value="0">主类别</option>
                <!-- <option v-for="item in cateInfo"  :key="item.cate_id" :selected="item.selected" :value="item.cate_id">{{item.cate_name | formatCate_name(item.level) }}</option> -->
              </select>
            </div>

            <!-- 文章描述 -->
            <div class="line">
              <div style="float:left;"><label for="name" class="labelStyle">文章描述</label></div>
              <div style="float:left;width:90%;"><a-textarea name="name" placeholder="请填写文章描述..."  rows="4"  style="width:100%;margin-left:14px;" /></div>
              <div style="clear:both;"></div>
            </div>

            <!-- 文章内容 -->
            <div class="line">
              <div style="float:left;">
                <label for="name" class="labelStyle">文章内容</label>
              </div>

              <div style="width:90%;float:left;margin-left:14px;">
                <ckeditor :editor="editor" @ready="onReady"  :config="editorConfig" v-model="editorData"
                  style="min-height:200px;border: 1px solid #ccc;">
                </ckeditor>
              </div>

              <div style="clear:both;"></div>
            </div> 

            <div class="line"> 
              <el-button type="primary" size="small" style="margin-left:70px;">提交</el-button>
            </div>

          </form>

                   

        </div>

      </div>
      
    </div>

  


    
  </div>
</template>

<script>
  // 导入富文本编辑器组件
  import DecoupledEditor from '@ckeditor/ckeditor5-build-decoupled-document';
  import '@ckeditor/ckeditor5-build-decoupled-document/build/translations/zh-cn';

  // 配置CKEditor插件
  // import FontColor from '@ckeditor/ckeditor5-font/src/fontColor'


  export default {
    name: 'addArt-container',
    data() {
      return {
        uploadfile:"thumb",
        editor: DecoupledEditor,
        editorData:"",
        // ...
        editorConfig: {
          language: "zh-cn",
          uiColor :'#DC143C',
          fontSize: {
            options: [8, 10, 'default', 14, 16, 18, 20, 22, 24, 26, 28, 32, 48]
          },
          fontFamily: {
            options: ["宋体", "仿宋", "微软雅黑", "黑体", "仿宋_GB2312", "楷体", "隶书", "幼圆"]
          },
          // toolbar:{
          //   items:[
          //     'Styles','Format','Font','FontSize',
          //     'Bold','Italic','Underline','Strike','Subscript','Superscript',
          //     'NumberedList','BulletedList','-','Outdent','Indent',
          //     'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock',
          //     'Link','Unlink','Anchor',
          //     'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak',
          //     'TextColor','BGColor',
          //     'Maximize', 'ShowBlocks','-',
          //   ]
          // }
        }
      };
    },
    methods: {
      onReady( editor )  {
        // Insert the toolbar before the editable area.
        editor.ui.getEditableElement().parentElement.insertBefore(
          editor.ui.view.toolbar.element,
          editor.ui.getEditableElement()
        );

        


        // 自定义上传图片插件
        editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        //  return new MyUploadAdapter( loader );
          return {
            upload: async () => {
              return await loader.file.then(f => {
                const F = new FileReader();
                F.readAsArrayBuffer(f);
                // console.log(f)
                return new Promise(resolve => {
                  F.onload = function () {
                    resolve({bufAsArray: F.result, file: f})
                  };
                })
              }).then(v => {
                //执行上传上传
                return this.uploadImgHook(v)
              });

            }
          }
        }; 
      },
      uploadImgHook(v){// 上传图片
        // console.log(v)
        let res = {}
        const data = new FormData();
        data.append('uploadImg', v.file);
        this.$http.post("myblog/php/server.php?p=Back&c=Article&a=uploadImg", data).then(result => {
          if(result.body.statu == 0){
            res.url = result.body.url
            res.uploaded = true
          }else{
            this.$message.error('发生未知错误,图片上传失败!!!');
          }
        })
        // console.log(res)
        return res
      },
      checkuploadfile(){

      },
      handleAvatarSuccess(){

      },
      handleAvatarError(){

      }


    }
  }
</script>


<style lang="scss" scoped>
  .addArt-container{

    // margin-top:30px;

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
