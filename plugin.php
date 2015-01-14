<?php
/*
Plugin Name: Custom Post Type Publications
Plugin URI: http://horttcore.de
Description: A custom post type for managing publications
Version: 2.0
Author: Ralf Hortt
Author URI: http://horttcore.de
License: GPL2
*/

require( 'classes/custom-post-type-publications.php' );
// require( 'classes/custom-post-type-publications.widget.php' );
require( 'inc/template-tags.php' );

if ( is_admin() )
	require( 'classes/custom-post-type-publications.admin.php' );
