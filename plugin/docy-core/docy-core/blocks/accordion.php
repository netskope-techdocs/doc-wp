<?php
function docy_acf_block_accordion( $block ) {
    $className = !empty($block['className']) ? $block['className'] : '';
    $rand = rand();
    $is_collapsed = get_field('collapse_state') == '1' ? 'true' : 'false';
    $is_show = get_field('collapse_state') == '1' ? 'show' : '';
    $id = sanitize_title(get_field('title')).$rand;

    if ( get_field('type') == 'toggle' ) :
        ?>
        <a class="toggle_btn <?php echo esc_attr($className); ?>" data-toggle="collapse" href="#<?php echo $id; ?>" role="button" aria-expanded="<?php echo esc_attr($is_collapsed) ?>"
           aria-controls="<?php echo $id; ?>">
            <?php echo get_field('title') ?>
        </a>
        <div class="collapse multi-collapse <?php echo esc_attr($is_show); ?>" id="<?php echo $id; ?>">
            <div class="card card-body toggle_body">
                <?php echo get_field('content'); ?>
            </div>
        </div>
        <?php
    endif;

    if ( get_field('type') == 'accordion' ) :
        ?>
        <div class="card doc_accordion">
            <div class="card-header" id="heading-<?php echo $rand; ?>">
                <h5 class="title mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#<?php echo esc_attr($id) ?>" aria-expanded="<?php echo esc_attr($is_collapsed) ?>" aria-controls="<?php echo esc_attr($id) ?>">
                        <?php echo get_field('title') ?><i class="icon_plus"></i><i class="icon_minus-06"></i>
                    </button>
                </h5>
            </div>
            <div id="<?php echo esc_attr($id) ?>" class="collapse show" aria-labelledby="heading-<?php echo $rand; ?>">
                <div class="card-body toggle_body">
                    <?php echo get_field('content'); ?>
                </div>
            </div>
        </div>
        <?php
    endif;

}