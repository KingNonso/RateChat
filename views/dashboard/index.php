<?php
    include(View::dashBar());
?>
<?php
    $max = 2000 * 1024; //2mb
    $user = new User();
?>

    <!-- Main content -->
    <section class="content">
    <!-- Your Page Content Here -->
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?php echo ($this->events);  ?></h3>

                    <p>Events</p>
                </div>
                <div class="icon">
                    <i class="fa fa-glass"></i>
                </div>
                <a href="<?php echo (URL);  ?>dashboard/event" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo ($this->news);  ?><sup style="font-size: 20px">%</sup></h3>


                    <p>News</p>
                </div>
                <div class="icon">
                    <i class="ionicons ion-clipboard"></i>
                </div>
                <a href="<?php echo (URL);  ?>dashboard/blog" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php echo ($this->roommate);  ?></h3>

                    <p>Requests </p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo (URL);  ?>dashboard/roommate" class="small-box-footer">View  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php echo ($this->buy);  ?></h3>

                    <p>Available </p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="<?php echo (URL);  ?>dashboard/market" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Info boxes -->
    <!-- /.row -->
    <section class="content-header">
        <h2>
            My Quick Links
        </h2>
        <div class="box-body">
            <?php if(Session::exists('home')){ ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                    <?php echo Session::flash('home');?>                         </div>
                <?php  ?>
            <?php } elseif(Session::exists('error')){ ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    <?php echo Session::flash('error');  //echo  //$this->error;?>
                </div>
            <?php } ?>
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-spinner"></i> RateChats Digital!</h4>
                <p id="status">Now Trending - Class of 2017 - Join Now if you are graduating <a href="<?php echo(URL); ?>ratechat/start"><span class="">Click here</span></a> </p>

            </div>


        </div>
    </section>

    <div class="row">
    <div class="col-md-6">
        <!-- Horizontal Form -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Quick Compose: Direct Message</h3>
            </div>
            <form action="<?php echo(URL.'reg/contact_support'); ?>" method="post" >
                <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />
                <div class="box-body">
                    <div class="form-group">
                        <label for="send_to">Send to:</label>

                        <select class="form-control" name="send_to" id="send_to" required="required">
                            <?php if (Session::exists('send_to')){?>
                                <option value="<?php echo $flash= Session::flash('send_to'); ?>" selected="selected"><?php echo $flash; ?></option>
                            <?php }?>
                            <?php Person::support(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>

                        <input type="text" class="form-control" name="subject" id="subject" value="<?php if (Session::exists('subject')){ echo(Session::flash('subject')); } ?>">
                    </div>

                    <div class="form-group">
                        <label>Message</label>
                        <textarea id="message" name="message" class="form-control" placeholder="The Message in detail..." rows="8">
                            <?php if (Session::exists('message')){ echo(Session::flash('message')); } ?>

                        </textarea>
                    </div>




                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="yes" id="anonymous" name="anonymous"> Send as Anonymous
                            </label>
                        </div>

                    </div>


                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">

                        <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                    </div>
                    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>

                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!-- left column -->
        <div class="col-md-6">
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
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <!--/.col (right) -->
    </div>
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>