<?php
use ElementorPro\Base\Base_Widget;
use Elementor\Core\Schemes\Typography ;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;


class Elementor_Moomoo_Calculate_Stamp_Duty extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        $this->_widget_name = $this->get_name();
        
        add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
        
        parent::__construct( $data, $args );

        
    }
    public function get_name() {
        return 'moomoo-calculate-stamp-duty';
    }
    
    
    public function get_title() {
        return __( 'Moomoo Calculate Stamp Duty', 'moomoo-extensions-elementor' );
    }

    public function get_icon() {
        return 'fa-solid fa-calculator';
    }
    
    public function get_categories() {
        return [ 'basic' ];
    }

    public function ndt_enqueue_scripts() {
        wp_enqueue_style('moomoo-calculate-stamp-duty', MM_EXT_ASSET_URL .'/css/moomoo-calculate-stamp-duty.css', array(), '1.3.0');
        wp_enqueue_script('moomoo-calculate-stamp-duty', MM_EXT_ASSET_URL .'/js/moomoo-calculate-stamp-duty.js', array('jquery'),'1.3.0', true);
        
    }
    protected function register_controls() {
       $this->register_content_section_controls();
       $this->register_style_section_controls();

    }
    public function register_content_section_controls(){
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Layout', 'moomoo-extensions-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );   
        
        $this->add_control(
            'calculate_title',
            [
                'label' => __( 'Calculate Title', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Calculate your Stamp Duty', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Calculate your Stamp Duty', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_property_price',
            [
                'label' => __( 'Property Price', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Property Price', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Property Price', 'moomoo-extensions-elementor' ),
            ]
        );
         $this->add_control(
            'calculate_error_alert',
            [
                'label' => __( 'Error Alert', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Please enter a numerical value', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Please enter a numerical value', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_unit_currency',
            [
                'label' => __( 'Unit Currency', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( '£', 'moomoo-extensions-elementor' ),
                'placeholder' => __( '£', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_checkbox_1',
            [
                'label' => __( 'Checkbox Label 1', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'The buyer is a non-UK resident', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'The buyer is a non-UK resident', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_checkbox_2',
            [
                'label' => __( 'Checkbox Label 2', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Property is a first home', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Property is a first home', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_checkbox_3',
            [
                'label' => __( 'Checkbox Label 3', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Property is a buy to let or second home*', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Property is a buy to let or second home*', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_checkbox_3_second_line',
            [
                'label' => __( 'Checkbox Label 3 - Second line', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __( '*Buy-to-let/second home rates are 3 percentage points above the current SDLT (Stamp Duty Land Tax)', 'moomoo-extensions-elementor' ),
                'placeholder' => __( '*Buy-to-let/second home rates are 3 percentage points above the current SDLT (Stamp Duty Land Tax)', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_button',
            [
                'label' => __( 'Button Label', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Button Label', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Button Label', 'moomoo-extensions-elementor' ),
            ]
        );

        $this->add_control(
            'calculate_result',
            [
                'label' => __( 'Result', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Result', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Result', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_stamp_duty_to_pay',
            [
                'label' => __( 'Stamp Duty to pay:', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Stamp Duty to pay:', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Stamp Duty to pay:', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_effective_rate',
            [
                'label' => __( 'Effective Rate:', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Effective Rate:', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Effective Rate:', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_result_title',
            [
                'label' => __( 'How the Stamp Duty is calculated', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __( 'How the Stamp Duty is calculated', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'How the Stamp Duty is calculated', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_tax_band',
            [
                'label' => __( 'Tax Band', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Tax Band', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Tax Band', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_tax_precent',
            [
                'label' => __( '%', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( '%', 'moomoo-extensions-elementor' ),
                'placeholder' => __( '%', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_tax_sum',
            [
                'label' => __( 'Taxable Sum', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Taxable Sum', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Taxable Sum', 'moomoo-extensions-elementor' ),
            ]
        );
        $this->add_control(
            'calculate_tax',
            [
                'label' => __( 'Tax', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Tax', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Tax', 'moomoo-extensions-elementor' ),
            ]
        );        
        $this->end_controls_section();
    }
    
    public function register_style_section_controls(){

        $this->start_controls_section(
            'tabcontent_section',
            [
                'label' => __( 'General Style', 'moomoo-extensions-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'form_width',
            [
                'label' => __( 'Limit Form Width', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1920,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                        'unit' => 'px',
                        'size' => 800,
                ],
                'selectors' => [
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'calculate_general',
                'label' =>'Calculate General',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .calculator, {{WRAPPER}} .moomoo-calculate-stamp-duty .calculator .checkbox label',             
                
            ]
        );
        $this->add_responsive_control(
            'calculate_general_color',
            [
                'label' => __( 'Calculate Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'type'      => Controls_Manager::COLOR,
                'default'   => '#333',
                'selectors' => [
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'calculate_title_style',
                'label' =>'Calculate Title',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .calculator h2',             
                
            ]
        );
        $this->add_responsive_control(
            'calculate_title_color',
            array(
                'label'     => __( 'Calculate Title Color', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000',
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator h2' => 'color: {{VALUE}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'calculate_error_style',
                'label' =>'Error sms',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .calculator p.stamp-error',             
                
            ]
        );
        $this->add_responsive_control(
            'calculate_error_color',
            array(
                'label'     => __( 'Error sms Color', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#d0103a',
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator p.stamp-error' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'calculate_result_style',
                'label' =>'Calculate Result',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .calculator h3',             
                
            ]
        );
        $this->add_responsive_control(
            'calculate_result_color',
            array(
                'label'     => __( 'Calculate Result Color', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#d0103a',
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator h3' => 'color: {{VALUE}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'calculate_stamp_duty_style',
                'label' =>'Stamp Duty & Rate',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .calculator .results-list h5',             
                
            ]
        );
        $this->add_responsive_control(
            'calculate_stamp_duty_color',
            array(
                'label'     => __( 'Stamp Duty & Rate Color', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000',
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator .results-list h5' => 'color: {{VALUE}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'calculate_amount_stamp_style',
                'label' =>'Amount Stamp',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .calculator .results-list table td div',             
                
            ]
        );
        $this->add_responsive_control(
            'calculate_amount_stamp_color',
            array(
                'label'     => __( 'Amount Stamp Color', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000',
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator .results-list table td div' => 'color: {{VALUE}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'calculate_table_title_style',
                'label' =>'Table Title',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .calculator .results-table h3',             
                
            ]
        );
        $this->add_responsive_control(
            'calculate_table_title_color',
            array(
                'label'     => __( 'Table Title Color', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000',
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator .results-table h3' => 'color: {{VALUE}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'calculate_table_head_style',
                'label' =>'Table Header Row',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .calculator .results-table table th',             
                
            ]
        );
        $this->add_responsive_control(
            'calculate_table_head_color',
            array(
                'label'     => __( 'Table Header Row Color', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000',
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator .results-table table th' => 'color: {{VALUE}};',
                ),
            )
        );
        $this->add_responsive_control(
            'calculate_table_first_row_color',
            array(
                'label'     => __( 'Border Buttom Color Of First Row ', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#d0103a',
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator .results-table table tr:first-child' => 'border-color: {{VALUE}};',
                ),
            )
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'calculate_table_body',
                'label' =>'Table Body Cell',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .calculator .results-table table td',             
                
            ]
        );
        $this->add_responsive_control(
            'calculate_table_body_color',
            array(
                'label'     => __( 'Table Body Cell Color', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#333',
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator .results-table table td' => 'color: {{VALUE}};',
                ),
            )
        );
        //Button style
         $this->add_responsive_control(
            'calculate_button_heading',
            [
                'label' => __( 'Button', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            array(
                'label' => __( 'Normal', 'moomoo-extensions-elementor' ),
            )
        );
        // Button text color
        $this->add_responsive_control(
            'button_text_color',
            array(
                'label'     => __( 'Text Color', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator .button' => 'color: {{VALUE}};',
                ),
            )
        );
        // Button background color
        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'           => 'btn_background_color',
                'label'          => __( 'Background Color', 'moomoo-extensions-elementor' ),
                'types'          => array( 'classic', 'gradient' ),             
                'selector'       => '{{WRAPPER}} .moomoo-elementor-extension .calculator .button',
            )
        );
        // Button Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'btn_border',
                'label'       => __( 'Border', 'moomoo-extensions-elementor' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .moomoo-elementor-extension .calculator .button',
            )
        );
        // Buttonn radius
        $this->add_responsive_control(
            'btn_border_radius',
            array(
                'label'      => __( 'Border Radius', 'moomoo-extensions-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        // Bengin Button Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .calculator .button',
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            array(
                'label' => __( 'Hover', 'moomoo-extensions-elementor' ),
            )
        );

        $this->add_responsive_control(
            'btn_hover_color',
            array(
                'label'     => __( 'Text Color', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#eee',
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator .button:hover' => 'color: {{VALUE}};',
                ),
            )
        );

         $this->add_responsive_control(
            'button_hover_border_color',
            array(
                'label'     => __( 'Border Color', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::COLOR,                
                'selectors' => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .calculator .button:hover' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'button_background_hover_color',
                'label'    => __( 'Background Color', 'moomoo-extensions-elementor' ),
                'types'    => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .calculator .button:hover'
            )
        );

       
        
        $this->end_controls_tab();

        $this->end_controls_tabs();
        //end button sytle
        
        $this->end_controls_section();

    }
   
    protected function render() {
        $settings = $this->get_settings_for_display();
        extract($settings);  
        ?>
          <div class="moomoo-elementor-extension">
            <div class="moomoo-calculate-stamp-duty">
                <form method="post" action="" id="form1">
                    <div class="calculator">
                        <div>
                            <div>
                                <h2><?php echo $calculate_title ?></h2> 
                                <label><?php echo $calculate_property_price; ?></label>
                            </div>
                            <div>
                                 <div class="input-field">
                                    <div class="key"><span><?php echo $calculate_unit_currency; ?></span></div>
                                    <input id="priceNew" type="text" class="js-price-format" autocomplete="new_password">
                                </div>
                                <input type="hidden" id="calculate_unit_currency" value="<?php echo $calculate_unit_currency; ?>">
                                <p class="stamp-error"><?php echo $calculate_error_alert; ?></p>
                            </div>
                            </div>
                        <div>
                            <div class="checkbox">
                                <input id="overseasBuyer" type="checkbox" data-tc-value="4"><label for="overseasBuyer"><?php echo $calculate_checkbox_1; ?></label>
                            </div>
                            <div class="checkbox">
                                <input id="firstHomeNew" type="checkbox" data-tc-value="1"><label for="firstHomeNew"><?php echo $calculate_checkbox_2; ?></label>
                            </div>
                            <div class="checkbox">
                                <input id="secondHomeNew" type="checkbox" data-tc-value="2"><label for="secondHomeNew"><?php echo $calculate_checkbox_3; ?><span><?php echo $calculate_checkbox_3_second_line; ?></span></label>
                            </div>
                            
                            <div >
                                <button type="button" class="button js-stamp-duty-calculate tc-stamp-duty-button"><?php echo $calculate_button; ?></button>
                            </div>
                        </div>
                        <div id="divResultNew">
                            <div class="stamp-results">
                                <div>
                                    <h3><?php echo $calculate_result; ?></h3>
                                </div>
                            </div>
                            <section class="results-list">
                                <table>
                                    <tbody><tr>
                                        <td>
                                            <h5><?php echo $calculate_stamp_duty_to_pay; ?></h5>
                                            <div id="amountToPayNew" class="stamp-red"></div>
                                        </td>
                                        <td>
                                            <h5><?php echo $calculate_effective_rate; ?></h5>
                                            <div id="effectiveRateNew" class="stamp-red"></div>
                                        </td>
                                    </tr>
                                </tbody></table>
                            </section>

                            <div class="results-table">
                                <h3><?php echo $calculate_result_title; ?></h3>

                                <table id="resultTableNew">
                                    <tbody><tr>
                                        <th style="width: 28%;"><?php echo $calculate_tax_band; ?></th>
                                        <th style="width: 16%;"><?php echo $calculate_tax_precent; ?></th>
                                        <th style="width: 28%;"><?php echo $calculate_tax_sum; ?></th>
                                        <th style="width: 28%;"><?php echo $calculate_tax; ?></th>
                                    </tr>
                                </tbody></table>
                            </div>
                        </div>
                    </div>   
                </form>
            </div>
          </div>
        <?php        
       
    }
}