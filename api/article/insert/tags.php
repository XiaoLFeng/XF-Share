<?PHP 
/*
 * XF-Share API 项目
 * 作者：筱锋xiao_lfeng
 * 文章添加
 */

// 获取组件
include($_SERVER['DOCUMENT_ROOT'].'/api/head-check.php');
// 获取参数
$post = file_get_contents('php://input');
$json_info = json_decode($post,true);
// 构建函数
if ($json_info['ssid'] == xfs_ssid()) {
    // 检查数据
    if (!empty($json_info['data']['tags_name']) and !empty($json_info['data']['tags_lore'])) {
        // 转义数据
        $name = $json_info['data']['tags_name'];
        $lore = $json_info['data']['tags_lore'];
        // 写入数据
        if (mysqli_query($conn,"INSERT INTO ".$setting['SQL_DATA']['tags']." (name,lore) VALUES ('$name','$lore')")) {
            // 构建json
            $data = array(
                'output'=>'SUCCESS',
                'code'=>200,
                'info'=>'标签生成完毕!',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        } else {
            // 构建json
            $data = array(
                'output'=>'INSERT_ERROR',
                'code'=>403,
                'info'=>'数据库写入失败',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        }
    } else {
        if (empty($json_info['data']['tags_name'])) {
            // 构建json
            $data = array(
                'output'=>'NAME_NONE',
                'code'=>403,
                'info'=>'参数 JSON[tags_name] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['tags_lore'])) {
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
                'output'=>'JSON_NONE',
                'code'=>403,
                'info'=>'参数 JSON[] 缺失（未知错误）',
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