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
$names = $_POST["name"];
$search = $_POST["search"];
$link = $_POST["link"];
$link_look = $_POST["link_look"];
$baidu = $_POST["baidu"];
$baidu_look = $_POST["baidu_look"];
$lanzou = $_POST["lanzou"];
$lanzou_look = $_POST["lanzou_look"];
$qita = $_POST["qita"];
$qita_look = $_POST["qita_look"];
$anther = $_POST["anther"];
$auther_look = $_POST["auther_look"];
$time = date("Y-m-d G:i:s");
// 连接数据库
$conn = mysqli_connect($host,$name,$password,$dbname);
//条件判断
if ($result = mysqli_query($conn,"INSERT into $hyo(name,search,link,link_look,baidu,baidu_look,lanzou,lanzou_look,qita,qita_look,anther,auther_look,time) values('$names','$search','$link','$link_look','$baidu','$baidu_look','$lanzou','$lanzou_look','$qita','$qita_look','$anther','$auther_look','$time')")) {
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