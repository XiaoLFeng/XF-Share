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

// 获取参数
$function = htmlspecialchars($_GET['function']);
// 页面ID
$menu_id = 3;
?>
<!doctype html>
<html lang="zh">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?PHP echo $ordinary_main['info']['xfs_title']['text']; ?> | 新建文章 - 管理终端</title>
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
<form action="./plugins/tags_add_upload.php" method="post">
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-9 mb-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-4 fs-4 fw-bold"><i class="bi bi-sliders2"></i> 标签添加</div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <div class="col-4 col-lg-3 col-xl-2 align-self-center"><label class="form-label fw-bold"><i class="bi bi-tags"></i> 标签名字</label></div>
                                        <div class="col-8 col-lg-9 col-xl-10"><input type="text" class="form-control" id="tags_name" name="tags_name" placeholder="例：Minecraft"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4 col-lg-3 col-xl-2 align-self-center"><label class="form-label fw-bold"><i class="bi bi-file-earmark-minus"></i> 标签描述</label></div>
                                        <div class="col-8 col-lg-9 col-xl-10"><input type="text" class="form-control" id="tags_lore" name="tags_lore" placeholder="例：我的世界相关标签内容"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 mb-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-4 fs-5 fw-bold"><i class="bi bi-sliders2"></i> 操作</div>
                                <div class="col-12 mb-1">
                                    <div class="row text-center">
                                        <div class="col-6 d-grid gap-2 px-3">
                                            <button class="btn btn-outline-success" type="submit"><i class="bi bi-check-circle"></i> 保存发布</button>
                                        </div>
                                        <div class="col-6 d-grid gap-2 px-3">
                                            <a class="btn btn-outline-danger" href="./tags.php" role="button"><i class="bi bi-x-circle"></i> 放弃发布</a>
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
</div>
</form>
<?PHP
}
?>
<!-- 页尾 -->
<?PHP include('../module/footer.php') ?>
</body>
<!-- JavaScript -->
<script src="../static/js/bootstrap.bundle.js"></script>
<script src="../static/js/bootstrap.min.js"></script>
<script src="../static/js/jQuery.js"></script>
<script>
    var tooltipTriggerList = Array.prototype.slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
</html>