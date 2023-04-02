<?php
App::uses('ACurl',	'Lib' .DS. 'Curl'); 

class CurlCourseClub extends ACurl {
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

		if ($domObj){   
	        foreach($domObj->find('article[class=listing-item]') as $e) {  

	        	foreach ($e->find('h2[class=title] a') as $judul){ 
	        		$result['title'][] = trim($judul->plaintext);
	        		$result['url'][]  = $judul->href; 
	        	}  

	        	foreach ($e->find('div[class=post-meta] time') as $time){ 
	        		$result['time'][] = $time->plaintext;
	        	} 
 
	        	foreach ($e->find('div[class=post-meta] a[class=post-author-a]') as $desc){ 
	        		$result['desc'][] = $desc->plaintext;
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
	        foreach($domObj->find('article[class=listing-item]') as $e) {  

	        	foreach ($e->find('h2[class=title] a') as $judul){ 
	        		$result['title'][] = trim($judul->plaintext);
	        		$result['url'][]  = $judul->href; 
	        	}  

	        	foreach ($e->find('div[class=post-meta] time') as $time){ 
	        		$result['time'][] = $time->plaintext;
	        	}  
	        }

	        foreach($domObj->find('div[class=pagination] a') as $page) { 
	        	if (is_numeric($page->innertext)){
	        		$pages[] = intval($page->plaintext);
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
	    $keys   = array(0=>'size',2=>'source');

		if ($domObj){       
			foreach($domObj->find('div[class=single-container] article') as $el ) {  
				foreach ($el->find('span.post-title') as $title){
					$result['title'] = $title->plaintext;
					break;
				}

				foreach ($el->find('p a') as $a){
					if (trim($a->plaintext) == 'Download Now') {
						$result['link'] = $a->href; 
						break;
					}
				} 

				foreach ($el->find('div[class=entry-content clearfix single-post-content] p strong') as $source) {  
					$plaintext = trim($source->plaintext);
					if (strstr($plaintext, 'Size')){
						$result['size'] = $plaintext;
					}
					$result['source'] = $plaintext; 
				}

				/*
				foreach ($el->find('a[rel=noreferrer]') as $hr) {  
					$paintext = trim($hr->plaintext); debug($plaintext);
					if ($plaintext == 'Download Now') {
						$result['link'] = $hr->href;
						break;
					}
				}
				*/ 
			}  
		}     
		return $result;
	}
}