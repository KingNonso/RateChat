<?php
    class User{
        private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn,
            $_student_details,
            $_student_count,
            $_page = 'index.php',
            $perpage = 50,/*Display Per Page 5 Articles */
            $start_pages,
            $calc_pages,
            $all_pages;

        public function __construct($user = null){
            $this->_db = Database::getInstance();

            $this->_sessionName = Config::get('session/session_name');
            $this->_cookieName = Config::get('remember/cookie_name');

            if(!$user){
                if(Session::exists($this->_sessionName)){
                    $user = Session::get($this->_sessionName);
                    if($this->find($user)){
                        $this->_isLoggedIn = true;
                    }else{
                        //process logout
                    }
                }
            }else{
                $this->find($user);
            }
        }

        public function update($table,$fields = array(),$where, $id=null){

            if(!$id && $this->isLoggedIn()){
                $id = $this->data()->id;
            }
            if(!$this->_db->update($table,$id,$fields,$where)){
                throw new Exception('There was a problem updating.');
            }
        }



        public function create($table, $fields = array()){
            if(!$this->_db->insert($table, $fields)){
                throw new Exception('There was a problem creating an account.');
            }
        }

        public function find($user = null){
            if($user){
                $field = (is_numeric($user)) ? 'id' : 'username';
                $data = $this->_db->get('users', array($field, '=',$user));

                if($data -> count()){
                    $this->_data = $data->first();
                    return true;
                }
            }
            return false;
        }

        public function packages() {
            $data = $this->_db->get('user_permissions')->results() ;

            $temp = array();

            foreach($data as $d){
                $temp[] = array(
                    'id' => $d->id,
                    'name' => $d->name,
                    'default_page' => $d->default_page,
                );
            }

            if($data){
                return $temp;
            }else{
                return null;
            }
        }



        public function get_profile_pic($member_id){
            return $this->_db->fetch_last('member_status','status_id','id',$member_id);
        }
        public function get_person_name($author_id){
            $profile =  $this->_db->fetch_exact('users','id',$author_id);
            $name = $profile['firstname']. ' '.$profile['surname'].' '.$profile['othername'];
            //$pix = $this->get_profile_pic($profile['profile_picture']);
            if(!empty($profile['profile_picture'])){
                $source = URL.'public/uploads/profile/'. $profile['profile_picture'];
            }else{
                if($profile['sex']== 'male'){
                    $avatar = 'male';
                }else{
                    $avatar = 'female';
                }
                $source = URL.'public/images/avatar-'.$avatar.'.png';
            }

            return array($name,$source,$profile['slug']);
        }

        public function get_post_reply($post_id){
            return $this->_db->get_assoc('post_reply', array('post_id','=',$post_id))->results_assoc();
        }
        public function get_reply_reaction($reply_id){
            $react = $this->_db->get_assoc('post_reply', array('comment_id','=',$reply_id))->results_assoc();
            $return = '';
            foreach($react as $r){
                list($reactor, $reactor_img, $reactor_slug) = $this->get_person_name($r['author']);
                $return .= '<div class="panel-body" id="comment_reply'.$r['reply_id'].'">';
                $return .= '<div class="col-sm-2">';
                $return .= '<img src="'.$reactor_img.'" class="img-rounded" height="37px" width="37px"  alt="'.$reactor.'">';
                $return .= '</div>';
                $return .= '<div class="col-sm-10 text-left text-holder">
                        <p>';
                $return .= '<a href="'.URL.'profile/member/'.$reactor_slug.'" class="poster-name text-left">'.$reactor.'</a>: '.$r['comment'];
                $return .= '        </p>
                                </div>
                            </div>';
                $return .= '';
                }
            return $return;

        }

        public function get_liked($user, $pattern = 'post_id', $id){
            $likes = $this->_db->get_assoc("likes", array($pattern,'=',$id))->results_assoc();
            $total_like_count = $this->_db->count_assoc();

            $user_likes_it = '';
            foreach($likes as $like){
                //Check if the viewer is among the likers
                if($user == $like['user_id']){
                    $user_likes_it = true;
                    break;
                }else{
                    $user_likes_it = false;
                }
            }
            //get all the likers
            $likers = '';
            for($i=0; $i < 3; $i++){
                $obj = array_pop($likes);
                if($obj == null) break;
                list($name) = $this->get_person_name($obj['user_id']);
                $likers .= $name.', ';
            }
            if(empty($likers)){
                $likers = 'Be the first of your friends';
            }else{
                $likers = chop($likers, ", ");

                if(($total_like_count) > 3){
                    $likers = $likers.' + '.($total_like_count - 3).' more';

                }


            }


            if($total_like_count == 1){
                if($user_likes_it){
                    $no_of_likes = '<span class="badge"  id="like'.$id.'">1</span> You like this';
                }else{
                    $no_of_likes = '<span class="badge"  id="like'.$id.'">1</span> Like';
                }

            }elseif($total_like_count == 2 ){
                if($user_likes_it){
                    $no_of_likes =  'You + <span class="badge"  id="like'.$id.'">'.($total_like_count -1). '</span> Likes';
                }else{
                    $no_of_likes =  '<span class="badge"  id="like'.$id.'">'.($total_like_count ). '</span> Likes';
                }

            }elseif($total_like_count >= 3){
                if($user_likes_it){
                    $no_of_likes =  'You + <span class="badge"  id="like'.$id.'">'.($total_like_count -1). '</span> Likes';
                }else{
                    $no_of_likes =  '<span class="badge"  id="like'.$id.'">'.($total_like_count). '</span> Likes';
                }

            }else{
                $no_of_likes = '<span class="badge"  id="like'.$id.'">0</span> Like';
            }

            return array($likes,$no_of_likes,$user_likes_it,$likers);

        }


        public function get_reply_likes($user, $pattern = 'reply_id', $id){
            $likes = $this->_db->get_assoc("likes", array($pattern,'=',$id))->results_assoc();
            $total_like_count = $this->_db->count_assoc();

            $user_likes_it = '';
            foreach($likes as $like){
                //Check if the viewer is among the likers
                if($user == $like['user_id']){
                    $user_likes_it = true;
                    break;
                }else{
                    $user_likes_it = false;
                }
            }
            //get all the likers
            $likers = '';
            for($i=0; $i < 3; $i++){
                $obj = array_pop($likes);
                if($obj == null) break;
                list($name) = $this->get_person_name($obj['user_id']);
                $likers .= $name.', ';
            }
            if(empty($likers)){
                $likers = 'Be first';
            }else{
                $likers = chop($likers, ", ");

                if(($total_like_count) > 3){
                    $likers = $likers.' + '.($total_like_count - 3).' more';

                }


            }


            if($total_like_count == 1){
                if($user_likes_it){
                    $no_of_likes = 'data-content="You like this"';
                }else{
                    $no_of_likes = 'data-content="'.$likers.' likes this"';
                }

            }elseif($total_like_count == 2 ){
                if($user_likes_it){
                    $no_of_likes =  'data-content="You + 1 more" title=" 2 likes"';
                }else{
                    $no_of_likes =  'data-content="'.$likers.' " title=" 2 likes"';
                }

            }elseif($total_like_count >= 3){
                if($user_likes_it){
                    $no_of_likes =  'data-content="You + '.($total_like_count -2). ' more" title=" '.($total_like_count -1). ' likes"';
                }else{
                    $no_of_likes =  'data-content="'.$likers.' " title=" '.($total_like_count). ' likes"';
                }

            }else{
                $no_of_likes = 'data-content="Take the like"';
            }

            return array($likes,$no_of_likes,$user_likes_it,$likers);

        }

        public function get_my_friends($user_id = null){
            $my_friends = array();
            $user_id = isset($user_id) ? $user_id :Session::get('user_id');
            $is_friend = $this->_db->get('friends',array('user1_id','=',$user_id))->results() ;
            $is_friend_count = $this->_db->count();
            if($is_friend_count){
                foreach($is_friend as $f){
                    if($f->accepted == 1)
                        $my_friends[] = $f->user2_id;
                }
            }
            $is_friend = $this->_db->get('friends',array('user2_id','=',$user_id))->results() ;
            $is_friend_count = $this->_db->count();
            if($is_friend_count){
                foreach($is_friend as $f){
                    if($f->accepted == 1)
                        $my_friends[] = $f->user1_id;
                }
            }
            //add myself, so I can see my own post
            $my_friends[] = Session::get('user_id');

            return(($my_friends)) ;



        }
        public function refToRecord($ref, $table = 'users'){
            $record = $this->_db->fetch_exact($table,'record_tracker',$ref);
            return $record;
        }








        /*-----------DEFUNCT USER FUNCTIONSS ----------------- */

        /*
         *
         */

        public function get_trending($ref){
            $slug = $this->_db->fetch_exact('events','event_id',$ref);
            return $slug;
        }
        public function get_attended($ref){
            $result = $this->_db->fetch_exact('event_registrations','event_id',$ref);
            return $result;
        }
        public function is_person_present($user, $event){
            $result = $this->_db->fetch_exact_two('event_registrations','user_id',$user,'event_id',$event);

            return $result;
        }

        public function get_designation($designation_id, $event){
            $result = $this->_db->fetch_exact_two('event_fee','event_fee_id',$designation_id,'event_id',$event);

            return $result['designation'];
        }

        public function executives_form(){
            return $this->_db->getAll('exco_positions')->results_assoc();
        }
        public function event_details($table,$id){
            $position = $this->_db->get_assoc($table,array('event_id','=', $id))->results_assoc();
            return $position;

        }
        public function get_current_national_chairman(){
            return $this->_db->fetch_exact('users','user_perms_id',3);
        }

        public function get_person_chapter($chapter_id){
            return $this->_db->fetch_exact('chapters','chapter_id',$chapter_id);
        }
        public function get_professional_info($member_id){
            return $this->_db->fetch_exact('info_final','user_id',$member_id);
        }
        public function find_exco_role($role_id){
            return $this->_db->fetch_exact('user_permissions','id',$role_id);
        }
        public function find_appointment($role_id){
            return $this->_db->fetch_exact('national_exco','id',$role_id);
        }
        public function find_news($scope = 'national', $news_id = null){
            switch($scope){
                case 'national': //this case is not used
                    $results =  $this->_db->get_assoc('news_desk', array('news_id','=',$news_id))->results_assoc();
                break;
                case 'latest':
                    $results =  $this->_db->getAll_assoc('news_desk')->results_assoc();
                    break;
                case 'events':
                    $results =  $this->_db->get_assoc('events',array('is_live','=',1))->results_assoc();
                    break;
                case 'events_ordered':
                    $results =  $this->_db->get_assoc('events',array('is_live','=',1),'event_id')->results_assoc();
                    break;
                case 'general':
                    $results =  $this->_db->getAll_assoc('news_desk','news_id')->results_assoc();
                    break;
            }
           // print_r($results);
            return $results;
        }
        public static function  lastFive($array, $limit = 5){
            //produce the last five results
            $lastFive = array();
            for($i=0; $i < $limit; $i++){
                $obj = array_pop($array);
                if($obj == null) break;
                $lastFive[] = $obj;
            }
            return $lastFive;
            //produce the first five results
            $arrayCount = count($array);
            if($arrayCount > 5){
                $output = array_slice($array, (-5),$arrayCount);
            }else{
                $output = $array;
            }

        }
        public function get_user_friends($user_id){
            $friends = array();
            array_push($friends,$user_id);

            $first = $this->_db->get_assoc('peer2peer', array('first_person','=',$user_id))->results_assoc();
            foreach($first as $f){
                array_push($friends,$f['second_person']);
            }
            $second = $this->_db->get_assoc('peer2peer', array('second_person','=',$user_id))->results_assoc();
            foreach($second as $s){
                array_push($friends,$s['first_person']);
            }


            return ($friends);
            //
        }

        public function news_reply($id){
            return $this->_db->get_assoc('news_desk_reply', array('news_id','=',$id))->results_assoc();
        }

        public function forums_i_belong($user_id){
            $forum = array();

            $first = $this->get_my_forum($user_id);
            foreach($first as $f){
                array_push($forum, $f['forum_id']);
            }

            return ($forum);
            //
        }

        public function get_all_forum_chat(){
            //$forum_gist = $this->_db->fetch_something('forum_chat','approved','yes');
            $forum_gist = $this->_db->get_assoc('forum_chat',array('approved','=','yes'), 'post_id')->results_assoc();
            return $forum_gist;
        }
        public function get_conversation(){
            $conversation = $this->_db->getAll_assoc('conversation', 'post_id')->results_assoc();
            return $conversation;
        }
        public function chapter_chat($chapter){
            $conversation = $this->_db->get_assoc('chapters_chat',array('chapter_id','=',$chapter), 'post_id')->results_assoc();
            return $conversation;
        }
        public function national_chat(){
            $conversation = $this->_db->getAll_assoc('national_chat', 'post_id')->results_assoc();
            return $conversation;
        }

        public function get_two_chat($sender,$receiver){
            $chat = array();

            $sent =  $this->_db->get_assoc('conversation', array('author_id','=',$sender),'post_id')->results_assoc();
            foreach($sent as $s){
                array_push($chat, $s['post_id']);
            }

            $received =  $this->_db->get_assoc('conversation', array('author_id','=',$receiver),'post_id')->results_assoc();
            foreach($received as $r){
                array_push($chat, $r['post_id']);
            }
            return $chat;


        }


        public function get_reply($table, $post_id){
            return $this->_db->get_assoc("{$table}", array('post_id','=',$post_id))->results_assoc();
        }

        public function get_friendship_request($person){
            return $this->_db->get_multiple('friendship_request', array('receiver','=',$person,'respond','=','no'))->results_assoc();
        }

        public function get_unanswered_question(){
            return $this->_db->get_multiple('question_moderator', array('answered','=','no','reffered','=','no'))->results_assoc();
        }
        public function get_question_i_asked($me){
            return $this->_db->get_multiple('question_moderator', array('answered','=','yes','user_id','=',$me))->results_assoc();
        }
        public function get_question_reply($question_id){
            return $this->_db->get_assoc('question_mod_answer', array('question_id','=',$question_id))->results_assoc();
        }
        public function get_my_professionals(){
            return $this->_db->get_assoc('users', array('user_perms_id','=',4))->results_assoc();
        }
        public function get_my_moderators(){
            return $this->_db->get_assoc('users', array('user_perms_id','=',3))->results_assoc();
        }
        public function get_refer_question(){
            return $this->_db->get_multiple('question_moderator', array('answered','=','no','reffered','=','yes'))->results_assoc();
        }





        //For pagination system is the next two functions used

        public function readArticles($page, $table)
        {
            $this->calc_pages = $this->perpage * $page;
            $this->start_pages = $this->calc_pages - $this->perpage;
            /* Look if $page = 1, then $this->start_pages = 0, so this Query retrive article index 0 to 5 */
            return $this->_db->pagination($table,$this->start_pages, $this->perpage);

        }

        public function forPagination($page, $table, $column,$page2nav)
        {

            /*To Find out how may rows in articles table & Store the result in a virtual column name "Total"*/
            $this->all_pages = $this->_db->getAll_assoc($table, $column)->count_assoc();
            //$this->_db->count_assoc() = $this->all_pages;

            /*Ceil will take the Highest value. like fi the result is 4.1 ceil make it 5*/
            $totalPages = ceil($this->all_pages / $this->perpage);
            echo "<ul class='pagination'>";
            if($page <=1 )
            {
                /*If the page is less than 1 or 1 the Prev will not hold any link*/
                echo "<li><span id='page_links' style='font-weight: bold;'>&laquo; Prev</span></li>";
            }
            else
            {
                /*otherwise Prev always hold the previous page link*/
                $j = $page - 1;
                echo "<li><span><a id='page_a_link' href='".$page2nav.".php?page=$j'> &laquo; Prev</a></span></li>";
            }
            for($i=1; $i <= $totalPages; $i++)
            {
                if($i<>$page)
                {
                    /*If the page not 1 the print the page number & hold the link.*/
                    echo "<li><span><a id='page_a_link' href='".$page2nav.".php?page=$i'>$i</a></span></li>";
                }
                else
                {
                    /*If the page is 1 the Display 1 & don't hold any link*/
                    echo "<li><span id='page_links' style='font-weight: bold;'>$i</span></li>";
                }
            }
            if($page == $totalPages )
            {
                /*If the page is last page then "Next" don't hold any link*/
                echo "<li><span id='page_links' style='font-weight: bold;'>Next &raquo;</span></li>";
            }
            else
            {	/*If the page is not last then "Next" hold the link of the next page*/
                $j = $page + 1;
                echo "<li><span><a id='page_a_link' href='".$page2nav.".php?page=$j'>Next &raquo;</a></span></li>";
            }
            echo "</ul>";
        }

        public function display_pagination($table, $column){
            $start = $this->start_pages+1;
            $per_page = $this->calc_pages;
            $total = $this->_db->getAll_assoc($table, $column)->count_assoc();;
            $show = "<p id=\"picCount\">Displaying ";
            $show .= $start;
            if ($start < $total) {
                $show .= ' to ';
                if ($per_page < $total) {
                    $show .= $per_page;
                }
                else {
                    $show .= $total;
                }
            }
            $show .= " of ".$total;
            $show .= "</p>";
            echo $show;
        }
        public function count(){
            return $this->_db->count_assoc();
        }

        public function search_box($search_term,$search_in){
            $search_term = "%".$search_term."%";
                 switch($search_in){
                case 'members': //search in portfolio table
                    $view =  $this->_db->get_triple_either('users',array('firstname','LIKE',$search_term,'surname','LIKE',$search_term,'othername','LIKE',$search_term))->results_assoc();
                    $this->_student_count = $this->_db->get_triple_either('users',array('firstname','LIKE',$search_term,'surname','LIKE',$search_term,'othername','LIKE',$search_term))->count();
                    break;
                case 'category':
                    $view =  $this->_db->get_assoc('blog_category',array('cat_name','LIKE',$search_term))->results_assoc();
                    $this->_student_count = $this->_db->get_assoc('blog_category',array('cat_name','LIKE',$search_term))->count();
                    break;
                case 'users':
                    $view =  $this->_db->get('users',array('email','LIKE',$search_term,'phone_number','LIKE',$search_term))->results();
                    $this->_student_count =$this->_db->count();
                    break;
                case 'shared_files'://search by room no
                    $view =  $this->_db->get_assoc('shared_files',array('paper_title','LIKE',$search_term))->results_assoc();
                    $this->_student_count = $this->_db->get_assoc('shared_files',array('paper_title','LIKE',$search_term))->count();
                    break;
            }

            return $view;
        }
        public function get_all_chapters(){
            return $this->_db->getAll('chapters')->results_assoc();
        }
        public function meeting_rendezvous($id){
            return $this->_db->fetch_exact('chapters','chapter_id', $id);
        }
        public function get_national_exco(){
            return $this->_db->get_assoc('national_exco',array('current','=',1))->results_assoc();
        }
        public function get_chapter_exco(){
            return $this->_db->get_assoc('chapters_exco',array('chapter_id','=',Session::get('chapter_id')))->results_assoc();
        }
        public function get_all_enrolment_fee($fee = null){
            if(isset($fee)){
                return $this->_db->get_assoc('enrollment_fees',array('enrol_id','=',$fee))->results_assoc();
            }else{
                return $this->_db->getAll('enrollment_fees')->results_assoc();

            }
        }
        public function get_particular_enrolment_fee($cadre, $status){
            return $this->_db->get_multiple('enrollment_fees',array('membership_cadre','=', $cadre,'status','=',$status))->results_assoc();
        }
        public function get_about_specific($about_id){
            return $this->_db->get_assoc('about_us', array('about_us_id','=',$about_id))->results_assoc();
        }
        public function get_team(){
            return $this->_db->getAll('team')->results_assoc();
        }
        public function get_team_member($member_id){
            return $this->_db->get_assoc('team', array('id','=',$member_id))->results_assoc();
        }
        public function get_my_forum($user){
            return $this->_db->get_assoc('forums_members', array('id','=',$user))->results_assoc();
        }
        public function get_forums_listed($user){
            $list = array();

            $forums = $this->_db->get_assoc('forums_members', array('id','=',$user))->results_assoc();
            foreach($forums as $my){
                array_push($list,$my['forum_id']);
            }
            return $list;

        }
        public function get_accepted_friends($user){
            return $this->_db->get_assoc('forums_members', array('id','=',$user))->results_assoc();
        }

        public function find_friends($user){
            $friends = array();
			array_push($friends,$user);
			
            $first = $this->_db->get_multiple('friendship_request', array('sender','=',$user,'respond','=','yes'))->results_assoc();
            foreach($first as $f){
                array_push($friends,$f['receiver']);
            }
            $second = $this->_db->get_multiple('friendship_request', array('receiver','=',$user,'respond','=','yes'))->results_assoc();
            foreach($second as $s){
                array_push($friends,$s['sender']);
            }


            return ($friends);

            //return $this->_db->get_multiple_either('peer2peer', array('first_person','=',$user,'second_person','=',$user),'p2p_id')->results_assoc();
        }
        public function all_people(){
            return $this->_db->getAll_assoc('users')->results_assoc();

        }
        public function get_multiple_forum($user, $forum){
        return $this->_db->get_multiple('forums_members', array('id','=',$user,'forum_id','=',$forum))->results_assoc();
    }
        public function check_friendship_status($user, $forum){
            return $this->_db->get_multiple('forums_members', array('id','=',$user,'forum_id','=',$forum))->results_assoc();
        }
        public function get_forum_name($contact_id){
            return $this->_db->get_assoc('forums', array('forum_id','=',$contact_id))->results_assoc();
        }
        public function get_forum_chat($forum_id,$yes='yes'){
            return $this->_db->get_multiple('forum_chat', array('forum_id','=',$forum_id,'approved','=',$yes),'post_id')->results_assoc();
        }
        public function get_forum_replys($post_id,$forum_id){
            return $this->_db->get_multiple('forum_reply', array('post_id','=',$post_id,'forum_id','=',$forum_id))->results_assoc();
        }
        public function get_forum_members($contact_id){
            return $this->_db->get_assoc('forums_members', array('forum_id','=',$contact_id))->results_assoc();
        }
        public function forums_I_Admin($admin_id){
            return $this->_db->get_assoc('forums', array('moderator','=',$admin_id))->results_assoc();
        }
        public function chats_to_approve($admin){
            $my_forums = $this->forums_I_Admin($admin);
            foreach($my_forums as $my){
                return $this->get_forum_chat($my['forum_id'],'no');
            }
        }
        public function get_all_forum(){
            return $this->_db->getAll_assoc('forums','forum_id')->results_assoc();
        }
        public function get_moderator($mod_id){
            return $this->_db->get_assoc('forums', array('moderator','=',$mod_id))->results_assoc();
        }
        public function remove_something($no,$table,$column){
            $thing_id = $no;
            $this->_db->delete($table,array($column,'=',$thing_id));
            return true;
        }
        public function get_all_question(){
            return $this->_db->getAll('iq_test_questions')->results_assoc();
        }
        public function get_question($about_id){
            return $this->_db->get_assoc('iq_test_questions', array('question_id','=',$about_id))->results_assoc();
        }
        public function my_pdf_uploads($person_id){
            $found = $this->_db->get_assoc('technical_papers', array('uploaded_by','=',$person_id))->results_assoc();
            $this->_student_count = $this->_db->get_assoc('technical_papers', array('uploaded_by','=',$person_id))->count();
            return $found;
        }

        public function resource_info($paper_id){
            return $this->_db->fetch_exact('technical_papers','paper_id',$paper_id);
        }

        public function latest_news(){
            return $this->_db->fetch_last('news_desk','news_id');
        }


        public function get_two_tables($table1,$table2,$table1_id,$table2_id,$user,$order = NULL,$order_id=NULL){
                $tableOne = $table1;
                $tableTwo = $table2;
                $tableOne_id = $table1.'.'.$table1_id;
                $tableTwo_id = $table2.'.'.$table2_id;
                    if(isset($order) && isset($order_id)){
                        $orderTable_id = $order.'.'.$order_id;
                    }else{
                        $orderTable_id = NULL;
                    }
                return $this->_db->get_jointed($tableOne,$tableTwo,$tableOne_id,$tableTwo_id, array($tableOne_id,'=',$user),$orderTable_id)->results_assoc();

        }
        //ends elites hut scripts


        public function get_all_blog_titles($public = true){
            if($public){
                return $this->_db->get_assoc('blog_post',array('post_status','=','publish'),'post_id')->results_assoc();
            }
            else{
                return $this->_db->getAll_assoc('blog_post','post_id')->results_assoc();
            }
        }

        public function get_blog_post($post_id = NULL){
            if($post_id){
                $result =  $this->_db->fetch_exact('blog_post','post_id',$post_id);
            }else{
                $result = $this->_db->fetch_last('blog_post','post_id','post_status', 'publish');

            }
            return $result;
        }

        function blog_category($cat_id){
            return $this->_db->fetch_exact('blog_category','cat_id',$cat_id);
        }
        function blog_tag($tag_id){
            return $this->_db->fetch_exact('blog_tag','tag_id',$tag_id);
        }

        public function get_blog_comments($post_id){
            return $this->_db->get_assoc('blog_comments',array('post_id','=',$post_id))->results_assoc();
        }
        public function get_comment_reply($comment_id){
            return $this->_db->get_assoc('blog_comment_reply',array('comment_id','=',$comment_id))->results_assoc();
        }




        public function login($username = null, $password = null,$remember = false){
            if(!$username && !$password && $this->exists()){
                //log user in
                Session::put($this->_sessionName,$this->data()->id);

            }else{
                $user = $this->find($username);
                if($user){
                    if($this->data()->password === Hash::make($password, $this->data()->salt)){
                        Session::put($this->_sessionName, $this->data()->id);
                        //	return true;
                        if($remember){
                            $hash = Hash::unique();
                            $hashCheck = $this->_db->get('user_sessions',array('user_id','=',$this->data()->id));
                            if(!$hashCheck->count()){
                                $this->_db->insert('user_sessions',array(
                                    'user_id' => $this->data()->id,
                                    'hash' => $hash
                                ));
                            }else{
                                $hash = $hashCheck->first()->hash;
                            }

                            Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));

                        }
                        return true;
                    }
                }
            }
            return false;
        }
        public function hasPermission($key){
            $group = $this->_db->get('user_permissions',array('id', '=',$this->data()->user_perms_id));
            if($group->count()){
                $permissions = json_decode($group->first()->permissions, true);
                //print_r($permissions);
                if($permissions[$key]== true){
                    return true;
                }
            }
            return false;
        }

        public function exists(){
            return (!empty($this->_data)) ? true : false;
        }

        public function logout(){
            $this->_db->delete('user_sessions',array('user_id','=',$this->data()->id));

            Session::delete($this->_sessionName);
            Cookie::delete($this->_cookieName);
            return true;
        }

        public function data(){
            return $this->_data;
        }

        public function isLoggedIn(){
            return $this->_isLoggedIn;
        }

        public function last_insert_id(){
            return array($this->_db->last_insert_id());
        }

    }

?>