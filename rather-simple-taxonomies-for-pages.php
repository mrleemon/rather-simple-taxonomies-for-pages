<?php
/**
 * Plugin Name: Rather Simple Taxonomies for Pages
 * Plugin URI:
 * Update URI: false
 * Description: Adds exclusive categories and tags for pages.
 * Version: 1.0
 * Author: Oscar Ciutat
 * Author URI: http://oscarciutat.com/code/
 * Text Domain: rather-simple-taxonomies-for-pages
 * License: GPLv2 or later
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package rather_simple_taxonomies_for_pages
 */

/**
 * Core class used to implement the plugin.
 */
class Rather_Simple_Taxonomies_For_Pages {

	/**
	 * Plugin instance.
	 *
	 * @var object $instance
	 */
	protected static $instance = null;

	/**
	 * Access this plugin’s working instance
	 *
	 * @return object of this class
	 */
	public static function get_instance() {

		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Used for regular plugin work.
	 */
	public function plugin_setup() {

		// Init.
		add_action( 'init', array( $this, 'load_language' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );

	}

	/**
	 * Constructor. Intentionally left empty and public.
	 */
	public function __construct() {}

	/**
	 * Load language
	 */
	public function load_language() {
		load_plugin_textdomain( 'rather-simple-taxonomies-for-pages', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Register taxonomy
	 */
	public function register_taxonomy() {

		// Adds category taxonomy to pages.
		$labels = array(
			'name'                  => _x( 'Categories', 'taxonomy general name' ),
			'singular_name'         => _x( 'Category', 'taxonomy singular name' ),
			'search_items'          => __( 'Search Categories' ),
			'all_items'             => __( 'All Categories' ),
			'parent_item'           => __( 'Parent Category' ),
			'parent_item_colon'     => __( 'Parent Category:' ),
			'edit_item'             => __( 'Edit Category' ),
			'view_item'             => __( 'View Category' ),
			'update_item'           => __( 'Update Category' ),
			'add_new_item'          => __( 'Add New Category' ),
			'new_item_name'         => __( 'New Category Name' ),
			'not_found'             => __( 'No categories found.' ),
			'no_terms'              => __( 'No categories' ),
			'items_list_navigation' => __( 'Categories list navigation' ),
			'items_list'            => __( 'Categories list' ),
			'most_used'             => _x( 'Most Used', 'categories' ),
			'back_to_items'         => __( '&larr; Back to Categories' ),
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug'         => 'page_category',
				'with_front'   => false,
				'hierarchical' => true,
			),
		);

		if ( ! taxonomy_exists( 'page_category' ) ) {
			register_taxonomy( 'page_category', 'page', $args );
		}

		// Adds tag taxonomy to pages.
		$labels = array(
			'name'                       => _x( 'Tags', 'taxonomy general name' ),
			'singular_name'              => _x( 'Tag', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Tags' ),
			'popular_items'              => __( 'Popular Tags' ),
			'all_items'                  => __( 'All Tags' ),
			'edit_item'                  => __( 'Edit Tag' ),
			'view_item'                  => __( 'View Tag' ),
			'update_item'                => __( 'Update Tag' ),
			'add_new_item'               => __( 'Add New Tag' ),
			'new_item_name'              => __( 'New Tag Name' ),
			'separate_items_with_commas' => __( 'Separate tags with commas' ),
			'add_or_remove_items'        => __( 'Add or remove tags' ),
			'choose_from_most_used'      => __( 'Choose from the most used tags' ),
			'not_found'                  => __( 'No tags found.' ),
			'no_terms'                   => __( 'No tags' ),
			'items_list_navigation'      => __( 'Tags list navigation' ),
			'items_list'                 => __( 'Tags list' ),
			'most_used'                  => _x( 'Most Used', 'tags' ),
			'back_to_items'              => __( '&larr; Back to Tags' ),
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug'       => 'page_tag',
				'with_front' => false,
			),
		);

		if ( ! taxonomy_exists( 'page_tag' ) ) {
			register_taxonomy( 'page_tag', 'page', $args );
		}

	}

}

add_action( 'plugins_loaded', array( Rather_Simple_Taxonomies_For_Pages::get_instance(), 'plugin_setup' ) );
