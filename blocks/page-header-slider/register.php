<?php

add_action('acf/init', 'page_header_slider_init');
function page_header_slider_init() {

// check function exists
    if( function_exists('acf_register_block') ) {

        $name = 'page-header-slider';

// register Page slider block
        acf_register_block(array(
            'name'                => $name,
            'title'                => __('Slider haut de page'),
            'description'        => __('Slider de haut de page avec texte et bouton'),
            'render_template'   => get_template_directory() . '/blocks/'.$name.'/template.php',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/'.$name.'/'.$name.'.js',
            'enqueue_style'    => get_template_directory_uri() . '/blocks/'.$name.'/'.$name.'.css',
            'category'            => 'widgets',
            'icon'                => 'screenoptions',
            'keywords'            => array( 'category', 'featured' ),
        ));

    }
}