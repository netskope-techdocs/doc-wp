<?php if ( get_field('docy_hero_search_keywords') == '1' && !empty(get_field('docy_hero_key_list')) ) : ?>
	<div class="header_search_keyword">
		<?php if ( !empty(get_field('docy_hero_key_label')) ) : ?>
			<span class="header-search-form__keywords-label"> <?php echo get_field('docy_hero_key_label'); ?> </span>
		<?php endif; ?>
		<?php if ( !empty(get_field('docy_hero_key_list')) ) : ?>
			<ul class="list-unstyled">
				<?php
				while ( have_rows('docy_hero_key_list') ) : the_row();
					?>
					<li class="wow fadeInUp" data-wow-delay="0.2s">
						<a href="#"> <?php echo esc_html(get_sub_field('docy_hero_key_title')); ?> </a>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php endif; ?>
	</div>
<?php endif; ?>