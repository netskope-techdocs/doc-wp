<?php
/**
 * Ajax Search Results
 */

$is_keywords      = docy_opt('is_keywords');
if ( $is_keywords == '1' ) : ?>
    <div class="header_search_keyword">
        <?php 
        if ( !empty($opt['keywords_label']) ) :
            ?>
            <span class="header-search-form__keywords-label">
                <?php echo esc_html($opt['keywords_label']) ?>
            </span>
            <?php 
        endif;

        // Search Keywords
        if ( !empty($opt['doc_keywords']) ) : 
            ?>
            <ul class="list-unstyled">
                <?php
                foreach ( $opt['doc_keywords'] as $keyword ) :
                    ?>
                    <li class="wow fadeInUp" data-wow-delay="0.2s">
                        <a href="#"> <?php echo esc_html($keyword['doc_keyword']); ?> </a>
                    </li>
                    <?php 
                endforeach; 
                ?>
            </ul>
            <?php 
        endif; 
        ?>
    </div>
    <?php
endif;