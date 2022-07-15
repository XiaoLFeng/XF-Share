<?php 
/*
 * 筱锋xiao_lfeng 分享系统
 * 由筱锋个人开发，不属于 锋叶FrontLeaves 团队
 * 若要商用，请与开发者联系
 * 若要闭源，请购买闭源许可
 * 尊重作者的权益
 */

// 载入组件
include('./module/head-check.php');

?>
<!doctype html>
<html lang="zh">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?PHP echo $content->title ?> | 用户中心</title>
    <meta name="keywords" content="<?PHP echo $content->keywords ?>">
    <meta name="description" content="<?PHP echo $content->subtitle ?>">
    <link rel="shortcut icon" href="<?PHP echo $content->icon ?>" type="image/x-icon">
    <!-- CSS -->
    <link href="./static/css/bootstrap.min.css" rel="stylesheet">
  </head>
<body>
<!-- 菜单 -->
<header>
<?PHP include('./module/header.php') ?>
</header>
<!-- 内容 -->
<!-- 页尾 -->
<?PHP include('./subsidiary/footer.php') ?>
</body>
<!-- JavaScript -->
<script src="./static/js/bootstrap.min.js"></script>
</html>
