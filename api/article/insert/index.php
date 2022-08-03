<?PHP 
/*
 * XF-Share API 项目
 * 作者：筱锋xiao_lfeng
 * 文章添加
 */

// 获取组件
include($_SERVER['DOCUMENT_ROOT'].'/api/head-check.php');
// 获取参数
$post = file_get_contents('php://input');
$json_info = json_decode($post,true);
// 构建函数
if ($json_info['ssid'] == xfs_ssid()) {
    // 检查内容是否缺失
    if (!empty($json_info['data']['user']['user'])
        and !empty($json_info['data']['article']['title'])
        and !empty($json_info['data']['article']['text']) 
        and !empty($json_info['data']['article']['tags']) 
        and !empty($json_info['data']['article']['hide'])) {
        // 检查是否隐藏是否符合布尔值
        if (!$json_info['data']['hide'] == TRUE and !$json_info['data']['hide'] == FALSE) {
            // 构建json
            $data = array(
                'output'=>'HIDE_BOOLEAN_ERROR',
                'code'=>403,
                'info'=>'参数 JSON[hide] 不符合布尔值参数',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } else {
            // 获取数据
            $result_person = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['person']." WHERE id='".$json_info['data']['user']['user']."'");
            $result_person_object = mysqli_fetch_object($result_person);
            // 转义数据
            $data_date = date("Y-m-d H:i:s");
            $data_username_id = $json_info['data']['user']['user'];
            $data_article_username = $result_person_object->username;
            $data_article_title = $json_info['data']['article']['title'];
            $data_article_type = $json_info['data']['article']['tags'];
            $data_article_text = $json_info['data']['article']['text'];
            $data_article_hide = $json_info['data']['article']['hide'];
            $data_article_icon = $json_info['data']['article']['icon_url'];
            $data_files_type = $json_info['data']['files']['file_type'];
            $data_files_title = $json_info['data']['files']['file_title'];
            $data_files_text = $json_info['data']['files']['file_text'];
            $data_files_offline_url = $json_info['data']['files']['file_offline_url'];
            $data_files_other = $json_info['data']['files']['file_other'];
            $data_files_version = $json_info['data']['files']['file_version'];
            // 载入数据库
            if (mysqli_query($conn,"INSERT INTO ".$setting['SQL_DATA']['article']." (username,title,type,text,date,see,hide,icon_url,draft) VALUES ('$data_article_username','$data_article_title','$data_article_type','$data_article_text','$data_date','0','$data_article_hide','$data_article_icon','1')")) {
                // 检查上传文件是否为空
                if (!empty($data_files_offline_url) || !empty($data_files_other)) {
                    // 查询数据库并获取最后一个
                    $result_article = mysqli_query($conn,"SELECT * FROM ".$setting['SQL_DATA']['article']." ORDER BY id DESC");
                    $result_article_object = mysqli_fetch_object($result_article);
                    // 再次整理数据
                    if (empty($data_files_offline_url)) {
                        $file_upload = $data_files_other;
                    } elseif (empty($data_files_other)) {
                        $file_upload = $data_files_offline_url;
                    } else {
                        $file_upload = $data_files_offline_url.','.$data_files_other;
                    }
                    if (mysqli_query($conn,"INSERT INTO ".$setting['SQL_DATA']['file']." (article_id,link,version,text,title,type,time,username_id) VALUES ('".$result_article_object->id."','$file_upload','$data_files_version','$data_files_text','$data_files_title','$data_files_type','$data_date','$data_username_id')")) {
                        // 构建json
                        $data = array(
                            'output'=>'SUCCESS',
                            'code'=>200,
                            'info'=>'文章生成，文件上传完毕!',
                        );
                        // 输出数据
                        echo json_encode($data,JSON_UNESCAPED_UNICODE);
                    } else {
                        // 构建json
                        $data = array(
                            'output'=>'FILE_UPLOAD_FAIL',
                            'code'=>200,
                            'info'=>'文章生成成功，文件上传失败!',
                        );
                        // 输出数据
                        echo json_encode($data,JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    // 构建json
                    $data = array(
                        'output'=>'SUCCESS',
                        'code'=>200,
                        'info'=>'文章生成完毕!',
                    );
                    // 输出数据
                    echo json_encode($data,JSON_UNESCAPED_UNICODE);
                }
            } else {
                // 构建json
                $data = array(
                    'output'=>'INSERT_ERROR',
                    'code'=>403,
                    'info'=>'数据库写入失败',
                );
                // 输出数据
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                header("HTTP/1.1 403 Forbidden");
            }
        }
    } else {
        if (empty($json_info['data']['user']['user'])) {                       // 用户名缺失
            // 构建json
            $data = array(
                'output'=>'USERNAME_NONE',
                'code'=>403,
                'info'=>'参数 JSON[username] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['article']['title'])) {                     // 标题缺失
            // 构建json
            $data = array(
                'output'=>'TITLE_NONE',
                'code'=>403,
                'info'=>'参数 JSON[title] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['article']['tags'])) {                       // 类型缺失
            // 构建json
            $data = array(
                'output'=>'TYPE_NONE',
                'code'=>403,
                'info'=>'参数 JSON[type] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['article']['text'])) {                         // 内容缺失
            // 构建json
            $data = array(
                'output'=>'TEXT_NONE',
                'code'=>403,
                'info'=>'参数 JSON[text] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } elseif (empty($json_info['data']['article']['hide'])) {                          // 是否隐藏缺失
            // 构建json
            $data = array(
                'output'=>'HIDE_NONE',
                'code'=>403,
                'info'=>'参数 JSON[hide] 缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        } else {
            // 构建json
            $data = array(
                'output'=>'NONE',
                'code'=>403,
                'info'=>'未知 JSON[] 参数缺失',
            );
            // 输出数据
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            header("HTTP/1.1 403 Forbidden");
        }
    }
} else {
    // 构建json
    $data = array(
        'output'=>'SSID_NONE',
        'code'=>403,
        'info'=>'不存在 GET 口，请使用 POST 接口，参数 JSON[ssid] 缺失或错误',
    );
    // 输出数据
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    header("HTTP/1.1 403 Forbidden");
}