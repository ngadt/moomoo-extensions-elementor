<?php

use ElementorPro\Base\Base_Widget;
use Elementor\Core\Schemes\Typography ;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
//use Elementor\Scheme_Color;
use Elementor\Core\Schemes\Color;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;


class Elementor_Moomoo_Icon_List extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        $this->_widget_name = $this->get_name();
        
        add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
        
        parent::__construct( $data, $args );

        
    }
    public function get_name() {
        return 'moomoo-icon-list';
    }
    
    
    public function get_title() {
        return __( 'Moomoo Icon List', 'moomoo-extensions-elementor' );
    }

    public function get_icon() {
        return 'eicon-bullet-list';
    }
    
    public function get_categories() {
        return [ 'moomoo' ];
    }

    public function ndt_enqueue_scripts() {
        wp_enqueue_style('mm-icon-list', MM_EXT_ASSET_URL .'/css/moomoo-icon-list.css', array(), time());
        wp_enqueue_script('mm-icon-list', MM_EXT_ASSET_URL .'/js/moomoo-icon-list.js', array('jquery'), time(), true);
        
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

        $this->add_control(
            'view',
            [
                'label' => __( 'Layout', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'traditional',
                'options' => [
                    'traditional' => [
                        'title' => __( 'Default', 'moomoo-extensions-elementor' ),
                        'icon' => 'eicon-editor-list-ul',
                    ],
                    'inline' => [
                        'title' => __( 'Inline', 'moomoo-extensions-elementor' ),
                        'icon' => 'eicon-ellipsis-h',
                    ],
                ],
                'render_type' => 'template',
                'classes' => 'elementor-control-start-end',
                'style_transfer' => true,
                'prefix_class' => 'elementor-icon-list--layout-',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text',
            [
                'label' => __( 'Text', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __( 'List Item', 'moomoo-extensions-elementor' ),
                'default' => __( 'List Item', 'moomoo-extensions-elementor' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'selected_icon',
            [
                'label' => __( 'Icon', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'fa4compatibility' => 'icon',
            ]
        );

       $repeater->add_control(
            'mm_video_source',
            [
                'label' => __( 'Video Source', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => array(
                    'youtube'  => __( 'Youtube', 'moomoo-extensions-elementor' ),
                    'vimeo'  => __( 'Vimeo', 'moomoo-extensions-elementor' ),
                    'self-hosted'  => __( 'Self Hosted', 'moomoo-extensions-elementor' )
                ),
                'default'   => ''                
            ]
        );
       $repeater->add_control(
            'link',
            [
                'label' => __( 'Video Url', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter your Video link', 'moomoo-extensions-elementor' ),
                'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',    
                'label_block'=>true,            
                'condition' => array(
                    'mm_video_source' => ['youtube','vimeo']
                ),
            ]
        );
        $repeater->add_control(
            'mm_self_host', 
            [
                'label' => __( 'Upload Video', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder' => __( 'Choose Video', 'moomoo-extensions-elementor' ),
                'condition' => array(
                    'mm_video_source' => ['self-hosted']
                ),
            ]
        );
        $repeater->add_control(
            'item_description',
            [
                'label' => __( 'Description', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __( 'Default description', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Type your description here', 'moomoo-extensions-elementor' ),
            ]
        );


        $this->add_control(
            'icon_list',
            [
                'label' => __( 'Items', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'text' => __( 'List Item #1', 'moomoo-extensions-elementor' ),
                        'selected_icon' => [
                            'value' => 'fas fa-check',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        'text' => __( 'List Item #2', 'moomoo-extensions-elementor' ),
                        'selected_icon' => [
                            'value' => 'fas fa-times',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        'text' => __( 'List Item #3', 'moomoo-extensions-elementor' ),
                        'selected_icon' => [
                            'value' => 'fas fa-dot-circle',
                            'library' => 'fa-solid',
                        ],
                    ],
                ],
                'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ text }}}',
            ]
        );      
        $this->add_control(
            'enable_popup',
            [
                'label' => __( 'Enable Popup when click', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'moomoo-extensions-elementor' ),
                'label_off' => __( 'Hide', 'moomoo-extensions-elementor' ),
                'return_value' => 'yes',
                'default' => 'no',
                'separator' => 'before',
                'prefix_class' => 'moomoo-enable-popup-',
            ]
        );
        $this->add_control(
            'link_click',
            [
                'label' => __( 'Apply Link On', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'full_width' => __( 'Full Width', 'moomoo-extensions-elementor' ),
                    'inline' => __( 'Inline', 'moomoo-extensions-elementor' ),
                ],
                'default' => 'full_width',
                'separator' => 'before',
                'prefix_class' => 'elementor-list-item-link-',
            ]
        );

        $this->end_controls_section();

    }
    
    public function register_style_section_controls(){

        $this->start_controls_section(
            'general_style_section',
            [
                'label' => __( 'General Style', 'moomoo-extensions-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'space_between',
            [
                'label' => __( 'Space Between', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
                    '{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
                    'body.rtl {{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'left: calc(-{{SIZE}}{{UNIT}}/2)',
                    'body:not(.rtl) {{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'right: calc(-{{SIZE}}{{UNIT}}/2)',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_align',
            [
                'label' => __( 'Alignment', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'moomoo-extensions-elementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'moomoo-extensions-elementor' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'moomoo-extensions-elementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
            ]
        );
        

        $this->add_control(
            'divider',
            [
                'label' => __( 'Divider', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'Off', 'moomoo-extensions-elementor' ),
                'label_on' => __( 'On', 'moomoo-extensions-elementor' ),
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'content: ""',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'divider_style',
            [
                'label' => __( 'Style', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'solid' => __( 'Solid', 'moomoo-extensions-elementor' ),
                    'double' => __( 'Double', 'moomoo-extensions-elementor' ),
                    'dotted' => __( 'Dotted', 'moomoo-extensions-elementor' ),
                    'dashed' => __( 'Dashed', 'moomoo-extensions-elementor' ),
                ],
                'default' => 'solid',
                'condition' => [
                    'divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-style: {{VALUE}}',
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-style: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'divider_weight',
            [
                'label' => __( 'Weight', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'condition' => [
                    'divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'divider_width',
            [
                'label' => __( 'Width', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'condition' => [
                    'divider' => 'yes',
                    'view!' => 'inline',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'divider_height',
            [
                'label' => __( 'Height', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'default' => [
                    'unit' => '%',
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'divider' => 'yes',
                    'view' => 'inline',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'divider_color',
            [
                'label' => __( 'Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ddd',
                'global' => [
                    'default' => '',
                ],
                'condition' => [
                    'divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => __( 'Icon', 'moomoo-extensions-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
                ],
                'global' => [
                    'default' =>'',
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __( 'Size', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 14,
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-icon-list-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_self_align',
            [
                'label' => __( 'Alignment', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'moomoo-extensions-elementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'moomoo-extensions-elementor' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'moomoo-extensions-elementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'vertical_align',
            array(
                'label'        => __( 'Vertical Align ', 'moomoo-extensions-elementor' ),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => array(
                    'flex-start'    => array(
                        'title' => __( 'Top', 'moomoo-extensions-elementor' ),
                        'icon'  => 'eicon-v-align-top',
                    ),
                    'center'  => array(
                        'title' => __( 'Middle', 'moomoo-extensions-elementor' ),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'flex-end'   => array(
                        'title' => __( 'Bottom', 'moomoo-extensions-elementor' ),
                        'icon'  => 'eicon-v-align-bottom',
                    )
                ),
                'default'      => 'top',
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-icon-list li .item-icon-list' => 'align-items: {{VALUE}};',
                ),
                'toggle'       => false,
            )
        );
        $this->add_responsive_control(
            'icon_padding',
            array(
                'label'      => __( 'Icon Padding', 'moomoo-extensions-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px' ),
                'selectors'  => array(
                    '{{WRAPPER}} .moomoo-icon-list li .item-icon-list span.elementor-icon-list-icon'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_text_style',
            [
                'label' => __( 'Text', 'moomoo-extensions-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-text' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' =>'',
                ],
            ]
        );

        $this->add_control(
            'text_color_hover',
            [
                'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_indent',
            [
                'label' => __( 'Text Indent', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-text' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'icon_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-list-item, {{WRAPPER}} .elementor-icon-list-item a',
                'global' => [
                    'default' => '',
                ],
            ]
        );

       
        $this->end_controls_section();
        $this->start_controls_section(
            'section_popup_style',
            [
                'label' => __( 'Popup', 'moomoo-extensions-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        /**
         * Heading control.
         */
        $this->add_responsive_control(
            'bg_outside_div',
            [
                'label' => __( 'Background Outside Div', 'plugin-name' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_div_out_side',
                'label' => __( 'Background Outside Div', 'moomoo-extensions-elementor' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .moomoo-icon-list .item-popup ',

            ]
        );
        $this->add_responsive_control(
            'bg_inside_div',
            [
                'label' => __( 'Background Inside Div', 'plugin-name' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_div_inside_side',
                'label' => __( 'Background Inside Div', 'moomoo-extensions-elementor' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .moomoo-icon-list .align-center-content ',

            ]
        );
        $this->add_responsive_control(
            'margin',
            [
                'label' => __( 'Padding Box', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .moomoo-icon-list .wrap-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_width',
            [
                'label' => __( 'Content Width', 'moomoo-extensions-elementor' ),
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
                    'size' => 80,
                ],
                'selectors' => [
                    '{{WRAPPER}} .moomoo-icon-list .align-center-content' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'video_width',
            [
                'label' => __( 'Video Width', 'moomoo-extensions-elementor' ),
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
                    'size' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .moomoo-icon-list iframe.elementor-video-iframe' => 'width: {{SIZE}}{{UNIT}}; left: calc((100{{UNIT}} - {{SIZE}}{{UNIT}})/2);'
                    
                ],
            ]
        );
        $this->add_responsive_control(
            'video_height',
            [
                'label' => __( 'Video Height', 'moomoo-extensions-elementor' ),
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
                    'size' => 70,
                ],
                'selectors' => [
                    '{{WRAPPER}} .moomoo-icon-list .videoWrapper' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .moomoo-icon-list .desc' => 'height: calc(100{{UNIT}}-{{SIZE}}{{UNIT}});',
                    
                ],
            ]
        );
        $this->add_responsive_control(
            'desc_width',
            [
                'label' => __( 'Limit Descrption Width', 'moomoo-extensions-elementor' ),
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
                    'size' => 100,
                ],
                'selectors' => [            
                    '{{WRAPPER}} .moomoo-icon-list .desc' => 'max-width: {{SIZE}}{{UNIT}};',
                    
                ],
            ]
        );
        $this->add_responsive_control(
            'margin',
            [
                'label' => __( 'Description Padding', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .moomoo-icon-list .desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'desc_color',
            [
                'label' => __( 'Title Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .moomoo-icon-list .desc' => 'color: {{VALUE}}',
                ],
            ]
        );
        
         $this->add_responsive_control(
            'text_align',
            [
                'label' => __( 'Description Alignment', 'moomoo-extensions-elementor' ),
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
                    '{{WRAPPER}} .moomoo-icon-list .desc' => 'text-align: {{VALUE}};',
                ),
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'font_style_intro_desc',
                'label' =>'Style',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-icon-list .desc p',             
                
            ]
        );

        $this->add_control(
            'close_icon',
            [
                'label' => __( 'Close Icon', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => '',
                ],
                'fa4compatibility' => 'icon',
            ]
        );
        $this->add_responsive_control(
            'close_icon_size',
            [
                'label' => __( 'Size', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 28,
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .moomoo-icon-list .close .elementor-icon-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .moomoo-icon-list .close .elementor-icon-list-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'close_icon_color',
            [
                'label' => __( 'Icon Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .moomoo-icon-list .close .elementor-icon-list-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .moomoo-icon-list .close .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
                ],
                'global' => [
                    'default' =>'',
                ],
            ]
        );
        $this->end_controls_section();

    }
    protected function render() {
        $settings = $this->get_settings_for_display();
        $fallback_defaults = [
            'fa fa-check',
            'fa fa-times',
            'fa fa-dot-circle-o',
        ];

        $this->add_render_attribute( 'icon_list', 'class', 'elementor-icon-list-items' );
        $this->add_render_attribute( 'list_item', 'class', 'elementor-icon-list-item' );

        if ( 'inline' === $settings['view'] ) {
            $this->add_render_attribute( 'icon_list', 'class', 'elementor-inline-items' );
            $this->add_render_attribute( 'list_item', 'class', 'elementor-inline-item' );
        }
        ?>
        <div class="moomoo-elementor-extension"><div class="moomoo-icon-list">
            <ul <?php echo $this->get_render_attribute_string( 'icon_list' ); ?>>
                <?php
                foreach ( $settings['icon_list'] as $index => $item ) :
                    $repeater_setting_key = $this->get_repeater_setting_key( 'text', 'icon_list', $index );

                    $this->add_render_attribute( $repeater_setting_key, 'class', 'elementor-icon-list-text' );

                    $this->add_inline_editing_attributes( $repeater_setting_key );
                    $migration_allowed = Icons_Manager::is_migration_allowed();
                    ?>
                    <li <?php echo $this->get_render_attribute_string( 'list_item' ); ?>>
                        <div class="item-icon-list">
                        <?php
                        if ( ! empty( $item['link']['url'] ) ) {
                            $link_key = 'link_' . $index;

                            $this->add_link_attributes( $link_key, $item['link'] );

                            echo '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
                        }

                        // add old default
                        if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
                            $item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
                        }

                        $migrated = isset( $item['__fa4_migrated']['selected_icon'] );
                        $is_new = ! isset( $item['icon'] ) && $migration_allowed;
                        if ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) :
                            ?>
                            <span class="elementor-icon-list-icon">
                                <?php
                                if ( $is_new || $migrated ) {
                                    Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
                                } else { ?>
                                        <i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
                                <?php } ?>
                            </span>
                        <?php endif; ?>
                        <span <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>><?php echo $item['text']; ?></span>
                        <?php if ( ! empty( $item['link']['url'] ) ) : ?>
                            </a>
                        <?php endif; ?>
                        </div>
                        <div class="item-popup">
                            <div class="wrap-content">
                                <div class="align-center-content">
                                <?php
                                $mm_video_link = $item['link']; 
                                $mm_video_source = $item['mm_video_source'];
                                $html ='';
                                 $type_video = array();    
                                 parse_str($mm_video_link, $type_video );
                                if($mm_video_source =='youtube'){
                                    $link_video = 'https://www.youtube.com/embed/'.$type_video['https://www_youtube_com/watch?v'];

                                }else if($mm_video_source =='vimeo') {
                                    $link_video = str_replace('https://vimeo.com', 'https://player.vimeo.com/video', $mm_video_link);
                                }
                                if($link_video){
                                    $html = '<div class="videoWrapper"><iframe class="elementor-video-iframe" src="'. $link_video.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
                                }

                                
                                echo $html;
                            ?>
                                <div class="desc"><p><?php echo $item['item_description']; ?></p></div>
                                <div class="close">
                                       <?php
                                            if ( ! empty( $settings['close_icon']['value'] )) :
                                            ?>
                                            <span class="elementor-icon-list-icon icon-close">
                                                <?php
                                                if ( $is_new || $migrated ) {
                                                    Icons_Manager::render_icon( $settings['close_icon'], [ 'aria-hidden' => 'true' ] );
                                                } else { ?>
                                                        <i class="<?php echo esc_attr( $settings['close_icon'] ); ?>" aria-hidden="true"></i>
                                                <?php } ?>
                                            </span>
                                        <?php else: ?>
                                                <span class="icon icon-close default"></span>
                                            
                                        <?php endif; ?>
                                       
                                </div><!-- close -->            
                                    
                            </div>
                            </div>
                            
                            
                        </div>
                    </li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div></div>
        <?php
    }
    protected function content_template() {
        ?>
        <#
            view.addRenderAttribute( 'icon_list', 'class', 'elementor-icon-list-items' );
            view.addRenderAttribute( 'list_item', 'class', 'elementor-icon-list-item' );

            if ( 'inline' == settings.view ) {
                view.addRenderAttribute( 'icon_list', 'class', 'elementor-inline-items' );
                view.addRenderAttribute( 'list_item', 'class', 'elementor-inline-item' );
            }
            var iconsHTML = {},
                migrated = {};
        #>
        <# if ( settings.icon_list ) { #>
            <ul {{{ view.getRenderAttributeString( 'icon_list' ) }}}>
            <# _.each( settings.icon_list, function( item, index ) {

                    var iconTextKey = view.getRepeaterSettingKey( 'text', 'icon_list', index );

                    view.addRenderAttribute( iconTextKey, 'class', 'elementor-icon-list-text' );

                    view.addInlineEditingAttributes( iconTextKey ); #>

                    <li {{{ view.getRenderAttributeString( 'list_item' ) }}}>
                        <# if ( item.link && item.link.url ) { #>
                            <a href="{{ item.link.url }}">
                        <# } #>
                        <# if ( item.icon || item.selected_icon.value ) { #>
                        <span class="elementor-icon-list-icon">
                            <#
                                iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
                                migrated[ index ] = elementor.helpers.isIconMigrated( item, 'selected_icon' );
                                if ( iconsHTML[ index ] && iconsHTML[ index ].rendered && ( ! item.icon || migrated[ index ] ) ) { #>
                                    {{{ iconsHTML[ index ].value }}}
                                <# } else { #>
                                    <i class="{{ item.icon }}" aria-hidden="true"></i>
                                <# }
                            #>
                        </span>
                        <# } #>
                        <span {{{ view.getRenderAttributeString( iconTextKey ) }}}>{{{ item.text }}}</span>
                        <# if ( item.link && item.link.url ) { #>
                            </a>
                        <# } #>
                    </li>
                <#
                } ); #>
            </ul>
        <#  } #>

        <?php
    }
  
}