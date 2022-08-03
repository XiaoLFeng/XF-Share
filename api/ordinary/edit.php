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
    // 检查内容是否缺失
    if (!empty($json_info['data']['xfs_title'])
        && !empty($json_info['data']['xfs_subtitle'])
        && !empty($json_info['data']['xfs_icon'])
        && !empty($json_info['data']['xfs_keywords'])
        && !empty($json_info['data']['xfs_allow_origin'])) {
        // 检查跨域要求是否符合布尔值
        if (!$json_info['data']['xfs_allow_origin'] == 'false' || !$json_info['data']['xfs_allow_origin'] == 'true') {
            // 构建json
            $data = array(
                'output'=>'ALLOW_ORIGIN_ERROR',
                'code'=>403,
                'info'=>'参数 JSON[xfs_allow_origin] 不符合布尔值',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } else {
            // 更新数据库信息
                // 构建函数
                function upload($ssid_info) {
                    global $conn,$setting,$json_info;
                    mysqli_query($conn,"UPDATE ".$setting['SQL_DATA']['info']." SET text='".$json_info['data']['xfs_title']."' WHERE info='xfs_title'");
                    mysqli_query($conn,"UPDATE ".$setting['SQL_DATA']['info']." SET text='".$json_info['data']['xfs_subtitle']."' WHERE info='xfs_subtitle'");
                    mysqli_query($conn,"UPDATE ".$setting['SQL_DATA']['info']." SET text='".$json_info['data']['xfs_icon']."' WHERE info='xfs_icon'");
                    mysqli_query($conn,"UPDATE ".$setting['SQL_DATA']['info']." SET text='".$json_info['data']['xfs_keywords']."' WHERE info='xfs_keywords'");
                    mysqli_query($conn,"UPDATE ".$setting['SQL_DATA']['info']." SET text='".$json_info['data']['xfs_allow_origin']."' WHERE info='xfs_allow_origin'");
                    if ($ssid_info == TRUE) {
                        mysqli_query($conn,"UPDATE ".$setting['SQL_DATA']['info']." SET text='".$json_info['data']['xfs_ssid']."' WHERE info='xfs_ssid'");
                    }
                }
            // 输出信息
            if (empty($json_info['data']['xfs_ssid'])) {
                upload(FALSE);
                // 构建json
                $data = array(
                    'output'=>'SUCCESS',
                    'code'=>200,
                    'info'=>'修改成功',
                );
                // 输出数据
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            } else {
                upload(TRUE);
                // 构建json
                $data = array(
                    'output'=>'SUCCESS',
                    'code'=>200,
                    'info'=>'修改成功',
                );
                // 输出数据
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            }
        }
    } else {
        if (empty($json_info['data']['xfs_title'])) {                      // 缺少 xfs_title
            // 构建json
            $data = array(
                'output'=>'TITLE_NONE',
                'code'=>403,
                'info'=>'参数 JSON[xfs_title] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['xfs_subtitle'])) {               // 缺少 subtitle
            // 构建json
            $data = array(
                'output'=>'SUBTITLE_NONE',
                'code'=>403,
                'info'=>'参数 JSON[xfs_subtitle] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['xfs_icon'])) {               // 缺少 icon
            // 构建json
            $data = array(
                'output'=>'ICON_NONE',
                'code'=>403,
                'info'=>'参数 JSON[xfs_icon] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['xfs_keywords'])) {                //缺少 keywords
            // 构建json
            $data = array(
                'output'=>'KEYWORDS_NONE',
                'code'=>403,
                'info'=>'参数 JSON[xfs_keywords] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['xfs_allow_origin'])) {               // 缺少 allow_origin(跨域)
            // 构建json
            $data = array(
                'output'=>'ALLOW_ORIGIN_NONE',
                'code'=>403,
                'info'=>'参数 JSON[xfs_allow_origin] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } else {                                                                // 未知错误
            // 构建json
            $data = array(
                'output'=>'NONE',
                'code'=>403,
                'info'=>'参数 JSON[] 缺失，未知错误',
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

mysqli_close($conn);