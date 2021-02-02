<?php
include('../plugins/safe.php');
include_once("../config.inc.php");
$Weblogin = $setting["sql"]["Web_login"];
$cookie = $_COOKIE["username"];
// 连接数据库
$conn=new MySQLi($setting["sql"]["host"],$setting["sql"]["username"],$setting["sql"]["password"],$setting["sql"]["dbname"]);
if($conn->connect_error){
	die("数据库连接失败！".$conn->connect_error);
}
$yuanpw = sqlCheck($_POST[ "yuanpw" ]);
$newpw = sqlCheck($_POST[ "newpw" ]);

if ( $yuanpw == ""
    or $newpw == "" ) {
    echo <<<EOF
	<script language="javascript">
		alert( "密码不能为空！" )
		window.location.href = "../admin/"
	</script>
EOF;
} else {
    $row = $conn->query( "SELECT * FROM $Weblogin WHERE username='$cookie'" )->fetch_assoc();
    if ( $row == NULL ) {
        echo <<<EOF
		<script language="javascript">
			alert( "用户名不存在！" )
		</script>
EOF;
    } else {
        $salt = explode( "$", $row[ "newpw" ] )[ 2 ];
        $newpw = '$SHA$' . $salt . '$' . hash( "SHA256", hash( "SHA256", $newpw ) . "$salt" );;
        if ( $newpw == $row[ "newpw" ] ) {
            echo <<<EOF
			<script language="javascript">
				alert( "修改成功！" )
			</script>
EOF;
        } else {
            echo <<<EOF
			<script language="javascript">
				alert( "修改失败！" )
			</script>
EOF;
        }
    }
}
mysqli_free_result($result);
mysqli_close($conn);
?>