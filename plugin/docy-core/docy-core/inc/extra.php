<?php

add_image_size( 'docy_370x300', 370, 300, true); // Screenshot carousel style 6
add_image_size( 'docy_70x70', 70, 70, true); // Recent posts thumbnail
add_image_size( 'docy_16x16', 16, 16, true); // Forums list widget forum thumbnail image
add_image_size( 'docy_60x40', 60, 40, true); // Forums list widget forum thumbnail image
add_image_size( 'docy_270x152', 270, 152, true); // Forums list widget forum thumbnail image
add_image_size( 'docy_671x411', 671, 411, true); // Video Carousel Thumb Single
add_image_size( 'docy_40x40', 40, 40, true); // Forum user image

/**
 * Elementor URL field output
 * @param $settings_key
 * @param bool $echo
 * @return string
 */
function docy_el_btn( $settings_key, $echo = true ) {
    if ( $echo == true ) {
        echo $settings_key['is_external'] == true ? 'target="_blank"' : '';
        echo $settings_key['nofollow'] == true ? 'rel="nofollow"' : '';
        echo !empty($settings_key['url']) ? 'href="'.esc_url($settings_key['url']).'"' : '';
    } else {
        $output = $settings_key['is_external'] == true ? 'target="_blank"' : '';
        $output .= $settings_key['nofollow'] == true ? 'rel="nofollow"' : '';
        $output .= !empty($settings_key['url']) ? 'href="'.esc_url($settings_key['url']).'"' : '';
        return $output;
    }
}

// Icon Array
function docy_icon_array($k, $replace = 'icon', $separator = '-') {
    $v = array();
    foreach ( $k as $kv ) {
        $kv = str_replace($separator, ' ', $kv);
        $kv = str_replace($replace, '', $kv);
        $v[] = array_push($v, ucwords($kv));
    }
    foreach($v as $key => $value) if($key&1) unset($v[$key]);
    return array_combine($k, $v);
}


// Social Share
function docy_social_share() { ?>
    <div class="social_icon">
        <?php esc_html_e( 'share:', 'docy-core') ?>
        <ul class="list-unstyled">
            <li><a href="https://facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="social_facebook"></i></a></li>
            <li><a href="https://twitter.com/intent/tweet?text=<?php the_permalink(); ?>"><i class="social_twitter"></i></a></li>
            <li><a href="https://www.pinterest.com/pin/create/button/?url=<?php the_permalink() ?>"><i class="social_pinterest"></i></a></li>
            <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>"><i class="social_linkedin"></i></a></li>
        </ul>
    </div>
    <?php
}


// Docy post share
function docy_post_share(){ ?>
    <div class="docy-share meta-item">
        <a href="javascript:void(0);" class="docy-share-btn" data-bs-toggle="modal" data-bs-target="#docy_share">
            <ion-icon name="share"></ion-icon><?php esc_html_e( 'Share', 'docy-core' ); ?>
        </a>
    </div>                
    <div class="modal fade" id="docy_share" tabindex="-3" role="dialog" aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a class="close" data-bs-dismiss="modal"> <i class=" icon_close"></i> </a>
                <div class="docy-share-wrap">
                    <h2> <?php the_title(); ?> </h2>
                    <div class="social-links">
                        <a href="mailto:?subject=<?php the_title(); ?>&amp;body= <?php esc_html_e('Check out this doc: ', 'docy-core'); the_permalink(); ?>" target="_blank"><i class="icon_mail"></i></a>
                        <a href="https://www.facebook.com/share.php?u=<?php the_permalink(); ?>"><i class="social_facebook_circle"></i></a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>"><i class="social_linkedin_square"></i></a>
                        <a href="https://twitter.com/share?url=<?php the_permalink(); ?>&amp;text=<?php the_title(); ?> &amp;hashtags=<?php echo site_url(); ?>"><i class="social_twitter"></i></a>
                    </div>
                    <?php echo wpautop( 'Or copy link' ); ?>
                    <div class="copy-url-wrap"> 
                        <input readonly type="text" value="<?php the_permalink(); ?>" class="word-wrap">
                        <div class="share-this-doc" data-success-message="success">
                            <img src="<?php echo DOCY_DIR_IMG ?>/clone.svg" alt="<?php esc_attr_e( 'Clipboard Icon', 'docy-core' ); ?>">
                        </div>
                    </div>                        
                </div>                    
            </div>
        </div>
    </div>
<?php }


add_filter( 'gettext','docy_enter_title');
function docy_enter_title( $input ) {
    global $post_type;
    if( is_admin() && 'Enter title here' == $input && 'team' == $post_type )
        return 'Enter here the team member name';
    return $input;
}

// Category array
function docy_cat_array($term = 'category') {
    $cats = get_terms( array(
        'taxonomy' => $term,
        'hide_empty' => true
    ));
    $cat_array = array();
    $cat_array['all'] = esc_html__( 'All', 'docy-core');
    foreach ($cats as $cat) {
        $cat_array[$cat->slug] = $cat->name;
    }
    return $cat_array;
}

/**
 * Make slug text
 */
function docy_get_slug( $text ) {
	// replace non letter or digits by -
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);

	// transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);

	// trim
	$text = trim($text, '-');

	// remove duplicate -
	$text = preg_replace('~-+~', '-', $text);

	// lowercase
	$text = strtolower($text);

	if (empty($text)) {
		return 'n-a';
	}

	return $text;
}

/**
 * Limit latter
 * @param $string
 * @param $limit_length
 * @param string $suffix
 */
function docy_core_limit_latter( $string, $limit_length, $suffix = '...' ) {
    if ( strlen($string) > $limit_length ) {
        echo strip_shortcodes(substr($string, 0, $limit_length) . $suffix);
    } else {
        echo strip_shortcodes(esc_html($string));
    }
}

/**
 * Social Links
 */
function docycore_social_links() {
    $opt = get_option( 'docy_opt' );
    ?>
    <?php if( !empty($opt['facebook'])) { ?>
        <li> <a href="<?php echo esc_url($opt['facebook']); ?>"><i class="social_facebook" aria-hidden="true"></i></a> </li>
    <?php } ?>

    <?php if( !empty($opt['twitter'])) { ?>
        <li> <a href="<?php echo esc_url($opt['twitter']); ?>"><i class="social_twitter" aria-hidden="true"></i></a> </li>
    <?php } ?>

    <?php if( !empty($opt['instagram'])) { ?>
        <li> <a href="<?php echo esc_url($opt['instagram']); ?>"><i class="social_instagram" aria-hidden="true"></i></a> </li>
    <?php } ?>

    <?php if( !empty($opt['linkedin'])) { ?>
        <li> <a href="<?php echo esc_url($opt['linkedin']); ?>"><i class="social_linkedin" aria-hidden="true"></i></a> </li>
    <?php } ?>

    <?php if( !empty($opt['youtube'])) { ?>
        <li> <a href="<?php echo esc_url($opt['youtube']); ?>"><i class="social_youtube" aria-hidden="true"></i></a> </li>
    <?php } ?>

    <?php if( !empty($opt['github'])) { ?>
        <li> <a href="<?php echo esc_url($opt['github']); ?>"><i class="social_github" aria-hidden="true"></i></a> </li>
    <?php } ?>

    <?php if( !empty($opt['dribbble'])) { ?>
        <li> <a href="<?php echo esc_url($opt['dribbble']); ?>"><i class="social_dribbble" aria-hidden="true"></i></a> </li>
    <?php }
}

/**
 * Day link to archive page
 **/
function docycore_day_link() {
    $archive_year   = get_the_time( 'Y' );
    $archive_month  = get_the_time( 'm' );
    $archive_day    = get_the_time( 'd' );
    echo get_day_link( $archive_year, $archive_month, $archive_day);
}

/**
 * Post Share Options
 */
function docycore_social_share() {
	$opt = get_option('docy_opt' );
	$is_social_share = isset($opt['is_social_share']) ? $opt['is_social_share'] : '';
	if ( $is_social_share == '1' ) :
		?>
        <div class="blog_social text-center">
			<?php if ( !empty($opt['share_title']) ) : ?>
                <h5><?php echo wp_kses_post($opt['share_title']) ?></h5>
			<?php endif; ?>
            <ul class="list-unstyled f_social_icon">
                <li><a href="https://facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="social_facebook"></i></a></li>
                <li><a href="https://twitter.com/intent/tweet?text=<?php the_permalink(); ?>" target="_blank"><i class="social_twitter"></i></a></li>
                <li><a href="https://www.pinterest.com/pin/create/button/?url=<?php the_permalink() ?>" target="_blank"><i class="social_pinterest"></i></a></li>
                <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>" target="_blank"><i class="social_linkedin"></i></a></li>
            </ul>
        </div>
	<?php
	endif;
}


// Arrow icon left right position
function docycore_arrow_left_right() {
    $arrow_icon = is_rtl() ? 'arrow_left' : 'arrow_right';
    echo esc_attr($arrow_icon);
}


/**
 * Elementor Title tags
 */
function docy_el_title_tags() {
    return [
        'h1'  => __( 'H1', 'docy-core' ),
        'h2' => __( 'H2', 'docy-core' ),
        'h3' => __( 'H3', 'docy-core' ),
        'h4' => __( 'H4', 'docy-core' ),
        'h5' => __( 'H5', 'docy-core' ),
        'h6' => __( 'H6', 'docy-core' ),
        'div' => __( 'Div', 'docy-core' ),
        'span' => __( 'Span', 'docy-core' ),
        'p' => __( 'Paragraph', 'docy-core' ),
    ];
}


/**
 * Get Default Image Elementor
 * @param $settins_key
 * @param string $class
 * @param string $alt
 */
function docy_el_image( $settings_key = '', $alt = '', $class = '', $atts = [] ) {
    if ( !empty($settings_key['id']) ) {
        echo wp_get_attachment_image( $settings_key['id'], 'full', '', array('class' => $class) );
    }
    elseif ( !empty($settings_key['url']) && empty($settings_key['id']) ) {
        $class = !empty($class) ? "class='$class'" : '';
        $attss = '';
        //echo print_r($atts);
        if ( !empty($atts) ) {
            foreach ( $atts as $k => $att ) {
                $attss .= "$k=". "'$att'";
            }
        }
        echo "<img src='{$settings_key['url']}' $class alt='$alt' $attss>";
    }
}

/**
 * Docs array
 *
 * @param string Post Type
 */
function docy_get_posts( $post_type = 'docs' ) {
    $docs  = get_pages(
        array(
            'post_type' => $post_type,
            'parent' => 0,
        ));
    $docs_array = [];
    if ( $docs ) {
        foreach ($docs as $doc) {
            $docs_array[$doc->ID] = $doc->post_title;
        }
    }

    return $docs_array;
}

function docy_get_faq_categories(){
    $opt            = get_option( 'docy_opt' ) ;
    $faq_posttype 	= $opt['faq'] ?? '';

    if ($faq_posttype != 1 ) {
        return false;
    }

        $cats = get_terms(
            array(
                'taxonomy'      => 'faq_cat',
                'hide_empty'    => true,
                'orderby'       => 'name',
                'order'         => 'ASC'
            )
        );

        $cats_array = [];
        foreach ($cats as $cat) {
            $cats_array[$cat->term_id] = $cat->name;
        }
        return $cats_array;
    

}


/**
 * @param string $post_type
 * @param int $limit
 * @param string $search
 * @return array
 */
function docy_get_query_post_list($post_type = 'any', $limit = -1, $search = '') {
    global $wpdb;
    $where = '';
    $data = [];

    if (-1 == $limit) {
        $limit = '';
    } elseif (0 == $limit) {
        $limit = "limit 0,1";
    } else {
        $limit = $wpdb->prepare(" limit 0,%d", esc_sql($limit));
    }

    if ('any' === $post_type) {
        $in_search_post_types = get_post_types(['exclude_from_search' => false]);
        if (empty($in_search_post_types)) {
            $where .= ' AND 1=0 ';
        } else {
            $where .= " AND {$wpdb->posts}.post_type IN ('" . join("', '",
                    array_map('esc_sql', $in_search_post_types)) . "')";
        }
    } elseif (!empty($post_type)) {
        $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_type = %s", esc_sql($post_type));
    }

    if (!empty($search)) {
        $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", '%' . esc_sql($search) . '%');
    }

    $query = "select post_title,ID  from $wpdb->posts where post_status = 'publish' $where $limit";
    $results = $wpdb->get_results($query);
    if (!empty($results)) {
        foreach ($results as $row) {
            $data[$row->ID] = $row->post_title;
        }
    }
    return $data;
}

/**
 * Get all elementor page templates
 *
 * @param  null  $type
 *
 * @return array
 */
function docy_get_el_templates($type = null)
{
    $options = [];

    if ($type) {
        $args = [
            'post_type' => 'elementor_library',
            'posts_per_page' => -1,
        ];
        $args['tax_query'] = [
            [
                'taxonomy' => 'elementor_library_type',
                'field' => 'slug',
                'terms' => $type,
            ],
        ];

        $page_templates = get_posts($args);

        if (!empty($page_templates) && !is_wp_error($page_templates)) {
            foreach ($page_templates as $post) {
                $options[$post->ID] = $post->post_title;
            }
        }
    } else {
        $options = docy_get_query_post_list('elementor_library');
    }

    return $options;
}

/**
 * Post order order by
 */
function docy_order_by() {
    $orderby = [
        'none' => esc_html__('None', 'docy-core'),
        'ID' => esc_html__('ID', 'docy-core'),
        'author' => esc_html__('Author', 'docy-core'),
        'title' => esc_html__('Title', 'docy-core'),
        'name' => esc_html__('Name', 'docy-core'),
        'type' => esc_html__('Type', 'docy-core'),
        'date' => esc_html__('Date', 'docy-core'),
        'modified' => esc_html__('Modified', 'docy-core'),
        'parent' => esc_html__('Parent', 'docy-core'),
        'rand' => esc_html__('Random', 'docy-core'),
        'comment_count' => esc_html__('Comment Count', 'docy-core'),
        'relevance' => esc_html__('Relevance', 'docy-core'),
        'menu_order' => esc_html__('Menu Order', 'docy-core'),
    ];

    return $orderby;
}

/**
 * Changelog Post Type Title Placeholder
 * @param $title
 * @return mixed|string
 */
function docycore_changelog_title_placeholder( $title ){
    $screen = get_current_screen();
    if ( 'changelog' == $screen->post_type ){
        $title = esc_html__( 'Add Version', 'docy-core' );
    }

    return $title;
}
add_filter( 'enter_title_here', 'docycore_changelog_title_placeholder' );


// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
    global $wp_version;

    if ( $wp_version !== '4.7.1' ) {
        return $data;
    }
    $filetype = wp_check_filetype( $filename, $mimes );
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];

}, 10, 4 );

function docycore_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'docycore_mime_types' );

function docycore_fix_svg() {
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'docycore_fix_svg' );

/**
 * Post's excerpt text
 * @param $settings_key
 * @param bool $echo
 * @return string
 **/
function docycore_excerpt($settings_key, $limit = 10) {
    echo wp_trim_words( wpautop( get_the_excerpt( $settings_key ) ), $limit, '');
}

/**
 * Category IDs
 * @return array
 */
function docy_cat_ids(){
    $taxonomys = get_terms( array(
        'taxonomy' => 'category',
        'hide_empty' => true,
    ) );
    $taxonomy = [];
    foreach( $taxonomys as $cat_id){
        $taxonomy[$cat_id->term_id]= $cat_id->name;    
    }

    return $taxonomy;
}

/**
 * @param string $content
 * @return string all shortcodes from content
 */
function docy_all_shortcodes($content) {
    $return = array();
    preg_match_all( '/' . get_shortcode_regex() . '/', $content, $shortcodes, PREG_SET_ORDER );
    if (!empty($shortcodes)) {
        foreach ($shortcodes as $shortcode) {
            $return[] 	= $shortcode;
            $return 	= array_merge($return, docy_all_shortcodes($shortcode[5]));
        }
    }
    return $return;
}