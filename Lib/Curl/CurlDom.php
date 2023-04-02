<?php
App::uses('ACrawler',	'Lib' .DS. 'Curl'); 

class CurlDom extends ACrawler {
	private $user_id;
	private $passwd; 
	private $post_url; 

	public function __construct($url = ''){   
		parent::__construct();
		if (!empty($url)) { 
			$this->setUrl($url);
		} 
	}  

	public function parseDom($domObj){  
		//$domObj = $this->dom();   
		$result = null; 

		if ($domObj){    
			$k = $l = 0;
	        foreach($domObj->find('div[id=content] article[class=post]') as $e) {  

	        	foreach ($e->find('h2[class=entry-title] a') as $judul){ 
	        		$result[$k]['title'] = trim($judul->plaintext);
	        		$result[$k]['url']  = $judul->href; 
	        		$l++;
	        		break;
	        	}  

	        	foreach ($e->find('div[class=entry-meta] span') as $time){ 
	        		$result[$k]['time'] = $time->plaintext;
	        		break;
	        	} 
 
	        	foreach ($e->find('div[class=entry-content] p') as $desc){ 
	        		$result[$k]['desc'] = $desc->plaintext;
	        		break;
	        	}
 
	        	foreach ($e->find('span[class=meta-category] a') as $desc){ 
	        		$result[$k]['desc'] = $desc->plaintext;
	        		break;
	        	}


	        	$k=$l;  
	        }

	        $pages = null;
	        foreach($domObj->find('nav a[class=page-numbers]') as $pn) {  
	        	$page = trim($pn->plaintext);
	        	if (is_numeric($page)){
	        		$pages[] = $page;
	        	}
	        }
	        if ($pages) {
	        	$result['pages'] = max($pages);
	        }

		}  
		unset($domObj);  
		return $result;

	}   

	public function search(){ 
		return $this->dashboard();
	}  
 
	public function detail(){   

		$domObj = $this->dom();   //die(debug($domObj->outertext));
		$result = null;  

		$result['size'] = '';
		if ($domObj){       
			foreach($domObj->find('article div[class=entry-content]') as $el ) {
				/*
				foreach ($el->find('h1[class=page-title]') as $title){
					$result['title'] = $title->plaintext;
				}

				foreach ($el->find('div[class=entry-content] p a') as $a){ 
					$result['link'] = $a->href;
					$result['source'] = 'N/A';
				}  


				foreach ($el->find('div[class=entry-content] p strong') as $size) {  
					
					$text = trim($size->plaintext);
					if (is_object($size) && strstr($text,'Size')) {
						$result['size'] = $text;
						break;
					}  
				} 
				*/
				foreach ($el->find('h2',0) as $title){
					die(debug($title));
				}
			}  
		}     
		return $result;
	}
}