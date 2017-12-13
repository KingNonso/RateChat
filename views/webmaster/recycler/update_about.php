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
<?php
    $mod = $this->about;
    $count = $this->count;
        ?>        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            <section class="content-header">
                <h2>
                    Update About <?php echo($mod['menu_name']); ?>
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
                            Here is where you update the info
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
                            <h3 class="box-title">THE <?php echo($mod['menu_name']); ?></h3>
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
                            <h3 class="box-title"> Write <?php echo($mod['menu_name']); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'webmaster/add_about/'.$mod['id']); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="subject">Subject (Title or Heading)</label>
                                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter  Title ..." value="<?php if (Session::exists('subject')){ echo(Session::flash('subject')); }else{ echo($mod['menu_name']);} ?>">

                                </div>
                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <p class="help-block">Select the Position, you want it to appear.</p>
                                    <select class="form-control" name="position" id="position">
                                        <?php
                                            $page_count = $mod['position'];
                                            for ($i = 1; $i <= $count; $i++){
                                                echo "<option value=\"{$i}\"";
                                                if($page_count == $i){
                                                    echo " selected=\"selected\"";
                                                }
                                                echo ">{$i}</option>";
                                            }                                        ?>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <p>Visible:
                                        <label>
                                            <input name="visible" type="radio" id="visible_0" value="0" <?php
                                                if($mod['visible']== 0){
                                                    echo "checked=\"checked\"";
                                                } ?> />
                                            No</label>
                                        &nbsp;
                                        <label>
                                            <input type="radio" name="visible" value="1" id="visible_1" <?php
                                                if($mod['visible']== 1){
                                                    echo "checked=\"checked\"";
                                                } ?> />
                                            Yes</label>
                                    </p>




                                </div>

                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea class="form-control textarea" rows="8" placeholder="Enter content here ..." id="content" name="content">
                                        <?php if (Session::exists('content')){ echo(Session::flash('content')); }else{echo $mod['content'];} ?>
                                    </textarea>

                                </div>


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="<?php echo URL; ?>webmaster/about" class="btn btn-default pull-right">Cancel</a>
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