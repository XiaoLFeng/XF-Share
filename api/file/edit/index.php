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
    if (!empty($json_info['data']['user']['user'])
    and !empty($json_info['data']['files']['file_id'])
    and !empty($json_info['data']['files']['file_other']) ) {
        // 转义数据
        $data_date = date("Y-m-d H:i:s");
        $data_username_id = $json_info['data']['user']['user'];
        $file_id = $json_info['data']['files']['file_id'];
        $data_files_type = $json_info['data']['files']['file_type'];
        $data_files_title = $json_info['data']['files']['file_title'];
        $data_files_text = $json_info['data']['files']['file_text'];
        $data_files_other = $json_info['data']['files']['file_other'];
        $data_files_version = $json_info['data']['files']['file_version'];
        // 检查数据
        if (!empty($data_files_other)) {
            // 输入文件进入数据库
            if (mysqli_query($conn,"UPDATE ".$setting['SQL_DATA']['file']." SET link='$data_files_other', version='$data_files_version', text='$data_files_text', title='$data_files_title', type='$data_files_type', time='$data_date'  WHERE id='$file_id'")) {
                // 构建json
                $data = array(
                    'output'=>'SUCCESS',
                    'code'=>200,
                    'info'=>'文件修改完毕',
                );
                // 输出数据
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            } else {
                // 构建json
                $data = array(
                    'output'=>'FILE_UPLOAD_FAIL',
                    'code'=>200,
                    'info'=>'文件上传失败',
                );
                // 输出数据
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            }
        } else {
            // 构建json
            $data = array(
                'output'=>'FILE_NONE',
                'code'=>200,
                'info'=>'文件 Json[file] 为空',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    } else {
        if (empty($json_info['data']['user']['user'])) {                       // 用户名缺失
            // 构建json
            $data = array(
                'output'=>'USERNAME_NONE',
                'code'=>403,
                'info'=>'参数 JSON[username] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['files']['file_id'])) {
            // 构建json
            $data = array(
                'output'=>'FILE_ID_NONE',
                'code'=>403,
                'info'=>'参数 JSON[file_id] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['files']['file_other'])) {
            // 构建json
            $data = array(
                'output'=>'FILE_OTHER_NONE',
                'code'=>403,
                'info'=>'参数 JSON[file_other] 缺失',
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