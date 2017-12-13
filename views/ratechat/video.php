<!DOCTYPE html>
<html>
<head>
    <title><?php $title = isset($this->title)? $this->title: 'School Board'; echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo URL; ?>public/images/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo URL; ?>public/images/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL; ?>public/images/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL; ?>public/images/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL; ?>public/images/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo URL; ?>public/images/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo URL; ?>public/images/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo URL; ?>public/images/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo URL; ?>public/images/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo URL; ?>public/images/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo URL; ?>public/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo URL; ?>public/images/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo URL; ?>public/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo URL; ?>public/images/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo URL; ?>public/images/favicons/ms-icon-144x144.png">
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
        <div class="col-sm-12 text-center">
            <br/>
            <img src="<?php echo URL; ?>public/images/unizik_logo.jpg" class="img-thumbnail center-block" alt="myUNIZIK" width="60" height="60">
            <h1><b>Year Book</b> </h1>

        </div>

        <div class="col-sm-6 col-sm-offset-3 register-box-body">
            <h3 class="error-code text-center"> Video Album </h3>

            <div class="box-body">
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
                        <p id="status">With the aid of a good camera and a well lightened environment, Tell us about yourself, your past and most importantly... Your future</p>

                    </div>
                <?php } ?>

            </div>

            <div>
                <h3>This is a video interview of yourself <small>Feel free to get creative with it</small></h3>
                <hr/>
                <p>Questions you are to respond to during the 3-5minutes you have include:</p>
                <ol>
                    <li>Who are you? Basic Info - Name, dept, hostel, DOB, height, weight, complexion, state of origin, home address</li>
                    <li>Who are you really? Your likes, dislikes, hobbies, interests, ups and downs</li>
                    <li>Who have you been? Your best moments, worst moments, most memorable friendships</li>
                    <li>What did you learn - about yourself, about people, about God - from your time in school? </li>
                    <li>What one moment would you really like to change or make happen?</li>
                    <li>What would you have done to make your <b>CGPA</b> Better?</li>
                    <li>Moments: Tell us about those moments that made you...
                        <ul>
                            <li>Scream</li>
                            <li>Laugh</li>
                            <li>Cry</li>
                            <li>Felt like you should just die :(</li>
                        </ul>
                    </li>
                    <li>Favorites: Tell us about those people/ places and what they mean to you
                        <ul>
                            <li>Favorite place inside school</li>
                            <li>Favorite place outside school</li>
                            <li>Favorite/ Best Lecturer</li>
                            <li>Favorite/ Best Friend</li>
                        </ul>
                    </li>
                    <li>Where do you see yourself in the next 10years?</li>
                    <li>Last words (Do a sign out dance, act or quote or anything)</li>

                </ol>
            </div>
            <form action="<?php echo(URL.'ratechat/ratechat_video'); ?>" method="post">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="url_link">Drop the Youtube Link</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-link"></i> </span>
                            <input type="text" id="url_link" name="url_link" class="form-control">

                        </div>
                        <p class="help-block">Create a free youtube channel, upload the video to your channel and copy and paste the link here. We would take it from there. </p>

                    </div>

                    <div class="col-sm-12 form-group">
                        <div class="row">
                            <div class="col-xs-8">
                                <label>
                                    <input type="checkbox"> Yes, my video meets up with the <a href="#">requirements</a>
                                </label>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-success btn-block btn-flat">Add Video</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>




                </div>


            </form>


        </div>
    </div>


</div>
<div class="container">

    <!-- Modal -->
    <div class="modal fade" id="find_student_reg_no" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Retrieve Student ID </h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo(URL.'login/login'); ?>" method="post" onsubmit="return false;">

                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label for="find_session">Academic Faculty</label>
                                <select class="form-control" name="find_session" id="find_session" required="required" onchange="retrieve_reg_no('class',1)">

                                    <?php echo($this->sessions); ?>
                                </select>
                            </div>
                            <div class="col-sm-12 form-group">

                                <label for="find_class">Select Department </label>
                                <select class="form-control" name="find_class" id="find_class" onchange="retrieve_reg_no('class',1)">
                                    <?php echo($this->classes); ?>
                                </select>
                            </div>

                            <div class="col-sm-12 form-group">
                                <label for="find_name">Select Name </label>
                                <select class="form-control" name="find_name" id="find_name" onchange="retrieve_reg_no('name',1)">
                                    <option value="0">Loading</option>
                                </select>
                            </div>


                            <div class="col-sm-12 form-group" id="submit">
                                <h2 id="ur_reg_no" class="text-danger"></h2>
                                <input type="hidden" id="found_reg_no">
                                <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="insert_found()">Insert User ID</button>
                            </div>

                        </div>


                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
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


</body>
</html>
