<?php

/**
 * Plugin Name:  Fake Data Generator
 * Plugin URI:   https://fluentcrm.com
 * Description:  Its fake!
 * Version:      0.1.0
 * Author:       Samin Yaser
 * Author URI:   https://yaser-dev.vercel.app
 * License:      GPLv2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  fdg
 * Domain Path:  /language
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use FDG\Includes\Init;

require_once 'vendor/autoload.php';

define( 'FDG', 'fdg' );
define( 'FDG_VERSION', '0.1.0' );
define( 'FDG_PATH', plugin_dir_path( __FILE__ ) );
define( 'FDG_URL', plugin_dir_url( __FILE__ ) );

if ( ! function_exists( 'fdg_autoloader' ) ) {
	function fdg_autoloader( $class ) {
		$namespace = 'FDG\\';
		$base_dir  = FDG_PATH;

		$len = strlen( $namespace );
		if ( strncmp( $namespace, $class, $len ) !== 0 ) {
			return;
		}

		$relative_class = substr( $class, $len );

		$file = $base_dir . str_replace( '\\', '/class-', strtolower( $relative_class ) ) . '.php';

		// error_log( print_r( 'Loading ' . $file, true ) );

		if ( file_exists( $file ) ) {
			require_once $file;
			return;
		}
	}
}

spl_autoload_register( 'fdg_autoloader' );

if ( ! function_exists( 'fdg_init' ) ) {
	function fdg_init() {
		new Init();
	}
}

fdg_init();
