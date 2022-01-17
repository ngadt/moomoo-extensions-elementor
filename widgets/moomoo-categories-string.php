<?php

use ElementorPro\Base\Base_Widget;
use Elementor\Core\Schemes\Typography ;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


class Elementor_Moomoo_Categories_String extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        $this->_widget_name = $this->get_name();
        
        add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
        
        parent::__construct( $data, $args );

        
    }
    public function get_name() {
        return 'moomoo-category-string';
    }
    
    
    public function get_title() {
        return __( 'Moomoo Category', 'moomoo-extensions-elementor' );
    }

    public function get_icon() {
        return 'fab fa-folder';
    }
    
    public function get_categories() {
        return [ 'basic' ];
    }

    public function ndt_enqueue_scripts() {
       /* wp_enqueue_style('mm-demo', MM_EXT_ASSET_URL .'/css/moomoo-demo.css', array(), time());
        wp_enqueue_script('mm-demo', MM_EXT_ASSET_URL .'/js/moomoo-demo.js', array('jquery'), time(), true);*/
        
    }
    protected function _register_controls() {
       $this->register_content_section_controls();
       $this->register_style_section_controls();

    }
    public function register_content_section_controls(){
    }
    
    public function register_style_section_controls(){
         $this->start_controls_section(
            'tabcontent_section',
            [
                'label' => __( 'General Style', 'moomoo-extensions-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default'=>'#fff',
                'selectors' => [
                    '{{WRAPPER}} .moomoo-categories-string a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'padding',
            [
                'label' => __( 'Padding', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .moomoo-categories-string .wrap-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'font_style_text',
                'label' =>'Style',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-categories-string a',             
                
            ]
        );
         $this->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default'=>'#236e87',
                'selectors' => [
                    '{{WRAPPER}} .moomoo-categories-string .wrap-category' => 'background: {{VALUE}}; display:table;',
                ],
            ]
        );
        $this->add_control(
            'border_style',
            [
                'label' => __( 'Skew sidebar', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'deg' ],
                'range' => [
                    'deg' => [
                        'min' => -50,
                        'max' => 50,
                        'step' => 2,
                    ]                    
                ],
                'default' => [
                    'unit' => 'deg',
                    'size' => -15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .moomoo-categories-string .wrap-category' => 'transform: skew({{SIZE}}deg);-o-transform: skew({{SIZE}}deg); -moz-transform: skew({{SIZE}}deg); -webkit-transform: skew({{SIZE}}deg);',
                    '{{WRAPPER}} .moomoo-categories-string .wrap-category a' => 'transform: skew(calc({{SIZE}}deg *-1));-o-transform: skew(calc({{SIZE}}deg *-1)); -moz-transform: skew(calc({{SIZE}}deg *-1)); -webkit-transform: skew(calc({{SIZE}}deg *-1)); display: inline-block',
                ],
            ]
        );
        $this->end_controls_section();

    }
   
    protected function render() {
        //$settings = $this->get_settings_for_display();
        if(is_category()){
             $category_current = get_queried_object();
        }else{
            $category_current = get_the_category();
        }
       
        ?>
        <div class="moomoo-elementor-extension">
            <div class="moomoo-categories-string">
                <div class="wrap-category">
                <?php 
                $html ='';
                foreach ($category_current as $cate) {
                    if($cate->parent == 0) continue; //remove oldest category
                    $html .='<a href="'.get_category_link($cate->term_id).'">'.$cate->name.'</a>'.', ';
                    
                } 
                echo trim($html,', ');
                ?>
                </div>
            </div>
        </div>
        <?php
      
    }
}