<?php
    include(View::webmaster_nav());
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Enquiry
            <small><?php
                    $new = ($this->new > 1)? $this->new : 'No';
                    echo $new;
                ?> new messages</small>
        </h1>
        <ol class="breadcrumb">
            <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <a href="<?php echo URL; ?>webmaster/enquiry" class="btn btn-primary btn-block margin-bottom">Back to Inbox</a>

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Folders</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a href="<?php echo URL; ?>webmaster/enquiry"><i class="fa fa-inbox"></i> Inbox
                                    <span class="label label-primary pull-right"><?php echo ($this->count); ?></span></a></li>
                            <li><a href="<?php echo URL; ?>webmaster/enquiry/sent"><i class="fa fa-envelope-o"></i> Sent</a></li>

                            <!--<li><a href="<?php echo URL; ?>webmaster/enquiry/drafts"><i class="fa fa-file-text-o"></i> Drafts</a></li>
                            <li><a href="#"><i class="fa fa-filter"></i> Junk <span class="label label-warning pull-right">65</span></a>
                            </li>
                            <li><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
                             -->

                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Labels</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#"><i class="fa fa-circle-o text-red"></i> Important</a></li>
                            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> Promotions</a></li>
                            <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Social</a></li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Compose Message</h3>
                    </div>
                    <?php
                        $mod = isset($this->read) ? $this->read: null;
                        $action = isset($this->action) ? (($this->action == 'reply')? 'RE: ': 'FWD: ') : null;
                    ?>
                    <!-- /.box-header -->
                    <form id="form1" name="form1" method="post" action="<?php echo URL; ?>enquiry_actions/<?php echo $this->action; ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <input class="form-control" placeholder="To:" value="<?php if($action === 'RE: ') echo($mod['email']); ?>" name="to" id="to">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Subject:" value="<?php if($mod['subject']) echo($action.' '.$mod['subject']); ?>" name="subject" id="subject">
                            </div>
                            <div class="form-group">

                                <textarea id="compose-textarea" class="form-control" name="msg" style="height: 300px" placeholder="Enter your message here">
                                    <?php if($mod['subject']) {  ?>
                                        Enter message here:

                                        <br/>
                                        <br/>
                                        <br/>
                                        <h4><u>Sender: <?php echo($mod['name']); ?> wrote:</u></h4>
                                        <p><?php echo($mod['message']); ?></p>
                                        <hr/>
                                    <?php  }  ?>

                                </textarea>
                            </div>
                            <!--
                                                   <div class="form-group">
                                <div class="btn btn-default btn-file">
                                    <i class="fa fa-paperclip"></i> Attachment
                                    <input type="file" name="attachment">
                                </div>
                                <p class="help-block">Max. 32MB</p>
                            </div>

                             -->

                        </div>
                        <div class="box-footer">
                            <div class="pull-right">

                                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                            </div>
                            <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                        </div>
                    </form>
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>


