<?php
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    $url = rtrim($url, '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);

    if (count($url) > 1) {
        //reconstruct the url back
        $url = URL . $url[0] . '/' . $url[1];
        if (count($url) > 2) {
            $subURL = URL . $url[0] . '/' . $url[1] . '/' . $url[2];
        }

    } else {
        //it means we are viewing the index page
        $active = $url[0];
        $url    = URL . $url[0];

    }

?>
<body class="hold-transition skin-purple sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>Rate</b>Chats</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Rate</b>Chats <?php $title = isset($this->title) ? $this->title : ' ';
                    echo $title; ?></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav hidden-xs hidden-sm">
                    <?php
                        $nav = $this->nav;
                        if (isset($nav)) {
                            foreach ($nav as $item => $page) {
                                if (!array_key_exists('top-ignore', $page)) {
                                    if (array_key_exists('pages', $page)) {

                                        foreach (($page) as $name => $link) {
                                            if (is_array($link)) {
                                                ?>
                                                <li class="dropdown user user-menu" <?php if ($page['href'] === $url) {
                                                    echo('class="active"');
                                                } ?>>

                                                    <a class="dropdown-toggle" data-toggle="dropdown"
                                                       href="<?php echo $page['href']; ?>"
                                                       title="<?php echo $page['title']; ?>"> <?php echo $page['class']; ?>
                                                        <span><?php echo $page['name']; ?></span> <i
                                                            class="fa fa-angle-left pull-right"></i></a>
                                                    <ul class="dropdown-menu">
                                                        <?php
                                                            while (list($key, $val) = each($link)) {
                                                                ?>
                                                                <li class="user-footer"> <a href="<?php echo $val; ?>"
                                                                                            title="<?php echo $key; ?>"
                                                                                            class="btn-default bg-purple-active <?php if (isset($subURL) && $subURL === $val) {
                                                                                                echo('active');
                                                                                            } ?>"><i
                                                                        class="fa fa-link"></i><span> <?php echo $key; ?></span></a>
                                                                </li><?php } ?>
                                                    </ul>
                                                </li>
                                            <?php }
                                        }
                                    } else { ?>
                                        <li class="<?php if ($page['href'] === $url) {
                                            echo('active');
                                        } ?>"><a href="<?php echo $page['href']; ?>"
                                                 title="<?php echo $page['title']; ?>"><?php echo $page['class']; ?>
                                                <span> <?php echo $page['name']; ?></span><?php if (array_key_exists('label', $page)) { ?> <?php echo $page['label']; ?> <?php } ?>
                                            </a></li>
                                    <?php }
                                }
                            } ?>
                        <?php } ?>


                    <!-- User Account Menu -->
                </ul>
                <ul class="nav navbar-nav">
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <?php
                            if(isset($this->notification)){ ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning"><?php echo(count($this->notification)); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have <?php echo(count($this->notification)); ?> notifications</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <?php
                                                foreach($this->notification as $r){ ?>
                                                    <li>
                                                        <a href="#">
                                                            <i class="fa <?php echo($r['icon']); ?>"></i> <?php echo($r['notice']); ?>
                                                        </a>
                                                    </li>


                                                <?php } ?>
                                            <li class="footer"><a href="#">View all</a></li>
                                        </ul>
                                    </li>
                                </ul>

                    <?php } ?>

                    </li>
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user-plus"></i>
                            <span class="label label-warning"><?php echo(count($this->friends)); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <?php
                                if(isset($this->friends)){
                                    foreach($this->friends as $r){

                            ?>

                            <li class="user-header">

                                <img src="<?php echo(URL . 'public/uploads/profile/' . $r['pix']); ?>" class="user-image"
                                     alt="<?php echo($r['name']); ?>">


                                <p>
                                    <?php echo($r['name']); ?>
                                    <small><?php echo($r['username']); ?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="javascript:void(0)" class="btn bg-orange-active btn-flat">Accept</a>
                                </div>
                                <div class="pull-right">
                                    <a href="javascript:void(0)" class="btn btn-default btn-flat">Decline</a>
                                </div>
                            </li>
                                    <?php } ?>
                                    <li class="user-footer">
                                        <a href="<?php echo URL; ?>admin/account" class="btn bg-orange-active btn-flat">Accept All</a>

                                    </li>
                                <?php } ?>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo(Session::get('logged_in_user_photo')); ?>" class="user-image"
                         alt="<?php echo(Session::get('logged_in_user_name')); ?>">
                </div>
                <div class="pull-left info">
                    <p><?php echo(Session::get('logged_in_user_name')); ?>
                    </p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- search form (Optional) -->
            <form action="<?php echo(URL.'dashboard/find_friends'); ?>" method="post" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="friend_name" id="friend_name" class="form-control" placeholder="Search People...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!-- /.search form -->