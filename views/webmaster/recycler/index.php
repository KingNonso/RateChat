<?php
    include(View::webmaster_nav());
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Webmaster Control panel</small>
      </h1>
      <ol class="breadcrumb">
          <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


      </ol>


    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Your Page Content Here -->
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>1</h3>

                        <p>New Enquires</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup> </h3>

                        <p>Photo Gallery</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-clipboard"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>4</h3>

                        <p>Admissions Applicants</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>5</h3>

                        <p>Bus Routes</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-ios-location"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Info boxes -->
        <!-- /.row -->
      <section class="content-header">
          <h2>
              Quick
          </h2>

      </section>

      <div class="row">
      <!-- left column -->
      <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
              <div class="box-header with-border">
                  <h3 class="box-title">Add New Bus Route</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form role="form">
                  <div class="box-body">
                      <div class="form-group">
                          <label for="exampleInputEmail1">Title</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter heading">
                      </div>
                      <div class="form-group">
                          <label>Post</label>
                          <textarea class="form-control" rows="3" placeholder="What's on your mind ..."></textarea>
                      </div>


                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                      <button type="submit" class="btn btn-primary">Save Draft</button>
                  </div>
              </form>
          </div>
          <!-- /.box -->


      </div>
      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
              <div class="box-header with-border">
                  <h3 class="box-title">Add New Event to Calendar</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" action="<?php echo(URL.'webmaster/add_event'); ?>" method="post" >
                  <input type="hidden" name="token" value="<?php echo Tokens::generate(); ?>" />
                  <div class="box-body">
                      <div class="form-group">
                          <label for="title" class="col-sm-2 control-label"> Title</label>

                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="title" id="title">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="description" class="col-sm-2 control-label">Event Description</label>

                          <div class="col-sm-10">
                              <textarea id="description" name="description" class="form-control" placeholder="Brief Description..."></textarea>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="datepicker" class="col-sm-2 control-label">Date</label>

                          <div class="col-sm-10">
                              <div class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right" id="datepicker" name="datepicker">
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="timepicker" class="col-sm-2 control-label">Time</label>

                          <div class="col-sm-10">
                              <div class="input-group bootstrap-timepicker">
                                  <div class="input-group-addon">
                                      <i class="fa fa-clock-o"></i>
                                  </div>
                                  <input type="text" class="form-control timepicker pull-right" id="timepicker" name="timepicker">
                              </div>
                          </div>
                      </div>
                      <div class="form-group"></div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                      <button type="reset" class="btn btn-default">Cancel</button>
                      <button type="submit" class="btn btn-info pull-right">Set Calender</button>
                  </div>
                  <!-- /.box-footer -->
              </form>
          </div>
          <!-- /.box -->
      </div>
      <!--/.col (right) -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>