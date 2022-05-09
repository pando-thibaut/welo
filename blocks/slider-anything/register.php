<?php

add_action('acf/init', 'slider_anything_init');
function slider_anything_init() {

// check function exists
    if( function_exists('acf_register_block') ) {

        $name = 'slider-anything';

// register Page slider block
        acf_register_block(array(
            'name'                => $name,
            'title'                => __('Slider universel '),
            'description'        => __('Créé un slider de tout enfant'),
            'render_template'   => get_template_directory() . '/blocks/'.$name.'/template.php',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/'.$name.'/'.$name.'.js',
            'enqueue_style'    => get_template_directory_uri() . '/blocks/'.$name.'/'.$name.'.css',
            'category'            => 'widgets',
            'supports'          => array(
                'jsx' => true
            ),
            'icon'                => 'screenoptions',
            'keywords'            => array( 'category', 'featured' ),
        ));

    }
}