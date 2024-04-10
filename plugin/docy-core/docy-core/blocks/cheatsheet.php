<?php
/**
 * Block Name: Cheat Sheet
 *
 * This is the template that displays the Cheat Sheet block.
 */
    function docy_acf_block_cheatsheet(){
        $title_txt = get_field('docy_cheatsheet_title');
        $title = strtolower($title_txt);
        $id = explode(' ', $title);
        $extended_collapse = get_field('docy_cheat_extended_collapse');
        ?>
        <div class="accordion cheatsheet_accordian" id="<?php echo esc_attr($id[0]).'-accordion-main'; ?>">
            <div id="<?php echo $id[0]; ?>" class="card">
                <div class="card-header" id="<?php echo esc_attr($id[0]).'-heading'; ?>">
                    <h4 class="mb-0" id="<?php echo esc_attr($id[0]).'-1'; ?>">
                        <button class="btn btn-link <?php echo ($extended_collapse == 0 ) ? 'collapsed' : ''; ?>" type="button" data-toggle="collapse" data-target="#<?php echo esc_attr($id[0]).'-collapsed'; ?>" aria-expanded="false" aria-controls="<?php echo esc_attr($id[0]).'-collapsed'; ?>">
                            <?php echo $title_txt; ?> <span class="pluse">[+]</span><span class="minus">[-]</span>
                        </button>
                        <a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="" href="#<?php echo esc_attr($id[0]).'-1'; ?>" style="font: 1em / 1 anchorjs-icons; padding-left: 0.375em;"></a></h4>
                </div>
                <div id="<?php echo esc_attr($id[0]).'-collapsed'; ?>" class="collapse <?php echo ($extended_collapse == 1 ) ? 'show' : ''; ?>" aria-labelledby="<?php echo esc_attr($id[0]).'-heading'; ?>" data-parent="#<?php echo esc_attr($id[0]).'-accordion-main'; ?>" style="">
                    <div class="row">
                        <?php if( have_rows('docy_cheat_sheet_list') ) : ?>
                        <?php while( have_rows('docy_cheat_sheet_list') ) : the_row(); ?>
                            <div class="col-lg-3">
                                <div class="cheatsheet_item shadow-sm">
                                    <div class="cheatsheet_num"><?php echo get_sub_field('docy_cheat_serial_number'); ?></div>
                                    <p><?php echo get_sub_field('docy_cheat_top_text'); ?></p>
                                    <h5><?php echo get_sub_field('docy_cheat_content'); ?></h5>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }