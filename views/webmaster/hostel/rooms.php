<?php
    include(View::webmaster_nav());

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Hostel Management Profile
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">

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
                    Please complete the form below.
                </div>
            <?php } ?>

        </div>

        <!-- /.col -->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header ">

                    <h3 class="box-title">Create/ Remove Hostel Rooms</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-7 text-left">
                            <?php if(isset($this->rooms)){ ?>
                                <h3>You Have <?php echo(count($this->rooms)) ?> Rooms.</h3>

                                <h4>
                                    <?php foreach($this->rooms as $r){?>
                                        <?php echo($r->room_name); ?>  <a href="<?php echo(URL.'webmaster/remove_room/'.$r->room_id); ?>" onclick="return confirm('Are you really sure you wanna remove  Room <?php echo($r->room_name); ?> ? Can\'t be undone')"><span class="badge">&times;</span></a> &nbsp;

                                    <?php } ?>
                                </h4>

                            <?php }else{?>
                                <div id="output">
                                    <span class="logo glyphicon glyphicon-home"></span>
                                </div>
                                <p>No Room Created Yet</p>

                            <?php } ?>

                        </div>
                        <div class="col-sm-5 text-left">
                            <form id="form1" name="form1" method="post" action="<?php echo URL; ?>hostel/create_rooms"  enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label" for="floor_term">Floor Term</label>
                                    <input type="hidden" name="block_id" id="block_id" value="<?php echo($this->block_id); ?>">
                                    <input type="hidden" name="hostel_id" id="hostel_id" value="<?php echo($this->hostel_id); ?>">
                                    <input class="form-control"  type="text" name="floor_term" id="floor_term" >
                                </div>

                                <div class="form-group">
                                    <label for="appendage">Prepend or Append Floor Term</label>
                                    <select class="form-control" name="appendage" id="appendage" >
                                        <option value="Prepend">Prepend</option>
                                        <option value="Append">Append</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="start"> Start Range</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">First Room</span>
                                        <input class="form-control"  type="text" name="start" id="start" />

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="end"> End Range</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">Last Room</span>
                                        <input class="form-control"  type="text" name="end" id="end" />

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="exemption"> Exemptions </label>
                                    <input class="form-control"  type="text" name="exemption" id="exemption" placeholder="Comma delimited list" >
                                </div>

                                <div class="form-group">
                                    <label for="spaces">Room Spaces</label>
                                    <select class="form-control" name="spaces" id="spaces" >
                                        <option value="1">Single</option>
                                        <option value="2">Double</option>
                                        <option value="3">Triple</option>
                                        <option value="4">Quadruple</option>
                                    </select>
                                </div>




                                <div class="form-group">
                                    <h4>How its gonna come out</h4>
                                </div>





                                <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />


                                <div class="row">
                                    <div class="col-sm-6">
                                        <input class="btn btn-primary btn-lg" type="submit" name="send" id="send" value="Create &amp; Add More" />
                                    </div>
                                    <div class="col-sm-6">

                                        <a href="<?php echo URL.'webmaster/management/'.$this->hostel_id; ?>" class="btn btn-success">Done</a>

                                    </div>
                                </div>
                                <br />

                            </form>
                        </div>

                    </div>

                </div>
            </div>




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
