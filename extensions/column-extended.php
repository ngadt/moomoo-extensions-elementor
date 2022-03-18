<?php
/**
 * Column Option Enhance functions
 *
 */


use Elementor\Controls_Manager;
use Elementor\Element_Column;

defined('ABSPATH') || die();

class MooMoo_Column_Extended {

     public static function init() {       
        add_action( 'elementor/element/column/_section_responsive/before_section_end', [ __CLASS__, 'add_controls' ] );
    }

    public static function add_controls( Element_Column $element ) {

        $element->add_responsive_control(
            'mm-column-order',
            [
                'label' => __( 'Column Order', 'moomoo-extensions' ),
                'type' => Controls_Manager::NUMBER,
                'style_transfer' => true,
               // 'devices' => [ 'mobile','tablet' ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-column' => '-webkit-box-ordinal-group: calc({{VALUE}} + 1 ); -ms-flex-order:{{VALUE}}; order: {{VALUE}};',
                ]
            ]
        );
    }
}

MooMoo_Column_Extended::init();
