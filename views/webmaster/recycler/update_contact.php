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
<?php
    $mod = $this->about;
    $count = $this->count;
        ?>        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            <section class="content-header">
                <h2>
                    Update Contact Type: <?php echo($mod['type']); ?>
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
                            <h3 class="box-title">THE <?php echo($mod['type']); ?></h3>
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
                            <h3 class="box-title"> Update <?php echo($mod['type']); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'webmaster/add_contact/'.$mod['id']); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="type">Type</label>

                                    <select class="form-control" name="type" id="type">
                                        <?php
                                            $flash= (Session::exists('type'))? Session::flash('type') : $mod['type'] ;
                                            if ($flash){?>
                                            <option value="<?php echo $flash; ?>" selected="selected"><?php echo ($flash); ?></option>
                                        <?php } ?>
                                        <option value="Phone" >Phone</option>
                                        <option value="Address" >Address</option>
                                        <option value="Route" >Route</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Details</label>
                                    <textarea class="form-control textarea" rows="8" placeholder="Enter content here ..." id="details" name="details">
                                        <?php if (Session::exists('details')){ echo(Session::flash('details')); }else{ echo($mod['details']);} ?>
                                    </textarea>
                                </div>


                            </div>

                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="<?php echo URL; ?>webmaster/about" class="btn btn-default pull-right">Cancel</a>
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