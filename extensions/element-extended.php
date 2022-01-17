<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

final class Moomoo_Element_Extension {

   
    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '7.0';    
    private static $_instance = null;
    
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }
    public function __construct() {

        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );

    }
    public function i18n() {

        load_plugin_textdomain( 'moomoo-extension' );

    }

    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed load the files required to run the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */


    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_missing_main_plugin() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'moomoo-extension' ),
            '<strong>' . esc_html__( 'Elementor Test Extension', 'moomoo-extension' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'moomoo-extension' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_elementor_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'moomoo-extension' ),
            '<strong>' . esc_html__( 'Elementor Test Extension', 'moomoo-extension' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'moomoo-extension' ) . '</strong>',
             self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_php_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'moomoo-extension' ),
            '<strong>' . esc_html__( 'Elementor Test Extension', 'moomoo-extension' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'moomoo-extension' ) . '</strong>',
             self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }
    public function init() {

        // Check if Elementor installed and activated
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

       
        // Add Plugin actions
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
        add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
        add_action( 'elementor/dynamic_tags/register_tags', [ $this, 'init_dynamicTags' ]);
        
    }
    public function includes_widgets() {

        // Include Widget files       
        require_once(__DIR__ . '/../widgets/menu-widget.php' );
        require_once(__DIR__ . '/../widgets/post-video.php' );
        require_once(__DIR__ . '/../widgets/posts-widget.php' );
        require_once(__DIR__ . '/../widgets/sidebar-widget.php' );
        require_once(__DIR__ . '/../widgets/post-navigation.php' );
        require_once(__DIR__ . '/../widgets/team-member.php' );
        require_once(__DIR__ . '/../widgets/map-light-hight-widget.php' );
        require_once(__DIR__ . '/../widgets/projects-widget.php' );
        require_once(__DIR__ . '/../widgets/team-member-style2.php' );
        require_once(__DIR__ . '/../widgets/tab-projects-widget.php' );
        require_once(__DIR__ . '/../widgets/gravity-form-widget.php' );
        require_once(__DIR__ . '/../widgets/moomoo-buttons.php' );
        require_once(__DIR__ . '/../widgets/moomoo-slides.php' );
        require_once(__DIR__ . '/../widgets/moomoo-media.php' );
        require_once(__DIR__ . '/../widgets/moomoo-banner-post.php' );
        require_once(__DIR__ . '/../widgets/moomoo-categories-string.php' );
        require_once(__DIR__ . '/../widgets/moomoo-icon-list.php' );

    }
    
    public function register_widgets() {
        $this->includes_widgets();
        $widgets_manager = \Elementor\Plugin::$instance->widgets_manager;

        $widgets_manager->register_widget_type( new \Elementor_Menu_Widget());   
        $widgets_manager->register_widget_type( new \Elementor_Post_Video_Widget());  
        $widgets_manager->register_widget_type( new \Elementor_Sidebar_Widget());  
        $widgets_manager->register_widget_type( new \Elementor_Posts_Widget());  
        $widgets_manager->register_widget_type( new \Post_Navigation_Widget());  
        $widgets_manager->register_widget_type( new \Elementor_Team_Member_Widget());
        $widgets_manager->register_widget_type( new \Elementor_Team_Member_Map_Light_Hight_Widget());
        $widgets_manager->register_widget_type( new \Elementor_Projects_Widget());  
        $widgets_manager->register_widget_type( new \Elementor_Team_Member_Style2_Widget());
        $widgets_manager->register_widget_type( new \Elementor_Tab_Projects_Widget());
        $widgets_manager->register_widget_type( new \Elementor_Gravity_Form_Widget());
        $widgets_manager->register_widget_type( new \Elementor_Moomoo_Buttons());
        $widgets_manager->register_widget_type( new \Elementor_MoomooSlides());
        $widgets_manager->register_widget_type( new \Elementor_Moomoo_Media()); 
        $widgets_manager->register_widget_type( new \Elementor_Moomoo_Banner_Post()); 
        $widgets_manager->register_widget_type( new \Elementor_Moomoo_Categories_String());  
        $widgets_manager->register_widget_type( new \Elementor_Moomoo_Icon_List());  

    }
    
    public function includes_controls() {

        // Include controls files       
        require_once(__DIR__ . '/../controls/moomoo-background-gradient.php' );
       

    }
   
    public function register_controls() {

        $this->includes_controls();

        // Register control
        $controls_manager = \Elementor\Plugin::$instance->controls_manager;
        /*$controls_manager->register_control( 'mmbackgroundgradient', new Group_Control_mmbackgroundgradient() );*/

        $controls_manager->add_group_control( Group_Control_mmbackgroundgradient::get_type(), new Group_Control_mmbackgroundgradient() );
       //$controls_manager->mmbackgroundgradient =  new Group_Control_mmbackgroundgradient();
      // var_dump($controls_manager->mmbackgroundgradient);
       // \Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Test_Control() );

    }
    public function init_dynamicTags($dynamic_tags){

    /*  \Elementor\Plugin::$instance->dynamic_tags->register_group( 'request-variables', [
                'title' => 'Request Variables' 
            ] );
         require_once(__DIR__ . '/../dynamic-tags/post-video.php' );

        // Finally register the tag
       $dynamic_tags->register_tag( 'Elementor_Post_Video' );*/
        
    }

}

Moomoo_Element_Extension::instance();
function add_elementor_widget_categories( $elements_manager ) {

    $elements_manager->add_category(
        'moomoo',
        [
            'title' => __( 'Moomoo', 'plugin-name' ),
            'icon' => 'fa fa-plug',
        ]
    );
  

}
add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );