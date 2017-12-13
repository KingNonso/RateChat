<?php

    class Webmaster extends Controller {

        function __construct() {
            parent::__construct();

            $this->view->generalJS = array('custom/js/ajax.js');
            $logged = Session::get('loggedIn');
            $logged = Session::get('loggedIn');
            if ($logged == false || Session::get('role') !== 'webmaster') {
                Redirect::to(URL.'login');
            }
        }
        function index(){
            //get the last item in the blog and all titles
            $this->view->title = 'Webmaster ';
            //$this->view->account = $this->model->account();

            $this->view->dashboard = $this->model->dashboard();
            $this->view->analysis = $this->model->analysis();
            $this->view->render('webmaster/index','admin');
        }

        function add_new_plan($manager){
            $this->view->manager = $this->model->account($manager) ;
            $this->view->hostel = $this->model->hostel() ;
            $this->view->title = 'Add Hostel Manager';
            $this->view->render('webmaster/add_new_plan','admin');
        }

        function make_admin($how,$id = null){
            $this->view->users = $this->model->make_admin($how,$id);

        }
        function block_user($how,$id){
            $this->view->users = $this->model->block_user($how,$id);

        }

        function enter_account($id){
            $this->view->users = $this->model->enter_account($id);
        }

        function set_hostel_manager($who,$id){
            $this->view->users = $this->model->set_hostel_manager($who,$id);
        }


        function account($name = null){
            $this->view->title = 'My Account ';
            $this->view->account = $this->model->account();
            $this->view->render('webmaster/account','admin');

        }

        function support($name = null){
            $this->view->title = ' Support Services ';
            $this->view->account = $this->model->account();
            $this->view->render('webmaster/support','admin');

        }

        function referral($name = null){
            $this->view->title = ' Referral Services ';
            $this->view->account = $this->model->account();
            //$this->view->referral = $this->model->referral();
            $this->view->render('webmaster/referral','admin');

        }

        function chat($name = null){
            $this->view->js = array('webmaster/js/send.js');
            $this->view->title = ' Direct Chat  ';
            $this->view->chat = $this->model->get_chat();
            $this->view->render('webmaster/chat','admin');

        }
        function messages($id){
            $this->model->send_chat($id);
        }

        function broadcast($name = null){
            $this->view->title = 'Message Broadcast';
            if(Input::exists()){
                $this->model->send_broadcast();

            }
            $this->view->broadcast = $this->model->get_broadcast();

            $this->view->render('webmaster/broadcast','admin');

        }

        function numbers(){
            $this->view->title = 'All Phone Numbers';
            $this->view->numbers =  $this->model->numbers();
            $this->view->render('webmaster/numbers','admin');


        }



        function plan($type = null){
            $this->view->packages = $this->model->packages();
            //$this->view->package = $this->model->packages($type);
            //$this->view->selected = (isset($type))? $type : null;

            $this->view->title = (isset($type))? 'Chosen plan' : 'Available plan';
            $this->view->render('webmaster/plan','admin');
        }
        function start($type= null){
            $this->view->plan = $this->model->check_plan($type);

            $this->view->js = array('webmaster/js/starter.js','webmaster/js/jquery.countdown.js');

            $this->view->title = 'Portfolio Maker';
            $this->view->render('webmaster/start','admin');
        }

        function merger($plan= null){
            If(Input::exists() && Input::get('action')=='merge'){
                $this->model->start_package($plan);
            }else{
                Redirect::to(URL.'webmaster/plan');
            }
        }


        function users($id=1){
            $this->view->js = array('webmaster/js/users.js');
            $this->view->users = $this->model->users($id);
            $this->view->packages = $this->model->packages();
            $this->view->title = 'Online Members';
            $this->view->render('webmaster/users','admin');
        }


        function portfolio($type= null){
            $this->view->portfolio = $this->model->portfolio();

            list($this->view->payables,$this->view->receivables) = $this->model->transaction($type);

            $this->view->title = 'My Portfolio';
            $this->view->render('webmaster/transaction','admin');
        }

        function confirm_payment($id = null){

            if(Input::exists()){
                $validate = new Validate();
                //validate input

                $validation = $validate->check($_POST,array(
                    'plan_id' => array(
                        'name' => 'plan_id',
                        'required' => true,
                    ),
                    'payer' => array(
                        'name' => 'You have not been matched on this package. Payer',
                        'required' => true,
                    ),

                ));

                if($validate->passed() && $this->model->confirm_payment($id, Input::get('plan_id'),Input::get('payer'))){
                } else {
                    $message = "";
                    if (count($validation->errors()) == 1) {
                        $message .= "An Error Occurred.";
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    } elseif (count($validation->errors()) > 1) {
                        $message .= "There were " . count($validation->errors()) . " errors in the form.<br />";
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    }
                }
            }
            Redirect::to(backToSender());


        }

        function create_new_plan(){
            if(Input::exists()){
                $validate = new Validate();
                //validate input

                $validation = $validate->check($_POST,array(
                    'plan_name' => array(
                        'name' => 'Plan Name',
                        'required' => true,
                    ),
                    'plan_amount' => array(
                        'name' => 'Amount Payable',
                        'required' => true,
                    ),

                ));

                if($validate->passed() && $this->model->create_new_plan(Input::get('plan_name'),Input::get('plan_amount'))){
                } else {
                    $message = "";
                    if (count($validation->errors()) == 1) {
                        $message .= "An Error Occurred.";
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    } elseif (count($validation->errors()) > 1) {
                        $message .= "There were " . count($validation->errors()) . " errors in the form.<br />";
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    }
                }
            }
            Redirect::to(backToSender());

        }

        public function pop($id = null, $plan = null){
            $this->view->generalJS = array('custom/js/upload_check.js','custom/js/ajax.js');

            $this->view->js = array('webmaster/js/wall_pic_post.js');

            $this->view->id = $id;
            $this->view->plan = $plan;

            Session::put('home','Please confirm the payment for this transaction');
            $this->view->title = 'My Transaction POP';
            $this->view->render('webmaster/pop','admin');

        }

        public function upload_pop(){
            $this->model->upload_pop(Input::get('picture'), Input::get('pool'),Input::get('plan_id'));

        }


        function picturePost(){
            $max = Input::get('max');
            $pool = Input::get('pool');
            $plan_id = Input::get('plan_id');
            $folder = 'pop/';

            $result = array();

            //upload
            $destination = UPLOAD_PATH . $folder;
            $upload = new Upload($destination);
            $upload->setMaxSize($max);
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

            if (!isset($path)) {
                $path = NULL;
                $output = "<p class=\"errors\"> ";
                $output .= "Please review the following fields: <br />";
                foreach ($result as $error) {
                    $output .= " - " . $error . "<br />";
                }
                $output .= "</p>";
                echo($output);
                return false;
            } else {
                $this->model->upload_pop($path, Input::get('pool'),Input::get('plan_id'));
                echo($path);
                exit();
            }
            //Do not resize, do not save any resized image. Responsive system automatically adjust to fit screen size
            /*
              else{
              $resize = new Resize($destination.$path);
              $resize->resizeImage(120, 90, 'exact');
              $resize->saveImage($destination.'/'.$id_key.'/'.$path, 100);
              } */
        }



        function upload($max, $folder, $step) {
            //echo($max);
            $result = array();

            //upload
            $destination = UPLOAD_PATH . $folder;
            $upload = new Upload($destination);
            $upload->setMaxSize($max);
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

            if (!isset($path)) {
                $result[] = "Please Upload an Image file";
                $path = NULL;
                $output = "<p class=\"errors\"> ";
                $output .= "Please review the following fields: <br />";
                foreach ($result as $error) {
                    $output .= " - " . $error . "<br />";
                }
                $output .= "</p>";
                Session::put('error', $output);
                //Redirect::to(backToSender());
                return null;

            } else {
                //$resize = new Resize($destination.$path);
                //$resize->resizeImage(120, 90, 'exact');
                //$resize->saveImage($destination.$path, 100);

                return $path;
            }
        }

        function update($what = null, $id = null){

            if(Input::exists() && $what && $id){
                $validate = new Validate();
                //validate input
                switch($what){
                    case 'password':
                        $validation = $validate->check($_POST,array(
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
                        break;
                    case 'personal':
                        $validation = $validate->check($_POST,array(
                            'special_needs' => array(
                                'name' => 'Preferences  ',
                            ),
                            'home_address' => array(
                                'name' => 'Home Address  ',
                            ),

                        ));

                }


                if($validate->passed() && $this->model->update($what,$id )){
                } else {
                    $message = "";
                    if (count($validation->errors()) == 1) {
                        $message .= "An Error Occurred.";
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    } elseif (count($validation->errors()) > 1) {
                        $message .= "There were " . count($validation->errors()) . " errors in the form.<br />";
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    }
                }
            }
            Redirect::to(backToSender());


        }

        function purge($id = null){

            if(Input::exists()){
                $validate = new Validate();
                //validate input

                $validation = $validate->check($_POST,array(
                    'plan_id' => array(
                        'name' => 'plan_id',
                        'required' => true,
                    ),
                    'payer' => array(
                        'name' => 'You have not been matched on this package. Payer',
                        'required' => true,
                    ),

                ));

                if($validate->passed() && $this->model->purge($id, Input::get('plan_id'),Input::get('payer'))){
                    Redirect::to(backToSender());
                } else {
                    $message = "";
                    if (count($validation->errors()) == 1) {
                        $message .= "An Error Occurred.";
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    } elseif (count($validation->errors()) > 1) {
                        $message .= "There were " . count($validation->errors()) . " errors in the form.<br />";
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    }
                }
            }
            Redirect::to(backToSender());


        }

        function purge_self($id = null){

            if(Input::exists()){
                $validate = new Validate();
                //validate input

                $validation = $validate->check($_POST,array(
                    'plan_id' => array(
                        'name' => 'plan_id',
                        'required' => true,
                    ),
                    'payer' => array(
                        'name' => 'You have not been matched on this package. Payer',
                        'required' => true,
                    ),

                ));

                if($validate->passed() && $this->model->purge_self($id, Input::get('plan_id'),Input::get('payer'))){
                    Redirect::to(backToSender());
                } else {
                    $message = "";
                    if (count($validation->errors()) == 1) {
                        $message .= "An Error Occurred.";
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    } elseif (count($validation->errors()) > 1) {
                        $message .= "There were " . count($validation->errors()) . " errors in the form.<br />";
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    }
                }
            }
            Redirect::to(backToSender());


        }

        function reward($type = null){

            if(Input::exists()){
                $validate = new Validate();
                //validate input

                $validation = $validate->check($_POST,array(
                    'message' => array(
                        'name' => 'message',
                        'required' => true,
                    ),
                    'link' => array(
                        'name' => 'link',
                        'required' => true,
                    ),

                ));

                if($validate->passed() && $this->model->reward($type)){
                } else {
                    $message = "";
                    if (count($validation->errors()) == 1) {
                        $message .= "An Error Occurred.";
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    } elseif (count($validation->errors()) > 1) {
                        $message .= "There were " . count($validation->errors()) . " errors in the form.<br />";
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    }
                }
            }
            Redirect::to(backToSender());


        }

        function hostel(){
            $this->view->hostel = $this->model->hostel() ;
            $this->view->header = "Hostel Information";
            $this->view->render('webmaster/hostel/hostel', 'admin');
        }

        function management($id = null){
            list($this->view->account,$this->view->blocks) = $this->model->get_hostel_details($id);

            $this->view->generalJS = array('upload_check.js');

            $this->view->title = 'Hostel Management Information';
            $this->view->render('webmaster/hostel/management', 'admin');
        }

        function create_block_room($hostel_id = null, $block_id = null){
            $id = (isset($id))? $id : Session::get('hostel_id');
            $this->view->hostel_id = $hostel_id;
            $this->view->block_id = $block_id;
            $this->view->rooms = $this->model->get_block_rooms($block_id);
            $this->view->header = "Block rooms";
            $this->view->render('webmaster/hostel/rooms','admin');
        }


        function remove_room($block_id = null){
            $this->view->rooms = $this->model->remove_room($block_id);
            Redirect::to(backToSender());
        }






    }