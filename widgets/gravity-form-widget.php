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
		
		wp_enqueue_style('mm-gravity-basic-form-widget', plugins_url('gravityforms/assets/css/dist/basic.min.css'), array(), '2.6.1.1');
		wp_enqueue_style('mm-gravity-theme-widget', plugins_url('gravityforms/assets/css/dist/theme.min.css'), array(), '2.6.1.1');
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
	protected function register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		$this->register_general_content_controls();
		$this->register_form_fields_content_controls();
		$this->register_radio_content_controls();
		$this->register_checkbox_content_controls();
		$this->register_next_content_controls();
		$this->register_previous_content_controls();		
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
		//Fields Margin
		$this->add_responsive_control(
			'fields_padding',
			array(
				'label'      => __( 'Space Bettwen Fields', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'allowed_dimensions' => array('top', 'bottom'),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper form .gform_fields .gfield' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
				),
			)
		);
		//Form Width
		$this->add_responsive_control(
            'form_width',
            [
                'label' => __( 'Limit Form Width', 'moomoo-extensions-elementor' ),
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
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-moomoo-gravity-form' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
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
            'input_style',
            [
                'label' => __( 'Input Fields', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
		//border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'moomoo-extensions-elementor' ),
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=date],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=email],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=number],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=password],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=search],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=tel],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=text],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=url],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container select,{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container textarea'
			]
		);
		//Background Color
		$this->add_control(
			'form_input_bgcolor',
			array(
				'label'     => __( 'Background Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#eeeeee',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=date],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=email],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=number],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=password],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=search],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=tel],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=text],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=url],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container select,{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container textarea' => 'background-color:{{VALUE}};',
				),
			)
		);
		//Text Color
		$this->add_control(
			'form_input_textcolor',
			array(
				'label'     => __( 'Text Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=date],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=email],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=number],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=password],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=search],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=tel],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=text],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=url],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container select,{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container textarea' => 'color:{{VALUE}};',
				),
			)
		);
		// Placeholder color
		$this->add_control(
			'form_input_color',
			array(
				'label'     => __( 'Input Text / Placeholder Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
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
		//Border Radius
		$this->add_responsive_control(
			'input_border_radius',
			array(
				'label'      => __( 'Border Radius', 'moomoo-extensions-elementor' ),
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
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=date],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=email],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=number],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=password],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=search],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=tel],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=text],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=url],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container select,{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		//Input Padding
		$this->add_responsive_control(
			'form_input_padding',
			array(
				'label'      => __( 'Padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=date],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=email],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=number],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=password],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=search],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=tel],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=text],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container input[type=url],{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container select,{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .ginput_container textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		
		//heading Label
		$this->add_control(
            'style_label',
            [
                'label' => __( 'Label', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        //Label Color
		$this->add_control(
			'form_label_color',
			array(
				'label'     => __( 'Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,				
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
        //label Position 
         $this->add_responsive_control(
            'label_position',
            array(
                'label'        => __( 'Position', 'moomoo-extensions-elementor' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'above',
                'options'      => array(
                    'above' => __( 'Above inputs', 'moomoo-extensions-elementor' ),
                    'left' => __( 'Left inputs', 'moomoo-extensions-elementor' ),
                    'right' => __( 'Right inputs', 'moomoo-extensions-elementor' )
                ),                
                'prefix_class' => 'moomoo-label-position-%s'
            )
        );
        
        //Label Vertical Align
		$this->add_responsive_control(
			'vertical_label',
			array(
				'label'        => __( 'Vertical Align ', 'moomoo-extensions-elementor' ),
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
				'condition' => array(
					'label_position' => [ 'left', 'right' ]
				),
				'default'      => 'top',
				'selectors' => array(
					'{{WRAPPER}}.moomoo-label-position-left .gform_wrapper.gravity-theme .gfield:not(.gsection):not(.gfield_html):not(fieldset), {{WRAPPER}}.moomoo-label-position-right .gform_wrapper.gravity-theme .gfield:not(.gsection):not(.gfield_html):not(fieldset)' => 'align-items: {{VALUE}};',
				),
				'toggle'       => false,
			)
		);   
		//Label Alignment
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
		//Label Width
		$this->add_responsive_control(
            'label_width',
            [
                'label' => __( 'Width', 'moomoo-extensions-elementor' ),
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
                'desktop_default' => [
					'size' => 300,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 200,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 100,
					'unit' => 'px',
				],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container label.gfield_label' => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}}.elementor-widget-moomoo-gravity-form' => '--label-width:{{SIZE}}{{UNIT}}'
                ],
            ]
        );		
		//Label Padding
		$this->add_responsive_control(
			'form_label_padding',
			array(
				'label'      => __( 'Padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container label.gfield_label'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				),
			)
		);		
		
		//heading Description
		$this->add_control(
            'style_description',
            [
                'label' => __( 'Description', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
		//Description Color
		$this->add_control(
			'form_input_desc_color',
			array(
				'label'     => __( 'Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,				
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
		//Description position 
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
		//Description Alignment
		$this->add_responsive_control(
			'align_description',
			array(
				'label'        => __( 'Alignment Description ', 'moomoo-extensions-elementor' ),
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
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gravity-theme form .gfield .gfield_description:not(.validation_message)' => 'text-align: {{VALUE}};',
				),
				'toggle'       => false,
			)
		); 
		//Description margin
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
		//Description Width
		$this->add_responsive_control(
            'description_width',
            [
                'label' => __( 'Width', 'moomoo-extensions-elementor' ),
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
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gfield_description:not(.validation_message)' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
		//Description style
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'label' =>'Description style',						
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gfield .gfield_description',				
				
			]
		);
		
		//heading Custom field
		$this->add_control(
            'style_pda',
            [
                'label' => __( 'Custom Field', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'description' =>'Pls add this class: moomoo-custom-field into field that you want to custom'
            ]
        );
        $this->add_control(
            'style_note',
            [
                'label' => __( 'Pls add this class: moomoo-custom-field into field that you want to custom', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'description' =>'Pls add this class: "moomoo-custom-field" into field that you want to custom'
            ]
        );
       
		//Custom style
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pda_typography',
				'label' =>'Style',						
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper .gform_body.gform-body .ginput_container.ginput_container_checkbox .gchoice .gfield-choice-input+label',				
				
			]
		);
		//Custom Color
		$this->add_control(
			'form_pad_field_color',
			array(
				'label'     => __( 'Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper .gform_body.gform-body .ginput_container.ginput_container_checkbox .gchoice .gfield-choice-input+label' => 'color: {{VALUE}};',
				),
			)
		);
		//Custom Padding
		$this->add_responsive_control(
			'pda_padding',
			array(
				'label'      => __( 'Padding', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper .gform_body.gform-body .ginput_container.ginput_container_checkbox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				
			)
		);
		//Custom Alignment
		$this->add_responsive_control(
			'pda_align',
			array(
				'label'     => __( 'Alignment', 'moomoo-extensions-elementor' ),
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
		//Required Asterisk Color
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

		
		$this->end_controls_section();
	}


	/**
	 * Register GForms Styler Radio Controls.	 
	 */
	protected function register_radio_content_controls() {
		$this->start_controls_section(
			'gf_radio_style',
			array(
				'label' => __( 'Radio', 'moomoo-extensions-elementor' ),
			)
		);
		$this->add_responsive_control(
			'gf_radio_horizontal',
			array(
				'label'        => __( 'Horizontal radio fields', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'moomoo-extensions-elementor' ),
				'label_off'    => __( 'No', 'moomoo-extensions-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'moomoo-horizontal-radio-%s',
			)
		);
		$this->add_responsive_control(
				'gf_radio_field_width',
				array(
					'label'      => __( 'Field width', 'moomoo-extensions-elementor' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( '%','px' ),
					'range'      => array(
						'%' => array(
							'min' => 0,
							'max' => 100,
						),
						'px' => array(
							'min' => 0,
							'max' => 1366,
						),
					),
					'default' => [
						'unit' => '%',
						'size' => 100,
					],
					'selectors'  => array(
						'{{WRAPPER}}.moomoo-horizontal-radio-yes .gfield_radio>div' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);		

		

		$this->add_control(
			'gf_radio_size',
			array(
				'label'      => _x( 'Size', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),				
				'default'    => array(
					'unit' => 'px',
					'size' => 13,
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .ginput_container.ginput_container_radio .gfield_radio label:before'  => 'width:{{SIZE}}{{UNIT}}; min-width:{{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .ginput_container.ginput_container_radio .gfield_radio input[type="radio"]'  => 'width:{{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				),
			)
		);
		
		$this->add_control(
			'radio_selected_color',
			array(
				'label'     => __( 'Selected Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .ginput_container.ginput_container_radio .gfield_radio input:checked +label:before' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'radio_label_color',
			array(
				'label'     => __( 'Label Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .ginput_container.ginput_container_radio .gfield_radio label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'gf_check_border_color',
			array(
				'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .ginput_container.ginput_container_radio .gfield_radio label:before' => 'border-color: {{VALUE}};',
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
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .ginput_container.ginput_container_radio .gfield_radio label:before' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
				),
			)
		);
		 $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'radio_label',
                'label' =>'Label Style',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .ginput_container.ginput_container_radio .gfield_radio label',             
                
            ]
        );

		$this->end_controls_section();
	}
	/**
	 * Register GForms Styler checkbox Controls.	 
	 */
	protected function register_checkbox_content_controls() {
		$this->start_controls_section(
			'gf_checkbox_check_style',
			array(
				'label' => __( 'Checkbox', 'moomoo-extensions-elementor' ),
			)
		);
		$this->add_responsive_control(
			'gf_checkbox_horizontal',
			array(
				'label'        => __( 'Horizontal checkbox fields', 'moomoo-extensions-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'moomoo-extensions-elementor' ),
				'label_off'    => __( 'No', 'moomoo-extensions-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'moomoo-horizontal-checkbox-%s',
			)
		);
		$this->add_responsive_control(
				'gf_checkbox_field_width',
				array(
					'label'      => __( 'Field width', 'moomoo-extensions-elementor' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( '%','px' ),
					'range'      => array(
						'%' => array(
							'min' => 0,
							'max' => 100,
						),
						'px' => array(
							'min' => 0,
							'max' => 1366,
						),
					),
					'default' => [
						'unit' => '%',
						'size' => 100,
					],
					'selectors'  => array(
						'{{WRAPPER}}.moomoo-horizontal-checkbox-yes .gfield_checkbox>div' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'checkbox_label',
                'label' =>'Label Style',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .ginput_container.ginput_container_checkbox .gfield_checkbox label',             
                
            ]
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
		//Button Alignment
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
		//Button Width
		$this->add_responsive_control(
            'button_submit_width',
            [
                'label' => __( 'Width', 'moomoo-extensions-elementor' ),
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
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="submit"], {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"]' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

		$this->add_responsive_control(
			'gf_button_padding',
			array(
				'label'      => __( 'Padding Submit', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="submit"], {{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container input[type="button"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				)
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
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper .gform_footer' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0',
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
	protected function register_next_content_controls() {
		$this->start_controls_section(
			'section_next_next_style',
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
		$this->add_responsive_control(
			'next_button_margin',
			array(
				'label'      => __( 'Margin', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				//'allowed_dimensions' => array('top', 'bottom'),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_next_button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				
			)
		);
		$this->add_responsive_control(
			'next_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_next_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'next_button_box_shadow',
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_next_button',
			)
		);

		$this->add_responsive_control(
            'next_button_width',
            [
                'label' => __( 'Width', 'moomoo-extensions-elementor' ),
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
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_next_button' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
		
		$this->start_controls_tabs( 'tabs_next_style' );

		$this->start_controls_tab(
			'tab_button_next',
			array(
				'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
			)
		);
       	//text
       	$this->add_control(
            'text_button_color_next',
            [
                'label' => __( 'Text Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_next_button' => 'color: {{VALUE}}'
                ],
            ]
        );

        //border
        $this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'next_button_border',
					'label' => esc_html__( 'Border Color', 'moomoo-extensions-elementor' ),
					'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_next_button',
				]
			);

        //background
        $this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'bg-next-button',
					'label' => __( 'Background', 'moomoo-extensions-elementor' ),
					'types' => [ 'classic', 'gradient'],
					'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_next_button'
				] 
			);
				
		
		$this->end_controls_tab();
		$this->start_controls_tab(
			'next_button_hover',
			array(
				'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
			)
		);		
		
		//text hover
		$this->add_control(
	            'text_button_color_next_hover',
	            [
	                'label' => __( 'Text Color', 'moomoo-extensions-elementor' ),
	                'type' => Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_next_button:hover' => 'color: {{VALUE}}'
	                ],
	            ]
	        );
		//border hover
		$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'next_button_border_hover',
					'label' => esc_html__( 'Border hover', 'moomoo-extensions-elementor' ),
					'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_next_button:hover',
				]
			);
		//background hover
		$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'bg-next-button-hover',
					'label' => __( 'Background hover', 'moomoo-extensions-elementor' ),
					'types' => [ 'classic', 'gradient'],
					'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_next_button:hover'
				] 
			);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		
	}
	protected function register_previous_content_controls() {
		$this->start_controls_section(
			'section_prev_style',
			array(
				'label' => __( 'Previous Button', 'moomoo-extensions-elementor' ),
			)
		);
		//prev padding
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
		//prev margin
		$this->add_responsive_control(
			'prev_button_margin',
			array(
				'label'      => __( 'Margin', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				//'allowed_dimensions' => array('top', 'bottom'),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				
			)
		);
		//prev border radius
		$this->add_responsive_control(
			'prev_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'moomoo-extensions-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		//prev shadown
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'prev_button_box_shadow',
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button',
			)
		);
		//prev width
		$this->add_responsive_control(
            'prev_button_width',
            [
                'label' => __( 'Width', 'moomoo-extensions-elementor' ),
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
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
				
		$this->start_controls_tabs( 'tabs_prev_style' );

		$this->start_controls_tab(
			'tab_button_prev',
			array(
				'label' => __( 'Previous Normal', 'moomoo-extensions-elementor' ),
			)
		);
       	// text
		$this->add_control(
	            'text_button_color_previous',
	            [
	                'label' => __( 'Text color', 'moomoo-extensions-elementor' ),
	                'type' => Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button' => 'color: {{VALUE}}'
	                ],
	            ]
	        );
       	// border
		$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'previous_button_border',
					'label' => esc_html__( 'Border', 'moomoo-extensions-elementor' ),
					'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button',
				]
			);
       	// background
		$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'bg-prev-button',
					'label' => __( 'Previous Button', 'moomoo-extensions-elementor' ),
					'types' => [ 'classic', 'gradient'],
					'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button'
				] 
			);		
		
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_button_prev_hover',
			array(
				'label' => __( 'Previous Hover', 'moomoo-extensions-elementor' ),
			)
		);
		// text hover
		$this->add_control(
	            'text_button_color_previous_hover',
	            [
	                'label' => __( 'Text color', 'moomoo-extensions-elementor' ),
	                'type' => Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button:hover' => 'color: {{VALUE}}'
	                ],
	            ]
	        );
       	// border hover
       	
       	$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'previous_button_border_hover',
					'label' => esc_html__( 'Border Hover', 'moomoo-extensions-elementor' ),
					'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button:hover',
				]
			);
       	// background hover
		$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'bg-prev-button-hover',
					'label' => __( 'Background Hover', 'moomoo-extensions-elementor' ),
					'types' => [ 'classic', 'gradient'],
					'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container .gform_wrapper .gform_page_footer .gform_previous_button:hover'
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
				'selector' => '{{WRAPPER}}.elementor-widget-moomoo-gravity-form .elementor-widget-container label.gfield_label, {{WRAPPER}}.elementor-widget-moomoo-gravity-form .gform_wrapper.gravity-theme legend',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_typography',
				'label'    => 'Text Typography',				
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

			?>
			<div class="<?php echo 'elementor-widget-moomoo-gravity-form .elementor-widget-container'; ?> elementor-clickable">
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