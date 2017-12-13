<?php

class Login extends Controller {

    function __construct() {
        parent::__construct();

        $this->view->generalJS = array('custom/js/ajax.js');
    }

    function index() {
        $this->view->js = array('login/js/main.js');
        $this->model->check_status(); //checks login status
        $this->view->title = 'Login - Rate Chats';
        $this->view->render('login/index', 'none');
    }

    function reg() {
        $this->view->generalJS = array('custom/phone/js/intlTelInput.js','custom/phone/js/activator.js');
        $this->view->generalCSS = array('custom/phone/css/intlTelInput.css');
        $this->view->js = array('login/js/ui.js');
        $this->view->title = 'Register';
        $this->view->render('login/reg', 'none');
    }

    function account_setup() {
        //@Task: Do your error checking
        if (Input::exists()) {
            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'first_name' => array(
                    'name' => 'First Name',
                    'required' => true,
                ),
                'last_name' => array(
                    'name' => 'Last Name',
                    'required' => true,
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
                'phone_number' => array(
                    'name' => 'Phone Number',
                    'required' => true,
                ),
                'slug' => array(
                    'name' => 'Username',
                    'required' => true,
                    'unique' => 'users',
                ),
                'email' => array(
                    'name' => 'Email',
                    'required' => true,
                    'unique' => 'users',
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
                    'name' => 'Agreement to Terms.',
                    'checked' => 'yes',
                    'checkbox' => 1
                ),
            ));
            if ($validation->passed() && $this->model->account_setup()) {

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
        Redirect::to(backToSender());
    }

    function recovery(){
        $this->view->js = array('login/js/pass_recover.js');

        $this->view->title = "Password Recovery";
        $this->view->render('login/password_recovery');
    }

    function recaptcha(){
        if (Input::exists()) {

            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'email_recover' => array(
                    'name' => 'Email',
                    'required' => true,
                ),
            ));
            if ($validation->passed()) { // && recaptcha()
                $email = Input::get('email_recover');
                $url_string = $this->model->recovery($email);
                if($url_string){
                    // Email the user their activation link
                    $to = $email;
                    $from = "no-reply@Rate Chats.com.ng"; //
                    $subject = 'Password Reset on Rate Chats Web';
                    $message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Rate Chats Website</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:20px; background:#f4511e; font-size:24px; color:#fff;">You requested a password reset: '. date('D, d F, Y ')." at " .date(' h:i:s a').'</div><div style="padding:24px; font-size:17px;">Hello, <h1>Password Reset Request</h1><br />This is an automatically generated email, it was sent to you because you have requested a password reset.<br />Your Password for this account: '.$email.' has been reset.<br /><br /><b><a href="https://Rate Chats.com.ng/login/reset/'.$email.'/'.$url_string.'">Click here to Complete this request now</a></b><br /><br />Please ignore this mail if you did not request it. Thanks</div></body></html>';
                    $headers = "From: $from\n";
                    $headers .= "MIME-Version: 1.0\n";
                    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
                    //$headers .= 'Cc: nonso@frogfreezone.com' . "\r\n";
                    //$headers .= 'Bcc: nonso@frogfreezone.com' . "\r\n";
                    $headers .= 'Reply-To: '.$from.'' . "\r\n";
                    if(!mail($to, $subject, $message, $headers)){
                        Session::put('error','Something went wrong with the last request. Please try again. Thanks');
                    }else{
                        Session::put('home','Mail was successfully sent. Please check your inbox or spam folder. If it doesn\'t arrive immediately, please wait 5 minutes');
                    }
                }

            }else{
                if (count($validation->errors()) == 1) {
                    $message = "Error in submission.";
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }
            }
        }
        Redirect::to(backToSender());

    }


    function run() {
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'login_email' => array(
                    'name' => 'Email',
                    'required' => true),
                'login_pwd' => array(
                    'name' => 'Password',
                    'required' => true)
            ));
            if ($validate->passed()) {
                $remember = (Input::get('login_me') === 'remember') ? true : false;

                if ($this->model->login_ajax(Input::get('login_email'), Input::get('login_pwd'), $remember)) {
                    //log user in
                    echo "success";
                    exit();
                } else {
                    //failed
                    echo "no_match";
                    exit();
                }



            } else {
                echo "f";
                exit();

            }
        }
    }

    function login() {
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'email' => array(
                    'name' => 'email',
                    'required' => true),
                'password' => array(
                    'name' => 'Password',
                    'required' => true),
            ));

            if ($validate->passed()) {
                //log user in
                $remember = (Input::checkbox('login_me')) ? true : false;

                if ($this->model->login(Input::get('email'), Input::get('password'), $remember)) {
                    Redirect::to(Session::get('page_to_redirect'));
                    Session::delete('page_to_redirect');
                    exit();
                } else {
                    //die(error_get_last());
                    //failed
                    $message = "Username/password incorrect.";
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
            Redirect::to(URL . "login");
        }
    }

    function check_details($detail){
        $this->model->check_details($detail);
    }

    function register() {
        //$this->view->js = array('login/js/main.js');

        //$this->model->check_status(); //checks login status
        $this->view->title = 'New Membership Register';
        $this->view->render('login/register', 'index');
    }





    function logout() {

        $this->view->title = 'Logout';
        $this->model->logout();

        Session::delete('loggedIn');
        Session::delete('role');
        Cookie::delete('hash');
        session_destroy();

        //thanks for destroying, now lets begin anew
        session_start();
        Session::flash('home', 'You have been successfully logged out!');

        Redirect::to(URL . 'login');
    }

    function reset($email = null, $url = null){
        if($email && $url){
            $email = urldecode($email);
            $url = urldecode($url);
            if($true = $this->model->reset($email , $url )){
                $this->view->title = 'Temporary Login Reset';
                $this->view->render('login/temp_login');
            }
        }
        elseif(Session::exists('temp_pass_session')){
            $this->view->title = 'Temporary Login Reset';
            $this->view->render('login/temp_login', 'index');

        }
        else{
            Redirect::to(URL.'login');
            exit;
        }


    }

    function temporary() {
        Session::put('temp_pass_session',1);
        if(Session::exists('temp_pass_session')){
            $this->view->title = 'Temporary Login Reset';
            $this->view->render('login/temp_login', 'index');

        }else{
            Redirect::to(URL.'login');
            exit;
        }

    }

    function temp_login() {

        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'password' => array(
                    'name' => 'Password',
                    'required' => true,
                    'min' => 6,
                ),
                'confirm_pass' => array(
                    'name' => 'Password Confirmation',
                    'required' => true,
                    'matches' => 'password'
                ),
            ));

            if ($validate->passed()) {
                list($email, $pass) = $this->model->temp_login();
                $login = $this->model->login($email,$pass,true);

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
        Redirect::to(URL . "login");
    }

}
