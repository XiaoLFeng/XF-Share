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

// 载入用户数据库
$xfs_person = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['person']);
$xfs_person_object = mysqli_fetch_object($xfs_person);

// 页面ID
$menu_id = 1;
?>
<!doctype html>
<html lang="zh">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?PHP echo info('xfs_title') ?> | <?PHP echo info('xfs_subtitle') ?></title>
        <meta name="keywords" content="<?PHP echo info('xfs_keywords') ?>">
        <meta name="description" content="<?PHP echo info('xfs_subtitle') ?>">
        <link rel="shortcut icon" href="<?PHP echo info('xfs_icon') ?>" type="image/x-icon">
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
                        <h1><?PHP echo info('xfs_title') ?></h1> 
                        <p><?PHP echo info('xfs_subtitle') ?></p> 
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 mb-3">
                            <div class="card round-3 shadow">
                                <img src="./src/img/lazyload.png" class="card-img-top" data-src="http://ww4.sinaimg.cn/large/006y8mN6gw1fa5obmqrmvj305k05k3yh.jpg">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">锋叶 1.18.2 客户端</h5>
                                    <div class="card-text text-secondary">2022-07-15</div>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <div class="text-end"><a class="text-decoration-none" href="./article.php?uid=">进入文章👉</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3">
                            <div class="card round-3 shadow">
                                <img src="./src/img/lazyload.png" class="card-img-top" data-src="http://ww4.sinaimg.cn/large/006y8mN6gw1fa5obmqrmvj305k05k3yh.jpg">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text text-secondary">2022-07-15</p>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <div class="text-end"><a class="text-decoration-none" href="./article.php?uid=">进入文章👉</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 mb-3">
                            <div class="card round-3 shadow">
                                <img src="./src/img/lazyload.png" class="card-img-top" data-src="http://ww4.sinaimg.cn/large/006y8mN6gw1fa5obmqrmvj305k05k3yh.jpg">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text text-secondary">2022-07-15</p>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <div class="text-end"><a class="text-decoration-none" href="./article.php?uid=">进入文章👉</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="row">
                <!-- 个人信息 -->
                <div class="col-12 mb-3">
                    <div class="card round-3 shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-center"><img src="<?PHP echo $xfs_person_object->icon ?>" style="height: 120px;" class="rounded-circle border border-1"></div>
                                <div class="col-12 mt-3">
                                    <div class="card-title text-center mx-2"><h5><strong><?PHP echo $xfs_person_object->displayname ?></strong></h5></div>
                                    <div class="card-title text-center mx-2"><?PHP echo $xfs_person_object->description ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 分类 -->
                <div class="col-12 mb-3">
                    <div class="card round-3 shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-center"><img src="<?PHP echo $xfs_person_object->icon ?>" style="height: 120px;" class="rounded-circle border border-1"></div>
                                <div class="col-12 mt-3">
                                    <div class="card-title text-center mx-2"><h5><strong><?PHP echo $xfs_person_object->displayname ?></strong></h5></div>
                                    <div class="card-title text-center mx-2"><?PHP echo $xfs_person_object->description ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 最近评论 -->
                <div class="col-12 mb-3">
                    <div class="card round-3 shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-center"><img src="<?PHP echo $xfs_person_object->icon ?>" style="height: 120px;" class="rounded-circle border border-1"></div>
                                <div class="col-12 mt-3">
                                    <div class="card-title text-center mx-2"><h5><strong><?PHP echo $xfs_person_object->displayname ?></strong></h5></div>
                                    <div class="card-title text-center mx-2"><?PHP echo $xfs_person_object->description ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
