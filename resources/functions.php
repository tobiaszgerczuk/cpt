<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);

    add_action( 'init', 'register_cpt_Samochód' );

    function register_cpt_Samochód() {
    $labels = array( 
        'name' => __( 'Samochody', 'Samochód' ),
        'singular_name' => __( 'Samochód', 'Samochód' ),
        'add_new' => __( 'Add New', 'Samochód' ),
        'add_new_item' => __( 'Add New Samochód', 'Samochód' ),
        'edit_item' => __( 'Edit Samochód', 'Samochód' ),
        'new_item' => __( 'New Samochód', 'Samochód' ),
        'view_item' => __( 'View Samochód', 'Samochód' ),
        'search_items' => __( 'Search Samochody', 'Samochód' ),
        'not_found' => __( 'No Samochody found', 'Samochód' ),
        'not_found_in_trash' => __( 'No Samochody found in Trash', 'Samochód' ),
        'parent_item_colon' => __( 'Parent Samochód:', 'Samochód' ),
        'menu_name' => __( 'Samochody', 'Samochód' ),
    );
    
    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Samochody',
        'supports' => array( 'title', 'editor', 'author'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type'     => array('samochód','samochody'),
        // overrides the default meta capabilities handling so we can use our own
        'map_meta_cap'        => true,
    );
    
    register_post_type( 'samochody', $args );
    }

	if( function_exists('acf_add_local_field_group') ):

        acf_add_local_field_group(array(
            'key' => 'group_6320665e67f6e',
            'title' => 'Samochód',
            'fields' => array(
                array(
                    'key' => 'field_6320666501f9e',
                    'label' => 'Plik graficzny',
                    'name' => 'plik_graficzny',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'url',
                    'preview_size' => 'medium',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_6320667f01f9f',
                    'label' => 'Marka',
                    'name' => 'marka',
                    'type' => 'text',
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
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_6320668601fa0',
                    'label' => 'Model',
                    'name' => 'model',
                    'type' => 'text',
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
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_6320668c01fa1',
                    'label' => 'Rocznik',
                    'name' => 'rocznik',
                    'type' => 'text',
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
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_6320669701fa2',
                    'label' => 'Mechanicy',
                    'name' => 'mechanicy',
                    'type' => 'user',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'role' => array(
                        0 => 'mechanik',
                    ),
                    'allow_null' => 0,
                    'multiple' => 1,
                    'return_format' => 'array',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'samochody',
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
            'show_in_rest' => 0,
        ));
        
        endif;		


function vm_activation() {
  $caps = [
    'read'         => true,
    'edit_posts'   => true,
    'upload_files' => true,
  ];

  add_role( 'mechanicy', 'Mechanik samochodowy', $caps );
}



// Allow 'reporter' User Role to  view the Dashboard
add_filter( 'woocommerce_prevent_admin_access', 'wc_reporter_admin_access', 20, 1 );
function wc_reporter_admin_access( $prevent_access ) {
    if( current_user_can('mechanicy') )
        $prevent_access = false;

    return $prevent_access;
}




// add role capabilities
add_action('admin_init','vm_add_role_caps',999);
function vm_add_role_caps() {

    // Add the roles you'd like to administer the custom post types
	$roles = array('mechanicy', 'administrator');

    
    foreach($roles as $the_role) {
        $role = get_role($the_role);
        $role->add_cap( 'read' );
        $role->add_cap( 'read_samochody');
        $role->add_cap( 'read_private_samochody' );
        $role->add_cap( 'edit_samochody' );
        $role->add_cap( 'edit_samochód' );
        $role->add_cap( 'edit_others_samochody' );
        $role->add_cap( 'edit_published_samochody' );
        $role->add_cap( 'edit_published_samochód' );
        $role->add_cap( 'publish_samochody' );
        $role->add_cap( 'delete_others_samochody' );
        $role->add_cap( 'delete_private_samochody' );
        $role->add_cap( 'delete_published_samochody' );
    }
    
}