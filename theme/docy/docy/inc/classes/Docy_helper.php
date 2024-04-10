<?php
/**
 * Docy theme helper functions and resources
 */

class Docy_Helper_Class {
    /**
	 * Hold an instance of Docy_Helper_Class class.
	 * @var Docy_Helper_Class
	 */
	protected static $instance = null;

	/**
	 * Main Docy_Helper_Class instance.
	 * @return Docy_Helper_Class - Main instance.
	 */
	public static function instance() {

		if (null == self::$instance) {
			self::$instance = new Docy_Helper_Class();
		}

		return self::$instance;
	}

    /**
     * Website Logo
     */
    public function logo() {
        $opt = get_option( 'docy_opt' );

        // Main Logo
        $main_logo = $opt['main_logo']['url'] ?? '';
        $retina_logo = !empty($opt['retina_logo']['url']) ? "srcset='{$opt['retina_logo']['url']} 2x'" : '';

        // Sticky Logo
        $sticky_logo = $opt['sticky_logo']['url'] ?? '';
        $retina_sticky_logo = !empty($opt['retina_sticky_logo']['url']) ? "srcset='{$opt['retina_sticky_logo']['url']} 2x'" : '';
        ?>
        <a class="navbar-brand header_logo" href="<?php echo esc_url(home_url('/')); ?>">
            <?php
            if ( !empty($main_logo) ) :
                ?>
                <img class="first_logo sticky_logo" src="<?php echo esc_url($main_logo) ?>" alt="<?php bloginfo('name'); ?>" <?php echo $retina_logo ?>>
                <?php if ( !empty($sticky_logo) ) : ?>
                    <img class="white_logo" src="<?php echo esc_url($sticky_logo) ?>" alt="<?php bloginfo('name'); ?>" <?php echo $retina_sticky_logo ?>>
                <?php endif; ?>
                <?php
            else:
                ?>
                <h3><?php echo get_bloginfo( 'name' ) ?></h3>
                <?php
            endif;
        echo '</a>';
    }

    /**
    * Render the Navbar classes based on conditions
    */
    function navbar_type() {
        $opt = get_option('docy_opt' );
        $header_type_page = function_exists('get_field') ? get_field('docy_header_type' ) : '';

        $post_default_navbar = is_singular('post') && ($header_type_page == 'default' || $header_type_page == ''); // If header type is default or not selected from Options :: Post
        $search_banner_type = $opt['select_search_banner'] ?? 'light';

        $header_type = $header_type_page != 'default' ? $header_type_page : '';

        if ( (docy_is_aesthetic_default() && !is_page()) || $post_default_navbar ) {
            $header_type = 'white';
        }

        if ( (!isset($header_type) && docy_is_titlebar_default() ) || docy_is_titlebar_default() ) {
            $header_type = 'black';
        }

        if ( is_home() && $search_banner_type == 'light' ) {
            $header_type = 'black';
        }

        // 404-Page Navbar Type class is 'dark_menu'
        if ( is_404() ) {
            $header_type = 'black';
        }

        $nav_classes = $header_type == 'white' ? ' menu_purple' : ' dark_menu';

        echo $nav_classes;
    }

    // Banner Title
    function banner_title() {
        $opt = get_option('docy_opt');
        if ( is_home() ) {
            $blog_title = ! empty( $opt['blog_title'] ) ? $opt['blog_title'] : esc_html__( 'Blog', 'docy' );
            echo esc_html($blog_title);
        } elseif ( is_page() || is_single() ) {
            the_title();
        } elseif( is_category() ) {
            single_cat_title();
        } elseif( is_archive() ) {
            the_archive_title();
        } elseif( is_search() ) {
            esc_html_e( 'Search result for: “', 'docy' ); echo get_search_query().'”';
        } else {
            the_title();
        }
    }

    /**
     * Social Links
     **/
    function social_links() {
        $opt = get_option( 'docy_opt' );
        ?>
        <?php if ( !empty($opt['facebook']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['facebook']); ?>"><i class="social_facebook" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['twitter']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['twitter']); ?>"><i class="social_twitter" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['instagram']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['instagram']); ?>"><i class="social_instagram" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['linkedin']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['linkedin']); ?>"><i class="social_linkedin" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['youtube']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['youtube']); ?>"><i class="social_youtube" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['github']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['github']); ?>"><i class="fab fa-github-alt" aria-hidden="true"></i></a> </li>
        <?php } ?>

        <?php if ( !empty($opt['dribbble']) ) { ?>
            <li> <a href="<?php echo esc_url($opt['dribbble']); ?>"><i class="social_dribbble" aria-hidden="true"></i></a> </li>
        <?php }
    }

    /**
    * @param $color
    * @param false $opacity
    * Convert hexdec color string to rgb(a) string
    * @return string
    */
    function hex2rgba( $color, $opacity = false ) {

	    $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if(empty($color))
              return $default;

        //Sanitize $color if "#" is provided
            if ($color[0] == '#' ) {
                $color = substr( $color, 1 );
            }

            //Check if color has 6 or 3 characters and get values
            if (strlen($color) == 6) {
                    $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                    $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                    return $default;
            }

            //Convert hexadec to rgb
            $rgb =  array_map('hexdec', $hex);

            //Check if opacity is set(rgba or rgb)
            if($opacity){
                if(abs($opacity) > 1)
                    $opacity = 1.0;
                $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
            } else {
                $output = implode(",",$rgb);
            }

            //Return rgb(a) color string
            return $output;
    }

    /** Render Meta CSS value
    * @param $handle
    * @param $css_items
    */
     function meta_css_render( $handle, $css_items ) {
         $dynamic_css = '';
         $opt = get_option( 'docy_opt' );

         if ( function_exists('get_field') ) {
             $change_types  = get_field('change_types', 'option');
             $toc_titles    = get_field('titles');

             $keys = array_keys($css_items);
             for ( $i = 0; $i < count($css_items); $i++ ) {
                 $split_id = explode('__', $keys[$i]);
                 $meta_id = $split_id[0];
                 $append = !empty($split_id[1]) ? $split_id[1] : '';
                 $meta_value = get_field($meta_id);
                 if ( !empty($meta_value) ) {
                     $css_i = 1;
                     foreach ( $css_items[$keys[$i]] as $property => $selector ) {
                         $css_output = "$selector {";
                         $css_output .= "$property: $meta_value$append;";
                         $css_output .= "}";
                         $dynamic_css .= $css_output;
                         $css_i++;
                     }
                 }
             }

             // Post Banner
             $banner_image = get_field('banner_image');
             $banner_background_color = get_field('banner_background_color');

            if ( !empty($banner_image['url']) ) {
                $dynamic_css .= ".tip_banner_area, .doc_banner_area{background: url({$banner_image['url']}) no-repeat;}";
            }
           
            $gradient_bg    = docy_opt('gradient_bg_color');
            $gradient_bg1   = $gradient_bg['gradient_bg_color-from'] ?? '#FFFBF2';
            $gradient_bg2   = $gradient_bg['gradient_bg_color-to'] ?? '#EDFFFD';
            
            if ( !empty($gradient_bg1 || $gradient_bg2) ) {
                $dynamic_css .= "body:is(.blog, .topic, .search, .tag, .category, .bbpress, .single-post) .body_wrapper {background: linear-gradient(45deg, {$gradient_bg1}, {$gradient_bg2});}";

                $dynamic_css .= "body .bg_color_gradient{background: linear-gradient(45deg, {$gradient_bg1}, {$gradient_bg2});}";
            }


             if ( !empty($banner_background_color) ) {
                 $dynamic_css .= ".doc_banner_area { background-color: $banner_background_color !important;}";
             }

             if ( !empty($opt['custom_css']) ) {
                $dynamic_css .= $opt['custom_css'];
             }

             if ( !empty($change_types) ) {
                 foreach ( $change_types as $change) {
                     $change_type_class = $change['type'] ? docy_get_slug($change['type']) : '';
                     $changelog_bg_color = !empty($change['background_color']) ? "background: {$change['background_color']};" : '';
                     $changelog_color = !empty($change['font_color']) ? "color: {$change['font_color']};" : '';
                     if ( !empty($changelog_color) || !empty($changelog_bg_color) ) {
                        $dynamic_css .= ".changelog_content span.$change_type_class { $changelog_bg_color $changelog_color }";
                     }
                 }
             }

             // TOC post Title colors
             if ( !empty($toc_titles) ) {
                 foreach ( $toc_titles as $ti => $toc_title ) {
                     $ti = $ti + 1;
                     if ( !empty($toc_title['color']) ) {
                         $dynamic_css .= ".tip_banner_area .col-lg-4:nth-child($ti) .tip_title {color: {$toc_title['color']} !important;}";
                     }
                 }
             }

             // Post Banner Overlay Color
            $banner_overlay_color = get_field('banner_overlay_color');
            if ( !empty($banner_overlay_color) ) {
                $dynamic_css .= "section.tip_banner_area::before { background-color: $banner_overlay_color; }";
            }
         }

         if ( !empty($opt['accent_solid_color_opt']) ) {

            $brand_color_rgb = $this->hex2rgba($opt['accent_solid_color_opt']);
            $dynamic_css .= ":root { --brand_color_rgb: $brand_color_rgb; }";

            $brand_color_dark = !empty($opt['brand_color_dark']) ? $this->hex2rgba($opt['brand_color_dark']) : '';
            $dynamic_css .= !empty($opt['brand_color_dark']) ? "body.body_dark { --brand_color_rgb: $brand_color_dark; }" : '';

            // background 0.05
            $dynamic_css .= ".categories_guide_item .doc_border_btn { background: rgba(var(--brand_color_rgb), 0.05); }";
            // background 0.2
            $dynamic_css .= ".pagination-wrapper .page-numbers:not(.current):hover, #bbpress-forums .bbp-single-user-details #bbp-user-navigation li:not(.current) a:hover, .more a:hover, .tip_doc_area .left_sidebarlist .nav-sidebar::before, .question_menu.docs3 .nav li a:not(.active):hover, .doc_tag .nav-item .nav-link:not(.active):hover { background: rgba(var(--brand_color_rgb), 0.2) !important; }";
            // background 0.6
            $dynamic_css .= ".direction_step{ background: rgba(var(--brand_color_rgb), 0.6); }";
            // background 0.7
            $dynamic_css .= ".single_post_tags.post-tags a:hover{ background: rgba(var(--brand_color_rgb), 0.7); }";
            // background 0.8
            $dynamic_css .= ".header_search_keyword ul li a.has-bg:hover, .fill-brand { background: rgba(var(--brand_color_rgb), 0.8); }";

            // color 0.6
            $dynamic_css .= ".direction_step + .direction_step:before{ color: rgba(var(--brand_color_rgb), 0.6); }";

            // Box Shadow 0.24
            $btn_shadow_class = '.categories_guide_item .doc_border_btn:hover, .all_doc_btn:hover';
            $dynamic_css .= "$btn_shadow_class { box-shadow: 0 20px 30px 0 rgba(var(--brand_color_rgb), 0.24); }";

            // Border Color 0.2
            $dynamic_css .= ".categories_guide_item .doc_border_btn, .search-banner-light .header_search_keyword ul li a, .doc_tag .nav-item .nav-link { border-color: rgba(var(--brand_color_rgb), 0.2); }";
            // Border Color 0.3
            $dynamic_css .= ".pagination .page-numbers { border-color: rgba(var(--brand_color_rgb), 0.3); }";
            // Border Color 0.4
            $dynamic_css .= ".editor-content a, .forum-post-content .content a { text-decoration-color: rgba(var(--brand_color_rgb), 0.4);}";
        }
        
        $is_box_shadow = $opt['is_box_shadow'] ?? '';
        if ( $is_box_shadow != '1' ) {
            $dynamic_css .= "
            #bbpress-forums #new-post > fieldset.bbp-form,
            .main-post, .all-answers, .bbp-reply-form, .search-main, #comments, .blog_comment_box, .bb-radius, .doc_subscribe_inner {
                 box-shadow: none;
            }";
         }

        wp_add_inline_style( $handle, $dynamic_css );
     }

     /**
     * Pagination
     **/
    function pagination() {
        the_posts_pagination(array(
            'screen_reader_text' => ' ',
            'prev_text'          => '<i class="arrow_carrot-left"></i>',
            'next_text'          => '<i class="arrow_carrot-right"></i>'
        ));
    }

    /**
    * Day link to archive page
    **/
    function day_link() {
        $archive_year   = get_the_time( 'Y' );
        $archive_month  = get_the_time( 'm' );
        $archive_day    = get_the_time( 'd' );
        echo get_day_link( $archive_year, $archive_month, $archive_day);
    }

    /**
     * Post's excerpt text
     * @param $settings_key
     * @param bool $echo
     * @return string
     **/
    function excerpt( $settings_key, $echo = true ) {
        $opt = get_option( 'docy_opt' );
        $blog_layout = !empty( $_GET['blog_layout'] ) ? $_GET['blog_layout'] : (!empty( $opt['blog_layout'] ) ? $opt['blog_layout'] : 'list');
        $excerpt_limit = !empty( $opt[$settings_key] ) ? $opt[$settings_key] : 40;
        if ( $blog_layout == 'grid' || $blog_layout == 'blog_category' ) {
            $excerpt_limit = 15;
        }
        $post_excerpt = get_the_excerpt();
        $excerpt = (strlen(trim($post_excerpt)) != 0) ? wp_trim_words(get_the_excerpt(), $excerpt_limit, '') : wp_trim_words(get_the_content(), $excerpt_limit, '');
        if(  $echo == true ) {
            echo wp_kses_post(wpautop($excerpt));
        } else {
            return wp_kses_post(wpautop($excerpt));
        }
    }

    /**
     * Post author avatar
     **/
     function post_author_avatar( $size = 30, $default = '', $alt = '', $args = null ) {
         $post_author_id = get_post_field( 'post_author', get_the_ID() );
         echo get_avatar($post_author_id, $size, $default, $alt, $args);
     }

    /**
    * Get the first category name
    * @param string $term
    */
    function first_category($term = 'category') {
        $cats = get_the_terms(get_the_ID(), $term);
        $cat  = is_array($cats) ? $cats[0]->name : '';
        echo esc_html($cat);
    }

    /**
    * Get the first category link
    * @param string $term
    */
    function first_category_link($term='category') {
        $cats = get_the_terms(get_the_ID(), $term);
        $cat  = is_array($cats) ? get_category_link($cats[0]->term_id) : '';
        echo esc_url($cat);
    }

    /**
     * Limit latter
    * @param $string
    * @param $limit_length
    * @param string $suffix
     */
    function limit_latter($string, $limit_length, $suffix = '...' ) {
        if (strlen($string) > $limit_length) {
            echo strip_shortcodes(substr($string, 0, $limit_length) . $suffix);
        }
        else {
            echo strip_shortcodes(esc_html($string));
        }
    }

    /**
    * Doc Layout
    * @return mixed|string
    */
    function doc_layout() {
        $opt = get_option('docy_opt' );
        $page_doc_layout = function_exists('get_field') ? get_field('doc_layout') : 'default';
        if ( $page_doc_layout == 'default' || $page_doc_layout == '' ) {
            $doc_layout = !empty($opt['doc_layout']) ? $opt['doc_layout'] : 'both_sidebar';
        } else {
            $doc_layout = $page_doc_layout;
        }

        return $doc_layout;
    }

    function page_width() {
        $page_doc_width = function_exists('get_field') ? get_field('doc_width') : 'default';
        if ( $page_doc_width == 'default' || $page_doc_width == '' ) {
            $header_width = docy_opt('header_width', 'boxed');
        } else {
            $header_width = $page_doc_width;
        }

        return $header_width;
    }

    /**
    * Image from Theme Settings
    * @param $settins_key
    * @param string $class
    * @param string $alt
    */
    function image_from_settings( $settings_key = '', $class = '', $alt = '' ) {
        $opt = get_option('docy_opt' );
        $page_image = function_exists('get_field') ? get_field($settings_key) : '';
        $sett_image = !empty($opt[$settings_key]) ? $opt[$settings_key] : '';
        $image = $page_image == '' ? $sett_image : $page_image;
        if ( !empty($image['id']) ) {
            echo wp_get_attachment_image($image['id'], 'full', '', array('class' => $class));
        }
        elseif ( !empty($image['url']) && empty($image['id']) ) {
            $class = !empty($class) ? "class='$class'" : '';
            echo "<img src='{$image['url']}' $class alt='$alt'>";
        }
    }
}


/**
 * Instance of Docy_Helper_Class class
 */
function Docy_helper() {
    return Docy_Helper_Class::instance();
}