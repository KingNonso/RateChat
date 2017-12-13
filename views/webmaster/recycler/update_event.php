<?php
    include(View::webmaster_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                The Hostel Event's Calender
                <small>Webmaster Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


            </ol>


        </section>
<?php
    $mod = $this->about;
    $count = $this->count;
        ?>        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            <section class="content-header">
                <h2>
                    Update Event: <?php echo($mod['title']); ?>
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
                    <?php }
                    else{?>
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-info"></i> Alert!</h4>
                            Here is where you update the info
                        </div>
                    <?php } ?>

                </div>

            </section>

            <div class="row">
                <!-- left column -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">THE <?php echo($mod['title']); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <p>A couple of things you need to note about Adding New Events to Calendar</p>
                            <ul>
                                <li><strong>The Title:</strong>
                                    This must be a memorable, catchy phrase. </li>
                                <li><strong>The Description:</strong>
                                    Describe the event in full length. </li>
                                <li><strong>The Date & Time</strong>
                                    . </li>
                            </ul>



                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Improve this Description</button>
                        </div>
                    </div>
                    <!-- /.box -->


                </div>
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"> Update <?php echo($mod['title']); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'webmaster/add_event/'.$mod['id']); ?>" method="post">
                            <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title">Title</label>

                                    <input type="text" class="form-control" name="title" id="title" value=" <?php if (Session::exists('title')){ echo(Session::flash('title')); }else{ echo($mod['title']);} ?>">
                                </div>
                                <div class="form-group">
                                    <label>Event Description</label>
                                    <textarea id="description" name="description" class="form-control" placeholder="Brief Description...">
                                        <?php if (Session::exists('description')){ echo(Session::flash('description')); }else{ echo($mod["description"]);} ?>

                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="datepicker">Date</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datepicker" name="datepicker">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="timepicker">Time</label>

                                    <div class="input-group bootstrap-timepicker">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control timepicker pull-right" id="timepicker" name="timepicker">
                                    </div>
                                </div>
                            </div>

                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="<?php echo URL; ?>webmaster/event" class="btn btn-default pull-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->


                </div>
                <!--/.col (left) -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>