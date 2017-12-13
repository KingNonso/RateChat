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
<?php
    $max = 1000 * 1024; //2mb
    $user = new User();
?>

<div id="about" class="container-fluid">

    <div class="row" id="container">
        <div class="col-sm-12 text-center">
            <br/>
            <img src="<?php echo URL; ?>public/images/unizik_logo.jpg" class="img-thumbnail center-block" alt="myUNIZIK" width="60" height="60">
            <h1><b>Year Book</b> </h1>

        </div>

        <div class="col-sm-6 col-sm-offset-3 register-box-body">
            <h3 class="error-code text-center">Questions </h3>

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
                        <p id="status">Ask questions you would like people to respond to?</p>

                    </div>
                <?php } ?>

            </div>
            <form id="form1" name="form1" method="post" action="<?php echo URL; ?>ratechat/ratechat_questions"  enctype="multipart/form-data">

                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="question">Questions: </label>
                        <textarea class="form-control" name="question" id="question"></textarea>


                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="scope">Scope: </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-hourglass"></i> </span>
                            <select class="form-control" name="scope" id="scope" required="required">
                                <?php if (Session::exists('scope')){?>
                                    <option value="<?php echo $flash = Session::flash('scope'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <?php Person::scope(); ?>
                            </select>

                        </div>

                    </div>

                    <div class="col-sm-12 form-group">
                        <div class="row">
                            <div class="col-xs-8">
                                <button type="submit" class="btn btn-success btn-block btn-flat">Add Question</button>
                            </div>
                            <div class="col-xs-4">
                                <a href="<?php echo(URL); ?>ratechat/start" class="btn btn-block btn-link btn-flat">Return to ratechat</a>
                            </div>
                            <!-- /.col -->
                            <!-- /.col -->
                        </div>
                    </div>


                </div>


            </form>


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
