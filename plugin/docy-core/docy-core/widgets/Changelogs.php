<?php
namespace DocyCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use WP_Query;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Changelog
 * @package DocyCore\Widgets
 */
class Changelogs extends Widget_Base {
    public function get_name() {
        return 'docy_changelog';
    }

    public function get_title() {
        return esc_html__( 'Changelogs', 'docy-hero' );
    }

    public function get_icon() {
        return 'eicon-history';
    }

    public function get_categories() {
        return [ 'docy-elements' ];
    }

    protected function register_controls() {
        // ---------------------------------- Filter Options ------------------------
        $this->start_controls_section(
            'filter', [
                'label' => esc_html__( 'Filter Options', 'docy-core' ),
            ]
        );

        $this->add_control(
            'ppp', [
                'label' => esc_html__( 'Show Changelogs', 'docy-core' ),
                'type' => Controls_Manager::NUMBER,
                'label_block' => true,
                'default' => 10
            ]
        );

        // Get changelog_cat terms name
        $terms = get_terms( array(
            'taxonomy' => 'changelog_cat',
            'hide_empty' => false,
        ) );

        // Pluck terms name
        $terms_name = wp_list_pluck( $terms, 'name', 'term_id' );

        $this->add_control(
            'cat', [
                'label' => esc_html__( 'Category', 'docy-core' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => $terms_name,
            ]
        );

        $this->add_control(
            'order', [
                'label' => esc_html__( 'Order', 'docy-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => 'ASC',
                    'DESC' => 'DESC'
                ],
                'default' => 'ASC'
            ]
        );

        $this->add_control(
            'orderby', [
                'label' => esc_html__( 'Order By', 'docy-core' ),
                'type' => Controls_Manager::SELECT2,
                'options' => docy_order_by(),
                'default' => 'date'
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $tax_query = !empty( $settings['cat'] ) ? array(
            array(
                'taxonomy' => 'changelog_cat',
                'field' => 'id',
                'terms' => $settings['cat'],
            ),
        ) : '';

        $posts = new WP_Query([
            'posts_per_page' => !empty($settings['ppp']) ? $settings['ppp'] : -1,
            'post_type'      => 'changelog',
            'order'          => $settings['order'],
            'orderby'        => $settings['orderby'],
            'tax_query'      => $tax_query,
        ]);
        ?>
        <div class="changelog_inner">

            <?php
            while ( $posts->have_posts() ) : $posts->the_post();
                $release_title = function_exists('get_field') ? get_field('release_title') : '';
                $date_of_release = function_exists('get_field') ? get_field('date_of_release') : '';
                $changes = function_exists('get_field') ? get_field('changes') : '';
                $has_downloadable_file = function_exists('get_field') ? get_field('has_downloadable_file') : '';
                $single_file = function_exists('get_field') ? get_field('single_file') : '';
                $package_file = function_exists('get_field') ? get_field('package_file') : '';

                $single_file_label = function_exists('get_field') ? get_field('single_file_label', 'option') : '';
                $single_file_label = !empty($single_file_label) ? $single_file_label : esc_html__('Zip', 'docy-core');
                $package_file_label = function_exists('get_field') ? get_field('package_file_label', 'option') : '';
                $package_file_label = !empty($package_file_label) ? get_field('package_file_label', 'option') : esc_html__('Download', 'docy-core');
                $change_types = function_exists('get_field') ? get_field('change_types', 'option') : '';
                ?>
                <div class="row changelog_info" id="v-<?php echo get_post_field( 'post_name', get_post() ); ?>" title="<?php the_title_attribute() ?>">
                    <div class="col-lg-3 changelog_date">
                        <div class="c_date">
                            <?php if ( $date_of_release ) : ?>
                                <h6><?php echo esc_html($date_of_release) ?></h6>
                            <?php endif; ?>
                            <?php echo !empty($release_title) ? wpautop($release_title) : ''; ?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="version_info">
                            <div class="c_version">
                                <?php the_title() ?>
                            </div>
                            <div class="line bottom_half"></div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="changelog_content">
                            <?php
                            if ( !empty($changes) ) :
                                foreach ( $changes as $change ) :
                                    $change_type_class = function_exists('docy_get_slug') && $change['change_type'] ? docy_get_slug($change['change_type']) : '';
                                    if ( !empty($change['title']) ) :
                                        ?>
                                        <p>
                                            <?php if ( !empty($change['change_type']) ) : ?>
                                                <span class="<?php echo $change_type_class ?>">
                                                    <?php echo esc_html($change['change_type']) ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php echo $change['title']; ?>
                                        </p>
                                        <?php
                                    endif;
                                endforeach;
                            endif;
                            ?>
                            <?php if ( $has_downloadable_file == '1' ) : ?>
                                <div class="download-links">
                                    <?php if ( !empty($single_file) ) : ?>
                                        <a href="<?php echo $single_file; ?>" class="changelog_btn">
                                            <i class="icon_document_alt"></i> <?php echo $single_file_label; ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ( !empty($package_file) ) : ?>
                                        <a href="<?php echo $package_file ?>" class="changelog_btn">
                                            <i class="icon_cloud-download_alt"></i> <?php echo $package_file_label; ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
        <?php
    }

}