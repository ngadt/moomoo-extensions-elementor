<?php

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
class Elementor_Team_Member_Widget extends \Elementor\Widget_Base {
	
	public function __construct( $data = [], $args = null ) {
		$this->_widget_name = $args['widget_name'];
		
		add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
		
		parent::__construct( $data, $args );

		
	}
	public function get_name() {
		return 'moomoo-team-member';
	}
	
	public function get_title() {
		return __( 'Moomoo team member', 'moomoo-extensions-elementor' );
	}

	public function get_icon() {
		return 'eicon-person';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}

	public function ndt_enqueue_scripts() {
		wp_enqueue_style('mm-ext-team-member', plugins_url( 'moomoo-extensions-elementor/assets/css/team-member.css' ), array(), time());
		wp_enqueue_script('mm-team-member-widget', plugins_url( 'moomoo-extensions-elementor/assets/js/team-member.js' ), array(), time());
		
	}

	
	
	protected function _register_controls() {



		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Team Member', 'moomoo-extensions-elementor' ),
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
			'avatar',
			[
				'label' => __( 'Avatar', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://dummyimage.com/330x355/dfa142/fff.gif&text=Avatar-330x355',
				],
			]
		);
		$this->add_control(
			'avatar_desc',
			[
				'label' => __( 'Avatar on description', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://dummyimage.com/260x500/dfa142/fff.gif&text=Avatar-260x500',
				],
			]
		);
		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Default description', 'moomoo-extensions-elementor' ),
				'placeholder' => __( 'Type your description here', 'moomoo-extensions-elementor' ),
			]
		);
		
		$this->end_controls_section();
		$this->start_controls_section(
			'section_style_team_member',
			[
				'label' => __( 'Style layout', 'moomoo-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE

			]
		);
		$this->add_control(
			'color_text',
			[
				'label' => __( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
				'default' => '#606060',
				'selectors' => [
					'{{WRAPPER}} .team-memeber>.name' => 'color: {{VALUE}}'
				],
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
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' =>'Button style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .team-memeber>.name view-more'
				
				
			]
		);
		$this->add_control(
			'desc_text',
			[
				'label' => __( 'Description Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' =>Schemes\Color::COLOR_1,
				],
				'default' => '#606060',
				'selectors' => [
					'section .member-description .desc-content' => 'color: {{VALUE}}',
					'section .member-description h5.name'=>'border-color: {{VALUE}}'
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_desc_typography',
				'label' =>'Description Name Style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => 'section .member-description h5.name'
				
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'detail_desc_typography',
				'label' =>'Description Detail Style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => 'section .member-description .detail'
				
			]
		);
		$this->end_controls_section();

	}


	protected function render() {

		//$settings = $this->get_active_settings(); 
		$settings = $this->get_settings_for_display();		
		$name 		  = $settings['name'];
      	$designation  = $settings['designation'];
      	$description  = $settings['description'];
	
		?>
		<div class="moomoo-extensions-elementor-extension">
			<div class="mm-ext-team-member-widget">
				
					<?php
				  $html ="<div class='team-memeber read-more'>
					<div class='avatar'>".wp_get_attachment_image( $settings['avatar']['id'], 'full')."</div>
					
					<div class='description'>
						<div class='desc-avatar'>".wp_get_attachment_image( $settings['avatar_desc']['id'], 'full')."</div>
						<div class='desc-content'>
							<h5 class='name'>$name</h5>
							<designation>$designation</designation>
							<div class='designation'><strong>Designation:</strong>$designation</div>
							<div class='detail'>".$description."</div>
						</div>					
					</div>
					<div class='name'><name>".$name."</name><designation>$designation</designation><view-more>View More ></view-more></div>
				</div>";
				echo $html;
			   ?>
				
			   
			</div>
		</div>
		
		<?php
	}

}