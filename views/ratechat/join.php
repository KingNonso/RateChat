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
        <div class="col-sm-12 text-center">
            <br/>
            <img src="<?php echo URL; ?>public/images/unizik_logo.jpg" class="img-thumbnail center-block" alt="myUNIZIK" width="60" height="60">
            <h1><b>Year Book</b> </h1>

        </div>

        <div class="col-sm-6 col-sm-offset-3 register-box-body">
            <h3 class="error-code text-center">Photo Album :: Video Album :: Memorable Moments</h3>

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
                        <h4><i class="icon fa fa-info"></i> Class of 2017!</h4>
                        <p id="status">A 3 Minute video (personal interview), Your Baby Picture, Your Year 1 and Final Year Pictures are required</p>

                    </div>
                <?php } ?>

            </div>
            <form action="<?php echo(URL.'ratechat/join_album'); ?>" method="post">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="grad_yr">Year of Graduation </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                            <select class="form-control" name="grad_yr" id="grad_yr" required="required">
                                <?php if (Session::exists('grad_yr')){?>
                                    <option value="<?php echo $flash = Session::flash('grad_yr'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0"> Year of Graduation</option>
                                <?php Person::student_grad_yr(); ?>

                            </select>

                        </div>

                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="program">Program</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i> </span>
                            <select class="form-control" name="program" id="program" required="required">
                                <?php if (Session::exists('program')){?>
                                    <option value="<?php echo $flash = Session::flash('program'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Program</option>
                                <?php Person::student(); ?>

                            </select>

                        </div>

                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="level">Level </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-signal"></i> </span>
                            <select class="form-control" name="level" id="level" required="required">
                                <?php if (Session::exists('level')){?>
                                    <option value="<?php echo $flash = Session::flash('level'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Level</option>
                                <?php Person::acad_level(); ?>

                            </select>

                        </div>

                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="faculty">Faculty </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i> </span>
                            <select class="form-control" name="faculty" id="faculty" required="required">
                                <?php if (Session::exists('faculty')){?>
                                    <option value="<?php echo $flash = Session::flash('faculty'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Faculty</option>
                                <?php Person::faculty(); ?>
                            </select>

                        </div>

                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="dept">Department </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-hourglass"></i> </span>
                            <select class="form-control" name="dept" id="dept" required="required">
                                <?php if (Session::exists('dept')){?>
                                    <option value="<?php echo $flash = Session::flash('dept'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Department</option>
                                <?php Person::depts(); ?>
                            </select>

                        </div>

                    </div>

                    <div class="col-sm-12 form-group">
                        <div class="row">
                            <div class="col-xs-8">
                                <label>
                                    <input type="checkbox"> I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-success btn-block btn-flat"> Start Album </button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>


                    <a href="<?php echo(URL); ?>login/recovery" class="text-center">I have already created an Album, Take me to my Profile</a>

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


<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
