<?php

namespace FDG\Includes;

final class Init {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}

	public function add_menu() {
		add_menu_page(
			__( 'Fake Data', 'textdomain' ),
			'Fake Data Generator',
			'manage_options',
			'fdg',
			function () {
				echo '<h1>Hello World</h1>';
			},
			'dashicons-database',
			6
		);
	}


	public function enqueue_scripts() {
		if ( isset( $_GET['page'] ) && ! empty( $_GET['page'] ) && 'fdg' === $_GET['page'] ) {
			// wp_enqueue_script(FDG, );
		}
	}
}
