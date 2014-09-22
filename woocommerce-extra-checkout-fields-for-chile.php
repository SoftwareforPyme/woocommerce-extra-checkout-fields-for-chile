<?php
/**
 * Plugin Name: WooCommerce Extra Checkout Fields for Chile
 * Plugin URI: https://github.com/Etiendas/woocommerce-extra-checkout-fields-for-chile
 * Description: Agrega nuevos campos como: RUT, Fecha de Nacimiento, Sexo, Número, Número de Móvil.
 * Version: 0.0.1
 * Author: claudiosanches
 * Author URI: http://claudiosmweb.com/
 * Edithor URI: https://etiendas.cl
 * Text Domain: woocommerce-extra-checkout-fields-for-chile
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Extra_Checkout_Fields_For_Chile' ) ) :

/**
 * Plugin main class.
 */
class Extra_Checkout_Fields_For_Chile {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '0.0.1';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin.
	 *
	 */
	private function __construct() {
		// Load plugin text domain.
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_admin() ) {
				$this->admin_includes();
			}

			$this->includes();
		} else {
			add_action( 'admin_notices', array( $this, 'woocommerce_fallback_notice' ) );
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-extra-checkout-fields-for-chile' );

		load_textdomain( 'woocommerce-extra-checkout-fields-for-chile', trailingslashit( WP_LANG_DIR ) . 'woocommerce-extra-checkout-fields-for-chile/woocommerce-extra-checkout-fields-for-chile-' . $locale . '.mo' );
		load_plugin_textdomain( 'woocommerce-extra-checkout-fields-for-chile', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Includes.
	 *
	 * @return void
	 */
	private function includes() {
		include_once 'includes/class-wc-extra-checkout-fields-for-chile-front-end.php';
		include_once 'includes/class-wc-extra-checkout-fields-for-chile-plugins-support.php';
		include_once 'includes/class-wc-extra-checkout-fields-for-chile-api.php';
	}

	/**
	 * Admin includes.
	 *
	 * @return void
	 */
	private function admin_includes() {
		include_once 'includes/class-wc-extra-checkout-fields-for-chile-admin.php';
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @return void
	 */
	public static function activate() {
		$default = array(
			'person_type'     => 1,
			'ie'              => 0,
			'rg'              => 0,
			'birthdate_sex'   => 0,
			'cell_phone'      => 1,
			'mailcheck'       => 1,
			'maskedinput'     => 1,
			'addresscomplete' => 1,
			'validate_rut'    => 1
		);

		add_option( 'wcbcf_settings', $default );
		add_option( 'wcbcf_version', self::VERSION );
	}

	/**
	 * WooCommerce fallback notice.
	 *
	 * @return string Fallack notice.
	 */
	public function woocommerce_fallback_notice() {
		echo '<div class="error"><p>' . sprintf( __( 'WooCommerce Extra Checkout Fields for Chile depends on %s to work!', 'woocommerce-extra-checkout-fields-for-Chile' ), '<a href="https://etiendas.cl/">' . __( 'WooCommerce', 'woocommerce-extra-checkout-fields-for-chile' ) . '</a>' ) . '</p></div>';
	}
}

/**
 * Activate method.
 */
register_activation_hook( __FILE__, array( 'Extra_Checkout_Fields_For_Chile', 'activate' ) );

/**
 * Initialize the plugin.
 */
add_action( 'plugins_loaded', array( 'Extra_Checkout_Fields_For_Chile', 'get_instance' ) );

endif;
