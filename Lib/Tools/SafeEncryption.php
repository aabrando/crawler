<?php
//ref https://stackoverflow.com/questions/1289061/best-way-to-use-php-to-encrypt-and-decrypt-passwords
class SafeEncryption {
    public static function encrypt($text, $salt=null){
        if(!$text){return false;}
        
        if (!$salt || !in_array(strlen($salt),array(16,24,32)) ){
            $salt = substr(Configure::read('Security.salt'), 0,32);
        }
        
        return self::_encrypt($text, $salt);    
    }

    public static function decrypt($string, $salt=null){
        if(!$string){return false;}
        
        if (!$salt || !in_array(strlen($salt),array(16,24,32)) ){
            $salt = substr(Configure::read('Security.salt'), 0,32);
        }
        
//        $crypttext   = self::_safe_b64decode($string);
//        $iv_size     = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
//        $iv          = mcrypt_create_iv($iv_size, MCRYPT_RAND);
//        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, $crypttext, MCRYPT_MODE_ECB, $iv);
//        return trim($decrypttext);

        return self::_decrypt($string, $salt);
    }

    private static function _safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    private static function _safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }

        return base64_decode($data);
    }

    private static function _encrypt($text, $key){ 
        $iv_size    = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv         = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext  = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
        return trim(self::_safe_b64encode($crypttext));
    }

    private static function _decrypt($string, $key){
        if(!$string){return false;}
        $crypttext   = self::_safe_b64decode($string);
        $iv_size     = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv          = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }

}