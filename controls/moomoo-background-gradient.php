<?php

use Elementor\Controls_Manager;
use Elementor\Modules\DynamicTags\Module as TagsModule;
//to to: set default value on each element (get args setting from user)
class Group_Control_Mmbackgroundgradient extends \Elementor\Group_Control_Base {
	protected static $fields;private $control_groups = [];
	private static $background_types;

	public static  function get_type() {
	
		return 'mmbackgroundgradient';
	}
	public function enqueue() {

	/*	wp_enqueue_script('mm-bg-gradient-admin',MM_EXT_ASSET_URL .'/js/controls/mm-background-gradient.js',array('wp-color-picker'), time(), true);
		
     	wp_enqueue_style( 'mm-multi-color' ,MM_EXT_ASSET_URL .'/css/controls/mm-background-gradient.css' );*/
	}
	
	protected function init_fields() {

		$fields = [];
		
		$colors = $this->get_args()['colors'];
		$count_colors = count($colors);
		if($count_colors<=1){
			$count_colors = $this->get_default_settings()['colors'];
		}
		
		$colors_string = '';
		if($count_colors>=2){
			for ($i=1; $i <=$count_colors ; $i++) { 

				$colors_string .= '{{color_'.$i.'.VALUE}},';
				
				$fields['color_'.$i] = [
					'label' => _x( 'Color '.$i, 'Background Control', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => $colors[$i-1],

					'render_type' => 'ui'
				];
			}
		}	
		$colors_string = trim($colors_string,',');
		$fields['gradient_angle'] = [
			'label' => _x( 'Angle', 'Background Control', 'elementor' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'deg' ],
			'default' => [
				'unit' => 'deg',
				'size' => 90,
			],
			'range' => [
				'deg' => [
					'step' => 10,
					'min' => 30,
					'max' => 90,
				],
			],
			'selectors' => [
				'{{SELECTOR}}' => 'background: linear-gradient({{SIZE}}{{UNIT}}, '.$colors_string.')',
			]
		];
		return $fields;
	}
	protected function get_default_options() {
		return [
			'popover' => true
			];
	}
	protected function get_default_settings() {
		return array(
			'label_block'=>true,
			'colors'=> array('#03a9f4', '#f44135', '#ffeb3b', '#03a9f4')
		);
	}
	

}