<?php
add_shortcode( 'docy_tooltip', function( $atts, $content ) {
    ob_start();
    $atts = shortcode_atts( array(
        'id'    => '1',
        'content' => ''
    ), $atts );
    wp_enqueue_script('tooltipster');
    ?>

    <a href="#" class="tooltips" data-tooltip-content="#tooltip-<?php echo esc_attr($atts['id']) ?>">
        <?php echo wp_kses_post($content); ?>
    </a>

    <?php
    $html = ob_get_clean();
    return $html;
});