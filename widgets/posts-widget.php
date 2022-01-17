<?php

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Elementor_Posts_Widget extends \Elementor\Widget_Base {
	
	public function __construct( $data = [], $args = null ) {
		$this->_widget_name = $args['widget_name'];
		
		add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
		
		parent::__construct( $data, $args );

		//wp_register_script( 'mm-posts-js', plugins_url( 'moomoo-extensions-elementor/assets/js/posts-widget.js' ), [ 'elementor-frontend' ], '1.0.0', true );
		//wp_enqueue_script('mm-posts-js', plugins_url( 'moomoo-extensions-elementor/assets/js/posts-widget.js' ), array('mm-slick-js'), time());

		
	}
	public function get_name() {
		return 'moomoo-posts';
	}
	
	public function get_title() {
		return __( 'Moomoo Posts', 'moomoo-extensions-elementor' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}

	public function ndt_enqueue_scripts() {
		wp_enqueue_style('mm-posts-widget', plugins_url( 'moomoo-extensions-elementor/assets/css/posts-widget.css' ), array(), time());
		wp_enqueue_script('mm-slick-slider', plugins_url( 'moomoo-extensions-elementor/assets/js/slick.min.js' ), array('jquery-migrate'), time(), false);
		wp_enqueue_script('mm-posts-js', plugins_url( 'moomoo-extensions-elementor/assets/js/posts-widget.js' ), array('mm-slick-slider'), time(), false);
		
	}
	private function get_available_tags() {
		$tags = get_tags();

		$options = [];

		foreach ( $tags as $tag ) {
			$options[ $tag->slug ] = $tag->name;
		}

		return $options;
	}
	
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Posts seting', 'moomoo-extensions-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$tags = $this->get_available_tags();
		if ( ! empty( $tags ) ) {
			$this->add_control(
				'tag',
				[
					'label' => __( 'Select Tag', 'moomoo-extensions-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => $tags,
					'default' => array_keys( $tags )[0],
					'save_default' => true,
					'separator' => 'after'
				]
			);
		}else {
			$this->add_control(
				'tag',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<strong>' . __( 'There are no tag in your site.', 'elementor-pro' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Tags screen</a> to create one.', 'moomoo-elementor' ), admin_url( 'edit-tags.php?taxonomy=post_tag' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}
		$this->add_control(
			'post_per_page',
			[
				
				'label'=>'Posts Per Page',
				'type' => Controls_Manager::NUMBER,
				'default' => '3',
			]
		);
		$this->add_control(
			'layout',
			[
				
				'label'=>'Posts Layout',
				'type' => Controls_Manager::SELECT,
				'options' => array('four-column'=>'4 Columns', 'one-column'=>'1 Column'),
				'default' => 'one-column',
				'save_default' => true,
				'separator' => 'after'
			]
		);
		$this->add_control(
			'text_color',
			[
				
				'label'=>'Text Color',
				'type' => Controls_Manager::COLOR,				
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .wrap-content h3, {{WRAPPER}} .wrap-content a, {{WRAPPER}} .wrap-content ' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wrap-content hr' => 'border-color:{{VALUE}}',
					'{{WRAPPER}} .slick-arrow.next-arrow i:after' => 'border-color: {{VALUE}} {{VALUE}} transparent transparent',
					'{{WRAPPER}} .slick-arrow.prev-arrow i:after' => 'border-color: {{VALUE}} transparent transparent {{VALUE}}',
				]
				
			]
		);
		$this->add_control(
			'category_color',
			[
				
				'label'=>'Category Color',
				'type' => Controls_Manager::COLOR,				
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .elementor-posts-widget .category-list a, {{WRAPPER}} .elementor-posts-widget .category-list' => 'color: {{VALUE}}'
				]
				
			]
		);

	$this->end_controls_section();

	}
	private function get_post_by_tag($tag_slug){
		$args = array(
		    'tax_query' => array(
		        array(
		            'taxonomy' => 'post_tag',
		            'field' => 'slug',
		            'terms' => $tag_slug
		        )
		    )
		);
		return get_posts( $args );

	}

	protected function render() {
		
		$settings 		= $this->get_settings_for_display();
		$tags_slug 		= $settings['tag'];
		$post_per_page 	= $settings['post_per_page'];
		$layout 		= $settings['layout'];
		?>
		<div class="moomoo-elementor-extension elementor-posts-widget">
			<div class="wrap-content">
				<?php 
					
					$posts = $this->get_post_by_tag($tags_slug);
					
					if($layout =='one-column'){
						?>
						<div class="layout-one-column">
							<?php
								$html ='';

									foreach ($posts as $post) {

										$ID_post = $post ->ID;
										$thumnail = get_the_post_thumbnail($post,'post-thumbnail',array('class'=>'thumbnail'));
										$title = $post ->post_title;
										$content = wp_trim_words($post->post_content,40);
										$category = get_the_category_list(', ','', $ID_post);
						 				$author = 'By '. get_the_author_meta('display_name',$post->post_author);

										if ($thumnail == '') {
											$thumnail ='<img src="http://dummyimage.com/924x400/4d494d/686a82.gif&text=Thumbnail" alt="placeholder+image" class="thumbnail">';
										}

										//$html .= '<div class="item-post" >';
										$html .= '<div class="wrap-content">';
											$html .= $thumnail;
											$html .= '<div class="category-list">'.$category.'</div>';
											$html .= '<h3 class="title uppercase">'.$title.'</h3>';
											$html .= '<p class="author">'.$author.'</p>';
											$html .= '<div class="short-desc">'.$content.'</div>';
											$html .= '<a href="'.get_permalink($ID_post).'" class="read-more">READ MORE ></a>';
											$html .= '<hr>';
										$html .= '</div>';
										//$html .= '</div>';

									}
									echo $html;
										

								?>
						</div>
						<?php
					}else{
						?>
						<div class="layout-4-columns">
							<div class="elementor-row moomoo-slider">
									<?php
									$html ='';

										foreach ($posts as $post) {

											$ID_post = $post ->ID;
											$thumnail = get_the_post_thumbnail($post,'post-thumbnail',array('class'=>'thumbnail'));
											$title = $post ->post_title;
											$content = wp_trim_words($post->post_content,15);

											if ($thumnail == '') {
												$thumnail ='<img src="http://dummyimage.com/280x210/4d494d/686a82.gif&text=Thumbnail" alt="placeholder+image" class="thumbnail">';
											}

											$html .= '<div class="elementor-column elementor-col-25 elementor-inner-column">';
												$html .= '<div class="wrap-content">';
													$html .= $thumnail;
													$html .= '<hr>';
													$html .= '<h3 class="title">'.$title.'</h3>';
													$html .= '<div class="short-desc">'.$content.'</div>';
													$html .= '<a href="'.get_permalink($ID_post).'" class="read-more">WATCH NOW ></a>';
													$html .= '<hr>';
												$html .= '</div>';
											$html .= '</div>';

										}
										echo $html;
										

									?>
									
								
							</div>
							
						</div>
						<?php
					}
					
				 ?>
			</div>
		</div>
		
		<?php

		

	}

}