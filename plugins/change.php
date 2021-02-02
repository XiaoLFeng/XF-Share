<?PHP
//引入需要
include_once("../config.inc.php");
// 定义变量
$hyo = $setting["sql"]["Web_db_hyo"];
$host = $setting["sql"]["host"];
$name = $setting["sql"]["username"];
$password = $setting["sql"]["password"];
$dbname = $setting["sql"]["dbname"];
//获取数据
$names = $_POST["lname"];
$search = $_POST["lsearch"];
$link = $_POST["llink"];
$link_look = $_POST["llink_look"];
$baidu = $_POST["lbaidu"];
$baidu_look = $_POST["lbaidu_look"];
$lanzou = $_POST["llanzou"];
$lanzou_look = $_POST["llanzou_look"];
$qita = $_POST["lqita"];
$qita_look = $_POST["lqita_look"];
$anther = $_POST["lanther"];
$auther_look = $_POST["lauther_look"];
$time = date("Y-m-d G:i:s");
// 连接数据库
$coo = $_COOKIE["search"];
$conn = mysqli_connect($host,$name,$password,$dbname);
//条件判断
if ($result = mysqli_query($conn,"UPDATE $hyo set name='$names',search='$search',link='$link',link_look='$link_look',baidu='$baidu',baidu_look='$baidu_look',lanzou='$lanzou',lanzou_look='$lanzou_look',qita='$qita',qita_look='$qita_look',anther='$anther',auther_look='$auther_look',time='$time' where search='$coo'")) {
    setcookie("search","$coo",time()-1,"/");
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