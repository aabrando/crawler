<?php 
App::uses('AppController','Controller');
App::uses('Security',  	  'Utility');   
App::uses("Crawler","Lib" .DS. "Curl");
App::uses('SafeEncryption', 'Lib' .DS. 'Tools');

class TutorialsController extends AppController {
    public $uses = array('Host','Dom');
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
                'category'  => 'Tutorial',
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
        $results = $this->viewVars['results'];
	
		if (isset($results['title'])) {
			return $this->render('list');
		}

		return $this->render('list2');
	}

    public function detail($server, $url)
    {
		$link = SafeEncryption::decrypt($url); 
        $this->Crawl->full_url = $link;
        $this->Crawl->getDom($server,3);
        if (@$this->viewVars['view_page']){
        	$this->render($this->viewVars['view_page']);
        }
    }

    public function add()
    {
    	$title_for_layout = "Add new host";
    	$this->set(compact('title_for_layout'));
		if ($this->request->is(array('post','put'))){
			$this->Dom = ClassRegistry::init('Dom'); 
			if (!empty($this->request->data['Host']['name']) && !empty($this->request->data['Host']['url'])  ) {
				$this->Host->create();
				$this->Host->save($this->request->data);

				$host_id = $this->Host->getLastInsertID();
				foreach($this->request->data['Dom'] as $k=>$v){
					if (!empty($v['dom2find'])){
						$newdata[] = array(
							'host_id'	=> $host_id,
							'part_id'	=> $k,
							'dom2find'	=> $v['dom2find'],
							'output'	=> $v['output'],
							'strneedle'	=> (isset($v['strneedle']) ? $v['strneedle'] : '(NULL)')		
						);
					}
				}

				if (!empty($newdata)){
					$this->Dom->create();
					$this->Dom->saveAll($newdata);
					$this->Flash->success("New host is saved");
					return $this->redirect('index');
				}
				else {
					$this->Flash->error("New entry is not saved"); 
				}

			}
			else {
				$this->Flash->error("Host name or URL is empty"); 
			}

		}
    }

	public function edit($id=null)
	{
		$this->Host->id = $id;
		if (!$this->Host->exists()){
			$this->Flash->error("Host not found");
			return $this->redirect('index');
		}



		if ($this->request->is(array('post','put'))){ 
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
						
						/*
						if (!empty($this->request->data['Playback']['path'])) {
							$this->Playback->recursive = -1;
							$found = $this->Playback->findByHostId($id);
							if ($found){
								$this->Playback->saveField('path',$this->request->data['Playback']['path']);
							}
						}
						*/

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