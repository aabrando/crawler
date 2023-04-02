<?php
App::uses('ACurl',	'Lib' .DS. 'Curl'); 

class CurlCourse extends ACurl {
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
	        foreach($domObj->find('article[class=post-box]') as $e) {  

	        	foreach ($e->find('h2[class=post-title] a') as $judul){ 
	        		$result['title'][] = trim($judul->plaintext);
	        		$result['url'][]  = $judul->href; 
	        	}  

	        	foreach ($e->find('time[class=published]') as $time){ 
	        		$result['time'][] = $time->plaintext;
	        	} 
 
	        	foreach ($e->find('div[class=post-excerpt] a') as $desc){
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
		$pages  = null;
		
		if ($domObj){  
	        foreach($domObj->find('article[class=post-box]') as $e) {  

	        	foreach ($e->find('h2[class=post-title] a') as $judul){ 
	        		$result['title'][] = trim($judul->plaintext);
	        		$result['url'][]  = $judul->href; 
	        	}  

	        	foreach ($e->find('time[class=published]') as $time){ 
	        		$result['time'][] = $time->plaintext;
	        	}  
	        }

	        foreach($domObj->find('nav[class=pagination] div a') as $page) { 
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

	public function detail($host){ 
		$domObj = $this->dom();   
		$result = null; 
		if ($domObj){  
	        foreach($domObj->find('div[class=entry-content]') as $e) {  

	        	foreach ($e->find('div[class=officialCourseLink] a') as $link){ 
	        		$url = $link->href;
	        		$result['link'][] = $url; 
	        	} 

	        	foreach ($e->find('div[class=officialCourseLink]') as $judul){ 
	        		$path = trim($judul->plaintext);
	        		if (!empty($url)) {
	        			$result['key'][] = str_replace($url, '', $path);
	        		} 
	        	}    
	        }
		} 
		unset($domObj);  
		return $result;

	} 

	public function freeCourses()
	{
		$domObj = $this->dom();    
		$result = null; 
		if ($domObj){  
	        foreach($domObj->find('div[id=primary] main') as $e) {  

	        	foreach ($e->find('h1[class=entry-title]') as $title){  
	        		$result['title'][] = $title->innertext; 
	        		$result['link'][]  = 'N/A'; 
	        	}  

	        	foreach ($e->find('a[id=download]') as $url){ 
	        			$result['url'][] = $url->href;
	        	}    
	        }
		} 
		unset($domObj);  
		return $result;
	}

	private function parseDetail()
	{
		$domObj = $this->dom();   
		$result = null; 
		if ($domObj){  
	        foreach($domObj->find('div[class=entry-content]') as $e) {  

	        	foreach ($e->find('div[class=officialCourseLink] a') as $link){ 
	        		$url = $link->href;
	        		$result['link'][] = $url; 
	        	} 

	        	foreach ($e->find('div[class=officialCourseLink]') as $judul){ 
	        		$path = trim($judul->plaintext);
	        		if (!empty($url)) {
	        			$result['key'][] = str_replace($url, '', $path);
	        		} 
	        	}    
	        }
		} 
		unset($domObj);  
		return $result;
	}
}