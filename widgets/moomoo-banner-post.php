<?php

use ElementorPro\Base\Base_Widget;
use Elementor\Core\Schemes\Typography ;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


class Elementor_Moomoo_Banner_Post extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        $this->_widget_name = $this->get_name();
        
        add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
        
        parent::__construct( $data, $args );

        
    }
    public function get_name() {
        return 'moomoo-banner-post';
    }
    
    
    public function get_title() {
        return __( 'Moomoo Banner Post', 'moomoo-extensions-elementor' );
    }

    public function get_icon() {
        return 'fab fa-image';
    }
    
    public function get_categories() {
        return [ 'basic' ];
    }

    public function ndt_enqueue_scripts() {
        wp_enqueue_style('mm-banner-post', MM_EXT_ASSET_URL .'/css/moomoo-banner-post.css', array(), time());
       /* wp_enqueue_script('mm-banner-post', MM_EXT_ASSET_URL .'/js/moomoo-media.js', array('jquery'), time(), true);*/
        
    }
    protected function _register_controls() {
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

         $this->add_responsive_control(
            'mm_height_banner',
            [
                'label' => __( 'Height Banner', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                        'step' => 20,
                    ]
                ],
                'default' => [
                    'unit' => 'px', 
                    'size' => 300,
                ],
                'show_label' => true,
                'selectors' => [
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-banner-post .wrap-banner-post' => 'height: {{SIZE}}{{UNIT}}'
                    
                ],
            ]
        );
        $this->add_control(
            'mm_image', 
            [
                'label' => __( 'Upload Image', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::MEDIA
            ]
        );
        $this->add_responsive_control(
            'mm_image_width',
            [
                'label' => __( 'Image Width', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px','%'],                
                'show_label' => true,
                'selectors' => [
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-banner-post .wrap-banner-post .center-box img' => 'height: {{SIZE}}{{UNIT}}'
                    
                ],
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
         $this->add_control(
            'description_style',
            [
                'label' => __( 'Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default'=>'#000',
                'selectors' => [
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-banner-post .wrap-banner-post h1' => 'color: {{VALUE}}'
                ],
            ]
        ); 
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'font_style_intro_desc',
                'label' =>'Style',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .moomoo-banner-post .wrap-banner-post h1',             
                
            ]
        );
        $this->add_responsive_control(
            'title_align',
            [
                'label' => __( 'Alignment', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'moomoo-extensions-elementor' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'moomoo-extensions-elementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'moomoo-extensions-elementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'=>'center',
                'prefix_class' => 'title-align%s-', 
            ]
        );
        $this->end_controls_section();

    }
    protected function get_oldest_cate_parent( $ID_Cate){

        $category = get_category($ID_Cate); 

        if($category->parent != 0){
            return self::get_oldest_cate_parent($category->parent);
        }       
        return $ID_Cate;
        
    }
    protected function render() {

        $setting = $this->get_settings_for_display();
        $mm_image = $setting['mm_image'];

        
        if(is_category()){
             $category_current = get_queried_object();
        }else{
            $category_current = get_the_category()[0];
        }
        
        $ID_cate_current =  $category_current->term_id;
        $ID_cate_oldest_parrent = $this->get_oldest_cate_parent($ID_cate_current);

        /*var_dump($ID_cate_current);
        var_dump($ID_cate_oldest_parrent);*/
        ?>
        <div class="moomoo-elementor-extension">
            <div class="moomoo-banner-post">
               <?php 
                    if (function_exists('z_taxonomy_image'))   
                    $image_cate = z_taxonomy_image_url($ID_cate_oldest_parrent); 
                    $name_oldest_cate_parrent = get_cat_name($ID_cate_oldest_parrent);
                    ?>
                    <div class="wrap-banner-post" style="background:url('<?php echo $image_cate; ?>') center center no-repeat; background-size: cover; display: flex;align-items: center;justify-content: center;flex-direction: column; text-align: center;">
                        <div class="center-box">
                            <a href="<?php echo home_url() ?>">
                            <?php 
                               echo wp_get_attachment_image( $mm_image['id'], 'full');
                             ?>
                             </a>
                             <h1 class="cate-name"  style="margin-top: 20px;"><?php echo $name_oldest_cate_parrent ?></h1>
                        </div>
                        
                    </div>
                    <?

               ?>
            </div><!-- moomoo-banner-post-->
        </div>
        <?php
    }
}