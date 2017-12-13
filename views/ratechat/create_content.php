<?php
    include(View::dashBar());
    $max = 2000 * 1024; //500kb

?>
    <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <section class="content">

        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">

            <!-- row -->
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 register-box-body">
                    <h3 class="error-code text-center">Create Content for Rating</h3>

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
                                <h4><i class="icon fa fa-info"></i> Now Trending!</h4>
                                <p id="status"> To Nominate a particular person, ask them for their Person ID</p>

                            </div>
                        <?php } ?>

                    </div>
                    <form action="<?php echo(URL.'ratechat/create_rate_content'); ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label for="name">Item Name:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-star"></i> </span>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="What name would you call this new content?" required>
                                </div>

                            </div>
                            <div class="col-sm-12 form-group">
                                <label for="description">Item Description: </label>

                                <textarea class="form-control" name="description" id="description"></textarea>

                            </div>
                            <div class="col-sm-12 form-group">
                                <label for="content_type">Item Image </label>

                                <input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?php echo $max; ?>" />
                                <input type="file" name="filename" id="filename"
                                       data-maxfiles="<?php echo $_SESSION['maxfiles']; ?>"
                                       data-postmax="<?php echo $_SESSION['postmax']; ?>"
                                       data-displaymax="<?php echo $_SESSION['displaymax']; ?>"
                                       />

                                <p id="status" class="help-block">Upload file should be no more than <?php echo Upload::convertFromBytes($max);?>.</p>
                                <p id="output" class="help-block"></p>



                            </div>
                            <div class="col-sm-12 form-group">
                                <div class="row">
                                    <div class="col-xs-8">
                                        <!-- <label>
                                            <input type="checkbox" required="required"> I am voting for this person
                                        </label> -->
                                    </div>

                                    <div class="col-xs-4">
                                        <button type="submit" class="btn btn-success btn-block btn-flat"> Create New </button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </div>
                            <div class="social-auth-links text-center">
                                <p>- OR -</p>

                                <a href="<?php echo(URL.'ratechat/publish_rate'); ?>" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-power-off"></i> I have finished creating Items for this category </a>



                            </div>



                        </div>


                    </form>


                </div>

            </div>
            <!-- /.row -->

            <!-- /.row -->

        </section>
        <!-- /.content -->

    </section>
    <!-- /.content -->
    </div>  <!-- /.content-wrapper -->

<div class="container">

    <!-- Modal -->
    <div class="modal fade" id="find_student_reg_no" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Retrieve Details </h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo(URL.'login/login'); ?>" method="post" onsubmit="return false;">

                        <div class="row">


                            <div class="col-sm-12 form-group">
                                <label for="find_name">Select Name </label>
                                <select class="form-control" name="find_name" id="find_name" onchange="retrieve_reg_no('my_class',1)">
                                    <option value="0">Choose</option>
                                    <?php foreach($this->everyone as $e){  ?>
                                        <option value="<?php echo($e['id']);  ?>"><?php echo($e['name']);  ?></option>

                                    <?php }  ?>

                                </select>
                            </div>


                            <div class="col-sm-12 form-group" id="submit">
                                <h2 id="ur_reg_no" class="text-danger"></h2>
                                <input type="hidden" id="found_reg_no">
                                <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="insert_found()">Insert User ID</button>
                            </div>

                        </div>


                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

</div>
<?php
    include(View::rightNav());
?>

