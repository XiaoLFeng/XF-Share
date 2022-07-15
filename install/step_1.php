<?PHP 
// 获取数据
$web_title = $_POST["web_title"];
$web_domain = $_POST["web_domain"];
$web_desc = $_POST["web_desc"];

// 将信息编译成数组
$data = array(
    'web_title'=>$web_title,
    'web_domain'=>$web_domain,
    'web_desc'=>$web_desc,
);
$data = json_encode($data);
// 将内容写入文件中
if (file_exists('../config.yml') == FALSE) {
    mkdir('../config.yml');
}
//header('location:./install.php?step=2');