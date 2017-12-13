<?php
    include(View::NavBar());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Portfolio
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
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Cash In</span>
                        <span class="info-box-number"><?php echo ($this->portfolio[0]);  ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Cash Out</span>
                        <span class="info-box-number"><?php echo ($this->portfolio[1]);  ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <!-- /.col -->
            <!-- /.col -->
        </div>

        <div class="row">
                <div class="col-md-6">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <i class="fa fa-heart"></i>

                            <h3 class="box-title">Alerts</h3>
                        </div>
                        <?php if(isset($this->payables)){ ?>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <?php
                                foreach($this->payables as $pack){
                                    ?>
        <div class="callout callout">

                                <h4><i class="icon fa fa-heart"></i> <?php echo($pack['fullname'].' - '.number_format($pack['amount']));  ?></h4>

                                <p>Plan: <strong> <?php echo ($pack['plan']);  ?></strong> </p>
                                <p>Bank: <strong> <?php echo ($pack['bank']);  ?></strong> </p>
                                <p>Account Name: <strong><?php echo ($pack['account_name']);  ?></strong> </p>
                                <p>Account Number: <strong><?php echo ($pack['account_no']);  ?></strong> </p>
                                <p>Phone: <strong><?php echo ($pack['phone_number']);  ?> </strong> </p>
                                <p>Address: <strong><?php echo ($pack['home_address']);  ?> </strong> </p>

        <?php if(!empty($pack['payer_confirm'])){ ?>
            <p>TRANSACTION CONFIRMED</p>

        <?php }else{ ?>
            <p> Time Left: <?php echo (($pack['time_left']));  ?> </p>
            <p>If you can't make payments</p>
            <form action="<?php echo(URL.'admin/purge_self/'.$pack['merge']);  ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
                <div class="">
                    <input type="hidden" name="plan_id" id="plan_id" value="<?php echo (($pack['plan_id']));  ?>" />
                    <input type="hidden" name="payer" id="payer" value="<?php echo (($pack['payer']));  ?>" />
                    <button type="submit" ONCLICK="return confirm('If you can\'t make payments... Then Proceed ')" class="btn btn-danger btn-sm">Can't Pay</button>
                </div>
            </form>
        <?php } ?>
            </div>
    <?php }?>

                        </div>
                        <?php } ?>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->

                <div class="col-md-6">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <i class="fa fa-bullhorn"></i>

                            <h3 class="box-title">Callouts</h3>
                        </div>
                        <!-- /.box-header -->
                        <?php if(isset($this->receivables)){ ?>
                        <div class="box-body">
                            <?php
                                foreach($this->receivables as $pack){ ?>
                                    <div class="callout callout">

                                        <h4><i class="icon fa fa-heart"></i> <?php echo($pack['fullname'].' - '.number_format($pack['amount']));  ?></h4>

                                        <p>Plan: <strong> <?php echo ($pack['plan']);  ?></strong> </p>
                                        <p>Phone: <strong><?php echo ($pack['phone_number']);  ?> </strong> </p>
                                        <p>Address: <strong><?php echo ($pack['home_address']);  ?> </strong> </p>

                                        <p> <?php echo number_format(($pack['amount']));  ?> Naira</p>

                                        <?php if(!empty($pack['payer_confirm'])){ ?>
                                            <p>TRANSACTION CONFIRMED</p>

                                        <?php }else{ ?>

                                            <p> Time Left: <?php echo (($pack['time_left']));  ?> </p>

                                            <?php if(($pack['payer']) ){ ?>

                                                <form action="<?php echo(URL.'admin/confirm_payment/'.$pack['db_row']);  ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                                    <div class="">
                                                        <input type="hidden" name="plan_id" id="plan_id" value="<?php echo (($pack['plan_id']));  ?>" />
                                                        <input type="hidden" name="payer" id="payer" value="<?php echo (($pack['payer']));  ?>" />
                                                        <button type="submit" class="btn btn-flat btn-primary">CONFIRM PAYMENT</button>
                                                    </div>
                                                </form>
                                            <?php } ?>
                                            <?php if(($pack['payer']) ){ ?>
                                            <!--
                                            <form action="<?php echo(URL.'admin/purge/'.$pack['merge']);  ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                                    <div class="">
                                                        <input type="hidden" name="plan_id" id="plan_id" value="<?php echo (($pack['plan_id']));  ?>" />
                                                        <input type="hidden" name="payer" id="payer" value="<?php echo (($pack['payer']));  ?>" />
                                                        <br/>
                                                        <button type="submit" ONCLICK="return confirm('This cannot be undone! Please be careful and play fair. ')" class="btn btn-flat btn-danger">Report</button>
                                                    </div>
                                                </form>
                                            -->

                                                
                                            <?php }else{ ?>
                                                <p>Please wait while someone will be matched to pay you. Thanks</p>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>

                                <?php }?>



                        </div>
                        <!-- /.box-body -->
<?php } ?>
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
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