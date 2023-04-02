<?php
App::uses('AppModel', 'Model');
/**
 * Host Model
 *
 * @property Dom $Dom
 * @property Movie $Movie
 */
class Host extends AppModel { 
	public $displayField = 'name';
 
  	public  $actsAs = array( 
  		'Containable'
  	);

	public $hasMany = array(
		'Dom' => array(
			'className' => 'Dom',
			'foreignKey' => 'host_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Dom.host_id ASC, Dom.part_id ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Movie' => array(
			'className' => 'Movie',
			'foreignKey' => 'host_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		/*
		'Playback' => array(
			'className' => 'Playback',
			'foreignKey' => 'host_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
		*/
	);

	public $hasOne = array(
		'Playback' => array(
			'className' => 'Playback',
			'foreignKey' => 'host_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function hasName($name, $excl_kind='2')
	{
		$rslt = $this->find('first',array(
			'conditions'	=> array('Host.name'	=> $name),
			'contain'		=> array('Dom'	=> array('Part')),
			'recursive'		=> 1
		));

		if (!$rslt) return false;
		$dom = array();
		foreach ($rslt['Dom'] as $r){
			if ($r['Part']['kind_id'] == $excl_kind){
				continue;
			}
			$dom['Dom'][] = $r;
		}  

		unset($rslt['Dom']);
		if ($dom && count($dom['Dom']))
			$rslt['Dom'] = $dom['Dom']; 

		return $rslt;
	}

	public function hasNameAndKind($name, $kind)
	{
		$rslt = $this->find('first',array(
			'conditions'	=> array(
				'Host.name'	=> $name
			),
			'contain'		=> array('Dom'	=> array('Part')),
			'recursive'		=> 1
		));

		if (!$rslt) return false;
		$dom = array();
		foreach ($rslt['Dom'] as $r){
			if ($r['Part']['kind_id'] == $kind){ 
				$dom['Dom'][] = $r; 
			} 
			else continue; 
		}  

		unset($rslt['Dom']);
		if ($dom && count($dom['Dom']))
			$rslt['Dom'] = $dom['Dom']; 

		return $rslt;
	}

	public function readToEdit($id)
	{
		$found = $this->find('first',array(
			'conditions'	=> array('Host.id'	=> $id)
		)); 

		$data  = null;
		if ($found){
			foreach ($found['Dom'] as $dom){
				$data[$dom['part_id']] = $dom;
			}
		}

		unset($found['Dom']);
		$found['Dom'] = $data;
		return $found;
	}

}
