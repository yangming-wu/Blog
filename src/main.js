 // 导入 Vue 包
// import Vue from "Vue"
import Vue from '../node_modules/vue/dist/vue.js'

// 导入Vuex
import Vuex from 'vuex'
Vue.use(Vuex)

const store = new Vuex.Store();

// 导入vue-router 路由
import VueRouter from "vue-router"
Vue.use(VueRouter)

/**
 * 3. 导入 vue-resource
 * 设置请求的根路径
 * 全局设置 post 时候表单数据格式组织形式 application/x-www-form-urlencoded
 */
import VueResource from "vue-resource"
Vue.use(VueResource)
Vue.http.options.root = 'http://localhost/';
Vue.http.options.emulateJSON = true;

// 导入 router.js
import router from "./router.js"

// 导入CKeditor
import CKEditor from '@ckeditor/ckeditor5-vue'
Vue.use(CKEditor)

// 引入ElementUI
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'


// 6.2 引入 antd ui框架
import Antd from 'ant-design-vue'

// 导入 APP 组件
import App from "./App.vue"

import 'ant-design-vue/dist/antd.css'
Vue.config.productionTip = false
Vue.use(Antd)

// 解决使用Ant-Design-Vue指定警告 [Vue warn]: Failed to resolve directive: ant-input
import antInputDirective from 'ant-design-vue/es/_util/antInputDirective'
Vue.use(antInputDirective)

// 解决 [Vue warn]: Failed to resolve directive: ant-ref
import ref from 'vue-ref';
Vue.use(ref, { name: 'ant-ref' });

Vue.use(ElementUI)


// 导入 css 文件
import './css/index.css'
import './css/font-awesome-4.7.0/css/font-awesome.min.css'

// 引入 jquery
import $ from "jquery"

// 引入 bootstrap
import 'bootstrap/dist/css/bootstrap.min.css'

// 7. 实例化 Vue
var vm = new Vue({
  el : "#app",
  render : c => c(App),
  router:router, //将路由对象挂载到 vm 上
  store:store // 将store挂载到vm上
});