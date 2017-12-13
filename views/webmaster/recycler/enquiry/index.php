<?php
    include(View::webmaster_nav());
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Enquiries from the Hostel's site
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
                        <span class="label label-primary pull-right"><?php echo count($this->enquiry); ?></span></a></li>
                <li><a href="<?php echo URL; ?>webmaster/enquiry/sent"><i class="fa fa-envelope-o"></i> Sent</a></li>
                <!--                <li><a href="<?php echo URL; ?>webmaster/enquiry/drafts"><i class="fa fa-file-text-o"></i> Drafts</a></li>

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

    </div>
    -->
    <!-- /.box -->
</div>
<!-- /.col -->
<div class="col-md-9">
<div class="box box-primary">
<div class="box-header with-border">
    <h3 class="box-title">Inbox</h3>

    <div class="box-tools pull-right">
        <div class="has-feedback">
            <input type="text" class="form-control input-sm" placeholder="Search Mail">
            <span class="glyphicon glyphicon-search form-control-feedback"></span>
        </div>
    </div>
    <!-- /.box-tools -->
</div>
<!-- /.box-header -->
<div class="box-body no-padding">
    <div class="mailbox-controls">
        <!-- Check all button 
        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
        </button>
        <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
        </div>-->
        <!-- /.btn-group
        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
        <div class="pull-right">
            1-50/200
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
            </div> -->
            <!-- /.btn-group -->
        </div>
        <!-- /.pull-right -->
    </div>
    <div class="table-responsive mailbox-messages">
        <table class="table table-hover table-striped">
            <tbody>
            <?php
                foreach($this->enquiry as $mod){
            ?>
            <tr>
                <td><input type="checkbox"></td>
                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                
                    <td class="mailbox-name"><a href="<?php echo URL; ?>webmaster/enquiry/read/<?php echo ($mod['enquiry_id']); ?>"> <?php echo ($mod['name']); ?> </a></td>
                    <td class="mailbox-subject"><a href="<?php echo URL; ?>webmaster/enquiry/read/<?php echo ($mod['enquiry_id']); ?>"> <b><?php echo ($mod['subject']); ?> </b> - <?php echo limit_word($mod['message'],30); ?>
                    </a></td>
                <td class="mailbox-attachment">
                <?php if($mod['status'] == 'new'){ ?>
                <small class="label pull-right bg-yellow">new</small>
                <?php } ?><!--<i class="fa fa-paperclip"></i>--></td>
                <?php
                    $date = new DateTime($mod['date']);
                    $dob = $date->format('d M, Y ');//h:i a
                ?>
                <td class="mailbox-date"><?php echo($dob); ?></td>
            </tr>
                <?php }  ?>
            </tbody>
        </table>
        <!-- /.table -->
    </div>
    <!-- /.mail-box-messages -->
</div>
<!-- /.box-body -->
<div class="box-footer no-padding">
    <div class="mailbox-controls">
        <!-- Check all button -->
        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
        </button>
        <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
        </div>
        <!-- /.btn-group -->
        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
        <div class="pull-right">
            <!-- 1-50/200
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
            </div>-->
            <!-- /.btn-group -->
        </div>
        <!-- /.pull-right -->
    </div>
</div>
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


