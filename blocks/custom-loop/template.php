<?php
/**
 * Block Name: Page Header Slider
 *
 */

?>

<?php

$post_type = get_field("post_type");
$template = get_field("template");
$taxonomies = get_field("taxonomies");
$cat = get_field("cat");
$number_posts = (!empty(get_field("number_posts"))) ? get_field("number_posts") : 8;
$order_by = (!empty(get_field("order_by"))) ? get_field("order_by") : "date";
$order_by_custom = get_field("order_by_custom");
$order = (!empty(get_field("order"))) ? get_field("order") : "DESC";
$included_ids = get_field("included_ids");
$excluded_ids = get_field("excluded_ids");
$custom_query_vars = get_field("custom_query_vars");
$meta_queries_array = get_field("meta_queries");

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$atts = array(
    "post_type" => $post_type,
    "template" => $template,
    'cat' => $cat,
    "posts_per_page" => $number_posts,
    'paged' => $paged,
    'order' => $order,
);

if ($order_by == 'custom') {
    $order_by = $order_by_custom;
}

$atts["orderby"] = $order_by;

if ($taxonomies != "") {
    $taxs_queries = array(
        "relation" => $taxonomies["relation"]
    );
    if (!empty($taxonomies["tax"]) && sizeof($taxonomies["tax"])) {
        foreach ($taxonomies["tax"] as $tax) {
            $taxs_queries[] = array(
                "taxonomy" => $tax->taxonomy,
                'field' => 'slug',
                'terms' => array($tax->slug),
            );
        }
    }
    $atts["tax_query"] = $taxs_queries;
}

if (!empty($included_ids))
    $atts["post__in"] = $included_ids;

if (!empty($excluded_ids))
    $atts["post__not_in"] = $excluded_ids;

if (is_array($meta_queries_array) && sizeof($meta_queries_array) && is_array($meta_queries_array["queries"]) &&sizeof($meta_queries_array["queries"])) {
    $metas_queries = array(
        "relation" => $meta_queries_array["relation"]
    );
    foreach ($meta_queries_array["queries"] as $query) {
        $metas_queries[] = array(
            "key" => $query["key"],
            "value" => $query["value"],
            "compare" => $query["compare"],
        );
    }
    $atts["meta_query"] = $metas_queries;
}
?>

<?php if (!is_admin()): ?>

    <?php /** -------------------------------------------------- Front Render -------------------------------------------------- */ ?>
    <?= renderCustomLoop($atts); ?>

<?php else: ?>

    <?php /** -------------------------------------------------- Backend Render -------------------------------------------------- */ ?>
    <div class="custom-loop-admin">
        <div class="custom-loop-admin-title">Custom Loop :</div>
        <div class="custom-loop-admin-info post-type"><span>Post Type : </span><span><?php echo $post_type; ?></span>
        </div>
        <div class="custom-loop-admin-info template"><span>Template : </span><span><?php echo $template; ?></span></div>
        <div class="custom-loop-admin-info taxonomy"><span>Taxonomies : </span>
            <?php if (is_array($taxonomies["tax"])) : ?>
            <span><?php
                echo $taxonomies["relation"] . " ";
                foreach ($taxonomies["tax"] as $tax) {
                    echo $tax->slug . " ";
                };
                ?></span>
        <?php endif; ?>
        </div>
        <div class="custom-loop-admin-info taxonomy">
            <span>Post Number : </span><span><?php echo $number_posts; ?></span></div>
        <div class="custom-loop-admin-info taxonomy"><span>Order by : </span><span><?php echo $order_by; ?></span></div>
        <div class="custom-loop-admin-info taxonomy"><span>Order : </span><span><?php echo $order; ?></span></div>
        <div class="custom-loop-admin-info taxonomy"><span>Included ids : </span><span>
        <?php if (is_array($included_ids)) : ?><?php foreach ($included_ids as $id) {
            echo $id . " ";
        }; ?></span>
            <?php endif; ?>
        </div>
        <div class="custom-loop-admin-info taxonomy"><span>Excluded ids : </span><span>
                <?php if (is_array($excluded_ids)) : ?><?php
                foreach ($excluded_ids as $id) {
                    echo $id . " ";
                }; ?></span>
            <?php endif; ?>
        </div>
        <div class="custom-loop-admin-info taxonomy"><span>Meta queries : </span><span>
                <?php if (is_array($meta_queries_array["queries"])) : ?><?php
                    echo $meta_queries_array["relation"] . " ";
                    foreach ($meta_queries_array["queries"] as $meta_query) {
                        echo json_encode($meta_query);
                    }; ?><?php endif; ?></span>
        </div>
        <!--<div class="custom-loop-admin-info taxonomy"><span>Custom Query vars : </span><span><?php echo $custom_query_vars; ?></span></div>-->
    </div>

<?php endif; ?>