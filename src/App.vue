<template>
  <div class="app-container">
    <router-view></router-view>
  </div>
    
</template>

<script>
import { constants } from 'crypto';
  export default {
    data () {
      return {
        msg : '哈哈哈~',
      }
    },
    created () {
      
    },
    methods : {
      
    }
  }
</script>

<style lang="scss" scoped>
  .app-container {
    width : 100%;
    height : 100%;
  }


</style>