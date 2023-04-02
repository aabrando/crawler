<?php
App::uses('AppModel', 'Model');
/**
 * Dom Model
 *
 * @property Host $Host
 * @property Part $Part
 */
class Dom extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'host_id';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Host' => array(
			'className' => 'Host',
			'foreignKey' => 'host_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Part' => array(
			'className' => 'Part',
			'foreignKey' => 'part_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
