<?php
    include(View::webmaster_nav());
?>
<?php
    $max = 2000 * 1024; //2mb
    $user = new User();
?>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
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
                        <h3> <?php echo ($this->dashboard[0]);  ?></h3>

                        <p>Hostels</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <a href="#" class="small-box-footer" data-toggle="modal" data-target="#downlines">More info  <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo ($this->dashboard[1]);  ?></h3>

                        <p>Users </p>
                    </div>
                    <div class="icon">
                        <i class="fa  fa-smile-o"></i>
                    </div>
                    <a href="#" class="small-box-footer" data-toggle="modal" data-target="#uplines">More info  <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo ($this->dashboard[2]);  ?></h3>

                        <p>Groups </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="#" class="small-box-footer" data-toggle="modal" data-target="#members">More info  <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo ($this->dashboard[3]);  ?></h3>

                        <p>Posts </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-comment"></i>
                    </div>
                    <a href="#" class="small-box-footer" data-toggle="modal" data-target="#trending">More info  <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
      <section class="content-header">
          <h2>TODAY</h2>

      </section>
      <!-- Info boxes -->
      <div class="row">
          <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-aqua"><i class="ion ionicons ion-bowtie"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text">New Members</span>
                      <span class="info-box-number"><?php echo ($this->analysis[0]);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                  <a class="btn btn-sm bg-aqua btn-flat pull-right" href="javascript:void(0)">View</a>

              </div>
              <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-green"><i class="fa fa-heartbeat"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text">Active Users</span>
                      <span class="info-box-number"><?php echo ($this->analysis[1]);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                  <a class="btn btn-sm bg-green btn-flat pull-right" href="javascript:void(0)">View</a>

              </div>
              <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix visible-sm-block"></div>

          <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-yellow"><i class="fa fa-unlock"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text">Logins</span>
                      <span class="info-box-number"><?php echo ($this->analysis[2]);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                  <a class="btn btn-sm bg-yellow btn-flat pull-right" href="javascript:void(0)">View</a>

              </div>
              <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-red"><i class="fa fa-keyboard-o"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text">Posts</span>
                      <span class="info-box-number"><?php echo ($this->analysis[3]);  ?></span>
                  </div><!-- /.info-box-content -->
                  <a class="btn btn-sm bg-red btn-flat pull-right" href="javascript:void(0)">View</a>
              </div>
              <!-- /.info-box -->
          </div>
          <!-- /.col -->
      </div>
        <!-- /.row -->
      <section class="content-header">
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
              <?php } ?>

          </div>

      </section>

      <div class="row">
      <!-- left column -->
      <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
              <div class="box-header with-border">
                  <h3 class="box-title">Your Personal Information</h3>
              </div>
              <?php $my = $this->account; ?>

              <!-- form start -->
              <div class="box-body">
                  <form class="form-horizontal" role="form" action="<?php echo(URL.'dashboard/update/personal/'.$my['id']); ?>" method="post">
                      <div class="form-group">
                          <label class="control-label col-sm-2" for="email">Name:</label>
                          <div class="col-sm-10">
                              <p class="form-control-static"><?php echo($my['fullname']); ?></p>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-sm-2" for="email">Email:</label>
                          <div class="col-sm-10">
                              <p class="form-control-static"><?php echo($my['email']); ?></p>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-sm-2" for="email">Phone:</label>
                          <div class="col-sm-10">
                              <p class="form-control-static"><?php echo($my['phone_number']); ?></p>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-sm-2" for="home_address">Address:</label>
                          <div class="col-sm-10">
                              <p class="form-control-static"><?php echo($my['home_address']); ?></p>
                          </div>

                      </div>

                  </form>

              </div>


          </div>
          <!-- /.box -->

      </div>
      <!--/.col (left) -->
      <!-- right column -->
          <div class="col-md-6">
              <!-- Horizontal Form -->
              <div class="box box-info">
                  <div class="box-header with-border">
                      <h3 class="box-title">Support Time Line</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-12">
                              <!-- The time line -->
                              <ul class="timeline">
                                  <!-- timeline time label -->
                                  <li class="time-label">
                  <span class="bg-red">
                    10 Feb. 2014
                  </span>
                                  </li>
                                  <!-- /.timeline-label -->
                                  <!-- timeline item -->
                                  <li>
                                      <i class="fa fa-envelope bg-blue"></i>

                                      <div class="timeline-item">
                                          <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                          <div class="timeline-body">
                                              Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                              weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                              jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                              quora plaxo ideeli hulu weebly balihoo...
                                          </div>
                                          <div class="timeline-footer">
                                              <a class="btn btn-primary btn-xs">Read more</a>
                                              <a class="btn btn-danger btn-xs">Delete</a>
                                          </div>
                                      </div>
                                  </li>
                                  <!-- END timeline item -->

                                  <!-- timeline item -->
                                  <!-- END timeline item -->
                                  <!-- timeline time label -->
                                  <!-- /.timeline-label -->

                                  <!-- timeline item -->
                                  <!-- END timeline item -->
                                  <li>
                                      <i class="fa fa-clock-o bg-gray"></i>
                                  </li>
                              </ul>
                          </div>
                          <!-- /.col -->
                      </div>
                  </div>
              </div>
              <!-- /.box -->
          </div>
      <!--/.col (right) -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <!-- Modal -->
    <div id="downlines" class="modal modal-info fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Your Downlines</h4>
                </div>
                <div class="modal-body">
                    <p>This shows every one that has been merged to pay you.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <div id="uplines" class="modal modal-success fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Your Uplines</h4>
                </div>
                <div class="modal-body">
                    <p>This shows every one that you are/have paid to.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <div id="members" class="modal modal-warning fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Users</h4>
                </div>
                <div class="modal-body">
                    <p>This shows every one that is on this Platform.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <div id="trending" class="modal modal-danger fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Total Transaction</h4>
                </div>
                <div class="modal-body">
                    <p>This monitors the entire Platform Transaction.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

<?php
    include(View::rightNav());
?>