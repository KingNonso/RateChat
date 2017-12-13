<?php
    include(View::dashBar());
    $max = 2000 * 1024; //500kb
    $user = new User();
?>
<?php
    $mod = $this->member;
?>

<!-- Content Wrapper. Contains page content -->

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box-body">
                <?php if(Session::exists('home')){ ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Done!</h4>
                        <?php echo Session::flash('home');?>                         </div>
                    <?php  ?>
                <?php } elseif(Session::exists('error')){ ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <?php echo Session::flash('error');  //echo  //$this->error;?>
                    </div>
                <?php }
                else{?>
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-bolt"></i>  Write New Ads!</h4>
                        You asked for it, Now you have it! The Whole world as your audience
                    </div>
                <?php } ?>

            </div>

        </div>
        <div class="col-md-3">
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title">Ads</h3>
                </div>
                <div class="box-body">
                    Some word of marketing
                    <br/>
                    <br/>
                    <p>To advertise here: write to support@ratechat.com.ng with email title "ADVERTISEMENT"</p>
                </div>
                <!-- /.box-body -->
                <!-- Loading (remove the following to stop the loading)-->
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <!-- end loading -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-9">
            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-orange-active">
                    <h3 class="widget-user-username"><?php echo($this->member['name']); ?></h3>
                    <h5 class="widget-user-desc"><?php echo($this->member['slug']); ?></h5>
                </div>
                <?php
                    $perms = array('Public','Celebrity','Executive');
                    $people = array('Friends','Fans','Followers');
                    $class = $perms[$this->member['user_perms_id']-1];
                    $fam = $people[$this->member['user_perms_id']-1];

                ?>
                <div class="widget-user-image">
                    <img src="<?php echo(URL.'public/uploads/profile/'.$mod['profile_picture']); ?>" class="img-circle">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo($class); ?></h5>
                                <span class="description-text">CLASS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">.</h5>
                                <span class="description-text">.</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo($this->member['count']); ?></h5>
                                <span class="description-text"><?php echo($fam); ?></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><a href="<?php echo(URL); ?>profile/member/<?php echo($this->member['slug']); ?>" > <?php echo($this->member['name']); ?> </a></h3>
                </div>

                <div class="box-body">

                    <img src="<?php echo(URL.'public/uploads/profile/'.$mod['profile_picture']); ?>" class="img-responsive">
                    <p> <?php echo($mod['nick']); ?> </p>

                    <p>ID: <?php echo($mod['slug']); ?> </p>
                    <p>DOB: <?php echo($mod['dob']); ?> </p>




                </div>
                <div class="box-footer text-left">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4> Bio Data <small>A little about me</small></h4>
                            <p> <?php echo($mod['bio_data']); ?> </p>

                        </div>

                    </div>
                </div>
            </div>

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













