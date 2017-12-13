<?php
    include(View::NavBar());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Plans
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


        </ol>
        <div class="row">
            <div class="col-sm-12">

                <?php if(Session::exists('home')){ ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Info!</h4>
                        <?php echo Session::flash('home');?>                         </div>
                    <?php  ?>
                <?php } if(Session::exists('error')){ ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <?php echo Session::flash('error');  //echo  //$this->error;?>
                    </div>
                <?php } ?>

            </div>
        </div>

    </section>

    <!-- Main content -->
    <section class="content">
        <section class="content">

            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-primary">
                        <div class="box-header ">

                            <h3 class="box-title">Currently Available Plans </h3>
                        </div>
                    </div>

                </div>

                <?php
                    foreach($this->packages as $pack){ ?>
                        <div class="col-sm-3">
                            <div class="panel panel-primary text-center">
                                <div class="panel-heading">
                                    <h1><?php echo($pack['package']);  ?></h1>
                                </div>
                                <div class="panel-body">
                                    <p><strong><?php echo number_format($pack['amount_in_naira']);  ?></strong> Naira</p>


                                    <p><strong>2:1 </strong> Matrix</p>
                                    <p><strong>Auto </strong> Assign</p>
                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-flat btn-success" type="reset">Active</button>

                                </div>
                            </div>
                        </div>

                    <?php }?>
                <div class="col-sm-3">
                    <div class="panel panel-primary text-center">
                        <div class="panel-heading">
                            <h1>Add New</h1>
                        </div>
                        <div class="panel-body">
                            <p><strong>Must be Greater than the former</strong> Naira</p>


                            <p><strong>2:1 </strong> Matrix</p>
                            <p><strong>Auto </strong> Assign</p>
                        </div>
                        <div class="panel-footer">
                            <a href="<?php echo(URL.'admin/add_new_plan/');  ?>" class="btn btn-flat btn-primary">Create</a>

                        </div>
                    </div>
                </div>

            </div>

        </section>
        <!-- Your Page Content Here -->

    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>