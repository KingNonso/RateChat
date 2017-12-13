<?php

    class Reg extends Controller {


        function __construct() {
            parent::__construct();

            $this->view->title = "Registrations";
            $this->view->header = "Registrations";
            $this->view->glyph = "open";
            $this->view->generalJS = array('custom/js/upload_check.js','custom/js/ajax.js');


        }

        function index(){

            $this->view->generalJS = array('custom/js/upload_check.js','custom/js/ajax.js','custom/plugins/country/countries-state.js','custom/phone/js/intlTelInput.js');
            $this->view->generalCSS = array('custom/phone/css/intlTelInput.css');
            $this->view->js = array('index/js/main.js','index/js/ui.js','registration/js/init.js','ratechat/js/school.js');
            $this->view->render('registration/start', 'none');
        }

        function retrieve($action){
            $this->view->retrieve = $this->model->retrieve($action);
        }


        function start($redirect = null){
            Session::put('url_on_finished',backToSender());
            Redirect::to(URL.'reg');

            $this->view->generalJS = array('custom/js/upload_check.js','custom/js/ajax.js','custom/plugins/country/countries-state.js','custom/phone/js/intlTelInput.js');
            $this->view->generalCSS = array('custom/phone/css/intlTelInput.css');

            $this->view->js = array('index/js/main.js','index/js/ui.js','registration/js/init.js');
            $this->view->render('registration/start', 'none');
        }

        function step($step = null) {
            if (!isset($_SESSION['record_tracker'])){
                Redirect::to(URL.'reg');
                exit;
            }
            $this->view->account = $this->model->get_info_personal();
            $this->view->generalJS = array('custom/js/upload_check.js','custom/js/ajax.js');
            $this->view->js = array('registration/js/init.js');
            $this->view->render('registration/step', TRUE);
        }

        function association(){
            $this->view->title = 'Student Association/ Club';
            $this->view->render('registration/association','',true);
        }



        function hostel() {
            $this->view->render('registration/hostel/index', TRUE);
        }


        function account_setup() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (Tokens::check(Input::get('token'))) {

                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'phone_code' => array(
                            'name' => 'Verification Code',
                            'required' => true,
                        ),
                        'slug' => array(
                            'name' => 'Personal Web Address',
                            'required' => true,
                            'unique' => 'info_personal',
                        ),
                        'email' => array(
                            'name' => 'email',
                            'required' => true,
                        ),
                        'password' => array(
                            'name' => 'Password',
                            'required' => true,
                            'min' => 6,
                        ),
                        'password_again' => array(
                            'name' => 'Password Confirmation',
                            'required' => true,
                            'matches' => 'password'
                        ),
                        'agreement_2_terms' => array(
                            'name' => 'First Name',
                            'checked' => 'yes',
                            'checkbox' => 1
                        ),
                    ));
                    if ($validation->passed() && $this->model->account_setup()) {
                        Session::delete('record_tracker');
                        $model = $this->reMapRouteToModel('login');
                        $login = $this->login->login(Input::get('email'),Input::get('password'),true);
                        if($login){
                            if((Session::exists('url_on_finished'))){
                                Redirect::to(Session::get('url_on_finished'));
                            }else{
                                Redirect::to(backToSender());
                            }
                        }


                    } else {
                        $message = "";
                        if (count($validation->errors()) == 1) {
                            $message .= "There was 1 error in the form.";
                        } else {
                            $message .= "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    }
                }
            }
            Redirect::to(URL . 'reg/account');
        }


        function personal() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (1) {
                   $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'surname' => array(
                            'name' => 'Surname',
                            'required' => true,
                        ),
                        'firstname' => array(
                            'name' => 'First name',
                            'required' => true,
                        ),
                        'othernames' => array(
                            'name' => 'Other name(s)',
                        ),
                        'password' => array(
                            'name' => 'Password',
                            'required' => true,
                            'min' => 6,
                        ),
                        'password_again' => array(
                            'name' => 'Password Confirmation',
                            'required' => true,
                            'matches' => 'password'
                        ),

                        'sex' => array(
                            'name' => 'Sex',
                            'required' => true,
                        ),
                        'datepicker' => array(
                            'name' => 'Date of Birth',
                            'required' => true,
                        ),
                        'marital_status' => array(
                            'name' => 'Marital Status',
                            'required' => true,
                        ),
                        'nationality' => array(
                            'name' => 'Nationality',
                            'required' => true,
                        ),
                        'state_origin' => array(
                            'name' => 'State of Origin',
                            'required' => true,
                        ),
                        'lga' => array(
                            'name' => 'LGA',
                            'required' => true,
                        ),
                        'residential_address' => array(
                            'name' => 'Permanent Home Address',
                            'required' => true,
                        ),
                        'country' => array(
                            'name' => 'country',
                        ),
                        'phone_number' => array(
                            'name' => 'phone_number',
                            'required' => true,
                        ),
                        'email' => array(
                            'name' => 'Email',
                            'required' => true,
                            'unique' => 'users'
                        ),
                    ));


                    if ($validation->passed()) {
                        //$occupation = (Input::get('occupation')== 'Student') ? 'student' : Input::get('occupation');
                        $date = new DateTime(Input::get('datepicker'));
                        $dob = $date->format('Y-m-d');

                        //$upload = $this->upload(Input::get('MAX_FILE_SIZE'), 'profile-pictures/', 'registration/index');
                        if ($this->model->personal_info(null, $dob)) {
                            Redirect::to(URL.'reg/step');
                            exit();
                        }
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    }
                }
            }
            Redirect::to(URL.'reg');

        }

        function verification_step() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (1) {

                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'program' => array(
                            'name' => 'Qualification',
                            'required' => true,
                        ),
                        'location' => array(
                            'name' => 'Location',
                            'required' => true,
                        ),
                        'hostel_name' => array(
                            'name' => ' Hostel Name',
                            'required' => true,
                        ),
                        'hostel_address' => array(
                            'name' => 'Hostel Address',
                        ),
                        'faculty' => array(
                            'name' => 'Faculty',
                        ),
                        'dept' => array(
                            'name' => 'Department',
                        ),
                        'level' => array(
                            'name' => 'Level',
                        ),
                        'grad_yr' => array(
                            'name' => ' Year of Graduation',
                        ),
                        'work_name' => array(
                            'name' => ' work_name',
                        ),
                        'work_place' => array(
                            'name' => ' work_place',
                        ),
                        'slug' => array(
                            'name' => 'Personal Web Address',
                            'required' => true,
                            'unique' => 'users'
                        ),

                    ));
                    $upload = $this->upload('profile-pictures',true);
                    if ($validation->passed() && $upload) {

                        //upload

                        if ($this->model->verification_step($upload)) {
                            //die(($upload).' every thing is ok');
                            if((Session::exists('url_on_finished'))){
                                Redirect::to(Session::get('url_on_finished'));
                            }else{
                                Redirect::to(URL.'login');
                            }

                        } else {
                            //we have a server error
                            Session::put('error', 'Please contact webmaster');
                            //out error
                        }
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        Session::put('error', $message);

                    }
                }
            }
            Redirect::to(URL . 'reg/step');

        }

        function reg_all_now() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (1) {
                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'program' => array(
                            'name' => 'Program',
                            'required' => true,
                        ),
                        'location' => array(
                            'name' => 'Location',
                            'required' => true,
                        ),
                        'hostel_address' => array(
                            'name' => 'Hostel Address',
                        ),
                        'faculty' => array(
                            'name' => 'Faculty',
                        ),
                        'department' => array(
                            'name' => 'Department',
                        ),
                        'level' => array(
                            'name' => 'Level',
                        ),
                        'grad_yr' => array(
                            'name' => ' Year of Graduation',
                        ),
                        'slug' => array(
                            'name' => 'Username',
                            'required' => true,
                            'unique' => 'users'
                        ),

                        'surname' => array(
                            'name' => 'Surname',
                            'required' => true,
                        ),
                        'firstname' => array(
                            'name' => 'First name',
                            'required' => true,
                        ),
                        'othernames' => array(
                            'name' => 'Other name(s)',
                        ),
                        'nickname' => array(
                            'name' => 'Nickname',
                        ),
                        'password' => array(
                            'name' => 'Password',
                            'required' => true,
                            'min' => 6,
                        ),
                        'password_again' => array(
                            'name' => 'Password Confirmation',
                            'required' => true,
                            'matches' => 'password'
                        ),

                        'sex' => array(
                            'name' => 'Sex',
                            'required' => true,
                        ),
                        'datepicker' => array(
                            'name' => 'Date of Birth',
                            'required' => true,
                        ),
                        'marital_status' => array(
                            'name' => 'Marital Status',
                            'required' => true,
                        ),
                        'nationality' => array(
                            'name' => 'Nationality',
                            'required' => true,
                        ),
                        'state_origin' => array(
                            'name' => 'State of Origin',
                            'required' => true,
                        ),
                        'lga' => array(
                            'name' => 'LGA',
                            'required' => true,
                        ),
                        'residential_address' => array(
                            'name' => 'Permanent Home Address',
                            'required' => true,
                        ),
                        'phone_number' => array(
                            'name' => 'phone_number',
                            'required' => true,
                        ),
                        'email' => array(
                            'name' => 'Email',
                            'required' => true,
                            'unique' => 'users'
                        ),
                    ));

                    $upload = $this->upload('profile-pictures',true);

                    if ($validation->passed()) {
                        //$occupation = (Input::get('occupation')== 'Student') ? 'student' : Input::get('occupation');
                        $date = new DateTime(Input::get('datepicker'));
                        $dob = $date->format('Y-m-d');

                        //$upload = $this->upload(Input::get('MAX_FILE_SIZE'), 'profile-pictures/', 'registration/index');
                        if ($this->model->reg_all_now($upload, $dob)) {
                            if((Session::exists('url_on_finished'))){
                                Redirect::to(Session::get('url_on_finished'));
                            }else{
                                Redirect::to(URL.'login');
                            }
                        }
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    }
                }
            }
            Redirect::to(URL.'reg');

        }


        function reg_association() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (1) {

                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'group_name' => array(
                            'name' => 'Name of Association/ Club',
                            'required' => true,
                            'unique' => 'student_groups'
                        ),
                        'year_reg' => array(
                            'name' => 'Year of Initial Registration',
                            'required' => true,
                        ),
                        'club_type' => array(
                            'name' => 'Association/ Club Type',
                            'required' => true,
                        ),
                        'staff_name' => array(
                            'name' => 'Name of Staff Adviser',
                            'required' => true,
                        ),
                        'staff_phone' => array(
                            'name' => 'Staff Adviser Phone Number',
                            'required' => true,
                        ),
                        'staff_status' => array(
                            'name' => 'Status of Staff Adviser',
                            'required' => true,
                        ),
                        'staff_dept' => array(
                            'name' => 'Staff Adviser Department',
                            'required' => true,
                        ),
                        'staff_fac' => array(
                            'name' => 'Staff Adviser  Faculty',
                            'required' => true,
                        ),
                        'brief_desc' => array(
                            'name' => 'Association Description',
                            'required' => true,
                        ),

                    ));

                    if ($validation->passed()) {

                        $this->view->codeword = $this->model->reg_association($this->upload('club_logo'));

                        $this->view->render('registration/done','',true);
                        exit();

                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        Session::put('error', $message);

                    }
                }
            }
            Redirect::to(backToSender());

        }

        function codeword() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (1) {

                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'codeword' => array(
                            'name' => 'Code Number',
                            'required' => true,
                        ),

                    ));

                    if ($validation->passed()) {
                        $this->view->codeword = $this->model->get_codeword(Input::get('codeword'));
                        $this->view->render('registration/done','',true);
                        exit();

                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        Session::put('error', $message);

                    }
                }
            }
            Redirect::to(backToSender());

        }





        function professional() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (Tokens::check(Input::get('token'))) {
                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'organization' => array(
                            'name' => 'Name of Organization',
                            'required' => true,
                        ),
                        'division' => array(
                            'name' => 'Division',
                        ),
                        'position' => array(
                            'name' => 'Position',
                            'required' => true,
                        ),
                        'specialization' => array(
                            'name' => 'Specialization',
                        ),
                        'biz_phone' => array(
                            'name' => 'Business Phone Number',
                        ),
                        'biz_email' => array(
                            'name' => 'Business Email Address',
                        ),
                        'employ_day' => array(
                            'name' => 'Employment/Entry Date - Day',
                            'required' => true,
                        ),
                        'employ_month' => array(
                            'name' => 'Employment/Entry Date - Month',
                            'required' => true,
                        ),
                        'employ_year' => array(
                            'name' => 'Employment/Entry Date - Year',
                            'required' => true,
                        ),
                        'exit_day' => array(
                            'name' => 'Retirement/ Exit Date - Day',
                        ),
                        'exit_month' => array(
                            'name' => 'Retirement/ Exit Date - Month',
                        ),
                        'exit_year' => array(
                            'name' => 'Retirement/ Exit Date - Year',
                        ),
                        'biz_address' => array(
                            'name' => 'Full Business Address',
                            'required' => true,
                        ),
                        'biz_postal' => array(
                            'name' => 'Business Postal Address',
                        ),
                    ));

                    $adm_day = Input::get('employ_day');
                    $adm_month = Input::get('employ_month');
                    $adm_year = Input::get('employ_year');
                    $gooddate1 = checkdate($adm_month, $adm_day, $adm_year) ? true : false;

                    $grad_day = Input::get('exit_day');
                    $grad_month = Input::get('exit_month');
                    $grad_year = Input::get('exit_year');
                    $gooddate2 = checkdate($grad_month, $grad_day, $grad_year) ? true : false;

                    if ($gooddate1) {
                        $date = new DateTime("$adm_year-$adm_month-$adm_day");
                        $employ_date = $date->format('Y-m-d');
                        $goodDate = true;

                        if ($gooddate2) {
                            $date = new DateTime("$grad_year-$grad_month-$grad_day");
                            $retire_date = $date->format('Y-m-d');
                        } else {
                            $retire_date = NULL;
                        }
                    }
                    if ($validation->passed() && $goodDate) {

                        if ($this->model->professional($employ_date, $retire_date)) {
                            //enter data to db
                            //die(($upload).' every thing is ok');
                        } else {
                            //we have a server error
                            Session::put('error', 'Please contact webmaster');
                            //out error
                        }
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        if (!$goodDate) {
                            $message .= "Please check your date format. Day - Month - Year combination";
                        }
                    }
                    Session::put('error', $message);
                }
            }
            Redirect::to(URL . 'reg/worker');
        }

        function parents_info() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (Tokens::check(Input::get('token'))) {
                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'parents_name' => array(
                            'name' => 'Name of Sponsor',
                            'required' => true,
                        ),
                        'relationship' => array(
                            'name' => 'Relationship',
                            'required' => true,
                        ),
                        'parents_phone' => array(
                            'name' => 'Phone Number of Parent/ Guardian',
                            'required' => true,
                        ),
                        'parents_email' => array(
                            'name' => 'Email of Parent/ Guardian',
                            'required' => true,
                        ),
                        'parents_occupation' => array(
                            'name' => 'Occupation of Parent',
                            'required' => true,
                        ),
                        'biz_address' => array(
                            'name' => 'Full Business/ Office Address',
                            'required' => true,
                        ),
                        'home_address' => array(
                            'name' => 'Home/ Residence Address',
                            'required' => true,
                        ),
                    ));

                    if ($validation->passed()) {

                        //$upload = $this->upload(Input::get('MAX_FILE_SIZE'), 'payments/', 'step-5');
                        if ($this->model->info_parents()) {
                            //enter data to db
                            //die(($upload).' every thing is ok');
                        } else {
                            //we have a server error
                            Session::put('error', 'Please contact webmaster');
                            //out error
                        }
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();

                    }
                    Session::put('error', $message);
                }
            }
            Redirect::to(URL . 'registration/step/parents');

        }

        function update_pass() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (1) {
                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'login_email' => array(
                            'name' => 'Email',
                        ),
                        'old_pass' => array(
                            'name' => 'Old Password',
                            'required' => true,
                            'min' => 6,
                        ),
                        'new_pass' => array(
                            'name' => 'New Password',
                            'required' => true,
                        ),
                        'new_again' => array(
                            'name' => 'New Password Confirmation',
                            'required' => true,
                            'matches' => 'new_pass',
                        ),
                   ));

                    if ($validation->passed()) {
                       if ($this->model->update_password()) {
                         }
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        Session::put('error', $message);

                    }
                }
            }
            Redirect::to(backToSender());

        }

        function account_update() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (1) {
                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'email' => array(
                            'name' => 'Email',
                            'required' => true,
                        ),
                        'phone_no' => array(
                            'name' => 'Phone Number',
                            'required' => true,
                        ),
                    ));


                    if ($validation->passed()) {
                        $this->model->account_update();
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    }
                }
            }
            Redirect::to(backToSender());

        }

        function picture_update() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (1) {
                    $upload = $this->upload('profile-pictures');

                    $this->model->picture_update($upload);
                }
            }
            Redirect::to(backToSender());

        }


        function upload($folder = '', $error = false) {
            //echo($max);
            $result = array();

            //upload
            $destination = UPLOAD_PATH . $folder;
            $upload = new Upload($destination);
            //$upload->setMaxSize($max);
            $upload->allowAllTypes();
            $upload->upload();
            foreach ($upload->getMessages() as $msg) {
                $result[] = $msg;
            }
            //if the sub-folder doesn't exist yet create it
            if (!is_dir($destination)) {
                mkdir($destination);
            }
            $path = $upload->fileName();

            if (!isset($path) && $error) {
                $result[] = "Please Upload an Image file";
                $path = NULL;
                $output = "<p class=\"errors\"> ";
                $output .= "Please review the following fields: <br />";
                foreach ($result as $error) {
                    $output .= " - " . $error . "<br />";
                }
                $output .= "</p>";
                Session::put('error', $output);
                //Redirect::to(URL . $step);
                //$this->view->render('reg/member/'.$step, true);

                return false;
            } else {
                return $path;
            }
            //Do not resize, do not save any resized image. Responsive system automatically adjust to fit screen size
            /*
              else{
              $resize = new Resize($destination.$path);
              $resize->resizeImage(120, 90, 'exact');
              $resize->saveImage($destination.'/'.$id_key.'/'.$path, 100);
              } */
        }

        function contact_support() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (1) {
                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'send_to' => array(
                            'name' => 'Send to',
                            'required' => true,
                        ),
                        'subject' => array(
                            'name' => 'Subject ',
                            'required' => true,
                        ),
                        'message' => array(
                            'name' => 'Message',
                            'required' => true,
                        ),
                    ));


                    if ($validation->passed()) {
                        $this->model->contact_support();
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    }
                }
            }
            Redirect::to(backToSender());

        }


    }
