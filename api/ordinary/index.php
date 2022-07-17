<?PHP 
/*
 * XF-Share API 项目
 * 作者：筱锋xiao_lfeng
 * 该内容为隐私重要内容，请勿随意修改
 */

// 获取组件
include($_SERVER['DOCUMENT_ROOT'].'/api/head-check.php');
// 获取参数
$type = htmlspecialchars($_GET['type']);
// 构建函数
if (!empty($type)) {
    if ($type == 'main') {
        // 编译数据
        $xfs_info = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['info']);
        // 构建
        $ordinary = array();
        while ($xfs_info_object = mysqli_fetch_object($xfs_info)) {
            if ($xfs_info_object->info == 'xfs_ssid') {
                $ordinary[$xfs_info_object->info] = array(
                    'id'=>$xfs_info_object->id,
                    'text'=>'抱歉，密钥不可查阅！',
                    'parameter'=>'抱歉，密钥不可查阅！'
                );
            } else {
                $ordinary[$xfs_info_object->info] = array(
                    'id'=>$xfs_info_object->id,
                    'text'=>$xfs_info_object->text,
                    'parameter'=>$xfs_info_object->parameter
                );
            }
        }
        // 构建json
        $data = array(
            'output'=>'SUCCESS',
            'code'=>200,
            'info'=>$ordinary,
        );
        // 输出数据
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    } else {
        // 构建json
        $data = array(
            'output'=>'TYPE_ERROR',
            'code'=>403,
            'info'=>'参数 Query['.$type.'] 不存在，可用参数为 "main"'
        );
        // 输出数据
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        header("HTTP/1.1 403 Forbidden");
    }
} else {
    // 构建json
    $data = array(
        'output'=>'TYPE_NONE',
        'code'=>403,
        'info'=>'缺少 Query[type] 参数'
    );
    // 输出数据
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    header("HTTP/1.1 403 Forbidden");
}
// 释放数据库
mysqli_free_result($xfs_info);
// 关闭数据库
mysqli_close($conn);