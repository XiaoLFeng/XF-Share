<?PHP 
/*
 * 筱锋xiao_lfeng 分享系统（插件）
 * 修改文章组件（管理）
 */

// 获取组件
include($_SERVER['DOCUMENT_ROOT'].'/setting.inc.php');
include($_SERVER['DOCUMENT_ROOT'].'/plugins/sql_conn.php');
// 获取参数
$tags_id = htmlspecialchars($_GET['tags_id']);
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
    // 默认不检查数据
    // 发送用户信息
    $url = $_SERVER['HTTP_HOST']."/api/article/edit/tags.php"; //请求地址
    $arr = array(
        'output'=>'SUCCESS',
        'code'=>200,
        'info'=>'上传完毕',
        'ssid'=>xfs_ssid(),
        'data'=>array(
            'tags_id'=>addslashes($tags_id),
            'tags_name'=>addslashes($_POST['tags_name']),
            'tags_lore'=>addslashes($_POST['tags_lore']),
        )
    ); //请求参数(数组)
    $jsonStr = json_encode($arr); //转换为json格式
    $result = http_post_json($url, $jsonStr);
    $result = json_decode($result,true);

    // 返回参数
    if ($result['output'] == 'SUCCESS') {
        echo <<<EOF
                <script language="javascript">
                    alert( "完成！" )
                    window.location.href = "../tags.php"
                </script>
                EOF;
    } elseif ($result['output'] == 'UPDATE_ERRROR') {
        echo <<<EOF
            <script language="javascript">
                alert( "数据库修改失败" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == '') {
        echo <<<EOF
            <script language="javascript">
                alert( "" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'ID_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "标签ID缺失" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'NAME_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "标签名字缺失" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'LORE_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "标签描述缺失" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'SSID_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "缺少通信密钥" )
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