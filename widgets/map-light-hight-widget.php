<?php

use Elementor\Controls_Manager;

/*use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;*/
/*use Elementor\Control_Repeater;
use Elementor\Core\Kits\Controls;*/
/*use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;*/

class Elementor_Team_Member_Map_Light_Hight_Widget extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        $this->_widget_name = $args['widget_name'];
        
        add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
        
        parent::__construct( $data, $args );

        
    }
    public function get_name() {
        return 'moomoo-team-memeber-map-light-hight';
    }
    
    
    public function get_title() {
        return __( 'Moomoo Team Member Map Light Hight', 'moomoo-extensions-elementor' );
    }

    public function get_icon() {
        return 'eicon-google-maps';
    }
    
    public function get_categories() {
        return [ 'basic' ];
    }

    public function ndt_enqueue_scripts() {
        wp_enqueue_style('mm-ext-map-light-hight-widget', MM_EXT_ASSET_URL .'/css/map-light-hight-widget.css', array(), time());
        wp_enqueue_script('mm-ext-map-light-hight-widget', MM_EXT_ASSET_URL .'/js/map-light-hight-widget.js', array(), time());
        
    }
    protected function register_controls() {

        

        $this->start_controls_section(
            'section_tabs',
            [
                'label' => __( 'Members', 'moomoo-extensions-elementor' ),
            ]
        );

        //$repeater = new Repeater();
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'member_name',
            [
                'label' => __( 'Name', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Member Name#01', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Member Name', 'moomoo-extensions-elementor' ),
                'label_block' => false,
            ]
        );
        $repeater->add_control(
            'member_photo',
            [
                'label' => __( 'Member photo', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::MEDIA
            ]
        );
        $repeater->add_control(
            'member_coords',
            [
                'label' => __( 'Coordinates', 'moomoo-extensions-elementor' ),
                 'type' => Controls_Manager::TEXTAREA,
                'default' => __( '1129,499, 1123,484, 1111,476', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'You can get coordinates at image-map.net', 'moomoo-extensions-elementor' ),
                'label_block' => true,
                'description'=> 'You can get coordinates at <a href="https://www.image-map.net/" target="_blank">here</a>'
            ]
        );
        

        $repeater->add_control(
            'member_email',
            [
                'label' => __( 'Email Address', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'info@crestbrick.com', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Email Address', 'moomoo-extensions-elementor' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'member_url',
            [
                'label' => __( 'Url to detail member', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'moomoo-extensions-elementor' ),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ]
            ]
        );
        $repeater->add_control(
            'member_position_tooltip_top',
            [
                'label' => __( 'Tooltip Top Position', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default'=>'45',
                'label_block' => false,
            ]
        );
        $repeater->add_control(
            'member_position_tooltip_left',
            [
                'label' => __( 'Tooltip Left Position', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default'=>'45',
                'label_block' => false,
            ]
        );
        $repeater->add_control(
            'memeber_info_detail_active',
            [
                'label' => __( 'Disable info detail', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'on',
            ]
        );

       /* $repeater->add_control(
            'memeber_content',
            [
                'label' => __( 'Content', 'moomoo-extensions-elementor' ),
                'default' => __( 'Member Content', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'This is content when hover to user', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::WYSIWYG,
                'show_label' => false,
                'dynamic' => [
                    'active' => false,
                ],
            ]
        );*/

        $this->add_control(
            'members',
            [
                'label' => __( 'Member', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'member_name' => __( 'Memeber #1', 'moomoo-extensions-elementor' ),
                        'member_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'moomoo-extensions-elementor' )                        
                       
                    ],
                    [
                        'member_name' => __( 'Memeber #2', 'moomoo-extensions-elementor' ),
                        'member_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'moomoo-extensions-elementor' )
                    ],
                ],
                'title_field' => '{{{ member_name }}}',
            ]
        );
        $this->add_control(
            'tooltip_background_color',
            [
                'label' => __( 'Background tooltip', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #map-light-hight .map-hover-detail > div' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} #map-light-hight .map-hover-detail > div:after'=>'border-color:transparent transparent {{VALUE}} transparent'
                ],
            ]
        ); 
        $this->add_control(
            'team_photo',
            [
                'label' => __( 'Team photo', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => MM_EXT_ASSET_URL.'/images/team-photo-min.png' ,
                ]
            ]
        );
        $this->add_control(
            'team_photo_size',
            [
                'label' => __( 'Team photo size', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'default' => [
                    'width' => '1920',
                    'height' => '1327',
                ]
            ]
        );
        

        $this->end_controls_section();

    }


    protected function render() {

        $members = $this->get_settings_for_display();
        $team_photo         = $members['team_photo']['url'];
        $team_photo_size    = $members['team_photo_size'];
       

            ?>
            <div class="moomoo-elementor-extension">
                <div id="map-light-hight" class="map-light-hight">
                    <div id="box-map" data-width="<?php  echo $team_photo_size['width']; ?>" data-height="<?php  echo $team_photo_size['height']; ?>" style="width: <?php echo $team_photo_size['width'].'px'; ?>">          
                         <map id="map-area" name="map-area">
                            <?php 
                            foreach ($members[ 'members' ] as $member ) {

                                $member_name        = $member['member_name'];              
                                $member_coords      = $member['member_coords'];                       
                                $member_url         = $member['member_url']['url'];
                                ?>
                                <area shape="poly" alt="<?php echo $member_name;?>" coords="<?php echo $member_coords; ?>" href="<?php echo $member_url; ?>" data-hover="<?php echo sanitize_title($member_name) ?>" data-hover-details="map-hover-<?php echo sanitize_title($member_name) ?>" >
                                <?php                               
                            } 
                            ?>
                            
                        </map>
                        <div class="map-images">
                            <img src="<?php echo $team_photo ?>" alt="Team our" usemap="#map-area" class="map-images" >
                        </div>

                        <div class="map-hover">
                            <?php 
                            foreach ($members[ 'members' ] as $member ) {

                                $member_name        = $member['member_name'];
                                $member_photo       = $member['member_photo']['url'];

                                ?>
                                <img id="<?php echo sanitize_title($member_name) ?>" src="<?php echo $member_photo?>" alt="<?php echo $member_name;?>">
                                <?php                               
                            } 
                            ?>

                        </div>
                        <div class="map-hover-detail">
                            <?php 
                            foreach ($members[ 'members' ] as $member ) {

                                $member_name        = $member['member_name'];                               
                                $member_email       = $member['member_email'];   
                                $member_position_tooltip  = $member['member_position_tooltip'];
                                $memeber_info_detail_active = ($member['memeber_info_detail_active'] == 'yes')? 'hidden' :'';
                                $unit ='%';
                                $top = $member['member_position_tooltip_top'];
                                $left = $member['member_position_tooltip_left'];

                               /* $unit   = $member_position_tooltip['unit'];
                                $top    = $member_position_tooltip['top'];
                                $right  = $member_position_tooltip['right'];
                                $bottom = $member_position_tooltip['bottom'];
                                $left   = $member_position_tooltip['left'];  */          
                               
                                ?>
                                <div id="map-hover-<?php echo sanitize_title($member_name) ?>" class="member"  style="top:<?php echo $top.$unit ?>; left:<?php echo $left.$unit ?>">
                                    <div class="name">
                                        Meet<b> <?php echo $member_name;?></b>
                                    </div>
                                    <ul class="info-contact <?php echo $memeber_info_detail_active; ?>">
                                        <li>
                                            <div class="icon">
                                                <i class="eicon-mail" aria-hidden="true"></i>
                                            </div> 
                                            <a href="mailto:<?php echo $member_email; ?>"><?php echo $member_email; ?></a></li>
                                    </ul>
                                </div>
                                <?php                               
                            } 
                            ?>
                           
                        </div>

                    </div>
                </div>
            </div>
           
        
        <?php

    }

  

}