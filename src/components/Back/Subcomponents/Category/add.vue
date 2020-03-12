<template>
  
  <div class="add-container">
    <div class="panel panel-success">

      <div class="panel-heading"><strong>添加分类</strong></div>

      <div class="panel-body">
        <div style="margin-left:10%;">
          <form class="form-inline" role="form">
            <div class="line"> 
              <label class="labelStyle" for="name">分类名称</label>
              <input type="text" class="input form-control" id="cate_name" name="cate_name" size="50" placeholder="请填写分类名称..." data-validate="required:请填写您的分类名称"  v-model="addCateInfo.cate_name" />
            </div>

            <div class="line"> 
              <label for="name">所属类别</label>
              <select class="form-control selectStyle" ref="Option">
                <option value="0">主类别</option>
                <option v-for="item in cateInfo"  :key="item.cate_id" :selected="item.selected" :value="item.cate_id">{{item.cate_name | formatCate_name(item.level) }}</option>
              </select>
            </div>

            <div class="line">
              <div style="float:left;"><label for="name" class="labelStyle">分类描述</label></div>
              <div style="float:left;width:90%;"><a-textarea name="name" placeholder="请填写分类描述..."  rows="4"  style="width:67%;margin-left:14px;" v-model="addCateInfo.cate_desc" /></div>
              <div style="clear:both;"></div>
            </div>

            <div class="line"> 
              <label class="labelStyle" for="name">分类排序</label>
              <input type="text" class="input form-control"  name="name" size="50"  placeholder="请填写排序编号..."  v-model="addCateInfo.cate_sort" />
            </div>

            <div class="line"> 
              <el-button type="primary" size="small" style="margin-left:70px;" @click="submitEdit">提交</el-button>
            </div>

          </form>
        </div>
      </div>

    </div>

  </div>


</template>

<script>
export default {

  data(){
    return {
      cateInfo:[],
      addCateInfo:{
        'cate_name' : "",
        'cate_sort' : "",
        'cate_desc' : "",
        'cate_pid'  : ""
      }
    }
  },
  created(){
    // 添加分类页面加载, 获取分类信息
    this.getCate()
  },
  methods:{
    getCate(){
      this.$http.post("myblog/php/server.php?p=Back&c=Category&a=add",{}).then(result => { 
        if(result.body.statu == 0){
          this.cateInfo = result.body.Info
        }else{
          this.$message.error('发生未知错误,获取分类信息失败!!!');
        }
      })
    },
    submitEdit(){

      this.addCateInfo.cate_pid = this.$refs.Option.value
      this.$http.post("myblog/php/server.php?p=Back&c=Category&a=dealAdd",this.addCateInfo).then(result => { 
        
        if(result.body.statu == 0){
            this.$message({
                type: 'success',
                message: result.body.Info
            });

            // 返回分类管理
            // this.$router.go(-1)

          }else{ // 发生错误
            this.$message.error('发生未知错误,获取分类信息失败!!!'); 
          }


      })

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

<style lang="scss" scoped>

  .add-container{

    margin-top:30px;

    .labelStyle{
      font-size:14px;
    }

    .line{
      margin-top:20px;
      margin-bottom:20px;
    }

    .input{
      width:60%;
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