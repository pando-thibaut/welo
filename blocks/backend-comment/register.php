<?php

add_action('acf/init', 'backend_comment_init');
function backend_comment_init() {

// check function exists
    if( function_exists('acf_register_block') ) {

        $name = 'backend-comment';

// register Page slider block
        acf_register_block(array(
            'name'                => $name,
            'title'                => __('Backend Comment'),
            'description'        => __('Text displaying only in backend'),
            'render_template'   => get_template_directory() . '/blocks/'.$name.'/template.php',
            'enqueue_style'    => get_template_directory_uri() . '/blocks/'.$name.'/'.$name.'.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/'.$name.'/'.$name.'.js',
            'category'            => 'widgets',
            'supports'          => array(
                'jsx' => true
            ),
            'icon'                => 'screenoptions',
            'keywords'            => array( 'category', 'featured' ),
            'mode' => "preview"
        ));

    }
}