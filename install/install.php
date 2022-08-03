<?PHP
$step = htmlspecialchars($_GET['step']);
// 判断步骤为空
if (empty($step)) {
    header('location:?step=1');
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/img/favicon.png" type="image/x-icon">
    <title>XF-Ziyuan | 安装系统</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
</head>
<body>
<!-- 页眉 -->
<?PHP include('./subsidiary/header.php'); ?>
<!-- 内容 -->
<div class="container my-4">
    <div class="row">
        <div class="col-12 my-4 text-center">
            <h2>XF-Ziyuan 系统安装面板 —— 步骤 <?PHP echo $step; ?></h2>
        </div>
        <div class="col-12 my-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <form action="./step_1.php" method="post">
                            <div class="col-12">
                                <div class="my-4 mx-4">
                                    <div class="row">
                                        <div class="col-12 mb-5">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 20%;">20%</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label"><img src="../src/svg/card-heading.svg" alt=""> 站点名字 <font color="red">*</font></label>
                                                <input class="form-control" placeholder="例如：筱锋资源站" type="text" id="web_title" name="web_title" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><img src="../src/svg/link-45deg.svg" alt=""> 站点域名 <font color="red">*</font></label>
                                                <input class="form-control" placeholder="例如：zy.x-lf.com" value="<?PHP echo $_SERVER['HTTP_HOST']; ?>" type="text" id="web_domain" name="web_domain" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><img src="../src/svg/megaphone.svg" alt=""> 站点描述 <font color="red">*</font></label>
                                                <input class="form-control" placeholder="例如：愿作一个安心的分享站" type="text" id="web_desc" name="web_desc" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center p-4"><input class="btn btn-primary btn-lg" type="submit" value="下一步"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 页尾 -->
<?PHP include('./subsidiary/footer.php'); ?>
</body>
<!-- JavaScript -->
<script src="../static/js/bootstrap.bundle.min.js"></script>
</html>