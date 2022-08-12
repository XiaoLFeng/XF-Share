<?PHP 
/*
 * 筱锋xiao_lfeng 分享系统（插件）
 * 修改文章组件（管理）
 */

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

// 获取参数
$file_id = htmlspecialchars($_GET['file_id']);

// 编译函数
if (!empty($_COOKIE['user'])/*检查COOKIE*/) {
    // 默认不检查数据
    // 发送用户信息
    $url = $_SERVER['HTTP_HOST']."/api/file/edit/"; //请求地址
    // 文件检查
    if (!empty($_POST['file_title'])) {
        // 文件整理
        $file_num = 1;
        while (!$_POST['upload_file_U_'.$file_num] == NULL) {
            $files[$file_num] = '('.$_POST['upload_file_U_'.$file_num].')'.$_POST['upload_file_D_'.$file_num];
            $file_num ++;
        };
        $file_nums = 1;
        while (!$_POST['edit_file_U_'.$file_nums] == NULL) {
            $edit_file[$file_nums] = '('.$_POST['edit_file_U_'.$file_nums].')'.$_POST['edit_file_D_'.$file_nums];
            $file_nums ++;
        };
        if (empty($files['1'])) {
            $file_list_edit = implode(",",$edit_file);
            $load_file = $file_list_edit;
        } elseif (empty($edit_file['1'])) {
            $file_list = implode(",",$files);
            $load_file = $file_list;
        } else {
            $file_list = implode(",",$files);
            $file_list_edit = implode(",",$edit_file);
            $load_file = $file_list_edit.','.$file_list;
        }
        // 判断文件是否有问题
        if (empty($_POST['file_text'])) {
            echo <<<EOF
                    <script language="javascript">
                        alert( "文件介绍不能为空！" )
                        window.history.go(-1);
                    </script>
                    EOF;
        } elseif (empty($file_list) && empty($file_list_edit)) {
            echo <<<EOF
                    <script language="javascript">
                        alert( "文件至少上传一个！" )
                        window.history.go(-1);
                    </script>
                    EOF;
        } elseif (empty($_POST['file_version'])) {
            echo <<<EOF
                    <script language="javascript">
                        alert( "请填写版本号" )
                        window.history.go(-1);
                    </script>
                    EOF;
        }
    }
    $arr = array(
        'output'=>'SUCCESS',
        'code'=>200,
        'info'=>'上传完毕',
        'ssid'=>xfs_ssid(),
        'data'=>array(
            'user'=>array(
                'user'=>$_COOKIE['user'],
            ),
            'files'=>array(
                'file_id'=>$file_id,
                'file_title'=>addslashes($_POST['file_title']),
                'file_type'=>addslashes($_POST['file_type']),
                'file_text'=>addslashes($_POST['file_text']),
                'file_other'=>$load_file,
                'file_version'=>addslashes($_POST['file_version']),
            )
        )
    ); //请求参数(数组)
    $jsonStr = json_encode($arr,JSON_UNESCAPED_UNICODE); //转换为json格式
    $result = http_post_json($url, $jsonStr);
    $result = json_decode($result,true);

    // 返回参数
    if ($result['output'] == 'SUCCESS') {
        echo <<<EOF
                <script language="javascript">
                    alert( "完成！" )
                    window.location.href = "../article.php"
                </script>
                EOF;
    } elseif ($result['output'] == 'FILE_UPLOAD_FAIL') {
        echo <<<EOF
            <script language="javascript">
                alert( "文件上传失败" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'FILE_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "参数 JSON[file] 缺失" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'USERNAME_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "您登陆了吗？" )
                window.history.go(-1);
            </script>
            EOF;
    } elseif ($result['output'] == 'FILE_OTHER_NONE') {
        echo <<<EOF
            <script language="javascript">
                alert( "文件缺失" )
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