
<!-- Container (Testimonies Section) -->
<div id="testimonies" class="container-fluid text-center">
    <h3><span class="glyphicon glyphicon-lock"></span> Password Recovery</h3>
</div>
<!-- Container (Home Cells Section) -->
<div id="home-cells" class="container-fluid text-center bg-grey">
    <h2 class="text-center">Enter Registered Email</h2>


    <div class="row">
        <div class="col-sm-12">
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
                    <h4><i class="icon fa fa-info"></i> Info</h4>
                    <p id="status"> A link will be sent to the registered email address to enable you reset your password</p>

                </div>
            <?php } ?>

        </div>

        <div class="col-sm-4 col-sm-offset-4">

            <form action="<?php echo(URL.'login/recaptcha'); ?>" method="post">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <input type="text" class="form-control" id="email_recover" name="email_recover"  placeholder="Enter your email">
                    </div>
                </div>
                <script src='https://www.google.com/recaptcha/api.js'></script>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <div class="g-recaptcha" data-sitekey="6LfMsCcUAAAAAANiuwWCWOXyIV0uMiU5VSL7yHo-"></div>                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 form-group" id="status"></div>

                    <div class="col-sm-12 form-group" id="submit">
                        <button class="btn btn-success btn-block" type="submit" onclick="">Reset my password</button>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>
