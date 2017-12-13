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
            <div class="col-sm-10 col-sm-offset-1 register-box-body" id="vote_box">
                <h3 class="error-code text-center"> <?php if(isset($this->rate)){ echo($this->rate['name']);}  ?></h3>
                <p class="text-center"><strong>Acknowledge</strong> <?php if(isset($this->rate)){ echo($this->rate['description']);}  ?></p>

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
                            <h4><i class="icon fa fa-cube"></i>Description</h4>
                            <p id="status"> <?php if(isset($this->honour)){ echo($this->honour['description']);}  ?></p>

                        </div>
                    <?php } ?>

                </div>
                <form action="<?php echo(URL.'result/check'); ?>" method="post">
                    <div class="row text-center">
                        <?php
                            if(isset($this->content) && ($this->response)){
                                foreach($this->content as $p){
                                    if($this->response->for_id == $p->id){
                                    ?>
                                    <div class="col-sm-4">
                                        <div class="thumbnail">
                                            <img src="<?php echo URL; ?>public/uploads/ratechat/<?php echo $p->file_name; ?>" class="img-responsive img-thumbnail" height="215" width="215" alt="Image of <?php echo $p->name; ?>">

                                            <input type="hidden" id="nominee_id" name="nominee_id" value="<?php echo Session::get('encryption'); ?>">
                                            <input type="hidden" id="redirect_path" name="redirect_path" value="<?php echo URL.'ratechat/index'; ?>">
                                            <p><strong><?php echo $p->name; ?></strong></p>

<h4 class="text-purple">You have voted </h4>
                                        </div>
                                    </div>
                                <?php }}}  ?>
                        <?php
                            if(isset($this->content) && !($this->response)){
                                foreach($this->content as $p){
                                    ?>
                                    <div class="col-sm-4">
                                        <div class="thumbnail">
                                            <img src="<?php echo URL; ?>public/uploads/ratechat/<?php echo $p->file_name; ?>" class="img-responsive img-thumbnail" height="215" width="215" alt="Image of <?php echo $p->name; ?>">

                                            <input type="hidden" id="nominee_id" name="nominee_id" value="<?php echo Session::get('encryption'); ?>">
                                            <input type="hidden" id="redirect_path" name="redirect_path" value="<?php echo URL.'ratechat/index'; ?>">
                                            <p><strong><?php echo $p->name; ?></strong></p>

                                            <button type="button" class="btn btn-primary" onclick="voteCube(<?php echo $p->id; ?>,<?php echo $p->ratechat_id; ?>)">Vote </button>
                                        </div>
                                    </div>
                                <?php }}  ?>
                    </div>
                    <div class="row text-center">
                        <div class="col-sm-12" id="loaderIcon">
                            <img src="<?php echo URL; ?>public/images/LoaderIcon.gif" class="img-responsive" alt="Processing Request">
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
                    <h4 class="modal-title">Retrieve Student ID </h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo(URL.'login/login'); ?>" method="post" onsubmit="return false;">

                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label for="find_session">Year of Grad</label>
                                <select class="form-control" name="find_session" id="find_session" required="required" onchange="retrieve_reg_no('class',1)">

                                    <?php echo($this->grad); ?>
                                </select>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label for="find_session">Academic Faculty</label>
                                <select class="form-control" name="find_session" id="find_session" required="required" onchange="retrieve_reg_no('class',1)">

                                    <?php echo($this->faculty); ?>
                                </select>
                            </div>
                            <div class="col-sm-12 form-group">

                                <label for="find_class">Select Department </label>
                                <select class="form-control" name="find_class" id="find_class" onchange="retrieve_reg_no('class',1)">
                                    <?php echo($this->classes); ?>
                                </select>
                            </div>

                            <div class="col-sm-12 form-group">
                                <label for="find_name">Select Name </label>
                                <select class="form-control" name="find_name" id="find_name" onchange="retrieve_reg_no('name',1)">
                                    <option value="0">Loading</option>
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

