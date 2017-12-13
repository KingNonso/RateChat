<?php
    include(View::webmaster_nav());
    $max = 500 * 1024; //500kb

?>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            My Profile
            <small>Webmaster Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
    <div class="col-xs-12">
<?php if(Session::exists('home')){?>
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

                <p class="text-muted text-center"><?php echo ucwords($_SESSION['role_name']);  ?></p>
                <!-- Profile Image -->
                <?php $rank = ($this->account);
                    //foreach($this->personnel_rank as $rank){ ?>

                <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Level</b> <a class="pull-right"><?php echo($rank['level']); ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Appointment</b><a class="pull-right"><?php echo($rank['appointment']); ?></a>
                        </li>
                    <li class="list-group-item">
                        <b>Title</b> <a class="pull-right"><?php echo($rank['title']); ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Department</b> <a class="pull-right"><?php echo($rank['department']); ?></a>
                    </li>


                    <?php //} ?>

                </ul>

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
                <strong><i class="fa fa-book margin-r-5"></i> Professional Bio Data</strong>

                <p class="text-muted">
                    <?php echo $rank['bio_data']; ?>
                </p>

                <hr>

                <strong><i class="fa fa-phone margin-r-5"></i> Other Details</strong>

                <p class="text-muted">
                    <?php echo $rank['phone_no']; ?>
                </p>
                <p class="text-muted">
                    <?php echo $rank['marital_status']; ?>
                </p>
                <p class="text-muted">
                    <?php echo $rank['residential_address']; ?>
                </p>

                <hr>

                <!--  <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

                              <p>
                    <?php
                    //$tags = explode(',',$this->account['skill']);
                    //$label = array('danger','success','info','warning','primary','default','danger','success','info','warning','primary','default');
                    //$i = count($tags);
                    //for($x = 0; $x<$i; $x++){ ?>
                                    <span class="label label-<?php //echo $label[$x]; ?>"><?php// echo $tags[$x]; ?></span>&nbsp;
                                    <?php // } ?>

                </p>
 -->

                <hr>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

                <p>I choose to be a Teacher in this decade, not because it is easy, but because it is hard. Because this goal
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
        <li><a href="#update_pass" data-toggle="tab">Password</a></li>
    </ul>
    <div class="tab-content">

        <div class="active tab-pane" id="settings">
            <form class="form-horizontal" action="<?php echo(URL.'webmaster/account_update'); ?>"  method="post" enctype="multipart/form-data" name="form1" id="form1">
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $this->account['email']; ?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">Phone</label>

                    <div class="col-sm-10">
                        <input type="hidden" name="token" id="token" value="<?php echo Tokens::generate(); ?>" />

                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">First Name</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="surname" class="col-sm-2 control-label">Last Name</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Last Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="othernames" class="col-sm-2 control-label">Other name</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="othernames" name="othernames" placeholder="Other names">
                    </div>
                </div>
                <div class="form-group">
                    <label for="marital_status" class="col-sm-2 control-label">Marital Status</label>

                    <div class="col-sm-10">
                        <select class="form-control" name="marital_status" id="marital_status" required="required">
                            <?php if (Session::exists('marital_status')){?>
                                <option value="<?php echo $flash= Session::flash('marital_status'); ?>" selected="selected"><?php echo $flash; ?></option>
                            <?php }?>
                            <?php Person::Marital_status(); ?>
                        </select>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"  for="residential_address">Address*</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" name="residential_address" id="residential_address" required="required">
                            <?php if (Session::exists('residential_address')){ echo(Session::flash('residential_address')); } ?>
                        </textarea>

                    </div>
                </div>
                <div class="form-group">
                    <label for="state_of_residence" class="col-sm-2 control-label">State of Residence*</label>

                    <div class="col-sm-10">
                        <select class="form-control" name="state_of_residence" id="state_of_residence" required="required">
                            <?php if (Session::exists('state_of_residence')){?>
                                <option value="<?php echo $flash= Session::flash('state_of_residence'); ?>" selected="selected"><?php echo $flash; ?></option>
                            <?php }?>
                            <?php Person::naija_state_gen(); ?>
                        </select>

                    </div>
                </div>
                <div class="form-group">
                    <label for="about" class="col-sm-2 control-label">About Me</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" id="about" name="about" placeholder="Experience"></textarea>
                    </div>
                </div>
                <!--
                                <div class="form-group">
                    <label for="skill" class="col-sm-2 control-label">Skills</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="skill" name="skill" placeholder="Skills">
                        <p class="help-block">You can enter multiple skills. Skills are comma delimited. Max of 12</p>

                    </div>
                </div>
-->

                <div class="form-group">
                    <label for="filename" class="col-sm-2 control-label">Picture</label>

                    <div class="col-sm-10">
                        <input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?php echo $max; ?>" />
                        <input type="file" name="filename" id="filename"
                               data-maxfiles="<?php echo $_SESSION['maxfiles']; ?>"
                               data-postmax="<?php echo $_SESSION['postmax']; ?>"
                               data-displaymax="<?php echo $_SESSION['displaymax']; ?>"
                               required="required" />

                        <p id="status" class="help-block">Upload file should be no more than <?php echo Upload::convertFromBytes($max);?>.</p>
                        <p id="output" class="help-block"></p>


                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="yes" id="agree" name="agree"> I agree to the <a href="<?php echo URL.'admin/documentation';?>" title="Help Terms" target="_new">terms and conditions</a>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="update_pass">
            <form class="form-horizontal" action="<?php echo(URL.'webmaster/update_pass'); ?>"  method="post">
                <div class="form-group">
                    <label for="login_email" class="col-sm-2 control-label">Login Email</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="login_email" name="login_email" placeholder="Email" value="<?php echo $this->account['email']; ?>" required="required">
                    </div>
                </div>

                <div class="form-group">
                    <label for="old_pass" class="col-sm-2 control-label">Old Password</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="old_pass" name="old_pass" placeholder="Old Password" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_pass" class="col-sm-2 control-label">New Password</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="new_pass" name="new_pass" placeholder="New Password" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_again" class="col-sm-2 control-label">Password Again</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="new_again" name="new_again" placeholder="Confirm new password, enter it again" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">Update Password</button>
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