<?php
App::uses('MoviePlay', 'Model');

/**
 * MoviePlay Test Case
 */
class MoviePlayTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.movie_play',
		'app.movie'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MoviePlay = ClassRegistry::init('MoviePlay');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MoviePlay);

		parent::tearDown();
	}

}
