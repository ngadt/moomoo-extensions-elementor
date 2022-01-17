<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes;
// old use Elementor\Typography ;
use Elementor\Core\Schemes\Typography;
//old use Elementor\Color;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;

class Elementor_Gravity_Form_Widget extends \Elementor\Widget_Base {
	
	public function __construct( $data = [], $args = null ) {
		$this->_widget_name =$this->get_name();
		
		add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
		
		parent::__construct( $data, $args );
		
	}
	public function get_name() {
		return 'moomoo-gravity-form';
	}
	
	public function get_title() {
		return __( 'Moomoo Gravity Form', 'moomoo-extensions-elementor' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}

	public function ndt_enqueue_scripts() {

		wp_enqueue_style('mm-gravity-form-widget', MM_EXT_ASSET_URL .'/css/gravity-form-widget.css', array(), time());		
		wp_enqueue_script('mm-gravity-form-widget',MM_EXT_ASSET_URL .'/js/gravity-form-widget.js',array('jquery'), '1.0.0', true);
		
	}
	protected function get_gravity_forms() {

		$field_options = array();

		if ( class_exists( 'GFForms' ) ) {
			$forms              = \RGFormsModel::get_forms( null, 'title' );
			$field_options['0'] = 'Select';
			if ( is_array( $forms ) ) {
				foreach ( $forms as $form ) {
					$field_options[ $form->id ] = $form->title;
				}
			}
		}

		if ( empty( $field_options ) ) {
			$field_options = array(
				'-1' => __( 'You have not added any Gravity Forms yet.', 'moomoo-extensions-elementor' ),
			);
		}

		return $field_options;
	}

	/**
	 * Returns gravity forms id
	 *
	 * @since 0.0.1
	 * @return integer Key id for Gravity Form.
	 */
	protected function get_gravity_form_id() {
		if ( class_exists( 'GFForms' ) ) {
			$forms = \RGFormsModel::get_forms( null, 'title' );

			if ( is_array( $forms ) ) {
				foreach ( $forms as $form ) {
					return $form->id;
				}
			}
		}

		return -1;
	}


	/**
	 * Register GForms Styler controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function _register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		$this->register_general_content_controls();
		$this->register_form_fields_content_controls();
		$this->register_radio_content_controls();
		$this->register_prev_next_content_controls();
		$this->register_button_content_controls();
		$this->register_button_step_controls();
		$this->register_error_style_controls();
		$this->register_spacing_controls();
		$this->register_typography_controls();
		
	}

	/**
	 * Register GForms Styler General Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_general_content_controls() {
		$this->start_controls_section(
			'section_button',
			array(
				'label' => __( 'General', 'moomoo-extensions-elementor' ),
			)
		);

		$this->add_control(
			'form_id',
			array(
				'label'   => __( 'Select Form', 'moomoo-extensions-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_gravity_forms(),
				'default' => '0',

			)
		);

		$this->add_control(
			'form_ajax_option',
			array(
				'label'        => __( 'Enable AJAX Form Submission', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'moomoo-extensions-elementor' ),
				'label_off'    => __( 'No', 'moomoo-extensions-elementor' ),
				'default'      => 'true',
				'label_block'  => false,
				'prefix_class' => 'uael-gf-ajax-',
			)
		);

		$this->add_control(
			'mul_form_option',
			array(
				'label'        => __( 'Keyboard Tab Key Support', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'moomoo-extensions-elementor' ),
				'label_off'    => __( 'No', 'moomoo-extensions-elementor' ),
				'default'      => 'no',
				'label_block'  => false,
				'return_value' => 'yes',
			)
		);
		$this->add_control(
			'form_tab_index_option',
			array(
				'label'     => __( 'Set Tabindex Value', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'condition' => array(
					'mul_form_option' => 'yes',
				),
			)
		);
		/*if ( parent::is_internal_links() ) {

			$this->add_control(
				'help_doc_tabindex',
				array(
					'type'            => Controls_Manager::RAW_HTML,
				
					'raw'             => sprintf( __( 'You need to change above tabindex value if pressing tab on your keyboard not works as expected. Please read %1$s this article %2$s for more information.', 'moomoo-extensions-elementor' ), '<a href=' . UAEL_DOMAIN . 'docs/gravity-form-tab-index/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => array(
						'mul_form_option' => 'yes',
					),
				)
			);
		}*/

		$this->add_control(
			'form_title_option',
			array(
				'label'       => __( 'Title & Description', 'moomoo-extensions-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'yes',
				'label_block' => false,
				'options'     => array(
					'yes'  => __( 'From Gravity Form', 'moomoo-extensions-elementor' ),
					'no'   => __( 'Enter Your Own', 'moomoo-extensions-elementor' ),
					'none' => __( 'None', 'moomoo-extensions-elementor' ),
				),
			)
		);

		$this->add_control(
			'form_title',
			array(
				'label'     => __( 'Form Title', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'form_title_option' => 'no',
				),
				'dynamic'   => array(
					'active' => true,
				),

			)
		);

		$this->add_control(
			'form_desc',
			array(
				'label'     => __( 'Form Description', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::TEXTAREA,
				'condition' => array(
					'form_title_option' => 'no',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->add_responsive_control(
			'form_title_desc_align',
			array(
				'label'     => __( 'Title & Description </br>Alignment', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'condition' => array(
					'form_title_option!' => 'none',
				),
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_description,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_heading' => 'text-align: {{VALUE}};',
				),
				'toggle'    => false,
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register GForms Styler Input Style Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_form_fields_content_controls() {
		$this->start_controls_section(
			'form_fields_control',
			array(
				'label' => __( 'Form Fields', 'moomoo-extensions-elementor' ),
			)
		);

		$this->add_control(
			'gf_style',
			array(
				'label'        => __( 'Field Style', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'box',
				'options'      => array(
					'box'       => __( 'Box', 'moomoo-extensions-elementor' ),
					'underline' => __( 'Underline', 'moomoo-extensions-elementor' ),
				),
				'prefix_class' => 'uael-gf-style-',
			)
		);

		$this->add_control(
			'form_input_size',
			array(
				'label'        => __( 'Field Size', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'sm',
				'options'      => array(
					'xs' => __( 'Extra Small', 'moomoo-extensions-elementor' ),
					'sm' => __( 'Small', 'moomoo-extensions-elementor' ),
					'md' => __( 'Medium', 'moomoo-extensions-elementor' ),
					'lg' => __( 'Large', 'moomoo-extensions-elementor' ),
					'xl' => __( 'Extra Large', 'moomoo-extensions-elementor' ),
				),
				'prefix_class' => 'uael-gf-input-size-',
			)
		);


		$this->add_responsive_control(
			'form_input_padding',
			array(
				'label'      => __( 'Input Padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper form .gform_body input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), 
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container select, 
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container .chosen-single' => 'padding-top: calc( {{TOP}}{{UNIT}} ); padding-right: {{RIGHT}}{{UNIT}}; padding-bottom: calc( {{BOTTOM}}{{UNIT}} ); padding-left: {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"] + label:before, 
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"] + label:before,
					{{WRAPPER}}:not(.uael-gf-check-default-yes)  .elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio .gchoice_label label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before' => 'height: {{BOTTOM}}{{UNIT}}; width: {{BOTTOM}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"]:checked + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"]:checked + label:before'  => 'font-size: calc( {{BOTTOM}}{{UNIT}} / 1.2 );',
				),
			)
		);

		$this->add_control(
			'form_input_bgcolor',
			array(
				'label'     => __( 'Field Background Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fafafa',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=email],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=text],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=password],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=url],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=tel],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=number],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=date],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper select, 
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-container-single .chosen-single, 
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-container-multi .chosen-choices, 
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper textarea, 
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"] + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"] + label:before, 
					{{WRAPPER}}:not(.uael-gf-check-default-yes)  .elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio .gchoice_label label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gf_progressbar,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gsection' => 'border-bottom-color:{{VALUE}};',
				),
			)
		);

		$this->add_control(
			'form_label_color',
			array(
				'label'     => __( 'Label Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox li label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio li label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gsection_title,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_html,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_product_price,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_product_price_label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gf_progressbar_title,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gf_page_steps,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox div label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio div label' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
            'label_width',
            [
                'label' => __( 'Label Width', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container label.gfield_label' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
		$this->add_responsive_control(
			'horizaltol_label',
			array(
				'label'        => __( 'Vertical Align Label ', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
					'flex-start'    => array(
						'title' => __( 'Top', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center'  => array(
						'title' => __( 'Middle', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'flex-end'   => array(
						'title' => __( 'Bottom', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-v-align-bottom',
					)
				),
				'default'      => 'top',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper.gravity-theme .left_label .gfield:not(.gsection):not(.gfield_html):not(fieldset), .gform_wrapper.gravity-theme .right_label .gfield:not(.gsection):not(.gfield_html):not(fieldset)' => 'align-items: {{VALUE}};',
				),
				'toggle'       => false,
			)
		);
		$this->add_responsive_control(
			'align_label',
			array(
				'label'        => __( 'Alignment Label ', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
					'left'    => array(
						'title' => __( 'Left', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => __( 'right', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-right',
					)
				),
				'default'      => 'top',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container label.gfield_label' => 'text-align: {{VALUE}};',
				),
				'toggle'       => false,
			)
		);
		$this->add_responsive_control(
			'form_label_padding',
			array(
				'label'      => __( 'Label Padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container label.gfield_label'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				),
			)
		);
		$this->add_control(
			'form_input_color',
			array(
				'label'     => __( 'Input Text / Placeholder Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gfield input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]),
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container select,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container .chosen-single,  
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container textarea,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gfield input::placeholder,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container textarea::placeholder,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"]:checked + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .uael-gf-select-custom:after ' => 'color: {{VALUE}}; opacity: 1;',
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"]:checked + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio .gchoice_button.uael-radio-active + .gchoice_label label:before' => 'background-color: {{VALUE}}; box-shadow:inset 0px 0px 0px 4px {{form_input_bgcolor.VALUE}};',
				),
			)
		);

		$this->add_control(
			'form_input_desc_color',
			array(
				'label'     => __( 'Field Description Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gfield .gfield_description,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_name input + label, 
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_creditcard input + span + label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container select + label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container .chosen-single + label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_time_hour label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_time_minute label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_address label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_total span,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_shipping_price,
					{{WRAPPER}} .uael-gf-select-custom + label,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gsection_description' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'form_input_desc_below_label',
			array(
				'label'        => __( 'Description below label', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'moomoo-extensions-elementor' ),
				'label_off'    => __( 'No', 'moomoo-extensions-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'moomoo-desc-below-label-',
			)
		);
		
		$this->add_responsive_control(
			'form_input_desc_positon',
			array(
				'label'      => __( 'Description margin', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}}.moomoo-desc-below-label-yes .gfield_description:not(.validation_message)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				),
			)
		);
		/*$this->add_control(
			'form_desc_padding_label',
			[
				'label' => __( 'Description padding label', 'plugin-domain' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'default' => 5,
			]
		);*/
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'label' =>'Description style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gfield .gfield_description',				
				
			]
		);
		$this->add_control(
			'form_input_fullwidth_pda',
			array(
				'label'        => __( 'PDA Full width ', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'moomoo-extensions-elementor' ),
				'label_off'    => __( 'No', 'moomoo-extensions-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'moomoo-full-width-pda-',
				 'separator' => 'before',

			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pda_typography',
				'label' =>'Pda style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper .gform_body.gform-body .ginput_container.ginput_container_checkbox .gchoice .gfield-choice-input+label',				
				
			]
		);
		$this->add_control(
			'form_pad_field_color',
			array(
				'label'     => __( 'PDA Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper .gform_body.gform-body .ginput_container.ginput_container_checkbox .gchoice .gfield-choice-input+label' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'pda_padding',
			array(
				'label'      => __( 'PDA Padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper .gform_body.gform-body .ginput_container.ginput_container_checkbox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				
			)
		);
		$this->add_responsive_control(
			'pda_align',
			array(
				'label'     => __( 'PDA Alignment', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify'  => array(
						'title' => __( 'Right', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper .gform_body.gform-body .ginput_container.ginput_container_checkbox .gchoice .gfield-choice-input+label' => 'text-align: {{VALUE}};',
				),
				'separator' => 'after',
			)
		);
		$this->add_control(
			'form_required_color',
			array(
				'label'     => __( 'Required Asterisk Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gfield_required' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'input_border_style',
			array(
				'label'       => __( 'Border Style', 'moomoo-extensions-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'solid',
				'label_block' => false,
				'options'     => array(
					'none'   => __( 'None', 'moomoo-extensions-elementor' ),
					'solid'  => __( 'Solid', 'moomoo-extensions-elementor' ),
					'double' => __( 'Double', 'moomoo-extensions-elementor' ),
					'dotted' => __( 'Dotted', 'moomoo-extensions-elementor' ),
					'dashed' => __( 'Dashed', 'moomoo-extensions-elementor' ),
				),
				'condition'   => array(
					'gf_style' => 'box',
				),
				'selectors'   => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=email],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=text],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=password],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=url],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=tel],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=number],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=date],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper select,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-single,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper textarea,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"] + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"] + label:before,
					{{WRAPPER}}:not(.uael-gf-check-default-yes)  .elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio .gchoice_label label:before' => 'border-style: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'input_border_size',
			array(
				'label'      => __( 'Border Width', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '1',
					'bottom' => '1',
					'left'   => '1',
					'right'  => '1',
					'unit'   => 'px',
				),
				'condition'  => array(
					'gf_style'            => 'box',
					'input_border_style!' => 'none',
				),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=email],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=text],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=password],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=url],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=tel],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=number],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=date],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper select,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-single, 
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-choices,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-container .chosen-drop,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper textarea,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"] + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"] + label:before,
					.gchoice_label label:before,
					{{WRAPPER}}:not(.uael-gf-check-default-yes)  .elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio .gchoice_label label:before' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'input_border_color',
			array(
				'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'gf_style'            => 'box',
					'input_border_style!' => 'none',
				),
				'default'   => '#eaeaea',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=email],
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=text],
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=password],
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=url],
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=tel],
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=number],
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=date],
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper select,
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-single,
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-choices,
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-container .chosen-drop,
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper textarea,
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"] + label:before,
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before,
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"] + label:before,
						{{WRAPPER}}:not(.uael-gf-check-default-yes)  .elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio .gchoice_label label:before' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'gf_border_bottom',
			array(
				'label'      => __( 'Border Size', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 20,
					),
				),
				'default'    => array(
					'size' => '2',
					'unit' => 'px',
				),
				'condition'  => array(
					'gf_style' => 'underline',
				),
				'selectors'  => array(
					'{{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=email],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=text],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=password],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=url],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=tel],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=number],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=date],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper select,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper .chosen-single,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper .chosen-choices,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper textarea' => 'border-width: 0 0 {{SIZE}}{{UNIT}} 0; border-style: solid;',
					'{{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper .chosen-container .chosen-drop' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					'{{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gfield_checkbox input[type="checkbox"] + label:before,
					{{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .ginput_container_consent input[type="checkbox"] + label:before, 
					{{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gfield_radio input[type="radio"] + label:before,
					{{WRAPPER}}:not(.uael-gf-check-default-yes)elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gfield_radio .gchoice_label label:before' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid; box-sizing: content-box;',
				),
			)
		);

		$this->add_control(
			'gf_border_color',
			array(
				'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'gf_style' => 'underline',
				),
				'default'   => '#c4c4c4',
				'selectors' => array(
					'{{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=email],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=text],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=password],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=url],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=tel],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=number],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper input[type=date],
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper select,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper .chosen-single,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper .chosen-choices,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper .chosen-container .chosen-drop,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gform_wrapper textarea,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gfield_checkbox input[type="checkbox"] + label:before,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .ginput_container_consent input[type="checkbox"] + label:before,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gfield_radio input[type="radio"] + label:before,
					 {{WRAPPER}}:not(.uael-gf-check-default-yes)elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gfield_radio .gchoice_label label:before' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'gf_border_active_color',
			array(
				'label'     => __( 'Border Active Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'gf_style'            => 'box',
					'input_border_style!' => 'none',
				),
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield input:focus,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield textarea:focus,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield select:focus,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-container-active.chosen-with-drop .chosen-single, 
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-container-active.chosen-container-multi .chosen-choices,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"]:checked + label:before,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"]:checked + label:before,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"]:checked + label:before,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio .gchoice_button.uael-radio-active + .gchoice_label label:before' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'gf_border_active_color_underline',
			array(
				'label'     => __( 'Border Active Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'gf_style' => 'underline',
				),
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield input:focus,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield textarea:focus,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield select:focus,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield .chosen-single:focus,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gfield_checkbox input[type="checkbox"]:checked + label:before,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .ginput_container_consent input[type="checkbox"] + label:before,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gfield_radio input[type="radio"]:checked + label:before,
					 {{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline .gfield_radio .gchoice_button.uael-radio-active + .gchoice_label label:before' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'form_border_radius',
			array(
				'label'      => __( 'Rounded Corners', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '0',
					'bottom' => '0',
					'left'   => '0',
					'right'  => '0',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=email],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=text],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=password],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=url],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=tel],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=number],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper input[type=date],
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper select,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-single, 
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-choices,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .chosen-container .chosen-drop,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper textarea,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"] + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}


	/**
	 * Register GForms Styler Radio & Checkbox Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_radio_content_controls() {
		$this->start_controls_section(
			'gf_radio_check_style',
			array(
				'label' => __( 'Radio & Checkbox', 'moomoo-extensions-elementor' ),
			)
		);
		$this->add_control(
			'gf_radio_horizontal',
			array(
				'label'        => __( 'Horizontal radio fields', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'moomoo-extensions-elementor' ),
				'label_off'    => __( 'No', 'moomoo-extensions-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'moomoo-horizontal-radio-',
			)
		);
		$this->add_responsive_control(
				'gf_radio_field_width',
				array(
					'label'      => __( 'Field width', 'moomoo-extensions-elementor' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( '%' ),
					'range'      => array(
						'%' => array(
							'min' => 0,
							'max' => 50,
						),
					),
					'default' => [
						'unit' => '%',
						'size' => 100,
					],
					'selectors'  => array(
						' {{WRAPPER}}.moomoo-horizontal-radio-yes .gfield_radio>div' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);
		$this->add_control(
			'gf_radio_check_custom',
			array(
				'label'        => __( 'Override Current Style', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'moomoo-extensions-elementor' ),
				'label_off'    => __( 'No', 'moomoo-extensions-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'uael-gf-check-',
			)
		);

		$this->add_control(
			'gf_radio_check_default',
			array(
				'label'        => __( 'Default Checkboxes/Radio Buttons', 'moomoo-extensions-elementor' ),
				'description'  => __( 'This option lets you use browser default checkboxes and radio buttons. Enable this if you face any issues with custom checkboxes and radio buttons.', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'moomoo-extensions-elementor' ),
				'label_off'    => __( 'No', 'moomoo-extensions-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'prefix_class' => 'uael-gf-check-default-',
				'condition'    => array(
					'gf_radio_check_custom!' => '',
				),
			)
		);

		$this->add_control(
			'gf_radio_check_size',
			array(
				'label'      => _x( 'Size', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'condition'  => array(
					'gf_radio_check_custom!' => '',
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'range'      => array(
					'px' => array(
						'min' => 15,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"] + label:before,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"] + label:before,
					 {{WRAPPER}}:not(.uael-gf-check-default-yes).elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio .gchoice_label label:before,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before,
					 {{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"],
					 {{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"],
					 {{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"]' => 'width: {{SIZE}}{{UNIT}}!important; height:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"]:checked + label:before,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before,
					 {{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"]:checked,
					 {{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"]'  => 'font-size: calc( {{SIZE}}{{UNIT}} / 1.2 );',
				),
			)
		);

		$this->add_control(
			'gf_radio_check_bgcolor',
			array(
				'label'     => __( 'Background Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'gf_radio_check_custom!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"] + label:before,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"] + label:before,
					 {{WRAPPER}}:not(.uael-gf-check-default-yes).elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio .gchoice_label label:before,
					 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before,
					 {{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"],
					 {{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"],
					 {{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"]' => 'background-color: {{VALUE}};',
				),
				'default'   => '#fafafa',
			)
		);

		$this->add_control(
			'gf_selected_color',
			array(
				'label'     => __( 'Selected Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				),
				'condition' => array(
					'gf_radio_check_custom!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"]:checked + label:before,
					{{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"]:checked:before' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"]:checked + label:before,
					{{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"]:checked:before' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"]:checked + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio .gchoice_button.uael-radio-active + .gchoice_label label:before,
					{{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"]:checked:before'    => 'background-color: {{VALUE}}; box-shadow:inset 0px 0px 0px 4px {{gf_radio_check_bgcolor.VALUE}};',
				),
			)
		);

		$this->add_control(
			'gf_select_color',
			array(
				'label'     => __( 'Label Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'gf_radio_check_custom!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container label.gfield_label, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'gf_check_border_color',
			array(
				'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#eaeaea',
				'condition' => array(
					'gf_radio_check_custom!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"] + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"] + label:before, 
					{{WRAPPER}}:not(.uael-gf-check-default-yes).elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio .gchoice_label label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before,
					{{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"],
					{{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"], 
					{{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"]' => 'border-color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'gf_check_border_width',
			array(
				'label'      => __( 'Border Width', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 20,
					),
				),
				'default'    => array(
					'size' => '1',
					'unit' => 'px',
				),
				'condition'  => array(
					'gf_radio_check_custom!' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"] + label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"] + label:before, 
					{{WRAPPER}}:not(.uael-gf-check-default-yes).elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio .gfield_radio .gchoice_label label:before,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before,
					{{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"],
					{{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_radio input[type="radio"], 
					{{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"]' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
				),
			)
		);

		$this->add_control(
			'gf_check_border_radius',
			array(
				'label'      => __( 'Checkbox Rounded Corners', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'condition'  => array(
					'gf_radio_check_custom!' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"] + label:before, 
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"] + label:before,
					{{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_checkbox input[type="checkbox"], 
					{{WRAPPER}}.uael-gf-check-default-yes.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_consent input[type="checkbox"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => '0',
					'bottom' => '0',
					'left'   => '0',
					'right'  => '0',
					'unit'   => 'px',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register GForms Styler Button Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_button_content_controls() {
		$this->start_controls_section(
			'section_style',
			array(
				'label' => __( 'Submit Button', 'moomoo-extensions-elementor' ),
			)
		);
		$this->add_responsive_control(
			'button_align',
			array(
				'label'        => __( 'Button Alignment', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
					'left'    => array(
						'title' => __( 'Left', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'moomoo-extensions-elementor' ),
						'icon'  => 'eicon-text-align-right',
					)
				),
				'default'      => 'left',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper .gform_footer, 
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper .gform_page_footer' => 'text-align: {{VALUE}};',
				),
				'toggle'       => false,
			)
		);
		$this->add_control(
			'btn_size',
			array(
				'label'        => __( 'Size', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'sm',
				'options'      => array(
					'xs' => __( 'Extra Small', 'moomoo-extensions-elementor' ),
					'sm' => __( 'Small', 'moomoo-extensions-elementor' ),
					'md' => __( 'Medium', 'moomoo-extensions-elementor' ),
					'lg' => __( 'Large', 'moomoo-extensions-elementor' ),
					'xl' => __( 'Extra Large', 'moomoo-extensions-elementor' ),
				),
				'prefix_class' => 'uael-gf-btn-size-',
			)
		);

		$this->add_responsive_control(
			'gf_button_padding',
			array(
				'label'      => __( 'Padding Submit', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="submit"], {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);

		$this->add_responsive_control(
			'gf_button_margin',
			array(
				'label'      => __( 'Margin', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'allowed_dimensions' => array('top', 'bottom'),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper .gform_footer' => 'padding: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0',
				),
				
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => __( 'Text Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="submit"], {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gf_progressbar_percentage span, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .percentbar_blue span' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'btn_background_color',
				'label'          => __( 'Background Color', 'moomoo-extensions-elementor' ),
				'types'          => array( 'classic', 'gradient' ),
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Color::get_type(),
							'value' => Color::COLOR_4,
						),
					),
				),
				'selector'       => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="submit"], {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"], {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gf_progressbar_percentage, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .percentbar_blue',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'btn_border',
				'label'       => __( 'Border', 'moomoo-extensions-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="submit"], {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"]',
			)
		);

		$this->add_responsive_control(
			'btn_border_radius',
			array(
				'label'      => __( 'Border Radius', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="submit"], {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="submit"], {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"]',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
			)
		);

		$this->add_control(
			'btn_hover_color',
			array(
				'label'     => __( 'Text Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="submit"]:hover, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"]:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'gf_button_hover_border_color',
			array(
				'label'     => __( 'Border Hover Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="submit"]:hover, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"]:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_background_hover_color',
				'label'    => __( 'Background Color', 'moomoo-extensions-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="submit"]:hover, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"]:hover',
			)
		);

		$this->add_control(
			'button_hover_border_color',
			array(
				'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="submit"]:hover, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"]:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}
	protected function register_prev_next_content_controls() {
		$this->start_controls_section(
			'section_next_prev_style',
			array(
				'label' => __( 'Prev Next Button', 'moomoo-extensions-elementor' ),
			)
		);
		
		$this->start_controls_tabs( 'tabs_prev_next_style' );

		$this->start_controls_tab(
			'tab_button_next',
			array(
				'label' => __( 'Next Button', 'moomoo-extensions-elementor' ),
			)
		);
		$this->add_responsive_control(
			'btn_next_padding',
			array(
				'label'      => __( 'Padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_next_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				)
				
			)
		);
		$this->add_control(
			'bg_next_button_header',
			[
				'label' => __( 'Background Next Normal', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_next_button',
				'label' => __( 'Next Background', 'moomoo-extensions-elementor' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container  .gform_wrapper .gform_page_footer .gform_next_button'
			]
		);
		$this->add_control(
			'bg_next_button_header_hover',
			[
				'label' => __( 'Background Next Hover', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_next_button_hover',
				'label' => __( 'Next Background Hover', 'moomoo-extensions-elementor' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container  .gform_wrapper .gform_page_footer .gform_next_button:hover',
				'separator'  => 'after',
			]
		);
		
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_button_previous',
			array(
				'label' => __( 'Previous Button', 'moomoo-extensions-elementor' ),
			)
		);
		
		$this->add_responsive_control(
			'btn_previous_padding',
			array(
				'label'      => __( 'Padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				)
			)
		);
		$this->add_control(
			'bg_prev_button_header',
			[
				'label' => __( 'Background Prev Normal', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg-prev-button',
				'label' => __( 'Previous Background', 'moomoo-extensions-elementor' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button',
				'separator'  => 'after'
			] 
		);
		$this->add_control(
			'bg_prev_button_header_hover',
			[
				'label' => __( 'Background Prev Hover', 'moomoo-extensions-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg-prev-button-hover',
				'label' => __( 'Previous Background Hover', 'moomoo-extensions-elementor' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button:hover',
				'separator'  => 'after'
			] 
		);
		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		
	}
	
	protected function register_button_step_controls(){
		$this->start_controls_section(
			'section_step_style',
			array(
				'label' => __( 'Step Bar', 'moomoo-extensions-elementor' ),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_step_typography',
				'label' =>'Step title style',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,				
				'selector' => '{{WRAPPER}} .gform_wrapper .gf_step span',				
				
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'btn_step_border',
				'label'       => __( 'Border', 'moomoo-extensions-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .gform_wrapper .gf_step',
			)
		);

		$this->add_responsive_control(
			'btn_step_border_radius',
			array(
				'label'      => __( 'Border Radius', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .gform_wrapper .gf_step' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'btn_step_padding',
			array(
				'label'      => __( 'Padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .gform_wrapper .gf_step' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);
		$this->start_controls_tabs( 'step_style' );
			$this->start_controls_tab(
				'step_style_normal',
				[
					'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
				]
			);
			$this->add_control(
				'text_step_color',
				array(
					'label'     => __( 'Step Color', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .gform_wrapper .gf_step span' => 'color: {{VALUE}}',
					),
				)
			);
			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'step-background-normal',
					'label' => __( 'Step Background', 'moomoo-extensions-elementor' ),
					'types' => [ 'classic', 'gradient', 'video' ],
					'selector' => '{{WRAPPER}} .gform_wrapper .gf_step',
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'step_style_active',
				[
					'label' => __( 'Active', 'moomoo-extensions-elementor' ),
				]
			);
			$this->add_control(
				'text_step_active_color',
				array(
					'label'     => __( 'Active Color', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .gform_wrapper .gf_step_active span' => 'color: {{VALUE}}',
					),
				)
			);
			
			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'step_active_bg_color',
					'label' => __( 'Active Background', 'plugin-domain' ),
					'types' => [ 'classic', 'gradient', 'video' ],
					'selector' => '{{WRAPPER}} .gform_wrapper .gf_step_active',
				]
			);
			$this->end_controls_tab();
		$this->end_controls_tabs();
		
		
		$this->end_controls_section();
	}
	

	/**
	 * Register GForms Styler Error Style Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_error_style_controls() {
		$this->start_controls_section(
			'form_error_field',
			array(
				'label' => __( 'Success / Error Message', 'moomoo-extensions-elementor' ),
			)
		);
		$this->add_control(
			'form_error',
			array(
				'label' => __( 'Field Validation', 'moomoo-extensions-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);
		$this->add_control(
			'form_error_msg_color',
			array(
				'label'     => __( 'Message Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff0000',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gfield_description.validation_message' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'gf_message_typo',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper form .gfield_description.validation_message',
			)
		);
		$this->add_responsive_control(
			'field_validation_padding',
			array(
				'label'      => __( 'Padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper form .gfield_description.validation_message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'form_error_field_background',
			array(
				'label'        => __( 'Advanced Settings', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'moomoo-extensions-elementor' ),
				'label_off'    => __( 'No', 'moomoo-extensions-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'uael-gf-error-',
			)
		);

			$this->add_control(
				'form_error_field_bgcolor',
				array(
					'label'     => __( 'Field Background Color', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'condition' => array(
						'form_error_field_background!' => '',
					),
					'selectors' => array(
						'{{WRAPPER}}.uael-gf-error-yes .gform_wrapper form .gfield_description.validation_message' => 'background-color: {{VALUE}};',
					),
				)
			);
			$this->add_control(
				'form_error_border_color',
				array(
					'label'     => __( 'Highlight Border Color', 'moomoo-extensions-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ff0000',
					'condition' => array(
						'form_error_field_background!' => '',
					),
					'selectors' => array(
						'{{WRAPPER}}.uael-gf-error-yes .gform_wrapper li.gfield_error input:not([type="submit"]):not([type="button"]):not([type="image"]),
						 {{WRAPPER}}.uael-gf-error-yes .gform_wrapper .gfield_error .ginput_container select,
						 {{WRAPPER}}.uael-gf-error-yes .gform_wrapper .gfield_error .ginput_container .chosen-single,
						 {{WRAPPER}}.uael-gf-error-yes .gform_wrapper .gfield_error .ginput_container textarea,
						 {{WRAPPER}}.uael-gf-error-yes .gform_wrapper li.gfield.gfield_error,
						 {{WRAPPER}}.uael-gf-error-yes .gform_wrapper li.gfield.gfield_error.gfield_contains_required.gfield_creditcard_warning,
						 {{WRAPPER}}.uael-gf-error-yes li.gfield_error .gfield_checkbox input[type="checkbox"] + label:before,
						 {{WRAPPER}}.uael-gf-error-yes li.gfield_error .ginput_container_consent input[type="checkbox"] + label:before,
						 {{WRAPPER}}.uael-gf-error-yes li.gfield_error .gfield_radio input[type="radio"] + label:before,
						 {{WRAPPER}}:not(.uael-gf-check-default-yes).uael-gf-error-yes li.gfield_error .gfield_radio .gchoice_label label:before' => 'border-color: {{VALUE}};',
						'{{WRAPPER}}.uael-gf-error-yes .gform_wrapper li.gfield_error input[type="text"]' =>
						'border: {{input_border_size.BOTTOM}}px {{input_border_style.VALUE}} {{VALUE}} !important;',
						'{{WRAPPER}}elementor-widget-moomoo-gravity-form .elementor-widget-container-underline.uael-gf-error-yes .gform_wrapper li.gfield_error input[type="text"]' =>
						'border-width: 0 0 {{gf_border_bottom.SIZE}}px 0 !important; border-style: solid; border-color:{{VALUE}};',
						'{{WRAPPER}}.uael-gf-error-yes .gform_wrapper form .gfield_description.validation_message'=>'border-color:{{VALUE}}'
					),
				)
			);

		$this->add_control(
			'form_validation_message',
			array(
				'label'     => __( 'Form Error Validation', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'form_valid_message_color',
			array(
				'label'     => __( 'Error Message Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.validation_error,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.gform_validation_errors h2' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'form_valid_bgcolor',
			array(
				'label'     => __( 'Error Message Background Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.validation_error,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.gform_validation_errors' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'form_valid_border_color',
			array(
				'label'     => __( 'Error Message Border Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff0000',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.validation_error,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.gform_validation_errors' => 'border-color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'form_border_size',
			array(
				'label'      => __( 'Border Size', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'    => '2',
					'bottom' => '2',
					'left'   => '2',
					'right'  => '2',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.validation_error,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.gform_validation_errors' => 'border-top: {{TOP}}{{UNIT}}; border-right: {{RIGHT}}{{UNIT}}; border-bottom: {{BOTTOM}}{{UNIT}}; border-left: {{LEFT}}{{UNIT}}; border-style: solid;',
				),
			)
		);

		$this->add_control(
			'form_valid_border_radius',
			array(
				'label'      => __( 'Rounded Corners', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.validation_error,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.gform_validation_errors' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'form_valid_message_padding',
			array(
				'label'      => __( 'Message Padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'    => '10',
					'bottom' => '10',
					'left'   => '10',
					'right'  => '10',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.validation_error,
					{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.gform_validation_errors' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cf7_error_validation_typo',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.validation_error h2,
				{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.gform_validation_errors h2',
			)
		);

		$this->add_control(
			'form_success_message',
			array(
				'label'     => __( 'Form Success Validation', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'form_success_message_color',
			array(
				'label'     => __( 'Success Message Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#008000',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_confirmation_message'   => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cf7_success_validation_typo',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_confirmation_message',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register GForms Styler Spacing Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_spacing_controls() {

		$this->start_controls_section(
			'form_spacing',
			array(
				'label' => __( 'Spacing', 'moomoo-extensions-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'form_title_margin_bottom',
				array(
					'label'      => __( 'Form Title Bottom Margin', 'moomoo-extensions-elementor' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'em', 'rem' ),
					'range'      => array(
						'px' => array(
							'min' => 0,
							'max' => 200,
						),
					),
					'condition'  => array(
						'form_title_option!' => 'none',
					),
					'selectors'  => array(
						'{{WRAPPER}} .uael-gf-form-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'form_desc_margin_bottom',
				array(
					'label'      => __( 'Form Description Bottom Margin', 'moomoo-extensions-elementor' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'em', 'rem' ),
					'range'      => array(
						'px' => array(
							'min' => 0,
							'max' => 200,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} .uael-gf-form-desc, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						'form_title_option!' => 'none',
					),
				)
			);

			$this->add_responsive_control(
				'form_fields_margin',
				array(
					'label'      => __( 'Between Two Fields', 'moomoo-extensions-elementor' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'em', 'rem' ),
					'range'      => array(
						'px' => array(
							'min' => 0,
							'max' => 200,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper li.gfield,
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper div.gfield, 
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gf_progressbar_wrapper,
						{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper fieldset.gfield' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'form_label_margin_bottom',
				array(
					'label'      => __( 'Label Bottom Spacing', 'moomoo-extensions-elementor' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'em', 'rem' ),
					'range'      => array(
						'px' => array(
							'min' => 0,
							'max' => 200,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_label, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gsection_title, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gf_progressbar_title,{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gf_page_steps' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
					),
				)
			);

			$this->add_responsive_control(
				'form_input_margin_top',
				array(
					'label'      => __( 'Input Top Spacing', 'moomoo-extensions-elementor' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'em', 'rem' ),
					'range'      => array(
						'px' => array(
							'min' => 0,
							'max' => 200,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container' => 'margin-top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'form_input_margin_bottom',
				array(
					'label'      => __( 'Input Bottom Spacing', 'moomoo-extensions-elementor' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'em', 'rem' ),
					'range'      => array(
						'px' => array(
							'min' => 0,
							'max' => 200,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);
			$this->add_control(
				'remove_margin_last_item',
				array(
					'label'        => __( 'Remove margin last item', 'moomoo-extensions-elementor' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'moomoo-extensions-elementor' ),
					'label_off'    => __( 'No', 'moomoo-extensions-elementor' ),
					'default'      => 'true',
					'label_block'  => false,
					'prefix_class' => 'remove-margin-last-item-',
				)
			);

			

		$this->end_controls_section();
	}

	/**
	 * Register GForms Styler Typography Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_typography_controls() {

		$this->start_controls_section(
			'form_typo',
			array(
				'label' => __( 'Typography', 'moomoo-extensions-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'form_title_typo',
			array(
				'label'     => __( 'Form Title', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'form_title_option!' => 'none',
				),
			)
		);
		$this->add_control(
			'form_title_tag',
			array(
				'label'     => __( 'HTML Tag', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'h1'  => __( 'H1', 'moomoo-extensions-elementor' ),
					'h2'  => __( 'H2', 'moomoo-extensions-elementor' ),
					'h3'  => __( 'H3', 'moomoo-extensions-elementor' ),
					'h4'  => __( 'H4', 'moomoo-extensions-elementor' ),
					'h5'  => __( 'H5', 'moomoo-extensions-elementor' ),
					'h6'  => __( 'H6', 'moomoo-extensions-elementor' ),
					'div' => __( 'div', 'moomoo-extensions-elementor' ),
					'p'   => __( 'p', 'moomoo-extensions-elementor' ),
				),
				'condition' => array(
					'form_title_option!' => 'none',
				),
				'default'   => 'h3',
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'title_typography',
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .uael-gf-form-title',
				'condition' => array(
					'form_title_option!' => 'none',
				),

			)
		);
		$this->add_control(
			'form_title_color',
			array(
				'label'     => __( 'Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'condition' => array(
					'form_title_option!' => 'none',
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .uael-gf-form-title' => 'color: {{VALUE}};',
				),

			)
		);

		$this->add_control(
			'form_desc_typo',
			array(
				'label'     => __( 'Form Description', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'form_title_option!' => 'none',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'desc_typography',
				'scheme'    => Typography::TYPOGRAPHY_2,
				'selector'  => '{{WRAPPER}} .uael-gf-form-desc, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_description',
				'condition' => array(
					'form_title_option!' => 'none',
				),
			)
		);
		$this->add_control(
			'form_desc_color',
			array(
				'label'     => __( 'Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				),
				'condition' => array(
					'form_title_option!' => 'none',
				),
				'default'   => '',
				'separator' => 'after',
				'selectors' => array(
					'{{WRAPPER}} .uael-gf-form-desc, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'form_input_typo',
			array(
				'label' => __( 'Form Fields', 'moomoo-extensions-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'form_label_typography',
				'label'    => 'Label Typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container label.gfield_label',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_typography',
				'label'    => 'Text Typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gfield input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]),
				 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container select,
				 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container .chosen-single,
				 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container textarea,
				 {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .uael-gf-select-custom',
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_desc_typography',
				'label'    => 'Description Typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gfield .gfield_description,
				{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_name input + label,
				{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_creditcard input + span + label,
				{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input + label,
				{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container select + label, 
				{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container .chosen-single + label,
				{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_time_hour label,
				{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gfield_time_minute label,
				{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_address label,
				{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container_total span,
				{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_shipping_price,
				{{WRAPPER}} .uael-gf-select-custom + label, 
				{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gsection_description',
			)
		);

		$this->add_control(
			'btn_typography_label',
			array(
				'label'     => __( 'Button Typography', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'btn_typography',
				'label'    => __( 'Typography', 'moomoo-extensions-elementor' ),
				'scheme'   => Typography::TYPOGRAPHY_4,
				'selector' => 'body {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type=submit], body {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"]',
			)
		);
		$this->end_controls_section();
	}

	

	/**
	 * GForms Styler refresh button.
	 *
	 * @since 1.2.0
	 * @access protected
	 */
	public function is_reload_preview_required() {
		return true;
	}

	/**
	 * Render GForms Styler output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function render() {
		
		$settings = $this->get_settings();
		ob_start();
			$classname = '';
			$moomooclassname ='';
			if ( 'yes' === $settings['gf_radio_check_custom'] ) {
				$classname = '';
			}
			
				

			?>
			<div class="uael-gf-style <?php echo 'elementor-widget-moomoo-gravity-form .elementor-widget-container'; ?> elementor-clickable">
				<?php
					$form_title  = '';
					$description = '';
					$form_desc   = 'false';
				if ( 'yes' === $settings['form_title_option'] ) {
					if ( class_exists( 'GFAPI' ) ) {
						$form       = array();
						$form       = GFAPI::get_form( absint( $settings['form_id'] ) );
						$form_title = isset( $form['title'] ) ? $form['title'] : '';
						$form_desc  = 'true';
					}
				} elseif ( 'no' === $settings['form_title_option'] ) {
					$form_title  = $this->get_settings_for_display( 'form_title' );
					$description = $this->get_settings_for_display( 'form_desc' );
					$form_desc   = 'false';
				} else {
					$form_title  = '';
					$description = '';
					$form_desc   = 'false';
				}
				if ( '' !== $form_title ) {
					?>
				<<?php echo esc_attr( $settings['form_title_tag'] ); ?> class="uael-gf-form-title"><?php echo wp_kses_post( $form_title ); ?></<?php echo esc_attr( $settings['form_title_tag'] ); ?>>
					<?php
				}
				if ( '' !== $description ) {
					?>
				<p class="uael-gf-form-desc"><?php echo wp_kses_post( $description ); ?></p>
					<?php
				}
				if ( '0' === $settings['form_id'] ) {
					esc_attr_e( 'Please select a Gravity Form', 'moomoo-extensions-elementor' );
				} elseif ( $settings['form_id'] ) {
					$ajax = ( 'yes' === $settings['form_ajax_option'] ) ? 'true' : 'false';

					$shortcode_extra = '';
					$shortcode_extra = apply_filters( 'uael_gf_shortcode_extra_param', '', absint( $settings['form_id'] ) );

					echo do_shortcode( '[gravityform id=' . absint( $settings['form_id'] ) . ' ajax="' . $ajax . '" title="false" description="' . $form_desc . '" tabindex=' . $settings['form_tab_index_option'] . ' ' . $shortcode_extra . ']' );
				}

				?>

			</div>
		<?php	
		$html = ob_get_clean();
		echo $html;
	}//render function

}