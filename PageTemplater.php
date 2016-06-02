<?php
/*
 * Add Page Templates to WordPress with a Plugin
 * BY:
 * - Tom McFarlin: https://github.com/tommcfarlin
 * - Harri Bell-Thomas: http://www.wpexplorer.com/author/harri/
 *
 * Link To: http://www.wpexplorer.com/wordpress-page-templates-plugin/
 *
 */
class wpafa_PageTemplater {
	
	/**
	 * A Unique Identifier
	 */
	protected $plugin_slug;
	
	/**
	 * A reference to an instance of this class.
	 */
	private static $instance;
	
	/**
	 * The array of templates that this plugin tracks.
	 */
	protected $templates;
	
	/**
	 * Returns an instance of this class.
	 */
	public static function get_instance() {
		if (null == self::$instance) {
			self::$instance = new wpafa_PageTemplater ();
		}
		
		return self::$instance;
	}
	
	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	private function __construct() {
		$this->templates = array ();
		
		// Add a filter to the attributes metabox to inject template into the cache.
		add_filter ( 'page_attributes_dropdown_pages_args', array (
				$this,
				'register_project_templates' 
		) );
		
		// Add a filter to the save post to inject out template into the page cache
		add_filter ( 'wp_insert_post_data', array (
				$this,
				'register_project_templates' 
		) );
		
		// Add a filter to the template include to determine if the page has our
		// template assigned and return it's path
		add_filter ( 'template_include', array (
				$this,
				'view_project_template' 
		) );
		
		// Add your templates to this array.
		$template_path = 'page-api.php';
		$this->templates = array (
				$template_path => 'WP-AFA API' 
		);
	}
	
	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doens't really exist.
	 */
	public function register_project_templates($atts) {
		
		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5 ( get_theme_root () . '/' . get_stylesheet () );
		
		// Retrieve the cache list.
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme ()->get_page_templates ();
		if (empty ( $templates )) {
			$templates = array ();
		}
		
		// New cache, therefore remove the old one
		wp_cache_delete ( $cache_key, 'themes' );
		
		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge ( $templates, $this->templates );
		
		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add ( $cache_key, $templates, 'themes', 1800 );
		
		return $atts;
	}
	
	/**
	 * Checks if the template is assigned to the page
	 */
	public function view_project_template($template) {
		global $post;
		
		if (! isset ( $this->templates [get_post_meta ( $post->ID, '_wp_page_template', true )] )) {
			
			return $template;
		}
		
		$file = plugin_dir_path ( __FILE__ ) . get_post_meta ( $post->ID, '_wp_page_template', true );
		
		// Just to be safe, we check if the file exist first
		if (file_exists ( $file )) {
			return $file;
		} else {
			echo $file;
		}
		
		return $template;
	}
	
	/*
	 * Hasan (2016-06-20)
	 * Add API Page
	 */
	public static function add_api_page() {
		$the_page = get_page_by_title ( 'wpafa-api' );
		$the_page_id = - 1;
		//
		
		
		if (! $the_page) {
			// Create post object
			$_p = array ();
			$_p ['post_title'] = 'wpafa-api';
			$_p ['post_content'] = '';
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
					1 
			);
			// the default 'Uncatrgorised'
			
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			$the_page_id = $the_page->ID;
			
			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}
		
		if ($the_page_id > 0) {
			
			$template_path = 'page-api.php';
			delete_post_meta ( $the_page_id, '_wp_page_template' );
			add_post_meta ( $the_page_id, '_wp_page_template', $template_path, true );
		}
		
		return $the_page_id;
	}
	/*
	 * Hasan (2016-06-20)
	 * Remove API Page
	 */
	public static function remove_api_page() {
		$the_page = get_page_by_title ( 'wpafa-api' );
		if ($the_page) {
			$page_to_delete = $the_page->ID;
			wp_delete_post ( $page_to_delete, true );
		}
	}
}