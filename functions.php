<?php

// Add Fav Icon - Michelle Yau
function add_favicon() {
	echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_template_directory_uri().'/favicon.ico" />';
}
add_action('wp_head', 'add_favicon');

// Include Theme Style - Michelle Yau
function add_theme_style() {
  wp_enqueue_style('foundation-style', get_template_directory_uri() . '/css/foundation.css',false,'1.1','all');
  wp_enqueue_style('app-style', get_template_directory_uri() . '/css/app.css',false,'1.1','all');
  wp_enqueue_style('sl-style', get_template_directory_uri() . '/css/sl.css');
}
add_action( 'wp_enqueue_scripts', 'add_theme_style' );

// Custom Scripts to Include - Michelle Yau & Silvena Lam
function add_theme_scripts() {
  wp_deregister_script('jquery');
  wp_register_script('jquery', get_template_directory_uri().'/js/vendor/jquery.js', false, false);
  wp_enqueue_script('jquery');
  wp_enqueue_script('what-input', get_template_directory_uri().'/js/vendor/what-input.js', array('jquery'), false, false);
	wp_enqueue_script('foundation-js', get_template_directory_uri().'/js/vendor/foundation.js', array('jquery', 'what-input'), false, false);
	wp_enqueue_script('app', get_template_directory_uri().'/js/app.js', array('jquery', 'what-input', 'foundation-js'), false, true);
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts');

// Register Menus - Michelle Yau
// Reference https://www.wpbeginner.com/wp-themes/how-to-add-custom-navigation-menus-in-wordpress-3-0-themes/
function boomradio_nav_menu() {
  register_nav_menu('boom-radio-menu',__( 'Boom Radio Menu' ));
}
add_action( 'init', 'boomradio_nav_menu' );

// Register Footer Widgets - Silvena Lam
function sidebar_registration() {
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #1', 'boomradio' ),
				'id'          => 'sidebar-1',
				'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'twentytwenty' ),
			)
		)
	);
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #2', 'boomradio' ),
				'id'          => 'sidebar-2',
				'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'twentytwenty' ),
			)
		)
	);
  register_sidebar(
    array_merge(
      $shared_args,
      array(
        'name'        => __( 'Footer #3', 'boomradio' ),
        'id'          => 'sidebar-3',
        'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'twentytwenty' ),
      )
    )
  );
}
add_action( 'widgets_init', 'sidebar_registration' );

function theme_post_thumbnails() {
    add_theme_support( 'post-thumbnails' );
}

//Remove Post for Admin Panel - Silvena Lam
function post_remove ()
{
   remove_menu_page('edit.php');
}
add_action('admin_menu', 'post_remove');

//Change Default Page Template - Silvena Lam
function sl_default_page_template() {
    global $post;
    if ( 'page' == $post->post_type
        && 0 != count( get_page_templates( $post ) )
        && get_option( 'page_for_posts' ) != $post->ID // Not the page for listing posts
        && '' == $post->page_template // Only when page_template is not set
    ) {
        $post->page_template = "single.php";
    }
}
add_action('add_meta_boxes', 'sl_default_page_template', 1);

// Add support for featured image for all post- Silvena Lam
add_action( 'after_setup_theme', 'theme_post_thumbnails' );

//Force Activate Plugins
//Source: https:/wordpress.stackexchange.com/questions/199798/activate-a-plugin-through-phpmyadmin-or-ftp
function activate_plugin_via_php() {
    $active_plugins = get_option( 'active_plugins' );
		if(!in_array('advanced-custom-fields/advanced-custom-fields.php',$active_plugins)):
		array_push($active_plugins, 'advanced-custom-fields/acf.php');
		endif;
		if(!in_array('custom-post-type-ui/custom-post-type-ui.php',$active_plugins)):
		array_push($active_plugins, 'custom-post-type-ui/custom-post-type-ui.php');
		endif;
		if(!in_array('wordpress-importer/wordpress-importer.php',$active_plugins)):
    array_push($active_plugins, 'wordpress-importer/wordpress-importer.php');
		endif;
    update_option( 'active_plugins', $active_plugins );
}
add_action( 'init', 'activate_plugin_via_php' );

//Register Custom Post Type and Taxonomies - Silvena Lam
function boom_custom_post_type() {
	/**
	 * Post Type: Carousel - Silvena Lam
	 */

	$labels = [
		"name" => __( "Carousel", "custom-post-type-ui" ),
		"singular_name" => __( "Carousel", "custom-post-type-ui" ),
		"menu_name" => __( "Carousel", "custom-post-type-ui" ),
		"all_items" => __( "All Carousel Images", "custom-post-type-ui" ),
		"add_new_item" => __( "Add New Carousel Images", "custom-post-type-ui" ),
		"edit_item" => __( "Edit Carousel", "custom-post-type-ui" ),
		"featured_image" => __( "Carousel Image", "custom-post-type-ui" ),
		"set_featured_image" => __( "Set Carousel Image", "custom-post-type-ui" ),
		"remove_featured_image" => __( "Remove Carousel Image", "custom-post-type-ui" ),
		"use_featured_image" => __( "Use as Carousel Image", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Carousel", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "Carousel Items",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "carousel",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "slug" => "carousel", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 5,
		"supports" => [ "title", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "carousel", $args );

	/**
	 * Post Type: Programs - Silvena Lam
	 */

	$labels = [
		"name" => __( "Programs", "custom-post-type-ui" ),
		"singular_name" => __( "Program", "custom-post-type-ui" ),
		"featured_image" => __( "Frontpage Thumbnail Image", "custom-post-type-ui" ),
		"set_featured_image" => __( "Set Frontpage Thumbnail Image", "custom-post-type-ui" ),
		"remove_featured_image" => __( "Remove Frontpage Thumbnail Image", "custom-post-type-ui" ),
		"use_featured_image" => __( "Use Frontpage Thumbnail Image", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Programs", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "Details of Radio Program",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "programs",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "slug" => "programs", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 5,
		"supports" => [ "title", "thumbnail" ],
		"taxonomies" => [ "show" ],
		"show_in_graphql" => false,
	];

	register_post_type( "programs", $args );

	/**
	 * Post Type: Contests - Silvena Lam
	 */

	$labels = [
		"name" => __( "Contests", "custom-post-type-ui" ),
		"singular_name" => __( "Contest", "custom-post-type-ui" ),
		"featured_image" => __( "Featured Image", "custom-post-type-ui" ),
		"set_featured_image" => __( "Set Featured Image", "custom-post-type-ui" ),
		"remove_featured_image" => __( "Remove Featured Image", "custom-post-type-ui" ),
		"use_featured_image" => __( "Use Featured Image", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Contests", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "contests",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "slug" => "contests", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 5,
		"supports" => [ "title", "editor", "thumbnail", "custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "contests", $args );

	/**
	 * Post Type: Trends - Silvena Lam
	 */

	$labels = [
		"name" => __( "Trends", "custom-post-type-ui" ),
		"singular_name" => __( "Trend", "custom-post-type-ui" ),
		"featured_image" => __( "Featured Image", "custom-post-type-ui" ),
		"set_featured_image" => __( "Set Featured Image", "custom-post-type-ui" ),
		"remove_featured_image" => __( "Remove Featured Image", "custom-post-type-ui" ),
		"use_featured_image" => __( "Use Cover Image", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Trends", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "trends",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "slug" => "trends", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 5,
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
		"show_in_graphql" => false,
	];

	register_post_type( "trends", $args );

	/**
	 * Post Type: Sponsors - Silvena Lam
	 */

	$labels = [
		"name" => __( "Sponsors", "custom-post-type-ui" ),
		"singular_name" => __( "Sponsor", "custom-post-type-ui" ),
		"featured_image" => __( "Sponsor Logo", "custom-post-type-ui" ),
		"set_featured_image" => __( "Set Sponsor Logo", "custom-post-type-ui" ),
		"remove_featured_image" => __( "Remove Sponsor Logo", "custom-post-type-ui" ),
		"use_featured_image" => __( "Use Sponsor Logo", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Sponsors", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "sponsors",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "slug" => "sponsors", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 5,
		"supports" => [ "title", "thumbnail", "excerpt" ],
		"show_in_graphql" => false,
	];

	register_post_type( "sponsors", $args );

	/**
	* Post Type: About - Chad Yusoff
	*/

	$labels = [
	"name" => __( "About", "custom-post-type-ui" ),
	"singular_name" => __( "About", "custom-post-type-ui" ),
	"featured_image" => __( "Featured Image", "custom-post-type-ui" ),
	"set_featured_image" => __( "Set Featured Image", "custom-post-type-ui" ),
	"remove_featured_image" => __( "Remove Featured Image", "custom-post-type-ui" ),
	"use_featured_image" => __( "Use Featured Image", "custom-post-type-ui" ),
	];

	$args = [
	"label" => __( "About", "custom-post-type-ui" ),
	"labels" => $labels,
	"description" => "about",
	"public" => true,
	"publicly_queryable" => true,
	"show_ui" => true,
	"show_in_rest" => true,
	"rest_base" => "about",
	"rest_controller_class" => "WP_REST_Posts_Controller",
	"has_archive" => false,
	"show_in_menu" => true,
	"show_in_nav_menus" => true,
	"delete_with_user" => false,
	"exclude_from_search" => false,
	"capability_type" => "page",
	"map_meta_cap" => true,
	"hierarchical" => true,
	"rewrite" => [ "slug" => "about", "with_front" => true ],
	"query_var" => true,
	"menu_position" => 5,
	"supports" => [ "title", "editor", "thumbnail", "custom-fields" ],
	"show_in_graphql" => false,
	];

	register_post_type( "about", $args );
}

add_action( 'init', 'boom_custom_post_type' );

function boom_taxonomies() {

	/**
	 * Taxonomy: Radio Shows - Silvena Lam
	 */

	$labels = [
		"name" => __( "Radio Shows", "custom-post-type-ui" ),
		"singular_name" => __( "Radio Show", "custom-post-type-ui" ),
	];


	$args = [
		"label" => __( "Radio Shows", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => false,
		"show_in_nav_menus" => false,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'show', 'with_front' => true,  'hierarchical' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "show",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "show", [ "programs" ], $args );

	/**
	 * Taxonomy: Categories - Silvena Lam
	 */

	$labels = [
		"name" => __( "Categories", "custom-post-type-ui" ),
		"singular_name" => __( "Category", "custom-post-type-ui" ),
	];


	$args = [
		"label" => __( "Categories", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => false,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'trends_c', 'with_front' => true,  'hierarchical' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "trends_c",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "trends_c", [ "trends" ], $args );
}
add_action( 'init', 'boom_taxonomies' );

function boom_taxonomies_trends_c() {

	/**
	 * Taxonomy: Categories.
	 */

	$labels = [
		"name" => __( "Categories", "custom-post-type-ui" ),
		"singular_name" => __( "Category", "custom-post-type-ui" ),
	];


	$args = [
		"label" => __( "Categories", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => false,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'trends_c', 'with_front' => true,  'hierarchical' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "trends_c",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "trends_c", [ "trends" ], $args );
}
add_action( 'init', 'boom_taxonomies_trends_c' );
//End of Register Custom Post Type and Taxonomies


//Register ACF Custom Field - Silvena Lam
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
'key' => 'group_6139b87f8fa03',
'title' => 'End Date',
'fields' => array(
array(
'key' => 'field_6139b9123bf96',
'label' => 'End Date',
'name' => 'end_date',
'type' => 'date_picker',
'instructions' => 'Choose the end date of the contest',
'required' => 1,
'conditional_logic' => 0,
'wrapper' => array(
	'width' => '',
	'class' => '',
	'id' => '',
),
'display_format' => 'd/m/Y',
'return_format' => 'j M, Y',
'first_day' => 1,
),
),
'location' => array(
array(
array(
	'param' => 'post_type',
	'operator' => '==',
	'value' => 'contests',
),
),
),
'menu_order' => 0,
'position' => 'acf_after_title',
'style' => 'default',
'label_placement' => 'top',
'instruction_placement' => 'label',
'hide_on_screen' => '',
'active' => true,
'description' => '',
));

acf_add_local_field_group(array(
'key' => 'group_613eed1504c5d',
'title' => 'Hyperlink',
'fields' => array(
array(
'key' => 'field_613eed42b9771',
'label' => 'Hyperlink',
'name' => 'hyperlink',
'type' => 'url',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
	'width' => '',
	'class' => '',
	'id' => '',
),
'default_value' => '',
'placeholder' => '',
),
),
'location' => array(
array(
array(
	'param' => 'post_type',
	'operator' => '==',
	'value' => 'sponsors',
),
),
array(
array(
	'param' => 'post_type',
	'operator' => '==',
	'value' => 'carousel',
),
),
),
'menu_order' => 0,
'position' => 'normal',
'style' => 'default',
'label_placement' => 'top',
'instruction_placement' => 'label',
'hide_on_screen' => '',
'active' => true,
'description' => '',
));

acf_add_local_field_group(array(
'key' => 'group_61876cca09391',
'title' => 'About',
'fields' => array(
array(
'key' => 'field_61876cd5614e4',
'label' => 'Show Description',
'name' => 'show_description',
'type' => 'textarea',
'instructions' => 'Enter show description here',
'required' => 1,
'conditional_logic' => 0,
'wrapper' => array(
	'width' => '',
	'class' => '',
	'id' => '',
),
'default_value' => '',
'placeholder' => '',
'maxlength' => '',
'rows' => '',
'new_lines' => '',
),
array(
'key' => 'field_61876cf7614e5',
'label' => 'Banner',
'name' => 'banner',
'type' => 'image',
'instructions' => 'Upload the banner here (Orientation: Landscape, Minimum Size: 970x238px)',
'required' => 1,
'conditional_logic' => 0,
'wrapper' => array(
	'width' => '',
	'class' => '',
	'id' => '',
),
'return_format' => 'url',
'preview_size' => 'full',
'library' => 'all',
'min_width' => 970,
'min_height' => 238,
'min_size' => '',
'max_width' => '',
'max_height' => '',
'max_size' => '',
'mime_types' => '',
),
),
'location' => array(
array(
array(
	'param' => 'post_type',
	'operator' => '==',
	'value' => 'programs',
),
),
),
'menu_order' => 1,
'position' => 'normal',
'style' => 'default',
'label_placement' => 'top',
'instruction_placement' => 'label',
'hide_on_screen' => '',
'active' => true,
'description' => '',
));

acf_add_local_field_group(array(
'key' => 'group_618764da75591',
'title' => 'Host 1',
'fields' => array(
array(
'key' => 'field_6187654da3f2b',
'label' => 'Host 1 Name',
'name' => 'host_1_name',
'type' => 'text',
'instructions' => 'Enter the preferred name of host 1 here',
'required' => 1,
'conditional_logic' => 0,
'wrapper' => array(
	'width' => '',
	'class' => '',
	'id' => '',
),
'default_value' => '',
'placeholder' => '',
'prepend' => '',
'append' => '',
'maxlength' => '',
),
array(
'key' => 'field_6187657ba3f2c',
'label' => 'Host 1 Bio Image',
'name' => 'host_1_image',
'type' => 'image',
'instructions' => 'Upload the a photo of Host 1 (Orientation: Portrait, Minimum Size: 684x1024px)',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
	'width' => '',
	'class' => '',
	'id' => '',
),
'return_format' => 'url',
'preview_size' => 'full',
'library' => 'all',
'min_width' => 684,
'min_height' => 1024,
'min_size' => '',
'max_width' => '',
'max_height' => '',
'max_size' => '',
'mime_types' => '',
),
array(
'key' => 'field_61876730a3f2d',
'label' => 'Host 1 Description',
'name' => 'host_1_description',
'type' => 'textarea',
'instructions' => '',
'required' => 1,
'conditional_logic' => 0,
'wrapper' => array(
	'width' => '',
	'class' => '',
	'id' => '',
),
'default_value' => '',
'placeholder' => 'Enter an "about me" type of description of host 1',
'maxlength' => '',
'rows' => '',
'new_lines' => '',
),
),
'location' => array(
array(
array(
	'param' => 'post_type',
	'operator' => '==',
	'value' => 'programs',
),
),
),
'menu_order' => 2,
'position' => 'normal',
'style' => 'default',
'label_placement' => 'top',
'instruction_placement' => 'label',
'hide_on_screen' => '',
'active' => true,
'description' => '',
));

acf_add_local_field_group(array(
'key' => 'group_61876a618beab',
'title' => 'Host 2',
'fields' => array(
array(
'key' => 'field_61876a618f72f',
'label' => 'Host 2 Name',
'name' => 'host_2_name',
'type' => 'text',
'instructions' => 'Enter the preferred name of host 2 here',
'required' => 1,
'conditional_logic' => 0,
'wrapper' => array(
	'width' => '',
	'class' => '',
	'id' => '',
),
'default_value' => '',
'placeholder' => '',
'prepend' => '',
'append' => '',
'maxlength' => '',
),
array(
'key' => 'field_61876a618f741',
'label' => 'Host 2 Bio Image',
'name' => 'host_2_image',
'type' => 'image',
'instructions' => 'Upload the a photo of Host 2 (Orientation: Portrait, Minimum Size: 684x1024px)',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
	'width' => '',
	'class' => '',
	'id' => '',
),
'return_format' => 'url',
'preview_size' => 'full',
'library' => 'all',
'min_width' => 684,
'min_height' => 1024,
'min_size' => '',
'max_width' => '',
'max_height' => '',
'max_size' => '',
'mime_types' => '',
),
array(
'key' => 'field_61876a618f748',
'label' => 'Host 2 Description',
'name' => 'host_2_description',
'type' => 'textarea',
'instructions' => '',
'required' => 1,
'conditional_logic' => 0,
'wrapper' => array(
	'width' => '',
	'class' => '',
	'id' => '',
),
'default_value' => '',
'placeholder' => 'Enter an "about me" type of description of host 2',
'maxlength' => '',
'rows' => '',
'new_lines' => '',
),
),
'location' => array(
array(
array(
	'param' => 'post_type',
	'operator' => '==',
	'value' => 'programs',
),
),
),
'menu_order' => 3,
'position' => 'normal',
'style' => 'default',
'label_placement' => 'top',
'instruction_placement' => 'label',
'hide_on_screen' => '',
'active' => true,
'description' => '',
));

endif;
//End of ACF Custom Field Registration

//Pagaination Links Function that works with Custom Post Type & Single Page Application - Silvena Lam
//This is a modified function based on the original paginate_links
function sl_paginate_links( $args = '' ) {
	global $wp_query, $wp_rewrite;

	// Setting up default values based on the current URL.
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$url_parts    = explode( '?', $pagenum_link );

	// Get max pages and current page out of the current query, if available.
	$total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
	$current = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;

	// Append the format placeholder to the base URL.
	$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

	// URL base depends on permalink settings.
	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	$defaults = array(
		'base'               => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below).
		'format'             => $format, // ?page=%#% : %#% is replaced by the page number.
		'total'              => $total,
		'current'            => $current,
		'aria_current'       => 'page',
		'show_all'           => false,
		'prev_next'          => true,
		'prev_text'          => __( '&laquo; Previous' ),
		'next_text'          => __( 'Next &raquo;' ),
		'end_size'           => 1,
		'mid_size'           => 2,
		'type'               => 'plain',
		'add_args'           => array(), // Array of query args to add.
		'add_fragment'       => '',
		'before_page_number' => '',
		'after_page_number'  => '',
	);

	$args = wp_parse_args( $args, $defaults );

	if ( ! is_array( $args['add_args'] ) ) {
		$args['add_args'] = array();
	}

	// Merge additional query vars found in the original URL into 'add_args' array.
	if ( isset( $url_parts[1] ) ) {
		// Find the format argument.
		$format       = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
		$format_query = isset( $format[1] ) ? $format[1] : '';
		wp_parse_str( $format_query, $format_args );

		// Find the query args of the requested URL.
		wp_parse_str( $url_parts[1], $url_query_args );

		// Remove the format argument from the array of query arguments, to avoid overwriting custom format.
		foreach ( $format_args as $format_arg => $format_arg_value ) {
			unset( $url_query_args[ $format_arg ] );
		}

		$args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
	}

	// Who knows what else people pass in $args.
	$total = (int) $args['total'];
	if ( $total < 2 ) {
		return;
	}
	$current  = (int) $args['current'];
	$end_size = (int) $args['end_size']; // Out of bounds? Make it the default.
	if ( $end_size < 1 ) {
		$end_size = 1;
	}
	$mid_size = (int) $args['mid_size'];
	if ( $mid_size < 0 ) {
		$mid_size = 2;
	}

	$add_args   = $args['add_args'];
	$r          = '';
	$page_links = array();
	$dots       = false;

	if ( $args['prev_next'] && $current && 1 < $current ) :
		$link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
		$link = str_replace( '%#%', $current - 1, $link );
		if ( $add_args ) {
			$link = add_query_arg( $add_args, $link );
		}
		$link .= $args['add_fragment'];

		$page_links[] = sprintf(
			'<div class="prev page-numbers" onclick="pageload(\'%s\')">%s</div>',
			/**
			 * Filters the paginated links for the given archive pages.
			 *
			 * @since 3.0.0
			 *
			 * @param string $link The paginated link URL.
			 */
			esc_url( apply_filters( 'sl_paginate_links', $link ) ),
			$args['prev_text']
		);
	endif;

	for ( $n = 1; $n <= $total; $n++ ) :
		if ( $n == $current ) :
			$page_links[] = sprintf(
				'<span aria-current="%s" class="page-numbers current">%s</span>',
				esc_attr( $args['aria_current'] ),
				$args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number']
			);

			$dots = true;
		else :
			if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
				$link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
				$link = str_replace( '%#%', $n, $link );
				if ( $add_args ) {
					$link = add_query_arg( $add_args, $link );
				}
				$link .= $args['add_fragment'];

				$page_links[] = sprintf(
					'<div class="page-numbers" onclick="pageload(\'%s\')">%s</div>',
					/** This filter is documented in wp-includes/general-template.php */
					esc_url( apply_filters( 'sl_paginate_links', $link ) ),
					$args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number']
				);

				$dots = true;
			elseif ( $dots && ! $args['show_all'] ) :
				$page_links[] = '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>';

				$dots = false;
			endif;
		endif;
	endfor;

	if ( $args['prev_next'] && $current && $current < $total ) :
		$link = str_replace( '%_%', $args['format'], $args['base'] );
		$link = str_replace( '%#%', $current + 1, $link );
		if ( $add_args ) {
			$link = add_query_arg( $add_args, $link );
		}
		$link .= $args['add_fragment'];

		$page_links[] = sprintf(
			'<div class="next page-numbers" onclick="pageload(\'%s\')">%s</div>',
			/** This filter is documented in wp-includes/general-template.php */
			esc_url( apply_filters( 'sl_paginate_links', $link ) ),
			$args['next_text']
		);
	endif;

	switch ( $args['type'] ) {
		case 'array':
			return $page_links;

		case 'list':
			$r .= "<ul class='page-numbers'>\n\t<li>";
			$r .= implode( "</li>\n\t<li>", $page_links );
			$r .= "</li>\n</ul>\n";
			break;

		default:
			$r = implode( "\n", $page_links );
			break;
	}

	/**
	 * Filters the HTML output of paginated links for archives.
	 *
	 * @since 5.7.0
	 *
	 * @param string $r    HTML output.
	 * @param array  $args An array of arguments. See paginate_links()
	 *                     for information on accepted arguments.
	 */
	$r = apply_filters( 'sl_paginate_links_output', $r, $args );

	return $r;
}

//Add ACF meta data in REST API
//Reference: https://stackoverflow.com/questions/56473929/how-to-expose-all-the-acf-fields-to-wordpress-rest-api-in-both-pages-and-custom
function create_ACF_meta_in_REST() {
    $postypes_to_exclude = ['acf-field-group','acf-field'];
    $extra_postypes_to_include = ["page"];
    $post_types = array_diff(get_post_types(["_builtin" => false], 'names'),$postypes_to_exclude);

    array_push($post_types, $extra_postypes_to_include);

    foreach ($post_types as $post_type) {
        register_rest_field( $post_type, 'ACF', [
            'get_callback'    => 'expose_ACF_fields',
            'schema'          => null,
       ]
     );
    }

}

function expose_ACF_fields( $object ) {
    $ID = $object['id'];
    return get_fields($ID);
}

add_action( 'rest_api_init', 'create_ACF_meta_in_REST' );
