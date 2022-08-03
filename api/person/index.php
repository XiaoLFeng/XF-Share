<?PHP 
/*
 * XF-Share API 项目
 * 作者：筱锋xiao_lfeng
 * 该内容为隐私重要内容，请勿随意修改
 */

// 获取组件
include($_SERVER['DOCUMENT_ROOT'].'/api/head-check.php');
// 获取参数
$ssid = htmlspecialchars($_GET['ssid']);
$username = htmlspecialchars($_GET['username']);
$type = htmlspecialchars($_GET['type']);
// 获取数据库
// 编译数据
$xfs_info = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['info']." WHERE info='xfs_ssid'");
$xfs_info_object = mysqli_fetch_object($xfs_info);
// 构建函数
if ($ssid == xfs_ssid()) {
    if ($ssid == $xfs_info_object->text) {
        if (!empty($username)) {
            if (!empty($type)) {
                if ($type == 'id') {
                    // 获取数据库中用户信息
                    $xfs_person = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['person']." WHERE id='$username'");
                    $xfs_person_object = mysqli_fetch_object($xfs_person);
                    if (!empty($xfs_person_object->username)) {
                        // 构建json
                        $data = array(
                            'output'=>'SUCCESS',
                            'code'=>200,
                            'info'=>array(
                                'id'=>$xfs_person_object->id,
                                'username'=>$xfs_person_object->username,
                                'displayname'=>$xfs_person_object->displayname,
                                'type'=>$xfs_person_object->type,
                                'mail'=>$xfs_person_object->mail,
                                'qq'=>$xfs_person_object->qq,
                                'description'=>$xfs_person_object->description,
                                'icon_url'=>$xfs_person_object->icon_url
                            )
                        );
                        // 输出数据
                        echo json_encode($data,JSON_UNESCAPED_UNICODE);
                    } else {
                        // 构建json
                        $data = array(
                            'output'=>'USERNAME_DENY',
                            'code'=>403,
                            'info'=>'用户 ['.$username.'] 不存在'
                        );
                        // 输出数据
                        echo json_encode($data,JSON_UNESCAPED_UNICODE);
                        header("HTTP/1.1 403 Forbidden");
                    }
                } elseif ($type == 'username') {
                    // 获取数据库中用户信息
                    $xfs_person = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['person']." WHERE username='$username'");
                    $xfs_person_object = mysqli_fetch_object($xfs_person);
                    if (!empty($xfs_person_object->username)) {
                        // 构建json
                        $data = array(
                            'output'=>'SUCCESS',
                            'code'=>200,
                            'info'=>array(
                                'id'=>$xfs_person_object->id,
                                'username'=>$xfs_person_object->username,
                                'displayname'=>$xfs_person_object->displayname,
                                'type'=>$xfs_person_object->type,
                                'mail'=>$xfs_person_object->mail,
                                'qq'=>$xfs_person_object->qq,
                                'description'=>$xfs_person_object->description,
                                'icon_url'=>$xfs_person_object->icon_url
                            )
                        );
                        // 输出数据
                        echo json_encode($data,JSON_UNESCAPED_UNICODE);
                    } else {
                        // 构建json
                        $data = array(
                            'output'=>'USERNAME_DENY',
                            'code'=>403,
                            'info'=>'用户 ['.$username.'] 不存在'
                        );
                        // 输出数据
                        echo json_encode($data,JSON_UNESCAPED_UNICODE);
                        header("HTTP/1.1 403 Forbidden");
                    }
                } else {
                    // 构建json
                    $data = array(
                        'output'=>'TYPE_ERROR',
                        'code'=>403,
                        'info'=>'缺少 Query[type] 错误'
                    );
                    // 输出数据
                    echo json_encode($data,JSON_UNESCAPED_UNICODE);
                    header("HTTP/1.1 403 Forbidden");
                }
            } else {
                // 构建json
                $data = array(
                    'output'=>'TYPE_ERROR',
                    'code'=>403,
                    'info'=>'缺少 Query[type] 缺失'
                );
                // 输出数据
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                header("HTTP/1.1 403 Forbidden");
            }
        } else {
            // 构建json
            $data = array(
                'output'=>'USERNAME_NONE',
                'code'=>403,
                'info'=>'缺少 Query[username] 参数'
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        }
    } else {
        // 构建json
        $data = array(
            'output'=>'SSID_ERROR',
            'code'=>403,
            'info'=>'密钥错误'
        );
        // 输出数据
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        header("HTTP/1.1 403 Forbidden");
    }
} else {
    // 构建json
    $data = array(
        'output'=>'SSID_NONE',
        'code'=>403,
        'info'=>'缺少 Query[ssid] 参数'
    );
    // 输出数据
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    header("HTTP/1.1 403 Forbidden");
}
// 释放数据库
mysqli_free_result($xfs_info);
// 关闭数据库
mysqli_close($conn);