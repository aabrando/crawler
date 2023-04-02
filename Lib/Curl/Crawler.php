<?php 

//App::uses('B64Encryption','Lib' .DS. 'Tool'); 
App::uses('DomObject',	  'Lib' .DS. 'Curl'); 
App::uses('ObjectCache',  'Lib' .DS. 'Cache');

set_time_limit(180) ; 
class Crawler {
	const COOKIE_PATH = ROOT .DS . APP_DIR .DS. 'tmp' .DS. 'sessions';

	private $cookiePath;
	private $certPath;
	private $headers;
	private $queries;
	private $post_fields;
	private $referer;
	private $host;

	public $removals;// = array('script');

	function __construct($host=null){ 
        $this->cookiePath = self::COOKIE_PATH .DS. 'cookies.txt';

		if ($host) {
			$this->host = $host;
        	$this->cookiePath = self::COOKIE_PATH .DS. md5($host).'.txt'; 
		}

        $this->certPath   = self::COOKIE_PATH .DS. 'GeoTrustGlobalCA.crt'; 
        $this->headers    = array(
	        "Accept: */*",
	        "Connection: Keep-Alive"
        );
	}
  
 	public function crawl($url){
		$this->queries = $url;

 		//if ($this->host)
		//	$this->queries = $this->host.$url;

		return $this->getDom('get');
 	}
 

	public function getHost(){
		return $this->host;
	}

	public function setReferer($referer)
	{
		$this->referer = $referer;
	}

	public function setCookieFile($file_name){
		if ($file_name){
			$this->cookiePath = self::COOKIE_PATH .DS. md5(trim($file_name)) .'.txt';
		}
	}

	public function getCookieText(){
		return file_get_contents($this->cookiePath);
	}

	public function setPostFields($post_fields){
		$this->post_fields = $post_fields;
	}

	public function get(){    
        $ch = curl_init();  

        $userAgent = trim(env('HTTP_USER_AGENT'));
        if (empty($userAgent)) {
        	//$userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36";
        	$userAgent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:98.0) Gecko/20100101 Firefox/98.0";
        }

        // basic curl options for all requests 
        curl_setopt($ch, CURLOPT_HTTPHEADER,  $this->headers);
        curl_setopt($ch, CURLOPT_HEADER,  0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		//curl_setopt($ch, CURLOPT_USERAGENT, $usrAgent);
		
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 400); //timeout in seconds

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookiePath);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookiePath); 

        if (!empty($this->referer)) {
        	curl_setopt($ch, CURLOPT_REFERER, $this->referer);
        }
 		
        curl_setopt($ch, CURLOPT_URL, $this->queries); 
        $content = curl_exec($ch);  
        curl_close($ch);     
        return $this->removeElement($content); 
	}

	public function post($post_fields=null){ 
		if ($post_fields) 
			$this->post_fields = $post_fields;

        $ch = curl_init(); 
        $userAgent = trim(env('HTTP_USER_AGENT'));
        if (empty($userAgent))
        	$userAgent =  "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36";

        // basic curl options for all requests
        curl_setopt($ch, CURLOPT_HTTPHEADER,  $this->headers);
        curl_setopt($ch, CURLOPT_HEADER,  0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookiePath);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookiePath); 
        // change URL to POST URL
        curl_setopt($ch, CURLOPT_URL, $this->queries); 

        // set post options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post_fields);
        $content = curl_exec($ch);   

        curl_close($ch); 
        return $this->removeElement($content); 
	}

	public function getDom($method="get"){   
		$ckey= $this->queries; 
		if ($this->post_fields)
			$ckey= $this->queries.'&'.$this->post_fields;

		try {
			switch ($method){
				case "post":
					return DomObject::make(ObjectCache::make($this, $ckey,'default')->post());
					break;

				case "string":
					return DomObject::make_str(ObjectCache::make($this, $ckey,'default')->get());
					break;

				case "get":
				default:  
					return DomObject::make(ObjectCache::make($this, $ckey,'default')->get());
					break;
			} 
		}
		catch(Exception $ex){
			CakeLog::debug($ex->getMessage());
		}

		return false;
	}	

	private function removeElement($content){  
		if (!$this->removals) return $content;
		$html = $content;

		if (is_array($this->removals)){
			foreach ($this->removals as $el){
				$html = str_replace($el, '', $html);
			}
		}
		else {
			$html = str_replace($this->removals, '', $html);
		} 

		return trim(stripslashes($html));
	}

}