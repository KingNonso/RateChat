<?php 
class Cookie{
	public static function exists($name){
		return (isset($_COOKIE[$name])) ? true : false;
	}
	
	public static function get($name){
		return $_COOKIE[$name];
	}
	
	public static function put($name, $value, $expiry){
        $expiry = time()+$expiry;
        $data = (object)array(
                'value1' => ' Just for fun ',
                'value2' => 'I save whatever i want here',
            );
        $cookieData = (object)array(
            'data' => $data,
            'expiry' => $expiry,
            'hash' => $value
        );
		if(setcookie($name,json_encode($cookieData),$expiry, '/')){
			return true;
		}
		return false;
	}
	
	public static function delete($name){
		//delete
		self::put($name, '',time()-42000, '/');
	}
}

?>