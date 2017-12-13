<?php

class Controller {

    public $model;

    function __construct() {
        $this->view = new View();
        $this->view->nav = array(
            'dashboard' => array(
                'name' => 'Latest Trends',
                'title' => 'Home Page',
                'href' => URL.'dashboard',
                'class' => '<i class="fa fa-dashboard"></i>'

            ),
            'public' => array(
                'name' => 'Public Class',
                'title' => 'Home Page',
                'href' => URL.'dashboard/group/Public',
                'class' => '<i class="fa fa-comments"></i>'

            ),
            'Celebrity' => array(
                'name' => 'Celebrity Class',
                'title' => 'Home Page',
                'href' => URL.'dashboard/group/Celebrity',
                'class' => '<i class="fa fa-commenting"></i>'

            ),
            'Executive' => array(
                'name' => 'Executive Class',
                'title' => 'Home Page',
                'href' => URL.'dashboard/group/Executive',
                'class' => '<i class="fa fa-comments-o"></i>'

            ),
            'ratechat' => array(
                'name' => 'Rating',
                'href' => URL.'ratechat/index',
                'title' => 'View your ratechat',
                'class' => '<i class="fa fa-desktop"></i>'
            ),
            'account' => array(
                'pages' => array(
                    'My Account' => URL.'dashboard/account',
                    'My Friends' => URL.'dashboard/friends',
                ),

                'name' => 'Profile',
                'href' => URL.'dashboard/account',
                'title' => 'Set your account',
                'class' => '<i class="fa fa-user"></i>',
                'top-ignore' => true

            ),
            'logout' => array(
                'name' => 'Logout Now',
                'href' => URL.'login/logout',
                'title' => 'Logout from your account',
                'class' => '<i class="fa fa-sign-out"></i>',
                'top-ignore' => true
            ),



        );
        $this->view->friends = $this->get_friends_request();
        $this->view->notification = $this->get_notification();

        if (!isset($_SESSION['maxfiles'])) {
            $_SESSION['maxfiles'] = ini_get('max_file_uploads');
            $_SESSION['postmax'] = Upload::convertToBytes(ini_get('post_max_size'));
            $_SESSION['displaymax'] = Upload::convertFromBytes($_SESSION['postmax']);
        }

    }

    function get_friends_request(){
        $model = new Model();
        $friends = $model->get_friends_request();
        return $friends;
    }

    function get_notification(){
        $model = new Model();
        $notification = $model->get_notification();
        return $notification;
    }


    public static function checkLoginRole($role = null){
        $logged = Session::get('loggedIn');
        if ($logged == false || Session::get('role') !== $role ) {
            Redirect::to(URL.'login');
            return false;
        }
        return true;

    }


    public function loadModel($name){
        $path = 'models/'.$name.'_model.php';
        $modelName = $name.'_Model';

        if(class_exists($modelName)){
            $this->model = new $modelName();
        }else{
            if(file_exists($path)){
                require $path;

                $this->model = new $modelName();
            }else{
                if(class_exists('Error')){
                    $controller = new Error();
                }else{
                    require 'controllers/error.php';
                    $controller = new Error();
                }
                return false;
            }

        }

    }

    public function reMapRouteToModel($name){

        $path = 'models/'.$name.'_model.php';
        $modelName = $name.'_Model';

        if(class_exists($modelName)){
            $this->$name = new $modelName();
            //$this->reMappedRoute = new $modelName();

        }else{
            if(file_exists($path)){
                require $path;
                //$this->reMappedRoute = new $modelName();
                $this->$name = new $modelName();
            }else{
                require 'controllers/error.php';
                $controller = new Error();
                return false;
            }

        }

    }



}

