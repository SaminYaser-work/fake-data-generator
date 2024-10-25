<?php

namespace FDG\Includes;

use Error;
use Exception;
use Faker;

class Generator {

	/**
	 * @var Faker\Generator $faker
	 */
	private static $faker = null;

	private static function get_faker_instance() {
		if ( empty( self::$faker ) ) {
			self::$faker = \Faker\Factory::create();
		}

		return self::$faker;
	}


	public static function schedule_data_generation( $data ) {

		// Validating table name
		$table = isset( $data['table'] ) ? sanitize_text_field( $data['table'] ) : null;

		if ( empty( $table ) ) {
			return __( 'Invalid table name', 'fdg' );
		}

		// Validating num of rows
		$num_of_rows = isset( $data['num_of_rows'] ) && is_numeric( $data['num_of_rows'] ) ? intval( $data['num_of_rows'] ) : null;

		if ( empty( $num_of_rows ) ) {
			return __( 'Number of rows not specified', 'fdg' );
		}

		global $wpdb;

		// Validating table
        $table_info = $wpdb->get_results('DESC ' . esc_sql( $table )); // phpcs:ignore

		if ( empty( $table_info ) ) {
			return __( 'Unknown table', 'fdg' );
		}

		$generate_task_params = array();

		// Validating columns and params
		foreach ( $table_info as $info ) {
			$col = $info->Field;

			if ( empty( $data[ $col ] ) ) {
				continue;
			}

			$fake_data_type = sanitize_key( $data[ $col ] );

			$generation_fn = '';
			$validation_fn = '';

			switch ( $fake_data_type ) {
				case 'int':
					$generation_fn = 'get_int_between';
					$validation_fn = 'get_validated_int_params';
					break;
			}

			if ( method_exists( static::class, $validation_fn ) && method_exists( static::class, $generation_fn ) ) {
				$params = call_user_func_array( array( static::class, $validation_fn ), array( &$info, &$data ) );
			} else {
				return __( 'Invalid data type', 'fdg' );
			}

			if ( self::is_error( $params ) ) {
				return $params['value'];
			}

			$generate_task_params[] = array(
				'col'           => $col,
				'generation_fn' => array( static::class, $generation_fn ),
				'params'        => $params,
			);
		}

		$trunc = isset( $data['trunc'] ) ? boolval( $data['trunc'] ) : false;

		$res = count( $generate_task_params ) > 0 ? Scheduler::try_scheduling( $generate_task_params, $table, $num_of_rows, $trunc ) : false;

		return $res ? 'success' : __( 'Failed to schedule task. Is another task running?', 'fdg' );
	}

	public static function handle_data_generation( $data, $table, $num_of_rows, $trunc ) {
		global $wpdb;

		Scheduler::set_running();

		if ( $trunc ) {
			$wpdb->query("TRUNCATE TABLE {$table}"); // phpcs:ignore
		}

		try {
			foreach ( range( 0, $num_of_rows ) as $i ) {

				if ( Scheduler::get_cancel() ) {
					throw new Exception( 'cancelled' );
				}

				$fake_data = array();

				foreach ( $data as $d ) {
					$fake_data[ $d['col'] ] = $d['generation_fn']( ...$d['params'] );
				}

				$res = $wpdb->insert( $table, $fake_data ); // phpcs:ignore

				if ( empty( $res ) ) {
					throw new Error( 'Failed to insert in column ' . $d['col'] );
				}
			}

			Scheduler::set_last_task_result( 'success' );
		} catch ( \Exception $e ) {
			Scheduler::set_last_task_result( $e->getMessage() );
		} finally {
			Scheduler::clear_cancel();
			Scheduler::set_idle();
		}
	}

	private static function get_validated_int_params( $info, $data ) {
		$col = $info->Field;

		if ( ! str_contains( $info->Type, 'int' ) ) {
			return array(
				'error' => true,
				'value' => __( 'Invalid data type for column', 'fdg' ) . ' ' . $col,
			);
		}

		$min_key = $col . '_int-min';
		$min     = isset( $data[ $min_key ] ) && is_numeric( $data[ $min_key ] ) ? intval( $data[ $min_key ] ) : null;

		if ( null === $min || $min < -2147483648 ) {
			return array(
				'error' => true,
				'value' => __( 'Invalid min int value for column', 'fdg' ) . ' ' . $col,
			);
		}

		$max_key = $col . '_int-max';
		$max     = isset( $data[ $max_key ] ) && is_numeric( $data[ $max_key ] ) ? intval( $data[ $max_key ] ) : null;

		if ( null === $max || $max > 2147483647 ) {
			return array(
				'error' => true,
				'value' => __( 'Invalid max int value for column', 'fdg' ) . ' ' . $col,
			);
		}

		return array(
			'min' => $min,
			'max' => $max,
		);
	}

	private static function get_int_between( $min, $max ) {
		$faker = self::get_faker_instance();
		return $faker->numberBetween( $min, $max );
	}

	private static function is_error( $res ) {
		return isset( $res['error'] ) && true === $res['error'];
	}
}
