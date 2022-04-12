<?php

use ElementorPro\Base\Base_Widget;
use Elementor\Core\Schemes\Typography ;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


class Elementor_Moomoo_Demo extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        $this->_widget_name = $this->get_name();
        
        add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
        
        parent::__construct( $data, $args );

        
    }
    public function get_name() {
        return 'moomoo-demo';
    }
    
    
    public function get_title() {
        return __( 'Moomoo Demo', 'moomoo-extensions-elementor' );
    }

    public function get_icon() {
        return 'fab fa-image';
    }
    
    public function get_categories() {
        return [ 'basic' ];
    }

    public function ndt_enqueue_scripts() {
        wp_enqueue_style('mm-demo', MM_EXT_ASSET_URL .'/css/moomoo-demo.css', array(), time());
        wp_enqueue_script('mm-demo', MM_EXT_ASSET_URL .'/js/moomoo-demo.js', array('jquery'), time(), true);
        
    }
    protected function register_controls() {
       $this->register_content_section_controls();
       $this->register_style_section_controls();

    }
    public function register_content_section_controls(){
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Layout', 'moomoo-extensions-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
         /**
         * select option control.
         */
        $this->add_control(
            'btn_size',
            array(
                'label'        => __( 'Size', 'moomoo-extensions-elementor' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'sm',
                'options'      => array(
                    'xs' => __( 'Extra Small', 'moomoo-extensions-elementor' ),
                    'sm' => __( 'Small', 'moomoo-extensions-elementor' ),
                    'md' => __( 'Medium', 'moomoo-extensions-elementor' ),
                    'lg' => __( 'Large', 'moomoo-extensions-elementor' ),
                    'xl' => __( 'Extra Large', 'moomoo-extensions-elementor' ),
                ),
                'prefix_class' => 'uael-gf-btn-size-',
            )
        );

        /**
         * Text control.
         */
        $this->add_control(
            'widget_title',
            [
                'label' => __( 'Title', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Default title', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Type your title here', 'moomoo-extensions-elementor' ),
            ]
        );
        /**
         * Number control.
         */
        $this->add_control(
            'price',
            [
                'label' => __( 'Price', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 5,
                'max' => 100,
                'step' => 5,
                'default' => 10,
            ]
        );
        /**
         * Textarea control.
         */
        $this->add_control(
            'item_description',
            [
                'label' => __( 'Description', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => __( 'Default description', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Type your description here', 'moomoo-extensions-elementor' ),
            ]
        );
        /** border */
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => esc_html__( 'Border', 'plugin-name' ),
                'selector' => '{{WRAPPER}} .your-class',
            ]
        );

        /**
         * Select control.
         */
        $this->add_control(
            'select_style',
            [
                'label' => __( 'Select Style', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'solid'  => __( 'Solid', 'moomoo-extensions-elementor' ),
                    'dashed' => __( 'Dashed', 'moomoo-extensions-elementor' ),
                    'dotted' => __( 'Dotted', 'moomoo-extensions-elementor' ),
                    'double' => __( 'Double', 'moomoo-extensions-elementor' ),
                    'none' => __( 'None', 'moomoo-extensions-elementor' ),
                ],
            ]
        );
        /**
         * Switcher control.
         */
        $this->add_control(
            'show_title',
            [
                'label' => __( 'Show Title', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'your-plugin' ),
                'label_off' => __( 'Hide', 'your-plugin' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        /**
         * Button control.
         */
        $this->add_control(
            'delete_content',
            [
                'label' => __( 'Delete Content', 'plugin-name' ),
                'type' => Controls_Manager::BUTTON,
                'separator' => 'before',
                'button_type' => 'success',
                'text' => __( 'Delete', 'moomoo-extensions-elementor' ),
                'event' => 'namespace:editor:delete',
            ]
        );
        /**
         * Hidden control.
         */
        $this->add_control(
            'view',
            [
                'label' => __( 'View', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );
        /**
         * Heading control.
         */
        $this->add_control(
            'more_options',
            [
                'label' => __( 'Additional Options', 'plugin-name' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        /**
         * Raw HTML control.
         */
        $this->add_control(
            'important_note',
            [
                'label' => __( 'Important Note', 'plugin-name' ),
                'type' => Controls_Manager::RAW_HTML,
                'raw' => __( 'A very important message to show in the panel.', 'plugin-name' ),
                'content_classes' => 'your-class',
            ]
        );
        /**
         * Deprecated Notice control.
         */
        $this->add_control(
            'deprecated_notice',
            [
                'type' => Controls_Manager::DEPRECATED_NOTICE,
        'widget' => 'your-old-widget',
        'since' => '2.6.0',
        'last' => '3.0.0',
        'plugin' => 'Your Great Plugin',
        'replacement' => 'your-new-widget',
                'content_classes' => 'your-class',
            ]
        );

        /**
         * Popover Toggle control.
         */
        $this->add_control(
            'border_popover_toggle',
            [
                'label' => __( 'Border', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'Default', 'your-plugin' ),
                'label_on' => __( 'Custom', 'your-plugin' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        /**
         * Section control.
         */
        $this->add_control();
        $this->add_control();
        $this->add_control();

        /**
         * Tab control.
         */
        $this->start_controls_tabs(
            'style_tabs'
        );

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => __( 'Normal', 'plugin-name' ),
            ]
        );

        $this->add_control();

        $this->add_control();

        $this->add_control();

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => __( 'Hover', 'plugin-name' ),
            ]
        );

        $this->add_control();

        $this->add_control();

        $this->add_control();

        $this->end_controls_tab();

        $this->end_controls_tabs();
        /**
         * Divider control.
         */
        $this->add_control(
            'hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
        $this->end_controls_section();
    }
    
    public function register_style_section_controls(){

        $this->start_controls_section(
            'tabcontent_section',
            [
                'label' => __( 'General Style', 'moomoo-extensions-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
         $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'font_style_intro_desc',
                'label' =>'Style',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .moomoo-banner-post .wrap-banner-post h1',             
                
            ]
        );
        /**
         * Color control.
         */
        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}}',
                ],
            ]
        );
        /**
         * Media control.
         */
        $this->add_control(
            'image',
            [
                'label' => __( 'Choose Image', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        /**
         * background control.
         */
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __( 'Background', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .wrapper',
            ]
        );
        /**
         * Slider control.
         */
        $this->add_control(
            'width',
            [
                'label' => __( 'Width', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .box' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        /**
         * Dimensions control.
         */
        $this->add_control(
            'margin',
            [
                'label' => __( 'Margin', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .your-class' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        /**
         * Choose control.
         */
        $this->add_control(
            'text_align',
            [
                'label' => __( 'Alignment', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'moomoo-extensions-elementor' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'moomoo-extensions-elementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'moomoo-extensions-elementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],

                'default' => 'center',
                'toggle' => true,
                'selectors' => array(
                    '{{WRAPPER}} .uael-gf-form-desc,
                    {{WRAPPER}} .uael-gf-form-title,
                    {{WRAPPER}} .uael-gf-style .gform_description,
                    {{WRAPPER}} .uael-gf-style .gform_heading' => 'text-align: {{VALUE}};',
                ),
            ]

        );
        /**
         * WYSIWYG control.
         */
        $this->add_control(
            'item_description',
            [
                'label' => __( 'Description', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __( 'Default description', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Type your description here', 'moomoo-extensions-elementor' ),
            ]
        );
        /**
         * Code control.
         */
        $this->add_control(
            'custom_html',
            [
                'label' => __( 'Custom HTML', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::CODE,
                'language' => 'html',
                'rows' => 20,
            ]
        );
        /**
         * Font control.
         */
        $this->add_control(
            'font_family',
            [
                'label' => __( 'Font Family', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::FONT,
                'default' => "'Open Sans', sans-serif",
                'selectors' => [
                    '{{WRAPPER}} .title' => 'font-family: {{VALUE}}',
                ],
            ]
        );
        /**
         * Image dimensions control.
         */
        $this->add_control(
            'custom_dimension',
            [
                'label' => __( 'Image Dimension', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'description' => __( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'plugin-name' ),
                'default' => [
                    'width' => '',
                    'height' => '',
                ],
            ]
        );
        /**
         * URL control.
         */
        $this->add_control(
            'website_link',
            [
                'label' => __( 'Link', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'moomoo-extensions-elementor' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
        /**
         * Repeater control.
         */
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'list_title', [
                'label' => __( 'Title', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'List Title' , 'moomoo-extensions-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'list_content', [
                'label' => __( 'Content', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __( 'List Content' , 'moomoo-extensions-elementor' ),
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'list_color',
            [
                'label' => __( 'Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => __( 'Repeater List', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => __( 'Title #1', 'moomoo-extensions-elementor' ),
                        'list_content' => __( 'Item content. Click the edit button to change this text.', 'moomoo-extensions-elementor' ),
                    ],
                    [
                        'list_title' => __( 'Title #2', 'moomoo-extensions-elementor' ),
                        'list_content' => __( 'Item content. Click the edit button to change this text.', 'moomoo-extensions-elementor' ),
                    ],
                ],
                'title_field' => '{{{ list_title }}}',
            ]
        );

        /**
         * Icon control.
         */
        $this->add_control(
            'icon',
            [
                'label' => __( 'Social Icons', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::ICON,
                'include' => [
                    'fa fa-facebook',
                    'fa fa-flickr',
                    'fa fa-google-plus',
                    'fa fa-instagram',
                    'fa fa-linkedin',
                    'fa fa-pinterest',
                    'fa fa-reddit',
                    'fa fa-twitch',
                    'fa fa-twitter',
                    'fa fa-vimeo',
                    'fa fa-youtube',
                ],
                'default' => 'fa fa-facebook',
            ]
        );
        /**
         * Icons control.
         */
        $this->add_control(
            'icon',
            [
                'label' => __( 'Icon', 'text-domain' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );
        /**
         * Gallery control.
         */
        $this->add_control(
            'gallery',
            [
                'label' => __( 'Add Images', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::GALLERY,
                'default' => [],
            ]
        );
        
        /**
         * Select2 control.
         */
        $this->add_control(
            'show_elements',
            [
                'label' => __( 'Show Elements', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    'title'  => __( 'Title', 'moomoo-extensions-elementor' ),
                    'description' => __( 'Description', 'moomoo-extensions-elementor' ),
                    'button' => __( 'Button', 'moomoo-extensions-elementor' ),
                ],
                'default' => [ 'title', 'description' ],
            ]
        );
        /**
         * Date/Time control.
         */
        $this->add_control(
            'due_date',
            [
                'label' => __( 'Due Date', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::DATE_TIME,
            ]
        );
        /**
         * Box shadow control.
         */
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => __( 'Box Shadow', 'moomoo-extensions-elementor' ),
                'selector' => '{{WRAPPER}} .wrapper',
            ]
        );
        /**
         * Text shadow control.
         */
        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'label' => __( 'Text Shadow', 'moomoo-extensions-elementor' ),
                'selector' => '{{WRAPPER}} .wrapper',
            ]
        );
        /**
         * Entrance animation control.
         */
        $this->add_control(
            'entrance_animation',
            [
                'label' => __( 'Entrance Animation', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::ANIMATION,
                'prefix_class' => 'animated ',
            ]
        );
        /**
         * Hover animation control.
         */
        $this->add_control(
            'hover_animation',
            [
                'label' => __( 'Hover Animation', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'prefix_class' => 'elementor-animation-',
            ]
        );

        $this->end_controls_section();

    }
   
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
          <div class="moomoo-elementor-extension">
            <div class="moomoo-banner-post">
            </div>
          </div>
        <?php
        echo '<div class="' . $settings['entrance_animation'] . '"> .. </div>';
       
    }
}