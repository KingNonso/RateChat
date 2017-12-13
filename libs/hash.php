<?php 
class Hash{
	public static function make($string, $salt = ''){
		return hash('sha256', $string.$salt);
	}

	public static function salt($length){
		return mcrypt_create_iv($length);
	}

	public static function unique(){
		return self::make(uniqid());
	}

    public static function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public static function randomString($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[self::crypto_rand_secure(0, $max)];
        }

        return $token;
    }

    public static function randomDigits($length){
        $digits ='';
        $numbers = range(0,9);
        shuffle($numbers);
        for($i = 0;$i < $length;$i++)
            $digits .= $numbers[$i];
        return $digits;
    }



    public function generateCode($length =   7){

        $unique =   FALSE;
        $chrDb  =   array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');

        while (!$unique){

            $str = '';
            for ($count = 0; $count < $length; $count++){

                $chr = $chrDb[rand(0,count($chrDb)-1)];

                if (rand(0,1) == 0){
                    $chr = strtolower($chr);
                }
                if (3 == $count){
                    $str .= '-';
                }
                $str .= $chr;
            }

            /* check if unique
            //$existingCode = UNIQUE CHECK GOES HERE
            if (!$existingCode){
                $unique = TRUE;
            }*/
        }
        return $str;
    }


}
?>