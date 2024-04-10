<?php
    function docy_acf_block_list(){
        $list_type = get_field('docy_list_order_type');
        if( $list_type == 'docy_unordered_list' ){
            ?>
            <div class="steps-panel">
                <ul class="ordered-list">
                    <?php while( have_rows('docy_icon_list') ) : the_row(); ?>
                    <li class="elementor-repeater-item-c16b3c7">
                        <?php echo get_sub_field('docy_icon_list_content'); ?>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <?php
        }
        if ($list_type == 'docy_ordered_list'){
            ?>
            <div class="steps-panel">
                <ol class="ordered-list">
                    <?php while( have_rows('docy_icon_list') ) : the_row(); ?>
                        <li class="elementor-repeater-item-c16b3c7">
                            <?php echo get_sub_field('docy_icon_list_content'); ?>
                        </li>
                    <?php endwhile; ?>
                </ol>
            </div>
            <?php
        }
    }