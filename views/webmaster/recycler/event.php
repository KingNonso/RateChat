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

        <!-- Main content -->
        <section class="content">
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Showing all </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th colspan="2">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach($this->about as $mod){
                                            ?>
                                            <tr>
                                                <td><?php echo($mod['title']); ?></td>
                                                <td><?php echo $mod['description'];  ?></td>
                                                <?php
                                                    $date = new DateTime($mod['date']);
                                                    $dob = $date->format('d M, Y ');//h:i a
                                                ?>
                                                <td><?php echo($dob); ?> @ <?php echo $mod['time'];  ?>
                                                </td>
                                                <td><a href="<?php echo URL; ?>webmaster/event/update/<?php echo $mod['id']; ?>" class="btn btn-success btn-flat">Update</a></td>

                                                <td><a href="<?php echo URL; ?>webmaster/event/delete/<?php echo $mod['id']; ?>" onclick="return confirm('This will be permanently deleted. It cannot be undone. PROCEED?')" class="btn btn-danger btn-flat">Delete </a></td>

                                            </tr>
                                        <?php }  ?>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th colspan="2">Actions</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- Your Page Content Here -->
            <section class="content-header">
                <h2>
                    Add New Event to Calendar
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
                            Here is where you enter new info
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
                            <h3 class="box-title">THE Event Planner</h3>
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
                            <h3 class="box-title"> Add New Event</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'webmaster/add_event'); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title">Title</label>

                                    <input type="text" class="form-control" name="title" id="title" value=" <?php if (Session::exists('title')){ echo(Session::flash('title')); } ?>">                                </div>

                                <div class="form-group">
                                    <label>Event Description</label>
                                    <textarea id="description" name="description" class="form-control" placeholder="Brief Description...">
                                        <?php if (Session::exists('description')){ echo(Session::flash('description')); } ?>

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