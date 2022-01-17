<?php


use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use ElementorPro\Base\Base_Widget;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Elementor_MoomooSlides extends \Elementor\Widget_Base {

	public function __construct( $data = [], $args = null ) {
		$this->_widget_name = self::get_name();
		
		add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
		
		parent::__construct( $data, $args );
		
	}
	public function ndt_enqueue_scripts() {
		wp_enqueue_style('mm-slides',MM_EXT_ASSET_URL .'/css/moomoo-slides.css', array(), time());
		wp_enqueue_style('mm-swiper', MM_EXT_ASSET_URL .'/css/swiper-bundle.min.css', array(), time());
		
		wp_enqueue_script('mm-swiper',MM_EXT_ASSET_URL .'/js/swiper-bundle.min.js',array('jquery'), time(), true);
		wp_enqueue_script('mm-slides',MM_EXT_ASSET_URL .'/js/moomoo-slides.js',array('mm-swiper'), time(), true);
		
	}

	public function get_name() {
		return 'moomoo-slides';
	}

	public function get_title() {
		return __( 'Moomoo Slides', 'moomoo-extensions-elementor' );
	}

	public function get_icon() {
		return 'eicon-slides';
	}

	public function get_keywords() {
		return [ 'slides', 'carousel', 'image', 'title', 'slider' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded','swiper-js' ];
	}

	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'moomoo-extensions-elementor' ),
			'sm' => __( 'Small', 'moomoo-extensions-elementor' ),
			'md' => __( 'Medium', 'moomoo-extensions-elementor' ),
			'lg' => __( 'Large', 'moomoo-extensions-elementor' ),
			'xl' => __( 'Extra Large', 'moomoo-extensions-elementor' ),
		];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => __( 'Slides', 'moomoo-extensions-elementor' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );

		$repeater->start_controls_tab( 'background', [ 'label' => __( 'Image', 'moomoo-extensions-elementor' ) ] );

		
		$repeater->add_control(
			'background_image',
			[
				'label' => _x( 'Image', 'Background Control', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/600x350/09f/fff/',
				],
			]
		);
		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'content', [ 'label' => __( 'Content', 'moomoo-extensions-elementor' ) ] );

		$repeater->add_control(
			'heading',
			[
				'label' => __( 'Title & Description', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Slide Heading', 'moomoo-extensions-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => __( 'Description', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'moomoo-extensions-elementor' ),
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click Here', 'moomoo-extensions-elementor' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'moomoo-extensions-elementor' ),
			]
		);

		$repeater->add_control(
			'link_click',
			[
				'label' => __( 'Apply Link On', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'slide' => __( 'Whole Slide', 'moomoo-extensions-elementor' ),
					'button' => __( 'Button Only', 'moomoo-extensions-elementor' ),
				],
				'default' => 'slide',
				'conditions' => [
					'terms' => [
						[
							'name' => 'link[url]',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'style', [ 'label' => __( 'Style', 'moomoo-extensions-elementor' ) ] );

		$repeater->add_control(
			'custom_style',
			[
				'label' => __( 'Custom', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => __( 'Set custom style that will only affect this specific slide.', 'moomoo-extensions-elementor' ),
			]
		);

		$repeater->add_control(
			'horizontal_position',
			[
				'label' => __( 'Horizontal Position', 'moomoo-extensions-elementor' ),
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
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-contents' => 'text-align: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left' => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right' => 'margin-left: auto',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		

		$repeater->add_control(
			'vertical_position',
			[
				'label' => __( 'Vertical Position', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-text' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'content_color',
			[
				'label' => __( 'Content Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-text .elementor-slide-heading' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-text .elementor-slide-description' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-text .elementor-slide-button' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'repeater_text_shadow',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-contents',
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label' => __( 'Slides', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'heading' => __( 'Slide 1 Heading', 'moomoo-extensions-elementor' ),
						'description' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'moomoo-extensions-elementor' ),
						'button_text' => __( 'Click Here', 'moomoo-extensions-elementor' ),
						'background_image' => 'https://via.placeholder.com/600x350/09f/fff/',
					],
					[
						'heading' => __( 'Slide 2 Heading', 'moomoo-extensions-elementor' ),
						'description' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'moomoo-extensions-elementor' ),
						'button_text' => __( 'Click Here', 'moomoo-extensions-elementor' ),
						'background_image' => 'https://via.placeholder.com/600x350/09f/fff/',
					],
					[
						'heading' => __( 'Slide 3 Heading', 'moomoo-extensions-elementor' ),
						'description' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'moomoo-extensions-elementor' ),
						'button_text' => __( 'Click Here', 'moomoo-extensions-elementor' ),
						'background_image' => 'https://via.placeholder.com/600x350/09f/fff/',
					],
				],
				'title_field' => '{{{ heading }}}',
			]
		);

		/*Ken Burns Effect
*/

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => __( 'Slider Options', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'both' => __( 'Arrows and Dots', 'moomoo-extensions-elementor' ),
					'arrows' => __( 'Arrows', 'moomoo-extensions-elementor' ),
					'dots' => __( 'Dots', 'moomoo-extensions-elementor' ),
					'none' => __( 'None', 'moomoo-extensions-elementor' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => __( 'Pause on Hover', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'render_type' => 'none',
				'frontend_available' => true,
				'condition' => [
					'autoplay!' => '',
				],
			]
		);

		$this->add_control(
			'pause_on_interaction',
			[
				'label' => __( 'Pause on Interaction', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'render_type' => 'none',
				'frontend_available' => true,
				'condition' => [
					'autoplay!' => '',
				],
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => __( 'Autoplay Speed', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 2000,
				'condition' => [
					'autoplay' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide' => 'transition-duration: calc({{VALUE}}ms*1.2)',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label' => __( 'Infinite Loop', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'transition',
			[
				'label' => __( 'Transition', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => __( 'Slide', 'moomoo-extensions-elementor' ),
					'fade' => __( 'Fade', 'moomoo-extensions-elementor' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'transition_speed',
			[
				'label' => __( 'Transition Speed', 'moomoo-extensions-elementor' ) . ' (ms)',
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_slides',
			[
				'label' => __( 'Slides', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label' => __( 'Image Width', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1920,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'size' => '50',
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-image' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'image_padding',
			[
				'label' => __( 'Image Padding', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slides_padding',
			[
				'label' => __( 'Content Padding', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-text .swiper-slide-contents' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'image_position',
			[
				'label' => __( 'Image Position', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
					'topp' => [
						'title' => __( 'Top', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'prefix_class' => 'image-position-%s',
			]
		);

		$this->add_control(
			'slides_vertical_position',
			[
				'label' => __( 'Vertical Position', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'middle',
				'options' => [
					'top' => [
						'title' => __( 'Top', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'prefix_class' => 'elementor--v-position-',
			]
		);

		$this->add_responsive_control(
			'slides_text_align',
			[
				'label' => __( 'Text Align', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'moomoo-extensions-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-text' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .swiper-slide-contents',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_slide',
				'types'          => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .mm-wrap-content',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Title', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_spacing',
			[
				'label' => __( 'Spacing', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-text .elementor-slide-heading:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Text Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-heading' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .elementor-slide-heading',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_description',
			[
				'label' => __( 'Description', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'description_spacing',
			[
				'label' => __( 'Spacing', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-text .elementor-slide-description:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Text Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-description' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .elementor-slide-description',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => __( 'Button', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'button_margin',
			[
				'label' => __( 'Margin', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label' => __( 'Size', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => self::get_button_sizes(),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .elementor-slide-button',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
			]
		);

		$this->add_control(
			'button_border_width',
			[
				'label' => __( 'Border Width', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => __( 'Normal', 'moomoo-extensions-elementor' ) ] );

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => __( 'Background Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => __( 'Border Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover', [ 'label' => __( 'Hover', 'moomoo-extensions-elementor' ) ] );

		$this->add_control(
			'button_hover_text_color',
			[
				'label' => __( 'Text Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label' => __( 'Background Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label' => __( 'Navigation', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label' => __( 'Arrows', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label' => __( 'Arrows Position', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'inside' => __( 'Inside', 'moomoo-extensions-elementor' ),
					'outside' => __( 'Outside', 'moomoo-extensions-elementor' ),
				],
				'prefix_class' => 'elementor-arrows-position-',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-swiper-button' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => __( 'Arrows Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-swiper-button' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label' => __( 'Dots', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => __( 'Dots Position', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'outside' => __( 'Outside', 'moomoo-extensions-elementor' ),
					'inside' => __( 'Inside', 'moomoo-extensions-elementor' ),
					'custom' => __( 'Custom', 'moomoo-extensions-elementor' ),
				],
				'prefix_class' => 'elementor-pagination-position-',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);
		$this->add_responsive_control(
			'dots_position_top',
			[
				'label' => __( 'Top', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%','px' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 95,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .moomoo-swiper-pagination' => 'top: {{SIZE}}{{UNIT}}; position: absolute; width: auto'
				],
				
				'condition' => [
					'dots_position' => 'custom',
				],
			]
		);
		$this->add_responsive_control(
			'dots_position_left',
			[
				'label' => __( 'Left', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%','px'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 95,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 46,
				],
				'selectors' => [
					'{{WRAPPER}} .moomoo-swiper-pagination' => 'left: {{SIZE}}{{UNIT}}; position: absolute; width: auto'
				],

				'condition' => [
					'dots_position' => 'custom',
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .swiper-container-horizontal .swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .swiper-pagination-fraction' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label' => __( 'Dots Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		

		$slide_setting = array(
			'autoplay' 				=> $settings['autoplay'],
			'autoplay_speed'		=> $settings['autoplay_speed'],
			'infinite'				=> $settings['infinite'],
			'navigation'			=> $settings['navigation'],
			'pause_on_hover'		=> $settings['pause_on_hover'],
			'pause_on_interaction'	=> $settings['pause_on_interaction'],
			'transition'			=> $settings['transition'],
			'transition_speed'		=> $settings['transition_speed']

		);
		$slide_setting = json_encode($slide_setting);


		if ( empty( $settings['slides'] ) ) {
			return;
		}

		$this->add_render_attribute( 'button', 'class', [ 'elementor-button', 'elementor-slide-button' ] );

		if ( ! empty( $settings['button_size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['button_size'] );
		}

		$slides = [];
		$slide_count = 0;

		foreach ( $settings['slides'] as $slide ) {
			$slide_html = '';
			$btn_attributes = '';
			$slide_attributes = '';
			$slide_element = 'div';
			$btn_element = 'div';
			$image  = $slide['background_image'];

			if ( ! empty( $slide['link']['url'] ) ) {
				$this->add_link_attributes( 'slide_link' . $slide_count, $slide['link'] );

				if ( 'button' === $slide['link_click'] ) {
					$btn_element = 'a';
					$btn_attributes = $this->get_render_attribute_string( 'slide_link' . $slide_count );
				} else {
					$slide_element = 'a';
					$slide_attributes = $this->get_render_attribute_string( 'slide_link' . $slide_count );
				}
			}

			$slide_html .= '<' . $slide_element . ' class="swiper-slide-text" ' . $slide_attributes . '>';

			$slide_html .= '<div class="swiper-slide-contents">';

			if ( $slide['heading'] ) {
				$slide_html .= '<div class="elementor-slide-heading">' . $slide['heading'] . '</div>';
			}

			if ( $slide['description'] ) {
				$slide_html .= '<div class="elementor-slide-description">' . $slide['description'] . '</div>';
			}

			if ( $slide['button_text'] ) {
				$slide_html .= '<' . $btn_element . ' ' . $btn_attributes . ' ' . $this->get_render_attribute_string( 'button' ) . '>' . $slide['button_text'] . '</' . $btn_element . '>';
			}

			$slide_html .= '</div></' . $slide_element . '>';
			$ken_class = '';
			$slide_html = '<div class="mm-wrap-content"><div class="swiper-slide-image' . $ken_class . '">'.wp_get_attachment_image( $slide['background_image']['id'], 'full').'</div>' . $slide_html.'</div>';

			$slides[] = '<div class="elementor-repeater-item-' . $slide['_id'] . ' swiper-slide">' . $slide_html . '</div>';
			$slide_count++;
		}

		$prev = 'left';
		$next = 'right';
		$direction = 'ltr';

		if ( is_rtl() ) {
			$prev = 'right';
			$next = 'left';
			$direction = 'rtl';
		}

		$show_dots = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
		$show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

		$slides_count = count( $settings['slides'] );
		?>
		<div class="elementor-swiper">
			<div class="elementor-slides-wrapper elementor-main-swiper swiper-container moomoo-swiper-container" dir="<?php echo $direction; ?>" data-animation="<?php echo $settings['content_animation']; ?>" data-settings ='<?php echo $slide_setting; ?>'>
				<div class="swiper-wrapper elementor-slides">
					<?php echo implode( '', $slides ); ?>
				</div>
				<?php if ( 1 < $slides_count ) : ?>
					<?php if ( $show_dots ) : ?>
						<div class="swiper-pagination moomoo-swiper-pagination"></div>
					<?php endif; ?>
					<?php if ( $show_arrows ) : ?>
						<div class="elementor-swiper-button elementor-swiper-button-prev moomoo-swiper-button-prev">
							<i class="eicon-chevron-<?php echo $prev; ?>" aria-hidden="true"></i>
							<span class="elementor-screen-only"><?php _e( 'Previous', 'moomoo-extensions-elementor' ); ?></span>
						</div>
						<div class="elementor-swiper-button elementor-swiper-button-next moomoo-swiper-button-next">
							<i class="eicon-chevron-<?php echo $next; ?>" aria-hidden="true"></i>
							<span class="elementor-screen-only"><?php _e( 'Next', 'moomoo-extensions-elementor' ); ?></span>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
