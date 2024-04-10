<?php
function docy_acf_block_notice( $block ) {
    switch ( $block['type'] ) {
        case 'primary':
            $alert_type_wrapper = '';
            break;
        case '':
    }
    ?>
    <div class="alert media message_alert fade show" role="alert">
        <i class="icon_volume-low"></i>
        <div class="media-body">
            <?php if ( !empty($block['title']) ) : ?>
                <h5> <?php echo wp_kses_post($block['title']) ?> </h5>
            <?php endif; ?>
            <?php echo !empty($block['description']) ? wp_kses_post(wpautop($block['description'])) : ''; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="icon_close"></i>
            </button>
        </div>
    </div>
    <?php
}