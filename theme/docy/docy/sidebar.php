<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package docy
 */

if ( ! is_active_sidebar( 'sidebar_widgets' ) ) {
	return;
}

$is_toc = is_single() ? docy_get_field('is_toc') : '';
?>

<div class="col-lg-<?php echo $is_toc == 1 ? '3' : '4'; ?>">
    <div class="blog_sidebar">
	    <?php dynamic_sidebar( 'sidebar_widgets' ); ?>
	</div>
</div>