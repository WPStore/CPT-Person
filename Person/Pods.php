<?php
/**
 * @author    WP-Store.io <code@wp-store.io>
 * @copyright Copyright (c) 2014, WP-Store.io
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
class Pods {

	private $pod_id;

	private $pod_name;

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function __construct() {

		if ( ! defined( 'PODS_VERSION' ) ) {
			return;
		}

		if ( ! class_exists( 'Acf' ) ) {

			$this->pod_name = 'pods_cpt-person';
			$this->setup_pods();

		}

	} // END __construct()

	private function setup_pods() {

		$this->create_pod();
//		$this->add_fields();

	}

	private function create_pod() {

		if ( ! pods_api()->pod_exists( array( 'name' => $this->pod_name ) ) ) {

			$pod_params = array(
				'name'    => $this->pod_name,
				'label'   => __( 'Person', 'cpt-person' ),
				'type'    => 'post_type',
				'object'  => 'person',
				'storage' => apply_filters( 'cpt_person_meta_pods_storage', 'meta' ),
			);

			$this->pod_id = pods_api()->save_pod( $pod_params );

		}

	}

	private function add_fields( $fields ) {

		if ( $this->pod_id ) {

			$params = array(
				'pod_id' => $this->pod_id,
				'pod'	 => $this->pod_name,
				'name'	 => 'latin_name',
				'type'	 => 'text',
			);

			$field_id = pods_api()->save_field( $params );

		}

	}



} // END class Pods
