<?php

namespace PremiumAddonsPro\Widgets;

use PremiumAddons\Helper_Functions;
use PremiumAddons\Includes;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Premium_Image_Hotspots extends Widget_Base {
    
	protected $templateInstance;

    public function getTemplateInstance() {
        return $this->templateInstance = Includes\premium_Template_Tags::getInstance();
    }

    public function get_name() {
        return 'premium-addon-image-hotspots';
    }

    public function is_reload_preview_required() {
        return true;
    }
    
    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Image Hotspots', 'premium-addons-pro') );
	}

    public function get_style_depends() {
        return [
            'tooltipster'
        ];
    }

    public function get_icon() {
        return 'pa-pro-hot-spot';
    }

    public function get_script_depends() {
        return [
            'lottie-js',
            'anime-js',
            'tooltipster-bundle-js',
            'premium-pro-js'
        ];
    }

    public function get_categories() {
        return [ 'premium-elements' ];
    }
    
    public function get_custom_help_url() {
		return 'https://premiumaddons.com/support/';
	}

    // Adding the controls fields for the premium image hotspots
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

    	/**START Background Image Section  **/
    	$this->start_controls_section('premium_image_hotspots_image_section',
			[
				'label' => __( 'Image', 'premium-addons-pro' ),
			]
		);

		$this->add_control('premium_image_hotspots_image',
			[
				'label' => __( 'Choose Image', 'premium-addons-pro' ),
				'type' => Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
                'label_block'   => true
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'background_image', // Actually its `image_size`.
				'default' => 'full'
			]
		);
        
        $this->add_control('premium_image_hotspots_stretch',
            [
                'label'         => __('Stretch Image', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Stretch image to full container width','premium-addons-pro'),
                'default'       => 'yes'
            ]);
        
        $this->add_responsive_control('premium_image_hotspots_align',
            [
                'label'             => __( 'Alignment', 'premium-addons-pro' ),
                'type'              => Controls_Manager::CHOOSE,
                'options'           => [
                    'left'    => [
                        'title' => __( 'Left', 'premium-addons-pro' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'premium-addons-pro' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'premium-addons-pro' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors'         => [
                    '{{WRAPPER}} .premium-image-hotspots-container' => 'text-align: {{VALUE}}',
                ],
                'default' => 'center',
                'condition'     => [
                    'premium_image_hotspots_stretch!'    => 'yes'
                ]
            ]
        );

        $this->add_control('float_effects',
            [
                'label'         => __('Floating Effects', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );

        $float_conditions = array(
            'float_effects' => 'yes'
        );
        
        $this->add_control('float_translate',
            [
                'label'         => __( 'Translate', 'premium-addons-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'frontend_available' => true,
                'condition'     => $float_conditions
            ]
        );
        
        $this->add_control('float_translatex',
			[
				'label'         => __( 'Translate X', 'premium-addons-pro' ),
				'type'          => Controls_Manager::SLIDER,
				'default' => [
                    'sizes' => [
                        'start' => -5,
                        'end' => 5,
                    ],
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ]
                ],
                'labels' => [
                    __( 'From', 'premium-addons-pro' ),
                    __( 'To', 'premium-addons-pro' ),
                ],
                'scales' => 1,
                'handles' => 'range',
                'condition'     => array_merge( $float_conditions, [
					'float_translate'     => 'yes'
				] )
			]
		);
        
        $this->add_control('float_translatey',
			[
				'label'         => __( 'Translate Y', 'premium-addons-pro' ),
				'type'          => Controls_Manager::SLIDER,
                'default' => [
                    'sizes' => [
                        'start' => -5,
                        'end' => 5,
                    ],
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ]
                ],
                'labels' => [
                    __( 'From', 'premium-addons-pro' ),
                    __( 'To', 'premium-addons-pro' ),
                ],
                'scales'    => 1,
                'handles'   => 'range',
                'condition' => array_merge( $float_conditions, [
					'float_translate'     => 'yes'
				] )
			]
		);
        
        $this->add_control('float_translate_speed',
			[
				'label'         => __( 'Speed', 'premium-addons-pro' ),
				'type'          => Controls_Manager::SLIDER,
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'size' => 1,
                ],
				'condition' => array_merge( $float_conditions, [
					'float_translate'     => 'yes'
				] )
			]
		);
        
        $this->add_control('float_rotate',
            [
                'label'         => __( 'Rotate', 'premium-addons-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'frontend_available' => true,
                'condition'     => $float_conditions
            ]
        );
        
        $this->add_control('float_rotatex',
			[
				'label'         => __( 'Rotate X', 'premium-addons-pro' ),
				'type'          => Controls_Manager::SLIDER,
				'default' => [
                    'sizes' => [
                        'start' => 0,
                        'end' => 45,
                    ],
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => -180,
                        'max' => 180,
                    ]
                ],
                'labels' => [
                    __( 'From', 'premium-addons-pro' ),
                    __( 'To', 'premium-addons-pro' ),
                ],
                'scales' => 1,
                'handles' => 'range',
                'condition'     => array_merge( $float_conditions, [
					'float_rotate'     => 'yes'
				] )
			]
		);
        
        $this->add_control('float_rotatey',
			[
				'label'         => __( 'Rotate Y', 'premium-addons-pro' ),
				'type'          => Controls_Manager::SLIDER,
				'default' => [
                    'sizes' => [
                        'start' => 0,
                        'end' => 45,
                    ],
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => -180,
                        'max' => 180,
                    ]
                ],
                'labels' => [
                    __( 'From', 'premium-addons-pro' ),
                    __( 'To', 'premium-addons-pro' ),
                ],
                'scales' => 1,
                'handles' => 'range',
                'condition'     => array_merge( $float_conditions, [
					'float_rotate'     => 'yes'
				] )
			]
		);
        
        $this->add_control('float_rotatez',
			[
				'label'         => __( 'Rotate Z', 'premium-addons-pro' ),
				'type'          => Controls_Manager::SLIDER,
                'default' => [
                    'sizes' => [
                        'start' => 0,
                        'end' => 45,
                    ],
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => -180,
                        'max' => 180,
                    ]
                ],
                'labels' => [
                    __( 'From', 'premium-addons-pro' ),
                    __( 'To', 'premium-addons-pro' ),
                ],
                'scales'    => 1,
                'handles'   => 'range',
                'condition' => array_merge( $float_conditions, [
					'float_rotate'     => 'yes'
				] )
			]
		);
        
        $this->add_control('float_rotate_speed',
			[
				'label'         => __( 'Speed', 'premium-addons-pro' ),
				'type'          => Controls_Manager::SLIDER,
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'size' => 1,
                ],
				'condition' => array_merge( $float_conditions, [
					'float_rotate'     => 'yes'
				] )
			]
		);
        
        $this->add_control('float_opacity',
            [
                'label'         => __( 'Opacity', 'premium-addons-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'frontend_available' => true,
                'condition'     => $float_conditions
            ]
        );

        $this->add_control('float_opacity_value',
			[
				'label'         => __( 'Value', 'premium-addons-pro' ),
				'type'          => Controls_Manager::SLIDER,
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'size' => 0.5,
                ],
				'condition' => array_merge( $float_conditions, [
					'float_opacity'     => 'yes'
				] )
			]
		);

        $this->add_control('float_opacity_speed',
			[
				'label'         => __( 'Speed', 'premium-addons-pro' ),
				'type'          => Controls_Manager::SLIDER,
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'size' => 1,
                ],
				'condition' => array_merge( $float_conditions, [
					'float_opacity'     => 'yes'
				] )
			]
        );

		$this->end_controls_section();
        
		$this->start_controls_section('premium_image_hotspots_icons_settings',
            [
                'label'         => __('Hotspots', 'premium-addons-pro'),
            ]
        );
        
        $this->add_control('premium_image_hotspots_notice', 
            [
                'raw'               => __('NEW: Now you can position hotspots from the preview area', 'premium-addons-pro'),
                'type'              => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ] 
        );
        
        $this->add_control('premium_image_hotspots_icons_animation',
            [
                'label'         => __('Radar Animation', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );

        $repeater = new Repeater();
        
        $repeater->add_control('premium_image_hotspots_icon_type_switch',
            [
                'label'         => __('Display On', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'font_awesome_icon'     => __('Font Awesome Icon', 'premium-addons-pro'),
                    'custom_image'          => __('Custom Image', 'premium-addons-pro'),
                    'text'                  => __('Text', 'premium-addons-pro'),
                    'animation'             => __('Lottie Animation', 'premium-addons-pro'),
                ],
                'default'       => 'font_awesome_icon',
                'label_block'   => true,
            ]
        );
        
        $repeater->add_control('premium_image_hotspots_font_awesome_icon',
            [
                'label'         => __('Select Icon', 'premium-addons-pro'),
                'type'          => Controls_Manager::ICON,
                'label_block'   => true,
                'default'       => 'fa fa-map-marker',
                'condition'     => [
                    'premium_image_hotspots_icon_type_switch'     => 'font_awesome_icon',
                ]
            ]
        );
        
        $repeater->add_control('premium_image_hotspots_custom_image',
            [
                'label'         => __('Custom Image', 'premium-addons-pro'),
                'type'          => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition'     => [
                    'premium_image_hotspots_icon_type_switch'     => 'custom_image',
                ]
            ]
        );
        
        $repeater->add_control('premium_image_hotspots_text',
            [
                'label'         => __('Text', 'premium-addons-pro'),
                'type'          => Controls_Manager::TEXT,
                'default'       => __('Hi, I\'m a Hotspot', 'premium-addons-pro'),
                'dynamic'       => [ 'active' => true ],
                'condition'     => [
                    'premium_image_hotspots_icon_type_switch'     => 'text',
                ]
            ]
        );

        $repeater->add_control('lottie_url', 
            [
                'label'             => __( 'Animation JSON URL', 'premium-addons-pro' ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'description'       => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
                'label_block'       => true,
                'condition'     => [
                    'premium_image_hotspots_icon_type_switch'     => 'animation',
                ]
            ]
        );

        $repeater->add_control('lottie_loop',
            [
                'label'         => __('Loop','premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default'       => 'true',
                'condition'     => [
                    'premium_image_hotspots_icon_type_switch'     => 'animation',
                ]
            ]
        );

        $repeater->add_control('lottie_reverse',
            [
                'label'         => __('Reverse','premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'     => [
                    'premium_image_hotspots_icon_type_switch'     => 'animation',
                ]
            ]
        );
        
        $repeater->add_responsive_control('preimum_image_hotspots_main_icons_horizontal_position',
            [
                'label'     => __('Horizontal Position', 'premium-addons-pro'),
                'type'      => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%'],
                'range'     => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 200,
                    ],
                ],
                'default'   => [
                    'size'  => 50,
                    'unit'  => '%'
                ],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} {{CURRENT_ITEM}}.premium-image-hotspots-main-icons'    => 'left: {{SIZE}}{{UNIT}}',
                    'body.rtl {{WRAPPER}} {{CURRENT_ITEM}}.premium-image-hotspots-main-icons'    => 'right: {{SIZE}}{{UNIT}}'
                ]
            ]
            );
        
        $repeater->add_responsive_control('preimum_image_hotspots_main_icons_vertical_position',
            [
                'label'     => __('Vertical Position', 'premium-addons-pro'),
                'type'      => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%'],
                'range'     => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 200,
                    ],
                ],
                'default'   => [
                    'size'  => 50,
                    'unit'  => '%'
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.premium-image-hotspots-main-icons'    => 'top: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        
        $repeater->add_control('premium_image_hotspots_icon_color',
			[
				'label'         => __( 'Color', 'premium-addons-pro' ),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
				'selectors'     => [
					'{{WRAPPER}} {{CURRENT_ITEM}} i.premium-image-hotspots-icon, {{WRAPPER}} {{CURRENT_ITEM}} p.premium-image-hotspots-text' => 'color: {{VALUE}};',
				],
                'condition'     => [
                    'premium_image_hotspots_icon_type_switch!' => ['custom_image', 'animation']
                ]
			]
		);
        
        $repeater->add_responsive_control('premium_image_hotspots_icon_size',
	        [
	            'label'         => __('Size', 'premium-addons-pro'),
	            'type'          => Controls_Manager::SLIDER,
	            'size_units'    => ['px', 'em'],
	            'range'     => [
	                'px'    => [
	                    'min'   => 0,
	                    'max'   => 500,
	                ],
	                'em'	=> [
	                    'min'   => 0,
	                    'max'   => 20,
	                ]
	            ],
                'selectors'     => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} i.premium-image-hotspots-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} img.premium-image-hotspots-image-icon, {{WRAPPER}} {{CURRENT_ITEM}} .premium-lottie-animation svg'    => 'width:{{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}'
                ],
                'condition'     => [
                    'premium_image_hotspots_icon_type_switch!' => 'text'
                ]
	    	]
    	);
        
        $repeater->add_control('premium_image_hotspots_icon_backcolor',
			[
				'label' => __( 'Background Color', 'premium-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} i.premium-image-hotspots-icon, {{WRAPPER}} {{CURRENT_ITEM}} p.premium-image-hotspots-text, {{WRAPPER}} {{CURRENT_ITEM}} img.premium-image-hotspots-image-icon, {{WRAPPER}} {{CURRENT_ITEM}} .premium-lottie-animation' => 'background-color: {{VALUE}}',
				]
			]
		);
        
        $repeater->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'premium_image_hotspots_icon_border',
                'selector'      => '{{WRAPPER}} {{CURRENT_ITEM}} i.premium-image-hotspots-icon, {{WRAPPER}} {{CURRENT_ITEM}} p.premium-image-hotspots-text, {{WRAPPER}} {{CURRENT_ITEM}} img.premium-image-hotspots-image-icon, {{WRAPPER}} {{CURRENT_ITEM}} .premium-lottie-animation'
            ]
        );
        
        $repeater->add_control('premium_image_hotspots_icon_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,    
                'size_units'    => ['px', 'em' , '%'],
                'selectors'     => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} i.premium-image-hotspots-icon, {{WRAPPER}} {{CURRENT_ITEM}} p.premium-image-hotspots-text, {{WRAPPER}} {{CURRENT_ITEM}} img.premium-image-hotspots-image-icon, {{WRAPPER}} {{CURRENT_ITEM}} .premium-lottie-animation' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $repeater->add_control('premium_image_hotspots_icon_radar',
			[
				'label' => __( 'Radar Color', 'premium-addons-pro' ),
				'type' => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.premium-image-hotspots-anim::before' => 'background-color: {{VALUE}} !important',
				],
			]
		);
        
        $repeater->add_control('premium_image_hotspots_icon_radar_radius',
            [
                'label'         => __('Radar Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,    
                'size_units'    => ['px', 'em' , '%'],
                'selectors'     => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.premium-image-hotspots-anim::before' => 'border-radius: {{SIZE}}{{UNIT}} !important'
                ]
            ]
        );
        
        $repeater->add_control('premium_image_hotspots_content', 
            [
                'label'         => __('Content to Show', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'text_editor'           => __('Text Editor', 'premium-addons-pro'),
                    'elementor_templates'   => __('Elementor Template', 'premium-addons-pro'),
                ],
                'default'       => 'text_editor'
            ]
        );
        
        $repeater->add_control('premium_image_hotspots_tooltips_texts',
            [
                'type'          => Controls_Manager::WYSIWYG,
                'default'       => __('Hi, I\'m a Tooltip', 'premium-addons-pro'),
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'premium_image_hotspots_content'    => 'text_editor'
                ]
            ]);
        
        $repeater->add_control('premium_image_hotspots_tooltips_temp',
            [
                'label'         => __( 'Elementor Template', 'premium-addons-pro' ),
                'description'   => __( 'Elementor Template is a template which you can choose from Elementor library. Each template will be shown in content', 'premium-addons-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->getTemplateInstance()->get_elementor_page_list(),
                'label_block'   => true,
                'condition'     => [
                   'premium_image_hotspots_content'  => 'elementor_templates',
                ],
            ]
        );
        
        $repeater->add_control('premium_image_hotspots_link_switcher',
            [
                'label'         => __('Link', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Add a custom link or select an existing page link','premium-addons-pro'),
            ]);
        
        $repeater->add_control('premium_image_hotspots_link_type',
            [
                'label'         => __('Link/URL', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'url'   => __('URL', 'premium-addons-pro'),
                    'link'  => __('Existing Page', 'premium-addons-pro'),
                ],
                'default'       => 'url',
                'condition'     => [
                    'premium_image_hotspots_link_switcher'  => 'yes',
                ],
                'label_block'   => true,
            ]);
        
        $repeater->add_control('premium_image_hotspots_existing_page',
            [
                'label'         => __('Existing Page', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT2,
                'description'   => __('Active only when tooltips trigger is set to hover','premium-addons-pro'),
                'options'       => $this->getTemplateInstance()->get_all_post(),
                'multiple'      => false,
                'condition'     => [
                    'premium_image_hotspots_link_switcher'  => 'yes',
                    'premium_image_hotspots_link_type'     => 'link',
                ],
                'label_block'   => true,
            ]);
        
        $repeater->add_control('premium_image_hotspots_url',
            [
                'label'         => __('URL', 'premium-addons-pro'),
                'type'          => Controls_Manager::URL,
                'placeholder'   => 'https://premiumaddons.com/',
                'dynamic'       => [ 'active' => true ],
                'condition'     => [
                    'premium_image_hotspots_link_switcher'  => 'yes',
                    'premium_image_hotspots_link_type'     => 'url',
                ],
                'label_block'   => true
            ]);
        
        $repeater->add_control('premium_image_hotspots_link_text',
            [
                'label'         => __('Link Title', 'premium-addons-pro'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'condition'     => [
                    'premium_image_hotspots_link_switcher' => 'yes',
                ],
                'label_block'   => true
            ]);
        
        $this->add_control('premium_image_hotspots_icons',
            [
                'label'         => __('Hotspots', 'premium-addons-pro'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'title_field'   => 'Hotspot: <# if ( "font_awesome_icon" === premium_image_hotspots_icon_type_switch ) { #> <i class="{{premium_image_hotspots_font_awesome_icon}}" aria-hidden="true"></i><#} else if( "text" === premium_image_hotspots_icon_type_switch ) { #> {{premium_image_hotspots_text}} <# } else if( "custom_image" === premium_image_hotspots_icon_type_switch ) {#> <img class="editor-pa-img" src="{{premium_image_hotspots_custom_image.url}}"><# } else { #> Lottie Animation <# } #>'
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('premium_image_hotspots_tooltips_section',
            [
                'label'         => __('Tooltips', 'premium-addons-pro'),
            ]
        );

        $this->add_control(
			'premium_image_hotspots_trigger_type', 
		    [
		        'label'         => __('Trigger', 'premium-addons-pro'),
		        'type'          => Controls_Manager::SELECT,
		        'options'       => [
		            'click'   => __('Click', 'premium-addons-pro'),
		            'hover'  => __('Hover', 'premium-addons-pro'),
		        ],
		        'default'       => 'hover'
		    ]
        );

        $this->add_control(
			'premium_image_hotspots_arrow', 
		    [
		        'label'         => __('Show Arrow', 'premium-addons-pro'),
		        'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __('Show', 'premium-addons-pro'),
                'label_off'     => __('Hide', 'premium-addons-pro'),
		    ]
        );

        $this->add_control(
        	'premium_image_hotspots_tooltips_position',
	        [
	            'label'         => __('Positon', 'premium-addons-pro'),
	            'type'          => Controls_Manager::SELECT2,
	            'options'       => [
	                'top'   => __('Top', 'premium-addons-pro'),
	                'bottom'=> __('Bottom', 'premium-addons-pro'),
	                'left'  => __('Left', 'premium-addons-pro'),
	                'right' => __('Right', 'premium-addons-pro'),
	            ],
                'description'       => __('Sets the side of the tooltip. The value may one of the following: \'top\', \'bottom\', \'left\', \'right\'. It may also be an array containing one or more of these values. When using an array, the order of values is taken into account as order of fallbacks and the absence of a side disables it','premium-addons-pro'),
                'default'           => ['top','bottom'],
	            'label_block'   => true,
                'multiple'      => true
	        ]
        );
        
        $this->add_control('premium_image_hotspots_tooltips_distance_position',
            [
                'label'             => __('Spacing', 'premium-addons-pro'),
                'type'              => Controls_Manager::NUMBER,
                'title'       => __('The distance between the origin and the tooltip in pixels, default is 6','premium-addons-pro'),
                'default'           => 6,
            ]
            );
        
        $this->add_control('premium_image_hotspots_min_width',
            [
                'label'             => __('Min Width', 'premium-addons-pro'),
                'type'              => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'       => 0,
                        'max'       => 800,
                    ],
                ],
                'description'       => __('Set a minimum width for the tooltip in pixels, default: 0 (auto width)','premium-addons-pro'),
            ]
            );
        
        $this->add_control('premium_image_hotspots_max_width',
            [
                'label'             => __('Max Width', 'premium-addons-pro'),
                'type'              => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'       => 0,
                        'max'       => 800,
                    ],
                ],
                'description'       => __('Set a maximum width for the tooltip in pixels, default: null (no max width)','premium-addons-pro'),
            ]
            );
        
        $this->add_responsive_control('premium_image_hotspots_tooltips_wrapper_height',
            [
                'label'         => __('Height', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em' , '%'],
                'range'         => [
                    'px'    => [
                        'min'       => 0,
                        'max'       => 500,
                    ],
                    'em'    => [
                        'min'       => 0,
                        'max'       => 20,
                    ]
                ],
                'label_block'   => true,
                'selectors'     => [
                    '.tooltipster-box.tooltipster-box-{{ID}}' => 'height: {{SIZE}}{{UNIT}} !important;'
                ]
        	]
        );

        $this->add_control('premium_image_hotspots_anim', 
            [
                'label'         => __('Animation', 'premium-addons-pro'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'fade'  => __('Fade', 'premium-addons-pro'),
                    'grow'  => __('Grow', 'premium-addons-pro'),
                    'swing' => __('Swing', 'premium-addons-pro'),
                    'slide' => __('Slide', 'premium-addons-pro'),
                    'fall'  => __('Fall', 'premium-addons-pro'),
                ],
                'default'       => 'fade',
                'label_block'   => true,
            ]
        );
        
        $this->add_control('premium_image_hotspots_anim_dur',
                [
                    'label'             => __('Animation Duration', 'premium-addons-pro'),
                    'type'              => Controls_Manager::NUMBER,
                    'title'             => __('Set the animation duration in milliseconds, default is 350', 'premium-addons-pro'),
                    'default'           => 350,
                ]
                );
        
        $this->add_control('premium_image_hotspots_delay',
                [
                    'label'             => __('Delay', 'premium-addons-pro'),
                    'type'              => Controls_Manager::NUMBER,
                    'title'              => __('Set the animation delay in milliseconds, default is 10'),
                    'default'           => 10,
                ]
                );
        
        $this->add_control('premium_image_hotspots_hide',
                [
                    'label'         => __('Hide on Mobiles', 'premium-addons-pro'),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => 'Show',
                    'label_off'     => 'Hide',
                    'description'   => __('Hide tooltips on mobile phones', 'premium-addons-pro'),
                ]
                );

        $this->end_controls_section();

        $this->start_controls_section('premium_image_hotspots_image_style_settings',
            [
                'label'         => __('Image', 'premium-addons-pro'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .premium-addons-image-hotspots-ib-img',
			]
		);
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'hover_css_filters',
                'label'     => __('Hover CSS Filter', 'premium-addons-pro'),
				'selector'  => '{{WRAPPER}} .premium-image-hotspots-container:hover .premium-addons-image-hotspots-ib-img'
			]
		);
        
        $this->add_control('blend_mode',
			[
				'label'     => __( 'Blend Mode', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''              => __( 'Normal', 'elementor' ),
					'multiply'      => 'Multiply',
					'screen'        => 'Screen',
					'overlay'       => 'Overlay',
					'darken'        => 'Darken',
					'lighten'       => 'Lighten',
					'color-dodge'   => 'Color Dodge',
					'saturation'    => 'Saturation',
					'color'         => 'Color',
					'luminosity'    => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .premium-addons-image-hotspots-ib-img' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'premium_image_hotspots_image_border',
                'selector'      => '{{WRAPPER}} .premium-image-hotspots-container .premium-addons-image-hotspots-ib-img',
            ]
        );

        $this->add_control('premium_image_hotspots_image_border_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em' , '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-addons-image-hotspots-ib-img' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('premium_image_hotspots_image_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em' ,'%'],
				'selectors'     => [
                  '{{WRAPPER}} .premium-addons-image-hotspots-ib-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]     
        );

        $this->end_controls_section();

        $this->start_controls_section('premium_image_hotspots_Hotspots_style_settings',
            [
                'label'         => __('Hotspots', 'premium-addons-pro'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('premium_image_hotspots_main_icons_active_borders_style_tabs');

        $this->start_controls_tab('premium_image_hotspots_main_icons_style_tab',
            [
                'label'         => __('Icon', 'premium-addons-pro'),
            ]
        );
        
        $this->add_control('premium_image_hotspots_main_icons_color',
			[
				'label' => __( 'Color', 'premium-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
				'selectors' => [
					'{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-icon' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_responsive_control('preimum_image_hotspots_main_icons_size',
	        [
	            'label'         => __('Size', 'premium-addons-pro'),
	            'type'          => Controls_Manager::SLIDER,
	            'size_units'    => ['px', 'em'],
	            'range'     => [
	                'px'    => [
	                    'min'   => 0,
	                    'max'   => 500,
	                ],
	                'em'	=> [
	                    'min'   => 0,
	                    'max'   => 20,
	                ]
	            ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
	    	]
    	);

		$this->add_control('premium_image_hotspots_main_icons_background_color',
			[
				'label' => __( 'Background Color', 'premium-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-icon' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'premium_image_hotspots_main_icons_border',
                    'selector'      => '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-icon'
                ]
                );

        $this->add_control('premium_image_hotspots_main_icons_border_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,    
                'size_units'    => ['px', 'em' , '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-icon' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => __('Shadow', 'premium-addons-pro'),
                    'name'          => 'premium_image_hotspots_main_icons_shadow',
                    'selector'      => '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-icon'
                ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'name'          => 'premium_image_hotspots_main_icons_shadow',
                    'selector'      => '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-icon',
                    'condition'     => [
                        'premium_image_hotspots_icons_animation!' => 'yes'
                    ]
                ]
                );
        
        $this->add_responsive_control('premium_image_hotspots_main_icons_margin',
                [
                    'label'         => __('Margin', 'premium-addons-pro'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->add_responsive_control('premium_image_hotspots_main_icons_padding',
                [
                    'label'         => __('Padding', 'premium-addons-pro'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);

        $this->end_controls_tab();
        
        $this->start_controls_tab('premium_image_hotspots_main_images_style_tab',
            [
                'label'         => __('Image/Lottie', 'premium-addons-pro'),
            ]
        );

        $this->add_responsive_control('preimum_image_hotspots_main_images_size',
	        [
	            'label'         => __('Size', 'premium-addons-pro'),
	            'type'          => Controls_Manager::SLIDER,
	            'size_units'    => ['px', 'em'],
	            'range'     => [
	                'px'    => [
	                    'min'   => 0,
	                    'max'   => 500,
	                ],
	                'em'	=> [
	                    'min'   => 0,
	                    'max'   => 20,
	                ]
	            ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-image-icon, {{WRAPPER}} .premium-lottie-animation svg' => 'width:{{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                ],
	    	]
    	);

		$this->add_control('preimum_image_hotspots_main_images_background',
			[
				'label' => __( 'Background Color', 'premium-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-image-icon, {{WRAPPER}} .premium-lottie-animation svg' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'preimum_image_hotspots_main_images_border',
                'selector'      => '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-image-icon, {{WRAPPER}} .premium-lottie-animation svg'
            ]
        );

        $this->add_control('preimum_image_hotspots_main_images_border_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,    
                'size_units'    => ['px', 'em' , '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-image-icon, {{WRAPPER}} .premium-lottie-animation svg' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'premium_image_hotspots_main_images_shadow',
                'selector'      => '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-image-icon, {{WRAPPER}} .premium-lottie-animation svg',
                'condition'     => [
                    'premium_image_hotspots_icons_animation!' => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control('premium_image_hotspots_main_images_margin',
            [
                'label'         => __('Margin', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-image-icon, {{WRAPPER}} .premium-lottie-animation svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('premium_image_hotspots_main_images_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-image-icon, {{WRAPPER}} .premium-lottie-animation svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('premium_image_hotspots_main_text_style_tab',
            [
                'label'         => __('Text', 'premium-addons-pro'),
            ]
        );

        $this->add_control(
			'premium_image_hotspots_main_text_color',
			[
				'label'         => __( 'Text Color', 'premium-addons-pro' ),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
				'selectors'     => [
					'{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-text' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'premium_image_hotspots_main_text_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-text'
                    ]
                ); 
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'name'          => 'premium_image_hotspots_main_text_shadow',
                    'selector'      => '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-text'
                ]
                );

		$this->add_control(
			'premium_image_hotspots_main_text_background_color',
			[
				'label' => __( 'Background Color', 'premium-addons-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
				'selectors' => [
					'{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-text' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'premium_image_hotspots_main_text_border',
                    'selector'      => '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-text'
                ]
                );

        $this->add_control('premium_image_hotspots_main_text_border_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,    
                'size_units'    => ['px', 'em' , '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-text' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'name'          => 'premium_image_hotspots_main_text_shadow',
                    'selector'      => '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-text',
                    'condition'     => [
                        'premium_image_hotspots_icons_animation!' => 'yes'
                    ]
                ]
                );
        
        $this->add_responsive_control('premium_image_hotspots_main_text_margin',
                [
                    'label'         => __('Margin', 'premium-addons-pro'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->add_responsive_control('premium_image_hotspots_main_text_padding',
                [
                    'label'         => __('Padding', 'premium-addons-pro'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .premium-image-hotspots-main-icons .premium-image-hotspots-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->add_control('premium_image_hotspots_radar_background',
			[
				'label' => __( 'Radar Color', 'premium-addons-pro' ),
				'type' => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'premium_image_hotspots_icons_animation'  => 'yes'
                ],
				'selectors' => [
					'{{WRAPPER}} .premium-image-hotspots-main-icons.premium-image-hotspots-anim::before' => 'background-color: {{VALUE}};',
				],
                'separator' => 'before'
			]
		);
        
        $this->add_control('premium_image_hotspots_radar_border_radius',
            [
                'label'         => __('Radar Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,    
                'size_units'    => ['px', 'em' , '%'],
                'condition' => [
                    'premium_image_hotspots_icons_animation'  => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-image-hotspots-main-icons.premium-image-hotspots-anim::before' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
			'premium_image_hotspots_main_icons_opacity',
			[
				'label'         => __( 'Hotspots Opacity', 'premium-addons-pro' ),
				'type'          => Controls_Manager::SLIDER,
				'range'         => [
					'px'    => [
		                'min' => 0,
		                'max' => 1,
		                'step'=> .1,
		            ]
				],
				'selectors'     => [
		            '{{WRAPPER}} .premium-image-hotspots-main-icons' => 'opacity: {{SIZE}};',
		        ],
                'separator' => 'before'
			]
		);


         $this->add_control('preimum_image_hotspots_main_icons_hover_animation',
	        [
				'label' => __( 'Hover Animation', 'premium-addons-pro' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

        $this->end_controls_section();
        
        $this->start_controls_section('premium_image_hotspots_tooltips_style_settings',
            [
                'label'         => __('Tooltips', 'premium-addons-pro'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('premium_image_hotspots_tooltips_wrapper_color',
            [
                'label'         => __('Text Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.tooltipster-box.tooltipster-box-{{ID}} .premium-image-hotspots-tooltips-text' => 'color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'premium_image_hotspots_tooltips_wrapper_typo',
				'scheme'                => Scheme_Typography::TYPOGRAPHY_1,
                'selector'              => '.tooltipster-box.tooltipster-box-{{ID}} .premium-image-hotspots-tooltips-text'
			]
		);
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'premium_image_hotspots_tooltips_content_text_shadow',
                'selector'      => '.tooltipster-box.tooltipster-box-{{ID}} .premium-image-hotspots-tooltips-text'
            ]
        );
        
        $this->add_control('premium_image_hotspots_tooltips_wrapper_background_color',
            [
                'label'         => __('Background Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.tooltipster-box.tooltipster-box-{{ID}}' => 'background: {{VALUE}};',
                    '.premium-tooltipster-base.tooltipster-top .tooltipster-arrow-{{ID}} .tooltipster-arrow-background' => 'border-top-color: {{VALUE}};',
                    '.premium-tooltipster-base.tooltipster-bottom .tooltipster-arrow-{{ID}} .tooltipster-arrow-background' => 'border-bottom-color: {{VALUE}};',
                    '.premium-tooltipster-base.tooltipster-right .tooltipster-arrow-{{ID}} .tooltipster-arrow-background' => 'border-right-color: {{VALUE}};',
                    '.premium-tooltipster-base.tooltipster-left .tooltipster-arrow-{{ID}} .tooltipster-arrow-background' => 'border-left-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'              => 'premium_image_hotspots_tooltips_wrapper_border',
                    'selector'          => '.tooltipster-box.tooltipster-box-{{ID}}'
                    ]
                );

        $this->add_control('premium_image_hotspots_tooltips_wrapper_border_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em' , '%'],
                'selectors'		=>[
                	'.tooltipster-box.tooltipster-box-{{ID}}'	=>	'border-radius: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'premium_image_hotspots_tooltips_wrapper_box_shadow',
                'selector'      => '.tooltipster-box.tooltipster-box-{{ID}}'
            ]
        );
        
        $this->add_responsive_control('premium_image_hotspots_tooltips_wrapper_margin',
            [
                'label'         => __('Margin', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
				'selectors'     => [
                  '.tooltipster-box.tooltipster-box-{{ID}} .tooltipster-content, .tooltipster-arrow-{{ID}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
		
        $this->start_controls_section('premium_img_hotspots_container_style',
            [
                'label'         => __('Container', 'premium-addons-pro'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('premium_img_hotspots_container_background',
            [
                'label'         => __('Background Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-image-hotspots-container' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'premium_img_hotspots_container_border',
                'selector'      => '{{WRAPPER}} .premium-image-hotspots-container',
            ]
        );

        $this->add_control('premium_img_hotspots_container_border_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-image-hotspots-container' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'premium_img_hotspots_container_box_shadow',
                'selector'      => '{{WRAPPER}} .premium-image-hotspots-container',
            ]
        );

        $this->add_responsive_control('premium_img_hotspots_container_margin',
            [
                'label'         => __('Margin', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-image-hotspots-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]      
        );
        
        $this->add_responsive_control('premium_img_hotspots_container_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-image-hotspots-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]      
        );
        
        $this->end_controls_section();
	}

	protected function render() {
    	
    	$settings = $this->get_settings_for_display();
        
        $id = $this->get_id();

        $trigger = $settings['premium_image_hotspots_trigger_type'];

        $icon_hover = $settings['preimum_image_hotspots_main_icons_hover_animation'];
        
        $animation_class = '';
        if( 'yes' === $settings['premium_image_hotspots_icons_animation'] ) {
            $animation_class = 'premium-image-hotspots-anim';
        }
        
		$image_src = $settings['premium_image_hotspots_image'];
		$image_src_size = Group_Control_Image_Size::get_attachment_image_src( $image_src['id'], 'background_image', $settings );
        if( empty( $image_src_size ) ) { 
            $image_src_size = $image_src['url'];
        } else { 
            $image_src_size = $image_src_size; 
        }
        
        $alt    = Control_Media::get_image_alt( $settings['premium_image_hotspots_image'] );

        $image_hotspots_settings = [
            'anim'      => $settings['premium_image_hotspots_anim'],
            'animDur'   => !empty( $settings['premium_image_hotspots_anim_dur'] ) ? $settings['premium_image_hotspots_anim_dur'] : 350,
            'delay'     => !empty( $settings['premium_image_hotspots_anim_delay'] ) ? $settings['premium_image_hotspots_anim_delay'] : 10,
            'arrow'     => ( $settings['premium_image_hotspots_arrow'] === 'yes' ) ? true : false,
            'distance'  => !empty( $settings['premium_image_hotspots_tooltips_distance_position'] ) ? $settings['premium_image_hotspots_tooltips_distance_position'] : 6,
            'minWidth'  => !empty($settings['premium_image_hotspots_min_width']['size'] ) ? $settings['premium_image_hotspots_min_width']['size'] : 0,
            'maxWidth'  => !empty( $settings['premium_image_hotspots_max_width']['size'] ) ? $settings['premium_image_hotspots_max_width']['size'] : 'null',
            'side'      => !empty( $settings['premium_image_hotspots_tooltips_position'] ) ? $settings['premium_image_hotspots_tooltips_position'] : array('right', 'left'),
            'hideMobiles'=> $settings['premium_image_hotspots_hide'] === "yes" ? true : false,
            'trigger'   => $trigger,
            'id'        => $id
        ];
        
        $this->add_render_attribute( 'container', [
            'id'            => 'premium-image-hotspots-' . $id,
            'class'         => 'premium-image-hotspots-container',
            'data-settings' => wp_json_encode( $image_hotspots_settings )
        ] );
        

        $this->add_render_attribute( 'image', [
            'class' => 'premium-addons-image-hotspots-ib-img',
            'alt'   => $alt,
            'src'   => $image_src_size
        ] );
        
        if ( 'yes' === $settings['premium_image_hotspots_stretch'] ) {
            $this->add_render_attribute( 'image', 'class', 'premium-image-hotspots-stretch' );
        }

        $this->add_render_attribute( 'image_wrap', 'class', 'premium-image-hotspots-img-wrap' );

        if( 'yes' === $settings['float_effects'] ) {

            $this->add_render_attribute( 'image_wrap', 'data-float', 'true' );
                        
            if( 'yes' === $settings['float_translate'] ) {
                
                $this->add_render_attribute('image_wrap', [
                    'data-float-translate'=> 'true',
                    'data-floatx-start' => $settings['float_translatex']['sizes']['start'],
                    'data-floatx-end' => $settings['float_translatex']['sizes']['end'],
                    'data-floaty-start' => $settings['float_translatey']['sizes']['start'],
                    'data-floaty-end' => $settings['float_translatey']['sizes']['end'] ,
                    'data-float-translate-speed' => $settings['float_translate_speed']['size']
                ]);
                
            }
            
            if( 'yes' === $settings['float_rotate'] ) {
                
                $this->add_render_attribute('image_wrap', [
                    'data-float-rotate'=> 'true',
                    'data-rotatex-start' => $settings['float_rotatex']['sizes']['start'],
                    'data-rotatex-start' => $settings['float_rotatex']['sizes']['end'],
                    'data-rotatey-start' => $settings['float_rotatey']['sizes']['start'],
                    'data-rotatey-start' => $settings['float_rotatey']['sizes']['end'],
                    'data-rotatez-start' => $settings['float_rotatez']['sizes']['start'],
                    'data-rotatez-start' => $settings['float_rotatez']['sizes']['end'],
                    'data-float-rotate-speed' => $settings['float_rotate_speed']['size']
                ]);
                
            }

            if( 'yes' === $settings['float_opacity'] ) {
                
                $this->add_render_attribute('image_wrap', [
                    'data-float-opacity' => 'true',
                    'data-float-opacity-value' => $settings['float_opacity_value']['size'],
                    'data-float-opacity-speed' => $settings['float_opacity_speed']['size'] 
                ]);
                
            }

        }
        
    ?>

	<div <?php echo $this->get_render_attribute_string('container'); ?>>
        <div <?php echo $this->get_render_attribute_string('image_wrap'); ?>>
            <img <?php echo $this->get_render_attribute_string('image'); ?>>
        </div>
        
    	<?php foreach ( $settings['premium_image_hotspots_icons'] as $index => $item ) {

            $icon_type = $item['premium_image_hotspots_icon_type_switch'];

            $list_item_key = 'hotspot_item_' . $index;

            $icon_key = 'hotspot_icon_' . $index;

            $link = $item['premium_image_hotspots_link_switcher'];

            $this->add_render_attribute( $list_item_key, [
                'class' => [
                    'premium-image-hotspots-main-icons',
                    'tooltip-wrapper',
                    $animation_class,
                    'elementor-repeater-item-' . $item['_id'],
                    'premium-image-hotspots-main-icons-'. $item['_id']
                ],
                'data-tooltip-content'  => '#tooltip_content'
            ] );

            if( ! empty( $icon_hover ) ) {
                $this->add_render_attribute( $icon_key, 'class', 'elementor-animation-' . $icon_hover );
            }
            

            if( $icon_type === 'font_awesome_icon' ) {
                
                $this->add_render_attribute( $icon_key, [
                    'class' => [
                        'premium-image-hotspots-icon',
                        $item['premium_image_hotspots_font_awesome_icon']
                    ]
                ]);

            } elseif(  $icon_type === 'custom_image' ) {

                $image_icon_alt = Control_Media::get_image_alt( $item['premium_image_hotspots_custom_image'] );

                $this->add_render_attribute( $icon_key, [
                    'class' => 'premium-image-hotspots-image-icon',
                    'alt' => $image_icon_alt,
                    'src' => $item['premium_image_hotspots_custom_image']['url']
                ]);

            } elseif( $icon_type === 'text' ) {

                $this->add_render_attribute( $icon_key,  'class', 'premium-image-hotspots-text' );

            } else {
                
                $this->add_render_attribute( $icon_key, [
                    'class' => [
                        'premium-image-hotspots-lottie',
                        'premium-lottie-animation'
                    ],
                    'data-lottie-url' => $item['lottie_url'],
                    'data-lottie-loop' => $item['lottie_loop'],
                    'data-lottie-reverse' => $item['lottie_reverse']
                ]);

            }

            if ( $link === 'yes' && $trigger === 'hover' ) {
            
                $link_type = $item['premium_image_hotspots_link_type'];
                
                if ( $link_type === 'url') {
                    $link_url = $item['premium_image_hotspots_url']['url'];
                } else {
                    $link_url = get_permalink( $item['premium_image_hotspots_existing_page' ]);
                }
                
                $link_key = 'hotspot_link_' . $index;

                $this->add_render_attribute( $link_key, [
                    'class' => 'premium-image-hotspots-tooltips-link',
                    'href'  => $link_url,
                    'title' => $item['premium_image_hotspots_link_text']
                ]);

                if( ! empty( $item['premium_image_hotspots_url']['is_external'] ) ) {
                    $this->add_render_attribute( $link_key, 'target', '_blank' ); 
                }

                if( ! empty( $item['premium_image_hotspots_url']['nofollow'] ) ) {
                    $this->add_render_attribute( $link_key, 'rel', 'nofollow' ); 
                }

            }
            

		?>
	        <div <?php echo $this->get_render_attribute_string( $list_item_key ); ?>>
                <?php if ( $link === 'yes' && $trigger === 'hover' ) : ?>
                    <a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
                <?php endif; ?>

                <?php if ( $icon_type === 'font_awesome_icon') : ?>
                    <i <?php echo $this->get_render_attribute_string( $icon_key ); ?>></i>
                <?php elseif ( $icon_type === 'custom_image') : ?>
                    <div class="pica">
                        <img <?php echo $this->get_render_attribute_string( $icon_key ); ?>>
                    </div>
                <?php elseif ( $icon_type === 'text') : ?>
                    <p <?php echo $this->get_render_attribute_string( $icon_key ); ?>>
                        <?php echo $item['premium_image_hotspots_text']; ?>
                    </p>
                <?php else: ?>
                    <div <?php echo $this->get_render_attribute_string( $icon_key ); ?>></div>
                <?php endif; ?>

                <?php if ( $link === 'yes' && $trigger === 'hover' ) : ?>
                    </a>
                <?php endif; ?>
                
                <div class="premium-image-hotspots-tooltips-wrapper">
                    <div id="tooltip_content" class="premium-image-hotspots-tooltips-text">
                    <?php
                        if( $item['premium_image_hotspots_content'] == 'elementor_templates' ) {
                            $template = $item['premium_image_hotspots_tooltips_temp'];
                            echo $this->getTemplateInstance()->get_template_content( $template );
                        } else {
                            echo $item['premium_image_hotspots_tooltips_texts']; 
                        } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <?php
	}
    
    protected function content_template() {
        ?>
        <#
        
            var listItemKey,
                linkURL,
                trigger,
                animationClass = '',
                id  = view.getID(),
                image = {
                    id: settings.premium_image_hotspots_image.id,
                    url: settings.premium_image_hotspots_image.url,
                    size: settings.background_image_size,
                    dimension: settings.background_image_custom_dimension,
                    model: view.getEditModel()
                },
                hotSpotsSettings = {};
            
            image_url = elementor.imagesManager.getImageUrl( image );
            
            trigger = settings.premium_image_hotspots_trigger_type;

            hotSpotsSettings.anim = settings.premium_image_hotspots_anim;
            hotSpotsSettings.animDur = '' !== settings.premium_image_hotspots_anim_dur ? settings.premium_image_hotspots_anim_dur : 350;
            hotSpotsSettings.delay  = '' !== settings.premium_image_hotspots_anim_delay ? settings.premium_image_hotspots_anim_delay : 10;
            hotSpotsSettings.arrow = 'yes' === settings.premium_image_hotspots_arrow ? true : false;
            hotSpotsSettings.distance = '' !== settings.premium_image_hotspots_tooltips_distance_position ? settings.premium_image_hotspots_tooltips_distance_position : 6;
            hotSpotsSettings.minWidth  = '' !== settings.premium_image_hotspots_min_width.size ? settings.premium_image_hotspots_min_width.size : 0;
            hotSpotsSettings.maxWidth  = '' !== settings.premium_image_hotspots_max_width.size ? settings.premium_image_hotspots_max_width.size : null;
            hotSpotsSettings.side = '' !== settings.premium_image_hotspots_tooltips_position ? settings.premium_image_hotspots_tooltips_position : ['right', 'left'];
            hotSpotsSettings.hideMobiles  = 'yes' === settings.premium_image_hotspots_hide ? true : false;
            hotSpotsSettings.trigger = trigger;
            hotSpotsSettings.id = id;
            
            if( 'yes' === settings.premium_image_hotspots_icons_animation ) {
                animationClass = 'premium-image-hotspots-anim';
            }
        
            var hoverAnimation = settings.preimum_image_hotspots_main_icons_hover_animation;
            
            view.addRenderAttribute( 'container', {
                'id': 'premium-image-hotspots-' + id,
                'class': 'premium-image-hotspots-container',
                'data-settings': JSON.stringify( hotSpotsSettings )
            });

            view.addRenderAttribute( 'tooltip_content', {
                'id': 'tooltip_content',
                'class': 'premium-image-hotspots-tooltips-text'
            });

            view.addRenderAttribute( 'image', {
                'class': 'premium-addons-image-hotspots-ib-img',
                'src': image_url
            });
            
            if ( 'yes' === settings.premium_image_hotspots_stretch ) {
            
                view.addRenderAttribute( 'image', 'class', 'premium-image-hotspots-stretch' );
            
            }

            view.addRenderAttribute( 'image_wrap', 'class', 'premium-image-hotspots-img-wrap' );

            if( 'yes' === settings.float_effects ) {

                view.addRenderAttribute( 'image_wrap', 'data-float', 'true' );
                            
                if( 'yes' === settings.float_translate ) {
                    
                    view.addRenderAttribute('image_wrap', {
                        'data-float-translate': 'true',
                        'data-floatx-start': settings.float_translatex.sizes.start,
                        'data-floatx-end': settings.float_translatex.sizes.end,
                        'data-floaty-start': settings.float_translatey.sizes.start,
                        'data-floaty-end': settings.float_translatey.sizes.end ,
                        'data-float-translate-speed': settings.float_translate_speed.size
                    });
                    
                }
                
                if( 'yes' === settings.float_rotate ) {
                    
                    view.addRenderAttribute('image_wrap', {
                        'data-float-rotate': 'true',
                        'data-rotatex-start': settings.float_rotatex.sizes.start,
                        'data-rotatex-start': settings.float_rotatex.sizes.end,
                        'data-rotatey-start': settings.float_rotatey.sizes.start,
                        'data-rotatey-start': settings.float_rotatey.sizes.end,
                        'data-rotatez-start': settings.float_rotatez.sizes.start,
                        'data-rotatez-start': settings.float_rotatez.sizes.end,
                        'data-float-rotate-speed': settings.float_rotate_speed.size
                    });
                    
                }

                if( 'yes' === settings.float_opacity ) {
                    
                    view.addRenderAttribute('image_wrap', {
                        'data-float-opacity': 'true',
                        'data-float-opacity-value': settings.float_opacity_value.size,
                        'data-float-opacity-speed': settings.float_opacity_speed.size 
                    });
                    
                }

            }

        #>
        
        <div {{{ view.getRenderAttributeString('container') }}}>
            <div {{{ view.getRenderAttributeString('image_wrap') }}}>
                <img {{{ view.getRenderAttributeString('image') }}}>
            </div>
            <#
            _.each( settings.premium_image_hotspots_icons, function( hotspot, index ) {
                

                var iconType = hotspot.premium_image_hotspots_icon_type_switch,
                    iconKey = 'hotspot_icon_' + index,
                    link = hotspot.premium_image_hotspots_link_switcher;

                listItemKey = 'hotspot_item_' + index;
                view.addRenderAttribute( listItemKey, {
                    'class': [
                        animationClass,
                        'premium-image-hotspots-main-icons',
                        'elementor-repeater-item-' + hotspot._id,
                        'tooltip-wrapper',
                        'premium-image-hotspots-main-icons-' + hotspot._id
                    ],
                    'data-tooltip-content': '#tooltip_content'
                });
                
                if( 'elementor_templates' === hotspot.premium_image_hotspots_content && '' !== hotspot.premium_image_hotspots_tooltips_temp ) {
                    view.addRenderAttribute( listItemKey, 'data-template-id', hotspot.premium_image_hotspots_tooltips_temp );
                }

                if( '' !== hoverAnimation ) {
                    view.addRenderAttribute( iconKey, 'class', 'elementor-animation-' + hoverAnimation );
                }

                if( iconType === 'font_awesome_icon' ) {
                
                    view.addRenderAttribute( iconKey, {
                        'class': [
                            'premium-image-hotspots-icon',
                            hotspot.premium_image_hotspots_font_awesome_icon
                        ]
                    });

                } else if(  iconType === 'custom_image' ) {

                    view.addRenderAttribute( iconKey, {
                        'class': 'premium-image-hotspots-image-icon',
                        'src': hotspot.premium_image_hotspots_custom_image.url
                    });

                } else if( iconType === 'text' ) {

                    view.addRenderAttribute( iconKey,  'class', 'premium-image-hotspots-text' );

                } else {
                    
                    view.addRenderAttribute( iconKey, {
                        'class': [
                            'premium-image-hotspots-lottie',
                            'premium-lottie-animation'
                        ],
                        'data-lottie-url': hotspot.lottie_url,
                        'data-lottie-loop': hotspot.lottie_loop,
                        'data-lottie-reverse': hotspot.lottie_reverse
                    });

                }

                if ( link === 'yes' && trigger === 'hover' ) {
                
                    var linkType = hotspot.premium_image_hotspots_link_type;
                    
                    if ( linkType === 'url' ) {
                        linkURL = hotspot.premium_image_hotspots_url.url;
                    } else {
                        linkURL = hotspot.premium_image_hotspots_existing_page;
                    }
                    
                    var linkKey = 'hotspot_link_' + index;

                    view.addRenderAttribute( linkKey, {
                        'class': 'premium-image-hotspots-tooltips-link',
                        'href': linkURL,
                        'title': hotspot.premium_image_hotspots_link_text
                    });
                }
                
            #>
            <div {{{ view.getRenderAttributeString(listItemKey) }}}>
                
                <# if ( link === 'yes' && trigger === 'hover' ) { #>
                    <a {{{ view.getRenderAttributeString(linkKey) }}}>
                <# } #>
                
		    		<# if ( 'font_awesome_icon' === iconType ) { #>
		        	    <i {{{ view.getRenderAttributeString( iconKey ) }}}></i>
		    		<# } else if ( 'custom_image' === iconType ) { #>
	    			    <div class="pica">
						    <img {{{ view.getRenderAttributeString( iconKey ) }}}>
					    </div>
					<# } else if ( 'text' === iconType ) { #>
						<p {{{ view.getRenderAttributeString( iconKey ) }}}>
                            {{{hotspot.premium_image_hotspots_text}}}
                        </p>
		    		<# } else { #>
                        <div {{{ view.getRenderAttributeString( iconKey ) }}}></div>
                    <# } #>
	    		
                
                <# if ( link === 'yes' && trigger === 'hover' ) { #>
                    </a>
                <# } #>

                <div class="premium-image-hotspots-tooltips-wrapper">
		            <div {{{ view.getRenderAttributeString('tooltip_content') }}}>
                        <# if( 'text_editor' === hotspot.premium_image_hotspots_content ) { #>
                                {{{hotspot.premium_image_hotspots_tooltips_texts}}}
                        <# } #>
                    </div>
		        </div>
            </div>
            <# }); #>
        </div>
        
    <?php
    
    }
    
}