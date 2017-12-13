<?php
    include(View::dashBar());
?>
<?php
    $max = 2000 * 1024; //2mb
    $user = new User();
?>

    <!-- Main content -->
    <section class="content">
    <section class="content">
    <div class="row">
    <div class="col-md-8">

        <?php if (isset($this->members)) { ?>
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Standard Members</h3>

                    <div class="box-tools pull-right">
                        <span class="label label-danger"><?php echo(count($this->members)); ?> Found</span>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                        <?php foreach ($this->members as $r) { ?>
                            <li>
                                <img src="<?php echo(URL . 'public/uploads/profile/' . $r['pix']); ?>"
                                     alt="<?php echo($r['name']); ?>">
                                <a class="users-list-name" href="<?php echo(URL); ?>dashboard/member/<?php echo($r['username']); ?>"><?php echo($r['name']); ?></a>
                                <span class="users-list-date"><?php echo($r['username']); ?></span>
                                <span class="users-list-date"><?php echo($r['sex']); ?></span>

                                <?php if($r['no'] == 'no'){ ?>
                                    <button class="btn btn-sm bg-orange" onclick="SendFriendShipRequest(<?php echo(Session::get('user_id')); ?>,<?php echo($r['id']); ?>,'friend_request')" id="send_<?php echo($r['id']); ?>">Send Friend Request</button>
                                    <span class="text-purple" id="friend_<?php echo($r['id']); ?>"></span>

                                <?php } ?>
                                <?php if($r['no'] == 'Cancel'){ ?>
                                    <span class="text-purple" id="friend_<?php echo($r['id']); ?>">Request Pending</span> <br/>
                                    <button class="btn btn-sm btn-default" onclick="RemoveFriendRequest(<?php echo(Session::get('user_id')); ?>,<?php echo($r['id']); ?>,'Cancel')" id="send_<?php echo($r['id']); ?>">Cancel</button>
                                <?php } ?>
                                <?php if($r['no'] == 'Decline'){ ?>
                                    <div id="send_<?php echo($r['id']); ?>">
                                        <button class="btn btn-sm bg-purple" onclick="AcceptFriendRequest(<?php echo(Session::get('user_id')); ?>,<?php echo($r['id']); ?>,1)">Accept Request</button>
                                        <button class="btn btn-sm btn-default" onclick="RemoveFriendRequest(<?php echo(Session::get('user_id')); ?>,<?php echo($r['id']); ?>,'Decline')">Decline</button>

                                    </div>
                                    <span class="text-purple" id="friend_<?php echo($r['id']); ?>"></span>
                                <?php } ?>
                                <?php if($r['no'] == 'Friends'){ ?>
                                    <span class="text-purple" id="friend_<?php echo($r['id']); ?>">Friends</span> <br/>
                                    <button class="btn btn-sm btn-default" onclick="BlockFriend(<?php echo(Session::get('user_id')); ?>,<?php echo($r['id']); ?>,1)" id="send_<?php echo($r['id']); ?>">Block</button>

                                <?php } ?>

                            </li>
                        <?php } ?>
                    </ul>
                    <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="javascript:void(0)" class="uppercase">View All</a>
                </div>
                <!-- /.box-footer -->
            </div>
        <?php } ?>
        <?php if (isset($this->celebs)) { ?>

            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Celebrity</h3>

                    <div class="box-tools pull-right">
                        <span class="label label-danger"><?php echo(count($this->celebs)); ?> Found</span>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                        <?php foreach ($this->celebs as $r) { ?>
                            <li>
                                <img src="<?php echo(URL . 'public/uploads/profile/' . $r['pix']); ?>"
                                     alt="<?php echo($r['name']); ?>">
                                <a class="users-list-name" href="<?php echo(URL); ?>dashboard/member/<?php echo($r['username']); ?>"><?php echo($r['name']); ?></a>
                                <span class="users-list-date"><?php echo($r['username']); ?></span>
                                <span class="users-list-date"><?php echo($r['sex']); ?></span>
                                <?php if($r['no'] == 'no'){ ?>
                                    <button class="btn btn-sm bg-orange" onclick="SendFriendShipRequest(<?php echo(Session::get('user_id')); ?>,<?php echo($r['id']); ?>,'fan')" id="send_<?php echo($r['id']); ?>">Become a Fan </button>
                                    <span class="text-purple" id="friend_<?php echo($r['id']); ?>"></span>

                                <?php } ?>
                                <?php if($r['no'] == 'Fanning'){ ?>
                                    <span class="text-purple" id="friend_<?php echo($r['id']); ?>">Fanning</span> <br/>
                                    <button class="btn btn-sm btn-default" onclick="RemoveFriendRequest(<?php echo(Session::get('user_id')); ?>,<?php echo($r['id']); ?>,'Cancel')" id="send_<?php echo($r['id']); ?>">Off the Fan</button>
                                <?php } ?>



                            </li>
                        <?php } ?>
                    </ul>
                    <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="javascript:void(0)" class="uppercase">View All </a>
                </div>
                <!-- /.box-footer -->
            </div>
        <?php } ?>
        <?php if (isset($this->execs)) { ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Executives</h3>

                    <div class="box-tools pull-right">
                        <span class="label label-danger"><?php echo(count($this->execs)); ?> Found</span>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                        <?php foreach ($this->execs as $r) { ?>
                            <li>
                                <img src="<?php echo(URL . 'public/uploads/profile/' . $r['pix']); ?>"
                                     alt="<?php echo($r['name']); ?>">
                                <a class="users-list-name" href="<?php echo(URL); ?>dashboard/member/<?php echo($r['username']); ?>"><?php echo($r['name']); ?></a>
                                <span class="users-list-date"><?php echo($r['username']); ?></span>
                                <span class="users-list-date"><?php echo($r['sex']); ?></span>
                                <?php if($r['no'] == 'no'){ ?>
                                    <button class="btn btn-sm bg-orange" onclick="SendFriendShipRequest(<?php echo(Session::get('user_id')); ?>,<?php echo($r['id']); ?>,'follow')" id="send_<?php echo($r['id']); ?>">Follow </button>
                                    <span class="text-purple" id="friend_<?php echo($r['id']); ?>"></span>
                                <?php } ?>
                                <?php if($r['no'] == 'Following'){ ?>
                                    <span class="text-purple" id="friend_<?php echo($r['id']); ?>">Following</span> <br/>
                                    <button class="btn btn-sm btn-default" onclick="RemoveFriendRequest(<?php echo(Session::get('user_id')); ?>,<?php echo($r['id']); ?>,'Cancel')" id="send_<?php echo($r['id']); ?>">UnFollow</button>
                                <?php } ?>

                            </li>
                        <?php } ?>
                    </ul>
                    <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="javascript:void(0)" class="uppercase">View All</a>
                </div>
                <!-- /.box-footer -->
            </div>
        <?php } ?>
    </div>
    <!-- /.col -->
    <div class="col-md-4">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Rate Chats</h3>
            </div>
            <div class="box-body">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="http://placehold.it/900x500/39CCCC/ffffff&text=The+King+Rocks" alt="First slide">

                            <div class="carousel-caption">
                                First Slide
                            </div>
                        </div>
                        <div class="item">
                            <img src="http://placehold.it/900x500/3c8dbc/ffffff&text=The+King+Rocks" alt="Second slide">

                            <div class="carousel-caption">
                                Second Slide
                            </div>
                        </div>
                        <div class="item">
                            <img src="http://placehold.it/900x500/f39c12/ffffff&text=The+King+Rocks" alt="Third slide">

                            <div class="carousel-caption">
                                Third Slide
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="fa fa-angle-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="fa fa-angle-right"></span>
                    </a>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Advertisement</h3>
            </div>
            <div class="box-body">
                Some word of promise
            </div>
            <!-- /.box-body -->
            <!-- Loading (remove the following to stop the loading)-->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <!-- end loading -->
        </div>
        <!-- /.box -->
        <button class="btn btn-circle btn-lg bg-orange-active" data-spy="affix" data-offset-bottom="0"><i
                class="fa fa-comments-o"></i></button>
    </div>
    </div>
    <!-- /.row -->
    </section>
    <!-- Your Page Content Here -->

    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>