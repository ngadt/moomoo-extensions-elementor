<?php

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
use ElementorPro\Base\Base_Widget;
use Elementor\Controls_Manager;

class Elementor_Projects_Widget extends \Elementor\Widget_Base {
	
	public function __construct( $data = [], $args = null ) {
		$this->_widget_name = $args['widget_name'];
		
		add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
		
		parent::__construct( $data, $args );
		
	}
	public function get_name() {
		return 'moomoo-projects';
	}
	
	public function get_title() {
		return __( 'Moomoo Projects', 'moomoo-extensions-elementor' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}

	public function ndt_enqueue_scripts() {

		wp_enqueue_style('mm-projects-widget', MM_EXT_ASSET_URL .'/css/projects-widget.css', array(), time());		
		//wp_enqueue_script('mm-projects-widget',MM_EXT_ASSET_URL .'/js/projects-widget.js',array('jquery'), time(), false);
		
	}
	private function get_list_categories() {

		$categories =  get_categories();
		$options = [];
		foreach ( $categories as $category ) {
			$options[ $category->term_id ] = $category->name;
		}
		return $options;
	}

	public function register_layout_section_controls(){

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Layout', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$categorys = $this->get_list_categories();
		if ( ! empty( $categorys ) ) {
			$this->add_control(
				'category',
				[
					'label' => __( 'Select Category', 'moomoo-extensions-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => $categorys,
					'default' => array_keys( $categorys )[0],
					'save_default' => true
				]
			);
		}else {
			$this->add_control(
				'category',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<strong>' . __( 'There are no category in your site.', 'elementor-pro' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">categorys screen</a> to create one.', 'moomoo-elementor' ), admin_url( 'edit-categorys.php?taxonomy=post_category' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}
		
		$this->add_control(
			'column',
			[
				
				'label'=>'Column',
				'type' => Controls_Manager::SELECT,
				'options' => array('100'=>'1', '50'=>'2', '33'=>'3','25'=>'4','20'=>'5','16'=>'6'),
				'default' => '1',
				'save_default' => true,
				'separator' => 'after'
			]
		);
		
		$this->register_read_more_controls();
		

		$this->end_controls_section();
		//style tab
		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => __( 'Layout', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_control(
			'text_color',
			[
				
				'label'=>'Text Color',
				'type' => Controls_Manager::COLOR,				
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .elementor-projects-widget .info-over, {{WRAPPER}} .elementor-projects-widget .info-over h3.title' => 'color: {{VALUE}}'
				]
				
			]
		);
		$this->add_control(
			'text_hover_color',
			[
				
				'label'=>'Text Hover Color',
				'type' => Controls_Manager::COLOR,				
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .elementor-projects-widget .info-over .view-more:hover' => 'color: {{VALUE}}'
				]
				
			]
		);
		$this->add_control(
			'background_text_color',
			[
				
				'label'=>'Background Text Color',
				'type' => Controls_Manager::COLOR,				
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .elementor-projects-widget .info-over' => 'background-color: {{VALUE}}'
				]
				
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => 'Title Style',
				'name' => 'title_style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .elementor-projects-widget .info-over h3',
				
				
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => 'Meta Data Style',
				'name' => 'meta_data_style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .elementor-projects-widget .info-over .meta-data',
				
				
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => 'Read More Style',
				'name' => 'read_more_style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .elementor-projects-widget .info-over .view-more',
				
				
			]
		);
		
		$this->end_controls_section();

	}

	protected function register_read_more_controls() {
		$this->add_control(
			'show_read_more',
			[
				'label' => __( 'Read More', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'moomoo-extensions-elementor' ),
				'label_off' => __( 'Hide', 'moomoo-extensions-elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label' => __( 'Read More Text', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Read More »', 'elementor-pro' ),
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);
	}

	protected function register_meta_data_controls() {
		$this->start_controls_section(
			'section_meta_data',
			[
				'label' => __( 'Meta Data', 'moomoo-extensions-elementor' ),
			]
		);

		$this->add_control(
			'meta_data_key',
			[
				'label' => __( 'Meta Key', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'property-value',
			]
		);

		
		 $this->end_controls_section();
		
	}
	
	public function register_pagination_section_controls() {
		$this->start_controls_section(
			'section_pagination',
			[
				'label' => __( 'Pagination', 'moomoo-extensions-elementor' ),
			]
		);

		$this->add_control(
			'pagination_type',
			[
				'label' => __( 'Pagination', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'elementor-pro' ),
					'numbers' => __( 'Numbers', 'elementor-pro' ),
					'prev_next' => __( 'Previous/Next', 'elementor-pro' ),
					'numbers_and_prev_next' => __( 'Numbers', 'elementor-pro' ) . ' + ' . __( 'Previous/Next', 'elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'pagination_post_per_page',
			[
				'label' => __( 'Project per page', 'moomoo-extensions-elementor' ),
				'default' => '4',
				'condition' => [
					'pagination_type!' => '',
				],
			]
		);
		$this->add_control(
			'pagination_limit_project',
			[
				'label' => __( 'Limit projects', 'moomoo-extensions-elementor' ),
				'default' => '-1',
				'condition' => [
					'pagination_type!' => '',
				],
			]
		);

		/*$this->add_control(
			'pagination_numbers_shorten',
			[
				'label' => __( 'Shorten', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'pagination_type' => [
						'numbers',
						'numbers_and_prev_next',
					],
				],
			]
		);
*/
		$this->add_control(
			'pagination_prev_label',
			[
				'label' => __( 'Previous Label', 'moomoo-extensions-elementor' ),
				'default' => __( '&laquo; Previous', 'moomoo-extensions-elementor' ),
				'condition' => [
					'pagination_type' => [
						'prev_next',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$this->add_control(
			'pagination_next_label',
			[
				'label' => __( 'Next Label', 'moomoo-extensions-elementor' ),
				'default' => __( 'Next &raquo;', 'moomoo-extensions-elementor' ),
				'condition' => [
					'pagination_type' => [
						'prev_next',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$this->add_control(
			'pagination_align',
			[
				'label' => __( 'Alignment', 'moomoo-extensions-elementor' ),
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
					'{{WRAPPER}} .elementor-projects-widget .moomoo-pagenavi ul.page-navi' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'pagination_type!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pagination_style',
			[
				'label' => __( 'Pagination', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination_type!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pagination_typography',
				'selector' => '{{WRAPPER}} .elementor-projects-widget .moomoo-pagenavi ul.page-navi li a',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'pagination_color_heading',
			[
				'label' => __( 'Colors', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'pagination_colors' );

		$this->start_controls_tab(
			'pagination_color_normal',
			[
				'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label' => __( 'Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-projects-widget .moomoo-pagenavi ul.page-navi li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_color_hover',
			[
				'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
			]
		);

		$this->add_control(
			'pagination_hover_color',
			[
				'label' => __( 'Color', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-projects-widget .moomoo-pagenavi ul.page-navi li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_color_active',
			[
				'label' => __( 'Active', 'moomoo-extensions-elementor' ),
			]
		);

		$this->add_control(
			'pagination_active_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-projects-widget .moomoo-pagenavi ul.page-navi li.active a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'pagination_spacing',
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
					'{{WRAPPER}} .elementor-projects-widget .moomoo-pagenavi ul.page-navi li a' => 'padding: 0  {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_controls() {
		

		$this->register_layout_section_controls();
		$this->register_meta_data_controls();
		$this->register_pagination_section_controls();

	}
	private function get_post_by_category($category_slug, $post_per_page, $pagination_limit_project){

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		

		$args = array(
			'post_type' => 'post',
			'numberposts'=> $pagination_limit_project,
			'posts_per_page'=> $post_per_page,
			'cat'=> $category_slug,
			'post_status'=>'publish',
			'paged'=> $paged
		);
	//var_dump(get_posts( $args ));
		return get_posts( $args );

	}
	
	protected function render() {
		
		$settings 		= $this->get_settings_for_display();

		//var_dump($settings);
	
		$column = $settings['column'];
		$category_slug = $settings['category'];
		$post_per_page = $settings['pagination_post_per_page'];
		$meta_data_key = $settings['meta_data_key'];
		$read_more_text = $settings['read_more_text'];
		$pagination_limit_project = $settings['pagination_limit_project'];
		$pagination_next_label =  $settings['pagination_next_label'];
		$pagination_prev_label = $settings['pagination_prev_label'];
		$pagination_align = $settings['pagination_align'];
		$pagination_type = $settings['pagination_type'];


		?>
		<div class="moomoo-elementor-extension elementor-projects-widget">
			<div class="elementor-row">
				<div class="">
					<?php
					
					$posts = $this->get_post_by_category($category_slug, $post_per_page, $pagination_limit_project);
					$count_posts = count($this->get_post_by_category($category_slug, -1, -1));
					$current_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$page_numbers = ceil($count_posts/$post_per_page);
					
					
						$html ='';

							foreach ($posts as $post) {

								$ID_post = $post ->ID;
								$thumnail = get_the_post_thumbnail($post,'post-thumbnail',array('class'=>'thumbnail'));
								$title = $post ->post_title;
								$meta_data = get_post_meta( $ID_post, $meta_data_key, false )[0];

								if ($thumnail == '') {
									$thumnail ='<img src="http://dummyimage.com/924x400/4d494d/686a82.gif&text=Thumbnail" alt="placeholder+image" class="thumbnail">';
								}
								ob_start();
								 	previous_posts_link($pagination_prev_label);
								 	$prev_link = (ob_get_contents() != NULL) ? '<li class="prev">'.ob_get_contents().'</li>' : '';
								ob_clean();
								ob_end_flush();

								ob_start();
									next_posts_link($pagination_next_label, $page_numbers);
									$next_link =  (ob_get_contents() != NULL) ? '<li class="next">'.ob_get_contents().'</li>' : '';
								ob_clean();
								ob_end_flush();

								$html .= '<div class="elementor-column elementor-col-'.$column.'">';
									$html .= '<a href="'.get_permalink($ID_post).'" class="read-more">';
										$html .= $thumnail;			
										$html .='<div class="info-over">';	
											$html .= '<h3 class="title">'.$title.'</h3>';
											$html .='<div class="info-left">';				
												$html .= '<span class="meta-data">'.$meta_data.'</span>';	
											$html .='</div>';
											$html .='<div class="info-right">';	
												$html .=  '<span class="view-more">'.$read_more_text.'</span>';
											$html .='</div>';
										$html .='</div>';
										
										
									$html .='</a>';
								$html .= '</div>';

							}
							$current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
							$pos = strpos($current_link, '/page/');
							if($pos){
								$current_link = substr($current_link,0,$pos).'/';
							}
				
							if($pagination_type !='' && $page_numbers>1){
								$html .= '<div class="moomoo-pagenavi"><ul class="page-navi">';
								$html .= $prev_link;
								for ($i=1; $i <= $page_numbers; $i++) { 
									$class_active = ($i == $current_page) ?'active': '';
									$html .='<li class="'.$class_active.'"><a href="'.$current_link.'page/'.$i.'">'.$i.'</a></li>';
								}
									$html .= $next_link;
								$html .= '</ul></div>';
							}
						
						echo $html;
							
						?>
				</div>
						
			</div>
		</div>
		
		<?php

	}

}