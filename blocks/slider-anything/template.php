<?php
/**
 * Block Name: Page Header Slider
 *
 */

?>

<?php

// Create class attribute allowing for custom "className" and "align" values.
$classes = '';
if (!empty($block['className'])) {
    $classes .= sprintf(' %s', $block['className']);
}
if (!empty($block['align'])) {
    $classes .= sprintf(' align%s', $block['align']);
}

$conf = array(
    'center' => get_field("center"),
    'autoplay' => get_field("autoplay"),
    'loop' => get_field("loop"),
    'rewind' => get_field("rewind"),
    'pause_on_hover' => get_field("pause_on_hover"),
    'mouse_drag' => get_field("mouse_drag"),
    'gutter' => get_field("gutter"),
    'item_desktop' => get_field("item_desktop"),
    'size_desktop' => get_field("size_desktop"),
    'item_tablet' => get_field("item_tablet"),
    'size_tablet' => get_field("size_tablet"),
    'item_mobile' => get_field("item_mobile"),
    'size_mobile' => get_field("size_mobile"),
    'arrows' => get_field("arrows"),
    'dots' => get_field("dots"),
    'speed' => get_field("speed"),
    'time_by_slide' => get_field("time_by_slide"),
    'slideby' => get_field("slideby"),
    'left_arrow' => !empty(get_field("left_arrow") ) ? get_field("left_arrow")["url"] : "",
    'right_arrow' => !empty(get_field("right_arrow") ) ? get_field("right_arrow")["url"] : "",
);

$id = uniqid();

?>

<?php if (!is_admin()): ?>

    <?php  /** -------------------------------------------------- Front Render -------------------------------------------------- */ ?>
    <div class="slider-anything <?php echo esc_attr($classes); ?>" slider-id="<?= $id; ?>">
        <div class="slider-anything-container">
            <InnerBlocks  />
        </div>
    </div>

    <script>
        var slider_anything_<?= $id . "=".json_encode($conf); ?>
    </script>

<?php else: ?>

    <?php  /** -------------------------------------------------- Backend Render -------------------------------------------------- */ ?>
    <div class="slider-anything backend <?php echo esc_attr($classes); ?>">
        <div class="slider-anything-container">
            <InnerBlocks  />
        </div>
    </div>

<?php endif; ?>