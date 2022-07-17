<?php 
/*
 * 筱锋xiao_lfeng 分享系统
 * 由筱锋个人开发，不属于 锋叶FrontLeaves 团队
 * 若要商用，请与开发者联系
 * 若要闭源，请购买闭源许可
 * 尊重作者的权益
 */

// 载入组件
include($_SERVER['DOCUMENT_ROOT'].'/module/head-check.php');
// 判断用户是否登录
if (empty($_COOKIE['user'])) {
    header('location: ../auth.php');
} else {
    // 获取用户信息
    $person_url = $_SERVER['HTTP_HOST'].'/api/person/?ssid='.xfs_ssid().'&username=xiao_lfeng';    
    $person_ch = curl_init($person_url);
    curl_setopt($person_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
    curl_setopt($person_ch, CURLOPT_RETURNTRANSFER, true);
    $person = curl_exec($person_ch);
    $person = json_decode($person,true);
    // 判断用户是否是管理员或者书写者
    if (!$person['info']['type'] == 1 or !$person['info']['type'] == 2) {
        header('location: ../index.php');
    }
}

// 页面ID
$menu_id = 3;
?>
<!doctype html>
<html lang="zh">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?PHP echo $ordinary_main['info']['xfs_title']['text']; ?> | <?PHP echo $ordinary_main['info']['xfs_subtitle']['text']; ?></title>
        <meta name="keywords" content="<?PHP echo $ordinary_main['info']['xfs_keywords']['text']; ?>">
        <meta name="description" content="<?PHP echo $ordinary_main['info']['xfs_subtitle']['text']; ?>">
        <link rel="shortcut icon" href="<?PHP echo $ordinary_main['info']['xfs_icon']['text']; ?>" type="image/x-icon">
        <!-- CSS -->
        <link href="../static/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://npm.akass.cn/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    </head>
<body>
<!-- 菜单 -->
<header>
<?PHP include('../module/header.php') ?>
</header>
<!-- 内容 -->
<?PHP 
if ($person['info']['type'] == 1) {
?>
<div class="container">
    <div class="row">
        <div class="col-12 mb-3 fs-4 fw-bold"><i class="bi bi-card-list"></i> 基本概况</div>
        <!-- 8分 -->
        <div class="col-12 col-lg-8 mb-3">
            <div class="row">
                <div class="col-6 col-lg-3 mb-3">
                    <div class="card shadow-sm rounded-3 bg-success bg-opacity-25 bg-gradient">
                        <div class="card-body text-center fs-5"><i class="bi bi-list-columns-reverse"></i> 文章 <font class="fw-bold"><?PHP echo 1 ?></font> 篇</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-3">
                    <div class="card shadow-sm rounded-3 bg-success bg-opacity-25 bg-gradient">
                        <div class="card-body text-center fs-5"><i class="bi bi-list-columns-reverse"></i> 文章 <font class="fw-bold"><?PHP echo 1 ?></font> 篇</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-3">
                    <div class="card shadow-sm rounded-3 bg-success bg-opacity-25 bg-gradient">
                        <div class="card-body text-center fs-5"><i class="bi bi-list-columns-reverse"></i> 文章 <font class="fw-bold"><?PHP echo 1 ?></font> 篇</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-3">
                    <div class="card shadow-sm rounded-3 bg-success bg-opacity-25 bg-gradient">
                        <div class="card-body text-center fs-5"><i class="bi bi-list-columns-reverse"></i> 文章 <font class="fw-bold"><?PHP echo 1 ?></font> 篇</div>
                    </div>
                </div>
                <div class="col-12 mb-3 fs-4 fw-bold"><i class="bi bi-hdd-rack"></i> 服务器信息</div>
                <div class="col-12 mb-3">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body mx-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row">操作系统</th>
                                        <td><?PHP echo php_uname('s').' '.php_uname('r'); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">运行环境</th>
                                        <td><?PHP echo $_SERVER["SERVER_SOFTWARE"]; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">域名</th>
                                        <td><?PHP echo 'http(s)://'.$_SERVER['HTTP_HOST'].'/'; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">网站文档目录</th>
                                        <td><?PHP echo $_SERVER["DOCUMENT_ROOT"]; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">PHP版本</th>
                                        <td><?PHP echo PHP_VERSION; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">服务器语言</th>
                                        <td><?PHP echo $_SERVER['HTTP_ACCEPT_LANGUAGE']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 4分 -->
        <div class="col-12 col-lg-4 mb-3">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">测试</div>
            </div>
        </div>
    </div>
</div>
<?PHP
}
?>
<!-- 页尾 -->
<?PHP include('../module/footer.php') ?>
</body>
<!-- JavaScript -->
<script src="../static/js/bootstrap.min.js"></script>
</html>
