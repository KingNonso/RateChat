<?php
    function escape($string){
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }

    function toAscii($str, $replace=array(), $delimiter='-') {
        setlocale(LC_ALL, 'en_US.UTF8');

        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = strtolower(trim($clean, '.'));

        return $clean;
    }

    function cleanUP() {
        //clears out my session variables on success. Thanks
        foreach ($_POST as $item => $thing) {
            Session::delete($item);
        }
    }

    function limit_word($str, $length = 500){
        //$str = strip_tags($str);
        $extract = substr($str, 0, $length);
        // check if up to the required no
        if (strlen($extract) >= $length){
            // find position of last space in extract
            $lastSpace = strrpos($extract, ' ');
            // use $lastSpace to set length of new extract and add ...
            return (substr($extract, 0, $lastSpace).'... ');
        }else{
            return false;
        }

    }
    function getFirst($text, $number=2) {//$text = text to extract, $number = no of sentences to extract
        // regular expression to find typical sentence endings
        $pattern = '/([.?!]["\']?)\s/';
        // use regex to insert break indicator
        $text = preg_replace($pattern, '$1bRE@kH3re', $text);
        // use break indicator to create array of sentences
        $sentences = preg_split('/bRE@kH3re/', $text);
        // check relative length of array and requested number
        $howMany = count($sentences);
        $number = $howMany >= $number ? $number : $howMany;
        // rebuild extract and return as single string
        $remainder = array_splice($sentences, $number);
        $result = array();
        $result[0] = implode(' ', $sentences);
        $result[1] = empty($remainder) ? false : true;
        return ($result);
    }


    function recaptcha($ajax = false){
        $secret = '6LfMsCcUAAAAAKvJhKo9iYq1nMSj89Jfh0irUFW8';
        $response = $_POST['g-recaptcha-response'];//;
        $userIP = $_SERVER['REMOTE_ADDR'];

        $url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$userIP");

        $result = json_decode($url, true);
        //die(print_r($result));

        if(isset($result) && $result['success']==1){
            return true;
        }else{
            return false;
        }


    }

    function  lastFive($array, $limit = 5){
        //produce the last five results
        $lastFive = array();
        for($i=0; $i < $limit; $i++){
            $obj = array_pop($array);
            if($obj == null) break;
            $lastFive[] = $obj;
        }
        return $lastFive;
        //produce the first five results
        $arrayCount = count($array);
        if($arrayCount > 5){
            $output = array_slice($array, (-5),$arrayCount);
        }else{
            $output = $array;
        }

    }



