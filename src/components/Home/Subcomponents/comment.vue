<template>

  <!-- 封装一个二级评论组件 -->
  <div class="cmt-container" @click="showface=0">

    <div id="qq" :class="[showtextarea.type == '评论' ? 'show' : 'disappear']">
        <p>发表评论</p>
        <hr>
        <div contentEditable='true' id="content" placeholder="请输入要评论的内容 (最多吐槽120字) ..." class="con commentBox" @click="checkLogin">
          
        </div>
        
        <div class="But">
          <img src="http://localhost/myblog/src/img/Home/Expression/bba_thumb.gif" class='bq' @click.stop="showface=1"/>
          <el-button class="submit" type="primary" @click="Comment">发表评论</el-button>
          <!--face begin-->
          <div :class="['face', showface?'show':'']">
            <ul>
              <li v-for="(item,index) in express" :key="index">
                <img :src="item.src" :title="item.title" @click="addExpress(item.src,'content')">
              </li>
            </ul>
          </div>
		    	<!--face end-->
		    </div>

    <!--qq end-->  
	  </div>

    <p class="list" >评论列表</p>
    <hr>
    <!-- 评论列表 -->
    <div class="cmt-list" v-if="sofa">
        
      <div v-for="(item, index) in cmt_list" :key="index" style="margin:15px 0;">
        <!-- 一级评论 -->
        <div style="float:left;width:8%;text-align:center;">
          <img :src="item.cmt_user_img" alt="" > <br>
          <span style="font-size:14px;">第{{index+1}}楼</span>
        </div>
        <div style="float:left;width:92%;">
          <div class="out-div">
            <div class="arrow" ></div>   
            <p v-html="item.cmt_content" style="font-size:14px;">{{item.cmt_content}}</p>
            <div style="padding-top:5px;font-size:14px;">
              用户：<span style="color:#6FC299">{{ item.cmt_user }}</span>&nbsp;&nbsp;发表时间：{{ item.cmt_time}}&nbsp;&nbsp;<span style="color:#6FC299;cursor: pointer;" @click.stop="showReply(item)">回复</span>
            </div> 
          </div>
        </div>
        <div style="clear:both;"></div>
        <!-- ************ 回复框 Begin ***************** -->
        
        <div id="qq" :class="[item.isSelected ? 'show' : 'disappear']" style="margin-bottom:15px;height:170px;" >
            
            <div contentEditable='true' :id="'content' + item.cmt_id" placeholder="请输入要评论的内容 (最多吐槽120字) ..." class="con commentBox" @click="checkLogin">
              
            </div>
            
            <div class="But">
              <img src="http://localhost/myblog/src/img/Home/Expression/bba_thumb.gif" class='bq' @click.stop="showface=1"/>
              <el-button class="submit" type="primary" @click="reply(item)">回复评论</el-button>
              <el-button class="submit" type="primary" @click="cancelReply(item)" style="margin-right:15px;">取消回复</el-button>
              <!--face begin-->
              <div :class="['face', showface ? 'show':'']">
                <ul>
                  <li v-for="(each,index) in express" :key="index">
                    <img :src="each.src" :title="each.title" @click="addExpress(each.src,'content' + item.cmt_id)">
                  </li>
                </ul>
              </div>
              <!--face end-->
            </div>

        <!--qq end-->  
        </div>
        <!-- ************ 回复框 END ******************* -->

        <div style="clear:both;"></div>

        <!-- 二级评论 -->
        <div class="sub" v-for="(subitem,i) in item.replyers" :key="i" style="margin:10px 0">
          <div style="float:left;width:8%;text-align:center;margin-left:7%;">
            <img :src="subitem.cmt_user_img" alt="" > <br>
          </div>
          <div style="float:left;width:85%;">
            <div class="out-div">
              <div class="arrow" ></div>   
              <p v-html="subitem.cmt_content" style="font-size:14px;">{{subitem.cmt_content}}</p>
              <div style="padding-top:10px;">
                用户：<span style="color:#6FC299">{{ subitem.cmt_user }}</span> 回复 <span style="color:#6FC299">{{ subitem.replyer}}</span>&nbsp;&nbsp;发表时间：{{ subitem.cmt_time}}&nbsp;&nbsp;<span @click.stop="showReply(subitem)" style="color:#6FC299;cursor: pointer;">回复</span>
              </div> 
            </div>
          </div>
          <div style="clear:both;"></div>

          <!-- ************ 回复框 Begin ***************** -->
        
          <div id="qq" :class="[subitem.isSelected ? 'show' : 'disappear']" style="margin-bottom:15px;height:170px;" >
              
              <div contentEditable='true' :id="'content' + subitem.cmt_id" placeholder="请输入要评论的内容 (最多吐槽120字) ..." class="con commentBox" @click="checkLogin">
                
              </div>
              
              <div class="But">
                <img src="http://localhost/myblog/src/img/Home/Expression/bba_thumb.gif" class='bq' @click.stop="showface=1"/>
                <el-button class="submit" type="primary" @click="reply(subitem)">回复评论</el-button>
                <el-button class="submit" type="primary" @click="cancelReply(subitem)" style="margin-right:15px;">取消回复</el-button>
                <!--face begin-->
                <div :class="['face', showface ? 'show':'']">
                  <ul>
                    <li v-for="(item,index) in express" :key="index">
                      <img :src="item.src" :title="item.title" @click="addExpress(item.src,'content' + subitem.cmt_id)">
                    </li>
                  </ul>
                </div>
                <!--face end-->
              </div>

          <!--qq end-->  
          </div>
          <!-- ************ 回复框 END ******************* -->


          <div style="clear:both;"></div>
        </div>
      </div>
      <div style="text-align:center;margin:10px 0;" v-show="showmore">
        <el-button type="danger" size="large" plain @click="getMore" style="width:50%;">加载更多</el-button>
      </div>   
    </div>

    <div v-else style="text-align:center;font-size:14px;color: #909399;">
      目前还没有小伙伴吐槽, 快来抢占沙发吧~
    </div>


  </div>
  
</template>

<script>
export default {
  data(){
    return {
      art_id:this.id, // 文章id
      pageIndex: 1, // 默认展示第一页数据
      sofa:false, // 抢占沙发
      showmore:false,
      showface:0, // 是否显示小图标
      showtextarea:{ // 显示文本框
        type : '评论',
        id : null,
        prams : {},
      }, 
      msg:'', // 评论框内容
      express:[  // 表情包
        {src:"http://localhost/myblog/src/img/Home/Expression/smilea_thumb.gif",title:"呵呵]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/tootha_thumb.gif",title:"嘻嘻]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/laugh.gif",title:"[哈哈]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/tza_thumb.gif",title:"[可爱]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/kl_thumb.gif",title:"[可怜]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/kbsa_thumb.gif",title:"[挖鼻屎]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/cj_thumb.gif",title:"[吃惊]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/shamea_thumb.gif",title:"[害羞]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/zy_thumb.gif",title:"[挤眼]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/bz_thumb.gif",title:"[闭嘴]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/bs2_thumb.gif",title:"[鄙视]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/lovea_thumb.gif",title:"[爱你]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/sada_thumb.gif",title:"[泪]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/heia_thumb.gif",title:"[偷笑]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/qq_thumb.gif",title:"[亲亲]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/sb_thumb.gif",title:"[生病]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/mb_thumb.gif",title:"[太开心]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/ldln_thumb.gif",title:"[懒得理你]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/yhh_thumb.gif",title:"[右哼哼]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/zhh_thumb.gif",title:"[左哼哼]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/x_thumb.gif",title:"[嘘]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/cry.gif",title:"[衰]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/wq_thumb.gif",title:"[委屈]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/t_thumb.gif",title:"[吐]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/k_thumb.gif",title:"[打哈气]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/bba_thumb.gif",title:"[抱抱]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/angrya_thumb.gif",title:"[怒]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/yw_thumb.gif",title:"[疑问]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/cza_thumb.gif",title:"[馋嘴]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/88_thumb.gif",title:"[拜拜]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/sk_thumb.gif",title:"[思考]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/sweata_thumb.gif",title:"[汗]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/sleepya_thumb.gif",title:"[困]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/sleepa_thumb.gif",title:"[睡觉]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/money_thumb.gif",title:"[钱]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/sw_thumb.gif",title:"[失望]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/cool_thumb.gif",title:"[酷]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/hsa_thumb.gif",title:"[花心]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/hatea_thumb.gif",title:"[哼]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/gza_thumb.gif",title:"[鼓掌]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/dizzya_thumb.gif",title:"[晕]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/bs_thumb.gif",title:"[悲伤]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/crazya_thumb.gif",title:"[抓狂]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/h_thumb.gif",title:"[黑线]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/yx_thumb.gif",title:"[阴险]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/nm_thumb.gif",title:"[怒骂]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/hearta_thumb.gif",title:"[心]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/unheart.gif",title:"[伤心]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/pig.gif",title:"[猪头]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/ok_thumb.gif",title:"[ok]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/ye_thumb.gif",title:"[耶]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/good_thumb.gif",title:"[good]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/no_thumb.gif",title:"[不要]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/z2_thumb.gif",title:"[赞]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/come_thumb.gif",title:"[来]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/sad_thumb.gif",title:"[弱]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/lazu_thumb.gif",title:"[蜡烛]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/clock_thumb.gif",title:"[钟]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/cake.gif",title:"[蛋糕]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/m_thumb.gif",title:"[话筒]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/weijin_thumb.gif",title:"[围脖]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/lxhzhuanfa_thumb.gif",title:"[转发]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/lxhluguo_thumb.gif",title:"[路过这儿]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/bofubianlian_thumb.gif",title:"[bofu变脸]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/gbzkun_thumb.gif",title:"[gbz困]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/boboshengmenqi_thumb.gif",title:"[生闷气]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/chn_buyaoya_thumb.gif",title:"[不要啊]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/daxiongleibenxiong_thumb.gif",title:"[dx泪奔]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/cat_yunqizhong_thumb.gif",title:"[运气中]"},
        {src:"http://localhost/myblog/src/img/Home/Expression/youqian_thumb.gif",title:"[有钱]"},
      ],
      cmt_list:[ // 评论列表
        
      ]
    }
  },
  created () {
    this.getComments();
  },
  mounted () {
    window.CKEDITOR = null;
  }
  ,
  methods:{
    /**
    * 核对登录状态
    */
    checkLogin(){
      this.$http.get("myblog/php/server.php?p=Home&c=SinglePage&a=check").then((result) => {
        if (result.body.statu === 0 && result.body.flag == "Failed") {
            this.$confirm('您的账号未登录，不能进行评论, 是否登录账号?', '提示', {
              confirmButtonText: '确定',
              cancelButtonText: '取消',
              type: 'warning'
            }).then(() => {
              // 账号未登录,跳转到登录界面
              let intervalId = window.setTimeout(() => {
                this.$router.push({path : '/Home/Login',query:{redirect: location.hostname}})
              }, 1000)
            }).catch(() => {
              this.$message({
                type: 'info',
                message: '已取消登录'
              });          
            });
        }
      })
    },
    /**
     * 获取文章评论信息
     */
    getComments(flag="init"){
      // 获取评论
      this.$http
        .post("myblog/php/server.php?p=Home&c=SinglePage&a=getComment", {"art_id" : this.$route.params.art_id, "pageindex": this.pageIndex})
        .then(result => {
          if (result.body.statu === 0) {
            // 每当获取新评论数据的时候，不要把老数据清空覆盖，而是应该以老数据，拼接上新数据
            this.cmt_list = this.cmt_list.concat(result.body.Info);
            this.sofa = (this.cmt_list.length == 0) ? false : true;
            this.showmore = this.cmt_list.length == 0 ? false : true;
          }else if(result.body.statu === 2 && flag == 'more'){
            this.$message({
              message: result.body.Info,
              type: 'warning'
            });
          }else {
            this.$message.error('获取评论信息失败!!!');
          }
        });
    },
    /**
     * 点击小图标,添加表情到文本框
     */
    addExpress(url,id){ 
      // 创建img
      let img = document.createElement('img');
      img.src = url;
      // 将img添加到文本框
      document.getElementById(id).appendChild(img);
    },
    /**
     * 点击发表评论
     */
    Comment(){
      // 1. 获取评论内容
      let content = document.getElementById('content').innerHTML;
      
      content = content.trim()
      
      // 2. 判断评论内容是否为空
      if(content.length == 0){
        this.$message.error('评论内容不能为空!!!');
        return
      }
      
      // 3. 发送请求, 提交评论
      this.$http.post("myblog/php/server.php?p=Home&c=SinglePage&a=postComment",{'art_id':this.$route.params.art_id, 'content':content}).then((result) => {
        if(result.body.statu == 0 && result.body.flag == "Success"){
          // 评论成功,拼接一个评论对象
          let obj = result.body.Info
          this.cmt_list.unshift(obj)
          document.getElementById('content').innerHTML = ""
        }else if(result.body.statu === 0 && result.body.flag == "Failed"){
          this.$confirm('您的账号未登录，不能进行评论, 是否登录账号?', '提示', {
              confirmButtonText: '确定',
              cancelButtonText: '取消',
              type: 'warning'
            }).then(() => {
              // 账号未登录,跳转到登录界面
              let intervalId = window.setTimeout(() => {
                this.$router.push({path : '/Home/Login',query:{redirect: location.hostname}})
              }, 1000)
            }).catch(() => {
              this.$message({
                type: 'info',
                message: '已取消登录'
              });          
            });
        }else{
          this.$message.error('未知错误, 评论失败, 请稍后再试!!!');
        }
      })
      
      
    },
    /**
     * 点击显示回复框
     */
    showReply(item){
      this.cmt_list.forEach((item,index) => {
        item.isSelected = false
        item.replyers.forEach((subitem) => {
          subitem.isSelected = false
        })
      })
      item.isSelected = true
      document.getElementById('content').innerHTML = ""
      this.showtextarea.type = '回复'
      this.showtextarea.id = item.cmt_id
    },
    /**
     * 点击取消回复
     */
    cancelReply(item){
      // 1. 取消回复前,将内容清空
      let id = 'content' + item.cmt_id
      document.getElementById(id).innerHTML = ""

      item.isSelected = false
      this.showtextarea.type = '评论'
      this.showtextarea.id = null
    },
    /**
     * 点击回复评论
     */
    reply(obj){
      // 1. 获取评论信息
      let id = "content" + obj.cmt_id
      let content = document.getElementById(id).innerHTML.trim()
      
      if(content.length == 0){
        this.$message.error('评论内容不能为空!!!');
        return  
      }

      this.$http.post("myblog/php/server.php?p=Home&c=SinglePage&a=postComment",{'art_id':this.$route.params.art_id, 'content':content, 'replyer':obj.cmt_user,'pid':obj.cmt_id}).then((result) => {
        if(result.body.statu == 0 && result.body.flag == "Success"){
          // 评论成功,拼接一个评论对象
          this.cmt_list.some((item,index) => {
            if(item.cmt_id == obj.cmt_id){
              this.cmt_list[index].replyers.push(result.body.Info)
              return true
            }else{
              item.replyers.some((subitem, i) => {
                if(subitem.cmt_id == obj.cmt_id){
                  this.cmt_list[index].replyers.push(result.body.Info)
                  return true  
                }
              })
            }
          })
          document.getElementById(id).innerHTML = ""
          obj.isSelected = false
          this.showtextarea.type = '评论'
          this.showtextarea.id = null
        }else if(result.body.statu === 0 && result.body.flag == "Failed"){
          this.$confirm('您的账号未登录，不能进行评论, 是否登录账号?', '提示', {
              confirmButtonText: '确定',
              cancelButtonText: '取消',
              type: 'warning'
            }).then(() => {
              // 账号未登录,跳转到登录界面
              let intervalId = window.setTimeout(() => {
                this.$router.push({path : '/Home/Login',query:{redirect: location.hostname}})
              }, 1000)
            }).catch(() => {
              this.$message({
                type: 'info',
                message: '已取消登录'
              });          
            });
        }else{
          this.$message.error('未知错误, 评论失败, 请稍后再试!!!');
        }
      })
    },
    /**
     * 加载更多
     */
    getMore() {
      // 加载更多
      this.pageIndex++;
      this.getComments('more');
    },

  },
  watch:{
    cmt_list:function(NewVal, OldVal){
      this.sofa = (NewVal.length == 0) ? false: true;
    }
  },
  props: ["id"]
}
</script>

<style lang="scss" scoped>
  .cmt-container{

    .show{
      display: block;
    }

    .disappear{
      display:none;
    }

    .con:empty:before{
      content:attr(placeholder);
      font-size: 14px;
      color: #909399;
      opacity: 0.5;
    }
    
    .con:focus{
      content:none;
    }

    .commentBox{
      -webkit-background-clip: text;
      outline: none;
      border:1.5px solid #ddd;
      height:100px;
      margin: 0 auto;
      overflow: hidden;
      border-radius: 5px;
      padding: 8px;
      box-sizing: border-box;
      font-size: 14px;
      color: #909399;
      background-image: linear-gradient(to right, #778899 0%, #333 100%);
    }

    .out-div {    
        display: inline-block;
        font-size:14px;
        color: #303133;   
        max-height: 80px;
        line-height:20px; 
        position: relative;  
        width: 100%;    
        text-align: left;  
        padding:10px; 
        border-radius: 5px;     
        vertical-align: top;   
        background-color: rgb(245,245,245);
        border:1px solid rgb(245,245,245);   
    }   
    .arrow {   
        width: 0px;   
        height: 0px;   
        border-top: 8px solid transparent;   
        border-right: 8px solid;   
        border-bottom: 8px solid transparent;   
        position: absolute;   
        margin-left: -18px;   
        margin-top: 5px;   
        border-right-color: rgb(245,245,245);   
    }

    #qq {
			width: 100%;
			/*宽*/
			height: 200px;
			/*高*/
			background: #fff;
			/*背景颜色*/
			margin: 50px auto 30px;
			border-radius: 5px;
			/*Html5 圆角*/
		}

    

    #qq p {
			font-size: 20px;
			color: #666;
			font-family: "微软雅黑";
			line-height: 25px;
		}

    .list{
      font-size: 20px;
			color: #666;
			font-family: "微软雅黑";
			line-height: 25px;
      margin-top:20px;
    }

    #qq .But {
			width: 100%;
			height: 35px;
			margin: 15px auto 0px;
			position: relative;
			/*相对，参考对象*/
		}

    #qq .But img.bq {
			float: left;
			/*左浮动*/
		}

    #qq .But .submit {
			
			float: right;
			/*右浮动*/
			cursor: pointer;
			/*手指*/
			color: #fff;
			font-size: 12px;
			font-family: "微软雅黑";
		}

    /*face begin*/
		#qq .But .face {
			width: 440px;
			background: #fff;
			border: 1px solid #ddd;
			box-shadow: 0 0 12px #666;
			position: absolute;
			/*绝对定位*/
			top: 21px;
			left: 15px;
			display: none;
			/*隐藏*/
		}

    #qq .But .face.show { // 点击小图标显示
      display: block;
      z-index: 1001;
    }


    #qq .But .face ul {
			width: 100%;
			height: 100%;
			display: flex;
			flex-wrap: wrap;
			padding: 8px;
			box-sizing: border-box;
		}

    #qq .But .face ul li {
			width: 30px;
			height: 30px;
			list-style-type: none;
			cursor: pointer;
			display: flex;
			justify-content: center;
			align-items: center;
		}

    /*msgCon begin*/
		.msgCon {
			width: 600px;
			margin: 0px auto;
			margin-bottom: 60px;
		}

		.msgCon .msgBox {
			background: #fff;
			padding: 10px;
			box-sizing: border-box;
			margin-top: 16px;
			border-radius: 4px;
		}

		.msgCon .msgBox .headUrl {
			width: 100%;
			height: 60px;
			border-bottom: 1px dotted #ddd;
			display: flex;
			align-items: center;
		}

		.msgCon .msgBox .headUrl img {
			width: 46px;
			height: 46px;
			border-radius: 50%
		}

		.msgCon .msgBox .headUrl div {
			flex: 1;
			display: flex;
			flex-flow: column;
			font-size: 16px;
			margin-left: 16px;
			-webkit-background-clip: text;
			color: transparent;
			background-image: linear-gradient(to top, #b224ef 0%, #7579ff 100%);
		}

		.msgCon .msgBox .headUrl div .time {
			font-size: 14px;
			margin-top: 6px;
			-webkit-background-clip: text;
			color: transparent;
			background-image: linear-gradient(to right, #74ebd5 0%, #9face6 100%);
		}

		.msgCon .msgBox .headUrl a {
			font-size: 14px;
			padding: 10px;
			color: salmon;
			cursor: pointer;
		}

		.msgCon .msgBox .msgTxt {
			font-size: 14px;
			color: #666;
			min-height: 40px;
			line-height: 24px;
			padding: 10px;
			box-sizing: border-box;
			word-wrap: break-word;
			-webkit-background-clip: text;
			color: transparent;
			background-image: linear-gradient(to right, #778899 0%, #333 100%);
		}

  }


</style>