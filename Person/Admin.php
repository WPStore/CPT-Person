<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2014-2017, WPStore.io
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\Plugins\Person
 */

namespace WPStore\Plugins\Person;

/**
 * @todo
 *
 * @since 0.1.0
 */
class Admin {

	/**
	 * Bind to hooks and filters
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function __construct() {

		add_action( 'init',            array( __CLASS__, 'admin_init' ) );
		add_action( 'plugin_row_meta', array( __CLASS__, 'plugin_row_meta' ), 10, 2 );

	} // END __construct()
	
	public static function admin_init() {

		Editor::init();
		Permalinks::init();
		Table::init();
		
	} // END admin_init()

	public static function plugin_row_meta( $links, $file ) {

		$support_url = __( 'https://support.wpstore.io/cpt-person/', 'cpt-person' );
		$source_url  = __( 'https://github.com/WPStore/CPT-Person/', 'cpt-person' );

		if ( $file == \WPStore\Plugins\wpstore_cpt_person()->get_basename() ) {
			$links['support'] = '<a href="' . esc_url( $support_url ) . '" target="_blank">' . __( 'Support', 'cpt-person' ) . '</a>';
			$links['source']  = '<a href="' . esc_url( $source_url ) . '" target="_blank">' . __( 'Development', 'cpt-person' ) . '</a>';
		}
		return $links;
	}


} // END class
