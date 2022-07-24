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
$files = htmlspecialchars($_GET['file']);

// 载入用户信息
$person_url = $_SERVER['HTTP_HOST'].'/api/person/?ssid='.xfs_ssid().'&username=xiao_lfeng';    
$person_ch = curl_init($person_url);
curl_setopt($person_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($person_ch, CURLOPT_RETURNTRANSFER, true);
$person = curl_exec($person_ch);
$person = json_decode($person,true);
// 载入文件信息
$file_url = $_SERVER['HTTP_HOST'].'/api/file/select/?ssid='.xfs_ssid().'&id='.$id;    
$file_ch = curl_init($file_url);
curl_setopt($file_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($file_ch, CURLOPT_RETURNTRANSFER, true);
$file = curl_exec($file_ch);
$file = json_decode($file,true);
// 载入单个文件信息
$onlyfile_url = $_SERVER['HTTP_HOST'].'/api/file/select/file.php?ssid='.xfs_ssid().'&id='.$files;    
$onlyfile_ch = curl_init($onlyfile_url);
curl_setopt($onlyfile_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($onlyfile_ch, CURLOPT_RETURNTRANSFER, true);
$onlyfile = curl_exec($onlyfile_ch);
$onlyfile = json_decode($onlyfile,true);
// 载入文章信息
$article_url = $_SERVER['HTTP_HOST'].'/api/article/select/?ssid='.xfs_ssid().'&id='.file_on();    
$article_ch = curl_init($article_url);
curl_setopt($article_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($article_ch, CURLOPT_RETURNTRANSFER, true);
$article = curl_exec($article_ch);
$article = json_decode($article,true);

// 构建函数
function file_on() {
    global $id;
    global $onlyfile;
    if (empty($id)) {
        return $onlyfile['data']['article_id'];
    } else {
        return $id;
    }
}

// 使用MarkDown转HTML编译
$Parsedown = new Parsedown();
?>
<!doctype html>
<html lang="zh">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?PHP echo $article['data']['title'] ?> - 文件下载 | <?PHP echo $ordinary_main['info']['xfs_title']['text']; ?></title>
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
<?PHP
if (!empty($id)) {
?>
<div class="container-xl my-2">
    <div class="row">
        <!-- 面包屑导航 -->
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./index.php" class="text-decoration-none text-dark"><i class="bi bi-house-door-fill"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">分类</li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="./article.php?id=<?PHP echo $id ?>" class="text-decoration-none text-dark"><?PHP echo $article['data']['title'] ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">文件下载</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 col-lg-9 mb-3">
            <div class="row">
                <!-- 内容 -->
                <div class="accordion" id="file_list">
                    <?PHP
                    // 初始化变量
                    $num = 1;
                    do {
                        // 判断是相同的文章所包含的文件
                        if ($file['data'][$num]['article_id'] == $article['data']['id']) {
                            ?>
                            <div class="accordion-item shadow-sm">
                                <h2 class="accordion-header" id="heading<?PHP echo $num ?>">
                                    <button class="accordion-button <?PHP if ($num == 1) {} else {echo 'collapsed';} ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?PHP echo $num ?>" aria-expanded="true" aria-controls="collapse<?PHP echo $num ?>">
                                        <div class="fs-5 fw-bold">
                                            <?PHP echo $file['data'][$num]['title'] ?></div><div class="text-secondary">&nbsp;&nbsp;<?PHP
                                            if ($file['data'][$num]['type'] == 'R') {
                                                echo '<span class="badge bg-success bg-opacity-75">[正式版] '.$file['data'][$num]['version'].'-'.$file['data'][$num]['type'].'</span>';
                                            } elseif ($file['data'][$num]['type'] == 'B') {
                                                echo '<span class="badge bg-primary bg-opacity-75">[测试版] '.$file['data'][$num]['version'].'-'.$file['data'][$num]['type'].'</span>';
                                            } elseif ($file['data'][$num]['type'] == 'A') {
                                                echo '<span class="badge bg-warning text-dark bg-opacity-75">[内测版] '.$file['data'][$num]['version'].'-'.$file['data'][$num]['type'].'</span>';
                                            }
                                            ?>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse<?PHP echo $num ?>" class="accordion-collapse collapse <?PHP if ($num == 1) {echo 'show';} ?>" aria-labelledby="heading<?PHP echo $num ?>" data-bs-parent="#file_list">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-12">发布时间：<?PHP echo $file['data'][$num]['time']; ?></div>
                                            <div class="col-12"><hr/></div>
                                            <div class="col-12"><?PHP echo $Parsedown->text(substr($file['data'][$num]['text'],0,201).'......'); ?></div>
                                            <div class="col-12"><a class="text-decoration-none text-info" href="?file=<?PHP echo $file['data'][$num]['id']; ?>">查看详情</a></div>
                                            <div class="col-12"><hr/></div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 fw-bold mb-1">文件下载</div>
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <ul class="list-group list-group-flush">
                                                                <?PHP
                                                                $a = 1;
                                                                do {
                                                                ?>
                                                                <li class="list-group-item">
                                                                    <div class="row">
                                                                        <div class="col-8 text-sart align-self-center fs-4"><i class="bi bi-file-earmark-text"></i> <?PHP echo $file['data'][$num]['link'][$a]['name'] ?> <font class="fs-5 text-secondary"><?PHP echo $file['data'][$num]['link'][$a]['url'] ?></font></div>
                                                                        <div class="col-4 text-end"><a class="btn btn-outline-success" href="<?PHP echo $file['data'][$num]['link'][$a]['url'] ?>" role="button"><i class="bi bi-cloud-download"></i> 下载</a></div>
                                                                    </div>
                                                                </li>
                                                                <?PHP
                                                                $a ++;
                                                                } while (!$file['data'][$num]['link'][$a]['name'] == NULL);
                                                                ?>
                                                            </ul>
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
                        $num ++;
                    } while (!$file['data'][$num]['id'] == NULL);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 mb-3">
            <div class="row">
                <!-- 内容 -->
                <div class="card shadow-sm rounded-3">
                    <div class="card-body"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?PHP
} else {
?>
<div class="container-xl my-2">
    <div class="row">
        <!-- 面包屑导航 -->
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./index.php" class="text-decoration-none text-dark"><i class="bi bi-house-door-fill"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">分类</li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="./article.php?id=<?PHP echo $onlyfile['data']['article_id'] ?>" class="text-decoration-none text-dark"><?PHP echo $article['data']['title'] ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="./article_file.php?id=<?PHP echo $onlyfile['data']['article_id'] ?>" class="text-decoration-none text-dark">文件下载</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?PHP echo $onlyfile['data']['title']; ?></li>
                </ol>
            </nav>
        </div>
        <div class="col-12 mb-3">
            <div class="row">
                <!-- 内容 -->
                <div class="card shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-1">
                                <?PHP 
                                if ($onlyfile['data']['type'] == 'R') {
                                    echo '<span class="badge bg-success bg-opacity-25 text-success">RELEASE</span>';
                                } elseif ($onlyfile['data']['type'] == 'B') {
                                    echo '<span class="badge bg-primary bg-opacity-25 text-primary">BETA</span>';
                                } elseif ($onlyfile['data']['type'] == 'A') {
                                    echo '<span class="badge bg-warning bg-opacity-25 text-warning">ALPHA</span>';
                                }
                                ?>
                                &nbsp;<font class="fs-5 fw-blod"><?PHP echo $onlyfile['data']['title']; ?></font>&nbsp;&nbsp;
                                <font class="text-secondary">Version:&nbsp;<?PHP echo $onlyfile['data']['version'].'-'.$onlyfile['data']['type']; ?></font>
                            </div>
                            <div class="col-12 text-end">发布时间：<?PHP echo $onlyfile['data']['time']; ?></div>
                            <div class="col-12"><hr/></div>
                            <div class="col-12"><?PHP echo $Parsedown->text($onlyfile['data']['text']); ?></div>
                            <div class="col-12"><hr/></div>
                            <div class="col-12 fw-bold mb-1">文件下载</div>
                            <div class="col-12">
                                <div class="card">
                                    <ul class="list-group list-group-flush">
                                        <?PHP
                                        $a = 1;
                                        do {
                                        ?>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-8 text-sart align-self-center fs-4"><i class="bi bi-file-earmark-text"></i> <?PHP echo $onlyfile['data']['link'][$a]['name'] ?> <font class="fs-5 text-secondary"><?PHP echo $onlyfile['data']['link'][$a]['url'] ?></font></div>
                                                <div class="col-4 text-end"><a class="btn btn-outline-success" href="<?PHP echo $onlyfile['data']['link'][$a]['url'] ?>" role="button"><i class="bi bi-cloud-download"></i> 下载</a></div>
                                            </div>
                                        </li>
                                        <?PHP
                                        $a ++;
                                        } while (!$onlyfile['data']['link'][$a]['name'] == NULL);
                                        ?>
                                    </ul>
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
<?PHP include('./module/footer.php') ?>
</body>
<!-- JavaScript -->
<script src="./static/js/bootstrap.min.js"></script>
</html>
