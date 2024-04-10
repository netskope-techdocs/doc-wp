<?php
/**
 * Block Name: Tab
 *
 * This is the template that displays the Tab block.
 */
function docy_acf_block_tab( $block ) {
    if( have_rows('tab_items') ):
        ?>
        <div class="tab_shortcode">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <?php
                $i = 1;
                while ( have_rows('tab_items') ) : the_row();
                    $tab_id = sanitize_title(get_sub_field('tab_title')).'-'.$i;
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ( $i == 1 ) ? 'active' : ''; ?>" id="<?php echo esc_attr($tab_id); ?>-tab" data-toggle="tab" href="#<?php echo esc_attr($tab_id); ?>" role="tab" aria-controls="<?php echo esc_attr($tab_id); ?>" aria-selected="true">
                            <?php the_sub_field('tab_title'); ?>
                        </a>
                    </li>
                    <?php
                    ++$i;
                endwhile;
                ?>
            </ul>
            <div class="tab-content">
                <?php
                unset($i);
                $i = 1;
                while ( have_rows('tab_items') ) : the_row();
                    $tab_id = sanitize_title(get_sub_field('tab_title')).'-'.$i;
                    ?>
                    <div class="tab-pane fade show <?php echo ( $i == 1 ) ? 'active' : ''; ?>" id="<?php echo esc_attr($tab_id); ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr($tab_id); ?>-tab">
                        <?php the_sub_field('tab_content'); ?>
                    </div>
                    <?php
                    ++$i;
                endwhile;
                ?>
            </div>
        </div>
        <?php
    endif;
}