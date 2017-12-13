

<section id="services" class="parallax-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-8 col-sm-offset-2">

                <h2 class="title-one">Password Reset</h2>

                <p>Input a new password here </p>
                <p>
                    <?php if (Session::exists('home')) { ?>
                        <?php echo Session::flash('home'); ?>
                    <?php } elseif (Session::exists('error')) { ?>
                        <?php echo Session::flash('error'); ?>
                    <?php } ?>

                </p>
                <div class="our-service">
                    <div class="services row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="single-service">
                                <i class="fa fa-lock"></i>
                                <form action="<?php echo(URL.'login/temp_login'); ?>" method="post">
                                    <input type="hidden" name="temp_pass_session" value="<?php echo Session::get('temp_pass_session'); ?>" >
                                    <input type="hidden" name="temp_pass_user" value="<?php echo Session::get('temp_pass_user'); ?>" >
                                    <input type="hidden" name="temp_pass_user_id" value="<?php echo Session::get('temp_pass_user_id'); ?>" >

                                    <div class="form-group">
                                        <input type="password" name="password" id="password" placeholder="Enter New Password"  class="form-control">

                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="confirm_pass" id="confirm_pass" placeholder="Confirm New Password" class="form-control">

                                    </div>
                                    <br/>

                                    <div class="form-group">
                                        <button type="submit"class="btn btn-primary btn-block">Done</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section><!--/#service-->
