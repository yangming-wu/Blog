<template>

  <div class="article-container">
    <div class="panel panel-info">

      <div class="panel-heading"><strong>文章列表</strong></div>

      <div class="panel-body">

        <el-button type="info" plain size="mini" name="checkall" @click="selectAllRow">全选</el-button>
        
        <router-link to="/Back/Article/add">
          <el-button type="success" plain size="mini">添加文章</el-button>
        </router-link>
        
        <el-button type="danger" plain size="mini" @click="delAll">批量删除</el-button>
        
        <router-link to="/Back/Article/recycle">
          <el-button type="primary" plain size="mini" >回收站</el-button>
        </router-link>
      </div>

      <table class="table table-hover">

        <thead>
		    <tr>
          <th width="45">选择</th>
          <th width="120">所属类别</th>
          <th width="200">文章标题</th>
          <th width="120">点击率</th>
          <th width="180">发布时间</th>
          <th width="100">是否推荐</th>
          <th width="100">操作</th>
        </tr>
        </thead>
        
        <tbody>
          <tr v-for="item in data" :key="item.art_id">
            <td><input type="checkbox"  :value="item.art_id" :checked="item.checked"  @click="selectBox(item.art_id)"/></td>
            <td>{{item.cate_id}}</td>
            <td>{{item.title}}</td>
            <td>{{item.hits}}</td>
            <td>{{item.addtime}}</td>
            <td>
              <el-button type="warning"  v-if="parseInt(item.is_recommend)" plain size="mini" @click="is_recommend(item.art_id)">已推荐</el-button>
              <el-button type="primary" v-else plain size="mini" @click="is_recommend(item.art_id)">未推荐</el-button>
            </td>
            <td>
              <router-link :to="'/Back/Article/edit/' + item.art_id">
                <el-button type="primary" plain size="mini">修改</el-button>
              </router-link>
              <el-button type="danger" plain size="mini" @click="del(item.art_id)">删除</el-button>
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
          :pageSize="pageSize"
          :showTotal="total => `总共 ${total} 条`"
          @showSizeChange="onShowSizeChange"
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
      data:[], // 存放文章列表
      checkAll:false, // 是否全选
      current: 1,
      pageSize: 10,
      total: 0,
    }
  },
  created(){
    // 页面加载,获取文章列表
    this.getArticle()
  },
  methods: {
    // 获取文章方法
    getArticle(pageNum=1){
      // 清空列表 
      this.data = []

      // 加载数据
      this.$http.post("myblog/php/server.php?p=Back&c=Article&a=index", {"pageSize":this.pageSize,"pageNum":pageNum}).then(result => {
        if(result.body.statu == 0){
          result.body.Info.forEach((item) => {
            item.checked = false
            this.data.push(item)
          })

          this.total = parseInt(result.body.total) 
        }else{
          this.$message.error('发生未知错误,获取文章列表失败!!!');
        }
      })
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
        if (item.art_id == id){
          num = index
          return true
        }
      })
      if (num !== null){
        console.log(num)
        this.data[num].checked = !this.data[num].checked
      }
    },
    delAll(){
      let self = this
      let art_ids_array = []
      this.data.forEach((item) => {
        if (item.checked === true){
          art_ids_array.push(item.art_id)   
        }
      })
     
      if (art_ids_array.length == 0){
        this.$message({
          type: 'error',
          message: "您未选择需要删除的文章!"
        });
      }else{
        this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          art_ids = art_ids_array.join()
          // 发送后台请求,删除数据
          this.$http.post("myblog/php/server.php?p=Back&c=Article&a=delAll",{"art_ids":art_ids}).then(result => {
            if (result.body.statu == 0){
              this.$message({
                type: 'success',
                message: result.body.Info
              });
              // 删除成功, 刷新页面
              self.data = []
              self.getArticle()
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
    del(art_id){
      let self = this
      this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
      }).then(() => {
        // 发送后台请求,删除数据
        this.$http.post("myblog/php/server.php?p=Back&c=Article&a=del",{"art_id":art_id}).then(result => {
          if (result.body.statu == 0){
            this.$message({
              type: 'success',
              message: result.body.Info
            });
            // 删除成功, 刷新页面
            self.data = []
            self.getArticle()
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
    is_recommend(art_id){
      let num = null;
      this.data.some((item,index) => {
        if(item.art_id == art_id){
          num = index
          return true
        }
      })

      if(num !== null){
        this.data[num].is_recommend = ( parseInt(this.data[num].is_recommend) == 0) ? 1 : 0

        this.$http.post("myblog/php/server.php?p=Back&c=Article&a=ifRecommend",{"art_id":art_id,"is_recommend":this.data[num].is_recommend}).then(result => {
          if (result.body.statu == 0){
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

      }else{
        this.$message.error('发生未知错误!!!'); 
      }
    },
    onShowSizeChange(current, pageSize) {
      this.pageSize = pageSize
    },
    onChange(pageNumber) {
      // console.log('Page: ', pageNumber);
      this.getArticle(pageNumber)
    }



  }
  
}
</script>

<style lang="scss" scoped>
  
</style>