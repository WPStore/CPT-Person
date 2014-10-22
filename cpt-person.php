<?php
/**
 * @author    Christian Foellmann <foellmann@foe-services.de>
 * @copyright Copyright (c) 2014, Christian Foellmann
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   CPT\Person
 * @version   0.0.3
 */
/**
Plugin Name: CPT Person
Plugin URI:  https://github.com/cfoellmann/CPT-Person
Description: Provides a standardized Custom Post Type 'Person' plus metadata registered through ACF or CMB2
Version:     0.0.3
Author:      Christian Foellmann
Author URI:  http://christian.foellmann.de
License:     GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: cpt-person
Domain Path: /languages

	CPT Person
	Copyright (C) 2014 Christian Foellmann (http://christian.foellmann.de)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace CPT;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

//require 'libs/autoload.php';

/**
 * @todo
 *
 * @since 0.0.1
 */
class Person {

	/**
	 * Current version of the plugin.
	 *
	 * @since 0.0.1
	 * @var   string
	 */
	public static $version = '0.0.3';

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 0.0.1
	 * @static
	 * @var   object $_instance
	 */
	protected static $_instance = null;

	/**
	 * Main Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since  0.0.1
	 * @static
	 * @return object Instance
	 */
	public static function get_instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	} // END get_instance()

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function __construct() {

		$this->require_files();

		// Initiate classes for all requests
		new \CPT\Person\ACF();
		new \CPT\Person\CMB2();
		new \CPT\Person\CPT();

		// Initiate classes for wp-admin requests
		if ( is_admin() ) {

			new \CPT\Person\Editor();
			new \CPT\Person\Permalinks();

		} // END if

		register_activation_hook(   __FILE__, array( '\\CPT\\Person', 'activation' ) );
		register_deactivation_hook( __FILE__, array( '\\CPT\\Person', 'deactivation' ) );

	} // END __construct()

	protected function require_files() {
		require_once 'Person/ACF.php';
		require_once 'Person/CMB2.php';
		require_once 'Person/CPT.php';
		require_once 'Person/Editor.php';
		require_once 'Person/Permalinks.php';
	}

	public function activation( $network_wide ) {

		if ( post_type_exists( 'person' ) && ! apply_filters( 'cpt_person_force_activation', false ) ) {
			wp_die( __( "A custom post type with the id 'person' is already registered. Activation is blocked to prevent conflicts. Set `add_filter( 'cpt_person_force_activation', '__return_true' )` to force activation." ), __( 'CPT Conflict' ) );
		}

		require_once 'Person/CPT.php';

		add_option(
			'cpt_person_base',
			apply_filters( 'cpt_person_option_base', 'person' )
		);

		\CPT\Person\CPT::register_cpt();

		flush_rewrite_rules();

	} // END activation()

	public function deactivation( $network_wide ) {

		flush_rewrite_rules();

	} // END activation()

} // END class


function CPT_Person() {
	return \CPT\Person::get_instance();
}

CPT_Person();
