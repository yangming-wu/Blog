<template>
  <div class="heart-container" v-on:click="add">
    <i class="fa fa-heart-o fa-lg" style="color:#FD8C84;" > </i> <span style="color:#FD8C84;" id="like" > {{myhits}}喜欢</span>
  </div>
</template>

<script>
export default {
  data(){
    return {
      flag: false,
      myhits : parseInt(this.hits)
    }
  },
  methods:{
    add(){
      if(this.flag === false){
        this.$http.post("myblog/php/server.php?p=Home&c=ArticleList&a=addHeart",{'art_id':this.art_id}).then(res => {
          if(res.body.statu == 0){
            this.myhits += 1
            this.flag = true
            console.log(this.hits)
            this.$emit('func',this.art_id) // 显示小球动画
          }else{
            this.$message.error('发生未知错误, 点赞失败!');
          }
        })
      }else{
        this.$message.error("您已经点过赞了!");
      }
    },
  },
  props: ['art_id','hits'],
}
</script>>

<style lang="scss" scoped>
  .heart-container{
    cursor:pointer;  
  }

</style>