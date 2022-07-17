<?PHP
/*
 * 前置组件
 */

// 设置请求头
header('Content-Type: application/json;charset=utf-8');

// 获取数据（获取数据库信息）
include($_SERVER['DOCUMENT_ROOT'].'/setting.inc.php');
// 链接数据库
include($_SERVER['DOCUMENT_ROOT'].'/plugins/sql_conn.php');

// 从数据库获取密钥
function xfs_ssid() {
    global $conn;
    global $setting;
    $xfs_ssid = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['info']." WHERE info='xfs_ssid'");
    $xfs_ssid_object = mysqli_fetch_object($xfs_ssid);
    return $xfs_ssid_object->text;
}
// 从数据库获取跨域
function xfs_allow_origin() {
    global $conn;
    global $setting;
    $xfs_allow_origin = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['info']." WHERE info='xfs_allow_origin'");
    $xfs_allow_origin_object = mysqli_fetch_object($xfs_allow_origin);
    return $xfs_allow_origin_object->text;
}

// 根据函数确认是否开启
if (xfs_allow_origin() == TRUE) {
    header('Access-Control-Allow-Origin:*');
}