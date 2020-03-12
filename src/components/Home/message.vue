<template>
  <div class="Message-Container">

    <!-- 布局 -->
    <a-row type="flex" justify="center" align="top">

      <a-col :span="2"></a-col>

      <!-- content-left -->
      <a-col :span="20" style="background:white;">
        <h1>这里是给我留言页面</h1>
      </a-col>

      <a-col :span="2"></a-col>
      
    </a-row>
    
  </div>
</template>


<script>


export default {
  data(){
    return {
      
    }
  },
  created(){

  },
  methods:{

  },
  components:{
    
  }
  
}
</script>

<style lang="scss" scoped>
  .Message-Container{
    min-height:608px;
  }

</style>