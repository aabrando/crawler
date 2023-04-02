<?php
/**
 * Dom Fixture
 */
class DomFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'host_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'part_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'dom2find' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'output' => array('type' => 'string', 'null' => true, 'default' => 'plaintext', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'host_id' => 1,
			'part_id' => 1,
			'dom2find' => 'Lorem ipsum dolor sit amet',
			'output' => 'Lorem ipsum dolor sit amet'
		),
	);

}
