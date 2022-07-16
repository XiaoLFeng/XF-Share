<?PHP 
/*
 * XF-Share API 项目
 * 作者：筱锋xiao_lfeng
 * 该内容为隐私重要内容，请勿随意修改
 */

// 开启session
session_start();
// 设置请求头
header('Content-Type: application/json;charset=utf-8');
header('Access-Control-Allow-Origin:*');
// 获取组件
include($_SERVER['DOCUMENT_ROOT'].'/setting.inc.php');
include($_SERVER['DOCUMENT_ROOT'].'/plugins/sql_conn.php');
// 获取参数
$post = file_get_contents('php://input');
$json_info = json_decode($post,true);
// 构建函数
if (!empty($json_info['ssid'])) {
    if (empty($json_info['username']) and empty($json_info['mail'])) {
        // 构建json
        $data = array(
            'output'=>'USER_INFO_NONE',
            'code'=>403,
            'info'=>'缺少 JSON[username] or [mail] 参数'
        );
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        header("HTTP/1.1 403 Forbidden");
    } else {
        if (!empty($json_info['password'])) {
            // 查找数据
            $xfs_person = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['person']." WHERE username='".$json_info['username']."'");
            $xfs_person_object = mysqli_fetch_object($xfs_person);
            // 获取密码
            $sql_password = $xfs_person_object->password;
            // 验证密码
            if (password_verify($json_info['password'], $sql_password)) {
                // 赋予COOKIE
                if ($json_info['stay_login']) {
                    setcookie(session_name(),session_id(),time()+2592000);
                    $_SESSION['user'] = $xfs_person_object->id;
                } else {
                    setcookie(session_name(),session_id(),time()+86400);
                    $_SESSION['user'] = $xfs_person_object->id;
                }
                // 构建json
                $data = array(
                    'output'=>'SUCCESS',
                    'code'=>200,
                    'info'=>'密码验证通过'
                );
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            } else {
                // 构建json
                $data = array(
                    'output'=>'PASSWORD_DENY',
                    'code'=>403,
                    'info'=>'密码 json[password] 错误！'
                );
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                header("HTTP/1.1 403 Forbidden");
            }

            // 释放数据库
            mysqli_free_result($xfs_person);
            // 关闭数据库
            mysqli_close($conn);
        } else {
            // 构建json
            $data = array(
                'output'=>'PASSWORD_NONE',
                'code'=>403,
                'info'=>'缺少 JSON[password] 参数'
            );
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        }
    }
} else {
    // 构建json
    $data = array(
        'output'=>'SSID_NONE',
        'code'=>403,
        'info'=>'不存在 GET 口，请使用 POST 接口',
        'demo'=>$json_info['ssid']
    );
    // 输出数据
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    header("HTTP/1.1 403 Forbidden");
}