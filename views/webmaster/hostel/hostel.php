<?php
    include(View::webmaster_nav());

?>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Hostels' <small>Control panel</small></h1>
        <ol class="breadcrumb">
            <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
    <div class="col-xs-12">
<?php if(Session::exists('home')){ ?>
    <div class="box box-success">
    <div class="box-header ">
            <h3 class="box-title"><?php echo Session::flash('home');?> </h3>
    </div>
    </div>

<?php } elseif(Session::exists('error')){ ?>
        <div class="box box-danger">
            <div class="box-header ">

            <h3 class="box-title"><?php echo Session::flash('error');?> </h3>
            </div>
        </div>

<?php }else{?>
        <div class="box box-primary">
            <div class="box-header ">

            <h3 class="box-title">Select From Existing</h3>
            </div>
        </div>
<?php }?>

    </div>

    <div class="col-md-12">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <div class="list-group">
                    <?php if(isset($this->hostel)){
                        foreach($this->hostel as $h){ ?>

                            <a href="<?php echo(URL.'webmaster/management/'.$h['hostel_id']); ?>" class="list-group-item">
                                <h4 class="list-group-item-heading"><?php echo($h['hostel']); ?></h4>
                                <p class="list-group-item-text"><?php echo($h['address']);  ?></p>
                            </a>


                    <?php }}  ?>
                 </div>


            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        <!-- /.box -->
    </div>
    <!-- /.col -->
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