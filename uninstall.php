<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2014-2017, WPStore.io
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\Plugins\Person
 */

/*
 * Block direct access
 */
if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

if ( ! is_multisite() ) { // Single Site Install

	delete_option( 'cpt_person_base' );

} else { // Multisite Installation
	// @todo EVAL multisite uninstall
}
