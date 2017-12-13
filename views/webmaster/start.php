<?php
    include(View::NavBar());

?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
               Start
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row text-center">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header ">

                            <h3 class="box-title">Your Upline </h3>
                        </div>
                    </div>

                </div>

                <div class="col-sm-4 col-sm-offset-4" id="loaderIcon">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img src="<?php echo(URL.'public/images/LoaderIcon.gif'); ?>" class="profile-user-img img-responsive img-circle" alt="Upline">

                            <h3 class="profile-username text-center">Please Wait - Processing Request</h3>
                            <form>
                                <input type="hidden" name="plan" id="plan" value="<?php echo($this->plan); ?>">
                                <input type="hidden" name="person" id="person" value="<?php echo(Session::get('user_id')); ?>">
                            </form>

                            <p class="text-muted text-center">You will be merged in 5 minutes</p>
                            <p class="text-muted text-center">Do not refresh or leave this page</p>
                            <p class="text-muted text-center">Transaction is Non-Retractable</p>
                            <p class="text-muted text-center">There is no purge button, clicking can't pay, automatically blocks this account</p>
                            <p class="text-muted text-center">You have 12 Hours to make payment</p>
                            <p class="text-muted text-center">You are to call or text the person you've been merged to within 30 minutes</p>
                            <p class="text-muted text-center">He/She can report you for <strong>irresponsiveness</strong> or <strong>negligence</strong></p>
                            <p class="text-muted text-center">Support will contact you by mail/phone, if we receive such a report</p>
                            <time datetime="00h00m35s"> </time>

                        </div>
                        <!-- /.box-body -->
                    </div>

                </div>

                <div id="upline"></div>
                <!-- /.col -->
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>
        <!--

         -->
    </div>  <!-- /.content-wrapper -->

    <!-- Main Footer -->
<?php
    include(View::rightNav());
?>