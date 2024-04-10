<?php
$opt = get_option('docy_opt');

$is_breadcrumb = $opt['is_breadcrumb'] ?? '1';

$update_txt = $opt['breadcrumb_update_text'] ?? esc_html__( 'Updated on', 'docy' );
$breadcrumb_home = $opt['breadcrumb_home'] ?? esc_html__( 'Home', 'docy' );

$breadcrumb_container = 'container';
if ( is_singular('docs') || is_post_type_archive('docs') ) {
    $breadcrumb_container = function_exists('ezd_container') ? ezd_container() : 'container';
}

if ( $is_breadcrumb == '1' ) :
    ?>
    <section class="page_breadcrumb">
    <div class="<?php echo esc_attr($breadcrumb_container) ?>">
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <nav aria-label="breadcrumb">
                    <?php
                    if ( is_search() ) {
                        ?>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo esc_url(home_url('/')) ?>">
                                    <?php echo esc_html($breadcrumb_home) ?>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php echo esc_html__('Search results for "', 'docy'); echo get_search_query().'"'; ?>
                            </li>
                        </ol>
                        <?php
                    } else {
                        docy_post_breadcrumbs();
                    }
                    ?>
                </nav>
            </div>
            <div class="col-lg-3 col-md-4">
                <span class="date">
                    <i class="<?php echo is_rtl() ? 'icon_quotations' : 'icon_clock_alt'; ?>"></i>
                    <?php echo esc_html($update_txt); ?>
                    <?php docy_modified_date(); ?>
                </span>
            </div>
        </div>
    </div>
</section>
    <?php
endif;