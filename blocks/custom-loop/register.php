<?php

add_action('acf/init', 'custom_loop_init');
function custom_loop_init() {

// check function exists
    if( function_exists('acf_register_block') ) {

        $name = 'custom-loop';

// register Page slider block
        acf_register_block(array(
            'name'                => $name,
            'title'                => __('Custom Loop'),
            'description'        => __('Boucle de post et template'),
            'render_template'   => get_template_directory() . '/blocks/'.$name.'/template.php',
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

function renderCustomLoop( $atts ) {

    foreach ($atts as $key => $att)
    {
        if(!empty($att))
            $query_args[$key] = $att;
    }


    if(isset($_GET['after']) || isset($_GET['before'])) {
        $args_date = array();
        if(!empty($_GET['after'])) {
            $day = explode("/",$_GET['after'])[0];
            $month = explode("/",$_GET['after'])[1];
            $year = explode("/",$_GET['after'])[2];
            $args_date['after'] = array(
                'day' => $day,
                'year' => $year,
                'month' => $month
            );
        }
        if(!empty($_GET['before'])) {
            $day = explode("/",$_GET['before'])[0];
            $month = explode("/",$_GET['before'])[1];
            $year = explode("/",$_GET['before'])[2];
            $args_date['before'] = array(
                'day' => $day,
                'year' => $year,
                'month' => $month
            );
        }
        $args_date['inclusive'] =  true;
        //$query->set('date_query', $args_date);
        $query_args["date_query"] = $args_date;
    }


    /*$addon_class = "";

    if(isset($atts['addon_class']) && $atts['addon_class'] != "")
        $addon_class = $atts['addon_class'];

    $query_args['paged'] = (get_query_var('paged') ? get_query_var('paged') : 1);*/

    ob_start();
    query_posts($query_args);

    //$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; query_posts("posts_per_page=5&paged=$paged");

    //echo '<div class="posts-loop '.$addon_class.'">';

    if(strpos('/'.$atts['template'], '/content') !== false) {
        while( have_posts() ) {
            the_post();
            locate_template($atts['template'], true, false);
        }
    }
    else {
        locate_template($atts['template'], true, false);
    }

    // Reset everything
    wp_reset_query();

    //echo '</div>';

    //return get_the_ID();
    //return locate_template($atts['template'], true, false);
    return ob_get_clean();
}