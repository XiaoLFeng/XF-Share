<?PHP 
/*
 * XF-Share API 项目
 * 作者：筱锋xiao_lfeng
 * 文章修改
 */

// 获取组件
include($_SERVER['DOCUMENT_ROOT'].'/api/head-check.php');
// 获取参数
$post = file_get_contents('php://input');
$json_info = json_decode($post,true);
// 构建函数
if ($json_info['ssid'] == xfs_ssid()) {
    // 检查内容是否缺失
    if (!empty($json_info['data']['tags_id'])
        and !empty($json_info['data']['tags_name'])
        and !empty($json_info['data']['tags_lore'])) {
        // 更新数据库
        if (mysqli_query($conn,"UPDATE ".$setting['SQL_DATA']['tags']." SET name='".$json_info['data']['tags_name']."', lore='".$json_info['data']['tags_lore']."' WHERE tags='".$json_info['data']['tags_id']."'")) {
            // 构建json
            $data = array(
                'output'=>'SUCCESS',
                'code'=>200,
                'info'=>'标签修改成功',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        } else {
            // 构建json
            $data = array(
                'output'=>'UPDATE_ERRROR',
                'code'=>403,
                'info'=>'更新错误，数据库出错',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        }
    } else {
        if (empty($json_info['data']['tags_id'])) {                       // 标签ID缺失
            // 构建json
            $data = array(
                'output'=>'ID_NONE',
                'code'=>403,
                'info'=>'参数 JSON[tags_id] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['tags_name'])) {                     // 标签名字缺失
            // 构建json
            $data = array(
                'output'=>'NAME_NONE',
                'code'=>403,
                'info'=>'参数 JSON[tags_name] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['tags_lore'])) {                     // 标签描述缺失
            // 构建json
            $data = array(
                'output'=>'LORE_NONE',
                'code'=>403,
                'info'=>'参数 JSON[tags_lore] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } else {
            // 构建json
            $data = array(
                'output'=>'NONE',
                'code'=>403,
                'info'=>'未知 JSON[] 参数缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        }
    }
} else {
    // 构建json
    $data = array(
        'output'=>'SSID_NONE',
        'code'=>403,
        'info'=>'不存在 GET 口，请使用 POST 接口，参数 JSON[ssid] 缺失或错误',
    );
    // 输出数据
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    header("HTTP/1.1 403 Forbidden");
}