<?php
    include(View::webmaster_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Admissions
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
                                        <th>Academic Session/ Term/ Class</th>
                                        <th>Date of Interview</th>
                                        <th>Venue(s)</th>
                                        <th>Requirements</th>
                                        <th>Details</th>
                                        <th>Active</th>
                                        <th colspan="2">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach($this->admissions as $mod){
                                            ?>
                                            <tr>
                                                <td><?php echo $mod['academic_session'];  ?> <br/> <b>#</b> <?php echo $mod['academic_term'];  ?> term <br/><b>#</b> <?php echo $mod['academic_class'];  ?> class</td>
                                                <?php
                                                    $date = new DateTime($mod['interview_date']);
                                                    $dob = $date->format('d M, Y ');//h:i a
                                                ?>
                                                <td><?php echo($dob); ?>
                                                    at <?php echo($mod['interview_time']); ?>
                                                </td>
                                                <td><?php echo($mod['venue']); ?></td>
                                                <td><?php echo $mod['requirements'];  ?></td>
                                                <td><?php echo $mod['other_details'];  ?></td>
                                                <td><?php $echo = ($mod['active'] == 1)? 'Yes': 'No'; echo $echo;  ?></td>
                                                <td><a href="<?php echo URL; ?>webmaster/admissions/update/<?php echo $mod['adm_int_id']; ?>" class="btn btn-success btn-flat">Update</a></td>
                                                <?php if($mod['active'] == 1){ ?>
                                                    <td><a href="<?php echo URL; ?>webmaster/admissions/deactivate/<?php echo $mod['adm_int_id']; ?>" class="btn btn-warning btn-flat">Deactivate</a></td>
                                                <?php } else{ ?>
                                                    <td><a href="<?php echo URL; ?>webmaster/admissions/activate/<?php echo $mod['adm_int_id']; ?>" class="btn btn-info btn-flat">Activate</a></td>
                                                    <?php } ?>


                                            </tr>
                                        <?php }  ?>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Academic Session/ Term/ Class</th>
                                        <th>Date of Interview</th>
                                        <th>Venue(s)</th>
                                        <th>Requirements</th>
                                        <th>Details</th>
                                        <th>Active</th>
                                        <th colspan="2">Actions</th>
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
                    Schedule a new Interview
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
                            <h3 class="box-title">THE Interview</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <p>When you wish to write admissions the hostel, there are a couple of things you need to note.</p>
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
                            <h3 class="box-title"> Create the Interview</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'webmaster/add_interview'); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="academic_session">Select Academic Session</label>
                                    <select class="form-control" name="academic_session" id="academic_session" required="required">
                                        <?php if (Session::exists('academic_session')){?>
                                            <option value="<?php echo $flash = Session::flash('academic_session'); ?>" selected="selected"><?php echo $flash; ?></option>
                                        <?php }?>
                                        <option value="0">Select Starting Session</option>
                                        <?php Date::sessionsInFuture(); ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="academic_term">Admission/Entry Term</label>
                                    <select class="form-control" name="academic_term" id="academic_term">
                                        <?php if (Session::exists('academic_term')){?>
                                            <option value="<?php echo $flash = Session::flash('academic_term'); ?>" selected="selected"><?php echo $flash; ?></option>
                                        <?php }?>
                                        <option value="0">Select Starting Term</option>
                                        <option value="All/ Any">All/ Any </option>
                                        <option value="1st">First (1st)</option>
                                        <option value="2nd">Second (2nd)</option>
                                        <option value="3rd">Third (3rd)</option>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="academic_class">Admission/Entry Class</label>
                                    <select class="form-control" name="academic_class" id="academic_class">

                                        <option value="All/ Any">All/ Any </option>
                                        <?php foreach ($this->class as $class){ if($class['parent_class'] == null){ ?>
                                            <option value="<?php echo $class['class_name']; ?>" <?php if (Session::flash('academic_class') == $class['class_name'] ){echo "selected=\"selected\"";} ?> ><?php echo $class['class_name'] ; ?></option>


                                        <?php }}  ?>




                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="datepicker" class="col-sm-2 control-label">Date</label>

                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right" id="datepicker" name="interview_date">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="timepicker" class="col-sm-2 control-label">Time</label>

                                            <div class="col-sm-10">
                                                <div class="input-group bootstrap-timepicker">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o"></i>
                                                    </div>
                                                    <input type="text" class="form-control timepicker pull-right" id="timepicker" name="interview_time">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

<hr/>
                                <div class="form-group">
                                    <p>Active:
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
                                    <label>Venue(s)</label>
                                    <textarea class="form-control textarea" rows="2" placeholder="Enter content here ..." id="venue" name="venue">
                                        <?php if (Session::exists('venue')){ echo(Session::flash('venue')); } ?>
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Requirements(s)</label>
                                    <textarea class="form-control textarea" rows="2" placeholder="Enter requirements here ..." id="requirements" name="requirements">
                                        <?php if (Session::exists('requirements')){ echo(Session::flash('requirements')); } ?>
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Other Detail(s)</label>
                                    <textarea class="form-control textarea" rows="2" placeholder="Enter content here ..." id="other_details" name="other_details">
                                        <?php if (Session::exists('other_details')){ echo(Session::flash('other_details')); } ?>
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