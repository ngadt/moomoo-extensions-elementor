<?php

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Elementor_Menu_Widget extends \Elementor\Widget_Base {
	
	public function __construct( $data = [], $args = null ) {
		$this->_widget_name = $this->get_name();
		
		add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
		
		parent::__construct( $data, $args );

		
	}
	public function get_name() {
		return 'moomoo-menu';
	}
	
	public function get_title() {
		return __( 'Moomoo Menu', 'moomoo-extensions-elementor' );
	}

	public function get_icon() {
		return 'fa fa-navicon';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}

	public function ndt_enqueue_scripts() {

		wp_enqueue_style('mm-menu',  MM_EXT_ASSET_URL .'/css/moomoo-menu.css', array(), time());		
		wp_enqueue_script('mm-menu', MM_EXT_ASSET_URL .'/js/moomoo-menu.js', array('jquery'), time(), true);
		
	}

	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}
	
	
	protected function register_controls() {

		$this->register_content_section_controls();		
		$this->register_style_section_controls();

	}
	public function register_content_section_controls(){
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Layout', 'plugin-name' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$menus = $this->get_available_menus();
		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label' => __( 'Select Menu', 'moomoo-extensions-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'save_default' => true,
					'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'moomoo-extensions-elementor' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<strong>' . __( 'There are no menus in your site.', 'moomoo-extensions-elementor' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'moomoo-elementor' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		$this->add_control(
			'style_menu',
			[
				'label' => __( 'Style General', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => array('auto'=>'Auto height','full-height'=>'Full Height Menu'),
				'default' => 'auto',
				'separator' => 'after',
				'prefix_class' => 'mm-style-menu-'
			]
		);

		$this->add_control(
			'image_menu',
			[
				'label' => __( 'Choose Image', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::MEDIA,
			]
		);
		$this->add_control(
			'size_button',
			[
				'label' => __( 'Button', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
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


		$this->end_controls_section();

	}
	public function register_style_section_controls(){

		$this->start_controls_section(
			'section_style_main_menu',
			[
				'label' => __( 'General Style', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .menu-expand nav ul.elementor-nav-menu li a',
				'separator' => 'before',
				
			]
		);
		
		
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_style_menu_item',
				'selector' => '{{WRAPPER}} .menu-expand nav ul.elementor-nav-menu li',
			]
		);
		
		$this->start_controls_tabs( 'tabs_menu_item_style' );

		$this->start_controls_tab(
			'tab_menu_item_normal',
			[
				'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
			]
		);
		$this->add_control(
			'color_menu_item',
			[
				'label' => __( 'Text Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_3,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .moomoo-elementor-extension .menu-expand nav ul.elementor-nav-menu li a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .moomoo-elementor-extension .icon-close:before, {{WRAPPER}} .moomoo-elementor-extension .icon-close:after' =>'background: {{VALUE}}',
					'{{WRAPPER}} .moomoo-elementor-extension .menu-expand nav ul .menu-item-has-children a:before' =>'border-top-color: {{VALUE}}'
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_hover',
			[
				'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
			]
		);

		$this->add_control(
			'color_menu_item_hover',
			[
				'label' => __( 'Text Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .moomoo-elementor-extension .menu-expand nav ul.elementor-nav-menu li a:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .moomoo-elementor-extension .menu-expand nav ul .menu-item-has-children a:hover:before' =>'border-top-color: {{VALUE}}'/*,
					'{{WRAPPER}}  .menu-expand nav ul.elementor-nav-menu li:hover'=>'border-color:{{VALUE}}',*/
				]
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
				
		
		
		$this->end_controls_section();
		$this->style_icon_menu();
		$this->style_icon_close();
		$this->style_wrapper_menu();
		$this->style_image_on_top_menu();
		$this->style_button();

	}
	protected function style_button(){
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => __( 'Button style', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE

			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'     => __( 'Font style', 'moomoo-extensions-elementor' ),
				'name'      => 'title_button_typography',
				'selector'  => '{{WRAPPER}} .mm-ext-navi-menu  .mm-menu-btn a'

			)
		);
		$this->add_control(
			'margin_button',
			array(
				'label'      => __( 'Margin', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .moomoo-elementor-extension .mm-menu-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => '0',
					'bottom' => '0',
					'left'   => '0',
					'right'  => '0',
					'unit'   => 'px',
				),
			)
		);
		$this->add_control(
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
				'prefix_class' => 'button-align-',
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
					'{{WRAPPER}} .mm-ext-navi-menu .mm-menu-btn a' => 'width: {{SIZE}}{{UNIT}}; --width: {{SIZE}}{{UNIT}};'
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
					'{{WRAPPER}} .mm-ext-navi-menu .mm-menu-btn a' => 'height: {{SIZE}}{{UNIT}}; --height: {{SIZE}}{{UNIT}};'

				],
			]
		);
		$this->add_control(
			'button_border_radius',
			array(
				'label'      => __( 'Rounded Corners', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mm-ext-navi-menu .mm-menu-btn a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'treat_button_border_hover',
				'label'    => __( 'Border Hover', 'moomoo-extensions-elementor' ),
				'selector' => '{{WRAPPER}} .mm-ext-navi-menu .mm-menu-btn a',
			)
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
							'{{WRAPPER}} .mm-ext-navi-menu  .mm-menu-btn a' => 'color: {{VALUE}};',
						),
					)
				);
				$this->add_control(
				'button_background_color',
					array(
						'label'     => __( 'Background', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ccc',
						'selectors' => array(
							'{{WRAPPER}} .mm-ext-navi-menu  .mm-menu-btn a' => 'background: {{VALUE}};',
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
							'{{WRAPPER}} .mm-ext-navi-menu  .mm-menu-btn a:hover' => 'color: {{VALUE}};',
						),
					)
				);
					$this->add_control(
				'button_background_color_hover',
					array(
						'label'     => __( 'Background', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ccc',
						'selectors' => array(
							'{{WRAPPER}} .mm-ext-navi-menu  .mm-menu-btn a:hover' => 'background: {{VALUE}};',
						),
					)
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
		$this->end_controls_section();
		
		
	}
	protected function style_wrapper_menu(){
		$this->start_controls_section(
			'section_style_box_menu',
			[
				'label' => __( 'Box Menu', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE

			]
		);
		$this->add_control(
			'background_menu_item',
			[
				'label' => __( 'Background Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .menu-expand, {{WRAPPER}} .icon-close' => 'background: {{VALUE}}',
					'{{WRAPPER}} .icon-close'=>'border-color: {{VALUE}}',
					'{{WRAPPER}} .moomoo-elementor-extension .menu-expand nav ul .menu-item-has-children a:after' => 'border-top-color: {{VALUE}}'
				],
			]
		);
		
		$this->add_responsive_control(
			'menu-margin-top',
			[
				'label' => __( 'Top', 'spicy' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','vhm'],
				'range' => [
					'vhm' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px', 
					'size' => 0,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .moomoo-elementor-extension .menu-expand' => 'top: {{SIZE}}{{UNIT}}'
				],
			]
		);
		
		$this->add_control(
			'padding_menu',
			array(
				'label'      => __( 'Wrapper padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .moomoo-elementor-extension .menu-expand nav ul.elementor-nav-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .moomoo-elementor-extension .mm-menu-btn' => 'padding: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => '20',
					'bottom' => '20',
					'left'   => '20',
					'right'  => '20',
					'unit'   => 'px',
				),
			)
		);
		$this->add_responsive_control(
			'menu-width',
			[
				'label' => __( 'Wrapper Width', 'spicy' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%','px'],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
						'step' => 10,
					],
					'px' => [
						'min' => 200,
						'max' => 1000,
						'step' => 10,
					]
				],
				'default' => [
					'unit' => 'px', 
					'size' => 400,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .moomoo-elementor-extension .open-menu .menu-expand' => 'width: {{SIZE}}{{UNIT}}'
				],
			]
		);
		$this->end_controls_section();
	}
	protected function style_icon_menu(){
		$this->start_controls_section(
			'section_style_menu_icon',
			[
				'label' => __( 'Icon Menu', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE

			]
		);
		$this->add_responsive_control(
			'icon-menu-size',
			[
				'label' => __( 'Size', 'spicy' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [					
					'px' => [
						'min' => 0.5,
						'max' => 5,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px', 
					'size' => 1,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .moomoo-elementor-extension .mm-ext-navi-menu .wrap-menu' => 'transform: scale({{SIZE}});'
				],
			]
		);
		
		$this->add_responsive_control(
			'icon-menu-radius',
			array(
				'label'      => __( 'Rounded Corners Icon', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '0',
					'bottom' => '0',
					'left'   => '0',
					'right'  => '0',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .moomoo-elementor-extension .open-menu.mm-ext-navi-menu .wrap-menu a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->start_controls_tabs( 'tabs_icon_menu_style' );

			$this->start_controls_tab(
				'icon_menu_normal',
				array(
					'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
				)
			);
				
				$this->add_responsive_control(
					'color-menu-icon-normal',
					[
						'label' => __( 'Color', 'moomoo-extensions-elementor' ),
						'type' => Controls_Manager::COLOR,  
						'default'=>'#fff',    
		                'selectors' => [
		                    '{{WRAPPER}} .moomoo-elementor-extension .wrap-menu a .icon-menu:before,
		                    {{WRAPPER}} .moomoo-elementor-extension .wrap-menu a  .icon-menu:after, 
		                    {{WRAPPER}} .moomoo-elementor-extension .wrap-menu a .icon-menu' => 'background: {{VALUE}};'],
					]
				);
				$this->add_responsive_control(
					'background-menu-icon',
					[
						'label' => __( 'Background', 'moomoo-extensions-elementor' ),
						'type' => Controls_Manager::COLOR,
						'default'=>'#000',
		                'selectors' => [
		                    '{{WRAPPER}} .moomoo-elementor-extension .wrap-menu a' => 'background:{{VALUE}};'],
					]
				);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'icon-menu-hover',
				array(
					'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
				)
			);
				
				$this->add_responsive_control(
					'color-menu-icon-hover',
					[
						'label' => __( 'Color', 'moomoo-extensions-elementor' ),
						'type' => Controls_Manager::COLOR,      
		                'selectors' => [
		                    '{{WRAPPER}} .moomoo-elementor-extension .wrap-menu a:hover .icon-menu:before,
		                    {{WRAPPER}} .moomoo-elementor-extension .wrap-menu a:hover  .icon-menu:after, 
		                    {{WRAPPER}} .moomoo-elementor-extension .wrap-menu a:hover .icon-menu ' => 'background: {{VALUE}};'],
					]
				);
				$this->add_responsive_control(
					'background-menu-icon-hover',
					[
						'label' => __( 'Background', 'moomoo-extensions-elementor' ),
						'type' => Controls_Manager::COLOR,
		                'selectors' => [
		                    '{{WRAPPER}} .moomoo-elementor-extension .wrap-menu:hover a' => 'background:{{VALUE}};'],
					]
				);
			$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}
	protected function style_icon_close(){
		$this->start_controls_section(
			'section_style_close_icon',
			[
				'label' => __( 'Icon Close', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE

			]
		);
		$this->add_control(
			'icon_close',
			[
				'label' => __( 'Icon', 'text-domain' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-times',
					'library' => 'solid',
				],
			]
		);
		$this->add_responsive_control(
			'icon_close_top',
			[
				'label' => __( 'Top', 'spicy' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%','px'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 10,
					]
				],
				'default' => [
					'unit' => 'px', 
					'size' => 10,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .moomoo-elementor-extension .mm-icon-close' => 'top: {{SIZE}}{{UNIT}}'
				],
			]
		);
		$this->add_responsive_control(
			'icon_close_left',
			[
				'label' => __( 'Left', 'spicy' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%','px'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 10,
					]
				],
				'default' => [
					'unit' => 'px', 
					'size' => 20,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .moomoo-elementor-extension .mm-icon-close' => 'left: {{SIZE}}{{UNIT}}'
				],
			]
		);
		
		$this->add_responsive_control(
			'icon_close_size',
			[
				'label' => __( 'Size', 'spicy' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','em'],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px', 
					'size' => 25,
				],
				'show_label' => true,
				'selectors' => [
					'{{WRAPPER}} .moomoo-elementor-extension .mm-icon-close i' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .moomoo-elementor-extension .mm-icon-wrapper' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}'
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon_close_style' );

			$this->start_controls_tab(
				'icon_close_normal',
				array(
					'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
				)
			);
				
				$this->add_control(
					'icon_close_color',
					array(
						'label'     => __( 'Icon Color', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
							'{{WRAPPER}} .moomoo-elementor-extension .mm-icon-close i' => 'color: {{VALUE}};',
						),
					)
				);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'icon_close_hover',
				array(
					'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
				)
			);
				
				$this->add_control(
					'icon_close_color_hover',
					array(
						'label'     => __( 'Icon Color', 'moomoo-extensions-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
							'{{WRAPPER}} .moomoo-elementor-extension .mm-icon-close i:hover' => 'color: {{VALUE}};',
						),
					)
				);
			$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}
	protected function style_image_on_top_menu(){
		$this->start_controls_section(
			'section_style_on_top_menu',
			[
				'label' => __( 'Image Style', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE

			]
		);
		$this->add_responsive_control(
			'image_align',
			array(
				'label'     => __( 'Image Alignment', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'moomoo-extensions-elementor' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'moomoo-extensions-elementor' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'moomoo-extensions-elementor' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .moomoo-elementor-extension .mm-menu-image' => 'text-align: {{VALUE}};'
				),
				'toggle'    => false,
			)
		);
		$this->add_responsive_control(
			'image_menu_padding',
			array(
				'label'      => __( 'Padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '0',
					'bottom' => '0',
					'left'   => '0',
					'right'  => '0',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .moomoo-elementor-extension .mm-menu-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				),
			)
		);

		$this->end_controls_section();
	}
	protected function render() {

		//$settings = $this->get_active_settings(); 
		$settings = $this->get_settings_for_display();
		/*echo "<pre>";
		var_dump($settings);
		echo "</pre>";*/
		
		$menu = $settings['menu'];
		
		$button_title   = $settings['button_title'];
		$button_link    = $settings['button_link'];
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

		$args = [
			'echo' => false,
			'menu' => $settings['menu'],
			'menu_class' => 'elementor-nav-menu',
			'menu_id' => 'menu-' . $this->get_id(),
			'fallback_cb' => '__return_empty_string',
			'container' => '',
		];

		$menu_html = wp_nav_menu( $args );
		if ( empty( $menu_html ) ) {
			return;
		}
		
		add_filter( 'nav_menu_item_id', '__return_empty_string' );
		?>
		<div class="moomoo-elementor-extension">
			<div class="mm-ext-navi-menu">
				<div class="wrap-menu">
			        <a href="#"><span class="icon-menu"></span></a>
			    </div>
			    <div class="menu-expand">
			    	<div class="mm-icon-close">
			    		<div class="mm-icon-wrapper">
							<?php \Elementor\Icons_Manager::render_icon( $settings['icon_close'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
			    	</div>
			    	<div class="mm-menu-image">
			    		<?php echo wp_get_attachment_image( $settings['image_menu']['id'], 'full' ); ?>
			    	</div>
			    	<nav <?php echo $this->get_render_attribute_string( 'main-menu' ); ?>><?php echo $menu_html; ?></nav>
			    	<div class="mm-menu-btn">
			    		<a class="" href="<?php echo $url; ?>" <?php echo $target.' '.$attributes_str ?> ><?php echo $button_title;?></a>
			    	</div>
			    </div>
				
			</div>
		</div>
		
		<?php

		

	}

}