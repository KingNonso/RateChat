<?php
    include(View::NavBar());

?>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          All Phone Numbers with Nigeria Code Prefixed
            <small>Control panel</small>
        </h1>
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

            <h3 class="box-title">Send a Message to all Members  </h3>
            </div>
        </div>
<?php }?>

    </div>

    <div class="col-md-12">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <?php if($this->numbers){
                    echo($this->numbers); ?>
                    <?php } ?>
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