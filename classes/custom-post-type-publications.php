<?php
/**
 * Custom Post Type Publications
 *
 * @package Custom Post Type Publications
 * @author Ralf Hortt
 **/
final class Custom_Post_Type_Publications
{



	/**
	 * Plugin constructor
	 *
	 * @access public
	 * @since 2.0
	 * @author Ralf Hortt
	 **/
	public function __construct()
	{

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );

	} // END __construct



	/**
	 * Load plugin translation
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt <me@horttcore.de>
	 * @since v2.0
	 **/
	public function load_plugin_textdomain()
	{

		load_plugin_textdomain( 'custom-post-type-publication', false, dirname( plugin_basename( __FILE__ ) ) . '/../languages/'  );

	} // END load_plugin_textdomain



	/**
	 * Register post type
	 *
	 * @access public
	 * @since 2.0
	 * @author Ralf Hortt
	 */
	public function register_post_type()
	{

		register_post_type( 'publication', array(
			'labels' => array(
				'name' => _x( 'Publications', 'post type general name', 'custom-post-type-publications' ),
				'singular_name' => _x( 'Publication', 'post type singular name', 'custom-post-type-publications' ),
				'add_new' => _x( 'Add New', 'Publication', 'custom-post-type-publications' ),
				'add_new_item' => __( 'Add New Publication', 'custom-post-type-publications' ),
				'edit_item' => __( 'Edit Publication', 'custom-post-type-publications' ),
				'new_item' => __( 'New Publication', 'custom-post-type-publications' ),
				'view_item' => __( 'View Publication', 'custom-post-type-publications' ),
				'search_items' => __( 'Search Publication', 'custom-post-type-publications' ),
				'not_found' =>  __( 'No Publications found', 'custom-post-type-publications' ),
				'not_found_in_trash' => __( 'No Publications found in Trash', 'custom-post-type-publications' ),
				'parent_item_colon' => '',
				'menu_name' => __( 'Publications', 'custom-post-type-publications' )
			),
			'public' => TRUE,
			'publicly_queryable' => TRUE,
			'show_ui' => TRUE,
			'show_in_menu' => TRUE,
			'query_var' => TRUE,
			'rewrite' => array( 'slug' => _x( 'publications', 'Post Type Slug', 'custom-post-type-publication' )),
			'capability_type' => 'post',
			'has_archive' => TRUE,
			'hierarchical' => FALSE,
			'menu_position' => NULL,
			'menu_icon' => 'dashicons-book-alt',
			'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
		) );

	} // END register_post_type



	/**
	 * Register taxonomy
	 *
	 * @access public
	 * @since 2.0
	 * @author Ralf Hortt
	 */
	public function register_taxonomy()
	{

		register_taxonomy( 'document-type',array( 'publication' ), array(
			'hierarchical' => TRUE,
			'labels' => array(
				'name' => _x( 'Document Types', 'taxonomy general name', 'custom-post-type-publication' ),
				'singular_name' => _x( 'Document Type', 'taxonomy singular name', 'custom-post-type-publication' ),
				'search_items' =>  __( 'Search Document Types', 'custom-post-type-publication' ),
				'all_items' => __( 'All Document Types', 'custom-post-type-publication' ),
				'parent_item' => __( 'Parent Document Type', 'custom-post-type-publication' ),
				'parent_item_colon' => __( 'Parent Document Type:', 'custom-post-type-publication' ),
				'edit_item' => __( 'Edit Document Type', 'custom-post-type-publication' ),
				'update_item' => __( 'Update Document Type', 'custom-post-type-publication' ),
				'add_new_item' => __( 'Add New Document Type', 'custom-post-type-publication' ),
				'new_item_name' => __( 'New Document Type Name', 'custom-post-type-publication' ),
				'menu_name' => __( 'Document Types', 'custom-post-type-publication' ),
			),
			'show_ui' => TRUE,
			'show_admin_column' => TRUE,
			'query_var' => TRUE,
			'rewrite' => array( 'slug' => _x( 'division', 'Document Type Slug', 'custom-post-type-publication' ) )
		));

	} // END register_taxonomy



} // END final class Custom_Post_Type_Publications

new Custom_Post_Type_Publications;
