<?
function disable_default_dashboard_widgets() {
        // remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );    // Right Now Widget
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' ); // Comments Widget
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );  // Incoming Links Widget
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );         // Plugins Widget

        // remove_meta_box('dashboard_quick_press', 'dashboard', 'core' );  // Quick Press Widget
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );   // Recent Drafts Widget
        remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );         //
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );       //
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' );       //
           
        // removing plugin dashboard boxes
        remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );         // Yoast's SEO Plugin Widget

        /*
        have more plugin widgets you'd like to remove?
        share them with us so we can get a list of
        the most commonly used. :D
        https://github.com/eddiemachado/bones/issues
        */
}


// removing the dashboard widgets
add_action( 'admin_menu', 'disable_default_dashboard_widgets' );
// adding any custom widgets
add_action( 'wp_dashboard_setup', 'bones_custom_dashboard_widgets' );


// RSS Dashboard Widget
function bones_rss_dashboard_widget() {
        if ( function_exists( 'fetch_feed' ) ) {
                include_once( ABSPATH . WPINC . '/feed.php' );               // include the required file
                $feed = fetch_feed( 'http://kindleman.com.au/feed/r ss' );        // specify the source feed
                $limit = $feed->get_item_quantity(7);                      // specify number of items
                $items = $feed->get_items(0, $limit);                      // create an array of items
        }
        if ($limit == 0) echo '<div>The RSS Feed is either empty or unavailable.</div>';   // fallback message
        else foreach ($items as $item) { ?>

        <h4 style="margin-bottom: 0;">
                <a href="<?php echo $item->get_permalink(); ?>" title="<?php echo mysql2date( __( 'j F Y @ g:i a', 'bonestheme' ), $item->get_date( 'Y-m-d H:i:s' ) ); ?>" target="_blank">
                        <?php echo $item->get_title(); ?>
                </a>
        </h4>
        <p style="margin-top: 0.5em;">
                <?php echo substr($item->get_description(), 0, 200); ?>
        </p>
        <?php }
}

function bones_custom_dashboard_widgets() {
        wp_add_dashboard_widget( 'bones_rss_dashboard_widget', __( 'Recently @ Kindleman ', 'bonestheme' ), 'bones_rss_dashboard_widget' );
        /*
        Be sure to drop any other created Dashboard Widgets
        in this function and they will all load.
        */
}



/************* CUSTOM LOGIN PAGE *****************/

// calling your own login css so you can style it

//Updated to proper 'enqueue' method
//http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
function bones_login_css() {
        wp_enqueue_style( 'kindling_login_css', get_template_directory_uri() . '/stylesheets/css/login.css', false );
}

// changing the logo link from wordpress.org to your site
function bones_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function bones_login_title() { return get_option( 'blogname' ); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'bones_login_css', 10 );
add_filter( 'login_headerurl', 'bones_login_url' );
add_filter( 'login_headertitle', 'bones_login_title' );


/************* CUSTOMIZE ADMIN *******************/

/*
I don't really recommend editing the admin too much
as things may get funky if WordPress updates. Here
are a few funtions which you can choose to use if
you like.
*/

// Custom Backend Footer
function bones_custom_admin_footer() {
        _e( '<span id="footer-thankyou">Developed by <a href="http://kindleman.com" target="_blank">Kindleman</a></span>. Built using <a href="http://kindleman.com.au/kindling" target="_blank">Kindling</a>.', 'bonestheme' );
}

// adding it to the admin area
add_filter( 'admin_footer_text', 'bones_custom_admin_footer' );


// get the the role object
$role_object = get_role( 'editor' );
// add $cap capability to this role object
$role_object->add_cap( 'edit_theme_options' );
$role_object->add_cap( 'create_users' );
$role_object->add_cap( 'delete_users' );
$role_object->add_cap( 'list_users' );
$role_object->add_cap( 'update_plugins' );
$role_object->add_cap( 'update_core' );



//edit_themes
	


?>