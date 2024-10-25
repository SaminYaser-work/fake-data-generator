<?php

namespace FDG\Tests\Unit;

use FDG\Includes\Init;
use WP_UnitTestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

/**
 * @testdox FDG Init Tests
 */
class TestInit extends WP_UnitTestCase {

	use MockeryPHPUnitIntegration;

	private Init $instance;

	/**
	 * Set up the test environment, creating a user.
	 */
	public function setUp(): void {
		parent::setUp();
		$this->instance = new Init();
	}

	/**
	 * Clean up the test environment after tests.
	 */
	public function tearDown(): void {
		parent::tearDown();
	}

	/**
	 * @test
	 * @testdox Admin menu action is properly registered
	 */
	public function test_added_menu_page(): void {
		$has_action = has_action( 'admin_menu', array( $this->instance, 'add_menu' ) );

		$this->assertNotFalse( $has_action, 'Admin menu action was not added' );

		$this->assertEquals( 10, $has_action, 'Admin menu action is not at expected priority' );
	}

	/**
	 * @test
	 * @testdox Menu page is created in admin menu
	 */
	public function test_menu_page_exists(): void {
		global $menu;

		$menu = array();

		do_action( 'admin_menu' );

		$menu_exists = false;
		foreach ( $menu as $item ) {
			if ( isset( $item[2] ) && $item[2] === 'fdg' ) {
				$menu_exists = true;
				break;
			}
		}

		$this->assertTrue( $menu_exists, 'Menu item was not created' );
	}

	/**
	 * @test
	 * @testdox Table information is retrievable
	 */
	public function test_get_all_tables(): void {
		$tables = $this->instance->get_all_tables();

		$res = is_array( $tables ) && count( $tables ) > 0;

		$this->assertTrue( $res, 'Invalid table name value' );
	}
}
