<?php
    class Input{
        public static function exists($type = 'post'){
            switch($type){
                case 'post':
                    return(!empty($_POST)) ? true : false;
                    break;
                case 'get':
                    return(!empty($_GET)) ? true : false;
                    break;
                default:
                    return false;
                    break;
            }
        }
        public static function get($item){
            if(isset($_POST[$item])){
                return htmlentities(trim($_POST[$item]));
                //return self::mysql_prep($_POST[$item]);
            }elseif(isset($_GET[$item])){
                return $_GET[$item];
            }
            return '';
        }
        public static function checkbox($item, $delimiter =', '){
            if(isset($_POST[$item]) && !empty($_POST[$item])){
                    $posts = is_array($_POST[$item])? $_POST[$item]: array($_POST[$item]);

                    $checkboxes = count($posts);
                    $tmp = '';
                    for($i=0; $i < $checkboxes; $i++){
                        $tmp .= ($posts[$i] . $delimiter);

                    }
                    $tmp = chop($tmp,$delimiter); //remove trailing ,
                    return $tmp;


            }
            return null;
        }

        public static function mysql_prep($value){
            //specific for mysql database
            $magic_quote_active = get_magic_quotes_gpc();
            $new_enough_php = function_exists("mysql_real_escape_string"); //i.e. PHP v4.3.0
            if($new_enough_php){ //PHP v4.3.0 or higher
                //undo any magic quote effects so mysql_real_escape_string can do the work
                if($magic_quote_active){ $value = stripslashes($value); }
                $value = mysql_real_escape_string($value);
            }else{// before PHP v4.3.0
                //if magic quote aren't already on then add slashes manually
                if(!$magic_quote_active){ $value = addslashes($value); }
                //if magic quotes are active, then the slashes already exist
            }
            echo $value;
            return $value;
        }
    }
?>