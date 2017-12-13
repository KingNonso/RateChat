<?php

class Bootstrap {

    public function __construct(){

        // initialize request and respond objects
        //$this->request  = new Request();
        //$this->response = new Response();
        $this->activity_log();

    }

    function run() {

		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/', $url);

		//if no path is set
		
		if (empty($url[0])) {
			require 'controllers/login.php';
			$controller = new Login();
            $controller->loadModel('login');
			$controller->index();
			return false;
		}

		$file = 'controllers/' . $url[0] . '.php';
		if (file_exists($file)) {
			require $file;
		} else {
            //this means we are not calling any classes from our controller
            $this->error();
            return false;
		}
		
		$controller = new $url[0];
		$controller->loadModel($url[0]);

        // calling methods
        if(isset($url[4])){
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2],$url[3],$url[4]);
            } else {
                $this->error();
            }
        }else{
            if(isset($url[3])){
                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}($url[2],$url[3]);
                } else {
                    $this->error();
                }
            }else{
            if (isset($url[2])) {
                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}($url[2]);
                } else {
                    $this->error();
                }
            } else {
                if (isset($url[1])) {
                    if (method_exists($controller, $url[1])) {
                        $controller->{$url[1]}();
                    } else {//if url0 is defined and url1 is undefined as a method in url0
                        $this->error();
                    }
                } else {
                    $controller->index();
                }
            }

        }
        }

		
	}


    private function activity_log(){
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        $rest = '';

        if (empty($url[0])) {
            $controller = 'index';
            $method = 'index';
            $rest = '';
        }else{
            $controller = $url[0];
            if($controller == 'public' || $controller == 'dist'){ return false;}

            if (isset($url[1])) {
                $method = $url[1];
                if (count($url) > 2) {
                    for($i=2; $i<count($url); $i++){
                        $rest .= $url[$i].'/';
                    }
                    $rest = chop($rest,'/');
                }
            }else{
                $method = 'index';
            }
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        $user = (Session::exists('user_id'))? Session::get('user_id') : $ip;

        $db = Database::getInstance();

        $db->insert('user_activity_log',array(
            'user_id' => $user,
            'controller' => $controller,
            'method' => $method,
            'rest' => $rest,
            'time' => Database::$today,

        ));

    }

    public function error() {
        require 'controllers/errata.php';
        $controller = new Errata();
        $controller->index();
        return false;
    }

}