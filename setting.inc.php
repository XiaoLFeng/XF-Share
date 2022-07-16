<?php 
/*
 * 筱锋xiao_lfeng 分享系统
 * 由筱锋个人开发，不属于 锋叶FrontLeaves 团队
 * 若要商用，请与开发者联系
 * 若要闭源，请购买闭源许可
 * 尊重作者的权益
 * 
 * 本页面含有重要参数，请勿随意修改
 * 该页面内容请勿截图外泄，以免造成不必要的后果
 */

// 初始化参数
$setting = array();

/* ----------------------------  WEB控制  ----------------------------- */
// 网站DeBUG模式
$setting['Debug'] = false;
// 闭站
$setting['STOP'] = false;

/* ----------------------------  数据库连接  ----------------------------- */
// 数据库地址
$setting['SQL']['host'] = '127.0.0.1';
// 数据库库名称
$setting['SQL']['dbname'] = 'xfshare';
// 数据库用户名
$setting['SQL']['username'] = 'root';
// 数据库登陆密码
$setting['SQL']['password'] = 'X+7ily20040722';

/* ----------------------------  数据表信息  ----------------------------- */
// 网站信息数据表
$setting['SQL_DATA']['info'] = 'xfs_info';
// 网站用户数据表
$setting['SQL_DATA']['person'] = 'xfs_person';