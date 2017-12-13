<?php
    include(View::dashBar());
    $max = 2000 * 1024; //500kb

?>
<!-- Content Wrapper. Contains page content -->
<section class="content-header">
    <h1>
        Rate
    </h1>
    <ol class="breadcrumb">
        <p style="color:#f36c36"><i class="fa fa-dashboard"></i> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


    </ol></section>

<!-- Main content -->
<section class="content">

    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <!-- /.col -->
        <div class="col-sm-10 col-sm-offset-1">
            <div class="row">
                <div class="col-sm-12 register-box-body">
                    <h3 class="error-code text-center"><?php echo $this->rate['name']; ?></h3>
                    <p class="error-code text-center"><?php echo $this->rate['description']; ?></p>

                    <div class="box-body" id="status">
                        <?php if (Session::exists('home')) { ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> Success!</h4>
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
                                <h4><i class="icon fa fa-info"></i> Note</h4>
                                <p id="status">Please respond frankly to the best of your knowledge</p>

                            </div>
                        <?php } ?>

                    </div>
                    <form id="form1" name="form1" method="post" action="<?php echo URL; ?>ratechat/ratechat_answers" onsubmit="return false">

                        <?php
                            foreach($this->content as $c){ ?>
                                <?php if(!in_array($c->id,$this->response)){ ?>
                                <div class="row" id="content_<?php echo $c->ratechat_id.'_'. $c->id; ?>">
                                <div class="col-sm-12 form-group">
                                    <label for="question">Question: </label>
                                    <p class="form-control-static">
                                        <?php echo $c->name; ?>
                                    </p>
                                    <img src="<?php echo URL.'public/uploads/ratechat/'.$c->file_name; ?>" class="img-responsive img-thumbnail" height="250" width="250">
                                    <p class="help-block"><?php echo $c->description; ?></p>

                                </div>
                                <div class="col-sm-12 form-group">
                                    <fieldset class="starability-checkmark">
                                        <input type="radio" id="no_rate<?php echo $c->ratechat_id.'_'. $c->id; ?>" class="input-no-rate ratings_stars" name="rate_<?php echo $c->ratechat_id.'_'. $c->id; ?>" value="0" checked aria-label="No rating." />

                                        <input type="radio" id="rate1_<?php echo $c->ratechat_id.'_'. $c->id; ?>" name="rate_<?php echo $c->ratechat_id.'_'. $c->id; ?>" class="ratings_stars" value="1" />
                                        <label for="rate1_<?php echo $c->ratechat_id.'_'. $c->id; ?>">1 star.</label>

                                        <input type="radio" id="rate2_<?php echo $c->ratechat_id.'_'. $c->id; ?>" name="rate_<?php echo $c->ratechat_id.'_'. $c->id; ?>" class="ratings_stars" value="2" />
                                        <label for="rate2_<?php echo $c->ratechat_id.'_'. $c->id; ?>">2 stars.</label>

                                        <input type="radio" id="rate3_<?php echo $c->ratechat_id.'_'. $c->id; ?>" name="rate_<?php echo $c->ratechat_id.'_'. $c->id; ?>"  class="ratings_stars" value="3" />
                                        <label for="rate3_<?php echo $c->ratechat_id.'_'. $c->id; ?>">3 stars.</label>

                                        <input type="radio" id="rate4_<?php echo $c->ratechat_id.'_'. $c->id; ?>" name="rate_<?php echo $c->ratechat_id.'_'. $c->id; ?>" class="ratings_stars" value="4" />
                                        <label for="rate4_<?php echo $c->ratechat_id.'_'. $c->id; ?>">4 stars.</label>

                                        <input type="radio" id="rate5_<?php echo $c->ratechat_id.'_'. $c->id; ?>" name="rate_<?php echo $c->ratechat_id.'_'. $c->id; ?>" class="ratings_stars" value="5" />
                                        <label for="rate5_<?php echo $c->ratechat_id.'_'. $c->id; ?>">5 stars.</label>

                                        <span class="starability-focus-ring"></span>
                                    </fieldset>

                                    <label for="rate_comment">Response: </label>

                                    <textarea class="form-control" name="rate_comment" id="rate_comment" rows="1"></textarea>
                                    <?php if(isset( $this->answer)){  ?>
                                        <p class="form-control-static">
                                            <b>Previous</b>: <?php echo $this->answer['answer'].' :: '.$this->answer['date_answered']; ?>
                                        </p>
                                        <p class="starability-result" data-rating="3">
                                            Rated: 3 stars
                                        </p>

                                    <?php } ?>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <div class="row">
                                        <div class="col-xs-8">
                                            <button type="submit" class="btn btn-success btn-block btn-flat" onclick="ratechatAnswers(<?php echo $c->id; ?>,<?php echo $c->ratechat_id; ?>)">Submit Reply </button>
                                        </div>

                                        <div class="col-xs-4">

                                        </div>
                                    </div>
                                    <hr/>
                                </div>
                        </div>
                        <?php } }  ?>

                    </form>


                </div>

            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
        <!-- row -->
        <!-- /.row -->

        <!-- /.row -->

    </section>
    <!-- /.content -->

</section>
<!-- /.content -->
</div>  <!-- /.content-wrapper -->

<?php
    include(View::rightNav());
?>

















