<?php

use ElementorPro\Base\Base_Widget;
use Elementor\Core\Schemes\Typography ;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;



class Elementor_Moomoo_Media extends \Elementor\Widget_Base {
    
    public function __construct( $data = [], $args = null ) {
        $this->_widget_name = $this->get_name();
        
        add_action('elementor/frontend/after_enqueue_scripts', array($this, 'ndt_enqueue_scripts'), 10);
        
        parent::__construct( $data, $args );

        
    }
    public function get_name() {
        return 'moomoo-media';
    }
    
    
    public function get_title() {
        return __( 'Moomoo Media', 'moomoo-extensions-elementor' );
    }

    public function get_icon() {
        return 'fab fa-medium';
    }
    
    public function get_categories() {
        return [ 'basic' ];
    }

    public function ndt_enqueue_scripts() {
        wp_enqueue_style('mm-media', MM_EXT_ASSET_URL .'/css/moomoo-media.css', array(), time());
        wp_enqueue_script('mm-media', MM_EXT_ASSET_URL .'/js/moomoo-media.js', array('jquery'), time(), true);
        
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

        $repeater = new \Elementor\Repeater();

         

        $repeater->add_control(
            'mm_photo',
            [
                'label' => __( 'Photo', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::MEDIA
            ]
        );
        $repeater->add_control(
            'mm_intro_description',
            [
                'label' => __( 'Description', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __( 'Item #01', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Description', 'moomoo-extensions-elementor' ),
            ]
        );
        $repeater->add_control(
            'content_dropdown',
            array(
                'label'     => __( 'Content dropdown', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => array(
                    'image'  => __( 'Image', 'moomoo-extensions-elementor' ),
                    'video'  => __( 'Video', 'moomoo-extensions-elementor' ),
                    'pdf'  => __( 'Pdf', 'moomoo-extensions-elementor' ),
                    'wp-editor'  => __( 'Wordpress Editor', 'moomoo-extensions-elementor' )
                ),
                'default'   => 'image',
            )
        );

        $repeater->add_control(
            'mm_file', 
            [
                'label' => __( 'Upload File', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'condition' => array(
                    'content_dropdown' => ['image','pdf']
                ),
            ]
        );

        $repeater->add_control(
            'mm_video_source',
            [
                'label' => __( 'Video Source', 'moomoo-extensions-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => array(
                    'youtube'  => __( 'Youtube', 'moomoo-extensions-elementor' ),
                    'vimeo'  => __( 'Vimeo', 'moomoo-extensions-elementor' ),
                    'self-hosted'  => __( 'Self Hosted', 'moomoo-extensions-elementor' )
                ),
                'default'   => 'youtube',
                'condition' => array(
                    'content_dropdown' => 'video',
                ),
            ]
        );

        $repeater->add_control(
            'mm_video_link',
            [
                'label' => __( 'Link', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter your Video link', 'moomoo-extensions-elementor' ),
                'default' => 'https://www.youtube.com/watch?v=9uOETcuFjbE',                
                'condition' => array(
                    'mm_video_source' => ['youtube','vimeo'],
                    'content_dropdown' =>'video'
                ),
            ]
        );
        $repeater->add_control(
            'mm_self_host', 
            [
                'label' => __( 'Upload Video', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder' => __( 'Choose Video', 'moomoo-extensions-elementor' ),
                'condition' => array(
                    'mm_video_source' => ['self-hosted'],
                    'content_dropdown' =>'video'
                ),
            ]
        );

        /*$repeater->add_control(
            'mm_pdf',
            [
                'label' => __( 'Upload PDF', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'condition' => array(
                    'content_dropdown' => 'pdf',
                ),
            ]
        );*/
        $repeater->add_control(
            'mm_wp_editor',
            [
                'label' => __( 'Description', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __( 'Item #01', 'moomoo-extensions-elementor' ),
                'placeholder' => __( 'Description', 'moomoo-extensions-elementor' ),               
                'condition' => array(
                    'content_dropdown' => 'wp-editor',
                ),
            ]
        );
        $this->add_control(
            'mm_media',
            [
                'label' => __( 'Item', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                       //'mm_name' => __( 'Item #1', 'moomoo-extensions-elementor' ),
                        'mm_intro_description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'moomoo-extensions-elementor' )                        
                       
                    ],
                    [
                        //'mm_name' => __( 'Item #2', 'moomoo-extensions-elementor' ),
                        'mm_intro_description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'moomoo-extensions-elementor' )
                    ],
                ]
            ]
        );
        
        $this->end_controls_section();
    }
    protected function mm_tabbar_style(){
        $this->start_controls_section(
            'tabbar_section',
            [
                'label' => __( 'Tab-Bar Style', 'moomoo-extensions-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        
        $this->add_responsive_control(
            'mm_content_tabbar',
            [
                'label' => __( 'Content Tab-Bar Width', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px','%'],
                'range' => [
                    'px' => [
                        'min' => 320,
                        'max' => 1920,
                        'step' => 50,
                    ]
                ],
                'default' => [
                    'unit' => 'px', 
                    'size' => 1200,
                ],
                'show_label' => true,
                'selectors' => [
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media ul.mm-tabbar' => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media .mm-tabcontent .item-content' => 'width: {{SIZE}}{{UNIT}}'
                    
                ],
            ]
        );
        $this->add_responsive_control(
            'mm_content_tabbar_padding',
            array(
                'label'      => __( 'Content Tab-Bar Padding', 'moomoo-extensions-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media ul.mm-tabbar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'mm_item_tabbar_padding',
            array(
                'label'      => __( 'Item Tab-Bar Padding', 'moomoo-extensions-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media ul.mm-tabbar li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        
        $this->add_control(
            'title_desc',
            [
                'label' => __( 'Intro Description', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_responsive_control(
            'mm_item_tabbar_desc_padding',
            array(
                'label'      => __( 'Padding', 'moomoo-extensions-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media ul.mm-tabbar li .intro-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'description_style',
            [
                'label' => __( 'Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default'=>'#000',
                'selectors' => [
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media .intro-desc, {{WRAPPER}} .moomoo-elementor-extension .moomoo-media .intro-desc p' => 'color: {{VALUE}}'
                ],
            ]
        ); 
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'font_style_intro_desc',
                'label' =>'Style',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media .intro-desc, {{WRAPPER}} .moomoo-elementor-extension .moomoo-media .intro-desc p',             
                
            ]
        );
        $this->add_control(
            'mm_item_tabbar_background',
            array(
                'label'      => __( 'Background Item Hover/Active', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default'=>'#008080',               
                'selectors'  => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media ul.mm-tabbar li:hover .intro-desc, {{WRAPPER}} .moomoo-elementor-extension .moomoo-media ul.mm-tabbar li.active .intro-desc' => 'background: {{VALUE}}',
                ),
            )
        );
        $this->add_control(
            'mm_item_tabbar_color_active',
            array(
                'label'      => __( 'Color Item Hover/Active', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default'=>'#fff',               
                'selectors'  => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media ul.mm-tabbar li:hover .intro-desc , {{WRAPPER}} .moomoo-elementor-extension .moomoo-media ul.mm-tabbar li.active .intro-desc ' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'mm_arrow_tabbar',
            [
                'label' => __( 'Arrow Bottom Size', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 50,
                        'step' => 5,
                    ]
                ],
                'default' => [
                    'unit' => 'px', 
                    'size' => 20,
                ],
                'show_label' => true,
                'selectors' => [
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media ul.mm-tabbar li' => '--size: {{SIZE}}{{UNIT}}'
                ],
            ]
        );
        
         $this->end_controls_section();
    }
    protected function mm_tabcontent_style(){
        $this->start_controls_section(
            'tabcontent_section',
            [
                'label' => __( 'Tab-Content Style', 'moomoo-extensions-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
         $this->add_control(
            'mm_content_tabcontent_background',
            [
                'label' => __( 'Background', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default'=>'#F2F2F2',
                'selectors' => [
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media .mm-tabcontent' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media li'=>' --color: {{VALUE}}',

                ]
            ]
        ); 
        $this->add_responsive_control(
            'mm_content_tabcontent',
            [
                'label' => __( 'Content Tab-Content Width', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px','%'],
                'range' => [
                    '%' => [
                        'min' => 20,
                        'max' => 100,
                        'step' => 10,
                    ]
                ],
                'default' => [
                    'unit' => '%', 
                    'size' => 100,
                ],
                'show_label' => true,
                'selectors' => [
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media .mm-tabcontent' => 'width: {{SIZE}}{{UNIT}}'
                ],
            ]
        );
        $this->add_responsive_control(
            'mm_content_tabcontent_padding',
            array(
                'label'      => __( 'Content Tab-Content Padding', 'moomoo-extensions-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media .mm-tabcontent .item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        
         $this->add_control(
            'mm_content_description_style',
            [
                'label' => __( 'Color', 'moomoo-extensions-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media .tabcontent .item-content.mm-wp-editor, {{WRAPPER}} .moomoo-elementor-extension .moomoo-media .mm-tabcontent .item-content.mm-wp-editor p' => 'color: {{VALUE}}'
                ],
                'condition' => array(
                    'content_dropdown' => 'wp-editor',
                ),
            ]
        ); 
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'font_style_tabcontent',
                'label' =>'Description style',
                'scheme' => Typography::TYPOGRAPHY_1,               
                'selector' => '{{WRAPPER}} .moomoo-elementor-extension .moomoo-media .tabcontent .item-content.mm-wp-editor, {{WRAPPER}} .moomoo-elementor-extension .moomoo-media .tabcontent .item-content.mm-wp-editor p',   
                'condition' => array(
                    'content_dropdown' => 'wp-editor',
                ),          
                
            ]
        );
        $this->end_controls_section();
    }
    public function register_style_section_controls(){

        $this->mm_tabbar_style();
        $this->mm_tabcontent_style();

    }
    protected function render() {
        // 'mm_media','mm_wp_editor', 'mm_video_link','mm_video_source','mm_file',   'content_dropdown','mm_intro_description',mm_photo

        $params             = $this->get_settings_for_display();
        $mm_media           = $params['mm_media'];
      
       
        
        ?>
        <div class="moomoo-elementor-extension">
            <div class="moomoo-media">
                <ul class="mm-tabbar">
                    <?php
                    $int = 1;
                    foreach ($mm_media as $media) {
                        $mm_intro_description  = $media['mm_intro_description'];
                        $mm_photo           = $media['mm_photo'];
                        $active = ( $int  ==1)? 'active' :'';
                        ?>
                        <li data-tab=".tab-<?php echo $int; ?>" class="<?php echo $active ;?>">
                            <div class="photo">
                                <?php echo wp_get_attachment_image( $mm_photo['id'], 'full') ?>
                            </div>
                            <div class="intro-desc">
                                <?php echo $mm_intro_description; ?>
                            </div>
                        </li>
                        <?php
                        $int++;
                    }
                    ?>
                </ul>
                <div class="mm-tabcontent">          
                    <?php

                    $html = '';
                    
                    $int = 1;
                    foreach ($mm_media as $media) {
                          $mm_video_source  = $media['mm_video_source'];
                          $content_dropdown = $media['content_dropdown'];
                          $active = ( $int  ==1)? 'active' :'';

                         
                        ?>
                        <div class="item-content mm-<?php echo $content_dropdown; ?> tab-<?php echo $int; ?> <?php echo $active ;?>">
                        <?php
                       

                        switch ($content_dropdown) {
                            case 'image':
                                $mm_file = $media['mm_file'];
                                $html = wp_get_attachment_image( $mm_file['id'], 'full');
                                break;
                            case 'video':
                                $mm_video_link = $media['mm_video_link']; 
                                 $type_video = array();    
                                 parse_str($mm_video_link, $type_video );
                                if($mm_video_source =='youtube'){
                                    $link_video = 'https://www.youtube.com/embed/'.$type_video['https://www_youtube_com/watch?v'];

                                }else if($mm_video_source =='vimeo') {
                                    $link_video = str_replace('https://vimeo.com', 'https://player.vimeo.com/video', $mm_video_link);
                                }

                                $html = '<div class="videoWrapper"><iframe class="elementor-video-iframe" src="'. $link_video.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
                                
                                
                                break;
                            case 'pdf':
                                $mm_file = $media['mm_file'];
                                $html ='<object data="'.$mm_file['url'].'" type="application/pdf">
                                     <embed src="'.$mm_file['url'].'" type="application/pdf" /> 
                                    </object>';                              
                                break;

                            default:
                                $mm_wp_editor = $media['mm_wp_editor'];
                                $html = $mm_wp_editor;
                                break;
                        }
                        $int++;
                        echo $html;
                        ?>                     
                            
                        </div>
                        <?php
                    }
                    ?>
                    
                    

                </div><!-- mm-tabcontent-->
            </div><!-- moomoo-media-->
        </div>
           
        
        <?php

    }

  

}