<?php
namespace ETC\App\Controllers\Elementor\General;

use ETC\App\Traits\Elementor;
use ETC\App\Controllers\Shortcodes;

/**
 * Testimonials widget.
 *
 * @since      2.1.3
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor
 */
class Testimonials extends \Elementor\Widget_Base {
	
	use Elementor;
	
	/**
	 * Get widget name.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'testimonials';
	}
	
	/**
	 * Get widget title.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Testimonials Widget', 'xstore-core' );
	}
	
	/**
	 * Get widget icon.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eight_theme-elementor-icon et-elementor-testimonials';
	}
	
	/**
	 * Get widget keywords.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'testimonials' ];
	}
	
	/**
	 * Get widget categories.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['eight_theme_general'];
	}
	
	/**
	 * Register Testimonials widget controls.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'settings',
			[
				'label' => __( 'General', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'type',
			[
				'label'         =>  esc_html__( 'Type', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SELECT,
				'options'       =>  [
					'slider'   =>  esc_html__('Slider', 'xstore-core'),
					'grid'  =>  esc_html__('Grid', 'xstore-core'),
				],
				'default'       => 'slider'
			]
		);
		
		$this->add_control(
			'style',
			[
				'label'         =>  esc_html__( 'Style', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SELECT,
				'options'       =>  [
					'style-1'   =>  esc_html__('Style 1', 'xstore-core'),
					'style-2'   =>  esc_html__('Style 2', 'xstore-core'),
					'style-3'   =>  esc_html__('Style 3', 'xstore-core'),
				],
				'default'       => 'style-1'
			]
		);
		
		$this->add_control(
			'image_position',
			[
				'label' 		=>	__( 'Image position', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'xstore-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'xstore-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => __( 'Right', 'xstore-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default'		=> 'top',
			]
		);
		
		$this->add_control(
			'add_shadow',
			[
				'label'         =>  esc_html__( 'Drop-shadow', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SWITCHER,
				'return_value'  =>  'yes',
				'default'       =>  '',
			]
		);
		
		$this->add_control(
			'add_border',
			[
				'label'         =>  esc_html__( 'With border', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SWITCHER,
				'return_value'  =>  'yes',
				'default'       =>  '',
			]
		);
		
		$this->end_controls_section();
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'image', [
				'label' => esc_html__('Image', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		
		$repeater->add_control(
			'rating',
			[
				'label' 		=> esc_html__( 'Show stars', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'' 			=>  esc_html__( 'None', 'xstore-core' ),
					'1'	=>	'1',
					'2'	=>	'2',
					'3'	=>	'3',
					'4'	=>	'4',
					'5'	=>	'5',
				],
				'default' => '4'
			]
		);
		
		$repeater->add_control(
			'name', [
				'label' => esc_html__('Name', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Name', 'xstore-core'),
			]
		);
		
		$repeater->add_control(
			'country', [
				'label' => esc_html__('Country', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Country', 'xstore-core'),
			]
		);
		
		$repeater->add_control(
			'content',
			[
				'label' => __( 'Content', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Some promo words', 'xstore-core' ),
			]
		);
		
		$this->start_controls_section(
			'et_section_tabs_content_settings',
			[
				'label' => esc_html__('Content', 'xstore-core'),
			]
		);
		
		$this->add_control(
			'testimonials_tab',
			[
				'label' => __( 'Testimonial Item', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'name' => esc_html__('Savannah Fox', 'xstore-core'),
						'content' => esc_html('I must say the theme is awesome.
							If somebody bought it just have in mind to correctly configure it and to contact support if facing a problem; support is fast and realiable.
							Thanks!', 'xstore-core'),
						'country' => 'Nauru',
					],
					[
						'name' => esc_html__('Judith Mckinney', 'xstore-core'),
						'content' => esc_html('This is by far the best theme on Themeforest. It adapts to a lot of the plugins, and their customer support is great. I really love this theme! Thanks 8theme.', 'xstore-core'),
						'country' => 'Seychelles',
					],
					[
						'name' => esc_html__('Harold Nguyen', 'xstore-core'),
						'content' => esc_html('As always a 5 star! i bought this theme the third or fourth time so far... really loving it. the new update from 6.0 is awesome', 'xstore-core'),
						'country' => 'Syrian Arab Republic',
					],
				],
				'title_field' => '{{{ name }}}',
				'show_label' => true,
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'sorting_section',
			[
				'label' => esc_html__( 'Order elements', 'xstore-core' ),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'image_order',
			[
				'label'		 =>	esc_html__( 'Image order', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' 		=> [
						'min' 	=> -5,
						'max' 	=> 5,
						'step' 	=> 1
					],
				],
			]
		);
		
		$this->add_control(
			'rating_order',
			[
				'label'		 =>	esc_html__( 'Rating order', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' 		=> [
						'min' 	=> -5,
						'max' 	=> 5,
						'step' 	=> 1
					],
				],
			]
		);
		
		$this->add_control(
			'content_order',
			[
				'label'		 =>	esc_html__( 'Content order', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' 		=> [
						'min' 	=> -5,
						'max' 	=> 5,
						'step' 	=> 1
					],
				],
			]
		);
		
		$this->add_control(
			'name_order',
			[
				'label'		 =>	esc_html__( 'Name order', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' 		=> [
						'min' 	=> -5,
						'max' 	=> 5,
						'step' 	=> 1
					],
				],
			]
		);
		
		$this->add_control(
			'country_order',
			[
				'label'		 =>	esc_html__( 'Country order', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' 		=> [
						'min' 	=> -5,
						'max' 	=> 5,
						'step' 	=> 1
					],
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'slider_settings',
			[
				'label' => esc_html__('Slider Settings', 'xstore-core'),
			]
		);
		
		$this->add_control(
			'slider_spacing',
			[
				'label'		 =>	esc_html__( 'Items spacing', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' 		=> [
						'min' 	=> 0,
						'max' 	=> 100,
						'step' 	=> 1
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
			]
		);
		
		$this->add_control(
			'slider_autoplay',
			[
				'label' 		=> esc_html__( 'Autoplay', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> '',
				'condition'     => ['type' => array( 'slider' ) ]
			]
		);
		
		$this->add_control(
			'slider_stop_on_hover',
			[
				'label' 		=> esc_html__( 'Pause On Hover', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> '',
				'conditions' 	=> [
					'relation' 	=> 'and',
					'terms' 	=> [
						[
							'name' 		=> 'slider_autoplay',
							'operator'  => '=',
							'value' 	=> 'true'
						],
						[
							'name' 		=> 'type',
							'operator'  => '=',
							'value' 	=> 'slider'
						],
					]
				],
			]
		);
		
		$this->add_control(
			'slider_interval',
			[
				'label' 		=> esc_html__( 'Autoplay Speed', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::NUMBER,
				'description' 	=> esc_html__( 'Interval between slides. In milliseconds.', 'xstore-core' ),
				'return_value' 	=> 'true',
				'default' 		=> 3000,
				'conditions' 	=> [
					'relation' 	=> 'and',
					'terms' 	=> [
						[
							'name' 		=> 'slider_autoplay',
							'operator'  => '=',
							'value' 	=> 'true'
						],
						[
							'name' 		=> 'type',
							'operator'  => '=',
							'value' 	=> 'slider'
						],
					]
				],
			]
		);
		
		$this->add_control(
			'slider_loop',
			[
				'label' 		=> esc_html__( 'Infinite Loop', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> 'true',
				'condition'     => ['type' => array( 'slider' ) ]
			]
		);
		
		$this->add_control(
			'slider_speed',
			[
				'label' 		=> esc_html__( 'Transition Speed', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::NUMBER,
				'description' 	=> esc_html__( 'Duration of transition between slides. In milliseconds.', 'xstore-core' ),
				'default' 		=> '300',
				'condition'     => ['type' => array( 'slider' ) ]
			]
		);
		
		$this->add_responsive_control(
			'slides',
			[
				'label' 	=>	esc_html__( 'Slider Items', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::NUMBER,
				'default' 	=>	4,
				'default_tablet' => 3,
				'default_mobile' => 2,
				'min' => 0,
				'condition'     => ['type' => array( 'slider' ) ]
			]
		);
		
		$this->add_control(
			'slider_vertical_align',
			[
				'label' => __( 'Vertical Align', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'flex-start' => [
						'title' => __( 'Start', 'xstore-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'xstore-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __( 'End', 'xstore-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-wrapper' => 'align-items: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'columns',
			[
				'label' 	=>	esc_html__( 'Columns', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::NUMBER,
				'default' 	=>	4,
				'min' => 0,
				'max' => 6,
				'condition'     => ['type' => 'grid' ]
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'slider_content_section',
			[
				'label' => esc_html__( 'Navigation & Pagination', 'xstore-core' ),
				'tab' =>  \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'navigation_header',
			[
				'label' => esc_html__( 'Navigation', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'hide_buttons',
			[
				'label' 		=> esc_html__( 'Show Navigation', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);
		
		$this->add_control(
			'hide_buttons_for',
			[
				'label' 		=> esc_html__( 'Hide Navigation Only For', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'' 			=>  esc_html__( 'Both', 'xstore-core' ),
					'mobile'	=>	esc_html__( 'Mobile', 'xstore-core' ),
					'desktop'	=>	esc_html__( 'Desktop', 'xstore-core' ),
				],
				'condition' => ['hide_buttons' => 'yes']
			]
		);
		
		$this->add_control(
			'navigation_type',
			[
				'label' 		=> esc_html__( 'Navigation Type', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'arrow' 	=>	esc_html__( 'Arrow', 'xstore-core' ),
					'archery' 	=>	esc_html__( 'Archery', 'xstore-core' ),
				],
				'default'	=> 'arrow',
				'condition' => ['hide_buttons' => 'yes']
			]
		);
		
		$this->add_control(
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
				'condition' => ['hide_buttons' => 'yes']
			]
		);
		
		$this->add_control(
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
				'condition' => ['hide_buttons' => 'yes']
			]
		);
		
		$this->add_control(
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
							'value' 	=> 'yes'
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
		
		$this->add_responsive_control(
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
							'value' 	=> 'yes'
						],
					]
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-entry' => '--arrow-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
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
							'value' 	=> 'yes'
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
		
		$this->add_control(
			'pagination_header',
			[
				'label' => esc_html__( 'Pagination', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'pagination_type',
			[
				'label' 		=> esc_html__( 'Pagination Type', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'hide' 		=>	esc_html__( 'Hide', 'xstore-core' ),
					'bullets' 	=>	esc_html__( 'Bullets', 'xstore-core' ),
					'lines' 	=>	esc_html__( 'Lines', 'xstore-core' ),
				],
				'default' 		=> 'hide',
			]
		);
		
		$this->add_control(
			'hide_fo',
			[
				'label' 		=> esc_html__( 'Hide Pagination Only For', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'' 			=>  esc_html__( 'Select option', 'xstore-core' ),
					'mobile'	=>	esc_html__( 'Mobile', 'xstore-core' ),
					'desktop'	=>	esc_html__( 'Desktop', 'xstore-core' ),
				],
				'condition' => ['pagination_type' => ['bullets', 'lines' ]],
			]
		);
		
		$this->start_controls_tabs( 'pagination_color' );
		
		$this->start_controls_tab( 'pagination_color_normal',
			[
				'label' => __( 'Normal', 'xstore-core' ),
				'condition' => ['pagination_type' => ['bullets', 'lines' ]],
			]
		);
		
		$this->add_control(
			'default_color',
			[
				'label' 	=> esc_html__( 'Pagination Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
//				'default' 	=> '#e1e1e1',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}; opacity: 1;',
				],
				'condition' => ['pagination_type' => ['bullets', 'lines' ]],
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'pagination_color_active',
			[
				'label' => __( 'Active', 'xstore-core' ),
				'condition' => ['pagination_type' => ['bullets', 'lines' ]],
			]
		);
		
		$this->add_control(
			'active_color',
			[
				'label' 	=> esc_html__( 'Pagination Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
//				'default' 	=> '#222',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
				],
				'condition' => ['pagination_type' => ['bullets', 'lines' ]],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'element_style_section',
			[
				'label' => esc_html__( 'Item', 'xstore-core' ),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'align',
			[
				'label' 		=>	__( 'Alignment', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'start'    => [
						'title' => __( 'Left', 'xstore-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'xstore-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => __( 'Right', 'xstore-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default'		=> 'start',
			]
		);
		
		$this->add_responsive_control(
			'quotes_size_proportion',
			[
				'label'		 =>	esc_html__( 'Quotes size', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' 		=> [
						'min' 	=> 1,
						'max' 	=> 200,
						'step' 	=> 1
					],
				],
				'condition' => ['style' => ['style-2', 'style-3' ]],
				'selectors' => [
					'{{WRAPPER}} .etheme-testimonials .testimonial' => '--size-quotes-proportion: {{SIZE}};',
				],
			]
		);
		
		$this->add_control(
			'quotes_color',
			[
				'label' => esc_html__('Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'condition' => ['style' => ['style-2', 'style-3' ]],
				'selectors' => [
					'{{WRAPPER}} .etheme-testimonials .quotes' => 'color: {{VALUE}}; opacity: 1;',
				],
			]
		);
		
		$this->add_control(
			'separator_quotes_style',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
		
		$this->add_responsive_control(
			'content_border_radius',
			[
				'label' => __( 'Border Radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '30',
					'right' => '30',
					'bottom' => '30',
					'left' => '30',
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial .content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__('Padding', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .testimonial .content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'content_margin',
			[
				'label' => esc_html__('Margin', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .testimonial .content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'content_bg',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .testimonial .content-wrapper'
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_shadow',
				'selector' => '{{WRAPPER}} .testimonial.with-shadow .content-wrapper',
				'separator' => 'before',
				'condition'     => ['add_shadow' => 'yes' ]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'label' => esc_html__('Border', 'xstore-core'),
				'selector' => '{{WRAPPER}} .testimonial.with-border .content-wrapper',
				'condition'     => ['add_border' => 'yes' ]
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'xstore-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'size',
			[
				'label' 	=>	__( 'Size', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::TEXT,
				'description' => __( 'Enter image size (Ex.: "medium", "large" etc.) or enter size in pixels (Ex.: 200x100 (WxH))', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'image_max_width',
			[
				'label' => __( 'Max-Width', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 300,
						'min' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'separator_panel_image_style',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
		
		$this->start_controls_tabs( 'image_effects' );
		
		$this->start_controls_tab( 'image_normal',
			[
				'label' => __( 'Normal', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'image_opacity',
			[
				'label' => __( 'Opacity', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial img' => 'opacity: {{SIZE}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_css_filters',
				'selector' => '{{WRAPPER}} .testimonial img',
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'image_hover',
			[
				'label' => __( 'Hover', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'image_opacity_hover',
			[
				'label' => __( 'Opacity', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_css_filters_hover',
				'selector' => '{{WRAPPER}} .testimonial:hover img',
			]
		);
		
		$this->add_control(
			'image_background_hover_transition',
			[
				'label' => __( 'Transition Duration', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .testimonial img',
				'separator' => 'before',
			]
		);
		
		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .testimonial img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'rating_style_section',
			[
				'label' => esc_html__( 'Rating', 'xstore-core' ),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'rating_color',
			[
				'label' => esc_html__('Rating Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .star-rating-wrapper .star-rating span:before' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'rating_margin',
			[
				'label' => esc_html__('Margin', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default' => [
                    'top' => 10,
                    'right' => 0,
                    'bottom' => 15,
                    'left' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}} .star-rating-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'content_style_section',
			[
				'label' => esc_html__( 'Content', 'xstore-core' ),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .content',
			]
		);
		
		$this->add_control(
			'content_wrapper_color',
			[
				'label' => esc_html__('Content Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .content' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'content_wrapper_margin',
			[
				'label' => esc_html__('Margin', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 20,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'name_style_section',
			[
				'label' => esc_html__( 'Name', 'xstore-core' ),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'selector' => '{{WRAPPER}} .name',
			]
		);
		
		$this->add_control(
			'name_color',
			[
				'label' => esc_html__('Name Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .name' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'name_margin',
			[
				'label' => esc_html__('Margin', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 10,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'country_style_section',
			[
				'label' => esc_html__( 'Country', 'xstore-core' ),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'country_typography',
				'selector' => '{{WRAPPER}} .country',
			]
		);
		
		$this->add_control(
			'country_color',
			[
				'label' => esc_html__('Country Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .country' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'country_margin',
			[
				'label' => esc_html__('Margin', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .country' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'nav_style_section',
			[
				'label' => esc_html__( 'Navigation & Pagination', 'xstore-core' ),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => ['hide_buttons' => 'yes']
			]
		);
		
		$this->start_controls_tabs('navigation_style_tabs');
		$this->start_controls_tab( 'navigation_style_normal',
			[
				'label' => esc_html__('Normal', 'xstore-core')
			]
		);
		
		$this->add_control(
			'advanced_nav_color',
			[
				'label' 	=> esc_html__( 'Nav Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-entry .swiper-custom-left,
					{{WRAPPER}} .swiper-entry .swiper-custom-right' => 'color: {{VALUE}};',
				]
			]
		);
		
		$this->add_control(
			'advanced_arrows_bg_color',
			[
				'label' 	=> esc_html__( 'Nav Background Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-entry .swiper-custom-left,
					{{WRAPPER}} .swiper-entry .swiper-custom-right' => 'background-color: {{VALUE}};',
				]
			]
		);
		
		$this->add_control(
			'advanced_arrows_border_color',
			[
				'label' 	=> esc_html__( 'Nav Border Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-entry .swiper-custom-left,
					{{WRAPPER}} .swiper-entry .swiper-custom-right' => 'border-color: {{VALUE}};',
				]
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'navigation_style_hover',
			[
				'label' => esc_html__('Hover', 'xstore-core')
			]
		);
		
		$this->add_control(
			'advanced_nav_color_hover',
			[
				'label' 	=> esc_html__( 'Nav Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-entry .swiper-custom-left:hover,
					{{WRAPPER}} .swiper-entry .swiper-custom-right:hover' => 'color: {{VALUE}};',
				]
			]
		);
		
		$this->add_control(
			'advanced_arrows_bg_color_hover',
			[
				'label' 	=> esc_html__( 'Nav Background', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-entry .swiper-custom-left:hover,
					{{WRAPPER}} .swiper-entry .swiper-custom-right:hover' => 'background-color: {{VALUE}};',
				]
			]
		);
		
		$this->add_control(
			'advanced_arrows_br_color_hover',
			[
				'label' 	=> esc_html__( 'Nav Border', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-entry .swiper-custom-left:hover,
					{{WRAPPER}} .swiper-entry .swiper-custom-right:hover' => 'border-color: {{VALUE}};',
				]
			]
		);
		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->end_controls_section();
	}
	
	/**
	 * Render Testimonials widget output on the frontend.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		
		if ( $settings['testimonials_tab'] ) {
			
			if ( function_exists('etheme_enqueue_style')) {
				etheme_enqueue_style( 'elementor-testimonials', true );
			}
			
			$box_id      = rand( 1000, 10000 );
			
			$item_class = $settings['image_position'] == 'top' ? 'layout-grid' : 'layout-list';
			$item_class .= $settings['type'] == 'slider' ? '' : ' ' . str_replace('col-xs-6', 'col-xs-12', etheme_get_product_class( $settings['columns'] ) );
			$item_class .= ' ' . $settings['style'];
			if ( $settings['add_shadow'] )
				$item_class .= ' with-shadow';
			if ( $settings['add_border'])
				$item_class .= ' with-border';
			
			$sorting = array();
			$sorting[] = array('type' => 'image', 'order' => $settings['image_order']['size']);
			$sorting[] = array('type' => 'rating', 'order' => $settings['rating_order']['size']);
			$sorting[] = array('type' => 'content', 'order' => $settings['content_order']['size']);
			$sorting[] = array('type' => 'name', 'order' => $settings['name_order']['size']);
			$sorting[] = array('type' => 'country', 'order' => $settings['country_order']['size']);
			
			usort($sorting, function ($item1, $item2) {
				return $item1['order'] <=> $item2['order'];
			});
			
			?>
            <div class="etheme-testimonials clearfix <?php echo $settings['navigation_position'] . ' ' . $settings['navigation_position_style'] . ' columns-' . $settings['columns'];  ?>" data-type="<?php echo $settings['type']; ?>">
				
				<?php if ( $settings['type'] == 'slider') :
    
				$settings['slides_mobile'] = empty($settings['slides_mobile']) ? 2 : $settings['slides_mobile'];
				$settings['slides_tablet'] = empty($settings['slides_tablet']) ? 3 : $settings['slides_tablet'];
				$settings['slides'] = empty($settings['slides']) ? 4 : $settings['slides'];
				
				?>

                <div class="swiper-entry">
                    <div
                            class="swiper-container <?php echo ($settings['slider_stop_on_hover']) ? 'stop-on-hover' : ''; ?> slider-<?php echo esc_attr($box_id); echo ( $settings['pagination_type'] == 'lines' ) ? ' swiper-pagination-lines' : '';?>"
                            data-breakpoints="1"
                            data-xs-slides="<?php echo esc_js( $settings['slides_mobile'] ); ?>"
                            data-sm-slides="<?php echo esc_js( $settings['slides_tablet'] ); ?>"
                            data-md-slides="<?php echo esc_js( $settings['slides'] ); ?>"
                            data-lt-slides="<?php echo esc_js( $settings['slides'] ); ?>"
                            data-slides-per-view="<?php echo esc_js( $settings['slides'] ); ?>"
                            data-slides-per-group="<?php echo esc_attr( 1 ); ?>"
						<?php if ( $settings['slider_autoplay']) : ?>
                            data-autoplay="<?php echo esc_attr( $settings['slider_interval'] ); ?>"
						<?php endif; ?>
                            data-speed="<?php echo esc_js($settings['slider_speed']); ?>"
						<?php if ( $settings['slider_loop']) : ?>
                            data-loop="true"
						<?php endif; ?>
                        data-space="<?php echo $settings['slider_spacing']['size']; ?>"
                    >

                        <div class="swiper-wrapper">
							
							<?php endif; ?>
							
							<?php
							
							foreach (  $settings['testimonials_tab'] as $item ) {
								
								$elements = array();
								
								ob_start(); ?>
                                <svg class="quotes" width=".75em" height=".62em" viewBox="0 0 75 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M58.5 61.8C53.9 61.8 50 60.1 46.8 56.7C43.6 53.1 42 48.3 42 42.3C42 33.7 43.3 26.7 45.9 21.3C48.5 15.7 51.4 11.3 54.6 8.09999C58.2 4.49999 62.5 1.79999 67.5 -1.14441e-05L70.5 4.8C67.1 6.39999 64.1 8.29999 61.5 10.5C59.3 12.5 57.2 14.9 55.2 17.7C53.4 20.3 52.5 23.5 52.5 27.3C52.5 28.7 52.7 29.8 53.1 30.6C53.3 31.2 53.6 31.6 54 31.8C54.4 31.6 55 31.4 55.8 31.2C56.4 31 57 30.8 57.6 30.6C58.4 30.4 59.2 30.3 60 30.3C64.6 30.3 68.2 31.7 70.8 34.5C73.6 37.1 75 40.7 75 45.3C75 49.9 73.4 53.8 70.2 57C67 60.2 63.1 61.8 58.5 61.8ZM16.5 61.8C11.9 61.8 8 60.1 4.8 56.7C1.6 53.1 8.49366e-07 48.3 8.49366e-07 42.3C8.49366e-07 33.7 1.3 26.7 3.9 21.3C6.5 15.7 9.4 11.3 12.6 8.09999C16.2 4.49999 20.5 1.79999 25.5 -1.14441e-05L28.5 4.8C25.1 6.39999 22.1 8.29999 19.5 10.5C17.3 12.5 15.2 14.9 13.2 17.7C11.4 20.3 10.5 23.5 10.5 27.3C10.5 28.7 10.7 29.8 11.1 30.6C11.3 31.2 11.6 31.6 12 31.8C12.4 31.6 13 31.4 13.8 31.2C14.4 31 15 30.8 15.6 30.6C16.4 30.4 17.2 30.3 18 30.3C22.6 30.3 26.2 31.7 28.8 34.5C31.6 37.1 33 40.7 33 45.3C33 49.9 31.4 53.8 28.2 57C25 60.2 21.1 61.8 16.5 61.8Z" fill="currentColor"></path>
                                </svg>
								<?php
								$elements['quotes'] = ob_get_clean();
								
								ob_start();
								if ( $item['rating'] ) : ?>
                                    <span class="star-rating-wrapper"><span class="star-rating"><span style="width: <?php echo ( ( $item['rating'] / 5 ) * 100 ) . '%'; ?>"></span></span></span>
								<?php endif;
								$elements['rating'] = ob_get_clean();
								
								ob_start();
								if ( $item['name'] != '' ) : ?>
                                    <span class="name"><?php echo $item['name']; ?></span>
								<?php
								endif;
								$elements['name'] = ob_get_clean();
								
								ob_start();
								if ( $item['content'] != '' ) : ?>
                                    <span class="content"><?php echo (( $settings['style'] == 'style-2') ? $elements['quotes'] : '') . $item['content']; ?></span>
								<?php endif; ?>
								<?php $elements['content'] = ob_get_clean();
								
								ob_start();
								if ( $item['country'] != '' ) : ?>
                                    <span class="country"><?php echo $item['country']; ?></span>
								<?php endif; ?>
								<?php $elements['country'] = ob_get_clean();
								
								ob_start();
								if ( $settings['style'] != 'style-3' ) {
									if ( isset( $item['image']['url'] ) && $item['image']['url'] != '' ) {
										if ( $settings['image_position'] == 'top' ) {
											echo '<span>';
										}
										if ( $item['image']['id'] != '' )
										    echo function_exists('etheme_get_image') ? etheme_get_image( $item['image']['id'], $settings['size'] ) : '';
										elseif ( $item['image']['url'] != '' )
											echo '<img src="'.$item['image']['url'].'">';
										if ( $settings['image_position'] == 'top' ) {
											echo '</span>';
										}
									}
								}
								$elements['image'] = ob_get_clean();
								
								if ( $settings['type'] == 'slider') {
									echo '<div class="swiper-slide">';
								}
								
								?>
                                <div class="testimonial <?php echo $item_class; ?>">

                                    <div class="content-wrapper <?php echo ' justify-content-' . $settings['align']; ?>">
										
										<?php if ( $settings['image_position'] == 'left' ) {
											echo $elements['image'];
										}
										
										if ( $settings['style'] == 'style-3') :
											echo $elements['quotes'];
										endif; ?>

                                        <div class="inner-content">
											
											<?php foreach ($sorting as $sorting_item) {
												if ( $sorting_item['type'] == 'image' && in_array($settings['image_position'], array('left', 'right')) ) continue;
												echo $elements[$sorting_item['type']];
											} ?>

                                        </div>
										
										<?php if ( $settings['image_position'] == 'right' ) {
											echo $elements['image'];
										} ?>

                                    </div>

                                </div>
								
								<?php if ( $settings['type'] == 'slider') {
									echo '</div>';
								} ?>
							
							<?php } ?>
							
							<?php if ( $settings['type'] == 'slider') : ?>
                        </div><!-- swiper-wrapper -->
						<?php
						if ( $settings['pagination_type'] != 'hide' ) {
							$pagination_class = '';
							if ( $settings['hide_fo'] == 'desktop' )
								$pagination_class = ' dt-hide';
                            elseif ( $settings['hide_fo'] == 'mobile' )
								$pagination_class = ' mob-hide';
							
							echo '<div class="swiper-pagination '.$pagination_class.'"></div>';
							
						}
						?>
                    </div><!-- swiper-container -->
					<?php
					if ( $settings['hide_buttons'] || ( !$settings['hide_buttons'] && $settings['hide_buttons_for'] != '' ) ) {
						$navigation_class = 'et-swiper-elementor-nav';
						if ( $settings['hide_buttons_for'] == 'desktop' )
							$navigation_class = ' dt-hide';
                        elseif ( $settings['hide_buttons_for'] == 'mobile' )
							$navigation_class = ' mob-hide';
						
						$navigation_class_left  = 'swiper-custom-left' . ' ' . $navigation_class;
						$navigation_class_right = 'swiper-custom-right' . ' ' . $navigation_class;
						
						$navigation_class_left .= ' type-' . $settings['navigation_type'] . ' ' . $settings['navigation_style'];
						$navigation_class_right .= ' type-' . $settings['navigation_type'] . ' ' . $settings['navigation_style'];
						
						if ( $settings['navigation_position'] == 'bottom' )
							echo '<div class="swiper-navigation">';
						?>
                        <div class="swiper-button-prev <?php echo $navigation_class_left; ?>"></div>
                        <div class="swiper-button-next <?php echo $navigation_class_right; ?>"></div>
						<?php
						if ( $settings['navigation_position'] == 'bottom' )
							echo '</div>';
					} ?>

                </div><div class="clear"></div><!-- slider-entry -->
			<?php endif; ?>

            </div>
		<?php }
		
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			echo Shortcodes::initPreviewJs();
		}
		
	}
	
}
