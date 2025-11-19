<?php
/**
 * Plugin Name:       Reset Divi Presets
 * Description:       Adds an admin bar menu with options to reset Divi 4 and Divi 5 global presets.
 * Version:           2.0.0
 * Author:            Pavel Kolpakov
 * Contributors:      Eduard Ungureanu
 * Author URI:        https://example.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       reset-divi-presets
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Main plugin class.
 */
final class Reset_Divi_Presets {

	/**
	 * The single instance of the class.
	 *
	 * @var Reset_Divi_Presets
	 */
	private static $instance = null;

	/**
	 * Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'admin_bar_menu', [ $this, 'add_admin_bar_menu' ], 100 );
		add_action( 'init', [ $this, 'handle_reset_actions' ] );
		add_action( 'admin_notices', [ $this, 'show_admin_notices' ] );
		add_action( 'wp_footer', [ $this, 'show_frontend_notices' ] );
	}

	/**
	 * Add admin bar menu.
	 */
	public function add_admin_bar_menu( $wp_admin_bar ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$wp_admin_bar->add_node( [
			'id'    => 'reset-divi-presets',
			'title' => __( 'Reset Divi Presets', 'reset-divi-presets' ),
			'href'  => '#',
		] );

		$current_url = home_url( add_query_arg( [] ) );

		$reset_divi_4_url = add_query_arg( [
			'action'   => 'reset_divi_4_presets',
			'_wpnonce' => wp_create_nonce( 'reset_divi_4_presets' ),
		], $current_url );

		$reset_divi_5_url = add_query_arg( [
			'action'   => 'reset_divi_5_presets',
			'_wpnonce' => wp_create_nonce( 'reset_divi_5_presets' ),
		], $current_url );

		$wp_admin_bar->add_node( [
			'id'     => 'reset-divi-4-presets',
			'title'  => __( 'Reset Divi 4 Presets', 'reset-divi-presets' ),
			'parent' => 'reset-divi-presets',
			'href'   => $reset_divi_4_url,
			'meta'   => [
				'onclick' => 'return confirm("' . __( 'Are you sure you want to reset Divi 4 presets?', 'reset-divi-presets' ) . '");',
			],
		] );

		$wp_admin_bar->add_node( [
			'id'     => 'reset-divi-5-presets',
			'title'  => __( 'Reset Divi 5 Presets', 'reset-divi-presets' ),
			'parent' => 'reset-divi-presets',
			'href'   => $reset_divi_5_url,
			'meta'   => [
				'onclick' => 'return confirm("' . __( 'Are you sure you want to reset Divi 5 presets?', 'reset-divi-presets' ) . '");',
			],
		] );
	}

	/**
	 * Handle reset actions.
	 */
	public function handle_reset_actions() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$redirect_url = remove_query_arg( [ 'action', '_wpnonce', 'rdp_notice' ] );

		if ( isset( $_GET['action'] ) && 'reset_divi_4_presets' === $_GET['action'] ) {
			check_admin_referer( 'reset_divi_4_presets' );
			delete_option( 'et_divi_builder_global_presets_history_ng' );
			delete_option( 'et_divi_builder_global_presets_ng' );
			wp_safe_redirect( add_query_arg( 'rdp_notice', 'divi_4_reset', $redirect_url ) );
			exit;
		}

		if ( isset( $_GET['action'] ) && 'reset_divi_5_presets' === $_GET['action'] ) {
			check_admin_referer( 'reset_divi_5_presets' );
			delete_option( 'et_divi_builder_global_presets_history_d5' );
			delete_option( 'et_divi_builder_global_presets_d5' );
			wp_safe_redirect( add_query_arg( 'rdp_notice', 'divi_5_reset', $redirect_url ) );
			exit;
		}
	}

	/**
	 * Show admin notices.
	 */
	public function show_admin_notices() {
		if ( ! isset( $_GET['rdp_notice'] ) ) {
			return;
		}

		$notice = '';

		if ( 'divi_4_reset' === $_GET['rdp_notice'] ) {
			$notice = __( 'Divi 4 presets have been reset.', 'reset-divi-presets' );
		}

		if ( 'divi_5_reset' === $_GET['rdp_notice'] ) {
			$notice = __( 'Divi 5 presets have been reset.', 'reset-divi-presets' );
		}

		if ( $notice ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $notice ) . '</p></div>';
		}
	}

	/**
	 * Show frontend notices.
	 */
	public function show_frontend_notices() {
		if ( ! isset( $_GET['rdp_notice'] ) ) {
			return;
		}

		$notice = '';

		if ( 'divi_4_reset' === $_GET['rdp_notice'] ) {
			$notice = __( 'Divi 4 presets have been reset.', 'reset-divi-presets' );
		}

		if ( 'divi_5_reset' === $_GET['rdp_notice'] ) {
			$notice = __( 'Divi 5 presets have been reset.', 'reset-divi-presets' );
		}

		if ( $notice ) {
			$redirect_url = remove_query_arg( 'rdp_notice' );
			echo "<script>alert('" . esc_js( $notice ) . "'); window.history.replaceState(null, null, '" . esc_url( $redirect_url ) . "');</script>";
		}
	}
}

/**
 * Begins execution of the plugin.
 */
function reset_divi_presets_run() {
	return Reset_Divi_Presets::instance();
}
reset_divi_presets_run();
