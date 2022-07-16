<?PHP 
/*
 * 筱锋xiao_lfeng 分享系统（插件）
 * 登录组件
 */

// 开启SESSION
session_start();
// 定义请求头
header("Content-type:text/html;charset=utf-8");
// 获取组件
include($_SERVER['DOCUMENT_ROOT'].'/setting.inc.php');
include($_SERVER['DOCUMENT_ROOT'].'/plugins/sql_conn.php');
// 获取参数
$type = htmlspecialchars($_GET['type']);
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
if ($type == 'email') {
    // 导入form参数
    $email = $_POST['email'];
    $password = $_POST['password'];
    // 检查数据是否合法
    if (preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$email) and preg_match("/[^~;)(]+/",$password)) {
        // 发送用户信息
        $url = $_SERVER['DOCUMENT_ROOT']."/api/auth/login.php"; //请求地址
        $arr = array(
            'ssid'=>xfs_ssid(),
            'email'=>$email,
            'username'=>null,
            'password'=>$password,
            'stay_login'=>$stay_login
        ); //请求参数(数组)
        $jsonStr = json_encode($arr); //转换为json格式
        $result = http_post_json($url, $jsonStr);
        $result = json_decode($result,true);

    // 正则表达式审核不通过情况下处理
    } else {
        if (preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$email) and !preg_match("/[^~;)(]+/",$password)) {
            echo <<<EOF
            <script language="javascript">
                alert( "密码不能包含【;】【(】【)】【~】" )
                window.history.go(-1);
            </script>
            EOF;
        } elseif (!preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$email) and preg_match("/[^~;)(]+/",$password)) {
            echo <<<EOF
            <script language="javascript">
                alert( "邮箱格式错误" )
                window.history.go(-1);
            </script>
            EOF;
        } elseif (!preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$email) and !preg_match("/[^~;)(]+/",$password)) {
            echo <<<EOF
            <script language="javascript">
                alert( "邮箱和密码格式均有误！" )
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
    }
} elseif ($type == 'username') {
    # code...
} else {
    echo <<<EOF
        <script language="javascript">
            alert( "类型错误，您未在指定地方提交！" )
            window.history.go(-1);
        </script>
        EOF;
}