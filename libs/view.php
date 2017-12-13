<?php

class View {
    private static $deviceType = null;

    function __construct() {
        $this->getInstance();
    }

    public static function getInstance() {
        //echo 'This is the view <br/>';

        /*
         if (!isset(self::$deviceType)) {
            require 'config/core/Mobile_Detect.php';
            $detect = new Mobile_Detect;
            self::$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
        }
        return self::$deviceType;

         */
    }


    public function render($page_to_render, $noInclude = false, $login_required = false) {

        $path = 'views/'.$page_to_render.'.php';
        if(file_exists($path)){

            if ($noInclude === 'none') {
                require $path;
            } elseif ($noInclude === 'admin') {
                require 'views/includes/admin_header.php';
                require $path;
                include 'views/includes/admin_footer.php';
            } elseif ($noInclude === 'member') {
                require 'views/includes/member_header.php';
                require $path;
                include 'views/includes/member_footer.php';
            } else {
                require 'views/includes/header.php';
                require $path;
                include 'views/includes/footer.php';
            }

            if($login_required){
                $logged = Session::get('loggedIn');
                if ($logged == false) {
                    include 'views/includes/login_required.php';
                }
            }

        }else{
            require 'controllers/errata.php';
            $controller = new Errata();
            $controller->index();
            return false;
        }
        /*
         *        if(self::$deviceType === 'phone' || self::$deviceType === 'tablet'){
            //for mobile adaptation: design pattern is to load
            $file = 'views/' . $page_to_render . '_mobile.php';
            if (file_exists($file)) {
                require $file;
            } else {
                //load mobile error: you cannot view this page except with a computer
            }
        }elseif(Session::get('activate_mobile_view_port')=== 'tablet'){
            require 'views/' . $page_to_render . '_tablet.php';
        }

         */


    }

    public static function close_Instance() {
        if (isset(self::$deviceType)) {
            self::$deviceType = NULL;
        }
        return self::$deviceType;
    }

    public static function read_file(){
        require 'views/index/js/sms.json';

    }
    function json_gallery_data(){
        header("Content-Type: application/json");
        $folder = (UPLOAD_PATH.$_POST["folder"]);
        $jsonData = '{';
        $dir = $folder."/";
        $dirHandle = opendir($dir);
        $i = 0;
        while ($file = readdir($dirHandle)) {
            if(!is_dir($file) && preg_match("/.jpg|.gif|.png/i", $file) ){//strpos($file, '.jpg')
                $i++;
                $src = URL.'public/uploads/'.$_POST["folder"].'/'.$file;
                $jsonData .= '"img'.$i.'":{ "num":"'.$i.'","src":"'.$src.'", "name":"'.$file.'" },';
            }
        }
        closedir($dirHandle);
        $jsonData = chop($jsonData, ",");
        $jsonData .= '}';

        echo ($jsonData);
    }

    public static function NavBar(){
        return 'views/includes/navigation.php';

    }
    public static function dashBar(){
        return 'views/includes/dashboard.php';

    }
    public static function staffBar(){
        return 'views/includes/staff.php';

    }
    public static function rightNav(){
        return 'views/includes/rightNav.php';

    }
    public static function topNav(){
        return 'views/includes/topNav.php';

    }

    public static function webmaster_nav(){
        return 'views/includes/webmaster_main_nav.php';

    }

    public static function modal_sms(){
        return 'views/includes/modal_sms.php';

    }


}
