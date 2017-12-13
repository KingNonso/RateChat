<?php
    include(View::dashBar());
    $max = 2000 * 1024; //500kb

?>
<!-- Content Wrapper. Contains page content -->
<section class="content-header">
    <h1>
        Rate
    </h1>
    <ol class="breadcrumb">
        <p style="color:#f36c36"><i class="fa fa-dashboard"></i> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


    </ol></section>

<!-- Main content -->
<section class="content">

    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <?php if(Session::get('user_perms_id') > 1){  ?>
                    <a href="<?php echo (URL.'ratechat/create'); ?>" class="btn bg-orange-active btn-block margin-bottom">Create New</a>
                <?php }  ?>

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">View</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <?php if(isset($this->rate_list)){  ?>
                        <div class="box-body no-padding">
                            <ul class="nav nav-pills nav-stacked">
                                <?php foreach($this->rate_list as $r){  ?>

                                    <li><a href="<?php echo(URL.'ratechat/answers/'.$r['id']);  ?>"><i class="fa <?php echo($r['seen']);  ?>"></i> <?php echo($r['name']);  ?>
                                            <span class="label label-warning pull-right"><?php echo($r['count']);  ?></span></a></li>
                                <?php } ?>

                            </ul>
                        </div>

                    <?php }  ?>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
                <?php if(isset($this->my_list)){  ?>
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Review</h3>

                            <div class="box-tools">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="box-body no-padding">
                            <ul class="nav nav-pills nav-stacked">
                                <?php foreach($this->my_list as $r){  ?>
                                    <li><a href="<?php echo(URL.'ratechat/responses/'.$r['id']);  ?>"><i class="fa <?php echo($r['seen']);  ?> text-red"></i> <?php echo($r['name']);  ?></a></li>
                                <?php } ?>

                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <?php  ?>
                    <?php  ?>
                <?php }  ?>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="row">
                    <div class="col-sm-12 register-box-body">

                        <div class="box-body">
                            <?php if (Session::exists('home')) { ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                                    <?php echo Session::flash('home'); ?>                         </div>
                                <?php ?>
                            <?php } elseif (Session::exists('error')) { ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    <?php echo Session::flash('error');  //echo  //$this->error;?>
                                </div>
                            <?php } else {
                                ?>
                                <div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-info"></i> Note</h4>
                                    <p id="status">Please respond frankly to the best of your knowledge</p>

                                </div>
                            <?php } ?>

                        </div>
                        <h3 class="error-code text-center">Rated Responses </h3>
                        <p>There are two responses that would be required of you </p>
                        <ol>
                            <li><strong>Star Rated: </strong> See what's up for review, Rate by clicking on the appropriate star level that you find satisfactory, and you may leave a small comment behind</li>
                            <li><strong>Vote Rated: </strong> Here, we are trying to compare two or more things. You have one chance to help us decide which is the best. </li>
                        </ol>
                        <h4 class="pull-right">Thanks for you time</h4>

                    </div>

                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- row -->
        <!-- /.row -->

        <!-- /.row -->

    </section>
    <!-- /.content -->

</section>
<!-- /.content -->
</div>  <!-- /.content-wrapper -->

<?php
    include(View::rightNav());
?>

















