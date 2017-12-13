<?php 
session_start();
//echo 'Inside config ini';
$GLOBALS['config'] = array(
	'mysql' => array(
			'host' => '127.0.0.1',
			'username' => 'root',
			'password' => '',
			'db' => 'ratechats'
		),
	'remember' => array(
			'cookie_name' => 'hash',
			'cookie_expiry' => 604800
		),
	'session' => array(
			'session_name' => 'user',
			'token_name' => 'token'
		),
);

	function autoloadClasses($class){
			$filename = 'libs/'.strtolower($class).'.php';
			if(is_readable($filename)){
				require_once($filename);
			}
		}
	if(version_compare(PHP_VERSION,'5.1.2','>=')){
		//SPL autoloading was introduced in PHP 5.1.2
		if(version_compare(PHP_VERSION,'5.3.0','>=')){
			spl_autoload_register('autoloadClasses',true,true);
			}else{
				spl_autoload_register('autoloadClasses');
			}
	}
	else{
		//fall back to trad autoload for older php version
		function __autoload($classname){
			autoloadClasses($classname);
		}
	}
include 'config/functions/sanitize.php';

//set time zone
ini_set('date.timezone','Africa/Lagos');

    function backToSender(){
        //help the user go back to where he is coming from
        // check that browser supports $_SERVER variables
        if (isset($_SERVER['HTTP_REFERER']) && isset($_SERVER['HTTP_HOST'])) {
            $url = parse_url($_SERVER['HTTP_REFERER']);
            // find if visitor was referred from a different domain
            if ($url['host'] == $_SERVER['HTTP_HOST']) {
                // if same domain, use referring URL
                $url = $_SERVER['HTTP_REFERER'];
                $url = chop($url,'/');
            }
        }
        else {
            // otherwise, send to main page
            $url = URL.'index';
        }
        return $url;
    }







