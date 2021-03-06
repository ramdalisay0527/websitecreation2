<?php

/**
 * Class: Premium_Flipbox
 * Name: Flip Box
 * Slug: premium-addon-flip-box
 */

namespace PremiumAddonsPro\Widgets;

use PremiumAddons\Helper_Functions;
use PremiumAddons\Includes;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Premium_Flipbox extends Widget_Base {
    
    public function getTemplateInstance() {
		return $this->templateInstance = Includes\premium_Template_Tags::getInstance();
	}
    
    public function get_name() {
        return 'premium-addon-flip-box';
    }
    
    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Flip Box', 'premium-addons-pro') );
	}
    
    public function get_icon() {
        return 'pa-pro-flip-box';
    }

    public function get_categories() {
        return [ 'premium-elements' ];
    }

    public function get_script_depends() {
        return [
            'lottie-js',
            'premium-pro-js'
        ];
    }
    
    public function get_custom_help_url() {
		return 'https://premiumaddons.com/support/';
	}

    // Adding the controls fields for the Flip Box
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() { 
        
        $this->start_controls_section('premium_flip_front_settings',
            [
                'label'         => __('Front', 'premium-addons-pro'),
            ]
        );

        $this->start_controls_tabs('premium_flip_front_tabs');
        
        $this->start_controls_tab('premium_flip_front_content_tab',
            [
                'label'         => __('Content', 'premium-addons-pro'),
            ]
        );
        
        $this->add_control('premium_flip_icon_fa_switcher',
            [
                'label'         => __('Icon', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('premium_flip_icon_selection',
            [
                'label'         => __('Icon Type', 'premium-addons-pro'),
                'description'   => __('Select type for the icon', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'icon',
                'options'       => [
                    'icon'  => __('Font Awesome Icon','premium-addons-pro'),
                    'image' => __('Custom Image','premium-addons-pro'),
                    'animation' => __('Lottie Animation','premium-addons-pro'),
                ],
                'label_block'   =>  true,
                'condition'     => [
                    'premium_flip_icon_fa_switcher' => 'yes',
                ],
            ]
        );
        
        $this->add_control('premium_flip_icon_fa_updated', 
            [
                'label'         => __('Icon', 'premium-addons-pro'),
                'description'   => __( 'Choose an Icon for Front Side', 'premium-addons-pro' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility'=> 'premium_flip_icon_fa',
                'default'       => [
                    'value'         => 'fas fa-star',
                    'library'       => 'fa-solid',
                ],
                'label_block'   => true,
                'condition'     => [
                    'premium_flip_icon_fa_switcher' => 'yes',
                    "premium_flip_icon_selection"   => 'icon'
                ],
            ]
        );
        
        $this->add_control('premium_flip_icon_image',
            [
                'label'         => __('Image', 'premium-addons-pro'),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'	=> Utils::get_placeholder_image_src(),
                    ],
                'description'   => __('Choose the icon image', 'premium-addons-pro' ),
                'label_block'   => true,
                'condition'     => [
                    'premium_flip_icon_fa_switcher' => 'yes',
                    "premium_flip_icon_selection"   => 'image'
                ]
            ]
        );

        $this->add_control('front_lottie_url', 
            [
                'label'             => __( 'Animation JSON URL', 'premium-addons-pro' ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'description'       => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
                'label_block'       => true,
                'condition'		=> [
                	'premium_flip_icon_fa_switcher' => 'yes',
                    "premium_flip_icon_selection"   => 'animation'
            	]
            ]
        );

        $this->add_control('front_lottie_loop',
            [
                'label'         => __('Loop','premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default'       => 'true',
                'condition'		=> [
                    'premium_flip_icon_fa_switcher' => 'yes',
                    "premium_flip_icon_selection"   => 'animation',
                    'front_lottie_url!'   => ''
            	]
            ]
        );

        $this->add_control('front_lottie_reverse',
            [
                'label'         => __('Reverse','premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'		=> [
                    'premium_flip_icon_fa_switcher' => 'yes',
                    "premium_flip_icon_selection"   => 'animation',
                    'front_lottie_url!'   => ''
            	]
            ]
        );

        $this->add_control('premium_flip_icon_size',
            [
                'label'         => __('Icon Size', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px','em','%'],
                'range'         => [
                    'px'    => [
                        'min' => 5,
                        'max' => 200
                    ],
                    'em'    => [
                        'min' => 5,
                        'max' => 30
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .premium-flip-text-wrapper svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important',
                ],
                'condition'     => [
                    'premium_flip_icon_fa_switcher' => 'yes',
                    'premium_flip_icon_selection!'   => 'image'
                ]
            ]
        );
        
        $this->add_control('premium_flip_image_size',
            [
                'label'         => __('Icon Size', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px','em'],
                'default'       => [
                    'size'  => 40,
                ],
                'range'         => [
                    'px'    => [
                        'min' => 5,
                        'max' => 200
                    ],
                ],
                'selectors'         => [
                    '{{WRAPPER}} .premium-flip-front-image' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition'         => [
                    'premium_flip_icon_fa_switcher' => 'yes',
                    'premium_flip_icon_selection'   => 'image'
                ]
            ]
        );
        
        $this->add_control('premium_flip_title_switcher',
            [
                'label'         => __('Title', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );

        $this->add_control('premium_flip_paragraph_header',
            [
                'label'         => __('Title', 'premium-addons-pro'),
                'description'   => __( 'Type a title for the front side', 'premium-addons-pro' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Front Box Title', 'premium-addons-pro'),
                'label_block'   => true,
                'condition'     => [
                    'premium_flip_title_switcher' => 'yes',
                ],
            ]
        );

        $this->add_control('premium_flip_paragraph_header_size',
            [
                'label'         => __('HTML Tag', 'premium-addons-pro'),
                'description'   => __( 'Select the front side title tag', 'premium-addons-pro' ),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h3',
                'options'       => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6' 
                    ],
                'label_block'   =>  true,
                'condition'     => [
                    'premium_flip_title_switcher' => 'yes',
                ],
            ]
        );
        
        $this->add_control('premium_flip_description_switcher',
            [
                'label'         => __('Description', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control('premium_flip_paragraph_text',
            [
                'label'         => __('Description', 'premium-addons-pro'),
                'type'          => Controls_Manager::WYSIWYG,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Your Cool Description', 'premium-addons-pro'),
                'condition'     => [
                    'premium_flip_description_switcher' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control('premium_flip_vertical_align',
            [
                'label'         => __( 'Vertical Position', 'premium-addons-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'flex-start'      => [
                        'title'=> __( 'Top', 'premium-addons-pro' ),
                        'icon' => 'fa fa-long-arrow-up',
                    ],
                    'center'        => [
                        'title'=> __( 'Middle', 'premium-addons-pro' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                    'flex-end'      => [
                        'title'=> __( 'Bottom', 'premium-addons-pro' ),
                        'icon' => 'fa fa-long-arrow-down',
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-content' => 'align-items: {{VALUE}};',
                ],
                'separator'     => 'before',
            ]
        );
        
        $this->add_responsive_control('premium_flip_horizontal_align',
            [
                'label'         => __( 'Horizontal Position', 'premium-addons-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'flex-start'  => [
                        'title'=> __( 'Left', 'premium-addons-pro' ),
                        'icon' => 'fa fa-long-arrow-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'premium-addons-pro' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                    'flex-end'     => [
                        'title'=> __( 'Right', 'premium-addons-pro' ),
                        'icon' => 'fa fa-long-arrow-right',
                    ]
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-content' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_responsive_control('premium_flip_text_align',
            [
                'label'         => __( 'Content Alignment', 'premium-addons-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'  => [
                        'title'=> __( 'Left', 'premium-addons-pro' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'premium-addons-pro' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title'=> __( 'Right', 'premium-addons-pro' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify'   => [
                        'title'=> __( 'Justify', 'premium-addons-pro' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('premium_flip_front_background_tab',
            [
                'label'         => __('Background', 'premium-addons-pro'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'          => 'premium_flip_front_background_type',
                'types'         => [ 'classic', 'gradient' ],
                'selector'      => '{{WRAPPER}} .premium-flip-front',
            ]
        );
        
        $this->add_control('premium_flip_overlay_selection',
            [
                'label'         => __('Overlay Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-overlay'    => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('premium_flip_back_settings',
            [
                'label'         => __('Back', 'premium-addons-pro'),
            ]
        );

        $this->start_controls_tabs('premium_flip_back_tabs');
        
        $this->start_controls_tab('premium_flip_back_content_tab',
            [
                'label'         => __('Content', 'premium-addons-pro'),
            ]
        );
        
        $this->add_control('premium_flip_back_icon_fa_switcher',
            [
                'label'         => __('Icon', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('premium_flip_back_icon_selection',
            [
                'label'         => __('Icon Type', 'premium-addons-pro'),
                'description'   => __('Select type for the icon', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'icon',
                'options'       => [
                    'icon'  => __('Font Awesome Icon','premium-addons-pro'),
                    'image' => __('Custom Image','premium-addons-pro'),
                    'animation' => __('Lottie Animation','premium-addons-pro'),
                    ],
                'label_block'   =>  true,
                'condition'     => [
                    'premium_flip_back_icon_fa_switcher' => 'yes',
                ],
            ]
        );
        
        $this->add_control('premium_flip_back_icon_fa_updated',
            [
                'label'         => __('Icon', 'premium-addons-pro'),
                'description'   => __( 'Choose an Icon for Back Side', 'premium-addons-pro' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility'=> 'premium_flip_back_icon_fa',
                'default'       => [
                    'value'         => 'fas fa-star',
                    'library'       => 'fa-solid',
                ],
                'label_block'   => true,
                'condition'     => [
                    'premium_flip_back_icon_fa_switcher'    => 'yes',
                    'premium_flip_back_icon_selection'      => 'icon',
                ],
            ]
        );
        
        $this->add_control('premium_flip_back_icon_image',
            [
                'label'         => __('Image', 'premium-addons-pro'),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'	=> Utils::get_placeholder_image_src(),
                ],
                'description'   => __('Choose the icon image', 'premium-addons-pro' ),
                'label_block'   => true,
                'condition'     => [
                    'premium_flip_back_icon_fa_switcher' => 'yes',
                    "premium_flip_back_icon_selection"   => 'image'
                ]
            ]
        );

        $this->add_control('back_lottie_url', 
            [
                'label'             => __( 'Animation JSON URL', 'premium-addons-pro' ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'description'       => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
                'label_block'       => true,
                'condition'		=> [
                	'premium_flip_back_icon_fa_switcher' => 'yes',
                    "premium_flip_back_icon_selection"   => 'animation'
            	]
            ]
        );

        $this->add_control('back_lottie_loop',
            [
                'label'         => __('Loop','premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default'       => 'true',
                'condition'		=> [
                    'premium_flip_back_icon_fa_switcher' => 'yes',
                    "premium_flip_back_icon_selection"   => 'animation',
                    'back_lottie_url!'   => ''
            	]
            ]
        );

        $this->add_control('back_lottie_reverse',
            [
                'label'         => __('Reverse','premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'		=> [
                    'premium_flip_back_icon_fa_switcher' => 'yes',
                    "premium_flip_back_icon_selection"   => 'animation',
                    'back_lottie_url!'   => ''
            	]
            ]
        );

        $this->add_control('premium_flip_back_icon_size',
            [
                'label'         => __('Icon Size', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px','em','%'],
                'range'         => [
                    'px'   => [
                        'min' => 5,
                        'max' => 200
                    ],
                    'em'    => [
                        'min' => 5,
                        'max' => 30
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .premium-flip-back-text-wrapper svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important',
                ],
                'condition'     => [
                    'premium_flip_back_icon_fa_switcher'    => 'yes',
                    'premium_flip_back_icon_selection!'      => 'image'
                ]
            ]
        );
        
        $this->add_control('premium_flip_back_image_size',
            [
                'label'         => __('Icon Size', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px','em'],
                'default'       => [
                    'size'      => 40,
                ],
                'range'         => [
                    'px'    => [
                        'min' => 5,
                        'max' => 200
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-image' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'premium_flip_back_icon_fa_switcher'    => 'yes',
                    'premium_flip_back_icon_selection'   => 'image'
                ]
            ]
        );
        
        $this->add_control('premium_flip_back_title_switcher',
            [
                'label'         => __('Title', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );

        $this->add_control('premium_flip_back_paragraph_header',
            [
                'label'         => __('Title', 'premium-addons-pro'),
                'description'   => __( 'Type a title for the back side', 'premium-addons-pro' ),
                'dynamic'       => [ 'active' => true ],
                'type'          => Controls_Manager::TEXT,
                'default'       => __('Back Box Title', 'premium-addons-pro'),
                'label_block'   => true,
                'condition'     => [
                    'premium_flip_back_title_switcher' => 'yes',
                ],
            ]
        );

        $this->add_control('premium_flip_back_paragraph_header_size',
            [
                'label'         => __('HTML Tag', 'premium-addons-pro'),
                'description'   => __('Select the tag for the title', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h3',
                'options'       => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6'
                    ],
                'label_block'   => true,
                'condition'     => [
                    'premium_flip_back_title_switcher' => 'yes',
                ],
            ]
        );

        $this->add_control('premium_flip_back_description_switcher',
            [
                'label'         => __('Description', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );
        
        $this->add_control('premium_flip_back_paragraph_text',
            [
                'label'         => __('Description', 'premium-addons-pro'),
                'type'          => Controls_Manager::WYSIWYG,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Your Cool Description', 'premium-addons-pro'),
                'label_block'   => true,
                'condition'     => [
                    'premium_flip_back_description_switcher' => 'yes',
                ],
            ]
        );

        $this->add_control('premium_flip_back_link_switcher',
            [
                'label'         => __('Link', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control('premium_flip_back_link_trigger', 
            [
                'label'         => __('Apply on', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'text'  => __('Button Only', 'premium-addons-pro'),
                    'full'  => __('Whole Box', 'premium-addons-pro'),
                ],
                'default'       => 'text',
                'label_block'   => true,
                'condition'		=> [
                    'premium_flip_back_link_switcher'	=> 'yes'
                ]
            ]
        );

        $this->add_control('premium_flip_back_link_text',
            [
                'label'         => __('Text', 'premium-addons-pro'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Click Me','premium-addons-pro'),
                'label_block'   => true,
                'condition'		=> [
                    'premium_flip_back_link_trigger'	=> 'text',
                    'premium_flip_back_link_switcher'	=> 'yes'
                ]
            ]
        );
        
        $this->add_control('premium_flip_back_link_selection', 
            [
                'label'         => __('Link Type', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'url'   => __('URL', 'premium-addons-pro'),
                    'link'  => __('Existing Page', 'premium-addons-pro'),
                ],
                'default'       => 'url',
                'label_block'   => true,
                'condition'		=> [
                    'premium_flip_back_link_switcher'	=> 'yes'
                ]
            ]
        );
        
        $this->add_control('premium_flip_back_link',
            [
                'label'         => __('Link', 'premium-addons-pro'),
                'type'          => Controls_Manager::URL,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'   => '#',
                ],
                'placeholder'   => 'https://premiumaddons.com/',
                'label_block'   => true,
                'separator'     => 'after',
                'condition'     => [
                    'premium_flip_back_link_switcher'	=> 'yes',
                    'premium_flip_back_link_selection' => 'url'
                ]
            ]
        );
        
        $this->add_control('premium_flip_back_existing_link',
            [
                'label'         => __('Existing Page', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->getTemplateInstance()->get_all_post(),
                'condition'     => [
                    'premium_flip_back_link_switcher'	=> 'yes',
                    'premium_flip_back_link_selection'     => 'link',
                ],
                'multiple'      => false,
                'separator'     => 'after',
                'label_block'   => true,
            ]
        );

        $this->add_responsive_control('premium_flip_back_vertical_align',
            [
                'label'         => __( 'Vertical Position', 'premium-addons-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'flex-start'    => [
                        'title'=> __( 'Top', 'premium-addons-pro' ),
                        'icon' => 'fa fa-long-arrow-up',
                    ],
                    'center'        => [
                        'title'=> __( 'Middle', 'premium-addons-pro' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                    'flex-end'      => [
                        'title'=> __( 'Bottom', 'premium-addons-pro' ),
                        'icon' => 'fa fa-long-arrow-down',
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-content' => 'align-items: {{VALUE}};',
                ],
                'separator'     => 'before',
            ]
        );
        
        $this->add_responsive_control('premium_flip_back_horizontal_align',
            [
                'label'         => __( 'Horizontal Position', 'premium-addons-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'flex-start'    => [
                        'title'=> __( 'Top', 'premium-addons-pro' ),
                        'icon' => 'fa fa-long-arrow-left',
                    ],
                    'center'        => [
                        'title'=> __( 'Middle', 'premium-addons-pro' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                    'flex-end'      => [
                        'title'=> __( 'Bottom', 'premium-addons-pro' ),
                        'icon' => 'fa fa-long-arrow-right',
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-content' => 'justify-content: {{VALUE}};',
                ],
                'separator'     => 'before',
            ]
        );
        
        $this->add_responsive_control('premium_flip_back_text_align',
            [
                'label'         => __( 'Content Alignment', 'premium-addons-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title'=> __( 'Left', 'premium-addons-pro' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'premium-addons-pro' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title'=> __( 'Right', 'premium-addons-pro' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify'   => [
                        'title'=> __( 'Justify', 'premium-addons-pro' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('premium_flip_back_background_tab',
            [
                'label'          => __('Background', 'premium-addons-pro'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'          => 'premium_flip_back_background_type',
                'types'         => [ 'classic', 'gradient' ],
                'selector'      => '{{WRAPPER}} .premium-flip-back',
            ]
        );
        
        $this->add_control('premium_flip_back_overlay_selection',
            [
                'label'         => __('Overlay Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-overlay'    => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('premium_flip_control_settings',
            [
                'label'         => __('Additional Settings', 'premium-addons-pro'),
            ]
        );
        
        $this->add_control('premium_flip_style',
            [
                'label'         => __('Effect', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'fade'  => __('Fade', 'premium-addons-pro'),
                    'flip'  => __('Flip', 'premium-addons-pro'),
                    'slide' => __('Slide', 'premium-addons-pro'),
                    'push'  => __('Push', 'premium-addons-pro'),
                    'zoom'  => __('Zoom', 'premium-addons-pro'),
                ],
                'prefix_class'  => 'premium-flip-style-',
                'render_type'   => 'template',
                'default'       => 'flip'
            ]   
        );

        $this->add_control('premium_flip_direction',
            [
                'label'         => __('Direction', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'rl' => __('Right to Left', 'premium-addons-pro'),
                    'lr' => __('Left to Right', 'premium-addons-pro'),
                    'tb' => __('Top to Bottom', 'premium-addons-pro'),
                    'bt' => __('Bottom to Top', 'premium-addons-pro'),
                ],
                'default'       => 'rl',
                'condition'     => [
                    'premium_flip_style!'   => [ 'fade', 'zoom' ]
                ]
            ]   
        );
        
        $this->add_control('premium_flip_text_animation',
            [
                'label'         => __('Hover Text Animation', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'condition'     => [
                    'premium_flip_style'   => 'flip'
                ]
            ]
        );

        $this->add_responsive_control('premium_flip_box_height',
            [
                'label'         => __('Height', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'  => 380,
                ],
                'range'         => [
                    'px'    => [
                        'min' => 155, 
                        'max' => 1500,
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-main-box'    => 'height: {{SIZE}}px;',
                ]
            ]
        );

        $this->add_control('transition_duration',
            [
                'label'			=> __( 'Speed', 'premium-addons-pro' ),
                'type'			=> Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0.1,
                        'max'   => 5,
                        'step'  => 0.1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .premium-flip-front, {{WRAPPER}} .premium-flip-back'   => 'transition-duration: {{SIZE}}s',
                ]
            ]
        );

        $this->start_controls_tabs('premium_flip_box_border_tabs');
        
        $this->start_controls_tab('premium_flip_box_border_normal',
            [
                'label'         => __('Normal', 'premium-addons-pro'),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'premium_flip_border_settings_normal',
                'selector'      => '{{WRAPPER}} .premium-flip-front',
            ]
        );

        $this->add_control('premium_flip_border_radius_normal',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px','em','%'],
                'range'         => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front, {{WRAPPER}}.premium-flip-style-flip .premium-flip-front-overlay'  => 'border-radius: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('premium_flip_box_border_hover',
            [
                'label'         => __('hover', 'premium-addons-pro'),
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'premium_flip_border_settings_hover',
                'selector'      => '{{WRAPPER}} .premium-flip-main-box:hover .premium-flip-back',
            ]
        );

        $this->add_control('premium_flip_border_radius_hover',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px','em','%'],
                'range'         => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back, {{WRAPPER}}.premium-flip-style-flip .premium-flip-back-overlay'  => 'border-radius: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('premium_flip_front_section_title_style',
            [
                'label'         => __('Front', 'premium-addons-pro'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'frontboxshadow',
                'selector'      => '{{WRAPPER}} .premium-flip-front',
            ]
        );

        $this->start_controls_tabs('premium_flip_box_style_tabs');
        
        $this->start_controls_tab('premium_flip_box_icon_style',
            [
                'label'         => __('Icon', 'premium-addons-pro'),
            ]
        );

        $this->add_control('premium_flip_fa_color_selection',
            [
                'label'         => __('Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-icon' => 'color: {{VALUE}};',
                ],
                'condition'     => [
                    'premium_flip_icon_selection'   => 'icon'
                ]
            ]
        );
        
        $this->add_control('premium_flip_fa_color_background_selection',
            [
                'label'         => __('Background Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-icon, {{WRAPPER}} .premium-flip-front-image, {{WRAPPER}} .premium-flip-front-lottie'    => 'background: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'premium_flip_icon_border',
                'selector'      => '{{WRAPPER}} .premium-flip-front-icon,{{WRAPPER}} .premium-flip-front-image, {{WRAPPER}} .premium-flip-front-lottie',
            ]
        );
        
        $this->add_control('premium_flip_icon_border_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px','em','%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-icon, {{WRAPPER}} .premium-flip-front-image, {{WRAPPER}} .premium-flip-front-lottie'  => 'border-radius: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Shadow','premium-addons-pro'),
                'name'          => 'premium_flip_icon_shadow',
                'selector'      => '{{WRAPPER}} .premium-flip-front-icon',
                'condition'     => [
                    'premium_flip_icon_selection'   => 'icon'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'         => __('Shadow','premium-addons-pro'),
                'name'          => 'premium_flip_image_shadow',
                'selector'      => '{{WRAPPER}} .premium-flip-front-image',
                'condition'     => [
                    'premium_flip_icon_selection'   => 'image'
                ]
            ]
        );
        
        $this->add_responsive_control('premium_flip_icon_margin',
            [
                'label'         => __('Margin', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-icon , {{WRAPPER}} .premium-flip-front-image, {{WRAPPER}} .premium-flip-front-lottie' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control('premium_flip_icon_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-icon, {{WRAPPER}} .premium-flip-front-image, {{WRAPPER}} .premium-flip-front-lottie' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('premium_flip_box_title_style',
            [
                'label'         => __('Title', 'premium-addons-pro'),
            ]
        );

        $this->add_control('premium_flip_title_color',
            [
                'label'         => __('Text Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-title' => 'color: {{VALUE}};',
                ],
                'separator'     => 'before',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'premium_flip_front_title_typo',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .premium-flip-front-title',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'premium_flip_title_shadow',
                'selector'      => '{{WRAPPER}} .premium-flip-front-title',
            ]
        );
        
        $this->add_control('premium_flip_title_background_color',
            [
                'label'         => __('Background Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-title'    => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control('premium_flip_title_margin',
            [
                'label'         => __('Margin', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_responsive_control('premium_flip_title_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab('premium_flip_box_description_style',
            [
                'label'         => __('Description', 'premium-addons-pro'),
            ]
        );

        $this->add_control('premium_flip_desc_color',
            [
                'label'         => __('Text Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-description' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'premium_flip_desc_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .premium-flip-front-description',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'premium_flip_description_shadow',
                'selector'      => '{{WRAPPER}} .premium-flip-front-description',
            ]
        );
        
        $this->add_control('premium_flip_description_background_color',
            [
                'label'         => __('Background Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-description'    => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control('premium_flip_desc_margin',
            [
                'label'         => __('Margin', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_responsive_control('premium_flip_desc_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-front-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('back_section_title_style',
            [
                'label'         => __('Back', 'premium-addons-pro'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'backboxshadow',
                'selector'      => '{{WRAPPER}} .premium-flip-back',
            ]
        );

        $this->start_controls_tabs('premium_flip_box_back_style_tabs');
        
        $this->start_controls_tab('premium_flip_box_back_icon_style',
            [
                'label'         => __('Icon', 'premium-addons-pro'),
            ]
        );
        
        $this->add_control('premium_flip_back_fa_color_selection',
            [
                'label'         => __('Icon Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-icon' => 'color: {{VALUE}};',
                ],
                'condition'     => [
                    'premium_flip_back_icon_fa_switcher'    => 'yes',
                    'premium_flip_back_icon_selection'      => 'icon'
                ]
            ]
        );
        
        $this->add_control('premium_flip_back_fa_color_background_selection',
            [
                'label'         => __('Background Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-icon, {{WRAPPER}} .premium-flip-back-image, {{WRAPPER}} .premium-flip-back-lottie'    => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'premium_flip_back_icon_border',
                'selector'      => '{{WRAPPER}} .premium-flip-back-icon, {{WRAPPER}} .premium-flip-back-image, {{WRAPPER}} .premium-flip-back-lottie',
            ]
        );

        $this->add_control('premium_flip_back_icon_border_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px','em','%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-icon, {{WRAPPER}} .premium-flip-back-image, {{WRAPPER}} .premium-flip-back-lottie'  => 'border-radius: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'     => __('Shadow','premium-addons-pro'),
                    'name'      => 'premium_flip_back_icon_shadow',
                    'selector'  => '{{WRAPPER}} .premium-flip-back-icon',
                    'condition' => [
                        'premium_flip_back_icon_selection'   => 'icon'
                    ]
                ]
            );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'         => __('Shadow','premium-addons-pro'),
                'name'          => 'premium_flip_back_image_shadow',
                'selector'      => '{{WRAPPER}} .premium-flip-back-image',
                'condition'     => [
                    'premium_flip_back_icon_selection'   => 'image'
                ]
            ]
        );

        $this->add_responsive_control('premium_flip_back_icon_margin',
            [
                'label'         => __('Margin', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-icon, {{WRAPPER}} .premium-flip-back-image, {{WRAPPER}} .premium-flip-back-lottie' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control('premium_flip_back_icon_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-icon, {{WRAPPER}} .premium-flip-back-image, {{WRAPPER}} .premium-flip-back-lottie' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        
        $this->start_controls_tab('premium_flip_box_back_title_style',
            [
                'label'         => __('Title', 'premium-addons-pro'),
            ]
        );

        $this->add_control('premium_flip_back_title_color',
            [
                'label'         => __('Text Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'premium_flip_back_title_typo',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .premium-flip-back-title',
			]
		);
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'premium_flip_back_title_shadow',
                'selector'      => '{{WRAPPER}} .premium-flip-back-title',
            ]
        );
        
        $this->add_control('premium_flip_back_title_background_color',
            [
                'label'         => __('Background Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-title'    => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control('premium_flip_back_title_margin',
            [
                'label'         => __('Margin', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control('premium_flip_back_title_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        
        $this->start_controls_tab('premium_flip_box_back_description_style',
            [
                'label'         => __('Description', 'premium-addons-pro'),
            ]
        );
        
        $this->add_control('premium_flip_back_desc_color',
            [
                'label'         => __('Text Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-description' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'premium_flip_back_desc_typography',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .premium-flip-back-description',
			]
		);
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'premium_flip_back_description_shadow',
                'selector'      => '{{WRAPPER}} .premium-flip-back-description',
                ]
            );
        
        $this->add_control('premium_flip_back_description_background_color',
            [
                'label'         => __('Background Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-description'    => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control('premium_flip_back_desc_margin',
            [
                'label'         => __('Margin', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}}  {{LEFT}}{{UNIT}};',
                    ]
                ]
            );
        
        $this->add_responsive_control('premium_flip_back_desc_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-back-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}}  {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        
       $this->end_controls_tab();

       $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('premium_flip_box_link_style',
            [
                'label'         => __('Link', 'premium-addons-pro'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'premium_flip_back_link_switcher'    => 'yes',
                    'premium_flip_back_link_trigger'    => 'text'
                ]
            ]
        );
       
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'premium_flip_box_link_typo',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .premium-flip-box-link',
                'condition'     => [
                    'premium_flip_back_link_switcher'   => 'yes',
                    'premium_flip_back_link_trigger'    => 'text'
                ]
            ]
        );
        
        $this->start_controls_tabs('premium_flip_box_link_style_tabs');
        
        $this->start_controls_tab('premium_flip_box_link_style_normal',
            [
                'label'         => __('Normal', 'premium-addons-pro'),
            ]
        );
        
        $this->add_control('premium_flip_box_link_color',
            [
                'label'         => __('Text Color','premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'      => Scheme_Color::get_type(),
                    'value'     => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-box-link' => 'color:{{VALUE}};'
                ],	
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'premium_flip_box_link_shadow',
                'selector'      => '{{WRAPPER}} .premium-flip-box-link',
            ]
        );
        
        $this->add_control('premium_flip_box_link_background',
            [
                'label'         => __('Background Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-box-link'  => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'premium_flip_box_link_border',
                'selector'      => '{{WRAPPER}} .premium-flip-box-link',
            ]
        );
        
        $this->add_control('premium_flip_box_link_border_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-box-link' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('premium_flip_box_link_margin',
            [
                'label'         => __('Margin', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-box-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('premium_flip_box_link_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-box-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('premium_flip_box_link_style_hover',
            [
                'label'         => __('Hover', 'premium-addons-pro'),
            ]
        );
        
        $this->add_control('premium_flip_box_link_hover_color',
            [
                'label'         => __('Text Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-box-link:hover'   => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'premium_flip_box_link_hover_shadow',
                'selector'      => '{{WRAPPER}} .premium-flip-box-link:hover',
            ]
        );
        
        $this->add_control('premium_flip_box_link_hover_background',
            [
                'label'         => __('Background Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-box-link:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'premium_flip_box_link_hover_border',
                'selector'      => '{{WRAPPER}} .premium-flip-box-link:hover',
            ]
        );
        
        $this->add_control('premium_flip_box_link_hover_border_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-box-link:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('premium_flip_box_link_hover_margin',
            [
                'label'         => __('Margin', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-box-link:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('premium_flip_box_link_hover_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-flip-box-link:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();
    }

    /**
	 * renders the HTML content of the widget
	 * @return void
	 */
    protected function render() {
        
        $settings   = $this->get_settings_for_display();
        
        $trigger    = $settings['premium_flip_back_link_trigger'];
        
        if( 'url' == $settings['premium_flip_back_link_selection'] ) {
            
            $button_url = $settings['premium_flip_back_link']['url'];
            
        } else {
            
            $button_url = get_permalink($settings['premium_flip_back_existing_link']);
            
        }
        
        if( 'yes' === $settings['premium_flip_icon_fa_switcher'] ) {
           if( 'icon' === $settings['premium_flip_icon_selection'] ) {
                if ( ! empty ( $settings['premium_flip_icon_fa'] ) ) {
                    $this->add_render_attribute( 'front_icon', 'class', array(
                       'premium-flip-front-icon',
                        $settings['premium_flip_icon_fa']
                    ) );
                    $this->add_render_attribute( 'front_icon', 'aria-hidden', 'true' );
                }
        
                $front_migrated = isset( $settings['__fa4_migrated']['premium_flip_icon_fa_updated'] );
                $front_new = empty( $settings['premium_flip_icon_fa'] ) && Icons_Manager::is_migration_allowed();
               
            } elseif( 'image' === $settings['premium_flip_icon_selection'] ) {
                $this->add_render_attribute('front_image', 'class', 'premium-flip-front-image' );
                $this->add_render_attribute('front_image', 'src', $settings['premium_flip_icon_image']['url'] );
                $this->add_render_attribute('front_image', 'alt', Control_Media::get_image_alt( $settings['premium_flip_icon_image'] ) );
            } else {
                $this->add_render_attribute( 'front_lottie', [
                    'class' => [
                        'premium-flip-front-lottie',
                        'premium-lottie-animation'
                    ],
                    'data-lottie-url' => $settings['front_lottie_url'],
                    'data-lottie-loop' => $settings['front_lottie_loop'],
                    'data-lottie-reverse' => $settings['front_lottie_reverse'],
                ]);
            }
        }
        
        if( 'yes' === $settings['premium_flip_back_icon_fa_switcher'] ) {
           if( 'icon' === $settings['premium_flip_back_icon_selection'] ) {
               if ( ! empty ( $settings['premium_flip_back_icon_fa'] ) ) {
                    $this->add_render_attribute( 'back_icon', 'class', array(
                       'premium-flip-back-icon',
                        $settings['premium_flip_back_icon_fa']
                    ) );
                    $this->add_render_attribute( 'back_icon', 'aria-hidden', 'true' );
                }
        
                $back_migrated = isset( $settings['__fa4_migrated']['premium_flip_back_icon_fa_updated'] );
                $back_new = empty( $settings['premium_flip_back_icon_fa'] ) && Icons_Manager::is_migration_allowed();
            } elseif( 'image' === $settings['premium_flip_back_icon_selection'] ) {
                $this->add_render_attribute('back_image', 'class', 'premium-flip-back-image' );
                $this->add_render_attribute('back_image', 'src', $settings['premium_flip_back_icon_image']['url'] );
                $this->add_render_attribute('back_image', 'alt', Control_Media::get_image_alt( $settings['premium_flip_back_icon_image'] ) );
            } else {
                $this->add_render_attribute( 'back_lottie', [
                    'class' => [
                        'premium-flip-back-lottie',
                        'premium-lottie-animation'
                    ],
                    'data-lottie-url' => $settings['back_lottie_url'],
                    'data-lottie-loop' => $settings['back_lottie_loop'],
                    'data-lottie-reverse' => $settings['back_lottie_reverse'],
                ]);
            }
        }
        
        $this->add_render_attribute('container', 'class', 'premium-flip-main-box' );
        
        if( 'flip' === $settings['premium_flip_style'] ) {
            if( 'yes' === $settings['premium_flip_text_animation'] ) {
                $this->add_render_attribute( 'container', 'data-flip-animation', 'true' );
            }
        }
        
        
    ?>
    
    <div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
        
        <div class="premium-flip-front premium-flip-front<?php echo $settings['premium_flip_direction']; ?>">
            <div class="premium-flip-front-overlay">
                <div class="premium-flip-front-content-container">
                    <div class="premium-flip-front-content">
                        <div class="premium-flip-text-wrapper">
                            <?php if('yes' == $settings['premium_flip_icon_fa_switcher']) : ?>
                                <?php if( 'icon' == $settings['premium_flip_icon_selection'] ) :
                                    if ( $front_new || $front_migrated ) :
                                        Icons_Manager::render_icon( $settings['premium_flip_icon_fa_updated'], [ 'class'=> 'premium-flip-front-icon', 'aria-hidden' => 'true' ] );
                                    else: ?>
                                        <i <?php echo $this->get_render_attribute_string( 'front_icon' ); ?>></i>
                                    <?php endif;
                                elseif( 'image' == $settings['premium_flip_icon_selection'] ) : ?>
                                    <img <?php echo $this->get_render_attribute_string( 'front_image' ); ?>>
                                <?php elseif( 'animation' == $settings['premium_flip_icon_selection'] ): ?>
                                    <div <?php echo $this->get_render_attribute_string( 'front_lottie' ); ?>></div>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if( 'yes' == $settings['premium_flip_title_switcher'] && !empty( $settings['premium_flip_paragraph_header'] ) ) : ?>
                                <<?php echo $settings['premium_flip_paragraph_header_size']; ?> class="premium-flip-front-title">
                                    <?php echo $settings['premium_flip_paragraph_header']; ?>
                                </<?php echo $settings['premium_flip_paragraph_header_size']; ?>>
                            <?php endif; ?>
                                
                            <?php if( 'yes' == $settings['premium_flip_description_switcher'] ) : ?>
                                <div class="premium-flip-front-description">
                                    <?php echo $settings['premium_flip_paragraph_text']; ?>
                                </div> 
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        <div class="premium-flip-back premium-flip-back<?php echo $settings['premium_flip_direction']; ?>">
            <div class="premium-flip-back-overlay">
                <div class="premium-flip-back-content-container">
                    <?php if( 'yes' == $settings['premium_flip_back_link_switcher'] && 'full' == $trigger ) : ?>
                        <a class="premium-flip-box-full-link" <?php if( ! empty( $button_url ) ) : ?> href="<?php echo $button_url; ?>"<?php endif;?><?php if( ! empty( $settings['premium_flip_back_link']['is_external'] ) ) : ?> target="_blank"<?php endif; ?><?php if( !empty( $settings['premium_flip_back_link']['nofollow'] ) ) : ?> rel="nofollow" <?php endif; ?>></a>
                    <?php endif; ?>
                    <div class="premium-flip-back-content">
                        <div class="premium-flip-back-text-wrapper">

                            <?php if('yes' == $settings['premium_flip_back_icon_fa_switcher']) : ?>
                                <?php if( 'icon' == $settings['premium_flip_back_icon_selection'] ) :
                                    if ( $back_new || $back_migrated ) :
                                        Icons_Manager::render_icon( $settings['premium_flip_back_icon_fa_updated'], [ 'class'=> 'premium-flip-back-icon', 'aria-hidden' => 'true' ] );
                                else: ?>
                                    <i <?php echo $this->get_render_attribute_string( 'back_icon' ); ?>></i>
                                <?php endif;
                                elseif( 'image' == $settings['premium_flip_back_icon_selection'] ) : ?>
                                    <img <?php echo $this->get_render_attribute_string( 'back_image' ); ?>>
                                <?php elseif( 'animation' == $settings['premium_flip_back_icon_selection'] ): ?>
                                    <div <?php echo $this->get_render_attribute_string( 'back_lottie' ); ?>></div>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if( 'yes' == $settings['premium_flip_back_title_switcher'] && !empty( $settings['premium_flip_back_paragraph_header'] ) ) : ?>
                                <<?php echo $settings[ 'premium_flip_back_paragraph_header_size']; ?> class="premium-flip-back-title">
                                    <?php echo $settings['premium_flip_back_paragraph_header']; ?>
                                </<?php echo $settings[ 'premium_flip_back_paragraph_header_size']; ?>> 
                            <?php endif; ?>

                            <?php if( $settings['premium_flip_back_description_switcher'] === 'yes' ) : ?>
                                <span class="premium-flip-back-description"><?php  echo $settings['premium_flip_back_paragraph_text']; ?></span>
                            <?php endif; ?>

                            <?php if( $settings['premium_flip_back_link_switcher'] === 'yes' && $trigger === 'text' ) : ?>
                                <a class="premium-flip-box-link text" <?php if( !empty( $button_url ) ) : ?> href="<?php echo $button_url; ?>"<?php endif;?><?php if( !empty( $settings['premium_flip_back_link']['is_external'] ) ) : ?> target="_blank" <?php endif; ?><?php if( !empty( $settings['premium_flip_back_link']['nofollow'] ) ) : ?> rel="nofollow" <?php endif; ?>><?php echo esc_html__( $settings['premium_flip_back_link_text'] ); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
 
    <?php
    }
    
    protected function content_template() {
        ?>
        <#
            var trigger = settings.premium_flip_back_link_trigger,
            
                buttonUrl = 'url' == settings.premium_flip_back_link_selection ? settings.premium_flip_back_link.url : settings.premium_flip_back_existing_link,
                
                backTitleTag = settings.premium_flip_back_paragraph_header_size,
                
                frontTitleTag = settings.premium_flip_paragraph_header_size,
                
                FlipDir = settings.premium_flip_direction;
                
            view.addRenderAttribute('back_side_wrap', 'class', ['premium-flip-back','premium-flip-back' + FlipDir ] );
            
            view.addRenderAttribute('front_side_wrap', 'class', ['premium-flip-front','premium-flip-front' + FlipDir ] );
            
            if( 'yes' === settings.premium_flip_icon_fa_switcher && 'icon' === settings.premium_flip_icon_selection ) {
            
                var frontIconHTML = elementor.helpers.renderIcon( view, settings.premium_flip_icon_fa_updated, { 'class': 'premium-flip-front-icon', 'aria-hidden': true }, 'i' , 'object' ),
                    frontMigrated = elementor.helpers.isIconMigrated( settings, 'premium_flip_icon_fa_updated' );
            
            }

            if( 'yes' === settings.premium_flip_icon_fa_switcher && 'animation' === settings.premium_flip_icon_selection ) {

                view.addRenderAttribute( 'front_lottie', {
                    'class': [
                        'premium-flip-front-lottie',
                        'premium-lottie-animation'
                    ],
                    'data-lottie-url': settings.front_lottie_url,
                    'data-lottie-loop': settings.front_lottie_loop,
                    'data-lottie-reverse': settings.front_lottie_reverse
                });

            }
            
            if( 'yes' === settings.premium_flip_back_icon_fa_switcher && 'icon' === settings.premium_flip_back_icon_selection ) {
            
                var backIconHTML = elementor.helpers.renderIcon( view, settings.premium_flip_back_icon_fa_updated, { 'class': 'premium-flip-back-icon', 'aria-hidden': true }, 'i' , 'object' ),
                    backMigrated = elementor.helpers.isIconMigrated( settings, 'premium_flip_back_icon_fa_updated' );
            
            }

            if( 'yes' === settings.premium_flip_back_icon_fa_switcher && 'animation' === settings.premium_flip_back_icon_selection ) {

                view.addRenderAttribute( 'back_lottie', {
                    'class': [
                        'premium-flip-back-lottie',
                        'premium-lottie-animation'
                    ],
                    'data-lottie-url': settings.back_lottie_url,
                    'data-lottie-loop': settings.back_lottie_loop,
                    'data-lottie-reverse': settings.back_lottie_reverse
                });

            }

            view.addRenderAttribute( 'container', 'class', 'premium-flip-main-box' );
            
            if( 'flip' === settings.premium_flip_style ) {
                if( 'yes' === settings.premium_flip_text_animation ) {
                    view.addRenderAttribute( 'container', 'data-flip-animation', 'true' );
                }
            }
            
        
        #>
        
        <div {{{ view.getRenderAttributeString('container') }}}>
            <div {{{ view.getRenderAttributeString('front_side_wrap') }}}>
                <div class="premium-flip-front-overlay">
                    <div class="premium-flip-front-content-container">
                        <div class="premium-flip-front-content">
                            <div class="premium-flip-text-wrapper">
                                <# if( 'yes' == settings.premium_flip_icon_fa_switcher && 'icon' === settings.premium_flip_icon_selection ) {
                                    if ( frontIconHTML && frontIconHTML.rendered && ( ! settings.premium_flip_icon_fa || frontMigrated ) ) { #>
                                            {{{ frontIconHTML.value }}}
                                    <# } else { #>
                                        <i class="premium-flip-front-icon {{ settings.premium_flip_icon_fa }}" aria-hidden="true"></i>
                                    <# }
                                } else if( 'yes' === settings.premium_flip_icon_fa_switcher && 'image' === settings.premium_flip_icon_selection ) { #>
                                    <img alt="front side img" class="premium-flip-front-image" src="{{ settings.premium_flip_icon_image.url }}">
                                <# } else if( 'yes' === settings.premium_flip_icon_fa_switcher && 'animation' === settings.premium_flip_icon_selection ) { #>
                                    <div {{{ view.getRenderAttributeString('front_lottie') }}}></div>
                                <# } #>
                                
                                <# if( 'yes' === settings.premium_flip_title_switcher && '' != settings.premium_flip_paragraph_header ) { #>
                            
                                <{{{frontTitleTag}}} class="premium-flip-front-title">{{{ settings.premium_flip_paragraph_header }}}</{{{frontTitleTag}}}>
                            
                                <# } #>
                                
                                <# if( 'yes' === settings.premium_flip_description_switcher ) { #>
                                
                                    <div class="premium-flip-front-description">{{{settings.premium_flip_paragraph_text}}}</div> 
                                
                                <# } #>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div {{{ view.getRenderAttributeString('back_side_wrap') }}}>
                <div class="premium-flip-back-overlay">
                    <div class="premium-flip-back-content-container">
                        <# if( 'yes' === settings.premium_flip_back_link_switcher && 'full' === trigger ) { #>
                            <a class="premium-flip-box-full-link" href="{{ buttonUrl }}"></a>
                        <# } #>
                        <div class="premium-flip-back-content">
                            <div class="premium-flip-back-text-wrapper">
                                <# if( 'yes' === settings.premium_flip_back_icon_fa_switcher && 'icon' === settings.premium_flip_back_icon_selection ) {
                                    if ( backIconHTML && backIconHTML.rendered && ( ! settings.premium_flip_back_icon_fa || backMigrated ) ) { #>
                                        {{{ backIconHTML.value }}}
                                <# } else { #>
                                    <i class="premium-flip-back-icon {{ settings.premium_flip_back_icon_fa }}" aria-hidden="true"></i>
                                <# }
                            
                                } else if( 'yes' === settings.premium_flip_back_icon_fa_switcher && 'image' === settings.premium_flip_back_icon_selection ) { #>
                                    <img alt="back side img" class="premium-flip-back-image" src="{{ settings.premium_flip_back_icon_image.url }}">
                                <# } else if( 'yes' === settings.premium_flip_back_icon_fa_switcher && 'animation' === settings.premium_flip_back_icon_selection ) { #>
                                    <div {{{ view.getRenderAttributeString('back_lottie') }}}></div>
                                <# } #>
                                
                                <# if( 'yes' === settings.premium_flip_back_title_switcher && '' != settings.premium_flip_back_paragraph_header ) { #>
                            
                                <{{{backTitleTag}}} class="premium-flip-back-title">{{{ settings.premium_flip_back_paragraph_header }}}</{{{backTitleTag}}}>
                            
                                <# } #>
                                
                                <# if( 'yes' === settings.premium_flip_back_description_switcher ) { #>
                                
                                    <div class="premium-flip-back-description">{{{settings.premium_flip_back_paragraph_text}}}</div> 
                                
                                <# } #>
                                
                                <# if( 'yes' === settings.premium_flip_back_link_switcher && 'text' === trigger ) { #>
                                
                            	<a class="premium-flip-box-link text" href="{{ buttonUrl }}">{{{ settings.premium_flip_back_link_text }}}</a>
                                
                                <# } #>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
    }
}