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
class Editor {

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 0.1.0
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
		add_filter( 'post_updated_messages', array( __CLASS__, 'updated_messages' ) );

	} // END load()

	/**
	 * Change 'Enter title here' placeholder for Persons to 'Name'
	 *
	 * @author Captain Theme <info@captaintheme.com>
	 * @since  0.1.0
	 */
	public static function change_title_name( $title ) {

	    $screen = get_current_screen();

	    if ( 'person' == $screen->post_type ) {
	        $title = __( 'Name', 'cpt-person' );
	    }

	    return $title;

	} // END change_title_name()

	/**
	 * Person update messages.
	 *
	 * See /wp-admin/edit-form-advanced.php
	 *
	 * @param array $messages Existing post update messages.
	 *
	 * @return array Amended post update messages with new CPT update messages.
	 */
	public static function updated_messages( $messages ) {
		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages['person'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Person updated.', 'cpt-person' ),
			2  => __( 'Custom field updated.', 'cpt-person' ),
			3  => __( 'Custom field deleted.', 'cpt-person' ),
			4  => __( 'Person updated.', 'cpt-person' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Person restored to revision from %s', 'cpt-person' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Person published.', 'cpt-person' ),
			7  => __( 'Person saved.', 'cpt-person' ),
			8  => __( 'Person submitted.', 'cpt-person' ),
			9  => sprintf(
				__( 'Person scheduled for: <strong>%1$s</strong>.', 'cpt-person' ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i', 'cpt-person' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Person draft updated.', 'cpt-person' )
		);

		return $messages;
	}

} // END class Editor
