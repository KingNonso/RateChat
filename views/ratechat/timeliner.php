<?php
    include(View::dashBar());
    $max = 2000 * 1024; //500kb

?>
  <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <section class="content">

        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">

            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <!-- The time line -->
                    <ul class="timeline">
                        <!-- timeline time label -->
                        <li class="time-label">
                  <span class="bg-red">
                    <?php echo(date('d M. Y')); ?>
                  </span>
                        </li>
                        <!-- /.timeline-label -->
                        <?php if(isset($this->timeline)){
                            foreach(($this->timeline) as $time => $t){
                                foreach($t as $val => $v){
                            ?>
                                    <?php if($val == 'video'){ ?>
                                        <li>
                                            <i class="fa fa-video-camera bg-maroon"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="fa fa-clock-o"></i> <?php echo($v['date']); ?></span>


                                                <h3 class="timeline-header"><a href="#">Video - My History: Present: Future</a> </h3>

                                                <div class="timeline-body">

                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe class="embed-responsive-item" src="<?php echo($v['url']); ?>" frameborder="0" allowfullscreen></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <?php if($val == 'image'){
                                        foreach($v as $p){
                                            ?>
                                            <li>
                                                <i class="fa fa-camera bg-purple"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="fa fa-clock-o"></i> <?php echo($p['date']); ?></span>

                                                    <h3 class="timeline-header"><a href="#"><?php echo($p['title']); ?></a> </h3>

                                                    <div class="timeline-body">
                                                        <img src="<?php echo(URL.'public/uploads/ratechat/'.$p['image']); ?>" alt="<?php echo($p['title']); ?>" class="img-responsive">
                                                        <p><?php echo($p['description']); ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php }} ?>

                                    <?php if($val == 'question'){
                                        foreach($v as $p){
                                            ?>
                                            <li>
                                                <i class="fa fa-comments bg-yellow"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="fa fa-clock-o"></i> <?php echo($p['date']); ?></span>

                                                    <h3 class="timeline-header"><a href="#"><?php echo($p['question']); ?></a> </h3>

                                                    <div class="timeline-body">

                                                        <p><?php echo($p['reply']); ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php }} ?>
                        <?php }}} ?>
    <!-- timeline item -->
                        <li>
                            <i class="fa fa-clock-o bg-gray"></i>
                        </li>
                    </ul>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- /.row -->

        </section>
        <!-- /.content -->

    </section>
    <!-- /.content -->
    </div>  <!-- /.content-wrapper -->

  <!-- Main Footer -->
<?php
    include(View::rightNav());
?>