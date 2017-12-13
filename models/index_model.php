<?php

class Index_Model extends Model {

    function __construct() {
        parent::__construct();
    }
    public function gallery() {
        $all =  $this->db->getAll_assoc('events','date',array('date','>=',date('Y-m-d')))->results_assoc();
        return lastFive($all);
    }
    public function events() {
        $data =  $this->db->get('events',array('date','>=',date('Y-m-d')),'date','DESC')->results();
        $result = array();
        foreach($data as $d){
            $attend = $this->db->fetch_exact_two('event_attendees','event_id',$d->id,'user_id',Session::get('user_id'));
            $result[] = array(
                'title' => $d->title,
                'description' => $d->description,
                'venue' => $d->venue,
                'date' => $d->date,
                'time' => $d->time,
                'user_id' => $d->user_id,
                'id' => $d->id,
                'attend' => $attend['ticket'],
            );
        }
        return lastFive($result);
    }

    public function get_settings() {
        $data = $this->db->fetch_exact('settings', 'id',1);
        if($data){
            return $data;
        }else{
            //call error
            return false;
        }
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


    public function run_about() {
        try{
            $this->db->insert('enquiries', array(
                'name' => Input::get('name'),
                'phone_no' => Input::get('phone_no'),
                'email' => Input::get('email'),
                'address' => Input::get('address'),
                'message' => Input::get('message'),
                'subject' => Input::get('subject'),
                'date' => $this->today,
                'status' => "new",//new, replied to or seen
            ));
            cleanUP();

            return true;


            $message = "Thank You. You will hear from us soon.";
            Session::flash('home',$message);
            Redirect::to(URL.'index/about');
        }catch(Exception $e){
            return false;
            //redirect user to specific page saying oops
            die($e->getMessage());
        }


    }

    public function last_post(){
         //get latest project that is last in db
        //I'm going to need this function in displaying the last result of a blog
        $result = $this->db->fetch_last('blog_post','post_id','post_status', 'publish');
        die(print_r($result));
    }

    public function all_blog_titles(){
            return $this->db->get_assoc('blog_post',array('post_status','=','publish'),'post_id')->results_assoc();

    }

    function hostel_search($str){
        $search_term = "%".$str."%";
        $search = $this->db->get('hostel',array('hostel_name','LIKE',$search_term))->results();

        $search_count = $this->db->count();

        if($search_count != 0){

            foreach($search as $suggestion){
                if($suggestion->parent_hostel != null){
                    continue;
                }
                $name = $suggestion->hostel_name. ' <br/> Address: '.$suggestion->address.' <br/> Room type '.$suggestion->room_type;
                $pic = $this->db->fetch_exact('hostel_picture','hostel_id',$suggestion->hostel_id);

                if(!empty($pic['file_path'])){
                    $source = URL.'public/uploads/hostel/'. $pic['file_path'];
                }else{
                    $source = URL.'public/uploads/hostel/yoth-hostel-sign.jpeg';
                }



                $echo = '';
                    //$echo = '<img class="img-circle" src="'.$source.'" width="30" height="30">';
                //$echo .= '<a href="'.URL.'profile/member/'.($suggestion['slug']).'">  '.$name.'</a>';
                // $chapter = $this->user->get_person_chapter($suggestion['chapter_id']);
                //$echo .= '<p>Chapter: '. $chapter['chapter_name'];
                //$echo = '<div class="col-sm-6">';
                $echo .= '<div class="row text-center col-sm-offset-3">
                        <div class="col-sm-2">';

                $echo .= '<img src="'.$source.'" class="img-circle" height="51px" width="51px"  alt="'.$name.'">';
                $echo .= '</div>
                        <div class="col-sm-7 text-left text-holder">';

                $echo .= '<a href="'.URL.'hostel/'.$suggestion->hostel_slug.'" class="poster-name text-left">'.$name.'</a>';

                $echo .= '</div>';
                $echo .= '</div>';
                $echo .= '<br/>';
                //$echo .= '</div>';




                echo($echo);
            }


        }else {
            echo "No suggestion";
        }

    }


}
