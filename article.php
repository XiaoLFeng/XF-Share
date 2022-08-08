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
include('./plugins/Parsedown.php');
// 获取参数
$id = htmlspecialchars($_GET['id']);

// 载入用户信息
$person_url = $_SERVER['HTTP_HOST'].'/api/person/?ssid='.xfs_ssid().'&type=id&username='.$_COOKIE['user']; 
$person_ch = curl_init($person_url);
curl_setopt($person_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($person_ch, CURLOPT_RETURNTRANSFER, true);
$person = curl_exec($person_ch);
$person = json_decode($person,true);
// 载入文章信息
$article_url = $_SERVER['HTTP_HOST'].'/api/article/select/?ssid='.xfs_ssid().'&id='.$id;
$article_ch = curl_init($article_url);
curl_setopt($article_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($article_ch, CURLOPT_RETURNTRANSFER, true);
$article = curl_exec($article_ch);
$article = json_decode($article,true);
// 载入文件信息
$file_url = $_SERVER['HTTP_HOST'].'/api/file/select/?ssid='.xfs_ssid().'&id='.$id;
$file_ch = curl_init($file_url);
curl_setopt($file_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($file_ch, CURLOPT_RETURNTRANSFER, true);
$file = curl_exec($file_ch);
$file = json_decode($file,true);

// 使用MarkDown转HTML编译
$Parsedown = new Parsedown();
?>
<!doctype html>
<html lang="zh">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?PHP echo $article['data']['title'] ?> | <?PHP echo $ordinary_main['info']['xfs_title']['text']; ?></title>
        <meta name="keywords" content="<?PHP echo $ordinary_main['info']['xfs_keywords']['text']; ?>">
        <meta name="description" content="<?PHP echo $ordinary_main['info']['xfs_subtitle']['text']; ?>">
        <link rel="shortcut icon" href="<?PHP echo $ordinary_main['info']['xfs_icon']['text']; ?>" type="image/x-icon">
        <!-- CSS -->
        <link href="./static/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://npm.akass.cn/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    </head>
<body>
<!-- 菜单 -->
<header>
<?PHP include('./module/header.php') ?>
</header>
<!-- 内容 -->
<div class="container-xl my-2">
    <div class="row">
        <!-- 面包屑导航 -->
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./index.php" class="text-decoration-none text-dark"><i class="bi bi-house-door-fill"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">分类</li>
                    <li class="breadcrumb-item active" aria-current="page"><?PHP echo $article['data']['title'] ?></li>
                </ol>
            </nav>
        </div>
        <div class="col-12 col-lg-9 mb-3">
            <div class="row">
                <!-- 内容 -->
                <div class="col-12 mb-3">
                    <div class="card rounded-3 shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4 col-sm-3 col-md-2 col-xxl-1"><img class="rounded-3" width="75" height="75" src="<?PHP echo $article['data']['icon_url'] ?>" alt=""></div>
                                        <div class="col-8 col-sm-9 col-md-10 col-xxl-11 align-self-center px-4">
                                            <h5><?PHP echo $article['data']['title'] ?></h5>
                                            <font color='grey'><i class="bi bi-eye"></i> <?PHP echo $article['data']['see'] ?> <i class="bi bi-clock"></i> <?PHP echo $article['data']['date'] ?></font>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12"><hr/></div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-outline-primary" id="copy-tosBtn"><i class="bi bi-clipboard"></i> 复制链接</button>
                                </div>
                                <div class="col-12"><hr/></div>
                                <div class="col-12"><?PHP echo $Parsedown->text($article['data']['text']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 评论 -->
                <div class="col-12 mb-3">
                    <div class="card rounded-3 shadow">
                        <div class="card-header"><i class="bi bi-chat-left-text"></i> 评论</div>
                        <div class="card-body">
                            放着测试用
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 mb-3">
            <div class="row">
                <!-- 个人信息 -->
                <div class="col-12 mb-3">
                    <div class="card rounded-3 shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-2"><img src="<?PHP echo $person['info']['icon_url']; ?>" style="height: 40px;" class="rounded-circle border border-1"></div>
                                        <div class="col-10 align-self-center ps-4"><?PHP echo $person['info']['displayname']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 版本信息 -->
                <div class="col-12 mb-3">
                    <div class="card rounded-3 shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="card-title"><h5><strong>版本列表</strong></h5></div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <div class="col-4 col-xxl-3 align-self-center">
                                            <?PHP
                                            if ($file['data'][1]['type'] == 'R') {
                                                ?>
                                                <span class="badge bg-success bg-opacity-25 text-success">RELEASE</span>
                                                <?PHP
                                            } elseif ($file['data'][1]['type'] == 'B') {
                                                ?>
                                                <span class="badge bg-primary bg-opacity-25 text-primary">BETA</span>
                                                <?PHP
                                            } elseif ($file['data'][1]['type'] == 'A') {
                                                ?>
                                                <span class="badge bg-warning bg-opacity-25 text-warning">APLHA</span>
                                                <?PHP
                                            }
                                            ?>
                                        </div>
                                        <div class="col-8">
                                            <a href="./article_file.php?file=<?PHP echo $file['data'][1]['id']; ?>" class="text-decoration-none"><strong><?PHP echo $file['data'][1]['version']; ?></strong></a><br/><font class="text-secondary"><?PHP echo $file['data'][1]['time']; ?></font>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12"><a href="./article_file.php?id=<?PHP echo $article['data']['id'] ?>" class="text-decoration-none text-dark">+ 其余 XX 个版本</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 时间信息 -->
                <div class="col-12 mb-3">
                    <div class="card rounded-3 shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <h5><strong>时间</strong></h5>
                                </div>
                                <hr class="px-5"/>
                                <div class="col-12 mb-3 text-secondary">
                                    <h6><strong>发布时间</strong></h6>
                                    <?PHP echo $article['data']['date'] ?>
                                </div>
                                <div class="col-12 text-secondary">
                                    <h6><strong>更新时间</strong></h6>
                                    <?PHP if (empty($article['data']['update_date'])) {
                                        echo $article['data']['date'];
                                    } else {
                                        echo $article['data']['update_date'];
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Toasts -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="copy-tos" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Bootstrap</strong>
            <small>限制</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Hello, world! This is a toast message.
        </div>
    </div>
</div>
<!-- 页尾 -->
<?PHP include('./module/footer.php') ?>
</body>
<!-- JavaScript -->
<script src="./static/js/bootstrap.min.js"></script>
</html>
