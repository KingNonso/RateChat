<?php
    include(View::webmaster_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Assign Hostel Manager to Hostel
                <small>Webmaster Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


            </ol>


        </section>

        <!-- Main content -->
        <section class="content">
            <section class="content-header">
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
                            Search by entering user's email, for results to be shown on the right side.
                        </div>
                    <?php } ?>

                </div>


            </section>

            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">THE Hostel Manager</h3>
                            </div>
                            <!-- /.box-header -->
                            <form action="<?php echo(URL.'webmaster/clearance'); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                                <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />

                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="type">Search for</label>
                                        <input class="form-control" required type="text" name="description" id="description" onkeyup="Search(this.value);"  value="<?php if (Session::exists('description')){ echo(Session::flash('description')); } ?>">

                                    </div>



                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>

                            <!-- form start -->
                            <!-- /.box-body -->

                        </div>
                        <!-- /.box -->


                    </div>
                    <div class="col-md-9 col-sm-12 col-xs-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Search Results</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th colspan="2">Account Details</th>
                                        <th colspan="2">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if(isset($this->people)){
                                        foreach($this->people as $mod){
                                            ?>
                                            <tr>
                                                <td><?php echo($mod['email']); ?></td>
                                                <td><?php echo $mod['phone_number'];  ?></td>
                                                <td><?php echo $mod['hostel_name'];  ?></td>
                                                <td><?php echo $mod['management'];  ?></td>


                                                <?php
                                                    if($mod['verified'] == 1){
                                                        ?>
                                                        <td><a href="<?php echo URL; ?>webmaster/manager/<?php echo $mod['user_id']; ?>" onclick="return confirm('This will Activate This Account. PROCEED?')" class="btn btn-success btn-flat">Activate </a></td>
                                                    <?php
                                                    }else{
                                                        ?>
                                                        <td><a href="<?php echo URL; ?>webmaster/clearance/deactivate/<?php echo $mod['user_id']; ?>" onclick="return confirm('This will Deactivate This Account. PROCEED?')" class="btn btn-danger btn-flat">Deactivate </a></td>
                                                    <?php
                                                    }
                                                ?>
                                                <td><a href="<?php echo URL; ?>webmaster/clearance/register/<?php echo $mod['id']; ?>" onclick="return confirm('This will Register the details associated with This Account, For the given Academic Term/Session. PROCEED?')" class="btn btn-primary btn-flat">View </a></td>
                                            </tr>
                                        <?php } } ?>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th colspan="2">Account Details</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- form start -->
                        </div>
                        <!-- /.box -->


                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </section>
            <!-- Your Page Content Here -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>