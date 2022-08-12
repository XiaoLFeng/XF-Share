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
$file_id = htmlspecialchars($_GET['file_id']);

// 获取文件信息
$file_url = $_SERVER['HTTP_HOST'].'/api/file/select/file.php?ssid='.xfs_ssid().'&id='.$file_id;     
$file_ch = curl_init($file_url);
curl_setopt($file_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($file_ch, CURLOPT_RETURNTRANSFER, true);
$file = curl_exec($file_ch);
$file = json_decode($file,true);

// 页面ID
$menu_id = 3;
?>
<!doctype html>
<html lang="zh">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?PHP echo $ordinary_main['info']['xfs_title']['text']; ?> | 文件编辑-管理终端</title>
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
<form action="./plugins/file_edit_upload.php?file_id=<?PHP echo $file_id; ?>" method="post">
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-9 mb-3">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="fs-5 fw-bold"><i class="bi bi-sliders2"></i> 文件编辑</div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">文件标题</label>
                                    <input type="text" class="form-control" id="file_title" name="file_title" value="<?PHP echo $file['data']['title']; ?>">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="formFile" class="form-label  fw-bold">文件介绍 <i class="bi bi-markdown"></i></label>
                                    <textarea class="form-control" rows="10" id="file_text" name="file_text"><?PHP echo $file['data']['text']; ?></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="formFile" class="form-label  fw-bold">上传 <font color="blue" data-bs-toggle="tooltip" data-bs-placement="top" title="如您已经添加了本地上传，则无法再次创建本地上传文件"><i class="bi bi-question-circle"></i></font></label>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <?PHP
                                                $num = 1;
                                                while (!$file['data']['link'][$num]['name'] == NULL) {
                                                    if (!$file['data']['link'][1]['name'] == '本地') {
                                                ?>
                                                <div class="col-12 mb-3">
                                                    <label for="formFile" class="form-label  fw-bold">本地上传 <font data-bs-toggle="tooltip" data-bs-placement="top" title="为了您的服务器安全建议不要上传可供PHP执行的文件（例如：.php .html .js）等等" color='blue'><i class="bi bi-question-circle"></i></font></label>
                                                    <input class="form-control" type="file" id="file_offline" name="file_offline">
                                                </div>
                                                <?PHP
                                                    }
                                                ?>
                                                <div class="col-4 col-lg-3"><input type="text" class="form-control" id="edit_file_U_<?PHP echo $num; ?>" name="edit_file_U_<?PHP echo $num; ?>" value="<?PHP echo $file['data']['link'][$num]['name']; ?>"></div>
                                                <div class="col-6 col-lg-8"><input type="text" class="form-control" id="edit_file_D_<?PHP echo $num; ?>" name="edit_file_D_<?PHP echo $num; ?>" value="<?PHP echo $file['data']['link'][$num]['url']; ?>"></div>
                                                <div class="col-2 col-lg-1 mb-3"><button type="button" id="del_edit_file_D_<?PHP echo $file['data']['link'][$num]; ?>" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button></div>
                                                <script>

                                                </script>
                                                <?PHP
                                                $num ++;
                                                }
                                                ?>
                                                <div class="col-12">
                                                    <div class="row" id="files">
                                                        <div class="col-12 mb-3" id="col_1">
                                                            <div class="row" id='row_line_1'>
                                                                <div class="col-4 col-lg-3" id="files_line_U_1"><input type="text" class="form-control" id="upload_file_U_1" name="upload_file_U_1" placeholder="百度网盘"></div>
                                                                <div class="col-8 col-lg-9" id="files_line_D_1"><input type="text" class="form-control" id="upload_file_D_1" name="upload_file_D_1" placeholder="https://pan.baidu.com/s/share/"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
        <div class="col-12 col-lg-4 col-xl-3 mb-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="fs-5 fw-bold"><i class="bi bi-sliders2"></i> 设置版本</div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">类型</label>
                                    <select class="form-select" id="file_type" name="file_type">
                                        <option value="R" <?PHP if($file['data']['type'] == 'R') {echo 'selected';}?>>稳定版 - RELEASE</option>
                                        <option value="B" <?PHP if($file['data']['type'] == 'B') {echo 'selected';}?>>测试版 - BETA</option>
                                        <option value="A" <?PHP if($file['data']['type'] == 'A') {echo 'selected';}?>>内测版 - ALPHA</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">版本号</label>
                                    <input type="text" class="form-control" id="file_version" name="file_version" value="<?PHP echo $file['data']['version']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="fs-5 fw-bold"><i class="bi bi-sliders2"></i> 操作</div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6 d-grid gap-2">
                                            <button class="btn btn-outline-success" type="submit"><i class="bi bi-check-circle"></i> 保存发布</button>
                                        </div>
                                        <div class="col-6 d-grid gap-2">
                                            <button class="btn btn-outline-danger" type="button" onclick="window.history.go(-1)"><i class="bi bi-x-circle"></i> 取消发布</button>
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
<script src="../static/js/bootstrap.bundle.min.js"></script>
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

var tooltipTriggerList = Array.prototype.slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
</html>
