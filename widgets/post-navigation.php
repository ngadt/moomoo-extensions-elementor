<?php
//namespace ElementorPro\Modules\ThemeElements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
use ElementorPro\Core\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Post_Navigation_Widget extends \Elementor\Widget_Base {

	public function __construct( $data = [], $args = null ) {
		$this->_widget_name = $args['widget_name'];
		
		add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
		
		parent::__construct( $data, $args );
		
		
	}

	public function ndt_enqueue_scripts() {
		wp_enqueue_style('mm-posts-navigation', plugins_url( 'moomoo-extensions-elementor/assets/css/post-navigation.css' ), array(), time());
	}

	public function get_name() {
		return 'moomoo-post-navigation';
	}

	public function get_title() {
		return __( 'MooMoo Post Navigation', 'elementor-pro' );
	}

	public function get_icon() {
		return 'eicon-post-navigation';
	}

	public function get_categories() {
		return [ 'theme-elements-single' ];
	}

	public function get_keywords() {
		return [ 'post', 'navigation', 'menu', 'links' ];
	}

	public function get_script_depends() {
		return [ 'moomoo-post-navigation' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_post_navigation_content',
			[
				'label' => __( 'Post Navigation', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'show_label',
			[
				'label' => __( 'Label', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor-pro' ),
				'label_off' => __( 'Hide', 'elementor-pro' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'label_color',
			[
				'label' => __( 'Label Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_2,
				],
				
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-post-navigation span.moomoo-post-navigation__prev--label, {{WRAPPER}} .elementor-moomoo-post-navigation span.moomoo-post-navigation__next--label'=>'color:{{VALUE}}'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' =>'Label style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .elementor-moomoo-post-navigation span.moomoo-post-navigation__prev--label, {{WRAPPER}} .elementor-moomoo-post-navigation span.moomoo-post-navigation__next--label'
				
				
			]
		);


		$this->add_control(
			'prev_label',
			[
				'label' => __( 'Previous Label', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Previous', 'elementor-pro' ),
				'condition' => [
					'show_label' => 'yes',
				],
			]
		);

		$this->add_control(
			'next_label',
			[
				'label' => __( 'Next Label', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Next', 'elementor-pro' ),
				'condition' => [
					'show_label' => 'yes',
				],
				'separator' => 'after'
			]
		);
		

		$this->add_control(
			'show_arrow',
			[
				'label' => __( 'Arrows', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor-pro' ),
				'label_off' => __( 'Hide', 'elementor-pro' ),
				'default' => 'yes',
			]
		);

		

		$this->add_control(
			'arrow_prev',
			[
				'label' => __( 'Arrows Prev Icon', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::ICONS,				
				'condition' => [
					'show_arrow' => 'yes',
				]
			]
		);
		$this->add_control(
			'arrow_next',
			[
				'label' => __( 'Arrows Next Icon', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'condition' => [
					'show_arrow' => 'yes',
				],
				'separator' => 'after'
			]
		);
		
		/*$this->add_control(
			'arrow_color',
			[
				'label' => __( 'Arrow Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_4,
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-post-navigation i.fa'=>'color:{{VALUE}}'
				]
			]
		);*/

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Post Title', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor-pro' ),
				'label_off' => __( 'Hide', 'elementor-pro' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'post_title_color',
			[
				'label' => __( 'Post Title Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],				
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-post-navigation span.moomoo-post-navigation__prev--title, {{WRAPPER}} .elementor-moomoo-post-navigation span.moomoo-post-navigation__next--title'=>'color:{{VALUE}}'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'post_title_typography',
				'label' =>'Post Title style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .elementor-moomoo-post-navigation span.moomoo-post-navigation__prev--title, {{WRAPPER}} .elementor-moomoo-post-navigation span.moomoo-post-navigation__next--title',
				'separator' => 'after',
				
			]
		);
		
		/*$this->add_control(
			'show_borders',
			[
				'label' => __( 'Borders', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor-pro' ),
				'label_off' => __( 'Hide', 'elementor-pro' ),
				'default' => 'yes',
				'prefix_class' => 'elementor-moomoo-post-navigation-borders-',
			]
		);*/

		// Filter out post type without taxonomies
		$post_type_options = [];
		$post_type_taxonomies = [];
		foreach ( Utils::get_public_post_types() as $post_type => $post_type_label ) {
			$taxonomies = Utils::get_taxonomies( [ 'object_type' => $post_type ], false );
			if ( empty( $taxonomies ) ) {
				continue;
			}

			$post_type_options[ $post_type ] = $post_type_label;
			$post_type_taxonomies[ $post_type ] = [];
			foreach ( $taxonomies as $taxonomy ) {
				$post_type_taxonomies[ $post_type ][ $taxonomy->name ] = $taxonomy->label;
			}
		}

		$this->add_control(
			'in_same_term',
			[
				'label' => __( 'In same Term', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $post_type_options,
				'default' => '',
				'multiple' => true,
				'label_block' => true,
				'description' => __( 'Indicates whether next post must be within the same taxonomy term as the current post, this lets you set a taxonomy per each post type', 'elementor-pro' ),
				'separator' => 'before',

			]
		);

		foreach ( $post_type_options as $post_type => $post_type_label ) {
			$this->add_control(
				$post_type . '_taxonomy',
				[
					'label' => $post_type_label . ' ' . __( 'Taxonomy', 'elementor-pro' ),
					'type' => Controls_Manager::SELECT,
					'options' => $post_type_taxonomies[ $post_type ],
					'default' => '',
					'condition' => [
						'in_same_term' => $post_type,
					],
				]
			);
		}

		$this->end_controls_section();

		$this->start_controls_section(
			'label_style',
			[
				'label' => __( 'Label', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_label' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_label_style' );

		$this->start_controls_tab(
			'label_color_normal',
			[
				'label' => __( 'Normal', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} span.moomoo-post-navigation__prev--label' => 'color: {{VALUE}};',
					'{{WRAPPER}} span.moomoo-post-navigation__next--label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'label_color_hover',
			[
				'label' => __( 'Hover', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'label_hover_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} span.moomoo-post-navigation__prev--label:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} span.moomoo-post-navigation__next--label:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} span.moomoo-post-navigation__prev--label, {{WRAPPER}} span.moomoo-post-navigation__next--label',
				'exclude' => [ 'line_height' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			[
				'label' => __( 'Title', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_post_navigation_style' );

		$this->start_controls_tab(
			'tab_color_normal',
			[
				'label' => __( 'Normal', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} span.moomoo-post-navigation__prev--title, {{WRAPPER}} span.moomoo-post-navigation__next--title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_color_hover',
			[
				'label' => __( 'Hover', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} span.moomoo-post-navigation__prev--title:hover, {{WRAPPER}} span.moomoo-post-navigation__next--title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} span.moomoo-post-navigation__prev--title, {{WRAPPER}} span.moomoo-post-navigation__next--title',
				'exclude' => [ 'line_height' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'arrow_style',
			[
				'label' => __( 'Arrow', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_arrow' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_post_navigation_arrow_style' );

		$this->start_controls_tab(
			'arrow_color_normal',
			[
				'label' => __( 'Normal', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'arrow_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .moomoo-post-navigation__arrow-wrapper' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'arrow_color_hover',
			[
				'label' => __( 'Hover', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'arrow_hover_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .moomoo-post-navigation__arrow-wrapper:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'arrow_size',
			[
				'label' => __( 'Size', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .moomoo-post-navigation__arrow-wrapper' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrow_padding',
			[
				'label' => __( 'Gap', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .moomoo-post-navigation__arrow-prev' => 'padding-right: {{SIZE}}{{UNIT}};',
					'body:not(.rtl) {{WRAPPER}} .moomoo-post-navigation__arrow-next' => 'padding-left: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} .moomoo-post-navigation__arrow-prev' => 'padding-left: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} .moomoo-post-navigation__arrow-next' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'borders_section_style',
			[
				'label' => __( 'Borders', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_borders!' => '',
				],
			]
		);

		$this->add_control(
			'sep_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				//'default' => '#D4D4D4',
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-post-navigation__separator' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .elementor-moomoo-post-navigation' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'borders_width',
			[
				'label' => __( 'Size', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-post-navigation__separator' => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-moomoo-post-navigation' => 'border-top-width: {{SIZE}}{{UNIT}}; border-bottom-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-moomoo-post-navigation__next.elementor-moomoo-post-navigation__link' => 'width: calc(50% - ({{SIZE}}{{UNIT}} / 2))',
					'{{WRAPPER}} .elementor-moomoo-post-navigation__prev.elementor-moomoo-post-navigation__link' => 'width: calc(50% - ({{SIZE}}{{UNIT}} / 2))',
				],
			]
		);

		$this->add_control(
			'borders_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-moomoo-post-navigation' => 'padding: {{SIZE}}{{UNIT}} 0;',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		
		$ID_next_post = get_next_post()->ID ;
		$ID_prev_post = get_previous_post()->ID;

		

		$prevThumbnail = get_the_post_thumbnail($ID_prev_post , 'post-thumbnail',array('class'=>'thumbnail prev-thumbnail') );
		
		$nextThumbnail = get_the_post_thumbnail($ID_next_post , 'post-thumbnail',array('class'=>'thumbnail next-thumbnail') );
		
		if ($prevThumbnail == '') {
			$prevThumbnail ='<img src="http://dummyimage.com/300x200/4d494d/686a82.gif&text=Thumbnail" alt="placeholder+image" class="thumbnail">';
		}
		if($nextThumbnail == ''){
			$nextThumbnail ='<img src="http://dummyimage.com/300x200/4d494d/686a82.gif&text=Thumbnail" alt="placeholder+image" class="thumbnail">';
		}

		$settings = $this->get_active_settings();

		$prev_label = '';
		$next_label = '';
		$prev_arrow = '';
		$next_arrow = '';

		if ( 'yes' === $settings['show_label'] ) {
			$prev_label = '<span class="moomoo-post-navigation__prev--label">' . $settings['prev_label'] . '</span>';
			$next_label = '<span class="moomoo-post-navigation__next--label">' . $settings['next_label'] . '</span>';
		}

		if ( 'yes' === $settings['show_arrow'] ) {
			if ( is_rtl() ) {
				$prev_icon_class = str_replace( 'left', 'right', $settings['arrow'] );
				$next_icon_class = $settings['arrow'];
			} else {
				$prev_icon_class = $settings['arrow'];
				$next_icon_class = str_replace( 'left', 'right', $settings['arrow'] );
			}
			ob_start();
			 	\Elementor\Icons_Manager::render_icon( $settings['arrow_next'], [ 'aria-hidden' => 'true' ] );
				$next_arrow = '<span class="icon">'.ob_get_contents().'</span>';
			ob_clean();
			ob_end_flush();

			ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['arrow_prev'], [ 'aria-hidden' => 'true' ] );
				$prev_arrow = '<span class="icon">'.ob_get_contents().'</span>';
			ob_clean();
			ob_end_flush();
			
		}

		$prev_title = '';
		$next_title = '';

		if ( 'yes' === $settings['show_title'] ) {
			$prev_title = '<span class="moomoo-post-navigation__prev--title">%title</span>';
			$next_title = '<span class="moomoo-post-navigation__next--title">%title</span>';
		}

		$in_same_term = false;
		$taxonomy = 'category';
		$post_type = get_post_type( get_queried_object_id() );

		if ( ! empty( $settings['in_same_term'] ) && is_array( $settings['in_same_term'] ) && in_array( $post_type, $settings['in_same_term'] ) ) {
			if ( isset( $settings[ $post_type . '_taxonomy' ] ) ) {
				$in_same_term = true;
				$taxonomy = $settings[ $post_type . '_taxonomy' ];
			}
		}
		
		?>

		<div class="elementor-moomoo-post-navigation">
			<?php if( !empty($ID_prev_post)): ?>
			<div class="elementor-moomoo-post-navigation__prev elementor-moomoo-post-navigation__link">
				<div class="flex-box">
					<?php previous_post_link( '%link', '<span class="elementor-moomoo-post-navigation__link__prev">' . $prev_label . $prev_title . '</span>'. $prev_arrow , $in_same_term, '', $taxonomy ); ?>
					<?php previous_post_link( '%link', $prevThumbnail, $in_same_term, '', $taxonomy ); ?>
				</div>
				
			</div>
			<?php endif; ?>
			<?php if( !empty($ID_next_post) && !empty($ID_prev_post)): ?>
				<div class="elementor-moomoo-post-navigation__separator-wrapper">
					<div class="elementor-moomoo-post-navigation__separator"></div>
				</div>
			<?php endif; ?>
			<?php if( !empty($ID_next_post)): ?>
			<div class="elementor-moomoo-post-navigation__next elementor-moomoo-post-navigation__link">
				<div class="flex-box">
				<?php next_post_link( '%link', $nextThumbnail, $in_same_term, '', $taxonomy ); ?>
				<?php next_post_link( '%link', '<span class="elementor-moomoo-post-navigation__link__next">' . $next_label . $next_title . '</span>' . $next_arrow, $in_same_term, '', $taxonomy ); ?>
				
				</div>
			</div>
			<?php endif; ?>

		</div>
		<?php
	}
	
}
