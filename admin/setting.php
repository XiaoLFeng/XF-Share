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
        <!-- 9分 -->
        <div class="col-12 col-lg-9 mb-3">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">
                            <form action="./plugins/setting_upload.php" method="post">
                                <div class="row">
                                    <div class="col-12 mb-3 fs-4 fw-bold"><i class="bi bi-gear"></i> 项目设置</div>
                                    <div class="col-12 mb-3 text-end"><button class="btn btn-outline-primary" type="submit"><i class="bi bi-check-lg"></i> 更新信息</button></div>
                                    <div class="col-12 mb-3 px-4">
                                        <div class="row">
                                            <div class="col-12 mb-3 fs-5 fw-bold"><i class="bi bi-card-list"></i> 网站基本信息</div>
                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-lg-3 col-xl-2 align-self-center"><label class="form-label"><i class="bi bi-house-door"></i> 网站标题 <font color="red">*</font></label></div>
                                                    <div class="col-12 col-sm-8 col-lg-9 col-xl-10"><input type="text" class="form-control" placeholder="XF-Share" id="xfs_title" name="xfs_title" value="<?PHP echo $ordinary_main['info']['xfs_title']['text']; ?>"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-lg-3 col-xl-2 align-self-center"><label class="form-label"><i class="bi bi-braces"></i> 网站副标题 <font color="red">*</font></label></div>
                                                    <div class="col-12 col-sm-8 col-lg-9 col-xl-10"><input type="text" class="form-control" placeholder="一个简易而又高效的分享源码" id="xfs_subtitle" name="xfs_subtitle" value="<?PHP echo $ordinary_main['info']['xfs_subtitle']['text']; ?>"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-lg-3 col-xl-2 align-self-center"><label class="form-label"><i class="bi bi-card-image"></i> 网站图标 <font color="red">*</font></label></div>
                                                    <div class="col-12 col-sm-8 col-lg-9 col-xl-10"><input type="text" class="form-control" placeholder="/src/img/favicon.png" id="xfs_icon" name="xfs_icon" value="<?PHP echo $ordinary_main['info']['xfs_icon']['text']; ?>"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-5">
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-lg-3 col-xl-2 align-self-center"><label class="form-label"><i class="bi bi-grip-horizontal"></i> 网站关键词 <font color="red">*</font></label></div>
                                                    <div class="col-12 col-sm-8 col-lg-9 col-xl-10"><input type="text" class="form-control" placeholder="Share,分享,分享项目" id="xfs_keywords" name="xfs_keywords" value="<?PHP echo $ordinary_main['info']['xfs_keywords']['text']; ?>"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3 fs-5 fw-bold"><i class="bi bi-key"></i> 隐私信息</div>
                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-lg-3 col-xl-2 align-self-center"><label class="form-label"><i class="bi bi-lock"></i> SSID密钥 <font color="red">*</font></label></div>
                                                    <div class="col-12 col-sm-8 col-lg-9 col-xl-10"><input type="text" class="form-control" placeholder="如不需要更改，请勿填写。修改的密钥请牢牢记住！" id="xfs_ssid" name="xfs_ssid"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-lg-3 col-xl-2 align-self-center"><label class="form-label"><i class="bi bi-file-earmark-binary"></i> 是否允许跨域 <font color="red">*</font></label></div>
                                                    <div class="col-12 col-sm-8 col-lg-9 col-xl-10">
                                                        <select class="form-select" id="xfs_allow_origin" name="xfs_allow_origin">
                                                            <option value="true" <?PHP if($ordinary_main['info']['xfs_allow_origin']['text'] == "true"){echo 'selected';}?>>开启(TRUE)</option>
                                                            <option value="false" <?PHP if($ordinary_main['info']['xfs_allow_origin']['text'] == "false"){echo 'selected';}?>>关闭(FALSE)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-end"><button class="btn btn-outline-primary" type="submit"><i class="bi bi-check-lg"></i> 更新信息</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 3分 -->
        <div class="col-12 col-lg-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="row px-3">
                                <a class="btn btn-outline-success mb-3" href="./index.php" role="button"><i class="bi bi-house"></i> 返回管理主页</a>
                                <a class="btn btn-outline-primary mb-1" href="/index.php" role="button"><i class="bi bi-house"></i> 返回主页</a>
                                <a class="btn btn-outline-primary" href="./index.php" role="button"><i class="bi bi-house"></i> 返回管理主页</a>
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
