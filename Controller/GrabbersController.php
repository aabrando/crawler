<?php
App::uses("AppController","Controller");
App::uses("Crawler","Lib" .DS. "Curl");
App::uses('SafeEncryption', 'Lib' .DS. 'Tools');

class GrabbersController extends AppController {
	public $uses = array('Host');

	public function beforeFilter()
	{
		$this->layout = 'simple';
	}

	public function host($name)
	{

	}

	public function r1()
	{ 
		$this->autoRender = false;
		$server  = 'R1';
		$host    = $this->Host->hasName($server);   
		if (!$host){
			$title_for_layout = "Host not found";
			$this->set(compact('title_for_layout'));
			return $this->render('host_not_found');
		}

		$title_for_layout = $host['Host']['name'];
		$page    = @$this->request->query['page'];
		if (!$page) $page = 1;

		$crawler = new Crawler($host['Host']['url']);
		$url     = $host['Host']['url'].$host['Host']['index'] . $page;

		$domObj  = $crawler->crawl($url);

		$results = array();
		foreach ($host['Dom'] as $part){
			foreach ($domObj->find($part['dom2find']) as $dom){   
				$results[$part['Part']['name']][] = trim($dom->{$part['output']});  
			}
		}
 		 

		$this->set(compact('title_for_layout','results','page','server'));
		$this->render('movie');
	}

}