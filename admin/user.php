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
    $person_url = $_SERVER['HTTP_HOST'].'/api/person/?ssid='.xfs_ssid().'&type=id&username='.$_COOKIE['user'];    
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
        <title><?PHP echo $ordinary_main['info']['xfs_title']['text']; ?> | 用户管理 - 管理终端</title>
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
        <!-- 9分 -->
        <div class="col-12 col-lg-9 mb-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3 fs-5 fw-bold"><i class="bi bi-sliders2"></i> 用户管理</div>
                                <div class="col-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">用户ID</th>
                                                <th scope="col">用户名</th>
                                                <th scope="col">昵称</th>
                                                <th scope="col">类型</th>
                                                <th scope="col">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td><?PHP echo $person['info']['id'];?></td>
                                                <td><?PHP echo $person['info']['username'];?></td>
                                                <td><?PHP echo $person['info']['displayname'];?></td>
                                                <td>
                                                    <?PHP 
                                                    if ($person['info']['type'] == 1) {
                                                        echo '管理员';
                                                    } else {
                                                        echo '用户';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                <a class="btn btn-sm btn-outline-primary" href="./user_edit.php?user_id=<?PHP echo $person['info']['id']; ?>" role="button"><i class="bi bi-pencil"></i> 修改</a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" disabled><i class="bi bi-x-circle"></i> 删除</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 3分 -->
        <div class="col-12 col-lg-3 mb-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3 fs-5 fw-bold"><i class="bi bi-sliders2"></i> 操作</div>
                                <div class="col-12">
                                    <div class="row px-4">
                                        <a class="btn btn-outline-success mb-2" href="./article_add.php" role="button"><i class="bi bi-file-earmark-plus"></i> 添加文章</a>
                                        <a class="btn btn-outline-success mb-2" href="./tags_add.php" role="button"><i class="bi bi-tags"></i> 添加标签</a>
                                        <a class="btn btn-outline-success mb-2" href="./index.php" role="button"><i class="bi bi-house-door"></i> 管理首页</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
<script src="../static/js/bootstrap.bundle.min.js"></script>
</html>
