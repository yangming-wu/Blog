<template>

  <div class="Comment-container">
    <div class="panel panel-default">

      <div class="panel-heading"><strong>评论管理</strong></div>

      <div class="panel-body">
        <div class="mid">
          <div style="width:200px;">
            <el-button type="info" plain size="mini" name="checkall" @click="selectAllRow">全选</el-button>
            <el-button type="danger" plain size="mini" @click="delAll">批量删除</el-button>
          </div>

          <div style="width:300px;">
            <a-input-search placeholder="请输入文章标题..."   enterButton="Search" size="default" v-model="search" @keyup="getComment(1)" @search="getComment(1)" />
          </div>
        </div>
      </div>

      <table class="table table-hover">
        <thead>
		    <tr>
          <th width="45">选择</th>
          <th width="160">文章标题</th>
          <th width="120">评论者</th>
          <th width="120">回复谁的评论</th>
          <th width="*">评论内容</th>
          <th width="160">评论时间</th>
          <th width="150" style="text-align:center;">操作</th>
        </tr>
        </thead>
        
        <tbody>
          <tr v-for="(item,index) in data" :key="index">
            <td><input type="checkbox"  :value="item.art_id" :checked="item.checked"  @click="selectBox(item.art_id)"/></td>
            <td>{{item.title}}</td>
            <td>{{item.cmt_user|formatReplyer(item.cmt_pid)}}</td>
            <td>{{item.replyer}}</td>
            <td v-html="item.cmt_content">{{item.cmt_content}}</td>
            <td>{{item.cmt_time}}</td>
            <td>
              <el-button type="primary" plain size="mini">修改</el-button>
              <el-button type="danger" plain size="mini" @click="del(item.cmt_id)">删除</el-button>
            </td>
          </tr>
        </tbody>
      </table>

    </div>

    <!-- 分页 -->
      <div style="padding-right:15px;margin-top:20px; margin-bottom:20px;text-align:right;">
        <a-pagination
          :total="total"
          :defaultCurrent="1"
          :current="currentPage"
          :pageSize="pageSize"
          :showTotal="total => `总共 ${total} 条`"
          @change="onChange"
        >
        </a-pagination>
      </div>

  </div>
  
</template>

<script>
export default {
  data(){
    return {
      checkAll:false, // 是否全选
      data : [], // 数据评论
      currentPage:1, // 当前页
      pageSize: 10,
      total: 0,
      search:'', // 默认搜索内容为空
    }
  },
  created () {
    this.getComment()
  },
  methods:{

    /**
     * 获取评论信息
     */
    getComment(pageNum=1){

      this.currentPage = pageNum

      // 请求数据
      this.$http.post("myblog/php/server.php?p=Back&c=Comment&a=Index", {"search":this.search,"pageSize":this.pageSize,"pageNum":pageNum}).then((result) => {
        // 清空列表 
        this.data = []        
        if(result.body.statu == 0){
          result.body.Info.forEach((item) => {
            item.checked = false // 默认所有的评论是未选中的状态
            this.data.push(item)
          })

          this.total = parseInt(result.body.total) 
        }else{
          this.$message.error('发生未知错误,获取评论列表失败!!!');
        }
      })

    },
    /**
     * 点击切换全选
     */
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
    /**
     * 点击批量删除评论
     */
    delAll(){
      let self = this
      let cmt_ids_array = []
      this.data.forEach((item) => {
        if (item.checked === true){
          cmt_ids_array.push(item.cmt_id)   
        }
      })
     
      if (cmt_ids_array.length == 0){
        this.$message({
          type: 'error',
          message: "您未选择需要删除的评论!"
        });
      }else{
        this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          cmt_ids = cmt_ids_array.join()
          // 发送后台请求,删除数据
          this.$http.post("myblog/php/server.php?p=Back&c=Comment&a=delAll",{"cmt_ids":cmt_ids}).then(result => {
            if (result.body.statu == 0){
              this.$message({
                type: 'success',
                message: result.body.Info
              });
              // 删除成功, 刷新页面
              self.data = []
              self.getComment()
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
    /**
     * 点击切换单选
     */
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
    },
    /**
     * 点击删除单条评论
     */
    del(cmt_id){
      let self = this
      this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
      }).then(() => {
        // 发送后台请求,删除数据
        this.$http.post("myblog/php/server.php?p=Back&c=Comment&a=del",{"cmt_id":cmt_id}).then(result => {
          if (result.body.statu == 0){
            this.$message({
              type: 'success',
              message: result.body.Info
            });
            // 删除成功, 刷新页面
            self.data = []
            self.getComment(this.currentPage)
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
    /**
     * 分页切换
     */
    onChange(pageNumber) {
      this.getComment(pageNumber)
    }

  },
  filters:{ // 定义私有过滤器
    formatReplyer(input,pid){
      pid = parseInt(pid)
      if(pid != 0){
        return "-".repeat(3) + " " + input;
      }
      return input
    }
  }
}
</script>

<style lang="scss" scoped>
  .Comment-container{
    height:auto;

    .mid{
      display: flex;
      display: -webkit-flex;
      justify-content: space-between;
    }

  }

</style>