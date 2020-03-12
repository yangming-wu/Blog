// 1. 导入 Vue-router 包
import VueRouter from "vue-router"
const originalPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
  return originalPush.call(this, location).catch(err => err)
}


// 2. 导入相应的路由组件

// 后台组件
import Back from "./components/Back/index.vue"
import login from "./components/Back/login.vue"
import Start from "./components/Back/start.vue"
import Category from "./components/Back/Category.vue"
import addCategory from "./components/Back/Subcomponents/Category/add.vue"
import editCategory from "./components/Back/Subcomponents/Category/edit.vue"
import Article from "./components/Back/Article.vue"
import addArticle from "./components/Back/Subcomponents/Article/add.vue"
import editArticle from "./components/Back/Subcomponents/Article/edit.vue"
import recycleArticle from "./components/Back/Subcomponents/Article/recycle.vue"
import comment from "./components/Back/comment.vue"
import master from "./components/Back/master.vue"
import Links from "./components/Back/Links.vue"

// 前台组件
import Home from "./components/Home/index.vue"
import start from "./components/Home/start.vue" // 首页
import project from "./components/Home/project.vue"
import message from "./components/Home/message.vue"
import Blogger from "./components/Home/Blogger.vue"
import SinglePage from "./components/Home/SinglePage.vue"
import ArticleList from "./components/Home/ArticleList.vue"
import Login from "./components/Home/Login.vue"
import Register from "./components/Home/Register.vue"

// 创建 VueRouter 实例化对象
var router = new VueRouter({
  routes : [
    {path:"/", redirect: "/Home/start"},
    {path:"/Back", component: Back, children:[
      { path: 'Start', component: Start },
      { path: 'Category', component: Category },
      { path: 'Category/add', component: addCategory },
      {path:'Category/edit/:cate_id/', component: editCategory},
      { path: 'Article', component: Article },
      {path: 'Article/add', component: addArticle},
      {path: 'Article/edit/:art_id/', component: editArticle},
      {path: 'Article/recycle', component: recycleArticle},
      { path: 'comment', component: comment },
      { path: 'master', component: master },
      { path: 'Links', component: Links },
    ]},
    {path:"/Back/login", component:login},

    {path:"/Home", component:Home, children:[
      { path: 'start', component:  start},
      { path: 'project', component: project},
      { path: 'message', component: message},
      { path: 'Blogger', component: Blogger},
      { path: 'Article/:cate_name/:art_id/', component: SinglePage},
      {path: 'ArticleList/:cate_name/', component: ArticleList}
      
    ]},
    { path: '/Home/Login', component: Login},
    { path: '/Home/Register', component: Register}
  ]
});


// 把 router 对象曝露出去
export default router