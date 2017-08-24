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
class Setup {

	/**
	 * @since 7.0.0
	 * @var   array
	 */
	private $warnings;

	/**
	 * @since 7.0.0
	 * @var   array
	 */
	private $notices;
	private $plugin_file;
	private $network_wide;

	public function __construct( $plugin_file, $network_wide ) {
		$this->plugin_file  = $plugin_file;
		$this->network_wide = $network_wide;
	}

	

	/**
	 * @todo desc
	 *
	 * @since 0.0.1
	 */
	public function activate() {

		do_action( "cpt-person/setup/pre-activation" );

		$this->custom_checks();

		$msg_warning = '';
		$msg_notice  = '';

		if ( $this->warnings ) {
			$msg_warning  = '<h1>' . __( 'Plugin Activation Error', 'cpt-person' ) . '</h1>';
			$msg_warning .= '<h3>' . __( "Custom Post Type (CPT) 'Person'", 'cpt-person' ) . '</h3><ul>';
			foreach ( $this->warnings as $warning ) {
				$msg_warning .= "<li>$warning</li>";
			}
			$msg_warning .= "</ul>";
		}

		if ( $this->notices ) {
			foreach ( $this->notices as $notice ) {
				$msg_notice .= $notice;
			}
		}

		if ( '' !== $msg_warning ) {
			// show warnings
			// abort activation
			wp_die( $msg_warning, __( 'Plugin Activation Error', 'cpt-person' ) );
		}

		if ( '' !== $msg_notice ) {
			// save notice(s) to db (transient?)
			// display notice(s)
		}
		
		require_once( dirname( __FILE__ ) . '/CPT.php' );

		if ( ! $this->network_wide ) {
			add_option(
				'cpt_person_base',
				apply_filters( "cpt-person/option-base", 'person' )
			);
		}

		\WPStore\Plugins\Person\CPT::register_cpt();

		flush_rewrite_rules();

		do_action( "cpt-person/setup/post-activation" );

	} // END run()

	public function pre_activation() {

	}

	public function custom_checks() {

		if ( post_type_exists( 'person' ) && ! apply_filters( "cpt-person/force-activation", false ) ) {
			$this->warnings['cpt_conflict'] = sprintf( __( "A custom post type (CPT) with the id '<code><b>person</b></code>' is already registered. Activation is blocked to prevent conflicts. Set %s to force activation.", 'cpt-person' ), '<code><i>apply_filters( "cpt-person/force-activation", false )</i></code>' );
		}

	} // END custom_checks()

	/**
	 * @todo
	 *
	 * @param string $required_version
	 */
	public function wp_require( $required_version = '3.8' ) {
		if ( version_compare( get_bloginfo( 'version' ), $required_version, '<' ) ) {
			$this->warnings['wp_requirement'] = sprintf( __( "WordPress %s or higher required. The plugin was not activated. On a side note: Why are you running an old version? :( Upgrade!", 'cpt-person' ), "<code><b>{$required_version}</b></code>" );
		}
	} // END wp_require()

	/**
	 * @todo
	 *
	 * @param string $required_version
	 */
	public function php_require( $required_version = '5.3.29' ) {
		if ( version_compare( PHP_VERSION, $required_version, '<' ) ) {
			$this->warnings['php_requirement'] = sprintf( __( 'PHP %1$s or higher required. You are running %2$s. Update to a newer version.', 'cpt-person' ), "<code><b>{$required_version}</b></code>", '<code><b>' . PHP_VERSION . '</b></code>' );
		}
	} // END php_require()

} // END class Setup
