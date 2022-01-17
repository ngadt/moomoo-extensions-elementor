<?php

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Elementor_Post_Video_Widget extends \Elementor\Widget_Base {
	
	public function __construct( $data = [], $args = null ) {
		$this->_widget_name = $args['widget_name'];
		
		add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
		
		parent::__construct( $data, $args );

		
	}
	public function get_name() {
		return 'moomoo-post-video';
	}
	
	public function get_title() {
		return __( 'Moomoo Post Video', 'moomoo-extensions-elementor' );
	}

	public function get_icon() {
		return 'eicon-youtube';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}

	public function ndt_enqueue_scripts() {
		/*wp_enqueue_style('mm-ext-frontend', plugins_url( 'moomoo-extensions-elementor/assets/css/frontend.css' ), array(), time());
		wp_enqueue_script('mm-ext-js', plugins_url( 'moomoo-extensions-elementor/assets/js/js.js' ), array(), time());*/
		
	}
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Post Video', 'plugin-name' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		
//image_dimensions
		$this->end_controls_section();

	}


	protected function render() {
		
		$settings = $this->get_settings_for_display();
		
		?>
		<div class="moomoo-elementor-extension elementor-aspect-ratio-169">
			<div class="mm-ext-navi-menu elementor-fit-aspect-ratio">
				<?php 
				
				$post_ID = get_the_ID();
				$link_video = get_post_meta( $post_ID, 'video_url', true );
				$type_video = array();	
				parse_str($link_video, $type_video );

				if(isset($type_video['https://www_youtube_com/watch?v'])){
				
					$link_video = 'https://www.youtube.com/embed/'.$type_video['https://www_youtube_com/watch?v'];
					
				}else{
					$link_video = str_replace('https://vimeo.com', 'https://player.vimeo.com/video', $link_video);
				}

				if(!$link_video){
					?>
					<iframe class="elementor-video-iframe" src="https://player.vimeo.com/video/336812660" frameborder="0" allowfullscreen></iframe>
					<?php
				}else{
					?>
					<iframe class="elementor-video-iframe" src="<?php echo $link_video ;?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<?php
				}

				 ?>
				
			</div>
		</div>
		
		<?php

		

	}

}