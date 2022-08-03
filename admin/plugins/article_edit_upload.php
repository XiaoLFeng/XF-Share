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
$article_id = htmlspecialchars($_GET['article_id']);
// 注册函数
    // 发送POST
    function http_post_json($url, $jsonStr) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($jsonStr)
            )
        );
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
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
    // 导入FORM参数
    $title = $_POST['title'];
    $icon_url = $_POST['icon_url'];
    $text = $_POST['text'];
    $tags = $_POST['tags'];
    $hide = $_POST['hide'];

    // 默认不检查数据
    // 发送用户信息
    $url = $_SERVER['HTTP_HOST']."/api/article/edit/article.php"; //请求地址
    $arr = array(
        'output'=>'SUCCESS',
        'code'=>200,
        'info'=>'上传完毕',
        'ssid'=>xfs_ssid(),
        'data'=>array(
            'article_id'=>$article_id,
            'title'=>$title,
            'icon_url'=>$icon_url,
            'text'=>$text,
            'tags'=>$tags,
            'hide'=>$hide
        )
    ); //请求参数(数组)
    $jsonStr = json_encode($arr); //转换为json格式
    $result = http_post_json($url, $jsonStr);
    $result = json_decode($result,true);
    // 返回参数
    if ($result['output'] == 'SUCCESS') {
        echo <<<EOF
                <script language="javascript">
                    alert( "修改完毕~" )
                    window.location.href = "../article.php"
                </script>
                EOF;
    } elseif ($result['output'] == 'HIDE_BOOLEAN_ERROR') {
        echo <<<EOF
            <script language="javascript">
                alert( "参数 JSON[hide] 不符合布尔值参数" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'UPDATE_ERROR') {
        echo <<<EOF
            <script language="javascript">
                alert( "数据库更新内容失败" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'TITLE_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "参数 JSON[title] 缺失" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'TEXT_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "参数 JSON[text] 缺失" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'TAGS_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "参数 JSON[tags] 缺失" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'HIDE_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "参数 JSON[hide] 缺失" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "未知 JSON[] 参数缺失" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'SSID_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "不存在 GET 口，请使用 POST 接口，参数 JSON[ssid] 缺失或错误" )
                window.history.go(-1);
            </script>
            EOF;
    } else {
        echo <<<EOF
            <script language="javascript">
                alert( "未知错误" )
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