<?php

class Dashboard_Model extends Model {

    function __construct() {
        parent::__construct();
        $this->user = new User();
    }

    public function get_person() {
        $user_id = Session::get('user_id');
        $data = $this->db->fetch_exact('users','id',$user_id);
        Session::put('logged_in_user_first_name', ucwords($data['firstname']));

        return($data);
    }

    function get_persons_details($person_id){
        $personal = $this->db->fetch_exact('users','id',$person_id);

        $group = array();

        $name = $personal['surname'].' '.$personal['firstname'].' '.$personal['othername'].' ';

        $people = array(
            'first' => $personal['firstname'],
            'name' => $name,
            'nick' => $personal['nickname'],
            'email' => $personal['email'],
            'phone_no' => $personal['phone_no'],
            'state_of_birth' => $personal['state_of_birth'],
            'place_of_birth' => $personal['place_of_birth'],
            'passion' => $personal['passion'],
            'hobbies' => $personal['hobbies'],
            'postal_address' => $personal['postal_address'],
            'postal_state' => $personal['postal_state'],
            'occupation' => $personal['occupation'],
            'slug' => $personal['slug'],
            'profile_picture' => $personal['profile_picture'],
            'marital_status' => $personal['marital_status'],
            'sex' => $personal['sex'],
            'dob' => $personal['dob'],
            'state_of_origin' => $personal['state_of_origin'],
            'bio_data' => $personal['bio_data'],
        );


        return array($people, $group);
    }

    public function personnel_rank(){
        $data  = $this->db->get('user_permissions',array('id','<',4))->results();
        return $data;
    }

    public function membership_upgrade($token){
        $data  = $this->db->get('user_permissions',array('id','=',$token))->first()->name;

        $this->db->insert('membership_upgrade', array(
            'user_id' => $_SESSION['user_id'],
            'from_what' => $_SESSION['role_name'],
            'to_what' => $data,
            'date' => $this->today,
        ));

        $this->db->update('users', array(
            'user_perms_id' => $token,
        ),'id', $_SESSION['user_id']);

        Session::put('role_name',$data);

        Session::put('home','Successfully Upgraded to '.$data);

        cleanUP();
        return true;

    }

    public function find_friends($search){
        $search_term = "%".$search."%";
        $view =  $this->db->get('users',array('firstname','LIKE',$search_term,'surname','LIKE',$search_term,'othername','LIKE',$search_term),'firstname','ASC','OR')->results();
        $members = null;
        $celebs = null;
        $execs = null;
        $i=1;
        foreach($view as $v){
            if($v->id == Session::get('user_id') ){ continue; }
            $request = 'no';

            $date = new DateTime($v->dob);
            $dob = $date->format('d, M');
            if($v->user_perms_id == 1){
                $friend = $this->db->get('friendships',array('receiver','=',$v->id,'sender','=',Session::get('user_id')),'id','ASC','AND')->first();
                if(($friend)){
                    $request = ($friend->accepted == 1)? 'Friends':'Cancel';
                }
                $friend = $this->db->get('friendships',array('sender','=',$v->id,'receiver','=',Session::get('user_id')),'id','ASC','AND')->first();
                if(($friend)){
                    $request = ($friend->accepted == 1)? 'Friends':'Decline';
                }

                $members[] = array(
                    'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                    'nick' => $v->nickname,
                    'id' => $v->id,
                    'username' => $v->slug,
                    'pix' => $v->profile_picture,
                    'sex' => $v->sex,
                    'marital_status' => $v->marital_status,
                    'dob' => $dob,
                    'no' => $request,
                );
            }elseif($v->user_perms_id == 2){
                $friend = $this->db->get('friendships',array('receiver','=',$v->id,'sender','=',Session::get('user_id')),'id','ASC','AND')->first();
                if(($friend)){
                    $request = 'Fanning';
                }
                $friend = $this->db->get('friendships',array('sender','=',$v->id,'receiver','=',Session::get('user_id')),'id','ASC','AND')->first();
                if(($friend)){
                    $request = 'Fanning';
                }

                $celebs[] = array(
                    'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                    'nick' => $v->nickname,
                    'id' => $v->id,
                    'username' => $v->slug,
                    'pix' => $v->profile_picture,
                    'sex' => $v->sex,
                    'marital_status' => $v->marital_status,
                    'dob' => $dob,
                    'no' => $request,
                );
            }elseif($v->user_perms_id == 3){
                $friend = $this->db->get('friendships',array('receiver','=',$v->id,'sender','=',Session::get('user_id')),'id','ASC','AND')->first();
                if(($friend)){
                    $request = 'Following';
                }
                $friend = $this->db->get('friendships',array('sender','=',$v->id,'receiver','=',Session::get('user_id')),'id','ASC','AND')->first();
                if(($friend)){
                    $request = 'Following';
                }

                $execs[] = array(
                    'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                    'nick' => $v->nickname,
                    'id' => $v->id,
                    'username' => $v->slug,
                    'pix' => $v->profile_picture,
                    'sex' => $v->sex,
                    'marital_status' => $v->marital_status,
                    'dob' => $dob,
                    'no' => $request,
                );
            }
            $i++;
        }

        return array($members,$celebs,$execs);

    }

    public function get_my_friends($id = null){
        $id = isset($id) ? $id : Session::get('user_id');
        $members = null;
        $celebs = null;
        $execs = null;

        // get those in the same user level
        $friend = $this->db->get('friendships',array('receiver','=',$id,'sender','=',$id),'id','ASC','OR')->results();
        foreach($friend as $f){
            $user_id = ($f->sender == $id)? $f->receiver : $f->sender;
            $v = $this->db->get('users',array('id','=',$user_id))->first();

            $date = new DateTime($v->dob);
            $dob = $date->format('d, M');
            if($v->user_perms_id == 1 && $f->accepted == 1){
                $members[] = array(
                    'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                    'nick' => $v->nickname,
                    'id' => $v->id,
                    'username' => $v->slug,
                    'pix' => $v->profile_picture,
                    'sex' => $v->sex,
                    'marital_status' => $v->marital_status,
                    'dob' => $dob,
                );
            }elseif($v->user_perms_id == 2){
                $celebs[] = array(
                    'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                    'nick' => $v->nickname,
                    'id' => $v->id,
                    'username' => $v->slug,
                    'pix' => $v->profile_picture,
                    'sex' => $v->sex,
                    'marital_status' => $v->marital_status,
                    'dob' => $dob,
                );
            }elseif($v->user_perms_id == 3){
                $execs[] = array(
                    'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                    'nick' => $v->nickname,
                    'id' => $v->id,
                    'username' => $v->slug,
                    'pix' => $v->profile_picture,
                    'sex' => $v->sex,
                    'marital_status' => $v->marital_status,
                    'dob' => $dob,
                );
            }
        }

        return array($members,$celebs,$execs);
    }

    public function get_my_friends_once($id = null){
        $id = isset($id) ? $id : Session::get('user_id');
        $members = null;
        $celebs = null;
        $execs = null;

        // get those in the same user level
        $friend = $this->db->get('friendships',array('receiver','=',$id,'sender','=',$id),'id','ASC','OR')->results();
        foreach($friend as $f){
            $user_id = ($f->sender == $id)? $f->receiver : $f->sender;
            $v = $this->db->get('users',array('id','=',$user_id))->first();
            // trying to get the last dm message
            //$last_dm = $this->db->get('direct_chat',array('receiver','=',$user_id,'sender','=',$user_id))->first();


            $date = new DateTime($v->lastLogin);
            $dob = $date->format('d D, M h:i a');
            if($v->user_perms_id == 1 && $f->accepted == 1){
                $members[] = array(
                    'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                    'id' => $v->id,
                    'username' => $v->slug,
                    'pix' => $v->profile_picture,
                    'sex' => $v->sex,
                    'marital_status' => $v->marital_status,
                    'lastLogin' => $dob,
                    'member' => 'Friend',
                );
            }elseif($v->user_perms_id == 2){
                $members[] = array(
                    'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                    'id' => $v->id,
                    'username' => $v->slug,
                    'pix' => $v->profile_picture,
                    'sex' => $v->sex,
                    'marital_status' => $v->marital_status,
                    'lastLogin' => $dob,
                    'member' => 'Celebrity',
                );
            }elseif($v->user_perms_id == 3){
                $members[] = array(
                    'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                    'id' => $v->id,
                    'username' => $v->slug,
                    'pix' => $v->profile_picture,
                    'sex' => $v->sex,
                    'marital_status' => $v->marital_status,
                    'lastLogin' => $dob,
                    'member' => 'Executive',
                );
            }
        }

        return $members;
    }

    public function direct_chat(){
        $data  = $this->db->get('direct_chat')->results();
        return $data;
    }

    public function saveDirectChat(){
        $message = Input::get('message');
        $receiver_id = Input::get('receiver_id');

        $this->db->insert('direct_chat', array(
            'sender' => $_SESSION['user_id'],
            'date' => $this->today,
            'message' => $message,
            'receiver' => $receiver_id,
        ));
        $insert_id = $this->db->last_insert_id();
        $this->send_notification('direct_msg',Session::get('user_id'),$receiver_id,$insert_id);

        $echo = "";
        $echo .= '<div class="direct-chat-msg right">';
        $echo .= '<div class="direct-chat-info clearfix">';
        $echo .= '<span class="direct-chat-name pull-right">You</span>';
        $echo .= '<span class="direct-chat-timestamp pull-left">'.date('dS D, h:i a').'</span>';
        $echo .= '</div>';
        $echo .= '<img class="direct-chat-img" src="'.(Session::get('logged_in_user_photo')).'" alt="'.Session::get('logged_in_user_name').'">';
        $echo .= '<div class="direct-chat-text">';
        $echo .= $message;
        $echo .= '</div>';
        $echo .= '</div>';

        echo($echo);
    }

    public function GetDirectChat($person = null){
        $data = $this->db->get('direct_chat',array('receiver','=',$person,'sender','=',$person),'id','ASC','OR')->results();

        $echo = "";
        foreach($data as $d){
            if(($d->sender == $_SESSION['user_id'])){
                $echo .= '<div class="direct-chat-msg right">';
                $echo .= '<div class="direct-chat-info clearfix">';
                $echo .= '<span class="direct-chat-name pull-right">You</span>';
                $echo .= '<span class="direct-chat-timestamp pull-left">'.date('dS D, h:i a').'</span>';
                $echo .= '</div>';
                $echo .= '<img class="direct-chat-img" src="'.(Session::get('logged_in_user_photo')).'" alt="'.Session::get('logged_in_user_name').'">';
                $echo .= '<div class="direct-chat-text">';
                $echo .= $d->message;
                $echo .= '</div>';
                $echo .= '</div>';
            }elseif(($d->receiver == $_SESSION['user_id'])){
                $person = $this->db->fetch_exact('users','id',$d->sender);
                $name = $person['firstname'].' '.$person['surname'].' '.$person['othername'];
                $photo = URL.'public/uploads/profile/'.$person['profile_picture'];
                $echo .= '<div class="direct-chat-msg">';
                $echo .= '<div class="direct-chat-info clearfix">';
                $echo .= '<span class="direct-chat-name pull-left">'.$name.'</span>';
                $echo .= '<span class="direct-chat-timestamp pull-right">'.date('dS D, h:i a').'</span>';
                $echo .= '</div>';
                $echo .= '<img class="direct-chat-img" src="'.$photo.'" alt="'.$name.'">';
                $echo .= '<div class="direct-chat-text">';
                $echo .= $d->message;
                $echo .= '</div>';
                $echo .= '</div>';

                Session::put('last_active_chat_id',$d->id);

            }
        }
        $echo .= '<div id="directAppend"></div>';


        echo($echo);
    }

    public function GetNewChat($person = null){
        $data = $this->db->get('direct_chat',array('receiver','=',$_SESSION['user_id'],'sender','=',$person,'id','>',Session::get('last_active_chat_id')),'id','ASC','AND')->results();

        if($this->db->count()){
            $echo = "";
            foreach($data as $d){
                $person = $this->db->fetch_exact('users','id',$d->sender);
                $name = $person['firstname'].' '.$person['surname'].' '.$person['othername'];
                $photo = URL.'public/uploads/profile/'.$person['profile_picture'];
                $echo .= '<div class="direct-chat-msg">';
                $echo .= '<div class="direct-chat-info clearfix">';
                $echo .= '<span class="direct-chat-name pull-left">'.$name.'</span>';
                $echo .= '<span class="direct-chat-timestamp pull-right">'.date('dS D, h:i a').'</span>';
                $echo .= '</div>';
                $echo .= '<img class="direct-chat-img" src="'.$photo.'" alt="'.$name.'">';
                $echo .= '<div class="direct-chat-text">';
                $echo .= $d->message;
                $echo .= '</div>';
                $echo .= '</div>';
                Session::put('last_active_chat_id',$d->id);

            }
            echo($echo);
            return true;

        }else{
            return false;
        }


    }


    public function get_people_in_class($search){
        $view =  $this->db->get('users',array('user_perms_id','=',$search),'firstname','ASC')->results();
        $members = null;
        $celebs = null;
        $execs = null;
        $i=1;
        foreach($view as $v){
            if($v->id == Session::get('user_id') ){ continue; }
            $request = 'no';

            $date = new DateTime($v->dob);
            $dob = $date->format('d, M');
            if($v->user_perms_id == 1){
                $friend = $this->db->get('friendships',array('receiver','=',$v->id,'sender','=',Session::get('user_id')),'id','ASC','AND')->first();
                if(($friend)){
                    $request = ($friend->accepted == 1)? 'Friends':'Cancel';
                }
                $friend = $this->db->get('friendships',array('sender','=',$v->id,'receiver','=',Session::get('user_id')),'id','ASC','AND')->first();
                if(($friend)){
                    $request = ($friend->accepted == 1)? 'Friends':'Decline';
                }

                $members[] = array(
                    'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                    'nick' => $v->nickname,
                    'id' => $v->id,
                    'username' => $v->slug,
                    'pix' => $v->profile_picture,
                    'sex' => $v->sex,
                    'marital_status' => $v->marital_status,
                    'dob' => $dob,
                    'no' => $request,
                );
            }elseif($v->user_perms_id == 2){
                $friend = $this->db->get('friendships',array('receiver','=',$v->id,'sender','=',Session::get('user_id')),'id','ASC','AND')->first();
                if(($friend)){
                    $request = 'Fanning';
                }
                $friend = $this->db->get('friendships',array('sender','=',$v->id,'receiver','=',Session::get('user_id')),'id','ASC','AND')->first();
                if(($friend)){
                    $request = 'Fanning';
                }

                $celebs[] = array(
                    'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                    'nick' => $v->nickname,
                    'id' => $v->id,
                    'username' => $v->slug,
                    'pix' => $v->profile_picture,
                    'sex' => $v->sex,
                    'marital_status' => $v->marital_status,
                    'dob' => $dob,
                    'no' => $request,
                );
            }elseif($v->user_perms_id == 3){
                $friend = $this->db->get('friendships',array('receiver','=',$v->id,'sender','=',Session::get('user_id')),'id','ASC','AND')->first();
                if(($friend)){
                    $request = 'Following';
                }
                $friend = $this->db->get('friendships',array('sender','=',$v->id,'receiver','=',Session::get('user_id')),'id','ASC','AND')->first();
                if(($friend)){
                    $request = 'Following';
                }

                $execs[] = array(
                    'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                    'nick' => $v->nickname,
                    'id' => $v->id,
                    'username' => $v->slug,
                    'pix' => $v->profile_picture,
                    'sex' => $v->sex,
                    'marital_status' => $v->marital_status,
                    'dob' => $dob,
                    'no' => $request,
                );
            }
            $i++;
        }

        return array($members,$celebs,$execs);

    }


    public function SendFriendShipRequest(){
        $sender = Input::get('sender');
        $receiver = Input::get('receiver');

        try{
            $this->db->insert('friendships',array(
                'date_sent' => $this->today,
                'sender' => $sender,
                'receiver' => $receiver,
                'accepted' => 0

            ));
            $this->send_notification(Input::get('class'),$sender,$receiver);
            echo('ok');
            return true;

        }catch (Exception $e){
            echo('error');
            return false;
        }

    }

    public function AcceptFriendRequest($block = false){

        try{
            if(!$block){
                /*
                             $this->db->pumpUpdate('friendships',array(
                'date_accepted' => $this->today,
                'accepted' => 1,

            ),array('receiver','=',Session::get('user_id'),'sender','=',Input::get('receiver')));

                 */
                $receiver = Input::get('receiver');
                $this->db->pumpUpdate('friendships',array(
                    'date_accepted' => $this->today,
                    'accepted' => 1,

                ),array('receiver','=',Session::get('user_id'),'sender','=',$receiver));
                $this->send_notification('friend_accept',Session::get('user_id'),$receiver);

            }else{
                $this->db->pumpUpdate('friendships',array(
                    'date_blocked' => $this->today,
                    'blocked' => 1,

                ),array('receiver','=',Session::get('user_id'),'sender','=',Input::get('receiver')));

                $this->db->pumpUpdate('friendships',array(
                    'date_blocked' => $this->today,
                    'blocked' => 1,

                ),array('sender','=',Session::get('user_id'),'receiver','=',Input::get('receiver')));

            }
            echo('ok');
            return true;

        }catch (Exception $e){
            echo('error');
            return false;
        }

    }

    public function RemoveFriendRequest($type = 'Cancel'){

        try{
            switch($type){
                case 'Cancel':
                    $this->db->delete('friendships',array('receiver','=',Input::get('receiver'),'sender','=',Input::get('sender')));
                    break;
                case 'Decline':
                    $this->db->delete('friendships',array('receiver','=',Session::get('user_id'),'sender','=',Input::get('receiver')));
                    break;
            }
            echo('ok');
            return true;

        }catch (Exception $e){
            echo('error');
            return false;
        }

    }










    function search_for_person($str, $event_id = null) {
        $search = $this->user->search_box($str, 'members');
        $search_count = $this->user->count();

        if ($search_count != 0) {

            foreach ($search as $suggestion) {
                if ($suggestion['user_id'] === Session::get('user_id')) {
                    continue; //makes person unable to search for themselves
                }
                $name = $suggestion['firstname'] . ' ' . $suggestion['surname'] . ' ' . $suggestion['othername'];
                if (!empty($profile['profile_picture'])) {
                    $source = URL . 'public/uploads/profile-pictures/' . $profile['profile_picture'];
                } else {
                    $source = URL . 'public/custom/img/avatar.png';
                }

                //$echo = '<img class="img-circle" src="'.$source.'" width="30" height="30">';
                //$echo .= '<a href="'.URL.'profile/member/'.($suggestion['slug']).'">  '.$name.'</a>';
                // $chapter = $this->user->get_person_chapter($suggestion['chapter_id']);
                //$echo .= '<p>Chapter: '. $chapter['chapter_name'];
                $echo = '<div class="col-sm-6">';
                $echo .= '<div class="row">
                        <div class="col-sm-2">';

                $echo .= '<img src="' . $source . '" class="img-circle" height="51px" width="51px"  alt="' . $name . '">';
                $echo .= '</div>
                        <div class="col-sm-10 text-left text-holder">';

                $echo .= '<a href="' . URL . 'profile/member/' . $suggestion['slug'] . '" class="poster-name text-left">' . $name . '</a>';

                $echo .= '</div>';
                $echo .= '</div>';
                $echo .= '<br/>';
                $echo .= '</div>';




                echo($echo);
            }
        } else {
            echo "No suggestion";
        }
    }



    public function lastFive($array, $limit = 10) {
        //produce the last five results
        $lastFive = array();
        for ($i = 0; $i < $limit; $i++) {
            $obj = array_pop($array);
            if ($obj == null)
                break;
            $lastFive[] = $obj;
        }
        return $lastFive;
        //produce the first five results
        $arrayCount = count($array);
        if ($arrayCount > 5) {
            $output = array_slice($array, (-5), $arrayCount);
        } else {
            $output = $array;
        }
    }

    public function wall_post($type = null) {
        $type_id = $this->get_user_hostel();

        if($type_id){
            $data = $this->db->get('post',array('type','=','hostel','type_id','=',$type_id),'post_id')->results();
            $limit = 12;
            $newArray = array();
            foreach ($data as $entry) {
                $newArray[] = array(
                    'post_id' => $entry->post_id,
                    'author_id' => $entry->author_id,
                    'when' => $entry->when,
                    'message' => $entry->message,
                    'post_image' => $entry->post_image,
                    //'tags' => $entry['tags'],
                );

                $arrayCount = count($newArray);
                if ($arrayCount === $limit) {
                    $last_id_picked = $newArray[$limit - 1]['post_id'];
                    Session::put('last_wall_post_id', $last_id_picked);
                    return $newArray;
                    break;
                }
            }
            if (Session::exists('last_wall_post_id'))
                Session::delete('last_wall_post_id');
            return $newArray;

        }else{
            return false;
        }
    }

    public function dept_post($type = null) {
        $data = $this->db->get('post',null,'post_id')->results();
        $relate = $this->get_my_relationships();
        $relate[] = Session::get('user_id');
        $limit = 12;
        $newArray = array();
        foreach ($data as $entry) {
            if(!(in_array($entry->author_id, $relate))){ continue;  }
            $newArray[] = array(
                'post_id' => $entry->post_id,
                'author_id' => $entry->author_id,
                'when' => $entry->when,
                'message' => $entry->message,
                'post_image' => $entry->post_image,
                //'tags' => $entry['tags'],
            );

            $arrayCount = count($newArray);
            if ($arrayCount === $limit) {
                $last_id_picked = $newArray[$limit - 1]['post_id'];
                Session::put('last_wall_post_id', $last_id_picked);
                return $newArray;
                break;
            }
        }
        if (Session::exists('last_wall_post_id'))
            Session::delete('last_wall_post_id');
        return $newArray;
    }

    public function member($name_slug) {
        $personal = $this->db->fetch_exact('users', 'slug', $name_slug);
        $name = $personal['surname'].' '.$personal['firstname'].' '.$personal['othername'].' ';
        $people = $this->get_my_friends($personal['id']);
        $count = count($people);

        $people = array(
            'first' => $personal['firstname'],
            'name' => $name,
            'nick' => $personal['nickname'],
            'slug' => $personal['slug'],
            'profile_picture' => $personal['profile_picture'],
            'marital_status' => $personal['marital_status'],
            'sex' => $personal['sex'],
            'dob' => $personal['dob'],
            'bio_data' => $personal['bio_data'],
            'user_perms_id' => $personal['user_perms_id'],
            'count' => $count,
        );

        return $people;
    }

    function account_update($path = null){
        $data = $this->db->fetch_exact('users','id',Session::get('user_id'));
        $this->db->update('users', array(
            'email' => Input::get('email'),
            'phone_no' => Input::get('phone_no'),
            'state_of_birth' => Input::get('state_of_birth'),
            'place_of_birth' => Input::get('place_of_birth'),
            'passion' => Input::get('passion'),
            'hobbies' => Input::get('hobbies'),
            'postal_address' => Input::get('postal_address'),
            'postal_state' => Input::get('postal_state'),
            'occupation' => Input::get('occupation'),
            'bio_data' => Input::get('bio_data'),

        ),'id',Session::get('user_id'));

        Session::put('home','Account Details Successfully Updated');

        return true;


    }
    function update_password(){
        $data = $this->db->fetch_exact('users','id',Session::get('user_id'));
        if ($data['password'] === Hash::make(Input::get('old_pass'), $data['salt'])) {
            $salt = Hash::salt(32);

            $this->db->update('users', array(
                'password' => Hash::make(Input::get('new_pass'), $salt),
                'salt' => $salt,

            ),'id',Session::get('user_id'));

            Session::put('home','Password Successfully Updated');

        }

        return true;


    }
    function picture_update($path = null){
        $data = $this->db->fetch_exact('users','id',Session::get('user_id'));
        $this->db->update('users', array(
            'profile_picture' => $path,

        ),'id',Session::get('user_id'));
        $myPhoto = URL.'public/uploads/profile/'.$path;
        Session::put('logged_in_user_photo',$myPhoto);
        Session::put('home','Profile Picture Successfully Updated');

        return true;


    }


    function get_broadcast(){
        $results = $this->db->get('broadcast',null,'id','DESC')->results();
        return $results;
    }


    public function load_more_wall_post($type = null) {
        $last_post_id = Session::exists('last_wall_post_id') ? Session::get('last_wall_post_id') : null;
        if ($last_post_id) { //there exists more post
            $post_data = $this->db->get('post',array('post_id', '<', $last_post_id),'post_id')->results();

            $relate = $this->get_my_relationships();
            $relate[] = Session::get('user_id');
            $limit = 10;
            $newArray = array();
            $post_remains = false;
            foreach ($post_data as $entry) {
                if(!(in_array($entry->author_id, $relate))){ continue;  }
                $newArray[] = array(
                    'post_id' => $entry->post_id,
                    'author_id' => $entry->author_id,
                    'when' => $entry->when,
                    'message' => $entry->message,
                    'post_image' => $entry->post_image,
                    //'tags' => $entry['tags'],
                );

                $arrayCount = count($newArray);
                if ($arrayCount === $limit) {
                    $post_remains = true;
                    $last_id_picked = $newArray[$limit - 1]['post_id'];
                    Session::put('last_wall_post_id', $last_id_picked);
                    //$new_posts = $newArray;
                    break;
                } else {
                    $post_remains = false;
                }
            }
            if (!$post_remains){Session::delete('last_wall_post_id'); }

            //return $newArray;


            $echo = '';

            $user = new User();
            foreach ($newArray as $d) {
                list($name, $source, $slug) = $user->get_person_name($d['author_id']);

                if ($d['post_image']) {
                    $picture = '<img src="' . URL . 'public/uploads/wall/' . $d['post_image'] . '" class="img-responsive" height="50%">';
                } else {
                    $picture = '';
                }

                $echo .= "";
                $echo .= '<div class="box box-widget" id="post_holder' . ($d['post_id']) . '">
                <div class="box-header with-border">
                    <div class="user-block">';
                $echo .= '<img src="' . $source . '" class="img-circle" alt="' . $name . '">';
                $echo .= '<span class="username">
                        <a href="' . URL . 'dashboard/profile/' . ($slug) . '" class="poster-name text-left">' . $name . ' </a></span>';
                $echo .= '<span class="description">Shared publicly - <span class="liveTime" data-lta-value="' . $d['when'] . '"></span></span>
                </div>';
                $echo .= '<div class="box-tools">';
                if (Session::get('user_id') == $d['author_id']) {
                    $echo .= '<a href="javascript:void(0);" onClick="callCrudAction(\'delete_post\',' . $d['post_id'] . ')" title="Delete Post" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></a>';
                }

                $echo .= '</div>';
                $echo .= '</div>';
                $echo .= '<div class="box-body">';
                $echo .= $picture;
                $echo .= '<div class="posted_hidden" id="full_post_'. $d["post_id"].'">';
                $echo .= '' . (nl2br($d['message'])) . '';
                $echo .= '</div>';
                $echo .= '<div id="part_post_'.$d["post_id"].'">';
                $extract = substr($d['message'], 0, 500);
                if (strlen($extract) >= 500){
                    $lastSpace = strrpos($extract, ' ');
                    $echo .= nl2br(substr($extract, 0, $lastSpace)).' ... ';
                    $echo .= '<a href="javascript:void(0);" class="text-primary" id="show_post_full" title="View all the text" onclick="showFullStory(\''. $d["post_id"].'\')">continue reading</a>';

                }else{
                    $echo .= (nl2br($d['message']));
                }
                $echo .= '</div>';
                //Likes

                list($likes, $like_count, $user_likes_it, $likers) = $user->get_liked(Session::get('user_id'), 'post_id', $d['post_id']);

                if (!$user_likes_it) {
                    $echo .= '<a href="javascript:void(0);" class="btn btn-default btn-xs" onClick="callCrudAction(\'like_post\',\'' . $d['post_id'] . '\')"';
                    $echo .= ' title="Like it" id="like-btn' . $d['post_id'] . '">';
                    $echo .= '<span class="fa fa-thumbs-o-up"></span> Like
                                        </a>';
                }

                $echo .= '<a href="javascript:void(0);" id="like-count' . $d['post_id'] . '" class="btn btn-link" data-toggle="popover" data-trigger="focus" data-content="'.$likers.'">'.$like_count.'</a>';
                $echo .= '<span class="pull-right text-muted">';
                //Arena for reply
                $replies = $user->get_post_reply($d['post_id']);
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

                $echo .= '<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="toggle(\'all_replies' . $d['post_id'] . '\')" data-toggle="popover" data-trigger="hover" data-content="' . $reply_content . '">
<i class="fa fa-comments" ></i> <span class="label label-default" id="reply-count' . $d['post_id'] . '">' . $reply_count . '</span></a>';
                $echo .= '</span>';
                $echo .= '</div>';


                $echo .= '<div class="box-footer box-comments" id="all_replies' . $d['post_id'] . '">';
                foreach ($replies as $reply) {
                    list($author, $author_img, $author_slug) = $user->get_person_name($reply['author']);

                    $echo .= '<div class="box-comment" id="reply'.$reply['reply_id'] .'">';

                    $echo .= '<img src="' . $author_img . '" class="img-circle img-sm"   alt="' . $author . '">';
                    $echo .= '<div class="comment-text"><span class="username">';
                    $echo .= '<a href="' . URL . 'dashboard/profile/' . $author_slug . '" class="poster-name text-left">' . $author . '</a>';

                    $echo .= '<span class="liveTime text-muted pull-right" data-lta-value="' . $reply['date_posted'] . '"></span></span> ';

                    $echo .= '' . $reply['comment'];
                    $echo .= '</div>';
                    $echo .= '</div>';

                }

                $echo .= '<div id="post-reply' . $d['post_id'] . '"></div>';
                $echo .= '</div>';
                $echo .= '<div class="box-footer">';
                $echo .= '<form method="post" onsubmit="return false">';
                $echo .= '<img src="' . Session::get('logged_in_user_photo') . '" class="img-responsive img-circle img-sm" alt="' . Session::get('logged_in_user_name') . '">';
                $echo .= '<div class="img-push">';
                $echo .= '<div class="input-group">';
                $echo .= '<input type="text" class="form-control"  id="txtmessage' . $d['post_id'] . '" placeholder="Reply to Post... " required="required">';
                $echo .= '<input name="author_id" id="author_id" type="hidden" value="' . $_SESSION['user_id'] . '" />';
                $echo .= '<input name="post_id" id="post_id" type="hidden" value="' . $d['post_id'] . '" />';

                $echo .= '<div class="input-group-btn">
                        <button type="submit" class="btn reply-btn" onClick="callCrudAction(\'comment\',' . $d['post_id'] . ')"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>';
                $echo .= '</div>';
                $echo .= '</div>';
                $echo .= '</form>';
                $echo .= '</div>';
                $echo .= '</div>';

            }

            echo($echo);
            exit();
        } else {
            echo('nothing');
            exit();
        }
    }

    public function group($type = null) {

        $chat = $this->db->get('post',array('ratechat_id','=',Session::get('active_ratechat')),'post_id')->results();
        $limit = 12;
        $newArray = array();
        foreach($chat as $c){
            $newArray[] = array(
                'post_id' => $c->post_id,
                'author_id' => $c->author_id,
                'when' => $c->when,
                'message' => $c->message,
                'post_image' => $c->post_image,
                //'tags' => $c['tags'],
            );

            $arrayCount = count($newArray);
            if ($arrayCount === $limit) {
                $last_id_picked = $newArray[$limit - 1]['post_id'];
                Session::put('last_wall_post_id', $last_id_picked);
                return $newArray;
                break;
            }

        }

        switch($type){
            case '':
                break;
            default:
                break;
        }


        if (Session::exists('last_wall_post_id'))
            Session::delete('last_wall_post_id');
        return $newArray;
    }



    function post($type = null) {
        try {
            $picture = !is_numeric(Input::get('picture')) ? Input::get('picture') : false;
            $message = Input::get('message');

            $this->db->insert('post', array(
                'author_id' => $_SESSION['user_id'],
                'when' => $this->today,
                'message' => $message,
                'post_image' => $picture,
                'type' => $type,
                'type_id' => 1,
            ));

            $insert_id = $this->db->last_insert_id();
            $this->send_notification('wrote_post',Session::get('user_id'),0,$insert_id);

            //output to wall

            $echo = "<br/>";
            $echo .= '<div class="box box-widget" id="post_holder' . $insert_id . '">
                <div class="box-header with-border">
                    <div class="user-block">';
            $echo .= '<img src="' . Session::get('logged_in_user_photo') . '" class="img-circle" alt="' . Session::get('logged_in_user_name') . '">';
            $echo .= '<span class="username">
                        <a href="' . URL . 'dashboard/profile/' . (Session::get('logged_in_user_slug')) . '" class="poster-name text-left">' . Session::get('logged_in_user_name') . ' </a></span>';
            $echo .= '<span class="description">Shared publicly - <span class="liveTime" data-lta-value="' . Input::get('date') . '">Just Now</span></span>
                </div>';
            $echo .= '<div class="box-tools">';
            $echo .= '<a href="javascript:void(0);" onClick="callCrudAction(\'delete_post\',' . $insert_id . ')" title="Delete Post" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></a>';
            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '<div class="box-body">';
            if ($picture) {
                $echo .= '<img src="' . URL . 'public/uploads/wall/' . $picture . '" class="img-responsive" height="50%">';
            }
            $echo .= '<div>';
            $echo .= '' . (nl2br($message)) . '';
            $echo .= '</div>';
            $echo .= '<a href="javascript:void(0);" class="btn btn-default btn-xs" onClick="callCrudAction(\'like_post\',' . $insert_id . ')" title="Like it" id="like-btn' . $insert_id . '">
                                <span class="fa fa-thumbs-o-up"></span> Like
                            </a>';

            $echo .= '<a href="javascript:void(0);" id="like-count' . $insert_id . '" class="btn btn-link" data-toggle="popover" data-trigger="focus" data-content="No Likes"></a>';
            $echo .= '<span class="pull-right text-muted">';
            $echo .= '<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="toggle(\'all_replies' . $insert_id . '\')" data-toggle="popover" data-trigger="hover" data-content="Add comments">
<i class="fa fa-comments" ></i> <span class="label label-default" id="reply-count' . $insert_id . '">Comment</span></a>';
            $echo .= '</span>';
            $echo .= '</div>';
            $echo .= '<div class="box-footer box-comments" id="all_replies' . $insert_id . '">';
            $echo .= '<div id="post-reply' . $insert_id . '"></div>';
            $echo .= '</div>';
            $echo .= '<div class="box-footer">';
            $echo .= '<form method="post" onsubmit="return false">';
            $echo .= '<img src="' . Session::get('logged_in_user_photo') . '" class="img-responsive img-circle img-sm" alt="' . Session::get('logged_in_user_name') . '">';
            $echo .= '<div class="img-push">';
            $echo .= '<div class="input-group">';
            $echo .= '<input type="text" class="form-control"  id="txtmessage' . $insert_id . '" placeholder="Reply to Post... " required="required">';
            $echo .= '<input name="author_id" id="author_id" type="hidden" value="' . $_SESSION['user_id'] . '" />';
            $echo .= '<input name="post_id" id="post_id" type="hidden" value="' . $insert_id . '" />';

            $echo .= '<div class="input-group-btn">
                        <button type="submit" class="btn reply-btn" onClick="callCrudAction(\'comment\',' . $insert_id . ')"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>';
            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '</form>';
            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '';
            $echo .= '';
            $echo .= '';


            $echo .= '<br/>';


            echo($echo);
        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }



    function comment() {
        $id = Input::get("post_id");
        try {
            $this->db->insert('post_reply', array(
                'post_id' => $id,
                'author' => $_SESSION['user_id'],
                'date_posted' => $this->today,
                'comment' => Input::get("txtmessage"),
            ));

            $insert_id = $this->db->last_insert_id();
            //get user details
            $receiver = $this->get_originators($id);
            $this->send_notification('reply_post',$_SESSION['user_id'],$receiver,$id);

            $profile = $this->db->fetch_exact('users', 'id', $_SESSION['user_id']);
            $name = $profile['firstname'] . ' ' . $profile['surname'] . ' ' . $profile['othername'];
            if (!empty($profile['profile_picture'])) {
                $source = URL . 'public/uploads/profile/' . $profile['profile_picture'];
            } else {
                if ($profile['sex'] == 'male') {
                    $avatar = 'male';
                } else {
                    $avatar = 'female';
                }
                $source = URL . 'public/images/avatar-' . $avatar . '.png';
            }
            //output to wall

            $echo = '<div class="box-comment" id="reply' . $insert_id . '">';

            $echo .= '<img src="' . $source . '" class="img-circle img-sm"   alt="' . $name . '">';
            $echo .= '<div class="comment-text"><span class="username">';
            $echo .= '<a href="' . URL . 'dashboard/profile/' . $profile['slug'] . '" class="poster-name text-left">' . $name . '</a>';

            $echo .= '<span class="liveTime text-muted pull-right" data-lta-value="' . Input::get('date') . '">Just Now</span></span> ';

            $echo .= '' . Input::get("txtmessage");
            $echo .= '</div>';
            $echo .= '</div>';



            echo($echo);
        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }

    function react() {
        try {
            $this->db->insert('post_reply', array(
                'comment_id' => Input::get("reply_id"),
                'author' => $_SESSION['user_id'],
                'date_posted' => $this->today,
                'comment' => Input::get("txtmessage"),
            ));

            $insert_id = $this->db->last_insert_id();
            //get user details

            $profile = $this->db->fetch_exact('users', 'id', $_SESSION['user_id']);
            $name = $profile['firstname'] . ' ' . $profile['surname'] . ' ' . $profile['othername'];
            if (!empty($profile['profile_picture'])) {
                $source = URL . 'public/uploads/profile-pictures/' . $profile['profile_picture'];
            } else {
                if ($profile['sex'] == 'Male') {
                    $avatar = 'male';
                } else {
                    $avatar = 'female';
                }
                $source = URL . 'public/images/avatar-' . $avatar . '.png';
            }
            //output to wall

            $echo = '<div class="panel-body" id="comment_reply' . $insert_id . '">
                        <div class="col-sm-2">';

            $echo .= '<img src="' . $source . '" class="img-rounded" height="37px" width="37px"  alt="' . $name . '">';
            $echo .= '        </div>
                        <div class="col-sm-10 text-left text-holder">';

            $echo .= '<p><a href="' . URL . 'dashboard/profile/' . $profile['slug'] . '" class="poster-name text-left">' . $name . '</a>: ' . Input::get("txtmessage");
            $echo .= '<br/>';
            $echo .= '<!-- <span class="pull-right">
                            Just Now
                           <a  href="javascript:void(0);" onClick="callCrudAction(\'like_comment\',' . $insert_id . ')" title="2 Likes" data-toggle="popover" data-trigger="hover" data-content="Jacob, Lucy" class="btn"><span class="glyphicon glyphicon-thumbs-up "></span></a>
                            <a href="javascript:void(0);" onclick="toggle(\'reply2comment' . $insert_id . '\')" title="3 Replies" data-toggle="popover" data-trigger="hover" data-content="Jacob, Lucy, Mary" class="btn"><span class="glyphicon glyphicon-share-alt"></span></a>
                            <a href="javascript:void(0);" onclick="callCrudAction(\'delete_comment\',' . $insert_id . ')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                        </span>-->
                                </p>';

            $echo .= '<!-- reply to reply here -->';
            $echo .= '</div>';
            $echo .= '</div>';


            echo($echo);
        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }

    public function get_originators($id, $post = 'post'){
        $profile =  $this->db->fetch_exact('post','post_id',$id);
        switch($post){
            case 'like':

        }
        //$user =  $this->db->fetch_exact('users','id',);
        return $profile['author_id'];

    }

    public function like($post, $id) {
        try {
            if ($post == 'post') {
                $this->db->insert('likes', array(
                    'post_id' => $id,
                    'user_id' => $_SESSION['user_id'],
                    'date' => $this->today,
                    'like' => 'Yes',
                ));
                $receiver = $this->get_originators($id);
                $this->send_notification('like_post',$_SESSION['user_id'],$receiver,$id);

                //count no of likes
                $likes = $this->db->get_assoc('likes', array('post_id', '=', $id))->results_assoc();
                $no_of_likes = $this->db->count_assoc();

                if (($no_of_likes == 1)) {
                    list($likers) = $this->user->get_person_name($likes[$no_of_likes - 1]['user_id']);
                } else {
                    $likers = '';
                    for ($i = 0; $i < 3; $i++) {
                        $obj = array_pop($likes);
                        if ($obj == null)
                            break;
                        list($name) = $this->user->get_person_name($obj['user_id']);
                        $likers .= $name . ', ';
                    }
                    $likers = chop($likers, ", ");

                    if (($no_of_likes) > 3) {
                        $likers = $likers . ' + ' . ($no_of_likes - 3) . ' more';
                    }
                }


                $echo = '';
                if ($no_of_likes == 1) {
                    $echo = '<a href="javascript:void(0);" class="btn btn-link" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="' . $likers . '" id="like-count' . $id . '">';
                    $echo .= '<span class="badge"  id="like' . $id . '">1</span> You';
                    $echo .= '</a>';
                } elseif ($no_of_likes == 2) {
                    $echo = '<a href="javascript:void(0);" class="btn btn-link" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="' . $likers . '" id="like-count' . $id . '">';
                    $echo .= 'You + <span class="badge"  id="like' . $id . '">' . ($no_of_likes - 1) . '</span>';
                    $echo .= '</a>';
                } elseif ($no_of_likes >= 3) {
                    $echo = '<a href="javascript:void(0);" class="btn btn-link" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="' . $likers . '" id="like-count' . $id . '">';
                    $echo .= 'You + <span class="badge"  id="like' . $id . '">' . ($no_of_likes - 1) . '</span>';
                    $echo .= '</a>';
                }
                echo $echo;

                exit();
            } else {
                $this->db->insert('likes', array(
                    'reply_id' => $id,
                    'user_id' => $_SESSION['user_id'],
                    'date' => $this->today,
                    'like' => 'Yes',
                ));
                //count no of likes
                /*
                 * $likes = $this->db->get_assoc('likes', array('reply_id', '=', $id))->results_assoc();
                  $no_of_likes = $this->db->count_assoc();
                  if($no_of_likes == 1){
                  echo "You like this";
                  }elseif($no_of_likes == 2 ){
                  echo "You like this + ".($no_of_likes -1). ' other';
                  }elseif($no_of_likes >= 3){
                  echo "You like this + ".($no_of_likes -1). ' others';
                  }
                  exit();
                 */
                return true;
            }
        } catch (Exception $e) {
            
        }
    }

    public function unlike($post, $id) {
        try {
            if ($post == 'post') {
                $this->db->delete('likes', array('post_id', '=', $id, 'user_id', '=', Session::get('user_id')));
                //count no of likes
                $likes = $this->db->get_assoc('likes', array('post_id', '=', $id))->results_assoc();
                $no_of_likes = $this->db->count_assoc();
                if ($no_of_likes == 0) {
                    echo '<span class="badge"  id="like' . $id . '">0</span> Like';
                } elseif ($no_of_likes == 1) {
                    echo '<span class="badge"  id="like' . $id . '">1</span> Like';
                } elseif ($no_of_likes >= 2) {
                    echo '<span class="badge"  id="like' . $id . '">' . ($no_of_likes - 1) . '</span> Likes';
                }
                exit();
            } else {
                $this->db->delete('likes', array('reply_id', '=', $id));
                $this->db->insert('likes', array(
                    'reply_id' => $id,
                    'user_id' => $_SESSION['user_id'],
                    'date' => $this->today,
                    'like' => 'Yes',
                ));
                //count no of likes
                $likes = $this->db->get_assoc('likes', array('reply_id', '=', $id))->results_assoc();
                $no_of_likes = $this->db->count_assoc();
                if ($no_of_likes == 1) {
                    echo '<span class="badge"  id="like' . $id . '">1</span> Like';
                } elseif ($no_of_likes == 2) {
                    echo '<span class="badge"  id="like' . $id . '">' . ($no_of_likes - 1) . '</span> Likes';
                } elseif ($no_of_likes >= 3) {
                    echo '<span class="badge"  id="like' . $id . '">' . ($no_of_likes - 1) . '</span> Likes';
                }
                exit();
            }
        } catch (Exception $e) {
            
        }
    }

    public function delete($type, $id) {
        try {
            if ($type == 'post') {
                $this->db->delete('post', array('post_id', '=', $id));
                return true;
            } elseif ($type == 'comment') {
                $data = $this->db->fetch_exact('post_reply', 'reply_id', $id);
                if ($data['post_id'])
                    $this->db->delete('post_reply', array('reply_id', '=', $id));
                echo $data['post_id'];
            }elseif ($type == 'document') {
                //check if the person deleting is the uploader
                $uploader = $this->db->fetch_exact('technical_papers', 'paper_id', $id);
                if ($_SESSION['user_id'] === $uploader['uploaded_by']) {
                    $this->db->delete('technical_papers', array('paper_id', '=', $id));
                }
                Redirect::to(URL . 'wall/documents#documents');
            }
        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }

    public function events($act) {
        $user_id = Session::get('user_id');
        //first find events registered for
        $event_reg = array();
        $event = $this->db->get_assoc('event_registrations', array('user_id', '=', $_SESSION['user_id']), 'event_id')->results_assoc();
        foreach ($event as $reg) {
            array_push($event_reg, $reg['event_id']);
        }

        switch ($act) {
            case 'manage':
                $first = $this->db->get_assoc('events', array('started_by', '=', $user_id), 'event_id')->results_assoc();

                break;
            case 'trending':
                //ALL THE EVENTS
                $trending = array();
                $allEvents = $this->db->get_assoc('events', array('is_live', '=', 1), 'event_id')->results_assoc();
                //trend only those found
                foreach ($allEvents as $it) {
                    if (!in_array($it['event_id'], $event_reg)) {
                        array_push($trending, $it['event_id']);
                    }
                }
                $first = $trending;
                //die('events_id '. print_r($trending));

                break;
            case 'registered':
                $first = $event_reg;
                break;
        }


        return ($first);
        //
    }


    public function get_event($id = null) {
        if($id){

            $data =  $this->db->fetch_exact('events', 'id',$id);
            $all =  $this->db->getAll_assoc('events','date',array('date','>=',date('Y-m-d')))->results_assoc();
            $count = $this->db->count_assoc();

            return array($data,$count);
        }else{
            $data =  $this->db->get('events',array('date','>=',date('Y-m-d')),'date','ASC')->results();
            $result = array();
            foreach($data as $d){
                //SELECT ``, ``, ``, `date`, `present`, `comment`, `` FROM `` WHERE 1
                $attend = $this->db->fetch_exact_two('event_attendees','event_id',$d->id,'user_id',Session::get('user_id'));
                $result[] = array(
                    'title' => $d->title,
                    'description' => $d->description,
                    'date' => $d->date,
                    'time' => $d->time,
                    'user_id' => $d->user_id,
                    'id' => $d->id,
                    'attend' => $attend['ticket'],
                );
            }
            return $result;
        }
    }

    public function get_event_ticket($id = null) {
        $data =  $this->db->fetch_exact('event_attendees', 'ticket',$id);
        if($data){
            $event =  $this->db->fetch_exact('events','id',$data['event_id']);
            $user =  $this->db->fetch_exact('users', 'id',$data['user_id']);
            $result = array(
                'invoice' => $data['id'],
                'title' => $event['title'],
                'description' => $event['description'],
                'manager' => $event['manager'],
                'venue' => $event['venue'],
                'event_type' => $event['event_type'],
                'phone' => $event['phone'],
                'date' => $event['date'],
                'time' => $event['time'],
                'user_id' => $event['user_id'],
                'id' => $event['id'],
                'ticket' => $id,
                'attendee' => $user['id'],
                'attendee_addy' => $user['hostel_address'],
                'attendee_phone' => $user['phone_no'],
            );
            return $result;

        }else{
            Redirect::to(backToSender());
            return false;
        }
    }
    public function attend_event($id = null,$attend = 0) {

        try {
            $check = $this->db->get('event_attendees',array('event_id','=',$id,'user_id','=',Session::get('user_id')))->results();
            if($this->db->count()){
                //do nothing
            }else{
                $ticket = $this->ticket_gen('event_attendees','ticket');

                $this->db->insert('event_attendees', array(
                    'event_id' => $id,
                    'ticket' => $ticket,
                    'user_id' => Session::get('user_id'),
                    'date' => $this->today,
                    'comment' => null,
                ));
            }

            cleanUP();
            Session::put('home', 'Done successfully! We would be looking forward to seeing you there!');
            return true;
        } catch (Exception $e) {
            return false;

            //redirect user to specific page saying oops
            //;
        }
    }
    public function view_event($id = null) {

        try {
            $check = $this->db->get('event_viewers',array('event_id','=',$id,'user_id','=',Session::get('user_id')))->results();
            if($this->db->count()){
                $first = $this->db->first();
                $this->db->update('event_viewers', array(
                    'event_id' => $id,
                    'user_id' => Session::get('user_id'),
                    'date' => $this->today,
                    'seen' => $first->seen+1,
                ),'id',$first->id);
            }else{
                $this->db->insert('event_viewers', array(
                    'event_id' => $id,
                    'user_id' => Session::get('user_id'),
                    'date' => $this->today,
                    'seen' => 1,
                ));
            }

            cleanUP();
            Session::put('home', 'Ok... We would love to see you there!');
            return $this->get_event($id);
        } catch (Exception $e) {
            return false;

            //redirect user to specific page saying oops
            //;
        }
    }

    public function add_event($update = null,$upload = null) {


        try {
            if($update){
                $this->db->update( 'events', array(
                    'description' => (Input::get('description')),
                    'title' => (Input::get('title')),
                    'date' => (Input::get('datepicker')),
                    'time' => (Input::get('timepicker')),
                    'event_type' => Input::get('club_type'),
                    'venue' => Input::get('venue'),
                    'user_id' => Session::get('user_id'),
                    'date_added' => $this->today,
                    'image' => $upload,
                ), 'id', $update);

            }else{
                $this->db->insert('events', array(
                    'title' => trim(Input::get('title')),
                    'description' => trim(Input::get('description')),
                    'date' => trim(Input::get('datepicker')),
                    'time' => trim(Input::get('timepicker')),
                    'event_type' => Input::get('club_type'),
                    'venue' => Input::get('venue'),
                    'manager' => Input::get('manager'),
                    'phone' => Input::get('phone'),
                    'user_id' => Session::get('user_id'),
                    'date_added' => $this->today,
                    'image' => $upload,
                ));
            }
            cleanUP();
            Session::flash('home', 'Information successfully saved!');

            return true;
        } catch (Exception $e) {
            return false;

            //redirect user to specific page saying oops
            //;
        }
    }

    function ticket_gen($table,$column){
        $ticket = Hash::randomString(8);
        $exists = $this->db->fetch_exact($table,$column,$ticket);
        if($exists){
            $this->ticket_gen($table,$column);
        }else{
            return $ticket;
        }
    }



    public function get_event_statistics($id = null) {
        $attend = $this->db->get('event_attendees',array('event_id','=',$id))->results();
        $people = array();
        $users = array();
        foreach($attend as $a){
            $users[] = $a->user_id;
            $person = $this->db->fetch_exact('users','id',$a->user_id);
            $name = $person['surname'].' '.$person['firstname'].' '.$person['othername'].' ';
            $people[] = array(
                'event_id' => $id,
                'name' => $name,
                'nick' => $person['nickname'],
                'slug' => $person['slug'],
                'date' => $a->date,
                'user_id' => $a->user_id,
                'ticket' => $a->ticket,
                'present' => $a->present,
                'attend' => 1,
            );
        }

        $viewers = $this->db->get('event_viewers',array('event_id','=',$id))->results();
        foreach($viewers as $a){
            if(in_array($a->user_id,$users)){
                continue;
            }else{
                $person = $this->db->fetch_exact('users','id',$a->user_id);
                $name = $person['surname'].' '.$person['firstname'].' '.$person['othername'].' ';
                $people[] = array(
                    'name' => $name,
                    'nick' => $person['nickname'],
                    'slug' => $person['slug'],
                    'date' => $a->date,
                    'attend' => 0,
                );

            }

        }

        if(count($people)){
            return $people;
        }else{
            Session::put('home','We are sorry, it seems there is no one on your invitation list');
            Redirect::to(backToSender());
        }

    }

    function event_rsvp($action = null, $id = null){

        try {
            $person = $this->db->fetch_exact('users','slug',$id);
            $check = $this->db->get('event_attendees',array('event_id','=',$action,'user_id','=',$person['id']))->results();
            if($this->db->count()){
                $first = $this->db->first();
                $this->db->update('event_attendees', array(
                    'present' => 1,
                    'date' => $this->today,
                ),'id',$first->id);
            }

            cleanUP();
            Session::put('home', 'Ok... RSVP Marked good!');

            return true;
        } catch (Exception $e) {
            return false;

            //redirect user to specific page saying oops
            //;
        }
    }



    public function delete_event($id) {
        try {
            $this->db->delete('events',array('id', '=',$id) );
            cleanUP();
            Session::flash('home', 'Information successfully deleted!');
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function get_market_category(){
        return $this->db->get_assoc('market_category')->results_assoc();

    }

    public function create_market($upload = null,$update= null) {

        try {
            if($update){
                $this->db->update( 'market_items', array(
                    'sold' => 1,
                    'user_id' => Session::get('user_id'),
                    'date' => $this->today,
                ), 'id', $update);

                Session::flash('home', 'Item successfully marked as sold!');
                Redirect::to(backToSender());
            }else{

                $this->db->insert('market_items', array(
                    'cat_id' => trim(Input::get('item_category')),
                    'item_name' => trim(Input::get('item_name')),
                    'used_state' => trim(Input::get('used_state')),
                    'price' => preg_replace('/\D/', '', (Input::get('price'))),
                    'description' => trim(Input::get('description')),
                    'effects' => Input::get('effects'),
                    'sold' => 0,
                    'user_id' => Session::get('user_id'),
                    'date' => $this->today,
                    'image' => $upload,
                ));
                Session::flash('home', 'Item successfully added!');
            }
            cleanUP();

            return true;
        } catch (Exception $e) {
            return false;

            //redirect user to specific page saying oops
            //;
        }
    }

    public function get_product($item = null){
        if($item){
            $product = $this->db->fetch_exact('market_items','id',$item);
            $seller = $this->db->fetch_exact('users','id',$product['user_id']);
            $data = array($product, $seller);
        }else{
            $data = $this->db->getAll_assoc('market_items','date',array('sold','=',0))->results_assoc();
        }
        return $data;

    }

    function summary(){
        //$events =  $this->db->get('events',array('date','>=',date('Y-m-d')))->results();
        $events = 1;

        //$news =  $this->db->get('blog_post',array('post_date','>=',Session::get('user_last_login'),'post_status','=','publish'))->results();
        $news =  $this->db->get('blog_post',array('post_status','=','publish'))->results();
        $news = $this->db->count();

        //$rates =  $this->db->get('rates',array('completed','=','no'))->results();
        $rates = 1;

        $buy = 1;

        return array($events,$news,$rates,$buy );



    }



}
