<?
add_action('init', 'bones_head_cleanup');


function bones_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );                    
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );                          
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );                               
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );                       
	// index link
	remove_action( 'wp_head', 'index_rel_link' );                         
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );            
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );             
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); 
	// WP version
	remove_action( 'wp_head', 'wp_generator' );                           

} /* end bones head cleanup */


	//add_theme_support('post-formats');
	add_theme_support('post-thumbnails');
	add_theme_support('menus');


	add_action('wp_enqueue_scripts', 'load_scripts');

	define('THEME_URL', get_template_directory_uri());


	function load_scripts(){
		wp_enqueue_script('jquery');
	}


