<?php
App::uses('Dom', 'Model');

/**
 * Dom Test Case
 */
class DomTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.dom',
		'app.host',
		'app.part'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Dom = ClassRegistry::init('Dom');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Dom);

		parent::tearDown();
	}

}
