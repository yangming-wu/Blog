const path = require('path')

// 导入 html-webpack-plugin 插件
const htmlWebpackPlugin = require("html-webpack-plugin")

// 导入 Vue 插件
const VueLoaderPlugin = require('vue-loader/lib/plugin')

// 这个配置文件其实就是一个 js 文件，通过Node中的模块操作，向外曝露一个配置对象
module.exports = {
  mode : 'development',
  entry : path.join(__dirname,"./src/main.js"), // 入口文件,要使用webpack打包的文件
  output : {
    path : path.join(__dirname,"./dist"), // 指定打包文件的目录
    filename : "bundle.js" // 指定输出文件的名称
  },
  plugins : [ // 配置插件节点

    new htmlWebpackPlugin({
      template : path.join(__dirname, "./src/index.html"),
      filename : "index.html"
    }),
    new VueLoaderPlugin(),
  ],
  module : {
    rules : [
      {test: /\.css$/, use : ["style-loader", "css-loader"]},
      { test: /\.scss$/, use: ['style-loader', 'css-loader', 'sass-loader'] },
      { test: /\.less$/, use: ['style-loader', 'css-loader', 'less-loader'] }, // 处理 less 文件的 loader
      {test: /\.(jpg|png|jepg|gif)$/, use : "url-loader?limit=3000&name=[hash:8]-[name].[ext]"},
      {test: /\.(ttf|svg|eot|woff|woff2)$/, use : "url-loader"},
      { test:/\.js$/, use: 'babel-loader', exclude:/node_modules/ },
      { test: /\.vue$/, use: 'vue-loader' }

    ]
  }
}