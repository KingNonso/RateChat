<?php
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    $url = rtrim($url, '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);

    if(count($url) > 1){
        //reconstruct the url back
        $url = URL.$url[0].'/'.$url[1];
        if(count($url) > 2){
            $subURL = URL.$url[0].'/'.$url[1].'/'.$url[2];
        }

    }else{
        //it means we are viewing the index page
        $active = $url[0];
        $url = URL.$url[0];

    }

?>


<!-- Sidebar Menu -->
<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <!-- Optionally, you can add icons to the links -->
    <!-- This is a dynamically generated navigation bar from the navigation array. It first passes the first level, then checks for 'pages' which signifies that has children, if 'pages' is not found, it continues normally, else if inserts a tree view i.e. a drop down -->

    <?php

        $nav = $this->nav;
        if (isset($nav)){
            foreach($nav as $item => $page){
                if (array_key_exists('pages',$page)){

                    foreach(($page) as $name => $link){
                        if (is_array($link)) {?>
                            <li class="treeview" <?php if($page['href'] === $url ){ echo('class="active"'); }  ?>>
                                <a href="<?php echo $page['href']; ?>" title="<?php echo $page['title']; ?>"> <?php echo $page['class']; ?> <span><?php echo $page['name']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <?php
                                        while (list($key, $val) = each($link)) {
                                            ?>
                                            <li> <a href="<?php echo $val; ?>" title="<?php echo $key; ?>" <?php if(isset($subURL) && $subURL === $val ){ echo('class="active"'); } ?>><i class="fa fa-link"></i><span> <?php echo $key; ?></span></a></li><?php   }     ?>
                                </ul>
                            </li>
                        <?php   }}} else{ ?>
                    <li <?php if($page['href'] === $url ){ echo('class="active"'); }  ?>> <a href="<?php echo $page['href']; ?>" title="<?php echo $page['title']; ?>"><?php echo $page['class']; ?><span> <?php echo $page['name']; ?></span><?php if(array_key_exists('label',$page)){ ?> <?php echo $page['label']; ?> <?php }  ?></a></li>
                <?php } }  ?>
        <?php }    ?>


</ul>
<!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header)
    <section class="content-header">
        <h1>
            <?php //$title = isset($this->title)? $this->title: 'RateChats'; echo $title; ?>
            <small>Dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <p style="color:#f36c36"> <?php //echo Session::breadcrumbs(); ?>  - You are here</p>


        </ol>


    </section>
    -->