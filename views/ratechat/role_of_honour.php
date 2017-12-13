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
        <div class="row" id="container">
            <br/>

            <div class="col-sm-10 col-sm-offset-1 register-box-body">
                <div class="col-sm-12 text-center">
                    <img src="<?php echo URL; ?>public/images/ratechat2.png" class="img-thumbnail center-block" alt="RateChats" width="50" height="50">
                    <h3 class="error-code text-center">RateChats</h3>
                    <h1>Results of Rates</h1>

                    <hr>



                </div>
                <div class="col-sm-6 ">

                    <p class="list-group-item-text">Rate</p>
                    <h4 class="list-group-item-heading"><?php echo($this->rate['name']); ?></h4>

                </div>

                <div class="col-sm-6 text-right">
                    <div class="imgholder">
                        <img src="<?php echo URL; ?>public/uploads/ratechat/<?php echo $this->rate['upload']; ?>" class="img-responsive img-thumbnail" height="100" width="100" alt="Image of <?php echo $this->rate['name']; ?>">

                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <br/>

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"><b>Role of Honour</b> <small>People & Power</small> </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th rowspan="2" style="width: 10px">#</th>
                                    <th rowspan="2" class="text-center">Content</th>
                                    <th class="text-center" colspan="5">STARS</th>
                                    <th class="text-center" rowspan="2">Total</th>
                                </tr>
                                <tr>
                                    <th class="text-center">5</th>
                                    <th class="text-center">4</th>
                                    <th class="text-center">3</th>
                                    <th class="text-center">2</th>
                                    <th class="text-center">1</th>
                                </tr>
                                <?php if(isset($this->response)){
                                    $i = 1;
                                    foreach($this->response as $s){ ?>
                                        <tr>
                                            <td><?php echo $i; $i++; ?></td>
                                            <td class="text-center">
                                                <img src="<?php echo URL; ?>public/uploads/ratechat/<?php echo $s['file_name']; ?>" class="img-responsive img-thumbnail" height="215" width="215" alt="Image of <?php echo $s['name']; ?>">
                                                <?php echo $s['name']; ?>
                                            </td>
                                            <td class="text-center"><?php echo $s['five']; ?></td>
                                            <td class="text-center"><?php echo $s['four']; ?></td>
                                            <td class="text-center"><?php echo $s['three']; ?></td>
                                            <td class="text-center"><?php echo $s['two']; ?></td>
                                            <td class="text-center"><?php echo $s['one']; ?></td>
                                            <td class="text-center"><?php echo $s['total']; ?> out of 5 stars</td>


                                        </tr>
                                    <?php }} ?>


                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->


                </div>





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

