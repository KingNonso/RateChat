<?php
    include(View::webmaster_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                The Hostel Contact Information
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
                                        <th>Type</th>
                                        <th>Details</th>
                                        <th>Date</th>
                                        <th colspan="2">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach($this->about as $mod){
                                            ?>
                                            <tr>
                                                <td><?php echo($mod['type']); ?></td>
                                                <td><?php echo $mod['details'];  ?></td>
                                                <?php
                                                    $date = new DateTime($mod['date']);
                                                    $dob = $date->format('d M, Y ');//h:i a
                                                ?>
                                                <td><?php echo($dob); ?>
                                                </td>
                                                <td><a href="<?php echo URL; ?>webmaster/contact/update/<?php echo $mod['id']; ?>" class="btn btn-success btn-flat">Update</a></td>

                                                <td><a href="<?php echo URL; ?>webmaster/contact/delete/<?php echo $mod['id']; ?>" onclick="return confirm('This will be permanently deleted. It cannot be undone. PROCEED?')" class="btn btn-danger btn-flat">Delete </a></td>

                                            </tr>
                                        <?php }  ?>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Type</th>
                                        <th>Details</th>
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
                    Set The Hostel's Contact
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
                            <h3 class="box-title">THE Contact</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <p>When you wish to set the hostel contact, there are a couple of things you need to note.</p>
                            <ul>
                                <li><strong>The Phone:</strong>
                                    Just enter a single phone number per line and submit. </li>
                                <li><strong>The Address:</strong>
                                    Just enter a full address, if multiple addresses, enter one by one and submit. </li>
                                <li><strong>The Route:</strong>
                                    This denotes bus routes. Obviously it should describe the major landmarks or bus stops that the bus is likely to pass through. Also if the bus takes multiple routes, or you have multiple buses, there route should be entered one by one. </li>
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
                            <h3 class="box-title"> Add New Contact</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'webmaster/add_contact'); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="type">Type</label>

                                    <select class="form-control" name="type" id="type">
                                        <option value="Phone" >Phone</option>
                                        <option value="Address" >Address</option>
                                        <option value="Route" >Route</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Details</label>
                                    <textarea class="form-control textarea" rows="8" placeholder="Enter content here ..." id="details" name="details">
                                        <?php if (Session::exists('details')){ echo(Session::flash('details')); } ?>
                                    </textarea>
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