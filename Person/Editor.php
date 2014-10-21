<?php
/**
 * @author    Christian Foellmann <foellmann@foe-services.de>
 * @copyright Copyright (c) 2014, Christian Foellmann
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   CPT\Person
 */

namespace CPT\Person;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

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
	public function __construct() {

		add_filter( 'enter_title_here',      array( $this, 'change_title_name' ) );
		add_action( 'add_meta_boxes_person', array( $this, 'metabox_name' ) );

	} // END __construct()

	/**
	 * Change 'Enter title here' placeholder for Persons to 'Name'
	 *
	 * @author Captain Theme <info@captaintheme.com>
	 * @since  0.0.1
	 */
	public function change_title_name( $title ) {

	    $screen = get_current_screen();

	    if ( 'person' == $screen->post_type ){
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
	public function metabox_name() {

		remove_meta_box( 'postimagediv', 'person', 'side' );
		add_meta_box( 'postimagediv', __( 'Photo', 'cpt-person' ), 'post_thumbnail_meta_box', 'person', 'side', 'low' );

	} // END metabox_name()

} // END class Editor
