<?php

/**
 * Class: Premium_Twitter_Feed
 * Name: Twitter Feed
 * Slug: premium-twitter-feed
 */

namespace PremiumAddonsPro\Widgets;

use PremiumAddons\Helper_Functions;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Premium_Twitter_Feed extends Widget_Base {
    
    public function get_name() {
        return 'premium-twitter-feed';
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Twitter Feed', 'premium-addons-pro') );
	}
    
    public function get_icon() {
        return 'pa-pro-twitter-feed';
    }
    
    public function get_categories() {
        return [ 'premium-elements' ];
    }
    
    public function get_style_depends() {
        return [
            'premium-addons'
        ];
    }
    
    public function get_script_depends() {
        return [
            'codebird-js',
            'social-dot-js',
            'jquery-socialfeed-js',
            'isotope-js',
            'imagesloaded',
            'jquery-slick',
            'premium-pro-js',
        ];
    }

    public function is_reload_preview_required() {
        return true;
    }
    
    public function get_custom_help_url() {
		return 'https://youtu.be/wsurRDuR6pg';
	}

    // Adding the controls fields for the Twitter Feed
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {
       
        $this->start_controls_section('access_credentials_section',
            [
                'label'             => __('Access Credentials', 'premium-addons-pro')
            ]
        );
        
        $this->add_control('consumer_key',
            [
                'label'             => __('Consumer Key', 'premium-addons-pro'),
                'type'              => Controls_Manager::TEXT,
                'label_block'       => false,
                'default'           => 'wwC72W809xRKd9ySwUzXzjkmS',
                'description'       => '<a href="https://apps.twitter.com/" target="_blank">Get Consumer Key </a>by creating a new app or selecting an existing app ',
            ]
        );
                
        $this->add_control('consumer_secret',
            [
                'label'             => __('Consumer Secret Key', 'premium-addons-pro'),
                'type'              => Controls_Manager::TEXT,
                'label_block'       => false,
                'default'           => 'rn54hBqxjve2CWOtZqwJigT3F5OEvrriK2XAcqoQVohzr2UA8h',
                'description'       => '<a href="https://apps.twitter.com/" target="_blank">Get Consumer Secret Key </a>by creating a new app or selecting an existing app',
                'separator'         => 'after'
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('account_settings_section',
            [
                'label'             => __('Accounts', 'premium-addons-pro')
            ]
        );
    
        $acc_repeater = new Repeater();
        
        $acc_repeater->add_control('account_id',
            [
                'label'             => __( 'Account ID', 'premium-addons-pro' ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'description'       => __('Account ID is prefixed by @', 'premium-addons-pro'),
                'label_block'       => true,
            ]
        );
        
        $this->add_control('account_names',
           [
               'label'              => __( 'Accounts', 'premium-addons-pro' ),
               'type'               => Controls_Manager::REPEATER,
               'default'            => [
                    [
                        'account_id'  => '@leap13themes',
                    ]
                ],
               'fields'             => $acc_repeater->get_controls(),
               'title_field'        => '{{{ account_id }}}',
               'prevent_empty'      => false
           ]
        );
                
        $hash_repeater              = new Repeater();
        
        $hash_repeater->add_control('hashtag',
            [
                'label'             => __( 'Hashtag', 'premium-addons-pro' ),
                'type'              => Controls_Manager::TEXT,
                'description'       => __('Hashtag is prefixed by a #', 'premium-addons-pro'),
                'label_block'       => true,
            ]
        );
        
        $this->add_control('hashtags',
           [
               'label'              => __( 'Hashtags', 'premium-addons-pro' ),
               'type'               => Controls_Manager::REPEATER,
               'fields'             => $hash_repeater->get_controls(),
               'title_field'        => '{{{ hashtag }}}',
               'prevent_empty'      => false
           ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('tweets_layout_settings',
            [
                'label'             => __('Layout','premium-addons-pro'),
            ]
        );
        
        $this->add_control('layout_style',
            [
                'label'             => __('Style', 'premium-addons-pro'),
                'type'              => Controls_Manager::SELECT,
                'description'       => __( 'Choose the layout style for the tweets', 'premium-addons-pro' ),
                'options'           => [
                    'list'      => __('List', 'premium-addons-pro'),
                    'masonry'   => __('Grid', 'premium-addons-pro'),
                ],
                'default'           => 'list',
            ]
        );
        
        $this->add_responsive_control('column_number',
            [
                'label'             => __('Tweets/Row', 'premium-addons-pro'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    '100%'  => __('1 Column', 'premium-addons-pro'),
                    '50%'   => __('2 Columns', 'premium-addons-pro'),
                    '33.33%'=> __('3 Columns', 'premium-addons-pro'),
                    '25%'   => __('4 Columns', 'premium-addons-pro'),
                    '20%'   => __('5 Columns', 'premium-addons-pro'),
                    '16.667%'=> __('6 Columns', 'premium-addons-pro'),
                ],
                'desktop_default'   => '33.33%',
				'tablet_default'    => '50%',
				'mobile_default'    => '100%',
                'render_type'       => 'template',
                'condition'         => [
                    'layout_style' =>  'masonry',
                ],
                'selectors'         => [
                    '{{WRAPPER}} .premium-social-feed-element-wrap' => 'width: {{VALUE}}'
                ],
            ]
        );
        
        $this->add_control('direction',
			[
				'label'             => __( 'Direction', 'premium-addons-pro' ),
				'type'              => Controls_Manager::CHOOSE,
				'options'           => [
					'ltr'    => [
						'title' => __( 'Left to Right', 'premium-addons-pro' ),
						'icon'  => 'fa fa-chevron-circle-right',
					],
					'rtl' => [
						'title' => __( 'Right to Left', 'premium-addons-pro' ),
						'icon'  => 'fa fa-chevron-circle-left',
					],
				],
				'default' => 'ltr',
			]
		);
        
        $this->add_responsive_control('align',
			[
				'label'             => __( 'Content Alignment', 'premium-addons-pro' ),
				'type'              => Controls_Manager::CHOOSE,
				'options'           => [
					'left'      => [
						'title' => __( 'Left', 'premium-addons-pro' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'    => [
						'title' => __( 'Center', 'premium-addons-pro' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'     => [
						'title' => __( 'Right', 'premium-addons-pro' ),
						'icon'  => 'fa fa-align-right',
					],
                    'justify'   => [
                        'title' => __( 'Justify', 'premium-addons-pro' ),
                        'icon'  => 'fa fa-align-justify',
                    ],
				],
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-text, {{WRAPPER}} .premium-feed-element-read-more' => 'text-align: {{VALUE}}',
                ],
				'default' => 'left',
			]
		);
            
        $this->end_controls_section();
        
        $this->start_controls_section('layout_settings',
            [
                'label'             => __('Advanced Settings','premium-addons-pro'),
            ]
        );
            
        $this->add_control('tweets_number',
            [
                'label'             => __('Tweets/Account','premium-addons-pro'),
                'type'              => Controls_Manager::NUMBER,
                'description'       => __('How many tweets will be shown for each account, default is 2','premium-addons-pro'),
                'default'           => 2,
            ]
        );
        
        $this->add_control('tweets_length',
            [
                'label'             => __('Tweet Length','premium-addons-pro'),
                'type'              => Controls_Manager::NUMBER,
                'default'           => 150,
            ]
        );
                    
        $this->add_control('tweets_media',
            [
                'label'             => __('Show Tweet Media','premium-addons-pro'),
                'type'              => Controls_Manager::SWITCHER,
                'label_on'          => 'Show',
                'label_off'         => 'Hide',
            ]
        );
        
        $this->add_control('tweets_avatar', 
            [
                'label'             => __('Show Avatar','premium-addons-pro'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'block' => __('Show', 'premium-addons-pro'),
                    'none'  => __('Hide', 'premium-addons-pro'),
                ],
                'default'           => 'block',
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-author-img'   => 'display: {{VALUE}}'
                ]
            ]
        );
        
        $this->add_control('tweets_date', 
            [
                'label'             => __('Show Date','premium-addons-pro'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'block' => __('Show', 'premium-addons-pro'),
                    'none'  => __('Hide', 'premium-addons-pro'),
                ],
                'default'           => 'block',
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-date'   => 'display: {{VALUE}}'
                ]
            ]
        );
        
        $this->add_control('tweets_read', 
            [
                'label'             => __('Show Read More','premium-addons-pro'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'inline-block' => __('Show', 'premium-addons-pro'),
                    'none'         => __('Hide', 'premium-addons-pro'),
                ],
                'default'           => 'inline-block',
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-read-more'   => 'display: {{VALUE}}'
                ]
            ]
        );
        
        $this->add_control('read_text',
            [
                'label'         => __( 'Read More Text', 'premium-addons-pro' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => 'Read More ???',
                'condition'     => [
                    'tweets_read'  => 'inline-block'
                ]
            ]
        );
        
        $this->add_control('tweets_icon',
            [
                'label'             => __('Show Twitter Icon','premium-addons-pro'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'inline-block' => __('Show', 'premium-addons-pro'),
                    'none'  => __('Hide', 'premium-addons-pro'),
                ],
                'default'           => 'inline-block',
                'selectors'         => [
                    '{{WRAPPER}} .premium-social-icon'   => 'display: {{VALUE}}'
                ]
            ]
        );
            
        $this->end_controls_section();
        
        $this->start_controls_section('carousel',
            [
                'label'             => __('Carousel','premium-addons-pro'),
            ]
        );
        
        $this->add_control('feed_carousel',
            [
                'label'         => __('Carousel', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER
            ]
        );
        
        $this->add_control('carousel_play',
            [
                'label'         => __('Auto Play', 'premium-addons-pro'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'feed_carousel'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('carousel_autoplay_speed',
			[
				'label'			=> __( 'Autoplay Speed', 'premium-addons-pro' ),
				'description'	=> __( 'Autoplay Speed means at which time the next slide should come. Set a value in milliseconds (ms)', 'premium-addons-pro' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 5000,
				'condition'		=> [
					'feed_carousel' => 'yes',
                    'carousel_play' => 'yes',
				],
			]
		);
        
        $this->add_responsive_control('carousel_arrows_pos',
            [
                'label'         => __('Arrows Position', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', "em"],
                'range'         => [
                    'px'    => [
                        'min'       => -100, 
                        'max'       => 100,
                    ],
                    'em'    => [
                        'min'       => -10, 
                        'max'       => 10,
                    ],
                ],
                'condition'		=> [
					'feed_carousel' => 'yes'
				],
                'selectors'     => [
                    '{{WRAPPER}} .premium-twitter-feed-wrapper a.carousel-arrow.carousel-next' => 'right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .premium-twitter-feed-wrapper a.carousel-arrow.carousel-prev' => 'left: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('tweet_box_style',
            [
                'label'             => __('Tweet Box','premium-addons-pro'),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->start_controls_tabs( 'tweet_box' );
        
        $this->start_controls_tab('tweet_box_normal',
            [
                'label'             => __('Normal', 'premium-addons-pro'),
            ]
        );
        
        $this->add_control('tweet_box_background', 
            [
                'label'             => __('Background', 'premium-addons-pro'),
                'type'              => Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .premium-social-feed-element' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'              => 'tweet_box_border',
                'selector'          => '{{WRAPPER}} .premium-social-feed-element',
            ]
        );
        
        $this->add_control('tweet_box_border_radius',
            [
                'label'             => __('Border Radius', 'premium-addons-pro'),
                'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px', '%' ,'em'],
                'default'           => [
                    'unit'  => 'px',
                    'size'  => 0,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .premium-social-feed-element' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'tweet_box_shadow',
                'selector'          => '{{WRAPPER}} .premium-social-feed-element',
            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab('tweet_box_hover',
            [
                'label'             => __('Hover', 'premium-addons-pro'),
            ]
        );
        
        $this->add_control('tweet_box_background_hover', 
            [
                'label'             => __('Background', 'premium-addons-pro'),
                'type'              => Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .premium-social-feed-element:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        /*Tweet Box Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'              => 'tweet_box_border_hover',
                'selector'          => '{{WRAPPER}} .premium-social-feed-element:hover',
            ]
        );
    
        $this->add_control('tweet_box_border_radius_hover',
            [
                'label'             => __('Border Radius', 'premium-addons-pro'),
                'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px', '%' ,'em'],
                'default'           => [
                    'unit'      => 'px',
                    'size'      => 0,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .premium-social-feed-element:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'tweet_box_shadow_hover',
                'selector'          => '{{WRAPPER}} .premium-social-feed-element:hover',
            ]
        );
        
        $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->add_responsive_control('tweet_box_margin',
            [
                'label'             => __('Margin', 'premium-addons-pro'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em', '%'],
                'separator'         => 'before',
                'selectors'         => [
                    '{{WRAPPER}} .premium-social-feed-element' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('tweet_box_padding',
            [
                'label'             => __('Padding', 'premium-addons-pro'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em', '%'],
                'selectors'         => [
                    '{{WRAPPER}} .premium-social-feed-element' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('content_style',
            [
                'label'             => __('Content','premium-addons-pro'),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'twitter_feed_content_typography',
                'selector'              => '{{WRAPPER}} .premium-feed-element-text',
            ]
        );

        $this->add_control('content_color', 
            [
                'label'             => __('Color', 'premium-addons-pro'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'      => Scheme_Color::get_type(),
                    'value'     => Scheme_Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control('links_color', 
            [
                'label'         => __('Links Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-feed-element-text a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control('links_hover_color', 
            [
                'label'         => __('Links Hover Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .premium-feed-element-text a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_responsive_control('twitter_feed_content_margin',
            [
                'label'             => __('Margin', 'premium-addons-pro'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em', '%'],
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_control('twitter_feed_readmore_heading',
            [
                'label'             => __('Read More', 'premium-addons-pro'),
                'type'              => Controls_Manager::HEADING,
                'condition'         => [
                    'tweets_read'  => 'inline-block'
                ],
            ]
        );
        
        $this->add_control('read_more_color', 
            [
                'label'             => __('Color', 'premium-addons-pro'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-read-more' => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'tweets_read'  => 'inline-block'
                ],
            ]
        );

        $this->add_control('read_more_color_hover', 
            [
                'label'             => __('Hover Color', 'premium-addons-pro'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-read-more:hover' => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'tweets_read'  => 'inline-block'
                ],
            ]
        );

        $this->add_control('read_more_background_color', 
            [
                'label'             => __('Background Color', 'premium-addons-pro'),
                'type'              => Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-read-more' => 'background-color: {{VALUE}}',
                ],
                'condition'         => [
                    'tweets_read'  => 'inline-block'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'twitter_feed_read_more_typography',
                'selector'      => '{{WRAPPER}} .premium-feed-element-read-more',
                'condition'     => [
                    'tweets_read'  => 'inline-block'
                ],
            ]
        );

        $this->add_responsive_control('read_more_margin',
            [
                'label'         => __('Margin', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-feed-read-more-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'     => [
                    'tweets_read'  => 'inline-block'
                ],
            ]
        );

        $this->add_responsive_control('read_more_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-feed-element-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'     => [
                    'tweets_read'  => 'inline-block'
                ],
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section('avatar_style',
            [
                'label'             => __('Avatar','premium-addons-pro'),
                'tab'               => Controls_Manager::TAB_STYLE,
                'condition'         => [
                    'tweets_avatar'    => 'block'
                ]
            ]
        );
        
        $this->add_responsive_control('avatar_size',
                [
                    'label'         => __('Size', 'premium-addons-pro'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px',"em", '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .premium-social-feed-element .media-object ' => 'width: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'avatar_border',
                    'selector'      => '{{WRAPPER}} .premium-feed-element-author-img img',
                ]
                );
        
        $this->add_control('avatar_radius',
                [
                    'label'         => __('Border Radius', 'premium-addons-pro'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px',"em", '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .premium-feed-element-author-img img' => 'border-radius: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );
                
        $this->add_responsive_control('avatar_margin',
                [
                    'label'         => __('Margin', 'premium-addons-pro'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .premium-feed-element-author-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_section();
        
        $this->start_controls_section('icon_style',
            [
                'label'             => __('Twitter Icon','premium-addons-pro'),
                'tab'               => Controls_Manager::TAB_STYLE,
                'condition'         => [
                    'tweets_icon'    => 'inline-block'
                ]
            ]
        );
        
        $this->add_control('twitter_icon_color', 
            [
                'label'             => __('Color', 'premium-addons-pro'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .premium-social-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control('twitter_icon_size',
            [
                'label'             => __('Size', 'premium-addons-pro'),
                'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px',"em"],
                'selectors'         => [
                    '{{WRAPPER}} .premium-social-icon' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('icon_margin',
            [
                'label'             => __('Margin', 'premium-addons-pro'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em', '%'],
                'selectors'         => [
                    '{{WRAPPER}} .premium-social-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
       
        $this->end_controls_section();
        
        $this->start_controls_section('title_style',
            [
                'label'             => __('Author','premium-addons-pro'),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control('title_color', 
            [
                'label'             => __('Color', 'premium-addons-pro'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                    ],
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-author a' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control('title_hover_color', 
            [
                'label'             => __('Hover Color', 'premium-addons-pro'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-author:hover a' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'title_typography',
                'selector'          => '{{WRAPPER}} .premium-feed-element-author a',
            ]
        ); 
                
        $this->add_responsive_control('title_margin',
            [
                'label'             => __('Margin', 'premium-addons-pro'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em', '%'],
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-author' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
     
        $this->end_controls_section();
        
        $this->start_controls_section('date_style',
            [
                'label'             => __('Date','premium-addons-pro'),
                'tab'               => Controls_Manager::TAB_STYLE,
                'condition'         => [
                    'tweets_date'  => 'block'
                ]
            ]
        );

        $this->add_control('date_color', 
            [
                'label'             => __('Color', 'premium-addons-pro'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-date a' => 'color: {{VALUE}};',
                ],
                'separator'         => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'date_typography',
                'selector'          => '{{WRAPPER}} .premium-feed-element-date a',
            ]
        ); 
        
        $this->add_responsive_control('date_margin',
            [
                'label'             => __('Margin', 'premium-addons-pro'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em', '%'],
                'selectors'         => [
                    '{{WRAPPER}} .premium-feed-element-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('carousel_style',
            [
                'label'         => __('Carousel', 'premium-addons-pro'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'feed_carousel'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('arrow_color',
            [
                'label'         => __('Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-twitter-feed-wrapper .slick-arrow' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control('arrow_size',
            [
                'label'         => __('Size', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-twitter-feed-wrapper .slick-arrow i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_control('arrow_background',
            [
                'label'         => __('Background Color', 'premium-addons-pro'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-twitter-feed-wrapper .slick-arrow' => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('arrow_border_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-twitter-feed-wrapper .slick-arrow' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control('arrow_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-twitter-feed-wrapper .slick-arrow' => 'padding: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('general_style',
            [
                'label'             => __('Container','premium-addons-pro'),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('container_background', 
            [
                'label'             => __('Background', 'premium-addons-pro'),
                'type'              => Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .premium-twitter-feed-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'              => 'container_box_border',
                'selector'          => '{{WRAPPER}} .premium-twitter-feed-wrapper',
            ]
        );
        
        $this->add_control('container_box_border_radius',
            [
                'label'             => __('Border Radius', 'premium-addons-pro'),
                'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px', '%' ,'em'],
                'selectors'         => [
                    '{{WRAPPER}} .premium-twitter-feed-wrapper' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'container_box_shadow',
                'selector'          => '{{WRAPPER}} .premium-twitter-feed-wrapper',
            ]
        );
            
        $this->add_responsive_control('container_margin',
            [
                'label'             => __('Margin', 'premium-addons-pro'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em', '%'],
                'selectors'         => [
                    '{{WRAPPER}} .premium-twitter-feed-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
                
        $this->add_responsive_control('container_padding',
            [
                'label'             => __('Padding', 'premium-addons-pro'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em', '%'],
                'selectors'         => [
                    '{{WRAPPER}} .premium-twitter-feed-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
      
        $this->end_controls_section();
                
    }
    
    /**
	 * renders the HTML content of the widget
	 * @return void
	 */
    protected function render() {
        
        $settings = $this->get_settings();
        
        $layout_class = $settings['layout_style'] == 'list' ? 'list-layout' : 'grid-layout';
        
        $layout = $settings['layout_style'] == 'list' ? 'list-template.php' : 'grid-template.php';
        
        $direction = $settings['direction'];

        $accounts = array();
        
        foreach ( $settings['account_names'] as $item ) { 
            
            if ( ! empty( $item['account_id'] ) ) {
                
                array_push( $accounts, $item['account_id'] );
                
            }
            
        }
        
        foreach ( $settings['hashtags'] as $item ) {
            
            if ( ! empty( $item['hashtag'] ) ) {
                
                array_push($accounts, $item['hashtag']);
                
            }
            
        }
        
        $limit = ! empty( $settings['tweets_number'] ) ? $settings['tweets_number'] : 2;
        
        $tweet_length = ! empty( $settings['tweets_length'] ) ? $settings['tweets_length'] : 130;
        
        $show_media = ( $settings['tweets_media'] == 'yes') ? true : false;
        
        $carousel = 'yes' === $settings['feed_carousel'] ? true : false; 
        
        if( $carousel ) {
            
            $this->add_render_attribute('twitter', 'data-carousel', $carousel );
            
            $play = 'yes' == $settings['carousel_play'] ? true : false;
            
            $speed = ! empty( $settings['carousel_autoplay_speed'] ) ? $settings['carousel_autoplay_speed'] : 5000;
            
            $this->add_render_attribute('twitter', 'data-play', $play );
            
            $this->add_render_attribute('twitter', 'data-speed', $speed );
            
            $this->add_render_attribute('twitter', 'data-rtl', is_rtl() );
            
        }
        
        $twitter_settings = [
            'accounts'  => $accounts,
            'limit'     => $limit,
            'consKey'   => $settings['consumer_key'],
            'consSec'   => $settings['consumer_secret'],
            'length'    => $tweet_length,
            'showMedia' => $show_media,
            'layout'    => $layout_class,
            'readMore'  => esc_html( $settings['read_text'] ),
            'template'  => plugins_url( '/templates/', __FILE__ ) . $layout,
        ];
        
        $this->add_render_attribute('twitter', 'class', [ 'premium-twitter-feed-wrapper', $direction ] );
        
        $this->add_render_attribute('twitter', 'data-settings', wp_json_encode( $twitter_settings ) );
        
        $this->add_render_attribute('twitter-inner', 'id', 'premium-social-feed-container-' . $this->get_id() );
        
        $this->add_render_attribute('twitter-inner', 'class', [ 'premium-social-feed-container', $layout_class ] );
        
        $feed_number = 1;
        
        if( 'masonry' === $settings['layout_style'] )
            $feed_number = intval ( 100 / substr( $settings['column_number'], 0, strpos( $settings['column_number'], '%') ) );
        
        $this->add_render_attribute('twitter', 'data-col', $feed_number );
        
        if( empty ( $settings['consumer_key'] ) || empty ( $settings['consumer_secret'] ) ) : ?>
            <div class="premium-error-notice">
                <?php echo __('Please fill the required fields: Consumer Key & Consumer Secret','premium-addons-pro'); ?>
            </div>
        <?php else: ?>
            <div <?php echo $this->get_render_attribute_string('twitter'); ?>>
                <div <?php echo $this->get_render_attribute_string('twitter-inner'); ?>></div>
                <div class="premium-loading-feed">
                    <div class="premium-loader"></div>
                </div>
            </div>
        <?php endif;
    }
    
}