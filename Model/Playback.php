<?php
App::uses('AppModel', 'Model');
/**
 * Playback Model
 *
 * @property Movie $Movie
 */
class Playback extends AppModel {


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
}
