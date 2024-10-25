<?php

namespace FDG\Includes;

class Init {

	public function __construct() {
		new \FDG\Includes\Rest();

		add_action( 'fdg_fake_data_generation', array( Generator::class, 'handle_data_generation' ), 10, 3 );

		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ), 99999 );
	}

	public function add_menu() {
		add_menu_page(
			__( 'Fake Data', 'textdomain' ),
			'Fake Data Generator',
			'manage_options',
			'fdg',
			array( $this, 'add_content' ),
			'dashicons-database',
			99
		);
	}

	public function add_content() {
		include_once FDG_PATH . 'includes/layout.php';
	}

	public function enqueue_scripts() {
		if ( ! $this->is_in_menu() ) {
			return;
		}

		wp_enqueue_script( FDG . '_js', FDG_URL . 'build/main.js', array( 'wp-api-fetch', 'wp-i18n' ), FDG_VERSION, null );

		$tables = $this->get_all_tables();

		wp_localize_script(
			FDG . '_js',
			'fdg',
			array(
				'tables' => $tables,
			)
		);
	}

	public function enqueue_styles() {
		if ( $this->is_in_menu() ) {
			// wp_dequeue_style( 'forms' );
			// wp_deregister_style( 'forms' );
			wp_enqueue_style( FDG . '_css', FDG_URL . 'build/main.css', array(), FDG_VERSION, null );
		}
	}

	public function get_all_tables() {
		global $wpdb;

		$tables = $wpdb->get_results( 'SHOW TABLES' );

		$res = array();

		foreach ( $tables as $table ) {
			foreach ( $table as $t ) {
				$res[] = array(
					'value' => $t,
					'label' => $t,
				);
			}
		}

		return $res;
	}

	private function is_in_menu() {
		return isset( $_GET['page'] ) && ! empty( $_GET['page'] ) && 'fdg' === $_GET['page'];
	}
}
