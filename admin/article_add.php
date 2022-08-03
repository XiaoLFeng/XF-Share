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

// 获取参数
$function = htmlspecialchars($_GET['function']);
$article_id = htmlspecialchars($_GET['article_id']);
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
<form action="./plugins/article_add_upload.php" method="post" enctype="multipart/form-data">
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-9 mb-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label fs-5 fw-bold">标题 <font color="red">*</font></label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="例：你好，世界" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">封面地址</label>
                                    <input type="text" class="form-control" id="icon_url" name="icon_url" placeholder="例：https://www.x-lf.com/icon.png">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">内容 <i class="bi bi-markdown"></i> <font color="red">*</font></label>
                                    <textarea class="form-control" rows="30" id="text" name="text" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3"><div class="card-title fs-5 fw-bold">文件</div></div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">文件标题</label>
                                            <input type="text" class="form-control" id="file_title" name="file_title" placeholder="例：XF-Share稳定版">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label fw-bold">类型</label>
                                            <select class="form-select" aria-label="Default select example" id="file_type" name="file_type">
                                                <option value="R">稳定版 - RELEASE</option>
                                                <option value="B">测试版 - BETA</option>
                                                <option value="A">内测版 - ALPHA</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label fw-bold">版本号</label>
                                            <input type="text" class="form-control" id="file_version" name="file_version" placeholder="例：1.0.0">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="formFile" class="form-label  fw-bold">文件介绍 <i class="bi bi-markdown"></i></label>
                                            <textarea class="form-control" rows="10" id="file_text" name="file_text"></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="formFile" class="form-label  fw-bold">本地上传 <font data-bs-toggle="tooltip" data-bs-placement="top" title="为了您的服务器安全建议不要上传可供PHP执行的文件（例如：.php .html .js）等等" color='blue'><i class="bi bi-question-circle"></i></font></label>
                                            <input class="form-control" type="file" id="file_offline" name="file_offline">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="formFile" class="form-label  fw-bold">其他</label>
                                            <div class="row" id="files">
                                                <div class="col-12 mb-3" id="col_1">
                                                    <div class="row" id='row_line_1'>
                                                        <div class="col-4 col-lg-3" id="files_line_U_1"><input type="text" class="form-control" id="upload_file_U_1" name="upload_file_U_1" placeholder="百度网盘"></div>
                                                        <div class="col-8 col-lg-9" id="files_line_D_1"><input type="text" class="form-control" id="upload_file_D_1" name="upload_file_D_1" placeholder="https://pan.baidu.com/s/share/"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-outline-primary" id="file_add" name="file_add"><i class="bi bi-plus"></i> 添加</button>
                                        </div>
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
                                        <option value="FALSE">不隐藏</option>
                                        <option value="TRUE">隐藏</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-1">
                                    <div class="row text-center">
                                        <div class="col-12 mb-3 d-grid gap-2 px-3">
                                            <button class="btn btn-outline-primary" type="submit"><i class="bi bi-archive"></i> 保存为草稿</button>
                                        </div>
                                        <div class="col-6 d-grid gap-2 px-3">
                                            <button class="btn btn-outline-success" type="submit"><i class="bi bi-check-circle"></i> 保存发布</button>
                                        </div>
                                        <div class="col-6 d-grid gap-2 px-3">
                                            <a class="btn btn-outline-danger" href="./article.php" role="button"><i class="bi bi-x-circle"></i> 放弃发布</a>
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
var a = 2;
$(document).ready(function(){
  $("#file_add").click(function(){
    var col_1 = document.createElement("div");
    col_1.classList = "col-12 mb-3";
    col_1.id = "col_" + a;
    var row = document.createElement("div");
    row.classList = "row";
    row.id = "row_line_" + a;
    var col_2 = document.createElement("div");
    col_2.classList = "col-4 col-lg-3";
    col_2.id = "files_line_U_" + a;
    var col_3 = document.createElement("div");
    col_3.classList = "col-8 col-lg-9";
    col_3.id = "files_line_D_" + a;
    var text_1 = document.createElement("input");
    text_1.classList = "form-control";
    text_1.placeholder = "网盘";
    text_1.type = "text";
    text_1.name = "upload_file_U_" + a;
    text_1.id = "upload_file_U_" + a;
    var text_2 = document.createElement("input");
    text_2.classList = "form-control";
    text_2.placeholder = "https://xxx.xxx.xxx/";
    text_2.type = "text";
    text_2.name = "upload_file_D_" + a;
    text_2.id = "upload_file_D_" + a;

    $("#files").append(col_1);
    $("#col_"+a).append(row);
    $("#row_line_"+a).append(col_2);
    $("#row_line_"+a).append(col_3);
    $("#files_line_U_"+a).append(text_1);
    $("#files_line_D_"+a).append(text_2);
    a ++;
  });
});
</script>
</html>