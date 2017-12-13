<?php
    include(View::webmaster_nav());
    $set = $this->settings;
?>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Hostel
            <small>System Setting</small>
        </h1>
        <ol class="breadcrumb">
            <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>

        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
    <div class="col-xs-12">
    <div class="box">
    <div class="box-header">
        <h3 class="box-title">Details of Hostel </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form class="form-horizontal" action="<?php echo(URL.'admin/run_settings'); ?>" method="post">
            <div class="form-group">
                <label for="site_name" class="col-sm-2 control-label">Site Name</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="site_name" name="site_name" placeholder="What's the Name" value="<?php echo $set['site_name']; ?>">
                    <p class="help-block">This is the name of the site, that appear everywhere. Limited to 30 characters</p>

                </div>
            </div>
            <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />
            <div class="form-group">
                <label for="tagline" class="col-sm-2 control-label">Tagline</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" name="tagline" id="tagline" placeholder="tagline" value="<?php echo $set['tagline']; ?>">
                    <p class="help-block">In a few words, explain what this site is about. Limited to 60 characters</p>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">E-mail Address</label>

                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" id="email" placeholder="email" value="<?php echo $set['email']; ?>">
                    <p class="help-block">This email address is used for admin purposes, like new comment notification, etc.</p>

                </div>
            </div>
            <div class="form-group">
                <label for="about" class="col-sm-2 control-label">About</label>

                <div class="col-sm-10">
                    <textarea class="form-control" id="about" name="about" placeholder="What are the vital keys we should know about this site? Vision? Mission? Why should people visit you?" rows="15"><?php echo $set['about']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- /.box -->
    </div>
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