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

require_once 'vendor/autoload.php';

define( 'FDG', 'fdg' );
define( 'FDG_VERSION', '0.1.0' );
define( 'FDG_PATH', plugin_dir_path( __FILE__ ) );
define( 'FDG_URL', plugin_dir_url( __FILE__ ) );

if ( ! function_exists( 'fdg_init' ) ) {
	function fdg_init() {
		require_once 'includes/class-init.php';
		new \FDG\Includes\Init();
	}
}

fdg_init();
