<?php
include('../plugins/safe.php');
include_once("../config.inc.php");
$Weblogin = $setting["sql"]["Web_login"];
// 连接数据库
$conn=new MySQLi($setting["sql"]["host"],$setting["sql"]["username"],$setting["sql"]["password"],$setting["sql"]["dbname"]);
if($conn->connect_error){
	die("数据库连接失败！".$conn->connect_error);
}
$username = sqlCheck($_POST[ "username" ]);
$password = sqlCheck($_POST[ "password" ]);

if ( $username == ""
    or $password == "" ) {
    echo <<<EOF
	<script language="javascript">
		alert( "用户名、密码不能为空！" )
		window.location.href = "../admin/"
	</script>
EOF;
} else {
    $row = $conn->query( "SELECT * FROM $Weblogin WHERE username='$username'" )->fetch_assoc();
    if ( $row == NULL ) {
        echo <<<EOF
		<script language="javascript">
			alert( "用户名不存在！" )
			window.location.href = "../admin/"
		</script>
EOF;
    } else {
        $salt = explode( "$", $row[ "password" ] )[ 2 ];
        $password = '$SHA$' . $salt . '$' . hash( "SHA256", hash( "SHA256", $password ) . "$salt" );;
        if ( $password == $row[ "password" ] ) {
            echo <<<EOF
			<script language="javascript">
				alert( "登录成功！" )
				window.location.href = "../admin/"
			</script>
EOF;
            setcookie( "username", $username, time() + 86400 , "/" );
        } else {
            echo <<<EOF
			<script language="javascript">
				alert( "密码错误！" )
				window.location.href = "../admin/"
			</script>
EOF;
        }
    }
}
mysqli_free_result($result);
mysqli_close($conn);
?>