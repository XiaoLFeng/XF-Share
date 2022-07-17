<?PHP 
// 构建显色函数
function color($color_id) {
    global $menu_id;
    if ($menu_id == $color_id) {
        echo 'active';
    }
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-primary bg-opacity-50 mb-4 shadow">
    <div class="container-fluid my-2">
        <a class="navbar-brand" href="<?PHP echo 'http://'.$_SERVER['HTTP_HOST'].'/index.php' ?>"><strong><?PHP echo $ordinary_main['info']['xfs_title']['text']; ?></strong></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?PHP color(1) ?>" aria-current="page" href="<?PHP echo 'http://'.$_SERVER['HTTP_HOST'].'/index.php' ?>"><i class="bi bi-house-door"></i> 首页</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?PHP color(2) ?>" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?PHP color(3) ?>" href="<?PHP echo 'http://'.$_SERVER['HTTP_HOST'].'/admin/index.php' ?>"><i class="bi bi-person"></i> 管理员面板</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?PHP color(4) ?>" href="<?PHP echo 'http://'.$_SERVER['HTTP_HOST'].'/auth.php' ?>"><i class="bi bi-box-arrow-in-left"></i> 用户登录</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="例：bilibili" aria-label="Search">
                <button class="btn btn-outline-success" type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom" title="搜索"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
</nav>