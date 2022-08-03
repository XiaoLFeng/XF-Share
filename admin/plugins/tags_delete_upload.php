<?PHP 
/*
 * 筱锋xiao_lfeng 分享系统（插件）
 * 修改文章组件（管理）
 */

// 定义请求头
header("Content-type:text/html;charset=utf-8");
// 获取组件
include($_SERVER['DOCUMENT_ROOT'].'/setting.inc.php');
include($_SERVER['DOCUMENT_ROOT'].'/plugins/sql_conn.php');
// 获取参数
$tags_id = htmlspecialchars($_GET['tags_id']);
// 注册函数
    // 从数据库获取密钥
    function xfs_ssid() {
        global $conn;
        global $setting;
        $xfs_ssid = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['info']." WHERE info='xfs_ssid'");
        $xfs_ssid_object = mysqli_fetch_object($xfs_ssid);
        return $xfs_ssid_object->text;
    }

// 编译函数
if (!empty($_COOKIE['user'])/*检查COOKIE*/) {
    // 删除数据
    $delete_url = $_SERVER['HTTP_HOST'].'/api/article/delete/tags.php?ssid='.xfs_ssid().'&tags='.$tags_id;    
    $delete_ch = curl_init($delete_url);
    curl_setopt($delete_ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
    curl_setopt($delete_ch, CURLOPT_RETURNTRANSFER, true);
    $delete = curl_exec($delete_ch);
    $delete = json_decode($delete,true);
    // 返回参数
    if ($delete['output'] == 'SUCCESS') {
        echo <<<EOF
                <script language="javascript">
                    alert( "已删除！" )
                    window.location.href = "../tags.php"
                </script>
                EOF;
    } elseif ($delete['output'] == 'ID_TAGS_ERROR') {
        echo <<<EOF
            <script language="javascript">
                alert( "删除失败，数据库删除错误！" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($delete['output'] == 'TAGS_ARTICLE_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "参数 Query[id] 错误，没有该标签" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($delete['output'] == 'TAGS_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "没有tags参数" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($delete['output'] == 'SSID_ERROR') {
        echo <<<EOF
            <script language="javascript">
                alert( "参数 Query[ssid] 密钥错误" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($delete['output'] == 'SSID_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "参数 Query[ssid] 缺失" )
                window.history.go(-1);
            </script>
            EOF;
    }
} else {
    echo <<<EOF
        <script language="javascript">
            alert( "您未登录哦！" )
            window.history.go(-1);
        </script>
        EOF;
}