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
 * @since 0.1.0
 */
class PluginLoader {

	/**
	 * Current version of the plugin.
	 *
	 * @since 0.0.1
	 * @var   string
	 */
	const VERSION = '0.1.0';

	/**
	 * Bind to hooks and filters
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public static function init() {

		add_action( 'init', array( '\WPStore\CPT\Person\CPT', 'register_cpt' ) );

		if ( is_admin() ) {

			add_action( 'init', array( __CLASS__, 'admin_init' ) );
			add_action( 'tgmpa_register', array( __CLASS__, 'required_plugins' ) );
			
		} // END if

		register_activation_hook(   __FILE__, array( __CLASS__, 'activation'   ) );
		register_deactivation_hook( __FILE__, array( __CLASS__, 'deactivation' ) );

	} // END __construct()
	
	public static function admin_init() {

		\WPStore\CPT\Person\Editor::init();
		\WPStore\CPT\Person\Permalinks::init();

		\WPStore\CPT\Person\ACF::init();
		\WPStore\CPT\Person\CMB2::init();
		
	} // END admin_init()

	public static function required_plugins() {

		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// This is an example of how to include a plugin from the WordPress Plugin Repository.
			array(
				'name'      => 'CMB2',
				'slug'      => 'cmb2',
				'required'  => false,
			),

			array(
				'name'      => 'Advanced Custom Fields',
				'slug'      => 'advanced-custom-fields',
				'required'  => false,
			),

		);

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to pre-packaged plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
				'page_title'                      => __( 'Install Required Plugins', 'theme-slug' ),
				'menu_title'                      => __( 'Install Plugins', 'theme-slug' ),
				'installing'                      => __( 'Installing Plugin: %s', 'theme-slug' ), // %s = plugin name.
				'oops'                            => __( 'Something went wrong with the plugin API.', 'theme-slug' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'theme-slug' ), // %1$s = plugin name(s).
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'theme-slug' ), // %1$s = plugin name(s).
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'theme-slug' ), // %1$s = plugin name(s).
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'theme-slug' ), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'theme-slug' ), // %1$s = plugin name(s).
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'theme-slug' ), // %1$s = plugin name(s).
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'theme-slug' ), // %1$s = plugin name(s).
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'theme-slug' ), // %1$s = plugin name(s).
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'theme-slug' ),
				'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'theme-slug' ),
				'return'                          => __( 'Return to Required Plugins Installer', 'theme-slug' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'theme-slug' ),
				'complete'                        => __( 'All plugins installed and activated successfully. %s', 'theme-slug' ), // %s = dashboard link.
				'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			)
		);

		tgmpa( $plugins, $config );

	}

	public function activation( $network_wide ) {

		if ( post_type_exists( 'person' ) && ! apply_filters( 'cpt_person_force_activation', false ) ) {
			wp_die( __( "A custom post type with the id 'person' is already registered. Activation is blocked to prevent conflicts. Set `add_filter( 'cpt_person_force_activation', '__return_true' )` to force activation." ), __( 'CPT Conflict' ) );
		}

		require_once( dirname( __FILE__ ) . 'CPT.php' );

		if ( ! $network_wide ) {
			add_option(
				'cpt_person_base',
				apply_filters( 'cpt_person_option_base', 'person' ) // use translated version of 'person' !?
			);
		}

		\WPStore\CPT\Person\CPT::register_cpt();

		flush_rewrite_rules();

	} // END activation()

	public function deactivation( $network_wide ) {

		flush_rewrite_rules();

	} // END activation()

} // END class PluginLoader
