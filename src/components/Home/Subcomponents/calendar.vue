<template>
  <!-- 封装一个日历组件 -->
  <div class="calendar-container">
    <div id='container' style="width:100%;"></div>
  </div>
</template>

<script>
import initCalendar from '../../../js/Home/calendar/simple-calendar-es6.js'

export default {
  data(){
    return {
      myCalendar : null,
    }
  },
  created(){
    
  },
  methods:{
    

  },
  mounted(){
    this.myCalendar = initCalendar('#container')
  },
  components:{
  
  }
}
</script>

<style lang="scss" scoped>
@import "../../../css/Home/calendar/simple-calendar.css";

</style>