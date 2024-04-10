<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package docy
 */
get_header();

// Is Table of Contents on Sidebar
$is_toc             = docy_get_field('is_toc');
$post_column        = $is_toc == '1' ? '9' : '12';
$p0                 = $is_toc == '1' ? '' : 'p-0';

if ( $is_toc == '1' ) {
    wp_enqueue_script('anchor');
    wp_enqueue_script('bootstrap-toc');
    $blog_column = is_active_sidebar('sidebar_widgets') ? '7' : '9';
} else {
    $blog_column = is_active_sidebar('sidebar_widgets') ? '8' : '10 m-auto';
}

$banner_type_page = docy_get_field('banner_type', 'colorful');
$banner_type_opt = docy_opt('banner_type', 'colorful');


if ( $banner_type_page != 'default' ) {
    // Fix old data (that was saved as 'toc'. Now it's 'colorful')
    $banner_type = $banner_type_page == 'toc' ? 'colorful' : $banner_type_page;
} else {
    $banner_type = $banner_type_opt;
}

// Banner
get_template_part( 'template-parts/single-post/banner', $banner_type );
?>
<section class="blog_area tip_doc_area" id="sticky_doc2">
    <div class="container">
        <div class="row">
            <?php
            if ( $is_toc == '1' ) :
                ?>
                <div class="col-lg-2 doc_mobile_menu doc-sidebar display_none">
                    <aside class="left_sidebarlist">
                        <nav data-toggle="toc" class="list-unstyled nav-sidebar doc-nav" id="docy-toc"> </nav>
                    </aside>
                </div>
            <?php endif; ?>

            <div class="col-lg-<?php echo esc_attr( $blog_column ) ?> blog_single_info">
                <div class="main-post <?php echo $is_toc == '1' ? 'anchor-enabled' : ''; ?>">
                    <div class="blog_single_item editor-content">
                        <?php
                        while ( have_posts() ) : the_post();
                            $user_desc = get_the_author_meta( 'description' );
                            the_post_thumbnail('full', array( 'class' => 'mb-4 featured-image' ) );
                            the_content();
                            wp_link_pages( array(
                                'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'docy' ) . '</span>',
                                'after'       => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                                'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'docy' ) . ' </span>%',
                                'separator'   => '<span class="screen-reader-text">, </span>',
                            ));
                        endwhile;
                        ?>
                    </div>
                    <?php
                    if ( has_tag() && docy_opt('is_post_tag', '1') == '1' ) : ?>
                        <div class="single_post_tags post-tags">
                            <?php the_tags( esc_html__( 'Tags : ', 'docy' ), ' ' ); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
                // Related posts
                if ( is_singular('post') ) {
                    get_template_part( 'template-parts/single-post/related-posts' );
                }

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>
<?php
get_footer();