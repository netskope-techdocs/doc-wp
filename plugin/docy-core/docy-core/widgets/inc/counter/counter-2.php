<section class="funfact-area">
    <div class="container">
        <div class="funfact-boxes">
            <?php
            $counter2 = $settings['counter2_section'];
            foreach ( $counter2 as $i => $counter ) {
                switch ( $i ) {
                    case 0:
                        $color = 'one';
                        break;
                    case 1:
                        $color = 'two';
                        break;
                    case 2:
                        $color = 'three';
                        break;
                    case 3:
                        $color = 'four';
                        break;
                    case 4:
                        $color = 'five';
                        break;
                    default:
                        $color = 'one';
                }
                ?>
                <div class="funfact-box text-center color-<?php esc_attr($color); ?> wow fadeInRight elementor-repeater-item-<?php echo esc_attr($counter['_id']) ?>" data-wow-delay="0.3s">
                    <div class="fanfact-icon">
                        <?php echo wp_get_attachment_image($counter['icon']['id'], 'full') ?>
                    </div>
                    <div class="counter"><?php echo esc_attr($counter['count_value']) ?></div>
                    <?php if (!empty($counter['count_label'])) : ?>
                        <h3 class="title"><?php echo esc_html($counter['count_label']) ?></h3>
                    <?php endif; ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>