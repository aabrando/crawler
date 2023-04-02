<?php
App::uses('ACurl',	'Lib' .DS. 'Curl'); 
App::uses('SafeEncryption', 'Lib' .DS. 'Tools');

class CurlMovies extends ACurl {
	private $user_id;
	private $passwd; 
	private $post_url; 
	private $host;  

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

	public function rebahin()
	{
		return $this->dashboard();
	}

	public function dashboard(){   
		$domObj = $this->dom();   
		$result = null; 

		if ($domObj){      
	        foreach($domObj->find('div[id=main] div[class=ml-item]') as $e) {   
	        	foreach ($e->find('a') as $link){
	        		$result['url'][] = $link->href;
	        		break;
	        	}
	        	foreach ($e->find('a img') as $img){ 
	        		$result['image'][] = $img->src;
	        		break; 
	        	}  

	        	foreach ($e->find('a h2') as $title){ 
	        		$result['title'][] = $title->plaintext;
	        		break; 
	        	} 
 
	        	foreach ($e->find('a span[class=mli-rating]') as $rating){ 
	        		$result['rating'][] = $rating->plaintext;
	        		break; 
	        	}  
 
	        	foreach ($e->find('a span[class=mli-durasi]') as $durasi){ 
	        		$result['durasi'][] = $durasi->plaintext;
	        		break; 
	        	} 
 
	        	foreach ($e->find('a span[class=mli-quality]') as $quality){ 
	        		$result['quality'][] = $quality->plaintext;
	        		break; 
	        	} 
	        }
 
	        if ($result) {
		        foreach($domObj->find('div ul[class=pagination] li a') as $paging) { 
		        	if (trim($paging->plaintext) == 'Last'){
		        		$last = strrchr($paging->href,"page");
		        		$last = str_replace('page', '', $last);
		        		$last = str_replace('/', '', $last);

		        		$result['pages'] = $last;
		        	}
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
	        foreach($domObj->find('main[id=main] article') as $e) {  

	        	foreach ($e->find('h2[class=entry-title] a') as $judul){ 
	        		$result['title'][] = trim($judul->plaintext);
	        		$result['url'][]  = $judul->href; 
	        	}  

	        	foreach ($e->find('li[class=meta-date] time') as $time){ 
	        		$result['time'][] = $time->plaintext;
	        	}  
	        }

	        foreach($domObj->find('nav[class=ct-pagination] div a') as $page) { 
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

		$domObj = $this->dom();   //die(debug($domObj->outertext));
		$result = null;  

		$result['size'] = '';
		if ($domObj){       
			foreach($domObj->find('main[id=main] article') as $el ) {
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
			}  
		}     
		return $result;
	}

	public function fromHost($host)
	{
		$this->host = $host;
		return $this;
	}

	public function watch($enc_url)
	{		
		$link = SafeEncryption::decrypt($enc_url);   
		switch ($this->host) {
			case 'Rebahin1':
				return $this->_watchRebahin($link);
				break;
			
			default:
				# code...
				break;
		}
	}

	public function _watchRebahin($url)
	{
		$this->add_query($url);
		$domObj = $this->dom();
		$len    = 0; 
		$start  = null;
		$hsvr   = null;

		$protocl= 'http://';
		if ($start = strpos($url, $protocl) >=0) { 
			$len = strlen($protocl);
		}
		else {
			$protocl = 'https://';
			if ($start = strpos($url, $protocl) >=0) {
				$len = strlen($protocl); 
			}
		} 


		$rhost    = substr($url, $len);
		$playback = $protocl.substr($rhost, 0, strpos($rhost, '/')).'/iembed/?source='; 

		if ($domObj){ 
			foreach ($domObj->find('div[id=server-list] div[class=server-wrapper]') as $movie){ 
				foreach ($movie->find('div[class=server]') as $server){
					$result['servers'][] = $playback.$server->{'data-iframe'};
					break;
				}  
			}

			foreach ($domObj->find('div[class=mvic-desc]') as $desc ){
				foreach ($desc->find('div[class=mvic-tagline2] h3') as $title){
					$result['title'] = trim($title->plaintext);
					break;
				}

				foreach ($desc->find('div[class=desc-des-pendek] p') as $txt){
					if (isset($result['desc'])) {
						$result['desc'] = $result['desc'].$txt->outertext;
					}
					else $result['desc'] = $txt->outertext;
				}
			}


		}   
		return $result;
	}

	public function _watchRebahinXXX($url)
	{
		$this->add_query($url);
		$domObj = $this->dom();
		$result = null;
		if ($domObj){
			foreach ($domObj->find('div[class=mvi-content]') as $movie){
				foreach ($movie->find('h3') as $title){
					$result['title'] = $title->plaintext;
					break;
				}

				foreach ($movie->find('div[class=desc] p') as $desc){
					$result['desc'] = $desc->plaintext;
					break;
				}

				foreach ($movie->find('div[class=mvic-desc] div[class=mvici-right] p') as $about){
					$result['about'][] = $about->plaintext;
				}
			}
		}
		return $result;
	}
}