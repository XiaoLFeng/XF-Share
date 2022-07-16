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
include('./setting.inc.php');
// 链接数据库
include('./plugins/sql_conn.php');
// 构建函数信息（设置需要什么获取什么）
function info($info) {
    global $conn;
    global $setting;
    $xfs_info = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['info']." WHERE info='".$info."'");
    $xfs_info_object = mysqli_fetch_object($xfs_info);
    mysqli_free_result($xfs_info);
    return $xfs_info_object->text;
}