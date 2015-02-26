<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2014-2015, WPStore.io
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\CPT\Person
 */

namespace WPStore\CPT\Person;

/**
 * @todo
 *
 * @since 0.0.1
 */
class Editor {

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public static function init() {

		// load meta box hooks on post creation screens
		foreach ( array( 'post', 'post-new' ) as $hook ) {
			add_action( "load-$hook.php", array( __CLASS__, 'load' ), 1, 0 );
		}

	} // END init()

	public static function load() {

		add_filter( 'enter_title_here',      array( __CLASS__, 'change_title_name' ) );
		add_action( 'add_meta_boxes_person', array( __CLASS__, 'metabox_name' ) );

	} // END load()

	/**
	 * Change 'Enter title here' placeholder for Persons to 'Name'
	 *
	 * @author Captain Theme <info@captaintheme.com>
	 * @since  0.0.1
	 */
	public static function change_title_name( $title ) {

	    $screen = get_current_screen();

	    if ( 'person' == $screen->post_type ) {
	        $title = __( 'Name', 'cpt-person' );
	    }

	    return $title;

	} // END change_title_name()

	/**
	 * Rename Featured Image Meta Box to 'Photo'.
	 *
	 * @author Captain Theme <info@captaintheme.com>
	 * @since  0.0.1
	 */
	public static function metabox_name() {

		remove_meta_box(
			'postimagediv',
			'person',
			'side'
		);

		add_meta_box(
			'postimagediv',
			__( 'Photo', 'cpt-person' ),
			'post_thumbnail_meta_box',
			'person',
			'side',
			'low'
		);

	} // END metabox_name()

} // END class Editor
