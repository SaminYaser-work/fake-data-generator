<?php

namespace FDG\Includes;

class Scheduler {

	const IDLE    = 'IDLE';
	const PENDING = 'PENDING';
	const RUNNING = 'RUNNING';

	public static function set_idle() {
		update_option( 'fdg_insertion_task', self::IDLE );
	}

	public static function set_running() {
		update_option( 'fdg_insertion_task', self::RUNNING );
	}

	public static function set_pending() {
		update_option( 'fdg_insertion_task', self::PENDING );
	}

	public static function set_last_task_result( $res ) {
		update_option( 'fdg_last_task_result', $res );
	}

	public static function get_last_task_result() {
		return get_option( 'fdg_last_task_result', null );
	}

	public static function is_idle() {
		return get_option( 'fdg_insertion_task', self::IDLE ) === self::IDLE;
	}

	public static function set_cancel() {
		update_option( 'fdg_cancel_insertion_task', 1 );
	}

	public static function clear_cancel() {
		update_option( 'fdg_cancel_insertion_task', 0 );
	}

	public static function get_cancel() {
		return get_option( 'fdg_cancel_insertion_task', '0' ) === '1';
	}

	public static function get_status() {
		$status = get_option( 'fdg_insertion_task', self::IDLE );

		if ( self::IDLE === $status ) {
			$last_res = self::get_last_task_result();
		}
	}

	public static function try_scheduling(...$args) {

		// if ( ! self::is_idle() ) {
		// return false;
		// }

		try {
			$res = wp_schedule_single_event( time(), 'fdg_fake_data_generation', $args );

			if ( $res ) {
				self::set_pending();
				return true;
			}

			self::set_idle();
			return false;

		} catch ( \Exception $e ) {
			error_log( print_r( $e->getMessage(), true ) );
			self::set_idle();
			return false;
		}
	}
}
