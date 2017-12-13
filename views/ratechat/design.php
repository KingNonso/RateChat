<!DOCTYPE html>
<html>
<head>
    <title><?php $title = isset($this->title)? $this->title: 'School Board'; echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link href="<?php echo URL; ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <?php  //page applicable plugin
        if (isset($this->cssPlugin))
        {
            foreach ($this->cssPlugin as $plugin)
            {
                echo '<link  href="'.URL.'public/custom/plugins/'.$plugin.'" rel="stylesheet" type="text/css">';
            }
        }
    ?>
    <!-- Theme style -->
    <link href="<?php echo URL; ?>public/custom/css/AdminLTE.min.css" rel="stylesheet" type="text/css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
    <link href="<?php echo URL; ?>public/custom/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition register-page">

<div id="about" class="container-fluid">

    <div class="row" id="container">
        <br/>

        <div class="col-sm-10 col-sm-offset-1 register-box-body">
            <div class="col-sm-12 text-center">
                <img src="<?php echo URL; ?>public/images/unizik_logo.jpg" class="img-thumbnail center-block" alt="myUNIZIK" width="50" height="50">
                <h3 class="error-code text-center">Nnamdi Azikiwe University </h3>
                <p>Anambra State</p>
                <p>Email: ratechat@myunizik.com.ng</p>

                <hr>

                <?php if (Session::exists('home')) { ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Alert!</h4>
                        <?php echo Session::flash('home'); ?>                         </div>
                    <?php ?>
                <?php } elseif (Session::exists('error')) { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <?php echo Session::flash('error');  //echo  //$this->error;?>
                    </div>
                <?php } else {
                    ?>
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-info"></i> Note</h4>
                        <p id="status">Important Updates will be displayed here</p>

                    </div>
                <?php } ?>



            </div>
            <div class="col-sm-6 ">

                <p class="list-group-item-text">Name</p>
                <h4 class="list-group-item-heading"><?php echo(Session::get('logged_in_user_name')); ?></h4>

                <p class="list-group-item-text">Student ID</p>
                <h4 class="list-group-item-heading"><?php echo(Session::get('logged_in_user_slug')); ?></h4>

                <p class="list-group-item-text">Email</p>
                <h4 class="list-group-item-heading"><?php echo(Session::get('email')); ?></h4>

            </div>

            <div class="col-sm-6 text-right">
                <div class="imgholder"><img src="<?php echo(Session::get('logged_in_user_photo')); ?>" class="user-image" alt="<?php echo(Session::get('logged_in_user_name')); ?>" width="100" height="100"></div>
            </div>
            <div class="col-sm-12 text-center">
                <br/>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><b>Album</b> <small> Track</small> </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th style="text-align: center">Item</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>3 Minutes Video Interview of yourself</td>
                                <td><a href="<?php echo URL; ?>ratechat/video" class="btn btn-danger btn-flat">Add Video </a></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Baby Picture </td>
                                <td><a href="<?php echo URL; ?>ratechat/picture/baby" class="btn bg-yellow btn-flat">Add Picture </a></td>

                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Year 1 Picture  </td>
                                <td><a href="<?php echo URL; ?>ratechat/picture/first" class="btn bg-yellow btn-flat">Add Picture </a></td>

                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Final Year Picture </td>
                                <td><a href="<?php echo URL; ?>ratechat/picture/final" class="btn bg-yellow btn-flat">Add Picture </a></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>Picture (Other Memoirs) </td>
                                <td><a href="<?php echo URL; ?>ratechat/picture/other" class="btn bg-black btn-flat">Add Memoirs </a></td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>Responses to Questions</td>
                                <td><a href="<?php echo URL; ?>ratechat/answers" class="btn bg-black btn-flat">Start </a></td>
                            </tr>
                            <tr>
                                <td>7.</td>
                                <td> Role of Honour - Vote cube </td>
                                <td><a href="<?php echo URL; ?>ratechat/honour" class="btn bg-black btn-flat">Start </a></td>
                            </tr>

                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->


            </div>




        </div>

    </div>

    <div class="row">
        <br/>

        <div class="col-sm-6 col-sm-offset-6">
            <a href="<?php echo URL; ?>ratechat/timeline" class="btn btn-default btn-flat"> View Your Time Line </a>
        </div>
        <br/>
        <br/>
    </div>
</div>


<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!-- Latest compiled JavaScript -->
<script src="<?php echo URL; ?>public/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo URL; ?>public/custom/js/app.min.js"></script>
<script src="<?php echo URL; ?>public/custom/js/demo.js"></script>

<?php
    //general applicable js
    if (isset($this->generalJS))
    {
        foreach ($this->generalJS as $general)
        {
            echo '<script type="text/javascript" src="'.URL.'public/custom/js/'.$general.'"></script>';
        }
    }
    if (isset($this->jsPlugin))
    {
        foreach ($this->jsPlugin as $jsPlugin)
        {
            echo '<script type="text/javascript" src="'.URL.'public/custom/plugins/'.$jsPlugin.'"></script>';
        }
    }
    //page specific js
    if (isset($this->js))
    {
        foreach ($this->js as $js)
        {
            echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
        }
    }

?>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
