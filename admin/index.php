<?php
//禁用错误报告
error_reporting(0);
include("../config.inc.php");
if (isset($_COOKIE["username"])==False) {
?>
<!doctype html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title><?PHP echo $setting["Web"]["name"] ?> —— 登陆系统</title>
	<link href="../css/style.css" rel="stylesheet" type="text/css">
	<!-- MDUI CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/css/mdui.min.css" integrity="sha384-cLRrMq39HOZdvE0j6yBojO4+1PrHfB7a9l5qLcmRm/fiWXYY+CndJPmyu5FV/9Tw" crossorigin="anonymous"/>
</head>
<body class="mdui-theme-primary-<?php echo $setting["Web"]["color"] ?> mdui-theme-accent-<?php echo $setting["Web"]["subcolor"] ?>">
	<div class="mdui-typo">
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	</div>
	<div class="mdui-container mdui-valign">
		<div class="mdui-center">
			<form action="../plugins/login.php" method="post">
				<h1 class="mdui-text-center" style="font-size: 36px;">筱锋资源提交登录系统</h1>
				<div class="mdui-textfield mdui-textfield-floating-label">
					<i class="mdui-icon material-icons">account_circle</i>
					<label class="mdui-textfield-label">用户名</label>
					<textarea class="mdui-textfield-input" type="text" name="username" id="userName" required></textarea>
				</div>
				<div class="mdui-textfield mdui-textfield-floating-label">
					<i class="mdui-icon material-icons">lock</i>
					<label class="mdui-textfield-label">密码</label>
					<textarea class="mdui-textfield-input" type="password" id="password" name="password" required></textarea>
				</div>
			    <p><input name="button" type="submit" class="mdui-center mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" id="button2" value="提交" required></p>
				</form>
			</div>
		</div>
</body>
<?PHP
}else {
// 定义变量
$hyo = $setting["sql"]["Web_db_hyo"];
$host = $setting["sql"]["host"];
$name = $setting["sql"]["username"];
$password = $setting["sql"]["password"];
$dbname = $setting["sql"]["dbname"];
// 连接数据库
$conn = mysqli_connect($host,$name,$password,$dbname);
$out = $_POST["delwiew"];
$look = mysqli_query($conn,"SELECT * from $hyo where search='$out'");
$result = mysqli_query($conn,"SELECT * from $hyo");
$coo = $_COOKIE["search"];
$results = mysqli_query($conn,"SELECT * from $hyo where search='$coo'");
$row = mysqli_fetch_object($results);
$count = mysqli_num_rows($result);
$cooset = array();
if (isset($cooset)) {
    setcookie( "del", $out, time() + 3600 , "/" );
    $cooset = array();
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="shortcut icon" href="<?PHP echo $setting["Web"]["Icon"] ?>" type="image/x-icon">
	<title><?PHP echo $setting["Web"]["name"] ?> &mdash; 后台</title>
	<!-- MDUI CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/css/mdui.min.css" integrity="sha384-cLRrMq39HOZdvE0j6yBojO4+1PrHfB7a9l5qLcmRm/fiWXYY+CndJPmyu5FV/9Tw" crossorigin="anonymous"/>
</head>
<body class="mdui-theme-primary-<?php echo $setting["Web"]["color"] ?> mdui-theme-accent-<?php echo $setting["Web"]["subcolor"] ?>">
<!-- 顶部份开始 -->
<!-- 菜单 -->
<div class="mdui-toolbar mdui-color-theme mdui-shadow-10">
    <span class="mdui-typo-title"><?PHP echo $setting["Web"]["name"] ?></span>
    <div class="mdui-toolbar-spacer"></div>
    <a class="mdui-btn mdui-btn-icon" mdui-tooltip="{content: '登录相关'}" mdui-menu="{target: '#menu-login'}"><i class="mdui-icon material-icons">account_circle</i></a>
    <!-- 登录菜单[Start] -->
    <ul class="mdui-menu mdui-menu-cascade" id="menu-login">
        <li class="mdui-menu-item">
            <a href="../plugins/loginout.php" class="mdui-ripple">
                <i class="mdui-menu-item-icon mdui-icon material-icons">call_missed_outgoing</i>
                登出
                <span class="mdui-menu-item-helper">退出登录</span>
            </a>
        </li>
    </li>
    </ul>
    <!-- 登陆菜单[End] -->
    <a href="javascript:location.reload();" mdui-tooltip="{content: '刷新'}" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">refresh</i></a>
    <a href="javascript:;" mdui-tooltip="{content: '暂无'}" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">more_vert</i></a>
</div>
<!-- 中间部分开始 -->
<!-- 中间部分 -->
<div class="mdui-container">
    <div class="mdui-typo">
        <br />
        <br />
    </div>
</div>
<!-- 欢迎介绍 -->
<div class="mdui-container">
    <div class="mdui-row">
        <div class="mdui-col-sm-12">
            <!-- 基本信息 -->
            <div class="mdui-btn-raised mdui-shadow-10">
                <div class="mdui-container">
                    <div class="mdui-typo">
                        <br />
                        <div class="mdui-typo-title"><p><i class="mdui-icon material-icons">info_outline</i> <strong>基本信息</strong></p></div>
                        <br />
                        <div class="mdui-typo-body-2 mdui-container">
                            <p><i class="mdui-icon material-icons">insert_chart</i> 总分享数据 <?php
                            echo $count;
                            ?></strong> 条</p>
                        </div>
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br />
<div class="mdui-container">
    <div class="mdui-row">
        <div class="mdui-col-sm-8">
            <!-- 基本信息 -->
            <div class="mdui-btn-raised mdui-shadow-10">
                <div class="mdui-container">
                    <div class="mdui-typo">
                        <br />
                        <div class="mdui-typo-title"><p><i class="mdui-icon material-icons">info_outline</i> <strong>上传数据</strong></p></div>
                        <p><b class="mdui-text-color-red">*</b> 号为必填数据</p>
                        <br />
                        <div class="mdui-typo-body-2 mdui-container">
                            <form action="../plugins/upload.php" method="POST">
                                <div class="mdui-textfield mdui-textfield-floating-label">
                                    <i class="mdui-icon material-icons">assignment_returned</i>
                                    <label class="mdui-textfield-label">资源名称 <b class="mdui-text-color-red">*</b></label>
                                    <textarea class="mdui-textfield-input" type="text" name="name" id="name" required></textarea>
                                </div>
                                <div class="mdui-textfield mdui-textfield-floating-label">
                                    <i class="mdui-icon material-icons">add_to_photos</i>
                                    <label class="mdui-textfield-label">资源查找 <b class="mdui-text-color-red">*</b>（最好英文，例如：main）</label>
                                    <textarea class="mdui-textfield-input" type="text" id="search" name="search" required></textarea>
                                </div>
                            <!-- 私人网盘 -->
                                <div class="mdui-textfield mdui-textfield-floating-label mdui-col-sm-8">
                                    <i class="mdui-icon material-icons">cloud_upload</i>
                                    <label class="mdui-textfield-label">私人网盘</label>
                                    <textarea class="mdui-textfield-input" type="text" id="link" name="link"></textarea>
                                </div>
                                <div class="mdui-textfield mdui-textfield-floating-label mdui-col-sm-4">
                                    <i class="mdui-icon material-icons">lock</i>
                                    <label class="mdui-textfield-label">提取码</label>
                                    <textarea class="mdui-textfield-input" type="text" id="link_look" name="link_look"></textarea>
                                </div>
                            <!-- 百度网盘 -->
                                <div class="mdui-textfield mdui-textfield-floating-label mdui-col-sm-8">
                                    <i class="mdui-icon material-icons">cloud_upload</i>
                                    <label class="mdui-textfield-label">百度网盘</label>
                                    <textarea class="mdui-textfield-input" type="text" id="baidu" name="baidu"></textarea>
                                </div>
                                <div class="mdui-textfield mdui-textfield-floating-label mdui-col-sm-4">
                                    <i class="mdui-icon material-icons">lock</i>
                                    <label class="mdui-textfield-label">提取码</label>
                                    <textarea class="mdui-textfield-input" type="text" id="baidu_look" name="baidu_look"></textarea>
                                </div>
                            <!-- 蓝奏云盘 -->
                                <div class="mdui-textfield mdui-textfield-floating-label mdui-col-sm-8">
                                    <i class="mdui-icon material-icons">cloud_upload</i>
                                    <label class="mdui-textfield-label">蓝奏云盘</label>
                                    <textarea class="mdui-textfield-input" type="text" id="lanzou" name="lanzou"></textarea>
                                </div>
                                <div class="mdui-textfield mdui-textfield-floating-label mdui-col-sm-4">
                                    <i class="mdui-icon material-icons">lock</i>
                                    <label class="mdui-textfield-label">提取码</label>
                                    <textarea class="mdui-textfield-input" type="text" id="lanzou_look" name="lanzou_look"></textarea>
                                </div>
                            <!-- 其他网盘 -->
                                <div class="mdui-textfield mdui-textfield-floating-label mdui-col-sm-8">
                                    <i class="mdui-icon material-icons">cloud_upload</i>
                                    <label class="mdui-textfield-label">其他网盘</label>
                                    <textarea class="mdui-textfield-input" type="text" id="qita" name="qita"></textarea>
                                </div>
                                <div class="mdui-textfield mdui-textfield-floating-label mdui-col-sm-4">
                                    <i class="mdui-icon material-icons">lock</i>
                                    <label class="mdui-textfield-label">提取码</label>
                                    <textarea class="mdui-textfield-input" type="text" id="qita_look" name="qita_look"></textarea>
                                </div>
                            <!-- 其他信息 -->
                                <div class="mdui-textfield mdui-textfield-floating-label mdui-col-sm-6">
                                    <i class="mdui-icon material-icons">panorama_fish_eye</i>
                                    <label class="mdui-textfield-label">其他方面</label>
                                    <textarea class="mdui-textfield-input" type="text" id="anther" name="auther_look"></textarea>
                                </div>
                                <div class="mdui-textfield mdui-textfield-floating-label mdui-col-sm-6">
                                    <i class="mdui-icon material-icons">panorama_fish_eye</i>
                                    <label class="mdui-textfield-label">链接</label>
                                    <textarea class="mdui-textfield-input" type="text" id="auther_look" name="anther"></textarea>
                                </div>
                                <br />
                                <br />
                                <input name="button" type="submit" class="mdui-center mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" id="button2" value="提交" required>
                            </form>
                        </div>
                        <br />
                    </div>
                    <br />
                </div>
            </div>
        </div>
        <div class="mdui-col-sm-4">
            <!-- 修改密码 -->
            <div class="mdui-btn-raised mdui-shadow-10">
                <div class="mdui-container">
                    <div class="mdui-typo">
                        <br />
                        <div class="mdui-typo-title"><p><i class="mdui-icon material-icons">error_outline</i> <strong>修改密码</strong></p></div>
                        <br />
                        <div class="mdui-typo-body-2 mdui-container">
                            <form action="../plugins/changepasswd.php" method="POST">
                                <div class="mdui-textfield mdui-textfield-floating-label">
                                    <i class="mdui-icon material-icons">lock_outline</i>
                                    <label class="mdui-textfield-label">原密码 <b class="mdui-text-color-red">*</b></label>
                                    <textarea class="mdui-textfield-input" type="password" name="yuanpw" id="yuanpw" required></textarea>
                                </div>
                                <div class="mdui-textfield mdui-textfield-floating-label">
                                    <i class="mdui-icon material-icons">lock_outline</i>
                                    <label class="mdui-textfield-label">新密码 <b class="mdui-text-color-red">*</b></label>
                                    <textarea class="mdui-textfield-input" type="password" name="newpw" id="newpw" required></textarea>
                                </div>
                                <br />
                                <input name="button" type="submit" class="mdui-center mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" id="button2" value="提交" required>
                            </form>
                        </div>
                        <br />
                    </div>
                    <br />
                </div>
            </div>
        </div>
        <div class="mdui-col-sm-4">
            <br />
            <!-- 删除数据 -->
            <div class="mdui-btn-raised mdui-shadow-10">
                <div class="mdui-container">
                    <div class="mdui-typo">
                        <br />
                        <div class="mdui-typo-title"><p><i class="mdui-icon material-icons">error_outline</i> <strong>删除数据</strong></p></div>
                        <div class="mdui-typo-body-2 mdui-container">
                            <form action="" method="POST">
                                <div class="mdui-textfield mdui-textfield-floating-label">
                                    <i class="mdui-icon material-icons">search</i>
                                    <label class="mdui-textfield-label">搜索(资源查找) <b class="mdui-text-color-red">*</b></label>
                                    <textarea class="mdui-textfield-input" type="text" name="delwiew" id="delwiew" required></textarea>
                                </div>
                                <br />
                                <input name="button" type="submit" class="mdui-center mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" id="button2" value="搜索" required>
                                <?php
                                    $looks = mysqli_fetch_object($look);
                                    if ($looks->name == NULL) {
                                        print ("<br />");
                                        print ("未查询到数据");
                                        setcookie( "del", $looks->search, time() + -1 , "/" );
                                    }else {
                                        print ("<br />");
                                        print ("信息:");
                                        print ("<br />");
                                        print ("名字：$looks->name");
                                        print ("<br />");
                                        print ("资源查找：$looks->search");
                                        print ("<br />");
                                        print ("更新日期：$looks->time");
                                        $cooset = "1" ;
                                    }
                                ?>
                            </form>
                            <form action="../plugins/del.php" method="POST">
                            <input name="222" type="submit" class="mdui-center mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" id="222" value="确认删除！" required>
                            </form>
                        </div>
                        <br />
                    </div>
                    <br />
                </div>
            </div>
        </div>
        <div class="mdui-col-sm-8">
            <br />
            <!-- 修改信息 -->
            <div class="mdui-btn-raised mdui-shadow-10">
                <div class="mdui-container">
                    <div class="mdui-typo">
                        <br />
                        <div class="mdui-typo-title"><p><i class="mdui-icon material-icons">info_outline</i> <strong>资源修改</strong></p></div>
                        <p><b class="mdui-text-color-red">*</b> 号为必填数据</p>
                        <form action="../plugins/look.php" method="POST">
                        <div class="mdui-textfield">
                            <div class="mdui-col-sm-8">
                            <i class="mdui-icon material-icons">search</i>
                            <label class="mdui-textfield-label">资源名称（填入资源查找数据） <b class="mdui-text-color-red">*</b></label>
                            <input class="mdui-textfield-input" type="text" id="looknow" name="looknow" required/>
                            </div>
                            <div class="mdui-col-sm-4">
                            <input name="QAQ" type="submit" class="mdui-center mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" id="QAQ" value="查询" required>
                            </div>
                        </form>
                        </div>
                        <div class="mdui-typo-body-2 mdui-container">
                            <form action="../plugins/change.php" method="POST">
                                <div class="mdui-textfield">
                                    <i class="mdui-icon material-icons">assignment_returned</i>
                                    <label class="mdui-textfield-label">资源名称 <b class="mdui-text-color-red">*</b></label>
                                    <input class="mdui-textfield-input" type="text" id="lname" name="lname" value="<?PHP echo $row->name ?>" required/>
                                </div>
                                <div class="mdui-textfield">
                                    <i class="mdui-icon material-icons">add_to_photos</i>
                                    <label class="mdui-textfield-label">资源查找 <b class="mdui-text-color-red">*</b>（最好英文，例如：main）</label>
                                    <input class="mdui-textfield-input" type="text" id="lsearch" name="lsearch" value="<?PHP echo $row->search ?>"/>
                                </div>
                            <!-- 私人网盘 -->
                                <div class="mdui-textfield mdui-col-sm-8">
                                    <i class="mdui-icon material-icons">cloud_upload</i>
                                    <label class="mdui-textfield-label">私人网盘</label>
                                    <input class="mdui-textfield-input" type="text" id="llink" name="llink" value="<?PHP echo $row->link ?>"/>
                                </div>
                                <div class="mdui-textfield mdui-col-sm-4">
                                    <i class="mdui-icon material-icons">lock</i>
                                    <label class="mdui-textfield-label">提取码</label>
                                    <input class="mdui-textfield-input" type="text" id="llink_look" name="llink_look" value="<?PHP echo $row->link_look ?>"/>
                                </div>
                            <!-- 百度网盘 -->
                                <div class="mdui-textfield mdui-col-sm-8">
                                    <i class="mdui-icon material-icons">cloud_upload</i>
                                    <label class="mdui-textfield-label">百度网盘</label>
                                    <input class="mdui-textfield-input" type="text" id="lbaidu" name="lbaidu" value='<?PHP echo $row->baidu ?>'/>
                                </div>
                                <div class="mdui-textfield mdui-col-sm-4">
                                    <i class="mdui-icon material-icons">lock</i>
                                    <label class="mdui-textfield-label">提取码</label>
                                    <input class="mdui-textfield-input" type="text" id="lbaidu_look" name="lbaidu_look" value='<?PHP echo $row->baidu_look ?>'/>
                                </div>
                            <!-- 蓝奏云盘 -->
                                <div class="mdui-textfield mdui-col-sm-8">
                                    <i class="mdui-icon material-icons">cloud_upload</i>
                                    <label class="mdui-textfield-label">蓝奏云盘</label>
                                    <input class="mdui-textfield-input" type="text" id="llanzou" name="llanzou" value='<?PHP echo $row->lanzou ?>'/>
                                </div>
                                <div class="mdui-textfield mdui-col-sm-4">
                                    <i class="mdui-icon material-icons">lock</i>
                                    <label class="mdui-textfield-label">提取码</label>
                                    <input class="mdui-textfield-input" type="text" id="llanzou_look" name="llanzou_look" value='<?PHP echo $row->lanzou_look ?>'/>
                                </div>
                            <!-- 其他网盘 -->
                                <div class="mdui-textfield mdui-col-sm-8">
                                    <i class="mdui-icon material-icons">cloud_upload</i>
                                    <label class="mdui-textfield-label">其他网盘</label>
                                    <input class="mdui-textfield-input" type="text" id="lqita" name="lqita" value='<?PHP echo $row->qita ?>'/>
                                </div>
                                <div class="mdui-textfield mdui-col-sm-4">
                                    <i class="mdui-icon material-icons">lock</i>
                                    <label class="mdui-textfield-label">提取码</label>
                                    <input class="mdui-textfield-input" type="text" id="lqita_look" name="lqita_look" value='<?PHP echo $row->qita ?>'/>
                                </div>
                            <!-- 其他信息 -->
                                <div class="mdui-textfield mdui-col-sm-6">
                                    <i class="mdui-icon material-icons">panorama_fish_eye</i>
                                    <label class="mdui-textfield-label">其他方面</label>
                                    <input class="mdui-textfield-input" type="text" id="lauther_look" name="lauther_look" value='<?PHP echo $row->auther_look ?>'/>
                                </div>
                                <div class="mdui-textfield mdui-col-sm-6">
                                    <i class="mdui-icon material-icons">panorama_fish_eye</i>
                                    <label class="mdui-textfield-label">链接</label>
                                    <input class="mdui-textfield-input" type="text" id="lanther" name="lanther" value='<?PHP echo $row->anther ?>'/>
                                </div>
                                <br />
                                <br />
                                <input name="change" type="submit" class="mdui-center mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" id="change" value="提交" required>
                            </form>
                        </div>
                        <br />
                    </div>
                    <br />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mdui-container">
    <div class="mdui-typo">
        <br />
        <br />
    </div>
</div>
<!-- Another -->
</body>
<?PHP
}
?>
<!-- 引入MDUI JS -->
<script src="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/js/mdui.min.js" crossorigin="anonymous" integrity="sha384-gCMZcshYKOGRX9r6wbDrvF+TcCCswSHFucUzUPwka+Gr+uHgjlYvkABr95TCOz3A"></script>
</html>