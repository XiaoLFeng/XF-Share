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
        <a class="navbar-brand" href="#"><strong><?PHP echo info('xfs_title') ?></strong></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?PHP color(1) ?>" aria-current="page" href="./index.php">首页</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?PHP color(2) ?>" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">dropdown</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="例：bilibili" aria-label="Search">
                <button class="btn btn-outline-success" type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom" title="搜索"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
</nav>