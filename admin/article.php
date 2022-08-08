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
$page = htmlspecialchars($_GET['page']);
// 若无页码配置，则修改数据
if (empty($page)) {
    header('location: ?page=1');
}

// 获取文章信息
$article_url = $_SERVER['HTTP_HOST'].'/api/article/select/all_article.php?ssid='.xfs_ssid().'&array=1&page='.$page;    
$article_ch = curl_init($article_url);
curl_setopt($article_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($article_ch, CURLOPT_RETURNTRANSFER, true);
$article = curl_exec($article_ch);
$article = json_decode($article,true);
// 载入标签信息
function tags($tags) {
    $tags_url = $_SERVER['HTTP_HOST'].'/api/article/select/tags.php?ssid='.xfs_ssid().'&tags='.$tags;    
    $tags_ch = curl_init($tags_url);
    curl_setopt($tags_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
    curl_setopt($tags_ch, CURLOPT_RETURNTRANSFER, true);
    $tags = curl_exec($tags_ch);
    $tags = json_decode($tags,true);
    if ($tags['data']['name'] == NULL) {
        return '未分类';
    } else {
        return $tags['data']['name'];
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
        <title><?PHP echo $ordinary_main['info']['xfs_title']['text']; ?> | 管理终端</title>
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
        <div class="col-12 col-lg-9 mb-3">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="fs-5 fw-bold"><i class="bi bi-sliders2"></i> 文章列表</div>
                        </div>
                        <div class="col-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">文章名称</th>
                                    <th scope="col">标签</th>
                                    <th scope="col">修改时间</th>
                                    <th scope="col">访问</th>
                                    <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    $num = 1;
                                    do {
                                    ?>
                                    <tr>
                                        <th scope="row"><?PHP echo $num; ?></th>
                                        <td><?PHP echo $article['data'][$num]['title']; ?></td>
                                        <td><span class="badge bg-secondary"><?PHP echo tags($article['data'][$num]['type']); ?></span></td>
                                        <td><?PHP
                                            if ($article['data'][$num]['update_date'] == NULL) {
                                                echo $article['data'][$num]['date'];
                                            } else {
                                                echo $article['data'][$num]['update_date'];
                                            }; 
                                            ?>
                                        </td>
                                        <td><?PHP echo $article['data'][$num]['see']; ?></td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-primary" href="./article_edit.php?article_id=<?PHP echo $article['data'][$num]['id']; ?>" role="button"><i class="bi bi-pencil"></i> 修改</a>
                                            <a class="btn btn-sm btn-outline-success" href="./file.php?article_id=<?PHP echo $article['data'][$num]['id']; ?>" role="button"><i class="bi bi-file-earmark-text"></i> 文件</a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-<?PHP echo $num; ?>"><i class="bi bi-x-circle"></i> 删除</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="modal-<?PHP echo $num; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">您确认吗？</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12">您确认删除 <strong><?PHP echo $article['data'][$num]['title']; ?></strong> 文章吗？</div>
                                                                <div class="col-12">这将会造成你很久都看不到它的！</div>
                                                                <div class="col-12">如果你想好了就按下红色按钮吧~</div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn bg-primary text-white" data-bs-dismiss="modal"><i class="bi bi-hand-index"></i> 点错了</button>
                                                            <a class="btn btn-danger text-white" href="./plugins/article_delete_upload.php?article_id=<?PHP echo $article['data'][$num]['id']; ?>" role="button"><i class="bi bi-exclamation-circle"></i> 我确认</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?PHP
                                    $num ++;
                                    } while (!$article['data'][$num]['id'] == NULL);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 mb-3">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="fs-5 fw-bold mb-3"><i class="bi bi-sliders2"></i> 操作</div>
                        </div>
                        <div class="col-12">
                            <div class="row px-4">
                                <a class="btn btn-outline-success mb-2" href="./article_add.php" role="button"><i class="bi bi-file-earmark-plus"></i> 添加文章</a>
                                <a class="btn btn-outline-success mb-2" href="./tags.php" role="button"><i class="bi bi-tags"></i> 标签管理</a>
                                <a class="btn btn-outline-success mb-2" href="./index.php" role="button"><i class="bi bi-house-door"></i> 管理首页</a>
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
