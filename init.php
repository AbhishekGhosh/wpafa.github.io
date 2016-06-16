<?php
/*
 * Plugin Name: WordPress - Application Foundation Using AngularJS (Example)
 * Plugin URI: https://github.com/hasanhalabi/wpafa.github.io
 * Description: This plugin helps in adding Application Foundation features to WordPress using AngularJS. The plugin add a new page represnts teh API.
 * Version: 0.1.0
 * Author: Hasan Halabi
 * Author URI: https://github.com/hasanhalabi/
 * Last Updated: 2016-06-02
 */
include_once 'PageTemplater.php';
wpafaeg_include_directory ( "wp-content/plugins/wp-afa-example/classes" );

// Actions Hooks
add_action ( 'plugins_loaded', array (
		'wpafaeg_PageTemplater',
		'get_instance' 
) );
add_action ( 'activated_plugin', 'wpafaeg_plugin_activation_hook', 10, 2 );
add_action ( 'deactivated_plugin', 'wpafaeg_plugin_deactivation_hook', 10, 2 );
add_action ( 'wp_enqueue_scripts', 'wpafaeg_enqueue_scripts' );
add_action('template_redirect', 'private_content_redirect_to_login', 9);

// Actions Functions
function wpafaeg_plugin_activation_hook($plugin, $network_activation) {
	if ($plugin == 'wp-afa-example/init.php') {
		wpafaeg_PageTemplater::add_plugin_pages ();
	}
}
function wpafaeg_plugin_deactivation_hook($plugin, $network_activation) {
	if ($plugin == 'wp-afa-example/init.php') {
		wpafaeg_PageTemplater::remove_plugin_pages ();
	}
}
function private_content_redirect_to_login() {
	global $wp_query,$wpdb;
	if (is_404()) {
		$private = $wpdb->get_row($wp_query->request);
		$location = wp_login_url($_SERVER["REQUEST_URI"]);
		if( 'private' == $private->post_status  ) {
			wp_safe_redirect($location);
			exit;
		}
	}
}
// Function Declarations
function wpafaeg_include_directory($path) {
	$files = glob ( sprintf ( '%s/*.php', $path ) );
	
	foreach ( $files as $filename ) {
		include_once $filename;
	}
}
function wpafaeg_enqueue_scripts() {
	wp_enqueue_script ( 'fontawesome', 'https://use.fontawesome.com/4f241189a7.js');
	wp_enqueue_script ( 'wpafa-ng-eg', plugin_dir_url ( __FILE__ ) . 'js/wpafaeg.js', array (
			'wpafa-ng-main' 
	), '0.1.0', true );
	wp_enqueue_style ( 'wpafa-ng-eg', plugin_dir_url ( __FILE__ ) . 'css/style.css' );
}