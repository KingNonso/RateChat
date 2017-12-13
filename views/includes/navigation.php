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
        $nav = array(
            'dashboard' => array(
                'name' => 'Dashboard',
                'title' => 'Home Page',
                'href' => URL.'admin',
                'class' => '<i class="fa fa-dashboard"></i>'

            ),
            'search' => array(
                'name' => 'Search Records',
                'href' => URL.'admin/search',
                'title' => 'Search entire hostel database',
                'class' => '<i class="fa fa-search"></i>'
            ),
            'latest' => array(
                'name' => 'New Tenants',
                'href' => URL.'admin/latest',
                'title' => 'Details of all new tenants',
                'class' => '<i class="fa fa-folder"></i>'
            ),
            'lease' => array(
                'name' => 'Lease Expired',
                'href' => URL.'admin/lease',
                'title' => 'All Lease Expiring in 3 months or less',
                'class' => '<i class="fa  fa-calendar"></i>'
            ),
            'tenants' => array(
                'name' => 'Tenant Record',
                'href' => URL.'admin/tenants',
                'title' => 'All Hostel tenants record',
                'class' => '<i class="fa fa-book"></i>'

            ),
            'hostel' => array(
                'pages' => array(
                    'Filled Rooms' => URL.'admin/rooms/filled',
                    'Vacant Rooms' => URL.'admin/rooms/vacant',
                    'Hostel Details' => URL.'admin/hostel',
                ),

                'name' => 'Hostel Record ',
                'href' => URL.'admin/hostel',
                'title' => 'Academic Subject',
                'class' => '<i class="fa fa-bookmark-o"></i>'

            ),
            /*
                     'events' => array(
                'name' => 'Events/ Calendar ',
                'href' => URL.'admin/event',
                'title' => 'Events/ Calendar',
                'class' => '<i class="fa fa-heartbeat"></i>'

            ),
                 'report' => array(
                'name' => 'Progress Report ',
                'href' => URL.'admin/report',
                'title' => 'Your report',
                'class' => '<i class="fa fa-pie-chart"></i>'

            ),

             */
            'management' => array(
                'name' => 'Management Info',
                'href' => URL.'admin/management',
                'title' => 'Hostel management',
                'class' => '<i class="fa fa-black-tie"></i>'

            ),
            'account' => array(
                'name' => 'My Account',
                'href' => URL.'admin/account',
                'title' => 'Set your account',
                'class' => '<i class="fa fa-user"></i>'

            ),
            'logout' => array(
                'name' => 'Logout Now',
                'href' => URL.'login/logout',
                'title' => 'Logout from your account',
                'class' => '<i class="fa fa-sign-out"></i>'

            ),



        );

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
                <?php } }  ?>                              <?php }    ?>


</ul>
<!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
</aside>