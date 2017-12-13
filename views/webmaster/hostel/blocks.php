<?php
    $max = 2000 * 1024; //2mb
    $user = new User();
    $hostel = $this->hostel;
    $blk_count = (count($this->blocks) > 1) ? count($this->blocks) : 1;
?>
<!-- Container (Home Cells Section) -->
<div id="home-cells" class="container-fluid text-center">


    <h2> Hostel blocks Registration</h2>
    <hr/>
    <div class="row">
    <div class="col-sm-12">


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

    <div class="col-sm-12">
        <div class="row ">

            <div class="col-sm-12 text-center" >
                <h4> Just One Block or More than one block</h4>
                <hr/>
                <p>Each hostel must have at least one block</p>
                <p>If this hostel has more than one block - Create Hostel Blocks</p>
                <div class="col-sm-5 text-left">
                    <?php if(isset($this->blocks)){ ?>
                        <h3>You Have <?php echo(count($this->blocks)) ?> Blocks.</h3>

                        <?php foreach($this->blocks as $r){?>
                            <h4> Block : <?php echo($r['block_name'].'; '); ?> </h4>
                            <a href="<?php echo URL.'hostel/create_block_room/'.$hostel['hostel_id'].'/'.$r['block_id']; ?>" class="btn btn-primary ">Create Rooms for this block</a>
                        <?php } ?>

                    <?php }else{?>
                        <div id="output">
                            <span class="logo glyphicon glyphicon-home"></span>
                        </div>
                        <p>Just a single block</p>

                    <?php } ?>

                </div>
                <div class="col-sm-7 text-left">
                    <form id="form1" name="form1" method="post" action="<?php echo URL; ?>hostel/create_blocks"  enctype="multipart/form-data">

                        <div class="form-group">
                            <label class="control-label" for="block_name">Name of Block*</label>
                            <input type="hidden" name="hostel_id" id="hostel_id" value="<?php echo($hostel['hostel_id']); ?>">
                            <input class="form-control" required="required" type="text" name="block_name" id="block_name"  value="<?php echo($hostel['hostel_name']); ?>"  >
                        </div>

                        <div class="form-group">
                            <label for="special_sex">Special Sex Reservation*</label>
                            <select class="form-control" name="special_sex" id="special_sex" required="required">
                                <option value="<?php echo $flash = $hostel['special_sex']; ?>" selected="selected"><?php echo $flash; ?></option>
                                <option value="Both">Both</option>
                                <option value="female">Female</option>
                                <option value="male">Male</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="hostel_slug">Web URL</label>
                            <div class="input-group">
                                <span class="input-group-addon">www.RateChats.com.ng/hostel/</span>
                                <input class="form-control"  type="text" name="hostel_slug" id="hostel_slug" value="<?php echo($hostel['hostel_slug']); ?>" />

                            </div>
                            <p id="slug-guard">Search Engine friendly</p>
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


    </div>

    </div>


</div>
