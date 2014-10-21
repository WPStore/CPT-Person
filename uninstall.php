<?php
/**
 * @author    WP-Store.io <code@wp-store.io>
 * @copyright Copyright (c) 2014, WP-Store.io
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   CPT\Person
 */

if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option( 'cpt_person_base' );
