<?PHP 
// 校验是否安装
/*
if (file_exists('./install/')) {
    // 检查是否安装
    if (!file_exists('./install/install.lock')) {
        header('location:./install/index.php');
    }
}
*/

// 获取数据（获取数据库信息）
include($_SERVER['DOCUMENT_ROOT'].'/setting.inc.php');
// 链接数据库
include($_SERVER['DOCUMENT_ROOT'].'/plugins/sql_conn.php');

// 载入网站基本信息
$ordinary_main_url = $_SERVER['HTTP_HOST'].'/api/ordinary/?type=main';    
$ordinary_main_ch = curl_init($ordinary_main_url);
curl_setopt($ordinary_main_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($ordinary_main_ch, CURLOPT_RETURNTRANSFER, true);
$ordinary_main = curl_exec($ordinary_main_ch);
$ordinary_main = json_decode($ordinary_main,true);

// 从数据库获取密钥
function xfs_ssid() {
    global $conn;
    global $setting;
    $xfs_ssid = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['info']." WHERE info='xfs_ssid'");
    $xfs_ssid_object = mysqli_fetch_object($xfs_ssid);
    return $xfs_ssid_object->text;
}
