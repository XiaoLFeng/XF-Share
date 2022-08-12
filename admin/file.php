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
include($_SERVER['DOCUMENT_ROOT'].'/plugins/Parsedown.php');
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
$type = htmlspecialchars($_GET['type']);
$file_id = htmlspecialchars($_GET['file_id']);

// 获取对应文章文件全部大概信息
$file_all_url = $_SERVER['HTTP_HOST'].'/api/file/select/?ssid='.xfs_ssid().'&id='.$article_id;     
$file_all_ch = curl_init($file_all_url);
curl_setopt($file_all_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($file_all_ch, CURLOPT_RETURNTRANSFER, true);
$file_all = curl_exec($file_all_ch);
$file_all = json_decode($file_all,true);
// 载入文章信息
$article_url = $_SERVER['HTTP_HOST'].'/api/article/select/?ssid='.xfs_ssid().'&id='.$article_id;    
$article_ch = curl_init($article_url);
curl_setopt($article_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($article_ch, CURLOPT_RETURNTRANSFER, true);
$article = curl_exec($article_ch);
$article = json_decode($article,true);

// 使用MarkDown转HTML编译
$Parsedown = new Parsedown();

// 页面ID
$menu_id = 3;
?>
<!doctype html>
<html lang="zh">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?PHP echo $ordinary_main['info']['xfs_title']['text']; ?> | 文件管理-管理终端</title>
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
    if (empty($type) or $type == 'all') {
?>
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-9 mb-3">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="fs-5 fw-bold"><i class="bi bi-sliders2"></i> 文件列表</div>
                        </div>
                        <?PHP 
                        if (!$file_all['data']['1']['id'] == NULL) {
                        ?>
                        <div class="col-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">编号</th>
                                        <th scope="col">名字</th>
                                        <th scope="col">类型</th>
                                        <th scope="col">版本</th>
                                        <th scope="col">更新时间</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP 
                                    $num = 1;     // 定义初始
                                    do {
                                    ?>
                                    <tr>
                                        <th scope="row"><?PHP echo $file_all['data'][$num]['id']; ?></th>
                                        <td><?PHP echo $file_all['data'][$num]['title']; ?></td>
                                        <td>
                                            <?PHP
                                            if ($file_all['data'][$num]['type'] == 'R') {
                                                echo '<span class="badge bg-success bg-opacity-25 text-success">RELEASE</span>';
                                            } elseif ($file_all['data'][$num]['type'] == 'B') {
                                                echo '<span class="badge bg-primary bg-opacity-25 text-primary">BETA</span>';
                                            } elseif ($file_all['data'][$num]['type'] == 'A') {
                                                echo '<span class="badge bg-warning bg-opacity-25 text-warning">ALPHA</span>';
                                            } else {
                                                echo '<span class="badge bg-secondary">NULL</span>';
                                            }
                                            ?>    
                                        </td>
                                        <td><?PHP echo $file_all['data'][$num]['version']; ?></td>
                                        <td><?PHP echo $file_all['data'][$num]['time']; ?></td>
                                        <td>
                                            <a class="btn btn-outline-success btn-sm" href="?type=info&article_id=<?PHP echo $article_id; ?>&file_id=<?PHP echo $file_all['data'][$num]['id']; ?>" role="button"><i class="bi bi-ticket-detailed"></i> 详细</a>
                                            <a class="btn btn-outline-primary btn-sm" href="./file_edit.php?file_id=<?PHP echo $file_all['data'][$num]['id']; ?>" role="button"><i class="bi bi-pencil"></i> 修改</a>
                                            <a class="btn btn-outline-danger btn-sm" href="#" role="button"><i class="bi bi-x-circle"></i> 删除</a>
                                        </td>
                                    </tr>
                                    <?PHP 
                                    $num ++;
                                    } while (!$file_all['data'][$num]['id'] == NULL);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?PHP
                        } else {
                        ?>
                        <div class="col-12 text-center">
                            <div class="row">
                                <div class="col-12 mb-4 fs-3 fw-bold">还没有任何版本哦，创建一个吧</div>
                                <div class="col-12 mb-3"><a class="btn btn-outline-success btn-lg" href="./file_add.php" role="button"><i class="bi bi-plus-circle"></i> 创建一个版本</a></div>
                            </div>
                        </div>
                        <?PHP
                        }
                        ?>
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
                                    <div class="fs-5 fw-bold"><i class="bi bi-info"></i> 相关信息</div>
                                </div>
                                <div class="col-12 px-3">
                                    <div class="row">
                                        <div class="col-12"><strong>文章：</strong><?PHP echo $article['data']['title'];?></div>
                                        <div class="col-12"><strong>作者：</strong><?PHP echo $article['data']['username'];?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div></div>
                <div class="col-12">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="fs-5 fw-bold"><i class="bi bi-sliders2"></i> 操作管理</div>
                                </div>
                                <div class="col-12 d-grid gap-2">
                                    <a class="btn btn-outline-primary" href="./article.php" role="button"><i class="bi bi-arrow-90deg-left"></i> 返回文章列表</a>
                                    <a class="btn btn-outline-success" href="./file_add.php" role="button"><i class="bi bi-plus-circle"></i> 创建一个版本</a>
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
    } elseif ($type == 'info') {
        if (!empty($file_id)) {
            // 获取文件信息
            $file_url = $_SERVER['HTTP_HOST'].'/api/file/select/file.php?ssid='.xfs_ssid().'&id='.$file_id;     
            $file_ch = curl_init($file_url);
            curl_setopt($file_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
            curl_setopt($file_ch, CURLOPT_RETURNTRANSFER, true);
            $file = curl_exec($file_ch);
            $file = json_decode($file,true);
?>
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-9 mb-3">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="fs-5 fw-bold"><i class="bi bi-sliders2"></i> 详细信息</div>
                        </div>
                        <div class="col-12 px-4">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="fs-3 fw-bold pb-2 border-bottom"><?PHP echo $file['data']['title']; ?></div>
                                </div>
                                <div class="col-6 mb-3">
                                    <strong>类型：</strong>
                                    <?PHP 
                                    if ($file['data']['type'] == 'R') {
                                        echo '<span class="badge bg-success bg-opacity-25 text-success">RELEASE</span>';
                                    } elseif ($file['data']['type'] == 'B') {
                                        echo '<span class="badge bg-primary bg-opacity-25 text-primary">BETA</span>';
                                    } elseif ($file['data']['type'] == 'A') {
                                        echo '<span class="badge bg-warning bg-opacity-25 text-warning">ALPHA</span>';
                                    } else {
                                        echo '<span class="badge bg-secondary">NULL</span>';
                                    }
                                    ?> &nbsp;&nbsp;
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#info"><i class="bi bi-info-circle"></i></button>
                                    <div class="modal fade" id="info" tabindex="-1" aria-labelledby="infoLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="infoLabel">类型说明</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">类型分为三种：</div>
                                                        <div class="col-12 px-4">正式版：<span class="badge bg-success bg-opacity-25 text-success">RELEASE</span></div>
                                                        <div class="col-12 px-5">正式版代表这个版本是稳定的构建版本，较少BUG。</div>
                                                        <div class="col-12 px-4">测试版：<span class="badge bg-primary bg-opacity-25 text-primary">BETA</span></div>
                                                        <div class="col-12 px-5">测试版代表这个版本为发布测试，不代表最终品质。</div>
                                                        <div class="col-12 px-4">内测版：<span class="badge bg-warning bg-opacity-25 text-warning">ALPHA</span></div>
                                                        <div class="col-12 px-5">内测版有较多问题，如追求稳定请勿选择！</div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal"><i class="bi bi-check-circle"></i> 我明白了</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <strong>版本：</strong><?PHP echo $file['data']['version'].'-'.$file['data']['type']; ?>
                                </div>
                                <div class="col-12 mb-3">
                                    <strong>发布/更新时间：</strong><?PHP echo $file['data']['time']; ?>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <div class="col-12 mb-1"><strong>文章详细信息：</strong></div>
                                        <div class="col-12">
                                            <div class="card rounded-3">
                                                <div class="card-body">
                                                    <?PHP echo $Parsedown->text($file['data']['text']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 mb-1"><strong>文件列表</strong> <font color="grey">(PS: 此页面暂不支持下载，请到下载页面下载)</font></div>
                                        <div class="col-12">
                                            <?PHP 
                                            if (!$file['data']['link']['1'] == NULL) {
                                            ?>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">方式</th>
                                                        <th scope="col">链接</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?PHP
                                                    $nums = 1;
                                                        while (!$file['data']['link'][$nums] == NULL) {
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?PHP echo $nums; ?></th>
                                                        <td><?PHP echo $file['data']['link'][$nums]['name']; ?></td>
                                                        <td><?PHP echo $file['data']['link'][$nums]['url']; ?></td>
                                                    </tr>
                                                    <?PHP
                                                    $nums ++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <?PHP } else {
                                            ?>
                                            暂未上传任何文件
                                            <?PHP
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
        <div class="col-12 col-lg-4 col-xl-3 mb-3">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="fs-5 fw-bold"><i class="bi bi-sliders2"></i> 操作</div>
                        </div>
                        <div class="col-12 d-grid gap-2">
                            <a class="btn btn-outline-success" href="./file.php?article_id=<?PHP echo $article_id; ?>" role="button"><i class="bi bi-arrow-90deg-left"></i> 返回文件列表</a>
                            <a class="btn btn-outline-primary" href="./file_edit.php?file_id=<?PHP echo $file_id;?>" role="button"><i class="bi bi-pencil"></i> 修改本文件内容</a>
                            <a class="btn btn-outline-danger" href="./file.php?article_id=<?PHP echo $article_id; ?>" role="button"><i class="bi bi-x-circle"></i> 删除本文件内容</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?PHP
        } else {
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm rounded-3">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-12 mt-3 mb-4 fs-3 fw-bold">参数 file_id 缺失，请检查</div>
                        <div class="col-12 mb-3"><button type="button" class="btn btn-primary btn-lg" onclick="window.history.back()">返回上一页</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?PHP
        }
    } else {
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm rounded-3">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-12 mt-3 mb-4 fs-3 fw-bold">类型填写错误，请检查</div>
                        <div class="col-12 mb-3"><button type="button" class="btn btn-primary btn-lg" onclick="window.history.back()">返回上一页</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?PHP
    }
}
?>
<!-- 页尾 -->
<?PHP include('../module/footer.php') ?>
</body>
<!-- JavaScript -->
<script src="../static/js/bootstrap.bundle.min.js"></script>
</html>
