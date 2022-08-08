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
// 获取参数
$page = htmlspecialchars($_GET['page']);

// 检查数据
if (empty($page)) {
    header('location: ?page=1');
}

// 载入个人用户信息
$person_url = $_SERVER['HTTP_HOST'].'/api/person/?ssid='.xfs_ssid().'&type=id&username='.$_COOKIE['user'];     
$person_ch = curl_init($person_url);
curl_setopt($person_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($person_ch, CURLOPT_RETURNTRANSFER, true);
$person = curl_exec($person_ch);
$person = json_decode($person,true);
// 载入文章信息
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
// 获取用户展示名字
function displayname($username) {
    $personal_url = $_SERVER['HTTP_HOST'].'/api/person/?ssid='.xfs_ssid().'&type=username&username='.$username;    
    $personal_ch = curl_init($personal_url);
    curl_setopt($personal_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
    curl_setopt($personal_ch, CURLOPT_RETURNTRANSFER, true);
    $personal = curl_exec($personal_ch);
    $personal = json_decode($personal,true);
    if ($personal['output'] == 'USERNAME_DENY') {
        return $username;
    } else {
        return $personal['info']['displayname'];
    }
}

// 页面ID
$menu_id = 1;
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
        <link href="./static/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://npm.akass.cn/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    </head>
<body>
<!-- 菜单 -->
<header>
<?PHP include('./module/header.php') ?>
</header>
<!-- 内容 -->
<div class="container-xl">
    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-12 px-2 mb-3">
                    <div class="p-5 bg-primary text-white rounded opacity-75 rounded-3 shadow">
                        <h1><?PHP echo $ordinary_main['info']['xfs_title']['text']; ?></h1> 
                        <p><?PHP echo $ordinary_main['info']['xfs_subtitle']['text']; ?></p> 
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="row">
                        <?PHP 
                        $a = 1;
                        while (!$article['data'][$a]['id'] == NULL) {
                        ?>
                        <div class="col-12 col-sm-6 mb-3">
                            <a href="./article.php?id=<?PHP echo $article['data'][$a]['id']; ?>" class="text-decoration-none text-black">
                                <div class="card rounded-3 shadow">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-1">
                                                <img class="rounded-3 shadow-sm" src="<?PHP echo $article['data'][$a]['icon_url']; ?>" width="50" height="50" alt="">
                                                <font class="mx-3 fs-5"><?PHP echo $article['data'][$a]['title']; ?></font>
                                            </div>
                                            <div class="col-6 mb-3 text-start">
                                                <div class="badge bg-secondary bg-opacity-10 text-secondary border"><? echo tags($article['data'][$a]['type']) ?></div>
                                            </div>
                                            <div class="col-6 mb-3 text-end"><i class="bi bi-person"></i> <?PHP echo displayname($article['data'][$a]['username']) ?></div>
                                            <hr/>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-4 text-secondary text-start"><i class="bi bi-eye"></i> <?PHP echo $article['data'][$a]['see']; ?></div>
                                                    <div class="col-8 text-secondary text-end"><i class="bi bi-calendar"></i> <?PHP echo $article['data'][$a]['date']; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?PHP 
                            // 判断是否达到阈值
                            if ($a <= 19) {
                                $a ++;
                            } else {
                                break;
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="row">
                <!-- 个人信息 -->
                <div class="col-12 mb-3">
                    <div class="card rounded-3 shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-center"><img src="<?PHP echo $person['info']['icon_url']; ?>" style="height: 120px;" class="rounded-circle border border-1"></div>
                                <div class="col-12 mt-3">
                                    <div class="card-title text-center mx-2"><h5><strong><?PHP echo $person['info']['displayname']; ?></strong></h5></div>
                                    <div class="card-title text-center mx-2"><?PHP echo $person['info']['description']; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 
                <div class="col-12 mb-3">
                    <div class="card rounded-3 shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-center"><img src="<?PHP echo $person['info']['icon_url']; ?>" style="height: 120px;" class="rounded-circle border border-1"></div>
                                <div class="col-12 mt-3">
                                    <div class="card-title text-center mx-2"><h5><strong><?PHP echo $person['info']['displayname']; ?></strong></h5></div>
                                    <div class="card-title text-center mx-2"><?PHP echo $person['info']['description']; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>分类 -->
                <!-- 
                <div class="col-12 mb-3">
                    <div class="card rounded-3 shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-center"><img src="<?PHP echo $person['info']['icon_url']; ?>" style="height: 120px;" class="rounded-circle border border-1"></div>
                                <div class="col-12 mt-3">
                                    <div class="card-title text-center mx-2"><h5><strong><?PHP echo $person['info']['displayname']; ?></strong></h5></div>
                                    <div class="card-title text-center mx-2"><?PHP echo $person['info']['description']; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>最近评论 -->
            </div>
        </div>
    </div>
</div>
<!-- 页尾 -->
<?PHP include('./module/footer.php') ?>
</body>
<!-- JavaScript -->
<script src="./static/js/bootstrap.min.js"></script>
</html>
