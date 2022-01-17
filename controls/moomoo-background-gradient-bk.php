<?php
use Elementor\Modules\DynamicTags\Module as TagsModule;

class Elementor_Moomoo_Background_Gradient extends \Elementor\Base_Data_Control {

	public  function get_type() {
		return 'mmbackgroundgradient';
	}
	// public function init_fields() {
	// 	$fields =[];
	// 	$fields['color_1'] = [
	// 		'label' => _x( 'Color', 'Background Control', 'elementor' ),
	// 		'type' => Controls_Manager::COLOR,
	// 		'default' => '',
	// 		'title' => _x( 'Background Color', 'Background Control', 'elementor' ),
	// 		'selectors' => [
	// 			'{{SELECTOR}}' => 'background-color: {{VALUE}};',
	// 		]
	// 	];
	// 	return $fields;
	// }
	/*public function filter_fields(){
		$fields =[];
		$fields['color'] = [
			'label' => _x( 'aaaaaa', 'Background Control', 'elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '',
			'title' => _x( 'Background Color', 'Background Control', 'elementor' ),
			'selectors' => [
				'{{SELECTOR}}' => 'background-color: {{VALUE}};',
			]
		];
		$fields['color_2'] = [
			'label' => _x( 'bbbb', 'Background Control', 'elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '',
			'title' => _x( 'Background Color', 'Background Control', 'elementor' ),
			'selectors' => [
				'{{SELECTOR}}' => 'background-color: {{VALUE}};',
			]
		];
		return $fields;
	}
	public static function get_background_types() {
		return [
			
			'multicolor' => [
				'title' => _x( 'ACXS', 'Background Control', 'elementor' ),
				'icon' => 'eicon-barcode',
			]
		];
	}*/

	public function content_template() {
		$control_uid = $this->get_control_uid();
		//var_dump($control_uid);
		?>
		<input class="color-picker" name="colors[]"  type="text" value="#03a9f4"  data-alpha="true" data-default-color="#03a9f4" />
		
		<div class="moomoo-control-field moomoo-background-gradient-control">
			<label class="elementor-control-title">{{{ data.label || '' }}}</label>
			<div class="elementor-control-input-wrapper elementor-control-dynamic-switcher-wrapper elementor-control-unit-5">
				<div class="elementor-color-picker-placeholder"></div>
			</div>
			<ul class="list-color">
				<li><input class="moomoo-color-picker" name="colors[]"  type="text" value="#03a9f4"  data-alpha="true" data-default-color="#03a9f4" /></li>
				
				<li><input class="moomoo-color-picker" name="colors[]"  type="text" value="#f44135"  data-alpha-enabled="true" data-default-color="#f44135" /></li>
				
				<li><input class="moomoo-color-picker" name="colors[]"  type="text" value="#ffeb3b"  data-alpha-enabled="true" data-default-color="#ffeb3b" /></li>
				
				<li><input class="moomoo-color-picker" name="colors[]"  type="text" value="#03a9f4"  data-alpha-enabled="true" data-default-color="#03a9f4" /></li>
				
			</ul>
		</div>
		
		<?php
	}


	public function enqueue() {

		/*wp_enqueue_style( 'wp-color-picker' );
	    wp_enqueue_script(
	        'iris',
	        admin_url( 'js/iris.min.js' ),
	        array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
	        false,
	        1
	    );
	    wp_enqueue_script(
	        'wp-color-picker',
	        admin_url( 'js/color-picker.min.js' ),
	        array( 'iris' ),
	        false,
	        1
	    );
	    $colorpicker_l10n = array(
	        'clear' => __( 'Clear' ),
	        'defaultString' => __( 'Default' ),
	        'pick' => __( 'Select Color' ),
	        'current' => __( 'Current Color' ),
	    );
	    wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n ); */

		//wp_enqueue_script('wp-color-picker');
    	//wp_enqueue_style('wp-color-picker');
    	//wp_enqueue_script('mm-pickr',ELEMENTOR_ASSETS_URL . 'lib/pickr/pickr.min.js',array(), time(), true);
    	//wp_enqueue_script('mm-color-picker-alpha',MM_EXT_ASSET_URL .'/js/controls/wp-color-picker-alpha.js',array('wp-color-picker'), time(), true);
		
wp_enqueue_style( 'wp-color-picker' );
wp_register_script( 'wp-color-picker-alpha', MM_EXT_ASSET_URL .'/js/controls/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.0.0', true);
wp_add_inline_script(
	'wp-color-picker-alpha',
	'jQuery( function() { jQuery( ".color-picker" ).wpColorPicker(); } );'
);
wp_enqueue_script( 'wp-color-picker-alpha' );




		wp_enqueue_script('mm-bg-gradient-admin',MM_EXT_ASSET_URL .'/js/controls/mm-background-gradient.js',array('wp-color-picker'), time(), true);
		//wp_enqueue_script( '', MM_ASSET_URL )
		$color_picker_strings = array(
			'clear'            => __( 'Clear', 'textdomain' ),
			'clearAriaLabel'   => __( 'Clear color', 'textdomain' ),
			'defaultString'    => __( 'Default', 'textdomain' ),
			'defaultAriaLabel' => __( 'Select default color', 'textdomain' ),
			'pick'             => __( 'Select Color', 'textdomain' ),
			'defaultLabel'     => __( 'Color value', 'textdomain' ),
		);
		wp_localize_script( 'wp-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );
		wp_enqueue_script( 'wp-color-picker-alpha' );
     	wp_enqueue_style( 'mm-multi-color' ,MM_EXT_ASSET_URL .'/css/controls/mm-background-gradient.css' );
	}
	protected function get_default_settings() {
		return array(
			'label_block'=>true,
			'alpha'=>true
		);
	}
	//protected function get_default_settings() {
		/*$fields['color'] = [
			'label' => _x( 'Color', 'Background Control', 'elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '',
			'title' => _x( 'Background Color', 'Background Control', 'elementor' ),
			'selectors' => [
				'{{SELECTOR}}' => 'background-color: {{VALUE}};',
			]
		];
		return $fields;*/
		/*return [
			'label' => _x( 'Color', 'Background Control', 'elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '',
			'title' => _x( 'Background Color', 'Background Control', 'elementor' ),
			'selectors' => [
				'{{SELECTOR}}' => 'background-color: {{VALUE}};',
			]
		];*/
		/*return [
			'label' => 'abc',
			//'default'=>'default param',
			//'name' =>'name_param'
		];*/
	//}

	//public function get_default_value() {
	//	$fields = [];
		/*$fields['color'] = [
			'label' => _x( 'Color', 'Background Control', 'elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '',
			'title' => _x( 'Background Color', 'Background Control', 'elementor' ),
			'selectors' => [
				'{{SELECTOR}}' => 'background-color: {{VALUE}};',
			],
			'condition' => [
				'background' => [ 'classic', 'gradient' ],
			],
		];*/
	//	return array('color_1' => '#03a9f4','color_2'=>'#f441a4', 'color_3'=>'#ffeb3b', 'color_4'=>'#03a9f4');
	//}

	/*public function get_value() {}

	public function get_style_value() {


	}*/

}
