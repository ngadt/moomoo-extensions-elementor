<?php
use ElementorPro\Base\Base_Widget;
use Elementor\Core\Schemes\Typography ;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;


class Elementor_Moomoo_Buttons extends \Elementor\Widget_Base {
	
	public function __construct( $data = [], $args = null ) {
		$this->_widget_name = self::get_name();
		
		add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
		
		parent::__construct( $data, $args );
		
	}
	public function get_name() {
		return 'moomoo-buttons';
	}
	
	public function get_title() {
		return __( 'Moomoo Buttons', 'moomoo-extensions-elementor' );
	}

	public function get_icon() {
		return 'eicon-button';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}

	public function ndt_enqueue_scripts() {

		wp_enqueue_style('mm-buttons', MM_EXT_ASSET_URL .'/css/moomoo-buttons.css', array(), time());	
		wp_enqueue_script('mm-TweenMax',MM_EXT_ASSET_URL .'/js/TweenMax.min.js',array('jquery'), '2.0.0', true);
		//wp_enqueue_script('mm-TimelineMax',MM_EXT_ASSET_URL .'/js/TimelineMax.min.js',array('jquery'), '2.0.1', true);
		wp_enqueue_script('mm-buttons',MM_EXT_ASSET_URL .'/js/moomoo-buttons.js',array('mm-TweenMax'), time(), true);
		
	}
	public static function get_button_style() {
		return [
			'glowing-gradient-button' 	=> __( 'Glowing Gradient', 'moomoo-extensions-elementor' ),
			'liquid-button' 			=> __( 'Liquid', 'moomoo-extensions-elementor' ),
			'creative-button' 			=> __( 'Creative', 'moomoo-extensions-elementor' ),
			'neon-light' 				=> __( 'Neon Light', 'moomoo-extensions-elementor' ),
			'shiny-glass' 				=> __( 'Shiny Glass', 'moomoo-extensions-elementor' ),
			'cool-button'				=> __( 'Cool','moomoo-extensions-elementor'),
			'animate-border-effect'		=> __( 'Border Effects','moomoo-extensions-elementor'),
			'treat-wrapper'				=> __( 'Treat Button','moomoo-extensions-elementor'),
			'bubbly-button'				=> __( 'Bubbly Button','moomoo-extensions-elementor'),
			'bubble-effect'				=> __( 'Bubble Effect','moomoo-extensions-elementor'),
			'hover-effect'				=> __( 'Hover Effect','moomoo-extensions-elementor'),
			'button-3d'					=> __( '3D Button','moomoo-extensions-elementor'),
			'ghost-button' 				=> __( 'Animated Gradient Ghost Button','moomoo-extensions-elementor')
		];
	}
	public function register_content_section_controls(){

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'button_title',
			array(
				'label'     => __( 'Name', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default' => __( 'Button', 'moomoo-extensions-elementor' )
			)
		);
		$this->add_control(
			'button_link',
			[
				'label' => __( 'Link', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'elementor' ),
				'default' => [
					'url' => '#',
				],
			]
		);
		
		$this->add_control(
			'style_button',
			[
				'label' => __( 'Select style', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' =>  self::get_button_style(),
				'default' => 'glowing-gradient-button'
			]
		);
		
		$this->end_controls_section();
		
	}
	public function register_style_section_controls(){

			$this->general_button_style();
			$this->glowing_gradient_style();
			$this->liquid_button_style();
			$this->creative_button_style();
			$this->neon_light_button_style();
			$this->shyny_glass_button_style();
			$this->cool_button_style();
			$this->border_effect_button_style();
			$this->treat_button_style();
			$this->bubbly_button_style();
			$this->bubble_effect_style();
			$this->hover_effect_style();
			$this->threeD_button_style();
			$this->ghost_button_style();
	}

	private function general_button_style(){
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_control(
			'size_button',
			[
				'label' => __( 'Button Dimension', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'button_width',
			[
				'label' => __( 'Button Width', 'spicy' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','vw'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 700,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 60,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px', 
					'size' => 200,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons .moomoo-btn' => 'width: {{SIZE}}{{UNIT}}; --width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-moomoo-buttons .liquid-button .liquid ' =>'height: {{SIZE}}{{UNIT}}'
				],
			]
		);
		$this->add_responsive_control(
			'button_height',
			[
				'label' => __( 'Button Height', 'spicy' ),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'after',
				'size_units' => [ 'px','vw'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 20,
						'step' => 0.5,
					],
				],
				'default' => [
					'unit' => 'px', 
					'size' => 60,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons .moomoo-btn' => 'height: {{SIZE}}{{UNIT}}; --height: {{SIZE}}{{UNIT}};'

				],
			]
		);
		$this->add_control(
			'custom_button',
			[
				'label' => __( 'Style Button', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'     => __( 'Font style', 'moomoo-extensions-elementor' ),
				'name'      => 'title_button_typography',
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .elementor-moomoo-buttons  .moomoo-btn'

			)
		);
		$this->add_responsive_control(
			'button_align',
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
				'default'=>'center',
				'devices' => [ 'desktop', 'tablet' ],
				'prefix_class' => 'button-align-%s',
			]
		);
		$this->start_controls_tabs( 'tabs_button_style' );
			$this->start_controls_tab(
				'button_normal',
				array(
					'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
				)
			);
				$this->add_control(
				'button_text_color',
					array(
						'label'     => __( 'Text Color', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ccc',
						'selectors' => array(
							'{{WRAPPER}} .elementor-moomoo-buttons  .moomoo-btn' => 'color: {{VALUE}};',
						),
					)
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'button_hover',
						array(
							'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
						)
					);
					$this->add_control(
					'button_text_color_hover',
					array(
						'label'     => __( 'Text Hover', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#fff',
						'selectors' => array(
							'{{WRAPPER}} .elementor-moomoo-buttons  .moomoo-btn:hover' => 'color: {{VALUE}};',
						),
					)
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
		$this->end_controls_section();
	}	
	private function glowing_gradient_style(){
		$this->start_controls_section(
			'style_glowing_gradient',
			[
				'label' => __( 'Style Glowing Gradient', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'glowing-gradient-button')
			]
		);
		$this->add_control(
			'glowing_gradient_border_radius',
			array(
				'label'      => __( 'Rounded Corners', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-moomoo-buttons .glowing-gradient-button, 
					 {{WRAPPER}} .elementor-moomoo-buttons .glowing-gradient-button:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Mmbackgroundgradient::get_type(),
			array(
				'label'     => __( 'Background Gradient', 'moomoo-extensions-elementor' ),
				'name'      => 'bg_gradient',	
				'colors'	=> array('#03a9f4','#f44135','#ffeb3b', '#03a9f4'),					
				'selector'  => '{{WRAPPER}} .glowing-gradient-button, {{WRAPPER}}  .glowing-gradient-button:before'

			)
		);

		$this->end_controls_section();
	}
	private function liquid_button_style(){
		$this->start_controls_section(
			'style_liquid_button',
			[
				'label' => __( 'Style Liquid Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'liquid-button')
			]
		);
		$this->add_control(
			'liquid_border_radius',
			array(
				'label'      => __( 'Rounded Corners', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-moomoo-buttons .liquid-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
				'liquid_bg_color',
				array(
					'label'     => __( 'Background Color', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#4973ff',
					'selectors' => array(
						'{{WRAPPER}} .liquid-button' => 'background: {{VALUE}}',
					),
				)
			);
		$this->end_controls_section();
	}
	private function creative_button_style(){
		$this->start_controls_section(
			'style_creative_button',
			[
				'label' => __( 'Style Creative Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'creative-button')
			]
		);
		
		$this->add_control(
				'creative_bg_Normal',
				array(
					'label'     => __( 'Background Normal', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#0D0D0F',
					'selectors' => array(
						'{{WRAPPER}} .creative-button' => 'background: {{VALUE}}',
					),
				)
			);
		$this->add_control(
				'creative_bg_right',
				array(
					'label'     => __( 'Background Hover', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#9E3D03',
					'selectors' => array(
						'{{WRAPPER}} .creative-button:hover' => 'background: {{VALUE}}',
					),
				)
			);
		$this->add_control(
				'creative_border_color',
				array(
					'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,	
					'default'   =>'#0EE4B8',
					'selectors' => array(
						'{{WRAPPER}} .creative-button span:nth-child(1)' => 'background: linear-gradient(to right,transparent, {{VALUE}})',
						'{{WRAPPER}} .creative-button span:nth-child(2)' => 'background: linear-gradient(to bottom,transparent, {{VALUE}})',
						'{{WRAPPER}} .creative-button span:nth-child(3)' => 'background: linear-gradient(to left,transparent, {{VALUE}})',
						'{{WRAPPER}} .creative-button span:nth-child(4)' => 'background: linear-gradient(to top,transparent, {{VALUE}})',
					),
				)
			);
		$this->add_control(
			'creative_button_speed',
			[
				'label' => __( 'Speed Animation', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 's'],
				'range' => [
					's' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					]
				],
				'default' => [
					'unit' => 's', 
					'size' => 1.8,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons .creative-button  span' => '--time: {{SIZE}}{{UNIT}}'
				],
			]
		);

		$this->end_controls_section();
	}
	private function neon_light_button_style(){
		$this->start_controls_section(
			'style_neon_light_button',
			[
				'label' => __( 'Style Neon Light Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'neon-light')
			]
		);

		$this->add_control(
				'neon_light_border',
				array(
					'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,	
					'default'   =>'#03e9f4',
					'selectors' => array(
						'{{WRAPPER}} .neon-light span:nth-child(1)' => 'background: linear-gradient(90deg,transparent, {{VALUE}})',
						'{{WRAPPER}} .neon-light span:nth-child(2)' => 'background: linear-gradient(180deg,transparent, {{VALUE}})',
						'{{WRAPPER}} .neon-light span:nth-child(3)' => 'background: linear-gradient(270deg,transparent, {{VALUE}})',
						'{{WRAPPER}} .neon-light span:nth-child(4)' => 'background: linear-gradient(360deg,transparent, {{VALUE}})',
					),
				)
			);
		$this->add_control(
				'neon_light_bg_gradient',
				array(
					'label'     => __( 'Background', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,	
					'default'   =>'#000',
					'selectors' => array(
						'{{WRAPPER}} .neon-light' => 'background: {{VALUE}}'
					),
				)
			);
		$this->add_control(
				'neon_light_bg_hover',
				array(
					'label'     => __( 'Background Hover', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,	
					'default'   => '#03e9f4',
					'selectors' => array(
						'{{WRAPPER}} .neon-light:hover' => 'background: {{VALUE}}; box-shadow: 0 0 5px {{VALUE}}, 0 0 25px {{VALUE}}, 0 0 50px {{VALUE}}, 0 0 200px {{VALUE}};',
               
					),
				)
			);

		$this->add_control(
			'neon_light_filter',
			array(
				   'label' => __( 'Filter Color', 'moomoo-extensions-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'deg' ],
					'default' => [
						'unit' => 'deg',
						'size' => 360,
					],
					'range' => [
						'deg' => [
							'step' => 10,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .neon-light' => 'filter: hue-rotate({{SIZE}}{{UNIT}})',
					]
			)
		);
		$this->add_control(
			'neon_light_button_speed',
			[
				'label' => __( 'Speed Animation', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 's'],
				'range' => [
					's' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					]
				],
				'default' => [
					'unit' => 's', 
					'size' => 1,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons .neon-light' => '--time: {{SIZE}}{{UNIT}}'
				],
			]
		);
		
		$this->end_controls_section();
	}
	private function shyny_glass_button_style(){
		$this->start_controls_section(
			'style_shiny_glass_button',
			[
				'label' => __( 'Style Shyny Glass Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'shiny-glass')
			]
		);
		$this->add_control(
			'shyny_glass_bg',
			array(
				'label'     => __( 'Background', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,	
				'default'   => '#57058D',
				'selectors' => array(
					'{{WRAPPER}} .elementor-moomoo-buttons .shiny-glass' => 'background: {{VALUE}}',
           
				),
			)
		);
		$this->add_control(
			'shyny_glass_bg_hover',
			array(
				'label'     => __( 'Background hover', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,	
				'default'   => '#A10274',
				'selectors' => array(
					'{{WRAPPER}} .elementor-moomoo-buttons .shiny-glass:hover' => 'background: {{VALUE}}; --color:  {{VALUE}}',
           
				),
			)
		);
		

		$this->end_controls_section();
	}
	private function cool_button_style(){
		$this->start_controls_section(
			'style_cool_button',
			[
				'label' => __( 'Cool Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'cool-button')
			]
		);
		$this->add_control(
				'cool_bg',
				array(
					'label'     => __( 'Background', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,	
					'default'   => '#000',
					'selectors' => array(
						'{{WRAPPER}} .cool-button' => 'background: {{VALUE}}',
               
					),
				)
			);
		$this->add_control(
				'cool_bg_hover',
				array(
					'label'     => __( 'Background Hover', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,	
					'default'   => '#03a9f4',
					'selectors' => array(
						'{{WRAPPER}} .cool-button:before' => 'background: {{VALUE}}',
               
					),
				)
			);
		$this->end_controls_section();
	}
	private function border_effect_button_style(){
		$this->start_controls_section(
			'style_border_effect_button',
			[
				'label' => __( 'Style Border Effects Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'animate-border-effect')
			]
		);
		$this->add_control(
			'border_effect_bg',
			array(
				'label'     => __( 'Background', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,	
				'default'   => '#fff',
				'selectors' => array(
					'{{WRAPPER}} .animate-border-effect, {{WRAPPER}} .animate-border-effect:before,{{WRAPPER}}  .animate-border-effect:after' => 'background: {{VALUE}}',
           
				),
			)
		);
		$this->add_control(
			'border_effect_bg_hover',
			array(
				'label'     => __( 'Background Hover', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,	
				'default'   => '#fff',
				'selectors' => array(
					'{{WRAPPER}} .animate-border-effect:hover' => 'background: {{VALUE}}',
           
				),
			)
		);
		$this->add_control(
				'border_effect_border',
				array(
					'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,	
					'default'   => '#000',
					'selectors' => array(
						'{{WRAPPER}} .animate-border-effect' => 'border-color: {{VALUE}}',
               
					),
				)
			);
		$this->end_controls_section();
	}
	private function treat_button_style(){
		$this->start_controls_section(
			'style_treat_button',
			[
				'label' => __( 'Style Treat Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'treat-wrapper')
			]
		);
		$this->add_control(
			'emoji_treat',
			array(
				'label'       => __( 'Emoj', 'moomoo-extensions-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'emoji-icon',
				'label_block' => false,
				'options'     => array(
					'emoji-icon'  => __( 'Input Emoji', 'moomoo-extensions-elementor' ),
					'emoji-image'   => __( 'Upload Image', 'moomoo-extensions-elementor' )
				)
			)
		);
		$this->add_control(
			'emoji_icon',
			array(
				'label'     => __( 'emoji_icon', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'show_label'=>false,
				'label_block'=>true,
				'condition' => array(
					'emoji_treat' => 'emoji-icon',
				),
				'default'   => '💖,💖,💖,💖,💖,💖,💖,💖,💖,💖,💖,💖,💖',
				'description' =>'Separate Emoji icon using the comma (,) character.
				You can get Emoji from <a href="https://emojipedia.org/" target="_blank">https://emojipedia.org/</a>.'

			)
		);
		$this->add_responsive_control(
			'emoji_icon_size',
			[
				'label' => __( 'Icon Size', 'spicy' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px', 
					'size' => 35,
				],
				'show_label' => true,
				'condition' => array(
					'emoji_treat' => 'emoji-icon',
				),
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons .treat' => 'font-size: {{SIZE}}{{UNIT}}'
				],
			]
		);
		$this->add_control(
			'emoji_image',
			array(
				'label'     => __( 'emoji_image', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::GALLERY,
				'condition' => array(
					'emoji_treat' => 'emoji-image',
				),
				'show_label'=>false,
				'label_block'=>true,
				'default'   =>  [],
			)
		);
		$this->add_control(
			'image_emoji_size',
			[
				'label' => __( 'Image Dimension', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'condition' => array(
					'emoji_treat' => 'emoji-image',
				)
			]
		);
		$this->add_responsive_control(
			'image_emoji_width',
			[
				'label' => __( 'Image Width', 'spicy' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px', 
					'size' => 70,
				],
				'show_label' => true,
				'condition' => array(
					'emoji_treat' => 'emoji-image',
				),
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons .treat' => 'width: {{SIZE}}{{UNIT}}'
				],
			]
		);
		$this->add_responsive_control(
			'image_emoji_height',
			[
				'label' => __( 'Image Height', 'spicy' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px', 
					'size' => 70,
				],
				'show_label' => true,
				'condition' => array(
					'emoji_treat' => 'emoji-image',
				),
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons .treat' => 'height: {{SIZE}}{{UNIT}}'
				],
			]
		);
		$this->add_control(
			'treat_border_radius',
			array(
				'label'      => __( 'Rounded Corners', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'separator' => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .elementor-moomoo-buttons .treat-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->start_controls_tabs( 'treat_button_style' );

			
			$this->start_controls_tab(
				'treat_button_normal',
				array(
					'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
				)
			);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					array(
						'name'     => 'treat_button_border',
						'label'    => __( 'Border', 'moomoo-extensions-elementor' ),
						'selector' => '{{WRAPPER}} .elementor-moomoo-buttons .treat-button',
					)
				);

				
				$this->add_group_control(
					Group_Control_Background::get_type(),
					array(
						'name'     => 'treat_button_background',
						'label'    => __( 'Background', 'moomoo-extensions-elementor' ),
						'types'    => array( 'classic', 'gradient','video' ),
						'selector' => '{{WRAPPER}} .elementor-moomoo-buttons .treat-button',
					)
				);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'treat_button_hover',
				array(
					'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
				)
			);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					array(
						'name'     => 'treat_button_border_hover',
						'label'    => __( 'Border Hover', 'moomoo-extensions-elementor' ),
						'selector' => '{{WRAPPER}} .elementor-moomoo-buttons .treat-button:hover',
					)
				);

				
				$this->add_group_control(
					Group_Control_Background::get_type(),
					array(
						'name'     => 'treat_button_background_hover',
						'label'    => __( 'Background Hover', 'moomoo-extensions-elementor' ),
						'types'    => array( 'classic', 'gradient','video' ),
						'selector' => '{{WRAPPER}} .elementor-moomoo-buttons .treat-button:hover',
					)
				);
			$this->end_controls_tab();

		$this->end_controls_tabs();
		
		$this->end_controls_section();
	}
	private function bubbly_button_style(){
		$this->start_controls_section(
			'section_bubbly_button_style',
			[
				'label' => __( 'Style Bubly Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'bubbly-button')
			]
		);
		$this->add_control(
			'bubbly_border_radius',
			array(
				'label'      => __( 'Rounded Corners', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'separator' => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .elementor-moomoo-buttons .bubbly-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->start_controls_tabs( 'bubbly_button_style' );

			
			$this->start_controls_tab(
				'bubbly_button_normal',
				array(
					'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
				)
			);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					array(
						'name'     => 'bubbly_button_border',
						'label'    => __( 'Border', 'moomoo-extensions-elementor' ),
						'selector' => '{{WRAPPER}} .elementor-moomoo-buttons .bubbly-button',
					)
				);
				$this->add_control(
					'bubbly_button_background',
					array(
						'label'     => __( 'Background', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,	
						'default'   => '#ff0081',
						'selectors' => array(
							'{{WRAPPER}} .elementor-moomoo-buttons .bubbly-button' => '--bgColor: {{VALUE}}'	               
						),
					)
				);
				
				
			$this->end_controls_tab();
			$this->start_controls_tab(
				'bubbly_button_hover',
				array(
					'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
				)
			);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					array(
						'name'     => 'bubbly_button_border_hover',
						'label'    => __( 'Border Hover', 'moomoo-extensions-elementor' ),
						'selector' => '{{WRAPPER}} .elementor-moomoo-buttons .bubbly-button:hover',
					)
				);

				
				$this->add_control(
					'bubbly_button_background_hover',
					array(
						'label'     => __( 'Background Hover', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,	
						'default'   => '#ff0081',
						'selectors' => array(
							'{{WRAPPER}} .elementor-moomoo-buttons .bubbly-button' => '--bgColorHover: {{VALUE}}'
						),
					)
				);
			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}
	private function bubble_effect_style(){
		$this->start_controls_section(
			'style_bubble_effect_button',
			[
				'label' => __( 'Style Bubble Effect Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'bubble-effect')
			]
		);
		$this->add_control(
			'bubble_hue_rotate',
			array(
				'label'        => __( 'Enable Hue Rotate Effect', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'moomoo-extensions-elementor' ),
				'label_off'    => __( 'No', 'moomoo-extensions-elementor' ),
				'default'      => 'true',
				'label_block'  => false,
				'prefix_class' => 'mm-enable-hue-rotate-',
			)
		);

		$this->start_controls_tabs( 'bubble_button_style' );

			
			$this->start_controls_tab(
				'bubble_button_normal',
				array(
					'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
				)
			);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					array(
						'name'     => 'bubble_button_border',
						'label'    => __( 'Border', 'moomoo-extensions-elementor' ),
						'selector' => '{{WRAPPER}} .mm-bubble-effect .button--bubble__container .mm-effect-button',
					)
				);
				$this->add_control(
					'bubble_button_background',
					array(
						'label'     => __( 'Background', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,	
						'default'   => '',
						'selectors' => array(						
							'{{WRAPPER}} .mm-bubble-effect .button--bubble__container .mm-effect-button,{{WRAPPER}} .mm-bubble-effect .button--bubble__effect-container .circle'=>'background-color: {{VALUE}};'
	               
						),
					)
				);
				
				
			$this->end_controls_tab();
			$this->start_controls_tab(
				'bubble_button_hover',
				array(
					'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
				)
			);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					array(
						'name'     => 'bubble_button_border_hover',
						'label'    => __( 'Border Hover', 'moomoo-extensions-elementor' ),
						'default'   => '#069D5C',
						'selector' => '{{WRAPPER}} .mm-bubble-effect .button--bubble__container .mm-effect-button:hover',
					)
				);

				
				$this->add_control(
					'bubble_button_background_hover',
					array(
						'label'     => __( 'Background Hover', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,	
						'default'   => '#ff0081',
						'selectors' => array(							
							'{{WRAPPER}} .mm-bubble-effect:hover .button--bubble__container .mm-effect-button,{{WRAPPER}} .mm-bubble-effect:hover .button--bubble__effect-container .circle'=>'background-color: {{VALUE}};'
	               
						),
					)
				);
			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}
	private function hover_effect_style(){
		$this->start_controls_section(
			'style_hover_effect_button',
			[
				'label' => __( 'Style Hover Effect Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'hover-effect')
			]
		);
		$this->add_control(
			'hover_effect_style',
			[
				'label' => __( 'Effect style', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' =>  array('fill'=>'Fill','pulse'=>'Pulse','close'=>'Close','raise'=>'Raise','up'=>'Up','slide'=>'Slide','offset'=>'Offset'),
				'default' => 'fill'
			]
		);
		$this->add_control(
			'hover_effect_border_color',
			array(
				'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,	
				'default'   => '#000',
				'selectors' => array(							
					'{{WRAPPER}} .elementor-moomoo-buttons .mm-hover-effect a'=>'border-color: {{VALUE}};'
           
				),
			)
		);
		$this->add_responsive_control(
			'hover_effect_border_width',
			[
				'label' => __( 'Border Width', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px', 
					'size' => 0,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons .mm-hover-effect a' => 'border-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_control(
			'hover_effect_speed',
			[
				'label' => __( 'Speed Animation', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 's'],
				'range' => [
					's' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					]
				],
				'default' => [
					'unit' => 's', 
					'size' => 0.8,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons .mm-hover-effect a' => '--time: {{SIZE}}{{UNIT}}'
				],
			]
		);
		$this->add_control(
			'hover_effect_border_radius',
			array(
				'label'      => __( 'Rounded Corners', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-moomoo-buttons .mm-hover-effect a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->start_controls_tabs( 'hover_effect_button_style' );
			$this->start_controls_tab(
				'button_hover_effect_normal',
					array(
						'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
					)
				);
				$this->add_control(
					'hover_effect_color',
					array(
						'label'     => __( 'Background Color', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,	
						'default'   => '#57058D',
						'selectors' => array(							
							'{{WRAPPER}} .elementor-moomoo-buttons .mm-hover-effect a'=>' background: {{VALUE}}; --bgColor: {{VALUE}}'
		           
						),
					)
				);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'button_hover_effect_hover',
					array(
						'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
					)
				);
				$this->add_control(
						'hover_effect_hover',
						array(
							'label'     => __( 'Background Hover', 'moomoo-extensions-elementor' ),
							'type'      => Controls_Manager::COLOR,	
							'default'   => '#0308EB',
							'selectors' => array(							
								'{{WRAPPER}} .elementor-moomoo-buttons .mm-hover-effect a'=>'--hover: {{VALUE}};'
			           
							),
						)
					);
			$this->end_controls_tab();
		$this->end_controls_tabs();

		/*$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'hover_effect_button_border',
				'label'    => __( 'Border', 'moomoo-extensions-elementor' ),
				'selector' => '{{WRAPPER}} .elementor-moomoo-buttons .mm-hover-effect a',
			)
		);*/
		/*$this->add_control(
			'hover_effect_border_color',
			array(
				'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,	
				'default'   => '#000',
				'selectors' => array(							
					'{{WRAPPER}} {{WRAPPER}} .elementor-moomoo-buttons .mm-hover-effect a'=>'border-color: {{VALUE}};'
           
				),
			)
		);*/
		$this->end_controls_section();
	}
	private function threeD_button_style(){
		$this->start_controls_section(
			'style_3d_button',
			[
				'label' => __( 'Style 3D Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'button-3d')
			]
		);
		$this->add_control(
			'button_3d_border_radius',
			array(
				'label'      => __( 'Rounded Corners', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'separator' => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .elementor-moomoo-buttons .mm-button-3d .button-3d' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'button_3d_border_width',
			[
				'label' => __( 'Border Width', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 4,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px', 
					'size' => 2,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons .button-3d' => 'border-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->start_controls_tabs( 'button_3d_style' );
			
			$this->start_controls_tab(
				'button_3d_normal',
					array(
						'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
					)
				);
				$this->add_control(
					'button_3d_background_1',
					array(
						'label'     => __( 'Background Layer 1', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,	
						'default'   => '#03a9f4',
						'selectors' => array(							
							'{{WRAPPER}} .elementor-moomoo-buttons .mm-button-3d .button-3d'=>'background: {{VALUE}};'
		           
						),
					)
				);
				$this->add_control(
					'button_3d_background_2',
					array(
						'label'     => __( 'Background Layer 2', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,	
						'default'   => '#6ab6f3',
						'selectors' => array(							
							'{{WRAPPER}} .elementor-moomoo-buttons .button-3d::before, {{WRAPPER}} .elementor-moomoo-buttons .button-3d:hover::before'=>'background: {{VALUE}};'
						),
					)
				);
				$this->add_control(
					'button_3d_background_3',
					array(
						'label'     => __( 'Background Layer 3', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,	
						'default'   => '#ade1f9',
						'selectors' => array(							
							'{{WRAPPER}} .elementor-moomoo-buttons .button-3d::before'=>'box-shadow: 0 0 0  {{button_3d_border_width.SIZE}}{{button_3d_border_width.UNIT}} {{button_3d_border_color.VALUE}}, 0  0.5em 0 0 {{VALUE}}',
							'{{WRAPPER}} .elementor-moomoo-buttons .button-3d:hover::before'=>' box-shadow: 0 0 0 {{button_3d_border_width.SIZE}}{{button_3d_border_width.UNIT}} {{button_3d_border_color.VALUE}}, 0 0.4em 0 0 {{VALUE}}',
							'{{WRAPPER}} .elementor-moomoo-buttons .button-3d:active::before'=>' box-shadow: 0 0 0 {{button_3d_border_width.SIZE}}{{button_3d_border_width.UNIT}} {{button_3d_border_color.VALUE}}, 0 0 {{VALUE}}'

		           
						),

					)
				);
				$this->add_control(
					'button_3d_border_color',
					array(
						'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,	
						'default'   => '#009688',
						'selectors' => [
							'{{WRAPPER}} .elementor-moomoo-buttons .button-3d' => ' border-color: {{VALUE}}'
						],
					)
				);
				
			$this->end_controls_tab();
			$this->start_controls_tab(
				'button_3d_hover',
					array(
						'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
					)
				);
				$this->add_control(
						'button_3d_background_hover_1',
						array(
							'label'     => __( 'Background Layer 1', 'moomoo-extensions-elementor' ),
							'type'      => Controls_Manager::COLOR,	
							'default'   => '',
							'selectors' => array(							
								'{{WRAPPER}} .elementor-moomoo-buttons .button-3d:hover'=>'background: {{VALUE}};'
			           
							),
						)
					);
					$this->add_control(
						'button_3d_background-hover_2',
						array(
							'label'     => __( 'Background Layer 2', 'moomoo-extensions-elementor' ),
							'type'      => Controls_Manager::COLOR,	
							'default'   => '',
							'selectors' => array(							
								'{{WRAPPER}} .elementor-moomoo-buttons .button-3d:hover::before'=>'background: {{VALUE}}'
			           
							),
						)
					);
					$this->add_control(
						'button_3d_background_hover_3',
						array(
							'label'     => __( 'Background Layer 3', 'moomoo-extensions-elementor' ),
							'type'      => Controls_Manager::COLOR,	
							'default'   => '',
							'selectors' => array(							
								'{{WRAPPER}} .elementor-moomoo-buttons .button-3d:hover::before'=>' box-shadow: 0 0 0 {{button_3d_border_width.SIZE}}{{button_3d_border_width.UNIT}} {{button_3d_border_hover_color.VALUE}}, 0 0.4em 0 0 {{VALUE}}'
			           
							),
						)
					);
					$this->add_control(
						'button_3d_border_hover_color',
						array(
							'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
							'type'      => Controls_Manager::COLOR,	
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .elementor-moomoo-buttons .button-3d:hover' => 'border-color: {{VALUE}}'
							],
						)
					);
			
			$this->end_controls_tab();

		$this->end_controls_tabs();
		//border-radius //border
		
		
		$this->end_controls_section();
	}
	private function ghost_button_style(){
		$this->start_controls_section(
			'style_ghost_button',
			[
				'label' => __( 'Animated Gradient Ghost Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array('style_button' =>'ghost-button')
			]
		);
		$this->add_control(
			'ghost_title_bg_gradient',
			[
				'label' => __( 'Background Gradient', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'ghost_bg_gradient_1',
			array(
				'label'     => __( 'Color 1', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,	
				'default'   => '#6559ae',
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons a.ghost-button' => '--color1: {{VALUE}}'
				],
			)
		);
		$this->add_control(
			'ghost_bg_gradient_2',
			array(
				'label'     => __( 'Color 2', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,	
				'default'   => '#ff7159',
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons a.ghost-button' => '--color2: {{VALUE}}'
				],
			)
		);
		$this->add_control(
			'ghost_bg_gradient_3',
			array(
				'label'     => __( 'Color 3', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,	
				'default'   => '#6559ae',
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons a.ghost-button' => '--color3: {{VALUE}}'
				],
			)
		);
		/*$this->add_group_control(
			Group_Control_Mmbackgroundgradient::get_type(),
			array(
				'label'     => __( 'Color Gradient', 'moomoo-extensions-elementor' ),
				'name'      => 'ghost_bg_gradient',	
				'colors'	=> array('#6559ae','#ff7159','#6559ae'),					
				'selector'  => '{{WRAPPER}} .elementor-moomoo-buttons a.ghost-button:after ,.elementor-moomoo-buttons a.ghost-button > span '

			)
		);*/
		$this->add_control(
			'ghost_border_width',
			[
				'label' => __( 'Border Width', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','vw'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 3,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px', 
					'size' => 4,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons a.ghost-button' => '--border: {{SIZE}}{{UNIT}}'
				],
			]
		);
		$this->add_control(
			'ghost_button_speed',
			[
				'label' => __( 'Speed Animation', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 's'],
				'range' => [
					's' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					]
				],
				'default' => [
					'unit' => 's', 
					'size' => 3,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-buttons a.ghost-button' => '--time: {{SIZE}}{{UNIT}}'
				],
			]
		);
		
		/*var_dump('{{button_width.SIZE}}-{{SIZE}}');*/
		$this->end_controls_section();
	}
	
	protected function register_controls() {		
		$this->register_content_section_controls();
		$this->register_style_section_controls();
	}
	
	
	protected function render() {
		
		$settings 		= $this->get_settings_for_display();
		$button_title   = $settings['button_title'];
		$style_button   = $settings['style_button'];
		$button_link    = $settings['button_link']; 
		$emoji_treat 	= $settings['emoji_treat'];

		$url 				= $button_link['url'];
		$target 			= ($button_link['is_external'] == 'on') ? 'target="_blank"': '';
		$nofollow 			= $button_link['nofollow'];
		$custom_attributes 	= trim($button_link['custom_attributes']);
		$att_arr 			= explode(',', $custom_attributes);
		$attributes_str 	='';
		
		if(strlen($custom_attributes)>=3){
			foreach ($att_arr as $att) {
				$attr_extract = explode('|', $att);
				$attributes_str .= $attr_extract[0].'="'.$attr_extract[1].'"';
			}
		}

		$treatmojis = [];
		if($style_button =='treat-wrapper'){
			if($emoji_treat == 'emoji-icon'){
				$emoji_icon = explode(',',$settings['emoji_icon']);
				if(@count($emoji_icon)>0){
					foreach ($emoji_icon as $icon) {
						$treatmojis[] = $icon;
					}
				}
				
			}else{
				$emoji_image = $settings['emoji_image'];
				if(@count($emoji_image)>0){
					foreach ($emoji_image as $image) {
						
						$treatmojis[] = "<img src='".$image['url']."'/>";
					}
				}
			}
			
			$treatmojis = htmlentities(json_encode($treatmojis));
		}
		?>
		<div class="moomoo-elementor-extension elementor-moomoo-buttons">
			
			<div class="mm-<?php echo $style_button; ?>">

			<?php

				$html = '';

				switch ($style_button) {
				    case 'liquid-button':
				       $html = '<a class="'. $style_button .' moomoo-btn" href="'.$url.'" '.$target.' '.$attributes_str.' ><span>'.$button_title.'</span><div class="liquid"></div></a>';
				       break;
				    case 'cool-button':
				        $html = '<a class="'. $style_button .' moomoo-btn" href="'.$url.'" '.$target.' '.$attributes_str.' ><span>'.$button_title.'</a>';
				        break;
				    case 'treat-wrapper':
				    	 $html = '<a class="'. $style_button .' moomoo-btn" href="'.$url.'" '.$target.' '.$attributes_str.' ><span class="treat-button" >'.$button_title.'</span><span class="treatmojis hidden">'. $treatmojis.'</span></a>';
				        break;
				    case 'bubbly-button':
				    	  $html = '<a class="'. $style_button .' moomoo-btn" href="'.$url.'" '.$target.' '.$attributes_str.' >'.$button_title.'<div class="bubbly"></div></a>';
				        break;
				  
				    case 'bubble-effect':
					    $html = '<svg xmlns="" version="1.1" class="goo">
							  <defs>
							    <filter id="goo">
							      <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
							      <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
							      <feComposite in="SourceGraphic" in2="goo"/>
							    </filter>
							  </defs>
							</svg>

							<span class="button--bubble__container">
							  <a href="'.$url.'" class="button button--bubble  moomoo-btn" '.$target.' '.$attributes_str.' >
							    '.$button_title.'
							  </a>
							  <span class="button--bubble__effect-container">
							    <span class="circle top-left"></span>
							    <span class="circle top-left"></span>
							    <span class="circle top-left"></span>

							    <span class="mm-effect-button"></span>

							    <span class="circle bottom-right"></span>
							    <span class="circle bottom-right"></span>
							    <span class="circle bottom-right"></span>
							  </span>
							</span>';
						break;
					case 'ghost-button':
						$html ='<a href="'.$url.'" class="ghost-button moomoo-btn" '.$target.' '.$attributes_str.' ><span>'.$button_title.'</span></a>';
						break;
					case 'hover-effect':
						$html ='<a class="'.$settings['hover_effect_style'].' moomoo-btn" '.$target.' '.$attributes_str.' >'.$button_title.'</a>';
						break;
				    default:
				        $html = '<a class="'. $style_button .' moomoo-btn" href="'.$url.'" '.$target.' '.$attributes_str.' ><span></span><span></span><span></span><span></span>'.$button_title.'</a>';
				        break;
				}
				
			?>
			<?php echo $html ?>
				
			</div>
		</div>		
		<?php
	}
	

}