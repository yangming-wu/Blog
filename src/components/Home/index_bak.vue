<template>
  <div class="index-container">
		<!-- 导航栏 -->
		<header id="header">
			<div class="navbox">
				<h2 id="mnavh"><span class="navicon"></span></h2>
				<div class="logo">博客</div>
				<nav>
					<ul id="starlist">
						<li><a href="index.html">首页</a></li>
						<li><a href="list.html">生活笔记</a></li>
						<li class="menu"><a href="list2.html">技术杂谈</a>
							<ul class="sub">
								<li><a href="/1"> 生物信息 </a></li>
								<li><a href="/2"> Python </a></li>
								<li><a href="/3"> Javascript </a></li>
								<li><a href="/4"> CSS3 | Html5 </a></li>
								<li><a href="/5"> PHP </a></li>
								<li><a href="/6"> Mysql </a></li>
								<li><a href="/7"> C | C++ </a></li>
							</ul>
							<span></span></li>
						
						<li><a href="list3.html">项目合作</a></li>
						<li><a href="about.html">关于博主</a></li>
						<li><a href="daohang.html">给我留言</a></li>
					</ul>
				</nav>
				<div class="searchico" ></div>
			</div>
		</header>
		<!--top end-->

		
		<router-view></router-view>


		<!-- footer -->
		<footer>
			<div class="box">
				<div class="wxbox">
					<ul>
						<li><img src="../../img/Home/wxgzh.jpg"><span>微信公众号</span></li>
						<li><img src="../../img/Home/wx.png"><span>我的微信</span></li>
					</ul>
				</div>
				<div class="endnav">
					<p><b>站点声明：</b></p>
					<p>1、本站个人博客模板，均为本人设计，个人可以使用，但是未经许可不得用于任何商业目的。</p>
					<p>2、所有文章未经授权禁止转载、摘编、复制或建立镜像，如有违反，追究法律责任。举报邮箱：<a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=HHh9cn95b3F1cHVye1xtbTJ-c3E" target="_blank">dacesmiling@qq.com</a></p>
					<p>Copyright © <a href="http://www.yangqq.com" target="_blank">www.yangqq.com</a> All Rights Reserved. 备案号：<a href="http://www.miitbeian.gov.cn/" target="_blank">蜀ICP备11002373号-1</a></p>
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

		}
	},
	created(){
		// 自动跳转到首页
		this.$router.push({path : '/Home/Start'}) 

	},
	methods:{
		

	},
	

}
</script>

<style lang="scss" scoped>
  .index-container{
		
		width:100%;
		height:100%;
		background-color: #EEEEEE;
		a { text-decoration: none;  }
		a:hover {  text-decoration: none; }
		


    
  }
</style>