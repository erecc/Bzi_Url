## 关于
学习PHP写的第一个小程序</br>
使用工具：</br>
        1.百度PHP代码生成器</br>
## 演示
示例站点：https://1v.hk </br>
![Example Image](images/bz_1.png)</br>
![Example Image](images/bz_2.png)</br>

## 运行环境
运行环境： PHP>5.3</br>
数据库：无</br>

## 功能：
1.支持自动添加二级域名跳转，（自动根据别名生成二级域名地址）</br>
2.支持添加黑名单（后台手动添加，黑名单检测以字符串方式）</br>
3.日志记录 （记录生成的二级域名，跳转新网址，来访IP地址）</br>

## 文件列表
在下载中，您将找到以下目录和文件  你会看到这样的东西 👇</br>
```
    bgo.css
    blacklist.php
    index.html
    log.php
    main.php
```
文件说明：</br>
   1.bgo.css         //不会写CSS，从Emlog上借用来的</br>
   2.blacklist.php  //黑名单配置文件</br>
   3.index.html    //主页，提交表单与根据来访域名前缀自动跳转至对应前缀的目录</br>
   4.log.php      //记录日志</br>
   5.main.php    //核心程序，黑名单检查，日志记录，生成跳转PHP页面全靠它了</br>
 ## 运行原理
   1.输入别名与要网址，验证别名是否为非法字符，网址是否完整合法</br>
   2.判断网址中是否存在黑名单中字符，如存在退出程序</br>
   3.别名与网址通过验证创建别名同名文件夹，并在该文件夹生成跳转PHP页面</br>
   4.生成PHP页面后，获取来访IP地址（防止被用于非法用途，后续添加拒绝服务IP列表）</br>
   5.将别名+跳转网址+访问IP 写入日志文件</br>
   6.访问方式目前有两种:</br>
     方法一：(主域名+/别名）</br>
     方法二：（别名.主域名）</br>
   7.可根据需求来定，如域名不方便使用泛解析只能使用方法一,同时在man.php文件中注释掉这一行（echo "或是直接访问：".htmlspecialchars($txt_url).".youname.com";）</br>
   
## 使用方法
   1.将域名A记录设置泛解析（*.youname.com）至你的主机空间, 同样绑定于你的主机上对应的程序主目录（非必须）</br>
   2.修改index.html 中此处位置 (var mainDomain = '这里填写你的主域名'; //填写你的域名) </br>
   3.根据需求可在 blacklist.php 中可根据需求填写黑名单字符（非必须）</br>
   
## Bug反馈
如果您发现有新的Bug可以反馈给我,在blog留言或是给我发Email 🎉</br>
  Blog: https://www.ximi.me</br>
 Email：admin@ximi.me</br>
