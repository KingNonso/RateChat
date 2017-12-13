<?php

    class Webmaster_Model extends Model {
        private  $_data;

        function __construct() {
            parent::__construct();
        }

        function account($user_id = null){
            $user_id = (isset($user_id))? $user_id : Session::get('user_id');
            $person = $this->db->fetch_exact('users','id',$user_id);
            //die(print_r($person));
            if($person){
                return $person;
            }else{
                return false;
            }
        }


        public function reward($type){

            $this->db->insert('testimonial',array(
                'platform' => $type,
                'message' => Input::get('message'),
                'link' => Input::get('link'),
                'user_id_on_platform' => Session::get('user_id'),
            ));
            Session::put('home','Saved Successfully... Subject to final verification. Thank you so much for your effort');
        }

        function check_plan($id){
            $data = $this->db->fetch_exact('prices','id',$id);
            if($data){
                return $data['id'];
            }else{
                Redirect::to(URL.'webmaster');
                exit;
            }
        }

        public function packages() {
            $data = $this->db->get('user_permissions')->results() ;

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
                $this->error();
            }
        }

        public function start_package($id) {

            $data = $this->db->get('scheme_gh',array('plan_id','=',$id,'trans_complete','<',1))->results();


            $mat_check = $this->db->get('scheme_ph',array('plan_id','=',$id,'user_id','=',Session::get('user_id')))->results();

            $matrix = 2;
            if($this->db->count() >= 2){
                $matrix = 3;
            }

            $matched = '';
            $row = '';

            foreach($data as $d){
                //look for same plan and another person
                if(($d->user_id != $_SESSION['user_id'] && empty($d->to_be_paid_by))){

                    $row = $d->id;
                    $matched = $d->user_id;
                    $add = $this->db->insert('scheme_ph',array(
                        'to_pay' => $matched,
                        'plan_id' => $id,
                        'ref_to_gh_table' => $row,
                        'matrix' => $matrix,
                        'user_id' => $_SESSION['user_id'],
                        'start_time' => $this->today,
                        'end_time' => $this->plus_12hrs,
                    ));
                    list($last_id) = $this->db->last_insert_id();
                    if ($last_id){
                        $add = $this->db->update('scheme_gh',array(
                            'to_be_paid_by' => $_SESSION['user_id'],
                            'ref_to_ph_table' => $last_id,
                            'start_time' => $this->today,
                            'end_time' => $this->plus_12hrs,
                        ),'id',$row);
                        //merger
                        $add = $this->db->insert('scheme_merge',array(
                            'gh_person_id' => $matched,
                            'gh_row' => $row,
                            'plan_id' => $id,
                            'ph_row' => $last_id,
                            'ph_person_id' => $_SESSION['user_id'],
                            'date' => $this->today,
                        ));
                    }




                    break;


                }else{
                    continue;
                }
            }
            //Get account details of matched
            $check = $this->db->fetch_exact('prices','id',$id);
            $person = $this->db->fetch_exact('users','id',$matched);
            Session::put('person_to_pay',$matched);
            Session::put('matched_row_to_pay',$row);
            $this->output($person,$check);


        }


        public function output($person,$check){
            $echo = '<div class="col-sm-4 col-sm-offset-4" id="upline">';
            $echo .= '<div class="box box-primary"><div class="box-body box-profile">';
            $echo .= '<img src="'.Session::get('logged_in_user_photo').'" class="profile-user-img img-responsive img-circle" alt="Upline">';
            $echo .= '<h3 class="profile-username text-center">'.$person['fullname'].'</h3>';
            $echo .= '<p class="text-muted text-center">Member</p>';
            $echo .= '</div></div>';
            $echo .= '<div class="box box-primary"><div class="box-header with-border">';
            $echo .= '<h3 class="box-title">Transaction Detail</h3>';
            $echo .= '</div>';
            $echo .= '<div class="box-body">';
            $echo .= '<strong><i class="fa fa-book margin-r-5"></i>  Just Now</strong>';
            $echo .= '<p class="text-muted">'.$check['package'].'</p>';
            $echo .= '<p class="text-muted">'.number_format($check['amount_in_naira']).'</p>';
            $echo .= ' </div> </div>';
            $echo .= '<div class="box box-primary"><div class="box-header with-border">';
            $echo .= '<h3 class="box-title">About Me</h3>';
            $echo .= '</div>';
            $echo .= '<div class="box-body">';
            $echo .= '<strong><i class="fa fa-book margin-r-5"></i>  Account</strong>';
            $echo .= '<p class="text-muted">'.$person['bank'].'</p>';
            $echo .= '<p class="text-muted">'.$person['account_name'].'</p>';
            $echo .= '<p class="text-muted">'.$person['account_no'].'</p>';
            $echo .= ' <hr>';
            $echo .= '<strong><i class="fa fa-phone margin-r-5"></i> Details</strong>';
            $echo .= '<p class="text-muted">'.$person['phone_number'].'</p>';
            $echo .= '<p class="text-muted">'.$person['home_address'].'</p>';
            $echo .= '<hr>';
            $echo .= '<strong><i class="fa fa-file-text-o margin-r-5"></i> Note</strong>';
            $echo .= '<p> Please call me on and after payment. Don\'t forget to keep your POP as it might be required </p>';
            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '</div>';

            echo($echo);
            exit;

        }

        public function transaction($id = null) {
            $payables = array();
            $receivables = array();

            $data = $this->db->get('scheme_gh',array('trans_complete','<',1,'user_id','=',$_SESSION['user_id']))->results();

            foreach($data as $d){
                $prices = $this->db->fetch_exact('prices','id',$d->plan_id);
                //look for people paying me
                if(!empty($d->to_be_paid_by)){

                    $merge = $this->db->fetch_exact_two('scheme_merge','ph_person_id',$d->to_be_paid_by,'gh_row',$d->id);

                    $parson = $this->db->fetch_exact('users','id',$d->to_be_paid_by);

                    $proof = $this->db->fetch_exact_two('scheme_ph','id',$d->ref_to_ph_table,'confirm',0);
                    $time_left = $this->timeLeft($d->end_time);
                    $receivables[] = array(
                        'plan_id' => $d->plan_id,
                        'plan' => $prices['package'],
                        'amount' => $prices['amount_in_naira'],
                        'db_row' => $d->id,
                        'merge' => $merge['merge_id'],
                        'time_left' => $time_left,
                        'fullname' => $parson['fullname'],
                        'phone_number' => $parson['phone_number'],
                        'home_address' => $parson['home_address'],
                        'payer' => $d->to_be_paid_by,
                        'payer_start_time' => $d->start_time,
                        'payer_end_time' => $d->end_time,
                        'payer_pop' => $proof['pop'],
                        'payer_confirm' => $d->trans_complete,
                    );
                }else{
                    $receivables[] = array(
                        'plan_id' => $d->plan_id,
                        'plan' => $prices['package'],
                        'amount' => $prices['amount_in_naira'],
                        'db_row' => $d->id,
                        'time_left' => 'Nil',
                        'fullname' => $prices['package'],
                        'phone_number' => 'N/A',
                        'home_address' => 'N/A',
                        'payer' => '',
                        'payer_start_time' => 'N/A',
                        'payer_end_time' => 'N/A',
                        'payer_pop' => 0,
                        'payer_confirm' => 0,
                    );

                }
            }

            $data = $this->db->get('scheme_ph',array('confirm','<',1,'user_id','=',$_SESSION['user_id']))->results();
            foreach($data as $d){
                //solve confirm problem
                $merge = $this->db->fetch_exact_two('scheme_merge','gh_person_id',$d->to_pay,'ph_row',$d->id);

                $prices = $this->db->fetch_exact('prices','id',$d->plan_id);
                $parson = $this->db->fetch_exact('users','id',$d->to_pay);
                $time_left = $this->timeLeft($d->end_time);

                $payables[] = array(
                    'fullname' => $parson['fullname'],
                    'bank' => $parson['bank'],
                    'account_name' => $parson['account_name'],
                    'account_no' => $parson['account_no'],
                    'phone_number' => $parson['phone_number'],
                    'home_address' => $parson['home_address'],
                    'plan' => $prices['package'],
                    'plan_id' => $d->plan_id,
                    'amount' => $prices['amount_in_naira'],
                    'db_row' => $d->id,
                    'merge' => $merge['merge_id'],
                    'time_left' => $time_left,
                    'payer' => $d->to_pay,
                    'start_time' => $d->start_time,
                    'end_time' => $d->end_time,
                    'pop' => $d->pop,
                    'payer_confirm' => $d->confirm,
                    'purge_alert' => $d->purge_alert,
                );

            }


            if($payables || $receivables){
                return array($payables,$receivables);

            }else{
                return array(null,null);
            }

        }


        public function dashboard(){
            $data = $this->db->get('hostel')->results();
            $results = array();
            $records = array();
            foreach($data as $d){
                if(in_array($d->record_tracker,$records)){
                    continue;

                }else{
                    $records[] = $d->record_tracker;
                    $results[] = array(
                        'hostel' => $d->hostel_name,
                        'address' => $d->address,
                        'room_type' => $d->room_type,
                        'features' => $d->features,
                        'room_rent' => $d->room_rent,
                        'hostel_slug' => $d->hostel_slug,
                        'hostel_id' => $d->hostel_id,

                    );
                }
            }

            $hostels =  count($results);

            $data = $this->db->get('users')->results();
            $users = $this->db->count();

            $post = $this->db->get('post')->results();
            $post = $this->db->count();


            $complete = $this->db->get('student_groups')->results();
            $complete = $this->db->count();

            return array($hostels,$users,$complete,$post);

        }

        public function analysis(){

            $new = array();
            $login = array();
            $active = array();
            $keyboard = array();

            $come = new DateTime('now');
            $today  = $come->format('Y-m-d');

            $data = $this->db->get('users')->results();
            foreach($data as $d){
                $joined = new DateTime($d->joined);
                $joined  = $joined->format('Y-m-d');

                $last_login = new DateTime($d->lastLogin);
                $last_login  = $last_login->format('Y-m-d');
                if($today == $joined){
                    $new[] = $d->id;

                }
                if($today == $last_login){
                    $login[] = $d->id;

                }
            }
            $new =  count($new);
            $login =  count($login);

            $data = $this->db->get('user_activity_log')->results();
            foreach($data as $d){
                $come = new DateTime('now');
                $come->sub(new DateInterval('PT30M'));//P2Y4DT6H8M
                $minutes = $come->format('Y-m-d H:i:s');

                if($d->time >= $minutes && !in_array($d->user_id,$active)){
                    $active[] = $d->user_id;

                }else{
                    continue;

                }


            }
            $active =  count($active);

            $post = $this->db->get('post')->results();
            foreach($post as $d){
                $joined = new DateTime($d->when);
                $joined  = $joined->format('Y-m-d');

                if($today == $joined){
                    $keyboard[] = $d->post_id;

                }
            }

            $keyboard =  count($keyboard);

            return array($new,$active,$login,$keyboard);

        }

        function get_hostel_details($hostel){

            $data = $this->db->fetch_exact('hostel','hostel_id',$hostel);
            $block = $this->db->get('hostel_blocks',array('hostel_id','=',$data['hostel_id']))->results();
            $blk = array();

            foreach($block as $b){
                $blk[] = array(
                    'block_id' => $b->block_id,
                    'block_name' => $b->block_name,
                    'special_sex' => $b->special_sex,
                );
            }

            return array($data,$blk);
        }


        public function hostel(){
            $data = $this->db->get('hostel')->results();
            $results = array();
            $records = array();
            foreach($data as $d){
                if(in_array($d->record_tracker,$records)){
                    continue;

                }else{
                    $records[] = $d->record_tracker;
                    $results[] = array(
                        'hostel' => $d->hostel_name,
                        'address' => $d->address,
                        'room_type' => $d->room_type,
                        'features' => $d->features,
                        'room_rent' => $d->room_rent,
                        'hostel_slug' => $d->hostel_slug,
                        'hostel_id' => $d->hostel_id,

                    );
                }
            }

            return $results;

        }

        public function get_block_rooms($hostel_id) {

            $data = $this->db->get('hostel_rooms', array('block_id','=',$hostel_id))->results();
            $count = $this->db->count();
            if($count > 0){
                return $data;
            }else{
                return null;
            }
        }

        public function remove_room($id) {
            $data = $this->db->fetch_exact('hostel_rooms', 'room_id',$id);
            $this->db->delete('hostel_rooms',array('room_id','=',$id));
            Session::put('home','Successfully deleted Room '.$data['room_name']);
            return true;
        }



        function users($id){
            $result = $this->db->get('users',array('user_perms_id','=',$id))->results();
            return $result;
        }

        function create_new_plan($plan_name,$plan_amount){

            $add = $this->db->insert('prices',array(
                'package' => $plan_name,
                'amount_in_naira' => $plan_amount
            ));
            Session::put('home','Successfully Done');
            return true;
        }

        public function portfolio(){
            $scheme_ph = $this->db->get('scheme_ph',array('user_id','=',$_SESSION['user_id']))->results();
            $ph = 0;
            $cycles = $this->db->count();
            foreach($scheme_ph as $d){
                $prices = $this->db->fetch_exact('prices','id',$d->plan_id);
                $ph += $prices['amount_in_naira'];
            }

            $scheme_gh = $this->db->get('scheme_gh',array('user_id','=',$_SESSION['user_id']))->results();
            $gh = 0;
            foreach($scheme_gh as $d){
                $prices = $this->db->fetch_exact('prices','id',$d->plan_id);
                $gh += $prices['amount_in_naira'];
            }



            return array(number_format($ph),number_format($gh),$cycles);


        }

        public function timeLeft($end){
            $datetime1 = new DateTime('now');
            $datetime2 = new DateTime($end);
            $interval = $datetime1->diff($datetime2);
            return $interval->format('%R %H:%I:%S ');

        }

        public function upload_pop($upload, $id, $plan){
            $data = $this->db->fetch_exact('ponzy_scheme','id',$id);

            if(($data['payer_1'] == $_SESSION['user_id']) && ($data['plan_id'] == $plan)){

                $add = $this->db->update('ponzy_scheme',array(
                    'payer_1_pop' => $upload, //user id
                ),'id',$id);
                return true;

            }elseif(($data['payer_2'] == $_SESSION['user_id']) && ($data['plan_id'] == $plan)){

                $add = $this->db->update('ponzy_scheme',array(
                    'payer_2_pop' => $upload, //user id
                ),'id',$id);
                return true;

            }elseif(($data['payer_3'] == $_SESSION['user_id']) && ($data['plan_id'] == $plan)){

                $add = $this->db->update('ponzy_scheme',array(
                    'payer_3_pop' => $upload, //user id
                ),'id',$id);
                return true;
            }
        }

        function confirm_payment($id, $plan, $payer){
            //confirm the payment
            // `gh_person_id`, ``, ``, ``, ``, `date`, `report`, `report_time`, `purge`, `purge_time` FROM ``
            $data = $this->db->fetch_exact_two('scheme_merge','gh_row',$id,'plan_id',$plan);


            if(($data['ph_person_id'] == $payer)){

                $add = $this->db->update('scheme_gh',array(
                    'trans_complete' => 1, //user id
                    'date_paid' => $this->today,
                ),'id',$id);

                $add = $this->db->update('scheme_ph',array(
                    'confirm' => 1,
                    'end_time' => $this->today,
                ),'id',$data['ph_row']);



                //insert the payer into row for him to be merged
                $track =  Hash::unique();
                $ph = $this->db->fetch_exact('scheme_ph','id',$data['ph_row']);
                if($ph['matrix']){
                    for($i=1; $i <= $ph['matrix']; $i++){
                        $add = $this->db->insert('scheme_gh',array(
                            'user_id' => $payer, //user id
                            'plan_id' => $plan, //record_tracker
                            'record_tracker' =>$track, //
                            'times_2be_paid' =>$ph['matrix'], //
                            'pay_no' =>$i, //
                        ));

                    }
                }



            }



            Session::put('home','Successfully Payment Confirmation');
            //check if recycle is possible
            $gh = $this->db->fetch_exact('scheme_gh','id',$data['gh_row']);
            $check = $this->db->get('scheme_gh',array('record_tracker','=',$gh['record_tracker']))->results();
            $number = array();
            foreach($check as $c){
                if(($c->trans_complete == 1) && ($data['record_tracker'] == $c->record_tracker)){
                    $number[] = 1;

                }
            }
            if(count($number) == $gh['times_2be_paid']){
                Session::put('home','Your Next Cycle is now 3:1 Matrix!');

                $special = $this->db->fetch_exact('users','id',Session::get('user_id'));

                if($special['user_perms_id'] == 3){
                    $track =  Hash::unique();

                    for($i=1; $i <= 2 ; $i++){
                        $add = $this->db->insert('scheme_gh',array(
                            'user_id' => Session::get('user_id'),
                            'plan_id' => $plan,
                            'record_tracker' =>$track,
                            'times_2be_paid' =>2,
                            'pay_no' =>$i,
                        ));

                    }

                }


            }

            return true;
        }


        function make_admin($how,$id){
            $package = Input::get('package');
            $user = Input::get('user_id');
            switch($how){
                case 'make'://``, `user_status`
                    $add = $this->db->update('users',array(
                        'user_perms_id' => $package,
                    ),'id',$user);

                    break;
                case 'unmake'://``, `user_status`
                    $add = $this->db->update('users',array(
                        'user_perms_id' => 1,
                    ),'id',$id);
                    break;

            }
            Session::put('home','Successfully Accomplished!!! ');
            if($package == 3){
                Redirect::to(URL.'webmaster/add_new_plan/'.$user);
            }else{
                Redirect::to(backToSender());

            }


        }

        function set_hostel_manager($who,$id){
            $add = $this->db->insert('hostel_managers',array(
                'hostel_id' => $id,
                'manager_id' => $who,
                'date' => $this->today,
            ));
            Session::put('home','Hostel Manager successfully assigned to the hostel! ');
            Redirect::to(URL.'webmaster/users/3');
            return true;
        }

        function numbers(){
            $data = $this->db->get('users')->results();
            $result = '';
            foreach($data as $d){
                $string = $d->phone_number;//'08033492136';
                $pattern = '/\A0/';
                $replacement = '234';//'${1}1,$3';
                $result .= (preg_replace($pattern,$replacement,$string)).', ';
            }

            return $result;
        }


        function block_user($how,$id){
            switch($how){
                case 'block'://``, ``
                    $add = $this->db->update('users',array(
                        'user_status' => 2,
                    ),'id',$id);
                    break;
                case 'undo'://``, `user_status`
                    $add = $this->db->update('users',array(
                        'user_status' => 1,
                    ),'id',$id);
                    break;

            }
            Session::put('home','Accomplished!!! With Extra Perfection... ');
            Redirect::to(backToSender());


        }

        public function enter_account($user = null) {
            if ($user) {
                //$field = 'username';
                $field = (is_numeric($user)) ? 'id' : 'username';
                $data = $this->db->get('users', array($field, '=', $user));

                if ($this->db->count()) {
                    $data = $this->db->first();
                    $_SESSION['user_id'] = $data->id;
                    $_SESSION['email'] = $data->email;
                    Session::put('loggedIn',true);

                    Session::put('logged_in_user_name',$data->fullname);
                    Session::put('logged_in_user_slug',$data->slug);
                    Redirect::to(URL ."dashboard");
                    exit;
                }
            }
            return false;
        }



        function update($what = null, $id = null){
            $salt = Hash::salt(32);
            switch($what){
                case 'password':
                    $add = $this->db->update('users',array(
                        'password' => Hash::make(Input::get('password'), $salt),
                        'salt' => $salt,
                    ),'id',Session::get('user_id'));

                    break;
                case 'personal':
                    $add = $this->db->update('users',array(
                        'home_address' => Input::get('home_address'),
                        'special_needs' => Input::get('special_needs'),
                    ),'id',Session::get('user_id'));

            }
            Session::put('home','Update was successful');
            return true;
        }

        public function error() {
            require 'controllers/error.php';
            $controller = new Error();
            $controller->hostel();
            exit();
        }

        function purge($id, $plan, $payer){
            $data = $this->db->fetch_exact('scheme_merge','merge_id',$id);

            $add = $this->db->insert('purges',array(
                'done_by_id' => $_SESSION['user_id'], //user id
                'done_on_id' => $payer, //user id
                'date' => $this->today, //user id
                'plan_id' => $plan, //user id
            ));

            $purge = false;
//($data['gh_person_id'] == Session::get('user_id')) && ($data['plan_id'] == $plan) && ($data['ph_person_id'] == $payer)
            if($purge){

                $add = $this->db->update('scheme_gh',array(
                    'to_be_paid_by' => null, //user id
                    'start_time' => null,
                    'end_time' => null,
                    'ref_to_ph_table' => null,
                    'trans_complete' => 0,
                ),'id',$data['gh_row']);

                $this->db->delete('scheme_ph',array('id','=',$data['ph_row']));

            }
            $add = $this->db->update('scheme_merge',array(
                'report' => 1, //user id
                'report_time' => $this->today,
            ),'merge_id',$data['merge_id']);



            Session::put('home','The Person has been successfully reported');

            return true;
        }

        function purge_self($id, $plan, $payer){
            //confirm the payment

            $data = $this->db->fetch_exact('scheme_merge','merge_id',$id);
            //$data = $this->db->fetch_exact('scheme_ph','id',$id);

            $gh_ref = $data['gh_row'];

            $add = $this->db->insert('purges',array(
                'comment' => 'Self Purge',
                'done_by_id' => $payer,
                'done_on_id' => $_SESSION['user_id'],
                'date' => $this->today,
                'plan_id' => $plan,
            ));

            $this->db->delete('scheme_ph',array('id','=',$data['ph_row']));

            $check = $this->db->fetch_exact('scheme_gh','id',$data['gh_row']);

            if($check['to_be_paid_by'] == Session::get('user_id')){
                $add = $this->db->update('scheme_gh',array(
                    'to_be_paid_by' => null, //user id
                    //'payer_1_pop' => null,
                    'start_time' => null,
                    'end_time' => null,
                    'ref_to_ph_table' => null,
                    'trans_complete' => 0,
                ),'id',$data['gh_row']);

            }
//``, `gh_person_id`, `ph_person_id`, `gh_row`, `ph_row`, `plan_id`, `date`, ``, ``, ``, `` FROM ``

            $add = $this->db->update('scheme_merge',array(
                'purge' => 1, //user id
                'purge_time' => $this->today,
            ),'merge_id',$data['merge_id']);





            Session::put('home','You have successfully renounced this payment. Please select plan');

            return true;
        }

        function get_broadcast(){
            $results = $this->db->get('broadcast',null,'id','DESC')->results();
            return $results;
        }
        function send_broadcast(){

            $add = $this->db->insert('broadcast',array(
                'message' => Input::get('message'),
                'date' => $this->today,
            ));
            return true;
        }

        function get_chat(){
            //SELECT ``, ``, ``, ``, ``, `anonymous`, `` FROM `` WHERE 1
            $data = array();
            $authors = array();
            $results = $this->db->get('support',null,'id','DESC')->results();
            foreach($results as $r){
                //$reply = $this->db->fetch_exact('post_reply','post_id',$r->post_id);
                $author = $this->db->fetch_exact('users','id',$r->user_id);
                $authors[] = $r->user_id;

                $data[] = array(
                    'send_to' => $r->send_to,
                    'subject' => $r->subject,
                    'message' => $r->message,
                    'date' => $r->date,
                    //'reply' => $reply['comment'],
                    'author' => $author['surname'].' '.$author['firstname'].' '.$author['othername'],
                    //'reply_date' => $reply['date_posted'],

                );
            }
            return $data;
        }
        function send_chat($id){
//SELECT `reply_id`, `post_id`, `comment_id`, `author`, ``, `date_posted` FROM `post_reply` WHERE 1
            $msg = Input::get('messages');
            $add = $this->db->insert('post_reply',array(
                'author' => Session::get('user_id'),
                'post_id' => $id,
                'comment' => $msg,
                'date_posted' => $this->today,
            ));

            $this->showMsg($msg);

        }

        function showMsg($msg){
            $echo = '<div class="direct-chat-msg right">
                                            <div class="direct-chat-info clearfix">
                                                <span class="direct-chat-name pull-right">Support Team</span>';

            $echo .= '<span class="direct-chat-timestamp pull-left">'.$this->today.'</span></div>';
            $echo .= ' <img class="direct-chat-img" src="'.Session::get('logged_in_user_photo').'" alt="'.Session::get('logged_in_user_name').'">';
            $echo .= ' <div class="direct-chat-text">'.$msg.'</div></div>';

            //$echo .= ' </div>';

            echo($echo);
            exit;
        }


    }
