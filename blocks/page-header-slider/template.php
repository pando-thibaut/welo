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

$slides = get_field("slides");
$slider_number_class = "multiple";
if(sizeof($slides) <= 1 )
{
    $slider_number_class = "single";
}
?>

<?php if (!is_admin()): ?>

    <?php  /** -------------------------------------------------- Front Render -------------------------------------------------- */ ?>

    <div class="page-header-slider <?php echo $slider_number_class . " ". esc_attr($classes); ?>">
        <div class="page-header-slider-inner">
            <?php foreach ($slides as $slide) : ?>
            <div class="page-header-slide">
                <div class="slide-image-background">
                    <img src="<?= $slide["image"]["sizes"]["fullwidth"]; ?>" alt="">
                </div>
                <div class="slide-image-content">
                    <div class="container">
                        <div class="slide-image-content-inner">
                            <?php if(is_array($slide["content"]) && sizeof($slide["content"]) > 0) : ?>
                            <?php foreach ($slide["content"] as $slide_content) : ?><?php if ($slide_content["acf_fc_layout"] == "pre-title") : ?>
                                <div class="page-header-slide-pre-title">
                                    <div class="page-header-slide-pre-title-text"><?= $slide_content["texte"] ?></div>
                                    <div class="page-header-slide-pre-title-separator"></div>
                                </div>
                            <?php elseif ($slide_content["acf_fc_layout"] == "title") : ?>
                                <div class="page-header-slide-title">
                                    <?= $slide_content["texte"] ?>
                                </div>
                            <?php elseif ($slide_content["acf_fc_layout"] == "button") : ?>
                                <a href="<?= $slide_content["link"] ?>"
                                   class="page-header-slide-button"><?= $slide_content["texte"]; ?> </a>
                            <?php endif; ?><?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        <div class="page-header-slider-nav">
            <div class="page-header-slider-nav-layout">
                <svg class="left-layout" width="41px" height="27px" viewBox="214 813.581 43.084 26.989" xmlns="http://www.w3.org/2000/svg" xmlns:bx="https://boxy-svg.com">
                    <path d="M 295.908 840.57 L 254.971 840.57 C 258.571 840.573 261.903 842.481 263.727 845.587 L 273.66 862.541 C 275.487 865.652 278.826 867.561 282.433 867.558 L 295.908 867.558 L 295.908 840.57 Z M 254.971 840.57 L 254.954 840.57 C 254.96 840.57 254.965 840.57 254.971 840.57 Z" style="stroke: rgb(0, 0, 0); stroke-width: 0px; fill: rgb(255, 255, 255);" transform="matrix(-1, 0, 0, -1, 509.90799, 1681.140015)" bx:origin="0 0"></path>
                </svg>
                <svg class="right-layout" width="41px" height="27px" viewBox="214 813.581 43.084 26.989" xmlns="http://www.w3.org/2000/svg" xmlns:bx="https://boxy-svg.com">
                    <path d="M 257.084 840.569 L 216.147 840.569 C 219.747 840.566 223.079 838.658 224.903 835.552 L 234.836 818.598 C 236.663 815.487 240.002 813.578 243.609 813.581 L 257.084 813.581 L 257.084 840.569 Z M 216.147 840.569 L 216.13 840.569 C 216.136 840.569 216.141 840.569 216.147 840.569 Z" style="stroke: rgb(0, 0, 0); stroke-width: 0px; fill: rgb(255, 255, 255);" bx:origin="0 0"></path>
                </svg>
            </div>
            <div class="page-header-slider-nav-dots">
            <?php foreach ($slides as $slide)  echo '<span></span>'; ?>
            </div>
        </div>
    </div>
<?php else: ?>

    <?php  /** -------------------------------------------------- Backend Render -------------------------------------------------- */ ?>

    <div class="page-header-slider backend <?php echo esc_attr($classes); ?>">
        <div class="page-header-slider-inner">
            <?php foreach ($slides as $slide) : ?>
            <div class="page-header-slide">
                <div class="slide-image">
                    <img src="<?= $slide["image"]["url"]; ?>" alt="">
                </div>
                <div class="slide-image-content">
                    <div class="container">
                        <div class="slide-image-content-inner">
                            <?php foreach ($slide["content"] as $slide_content) : ?><?php if ($slide_content["acf_fc_layout"] == "pre-title") : ?>
                                <div class="page-header-slide-pre-title">
                                    <div class="page-header-slide-pre-title-text"><?= $slide_content["texte"] ?></div>
                                    <div class="page-header-slide-pre-title-separator"></div>
                                </div>
                            <?php elseif ($slide_content["acf_fc_layout"] == "title") : ?>
                                <div class="page-header-slide-title">
                                    <?= $slide_content["texte"] ?>
                                </div>
                            <?php elseif ($slide_content["acf_fc_layout"] == "button") : ?>
                                <a href="<?= $slide_content["link"] ?>"
                                   class="page-header-slide-button"><?= $slide_content["texte"]; ?> </a>
                            <?php endif; ?><?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>