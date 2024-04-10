<?php
/**
 * @param array $atts
 * @param $content
 * @return false|string
 */
function docy_code_shortcode_extracted(array $atts, $content) {
    $theme = $atts['theme'] ?? 'prism';
    $inline = $atts['inline'] ?? '';

    if ( !empty($content) ) :
        if ( $inline != 'true' ) : ?>
            <div class="docy-source-code <?php echo $theme ?>" data-lng-type="<?php echo esc_attr($atts['lang']) ?>">
                <pre>
        <?php endif; ?>
                    <code class="language-<?php echo esc_attr($atts['lang']) ?>">
                        <?php
                        if ($atts['lang'] == 'CSS' || $atts['lang'] == 'css' || $atts['lang'] == 'js' || $atts['lang'] == 'JS') {
                            echo str_replace('<br />', ' ', $content);
                        } else {
                            echo esc_html($content);
                        }
                        ?>
                    </code>
            <?php if ( $inline != 'true' ) : ?>
                </pre>
            </div>
            <?php
        endif;
    endif;
    $html = ob_get_clean();
    return $html;
}

add_shortcode( 'code', function($atts, $content ) {
    ob_start();

	$atts = shortcode_atts( array(
        'theme' => 'prism',
        'lang' => 'markup',
        'inline' => '',
	), $atts );

    return docy_code_shortcode_extracted($atts, $content);
});