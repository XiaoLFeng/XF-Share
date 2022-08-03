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
    $url = $_SERVER['HTTP_HOST']."/api/ordinary/edit.php"; //请求地址
    $arr = array(
        'output'=>'SUCCESS',
        'code'=>200,
        'info'=>'上传完毕',
        'ssid'=>xfs_ssid(),
        'data'=>array(
            'xfs_title'=>$_POST['xfs_title'],
            'xfs_subtitle'=>$_POST['xfs_subtitle'],
            'xfs_icon'=>$_POST['xfs_icon'],
            'xfs_keywords'=>$_POST['xfs_keywords'],
            'xfs_ssid'=>$_POST['xfs_ssid'],
            'xfs_allow_origin'=>$_POST['xfs_allow_origin'],
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
                    window.location.href = "../setting.php"
                </script>
                EOF;
    } elseif ($result['output'] == 'TITLE_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "缺少网站标题" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'SUBTITLE_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "缺少网站副标题" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'ICON_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "缺少网站图标" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'KEYWORDS_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "缺少网站关键词" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'ALLOW_ORIGIN_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "缺少允许跨域" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'ALLOW_ORIGIN_ERROR') {
        echo <<<EOF
            <script language="javascript">
                alert( "跨域内容错误（不符合布尔值）" )
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