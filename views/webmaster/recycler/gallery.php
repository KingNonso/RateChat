<?php
include(View::webmaster_nav());
?>
<?php
$user = new User();
$max = 500 * 1024; //50kb
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            The Hostel Photo Gallery
            <small>Webmaster Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


        </ol>


    </section>

    <!-- Main content -->
    <section class="content">
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    if (isset($this->perform_update)) {
                        ?>
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-info"></i> Alert!</h4>
                            Task Has been loaded below
                        </div>
                    <?php } ?>

                    <div class="box">
                        <?php
                        if (!$this->gallery) {
                            ?>
                            <div class="box-header">
                                <h3 class="box-title">Nothing to Display </h3>
                            </div>
                        <?php
                        } else {
                            ?>
                            <div class="box-header">
                                <h3 class="box-title">Showing all </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th colspan="2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($this->gallery as $image) {
                                            ?>
                                            <tr>
                                                <td><?php echo($image['image']); ?></td>
                                                <td><?php echo($image['head']); ?></td>
                                                <td><?php echo $image['description']; ?></td>
                                                <?php
                                                $date = new DateTime($image['date']);
                                                $dob = $date->format('d M, Y '); //h:i a
                                                ?>
                                                <td><?php echo($dob); ?>
                                                </td>
                                                <td><a href="<?php echo URL; ?>webmaster/gallery/update/<?php echo $image['id']; ?>" class="btn btn-success btn-flat">Update</a></td>

                                                <td><a href="<?php echo URL; ?>webmaster/gallery/delete/<?php echo $image['id']; ?>" onclick="return confirm('This will be permanently deleted. It cannot be undone. PROCEED?')" class="btn btn-danger btn-flat">Delete </a></td>

                                            </tr>
                                        <?php } ?>


                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th colspan="2">Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        <?php } ?>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- Your Page Content Here -->
        <section class="content-header">
            <h2>
                Add To Hostel Photo Gallery
            </h2>
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
                        <h4><i class="icon fa fa-info"></i> Alert!</h4>
                        Here is where you enter the info
                    </div>
                <?php } ?>

            </div>


        </section>

        <div class="row">
            <!-- left column -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">THE Photo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <p>When you wish to add to the hostel Photo, there are a couple of things you need to note.</p>
                        <ul>
                            <li><strong>The Image:</strong>
                                Just upload a single picture, ensure it is of a high resolution. </li>
                            <li><strong>The Title:</strong>
                                This is the header, usually appears in bold. </li>
                            <li><strong>The Image Description:</strong>
                                Tell everyone about the image, what it means and what it symbolizes. </li>
                        </ul>



                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Improve this Description</button>
                    </div>
                </div>
                <!-- /.box -->


            </div>
            <div class="col-md-9 col-sm-12 col-xs-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"> Gallery</h3>
                    </div>
                    <!-- /.box-header -->
                    <?php
                    if (isset($this->about)) {
                        $update = $this->about;
                        $count = $this->count;
                    }
                    ?>
                    <!-- form start -->
                    <form action="<?php echo(URL . 'webmaster/add_gallery'); ?><?php if (isset($update['id'])) {
                        echo('/' . $update['id']);
                    } ?>" method="post" id="contact_form" enctype="multipart/form-data" class="form-horizontal">
                        <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />
                        <input type="hidden" name="previous_upload" id="previous_upload" value="<?php if (Session::exists('previous_upload')) {
                        echo(Session::flash('previous_upload'));
                    } elseif (isset($update['image'])) {
                        echo($update['image']);
                    } ?>" />

                        <div class="box-body">
                            <div class="form-group">
                                <label for="filename" class="col-sm-2 control-label">Picture</label>

                                <div class="col-sm-10">
                                    <input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?php echo $max; ?>" />
                                    <input type="file" name="filename" id="filename"
                                           data-maxfiles="<?php echo $_SESSION['maxfiles']; ?>"
                                           data-postmax="<?php echo $_SESSION['postmax']; ?>"
                                           data-displaymax="<?php echo $_SESSION['displaymax']; ?>"
                                           />

                                    <p id="status" class="help-block">Upload file should be no more than <?php echo Upload::convertFromBytes($max); ?>.</p>
                                    <p id="output" class="help-block"></p>


                                </div>
                            </div>
                            <div class="form-group">
                                <label for="head" class="col-sm-2 control-label">Title</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="head" name="head" placeholder="Image Title" value="<?php if (Session::exists('head')) {
                        echo(Session::flash('head'));
                    } elseif (isset($update['head'])) {
                        echo($update['head']);
                    } ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>

                                <div class="col-sm-10">
                                    <textarea class="form-control" id="description" name="description" placeholder="Image Description">
<?php if (Session::exists('description')) {
    echo(Session::flash('description'));
} elseif (isset($update['description'])) {
    echo($update['description']);
} ?>
                                    </textarea>
                                </div>
                            </div>


                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->


            </div>
            <!--/.col (left) -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
include(View::rightNav());
?>