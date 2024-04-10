<?php

    $videos = new \WP_Query(array(
        'post_type' => 'video',
        'posts_per_page' => !empty(get_field('video_spl')) ? get_field('video_spl') : -1,
    ));

    $cats = get_terms( array (
        'taxonomy' => 'video_cat',
        'hide_empty' => true
    ));



?>

<section class="video_list_area p_125 video-playlist">
    <div class="container">
        <div class="row justify-content-sm-between">
            <div class="col-lg-7">
                <div class="tab-content video_tabs" id="myTabContent2">
                    <?php
                    $i = 0;
                    while ( $videos->have_posts() ) : $videos->the_post();
                        $active = ($i == 0) ? 'show active' : '';
                        ?>
                        <div class="tab-pane fade <?php echo esc_attr($active) ?>" id="video<?php the_ID(); ?>" role="tabpanel" aria-labelledby="video<?php the_ID(); ?>-tab">
                            <div class="artplayer-app<?php the_ID(); ?>"></div>
                        </div>
                        <?php
                        ++$i;
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="video_list">
                    <?php
                    if(get_field('video_h_tag') == 'video_h1_tag'){
                        $tag = 'h1';
                    }
                    if(get_field('video_h_tag') == 'video_h2_tag'){
                        $tag = 'h2';
                    }
                    if(get_field('video_h_tag') == 'video_h3_tag'){
                        $tag = 'h3';
                    }
                    if(get_field('video_h_tag') == 'video_h4_tag'){
                        $tag = 'h4';
                    }
                    if(get_field('video_h_tag') == 'video_h5_tag'){
                        $tag = 'h5';
                    }
                    if(get_field('video_h_tag') == 'video_h6_tag'){
                        $tag = 'h6';
                    }
                    echo !empty(get_field('video_tt')) ? sprintf('<%1$s class="title" data-animation="wow fadeInUp" data-wow-delay="0.2s"> %2$s </%1$s>', $tag, nl2br(get_field('video_tt'))) : '';
                    ?>
                    <div class="video_list_inner scroll">
                        <div class="accordion" id="accordionExample">
                            <?php
                            foreach ( $cats as $index => $cat ) :
                                $cat_videos_i = 0;
                                $cat_videos = new \WP_Query( array (
                                    'post_type' => 'video',
                                    'posts_per_page' => -1,
                                    'tax_query' => array (
                                        array(
                                            'taxonomy' => 'video_cat',
                                            'field'    => 'slug',
                                            'terms'    => $cat->slug,
                                        ),
                                    ),
                                ));

                                $cat_videos_count = $cat_videos_i < 10 ? '0'.$cat_videos->post_count : $cat_videos->post_count;

                                $tab_count = $index + 1;
                               // $tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', '', $index );
                                $cat_coll = $tab_count == 1 ? '' : 'collapsed';
                               /* $this->add_render_attribute( $tab_content_setting_key, [
                                    'class' => [ 'btn btn-link btn-block text-left', $cat_coll ],
                                    'data-toggle' => 'collapse',
                                    'data-target' => '#'.$cat->slug,
                                    'aria-expanded' => $index == 0 ? 'true' : 'false',
                                    'aria-controls' => $cat->slug,
                                    'type' => 'button'
                                ]);*/
                                ?>
                                <div class="card">
                                    <div class="card-header" id="<?php echo esc_attr($cat->slug.'-tab') ?>">
                                        <button class="btn btn-link btn-block text-left <?php echo $cat_coll; ?>" type="button" data-toggle="collapse"
                                                data-target="#<?php echo $cat->slug; ?>" aria-controls="<?php echo $cat->slug; ?>">

                                            <span class="title"> <?php echo $cat->name; ?> </span>
                                            <span class="count">(<?php echo $cat_videos_count; ?>)</span>
                                            <span class="plus-minus">
                                                <i class="icon_plus"></i>
                                                <i class="icon_minus-06"></i>
                                            </span>
                                        </button>
                                    </div>

                                    <div id="<?php echo $cat->slug; ?>" class="collapse <?php echo $index == 0 ? 'show' : '' ?>" aria-labelledby="<?php echo $cat->slug.'-tab'; ?>" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <?php
                                                while ( $cat_videos->have_posts() ) : $cat_videos->the_post();
                                                    $active = $cat_videos_i == 0 && $index == 0 ? ' active' : '';
                                                    ?>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link<?php echo $active; ?>" id="video<?php the_ID(); ?>-tab" data-toggle="tab" href="#video<?php the_ID(); ?>" role="tab" aria-controls="video<?php the_ID(); ?>" aria-selected="true">
                                                            <div class="media d-flex">
                                                                <?php if ( has_post_thumbnail(get_the_ID()) ) : ?>
                                                                    <div class="d-flex">
                                                                        <div class="video_tab_img">
                                                                            <?php the_post_thumbnail('docy_60x40'); ?>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="media-body">
                                                                    <h4><?php the_title() ?></h4>
                                                                    <div class="list">
                                                                        <div><ion-icon name="person-outline"></ion-icon> <?php the_author_meta('display_name'); ?> </div>
                                                                        <div><ion-icon name="calendar-clear-outline"></ion-icon> <?php the_time(get_option('date_format')); ?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <?php
                                                    ++$cat_videos_i;
                                                endwhile;
                                                wp_reset_postdata();
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    (function ($) {
        $(document).ready(function () {
            const list = [
                <?php
                while ( $videos->have_posts() ) : $videos->the_post();
                    $video = function_exists('get_field') ? get_field('video') : '';
                    ?>
                    {
                        className: ".artplayer-app<?php the_ID(); ?>",
                        url: "<?php echo esc_js($video['url']);  ?>",
                        title: "<?php the_title(); ?>",
                        poster: "<?php the_post_thumbnail_url(); ?>",
                    },
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            ];

            list.forEach(function (e) {
                var art = new Artplayer({
                    container: e.className,
                    url: e.url,
                    title: e.title,
                    poster: e.poster,
                    volume: 0.5,
                    muted: false,
                    autoplay: false,
                    pip: true,
                    autoSize: true,
                    autoMini: false,
                    screenshot: true,
                    setting: true,
                    loop: true,
                    flip: true,
                    rotate: true,
                    playbackRate: true,
                    aspectRatio: false,
                    fullscreen: true,
                    fullscreenWeb: true,
                    subtitleOffset: true,
                    miniProgressBar: true,
                    localVideo: true,
                    localSubtitle: true,
                    networkMonitor: false,
                    mutex: true,
                    light: true,
                    backdrop: true,
                    isLive: false,
                    theme: "#10b3d6",
                    lang: navigator.language.toLowerCase(),
                    // moreVideoAttr: {
                    //   crossOrigin: "anonymous",
                    // },
                    contextmenu: [
                        {
                            html: "Custom menu",
                            click: function (contextmenu) {
                                console.info("You clicked on the custom menu");
                                contextmenu.show = false;
                            },
                        },
                    ],
                    controls: [
                        {
                            position: "right",
                            html: "Control",
                            index: 10,
                            click: function () {
                                console.info("You clicked on the custom control");
                            },
                        },
                    ],
                    icons: {
                        loading: '<img src="<?php echo plugins_url('inc/video-playlist/images/ploading.gif', __FILE__); ?>">',
                        state: '<ion-icon name="play"></ion-icon>',
                    },
                });
            });

            $(document).on("click", function (e) {
                var el = e.target.nodeName,
                    parent = e.target.parentNode;
                if (
                    (el === "path" && videoControlClassCheck(parent.parentNode)) ||
                    (el === "svg" && videoControlClassCheck(parent))
                ) {
                    jQuery(".video_list_area").toggleClass("theatermode");
                }
            });

            function videoControlClassCheck(parent) {
                return parent.className.indexOf("art-icon-fullscreenWeb") !== -1;
            }
        })
    })(jQuery);
</script>