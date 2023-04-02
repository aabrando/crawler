<?php
App::uses('AppModel', 'Model');
/**
 * Movie Model
 *
 * @property Host $Host
 * @property Playback $Playback
 */
class Movie extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';


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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Playback' => array(
			'className' => 'Playback',
			'foreignKey' => 'movie_id',
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

}
