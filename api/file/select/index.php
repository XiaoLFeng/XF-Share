<?PHP 
/*
 * XF-Share API 项目
 * 作者：筱锋xiao_lfeng
 * 文件查询
 */

// 获取组件
include($_SERVER['DOCUMENT_ROOT'].'/api/head-check.php');
include($_SERVER['DOCUMENT_ROOT'].'/plugins/sql_conn.php');
// 获取参数
$ssid = htmlspecialchars($_GET['ssid']);
$id = htmlspecialchars($_GET['id']);
// 构建函数
if (!empty($ssid)) {
    if ($ssid == xfs_ssid()) {
        if (!empty($id)) {
            // 获取文件信息
            $result_fileget = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['file']." WHERE article_id='".$id."'");
            $result_filegets = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['file']." WHERE article_id='".$id."' ORDER BY time DESC");
            // 判断信息有无
            if ($result_fileget_object = mysqli_fetch_object($result_fileget)) {
                // 存在则循环
                $num = 1;
                $arr = array();
                while ($result_filegets_object = mysqli_fetch_object($result_filegets)) {
                    // 获取 link 列表并编译（拆解）
                    $link_array = explode(',',$result_filegets_object->link);
                    // 整理 link 数据
                    $a = 1;
                    do {
                        preg_match("/(?<=[(])(.*)(?=[)])/",$link_array[$a-1],$name);
                        preg_match("/[a-zA-z]+:\/\/[^\s]*/",$link_array[$a-1],$url);
                        // 编译数据
                        $urllist[$a] = array(
                            'name'=>$name[0],
                            'url'=>$url[0],
                        );
                        $a++;
                    } while (!$link_array[$a-1] == NULL);
                    // 编译数据
                    $arr[$num] = array(
                        'id'=>$result_filegets_object->id,
                        'article_id'=>$result_filegets_object->article_id,
                        'link'=>$urllist,
                        'version'=>$result_filegets_object->version,
                        'title'=>$result_filegets_object->title,
                        'text'=>$result_filegets_object->text,
                        'type'=>$result_filegets_object->type,
                        'time'=>$result_filegets_object->time,
                        'username_id'=>$result_filegets_object->username_id
                    );
                    $num++;
                }
                // 构建json
                $data = array(
                    'output'=>'SUCCESS',
                    'code'=>200,
                    'info'=>'输出成功',
                    'data'=>$arr
                );
                // 输出数据
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            } else {
                // 构建json
                $data = array(
                    'output'=>'ID_SEARCH_NONE',
                    'code'=>403,
                    'info'=>'不存在ID为 Query[id] 文章的文件',
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