<template>
  <div class="index-container">
		<!-- 3D轮播图效果 需要抽离为组件 -->
    <div id="page">
			<div id="section-container">

				<div id="viewport-shadow" >

					<div id="viewport">
						<div id="box" style="width:100%;">
							<figure class="slide" style="width:100%;"><img  style="width:100%;height:100%;" src="http://localhost/myblog/src/img/Home/lunbo1.jpg"></figure>
							<figure class="slide" style="width:100%;"><img  style="width:100%;height:100%;" src="http://localhost/myblog/src/img/Home/lunbo3.jpg"></figure>
							<figure class="slide" style="width:100%;"><img  style="width:100%;height:100%;" src="http://localhost/myblog/src/img/Home/lunbo4.jpg"></figure>
							<figure class="slide" style="width:100%;"><img  style="width:100%;height:100%;" src="http://localhost/myblog/src/img/Home/lunbo5.jpg"></figure>
						</div>
					</div>
					<div id="time-indicator"></div>
				</div>

				<div class="footer-container">
					<nav class="slider-controls">
						<ul id="controls">
							<li><a class="goto-slide current" href="#" data-slideindex="0"></a></li>
							<li><a class="goto-slide" href="#" data-slideindex="1"></a></li>
							<li><a class="goto-slide" href="#" data-slideindex="2"></a></li>
							<li><a class="goto-slide" href="#" data-slideindex="3"></a></li>
						</ul>
					</nav>
				</div>

			</div>
		</div>
  </div>
</template>

<script>

// 1. 导入3D轮播图js文件
import init3D from "../../../js/init3Dlunbo.js"

export default {
  data(){
    return {
			
    }
  },
  mounted(){
		// 初始化3D轮播图
		init3D("scrollVert3d");
  }
  
}
</script>

<style lang="scss" scoped>
	.index-container{

		#page {
			width: 100%;
			margin: 0 auto;

			#section-container{
				margin: 0;
				padding: 0;
				border: 0;
				font-size: 100%;
				font: inherit;
				vertical-align: baseline;

				#viewport-shadow {
					position: relative;
					width:100%;
					

						#viewport {
							width:100%;
							overflow: hidden;
						}

						#viewport, #box,  .slide{
							width:100%;
							height: 375px;
						}
						
						#time-indicator {
							width: 0px;
							height: 3px;
							background-color: #2edbac;
							position: absolute;
							top: 375px;
							left: 0px;
						}
				}
			}
			
			.footer-container{
				margin: 0;
				padding: 0;
				border: 0;
				font-size: 100%;
				font: inherit;
				vertical-align: baseline;
				position: relative;;
				

				#controls {
					position: absolute;
					top: -40px;
					left:85%;
					float: right;
					overflow: hidden;
				}

				/* line 44, sass/screen.scss */
				#controls li {
					display: inline;
				}

				.goto-slide {
					margin-left: 10px;
					width: 14px;
					height: 14px;
					display: block;
					float: left;
					border: solid 1px #000;
					background-color: #555;
					border-radius: 8px;
					-webkit-box-shadow: inset 0px 0px 8px #333;
					-moz-box-shadow: inset 0px 0px 8px #333;
					box-shadow: inset 0px 0px 8px #333;
				}

				.goto-slide.current {
					background-color: #2edbac;

				}

			}
			
		}
	}

</style>
