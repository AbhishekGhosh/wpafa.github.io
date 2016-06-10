<?php
/*
 * Plugin Name: WordPress - Application Foundation Using AngularJS
 * Plugin URI: https://github.com/hasanhalabi/wpafa.github.io
 * Description: This plugin helps in adding Application Foundation features to WordPress using AngularJS. The plugin add a new page represnts teh API.
 * Version: 0.1.0
 * Author: Hasan Halabi
 * Author URI: https://github.com/hasanhalabi/
 * Last Updated: 2016-06-02
 */
include_once 'PageTemplater.php';
wpafa_include_directory ( "wp-content/plugins/wp-afa/classes" );

// Actions Hooks
add_action ( 'plugins_loaded', array (
		'wpafa_PageTemplater',
		'get_instance' 
) );
add_action ( 'activated_plugin', 'wpafa_plugin_activation_hook', 10, 2 );
add_action ( 'deactivated_plugin', 'wpafa_plugin_deactivation_hook', 10, 2 );
add_action ( 'wp_enqueue_scripts', 'wpafa_enqueue_scripts' );
// Actions Functions
function wpafa_plugin_activation_hook($plugin, $network_activation) {
	if ($plugin == 'wp-afa/init.php') {
		wpafa_PageTemplater::add_api_page ();
	}
}
function wpafa_plugin_deactivation_hook($plugin, $network_activation) {
	if ($plugin == 'wp-afa/init.php') {
		wpafa_PageTemplater::remove_api_page ();
	}
}

// Function Declarations
function wpafa_include_directory($path) {
	$files = glob ( sprintf ( '%s/*.php', $path ) );
	
	foreach ( $files as $filename ) {
		include_once $filename;
	}
}
function log_to_file($content) {
	$content = var_export ( $content, TRUE );
	
	// file_put_contents ( 'D:\\temps\\wpafa-log.txt', "\n--------------\n$content", FILE_APPEND );
}
function wpafa_enqueue_scripts() {
	wp_enqueue_script ( 'wpafa-angular', plugin_dir_url ( __FILE__ ) . 'js/angular.min.js', array (), '1.5.6', true );
	wp_enqueue_script ( 'wpafa-ng-main', plugin_dir_url ( __FILE__ ) . 'js/wpafa.js', array (
			'wpafa-angular' 
	), '0.1.0', true );
}