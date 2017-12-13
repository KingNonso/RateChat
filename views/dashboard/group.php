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
    <!-- /.col

    <div class="box box-widget widget-user">
        <div class="widget-user-header bg-orange-active">


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

                    </div>
                </div>
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <?php echo ucfirst($this->type); ?> forum
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo(Session::get('logged_in_user_slug')); ?></h5>

                    </div>
                </div>
            </div>
        </div>
    </div>
    -->

    <div class="panel panel-default text-left">
        <div class="panel-body">
            <form name="main_post" id="main_post" method="post" action="<?php echo URL; ?>wall/post" onsubmit="return false">
                <p id="output"></p>
                <input type="hidden" id="group_type" name="group_type" value="<?php echo $this->type; ?>">
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
                        <button type="submit" class="btn bg-orange-active btn-sm" onclick="callCrudAction('post', 1)">
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
                        <span class="username"><a href="<?php echo(URL); ?>dashboard/member/<?php echo($slug); ?>" class="poster-name text-left"><?php echo($name); ?> </a></span>
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
                    <div class="posted_hidden" id="full_post_<?php echo $d["post_id"]; ?>" style="display: none"><?php

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
                                            <a href="<?php echo(URL); ?>dashboard/member/<?php echo($author_slug); ?>" class="poster-name text-left"><?php echo($author); ?></a>
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
                                <div class="input-group-btn ">
                                    <button type="submit" class="btn bg-orange-active reply-btn" onClick="callCrudAction('comment', '<?php echo($d['post_id']); ?>')"><span class="glyphicon glyphicon-plus"></span></button>
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
    <h5 class="widget-user-desc" id="end_of_doc"><button type="button" class="btn bg-orange-active " onclick="showOlderPost()">View Older Post</button> </h5>

    <!-- Widget: user widget style 1 -->
    <div class="box box-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="box-footer no-padding"></div>
    </div>
    <!-- /.widget-user -->
    <!-- Box Comment -->
    <!-- /.box -->
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

        <!-- DIRECT CHAT PRIMARY -->
        <div class="box box-warning direct-chat direct-chat-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Direct Chat</h3>

                <div class="box-tools pull-right">
                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow"><?php echo (count($this->relates)); ?></span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                        <i class="fa fa-comments"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages" id="scrolling_div">
                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-left">Webmaster King</span>
                            <span class="direct-chat-timestamp pull-right"><?php echo date('dS D, h:i a'); ?></span>
                        </div>
                        <!-- /.direct-chat-info -->
                        <img class="direct-chat-img" src="<?php echo (URL.'public/images/avatar-male.png'); ?>" alt="Webmaster"><!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            Do you know that you can chat with a friend from here? Click on the <i class="fa fa-comments"></i> up there to start
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->

                    <!-- Message to the right -->
                    <div class="direct-chat-msg right">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-right">You</span>
                            <span class="direct-chat-timestamp pull-left"><?php echo date('dS D, h:i a'); ?></span>
                        </div>
                        <!-- /.direct-chat-info -->
                        <img class="direct-chat-img" src="<?php echo (Session::get('logged_in_user_photo')); ?>" alt="<?php echo(Session::get('logged_in_user_name')); ?>"><!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            That's unbelievable! WOW!!!
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                    <div id="directAppend"></div>
                    <!-- /.direct-chat-msg -->
                </div>
                <!--/.direct-chat-messages-->
                <!-- Contacts are loaded here -->
                <div class="direct-chat-contacts" id="direct-chat-contacts">
                    <ul class="contacts-list">
                        <?php if (isset($this->relates)) { ?>
                            <?php foreach ($this->relates as $r) { ?>
                                <li>
                                    <a href="javascript:void(0);" onclick="GetDirectChat(<?php echo($r['id']); ?>)" data-toggle="tooltip" title="<?php echo($r['member']); ?>" data-widget="chat-pane-toggle">
                                        <img class="contacts-list-img" src="<?php echo(URL . 'public/uploads/profile/' . $r['pix']); ?>"
                                             alt="<?php echo($r['name']); ?>">

                                        <div class="contacts-list-info">
                            <span class="contacts-list-name">
                              <?php echo($r['name']); ?>
                              <small class="contacts-list-date pull-right">Last seen: <?php echo($r['lastLogin']); ?></small>
                            </span>
                                            <span class="contacts-list-msg"><?php echo($r['member']); ?></span>
                                        </div>
                                        <!-- /.contacts-list-info -->
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                        <!-- End Contact Item -->
                    </ul>
                    <!-- /.contatcts-list -->
                </div>
                <!-- /.direct-chat-pane -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <form action="#" onsubmit="return false" method="post">
                    <div class="input-group">
                        <input type="text" name="directMsg" id="directMsg" placeholder="Type Message ..." class="form-control">
                        <input type="hidden" id="receiver_id" name="receiver_id" value="7">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-warning btn-flat" onclick="directChat()">Send</button>
                      </span>
                    </div>
                </form>
            </div>
            <!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->

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
        <button class="btn btn-circle btn-lg bg-orange-active" data-spy="affix" data-offset-bottom="0"><i class="fa fa-comments-o" ></i></button>
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