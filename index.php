<?php
include("config.inc.php");
$search = htmlspecialchars($_GET["search"]);
// 变量更新
$hyo = $setting["sql"]["Web_db_hyo"];
$host = $setting["sql"]["host"];
$name = $setting["sql"]["username"];
$password = $setting["sql"]["password"];
$dbname = $setting["sql"]["dbname"];
// 连接数据库
$conn = mysqli_connect($host,$name,$password,$dbname);
mysqli_query($conn,"set names utf8");
if ($search == NULL) {
	$result = mysqli_query($conn,"select * from $hyo");
	// 语言空置监控
	if ($setting["Web"]["lang"] == "") {
		$setting["Web"]["lang"] = array();
		$setting["Web"]["lang"] = "zh";
	}else {
		if ($setting["Web"]["lang"] == "zh") {
		}elseif ($setting["Web"]["lang"] == "zh-hk") {
		}elseif ($setting["Web"]["lang"] == "en") {
		}else {
			$setting["Web"]["lang"] = array();
			$setting["Web"]["lang"] = "zh";
		}
	}
?>
<!-- HTML内容 -->
<!DOCTYPE html>
<html lang="<?PHP echo $setting["Web"]["lang"]?>">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<title><?PHP echo $setting["Web"]["name"] ?></title>
	<link rel="shortcut icon" href="<?PHP echo $setting["Web"]["Icon"] ?>" type="image/x-icon">
    <!-- 加载 MDUI CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/css/mdui.min.css" integrity="sha384-cLRrMq39HOZdvE0j6yBojO4+1PrHfB7a9l5qLcmRm/fiWXYY+CndJPmyu5FV/9Tw" crossorigin="anonymous"/>
</head>
<body class="mdui-theme-primary-<?php echo $setting["Web"]["color"] ?> mdui-theme-accent-<?php echo $setting["Web"]["subcolor"] ?>">
    <!-- Menu -->
    <div class="mdui-toolbar mdui-color-theme mdui-shadow-5">
        <span class="mdui-typo-headline"><?PHP echo $setting["Web"]["name"] ?></span>
        <div class="mdui-toolbar-spacer"></div>
        <a href="javascript:location.reload();" class="mdui-btn mdui-btn-icon" mdui-tooltip="{content: '刷新'}"><i class="mdui-icon material-icons">refresh</i></a>
        <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">more_vert</i></a>
    </div>
    <!-- 标题 -->
    <div class="mdui-container mdui-valign">
        <div class="mdui-center">
            <p class="mdui-typo-display-3 mdui-text-center" style="font-weight:300;"><?PHP echo $setting["Web"]["name"] ?></p>
        </div>
        <br/>
        </div>
    </div>
	<div class="mdui-container mdui-valign">
        <div class="mdui-typo  mdui-col-xs-12">
            <br />
            <br />
        </div>
    </div>
    <div class="mdui-container mdui-valign">
        <div class="mdui-table-fluid mdui-typo">
            <table class="mdui-table mdui-table-hoverable">
                <thead>
                    <tr>
						<?PHP
						//语言相关
						if ($setting["Web"]["lang"] == "zh") {
						?>
                        <th>名称</th>
                        <th>进入</th>
						<th>更新时间</th>
						<?PHP
						}elseif ($setting["Web"]["lang"] == "en") {
						?>
						<th>name</th>
						<th>into</th>
						<th>update</th>
						<?PHP
						}elseif ($setting["Web"]["lang"] == "zh-hk") {
						?>
						<th>名稱</th>
						<th>進入</th>
						<th>更新時間</th>
						<?PHP
						}
						?>
                    </tr>
                </thead>
				<?php
				// 输出数据（循环输出）
                while($row = mysqli_fetch_object($result)){
                ?>
                <tbody>
                    <tr>
                        <td><?php echo $row->name ?></td>
						<td><a href="?search=<?php echo $row->search ?>" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent">
						<?PHP
						//语言相关
						if ($setting["Web"]["lang"] == "zh") {
							echo "详细查看";
						}elseif ($setting["Web"]["lang"] == "en") {
							echo "consult";
						}elseif ($setting["Web"]["lang"] == "zh-hk") {
							echo "詳細查看";
						}
						?>
						</a></td>
                        <td><?php echo $row->time ?></td>
                    </tr>
                </tbody>
                <?PHP
                }
                ?>
            </table>
        </div>
    </div>
</body>
<!-- 加载 MDUI JavaScript -->
<script
      src="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/js/mdui.min.js"
      integrity="sha384-gCMZcshYKOGRX9r6wbDrvF+TcCCswSHFucUzUPwka+Gr+uHgjlYvkABr95TCOz3A"
	  crossorigin="anonymous">
</script>
</html>
<!-- 尾部 -->
<!-- END -->
<?PHP
mysqli_free_result($result);
mysqli_close($conn);
} else {
// 从数据库调取数据
$result = mysqli_query($conn,"SELECT * FROM $hyo where search='$search'");
$row = mysqli_fetch_object($result)
?>
<!-- -------------------------------------- 查询数据 -------------------------------------- -->
<!-- HTML内容 -->
<!DOCTYPE html>
<html lang="<?PHP echo $setting["Web"]["lang"]?>">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<title><?PHP echo $setting["Web"]["name"] ?></title>
	<link rel="shortcut icon" href="<?PHP echo $setting["Web"]["Icon"] ?>" type="image/x-icon">
    <!-- 加载 MDUI CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/css/mdui.min.css" integrity="sha384-cLRrMq39HOZdvE0j6yBojO4+1PrHfB7a9l5qLcmRm/fiWXYY+CndJPmyu5FV/9Tw" crossorigin="anonymous"/>
</head>
<body class="mdui-theme-primary-<?php echo $setting["Web"]["color"] ?> mdui-theme-accent-<?php echo $setting["Web"]["subcolor"] ?>">
    <!-- Menu -->
    <div class="mdui-toolbar mdui-color-theme mdui-shadow-5">
        <span class="mdui-typo-headline"><?PHP echo $setting["Web"]["name"] ?></span>
        <div class="mdui-toolbar-spacer"></div>
        <a href="javascript:location.reload();" class="mdui-btn mdui-btn-icon" mdui-tooltip="{content: '刷新'}"><i class="mdui-icon material-icons">refresh</i></a>
        <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">more_vert</i></a>
    </div>
    <!-- 标题 -->
    <div class="mdui-container mdui-valign">
        <div class="mdui-center">
			<p class="mdui-typo-display-2 mdui-text-center" style="font-weight:300;"><strong><?PHP echo $setting["Web"]["name"] ?></strong></p>
			<p class="mdui-typo-display-1 mdui-text-center" style="font-weight:300;"><?PHP echo $row->name ?></p>
        </div>
        <br/>
        </div>
	<div class="mdui-container mdui-valign">
        <div class="mdui-typo  mdui-col-xs-12">
            <br />
            <br />
        </div>
	</div>
<!-- 欢迎介绍 -->
<div class="mdui-container">
    <a href="/" class="mdui-shadow-5 mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent">返回</a>
</div>
<br />
<br />
<div class="mdui-container">
    <div class="mdui-row">
        <div class="mdui-col-sm-12">
            <!-- 基本信息 -->
            <div class="mdui-btn-raised mdui-shadow-10">
                <div class="mdui-container">
                    <div class="mdui-typo">
						<br />
					<!-- 资源相关方面 -->
                        <div class="mdui-typo-title"><p><i class="mdui-icon material-icons">info_outline</i> <strong>
						<?PHP 
						//语言相关
						if ($setting["Web"]["lang"] == "zh") {
							echo "资源相关";
						}elseif ($setting["Web"]["lang"] == "en") {
							echo "Resource related";
						}elseif ($setting["Web"]["lang"] == "zh-hk") {
							echo "資源相關";
						}
						?>
						</strong></p></div>
                        <br />
                        <div class="mdui-container mdui-typo-body-2">
							<p><i class="mdui-icon material-icons">album</i> <?php
							//语言相关
							if ($setting["Web"]["lang"] == "zh") {
								echo "资源相关";
							}elseif ($setting["Web"]["lang"] == "en") {
								echo "Resource related";
							}elseif ($setting["Web"]["lang"] == "zh-hk") {
								echo "資源相關";
							}
							echo "：" .$row->name ?></p>
                            <p><i class="mdui-icon material-icons">add_alarm</i> <?php
							//语言相关
							if ($setting["Web"]["lang"] == "zh") {
								echo "查询名字";
							}elseif ($setting["Web"]["lang"] == "en") {
								echo "Query name";
							}elseif ($setting["Web"]["lang"] == "zh-hk") {
								echo "査詢名字";
							}
							echo "：" .$row->search ?></p>
							<p><i class="mdui-icon material-icons">access_time</i> <?php
							//语言相关
							if ($setting["Web"]["lang"] == "zh") {
								echo "更新时间";
							}elseif ($setting["Web"]["lang"] == "en") {
								echo "Update time";
							}elseif ($setting["Web"]["lang"] == "zh-hk") {
								echo "更新時間";
							}
							echo "：" .$row->time ?></p>
						<!-- 其他方面 -->
							<?PHP
							if ($row->auther_look =="") {
							}else {
							?>
							<p><i class="mdui-icon material-icons">timeline</i> <?php
							//语言相关
							if ($setting["Web"]["lang"] == "zh") {
								echo "其他方面";
							}elseif ($setting["Web"]["lang"] == "en") {
								echo "other aspects";
							}elseif ($setting["Web"]["lang"] == "zh-hk") {
								echo "其他方面";
							}
							echo "：";
							?>
							<a href="<?PHP echo	$row->anther ?>">
							<?PHP
							echo $row->auther_look ?></a></p>
							<?PHP } ?>
						</div>
						<br />
					<!-- 资源下载方面 -->
						<div class="mdui-typo-title"><p><i class="mdui-icon material-icons">file_download</i> <strong>
						<?PHP 
						//语言相关
						if ($setting["Web"]["lang"] == "zh") {
							echo "资源下载";
						}elseif ($setting["Web"]["lang"] == "en") {
							echo "Resource download";
						}elseif ($setting["Web"]["lang"] == "zh-hk") {
							echo "資源下載";
						}
						?>
						</strong></p></div>
						<br />
						<div class="mdui-container mdui-typo-body-2">
						<!-- 私人网盘 -->
							<?PHP
							if ($row->link =="") {
							}else {
							?>
							<p><i class="mdui-icon material-icons">cloud_download</i> <?php
							//语言相关
							if ($setting["Web"]["lang"] == "zh") {
								echo "私人网盘";
							}elseif ($setting["Web"]["lang"] == "en") {
								echo "Private disk";
							}elseif ($setting["Web"]["lang"] == "zh-hk") {
								echo "私人網盤";
							}
							echo "：" ?>
							<a href="<?PHP echo $row->link ?>" class="mdui-shadow-5 mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent">
							<?php
							if ($row->link_look == "") {
								echo "点击下载";
							}else {
								//语言相关
								if ($setting["Web"]["lang"] == "zh") {
									echo "密码";
								}elseif ($setting["Web"]["lang"] == "en") {
									echo "password";
								}elseif ($setting["Web"]["lang"] == "zh-hk") {
									echo "密碼";
								}
								echo "：" .$row->link_look;
							}
							?>
							</a>
							</p>
							<?PHP } ?>
						<!-- 百度网盘 -->
							<?PHP
							if ($row->baidu =="") {
							}else {
							?>
							<p><i class="mdui-icon material-icons">av_timer</i> <?php
							//语言相关
							if ($setting["Web"]["lang"] == "zh") {
								echo "百度网盘";
							}elseif ($setting["Web"]["lang"] == "en") {
								echo "Baidu disk";
							}elseif ($setting["Web"]["lang"] == "zh-hk") {
								echo "百度網盤";
							}
							echo "："?>
							<a href="<?PHP echo $row->baidu ?>" class="mdui-shadow-5 mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent">
							<?php
							if ($row->baidu_look == "") {
								echo "点击下载";
							}else {
								//语言相关
								if ($setting["Web"]["lang"] == "zh") {
									echo "密码";
								}elseif ($setting["Web"]["lang"] == "en") {
									echo "password";
								}elseif ($setting["Web"]["lang"] == "zh-hk") {
									echo "密碼";
								}
								echo "：" .$row->baidu_look;
							}
							?>
							</a>
							</p>
							<?PHP } ?>
						<!-- 蓝奏云网盘 -->
							<?PHP
							if ($row->lanzou =="") {
							}else {
							?>
							<p><i class="mdui-icon material-icons">brightness_4</i> <?php
							//语言相关
							if ($setting["Web"]["lang"] == "zh") {
								echo "蓝奏云盘";
							}elseif ($setting["Web"]["lang"] == "en") {
								echo "BlueCloud disk";
							}elseif ($setting["Web"]["lang"] == "zh-hk") {
								echo "藍奏雲盤";
							}
							echo "："?>
							<a href="<?PHP echo $row->lanzou ?>" class="mdui-shadow-5 mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent">
							<?php
							if ($row->lanzou_look == "") {
								echo "点击下载";
							}else {
								//语言相关
								if ($setting["Web"]["lang"] == "zh") {
									echo "密码";
								}elseif ($setting["Web"]["lang"] == "en") {
									echo "password";
								}elseif ($setting["Web"]["lang"] == "zh-hk") {
									echo "密碼";
								}
								echo "：" .$row->lanzou_look;
							}
							?>
							</a>
							</p>
							<?PHP } ?>
						<!-- 其他网盘 -->
							<?PHP
							if ($row->qita =="") {
							}else {
							?>
							<p><i class="mdui-icon material-icons">location_searching</i> <?php
							//语言相关
							if ($setting["Web"]["lang"] == "zh") {
								echo "其他云盘";
							}elseif ($setting["Web"]["lang"] == "en") {
								echo "Other disks";
							}elseif ($setting["Web"]["lang"] == "zh-hk") {
								echo "其他雲盤";
							}
							echo "："?>
							<a href="<?PHP echo $row->qita ?>" class="mdui-shadow-5 mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent">
							<?php
							if ($row->qita_look == "") {
								echo "点击下载";
							}else {
								//语言相关
								if ($setting["Web"]["lang"] == "zh") {
									echo "密码";
								}elseif ($setting["Web"]["lang"] == "en") {
									echo "password";
								}elseif ($setting["Web"]["lang"] == "zh-hk") {
									echo "密碼";
								}
								echo "：" .$row->qita_look;
							}
							?>
							</a>
							</p>
							<?PHP } ?>
						</div>
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br />
<br />
<br />
<br />
<br />
</body>
<!-- 加载 MDUI JavaScript -->
<script
      src="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/js/mdui.min.js"
      integrity="sha384-gCMZcshYKOGRX9r6wbDrvF+TcCCswSHFucUzUPwka+Gr+uHgjlYvkABr95TCOz3A"
	  crossorigin="anonymous">
</script>
</html>
<!-- 尾部 -->
<!-- END -->
<?PHP
}
?>
