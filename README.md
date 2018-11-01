## 起源
起初是给**广西科技大学**易班发展中心的光棍节活动开发的一个网站，活动结束后发现效果还不错，同学们的响应很热烈，而且在广西内的高校内也是好评不断。

于是，我就把此网站开源了，希望能对同学们有帮助。

## 链接
https://pingxonline.com/app/saylove/

## 我的博客
https://pingxonline.com/

## 主要特性
- 发起表白
- 查看表白
- 搜索某人的表白
- 点赞
- 分享
- 评论
- 猜名字
- 性别区分
- 邮件通知被表白者
- 如何让网站应用支持Emoji 
[让应用程序支持 emoji 字符](https://www.liaoxuefeng.com/article/00145803336427519ae82a6c5b5474682c0c4ba5b47fb33000)
## 目的
脱单神器助你早日脱单。

## 快速使用
1. 导入该项目中的saylovewall.sql数据库文件。

2. 修改数据库链接配置:
      修改connect.php中的


<code>        
$host = '127.0.0.1'; // 数据库地址

$user = 'root';  // 数据库用户名字

$pass = '';   // 数据连接密码

$db_name = 'wishingwall'; // 链接的数据的名字

</code>

  
3. 邮件服务配置： email.php

  登录你自己的QQ邮箱，在设置-账户中，开启SMTP功能，记录此授权码！！重要！！

  返回email.php，按照注释修改成QQ邮箱和当初开启 SMTP 时生成的授权码。

  此邮件服务效果并不乐观，因为QQ限制最大发邮件数量，短时间内大量邮件发送出去会被退回。建议使用第三方邮件平台，付费服务。



这个网站会有许许多多的BUG，欢迎大家一起来完善。

## 管理后台

后台账号密码写在admin/login.php代码里面。

支持数据修改，重发邮件等服务。

基于layui开发

## 更新历史

2017-11-10

后台基本开发完毕。

2017-11-4

计划开发： 表白大屏幕墙，自动获取最新表白（弹幕版、从顶向下显示版）
审核模式：表白之后进入审核列表，管理员使用后台审核表白，审核通过才能显示


2017-11-1
1. 管理后台正在开发中


2017-10-19

1.优化UI
2. 完善代码注释
## 支持
基于jQuery Mobile开发。

## 界面

![](https://pingxonline.com/wp-content/uploads/2017/08/1.png)

![](https://pingxonline.com/wp-content/uploads/2017/08/2.png)

![](https://pingxonline.com/wp-content/uploads/2017/08/3.png)
