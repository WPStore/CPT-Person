<?php
/**
 * @author    Christian Foellmann <foellmann@foe-services.de>
 * @copyright Copyright (c) 2014, Christian Foellmann
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   CPT\Person
 */

if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option( 'cpt_person_base' );
