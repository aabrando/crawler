<?php
/*
CaptchaComponent
*/
App::uses('Component', 'Controller');
App::uses("Crawler","Lib" .DS. "Curl");
App::uses("LmntParser","Lib" .DS. "Parser");

class CrawlComponent extends Component{ 
    public $full_url;

	function __construct($collection, $settings){		
		$this->Controller = $collection->getController();	                                   
	}
    
    public function getDom($server, $kind='1'){
        $this->Host = ClassRegistry::init('Host');

		$host    = $this->Host->hasNameAndKind($server,$kind);  
		 
		if (!$host){
			$title_for_layout = "Host not found";
			$this->Controller->set(compact('title_for_layout'));
			return $this->Controller->render('/Hosts/not_found');
		}

		$page    = @$this->Controller->request->query['page'];
		$title_for_layout = $host['Host']['name'];

		if (!$page || $page <= 1) {
			$page = $host['Host']['start_page'];
			$this->Controller->set('page','1');
		}
		else { 
			$this->Controller->set('page',$page); 
		}

        if (!empty($this->full_url)){  
        	if (strstr($this->full_url, $host['Host']['url'])){
        		$url = strstr($this->full_url, $host['Host']['url']);
        	}
            else $url  = $host['Host']['url'].$this->full_url; 
        }
        else{
		    $url     = $host['Host']['url'].$host['Host']['index'] . $page .$host['Host']['suffix1'];   

		    if ($page <=1) {
		    	$url  = str_replace('/page/','',$host['Host']['url'].$host['Host']['index']);  

		    	if (strstr($url,'page=')){
		    		$url = str_replace('page=', 'page=1', $url);
		    	}
		    } 
        } 

		$results = array();   

		if (!empty($host['Host']['class']) && (in_array($kind, array(1,3) ))) { 
			if (!empty($host['Host']['class'])){
				App::uses($host['Host']['class'],'Lib' .DS.'Parser');
			}

			if (class_exists($host['Host']['class'])){
				$parser  = new $host['Host']['class']($url, $host, $page);
				$results = $parser->parseDom($kind);  
				$perpagecnt = $parser->perpagecnt;

				if ($kind == 3 && $parser->view_page){
					$this->Controller->set('view_page',$parser->view_page);
				}
				$this->Controller->set('perpagecnt',$perpagecnt);
			}  
		}
		else {	  
        	$crawler = new Crawler($host['Host']['url']);   

			$domObj  = $crawler->crawl($url);  
			$lmnObj  = new LmntParser($domObj);
			$results = $lmnObj->parseElement($host); //die(debug($results));
			$this->Controller->set('last_url',$url);
		}

		$this->Controller->set(compact('title_for_layout','results','server','host')); 
    }

}