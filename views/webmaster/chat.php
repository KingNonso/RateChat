<?php
    include(View::webmaster_nav());
?>
<?php
    $user = new User();
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Direct Messages
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

                            <h3 class="box-title">Direct Message With Members </h3>
                        </div>
                    </div>

                </div>


                <div>
                <?php if($this->chat){
                    foreach($this->chat as $b){
                       ?>
                        <div class="col-md-6">
                            <!-- DIRECT CHAT PRIMARY -->
                            <div class="box box-primary direct-chat direct-chat-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo($b['subject']); ?> </h3>

                                    <div class="box-tools pull-right">

                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <!-- Conversations are loaded here -->
                                    <div class="direct-chat-messages">
                                        <!-- Message. Default to the left -->
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-info clearfix">
                                                <span class="direct-chat-name pull-left"><?php echo($b['author']); ?></span>
                                                <span class="direct-chat-timestamp pull-right"><?php echo($b['date']); ?></span>
                                            </div>
                                            <!-- /.direct-chat-info -->
                                            <img class="direct-chat-img" src="<?php echo(Session::get('logged_in_user_photo')); ?>" alt="<?php echo($b['author']); ?>"><!-- /.direct-chat-img -->


                                            <div class="direct-chat-text">
                                                <?php echo($b['message']); ?>
                                            </div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->




                                        <!-- /.direct-chat-msg -->
                                    </div>
                                    <!--/.direct-chat-messages-->

                                    <!-- Contacts are loaded here -->
                                    <!-- /.direct-chat-pane -->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <form action="#" method="post" onsubmit="return false;">
                                        <div class="input-group">
                                            <?php echo($b['send_to']); ?>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.box-footer-->
                            </div>
                            <!--/.direct-chat -->
                        </div>


                    <?php }} ?>

                <!-- /.col -->

                <!-- /.col -->

                <!-- /.col -->

                <!-- /.col -->

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