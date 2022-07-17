<?PHP 
/*
 * XF-Share API 项目
 * 作者：筱锋xiao_lfeng
 * 文章查询
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
                // 构建json
                $data = array(
                    'output'=>'SUCCESS',
                    'code'=>403,
                    'info'=>'查询成功',
                    'data'=>array(
                        'id'=>$result_article_object->id,
                        'username'=>$result_article_object->username,
                        'title'=>$result_article_object->title,
                        'type'=>$result_article_object->type,
                        'text'=>$result_article_object->text,
                        'date'=>$result_article_object->date,
                        'update_date'=>$result_article_object->update_date,
                        'see'=>$result_article_object->see,
                        'hide'=>$result_article_object->hide
                    )
                );
                // 输出数据
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
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