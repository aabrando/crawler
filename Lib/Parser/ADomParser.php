<?php 
abstract class ADomParser {
	protected $domHost;
	protected $url;
	protected $page;
	public $view_page;
	public $perpagecnt;

	function __construct($url, $dhost, $page){
		$this->url     = $url;
		$this->domHost = $dhost;
		$this->page    = $page;
		$this->view_page  = null;
		$this->perpagecnt = null;
	}

	abstract function parseDom($kind_id); 

	protected function parseData($results){
		$data = array();  
		if ($results){
			foreach ($results as $r){  
				if (!is_array($r)) continue;
				foreach ($r['title'] as $key=>$val){ 
					$data[] = array(
						'title'	 => $val,
						'url'	 => $r['url'][$key], 
						'desc'	 => @$r['desc'][$key],
						'time'   => $r['date'][$key] 
					);
				}
			}
		} 
		return $data;
	}

	protected function parseData2($results){
		$data = array(); die(debug($results));
		if ($results){
			foreach ($results as $r){  
				if (!is_array($r)) continue;
				foreach ($r['title'] as $key=>$val){ 
					$data['title'][] = $val;
					$data['url'][] 	 = $r['url'][$key];
					$data['desc'][]  = @$r['desc'][$key];
					$data['time'][]  = $r['date'][$key];  
				}
			}
		} 
		return $data;
	}

}