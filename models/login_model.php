<?php

class Login_Model extends Model {
    private  $_data;

    function __construct() {
        parent::__construct();
    }

    function check_status(){
        if(Session::exists('page_to_redirect')){
            Redirect::to(Session::get('page_to_redirect'));
            Session::delete('page_to_redirect');
            exit;

        }
        $status = parent::check_status();
        if($status){
            $user = $this->find($status);
            $this->run();
            Redirect::to(Session::get('page_to_redirect'));
            Session::delete('page_to_redirect');
            exit;
        }
        return false;
    }

    public function find($user = null) {
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'email';
            $data = $this->db->get('users', array($field, '=', $user));

            if ($this->db->count()) {
                $this->_data = $this->db->first();
                return true;
            }
        }
        return false;
    }

    function hasPermission() {
        $role = $this->db->get('user_permissions',array('id', '=',$this->data()->user_perms_id));
        if ($this->db->count()) {
            $permissions = json_decode($this->db->first()->permissions, true);
            Session::put('role',$permissions['role']);
            Session::put('role_id',$this->data()->user_perms_id);
            Session::put('role_name',$this->db->first()->name);
            return Session::put('page_to_redirect',URL.$this->db->first()->default_page);
        }
        return false;
    }

    public function data() {
        return $this->_data;
    }

    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    public function login($username = null, $password = null, $remember = false) {
        if (!$username && !$password && $this->exists()) {
            //log user in
            Session::put($this->_sessionName, $this->data()->id);
        } else {
            $user = $this->find($username);

            if ($user) {
                if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    if($this->data()->verified == 1){
                        Session::put($this->_sessionName, $this->data()->id);
                        //	return true;
                        if ($remember) {
                            $hash = Hash::unique();
                            $hashCheck = $this->db->get('user_sessions', array('user_id', '=', $this->data()->id));
                            if (!$this->db->count()) {
                                $this->db->insert('user_sessions', array(
                                    'user_id' => $this->data()->id,
                                    'hash' => $hash
                                ));
                            } else {
                                $hash = $this->db->first()->hash;
                            }

                            Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                        }
                        return $this->run();

                    }else{//user is not verified
                        Redirect::to(URL.'login/verify');
                    }

                }
            }
        }
        return false;
    }


    public function run() {
        cleanUP();

        $_SESSION['user_id'] = $this->data()->id;
        $_SESSION['email'] = $this->data()->email;
        Session::put('loggedIn',true);
        $me = $this->data()->surname.' '.$this->data()->firstname.' '.$this->data()->othername;
        Session::put('logged_in_user_name',$me);
        Session::put('logged_in_user_slug',$this->data()->slug);
        Session::put('last_login_record',$this->data()->lastLogin);

        Session::put('user_perms_id',$this->data()->user_perms_id);

        $photo = $this->data()->profile_picture;
        if(!empty($photo)){
            $myPhoto = URL.'public/uploads/profile/'.$photo;

        }else{
            if($this->data()->sex == 'male'){
                $myPhoto = URL.'public/images/avatar-male.png';
            }else{
                $myPhoto = URL.'public/images/avatar-female.png';
            }
        }
        Session::put('logged_in_user_photo',$myPhoto);

        $update = $this->db->update('users',array(
            'lastLogin' => $this->today,
        ),'id',$this->data()->id);

        $insert = $this->db->insert('user_login_log',array(
            'login_time' => $this->today,
            'user_id' => $this->data()->id,
            'device' => null,
            'browser' => null,
            'ip_address' => null,
            'organization' => null,
            'operating_system' => null,
            'location' => null,
        ));


        $user_log_id = $this->db->last_insert_id();
        Session::put('user_log_id',$user_log_id);

        //activate my duties tab
        return $this->hasPermission();

    }

    public function login_ajax($username = null, $password = null, $remember = false) {
        if (!$username && !$password && $this->exists()) {
            //log user in
            Session::put($this->_sessionName, $this->data()->id);
        } else {
            $user = $this->find($username);

            if ($user) {
                if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    if($this->data()->verified == 1){
                        Session::put($this->_sessionName, $this->data()->id);
                        //	return true;
                        if ($remember) {
                            $hash = Hash::unique();
                            $hashCheck = $this->db->get('user_sessions', array('user_id', '=', $this->data()->id));
                            if (!$this->db->count()) {
                                $this->db->insert('user_sessions', array(
                                    'user_id' => $this->data()->id,
                                    'hash' => $hash
                                ));
                            } else {
                                $hash = $this->db->first()->hash;
                            }

                            Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                        }
                        $_SESSION['user_id'] = $this->data()->id;
                        $_SESSION['email'] = $this->data()->email;
                        Session::put('loggedIn',true);

                        $me = $this->data()->firstname.' '.$this->data()->surname.' '.$this->data()->othername;
                        Session::put('logged_in_user_name',$me);
                        Session::put('logged_in_user_slug',$this->data()->slug);
                        Session::put('user_last_login',$this->data()->lastLogin);
                        $update = $this->db->update('users',array(
                            'lastLogin' => $this->today,
                        ),'id',$this->data()->id);
                        $photo = $this->data()->profile_picture;
                        if(!empty($photo)){
                            $myPhoto = URL.'public/uploads/profile-pictures/'.$photo;

                        }else{
                            if($this->data()->sex == 'male'){
                                $myPhoto = URL.'public/images/avatar-male.png';
                            }else{
                                $myPhoto = URL.'public/images/avatar-female.png';
                            }
                        }
                        Session::put('logged_in_user_photo',$myPhoto);
                        Session::put('logged_in_user_status',$this->data()->status);
                        //activate my duties tab
                        $duty = $this->data()->user_perms_id;
                        if($duty < 3){
                            Session::put('page_to_redirect',URL . "dashboard");
                            $this->hasPermission();
                            return true;
                        }
                        elseif ($duty == 3) {
                            $reserve = $this->db->fetch_exact('hostel_managers','manager_id',$this->data()->id);
                            $hostel = $this->db->fetch_exact('hostel','hostel_id',$reserve['hostel_id']);
                            Session::put('hostel_name',$hostel['hostel_name']);
                            Session::put('hostel_session_id',$reserve['hostel_id']);
                            $this->hasPermission();
                            return true;
                        }else{
                            $this->hasPermission();
                            Session::put('page_to_redirect',URL . "webmaster");
                            return true;
                        }

                    }else{//user is not verified
                        Redirect::to(URL.'login/verify');
                    }

                }
            }
        }
        return false;
    }


    public function logout(){
        $update = $this->db->update('user_login_log',array(
            'logout_time' => $this->today,
        ),'log_id',$_SESSION['user_log_id']);
        return true;

    }


    public function recovery($email){
        //check whether email exist
        $user = $this->find($email);
        if($user){
            $hash = Hash::unique();
            try{
                $this->db->insert('user_options', array(
                    'user_id' => $this->data()->id,
                    'email' => $email,
                    'date' => $this->today,
                    'temp_pass' => Hash::make($email, $hash),
                    'temp_hash' => $hash,
                ));

                return urlencode($hash);
            }catch (Exception $e){
                return false;
            }
        }else{
            return false;

        }
    }

    public function reset($email,$url){
        $true = $this->db->fetch_exact_two('user_options','email',$email,'temp_hash',$url);
        if(($true['temp_pass'] == Hash::make($email, $url)) && $true['used'] < 1){
            Session::put('temp_pass_session',Hash::make($email));
            Session::put('temp_pass_user',$true['email']);
            Session::put('temp_pass_user_id',$true['user_id']);

            try{
                $this->db->update('user_options', array(
                    'used' => 1,
                    'date' => $this->today,
                ),'user_id',$true['user_id']);

                Session::put('home', 'This session is protected. Please do not reload your browser.');
                return true;
                //Redirect::to(URL.'login/reset/'.urlencode(Hash::make(Hash::randomString(16))));
                //exit;
            }catch (Exception $e){
                Redirect::to(URL.'login/recovery');
                return false;
            }
        }else{
            Session::put('error', 'Something went wrong with the last request. Please try again later.');
            Redirect::to(URL.'login/recovery');
            exit;
        }

    }

    public function temp_login(){
        $salt = Hash::salt(32);

        try{

            $this->db->update('users', array(
                'password' => Hash::make(Input::get('password'), $salt),
                'salt' => $salt,
                'lastLogin' => $this->today,
            ),'id',Session::get('temp_pass_user_id'));



            return array(Input::get('temp_pass_user'),Input::get('password'));

        }catch (Exception $e){
            return false;
        }

    }


    public function account_setup() {
        //register user
        $salt = Hash::salt(32);
        try {
            $this->db->insert('users', array(
                'surname' => Input::get('last_name'),
                'firstname' => Input::get('first_name'),
                'email' => Input::get('email'),
                'sex' => Input::get('sex'),
                'dob' => Input::get('datepicker'),
                'slug' => Input::get('slug'),
                'marital_status' => Input::get('marital_status'),
                'phone_no' => Input::get('phone_number'),
                'password' => Hash::make(Input::get('password'), $salt),
                'salt' => $salt,
                'joined' => $this->today,
                'verified' => 1,
                'lastLogin' => $this->today,
                'user_perms_id' => 1,
                'user_status' => 1,
                'agreement_2_terms' => 1,

            ));
            Session::flash('home','Your Registration was successful, You have been logged in automatically.');
            Redirect::to(URL.'login');

        } catch (Exception $e) {
            return false;
        }
    }

    public function check_details($detail){
        if($detail === 'code'){
            $data = $this->db->get('user_options', array('phone', '=', trim(Input::get($detail)),'user_id','=',Session::get('user_id')));

            if ($this->db->first()) {
                Session::put('code_verified',true);
                echo('detail_ok');
                exit();
            }else{
                echo('detail_exists');
                exit();
            }
        }else{
            $data = $this->db->get('users', array($detail, '=', trim(Input::get($detail))));

            if (!$this->db->count()) {
                echo('detail_ok');
                exit();
            }else{
                echo('detail_exists');
                exit();
            }

        }

    }


}
