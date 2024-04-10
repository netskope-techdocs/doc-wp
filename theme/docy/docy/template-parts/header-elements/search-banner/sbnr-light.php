<?php
$opt        = get_option('docy_opt');

$bg_image   = !empty(docy_opt('sbnr_light_bg')['background-image']['url']) ? "background-image: url(".esc_url(docy_opt('sbnr_light_bg')['background-image']['url']).");" : '';
$bg_color   = !empty(docy_opt('sbnr_light_bg')['background-color']) ? "background-color: ".esc_attr(docy_opt('sbnr_light_bg')['background-color']).";" : '';
$bg_style   = $bg_color != '' || $bg_image ? "style='$bg_image $bg_color'" : "style='background-image: url(".esc_url(DOCY_DIR_IMG.'/banner-bg.png').");'";

$breadcrumb_container   = is_singular('docs') || is_post_type_archive('docs') ? 'custom_container' : '';
$placeholder            = !empty($opt['banner_search_placeholder']) ? $opt['banner_search_placeholder'] : '';
$is_focus_search        = $opt['is_focus_search'] ?? '';
$is_focus_search        = $is_focus_search == '1' ? 'focused-form' : '';
?>

<section class="doc_banner_area search-banner-light sbnr-global bg-<?php echo docy_opt('search_banner_bg') ?>" <?php echo $bg_style ?>>
    <div class="container">
        <div class="doc_banner_content">
            <form action="<?php echo esc_url(home_url('/')) ?>" role="search" method="get" class="header_search_form <?php echo esc_attr($is_focus_search) ?>">
                <div class="header_search_form_info">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <label for="searchInput">
                                <i class="icon_search"></i>
                            </label>
                            <input type='search' id="searchInput" name="s"  placeholder="<?php echo esc_attr($placeholder) ?>" autocomplete="off" value="<?php echo get_search_query() ?>"/>
                            <?php include('search-spinner.php'); ?>
                            <?php if ( defined('ICL_LANGUAGE_CODE') ) : ?>
                                <input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"/>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php
                include('ajax-search-results.php');
                include('keywords.php');
                ?>
            </form>
        </div>
    </div>
</section>

<?php
include('breadcrumb.php');