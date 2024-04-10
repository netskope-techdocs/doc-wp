<?php if ( $settings['is_keywords'] == 'yes' && !empty($settings['keywords']) ) : ?>
	<div class="header_search_keyword">
		<?php if ( !empty($settings['keywords_label']) ) : ?>
			<span class="header-search-form__keywords-label"> <?php echo $settings['keywords_label'] ?> </span>
		<?php endif; ?>
		<?php if ( !empty($settings['keywords']) ) : ?>
			<ul class="list-unstyled">
				<?php
				foreach ( $settings['keywords'] as $keyword ) :
					?>
					<li class="wow fadeInUp" data-wow-delay="0.2s">
						<a href="#"> <?php echo esc_html($keyword['title']); ?> </a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
<?php endif; ?>