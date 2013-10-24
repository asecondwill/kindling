<?
/*
|==============================================================
| Defing the home page fields here.  Related pages, wysiwyg's etc. 
\------------------------------------------------------------
*/
function home_metaboxes( $meta_boxes ) {
	global $prefix;
	$meta_boxes[] = array(
		'id' => 'content_metabox',
		'title' => 'Content',
		'pages' => array('home_page'), // post type
		
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
            'name'     => 'Acknowledgements',
            'desc'     => '',
            'id'       => $prefix . 'acknowledgements',
            'type'     => 'wysiwyg',
            'posttype' => 'article',
        ),
        array(
            'name'     => 'References',
            'desc'     => '',
            'id'       => $prefix . 'reference',
            'type'     => 'wysiwyg',
            'posttype' => 'article',
        ),
        array(
            'name'     => 'PDF',
            'desc'     => '',
            'id'       => $prefix . 'PDF',
            'type'     => 'file',
            'posttype' => 'article',
        ),
         array(
            'name'     => 'Order',
            'desc'     => '',
            'id'       => $prefix . 'order_number',
            'type'     => 'text',
            'std' => 0,
            'default' => 0,

        )
		),
		
	);

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'home_metaboxes' );    


/*
|==============================================================
| add it to the menu.  how do we know the post id?? (function to work it out. TODO)
\------------------------------------------------------------
*/
/*
add_action( 'admin_menu', 'my_custom_menu' );
function my_custom_menu () {
  if ( function_exists( 'add_menu_page' )  ) {
    add_menu_page(  'Home Page', 
                    'Home page', 
                    0, 
                    'post.php?post=1&action=edit', 
                    '', 
                    '/wp-admin/images/generic.png', '3');
  } 
}
*/

/*
|==============================================================
| Allow this post tpye to be set as home page.
\------------------------------------------------------------
*/
add_filter( 'get_pages',  'add_my_cpt' );
function add_my_cpt( $pages )
{
     $my_cpt_pages = new WP_Query( array( 'post_type' => 'home_page' ) );
     if ( $my_cpt_pages->post_count > 0 )
     {
         $pages = array_merge( $pages, $my_cpt_pages->posts );
     }
     return $pages;
}



// let's create the function for the custom type
function custom_post_homepage() { 
        // creating (registering) the custom type 
        register_post_type( 'home_page', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
                 // let's now add all the options for this post type
                array( 'labels' => array(
                        'name' => __( 'Home Page', 'kindlingtheme' ), /* This is the Title of the Group */
                        'singular_name' => __( 'Home Page', 'kindlingtheme' ), /* This is the individual type */
                        'all_items' => __( 'All Home Pages', 'kindlingtheme' ), /* the all items menu item */
                        'add_new' => __( 'Add New', 'kindlingtheme' ), /* The add new menu item */
                        'add_new_item' => __( 'Add New Custom Type', 'kindlingtheme' ), /* Add New Display Title */
                        'edit' => __( 'Edit', 'kindlingtheme' ), /* Edit Dialog */
                        'edit_item' => __( 'Edit Post Types', 'kindlingtheme' ), /* Edit Display Title */
                        'new_item' => __( 'New Post Type', 'kindlingtheme' ), /* New Display Title */
                        'view_item' => __( 'View Post Type', 'kindlingtheme' ), /* View Display Title */
                        'search_items' => __( 'Search Post Type', 'kindlingtheme' ), /* Search Custom Type Title */ 
                        'not_found' =>  __( 'Nothing found in the Database.', 'kindlingtheme' ), /* This displays if there are no entries yet */ 
                        'not_found_in_trash' => __( 'Nothing found in Trash', 'kindlingtheme' ), /* This displays if there is nothing in the trash */
                        'parent_item_colon' => ''
                        ), /* end of arrays */
                        'description' => __( 'Your Sites HomePage', 'kindlingtheme' ), /* Custom Type Description */
                        'public' => true,
                        'publicly_queryable' => true,
                        'exclude_from_search' => true,
                        'show_ui' => true,
                        'query_var' => true,
                        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
                        'menu_icon' => get_stylesheet_directory_uri() . '/img/custom-post-icon.png', /* the icon for the Home Page type menu */
                        'rewrite'        => array( 'slug' => 'custom_type', 'with_front' => false ), /* you can specify its url slug */
                        'has_archive' => 'custom_type', /* you can rename the slug here */
                        'capability_type' => 'post',
                        'hierarchical' => false,
                        /* the next one is important, it tells what's enabled in the post editor */
                        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', /* 'trackbacks', */ /* 'custom-fields', */ /* 'comments',  */'revisions', 'sticky')
                 ) /* end of options */
        ); /* end of register post type */
        
        /* this adds your post categories to your Home Page type */
        register_taxonomy_for_object_type( 'category', 'custom_type' );
        /* this adds your post tags to your Home Page type */
        register_taxonomy_for_object_type( 'post_tag', 'custom_type' );
        
} 

        // adding the function to the Wordpress init
        add_action( 'init', 'custom_post_homepage');
        
        /*
        for more information on taxonomies, go here:
        http://codex.wordpress.org/Function_Reference/register_taxonomy
        */
        
        // now let's add custom categories (these act like categories)
    register_taxonomy( 'custom_cat', 
            array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
            array('hierarchical' => true,     /* if this is true, it acts like categories */             
                    'labels' => array(
                            'name' => __( 'Custom Categories', 'kindlingtheme' ), /* name of the custom taxonomy */
                            'singular_name' => __( 'Custom Category', 'kindlingtheme' ), /* single taxonomy name */
                            'search_items' =>  __( 'Search Custom Categories', 'kindlingtheme' ), /* search title for taxomony */
                            'all_items' => __( 'All Custom Categories', 'kindlingtheme' ), /* all title for taxonomies */
                            'parent_item' => __( 'Parent Custom Category', 'kindlingtheme' ), /* parent title for taxonomy */
                            'parent_item_colon' => __( 'Parent Custom Category:', 'kindlingtheme' ), /* parent taxonomy title */
                            'edit_item' => __( 'Edit Custom Category', 'kindlingtheme' ), /* edit custom taxonomy title */
                            'update_item' => __( 'Update Custom Category', 'kindlingtheme' ), /* update title for taxonomy */
                            'add_new_item' => __( 'Add New Custom Category', 'kindlingtheme' ), /* add new title for taxonomy */
                            'new_item_name' => __( 'New Custom Category Name', 'kindlingtheme' ) /* name title for taxonomy */
                    ),
                    'show_admin_column' => true, 
                    'show_ui' => true,
                    'query_var' => true,
                    'rewrite' => array( 'slug' => 'custom-slug' ),
            )
    );   
    
        // now let's add custom tags (these act like categories)
    register_taxonomy( 'custom_tag', 
            array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
            array('hierarchical' => false,    /* if this is false, it acts like tags */                
                    'labels' => array(
                            'name' => __( 'Custom Tags', 'kindlingtheme' ), /* name of the custom taxonomy */
                            'singular_name' => __( 'Custom Tag', 'kindlingtheme' ), /* single taxonomy name */
                            'search_items' =>  __( 'Search Custom Tags', 'kindlingtheme' ), /* search title for taxomony */
                            'all_items' => __( 'All Custom Tags', 'kindlingtheme' ), /* all title for taxonomies */
                            'parent_item' => __( 'Parent Custom Tag', 'kindlingtheme' ), /* parent title for taxonomy */
                            'parent_item_colon' => __( 'Parent Custom Tag:', 'kindlingtheme' ), /* parent taxonomy title */
                            'edit_item' => __( 'Edit Custom Tag', 'kindlingtheme' ), /* edit custom taxonomy title */
                            'update_item' => __( 'Update Custom Tag', 'kindlingtheme' ), /* update title for taxonomy */
                            'add_new_item' => __( 'Add New Custom Tag', 'kindlingtheme' ), /* add new title for taxonomy */
                            'new_item_name' => __( 'New Custom Tag Name', 'kindlingtheme' ) /* name title for taxonomy */
                    ),
                    'show_admin_column' => true,
                    'show_ui' => true,
                    'query_var' => true,
            )
    ); 
    
    /*
            looking for custom meta boxes?
            check out this fantastic tool:
            https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
    */
    
// Initialize the metabox class
add_action( 'init', 'home_initialize_cmb_meta_boxes', 9999 );
function home_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( dirname(__FILE__). '/../lib/Custom-Metaboxes-and-Fields-for-WordPress/init.php' );
	}
}
