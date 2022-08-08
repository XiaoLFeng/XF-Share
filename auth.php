<?php 
/*
 * 筱锋xiao_lfeng 分享系统
 * 由筱锋个人开发，不属于 锋叶FrontLeaves 团队
 * 若要商用，请与开发者联系
 * 若要闭源，请购买闭源许可
 * 尊重作者的权益
 */

// 检查是否登录
if (!empty($_COOKIE['user'])) {
	header('location: http://'.$_SERVER['HTTP_HOST'].'/index.php');
}
// 载入组件
include('./module/head-check.php');
// 载入参数
$type = htmlspecialchars($_GET['type']);

// 载入用户信息
$person_url = $_SERVER['HTTP_HOST'].'/api/person/?ssid='.xfs_ssid().'&type=id&username='.$_COOKIE['user'];     
$person_ch = curl_init($person_url);
curl_setopt($person_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($person_ch, CURLOPT_RETURNTRANSFER, true);
$person = curl_exec($person_ch);
$person = json_decode($person,true);

// 页面ID
$menu_id = 4;
?>
<!doctype html>
<html lang="zh">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?PHP echo $ordinary_main['info']['xfs_title']['text']; ?> | 用户登录</title>
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
if ($type == 'login' or empty($type)) {
?>
<div class="container">
	<div class="row">
		<div class="col-12 my-5"></div>
		<div class="col-3 my-5"></div>
		<div class="col-6 my-5">
			<div class="card shadow rounded-3">
				<div class="card-body">
					<form action="./plugins/login.php?type=email" method="post">
						<div class="card-title text-center my-3"><h4><strong><?PHP echo $ordinary_main['info']['xfs_title']['text']; ?> | 用户登录(邮箱)</strong></h4></div>
						<div class="card-text mt-4 mx-4">
							<div class="mb-3 row">
								<label for="staticEmail" class="col-sm-2 col-form-label"><i class="bi bi-envelope"></i> 邮箱</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="email" name="email">
								</div>
							</div>
							<div class="mb-3 row">
								<label for="inputPassword" class="col-sm-2 col-form-label"><i class="bi bi-lock"></i> 密码</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="password" name="password">
								</div>
							</div>
							<div class="mb-4 form-check">
								<input class="form-check-input" type="checkbox" value="TRUE" id="stay_login" name="stay_login">
								<label class="form-check-label">保持登录状态</label>
							</div>
							<div class="mb-4 text-center">
								<button class="btn btn-primary" type="submit"><i class="bi bi-check"></i> 提交</button>
							</div>
						</div>
					</form>
					<hr class="mx-3"/>
					<div class="row mx-3">
						<div class="col-6 text-start"><a href="?type=login2" class="text-decoration-none">使用用户名登录</a></div>
						<div class="col-6 text-end"><a href="?type=register" class="text-decoration-none">注册账户</a></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-3 my-5"></div>
		<div class="col-12 my-5"></div>
	</div>
</div>
<?PHP
} elseif ($type == 'login2') {
?>
	<div class="container">
		<div class="row">
			<div class="col-12 my-5"></div>
			<div class="col-3 my-5"></div>
			<div class="col-6 my-5">
				<div class="card shadow rounded-3">
					<div class="card-body">
						<form action="./plugins/login.php?type=username" method="post">
							<div class="card-title text-center my-3"><h4><strong><?PHP echo $ordinary_main['info']['xfs_title']['text']; ?> | 用户登录(用户名)</strong></h4></div>
							<div class="card-text mt-4 mx-4">
								<div class="mb-3 row">
									<label for="staticEmail" class="col-sm-2 col-form-label"><i class="bi bi-person"></i> 用户名</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="username" name="username">
									</div>
								</div>
								<div class="mb-4 row">
									<label for="inputPassword" class="col-sm-2 col-form-label"><i class="bi bi-lock"></i> 密码</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" id="password" name="password">
									</div>
								</div>
								<div class="mb-4 text-center">
									<button class="btn btn-primary" type="submit"><i class="bi bi-check"></i> 提交</button>
								</div>
							</div>
						</form>
						<hr class="mx-3"/>
						<div class="row mx-3">
							<div class="col-6 text-start"><a href="?type=login" class="text-decoration-none">使用邮箱登录</a></div>
							<div class="col-6 text-end"><a href="" class="text-decoration-none">注册账户</a></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-3 my-5"></div>
			<div class="col-12 my-5"></div>
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