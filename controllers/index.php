<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();

        $this->view->generalJS = array('custom/js/ajax.js');
    }

    function index(){
        $this->view->generalJS = array('custom/js/upload_check.js','custom/js/ajax.js','custom/plugins/country/countries-state.js','custom/phone/js/intlTelInput.js');
        $this->view->generalCSS = array('custom/phone/css/intlTelInput.css');

        //$this->view->generalJS = array('custom/js/upload_check.js','custom/js/ajax.js','custom/js/faculty-dept.js','custom/plugins/country/countries-state.js');
        $this->view->js = array('index/js/main.js','index/js/ui.js','registration/js/init.js');

        $this->view->title = "Rate Chats ";
        $model = $this->reMapRouteToModel('blog');
        $this->view->latest10 = $this->blog->get_all_blog_titles(false, 5);
        $this->view->last = $this->blog->get_last_post();
        $this->view->gallery = $this->model->gallery();
        $this->view->events = $this->model->events();


        $this->view->render('index/index', 'none');
    }

    function about(){
        $this->view->title = "About Rate Chats ";
        $this->view->render('index/about');
    }


    function hostel_search($str, $for = null){
        $this->model->hostel_search($str, $for);
    }

    function event($action = null, $id = null){
        if($action && $id){
            switch($action){
                case 'view':
                    list($this->view->about, $this->view->count) = $this->model->view_event($id);
                    $page = 'view';
                    break;
            }

        }else{
            $this->view->about = $this->model->get_event();
            $page = 'event';
        }
        $this->view->jsPlugin = array('timepicker/bootstrap-timepicker.min.js');
        $this->view->cssPlugin = array('timepicker/bootstrap-timepicker.min.css');
        $this->view->js = array('webmaster/js/ui.js');
        $this->view->generalJS = array('upload_check.js','ajax.js');

        $this->view->title = 'The  Event\'s Calender ';
        $this->view->render('index/event/'.$page);
    }


    function roommate($sex = null){
        $model = $this->reMapRouteToModel('dashboard');
        list($this->view->roommate,$this->view->male,$this->view->female) = $this->dashboard->get_roommate_request($sex);

        $this->view->title = 'Find Roommate ';
        $this->view->render('index/roommate');
    }


    /*_--------------------------- ACTION GROUP  -------------------------------------------------     */

    function run_about() {
        if (Input::exists()) {
            if (Tokens::check(Input::get('token'))) {

                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'name' => array(
                        'name' => 'Full Names',
                        'required' => true),
                    'phone_no' => array(
                        'name' => 'Phone Number'),
                    'email' => array(
                        'name' => 'Email',
                        'required' => true),
                    'address' => array(
                        'name' => 'Contact Address'),
                    'message' => array(
                        'name' => 'Message',
                        'required' => true),
                    'subject' => array(
                        'name' => 'Subject',
                        )
                ));
                if ($validation->passed() && recaptcha(TRUE) && $this->model->run_about()) {
                    echo('success');
                    exit();


                } else {
                    echo('bad_validation');
                    exit();

                }
            }
        }
    }



	

}