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
            <div class="col-md-9">
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua-active">


                    </div>
                    <div class="widget-user-image">
                        <h3 class="widget-user-username"></h3>
                        <img class="img-circle" src="<?php echo(Session::get('logged_in_user_photo')); ?>" alt="<?php echo(Session::get('logged_in_user_name')); ?>">
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header"><?php echo(Session::get('logged_in_user_name')); ?></h5>
                                    <span class="description-text">Name</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">

                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header"><?php echo(Session::get('logged_in_user_slug')); ?></h5>
                                    <span class="description-text">ID</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>


                <div class="panel panel-default text-left">
                    <div class="panel-body">
                        <form name="main_post" id="main_post" method="post" action="<?php echo URL; ?>wall/post" onsubmit="return false">
                            <p id="output"></p>
                            <textarea class="form-control" id="post_message" name="post_message" placeholder="What is on your mind... <?php echo(Session::get('logged_in_user_first_name')); ?>?" rows="3" required="required" ></textarea><br>
                            <div>
                                <div class=" form-group col-sm-9">
                                    <div class="pull-left">
                                        <input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?php echo $max; ?>" />
                                        <label class="btn btn-default btn-xs btn-file">
                                            <span><i class="glyphicon glyphicon-camera"></i> Add Photo</span>
                                            <input type="file" name="filename" id="filename" class="btn btn-default"
                                                   data-maxfiles="<?php echo $_SESSION['maxfiles']; ?>"
                                                   data-postmax="<?php echo $_SESSION['postmax']; ?>"
                                                   data-displaymax="<?php echo $_SESSION['displaymax']; ?>"

                                                   />
                                        </label>



                                    </div>



                                </div>

                                <div class="pull-right" id="post">
                                    <button type="submit" class="btn btn-default btn-sm" onclick="callCrudAction('post', 1)">
                                        <span class="glyphicon glyphicon-pencil"></span> Post
                                    </button>

                                </div>


                            </div>

                        </form>

                    </div>
                </div>

                <span id="wall_post"></span>
                <?php
                $data = $this->wall_post;
                ?>

                <?php
                foreach ($data as $d) {
                    list($name, $source, $slug) = $user->get_person_name($d['author_id']);

                    if ($d['post_image']) {
                        $picture = '<img src="' . URL . 'public/uploads/wall/' . $d['post_image'] . '" class="img-responsive" height="50%">';
                    } else {
                        $picture = '';
                    }
                    ?>

                    <!-- Box Comment -->
                    <div class="box box-widget" id="post_holder<?php echo($d['post_id']); ?>">
                        <div class="box-header with-border">
                            <div class="user-block">
                                <img class="img-circle" src="<?php echo($source); ?>" alt="<?php echo($name); ?>">
                                <span class="username"><a href="<?php echo(URL); ?>profile/member/<?php echo($slug); ?>" class="poster-name text-left"><?php echo($name); ?> </a></span>
                                <span class="description">Shared publicly - <span class="liveTime" data-lta-value="<?php echo($d['when']); ?>"></span></span>
                            </div>
                            <!-- /.user-block -->
                            <div class="box-tools">
                                <!--
                                     <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                                            <i class="fa fa-circle-o"></i></button>
                                     <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>

                                -->
                                <?php
                                    if(Session::get('user_id') == $d['author_id']){
                                        ?>
                                        <a href="javascript:void(0);" onClick="callCrudAction('delete_post','<?php echo($d['post_id']); ?>')" title="Delete" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></a>
                                    <?php }  ?>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
    <?php echo($picture); ?>
                            <div class="posted_hidden" id="full_post_<?php echo $d["post_id"]; ?>"><?php

                                    echo nl2br(($d['message']));                                ?>
                            </div>

                            <div id="part_post_<?php echo $d["post_id"]; ?>"><?php
                                    $extract = substr($d['message'], 0, 500);
                                    // check if up to the required no
                                    if (strlen($extract) >= 500){
                                        // find position of last space in extract
                                        $lastSpace = strrpos($extract, ' ');
                                        // use $lastSpace to set length of new extract and add ...
                                        echo nl2br(substr($extract, 0, $lastSpace)).' ... '; ?><a href="javascript:void(0);" class="text-primary" id="show_post_full" title="View all the text" onclick="showFullStory(<?php echo $d["post_id"]; ?>)">continue reading</a>
                                    <?php }else{
                                        echo (nl2br($d['message']));
                                    }

                                ?>
                            </div>

                            <!--
                                   <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>

                            -->
    <?php
    list($likes, $like_count, $user_likes_it, $likers) = $user->get_liked(Session::get('user_id'), 'post_id', $d['post_id']);
    ?>
                            <?php
                            if (!$user_likes_it) {
                                ?>
                                <a href="javascript:void(0);" class="btn btn-default btn-xs" onClick="callCrudAction('like_post', '<?php echo($d['post_id']); ?>')" title="Like it" id="like-btn<?php echo($d['post_id']); ?>">
                                    <span class="fa fa-thumbs-o-up"></span> Like
                                </a>

    <?php } ?>
                            <a href="javascript:void(0);" class="btn btn-link" data-toggle="popover" data-trigger="hover" data-content="<?php echo($likers); ?>" id="like-count<?php echo($d['post_id']); ?>"><?php echo($like_count); ?></a>

    <?php
    $replies = $user->get_post_reply($d['post_id']);
    ?>
                            <?php
                            $reply_count = $user->count();
                            if ($reply_count == 0) {
                                $reply_count = 'Comment';
                                $reply_content = 'No Comments yet';
                            } else {
                                if ($reply_count == 1) {
                                    $reply_count = '1 Comment';
                                    $reply_content = 'View this comment';
                                } else {
                                    $reply_count = $reply_count . ' Comments';
                                    $reply_content = 'Click to view comments';
                                }
                            }
                            ?>

                            <span class="pull-right text-muted">

                                <a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="toggle('all_replies<?php echo($d['post_id']); ?>')" data-toggle="popover" data-trigger="hover" data-content="<?php echo($reply_content); ?>">
                                    <i class="fa fa-comments" ></i> <span id="reply-count<?php echo($d['post_id']); ?>"><?php echo($reply_count); ?></span></a>
                            </span>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer box-comments" id="all_replies<?php echo($d['post_id']); ?>">

    <?php
    foreach ($replies as $reply) {
        list($author, $author_img, $author_slug) = $user->get_person_name($reply['author']);
        ?>

                                <div class="box-comment" id="reply<?php echo($reply['reply_id']); ?>">
                                    <!-- User image -->
                                    <img class="img-circle img-sm" src="<?php echo($author_img); ?>" alt="<?php echo($author); ?>">

                                    <div class="comment-text">
                                        <span class="username">
                                            <a href="<?php echo(URL); ?>profile/member/<?php echo($author_slug); ?>" class="poster-name text-left"><?php echo($author); ?></a>
                                            <span class="liveTime text-muted pull-right" data-lta-value="<?php echo($reply['date_posted']); ?>"></span>
                                        </span><!-- /.username -->
        <?php echo($reply['comment']); ?>
                                    </div>
                                    <!-- /.comment-text -->
                                </div>
    <?php } ?>
                            <!-- /.box-comment -->
                            <!-- /New comment -->
                            <div id="post-reply<?php echo($d['post_id']); ?>"></div>
                        </div>
                        <!-- /.box-footer -->
                        <div class="box-footer">
                            <form method="post" onsubmit="return false">
                                <img class="img-responsive img-circle img-sm" src="<?php echo (Session::get('logged_in_user_photo')); ?>" alt="<?php echo(Session::get('logged_in_user_name')); ?>">
                                <!-- .img-push is used to add margin to elements next to floating images -->
                                <div class="img-push">
                                    <div class="input-group">
                                        <input type="text" class="form-control"  id="txtmessage<?php echo($d['post_id']); ?>" placeholder="Reply to Post... " required="required">
                                        <input name="author_id" id="author_id" type="hidden" value="<?php echo($d['author_id']); ?>" />
                                        <input name="post_id" id="post_id" type="hidden" value="<?php echo($d['post_id']); ?>" />
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn reply-btn" onClick="callCrudAction('comment', '<?php echo($d['post_id']); ?>')"><span class="glyphicon glyphicon-plus"></span></button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
<?php } ?>

                <div id="load_more_wall_post">

                </div>


                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-yellow">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo (Session::get('logged_in_user_photo')); ?>" alt="<?php echo(Session::get('logged_in_user_name')); ?>">
                        </div>
                        <!-- /.widget-user-image -->
                        <h3 class="widget-user-username"><?php echo(Session::get('logged_in_user_name')); ?></h3>
                        <h5 class="widget-user-desc" id="end_of_doc"><button type="button" class="btn btn-default " onclick="showOlderPost()">View Older Post</button> </h5>
                    </div>
                    <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="#">Device <span class="pull-right badge bg-blue"><?php echo(Session::get('user_device_used')); ?></span></a></li>
                            <li><a href="#">Last Login <span class="pull-right badge bg-aqua"><?php echo(Session::get('user_last_login')); ?></span></a></li>
                            <li><a href="#">Browser <span class="pull-right badge bg-green"><?php echo(Session::get('user_browser_used')); ?></span></a></li>
                            <li><a href="#">Operating System <span class="pull-right badge bg-red"><?php echo(Session::get('user_os_used')); ?></span></a></li>
                            <li><a href="#">ISP & Location <span class="pull-right badge bg-gray"><?php echo(Session::get('user_isp_used')); ?></span></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /.widget-user -->
                <!-- Box Comment -->
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <div class="user-block">
                            <img class="img-circle" src="../dist/img/user1-128x128.jpg" alt="User Image">
                            <span class="username"><a href="#">Jonathan Burke Jr.</a></span>
                            <span class="description">Shared publicly - 7:30 PM Today</span>
                        </div>
                        <!-- /.user-block -->
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                                <i class="fa fa-circle-o"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- post text -->
                        <p>Far far away, behind the word mountains, far from the
                            countries Vokalia and Consonantia, there live the blind
                            texts. Separated they live in Bookmarksgrove right at</p>

                        <p>the coast of the Semantics, a large language ocean.
                            A small river named Duden flows by their place and supplies
                            it with the necessary regelialia. It is a paradisematic
                            country, in which roasted parts of sentences fly into
                            your mouth.</p>

                        <!-- Attachment -->
                        <div class="attachment-block clearfix">
                            <img class="attachment-img" src="../dist/img/photo1.png" alt="Attachment Image">

                            <div class="attachment-pushed">
                                <h4 class="attachment-heading"><a href="http://www.lipsum.com/">Lorem ipsum text generator</a></h4>

                                <div class="attachment-text">
                                    Description about the attachment can be placed here.
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry... <a href="#">more</a>
                                </div>
                                <!-- /.attachment-text -->
                            </div>
                            <!-- /.attachment-pushed -->
                        </div>
                        <!-- /.attachment-block -->

                        <!-- Social sharing buttons -->
                        <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>
                        <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button>
                        <span class="pull-right text-muted">45 likes - 2 comments</span>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer box-comments">
                        <div class="box-comment">
                            <!-- User image -->
                            <img class="img-circle img-sm" src="../dist/img/user3-128x128.jpg" alt="User Image">

                            <div class="comment-text">
                                <span class="username">
                                    Maria Gonzales
                                    <span class="text-muted pull-right">8:03 PM Today</span>
                                </span><!-- /.username -->
                                It is a long established fact that a reader will be distracted
                                by the readable content of a page when looking at its layout.
                            </div>
                            <!-- /.comment-text -->
                        </div>
                        <!-- /.box-comment -->
                        <div class="box-comment">
                            <!-- User image -->
                            <img class="img-circle img-sm" src="../dist/img/user5-128x128.jpg" alt="User Image">

                            <div class="comment-text">
                                <span class="username">
                                    Nora Havisham
                                    <span class="text-muted pull-right">8:03 PM Today</span>
                                </span><!-- /.username -->
                                The point of using Lorem Ipsum is that it has a more-or-less
                                normal distribution of letters, as opposed to using
                                'Content here, content here', making it look like readable English.
                            </div>
                            <!-- /.comment-text -->
                        </div>
                        <!-- /.box-comment -->
                    </div>
                    <!-- /.box-footer -->
                    <div class="box-footer">
                        <form action="#" method="post">
                            <img class="img-responsive img-circle img-sm" src="../dist/img/user4-128x128.jpg" alt="Alt Text">
                            <!-- .img-push is used to add margin to elements next to floating images -->
                            <div class="img-push">
                                <input type="text" class="form-control input-sm" placeholder="Press enter to post comment">
                            </div>
                        </form>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Loading</h3>
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