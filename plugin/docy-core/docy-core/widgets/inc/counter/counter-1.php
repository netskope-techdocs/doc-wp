<section class="doc_fun_fact_area">
	<div class="animated-waves">
		<svg width="100%" height="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" class="animated-wave">
			<title>Wave</title>
			<defs></defs>
			<path id="animated-wave-three" d="" />
		</svg>
		<svg width="100%" height="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" class="animated-wave">
			<title>Wave</title>
			<defs></defs>
			<path id="animated-wave-four" d="" />
		</svg>
	</div>
	<div class="container">
		<div class="row">
			<?php
			if (!empty($counters)) {
				foreach ($counters as $counter) {
					?>
					<div class="col-lg-3 col-md-3 col-sm-6 wow fadeInUp elementor-repeater-item-<?php echo $counter['_id'] ?>">
						<div class="doc_fact_item">
							<div class="counter"><?php echo esc_attr($counter['count_value']) ?></div>
							<?php if (!empty($counter['count_label'])) : ?>
								<p><?php echo esc_html($counter['count_label']) ?></p>
							<?php endif; ?>
						</div>
					</div>
					<?php
				}}
			?>
		</div>
	</div>
</section>