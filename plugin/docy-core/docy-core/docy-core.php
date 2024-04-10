<?php
/**
 * Plugin Name: Docy Core
 * Plugin URI: https://themeforest.net/user/spider-themes/portfolio
 * Description: This plugin adds the core features to the Docy WordPress theme. You must have to install this plugin to get all the features included with the Docy theme.
 * Version: 3.1.8
 * Author: spider-themes
 * Author URI: https://themeforest.net/user/spider-themes/portfolio
 * Text domain: docy-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Docy Core Directories
define( 'SC_IMAGES', plugins_url( 'widgets/images/', __FILE__ ) );

require_once __DIR__ . '/vendor/autoload.php';
define( 'DOCY_PATH', plugin_dir_path( __FILE__ ) );
define( 'DOCY_URL', plugin_dir_url( __FILE__ ) );


// Make sure the same class is not loaded twice in free/premium versions.
if ( ! class_exists( 'Docy_core' ) ) {
	/**
	 * Main Docy Core Class
	 *
	 * The main class that initiates and runs the Docy Core plugin.
	 */
	class Docy_core {
		/**
		 * Docy Core Version
		 *
		 * Holds the version of the plugin.
		 *
		 * @var string The plugin version.
		 */
		const VERSION = '1.0';

		/**
		 * Minimum Elementor Version
		 *
		 * Holds the minimum Elementor version required to run the plugin.
		 *
		 * @var string Minimum Elementor version required to run the plugin.
		 */
		const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

		/**
		 * Minimum PHP Version
		 *
		 * Holds the minimum PHP version required to run the plugin.
		 *
		 * @var string Minimum PHP version required to run the plugin.
		 */
		const  MINIMUM_PHP_VERSION = '7.4';

		/**
		 * Plugin's directory paths
		 * @since 1.0
		 */
		const CSS = null;
		const JS = null;
		const IMG = null;
		const VEND = null;

		/**
		 * Instance
		 *
		 * Holds a single instance of the `Docy_Core` class.
		 *
		 * @access private
		 * @static
		 *
		 * @var Docy_Core A single instance of the class.
		 */
		private static $_instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @access public
		 * @static
		 *
		 * @return Docy_Core An instance of the class.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Clone
		 *
		 * Disable class cloning.
		 *
		 * @access protected
		 *
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'docy-core' ), '1.7.0' );
		}

		/**
		 * Wakeup
		 *
		 * Disable unserializing the class.
		 *
		 * @access protected
		 *
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'docy-core' ), '1.7.0' );
		}

		/**
		 * Constructor
		 *
		 * Initialize the Docy Core plugins.
		 *
		 * @access public
		 */
		public function __construct() {
			$this->init_hooks();
			$this->core_includes();
			do_action( 'docy_core_loaded' );
			//add_action('plugins_loaded', [$this, 'pro_elements_integration']);
		}

		/**
		 * Integrate Pro elements
		 */
		public function pro_elements_integration(){
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			if ( is_plugin_active('pro-elements/pro-elements.php') || is_plugin_active('elementor-pro/elementor-pro.php') ) {
                return '';
			} else {
				require plugin_dir_path( __FILE__ ) . '/inc/third-party/pro-elements/pro-elements.php';
			}
		}

		/**
		 * Include Files
		 *
		 * Load core files required to run the plugin.
		 *
		 * @access public
		 */
		public function core_includes() {
			// Get option values from theme options

			// Extra functions
			require_once __DIR__ . '/inc/extra.php';
			//require_once __DIR__ . '/inc/notices.php';
			
            // Custom post types
			
			$opt 							= get_option( 'docy_opt' );
			$post_type_disable 				= $opt['post_type_disable'] ?? '';

			$mega_menu 						= $post_type_disable['mega_menu'] ?? '';
			$faq_posttype 					= $post_type_disable['faq'] ?? '';
			$video_posttype 				= $post_type_disable['video'] ?? '';
			$changelog_posttype 			= $post_type_disable['changelog'] ?? '';

			if ( $mega_menu == '1' ) {
				require_once __DIR__ . '/post-type/mega_menu.pt.php';
			}

			if ( $faq_posttype == '1' ) {
				require_once __DIR__ . '/post-type/faq.pt.php';
			}

			if ( $video_posttype == '1' ) {
				require_once __DIR__ . '/post-type/video.pt.php';
			}

			if ( $changelog_posttype == '1' ) {
				require_once __DIR__ . '/post-type/changelog.pt.php';
			}

			require_once __DIR__ . '/post-type/acf_meta.php';
			// Gutenberg Blocks
			require_once __DIR__ . '/blocks/_blocks.php';

			/**
			 * Register widget area.
			 *
			 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
			 */
			require_once __DIR__ . '/wp-widgets/widgets.php';

			// Elementor custom field icons
			require_once __DIR__ . '/inc/icons.php';

			// Shortcodes
			require_once __DIR__ . '/shortcodes/code.php';
			require_once __DIR__ . '/shortcodes/direction.php';
			require_once __DIR__ . '/shortcodes/tooltip.php';
			require_once __DIR__ . '/shortcodes/tags.php';
		}

		/**
		 * Init Hooks
		 *
		 * Hook into actions and filters.
		 *
		 * @access private
		 */
		private function init_hooks() {
			add_action( 'init', [ $this, 'i18n' ] );
			add_action( 'plugins_loaded', [ $this, 'init' ] );
		}

		/**
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 *
		 * @access public
		 */
		public function i18n() {
			load_plugin_textdomain( 'docy-core', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Init Docy Core
		 *
		 * Load the plugin after Elementor (and other plugins) are loaded.
		 *
		 * @access public
		 */
		public function init() {
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );

				return;
			}

			// Check for required Elementor version

			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );

				return;
			}

			// Check for required PHP version

			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );

				return;
			}

			add_filter( 'elementor/icons_manager/additional_tabs', [ $this, 'font_icons' ] );

			// Add new Elementor Categories
			add_action( 'elementor/init', [ $this, 'add_elementor_category' ] );

			// Register Widget Scripts
			add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_widget_scripts' ] );
			add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'register_widget_scripts' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

			// Register Widget Scripts
			add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_elementor_editor_styles' ] );
			add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_widget_styles' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_core_styles' ] );

			// Editor Styles
			add_action( 'enqueue_block_editor_assets', [ $this, 'gutenberg_editor_scripts' ] );
 
			add_action( 'admin_enqueue_scripts', [ $this, 'register_admin_styles'] );

			// Register New Widgets
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );

			add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets_to_translate_filter' ] );
		}

		/**
		 * Integrate WPML
		 */
		public function wpml_widgets_to_translate_filter( $widgets ) {
			require_once __DIR__ . '/wpml/WPML_Fields.php';

			return $widgets;
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have Elementor installed or activated.
		 *
		 * @access public
		 */
		public function admin_notice_missing_main_plugin() {
			$message = sprintf(
			/* translators: 1: Docy Core 2: Elementor */
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'docy-core' ),
				'<strong>' . esc_html__( 'Docy core', 'docy-core' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'docy-core' ) . '</strong>'
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required Elementor version.
		 *
		 * @access public
		 */
		public function admin_notice_minimum_elementor_version() {
			$message = sprintf(
			/* translators: 1: Docy Core 2: Elementor 3: Required Elementor version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'docy-core' ),
				'<strong>' . esc_html__( 'Docy Core', 'docy-core' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'docy-core' ) . '</strong>',
				self::MINIMUM_ELEMENTOR_VERSION
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required PHP version.
		 *
		 * @access public
		 */
		public function admin_notice_minimum_php_version() {
			$message = sprintf(
			/* translators: 1: Docy Core 2: PHP 3: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'docy-core' ),
				'<strong>' . esc_html__( 'Docy Core', 'docy-core' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'docy-core' ) . '</strong>',
				self::MINIMUM_PHP_VERSION
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/**
		 * Add new Elementor Categories
		 *
		 * Register new widget categories for Docy Core widgets.
		 *
		 * @since 1.0.0
		 * @since 1.7.1 The method moved to this class.
		 *
		 * @access public
		 */
		public function add_elementor_category() {
			\Elementor\Plugin::instance()->elements_manager->add_category( 'docy-elements', [
				'title' => __( 'Docy Elements', 'docy-core' ),
			], 1 );
		}

		/**
		 * Register Widget Styles
		 *
		 * Register custom styles required to run Docy Core.
		 *
		 * @access public
		 */
		public function enqueue_widget_styles() {
			wp_register_style( 'ionicons', 'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', '', '2.0.1' );
			wp_register_style( 'prism', plugins_url( 'assets/vendors/prism/prism.min.css', __FILE__ ) );
			wp_register_style( 'nice-select', plugins_url( 'assets/vendors/niceselectpicker/nice-select.css', __FILE__ ) );
			wp_register_style( 'simple-line-icon', plugins_url( 'assets/vendors/simple-line-icon/simple-line-icons.css', __FILE__ ) );
			wp_register_style( 'animated', plugins_url( 'assets/vendors/slick/animated.css', __FILE__ ) );
			wp_register_style( 'slick', plugins_url( 'assets/vendors/slick/slick.css', __FILE__ ) );
			wp_register_style( 'slick-theme', plugins_url( 'assets/vendors/slick/slick-theme.css', __FILE__ ) );
			wp_register_style( 'elegant-icon', plugins_url( 'assets/vendors/elegant-icon/style.css', __FILE__ ) );
			wp_register_style( 'video-js', plugins_url( 'assets/vendors/video/videojs.min.css', __FILE__ ) );
			wp_register_style( 'video-js-theaterMode', plugins_url( 'assets/vendors/video/videojs.theaterMode.css', __FILE__ ) );
		}
		
		/**
		 * Register scripts & styles
		 *
		 * @access public
		 */
		public function enqueue_core_styles(){
			//wp_enqueue_style( 'docy-core-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
			//wp_enqueue_script( 'docy-core-script', plugins_url( 'assets/js/scripts.js', __FILE__ ), array( 'jquery' ), false, true );
		}

		/**
		 * Register Widget Scripts
		 *
		 * Register custom scripts required to run Docy Core.
		 *
		 * @access public
		 */
		public function register_widget_scripts() {
			wp_register_script( 'ajax-chimp', plugins_url( 'assets/js/ajax-chimp.js', __FILE__ ), 'jquery', '1.0', true );
			wp_register_script( 'prism', plugins_url( 'assets/vendors/prism/prism.js', __FILE__ ), array( 'jquery' ), '1.17.1', true );
			wp_register_script( 'tooltipster', plugins_url( 'assets/vendors/tooltipster/js/tooltipster.bundle.min.js', __FILE__ ), array( 'jquery' ), '4.2.8', true );
			wp_register_script( 'parallaxie', plugins_url( 'assets/js/parallaxie.js', __FILE__ ), array( 'jquery' ), '0.5', true );
			wp_register_script( 'nice-select', plugins_url( 'assets/vendors/niceselectpicker/jquery.nice-select.min.js', __FILE__ ), 'jquery', '1.0', true );
			wp_register_script( 'floatThead', plugins_url( 'assets/js/jquery.floatThead.min.js', __FILE__ ), array( 'jquery' ), '2.1.4', true );
			wp_register_script( 'counterup', plugins_url( 'assets/vendors/counterup/jquery.counterup.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
			wp_register_script( 'waypoints', plugins_url( 'assets/vendors/counterup/jquery.waypoints.min.js', __FILE__ ), array( 'jquery' ), '4.0.1', true );
			wp_register_script( 'tweenmax', plugins_url( 'assets/js/TweenMax.min.js', __FILE__ ), array( 'jquery' ), '2.0.0', true );
			wp_register_script( 'wavify', plugins_url( 'assets/js/jquery.wavify.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
			wp_register_script( 'chart', plugins_url( 'assets/js/Chart.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
			wp_register_script( 'slick', plugins_url( 'assets/vendors/slick/slick.min.js', __FILE__ ), array( 'jquery' ), '1.9.0', true );
			wp_register_script( 'wow', plugins_url( 'assets/vendors/wow/wow.min.js', __FILE__ ), array( 'jquery' ), '1.9.0', true );
			wp_register_script( 'artplayer', plugins_url( 'assets/vendors/video/artplayer.js', __FILE__ ), array( 'jquery' ), '3.5.26', true );
			wp_register_script( 'mcustomscrollbar', plugins_url( 'assets/vendors/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js', __FILE__ ), array( 'jquery' ), '3.1.13', true );
			wp_register_script( 'parallax-scroll', plugins_url( 'assets/js/jquery.parallax-scroll.js', __FILE__ ), array( 'jquery' ), '3.1.13', true );
			wp_register_script( 'video-js', plugins_url( 'assets/vendors/video/video.min.js', __FILE__ ), array( 'jquery' ), '7.6.0', true );
			wp_register_script( 'video-js-nuevo', plugins_url( 'assets/vendors/video/nuevo.min.js', __FILE__ ), array( 'jquery' ), '7.6.0', true );
		}

		public function enqueue_elementor_editor_styles() {
			wp_enqueue_style( 'docy-elementor-editor', plugins_url( 'assets/css/elementor-editor.css', __FILE__ ) );
		}

		public function enqueue_scripts() {
			wp_deregister_style( 'elementor-animations' );
			wp_deregister_style( 'e-animations' );
			if ( is_post_type_archive( 'topic' ) ) {
				wp_deregister_style( 'bbp-default' );
			}
			//wp_deregister_script('wedocs-anchorjs');
		}

		public function register_admin_styles() {
			wp_enqueue_style( 'docy-gutenberg-editor', plugins_url( 'assets/css/gutenberg-editor.css', __FILE__ ) );
            //wp_enqueue_style( 'docy_core_admin', plugins_url( 'assets/css/docy-core-admin.css', __FILE__ ) );
        }

		public function gutenberg_editor_scripts() {
			wp_enqueue_style( 'docy-gutenberg-editor', plugins_url( 'assets/css/gutenberg-editor.css', __FILE__ ) );
		}

		/**
		 * Register New Widgets
		 *
		 * Include Docy Core widgets files and register them in Elementor.
		 *
		 * @access public
		 */
		public function on_widgets_registered() {
			$this->include_widgets();
			$this->register_widgets();
		}

		/***
		 * Added Custom Font Icon Integrated Elementor Icon Library
		 */
		public function font_icons( $custom_fonts ) {
			$css_data  = plugins_url( 'assets/vendors/elegant-icon/style.css', __FILE__ );
			$json_data = plugins_url( '/assets/vendors/elegant-icon/eleganticons.json', __FILE__ );

			$custom_fonts['elegant-icon'] = [
				'name'          => 'elegant-icon',
				'label'         => esc_html__( 'Elegant Icons', 'docy' ),
				'url'           => $css_data,
				'prefix'        => '',
				'displayPrefix' => '',
				'labelIcon'     => 'icon_star',
				'ver'           => '',
				'fetchJson'     => $json_data,
				'native'        => true,
			];

			return $custom_fonts;
		}

		public static function generate_custom_font_icons() {
			$css_source = '';
			global $wp_filesystem;
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
			$css_file = DOCY_PATH . '/assets/vendors/elegant-icon/style.css';
			if ( $wp_filesystem->exists( $css_file ) ) {
				$css_source = $wp_filesystem->get_contents( $css_file );
			}
			preg_match_all( "/\.(.*?):\w*?\s*?{/", $css_source, $matches, PREG_SET_ORDER, 0 );
			$iconList = [];
			foreach ( $matches as $match ) {
				$icon       = str_replace( '', '', $match[1] );
				$icons      = explode( ' ', $icon );
				$iconList[] = current( $icons );
			}
			$icons        = new \stdClass();
			$icons->icons = $iconList;
			$icon_data    = json_encode( $icons );
			$js_file      = DOCY_PATH . '/assets/vendors/elegant-icon/eleganticons.json';
			global $wp_filesystem;
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
			if ( $wp_filesystem->exists( $js_file ) ) {
				$content = $wp_filesystem->put_contents( $js_file, $icon_data );
			}
		}

		/**
		 * Include Widgets Files
		 *
		 * Load Docy Core widgets files.
		 *
		 * @access private
		 */
		private function include_widgets() {
			require_once __DIR__ . '/vendor/autoload.php';
		}

		/**
		 * Register Widgets
		 *
		 * Register Docy Core widgets.
		 *
		 * @access private
		 */
		private function register_widgets() {
			// Site Elements
			$forum_widgets = [];
			if ( class_exists( 'bbPress' ) ) {
				$forum_widgets = [ 'Forums', 'Forum_topics', 'Single_forum' ];
			}
			
			$opt 				= get_option( 'docy_opt' );
			$post_type_disable 	= $opt['post_type_disable'] ?? '';
		
			$faq_posttype 		= $post_type_disable['faq'] ?? '';
			$video_posttype 	= $post_type_disable['video'] ?? '';
			$changelog_posttype = $post_type_disable['changelog'] ?? '';

			$faq 				= [];
			$video 				= [];
			$changelog 			= [];

			if ( $faq_posttype == '1' ) {
				$faq 			= [ 'Faq' ];
			}

			if ( $video_posttype == '1' ) {
				$video 			= [ 'Video_playlist' ];
			}

			if ( $changelog_posttype == '1' ) {
				$changelog 		= [ 'Changelogs' ];
			}
			
			$widgets = [
				'Hero',
				'Accordion',
				'Button',
				'Docs',
				'Single_doc',
				'Testimonial',
				'Subscribe',
				'Tabs',
				'Process_Tabs',
				'Alerts_box',
				'Data_Table',
				'Image_HotSpots',
				'Counter',
				'Quote',
				'Info_box',
				'Cheatsheet',
				'List_item',
				'Call_to_action',
				'Search_Form',
				'Accordion_Article',
                'Nav_Menu'
			];

			$widgets = array_merge( $widgets, $forum_widgets, $faq, $video, $changelog );

			foreach ( $widgets as $widget ) {
				$classname = "\\DocyCore\\Widgets\\$widget";
                if ( function_exists('Docy_helper') ) {
                    \Elementor\Plugin::instance()->widgets_manager->register(new $classname());
                }
			}
		}
	}
}
// Make sure the same function is not loaded twice in free/premium versions.

if ( ! function_exists( 'docy_core_load' ) ) {
	/**
	 * Load Docy Core
	 *
	 * Main instance of Docy_Core.
	 *
	 */
	function docy_core_load() {
		return Docy_core::instance();
	}

	// Run Docy Core
	docy_core_load();
}


function docy_admin_cpt_script( $hook ) {
	global $post;

	if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
		if ( 'service' === $post->post_type ) {
			wp_enqueue_style( 'themify-icons', plugins_url( 'assets/vendors/themify-icon/themify-icons.css', __FILE__ ) );
		}
	}
}
add_action( 'admin_enqueue_scripts', 'docy_admin_cpt_script', 10, 1 );