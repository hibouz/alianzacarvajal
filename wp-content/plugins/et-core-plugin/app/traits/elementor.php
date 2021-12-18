<?php
namespace ETC\App\Traits;

/**
 * Elementor Trait
 *
 * @since      1.4.4
 * @package    ETC
 * @subpackage ETC/Core
 */
trait Elementor {

	/**
	 * Get brands terms.
	 *
	 * @since 2.1.3
	 * @access public
	 */
	public static function get_terms( $taxonomy, $top_level_only = false, $with_empty = true ) {
		$args = array(
			'taxonomy'      => $taxonomy,
			'hide_empty'    =>	false,
			'include' 		=> 'all',
		);
		
		if ( $top_level_only )
			$args['parent'] = 0;

		$the_query = new \WP_Term_Query($args);
		$list = array();
		if ( $with_empty ) 
			$list[] = __( 'Select Option', 'xstore-core' );

		foreach( $the_query->get_terms() as $term ) { 
			$id = $term->term_id;
			$list[$id] = $term->name . ' (id - ' . $id . ')';
		}

		return $list;
	}

	/**
	 * Get products id and title.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public static function get_products_args() {
		$args = array(
			'post_type'   			=> array( 'product_variation', 'product' ),
			'post_status'           => 'publish',
			'ignore_sticky_posts'   => 1,
			'posts_per_page'		=> 200,
		);

		return $args;
	}

	/**
	 * Get products id and title.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public static function get_products() {
		$args = self::get_products_args();

		$the_query       = new \WP_Query( $args );
		$list = array();
		$list[] = __( 'Select Option', 'xstore-core' );

		if ( $the_query->have_posts() ) : 
			while ( $the_query->have_posts() ) : 
				$the_query->the_post();
				$id = get_the_ID();
				$list[$id] = get_the_title() . ' (id - ' . $id . ')';
			endwhile;
			wp_reset_postdata();
		endif;

		return $list;
	}

	/**
	 * Get products id and title.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public static function get_post_pages_args($array) {
		$args = array(
			'post_type'   			=> $array,
			'post_status'           => 'publish',
			'ignore_sticky_posts'   => 1,
			'posts_per_page'		=> 200,
		);

		return $args;
	}

	/**
	 * Get products id and title.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public static function get_post_pages( $array = array('post') ) {
		$args = self::get_post_pages_args($array);

		$the_query       = new \WP_Query( $args );
		$list = array();
		$list[] = __( 'Select Option', 'xstore-core' );

		if ( $the_query->have_posts() ) : 
			while ( $the_query->have_posts() ) : 
				$the_query->the_post();
				$id = get_the_ID();
				$list[$id] = get_the_title() . ' (id - ' . $id . ')';
			endwhile;
			wp_reset_postdata();
		endif;

		return $list;
	}

	/**
	 * Get static block id and title.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public static function get_static_blocks() {
		if ( ! function_exists( 'etheme_get_static_blocks' ) ) {
			return;
		}

		$static_blocks = array();
		$static_blocks[] = "--choose--";
		
		foreach ( etheme_get_static_blocks() as $block ) {
			$static_blocks[$block['value']] = $block['label'];
		}

		return $static_blocks;
	}

	/**
	 * Get instagram_api_data.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public static function instagram_api_data() {
		$api_data = get_option( 'etheme_instagram_api_data' );
		$api_data = json_decode($api_data, true);
		$users    = array( '' => '' );

		if ( is_array($api_data) && count( $api_data ) ) {
			foreach ( $api_data as $key => $value ) {
				$value = json_decode( $value, true );
				if ( isset($value['data']['username']) ) {
					$users[$key] = $value['data']['username'] . ' (old API)';
				} else {
					$users[$key] = $value['username'];
				}
			}
		}

		return $users;
	}

	/**
	 * Get menu params.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public static function menu_params() {
		$menus = wp_get_nav_menus();
		$menu_params = array();
		foreach ( $menus as $menu ) {
			$menu_params[$menu->term_id] = $menu->name;
		}

		return $menu_params;
	}
	
	/**
	 * Create new controls for requested widgets
	 *
	 * @since 2.1.3
	 * @access public
	 */
	public static function get_slider_params( $control ) {

		$control->add_control(
			'hide_buttons',
			[
				'label' 		=> __( 'Hide navigation', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> '',
			]
		);

		$control->add_control(
			'hide_buttons_for',
			[
				'label' 		=> __( 'Hide navigation only for', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'' 			=>  __( 'Both', 'xstore-core' ),
					'mobile'	=>	__( 'Mobile', 'xstore-core' ),
					'desktop'	=>	__( 'Desktop', 'xstore-core' ),
				],
				'condition' => ['hide_buttons' => 'true'],
			]
		);
		
		$control->add_control(
			'navigation_type',
			[
				'label' 		=> esc_html__( 'Navigation Type', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'arrow' 	=>	esc_html__( 'Arrow', 'xstore-core' ),
					'archery' 	=>	esc_html__( 'Archery', 'xstore-core' ),
				],
				'default'	=> 'arrow',
				'condition' => ['hide_buttons' => '']
			]
		);
		
		$control->add_control(
			'navigation_style',
			[
				'label' 		=> esc_html__( 'Navigation Style', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'style-1' 	=>	esc_html__( 'Style 1', 'xstore-core' ),
					'style-2' 	=>	esc_html__( 'Style 2', 'xstore-core' ),
					'style-3' 	=>	esc_html__( 'Style 3', 'xstore-core' ),
					'style-4' 	=>	esc_html__( 'Style 4', 'xstore-core' ),
					'style-5' 	=>	esc_html__( 'Style 5', 'xstore-core' ),
					'style-6' 	=>	esc_html__( 'Style 6', 'xstore-core' ),
				],
				'default'	=> 'style-1',
				'condition' => ['hide_buttons' => '']
			]
		);
		
		$control->add_control(
			'navigation_position',
			[
				'label' 		=> esc_html__( 'Navigation Position', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'middle' 			=>	esc_html__( 'Middle', 'xstore-core' ),
					'middle-inside' 	=>	esc_html__( 'Middle Inside', 'xstore-core' ),
					'bottom' 			=>	esc_html__( 'Bottom', 'xstore-core' ),
				],
				'default'	=> 'middle',
				'condition' => ['hide_buttons' => '']
			]
		);
		
		$control->add_control(
			'navigation_position_style',
			[
				'label' 		=> esc_html__( 'Nav Hover Style', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'arrows-hover' 	=>	esc_html__( 'Display On Hover', 'xstore-core' ),
					'arrows-always' 	=>	esc_html__( 'Always Display', 'xstore-core' ),
				],
				'default'		=> 'arrows-hover',
				'conditions' 	=> [
					'relation' => 'and',
					'terms' 	=> [
						[
							'name' 		=> 'hide_buttons',
							'operator'  => '=',
							'value' 	=> ''
						],
						[
							'relation' => 'or',
							'terms' 	=> [
								[
									'name' 		=> 'navigation_position',
									'operator'  => '=',
									'value' 	=> 'middle'
								],
								[
									'name' 		=> 'navigation_position',
									'operator'  => '=',
									'value' 	=> 'middle-inside'
								],
							]
						]
					]
				]
			]
		);
		
		$control->add_responsive_control(
			'navigation_size',
			[
				'label'		 =>	esc_html__( 'Navigation size', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' 		=> [
						'min' 	=> 10,
						'max' 	=> 120,
						'step' 	=> 1
					],
				],
				'conditions' 	=> [
					'relation' 	=> 'and',
					'terms' 	=> [
						[
							'name' 		=> 'hide_buttons',
							'operator'  => '=',
							'value' 	=> ''
						],
					]
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-entry' => '--arrow-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$control->add_responsive_control(
			'navigation_space',
			[
				'label'		 =>	esc_html__( 'Navigation space', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' 		=> [
						'min' 	=> 0,
						'max' 	=> 200,
						'step' 	=> 1
					],
				],
				'conditions' 	=> [
					'relation' 	=> 'and',
					'terms' 	=> [
						[
							'name' 		=> 'hide_buttons',
							'operator'  => '=',
							'value' 	=> ''
						],
						[
							'name' 		=> 'navigation_position',
							'operator'  => '=',
							'value' 	=> 'bottom'
						],
					]
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-entry' => '--arrow-space: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$control->add_control(
			'pagination_type',
			[
				'label' 		=> __( 'Pagination type', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'hide' 		=>	__( 'Hide', 'xstore-core' ),
					'bullets' 	=>	__( 'Bullets', 'xstore-core' ),
					'lines' 	=>	__( 'Lines', 'xstore-core' ),
				],
				'default' 		=> 'hide',
			]
		);
		
		$control->add_control(
			'hide_fo',
			[
				'label' 		=> __( 'Hide pagination only for', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'' 			=>  __( 'Select option', 'xstore-core' ),
					'mobile'	=>	__( 'Mobile', 'xstore-core' ),
					'desktop'	=>	__( 'Desktop', 'xstore-core' ),
				],
				'condition' => ['pagination_type' => ['bullets', 'lines' ]],
			]
		);

		$control->add_control(
			'slider_autoplay',
			[
				'label' 		=> __( 'Autoplay', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> '',
			]
		);

		$control->add_control(
			'slider_stop_on_hover',
			[
				'label' 		=> __( 'Pause on hover', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> '',
				'condition' 	=> ['slider_autoplay' => 'true'],
			]
		);

		$control->add_control(
			'slider_interval',
			[
				'label' 		=> __( 'Autoplay speed', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::NUMBER,
				'description' 	=> __( 'Interval between slides. In milliseconds.', 'xstore-core' ),
				'return_value' 	=> 'true',
				'default' 		=> 3000,
				'condition' 	=> ['slider_autoplay' => 'true'],
			]
		);
		
		$control->add_control(
			'slider_loop',
			[
				'label' 		=> __( 'Infinite loop', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> 'true',
			]
		);

		$control->add_control(
			'slider_speed',
			[
				'label' 		=> __( 'Transition Speed', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::NUMBER,
				'description' 	=> __( 'Duration of transition between slides. In milliseconds.', 'xstore-core' ),
				'default' 		=> '300',
			]
		);

		$control->add_responsive_control(
			'slides',
			[
				'label' 	=>	__( 'Slider items', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::NUMBER,
				'default' 	=>	4,
				'default_tablet' => 3,
				'default_mobile' => 2,
				// 'min' 	=> 0,
				// 'max' 	=> '',
				// 'step' 	=> 1,
				// 'render_type' => 'template',

				'min' => 0,
				// 'device_args' => [
				// 	Controls_Stack::RESPONSIVE_TABLET => [
				// 		'default' => 3,
				// 	],
				// 	Controls_Stack::RESPONSIVE_MOBILE => [
				// 		'default' => 2,
				// 	],
				// ],
			]
		);
		
		$control->add_control(
			'slider_valign',
			[
				'label' 	=>	__( 'Vertical align', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Top', 'xstore-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'xstore-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __( 'Bottom', 'xstore-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default'	=> 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .swiper-wrapper' => 'align-items: {{VALUE}};',
				],
			]
		);

		// $control->add_control(
		// 	'large',
		// 	[
		// 		'label' 	=>	__( 'Large screens', 'xstore-core' ),
		// 		'type' 		=>	\Elementor\Controls_Manager::NUMBER,
		// 		'default' 	=>	4,
		// 		'min' 	=> 0,
		// 		// 'max' 	=> '',
		// 		'step' 	=> 1,
		// 		// 'render_type' => 'template',
		// 	]
		// );

		// $control->add_control(
		// 	'notebook',
		// 	[
		// 		'label' 	=>	__( 'On notebooks', 'xstore-core' ),
		// 		'type' 		=>	\Elementor\Controls_Manager::NUMBER,
		// 		'default' 	=>	3,
		// 		'min' 	=> 0,
		// 		// 'max' 	=> '',
		// 		'step' 	=> 1,
		// 		// 'render_type' => 'template',
		// 	]
		// );

		// $control->add_control(
		// 	'tablet_land',
		// 	[
		// 		'label' 	=>	__( 'On tablet portrait', 'xstore-core' ),
		// 		'type' 		=>	\Elementor\Controls_Manager::NUMBER,
		// 		'default' 	=>	2,
		// 		'min' 	=> 0,
		// 		// 'max' 	=> '',
		// 		'step' 	=> 1,
		// 		// 'render_type' => 'template',
		// 	]
		// );

		// $control->add_control(
		// 	'mobile',
		// 	[
		// 		'label' 	=>	__( 'On mobile', 'xstore-core' ),
		// 		'type' 		=>	\Elementor\Controls_Manager::NUMBER,
		// 		'default' 	=>	1,
		// 		'min' 	=> 0,
		// 		// 'max' 	=> '',
		// 		'step' 	=> 1,
		// 		// 'render_type' => 'template',
		// 	]
		// );

//		$control->end_controls_section();

//		$control->start_controls_section(
//			'navigation_style',
//			[
//				'label' => __( 'Navigation', 'xstore-core' ),
//				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
//			]
//		);

		$control->add_control(
			'nav_color',
			[
				'label' 	=> __( 'Navigation color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
//				'default' => '#888',
				'selectors' => [
					'{{WRAPPER}} .swiper-nav' => 'color: {{VALUE}};',
				],
			]
		);

		$control->add_control(
			'arrows_bg_color',
			[
				'label' 	=> __( 'Arrows background color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
//				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .swiper-nav' => 'background-color: {{VALUE}};',
				],
			]
		);

//		$control->end_controls_section();

//        $control->start_controls_section(
//            'pagination_style',
//            [
//                'label'                 => __( 'Pagination', 'xstore-core' ),
//                'tab'                   => \Elementor\Controls_Manager::TAB_STYLE,
//            ]
//        );

		$control->start_controls_tabs( 'pagination_color_settings' );

		$control->start_controls_tab(
			'pagination_color_settings_regular',
			[
				'label' => __( 'Regular', 'xstore-core' ),
			]
		);

		$control->add_control(
			'default_color',
			[
				'label' 	=> __( 'Pagination color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
//				'default' 	=> '#e1e1e1',
			]
		);

		$control->end_controls_tab();

		$control->start_controls_tab(
			'pagination_color_settings_active',
			[
				'label' => __( 'Active', 'xstore-core' ),
			]
		);

		$control->add_control(
			'active_color',
			[
				'label' 	=> __( 'Pagination color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
//				'default' 	=> '#222',
			]
		);

		$control->end_controls_tab();

		$control->end_controls_tabs();

//		$control->end_controls_section();

	}	

	/**
	 * Create new controls for requested widgets
	 *
	 * @since 2.1.3
	 * @access public
	 */
	public static function get_slider_params_repeater( $repeater ) {

		$repeater->add_control(
			'navigation_header',
			[
				'label' => __( 'Navigation', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'hide_buttons',
			[
				'label' 		=> __( 'Hide navigation', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> '',
			]
		);

		$repeater->add_control(
			'navigation_style',
			[
				'label' 		=> __( 'Navigation Style', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'arrow-style-1' 	=>	__( 'Arrow Style 1', 'xstore-core' ),
					'arrow-style-2' 	=>	__( 'Arrow Style 2', 'xstore-core' ),
					'arrow-style-3' 	=>	__( 'Arrow Style 3', 'xstore-core' ),
					'arrow-style-4' 	=>	__( 'Arrow Style 4', 'xstore-core' ),
					'arrow-style-5' 	=>	__( 'Arrow Style 5', 'xstore-core' ),
					'arrow-style-6' 	=>	__( 'Arrow Style 6', 'xstore-core' ),
					'archery-style-1' 	=>	__( 'Archery Style 1', 'xstore-core' ),
					'archery-style-2' 	=>	__( 'Archery Style 2', 'xstore-core' ),
					'archery-style-3' 	=>	__( 'Archery Style 3', 'xstore-core' ),
					'archery-style-4' 	=>	__( 'Archery Style 4', 'xstore-core' ),
					'archery-style-5' 	=>	__( 'Archery Style 5', 'xstore-core' ),
					'archery-style-6' 	=>	__( 'Archery Style 6', 'xstore-core' ),
				],
				'condition' => ['hide_buttons' => ''],
				'default'	=> 'arrow-style-1',
			]
		);

		$repeater->add_control(
			'navigation_position',
			[
				'label' 		=> __( 'Navigation Position', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'nav-bar' 			=>	__( 'Nav Bar', 'xstore-core' ),
					'middle' 			=>	__( 'Middle', 'xstore-core' ),
					'middle-inside' 	=>	__( 'Middle Inside', 'xstore-core' ),
				],
				'condition' => ['hide_buttons' => ''],
				'default'	=> 'middle',
			]
		);

		$repeater->add_control(
			'navigation_position_style',
			[
				'label' 		=> __( 'Nav Hover Style', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'arrows-hover' 	=>	__( 'Display on hover', 'xstore-core' ),
					'arrows-always' 	=>	__( 'Always Display', 'xstore-core' ),
				],
				'default'		=> 'arrows-hover',
				'conditions' 	=> [
					'relation' => 'or',
					'terms' 	=> [
						[
							'name' 		=> 'navigation_position',
							'operator'  => '=',
							'value' 	=> 'middle'
						],
						[
							'name' 		=> 'navigation_position',
							'operator'  => '=',
							'value' 	=> 'middle-inside'
						]
					]
				]
			]
		);

		$repeater->add_responsive_control(
			'navigation_arrow_size',
			[

				'label'	=>	__( 'Nav Arrow Size', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 70,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-prev:before' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'conditions' 	=> [
					'relation' => 'or',
					'terms' 	=> [					
						[
							'name' 		=> 'navigation_position',
							'operator'  => '=',
							'value' 	=> 'middle'
						],						
						[
							'name' 		=> 'navigation_position',
							'operator'  => '=',
							'value' 	=> 'middle-inside'
						]
					]
				]
			]
		);

		// $repeater->add_responsive_control(
		// 	'navigation_nav_position',
		// 	[

		// 		'label'	=>	__( 'Nav position', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::SLIDER,
		// 		'size_units' => [ 'px', '%' ],
		// 		'range' => [
		// 			'px' => [
		// 				'min' => -500,
		// 				'max' => 1600,
		// 				'step' => 1
		// 			],
		// 			'%' => [
		// 				'min' => 0,
		// 				'max' => 100,
		// 			],
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .et-advance-product-tabs .et-tabs-nav .swiper-button-prev.navbar' => 'left: {{SIZE}}{{UNIT}};',
		// 			'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
		// 			'{{WRAPPER}} .et-advance-product-tabs .et-tabs-nav .swiper-button-next.navbar' => 'right: {{SIZE}}{{UNIT}};',
		// 			'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
		// 		],
		// 		'condition' => ['hide_buttons' => ''],
		// 	]
		// );

		// $repeater->add_responsive_control(
		// 	'navigation_nav_right_position',
		// 	[

		// 		'label'	=>	__( 'Right nav position', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::SLIDER,
		// 		'size_units' => [ 'px', '%' ],
		// 		'range' => [
		// 			'px' => [
		// 				'min' => -500,
		// 				'max' => 1600,
		// 				'step' => 1
		// 			],
		// 			'%' => [
		// 				'min' => 0,
		// 				'max' => 100,
		// 			],
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .et-advance-product-tabs .et-tabs-nav .swiper-button-next.navbar' => 'left: {{SIZE}}{{UNIT}};',
		// 			'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-next' => 'left: {{SIZE}}{{UNIT}};',
		// 			'{{WRAPPER}} .et-advance-product-tabs .swiper-button-next.bottom' => 'left: {{SIZE}}{{UNIT}};',
		// 		],
		// 		'condition' => ['hide_buttons' => ''],
		// 	]
		// );

		$repeater->add_control(
			'nav_color',
			[
				'label' 	=> __( 'Nav color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => [
					'{{WRAPPER}} .et-advance-product-tabs .et-tabs-nav .swiper-button-next.navbar' => 'color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .et-tabs-nav .swiper-button-prev.navbar' => 'color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-next' => 'color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-prev' => 'color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-button-next.bottom' => 'color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-button-prev.bottom' => 'color: {{VALUE}};',
				],
				'condition' => ['hide_buttons' => ''],
			]
		);

		$repeater->add_control(
			'arrows_bg_color',
			[
				'label' 	=> __( 'Nav background color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => [
					'{{WRAPPER}} .et-advance-product-tabs .et-tabs-nav .swiper-button-next.navbar' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .et-tabs-nav .swiper-button-prev.navbar' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-next' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-prev' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-button-next.bottom' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-button-prev.bottom' => 'background-color: {{VALUE}};',
				],
				'condition' => ['hide_buttons' => ''],
			]
		);

		$repeater->add_control(
			'nav_color_hover',
			[
				'label' 	=> __( 'Nav color hover', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => [
					'{{WRAPPER}} .et-advance-product-tabs .et-tabs-nav .swiper-button-next.navbar:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .et-tabs-nav .swiper-button-prev.navbar:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-next:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-prev:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-button-next.bottom:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-button-prev.bottom:hover' => 'color: {{VALUE}};',
				],
				'condition' => ['hide_buttons' => ''],
			]
		);

		$repeater->add_control(
			'arrows_bg_color_hover',
			[
				'label' 	=> __( 'Nav background hover', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => [
					'{{WRAPPER}} .et-advance-product-tabs .et-tabs-nav .swiper-button-next.navbar:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .et-tabs-nav .swiper-button-prev.navbar:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-next:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-entry .swiper-button-prev:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-button-next.bottom:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .et-advance-product-tabs .swiper-button-prev.bottom:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => ['hide_buttons' => ''],
			]
		);

		$repeater->add_control(
			'hide_buttons_for',
			[
				'label' 		=> __( 'Hide navigation only for', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'' 			=>  __( 'Both', 'xstore-core' ),
					'mobile'	=>	__( 'Mobile', 'xstore-core' ),
					'desktop'	=>	__( 'Desktop', 'xstore-core' ),
				],
				'condition' => ['hide_buttons' => 'true'],
			]
		);

		$repeater->add_control(
			'pagination_header',
			[
				'label' => __( 'Pagination', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'pagination_type',
			[
				'label' 		=> __( 'Pagination type', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'hide' 		=>	__( 'Hide', 'xstore-core' ),
					'bullets' 	=>	__( 'Bullets', 'xstore-core' ),
					'lines' 	=>	__( 'Lines', 'xstore-core' ),
				],
				'default' 		=> 'hide',
			]
		);

		$repeater->add_control(
			'hide_fo',
			[
				'label' 		=> __( 'Hide pagination only for', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'' 			=>  __( 'Select option', 'xstore-core' ),
					'mobile'	=>	__( 'Mobile', 'xstore-core' ),
					'desktop'	=>	__( 'Desktop', 'xstore-core' ),
				],
				'condition' => ['pagination_type' => ['bullets', 'lines' ]],
			]
		);

		$repeater->add_control(
			'default_color',
			[
				'label' 	=> __( 'Pagination color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#e1e1e1',
				'condition' => ['pagination_type' => ['bullets', 'lines' ]],
			]
		);

		$repeater->add_control(
			'active_color',
			[
				'label' 	=> __( 'Pagination color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#222',
				'condition' => ['pagination_type' => ['bullets', 'lines' ]],
			]
		);

		$repeater->add_control(
			'Settings_header',
			[
				'label' => __( 'Settings', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'slider_autoplay',
			[
				'label' 		=> __( 'Autoplay', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> '',
			]
		);

		$repeater->add_control(
			'slider_stop_on_hover',
			[
				'label' 		=> __( 'Pause on hover', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> '',
				'condition' 	=> ['slider_autoplay' => 'true'],
			]
		);

		$repeater->add_control(
			'slider_interval',
			[
				'label' 		=> __( 'Autoplay speed', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::NUMBER,
				'description' 	=> __( 'Interval between slides. In milliseconds.', 'xstore-core' ),
				'return_value' 	=> 'true',
				'default' 		=> 3000,
				'condition' 	=> ['slider_autoplay' => 'true'],
			]
		);

		$repeater->add_control(
			'slider_loop',
			[
				'label' 		=> __( 'Infinite loop', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> 'true',
			]
		);

		$repeater->add_control(
			'slider_speed',
			[
				'label' 		=> __( 'Transition Speed', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::NUMBER,
				'description' 	=> __( 'Duration of transition between slides. In milliseconds.', 'xstore-core' ),
				'default' 		=> '300',
			]
		);

		$repeater->add_responsive_control(
			'slides',
			[
				'label' 	=>	__( 'Slider items', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::NUMBER,
				'default' 	=>	4,
				'default_tablet' => 3,
				'default_mobile' => 2,
				'min' => 0,
			]
		);

	}

	public static function slider_navigation( $widget_settings, $tab_settings, $visibility = 'none' ){

		$navigation_class = '';
		if ( $tab_settings['hide_buttons_for'] == 'desktop' ) 
			$navigation_class = ' dt-hide';
		elseif ( $tab_settings['hide_buttons_for'] == 'mobile' ) 
			$navigation_class = ' mob-hide';
		
		$navigation_class_left  = 'swiper-custom-left' . ' ' . $navigation_class;
		$navigation_class_right = 'swiper-custom-right' . ' ' . $navigation_class;
		
		$navigation_class_left .= ' type-' . $widget_settings['navigation_type'] . ' ' . $widget_settings['navigation_style'];
		$navigation_class_right .= ' type-' . $widget_settings['navigation_type'] . ' ' . $widget_settings['navigation_style'];

		if ( 'nav-bar' === $widget_settings['navigation_position'] ) {

			$style = 'style="display: '. $visibility . '; '. $style .'"';

			return'
			<li '. $style .' data-id="'. $tab_settings['_id'] .'" class="skip swiper-button-prev navbar ' . $navigation_class_left .' '. $navigation_class . '" ></li>
			<li style="display:'. $visibility . ';" data-id="'. $tab_settings['_id'] .'" class="skip swiper-button-next navbar ' . $navigation_class_right .' '. $navigation_class . '"></li>';
		}		

		if ( 'bottom' === $widget_settings['navigation_position'] ) {
			return'
			<div class="swiper-button-prev bottom ' . $navigation_class_left .' '. $navigation_class . '"></div>
			<div class="swiper-button-next bottom ' . $navigation_class_right .' '. $navigation_class . '"></div>';
		}

		return false;
	}

	/**
	 * Create menu list item widget
	 *
	 * @since 2.1.3
	 * @access public
	 */
  	public static function get_menu_list_item( $repeater ) {

      $divider = 0;

      $repeater->start_controls_tabs( 'menu_list_item_tabs' );

      $repeater->start_controls_tab(
        'menu_list_item_content',
        [
          'label' => __( 'Content', 'xstore-core' ),
        ]
      );

      $repeater->add_control(
        'divider'.$divider++,
        [
          'label' => __( 'Title', 'xstore-core' ),
          'type' => \Elementor\Controls_Manager::HEADING,
          'separator' => 'before',
        ]
      );

      $repeater->add_control(
        'title',
        [
          'label' => __( 'Title', 'xstore-core' ),
          'type'  => \Elementor\Controls_Manager::TEXT,
        ]
      );

      $repeater->add_control(
        'title_custom_tag',
        [
          'label'     =>  __( 'Element Tag', 'xstore-core' ),
          'type'      =>  \Elementor\Controls_Manager::SELECT,
          'options'     =>  [
            'h1'      => esc_html__( 'H1', 'xstore-core' ), 
            'h2'      => esc_html__( 'H2', 'xstore-core' ), 
            'h3'      => esc_html__( 'H3', 'xstore-core' ), 
            'h4'      => esc_html__( 'H4', 'xstore-core' ), 
            'h5'      => esc_html__( 'H5', 'xstore-core' ), 
            'h6'      => esc_html__( 'H6', 'xstore-core' ), 
            'p'       => esc_html__( 'P', 'xstore-core' ), 
            'div'     => esc_html__( 'DIV', 'xstore-core' ), 
          ],
          'default'   => 'h3',
        ]
      );

      $repeater->add_control(
        'link',
        [
          'label' => __( 'Link', 'xstore-core' ),
          'type'  => \Elementor\Controls_Manager::URL,
        ]
      );

      $repeater->add_control(
        'label',
        [
          'label'     =>  __( 'Label', 'xstore-core' ),
          'type'      =>  \Elementor\Controls_Manager::SELECT,
          'options'     =>  [
            ''    =>  esc_html__( 'Select label', 'xstore-core' ),
            'hot' =>  esc_html__( 'Hot', 'xstore-core' ),
            'sale'  =>  esc_html__( 'Sale', 'xstore-core' ),
            'new' =>  esc_html__( 'New', 'xstore-core' ),
          ],
        ]
      );

		// on update ( bug with fa icons on frontend )
  //     $repeater->add_control(
  //       'divider'.$divider++,
  //       [
  //         'label' => __( 'Icon', 'xstore-core' ),
  //         'type' => \Elementor\Controls_Manager::HEADING,
  //         'separator' => 'before',
  //       ]
  //     );

  //     $repeater->add_control(
  //       'add_icon',
  //       [
  //         'label'     =>  __( 'Add icon ?', 'xstore-core' ),
  //         'type'      =>  \Elementor\Controls_Manager::SWITCHER,
  //         'return_value'  =>  'true',
  //         'default'     =>  '',
  //       ]
  //     );

  // 		$repeater->add_control(
		// 	'type',
		// 	[
		// 		'label' 		=>	__( 'Icon library', 'xstore-core' ),
		// 		'type' 			=>	\Elementor\Controls_Manager::SELECT,
		// 		'options' 		=>	[
		// 			'svg'			=>	esc_html__( 'Icon', 'xstore-core' ),
		// 			'image'			=>	esc_html__( 'Upload image', 'xstore-core' ),
		// 		],
		// 		'default'		=> 'svg',
		// 		'condition' => [ 'add_icon' => 'true' ],
		// 	]
		// );

		// $repeater->add_control(
		// 	'icon_library',
		// 	[
		// 		'label' => __( 'Icon', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::ICONS,
		// 		'separator' => 'before',
		// 		'fa4compatibility' => 'icon',
		// 		'default' => [
		// 			'value' => 'et-icon et-gift',
		// 			'library' => 'xstore-icons',
		// 		],
		// 		'label_block' => false,
		// 		'skin' => 'inline',
		// 		'conditions' 	=> [
		// 			'terms' 	=> [
		// 				[
		// 					'name' 		=> 'type',
		// 					'operator'  => '=',
		// 					'value' 	=> 'svg'
		// 				],						
		// 				[
		// 					'name' 		=> 'add_icon',
		// 					'operator'  => '=',
		// 					'value' 	=> 'true'
		// 				],
		// 			]
		// 		]
		// 	]
		// );

		// $repeater->add_control(
		// 	'icon_svg_size',
		// 	[
		// 		'label' => __( 'SVG width', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::SLIDER,
		// 		'size_units' => [ 'px', 'em', 'rem' ],
		// 		'range' => [
		// 			'px' => [
		// 				'min' => 0,
		// 				'max' => 70,
		// 				'step' => 1,
		// 			],
		// 		],
		// 		'conditions' 	=> [
		// 			'terms' 	=> [
		// 				[
		// 					'name' 		=> 'type',
		// 					'operator'  => '=',
		// 					'value' 	=> 'svg'
		// 				],						
		// 				[
		// 					'name' 		=> 'add_icon',
		// 					'operator'  => '=',
		// 					'value' 	=> 'true'
		// 				],
		// 				[
		// 					'name' 		=> 'icon_library[library]',
		// 					'operator'  => '=',
		// 					'value' 	=> 'svg'
		// 				],
		// 			]
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .et-menu-list .item-title-holder .menu-title img' => 'width: {{SIZE}}{{UNIT}};',
		// 		],
		// 	]
		// );

		// $repeater->add_control(
		// 	'position',
		// 	[
		// 		'label' 		=>	__( 'Position of the icon/image', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::CHOOSE,
		// 		'options' => [
		// 			'left-center' => [
		// 				'title' => __( 'Left', 'xstore-core' ),
		// 				'icon' => 'eicon-h-align-left',
		// 			],
		// 			'center-center' => [
		// 				'title' => __( 'Top', 'xstore-core' ),
		// 				'icon' => 'eicon-v-align-top',
		// 			],
		// 			'right-center' => [
		// 				'title' => __( 'Right', 'xstore-core' ),
		// 				'icon' => 'eicon-h-align-right',
		// 			],
		// 		],
		// 		'render_type' => 'template',
		// 		'default' => 'left-center',
		// 		'conditions' 	=> [
		// 			'terms' 	=> [					
		// 				[
		// 					'name' 		=> 'add_icon',
		// 					'operator'  => '=',
		// 					'value' 	=> 'true'
		// 				],
		// 				[
		// 					'name' 		=> 'icon_library[library]',
		// 					'operator'  => '!=',
		// 					'value' 	=> ''
		// 				],
		// 			]
		// 		],
		// 	]
		// );

		// $repeater->add_control(
		// 	'divider'.$divider++,
		// 	[
		// 		'label' => __( 'Image', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::HEADING,
		// 		'separator' => 'before',
		// 		'conditions' 	=> [
		// 			'terms' 	=> [
		// 				[
		// 					'name' 		=> 'type',
		// 					'operator'  => '=',
		// 					'value' 	=> 'image'
		// 				],						
		// 				[
		// 					'name' 		=> 'add_icon',
		// 					'operator'  => '=',
		// 					'value' 	=> 'true'
		// 				],
		// 			]
		// 		]
		// 	]
		// );

		// $repeater->add_control(
		// 	'img',
		// 	[
		// 		'label' => __( 'Image', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::MEDIA,
		// 		'default' => [
		// 			'url' => \Elementor\Utils::get_placeholder_image_src(),
		// 		],
		// 		'conditions' 	=> [
		// 			'terms' 	=> [
		// 				[
		// 					'name' 		=> 'type',
		// 					'operator'  => '=',
		// 					'value' 	=> 'image'
		// 				],						
		// 				[
		// 					'name' 		=> 'add_icon',
		// 					'operator'  => '=',
		// 					'value' 	=> 'true'
		// 				],
		// 			]
		// 		]
		// 	]
		// );

		// $repeater->add_control(
		// 	'img_size',
		// 	[
		// 		'label' => __( 'Image size', 'xstore-core' ),
		// 		'type' 	=> \Elementor\Controls_Manager::TEXT,
		// 		'description' => __( 'Enter image size (Ex.: "medium", "large" etc.) or enter size in pixels (Ex.: 200x100 (WxH))', 'xstore-core' ),
		// 		'conditions' 	=> [
		// 			'terms' 	=> [
		// 				[
		// 					'name' 		=> 'type',
		// 					'operator'  => '=',
		// 					'value' 	=> 'image'
		// 				],						
		// 				[
		// 					'name' 		=> 'add_icon',
		// 					'operator'  => '=',
		// 					'value' 	=> 'true'
		// 				],
		// 			]
		// 		]
		// 	]
		// );

		$repeater->add_control(
			'divider'.$divider++,
			[
				'label' => __( 'Advanced', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'class',
			[
				'label' => __( 'CSS Classes', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

      	$repeater->end_controls_tab();

      	$repeater->start_controls_tab(
        	'menu_list_item_style',
        	[
          		'label' => __( 'Style', 'xstore-core' ),
        	]
      	);

      	$repeater->add_control(
	        'divider'.$divider++,
	        [
          		'label' => __( 'Title', 'xstore-core' ),
	          	'type' => \Elementor\Controls_Manager::HEADING,
	          	'separator' => 'before',
	        ]
      	);

      	$repeater->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'          => 'title_typography',
                'label'         => __( 'Typography', 'xstore-core' ),
                'selector'      => '{{WRAPPER}} {{CURRENT_ITEM}}  .menu-title',
          		'separator'     => 'before',
            ]
    	);

      $repeater->add_control(
        	'color',
        	[
	          	'label'   => __( 'Color', 'xstore-core' ),
	          	'type'    => \Elementor\Controls_Manager::COLOR,
	            'selectors'    => [
	                '{{WRAPPER}} {{CURRENT_ITEM}} .menu-title' => 'color: {{VALUE}};',
	            ],
        	]
      	);

      $repeater->add_control(
        'hover_color',
        [
          'label'   => __( 'Color (hover)', 'xstore-core' ),
          'type'    => \Elementor\Controls_Manager::COLOR,
          'selectors'    => [
            '{{WRAPPER}} {{CURRENT_ITEM}}:hover .menu-title' => 'color: {{VALUE}};',
          ],
        ]
      	);

	    $repeater->add_control(
	        'item_paddings',
	        [
	          'label' => __( 'Paddings', 'xstore-core' ),
	          'type' => \Elementor\Controls_Manager::DIMENSIONS,
	          'size_units' => [ 'px', '%' ],
	          'selectors' => [
	            '{{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .menu-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	          ],
	        ]
	      );

	    	// on update ( bug with fa icons on frontend )

	  		//  $repeater->add_control(
			// 	'divider'.$divider++,
			// 	[
			// 		'label' => __( 'Icon', 'xstore-core' ),
			// 		'type' => \Elementor\Controls_Manager::HEADING,
			// 		'separator' => 'before',
			// 		'conditions' 	=> [
			// 			'terms' 	=> [
			// 				[
			// 					'name' 		=> 'type',
			// 					'operator'  => '=',
			// 					'value' 	=> 'svg'
			// 				],						
			// 				[
			// 					'name' 		=> 'add_icon',
			// 					'operator'  => '=',
			// 					'value' 	=> 'true'
			// 				],
			// 				[
			// 					'name' 		=> 'icon_library[library]',
			// 					'operator'  => '!in',
			// 					'value' 	=> ['svg', '']
			// 				],
			// 			]
			// 		]
			// 	]
			// );

			// $repeater->add_control(
			// 	'icon_size',
			// 	[
			// 		'label' => __( 'Icon size', 'xstore-core' ),
			// 		'type' => \Elementor\Controls_Manager::SLIDER,
			// 		'size_units' => [ 'px', 'em', 'rem' ],
			// 		'range' => [
			// 			'px' => [
			// 				'min' => 0,
			// 				'max' => 70,
			// 				'step' => 1,
			// 			],
			// 		],
			// 		'conditions' 	=> [
			// 			'terms' 	=> [
			// 				[
			// 					'name' 		=> 'type',
			// 					'operator'  => '=',
			// 					'value' 	=> 'svg'
			// 				],						
			// 				[
			// 					'name' 		=> 'add_icon',
			// 					'operator'  => '=',
			// 					'value' 	=> 'true'
			// 				],
			// 				[
			// 					'name' 		=> 'icon_library[library]',
			// 					'operator'  => '!=',
			// 					'value' 	=> ['svg', '']
			// 				],
			// 			]
			// 		],
			// 		'selectors' => [
			// 			'{{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .menu-title i i' => 'font-size: {{SIZE}}{{UNIT}};',
			// 		],
			// 	]
			// );

			// $repeater->add_control(
			// 	'icon_spacing',
			// 	[
			// 		'label' => __( 'Spacing', 'xstore-core' ),
			// 		'type' => \Elementor\Controls_Manager::SLIDER,
			// 		'size_units' => [ 'px', 'em', 'rem' ],
			// 		'range' => [
			// 			'px' => [
			// 				'min' => 0,
			// 				'max' => 70,
			// 				'step' => 1,
			// 			],
			// 		],
			// 		'conditions' 	=> [
			// 			'terms' 	=> [
			// 				[
			// 					'name' 		=> 'type',
			// 					'operator'  => '=',
			// 					'value' 	=> 'svg'
			// 				],						
			// 				[
			// 					'name' 		=> 'add_icon',
			// 					'operator'  => '=',
			// 					'value' 	=> 'true'
			// 				],
			// 				[
			// 					'name' 		=> 'icon_library[value]',
			// 					'operator'  => '!=',
			// 					'value' 	=> ''
			// 				],
			// 			]
			// 		],
			// 		'selectors' => [
			// 			'{{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .position-left-center i, {{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .position-left-center img' => 'margin: 0 {{SIZE}}{{UNIT}} 0 0;',
			// 			'{{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .position-center-center i, {{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .position-center-center img' => 'margin: 0 0 {{SIZE}}{{UNIT}} 0;',
			// 			'{{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .position-right-center i, {{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .position-right-center img' => 'margin: 0 0 0 {{SIZE}}{{UNIT}};',
			// 		],
			// 	]
			// );

			// in next update will be improved not to use at this time 
			// $repeater->add_control(
			// 	'icon_border_radius',
			// 	[
			// 		'label' => __( 'Border Radius', 'xstore-core' ),
			// 		'type' => \Elementor\Controls_Manager::DIMENSIONS,
			// 		'size_units' => [ 'px', '%' ],
			// 		'selectors' => [
			// 			'{{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .menu-title i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			// 		],
			// 		'conditions' 	=> [
			// 			'terms' 	=> [
			// 				[
			// 					'name' 		=> 'type',
			// 					'operator'  => '=',
			// 					'value' 	=> 'svg'
			// 				],						
			// 				[
			// 					'name' 		=> 'add_icon',
			// 					'operator'  => '=',
			// 					'value' 	=> 'true'
			// 				],
			// 				[
			// 					'name' 		=> 'icon_library[library]',
			// 					'operator'  => '!in',
			// 					'value' 	=> ['svg', '']
			// 				],
			// 			]
			// 		]
			// 	]
			// );

	      	// on update ( bug with fa icons on frontend )
			// $repeater->add_control(
			// 	'icon_color',
			// 	[
			// 		'label' 	=> __( 'Icon color', 'xstore-core' ),
			// 		'type' 		=> \Elementor\Controls_Manager::COLOR,
			// 		'conditions' 	=> [
			// 			'terms' 	=> [
			// 				[
			// 					'name' 		=> 'type',
			// 					'operator'  => '=',
			// 					'value' 	=> 'svg'
			// 				],						
			// 				[
			// 					'name' 		=> 'add_icon',
			// 					'operator'  => '=',
			// 					'value' 	=> 'true'
			// 				],
			// 				[
			// 					'name' 		=> 'icon_library[library]',
			// 					'operator'  => '!=',
			// 					'value' 	=> ['svg', '']
			// 				],
			// 			]
			// 		],
			// 		'selectors' => [
			// 			'{{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .menu-title i' => 'fill: {{VALUE}};',
			// 		],
			// 	]
			// );

			// $repeater->add_control(
			// 	'icon_color_hover',
			// 	[
			// 		'label' 	=> __( 'Icon color (hover)', 'xstore-core' ),
			// 		'type' 		=> \Elementor\Controls_Manager::COLOR,
			// 		'conditions' 	=> [
			// 			'terms' 	=> [
			// 				[
			// 					'name' 		=> 'type',
			// 					'operator'  => '=',
			// 					'value' 	=> 'svg'
			// 				],						
			// 				[
			// 					'name' 		=> 'add_icon',
			// 					'operator'  => '=',
			// 					'value' 	=> 'true'
			// 				],
			// 				[
			// 					'name' 		=> 'icon_library[library]',
			// 					'operator'  => '!=',
			// 					'value' 	=> ['svg', '']
			// 				],
			// 			]
			// 		],
			// 		'selectors' => [
			// 			'{{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .menu-title:hover i' => 'fill: {{VALUE}};',
			// 		],
			// 	]
			// );

			// in next update will be improved not to use at this time 
			// $repeater->add_control(
			// 	'icon_bg_color',
			// 	[
			// 		'label' 	=> __( 'Icon background color', 'xstore-core' ),
			// 		'type' 		=> \Elementor\Controls_Manager::COLOR,
			// 		'conditions' 	=> [
			// 			'terms' 	=> [
			// 				[
			// 					'name' 		=> 'type',
			// 					'operator'  => '=',
			// 					'value' 	=> 'svg'
			// 				],						
			// 				[
			// 					'name' 		=> 'add_icon',
			// 					'operator'  => '=',
			// 					'value' 	=> 'true'
			// 				],
			// 				[
			// 					'name' 		=> 'icon_library[library]',
			// 					'operator'  => '!in',
			// 					'value' 	=> ['svg', '']
			// 				],
			// 			]
			// 		],
			// 		'selectors' => [
			// 			'{{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .menu-title i' => 'background-color: {{VALUE}};',
			// 		],
			// 	]
			// );

		// $repeater->add_control(
		// 	'icon_bg_color_hover',
		// 	[
		// 		'label' 	=> __( 'Icon background color (hover)', 'xstore-core' ),
		// 		'type' 		=> \Elementor\Controls_Manager::COLOR,
		// 		'conditions' 	=> [
		// 			'terms' 	=> [
		// 				[
		// 					'name' 		=> 'type',
		// 					'operator'  => '=',
		// 					'value' 	=> 'svg'
		// 				],						
		// 				[
		// 					'name' 		=> 'add_icon',
		// 					'operator'  => '=',
		// 					'value' 	=> 'true'
		// 				],
		// 				[
		// 					'name' 		=> 'icon_library[library]',
		// 					'operator'  => '!in',
		// 					'value' 	=> ['svg', '']
		// 				],
		// 			]
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .et-menu-list {{CURRENT_ITEM}} .menu-title:hover i' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );

      	$repeater->end_controls_tab();

  		$repeater->end_controls_tabs();

      	// $repeater->end_controls_section();

	}

	/**
	 * Create menu list item widget
	 *
	 * @since 2.1.3
	 * @access public
	 */
	public static function get_scroll_text_item( $repeater ) {

        $repeater->add_control(
            'content',
            [
                'label' => __( 'Text', 'xstore-core' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'placeholder' => __( 'Lorem ipsum dolor ...', 'xstore-core' ),
            ]
        );

        $repeater->add_control(
            'tooltip',
            [
                'label'         =>  __( 'Use tooltip instead of link', 'xstore-core' ),
                'type'          =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'      =>  __( 'Hide', 'xstore-core' ),
                'label_off'     =>  __( 'Show', 'xstore-core' ),
                'return_value'  =>  'true',
                'default'       =>  '',
            ]
        );        

        $repeater->add_control(
            'tooltip_title',
            [
                'label' => __( 'Tooltip title', 'xstore-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition'     =>  ['tooltip' => 'true'],
            ]
        );

        $repeater->add_control(
            'tooltip_content',
            [
                'label' => __( 'Tooltip content', 'xstore-core' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'placeholder'   => __( 'Lorem ipsum dolor ...', 'xstore-core' ),
                'condition'     =>  ['tooltip' => 'true'],
            ]
        );

        $repeater->add_control(
            'tooltip_content_pos',
            [
                'label'         =>  __( 'Tooltip content position', 'xstore-core' ),
                'type'          =>  \Elementor\Controls_Manager::SELECT,
                'options'       =>  [
                    'bottom' => esc_html__( 'Bottom', 'xstore-core' ),
                    'top' 	 => esc_html__( 'Top', 'xstore-core' ),
                ],
            ]
        );

        $repeater->add_control(
        	'button_link',
        	[
        		'label' => __( 'Button link', 'xstore-core' ),
        		'type' => \Elementor\Controls_Manager::URL,
        		'placeholder' => __( 'https://your-link.com', 'xstore-core' ),
        		'show_external' => true,
        		'default' => [
        			'url' => '',
        			'is_external' => true,
        			'nofollow' => true,
        		],
        		'conditions' 	=> [
        			'terms' 	=> [
        				[
        					'name' 		=> 'tooltip',
        					'operator'  => '!=',
        					'value' 	=> 'true'
        				]
        			]
        		]
        	]
        );

        $repeater->add_control(
            'el_class',
            [
                'label' => __( 'CSS Classes', 'xstore-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

	}

	/**
	 * Create slider item
	 *
	 * @since 2.1.3
	 * @access public
	 */
	public static function get_slider_item( $repeater ) {

		$repeater->start_controls_tabs( 'slide_settings' );

		$repeater->start_controls_tab(
			'content_settings',
			[
				'label' => __( 'Content', 'xstore-core' ),
			]
		);

		$repeater->add_control(
			'divider_title',
			[
				'label' => __( 'Title Settings', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' 		=>	__( 'Title', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::TEXT,
				'default' => __( 'Slide Heading', 'xstore-core' ),
			]
		);

		$repeater->add_control(
			'title_class',
			[
				'label' 		=>	__( 'CSS Classes', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'divider_subtitle',
			[
				'label' => __( 'Subtitle Settings', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label' 		=>	__( 'Subtitle', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::TEXT,
				'default' => __( 'Slide Subtitle', 'xstore-core' ),
			]
		);

		$repeater->add_control(
			'subtitle_class',
			[
				'label' 		=>	__( 'CSS Classes', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::TEXT,
			]
		);


		$repeater->add_control(
			'subtitle_above',
			[
				'label' 		=>	__( 'Show subtitle above title ?', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=>	__( 'Hide', 'xstore-core' ),
				'label_off' 	=>	__( 'Show', 'xstore-core' ),
				'return_value'  =>	'true',
				'default' 		=>	'',
			]
		);

		$repeater->add_control(
			'divider_content',
			[
				'label' => __( 'Content Settings', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'content',
			[
				'label' => __( 'Content', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'xstore-core' ),
			]
		);

		$repeater->add_control(
			'divider_button',
			[
				'label' => __( 'Button', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
	
		$repeater->add_control(
			'button_title',
			[
				'label' => __( 'Button Title', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Click here', 'xstore-core' )
			]
		);

		$repeater->add_control(
			'button_link',
			[
				'label' => __( 'Button link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::URL,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' 		=>	__( 'Apply for slide', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=>	__( 'Hide', 'xstore-core' ),
				'label_off' 	=>	__( 'Show', 'xstore-core' ),
				'return_value'  =>	'true',
				'default' 		=>	'',
			]
		);

		$repeater->add_control(
			'divider_class',
			[
				'label' => __( 'Advanced', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'el_class',
			[
				'label' 		=>	__( 'CSS Classes', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::TEXT,
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'background_settings',
			[
				'label' => __( 'Background', 'xstore-core' ),
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic' ], // classic, gradient, video, slideshow
				'selector'    => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
						'default' => 'classic'
					],
					'color' => [
						'default' => '#fafafa'
					],
					'position' => [
						'default' => 'center center'
					],
					'repeat' => [
						'default' => 'no-repeat'
					],
					'size' => [
						'default' => 'cover'
					],
				],
			]
		);

		// $repeater->add_control(
		// 	'bg_img',
		// 	[
		// 		'label' => __( 'Image', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::MEDIA,
		// 		'default' => [
		// 			'url' => \Elementor\Utils::get_placeholder_image_src(),
		// 		],
		// 	]
		// );

		// $repeater->add_control(
		// 	'bg_size',
		// 	[
		// 		'label' 		=>	__( 'Background size', 'xstore-core' ),
		// 		'type' 			=>	\Elementor\Controls_Manager::SELECT,
		// 		'options' 		=>	[
		// 			'cover'		=>	esc_html__('Cover', 'xstore-core'),
		// 			'contain'	=>	esc_html__('Contain', 'xstore-core'),
		// 			'auto'		=>	esc_html__('Auto', 'xstore-core'),
		// 		],
		// 		'default' => 'cover'
		// 	]
		// );

		// $repeater->add_control(
		// 	'background_position',
		// 	[
		// 		'label' 		=>	__( 'Background position', 'xstore-core' ),
		// 		'type' 			=>	\Elementor\Controls_Manager::SELECT,
		// 		'options' 		=>	[
		// 			'' => esc_html__('Select option', 'xstore-core'),
		// 			'left_top'			=>	esc_html__('Left top', 'xstore-core'),
		// 			'left'				=>	esc_html__('Left center', 'xstore-core'),
		// 			'left_bottom'		=>	esc_html__('Left bottom', 'xstore-core'),
		// 			'right_top'			=>	esc_html__('Right top', 'xstore-core'),
		// 			'right'				=>	esc_html__('Right center', 'xstore-core'),
		// 			'right_bottom'		=>	esc_html__('Right bottom', 'xstore-core'),
		// 			'center_top'		=>	esc_html__('Center top', 'xstore-core'),
		// 			'center'			=>	esc_html__('Center center', 'xstore-core'),
		// 			'center_bottom'		=>	esc_html__('Center bottom', 'xstore-core'),
		// 			'custom'			=>	esc_html__('(x% y%)', 'xstore-core'),
		// 		],
		// 	]
		// );

		// $repeater->add_control(
		// 	'bg_pos_x',
		// 	[
		// 		'label' 		=>	__( 'Axis X', 'xstore-core' ),
		// 		'type' 			=>	\Elementor\Controls_Manager::TEXT,
		// 		'description' 	=>	__( 'Use this field to add background position by X axis. For example 50', 'xstore-core' ),
		// 		'condition' 	=>	['background_position' => 'custom'],
		// 	]
		// );

		// $repeater->add_control(
		// 	'bg_pos_y',
		// 	[
		// 		'label' 		=>	__( 'Axis Y', 'xstore-core' ),
		// 		'type' 			=>	\Elementor\Controls_Manager::TEXT,
		// 		'description' 	=>	__( 'Use this field to add background position by Y axis. For example 50', 'xstore-core' ),
		// 		'condition' 	=>	['background_position' => 'custom'],
		// 	]
		// );

		// $repeater->add_control(
		// 	'background_repeat',
		// 	[
		// 		'label' 		=>	__( 'Background repeat', 'xstore-core' ),
		// 		'type' 			=>	\Elementor\Controls_Manager::SELECT,
		// 		'options' 		=>	[
		// 			''			=>	esc_html__('Unset', 'xstore-core'),
		// 			'no-repeat'	=>	esc_html__('No repeat', 'xstore-core'),
		// 			'repeat'	=>	esc_html__('Repeat', 'xstore-core'),
		// 			'repeat-x'	=>	esc_html__('Repeat x', 'xstore-core'),
		// 			'repeat-y'	=>	esc_html__('Repeat y', 'xstore-core'),
		// 			'round'		=>	esc_html__('Round', 'xstore-core'),
		// 			'space'		=>	esc_html__('Space', 'xstore-core'),
		// 		],
		// 	]
		// );

		// $repeater->add_control(
		// 	'bg_color',
		// 	[
		// 		'label' 	=> __( 'Background Color', 'xstore-core' ),
		// 		'type' 		=> \Elementor\Controls_Manager::COLOR,
		// 	]
		// );

		$repeater->add_control(
			'bg_overlay',
			[
				'label' 	=> __( 'Background Overlay', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'style_settings',
			[
				'label' => __( 'Style', 'xstore-core' ),
			]
		);

		$repeater->add_control(
			'divider_content_style',
			[
				'label' => __( 'Content', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'content_width',
			[

				'label'	=>	__( 'Content width', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
						'step' => 10
					],
				],
			]
		);

		$repeater->add_control(
			'align',
			[
				'label' 		=>	__( 'Horizontal align', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'start'		=>	esc_html__( 'Left', 'xstore-core' ),
					'end'		=>	esc_html__( 'Right', 'xstore-core' ),
					'center'	=>	esc_html__( 'Center', 'xstore-core' ),
					'between'	=>	esc_html__( 'Stretch', 'xstore-core' ),
					'around'	=>	esc_html__( 'Stretch (no paddings)', 'xstore-core' ),
				],
				'default' => 'center'
			]
		);

		$repeater->add_control(
			'v_align',
			[
				'label' 		=>	__( 'Vertical align', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'start'		=>	esc_html__( 'Top', 'xstore-core' ),
					'end'		=>	esc_html__( 'Bottom', 'xstore-core' ),
					'center'	=>	esc_html__( 'Middle', 'xstore-core' ),
					'stretch'	=>	esc_html__( 'Full height', 'xstore-core' ),
				],
				'default' => 'center'
			]
		);

		$repeater->add_responsive_control(
			'text_align',
			[
				'label' 		=>	__( 'Text align', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'xstore-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'xstore-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'xstore-core' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'xstore-core' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$repeater->add_responsive_control(
			'content_paddings',
			[
				'label' => __( 'Padding', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				// 'devices' => [ self::RESPONSIVE_DESKTOP, self::RESPONSIVE_MOBILE ],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$repeater->add_control(
			'divider_title_style',
			[
				'label' => __( 'Title', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_group_control(
	        \Elementor\Group_Control_Typography::get_type(),
	        [
	            'name'        	=> 'title_typography',
	            'label'       	=> __( 'Typography', 'xstore-core' ),
	            'selector'    	=> '{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-title',
				'separator'   	=> 'before',
	        ]
	    );

		$repeater->add_control(
			'color',
			[
				'label' 	=> __( 'Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-title' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_responsive_control(
			'title_spacing',
			[
				'label' => __( 'Spacing', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater->add_control(
			'title_css_animation',
			[
				'label' => __( 'Animation Type', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::ANIMATION,
				'render_type' => 'ui',
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-title' => 'animation-name: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'title_animation_duration',
			[
				'label' 		=>	__( 'Animation duration', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::NUMBER,
				'default' 		=> 500,
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'title_css_animation',
							'operator'  => '!=',
							'value' 	=> 'none'
						]
					]
				],
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-title' => 'animation-duration: {{VALUE}}ms;',
				],
			]
		);

		$repeater->add_control(
			'title_animation_delay',
			[
				'label' 		=>	__( 'Animation delay', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::NUMBER,
				'default' 		=> 0,
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'title_css_animation',
							'operator'  => '!=',
							'value' 	=> 'none'
						]
					]
				],
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-title' => 'animation-delay: {{VALUE}}ms;',
				],
			]
		);

		$repeater->add_control(
			'divider_subtitle_style',
			[
				'label' => __( 'Subtitle', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_group_control(
	        \Elementor\Group_Control_Typography::get_type(),
	        [
	            'name'        	=> 'subtitle_typography',
	            'label'       	=> __( 'Typography', 'xstore-core' ),
	            'selector'    	=> '{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-subtitle',
				'separator'   	=> 'before',
	        ]
	    );

		$repeater->add_control(
			'subtitle_color',
			[
				'label' 	=> __( 'Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_responsive_control(
			'subtitle_spacing',
			[
				'label' => __( 'Spacing', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater->add_control(
			'subtitle_css_animation',
			[
				'label' => __( 'Animation Type', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::ANIMATION,
				'render_type' => 'ui',
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-subtitle' => 'animation-name: {{VALUE}};',
				],

			]
		);

		$repeater->add_control(
			'subtitle_animation_duration',
			[
				'label' 		=>	__( 'Animation duration', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::NUMBER,
				'default' 		=> 500,
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'subtitle_css_animation',
							'operator'  => '!=',
							'value' 	=> 'none'
						]
					]
				],
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-subtitle' => 'animation-duration: {{VALUE}}ms;',
				],
			]
		);

		$repeater->add_control(
			'subtitle_animation_delay',
			[
				'label' 		=>	__( 'Animation delay', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::NUMBER,
				'default' 		=> 0,
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'subtitle_css_animation',
							'operator'  => '!=',
							'value' 	=> 'none'
						]
					]
				],
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-subtitle' => 'animation-delay: {{VALUE}}ms;',
				],
			]
		);

		$repeater->add_control(
			'divider_description_style',
			[
				'label' => __( 'Description', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_group_control(
	        \Elementor\Group_Control_Typography::get_type(),
	        [
	            'name'        	=> 'description_typography',
	            'label'       	=> __( 'Typography', 'xstore-core' ),
	            'selector'    	=> '{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .description',
				'separator'   	=> 'before',
	        ]
	    );

		$repeater->add_control(
			'description_color',
			[
				'label' 	=> __( 'Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .description' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_responsive_control(
			'description_spacing',
			[
				'label' => __( 'Spacing', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater->add_control(
			'description_animation',
			[
				'label' => __( 'Animation Type', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::ANIMATION,
				'render_type' => 'ui',
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .description' => 'animation-name: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'description_animation_duration',
			[
				'label' 		=>	__( 'Animation duration', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::NUMBER,
				'default' 		=> 500,
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'description_animation',
							'operator'  => '!=',
							'value' 	=> 'none'
						]
					]
				],
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .description' => 'animation-duration: {{VALUE}}ms;',
				],
			]
		);

		$repeater->add_control(
			'description_animation_delay',
			[
				'label' 		=>	__( 'Animation delay', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::NUMBER,
				'default' 		=> 0,
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'description_animation',
							'operator'  => '!=',
							'value' 	=> 'none'
						]
					]
				],
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .description' => 'animation-delay: {{VALUE}}ms;',
				],
			]
		);

		$repeater->add_control(
			'divider_button_style',
			[
				'label' => __( 'Button', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'button_color',
			[
				'label' 	=> __( 'Text color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
			]
		);

		$repeater->add_control(
			'button_hover_color',
			[
				'label' 	=> __( 'Text color (hover)', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
			]
		);

		$repeater->add_control(
			'button_bg',
			[
				'label' 	=> __( 'Background color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
			]
		);

		$repeater->add_control(
			'button_hover_bg',
			[
				'label' 	=> __( 'Background color (hover)', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        	=> 'button_typography',
				'label' 		=> __( 'Button Typography', 'xstore-core' ),
				'description' 	=> __( 'Use this field to add element font size. For example 20px', 'xstore-core' ),
				'selector'    	=> '{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-button',
				'separator'   	=> 'before',
			]
		);

		$repeater->add_responsive_control(
			'button_paddings',
			[
				'label' => __( 'Padding', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'unit' => 'px',
					'top' => '10',
					'right' => '25',
					'bottom' => '10',
					'left' => '15',
					'isLinked' => false
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$repeater->add_responsive_control(
			'button_border_radius',
			[
				'label' => __( 'Border radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'unit' => 'px',
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$repeater->add_control(
			'button_animation',
			[
				'label' => __( 'Animation type', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::ANIMATION,
				'render_type' => 'ui',
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-button' => 'animation-name: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'button_animation_duration',
			[
				'label' 		=>	__( 'Animation duration', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::NUMBER,
				'default' 		=> 500,
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'button_animation',
							'operator'  => '!=',
							'value' 	=> 'none'
						]
					]
				],
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-button' => 'animation-duration: {{VALUE}}ms;',
				],
			]
		);

		$repeater->add_control(
			'button_animation_delay',
			[
				'label' 		=>	__( 'Animation delay', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::NUMBER,
				'default' 		=> 0,
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'description_animation',
							'operator'  => '!=',
							'value' 	=> 'none'
						]
					]
				],
				'selectors'    => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content .slide-button' => 'animation-delay: {{VALUE}}ms;',
				],
			]
		);

		$repeater->end_controls_tabs();
	}

	/**
	 * Create banner with mask control
	 *
	 * @since 2.1.3
	 * @access public
	 */
	public static function get_banner_with_mask( $control, $repeater = false ) {

		if ( !$repeater ) {
			$control->start_controls_section(
				'settings',
				[
					'label' => __( 'Banner with mask', 'xstore-core' ),
					'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
		}

		$control->add_control(
			'img',
			[
				'label' => __( 'Banner Image', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$control->add_control(
			'title',
			[
				'label' => __( 'Title', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'xstore-core' ),
				'default' => __( 'Banner title', 'xstore-core' )
			]
		);

		$control->add_control(
			'subtitle',
			[
				'label' => __( 'Subtitle', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'xstore-core' ),
				'default' => __( 'Banner subtitle', 'xstore-core' )
			]
		);

		$control->add_control(
			'content',
			[
				'label' => __( 'Content', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Some promo words', 'xstore-core' ),
			]
		);

		$control->add_control(
			'link',
			[
				'label' => __( 'Link', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'xstore-core' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$control->add_control(
			'button_title',
			[
				'label' => __( 'Button Title', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'show_external' => true,
				'default' => __( 'Button Title', 'xstore-core' )
			]
		);

		$control->add_control(
			'button_link',
			[
				'label' => __( 'Button link', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'xstore-core' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		// if using placeholder with ajax loading it won't be shown correctly
		// $control->add_control(
		// 	'ajax',
		// 	[
		// 		'label' => __( 'Lazy loading for this element', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'description' 	=>	__( 'Works for live mode, not for the preview', 'xstore-core' ),
		// 		'label_on' => __( 'Yes', 'xstore-core' ),
		// 		'label_off' => __( 'No', 'xstore-core' ),
		// 		'return_value' => 'true',
		// 		'default' => '',
		// 	]
		// );

		if ( !$repeater ) {
			$control->end_controls_section();
			$control->start_controls_section(
				'style_section',
				[
					'label' => __( 'Content', 'xstore-core' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);
		}

		$control->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'xstore-core' ),
				'selector' => '{{WRAPPER}} .banner-title',
			]
		);

		$control->add_control(
			'title_font_container_textcolor',
			[
				'label' => __( 'Title Text Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .banner-content .banner-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$control->add_control(
			'title_html_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
				],
				'default' => 'h2',
			]
		);

		$control->add_control(
			'hide_title_responsive',
			[
				'label' => __( 'Hide title on mobile', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default' => '',
			]
		);

		$control->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'separator' => 'before',
				'label' => __( 'Subtitle Typography', 'xstore-core' ),
				'selector' => '{{WRAPPER}} .banner-subtitle',
			]
		);

		$control->add_control(
			'subtitle_font_container_textcolor',
			[
				'label' => __( 'Subtitle Text Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .banner-content .banner-subtitle' => 'color: {{VALUE}};',
				],
			]
		);
		
		$control->add_control(
			'subtitle_html_tag',
			[
				'label' => esc_html__( 'Subtitle HTML Tag', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
				],
				'default' => 'h2',
			]
		);

		$control->add_control(
			'hide_subtitle_responsive',
			[
				'label' => __( 'Hide subtitle on mobile', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default' => '',
			]
		);
		
		$control->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'separator' => 'before',
				'label' => __( 'Content Typography', 'xstore-core' ),
				'selector' => '{{WRAPPER}} .content-inner',
			]
		);
		
		$control->add_control(
			'content_font_container_textcolor',
			[
				'label' => __( 'Content Text Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .banner-content .content-inner' => 'color: {{VALUE}};',
				],
			]
		);

		// in next update to improve 
		// $control->add_control(
		// 	'text_effect',
		// 	[
		// 		'label' => __( 'Text hover effect', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::SELECT,
		// 		'options' => [
		// 			0 => __('None', 'xstore-core'),
		// 			1 => __('To top', 'xstore-core'),
		// 		],
		// 		'default' => 0
		// 	]
		// );

		$control->add_responsive_control(
			'align',
			[
				'label' =>	__( 'Content Alignment', 'xstore-core' ),
				'type' 	=>	\Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'xstore-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'xstore-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'xstore-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default'	=> 'left',
				'selectors' => [
					'{{WRAPPER}} .banner .banner-content, {{WRAPPER}} .banner .banner-content .banner-title, {{WRAPPER}} .banner .banner-content .banner-subtitle' => 'text-align: {{VALUE}} !important;',
				],
			]
		);

		$control->add_control(
			'valign',
			[
				'label' => __( 'Content Vertical align', 'xstore-core' ),
				'type' 	=>	\Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top'    => [
						'title' => __( 'Top', 'xstore-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'xstore-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'xstore-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default'	=> 'top',
			]
		);

		// $control->add_control(
		// 	'font_style',
		// 	[
		// 		'label' => __( 'Font style', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::SELECT,
		// 		'options' => [
		// 			'dark'	=>	esc_html__('Dark', 'xstore-core'),
		// 			'light'	=>	esc_html__('Light', 'xstore-core'), 
		// 		],
		// 		'default' => 'dark'
		// 	]
		// );

		// $control->add_control(
		// 	'responsive_fonts',
		// 	[
		// 		'label' => __( 'Responsive fonts', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'return_value' => 'true',
		// 		'default' => '',
		// 	]
		// );
		
		$control->add_control(
			'hide_description_responsive',
			[
				'label' => __( 'Hide description on mobile', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default' => '',
			]
		);		
		
		$control->add_control(
			'is_active',
			[
				'label' => __( 'Hovered state by default', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'separator' => 'before',
				'description' => __( 'Make banner with hovered effects by default', 'xstore-core' ),
				'return_value' => 'true',
				'default' => '',
			]
		);

		$control->add_responsive_control(
			'content_margin',
			[
				'label' => __( 'Content Margin', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .banner-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$control->add_responsive_control(
			'content_border',
			[
				'label' => __( 'Content Border', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .banner-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$control->add_responsive_control(
			'content_paddings',
			[
				'label' => __( 'Content Paddings', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		if ( !$repeater ) {
			$control->end_controls_section();
			$control->start_controls_section(
				'image_section',
				[
					'label' => __( 'Image', 'xstore-core' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);
		}

		$control->add_control(
			'img_size',
			[
				'label' 	=>	__( 'Size', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::TEXT,
				'description' => __( 'Enter image size (Ex.: "medium", "large" etc.) or enter size in pixels (Ex.: 200x100 (WxH))', 'xstore-core' ),
			]
		);

		// $control->add_control(
		// 	'img_size_dimension',
		// 	[
		// 		'label' => __( 'Image Dimension', 'xstore-core' ),
		// 		'type' => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
		// 		'description' => __( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'xstore-core' ),
		// 		'default' => [
		// 			'width' => '200',
		// 			'height' => '100',
		// 		],
		// 		'condition' => ['img_size' => 'custom'],
		// 	]
		// );

		$control->add_responsive_control(
			'img_min_size',
			[
				'label' => __( 'Image min height', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Enter image min-height. Example in pixels: 200px', 'xstore-core' ),
				'selectors' => [
					'{{WRAPPER}} .banner img' => 'min-height: {{VALUE}} !important; object-fit="cover"',
				],
			]
		);
		
		$control->add_responsive_control(
			'img_object_fit_position',
			[
				'label' 	=> __( 'Image position', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::SELECT,
				'default' 	=> '',
				'label_block'	=> 'true',
				'options' 	=> [
					'' => __( 'Default', 'xstore-core' ),
					'left top' => __( 'Left Top', 'xstore-core' ),
					'left center' => __( 'Left Center', 'xstore-core' ),
					'left bottom' => __( 'Left Bottom', 'xstore-core' ),
					'right top' => __( 'Right Top', 'xstore-core' ),
					'right center' => __( 'Right Center', 'xstore-core' ),
					'right bottom' => __( 'Right Bottom', 'xstore-core' ),
					'center top' => __( 'Center Top', 'xstore-core' ),
					'center center'  => __( 'Center Center', 'xstore-core' ),
					'center bottom' => __( 'Center Bottom', 'xstore-core' ),
				],
				'selectors' => [
					'{{WRAPPER}} .banner img' => 'object-position: {{VALUE}} !important;',
				],
			]
		);

		$control->add_control(
			'type',
			[
				'label' 	=> __( 'Hover animation', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::SELECT,
				'default' 	=> 3,
				'label_block'	=> 'true',
				'options' 	=> [
					2 => __('Zoom In', 'xstore-core'),
					6 => __('Slide right', 'xstore-core'),
					4 => __('Zoom out', 'xstore-core'),
					5 => __('Scale out', 'xstore-core'),
					3 => __('None', 'xstore-core'),
				],
			]
		);

		$control->start_controls_tabs( 'image_settings' );

		$control->start_controls_tab(
			'image_settings_normal',
			[
				'label' => __( 'Normal', 'xstore-core' ),
			]
		);

		$control->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_css_filters',
				'selector' => '{{WRAPPER}} .banner img',
			]
		);

		$control->add_control(
			'image_opacity',
			[
				'label' => __( 'Opacity', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'description' => __( 'Enter value between 0.0 to 1 (0 is maximum transparency, while 1 is lowest)', 'xstore-core' ),
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01
					],
				],
			]
		);

		$control->add_control(
			'banner_color_bg',
			[
				'label' => __( 'Background Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'description' => __( 'Use image opacity option to add overlay effect with background', 'xstore-core' ),
			]
		);

		$control->end_controls_tab();

		$control->start_controls_tab(
			'image_settings_hover',
			[
				'label' => __( 'Hover', 'xstore-core' ),
			]
		);

		$control->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_css_filters_hover',
				'selector' => '{{WRAPPER}} .banner:hover img',
			]
		);

		$control->add_control(
			'image_opacity_on_hover',
			[
				'label' => __( 'Opacity', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'description' => __( 'Enter value between 0.0 to 1 (0 is maximum transparency, while 1 is lowest)', 'xstore-core' ),
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01
					],
				],
			]
		);

		$control->add_control(
			'type_with_diagonal',
			[
				'label' => __( 'With diagonal', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'Image effect with diagonal', 'xstore-core' ),
				'return_value' => 'true',
				'default' => '',
			]
		);

		$control->add_control(
			'type_with_border',
			[
				'label' => __( 'With border animation', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'Image effect with border inside', 'xstore-core' ),
				'return_value' => 'true',
				'default' => '',
			]
		);

		$control->end_controls_tab();

		$control->end_controls_tabs();

		if ( !$repeater ) {
			$control->end_controls_section();
			$control->start_controls_section(
				'button_section',
				[
					'label' => __( 'Button', 'xstore-core' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);
		}

		$control->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        	=> 'button_typography',
				'label' 		=> __( 'Button typography', 'xstore-core' ),
				'selector'    	=> '{{WRAPPER}} .banner-content .button-wrap .banner-button',
				'separator'   	=> 'before',
			]
		);

		$control->start_controls_tabs( 'button_settings' );

		$control->start_controls_tab(
			'button_settings_normal',
			[
				'label' => __( 'Normal', 'xstore-core' ),
			]
		);

		$control->add_control(
			'button_color',
			[
				'label' => __( 'Button Text color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
//				'selectors' => [
//					'{{WRAPPER}} .banner-button' => 'color: {{VALUE}};',
//				],
			]
		);

		$control->add_control(
			'button_bg',
			[
				'label' => __( 'Button background color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
//				'selectors' => [
//					'{{WRAPPER}} .banner-button' => 'background-color: {{VALUE}};',
//				],
			]
		);

		$control->end_controls_tab();

		$control->start_controls_tab(
			'button_settings_hover',
			[
				'label' => __( 'Hover', 'xstore-core' ),
			]
		);

		$control->add_control(
			'button_hover_color',
			[
				'label' => __( 'Button Text color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
//				'selectors' => [
//					'{{WRAPPER}} .banner-button:hover' => 'color: {{VALUE}};',
//				],
			]
		);

		$control->add_control(
			'button_hover_bg',
			[
				'label' => __( 'Button background color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
//				'selectors' => [
//					'{{WRAPPER}} .banner-button:hover' => 'background-color: {{VALUE}};',
//				],
			]
		);

		$control->end_controls_tabs();

		$control->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .banner-content .button-wrap .banner-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$control->add_control(
			'button_paddings',
			[
				'label' => __( 'Button paddings', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .banner-content .button-wrap .banner-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$control->add_control(
			'hide_button_responsive',
			[
				'label' => __( 'Hide button on mobile', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default' => '',
			]
		);

		if ( !$repeater ) {
			$control->end_controls_section();
		}
	}

	/**
	 * get contact for 7 items
	 * @return items
	 */
	function get_contact_form_7() {
		if ( ! function_exists( 'wpcf7' ) ) {
			return array();
		}

		$options = array();

		$args = array(
			'post_type'         => 'wpcf7_contact_form',
			'posts_per_page'    => -1
		);

		$contact_forms = get_posts( $args );

		if ( ! empty( $contact_forms ) && ! is_wp_error( $contact_forms ) ) {

			$i = 0;

			foreach ( $contact_forms as $post ) {	
				if ( $i == 0 ) {
					$options[0] = esc_html__( 'Select a contact form', 'xstore-core' );
				}
				$options[ $post->ID ] = $post->post_title;
				$i++;
			}
		}

		return $options;
	}

}
