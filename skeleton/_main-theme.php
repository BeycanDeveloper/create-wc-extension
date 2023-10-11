<?php
/**
 * @package WooCommerce\Admin
 */

if ( ! function_exists('get_different_path_part') ) {
	function get_different_path_part($path1, $path2) {
		// Dizin yollarını ters veya düz slash karakterlerine göre parçala
		$parts1 = preg_split('/[\\/\\\\]/', $path1);
		$parts2 = preg_split('/[\\/\\\\]/', $path2);
	
		// Her iki yolda da aynı olan kısmı atla
		while (!empty($parts1) && !empty($parts2) && $parts1[0] === $parts2[0]) {
			array_shift($parts1);
			array_shift($parts2);
		}
	
		// Kalan kısımları bir araya getirerek farklı olan bölümü al
		$different_part = implode(DIRECTORY_SEPARATOR, $parts2);
	
		return $different_part;
	}
}

// Exit if accessed directly.
if ( ! function_exists('get_extension_url_from_dir') ) {
	function get_extension_url_from_dir($extension_dir) {
		$extension_dir = get_different_path_part(get_template_directory(), $extension_dir);
		$extension_dir = str_ireplace('\\', '/', $extension_dir);
		return trailingslashit(get_template_directory_uri()) . $extension_dir;
	}
}

add_action( 'admin_enqueue_scripts', function () {
	if ( ! class_exists( 'Automattic\WooCommerce\Admin\PageController' ) || ! \Automattic\WooCommerce\Admin\PageController::is_admin_or_embed_page() ) {
		return;
	}

	$css_path          = 'build/index.css';
	$script_path       = 'build/index.js';
	$css_file          = dirname( __FILE__ ) . '/' . $css_path;
	$script_file       = dirname( __FILE__ ) . '/' . $script_path;
	$script_asset_path = dirname( __FILE__ ) . '/build/index.asset.php';
	$script_asset      = file_exists( $script_asset_path )
		? require( $script_asset_path )
		: array( 'dependencies' => array(), 'version' => filemtime( __FILE__ ) );
	$script_url = get_extension_url_from_dir(__DIR__) . '/' . $script_path;
	$css_url = get_extension_url_from_dir(__DIR__) . '/' . $css_path;

	if ( file_exists( $script_file ) ) {
		wp_register_script(
			'{{extension_name}}',
			$script_url,
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);
		wp_enqueue_script( '{{extension_name}}' );
	}

	if ( file_exists( $css_file ) ) {
		$css_file = dirname( __FILE__ ) . '/build/index.css';
		$css_version = file_exists($css_file) ? filemtime( $css_file ) : filemtime( __FILE__ );
		wp_register_style(
			'{{extension_name}}',
			$css_url,
			// Add any dependencies styles may have, such as wp-components.
			array(),
			$css_version
		);
		wp_enqueue_style( '{{extension_name}}' );
		}
});
