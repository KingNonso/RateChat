<?php
    include(View::webmaster_nav());

?>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          Message Broadcast
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
                <form class="form" role="form" action="<?php echo(URL.'webmaster/broadcast'); ?>" method="post">
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea class="form-control" rows="5" id="message" name="message"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Send</button>
                    </div>
                </form>

            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-success">
            <div class="box-header ">
                <h3 class="box-title">All Messages  </h3>
            </div>

            <div class="box-body chat" id="chat-box">
                <!-- chat item -->
                <?php if($this->broadcast){
                    foreach($this->broadcast as $b){ ?>
                <div class="item">
                    <img src="<?php echo(URL.'public/images/avatar.jpg'); ?>" alt="user image" class="online">

                    <p class="message">
                        <a href="#" class="name">
                            <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo($b->date); ?></small>
                            Support
                        </a>
                        <?php echo($b->message); ?>
                    </p>
                </div>
                <?php }} ?>
            </div>            <!-- /.box-body -->
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