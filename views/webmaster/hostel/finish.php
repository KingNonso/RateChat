<?php
    $max = 2000 * 1024; //2mb
    $user = new User();
?>

<!-- Container (Home Cells Section) -->
<div id="home-cells" class="container-fluid text-center">


    <h2> Hostel Registration</h2>
    <hr/>
    <div class="row">
    <div class="col-sm-12">
        <h1>Registration Completed</h1>

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

    <div class="col-sm-5 text-left">
        <?php if(isset($this->rooms)){ ?>
            <h3>You Have <?php echo(count($this->rooms)) ?> Rooms.</h3>
        <h4>
            <?php foreach($this->rooms as $r){?>
                Room: <?php echo($r->room_name.'; '); ?>
            <?php } ?>
            </h4>
        <?php }else{?>
            <div id="output">
                <span class="logo glyphicon glyphicon-home"></span>
            </div>

        <?php } ?>

        </div>
        <div class="col-sm-7 text-left">
            <h2>REGISTRATION COMPLETE</h2>
            <p>You would be contacted in 24 hours by a member of staff of RateChats with modalities for your hostel</p>

        </div>
    </div>


</div>
