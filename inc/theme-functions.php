<?php

if (!defined('_PNDO_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_PNDO_VERSION', '1.0.0');
}

/**
 * FOOTER HEADER functions
 */

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'   => 'General Settings',
        'menu_title'   => 'General',
        'menu_slug'    => 'general-settings',
        'capability'   => 'edit_posts',
        'redirect'    => false
    ));
    acf_add_options_sub_page(array(
        'page_title'   => 'Header Settings',
        'menu_title'   => 'Header',
        'parent_slug'  => 'general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'   => 'Footer Settings',
        'menu_title'   => 'Footer',
        'parent_slug'  => 'general-settings',
    ));
}


/**
 * CSS and JS INCLUDE
 */

add_action('wp_enqueue_scripts', 'grid_layout_stylesheet');
function grid_layout_stylesheet()
{
    wp_enqueue_style('grid-layout-stylesheet',  get_stylesheet_directory_uri() . '/css/grid-layout.css', array(), _PNDO_VERSION);
}

add_action('wp_enqueue_scripts', 'animeos_stylesheet');
function animeos_stylesheet()
{
    wp_enqueue_style('animeos-stylesheet',  get_stylesheet_directory_uri() . '/css/animeOS.css', array(), _PNDO_VERSION);
    //wp_register_script('animeos-js',  get_stylesheet_directory_uri() . '/js/animeOS.js', array(), _PNDO_VERSION, true);
    //wp_enqueue_script('animeos-js');

    wp_register_script('pndo-anime-js',  get_stylesheet_directory_uri() . '/js/pndo-anime.js', array(), _PNDO_VERSION, true);
    wp_enqueue_script('pndo-anime-js');
}

add_action('wp_enqueue_scripts', 'theme_external_libs');
function theme_external_libs()
{
    // Tiny slider
    wp_enqueue_style('tiny-slider-stylesheet',  'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css', array(), _PNDO_VERSION);
    wp_register_script('wp-tiny-slider-js',  'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js',array(), _PNDO_VERSION, true);
    wp_enqueue_script('wp-tiny-slider-js');

    wp_register_script('imageloaded-js',  'https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js',array(), _PNDO_VERSION, true);
    wp_enqueue_script('imageloaded-js');
}

add_action('wp_enqueue_scripts', 'pndogutenberg_css_js');
function pndogutenberg_css_js()
{
    wp_enqueue_style('pndogutenberg-stylesheet',  get_stylesheet_directory_uri() . '/css/pndogutenberg.css', array(), _PNDO_VERSION);
    wp_register_script('pndogutenberg-js',  get_stylesheet_directory_uri() . '/js/pndogutenberg.js', array(), _PNDO_VERSION, true);
    wp_enqueue_script('pndogutenberg-js');
}

function pndo_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'pndo_content_width', 1200 );
}
add_action( 'after_setup_theme', 'pndo_content_width', 0 );


/**
 *
 * BLOCS DECLARATIONS
 *
 */

require_once get_template_directory() . '/blocks/page-header-slider/register.php';
require_once get_template_directory() . '/blocks/slider-anything/register.php';
require_once get_template_directory() . '/blocks/custom-loop/register.php';
require_once get_template_directory() . '/blocks/backend-comment/register.php';


// Register the three useful image sizes for use in Add Media modal
add_filter( 'image_size_names_choose', 'usable_images_sizes' );
function usable_images_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'fullwidth' => __( 'Image Fullwidth' ),
    ) );
}

add_action( 'after_setup_theme', 'setup' );
function setup() {
    add_image_size( 'fullwidth', 1920, 99999 );

}


function default_blocks_cuisine()
{
    $template = array(
        array('acf/backend-comment', array(
            'align' => '',
            'mode' => 'preview',
            'data' => array("comment" => "Ci-dessous, Le contenu présent dans la liste de cuisine de la page d'accueil de la cuisine<hr />"),
            'className' => "not-editable"
        )),
        array('acf/image-markers', array(
            'align' => '',
            'mode' => 'preview',
        )),
        array('acf/backend-comment', array(
            'align' => '',
            'mode' => 'preview',
            'data' => array("comment" => "Ci-dessous, le contenu de la page \"Détails\" de la cuisine<hr />"),
            'className' => "not-editable"
        )),
        array('acf/image-markers', array(
            'align' => '',
            'mode' => 'preview',
        ))
    );
    $post_type_object = get_post_type_object('post');
    $post_type_object->template = $template;
}

add_action('init', 'default_blocks_cuisine', 20);