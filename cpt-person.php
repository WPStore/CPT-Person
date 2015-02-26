<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2014-2015, WPStore.io
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @package   WPStore\CPT\Person
 * @version   0.1.0
 */
/**
Plugin Name: CPT Person
Plugin URI:  http://wpstore.io/plugin/cpt-person
Description: Provides a standardized Custom Post Type 'Person' plus metadata registered through ACF or CMB2
Version:     0.1.0
Author:      WPStore.io
Author URI:  http://wpstore.io
License:     GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: cpt-person
Domain Path: /languages

	CPT Person
	Copyright (C) 2014-2015 WPStore.io (http://wpstore.io)

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

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct access! This plugin requires WordPress to be loaded.' );
}

// plugin requires PHP 5.x or newer
if ( version_compare( PHP_VERSION, '5.4.0', '<' ) ) {
	if ( is_admin() ) {
		trigger_error( 'This WordPress plugin requires PHP version 5.4 or higher.' );
	}
	return;
}

// PHP namespace autoloader
require_once( dirname( __FILE__ ) . '/libs/autoload.php' );
//require_once( dirname( __FILE__ ) . '/Person/PluginLoader.php' );
//require_once( dirname( __FILE__ ) . '/Person/ACF.php' );
//require_once( dirname( __FILE__ ) . '/Person/CMB2.php');
//require_once( dirname( __FILE__ ) . '/Person/CPT.php' );
//require_once( dirname( __FILE__ ) . '/Person/Editor.php' );
//require_once( dirname( __FILE__ ) . '/Person/Permalinks.php' );

// initialize on plugins loaded
add_action( 'plugins_loaded', array( '\\WPStore\\CPT\\Person\\PluginLoader', 'init' ), 0, 0 );
