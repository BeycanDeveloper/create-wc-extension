<?php
/**
 * Plugin Name: {{extension_name}}
 *
 * @package WooCommerce\Admin
 */

add_action( 'admin_enqueue_scripts', function () {
	if ( ! class_exists( 'Automattic\WooCommerce\Admin\PageController' ) || ! \Automattic\WooCommerce\Admin\PageController::is_admin_or_embed_page() ) {
		return;
	}

	$css_path          = '/build/index.css';
	$script_path       = '/build/index.js';
	$css_file          = dirname( __FILE__ ) . $css_path;
	$script_file       = dirname( __FILE__ ) . $script_path;
	$script_asset_path = dirname( __FILE__ ) . '/build/index.asset.php';
	$script_asset      = file_exists( $script_asset_path )
		? require( $script_asset_path )
		: array( 'dependencies' => array(), 'version' => filemtime( __FILE__ ) );
	$script_url = plugins_url( $script_path, __FILE__ );
	$css_url = plugins_url( $css_path, __FILE__ );

	if ( file_exists( $script_file ) ){
		wp_register_script(
			'{{extension_slug}}',
			$script_url,
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);
		wp_enqueue_script( '{{extension_slug}}' );
	}

	if ( file_exists( $css_file ) ) {
		$css_file = dirname( __FILE__ ) . '/build/index.css';
		$css_version = file_exists($css_file) ? filemtime( $css_file ) : filemtime( __FILE__ );
		wp_register_style(
			'{{extension_slug}}',
			$css_url,
			// Add any dependencies styles may have, such as wp-components.
			array(),
			$css_version
		);

		wp_enqueue_style( '{{extension_slug}}' );
	}
});
