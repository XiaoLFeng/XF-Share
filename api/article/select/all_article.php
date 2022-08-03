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
$page = htmlspecialchars($_GET['page']);
$array = htmlspecialchars($_GET['array']);
// 函数编译
    // 编译是否倒叙
    function arrays() {
        global $array;
        if ($array == 1) {
            return 'DESC';
        } else {
            return '';
        }
    }
    // 编译页码
    function page() {
        global $page;
        $page_q = ($page-1)*20;
        $page_h = $page*20;
        $pages = $page_q.','.$page_h;
        return $pages;
    }
// 构建函数
if (!empty($ssid)) {
    if ($ssid == xfs_ssid()) {
        if (!empty($array)) {
            // 从数据库获取数据
            $result_article = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['article']." ORDER BY id ".arrays()." limit ".page());
            // 编译数据
            $arr_num = 1;
            $datas = array();
            while ($result_article_object = mysqli_fetch_object($result_article)) {
                $datas[$arr_num] = array(
                    'id'=>stripslashes($result_article_object->id),
                    'username'=>stripslashes($result_article_object->username),
                    'title'=>stripslashes($result_article_object->title),
                    'type'=>stripslashes($result_article_object->type),
                    'date'=>stripslashes($result_article_object->date),
                    'update_date'=>stripslashes($result_article_object->update_date),
                    'see'=>stripslashes($result_article_object->see),
                    'hide'=>stripslashes($result_article_object->hide),
                    'icon_url'=>stripslashes($result_article_object->icon_url)
                );
                $arr_num ++;
            }
            // 构建json
            $data = array(
                'output'=>'SUCCESS',
                'code'=>200,
                'info'=>'查询成功',
                'data'=>$datas,
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        } else {
            // 构建json
            $data = array(
                'output'=>'ARRAY_NONE',
                'code'=>403,
                'info'=>'参数 Query[array] 缺失',
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