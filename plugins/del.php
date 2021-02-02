<?PHP
//引入需要
include_once("../config.inc.php");
// 定义变量
$hyo = $setting["sql"]["Web_db_hyo"];
$host = $setting["sql"]["host"];
$name = $setting["sql"]["username"];
$password = $setting["sql"]["password"];
$dbname = $setting["sql"]["dbname"];
$cookie = $_COOKIE["del"];
// 连接数据库
$conn = mysqli_connect($host,$name,$password,$dbname);
//条件判断
if ($del = mysqli_query($conn,"DELETE from $hyo where search='$cookie'")) {
    setcookie("del","",time()-1,"/");
    echo <<<EOF
<script language="javascript">
    alert( "成功！" )
    window.location.href = "../admin/"
</script>
EOF;
}else {
    echo <<<EOF
<script language="javascript">
    alert( "失败！" )
    window.location.href = "../admin/"
</script>
EOF;
}