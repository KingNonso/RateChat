<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php $title = isset($this->title)? $this->title: 'Rate Chats'; echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/custom/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/custom/plugins/iCheck/square/blue.css">
    <?php  //General or public applicable css
        if (isset($this->generalCSS))
        {
            foreach ($this->generalCSS as $plugin)
            {
                echo '<link  href="'.URL.'public/'.$plugin.'" rel="stylesheet" type="text/css">';
            }
        }
    ?>
    <?php  //General or public applicable css
        if (isset($this->pageCSS))
        {
            foreach ($this->pageCSS as $plugin)
            {
                echo '<link  href="'.URL.'views/'.$plugin.'" rel="stylesheet" type="text/css">';
            }
        }
    ?>
    <?php  //page applicable plugin
        if (isset($this->cssPlugin))
        {
            foreach ($this->cssPlugin as $plugin)
            {
                echo '<link  href="'.URL.'public/custom/plugins/'.$plugin.'" rel="stylesheet" type="text/css">';
            }
        }
    ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition register-page">

<div class="container-fluid">

    <div class="row" id="container">
        <div class="col-sm-12 text-center">
            <br/>
            <img src="<?php echo URL; ?>public/images/ratechat3.png" class="img-thumbnail center-block" alt="RateChats" width="120" height="120">
            <br/>
        </div>
        <div class="col-sm-6 col-sm-offset-3 register-box-body">


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
                        <h4><i class="icon fa fa-user-plus"></i> <b>Register</b>,</h4>
                        <p id="status">Welcome to Rate Chats, To Register: Fill out your detail in the fields below </p>

                    </div>
                <?php } ?>

            </div>
            <form action="<?php echo(URL.'login/account_setup'); ?>" method="post">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="first_name">First Name</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>

                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter First Name  " required>
                        </div>

                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="last_name">Last Name</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>

                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter Last Name " required>
                        </div>

                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="sex">Sex</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-heart"></i> </span>
                            <select class="form-control" name="sex" id="sex" required="required">
                                <?php if (Session::exists('sex')){?>
                                    <option value="<?php echo $flash = Session::flash('sex'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Select</option>
                                <?php Person::sex(); ?>
                            </select>

                        </div>

                    </div>

                    <div class="col-sm-4 form-group">
                        <label class="control-label"> Date of Birth</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                            <input class="form-control" id="datepicker" name="datepicker" placeholder="Date of Birth" type="text">
                        </div>

                    </div>
                    <div class="col-sm-4 form-group">
                        <label for="marital_status">Marital Status</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-hourglass"></i> </span>
                            <select class="form-control" name="marital_status" id="marital_status" required="required">
                                <?php if (Session::exists('marital_status')){?>
                                    <option value="<?php echo $flash= Session::flash('marital_status'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <?php Person::Marital_status(); ?>
                            </select>

                        </div>

                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="control-label" id="call_center" ><i class="glyphicon glyphicon-phone"></i> Phone Number:</label>
                        <div class="input-group">
                            <input type="hidden" name="url_path" id="url_path" value="<?php echo URL; ?>">
                            <input type="tel" id="telephone" name="telephone" onchange="intlNumber()" class="form-control" required>
                            <input type="hidden" id="phone_number" name="phone_number">
                        </div>

                    </div>
                    <div class="col-sm-4 form-group">
                        <label for="slug">Username</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-star"></i> </span>

                            <input type="text" id="slug" name="slug" class="form-control" placeholder="Enter Unique Username " required>
                        </div>

                    </div>
                    <div class="col-sm-4 form-group">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i> </span>

                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address " required>
                        </div>

                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i> </span>
                            <input type="password" id="password"  name="password"  class="form-control" placeholder="Enter Password: " required>
                        </div>

                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="password_again">Retype Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i> </span>
                            <input type="password" id="password_again"  name="password_again"  class="form-control" placeholder="Enter Password: " required>
                        </div>

                    </div>

                    <div class="col-sm-12 form-group">
                        <div class="row">
                            <div class="col-xs-8">
                                <label>
                                    <input type="checkbox" value="yes" id="agreement_2_terms" name="agreement_2_terms"> I agree to the <a href="#">terms</a>
                                </label>

                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Register Now</button>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="social-auth-links text-center">
                            <p>- OR -</p>
                            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
                                Facebook</a>
                            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
                                Google+</a>
                        </div>

                    </div>


                    <div class="col-sm-12 form-group">
                        <a href="<?php echo URL; ?>login" class="text-center">I already have a membership</a>
                    </div>


                </div>


            </form>


        </div>

    </div>


</div>

<!-- /.register-box -->

<!-- jQuery 2.2.0 -->
<script src="<?php echo URL; ?>public/custom/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="<?php echo URL; ?>public/custom/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo URL; ?>public/custom/plugins/iCheck/icheck.min.js"></script>
<?php
    //general applicable js
    if (isset($this->generalJS))
    {
        foreach ($this->generalJS as $general)
        {
            echo '<script type="text/javascript" src="'.URL.'public/'.$general.'"></script>';
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
