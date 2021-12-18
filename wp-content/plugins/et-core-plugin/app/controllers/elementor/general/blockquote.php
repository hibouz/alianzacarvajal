<?php
namespace ETC\App\Controllers\Elementor\General;

use ETC\App\Traits\Elementor;
use ETC\App\Controllers\Shortcodes;

/**
 * Text button widget.
 *
 * @since      4.0.5
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor/General
 */
class Blockquote extends \Elementor\Widget_Base {
	
	/**
	 * Get widget name.
	 *
	 * @since 4.0.5
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'blockquote';
	}
	
	/**
	 * Get widget title.
	 *
	 * @since 4.0.5
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Blockquote', 'xstore-core' );
	}
	
	/**
	 * Get widget icon.
	 *
	 * @since 4.0.5
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eight_theme-elementor-icon et-elementor-blockquote';
	}
	
	/**
	 * Get widget keywords.
	 *
	 * @since 4.0.5
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'block', 'quote', 'blockquote' ];
	}
	
	/**
	 * Get widget categories.
	 *
	 * @since 4.0.5
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['eight_theme_general'];
	}
	
	/**
	 * Register Blockquote widget controls.
	 *
	 * @since 4.0.5
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'type',
			[
				'label' 		=>	__( 'Type', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'grid'	=>	__('Grid', 'xstore-core'),
					'slider'	=>	__('Slider', 'xstore-core'),
				],
				'default'	  => 'grid',
			]
		);
		
		$this->add_control(
			'style',
			[
				'label' 		=>	__( 'Style', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'default'	=>	__('Classic', 'xstore-core'),
					'border_top'	=>	__('Border top', 'xstore-core'),
					'border_left'	=>	__('Border left', 'xstore-core'),
				],
				'default'	  => 'default',
			]
		);
		
		$this->add_control(
			'align',
			[
				'label' => __( 'Alignment', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
				'prefix_class' => 'elementor-align-',
				'default' => '',
			]
		);
		
		$this->start_controls_tabs( 'style_border' );
		
		$this->start_controls_tab( 'style_border_normal',
			[
				'label' => __( 'Normal', 'xstore-core' ),
				'condition' => ['style' => ['border_top', 'border_left' ]],
			]
		);
		$this->add_control(
			'style_border_width',
			[
				'label' => __( 'Main Border width', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 30,
					],
				],
				'default' => [
                    'unit' => 'px',
                    'size' => 7
                ],
				'selectors' => [
					'{{WRAPPER}} .style-border_left .etheme-blockquote' => 'border-left-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .style-border_top .etheme-blockquote' => 'border-top-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .style-border_top.quote-top .quotes' => 'margin-top: calc(-{{SIZE}}{{UNIT}} / 2);',
				],
				'condition' => ['style' => ['border_top', 'border_left' ]],
			]
		);
		
		$this->add_control(
			'style_border_color',
			[
				'label' 	=> esc_html__( 'Main Border Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .style-border_left .etheme-blockquote ' => 'border-left-color: {{VALUE}};',
					'{{WRAPPER}} .style-border_top .etheme-blockquote' => 'border-top-color: {{VALUE}};',
				],
				'condition' => ['style' => ['border_top', 'border_left' ]],
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'style_border_hover',
			[
				'label' => __( 'Hover', 'xstore-core' ),
                'condition' => ['style' => ['border_top', 'border_left' ]],
			]
		);
		
		$this->add_control(
			'style_border_width_hover',
			[
				'label' => __( 'Main Border width', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .style-border_left .etheme-blockquote:hover' => 'border-left-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .style-border_top .etheme-blockquote:hover' => 'border-top-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .style-border_top.quote-top .etheme-blockquote:hover .quotes' => 'margin-top: calc(-{{SIZE}}{{UNIT}} / 2);',
				],
				'condition' => ['style' => ['border_top', 'border_left' ]],
			]
		);
		
		$this->add_control(
			'style_border_color_hover',
			[
				'label' 	=> esc_html__( 'Main Border Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .style-border_left .etheme-blockquote:hover' => 'border-left-color: {{VALUE}};',
					'{{WRAPPER}} .style-border_top .etheme-blockquote:hover' => 'border-top-color: {{VALUE}};',
				],
				'condition' => ['style' => ['border_top', 'border_left' ]],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->add_control(
			'quote_position',
			[
				'label' 		=>	__( 'Icon position', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'separator' => 'before',
				'options' 		=>	[
					'above_content'	=>	__('Before content', 'xstore-core'),
					'under_content'	=>	__('After content', 'xstore-core'),
					'top'	=>	__('Absolute Top', 'xstore-core'),
				],
				'default'	  => 'above_content',
			]
		);
		
		$this->add_control(
			'custom_quote_icon',
			[
				'label' 		=> esc_html__( 'Custom icon', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'yes',
				'default' 		=> '',
			]
		);
		
		$this->add_control(
			'selected_icon',
			[
				'label' => __( 'Icon', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin' => 'inline',
				'label_block' => false,
				'condition' => ['custom_quote_icon' => ['yes']],
			]
		);
		
		$this->add_control(
			'quote_proportion',
			[
				'label'		 =>	esc_html__( 'Icon size', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' 		=> [
						'min' 	=> 0,
						'max' 	=> 50,
						'step' 	=> 1
					],
					'em' 		=> [
						'min' 	=> 0,
						'max' 	=> 10,
						'step' 	=> .1
					],
				],
				'default' => [
					'unit' => 'em',
//					'size' => 1.3,
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-blockquotes-wrapper' => '--quote-proportion: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'quote_min_dimensions',
			[
				'label'		 =>	esc_html__( 'Icon min-width/min-height', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' 		=> [
						'min' 	=> 0,
						'max' 	=> 50,
						'step' 	=> 1
					],
					'em' 		=> [
						'min' 	=> 0,
						'max' 	=> 10,
						'step' 	=> .1
					],
				],
				'default' => [
					'unit' => 'em',
//					'size' => .4,
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-blockquotes-wrapper' => '--quote-min-dimensions: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'author',
			[
				'label' 		=>	__( 'Author', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::TEXT,
				'default' => __( 'Author', 'xstore-core' ),
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
			'button_text',
			[
				'label' => __( 'Text', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Click here', 'xstore-core' ),
				'placeholder' => __( 'Click here', 'xstore-core' ),
			]
		);
		
		$repeater->add_control(
			'button_link',
			[
				'label' => __( 'Link', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'xstore-core' ),
				'default' => [
					'url' => '#',
				],
			]
		);
		
		$this->start_controls_section(
			'content_settings',
			[
				'label' => esc_html__('Content', 'xstore-core'),
			]
		);
		
		$this->add_control(
			'blockquote_item',
			[
				'label' => __( 'Blockquote Item', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'author' => 'Judith Flores',
						'content' => 'Tortor, eget erat ac molestie lacus pretium nulla. Leo ante lectus a non velit venenatis. Est commodo a amet dignissim congue eu tellus id duis. Laoreet ac, ut urna, consectetur.',
                        'button_text' => ''
					],
					[
						'author' => 'Judith Flores',
						'content' => 'Tortor, eget erat ac molestie lacus pretium nulla. Leo ante lectus a non velit venenatis. Est commodo a amet dignissim congue eu tellus id duis. Laoreet ac, ut urna, consectetur.',
						'button_text' => ''
					],
				],
				'title_field' => '{{{ author }}}',
				'show_label' => true,
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'slider_settings',
			[
				'label' => esc_html__('Slider Settings', 'xstore-core'),
				'condition' => ['type' => ['slider']],
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
			'slides_inner_spacing',
			[
				'label'		 =>	esc_html__( 'Slides inner spacing', 'xstore-core' ),
				'description' => esc_html__('May be usefull with combination of box-shadow option', 'xstore-core'),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' 		=> [
						'min' 	=> 0,
						'max' 	=> 100,
						'step' 	=> 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide' => 'padding: {{SIZE}}{{UNIT}};',
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
			]
		);
		
		$this->add_control(
			'slider_speed',
			[
				'label' 		=> esc_html__( 'Transition Speed', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::NUMBER,
				'description' 	=> esc_html__( 'Duration of transition between slides. In milliseconds.', 'xstore-core' ),
				'default' 		=> '300',
			]
		);
		
		$this->add_responsive_control(
			'slides',
			[
				'label' 	=>	esc_html__( 'Slider Items', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::NUMBER,
				'default' 	=>	3,
				'default_tablet' => 3,
				'default_mobile' => 2,
				'min' => 1,
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
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'slider_content_section',
			[
				'label' => esc_html__( 'Navigation & Pagination', 'xstore-core' ),
				'tab' =>  \Elementor\Controls_Manager::TAB_CONTENT,
				'condition'     => ['type' => array( 'slider' ) ]
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
			'show_navigation',
			[
				'label' 		=> esc_html__( 'Show Navigation', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);
		
		$this->add_control(
			'show_navigation_for',
			[
				'label' 		=> esc_html__( 'Show Navigation Only For', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'' 			=>  esc_html__( 'Both', 'xstore-core' ),
					'mobile'	=>	esc_html__( 'Mobile', 'xstore-core' ),
					'desktop'	=>	esc_html__( 'Desktop', 'xstore-core' ),
				],
				'condition' => ['show_navigation' => 'yes']
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
				'condition' => ['show_navigation' => 'yes']
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
				'condition' => ['show_navigation' => 'yes']
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
				'condition' => ['show_navigation' => 'yes']
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
							'name' 		=> 'show_navigation',
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
							'name' 		=> 'show_navigation',
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
							'name' 		=> 'show_navigation',
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
			'show_pagination_for',
			[
				'label' 		=> esc_html__( 'Show Pagination Only For', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'' 			=>  esc_html__( 'Both', 'xstore-core' ),
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
			'style_section',
			[
				'label' => esc_html__( 'Blockquote', 'xstore-core' ),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .etheme-blockquote',
			]
		);
		
		$this->add_control(
			'content_gap',
			[
				'label' => __( 'Content Gap', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .etheme-blockquote' => '--gap-inner: {{SIZE}}{{UNIT}}',
				],
			]
		);
		
		$this->add_control(
			'color',
			[
				'label' => esc_html__('Content Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .etheme-blockquote' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .etheme-blockquote'
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'shadow',
				'selector' => '{{WRAPPER}} .etheme-blockquote',
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__('Border', 'xstore-core'),
				'selector' => '{{WRAPPER}} .etheme-blockquote',
			]
		);
		
		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__('Padding', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default' => [
					'top' => 15,
					'right' => 15,
					'bottom' => 15,
					'left' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-blockquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'border_radius',
			[
				'label'		 =>	esc_html__( 'Border radius', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' 		=> [
						'min' 	=> 0,
						'max' 	=> 100,
						'step' 	=> 1
					],
					'em' 		=> [
						'min' 	=> 0,
						'max' 	=> 30,
						'step' 	=> .1
					],
					'%' 		=> [
						'min' 	=> 0,
						'max' 	=> 100,
						'step' 	=> 1
					],
				],
				'default' => [
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-blockquote' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'style_quote_section',
			[
				'label' => esc_html__( 'Icon', 'xstore-core' ),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'quote_color',
			[
				'label' => esc_html__('Icon Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quotes' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'quote_bg_color',
			[
				'label' => esc_html__('Icon Background Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'default' => '#e1e1e1',
				'selectors' => [
					'{{WRAPPER}} .quotes' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'quote_spacing',
			[
				'label'		 =>	esc_html__( 'Icon space', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' 		=> [
						'min' 	=> 0,
						'max' 	=> 50,
						'step' 	=> 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .quote-above_content .quotes' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .quote-top .blockquote-content' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['quote_position' => ['above_content', 'top']],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'style_author_section',
			[
				'label' => esc_html__( 'Author', 'xstore-core' ),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'author_color',
			[
				'label' => esc_html__('Text Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .author' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'author_typography',
				'selector' => '{{WRAPPER}} .author',
			]
		);
		
		$this->end_controls_section();
		
	}
	
	/**
	 * Render blockquote widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		
		if ( function_exists( 'etheme_enqueue_style' ) )
			etheme_enqueue_style( 'etheme-blockquote', true );
		
		$settings = $this->get_settings_for_display();
		
		$this->add_render_attribute( 'main_wrapper', 'class', 'etheme-blockquotes-wrapper' );
		
		if ( $settings['style'] != 'default' ) {
		    $this->add_render_attribute( 'main_wrapper', 'class', 'style-'.$settings['style'] );
		}
		
		$this->add_render_attribute( 'main_wrapper', 'class', 'quote-'.$settings['quote_position'] );
		
		if ( $settings['type'] == 'slider' ) {
            $this->add_render_attribute( 'main_wrapper', 'class', $settings['navigation_position'] );
            $this->add_render_attribute( 'main_wrapper', 'class', $settings['navigation_position_style'] );
		}
		
		$this->add_render_attribute( 'wrapper', 'class', 'etheme-blockquote' );
		
		$this->add_render_attribute( 'content', 'class', 'blockquote-content' );
		$slides = $slides_tablet = $slides_mobile = $settings['slides'];
		if ( isset($settings['slides_mobile']) ) {
		    $slides_mobile = $settings['slides_mobile'];
		}
		if ( isset($settings['slides_tablet']) ) {
		    $slides_tablet = $settings['slides_tablet'];
		}
		
		if ( count($settings['blockquote_item']) ) {
		    echo '<div ' . $this->get_render_attribute_string( 'main_wrapper' ). '>';
		    if ( $settings['type'] == 'slider' ) {
		        ?>
		        <div class="swiper-entry">
                    <div class="swiper-container <?php echo ($settings['slider_stop_on_hover']) ? 'stop-on-hover' : ''; echo ( $settings['pagination_type'] == 'lines' ) ? ' swiper-pagination-lines' : '';?>"
                            data-breakpoints="1"
                            data-xs-slides="<?php echo esc_js( $slides_mobile ); ?>"
                            data-sm-slides="<?php echo esc_js( $slides_tablet ); ?>"
                            data-md-slides="<?php echo esc_js( $slides ); ?>"
                            data-lt-slides="<?php echo esc_js( $slides ); ?>"
                            data-slides-per-view="<?php echo esc_js( $slides ); ?>"
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
            <?php }
                foreach ( $settings['blockquote_item'] as $item ) :
                if ( $settings['type'] == 'slider' ) {
                    echo '<div class="swiper-slide">';
                }
                ?>
                    <blockquote <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
                        <?php
                            if ( $settings['quote_position'] != 'under_content' ) {
                                $this->render_quote_icon($settings);
                            }
                        ?>
                        <p <?php echo $this->get_render_attribute_string( 'content' ); ?>>
                            <?php echo $item['content']; ?>
                        </p>
                        <?php if ( $item['button_text'] || $item['author'] || $settings['quote_position'] == 'under_content') : ?>
                            <footer>
                               <?php
                                    if ( $settings['quote_position'] == 'under_content' || $item['author'] ) : ?>
                                        <div class="author-wrapper">
                                            <?php
                                            if ( $settings['quote_position'] == 'under_content' ) {
                                                $this->render_quote_icon($settings);
                                            }
                                            if ( $item['author'] ) {
                                                echo '<span class="author">'.$item['author'].'</span>';
                                            } ?>
                                        </div>
                                    <?php endif;
                                    if ( $item['button_text'] ) {
                                        if ( ! empty( $item['button_link']['url'] ) ) {
                                            $this->add_link_attributes( 'button', $item['button_link'] );
                                        }
                                        $this->add_render_attribute( 'button', 'class', 'elementor-button' );
                                        $this->add_render_attribute( 'button', 'role', 'button' );
                                        ?>
                                        <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
                                            <?php echo $item['button_text']; ?>
                                        </a>
                                    <?php } ?>
                            </footer>
                        <?php endif; ?>
                    </blockquote>
                <?php
                if ( $settings['type'] == 'slider' ) {
                    echo '</div>'; // .swiper-slide
                }
                endforeach;
                if ( $settings['type'] == 'slider' ) {
                    echo '</div>'; // .swiper-wrapper
                    
                    if ( $settings['pagination_type'] != 'hide' ) {
                        $pagination_class = '';
                        if ( $settings['show_pagination_for'] == 'desktop' ) {
                            $pagination_class = ' mob-hide';
                        }
                        elseif ( $settings['show_pagination_for'] == 'mobile' ) {
                            $pagination_class = ' dt-hide';
                        }
                        
                        echo '<div class="swiper-pagination '.$pagination_class.'"></div>';
                        
                    }
                    
                echo '</div>'; // .swiper-container
                
                if ( $settings['show_navigation'] ) {
                    $navigation_class = 'et-swiper-elementor-nav';
                    if ( $settings['show_navigation_for'] == 'desktop' )
                        $navigation_class = ' mob-hide';
                    elseif ( $settings['show_navigation_for'] == 'mobile' )
                        $navigation_class = ' dt-hide';
                    
                    $navigation_class_left  = 'swiper-custom-left ' . $navigation_class;
                    $navigation_class_right = 'swiper-custom-right ' . $navigation_class;
                    
                    $navigation_class_left .= ' type-' . $settings['navigation_type'] . ' ' . $settings['navigation_style'];
                    $navigation_class_right .= ' type-' . $settings['navigation_type'] . ' ' . $settings['navigation_style'];
                    
                    if ( $settings['navigation_position'] == 'bottom' ) {
                        echo '<div class="swiper-navigation">';
                    } ?>
                    
                    <div class="swiper-button-prev <?php echo $navigation_class_left; ?>"></div>
                    <div class="swiper-button-next <?php echo $navigation_class_right; ?>"></div>
                    
                    <?php if ( $settings['navigation_position'] == 'bottom' ) {
                        echo '</div>'; // swiper-navigation
                    }
                    
                }
            
            echo '</div>'; // .swiper-entry
            
            } // endif $settings['type'] == 'slider'
            
            echo '</div>'; // .etheme-blockquotes-wrapper
        }
		
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			echo Shortcodes::initPreviewJs();
		}
	}
	
	public function render_quote_icon($settings) {
	    ?>
	    
	    <?php if ( $settings['custom_quote_icon'] ) :
	            if (! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
	            <span class="quotes">
                    <span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
                        <?php
                            \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                        ?>
                    </span>
                </span>
                <?php endif;
			else: ?>
			<span class="quotes">
                <svg width="1em" height="1em" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.15905 15.084C3.98571 15.084 2.97371 14.6587 2.12305 13.808C1.27238 12.9573 0.847045 11.9453 0.847045 10.772C0.847045 10.508 0.891045 10.2147 0.979045 9.892C1.06705 9.56933 1.16971 9.232 1.28705 8.88L4.49905 0.607998H8.45905L6.12705 6.636C7.06571 6.84133 7.84305 7.32533 8.45905 8.088C9.10438 8.85067 9.42705 9.74533 9.42705 10.772C9.42705 11.9453 9.00171 12.9573 8.15105 13.808C7.32971 14.6587 6.33238 15.084 5.15905 15.084ZM14.883 15.084C13.7097 15.084 12.6977 14.6587 11.847 13.808C11.0257 12.9573 10.615 11.9453 10.615 10.772C10.615 10.508 10.6444 10.244 10.703 9.98C10.7617 9.716 10.835 9.46667 10.923 9.232L14.223 0.607998H18.227L15.851 6.636C16.7897 6.84133 17.567 7.32533 18.183 8.088C18.8284 8.85067 19.151 9.74533 19.151 10.772C19.151 11.9453 18.7404 12.9573 17.919 13.808C17.0977 14.6587 16.0857 15.084 14.883 15.084Z" fill="currentColor"></path>
                </svg>
            </span>
			<?php endif; ?>
        <?php
	}
	
}
