<template>
  <div class="index-container">
		
		<div class="head-container">
			<div class="blog">
				<div class="bounce">
					<span class="letter">吴</span>
					<span class="letter">杨</span>
					<span class="letter">名</span>
					<span class="letter">博</span>
					<span class="letter">客</span>
				</div>
			</div>
			<ul class="menu">
				<li><router-link tag="span"  to="/Home/start" :class="[isSelect.indexOf('start') !== -1 ? 'index_active' : '']" >首页</router-link></li>
				<li v-for="(item,index) in data" :key="index">
					<router-link tag="span" :to="'/Home/ArticleList/' + index " :class="[isSelect.indexOf(index) !== -1 ? 'index_active' : '']" >{{index}}</router-link>
					<ul class="submenu">
						<li v-for="item1 in item" :key="item1.cate_id">
							<router-link tag="span"  :to="'/Home/ArticleList/' + item1.cate_name " :class="[isSelect.indexOf(item1.cate_name) !== -1 ? 'index_active' : '']" >{{item1.cate_name}}</router-link>
						</li>
					</ul>
				</li>

				<!-- <li><router-link tag="span" to="/Home/project" :class="[isSelect.indexOf('project') !== -1 ? 'index_active' : '']" >项目合作</router-link></li> -->
				<li><router-link tag="span" to="/Home/message" :class="[isSelect.indexOf('message') !== -1 ? 'index_active' : '']" >给我留言</router-link></li>
				<li><router-link tag="span" to="/Home/Blogger" :class="[isSelect.indexOf('Blogger') !== -1 ? 'index_active' : '']" >关于博主</router-link></li>
			</ul>
	</div>

	<!-- 欢迎来访 -->
  <a-row  type="flex" justify="center" style="margin-bottom:15px;">

    <a-col :span="2"></a-col>

    <!-- content-left -->
    <a-col :span="14" style="height:50px;background:white;line-height:50px;padding-left:10px;font-size:16px;box-sizing:border-box; ">
      <i class="fa fa-volume-up fa-lg" style="color:green;" aria-hidden="true"></i> <span style="dispaly:inline-block;margin-left:15px;">欢迎来访~</span>
    </a-col>

    <!-- content-right -->
    <a-col :span="6" style="height:50px;background:white;line-height:50px;font-size:16px;text-align:right;padding-right:20px;box-sizing:border-box; ">
      <i class="fa fa-user fa-lg" style="color:#B1B1B1;"></i> 
			<span style="color:green;cursor: pointer;dispaly:inline-block;margin-right:10px;"> 投稿</span> 
			
			<i class="fa fa-power-off fa-lg" style="color:#B1B1B1;"></i>
			<span v-if="login" style="color:green;cursor: pointer;dispaly:inline-block;margin-right:10px;">{{user}}</span>
			<router-link v-else tag="span" to="/Home/Login" style="color:green;cursor: pointer;"> 登录</router-link>
    </a-col>

    <a-col :span="2"></a-col>
      
  </a-row>

	<!-- 中间内容部分 -->
	<router-view></router-view>
	
	<!-- 页脚 -->
	<footer>
			<div class="box">
				<div class="wxbox">
					<ul>
						<li><img src="http://localhost/myblog/src/img/Home/wxgzh.jpg"><br><span>微信公众号</span></li>
						<li><img src="http://localhost/myblog/src/img/Home/wx.png"><br><span>我的微信</span></li>
					</ul>
				</div>
				<div class="endnav">
					<p><b>站点声明：</b></p>
					<p>1、本站个人博客模板，均为本人设计，个人可以使用，但是未经许可不得用于任何商业目的。</p>
					<p>2、所有文章未经授权禁止转载、摘编、复制或建立镜像，如有违反，追究法律责任。举报邮箱：<a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=1073509605@qq.com" target="_blank">1073509605@qq.com</a></p>
					<p>Copyright © <a href="http://www.yangqq.com" target="_blank">www.yangqq.com</a> All Rights Reserved. 备案号：<a href="http://www.miitbeian.gov.cn/" target="_blank">皖ICP备110038300号-1</a></p>
				</div>
			</div>
			<a href="#">
			<div class="top"></div>
			</a> 
		</footer>


  </div>
</template>

<script>

export default {

	data(){
		return {
			showSearch:false,
			data : [],
			isSelect:['start'],
			login:true,
			user:''
		}
	},
	created(){
		// 获取信息
		this.getData()
		// 自动跳转到首页
		// this.$router.push({path : '/Home/Start'})

	},
	methods:{
		getData(){
			this.$http.post("myblog/php/server.php?p=Home&c=Index&a=Index").then((result) => {
				if(result.body.statu == 0){
					this.data = result.body.Category
					// 获取当前的分类页面
					let cate_name = this.getCateName(this.$route.path)
					this.SelectItem(cate_name)
					this.login = result.body.flag == "Success" ? true : false;
					this.user = result.body.user
				}else{
					this.$message.error('发生未知错误,获取信息失败!');
				}
			})
		},
		SelectItem(cate){
			if(['start','project','message','Blogger'].indexOf(cate) !== -1){
				this.isSelect = [cate]
			}else{
				for(let index in this.data){
					if(cate == index){
						this.isSelect = [index]
						break	
					}else{
						let res = this.data[index].some(subItem => {
							if(subItem.cate_name == cate){
								this.isSelect = [index,subItem.cate_name]
								return true
							}
						})
						if (res) break
					}
				}
			}
		},
		getCateName(value){
			var arr = value.split('/')
			let cate_name = "start"
			if(/Article/.test(arr[2])){
				cate_name = arr[3]
			}else{
				cate_name = arr[2]
			}
			return cate_name
		}	
	},
	watch:{
		'$route.path': function(newVal, oldVal){
			let cate_name = this.getCateName(newVal)
			this.SelectItem(cate_name)
		}
	}
	
}
</script>

<style lang="scss" scoped>
  .index-container{
		width:100%;
		
		background-color: #EEEEEE;
		
		@import "../../css/Home/main.css";
		
		.index_active{
			background-color: red;
			background: -moz-linear-gradient(#FF0000, 	#FF4500);
			background: -ms-linear-gradient(#FF0000, #FF4500);
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #FF0000), color-stop(100%, #FF4500));
			background: -webkit-linear-gradient(#FF0000, #FF4500);
			background: -o-linear-gradient(#FF0000, #FF4500);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF0000', endColorstr='#FF4500');
			-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF0000', endColorstr='#FF4500')";
			background: linear-gradient(#FF0000, #FF4500);
			color:white;
		}

		.blog .bounce {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 100%;
			color: white;
			height: 50px;
			font-size:12px;
			font: normal bold 2.5rem "Product Sans", sans-serif;
			white-space: nowrap;
			// border:1px solid red;

			.letter {
				animation: bounce 0.75s cubic-bezier(0.05, 0, 0.2, 1) infinite alternate;
				display: inline-block;
				transform: translate3d(0, 0, 0);
				margin-top: 0.5em;
				text-shadow: rgba(255, 255, 255, 0.4) 0 0 0.05em;
				font: normal 500 2.5rem 'Varela Round', sans-serif;
			}

			.letter:nth-child(1) {
				animation-delay: 0s;
			}
			.letter:nth-child(2) {
				animation-delay: 0.0833333333s;
			}
			.letter:nth-child(3) {
				animation-delay: 0.1666666667s;
			}
			.letter:nth-child(4) {
				animation-delay: 0.25s;
			}
			.letter:nth-child(5) {
				animation-delay: 0.3333333333s;
			}
			.letter:nth-child(6) {
				animation-delay: 0.4166666667s;
			}

			@keyframes bounce {
				0% {
					transform: translate3d(0, 0, 0);
					text-shadow: rgba(255, 255, 255, 0.4) 0 0 0.05em;
				}
				100% {
					transform: translate3d(0, -1em, 0);
					text-shadow: rgba(255, 255, 255, 0.4) 0 1em 0.35em;
				}
			}
		}

    
  }
</style>