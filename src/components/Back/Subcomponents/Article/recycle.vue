<template>

  <div class="recycle-container">

    <div class="panel panel-info">

      <div class="panel-heading"><strong>回收站</strong></div>

      <div class="panel-body">
        <el-button type="info" plain size="mini" name="checkall" @click="selectAllRow">全选</el-button>

        <router-link to="/Back/Article">
        <el-button type="success" plain size="mini">文章首页</el-button>
        </router-link>

        <el-button type="danger" plain size="mini" @click="delAll">批量删除</el-button>

      </div>

      <table class="table table-hover">
        <thead>
		    <tr>
          <th width="75" style='vertical-align: middle;text-align: center;'>选择</th>
          <th width="250" style='vertical-align: middle;text-align: center;'>所属类别</th>
          <th width="340" style='vertical-align: middle;text-align: center;'>文章标题</th>
          <th width="230" style='vertical-align: middle;text-align: center;'>点击率</th>
          <th width="*" style='vertical-align: middle;text-align: center;'>发布时间</th>
          <th width="200" style='vertical-align: middle;text-align: center;'>操作</th>
        </tr>
        </thead>
        
        <tbody>
          
          <tr v-for="item in data" :key="item.art_id" style='vertical-align: middle;text-align: center;'>
            <td>
              <input type="checkbox" :checked="item.checked" :value="item.art_id"  @click="selectBox(item.art_id)" />
            </td>
            <td>{{item.cate_name}}</td>
            <td>{{item.title}}</td>
            <td>{{item.hits}}</td>
            <td>{{item.addtime}}</td>
            <td>
              <el-button type="primary" plain size="mini" @click="recoverArt(item.art_id)">还原</el-button>
              <el-button type="danger" plain size="mini" @click="del(item.art_id)">删除</el-button>
            </td>
          </tr>
        </tbody>
      </table>

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

  </div>

</template>

<script>

export default {

  data(){
    return {
      data : [],
      checkAll:false, // 是否全选
      current: 1,
      pageSize: 10,
      total: 0,
    }
  },
  created(){
    // 1. 显示回收站文章列表
    this.getArticle()

  },
  methods:{

    getArticle(pageNum=1){
      // 清空列表 
      this.data = []

      // 加载数据
      this.$http.post("myblog/php/server.php?p=Back&c=Article&a=recycle",{"pageSize":this.pageSize,"pageNum":pageNum}).then(result => {
        if(result.body.statu == 0){
          result.body.data.forEach((item)=>{
            item.checked = false
            this.data.push(item)
          })

          this.total = parseInt(result.body.total)
        }else{
          this.$message({
            type: 'error',
            message: '未知错误,获取信息失败!!!'
          });
        }

      })
    },
    selectAllRow(){// 全选功能
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
    delAll(){// 批量删除
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
          let art_ids = art_ids_array.join()
          // 发送后台请求,删除数据
          this.$http.post("myblog/php/server.php?p=Back&c=Article&a=realDelAll",{"art_ids":art_ids}).then(result => {
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
    selectBox(art_id){// 选中文章
      let num = null
      this.data.some((item,index) => {
        if (item.art_id == id){
          num = index
          return true
        }
      })
      if (num !== null){
        this.data[num].checked = !this.data[num].checked
      }
    },
    recoverArt(art_id){// 还原文章
      let self = this
      this.$confirm('此操作将还原该文章, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
      }).then(() => {
        // 发送后台请求,删除数据
        this.$http.post("myblog/php/server.php?p=Back&c=Article&a=recover",{"art_id":art_id}).then(result => {
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
          message: '已取消还原'
        });          
      });

    },
    del(art_id){// 彻底删除文章
      let self = this
      this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
      }).then(() => {
        // 发送后台请求,删除数据
        this.$http.post("myblog/php/server.php?p=Back&c=Article&a=realDel",{"art_id":art_id}).then(result => {
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

  .recycle-container{
    height:100%;
  }


  
</style>