<?php
App::uses('ACurl',	'Lib' .DS. 'Curl'); 

class CurlBitdown extends ACurl {
	private $user_id;
	private $passwd; 
	private $post_url; 

	public function __construct($url = ''){   
		parent::__construct();
		if (!empty($url)) { 
			$this->setDashboardUrl($url);
		} 
	} 

	public function setReferer($referer)
	{
		$this->referer = $referer;
	}
 
	public function add_query($query){
		if (is_array($query))
			$this->queries  = $this->dashboard . http_build_query($query);
		else $this->queries = $this->dashboard . $query;
	}

	public function dashboard(){  
		$domObj = $this->dom();   
		$result = null; 

		if ($domObj){    //die(debug($domObj->outertext));
	        foreach($domObj->find('div[class=main-page] div[class=article-category]') as $e) {  

	        	foreach ($e->find('div[class=cart] h2 a') as $judul){ 
	        		$str = trim($judul->plaintext);
	        		$str = preg_replace('/[^\00-\255]+/u', '', $str);
	        		$result['title'][] = $str;
	        		$result['url'][]   = $judul->href; 
	        		$result['time'][]  = "";
	        		$result['time'][]  = "";
	        	}    
	        }
		} 
		unset($domObj);  
		return $result;

	}  

	public function search(){  
		$domObj = $this->dom();   
		$result = null; 

		if ($domObj){     
	        foreach($domObj->find('div[class=main-page] div[class=article-category]') as $e) {  

	        	foreach ($e->find('div[class=cart] h2 a') as $judul){ 
	        		$str = trim($judul->plaintext);
	        		$str = preg_replace('/[^\00-\255]+/u', '', $str);
	        		$result['title'][] = $str;
	        		$result['url'][]   = $judul->href; 
	        		$result['time'][]  = ""; 
	        	}    
	        }

	        $pages = null;
	        foreach($domObj->find('ul[class=pagination] li a') as $page) { 
	        	$a_text = trim(str_replace('Page', '', $page->plaintext)); 
	        	if (is_numeric($a_text)){
	        		$pages[] = intval($a_text);
	        	}
	        } 
	         
	        $result['pages'] = -1;
	        if (is_array($pages)) { 
	        	$result['pages'] = max($pages);
	        }
		} 
		unset($domObj);  
		return $result; 
	}  

	public function detail(){   

		$domObj = $this->dom();   
		$result = null;  
		 
		$result['links'] = array();
		if ($domObj){       
			foreach($domObj->find('div[class=main-page] div[class=cart]') as $el ) {
				foreach ($el->find('div[class=header] h1 a') as $title){
	        		$str = trim($title->plaintext);
	        		$str = preg_replace('/[^\00-\255]+/u', '', $str);

					$result['title'] = $str;
					break;
				}  
			}  


			foreach ($domObj->find('div[id=tab-download] table a') as $links) {  
				
				$text = trim($links->href);  
				if (is_object($links) && strstr($text,'bitdl.ir')) {
					$key = md5($text);
					$result['links'][$key] = $links->href;
				}  
			} 


			foreach ($domObj->find('div[class=password] span') as $pwd) {   
					$result['pwd'] = $pwd->plaintext; 
					break;
			} 
		}   
		//die(debug($result)); 
		return $result;
	}
}