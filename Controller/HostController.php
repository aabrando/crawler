<?php 
App::uses("AppController","Controller");

class HostController extends AppController {
	public $uses = array('Host','Dom');
	public $components = array('Paginator');

	public function beforeFilter()
	{
		$this->layout = 'simple';
	}

	public function index(){
		$this->Paginator->settings = array(
			'order'	=> 'Host.id DESC',
			'limit'	=> '20'
		);

		$hosts = $this->Paginator->paginate('Host');
		$title_for_layout = "Daftar Server";
		$this->set(compact('title_for_layout','hosts'));
	}

	public function add()
	{
		$title_for_layout = "New Host";
		$newdata = array();

		if ($this->request->is(array('post','put'))){
			if (!empty($this->request->data['Host']['name']) && !empty($this->request->data['Host']['url'])  ) {
				$this->Host->create();
				$this->Host->save($this->request->data);

				$host_id = $this->Host->getLastInsertID();
				foreach($this->request->data['Dom'] as $k=>$v){
					if (!empty($v['dom2find'])){
						$newdata['Dom']['host_id'][] = $host_id;
						$newdata['Dom']['name'][] = $this->request->data['Host']['name'];
						$newdata['Dom']['host'][] = $this->request->data['Host']['url'];
						$newdata['Dom']['part_id'][] = $k;
						$newdata['Dom']['dom2find'][] = $v['dom2find'];
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
		
		$this->set(compact('title_for_layout'));
	}

	public function edit($id=null)
	{
		$this->Host->id = $id;
		if (!$this->Host->exists()){
			$this->Flash->error("Host not found");
			return $this->redirect('index');
		}

		$this->request->data = $this->Host->read();
		if ($this->request->is(array('post','put'))){

		}

		$title_for_layout = "Edit host ".$this->request->data['Host']['name'];
		$this->set(compact('title_for_layout'));
		//die(debug($this->request->data));
	}


}