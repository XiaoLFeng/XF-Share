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
    if (!empty($json_info['data']['username']) and !empty($json_info['data']['title']) and !empty($json_info['data']['type']) and !empty($json_info['data']['text']) and !empty($json_info['data']['date']) and !empty($json_info['data']['hide'])) {
        // 检查是否隐藏是否符合布尔值
        if (!$json_info['data']['hide'] == TRUE and !$json_info['data']['hide'] == FALSE) {
            // 构建json
            $data = array(
                'output'=>'HIDE_BOOLEAN_ERROR',
                'code'=>403,
                'info'=>'参数 JSON[hide] 不符合布尔值参数',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } else {
            // 转义数据
            $data_username = $json_info['data']['username'];
            $data_title = $json_info['data']['title'];
            $data_type = $json_info['data']['type'];
            $data_text = $json_info['data']['text'];
            $data_date = $json_info['data']['date'];
            $data_hide = $json_info['data']['hide'];
            // 载入数据库
            if (mysqli_query($conn,"INSERT INTO ".$setting['SQL_DATA']['article']." (username,title,type,text,date,see,hide) VALUES ('$data_username','$data_title','$data_type','$data_text','$data_date','0','$data_hide')")) {
                // 构建json
                $data = array(
                    'output'=>'SUCCESS',
                    'code'=>200,
                    'info'=>'文章生成完毕!',
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
        }
    } else {
        if (empty($json_info['data']['username'])) {                       // 用户名缺失
            // 构建json
            $data = array(
                'output'=>'USERNAME_NONE',
                'code'=>403,
                'info'=>'参数 JSON[username] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['title'])) {                     // 标题缺失
            // 构建json
            $data = array(
                'output'=>'TITLE_NONE',
                'code'=>403,
                'info'=>'参数 JSON[title] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['type'])) {                       // 类型缺失
            // 构建json
            $data = array(
                'output'=>'TYPE_NONE',
                'code'=>403,
                'info'=>'参数 JSON[type] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['text'])) {                         // 内容缺失
            // 构建json
            $data = array(
                'output'=>'TEXT_NONE',
                'code'=>403,
                'info'=>'参数 JSON[text] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['date'])) {                       // 日期缺失
            // 构建json
            $data = array(
                'output'=>'DATE_NONE',
                'code'=>403,
                'info'=>'参数 JSON[date] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['hide'])) {                          // 是否隐藏缺失
            // 构建json
            $data = array(
                'output'=>'HIDE_NONE',
                'code'=>403,
                'info'=>'参数 JSON[hide] 缺失',
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