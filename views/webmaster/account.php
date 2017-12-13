<?php
    include(View::NavBar());

?>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            My Profile
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
    <div class="col-xs-12">
<?php if(Session::exists('home')){ ?>
    <div class="box box-success">
    <div class="box-header ">
            <h3 class="box-title"><?php echo Session::flash('home');?> </h3>
    </div>
    </div>

<?php } elseif(Session::exists('error')){ ?>
        <div class="box box-danger">
            <div class="box-header ">

            <h3 class="box-title"><?php echo Session::flash('error');?> </h3>
            </div>
        </div>

<?php }else{?>
        <div class="box box-primary">
            <div class="box-header ">

            <h3 class="box-title">Update Account Details </h3>
            </div>
        </div>
<?php }?>

    </div>

    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img src="<?php echo(Session::get('logged_in_user_photo')); ?>" class="profile-user-img img-responsive img-circle" alt="<?php echo(Session::get('logged_in_user_name')); ?>">

                <h3 class="profile-username text-center"><?php echo(Session::get('logged_in_user_name')); ?></h3>

                <p class="text-muted text-center">Member</p>
                <!-- Profile Image -->
                <?php $my = $this->account; ?>


            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-book margin-r-5"></i>  Bio Data</strong>

                <p class="text-muted">
                    <?php echo $my['fullname']; ?>
                </p>

                <hr>

                <strong><i class="fa fa-phone margin-r-5"></i> Other Details</strong>

                <p class="text-muted">
                    <?php echo $my['phone_number']; ?>
                </p>
                <p class="text-muted">
                    <?php echo $my['email']; ?>
                </p>
                <p class="text-muted">
                    <?php echo $my['home_address']; ?>
                </p>

                <hr>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Declaration</strong>

                <p>I choose to be a Member in this platform, not because it is easy, but because it is hard. Because this goal
                    will serve to measure the best of my energies and skills...</p>
                <p>Because this challenge is one I'm willing to accept, one I'm unwilling to postpone and one which I intend to win.</p>
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
    <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
        <li><a href="#updator" data-toggle="tab">Password</a></li>
    </ul>
    <div class="tab-content">

        <div class="active tab-pane" id="settings">
            <form class="form-horizontal" role="form" action="<?php echo(URL.'dashboard/update/personal/'.$my['id']); ?>" method="post">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Name:</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?php echo($my['fullname']); ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?php echo($my['email']); ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Phone:</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?php echo($my['phone_number']); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="home_address">Address:</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?php echo($my['home_address']); ?></p>
                    </div>

                </div>

            </form>

        </div>
        <div class="tab-pane" id="updator">
            <form class="form-horizontal" role="form" action="<?php echo(URL.'admin/update/password/'.$my['id']); ?>" method="post">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Username:</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?php echo($my['username']); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="password">Password:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="confirm_pass">Confirm Password:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" placeholder="Re-enter password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
    </div>
    <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->

    </section>
    <!-- /.content -->
    </div>  <!-- /.content-wrapper -->

  <!-- Main Footer -->
<?php
    include(View::rightNav());
?>