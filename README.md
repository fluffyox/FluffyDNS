<p align="center">
<a href="https://dq.amgl.work" target="_blank" rel="noopener noreferrer">
        <img width="100" src="https://i2.100024.xyz/2023/08/06/shxvov.webp" alt="Logo" />
</p>

<div align="center">

# FluffyDNS

[![GitHub release (latest by date)](https://img.shields.io/github/v/release/FluffyOx/FluffyDNS)](https://github.com/FluffyOx/FluffyDNS/releases) ![GitHub stars](https://img.shields.io/github/stars/FluffyOx/FluffyDNS?style=flat) ![LICENSE](https://badgen.net/static/license/MIT/green)

![JS.svg](https://img1.imgtp.com/2023/08/06/Qcj9M4eW.svg) ![HTML.svg](https://img1.imgtp.com/2023/08/06/wRHfPWlm.svg) ![CSS.svg](https://img1.imgtp.com/2023/08/06/RRZiXeWU.svg)
</div>

</div>

<p align="center">
<a href="https://dq.amgl.work">官网</a> &nbsp;&bull;&nbsp;
<a href="#简介">简介</a> &nbsp;&bull;&nbsp;
<a href="#使用">使用</a> &nbsp;&bull;&nbsp;
<a href="#特性">特性</a> &nbsp;&bull;&nbsp;
<a href="#打包">特性</a> &nbsp;&bull;&nbsp;
<a href="#部署">部署</a>
</p>


<div align="center">
  <a href="https://github.com/FluffyOx/FluffyDNS/README_EN.md">English</a>
</div>

## 简介

FluffyDNS是一个DNS记录查询工具。支持web界面以及curl命令行。

## 使用

你可以访问 [官网](https://dq.amgl.work) 来使用FluffyDNS或者下载 [Releases](https://github.com/FluffyOx/FluffyDNS/releases)（国内可通过[123云盘下载](https://www.123pan.com/s/xSj8Vv-UDxU3.html)）

- 在网页上使用：

1. 在搜索框输入域名
2. 按下回车/点击查询/等待自动识别

- 在终端使用（cmd以及Linux终端）：

1. 执行`curl dq.amgl.work`可以看到使用说明
2. 执行`curl dq.amgl.work/y.qq.com` 可以看到查询结果

- 在PowerShell中使用（Win11的终端,vscode终端）

1. 执行 `(curl dq.amgl.work).Content`可以看到使用说明
2. 执行`(curl dq.amgl.work/y.qq.com).Content`可以看到查询结果

![输入即搜索](https://img1.imgtp.com/2023/08/08/TxNqywc2.gif)

![cmd演示](https://img1.imgtp.com/2023/08/08/7OlcZrZo.gif)

## 特性

1. 使用原生html js css编写。
2. 识别9000多种域名后缀，支持域名查询广泛。
3. 支持用户使用curl命令行进行交互。

## 打包
参考[Tauri官方文档](https://tauri.app)

## 部署
**这里以宝塔为例**

### 一、创建站点

宝塔首页->网站->添加站点->输入您的域名（其他选项不用改）->点击提交

![external.png](https://img1.imgtp.com/2023/08/08/UdW6LiGx.png)

### 二、部署代码

将源码拷贝到网站根目录

![external.png](https://img1.imgtp.com/2023/08/08/mRXaRqn0.png)

### 三、添加Nginx伪静态规则

复制nginx.conf ->宝塔首页->网站列表->点击网站->伪静态->粘贴配置

![img](https://img1.imgtp.com/2023/08/08/bqmJLeYH.png)

![img](https://img1.imgtp.com/2023/08/08/7EzflxLi.png)

## 开源协议

本项目遵循[MIT开源协议](https://github.com/FluffyOx/FluffyDNS/blob/main/LICENSE)



