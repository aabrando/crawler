<?php  
App::uses('ADomParser','Lib' .DS. 'Parser');
App::uses("LmntParser","Lib" .DS. "Parser");

class DomDcw extends ADomParser { 

	function __construct($url, $dhost, $page){ 
		parent::__construct($url, $dhost, $page);
		$this->view_page = 'detail_dcw';
	}

	public function parseDom($kind_id){   
		if (!$kind_id) return false;
		switch($kind_id){
			case 1:
				return $this->parseIndexPage();
				break;

			case 3:
				return $this->parseDetailPage();
				break;
		}
	}

	private function parseIndexPage(){  
 		$maxpage = 216;
 		$divider = 10; 
 		$i       = 1;
 		$start   = 1;
 		
 		//Cek di web aslinya per-page faktor brp
 		$this->perpagecnt = 80;

 		if (!$this->page) {
 			$this->page = 1;
 		}
 		else {
 			$start = (($this->page-1) * $divider) + 1;
 		}

		$max     = $this->page * $divider;
		$results = null;

    	$crawler = new Crawler($this->domHost['Host']['url']);  

		for ($i=$start;$i <= $max; $i++){  
			$url   = $this->domHost['Host']['url'].$this->domHost['Host']['index'].$i.$this->domHost['Host']['suffix1'];  
			$domObj = $crawler->crawl($url);   

			$lmnObj    = new LmntParser($domObj);
			$results[] = $lmnObj->parseElement($this->domHost);

		} 
		unset($crawler);
		unset($domObj);
		unset($lmnObj);
 		return $this->parseData($results);   
	}

	public function parseDetailPage(){ 
    	$crawler = new Crawler($this->domHost['Host']['url']); 
    	$domObj = $crawler->crawl($this->url);   
		$result = array(); 
		 
		$path = null;
		foreach ($this->domHost['Dom'] as $part){   
			foreach ($domObj->find($part['dom2find']) as $dom){  
					$lmnt = trim(html_entity_decode($dom->{$part['output']})); 
					$result[$part['Part']['name']][] = $lmnt;  
					
					if ($part['Part']['name'] == 'title'){
						$path = $lmnt;  
					}

					if ($part['Part']['name'] == 'url'){
						$url = $lmnt;
					}

	        		if (!empty($url)) {
	        			$key =  str_replace($url, '', $path); 
	        			if (!empty($key))
	        				$result['key'][] = str_replace($url, '', $path);
	        		} 
				}
		}
		  
		return $result;
	}
 

}