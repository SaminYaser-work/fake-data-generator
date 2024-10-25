<?php

namespace FDG\Includes;

use WP_HTTP_Response;
use WP_REST_Request;

class Rest {

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		register_rest_route(
			'fdg/v1',
			'/get-table-info/',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle_get_table_info' ),
				'permission_callback' => array( $this, 'check_permission' ),
			)
		);

		register_rest_route(
			'fdg/v1',
			'/generate/',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle_generate' ),
				'permission_callback' => array( $this, 'check_permission' ),
			)
		);

		register_rest_route(
			'fdg/v1',
			'/check-status/',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'handle_check_status' ),
				'permission_callback' => array( $this, 'check_permission' ),
			)
		);

		register_rest_route(
			'fdg/v1',
			'/cancel/',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'handle_cancel' ),
				'permission_callback' => array( $this, 'check_permission' ),
			)
		);
	}

	public function handle_get_table_info( WP_REST_Request $req ) {
		$table = isset( $req['table'] ) ? sanitize_text_field( $req['table'] ) : null;

		if ( empty( $table ) ) {
			return rest_ensure_response( new WP_HTTP_Response( null, 401 ) );
		}

		global $wpdb;

		$columns = $wpdb->get_results(
			'DESCRIBE ' . $table
		);

		return rest_ensure_response( $columns );
	}

	public function handle_generate( WP_REST_Request $req ) {
		$data = $req->get_json_params();
		$res  = Generator::schedule_data_generation( $data );
		return rest_ensure_response( $res );
	}

	public function handle_check_status() {
		return rest_ensure_response( Scheduler::get_status() );
	}

	public function handle_cancel() {
		Scheduler::set_cancel();
		return rest_ensure_response(true);
	}

	public function check_permission() {
		return current_user_can( 'manage_options' );
		// return true;
	}
}
