<?php
    include(View::webmaster_nav());
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Read Enquiry
        </h1>
        <ol class="breadcrumb">
            <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>
        </ol>
    </section>
    <?php
        $mod = $this->read;
    ?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <a href="<?php echo URL; ?>webmaster/enquiry/compose" class="btn btn-primary btn-block margin-bottom">Compose</a>

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
                <!-- /. box
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

                </div>-->
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Subject: <?php echo($mod['subject']); ?></h3>

                        <div class="box-tools pull-right">
                            <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                            <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body no-padding">
                        <div class="mailbox-read-info">
                            <h3>Sender: <?php echo($mod['name']); ?></h3>
                            <h4>Address: <?php echo($mod['address']); ?> </h4>
                            
                            <h5>Contact: <?php echo($mod['email'].' || ' .$mod['phone_no']); ?>

                                <span class="mailbox-read-time pull-right">
                    <?php
                        $date = new DateTime($mod['date']);
                        $today = $date->format('d F, Y');
						echo $today;
                    ?>
                                                                        <?php
                                                                            
                                                                        ?>
                                    </span></h5>
                        </div>
                        <!-- /.mailbox-read-info -->
                        <div class="mailbox-controls with-border text-center">
                            <div class="btn-group">
                                <a href="<?php echo URL; ?>webmaster/enquiry/delete/<?php echo $mod['enquiry_id']; ?>" onclick="return confirm('This will be permanently deleted. It cannot be undone. PROCEED?')" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete"> <i class="fa fa-trash-o"></i></a>
                                <a href="<?php echo URL; ?>webmaster/enquiry/reply/<?php echo $mod['enquiry_id']; ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply"> <i class="fa fa-reply"></i></a>
                                <a href="<?php echo URL; ?>webmaster/enquiry/forward/<?php echo $mod['enquiry_id']; ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward"> <i class="fa fa-share"></i></a>

                            </div>
                            <!-- /.btn-group -->
                            <button onclick="window.print();" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">
                                <i class="fa fa-print"></i></button>
                        </div>
                        <!-- /.mailbox-controls -->
                        <div class="mailbox-read-message">
                            <p><?php echo($mod['message']); ?></p>
                            
                            <br/>

                            
                        </div>
                        <!-- /.mailbox-read-message -->
                    </div>
                    <!-- /.box-body
                    <div class="box-footer">
                        <ul class="mailbox-attachments clearfix">
                            <li>
                                <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                                <div class="mailbox-attachment-info">
                                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> June 2016-report.pdf</a>
                        <span class="mailbox-attachment-size">
                          1,245 KB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                                </div>
                            </li>
                            <li>
                                <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>

                                <div class="mailbox-attachment-info">
                                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> App Description.docx</a>
                        <span class="mailbox-attachment-size">
                          1,245 KB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                                </div>
                            </li>
                            <li>
                                <span class="mailbox-attachment-icon has-img"><img src="<?php echo URL; ?>public/custom/img/photo1.png" alt="Attachment"></span>

                                <div class="mailbox-attachment-info">
                                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
                        <span class="mailbox-attachment-size">
                          2.67 MB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                                </div>
                            </li>
                            <li>
                                <span class="mailbox-attachment-icon has-img"><img src="<?php echo URL; ?>public/custom/img/photo2.png" alt="Attachment"></span>

                                <div class="mailbox-attachment-info">
                                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
                        <span class="mailbox-attachment-size">
                          1.9 MB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                                </div>
                            </li>
                        </ul>
                    </div>-->
                    <!-- /.box-footer -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="<?php echo URL; ?>webmaster/enquiry/reply/<?php echo $mod['enquiry_id']; ?>" class="btn btn-primary" title="Reply"> <i class="fa fa-reply"></i> Reply </a>
                            <a href="<?php echo URL; ?>webmaster/enquiry/forward/<?php echo $mod['enquiry_id']; ?>" class="btn btn-info" title="Forward"> <i class="fa fa-share"></i> Forward </a>
                        </div>
                        <a href="<?php echo URL; ?>webmaster/enquiry/delete/<?php echo $mod['enquiry_id']; ?>" onclick="return confirm('This will be permanently deleted. It cannot be undone. PROCEED?')" class="btn btn-danger" title="Delete"> <i class="fa fa-trash-o"></i> Delete </a>


                        <button onclick="window.print();" type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- Main Footer -->
<?php
    include(View::rightNav());
?>


