<?php

class Ratechat extends Controller {

    function __construct() {
        parent::__construct();

        $logged = Session::get('loggedIn');
        if ($logged == false) {
            Redirect::to(URL.'login');
            return false;
        }
        $this->view->generalJS = array('ajax.js');
    }

    function index(){
        list($this->view->rate_list,$this->view->my_list) = $this->model->get_rating_list();
        $this->view->js = array('ratechat/js/starRating.js');
        $this->view->cssPlugin = array('starability-master/starability-minified/starability-all.min.css');
        //$this->view->jsPlugin = array('ratechat/js/honour.js');

        ///list($this->view->questions,$this->view->answer) = $this->model->get_ratechat_questions();
        $this->view->title = "Start Rate";
        $this->view->render('ratechat/index','admin');
    }

    function answers($next = null){

        list($this->view->rate,$this->view->content, $type,$this->view->response) = $this->model->get_ratechat_questions($next);
        $this->view->title = "Response Rate";
        if($type == 'vote'){
            Session::put('encryption',Hash::unique());
            $this->view->js = array('ratechat/js/honour.js');
            $this->view->render('ratechat/honour','admin');
        }else{
            $this->view->js = array('ratechat/js/starRating.js');
            $this->view->cssPlugin = array('starability-master/starability-minified/starability-all.min.css');
            $this->view->render('ratechat/answers','admin');
        }
    }

    function responses($next = null){

        list($this->view->rate,$this->view->content, $type,$this->view->response) = $this->model->get_ratechat_responses($next);
        $this->view->title = "Responses";
        if($type == 'vote'){
            Session::put('encryption',Hash::unique());
            $this->view->js = array('ratechat/js/honour.js');
            $this->view->render('ratechat/vote_result','admin');
        }else{
            $this->view->js = array('ratechat/js/starRating.js');
            $this->view->cssPlugin = array('starability-master/starability-minified/starability-all.min.css');
            $this->view->render('ratechat/role_of_honour','admin');
        }

    }


    function voteCube($action){
        if(Input::exists('post') && $action == Session::get('encryption')){
            $this->view->retrieve = $this->model->voteCube($action);
        }
    }
    function ratechatAnswers(){
        if(Input::exists('post')){
            $this->view->retrieve = $this->model->ratechatAnswers();
        }
    }

    function starRater(){
        $this->model->starRater();  ;
    }
    function create(){
        $this->view->generalJS = array('upload_check.js');
        $this->view->title = "Create New ";
        $this->view->render('ratechat/create','admin');
    }

    function create_rate($update = null){
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'name' => array(
                    'name' => 'Name ',
                    'required' => true),
                'description' => array(
                    'name' => 'Description',
                    ),
                'rate_type' => array(
                    'name' => 'Rating Type',
                    'required' => true),

            ));
            if ($validation->passed()) {
                $upload = $this->upload('ratechat');
                $this->view->timeline = $this->model->create_rate($upload, $update);
            } else {
                $message = "";
                if (count($validation->errors()) == 1) {
                    $message .= "There was 1 error in the form.";
                } else {
                    $message .= "There were " . count($validation->errors()) . " errors in the form.<br />";
                }
                $message .= $validate->display_errors();
                Session::put('error', $message);
                Redirect::to(backToSender());
            }
        }
        $this->view->generalJS = array('upload_check.js');
        $this->view->title = "Content for Rating/Ranking ";
        $this->view->render('ratechat/create_content','admin');


    }

    function create_rate_content($update = null){
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'name' => array(
                    'name' => 'Name ',
                    'required' => true),
                'description' => array(
                    'name' => 'Description',
                ),
                'content_type' => array(
                    'name' => 'Content Type',
                    ),

            ));
            if ($validation->passed()) {
                $upload = $this->upload('ratechat');
                $this->view->timeline = $this->model->create_rate_content($upload,$update);
            } else {
                $message = "";
                if (count($validation->errors()) == 1) {
                    $message .= "There was 1 error in the form.";
                } else {
                    $message .= "There were " . count($validation->errors()) . " errors in the form.<br />";
                }
                $message .= $validate->display_errors();
                Session::put('error', $message);
                Redirect::to(backToSender());
            }
        }
        $this->view->generalJS = array('upload_check.js');
        $this->view->title = "Content for Rating/Ranking ";
        $this->view->render('ratechat/create_content','admin');


    }

    function publish_rate(){
        $this->view->publish_rate = $this->model->publish_rate();
        Redirect::to(URL.'ratechat/answers');
    }


    function retrieve($action){
        $this->view->retrieve = $this->model->retrieve($action);
    }


    function join($sex = null){
        $this->view->title = "  - Join ";
        $this->view->render('ratechat/join','none');
    }

    function start($sex = null){
        $this->view->title = "  ";
        $this->view->render('ratechat/design','none');
    }
    function ratechat($sex = null){
        $this->view->honour = $this->model->get_role_of_honour();
        $this->view->title = "  - Role of Honour ";
        $this->view->render('ratechat/role_of_honour','none');
    }

    function video($sex = null){
        $this->view->title = "  - Video ";
        $this->view->render('ratechat/video','none');
    }

    function picture($tag = null){
        $this->view->generalJS = array('upload_check.js','ajax.js');
        switch($tag){
            case 'baby':
            case 'first':
            case 'final':
                $this->view->tag = $tag;
            break;
            case 'other':
                $this->view->tag = $tag;
                break;
            default:
                Session::flash('error','Invalid Selection... Default action applied');
                $this->view->tag = 'other';
                break;

        }
        $this->view->title = "  - picture ";
        $this->view->render('ratechat/picture','none');
    }

    function questions($sex = null){
        $this->view->title = "  - Slum Badge ";
        $this->view->render('ratechat/questions','none');
    }

    function timeline($person = null){
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'student_id' => array(
                    'name' => 'Student ID ',
                    'required' => true),
                'student_pin' => array(
                    'name' => 'Access PIN',
                    'required' => true),

            ));
            if ($validation->passed()) {
                //log who the viewer is

                //go to timeline
                //$person = Input::get('student_id');
                Redirect::to(backToSender());
            } else {
                $message = "";
                if (count($validation->errors()) == 1) {
                    $message .= "There was 1 error in the form.";
                } else {
                    $message .= "There were " . count($validation->errors()) . " errors in the form.<br />";
                }
                $message .= $validate->display_errors();
                Session::put('error', $message);
                Redirect::to(backToSender());
            }
        }

        $this->view->timeline = $this->model->timeline($person);
        $this->view->title = "  - Time Line ";
        $this->view->render('ratechat/timeliner','admin');
    }




    function vote($person = null){
        $this->view->title = " Roll of Honour ";
        $this->view->criteria = $this->model->get_ratechat_criteria($person);
        $this->view->title = "  - Time Line ";
        $this->view->render('ratechat/vote_criteria','admin');
    }

    function nominate($person = null){
        $this->view->title = "Nominate ";
        $this->view->criteria = $this->model->get_ratechat_criteria($person);
        $this->view->js = array('ratechat/js/school.js');
        $this->view->everyone = $this->model->get_everyone_in_my_class();
        $this->view->render('ratechat/vote','admin');
    }


        /*_--------------------------- ACTION GROUP  -------------------------------------------------     */

    function ratechat_vote_criteria() {
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'criteria' => array(
                    'name' => 'criteria ',
                    'required' => true),
                'scope' => array(
                    'name' => 'scope',
                    'required' => true),

                'description' => array(
                    'name' => 'description',
                ),
            ));
            if ($validation->passed() && $this->model->ratechat_vote_criteria()) {
                //Redirect::to(URL.'ratechat/vote');

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

    function ratechat_video() {
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'url_link' => array(
                    'name' => 'Youtube Link ',
                    'required' => true),
            ));
            if ($validation->passed() && $this->model->ratechat_video()) {
                Redirect::to(URL.'ratechat/start');

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

    function ratechat_questions() {
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'question' => array(
                    'name' => 'question ',
                    'required' => true),
                'scope' => array(
                    'name' => 'scope ',
                    'required' => true),
            ));
            if ($validation->passed() && $this->model->ratechat_questions()) {
                //Redirect::to(URL.'ratechat/start');

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

    function ratechat_answers() {
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'answer' => array(
                    'name' => 'Answer ',
                    'required' => true),
            ));
            if ($validation->passed() && $this->model->ratechat_answers()) {
                //Redirect::to(URL.'ratechat/start');

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

    function ratechat_pictures() {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (1) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'title' => array(
                        'name' => 'title',
                        'required' => true,
                    ),
                    'description' => array(
                        'name' => 'description',
                    ),

                ));
                $upload = $this->upload('ratechat',true);
                if ($validation->passed() && $upload) {

                    //upload

                    if ($this->model->ratechat_pictures($upload)) {
                        Redirect::to(URL.'ratechat/start');

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


    function i_nominate() {
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'student_id' => array(
                    'name' => 'Student ID ',
                    'required' => true),
                'position' => array(
                    'name' => 'Position being Nominated for ',
                    'required' => true),
            ));
            if ($validation->passed() && $this->model->i_nominate()) {
                Redirect::to(URL.'ratechat/honour');

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


}