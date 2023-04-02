<?php

class B64Encryption {
	public $skey = "l4kup0n_refer";

    function __construct(){
        $this->skey = Configure::read('Security.salt');
        if (empty($this->skey)) $this->skey = 'S4lty_Rec1pi3s';
    }

	public function getEncryptDecrypt($string){
		$encrypted = $this->encrypt($string);
		$decrypted = $this->decrypt($encrypted);

		$result = array(
			'encrypt' => $encrypted,
			'decrypt' => $decrypted
		);
		return $result;
	}

	public  function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

	public function encrypt($string){
        if(!$string){return false;}
        $text 		= $string;
        $iv_size 	= mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv 		= mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext  = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext));
    }

    public function decrypt($string){
        if(!$string){return false;}
        $crypttext 	 = $this->safe_b64decode($string);
        $iv_size 	 = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv 		 = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }

}