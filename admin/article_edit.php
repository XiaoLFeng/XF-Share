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
$article_id = htmlspecialchars($_GET['article_id']);
// 载入文章信息
$article_url = $_SERVER['HTTP_HOST'].'/api/article/select/?ssid='.xfs_ssid().'&id='.$article_id;    
$article_ch = curl_init($article_url);
curl_setopt($article_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($article_ch, CURLOPT_RETURNTRANSFER, true);
$article = curl_exec($article_ch);
$article = json_decode($article,true);
// 载入标签信息
$tags_url = $_SERVER['HTTP_HOST'].'/api/article/select/all_tags.php?ssid='.xfs_ssid().'&array=2';    
$tags_ch = curl_init($tags_url);
curl_setopt($tags_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($tags_ch, CURLOPT_RETURNTRANSFER, true);
$tags = curl_exec($tags_ch);
$tags = json_decode($tags,true);
// 页面ID
$menu_id = 3;
?>
<!doctype html>
<html lang="zh">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?PHP echo $ordinary_main['info']['xfs_title']['text']; ?> | 文章编辑 - 管理终端</title>
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
<form action="./plugins/article_edit_upload.php?article_id=<?PHP echo $article_id; ?>" method="post">
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-9 mb-3">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fs-5 fw-bold">标题 <font color="red">*</font></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="例：你好，世界" value="<?PHP echo $article['data']['title']; ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">封面地址</label>
                            <input type="text" class="form-control" id="icon_url" name="icon_url" placeholder="例：https://www.x-lf.com/icon.png" value="<?PHP echo $article['data']['icon_url']; ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">内容 <font color="red">*</font></label>
                            <textarea class="form-control" rows="30" id="text" name="text"><?PHP echo $article['data']['text']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 mb-3">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">标签</label>
                            <select class="form-select" id="tags" name="tags">
                                <?PHP 
                                $num = 1;
                                do {
                                ?><option value="<?PHP echo $tags['data'][$num]['tags']; ?>" <?PHP if ($article['data']['type'] == $tags['data'][$num]['tags']) {
                                    echo 'selected';
                                } ?>><?PHP echo $tags['data'][$num]['name']; ?></option><?PHP
                                    $num ++;
                                } while (!$tags['data'][$num]['tags'] == NULL);
                                ?>
                            </select>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold">隐藏</label>
                            <select class="form-select" id="hide" name="hide">
                                <option value="FALSE" <?PHP if($article['data']['hide'] == "FALSE"){echo 'selected';} ?>>不隐藏</option>
                                <option value="TRUE" <?PHP if($article['data']['hide'] == "TRUE"){echo 'selected';} ?>>隐藏</option>
                            </select>
                        </div>
                        <div class="col-12 mb-1">
                            <div class="row text-center">
                                <div class="col-6">
                                    <button class="btn btn-outline-success" type="submit"><i class="bi bi-check-circle"></i> 保存修改</button>
                                </div>
                                <div class="col-6">
                                    <a class="btn btn-outline-danger" href="./article.php" role="button"><i class="bi bi-x-circle"></i> 放弃修改</a>
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
<script src="../static/js/bootstrap.bundle.min.js"></script>
<script>
    var tooltipTriggerList = Array.prototype.slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
</html>
