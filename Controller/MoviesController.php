<?php
App::uses("AppController","Controller"); 
App::uses('Security',  	  'Utility');   
App::uses("Crawler","Lib" .DS. "Curl");
App::uses('SafeEncryption', 'Lib' .DS. 'Tools');

class MoviesController extends AppController { 

	public $uses = array('Host','Playback','Dom');
	public $components = array('Paginator','Crawl');

	public function beforeFilter()
	{
		$this->layout = 'simple';
	}

	public function index()
	{
		$this->Paginator->settings = array(
			'order'	=> 'Host.id DESC',
			'limit'	=> '20',
			'conditions'	=> array(
                'category'  => 'Movie',
				'enabled'	=> '1'
            )
		);

		$hosts = $this->Paginator->paginate('Host');
		$title_for_layout = "Daftar Server";
		$this->set(compact('title_for_layout','hosts'));
	}

	public function host($server)
	{
		//Cache::clear();
		$this->autoRender = false;
        $this->Crawl->getDom($server,1);
		$this->render('movie');
	}

	public function watch($server, $url)
	{   
		//Cache::clear();  
		$this->Playback->recursive = -1;

		/*
		$link = SafeEncryption::decrypt($url);  
		$host    = $this->Host->hasNameAndKind($server,'2');  
		if (!$host){
			$title_for_layout = "Host not found";
			$this->set(compact('title_for_layout'));
			return $this->render('host_not_found');
		}   
		$crawler = new Crawler($host['Host']['url']);  
    	
    	$crawler->removals = array(
    		'script'
    	); 
        	
		$domObj  = $crawler->crawl($link);    
		$results = array();
		if (isset($host['Dom']) && $host['Dom']) {
			foreach ($host['Dom'] as $part){  
				foreach ($domObj->find($part['dom2find']) as $dom){     
					$results[$part['Part']['name']][] = trim($dom->{$part['output']});  
				}
			}  
		}
		 
		$playback = $this->Playback->findByHostId($host['Host']['id']); 

		$title_for_layout = "Watch ".@$results['title'][0];
		$this->set(compact('title_for_layout','results','host','playback'));
		*/

		$play_id = '2';
		$link    = SafeEncryption::decrypt($url);   
        $this->Crawl->full_url = $link;

		$svrinfo = $this->Host->hasNameAndKind($server,$play_id);  
		$playbak_suffix = $svrinfo['Host']['suffix2'];  
        $this->Crawl->getDom($server,$play_id);

        if (isset($this->viewVars['view_page'])){
        	$this->render($this->viewVars['view_page']);
        }
        $this->set(compact('playbak_suffix','svrinfo'));

	}

 	public function add()
 	{
    	$title_for_layout = "Add new host";
		if ($this->request->is(array('post','put'))){ 
			if (!empty($this->request->data['Host']['name']) && !empty($this->request->data['Host']['url'])  ) {
				$this->Host->create();
				if ($host = $this->Host->save($this->request->data)) {
 
					foreach($this->request->data['Dom'] as $k=>$v){ 
						if (!empty($v['dom2find'])){
							$newdata[] = array(
								'host_id'	=> $host['Host']['id'],
								'part_id'	=> $k,
								'dom2find'	=> $v['dom2find'],
								'output'	=> $v['output'],
								'strneedle'	=> (isset($v['strneedle']) ? $v['strneedle'] : '(NULL)')		
							);
						}
					}

					if (!empty($newdata)){
						$this->Dom->deleteAll(array('Dom.host_id'	=> $host['Host']['id']),false);
						$this->Dom->create();
						$this->Dom->saveAll($newdata);

						if (!empty($this->request->data['Playback']['path'])) {
							$this->Playback->recursive = -1;
							$found = $this->Playback->findByHostId($id);
							if ($found){
								$this->Playback->saveField('path',$this->request->data['Playback']['path']);
							}
						}

						$this->Flash->success("Added");
						return $this->redirect('index');
					}
					else {
						$this->Flash->error("Entry is not saved"); 
					}
				}

			}
		}
    	$this->set(compact('title_for_layout'));
 	}

 	public function edit($id=null)
 	{
		$this->Host->id = $id;
		if (!$this->Host->exists()){
			$this->Flash->error("Host not found");
			return $this->redirect('index');
		}

		if ($this->request->is(array('post','put'))){ 
 				//debug($this->request->data); die();
				if (!empty($this->request->data['Host']['name']) && !empty($this->request->data['Host']['url'])  ) {
					$this->Host->save($this->request->data);
 
					foreach($this->request->data['Dom'] as $k=>$v){  
						if (!empty($v['dom2find'])){
							$newdata[] = array(
								'host_id'	=> $id,
								'part_id'	=> $k,
								'dom2find'	=> $v['dom2find'],
								'output'	=> $v['output'],
								'strneedle'	=> (isset($v['strneedle']) ? $v['strneedle'] : '(NULL)')		
							);
						}
					}

					if (!empty($newdata)){
						$this->Dom->deleteAll(array('Dom.host_id'	=> $id),false);
						$this->Dom->create();
						$this->Dom->saveAll($newdata);

						if (!empty($this->request->data['Playback']['path'])) {
							$this->Playback->recursive = -1;
							$found = $this->Playback->findByHostId($id);
							if ($found){
								$this->Playback->saveField('path',$this->request->data['Playback']['path']);
							}
						}

						$this->Flash->success("Updated");
						return $this->redirect('index');
					}
					else {
						$this->Flash->error("Entry is not saved"); 
					}

				}
				else {
					$this->Flash->error("Host name or URL is empty"); 
				}
 
		}
		else $this->request->data = $this->Host->readToEdit($id);
 

		$title_for_layout = "Edit host ".$this->request->data['Host']['name'];
		$this->set(compact('title_for_layout')); 
 	}
}