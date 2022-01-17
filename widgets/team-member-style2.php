<?php

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
class Elementor_Team_Member_Style2_Widget extends \Elementor\Widget_Base {
	
	public function __construct( $data = [], $args = null ) {
		$this->_widget_name = $args['widget_name'];
		
		add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
		
		parent::__construct( $data, $args );

		
	}
	public function get_name() {
		return 'moomoo-team-member-style2';
	}
	
	public function get_title() {
		return __( 'Moomoo team member style 2', 'moomoo-extensions-elementor' );
	}

	public function get_icon() {
		return 'eicon-person';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}

	public function ndt_enqueue_scripts() {
		wp_enqueue_style('mm-ext-team-member-style2', plugins_url( 'moomoo-extensions-elementor/assets/css/team-member-style2.css' ), array(), time());
		wp_enqueue_script('mm-team-member-style2', plugins_url( 'moomoo-extensions-elementor/assets/js/team-member-style2.js' ), array(), time());
		
	}

	
	
	protected function _register_controls() {



		$this->start_controls_section(
			'layout_section',
			[
				'label' => __( 'Layout', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'name',
			[
				'label' => __( 'Name', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Daisy', 'moomoo-extensions-elementor' ),
				'placeholder' => __( 'Type your name here', 'moomoo-extensions-elementor' ),
			]
		);

		$this->add_control(
			'designation',
			[
				
				'label' => __( 'Designation', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 4,
				'default' => __( 'Co-Founder, <br>Head of Marketing', 'moomoo-extensions-elementor' ),
				'placeholder' => __( 'Type your name here', 'moomoo-extensions-elementor' ),
			]
		);

		$this->add_control(
			'designation_style',
			[
				
				'label' => __( 'Designation Style', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'below-avatar',
				'options' => [
					'cover-avatar'  => __( 'Cover Avatar', 'moomoo-extensions-elementor' ),
					'below-avatar' => __( 'Below Avatar', 'moomoo-extensions-elementor' )
				],
			]
		);

		$this->add_control(
			'avatar',
			[
				'label' => __( 'Avatar', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://dummyimage.com/300x400/dfa142/fff.gif&text=Avatar-300x400',
				],
			]
		);
	
		
		
		$this->end_controls_section();

		$this->start_controls_section(
			'desc_section',
			[
				'label' => __( 'Description', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'description_left',
			[
				'label' => __( 'Left Description', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Default description', 'moomoo-extensions-elementor' ),
				'placeholder' => __( 'Type your description here', 'moomoo-extensions-elementor' ),
			]
		);
		$this->add_control(
			'description_right',
			[
				'label' => __( 'Right Description', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Default description', 'moomoo-extensions-elementor' ),
				'placeholder' => __( 'Type your description here', 'moomoo-extensions-elementor' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_team_member',
			[
				'label' => __( 'Style layout', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE

			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'label' =>'Name style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .team-memeber>.name name'
				
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'designation_typography',
				'label' =>'Designation style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .team-memeber>.name designation'
				
			]
		);
		
		$this->designation_style_setting();
		$this->description_style_setting();

		$this->end_controls_section();

	}
	private function description_style_setting(){

		$this->add_control(
			'description_heading',
			[
				'label' => __( 'Description Options', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'desc_text',
			[
				'label' => __( 'Text Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' =>Schemes\Color::COLOR_1,
				],
				'default' => '#ffffff',
				'selectors' => [
					'section .member-description .desc-content .detail' => 'color: {{VALUE}}',
					'section .member-description .desc-content:after'=>'background: {{VALUE}}'
				],
				
			]
		);
		$this->add_control(
			'desc_background',
			[
				'label' => __( 'Background Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' =>Schemes\Color::COLOR_1,
				],
				'default' => '#606060',
				'selectors' => [
					'{{WRAPPER}} .team-memeber.active::after, section .member-description' => 'background: {{VALUE}}'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'detail_desc_typography',
				'label' =>'Font Style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => 'section .member-description .detail'
				
			]
		);
	}
	private function designation_style_setting(){
		$this->add_control(
			'designation_heading',
			[
				'label' => __( 'Short Description Option', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->start_controls_tabs( 'designation_tabs' );

		$this->start_controls_tab(
			'designation_normal',
			[
				'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
			]
		);
			$this->add_control(
				'designation_text_color',
				[
					'label' => __( 'Text Color', 'moomoo-extensions-elementor' ),
					'type' => Controls_Manager::COLOR,
					'scheme' => [
						'type' => Schemes\Color::get_type(),
						'value' => '#000000',
					],
					
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .team-memeber-style2 .team-memeber>.name' => 'color: {{VALUE}}'
					],
				]
			);
			$this->add_control(
				'designation_bg_color',
				[
					'label' => __( 'Background Color', 'moomoo-extensions-elementor' ),
					'type' => Controls_Manager::COLOR,
					'scheme' => [
						'type' => Schemes\Color::get_type(),
						'value' => '#ffffff',
					],
					
					'default' => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .team-memeber-style2 .team-memeber>.name' => 'background: {{VALUE}}'
					],
				]
			);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'designation_hover',
			[
				'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
			]
		);

		$this->add_control(
			'designation_text_hover',
			[
				'label' => __( 'Text Hover', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .team-memeber-style2 .team-memeber:hover>.name' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'designation_bg_hover',
			[
				'label' => __( 'Background Hover', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => '#03a9f4',
				],
				
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .team-memeber-style2 .team-memeber:hover>.name' => 'background: {{VALUE}}'
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'designation_active',
			[
				'label' => __( 'Active', 'moomoo-extensions-elementor' ),
			]
		);

		$this->add_control(
			'designation_text_active',
			[
				'label' => __( 'Text Active', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_4,
				],
				
				'selectors' => [
					'{{WRAPPER}} .team-memeber-style2 .team-memeber.active>.name' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'designation_bg_active',
			[
				'label' => __( 'Background Active', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => '#03a9f4',
				],
				
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .team-memeber-style2 .team-memeber.active>.name' => 'background: {{VALUE}}'
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
	}

	protected function render() {

		//$settings = $this->get_active_settings(); 
		$settings = $this->get_settings_for_display();		
		$name 		  = $settings['name'];
      	$designation  = $settings['designation'];
      	$description_left  = $settings['description_left'];
      	$description_right  = $settings['description_right'];
      	$designation_style = $settings['designation_style'];
	
		?>
		<div class="moomoo-elementor-extension team-memeber-style2">
			<div class="mm-ext-team-member-widget">
				
					<?php
				  $html ="<div class='team-memeber read-more  ".$designation_style."'>
					<div class='avatar'>".wp_get_attachment_image( $settings['avatar']['id'], 'full')."</div>
					<div class='name'><name>".$name."</name><designation>$designation</designation></div>
					<div class='description'>
						<div class='desc-content'>
							<div class='detail left-desc'>".$description_left."</div>
							<div class='detail right-desc'>".$description_right."</div>
						</div>					
					</div>
					
				</div>";
				echo $html;
			   ?>
				
			   
			</div>
		</div>
		
		<?php
	}

}