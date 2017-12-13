<?php

class Ratechat_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function create_rate($upload = null, $update = null){

        $this->db->insert('ratechat',array(
            'creator' => Session::get('user_id'),
            'name' => Input::get('name'),
            'description' => Input::get('description'),
            'rate_type' => Input::get('rate_type'),
            'upload' => $upload,
            'date' => $this->today,
        ));

        $return = $this->db->last_insert_id();
        $this->send_notification('create_rate',Session::get('user_id'),0,$return);
        Session::put('ratechat_id_created',$return);

        Session::put('home','New Rating was created successfully');

        return $return;
    }

    public function create_rate_content($upload = null,$update = null){

        $this->db->insert('ratechat_rate_content',array(
            'ratechat_id' => Session::get('ratechat_id_created'),
            'created_by' => Session::get('user_id'),
            'name' => Input::get('name'),
            'description' => Input::get('description'),
            'content_type' => 'none',
            'file_name' => $upload,
            'date' => $this->today,
        ));

        $return = $this->db->last_insert_id();

        Session::put('home','New Rate content was created successfully');

        return $return;
    }


    public function publish_rate(){

        $this->db->update('ratechat',array(
            'date' => $this->today,
            'publish' => 1,
        ),'id',Session::get('ratechat_id_created'));

        Session::put('home','Rate chat was published for general consumption');
        return true;
    }

    public function get_rating_list(){
        $menu = null;
        $create = null;
        $rate = $this->db->get('ratechat',null,'id','DESC')->results();
        foreach($rate as $r){
            $joins = $this->db->fetch_exact_two('ratechat_joins','user_id',Session::get('user_id'),'ratechat_id',$r->id);
            $j = ($joins)? ' text-purple': ' text-orange';
            $star = ($r->rate_type == 'star')? 'fa-star-half-o' :'fa-spinner';
            $star .= $j;

            $count = $this->db->get('ratechat_rate_content',array('ratechat_id','=',$r->id))->count();
            if(($r->creator == Session::get('user_id'))){
                $create[] = array(
                    'name' => $r->name,
                    'description' => $r->description,
                    'creator' => $r->creator,
                    'seen' => $star,
                    'count' => $count,
                    'publish' => $r->publish,
                    'id' => $r->id,
                );
            }
            $menu[] = array(
                'name' => $r->name,
                'description' => $r->description,
                'creator' => $r->creator,
                'seen' => $star,
                'publish' => $r->publish,
                'id' => $r->id,
                'count' => $count,
            );

        }
        return array($menu, $create);
    }


    public function ratechat_video() {
        try{
            $check = $this->db->fetch_exact('ratechat_video','user_id',Session::get('user_id'));

            if($check){
                $this->db->update('ratechat_video', array(
                    'url' => Input::get('url_link'),
                    'date' => $this->today,
                ),'user_id',Session::get('user_id'));
                $message = "Updated successfully... Please proceed.";
            }else{
                $this->db->insert('ratechat_video', array(
                    'url' => Input::get('url_link'),
                    'user_id' => Session::get('user_id'),
                    'date' => $this->today,
                ));
                $message = "Added successfully... Please proceed.";
            }

            cleanUP();
            Session::flash('home',$message);

            return true;

        }catch(Exception $e){
            return false;
        }


    }

    public function ratechat_pictures($file) {
        try{
            $this->db->insert('ratechat_pictures', array(
                'user_id' => Session::get('user_id'),
                'title' => Input::get('title'),
                'description' => Input::get('description'),
                'tag' => Input::get('tag'),
                'file' => $file,
                'date' => $this->today,
            ));


            cleanUP();
            Session::flash('home','Added Successfully');

            return true;

        }catch(Exception $e){
            return false;
        }


    }

    public function ratechat_questions() {
        try{
            $this->db->insert('ratechat_questions', array(
                'question' => Input::get('question'),
                'scope' => Input::get('scope'),
                'asked_by' => Session::get('user_id'),
                'date_asked' => $this->today,
                'date_updated' => $this->today,
            ));

            cleanUP();
            $message = "That was done successfully... Please proceed.";
            Session::flash('home',$message);

            return true;

        }catch(Exception $e){
            return false;
        }


    }

    function get_ratechat_questions($next){
        $check = $this->db->get('ratechat_answers',array('ratechat_id','=',$next))->first();

        if(!$check){
            $this->db->insert('ratechat_joins', array(
                'ratechat_id' => $next,
                'user_id' => Session::get('user_id'),
                'date' => $this->today,
            ));
            $this->send_notification('rate_respond',Session::get('user_id'),0,$next);
        }

        $rate = $this->db->fetch_exact('ratechat','id',$next);
        $content = $this->db->get('ratechat_rate_content',array('ratechat_id','=',$next))->results();
        if($rate['rate_type'] == 'vote'){
            $responses = $this->db->get('ratechat_vote',array('ratechat_id','=',$next,'user_id','=',Session::get('user_id')))->first();
        }else{
            $responses = array();
            $response = $this->db->get('ratechat_stars',array('ratechat_id','=',$next,'user_id','=',Session::get('user_id')))->results();
            foreach($response as $r){
                $responses[] = $r->id;
            }

        }
        return array($rate, $content, $rate['rate_type'],$responses);

    }

    function get_ratechat_responses($next){
        $rate = $this->db->fetch_exact('ratechat','id',$next);

        $content = $this->db->get('ratechat_rate_content',array('ratechat_id','=',$next))->results();

        if($rate['rate_type'] == 'vote'){
            $responses = array();
            foreach($content as $c){
                $responses[] = $this->db->get('ratechat_vote',array('ratechat_id','=',$next,'for_id','=',$c->id))->count();
            }
        }else{
            $responses = array();
           // $answers = $this->db->get('ratechat_answers',array('ratechat_id','=',$next))->results();
            //$stars = $this->db->get('ratechat_stars',array('ratechat_id','=',$next,'user_id','=',Session::get('user_id')))->results();
            $five = array();
            $four = array();
            $three = array();
            $two = array();
            $one = array();
            $stars = array();
            foreach($content as $r){
                $sower = $this->db->get('ratechat_stars',array('ratechat_id','=',$next,'for_id','=',$r->id))->results();
                if($this->db->count()){
                    $flight = $this->db->count();
                    foreach($sower as $s){
                        $stars[] = $s->stars;
                        switch($s->stars){
                            case 5: $five[] = $s->id; break;
                            case 4: $four[] = $s->id; break;
                            case 3: $three[] = $s->id; break;
                            case 2: $two[] = $s->id; break;
                            case 1: $one[] = $s->id; break;
                        }

                    }
                    $truth = round((array_sum($stars)/count($stars)),1);

                }else{
                    $truth = 0;
                }
                $responses[] = array(
                    'total' => ($truth),
                    'five' => count($five),
                    'four' => count($four),
                    'three' => count($three),
                    'two' => count($two),
                    'one' => count($one),
                    'name' => $r->name,
                    'file_name' => $r->file_name,
            );
            }
        }
       return array($rate, $content, $rate['rate_type'],$responses);

    }

    function voteCube($slug = null){

        $this->db->insert('ratechat_vote',array(
            'for_id' => Input::get('content'),
            'ratechat_id' => Input::get('rate'),
            'user_id' => Session::get('user_id'),
            'date' => $this->today,
        ));

        echo("Thank you for your response. Please wait... Processing... You are in a secure environment.<br/> Secure OTP is:  ".$slug);
        return true;

    }


    public function starRater(){
        $star = explode('_',Input::get('widget_id'));
        $check = $this->db->get('ratechat_stars',array('for_id','=',$star[2]))->first();

        if($check){
            $this->db->pumpUpdate('ratechat_stars', array(
                'stars' => Input::get('clicked_on'),
                'date' => $this->today,
            ),array('for_id','=',$star[2],'ratechat_id','=',$star[1],'user_id','=',Session::get('user_id')));
        }else{
            $this->db->insert('ratechat_stars', array(
                'ratechat_id' => $star[1],
                'stars' => Input::get('clicked_on'),
                'for_id' => $star[2],
                'user_id' => Session::get('user_id'),
                'date' => $this->today,
            ));
        }
        cleanUP();
        return true;
    }

    public function ratechatAnswers() {
        $rate = Input::get('rate');;
        $content = Input::get('content');
        $check = $this->db->get('ratechat_answers',array('ratechat_id','=',$rate,'content_id','=',$content))->first();

        try{
            if($check){
                $this->db->pumpUpdate('ratechat_answers', array(
                    'answer' => Input::get('rate_comment'),
                    'date_updated' => $this->today,
                ),array('content_id','=',$content,'ratechat_id','=',$rate,'user_id','=',Session::get('user_id')));
            }else{
                $this->db->insert('ratechat_answers', array(
                    'ratechat_id' => $rate,
                    'content_id' => $content,
                    'answer' => Input::get('rate_comment'),
                    'user_id' => Session::get('user_id'),
                    'date_answered' => $this->today,
                    'date_updated' => $this->today,
                ));

            }

            cleanUP();

            return true;

        }catch(Exception $e){
            return false;
        }


    }

    public function ratechat_vote_criteria() {
        try{
            $this->db->insert('ratechat_vote_criteria', array(
                'criteria' => Input::get('criteria'),
                'scope' => Input::get('scope'),
                'description' => Input::get('description'),
                'created_by' => Session::get('user_id'),
                'date' => $this->today,
            ));

            cleanUP();
            $message = "That was done successfully... Please proceed.";
            Session::flash('home',$message);

            return true;

        }catch(Exception $e){
            return false;
        }


    }

    public function get_ratechat_criteria() {
        $data = $this->db->get('ratechat_vote_criteria')->results();
        return $data;

    }


        function retrieve($action){
        $echo = '';
        switch ($action) {
            case "faculty":
                $data =  $this->db->get('unizik_depts',array('faculty_id','=',Input::get('faculty')))->results();
                $echo = '<option value="0">Select Department</option>';
                foreach($data as $d){
                    $echo .= '<option  value="'.$d->id.'"';
                    $echo .= '>'.$d->name.'</option>';

                }

                break;
            case "dept":
                $data =  $this->db->fetch_exact_two('ratechat','year',Input::get('grad_year'),'dept',Input::get('department'));

                $echo = '<option value="0">Select Name</option>';
                $people =  $this->db->get('users',array('ratechat_id','=',$data['id']))->results();

                foreach($people as $d){
                    $name = $d->surname.' '.$d->firstname.' '.$d->othername;
                    if(!empty($d->surname)){
                        $name .= " aka ".$d->nickname;
                    }
                    $echo .= '<option  value="'.$d->id.'"';
                    $echo .= '>'.$name.'</option>';

                }

                break;

            case "name":
                $data = $this->db->fetch_exact('users','id',Input::get('name_id'));
                $echo = $data['slug'];
                break;

        }
        echo($echo);
    }

    function timeline($user){
        $person = isset($user)? $user : Session::get('logged_in_user_slug');

        $use = $this->db->fetch_exact('users','slug',$person);
        $user = $use['id'];


        if(!$user){
            Session::put('error','Invalid request - User With ID not found.');
            Redirect::to(URL.'ratechat');
        }
        $items = array();
        //get video
        $video = $this->db->fetch_exact('ratechat_video','user_id',$user);
        $items[] = array('video' => array(
            'url' =>$video['url'],
            'date' => $video['date'],
        ));

        //get pictures
        $pictures = $this->db->get('ratechat_pictures',array('user_id','=',$user))->results();
        $pix = array();
        foreach($pictures as $p){
            $pix[] = array(
                'image' => $p->file,
                'title' => $p->title,
                'description' => $p->description,
                'date' => $p->date,
            );
        }
        $items[] = array('image' => $pix);

        //get responses to questions
        $responses = $this->db->get('ratechat_answers',array('user_id','=',$user))->results();
        $reply = array();
        foreach($responses as $r){
            $question = $this->db->fetch_exact('ratechat_questions', 'id',$r->question_id);
            $reply[] = array(
                'question' => $question['question'],
                'reply' => $r->answer,
                'date' => $r->date_answered,
            );
        }
        $items[] = array('question' => $reply);

        //check if for next, previous or go to start of class
        return $items;
    }

    function get_everyone_in_my_class($class = null){
        $data =  $this->db->get('users')->results();

        $echo = array();
        foreach($data as $d){
            $name = $d->surname.' '.$d->firstname.' '.$d->othername;
            if(!empty($d->nickname)){
                $name .= " aka ".$d->nickname;
            }
            $echo[] = array(
                'name' => $name,
                'id' => $d->id,
                'slug' => $d->slug,
            );

        }


        return $echo;

    }

    public function i_nominate() {
        try{
            $criteria = Input::get('position');
            $nominee = $this->get_id_from_slug(Input::get('student_id'));
            $check = $this->db->get('ratechat_vote_nominees',array('criteria','=',$criteria,'nominee','=',$nominee))->results();
            if(!$this->db->count()){
                $this->db->insert('ratechat_vote_nominees', array(
                    'criteria' => $criteria,
                    'nominee' => $nominee,
                    'nominated_by' => Session::get('user_id'),
                    'date' => $this->today,
                ));
                $message = "That was done successfully... Please proceed.";

            }else{
                $message = "The Person has already been nominated... Please proceed.";

            }

            cleanUP();
            Session::flash('home',$message);

            return true;

        }catch(Exception $e){
            return false;
        }


    }

    function get_nominees($next = null){
        $this->getNextVote();

        $last_vote = $this->db->fetch_last('ratechat_voters', 'id','voter_id',Session::get('user_id'));
        $nominations = $this->db->get('ratechat_vote_nominees')->results();
        $norm = '';
        $last = isset($last_vote['criteria'])? $last_vote['criteria'] : 0;
        foreach($nominations as $n){
            if($n->criteria > $last){
                $norm = $n->criteria;
                break;
            }
        }
        $person = array();
        $criteria = $this->db->fetch_exact('ratechat_vote_criteria','id',$norm);
        foreach($nominations as $n){
            if($n->criteria == $norm){
                $name = $this->db->fetch_exact('users','id',$n->nominee);
                $vote = $this->db->get('ratechat_voters',array('voting_for','=',$n->nominee,'criteria','=',$norm));
                $vote_count = $this->db->count();

                $person[] = array(
                    'user_id' => $n->nominee,
                    'profile_picture' => $name['profile_picture'],
                    'name' => $name['surname'].' '.$name['firstname'].' '.$name['othername'].' '.$name['nickname'],
                    'votes' => $vote_count,
                );

            }

        }

        return array($person,$criteria);
    }


    function get_id_from_slug($slug){
        $nominee = $this->db->fetch_exact('users','slug',$slug);
        return $nominee['id'];

    }




    function get_person_award($user){
        $use = $this->db->fetch_exact('users','slug',$user);
        //get award if awarded
        $award = $this->db->get('ratechat_vote_nominees',array('nominee','=',$user))->results();
        $honour = array();
        foreach($award as $a){
            //get all contestants and vote for that criteria
            $peeps = array();
            $contestants = $this->db->get('ratechat_voters',array('ratechat_id','=',$use['ratechat_id'],'criteria','=',$a->id))->results();
            foreach($contestants as $c){
                if(in_array($c->voting_for,$peeps)){
                    $peeps[$c->voting_for][] = $c->voter_id;
                }else{
                    $peeps[$c->voting_for][] = $c->voter_id;

                }
            }
            $keys = (array_keys($peeps));
            $owner = count($peeps[$user]);
            echo('  Owner is '.$owner.' ');
            $winner = false;

            for($i=0; $i< count($keys); $i++){
                if($keys[$i] == $user){
                    //do nothing
                }else{
                    $votes = count($peeps[$keys[$i]]);
                    echo(' Other is '.$votes);
                    if($owner >= $votes){
                        $winner = true;
                        continue;
                    }else{
                        $winner = false;
                    }

                }
            }

            //populate the criteria
            if($winner){
                //SELECT ``, ``, `scope`, `ratechat_id`, `description`, `created_by`, `date` FROM `` WHERE 1
                $cite = $this->db->fetch_exact('ratechat_vote_criteria','id',$a->criteria);
                $honour[] = array('criteria' =>$cite['criteria'] );
            }


        }
        $items[] = array('honour' => $honour);

    }

    function get_role_of_honour(){
        $possible = array();
        $pos = $this->db->get('ratechat_vote_criteria')->results();
        foreach($pos as $p){
            $nominee = $this->db->get('ratechat_vote_nominees',array('criteria','=',$p->id))->results();
            $person = array();
            $votes = array();
            //$criteria = array();
            foreach($nominee as $n){
                $contestants = $this->db->get('ratechat_voters',array('voting_for','=',$n->nominee,'criteria','=',$n->id))->results();
                $votes[] = $this->db->count();
                $person[] = $n->nominee;
            }

            arsort($votes);

            foreach($votes as $x=>$x_value)
            {
                $Key = $x;
                $Value = $x_value;
                $person = $person[$Key];
                break;
            }


            $name = $this->db->fetch_exact('users','id',$person);
            $name = $name['surname'].' '.$name['firstname'].' '.$name['othername'];

            if(($p->scope == 2) || $p->scope == 1){
                $possible[] = array(
                    'id' => $p->id,
                    'criteria' => $p->criteria,
                    'description' => $p->description,
                    'name' => $name,
                    'value' => $Value,
                    'colour' => $this->progress_bar($Value),
                );
            }
        }

        return $possible;

    }

    function progress_bar($v){
        if($v >= 70){
            $bg = 'success';
        }elseif($v >= 60){
            $bg = 'primary';
        }elseif($v >= 50){
            $bg = 'info';
        }elseif($v >= 40){
            $bg = 'warning';
        }elseif($v < 40){
            $bg = 'danger';
        }

        return $bg;

    }




















}
