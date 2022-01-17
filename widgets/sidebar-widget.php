<?php

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Elementor_Sidebar_Widget extends \Elementor\Widget_Base {
	
	public function __construct( $data = [], $args = null ) {
		$this->_widget_name = $args['widget_name'];
		
		add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
		
		parent::__construct( $data, $args );

		
	}
	public function get_name() {
		return 'moomoo-sidebar';
	}
	
	public function get_title() {
		return __( 'Moomoo sidebar', 'moomoo-extensions-elementor' );
	}

	public function get_icon() {
		return 'eicon-sidebar';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}

	public function ndt_enqueue_scripts() {
		wp_enqueue_style('mm-ext-sidebar',  MM_EXT_ASSET_URL .'/css/sidebar-widget.css', array(), time());
		//wp_enqueue_script('mm-sticky-sidebar', plugins_url( 'moomoo-extensions-elementor/assets/js/jquery.sticky.min.js' ), array(), '1.0.0');
		//wp_enqueue_script('mm-sidebar-widget',  MM_EXT_ASSET_URL .'/sidebar-widget.js', array(), time(),true);
		
	}

	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}
	
	
	protected function _register_controls() {



		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Menu Sidebar', 'plugin-name' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$menus = $this->get_available_menus();
		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label' => __( 'Select Menu', 'moomoo-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'save_default' => true,
					'separator' => 'after',
					'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'elementor-pro' ), admin_url( 'sidebar-menus.php' ) ),
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<strong>' . __( 'There are no menus in your site.', 'elementor-pro' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'moomoo-elementor' ), admin_url( 'sidebar-menus.php?action=edit&menu=0' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		$this->add_control(
			'sitebar_title',
			[
				
				'label' => __( 'Sitebar Title', 'moomoo-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'MUST READ', 'moomoo-elementor' )
			]
		);
		$this->add_control(
			'sidebar_color_item',
			[
				'label' => __( 'Sitebar Title Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_3,
				],				
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sidebar-menu .sitebar_title h3'=>'color:{{VALUE}}',
					'{{WRAPPER}} .sidebar-menu .sitebar_title hr'=>'border-color:{{VALUE}}'
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sitebar_title_style',
				'label' =>'Sidebar Title style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .sidebar-menu .sitebar_title h3'
				
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label' => __( 'Style Menu', 'moomoo-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE

			]
		);

		$this->start_controls_tabs( 'tabs_menu_item_style' );

		$this->start_controls_tab(
			'tab_menu_item_normal',
			[
				'label' => __( 'Normal', 'elementor-pro' ),
			]
		);
		$this->add_control(
			'color_menu_item',
			[
				'label' => __( 'Menu Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => '#606060',
				],
				
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .moomoo-elementor-extension .sidebar-menu nav ul.elementor-sidebar-menu li a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .moomoo-elementor-extension .icon-close:before, {{WRAPPER}} .moomoo-elementor-extension .icon-close:after' =>'background: {{VALUE}}',
					'{{WRAPPER}} .moomoo-elementor-extension .sidebar-menu nav ul .menu-item-has-children a:before' =>'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .moomoo-elementor-extension .mm-ext-sidebar-widget ul li:before '=>'color:{{VALUE}}'
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_hover',
			[
				'label' => __( 'Hover', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'color_menu_item_hover',
			[
				'label' => __( 'Menu Color Hover', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_4,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .moomoo-elementor-extension .sidebar-menu nav ul.elementor-sidebar-menu li a:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .moomoo-elementor-extension .sidebar-menu nav ul .menu-item-has-children a:hover:before' =>'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .moomoo-elementor-extension .mm-ext-sidebar-widget ul li:hover:before '=>'color:{{VALUE}}'
				]
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typography',
				'label' =>'Menu style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .sidebar-menu nav ul.elementor-sidebar-menu li a',
				'separator' => 'before',
				
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'count_item_menu',
				'label'=> 'Count item menu style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .mm-ext-sidebar-widget ul li:before',
				'separator' => 'before',
				
			]
		);
		$this->add_control(
			'count-item-padding-right',
			[
				'label' => __( 'Count item padding right (px)', 'elementor-pro' ),
				'type' => Controls_Manager::NUMBER,		
                'seperate'=>'before',
                'default' =>60,
                'selectors' => [
                    '{{WRAPPER}} .sidebar-menu nav ul li  ' => 'padding-left:{{VALUE}}px'],
			]
		);
		$this->add_control(
			'box_menu',
			[
			'label' => __( 'Box Menu Padding', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mm-ext-sidebar-widget .sidebar-menu ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'background_menu_item',
			[
				'label' => __( 'Background Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sidebar-menu, {{WRAPPER}} .icon-close' => 'background: {{VALUE}}',
					'{{WRAPPER}} .icon-close'=>'border-color: {{VALUE}}',
					'{{WRAPPER}} .moomoo-elementor-extension .sidebar-menu nav ul .menu-item-has-children a:after' => 'border-top-color: {{VALUE}}'
				],
			]
		);
		

		$this->end_controls_section();
		
		$this->end_controls_section();


	}


	protected function render() {

		//$settings = $this->get_active_settings(); 
		$settings = $this->get_settings_for_display();
		/*echo "<pre>";
		var_dump($settings);
		echo "</pre>";*/
		
		$menu = $settings['menu'];
		$args = [
			'echo' => false,
			'menu' => $settings['menu'],
			'menu_class' => 'elementor-sidebar-menu',
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
			<div class="mm-ext-sidebar-widget">
			    <div class="sidebar-menu">
			    	<div class="sitebar_title"> 
			    		<h3> <?php echo $settings['sitebar_title'] ?> </h3>
			    		<hr>
			    	</div>	
			    	<nav <?php echo $this->get_render_attribute_string( 'main-menu' ); ?>><?php echo $menu_html; ?></nav>
			    </div>
				
			</div>
		</div>
		
		<?php

		

	}

}