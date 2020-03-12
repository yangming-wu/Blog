<template>
  <div class="label-container">
    <router-link tag="span" :to="'/Home/ArticleList/' + label " >
    <div class="out-div">   
        <div class="arrow" ></div>   
        {{label}} 
    </div>
    </router-link>
  </div>
</template>

<script>
export default {
  data(){
    return {

    }
  },
  props: ['label'],
}
</script>>

<style lang="scss" scoped>
  .label-container{
    cursor:pointer;
    margin-right:10px;
    .out-div {    
        display: inline-block;
        font-size:16px;
        color:#FFFFFF;   
        height: 30px;
        line-height:30px;   
        width: 100px;    
        text-align: center;   
        border-radius: 3px;     
        vertical-align: top;   
        background-color: #FD8C84;
        // border:1px solid #FD8C84;   
    }   
    .arrow {   
        width: 0px;   
        height: 0px;   
        border-top: 10px solid transparent;   
        border-left: 10px solid;   
        border-bottom: 10px solid transparent;   
        position: absolute;   
        margin-left: 96px;   
        margin-top: 5px;   
        border-left-color: #FD8C84;   
    }
  }

</style>