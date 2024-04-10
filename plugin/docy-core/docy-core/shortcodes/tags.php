<?php
add_shortcode( 'terms', function ( $atts, $content ) {
	ob_start();
	$atts = shortcode_atts( array(
		'tax' => 'category',
	), $atts );

	$tags = get_terms( $atts['tax'] );

	foreach ( $tags as $tag ) { ?>
        <div class="tag-wrapper bs-sm h:bs-md">
            <div class="tag-title">
                <h2><a href="<?php echo get_term_link( $tag ); ?>"> <?php echo $tag->name; ?> </a></h2>
            </div>
            <div class="tag-content">
				<?php echo $tag->description; ?>
            </div>
        </div>
	<?php }

	return ob_get_clean();
});