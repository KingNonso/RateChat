<?php

class Model {
    public $db;

    function __construct() {
       $this->db = Database::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');
        $this->user = new User();
        //appointment dates
        $come = new DateTime('now');
        $this->today = $come->format('Y-m-d H:i:s');
        $come->add(new DateInterval('P1Y'));
        $this->nextYr = $come->format('Y-m-d');

    }

    public function get_friends_request(){
        $data = $this->db->get('friendships',array('receiver','=',Session::get('user_id'),'accepted','=',0))->results();
        $result = null;
        foreach($data as $d){
            $v = $this->db->get('users',array('id','=',$d->sender))->results();

            $v = $this->db->first();
            //if($v->user_perms_id > 1){ continue; }
            $result[] = array(
                'name' => $v->firstname.' '.$v->surname.' '.$v->othername,
                'id' => $v->id,
                'username' => $v->slug,
                'pix' => $v->profile_picture,
                'sex' => $v->sex,
                'marital_status' => $v->marital_status,
                'cart' => $d->id,
            );


        }
        return $result;
    }

    public function send_notification($about,$from,$to = 0,$page = null){
        $this->db->insert('notification',array(
            'date' => $this->today,
            'actor_id' => $from,
            'viewer_id' => $to,
            'notice' => $about,
            'page' => $page,

        ));
        return true;

    }

    public function get_notification(){
        $about = $this->db->get('notification',array('viewer_id','=',
        Session::get('user_id'),'viewer_id','=',0),'date','DESC','OR')->results();
        $notice = '';
        $icon = '';
        $notification = array();

        //get notified of people i am in relationship with
        $relate = $this->get_my_relationships();

        foreach($about as $a){
            if(!(in_array($a->actor_id, $relate) || $a->notice == 'friend_request')){ continue;  }
            if($a->date < Session::get('last_login_record')){ break; }
            if($a->actor_id == Session::get('user_id')){ continue; }
            $sender = $this->db->get('users',array('id','=',$a->actor_id))->first();
            $sex = ($sender->sex == 'male')? ' his ': ' her ';
            $send = $sender->firstname.' '.$sender->surname.' '.$sender->othername;
            switch($a->notice){
                case 'friend_request':
                    $icon = 'fa-user-plus text-orange';
                    $iconic = 'fa-user-plus bg-orange';
                    $notice = $send.' sent you a friend request';
                    break;
                case 'friend_accept':
                    $icon = 'fa-user-plus text-purple';
                    $iconic = 'fa-user-plus bg-purple';
                    $notice = $send.' accepted your friend request';
                    break;
                case 'follow':
                    $icon = 'fa-user-plus text-orange';
                    $iconic = 'fa-user-plus bg-orange';
                    $notice = $send.' started following you';
                    break;
                case 'fan':
                    $icon = 'fa-user-plus text-orange';
                    $iconic = 'fa-user-plus bg-orange';
                    $notice = $send.' started fanning you';
                    break;
                case 'wrote_post':
                    $icon = 'fa-comment text-blue';
                    $iconic = 'fa-comment bg-blue';
                    $notice = $send.' made a new post on '.$sex.' time line';
                    break;
                case 'direct_msg':
                    $icon = 'fa-comment text-red';
                    $iconic = 'fa-comment bg-red';
                    $notice = $send.' sent you a direct message ';
                    break;
                case 'reply_post':
                    $notice = $send.' replied to a comment on your time line';
                    $icon = 'fa-comments-o  text-green';
                    $iconic = 'fa-comments-o  bg-green';
                    break;
                case 'like_post':
                    $icon = 'fa-thumbs-up text-black';
                    $iconic = 'fa-thumbs-up bg-black';
                    $notice = $send.' likes a post on your time line';
                    break;
                case 'create_rate':
                    $icon = 'fa-balance-scale  text-danger';
                    $iconic = 'fa-balance-scale  bg-danger';
                    $notice = $send.' created a new rating on the chart';
                    break;
                case 'rate_respond':
                    $icon = ' fa-star-half-o text-warning';
                    $iconic = ' fa-star-half-o bg-warning';
                    $notice = $send.' responded to a rating you created on the chart';
                    break;


            }

            $notification[] = array(
                'name' => $send,
                'icon' => $icon,
                'iconic' => $iconic,
                'notice' => $notice,
                'date' => $a->date,
                'link' => $a->page,
            );


        }
        return $notification;
        echo('<pre>');
        print_r($relate);
        die();

    }

    public function get_my_relationships(){
        $members = array();
        // get those in the same user level
        $friend = $this->db->get('friendships',array('receiver','=',Session::get('user_id'),'sender','=',Session::get('user_id')),'id','ASC','OR')->results();
        foreach($friend as $f){
            $user_id = ($f->sender == Session::get('user_id'))? $f->receiver : $f->sender;
            $v = $this->db->get('users',array('id','=',$user_id))->first();

            if($v->user_perms_id == 1 && $f->accepted == 1){
                $members[] = $v->id;
            }elseif($v->user_perms_id == 2){
                $members[] = $v->id;
            }elseif($v->user_perms_id == 3){
                $members[] = $v->id;
            }
        }

        return $members;
    }

    function check_status(){
        if(Session::exists($this->_sessionName) && Cookie::exists($this->_cookieName)){
            $user = Session::get($this->_sessionName);
            $cookie = json_decode(Cookie::get($this->_cookieName));
            $expiry = $cookie->expiry;
            $hash = $cookie->hash;
            $hashCheck = $this->db->fetch_exact('user_sessions','user_id',$user);
            if(($hash === $hashCheck['hash']) && (time() < $expiry)  ){
                Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                //then just put in a logged in state
                    return $hashCheck['user_id'];
            }else{
                return false;
            }
        }
        return false;
    }





}
