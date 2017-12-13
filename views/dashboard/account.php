<?php
    include(View::dashBar());
    $max = 2000 * 1024; //500kb

?>
  <!-- Content Wrapper. Contains page content -->

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
    <?php $rank = ($this->account); ?>

    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img src="<?php echo(Session::get('logged_in_user_photo')); ?>" class="profile-user-img img-responsive img-circle" alt="<?php echo(Session::get('logged_in_user_name')); ?>">

                <h3 class="profile-username text-center"><?php echo(Session::get('logged_in_user_name')); ?></h3>

                <p class="text-muted text-center"><?php echo ucwords($_SESSION['logged_in_user_slug']);  ?></p>
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Membership: <a class="pull-right"><?php echo ucwords($_SESSION['role_name']);  ?></a> </b>
                    </li>

                </ul>

                <!-- Profile Image -->


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
                <strong><i class="fa fa-file-text-o margin-r-5"></i>Status</strong>

                <p><?php echo $rank['marital_status']; ?></p>


                <hr>

                <strong><i class="fa fa-book margin-r-5"></i> DOB</strong>

                <p class="text-muted">
                    <?php echo $rank['dob']; ?>
                </p>

                <hr>
                <strong><i class="fa fa-black-tie margin-r-5"></i> Bio</strong>
                <p class="text-muted">
                    <?php echo $rank['bio_data']; ?>
                </p>

            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
    <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li><a href="#settings" data-toggle="tab">Settings</a></li>
        <li class="active"><a href="#update_pass" data-toggle="tab">Password</a></li>
        <li><a href="#picture" data-toggle="tab">Picture</a></li>
        <li><a href="#upgrade" data-toggle="tab">Upgrade</a></li>
        <!--  <li><a href="#Leadership" data-toggle="tab">Groups</a></li> -->
    </ul>
    <div class="tab-content">

        <div class="tab-pane" id="settings">
            <form class="form-horizontal" action="<?php echo(URL.'dashboard/account_update'); ?>"  method="post">
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $this->account['email']; ?>" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">Phone</label>

                    <div class="col-sm-10">

                        <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Phone Number" required="required" value="<?php echo $rank['phone_no']; ?>">
                        <p class="help-block">Leave prefixed in International format</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="state_of_birth" class="col-sm-2 control-label">State of Birth</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="state_of_birth" name="state_of_birth" placeholder="State of Birth" value="<?php echo $rank['state_of_birth']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="place_of_birth" class="col-sm-2 control-label">Place of Birth</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" placeholder="Place of Birth" value="<?php echo $rank['place_of_birth']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="passion" class="col-sm-2 control-label">Passion</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="passion" name="passion" placeholder="Your driving force" value="<?php echo $rank['passion']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="hobbies" class="col-sm-2 control-label">Hobbies</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="hobbies" name="hobbies" placeholder="hobbies" value="<?php echo $rank['hobbies']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"  for="postal_address">Postal Address*</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" name="postal_address" id="postal_address" required="required">
                            <?php echo $rank['postal_address']; ?>
                        </textarea>

                    </div>
                </div>
                <div class="form-group">
                    <label for="state_of_residence" class="col-sm-2 control-label">Postal State </label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="postal_state" name="postal_state" placeholder="postal_state" value="<?php echo $rank['postal_state']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="bio_data" class="col-sm-2 control-label">About Me</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" id="bio_data" name="bio_data" placeholder="Bio Data">
                            <?php echo $rank['bio_data']; ?>
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="occupation" class="col-sm-2 control-label">Skills</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Skills" value="<?php echo $rank['occupation']; ?>">
                        <p class="help-block">You can enter multiple skills. Skills are comma delimited. Max of 12</p>

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="yes" id="agree" name="agree"> I agree to the <a href="<?php //echo URL.'admin/documentation';?>" title="Help Terms" target="_new">terms and conditions</a>
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
        <div class="tab-pane active" id="update_pass">
            <form class="form-horizontal" action="<?php echo(URL.'dashboard/update_pass'); ?>"  method="post">
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
                    <label for="" class="col-sm-2 control-label">Password Confirmation</label>

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
        <div class="tab-pane" id="picture">
            <form class="form-horizontal" action="<?php echo(URL.'dashboard/picture_update'); ?>"  method="post" enctype="multipart/form-data" name="form1" id="form1">
                <div class="form-group">
                    <label for="filename" class="col-sm-2 control-label">Update Profile Picture</label>

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
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="upgrade">
            <form class="form-horizontal" action="<?php echo(URL.'dashboard/membership_upgrade'); ?>"  method="post">
                <div class="form-group">
                    <label for="login_email" class="col-sm-2 control-label"> Email</label>

                    <div class="col-sm-10">
                        <p class="form-control-static"><?php echo $this->account['email']; ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="membership" class="col-sm-2 control-label"> Membership</label>

                    <div class="col-sm-10">
                        <select class="form-control" name="membership" id="membership" required="required">
                            <?php if (isset($this->personnel_rank)){
                                foreach($this->personnel_rank as $r){ ?>
                                <option value="<?php echo $r->id; ?>" selected="selected"><?php echo $r->name; ?></option>
                            <?php } } ?>
                        </select>

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
    </div>


    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Activity <small>matrix</small> </h3>

        </div>
        <!-- /.box-header -->
        <!-- /.box-footer-->
    </div>

    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <div class="row">
        <div class="col-md-12">
            <!-- The time line -->
            <ul class="timeline">
                <!-- timeline time label -->
                <li class="time-label">
                  <span class="bg-red">
                   <?php echo(date('d M, Y')); ?>
                  </span>
                </li>
                <!-- /.timeline-label -->

                <?php if(isset($this->notification)){
                    foreach($this->notification as $b){ ?>
                        <li>
                            <i class="fa <?php echo($b['iconic']); ?>"></i>

                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> <?php echo($b['date']); ?></span>

                                <h3 class="timeline-header"><a href="#"><?php echo($b['name']); ?></a> activity </h3>

                                <div class="timeline-body">
                                    <?php echo($b['notice']); ?>
                                </div>
                            </div>
                        </li>

                    <?php }} ?>


                <!-- timeline item -->
                <li>
                    <i class="fa fa-laptop bg-purple"></i>

                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> On Login</span>

                        <h3 class="timeline-header"><a href="#"> LOG</a> update</h3>

                        <div class="timeline-body">

                            <ul class="nav nav-stacked">
                                <li><a href="#">Device <span class="pull-right badge bg-blue"><?php echo(Session::get('user_device_used')); ?></span></a></li>
                                <li><a href="#">Last Login <span class="pull-right badge bg-aqua"><?php echo(Session::get('user_last_login')); ?></span></a></li>
                                <li><a href="#">Browser <span class="pull-right badge bg-green"><?php echo(Session::get('user_browser_used')); ?></span></a></li>
                                <li><a href="#">Operating System <span class="pull-right badge bg-red"><?php echo(Session::get('user_os_used')); ?></span></a></li>

                            </ul>

                        </div>
                    </div>
                </li>
                <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                </li>
            </ul>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.content -->
    <!-- DIRECT CHAT -->
    <!--/.direct-chat -->

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