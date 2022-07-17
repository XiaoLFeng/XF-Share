<?PHP 
/*
 * XF-Share API 项目
 * 作者：筱锋xiao_lfeng
 * 删除文章
 */

// 获取组件
include($_SERVER['DOCUMENT_ROOT'].'/api/head-check.php');
// 获取参数
$ssid = htmlspecialchars($_GET['ssid']);
$id = htmlspecialchars($_GET['id']);
// 构建函数
if (!empty($ssid)) {
    if ($ssid == xfs_ssid()) {
        if (!empty($id)) {
            // 从数据库获取数据
            $result_article = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['article']." WHERE id='$id'");
            $result_article_object = mysqli_fetch_object($result_article);
            if (!$result_article_object->id == NULL) {
                // 删除数据
                if (mysqli_query($conn,"DELETE FROM ".$setting['SQL_DATA']['article']." WHERE id='$id'")) {
                    // 构建json
                    $data = array(
                        'output'=>'SUCCESS',
                        'code'=>200,
                        'info'=>'删除成功',
                    );
                    // 输出数据
                    echo json_encode($data,JSON_UNESCAPED_UNICODE);
                } else {
                    // 构建json
                    $data = array(
                        'output'=>'ID_ARTICLE_NONE',
                        'code'=>403,
                        'info'=>'删除失败，数据库删除错误！',
                    );
                    // 输出数据
                    echo json_encode($data,JSON_UNESCAPED_UNICODE);
                    header("HTTP/1.1 403 Forbidden");
                }
            } else {
                // 构建json
                $data = array(
                    'output'=>'ID_ARTICLE_NONE',
                    'code'=>403,
                    'info'=>'参数 Query[id] 错误，没有该文章',
                );
                // 输出数据
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                header("HTTP/1.1 403 Forbidden");
            }
        } else {
            // 构建json
            $data = array(
                'output'=>'ID_NONE',
                'code'=>403,
                'info'=>'参数 Query[id] 缺失',
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
            'info'=>'参数 Query[ssid] 密钥错误',
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
        'info'=>'参数 Query[ssid] 缺失',
    );
    // 输出数据
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    header("HTTP/1.1 403 Forbidden");
}