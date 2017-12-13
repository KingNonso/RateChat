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
<?php if(Session::exists('home')){?>
    <div class="box box-success">
    <div class="box-header ">
            <h3 class="box-title"><?php echo Session::flash('home');?> </h3>
    </div>
    </div>

<?php } elseif(Session::exists('error')){ ?>
        <div class="box box-danger">
            <div class="box-header ">

            <h3 class="box-title"><?php echo Session::flash('error');?> </h3>
            </div>
        </div>

<?php }else{?>
        <div class="box box-primary">
            <div class="box-header ">

            <h3 class="box-title"> <?php echo $this->account['hostel_name']; ?> Management Details </h3>
            </div>
        </div>
<?php }?>

    </div>

    <!-- /.col -->
    <div class="col-md-12">
        <form class="form-horizontal" action="<?php echo(URL.'webmaster/account_update'); ?>"  method="post" enctype="multipart/form-data" name="form1" id="form1">
            <div class="form-group">
                <label for="hostel_name" class="col-sm-2 control-label">Hostel Blocks</label>

                <div class="col-sm-10">
                    <p class="form-control-static">

                        <?php if(isset($this->blocks)){ ?>
                        You Have <?php echo(count($this->blocks)) ?> Blocks.

                    <?php foreach($this->blocks as $r){?>
                        <h4> Block : <?php echo($r['block_name'].'; '); ?> </h4>
                        <a href="<?php echo URL.'webmaster/create_block_room/'.$this->account['hostel_id'].'/'.$r['block_id']; ?>" class="btn btn-default ">Create Rooms for this block</a>
                    <?php } ?>

                    <?php }else{?>
                        <div id="output">
                            <span class="logo glyphicon glyphicon-home"></span>
                        </div>
                        <p>Just a single block</p>

                    <?php } ?>


                    </p>

                    <input type="hidden" class="form-control" id="hostel_id" name="hostel_id" value="<?php echo $this->account['hostel_id']; ?>" required="required">
                </div>
            </div>
            <div class="form-group">
                <label for="address" class="col-sm-2 control-label">Address</label>

                <div class="col-sm-10">
                    <p class="form-control-static"> <?php echo $this->account['address']; ?></p>

                </div>
            </div>
            <div class="form-group">
                <label for="features" class="col-sm-2 control-label">Features </label>

                <div class="col-sm-10">
                    <p class="form-control-static"> <?php echo $this->account['features']; ?></p>

                </div>
            </div>
            <div class="form-group">
                <label for="management" class="col-sm-2 control-label">Management </label>

                <div class="col-sm-10">
                    <p class="form-control-static"> <?php echo $this->account['management']; ?></p>

                </div>
            </div>
            <div class="form-group">
                <label for="contact" class="col-sm-2 control-label"> Contact</label>

                <div class="col-sm-10">
                    <p class="form-control-static"> <?php echo $this->account['contact']; ?></p>

                </div>
            </div>
            <div class="form-group">
                <label for="marital_status" class="col-sm-2 control-label">  Location</label>

                <div class="col-sm-10">
                    <p class="form-control-static"> <?php echo $this->account['site']; ?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"  for="room_type">Room</label>

                <div class="col-sm-10">
                    <p class="form-control-static"> <?php echo $this->account['room_type']; ?></p>

                </div>
            </div>
            <div class="form-group">
                <label for="state_of_residence" class="col-sm-2 control-label">Rent  </label>

                <div class="col-sm-10">
                    <p class="form-control-static"> <?php echo number_format($this->account['room_rent']); ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="bank_account" class="col-sm-2 control-label">Bank & Account Details</label>

                <div class="col-sm-10">
                    <p class="form-control-static"> <?php echo $this->account['bank_account']; ?></p>


                </div>
            </div>

            <div class="form-group">
                <label for="skill" class="col-sm-2 control-label">Reservation for Sex</label>

                <div class="col-sm-10">

                    <p class="form-control-static"> <?php if(isset($this->block)){ echo $this->block['special_sex']; }else{ echo $this->account['special_sex']; } ?></p>
                </div>
            </div>

            <div class="form-group">
                <label for="filename" class="col-sm-2 control-label">Web</label>

                <div class="col-sm-10">
                    <p class="form-control-static"> www.RateChats.com.ng/hostel/ <?php echo $this->account['hostel_slug']; ?></p>


                </div>
            </div>
        </form>

        <div class="box box-primary">
            <div class="box-header ">

                <h3 class="box-title">Create a New Hostel Block</h3>
            </div>
            <div class="box-body">
                <form id="form1" name="form1" method="post" action="<?php echo URL; ?>hostel/create_blocks"  enctype="multipart/form-data">

                    <div class="form-group">
                        <label class="control-label" for="block_name">Name of Block*</label>
                        <input type="hidden" name="hostel_id" id="hostel_id" value="<?php echo($this->account['hostel_id']); ?>">
                        <input class="form-control" required="required" type="text" name="block_name" id="block_name"  value="<?php echo($this->account['hostel_name']); ?>"  >
                    </div>

                    <div class="form-group">
                        <label for="special_sex">Special Sex Reservation*</label>
                        <select class="form-control" name="special_sex" id="special_sex" required="required">
                            <option value="<?php echo $flash = $this->account['special_sex']; ?>" selected="selected"><?php echo $flash; ?></option>
                            <option value="Both">Both</option>
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="hostel_slug">Web URL</label>
                        <div class="input-group">
                            <span class="input-group-addon">www.RateChats.com.ng/hostel/</span>
                            <input class="form-control"  type="text" name="hostel_slug" id="hostel_slug" value="<?php echo($this->account['hostel_slug']); ?>" />

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <input class="btn btn-primary btn-lg" type="submit" name="send" id="send" value="Submit &amp; Proceed" />
                            <a href="<?php echo URL.'hostel/finish'; ?>" class="btn btn-success pull-right">Done</a>

                        </div>
                    </div>
                    <br />

                </form>

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