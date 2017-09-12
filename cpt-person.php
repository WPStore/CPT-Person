<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2014-2017, WPStore.io
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @package   WPStore\Plugins\Person
 * @version   0.1.0
 */
/**
Plugin Name: Custom Post Type (CPT) 'Person'
Plugin URI:  https://www.wpstore.io/plugin/cpt-person
Description: Provides a standardized Custom Post Type 'Person' plus metadata registered through CMB2, ACF
Version:     0.1.0
Author:      WPStore.io
Author URI:  https://www.wpstore.io
Donate link: https://www.wpstore.io/donate
License:     GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: cpt-person
Domain Path: /languages

	Custom Post Type (CPT) 'Person'
	Copyright (C) 2014-2017 WPStore.io (https://www.wpstore.io)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace WPStore\Plugins;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct access! This plugin requires WordPress to be loaded.' );
}

/**
 * Class Person
 * @todo
 */
final class Person {

	/**
	 * Current version
	 *
	 * @var  string
	 * @since  0.1.0
	 */
	const VERSION = '0.1.0';

	/**
	 * Path of plugin directory
	 *
	 * @var string
	 * @since  0.1.0
	 */
	var $path = '';

	/**
	 * Plugin basename
	 *
	 * @var string
	 * @since  0.1.0
	 */
	protected $basename = '';

	/**
	 * Singleton instance of plugin
	 *
	 * @var WPStore_CPT_Person
	 * @since  0.1.0
	 */
	protected static $single_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since  0.1.0
	 * @return WPStore_CPT_Person A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Sets up our plugin
	 *
	 * @since  0.1.0
	 */
	protected function __construct() {

		$this->basename = $this->get_basename();
		$this->path     = $this->get_path();

		$this->autoloader();

	} // END __construct()

	/**
	 * @todo DESC
	 * @todo autoloader
	 *
	 * @since 0.0.1
	 * @return void
	 */
	private function autoloader() {

		$base = $this->path . '/';

		if ( !class_exists('\\WPUtils\\Autoloader') ) {
			require_once( $base . 'utils/autoloader.php' );
		}

		// instantiate the loader
		$loader = new \WPUtils\Autoloader;

		// register the autoloader
		$loader->register();

		// register the base directories for the namespace prefix
		$loader->addNamespace('WPStore\Person', $base . '/Person');

	} // END require_files()

	/**
	 * Init hooks
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function init() {

		add_action( 'plugins_loaded', array( '\WPStore\Plugins\Person', 'load_textdomain' ) );

		new Person\CPT();

		if ( ! is_admin() ) {
			// Frontend
			return;
		} // END if

		if ( is_admin() && ! is_network_admin() ) {
			new Person\Admin();
		}

	} // END init()

	/** Helper functions ******************************************************/

	/**
	 * Get the plugin path.
	 *
	 * @since  0.1.0
	 *
	 * @param  string $folder (optional) appended path.
	 *
	 * @return string       Directory and path
	 */
	public function get_path( $folder = '' ) {

		$path = (string) apply_filters( "cpt-person/path", untrailingslashit( plugin_dir_path( __FILE__ ) ) );

		return $path . $folder;

	} // End get_path()

	/**
	 * Get the plugin url.
	 *
	 * @since  0.1.0
	 *
	 * @param  string $path (optional) appended path.
	 *
	 * @return string URL and path
	 */
	public function get_url( $path = '' ) {

		$url = esc_url( apply_filters( "cpt-person/url", plugins_url( '', __FILE__ ) ) );

		return $url . $path;

	} // End get_url()

	/**
	 * Get plugin basename
	 *
	 * @uses plugin_basename()
	 *
	 * @return string
	 * @since 0.1.0
	 */
	public function get_basename() {
		return plugin_basename( __FILE__ );
	}

	/**
	 * Load language files
	 *
	 * @uses load_plugin_textdomain()
	 *
	 * @return void
	 */
	public function load_textdomain() {

		load_plugin_textdomain(
			'cpt-person',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages/'
		);

	} // END load_textdomain()

	/**
	 * @todo DESC
	 *
	 * @todo Check for PHP >= 5.3
	 * @todo Check for PHP json: extension_loaded('json')
	 * @todo Check WP version >= 3.8
	 * @todo redirect to welcome/auth/plugin page
	 *
	 * @since 0.0.1
	 * @return void
	 */
	public static function activation( $network_wide ) {

		require_once dirname( __FILE__ ) . '/Person/Setup.php';

		$activation = new \WPStore\Plugins\Person\Setup( __FILE__, $network_wide );

		$activation->wp_require( '4.8' );
		$activation->php_require( '5.4' );

		$activation->activate();

	} // END activation()

	/**
	 * @todo
	 *
	 * @param bool $network_wide
	 */
	public static function deactivation( $network_wide ) {

		if ( true == $network_wide ) {
			return;
		} else {
			flush_rewrite_rules();
		}

	} // END activation()

} // END class

/**
 * Grab the WPStore_CPT_Person object and return it.
 * Wrapper for WPStore_CPT_Person::get_instance()
 *
 * @since  0.1.0
 * @return WPStore_CPT_Person  Singleton instance of plugin class.
 */
function wpstore_cpt_person() {
	return \WPStore\Plugins\Person::get_instance();
} // END wpstore_cpt_person()

// Kick it off.
add_action( 'plugins_loaded', array( wpstore_cpt_person(), 'init' ) );

/** (De-)Activation */
register_activation_hook( __FILE__, array( wpstore_cpt_person(), 'activation' ) );
register_deactivation_hook( __FILE__, array( wpstore_cpt_person(), 'deactivation' ) );
