<template>
  <div class="Category-container">
    <div class="panel panel-default">

      <div class="panel-heading"><strong>分类列表</strong></div>

      <div class="panel-body">
        <el-button type="info" plain size="mini" name="checkall" @click="selectAllRow">全选</el-button>
        <router-link to="/Back/Category/add">
        <el-button type="success" plain size="mini">添加分类</el-button>
        </router-link>
        <el-button type="danger" plain size="mini" @click="delAll">批量删除</el-button>
      </div>

      <table class="table table-hover">
        <thead>
		    <tr>
          <th width="45">选择</th>
          <th width="120">所属类别</th>
          <th width="240">分类名称</th>
          <th width="*">分类描述</th>
          <th width="150" style="text-align:center;">操作</th>
        </tr>
        </thead>
        
        <tbody>
          
          <tr v-for="item in data" :key="item.cate_id">
            <td><input type="checkbox"  :checked="item.checked" :value="item.cate_id"  @click="selectBox(item.cate_id)" /></td>
            <td>{{item.cate_pid}}</td>
            <td>{{item.cate_name | formatCate_name(item.level)}}</td>
            <td>{{item.cate_desc }}</td>
            <td>
              <router-link :to="'/Back/Category/edit/' + item.cate_id">
                <el-button type="primary" plain size="mini">修改</el-button>
              </router-link>
              <el-button type="danger" plain size="mini" @click="del(item.cate_id)">删除</el-button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>

export default {

  data(){
    return {
      data:[], // 分类信息
      checkAll:false, // 是否全选
    }
  },
  created(){
    // 页面加载, 获取分类数据
    this.getData()
  },
  methods: {

    // 加载分类信息
    getData(){
      this.$http.post("myblog/php/server.php?p=Back&c=Category&a=index").then(result => {
        if(result.body.statu == 0){
          // this.data = result.body.info
          result.body.Info.forEach((item) => {
            item.checked = false
            this.data.push(item)
          })
          
        }else{ // 发生错误
          this.$message.error('发生未知错误,获取分类信息失败!!!'); 
        }
      })
    },
    del(cate_id){
      this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
      }).then(() => {
        // 发送后台请求,删除数据
        this.$http.post("myblog/php/server.php?p=Back&c=Category&a=del",{"cate_id":cate_id}).then(result => {
          if (result.body.statu == 0){
            // 删除成功, 刷新页面
            this.data = []
            this.getData()

            this.$message({
              type: 'success',
              message: result.body.Info
            });
          }else{
            this.$message({
              type: 'error',
              message: result.body.Info
            });
          }
        })
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消删除'
        });          
      });
    },
    delAll(){
      let cate_ids_array = []
      this.data.forEach((item) => {
        if (item.checked === true){
          cate_ids_array.push(item.cate_id)   
        }
      })

      if (cate_ids_array.length == 0){
        this.$message({
          type: 'error',
          message: "您未选择需要删除的分类!"
        });
      }else{
        
        this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          let cate_ids = cate_ids_array.join()

          // 发送后台请求,删除数据
          this.$http.post("myblog/php/server.php?p=Back&c=Category&a=delAll",{"cate_ids":cate_ids}).then(result => {
            if (result.body.statu == 0){
              // 删除成功, 刷新页面
              this.data = []
              this.getData()

              this.$message({
                type: 'success',
                message: result.body.Info
              });
            }else{
              this.$message({
                type: 'error',
                message: result.body.Info
              });
            }
          })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除'
          });          
        });
      }


    },
    selectAllRow(){
      this.checkAll = !this.checkAll
      let NewData = []
      this.data.forEach((item) => {
        if (this.checkAll === true){
          item.checked = true
        }else{
          item.checked = false
        }
        NewData.push(item)
      })
      this.data = [...NewData]
    },
    selectBox(id){
      let num = null
      this.data.some((item,index) => {
        if (item.cate_id == id){
          num = index
          return true
        }
      })
      if (num !== null){
        this.data[num].checked = !this.data[num].checked
      }
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
  .Category-container{
    overflow-y:hidden;
    height:auto;
  }
  
</style>