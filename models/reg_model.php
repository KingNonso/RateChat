<?php

    class Reg_Model extends Model {

        function __construct() {
            parent::__construct();
            $this->user = new User();
        }

        public function reg_all_now($path = null, $dob= null) {
            try{
                $year = Input::get('grad_yr');
                $program = Input::get('program');
                $level = Input::get('level');
                $faculty = Input::get('faculty');
                $dept = Input::get('department');

                $ratechat = $this->db->get('ratechat')->results();
                $ratechat_id = 0;
                foreach($ratechat as $y){
                    if($y->year == $year && $y->program == $program  && $y->faculty == $faculty && $y->dept == $dept){//&& $y->level == $level
                        $ratechat_id = $y->id;
                        break;
                    }
                }

                if(!$ratechat_id ){//&& ($program == 1 || $program == 2)
                    $this->db->insert('ratechat', array(
                        'year' => $year,
                        'program' => $program,
                        'faculty' => $faculty,
                        'dept' => $dept,
                        'date' => $this->today,
                    ));
                    $ratechat_id = $this->db->last_insert_id();

                }

                $phone_no = Input::get('phone_number');
                $email = Input::get('email');
                $salt = Hash::salt(32);

                $this->db->insert('users', array(
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'joined' => $this->today,
                    'verified' => 1,
                    'lastLogin' => $this->today,
                    'user_perms_id' => 1,

                    'reg_no' => Input::get('reg_no'),
                    'level' => $level,
                    'ratechat_id' => $ratechat_id,
                    'nickname' => Input::get('nickname'),

                    'surname' => Input::get('surname'),
                    'firstname' => Input::get('firstname'),
                    'othername' => Input::get('othername'),
                    'sex' => Input::get('sex'),
                    'dob' => $dob,
                    'marital_status' => Input::get('marital_status'),
                    'state_of_origin' => Input::get('state_origin'),
                    'nationality' => Input::get('nationality'),
                    'residential_address' => Input::get('residential_address'),
                    'hostel_address' => Input::get('hostel_address'),
                    'hostel_location' => Input::get('location'),
                    //'country_of_residence' => Input::get('country'),
                    //'state_of_residence' => Input::get('state'),
                    'lga' => Input::get('lga'),
                    'phone_no' => $phone_no,
                    'email' => $email,
                    //'passion' => Input::get('passion'),
                    //'occupation' => Input::get('occupation'),
                    'slug' => (Input::get('slug')),
                    'profile_picture' => $path,
                    'agreement_2_terms' => "Yes",
                    'date_created' => $this->today,
                ));

                $last_id = $this->db->last_insert_id();
                if ($last_id) {
                    $_SESSION['user_id'] = $last_id;

                }

                $this->db->insert('ratechat_joins', array(
                    'ratechat_id' => $ratechat_id,
                    'user_id' => Session::get('user_id'),
                    'date' => $this->today,
                ));
                cleanUP();
                Session::flash('home','Done... Registration was successful');

                return true;

            }catch(Exception $e){
                return false;
            }


        }


        function get_info_personal() {
            $guide = $this->db->fetch_exact('users','record_tracker',$_SESSION['record_tracker']);
            $data = array(
                'name' => $guide['surname'].' '.$guide['firstname'].' '.$guide['othername'],
                'phone_no' => $guide['phone_no'],
                'email' => $guide['email'],
                //'passion' => $guide['passion'],
            );
            return $data;
        }

        public function verification_step($path) {

            try {
                $this->db->insert('info_educational', array(
                    'user_id' => Session::get('user_id'),
                    'program' => Input::get('program'),
                    'location' => (Input::get('location')),
                    'faculty' => (Input::get('faculty')),
                    'dept' => (Input::get('dept')),
                    'level' => (Input::get('level')),
                    'grad_yr' => (Input::get('grad_yr')),
                    'hostel_name' => (Input::get('hostel_name')),
                    'hostel_address' => (Input::get('hostel_address')),
                    'work_name' => (Input::get('work_name')),
                    'work_place' => (Input::get('work_place')),
                    'record_tracker' => Session::get('record_tracker'),
                    'date' => $this->today,

                ));


                $this->db->update('users', array(
                    'slug' => (Input::get('slug')),
                    'profile_picture' => $path,

                ),'id',Session::get('user_id'));

                Session::put('home','Registration was successful');
                Session::delete('record_tracker');
                return true;



            } catch (Exception $e) {
                return false;
            }
        }

        function codeNumber($table ='student_groups',$col = 'token'){
            $token = Hash::randomDigits(6);

            $check = $this->db->fetch_exact($table,$col,$token);
            if($check){
                $this->codeNumber();
            }else{
                return $token;
            }
        }

        public function get_codeword($token){
            $data = $this->db->fetch_exact('student_groups','token',$token);
            return $data;
        }

        public function reg_association($path) {
            $token = $this->codeNumber('student_groups','token');

            try {

                $this->db->insert('student_groups', array(
                    'reg_by' => Session::get('user_id'),
                    'group_name' => Input::get('group_name'),
                    'year_of_initial_reg' => (Input::get('year_reg')),
                    'staff_name' => (Input::get('staff_name')),
                    'staff_phone' => (Input::get('staff_phone')),
                    'staff_status' => (Input::get('staff_status')),
                    'staff_dept' => (Input::get('staff_dept')),
                    'staff_faculty' => (Input::get('staff_fac')),
                    'token' => ($token),
                    'group_desc' => (Input::get('brief_desc')),

                    'sch_group' => 1,
                    'club_type' => (Input::get('club_type')),
                    'date' => $this->today,
                    'next_renewal' => $this->nextYr,
                    'group_logo' => $path,

                ));

                $group_id = $this->db->last_insert_id();

                $this->db->insert('student_group_members', array(
                    'user_id' => Session::get('user_id'),
                    'date' => $this->today,
                    'admin' => 1,
                    'group_id' => $group_id,
                    'invite' => $token,
                ));

                Session::put('home','Registration was successful');
                Session::put('codeNumber',$token);
                return $this->get_codeword($token);



            } catch (Exception $e) {
                return false;
            }
        }

        public function personal_info($path = null, $dob= null) {
            $record = Hash::unique();
            Session::put('record_tracker',$record);
            $phone_no = Input::get('phone_number');
            $email = Input::get('email');

            try {
                $salt = Hash::salt(32);
                $this->db->insert('users', array(
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'joined' => $this->today,
                    'verified' => 1,
                    'lastLogin' => $this->today,
                    'record_tracker' => Session::get('record_tracker'),
                    'user_perms_id' => 1,

                    'surname' => Input::get('surname'),
                    'firstname' => Input::get('firstname'),
                    'othername' => Input::get('othernames'),
                    'sex' => Input::get('sex'),
                    'dob' => $dob,
                    'marital_status' => Input::get('marital_status'),
                    'state_of_origin' => Input::get('state_origin'),
                    'nationality' => Input::get('nationality'),
                    'residential_address' => Input::get('residential_address'),
                    'country_of_residence' => Input::get('country'),
                    'state_of_residence' => Input::get('state'),
                    'lga' => Input::get('lga'),
                    'phone_no' => $phone_no,
                    'email' => $email,
                    'passion' => Input::get('passion'),
                    'occupation' => Input::get('occupation'),
                    'profile_picture' => $path,
                    'agreement_2_terms' => "Yes",
                    'date_created' => $this->today,
                ));

                $last_id = $this->db->last_insert_id();
                if ($last_id) {
                    $_SESSION['user_id'] = $last_id;

                }





                self::cleanUP();
                /*
                 *
                          $verify_email = $this->verify_email();
                $verify_phone = $this->verify_phone($phone_no);
                $hash = Hash::unique();

                $this->db->insert('user_options', array(
                    'email' => $verify_email,
                    'phone' => $verify_phone,
                    'email_hash' => Hash::make($verify_email, $hash),
                    'record_tracker' => $_SESSION['record_tracker'],
                    'date' => $this->today,
                ));
       */
                Session::flash('home', 'Information successfully saved, You may proceed!');
                return true;
            } catch (Exception $e) {
                //redirect user to specific page saying oops
                return false;
            }
        }

        public function educational($path, $admission, $graduation) {
            try {
                $guide = $this->db->fetch_exact('info_educational','record_tracker',$_SESSION['record_tracker']);
                if(!empty($guide['record_tracker'])){
                    $this->db->update('info_educational', array(
                        //'user_id' => $_SESSION['user_id'],
                        'record_tracker' => $_SESSION['record_tracker'],
                        'institution' => Input::get('institute'),
                        'program' => Input::get('program'),
                        'course' => Input::get('course'),
                        'faculty' => Input::get('faculty'),
                        'admission_date' => $admission,
                        'graduation_date' => $graduation,
                        'hod_supevisor' => Input::get('hod'),
                        'upload_certification' => $path,
                        'school_address' => Input::get('sch_address'),
                        'school_postal' => Input::get('sch_postal'),
                        'school_phone' => Input::get('sch_phone'),
                        'date' => $this->today

                    ),'edu_id',$guide['edu_id']);


                }else{
                    $this->db->insert('info_educational', array(
                        //'user_id' => $_SESSION['user_id'],
                        'record_tracker' => $_SESSION['record_tracker'],
                        'institution' => Input::get('institute'),
                        'program' => Input::get('program'),
                        'course' => Input::get('course'),
                        'faculty' => Input::get('faculty'),
                        'admission_date' => $admission,
                        'graduation_date' => $graduation,
                        //'hod_supevisor' => Input::get('hod'),
                        'upload_certification' => $path,
                        'school_address' => Input::get('sch_address'),
                        'school_postal' => Input::get('sch_postal'),
                        'school_phone' => Input::get('sch_phone'),
                        'date' => $this->today

                    ));

                }

                self::cleanUP();

                Session::flash('home', 'Information successfully saved, You may proceed with the registration!');
                Redirect::to(URL . 'reg/account');
                exit;

            } catch (Exception $e) {
                //redirect user to specific page saying oops
                return false;
            }
        }

        public function professional($employ_date, $retire_date) {
            try {
                $guide = $this->db->fetch_exact('info_professional','record_tracker',$_SESSION['record_tracker']);
                if(!empty($guide['record_tracker'])){
                    $this->db->update('info_professional', array(
                        //'user_id' => $_SESSION['user_id'],
                        'record_tracker' => $_SESSION['record_tracker'],
                        'organization' => Input::get('organization'),
                        'division' => Input::get('division'),
                        'specialization' => Input::get('specialization'),
                        'position' => Input::get('position'),
                        'employment_year' => $employ_date,
                        'retirement_year' => $retire_date,
                        'business_phone' => Input::get('biz_phone'),
                        'business_email' => Input::get('biz_email'),
                        'business_address' => Input::get('biz_address'),
                        'business_postal' => Input::get('biz_postal'),
                        'date' => $this->today

                    ),'prof_id',$guide['prof_id']);


                }else{
                    $this->db->insert('info_professional', array(
                        //'user_id' => $_SESSION['user_id'],
                        'record_tracker' => $_SESSION['record_tracker'],
                        'organization' => Input::get('organization'),
                        'division' => Input::get('division'),
                        'specialization' => Input::get('specialization'),
                        'position' => Input::get('position'),
                        'employment_year' => $employ_date,
                        'retirement_year' => $retire_date,
                        'business_phone' => Input::get('biz_phone'),
                        'business_email' => Input::get('biz_email'),
                        'business_address' => Input::get('biz_address'),
                        'business_postal' => Input::get('biz_postal'),
                        'date' => $this->today

                    ));

                }

                self::cleanUP();

                Session::flash('home', 'Information successfully saved, You may proceed with the registration!');
                Redirect::to(URL . 'reg/account');
                exit;

            } catch (Exception $e) {
                //redirect user to specific page saying oops
                return false;
            }
        }


        public function info_parents() {
            try {
                $guide = $this->db->fetch_exact('info_parents','record_tracker',$_SESSION['record_tracker']);
                if(!empty($guide['record_tracker'])){
                    $this->db->update('info_parents', array(
                        //'user_id' => $_SESSION['user_id'],
                        'record_tracker' => $_SESSION['record_tracker'],
                        'parents_name' => Input::get('parents_name'),
                        'relationship' => Input::get('relationship'),
                        'parents_phone' => Input::get('parents_phone'),
                        'parents_email' => Input::get('parents_email'),
                        'parents_occupation' => Input::get('parents_occupation'),
                        'biz_address' => Input::get('biz_address'),
                        'home_address' => Input::get('home_address'),
                        'date' => $this->today
                    ),'parents_id',$guide['parents_id']);

                }else{
                    $this->db->insert('info_parents', array(
                        //'user_id' => $_SESSION['user_id'],
                        'record_tracker' => $_SESSION['record_tracker'],
                        'parents_name' => Input::get('parents_name'),
                        'relationship' => Input::get('relationship'),
                        'parents_phone' => Input::get('parents_phone'),
                        'parents_email' => Input::get('parents_email'),
                        'parents_occupation' => Input::get('parents_occupation'),
                        'biz_address' => Input::get('biz_address'),
                        'home_address' => Input::get('home_address'),
                        'date' => $this->today
                    ));
                }


                self::cleanUP();

                Session::flash('home', 'Information successfully saved, Your Application was successfully saved. DONE!');
                Redirect::to(URL . 'admission/step/web');
            } catch (Exception $e) {
                //redirect user to specific page saying oops
                return false;
            }
        }

        public function contact_support() {
            $anonymous = (Input::checkbox('anonymous')=='yes')?1:0;
            try {
                $this->db->insert('support', array(
                    'user_id' => $_SESSION['user_id'],
                    'send_to' => Input::get('send_to'),
                    'subject' => Input::get('subject'),
                    'message' => Input::get('message'),
                    'anonymous' => $anonymous,
                    'date' => $this->today
                ));


                self::cleanUP();

                Session::flash('home', 'Message was sent. Thank you for contacting us!');
                return true;
            } catch (Exception $e) {
                //redirect user to specific page saying oops
                return false;
            }
        }


        function verify_phone($phone_no){
            $hash = Hash::randomDigits(8);
            //$message = 'Here is your verification/ activation code. <br/> '.$salt.'<br/> Please follow <a href="www.schooledu.com.ng">www.school.com</a> to complete your registration';

            $msg = 'Welcome to myUNIZIK, Here is your verification code: '.$hash.' use as your One Time Password';
            if($response = $this->sendSMS($phone_no,$msg)){
                return $hash;

            }else{
                return null;
            }
        }

        function sendSMS($to, $message = null, $originator = 'myUNIZIK',$key= '8ec7d31e9a2774') {
            // Simple SMS send function
            // Example of use
            /*
             For multiple destinations use sms/bulk instead of sms/send:
    http(s)://smstube.ng/api/sms/bulk/key=yourkey&from=senderid&text=smstext&to[]=MOB1&to[]=MOB2&to[]=.....&to[]=MOBX

            *
             */
            // Simple SMS send function
            // Example of use
            $salt = Hash::salt(8);

            $URL = "https://smstube.ng/api/sms/send?key=" . $key . "&to=" . $to;
            $URL .= "&text=".urlencode($message).'&from='.urlencode($originator);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $URL);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);
            //echo $output;
            return $output;
        }

        function verify_email(){
            $salt = Hash::randomString(24);
            urlencode($salt);
            return $salt;

            // Email the user their activation link
            $email = Input::get('email');
            $to = $email;
            $from = "info@frogfreezone.com";
            $subject = 'School Education - Account Verification/ Activation';
            $message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>School Education - Account Verification/ Activation</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;">
<div style="padding:10px; background:#333; font-size:24px; color:#CCC;">School Education - Account Verification/ Activation Details: '. date('D, d F, Y ')." at " .date(' h:i:s a').'</div><div style="padding:24px; font-size:17px;">
  <p>Hello dear, <br /><br />
    You have  recently applied to create an account on   <a href="http://judidaily.com.ng/">School Education</a><br />
  <br />
  This mail was sent to you in response to that request.</p>
  <p>You may please copy and paste the link below to continue your application or you may just click on it.</p>
  <p><br />
    <a href="http://localhost/www/doing/school_app/login/verify/'.urlencode($email).'/'.urlencode($salt).'">Click here to Proceed with your application now</a><br /><br />
    <b>Do not reply this mail. It is a system response from the application on <a href="http://judidaily.com.ng">School Education</a></b></p>
  <b>
  <p>Finally:</p> Please ignore this mail if you did not request it. Thanks</b></div></body></html>';
            $headers = "From: $from\n";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\n";
            //$headers .= 'Cc: nonso@frogfreezone.com' . "\r\n";
            //$headers .= 'Bcc: nonso@frogfreezone.com' . "\r\n";
            $headers .= 'Reply-To: '.$from.'' . "\r\n";
            if(!mail($to, $subject, $message, $headers)){
                return false;
            }else{
                return $salt;

            }
        }


        public static function cleanUP() {
            //clears out my session variables on success. Thanks
            foreach ($_POST as $item => $thing) {
                Session::delete($item);
            }
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

        function picture_update($path = null){
            $data = $this->db->fetch_exact('users','id',Session::get('user_id'));
            $this->db->update('users', array(
                'profile_picture' => $path,

            ),'id',Session::get('user_id'));
            $myPhoto = URL.'public/uploads/profile-pictures/'.$path;
            Session::put('logged_in_user_photo',$myPhoto);
            Session::put('home','Profile Picture Successfully Updated');

            return true;


        }


    }
