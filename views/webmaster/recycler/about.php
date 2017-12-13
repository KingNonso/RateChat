<?php
    include(View::webmaster_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                About The Hostel
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
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Showing all </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Titles</th>
                                        <th>Position</th>
                                        <th>Visible</th>
                                        <th>Date</th>
                                        <th colspan="3">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach($this->about as $mod){
                                            ?>
                                            <tr>
                                                <td><?php echo($mod['menu_name']); ?></td>
                                                <td><?php echo $mod['position'];  ?></td>
                                                <td><?php $echo = ($mod['visible'] == 1)? 'Yes': 'No'; echo $echo;  ?></td>
                                                <?php
                                                    $date = new DateTime($mod['date']);
                                                    $dob = $date->format('d M, Y ');//h:i a
                                                ?>
                                                <td><?php echo($dob); ?>
                                                </td>
                                                <td><a href="<?php echo URL; ?>webmaster/about/update/<?php echo $mod['id']; ?>" class="btn btn-success btn-flat">Update</a></td>
                                                <?php if($mod['visible'] == 1){ ?>
                                                    <td><a href="<?php echo URL; ?>webmaster/about/hide/<?php echo $mod['id']; ?>" class="btn btn-warning btn-flat">Hide</a></td>
                                                <?php } else{ ?>
                                                    <td><a href="<?php echo URL; ?>webmaster/about/show/<?php echo $mod['id']; ?>" class="btn btn-info btn-flat">Show</a></td>
                                                    <?php } ?>



                                                <td><a href="<?php echo URL; ?>webmaster/about/delete/<?php echo $mod['id']; ?>" onclick="return confirm('This will be permanently deleted. It cannot be undone. PROCEED?')" class="btn btn-danger btn-flat">Delete </a></td>

                                            </tr>
                                        <?php }  ?>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Titles</th>
                                        <th>Position</th>
                                        <th>Visible</th>
                                        <th>Date</th>
                                        <th colspan="3">Actions</th>
                                    </tr>
                                    </tfoot>
                                </table>
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
            <!-- Your Page Content Here -->
            <section class="content-header">
                <h2>
                    Write About The Hostel
                </h2>
                <div class="box-body">
                    <?php if(Session::exists('home')){ ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-check"></i> Alert!</h4>
                            <?php echo Session::flash('home');?>                         </div>
                    <?php  ?>
                    <?php } elseif(Session::exists('error')){ ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php echo Session::flash('error');  //echo  //$this->error;?>
                        </div>
                    <?php }
                    else{?>
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-info"></i> Alert!</h4>
                            Here is where you enter new info
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
                            <h3 class="box-title">THE About</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <p>When you wish to write about the hostel, there are a couple of things you need to note.</p>
                            <ul>
                                <li><strong>The Position:</strong> Anything with position one is what appears first in the display. The position 1, is also unique as it shows up on the home page also. The position shows the hierarchy of how it would be displayed to the user. </li>
                                <li><strong>The Visibility:</strong> Anything with Visibility equals to one will be shown, while Visibility equals to zero(0) will be hidden. This is useful if you just want to hide and not delete a particular content. </li>
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
                            <h3 class="box-title"> Write the About</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'webmaster/add_about'); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="subject">Subject (Title or Heading)</label>
                                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter  Title ..." value="<?php if (Session::exists('subject')){ echo(Session::flash('subject')); } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <p class="help-block">Select the Position, you want it to appear.</p>
                                    <select class="form-control" name="position" id="position">
                                        <?php
                                            $page_count = count($this->about);
                                            $page_count++;
                                        ?>

                                        <?php for ($count = 1; $count <= $page_count; $count++){?>
                                            <option value="<?php echo $count; ?>" <?php if (Session::flash('position') == $count ){echo "selected=\"selected\"";} elseif($page_count === $count){ echo "selected=\"selected\""; } ?> ><?php echo $count ; ?></option>


                                        <?php }  ?>




                                    </select>
                                </div>
                                <div class="form-group">
                                    <p>Visible:
                                        <label>
                                            <input name="visible" type="radio" id="visible_0" value="0" <?php if (Session::exists('visible') && Session::flash('visible') === 0){ echo("checked=\"checked\""); } ?> />
                                            No</label>
                                        &nbsp;
                                        <label>
                                            <input type="radio" name="visible" value="1" id="visible_1" <?php if (Session::exists('visible') && Session::flash('visible') === 1){ echo("checked=\"checked\""); } ?> />
                                            Yes</label>
                                    </p>




                                </div>

                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea class="form-control textarea" rows="8" placeholder="Enter content here ..." id="content" name="content">
                                        <?php if (Session::exists('content')){ echo(Session::flash('content')); } ?>
                                    </textarea>
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