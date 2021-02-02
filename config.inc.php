<?php
/*
（简体中文）
本设计作者：筱锋xiao_lfeng
作者博客：https://www.xiaolfeng.cn/
本网站使用Docs：https://docs.x-lf.cn/Leaves-Ziyuan/
本网站可以移除版权信息，但是请注意！不能声明为原创

（繁體中文）
本設計作者：筱鋒xiao_lfeng
作者部落格：https://www.xiaolfeng.cn/
本網站使用Docs：https://docs.x-lf.cn/Leaves-Ziyuan/
本網站可以移除版權資訊，但是請注意！不能聲明為原創

（English）
The author of this design: xiao_lfeng
Author's blog: https://www.xiaolfeng.cn/
This website uses docs: https://docs.x-lf.cn/Leaves-Ziyuan/
This website can remove copyright information, but please note! Cannot be declared original :)
*/

//初始化参数
$setting = array();

/* ----------------------------  WEB页面信息(Web Info)  ----------------------------- */
// 网站名字
$setting["Web"]["name"] = "叶子分享站";
// ICO图标地址
$setting["Web"]["Icon"] = "../favicon.ico";
// 主题颜色可以看 https://www.mdui.org/docs/
// 主题颜色（主颜色）
$setting["Web"]["color"] = "light-blue";
// 主题颜色（次颜色）
$setting["Web"]["subcolor"] = "blue";
// 网站语言（目前支持zh=简体，en=English，zh-hk=繁體中文）
$setting["Web"]["lang"] = "zh";

/* ----------------------------  MySQL链接(MySQL connect)  ----------------------------- */
// 数据库地址
$setting["sql"]["host"] = "localhost";
// 数据库用户名
$setting["sql"]["username"] = "leaves";
// 数据库连接密码
$setting["sql"]["password"] = "123456";
// 选择数据库（Minecreaft游戏）
$setting["sql"]["dbname"] = "leaves";
// 选择数据表（网站）
$setting["sql"]["Web_db_hyo"] = "ziyuan";
// 选择数据表（登录）
$setting["sql"]["Web_login"] = "auth";

?>