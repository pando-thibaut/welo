<?php
/**
 * Block Name: Page Header Slider
 *
 */

?>

<?php
$classes = '';
if (!empty($block['className'])) {
    $classes .= sprintf(' %s', $block['className']);
}
$comment = get_field("comment");

?>

<?php if (!is_admin()): ?>

    <?php /** -------------------------------------------------- Front Render -------------------------------------------------- */ ?>

<?php else: ?>

    <?php /** -------------------------------------------------- Backend Render -------------------------------------------------- */ ?>
    <div class="backend-comment<?= $classes ?>">
        <?= $comment; ?>
    </div>

<?php endif; ?>