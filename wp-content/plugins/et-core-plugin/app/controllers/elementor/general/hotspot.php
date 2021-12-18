<?php
namespace ETC\App\Controllers\Elementor\General;

/**
 * Animated Headline widget.
 *
 * @since      4.0.6
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor/General
 */
class HotSpot extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 4.0.6
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'etheme_hotspot';
	}
	
	/**
	 * Get widget title.
	 *
	 * @since 4.0.6
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Hotspot', 'xstore-core' );
	}
	
	/**
	 * Get widget icon.
	 *
	 * @since 4.0.6
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eight_theme-elementor-icon et-elementor-hotspot';
	}
	
	/**
	 * Get widget keywords.
	 *
	 * @since 4.0.6
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'hotspot', 'image', 'tooltip', 'CTA', 'dot' ];
	}
	
	/**
	 * Get widget categories.
	 *
	 * @since 4.0.6
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['eight_theme_general'];
	}
	
	/**
	 * Register Title With Text widget controls.
	 *
	 * @since 4.0.6
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
			]
		);
		
		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'xstore-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'xstore-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'xstore-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		/**
		 * Section Hotspot
		 */
		$this->start_controls_section(
			'hotspot_section',
			[
				'label' => __( 'Hotspot', 'xstore-core' ),
			]
		);
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->start_controls_tabs( 'hotspot_repeater' );
		
		$repeater->start_controls_tab(
			'hotspot_content_tab',
			[
				'label' => __( 'Content', 'xstore-core' ),
			]
		);
		
		$repeater->add_control(
			'hotspot_label',
			[
				'label' => __( 'Label', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'hotspot_link',
			[
				'label' => __( 'Link', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'xstore-core' ),
			]
		);
		
		$repeater->add_control(
			'hotspot_icon',
			[
				'label' => __( 'Icon', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
			]
		);
		
		$repeater->add_control(
			'hotspot_icon_position',
			[
				'label' => __( 'Icon Position', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Icon Left', 'xstore-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Icon Right', 'xstore-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'condition' => [
					'hotspot_icon[value]!' => '',
					'hotspot_label!' => '',
				],
				'default' => 'left',
			]
		);
		
		$repeater->add_control(
			'hotspot_icon_spacing',
			[
				'label' => __( 'Icon Spacing', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '5',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' =>
						'--icon-space: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'hotspot_icon[value]!' => '',
					'hotspot_label!' => '',
				],
			]
		);
		
		$repeater->add_control(
			'hotspot_custom_size',
			[
				'label' => __( 'Custom Hotspot Size', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
				'description' => __( 'Set custom Hotspot size that will only affect this specific hotspot.', 'xstore-core' ),
			]
		);
		
		$repeater->add_control(
            'hotspot_width',
            [
				'label' => __( 'Min Width', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--hotspot-min-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'hotspot_custom_size' => 'yes',
				],
			]
		);
		
		$repeater->add_control(
			'hotspot_height',
			[
				'label' => __( 'Min Height', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--hotspot-min-height: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'hotspot_custom_size' => 'yes',
				],
			]
		);
		
		$repeater->add_control(
			'hotspot_tooltip_content_type',
			[
				'label' => __( 'Content type', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'product' => __( 'Product', 'xstore-core' ),
//					'post' => __( 'Post', 'xstore-core' ),
					'custom' => __( 'Custom', 'xstore-core' ),
					'' => __( 'None', 'xstore-core' ),
				],
				'default' => 'custom',
				'separator' => 'before',
			]
		);
		
		$repeater->add_control(
			'product_id',
			[
				'label' 		=> __( 'Product ID', 'xstore-core' ),
				'label_block' 	=> true,
				'type' 			=> 'etheme-ajax-product',
				'multiple' 		=> false,
				'placeholder' 	=> esc_html__('Enter product title', 'xstore-core'),
				'data_options' 	=> [
					'post_type' => array( 'product_variation', 'product' ),
				],
				'condition' => [
					'hotspot_tooltip_content_type' => 'product'
				]
			]
		);
		
		$repeater->add_control(
			'hotspot_tooltip_image',
			[
				'label' => esc_html__( 'Choose Image', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'hotspot_tooltip_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
			]
		);
		
		$repeater->add_control(
			'hotspot_tooltip_title',
			[
				'render_type' => 'template',
				'label' => __( 'Tooltip Title', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'The title', 'xstore-core' ),
				'condition' => [
					'hotspot_tooltip_content_type' => 'custom'
				]
			]
		);
		
		$repeater->add_control(
			'hotspot_tooltip_content',
			[
				'render_type' => 'template',
				'label' => __( 'Tooltip Content', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Add Your Tooltip Text Here', 'xstore-core' ),
                'condition' => [
                    'hotspot_tooltip_content_type' => 'custom'
                ]
			]
		);
		
		$repeater->add_control(
			'hotspot_tooltip_button',
			[
				'label' => __( 'Button Text', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'hotspot_tooltip_content_type' => 'custom'
				]
			]
		);
		
		$repeater->add_control(
			'hotspot_tooltip_button_link',
			[
				'label' => __( 'Link', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'xstore-core' ),
				'default' => [
					'url' => '#',
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'hotspot_tooltip_content_type' => 'custom',
					'hotspot_tooltip_button!' => ''
				]
			]
		);
		
		$repeater->end_controls_tab();
		
		$repeater->start_controls_tab(
			'hotspot_tooltip_position_tab',
			[
				'label' => __( 'Position', 'xstore-core' ),
			]
		);
		
//		$repeater->add_control(
//			'hotspot_horizontal',
//			[
//				'label' => __( 'Horizontal Orientation', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::CHOOSE,
//				'default' => 'left',
//				'options' => [
//					'left' => [
//						'title' => __( 'Left', 'xstore-core' ),
//						'icon' => 'eicon-h-align-left',
//					],
//					'right' => [
//						'title' => __( 'Right', 'xstore-core' ),
//						'icon' => 'eicon-h-align-right',
//					],
//				],
//				'toggle' => false,
//			]
//		);
		
		$repeater->add_responsive_control(
			'hotspot_offset_x',
			[
				'label' => __( 'Offset X', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => '50',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--hotspot-x: {{SIZE}}%;',
				],
			]
		);
		
//		$repeater->add_control(
//			'hotspot_vertical',
//			[
//				'label' => __( 'Vertical Orientation', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::CHOOSE,
//				'options' => [
//					'top' => [
//						'title' => __( 'Top', 'xstore-core' ),
//						'icon' => 'eicon-v-align-top',
//					],
//					'bottom' => [
//						'title' => __( 'Bottom', 'xstore-core' ),
//						'icon' => 'eicon-v-align-bottom',
//					],
//				],
//				'default' => 'top',
//				'toggle' => false,
//			]
//		);
		
		$repeater->add_responsive_control(
			'hotspot_offset_y',
			[
				'label' => __( 'Offset Y', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => '50',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--hotspot-y: {{SIZE}}%;',
				],
			]
		);
		
		$repeater->add_control(
			'hotspot_tooltip_custom_properties',
			[
				'label' => __( 'Custom Tooltip Properties', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => sprintf( __( 'Set custom Tooltip opening that will only affect this specific hotspot.', 'xstore-core' ), '<code>|</code>' ),
			]
		);
		
		$repeater->add_control(
			'hotspot_tooltip_heading',
			[
				'label' => __( 'Box', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'hotspot_tooltip_custom_properties' => 'yes',
				],
			]
		);
		
		$repeater->add_responsive_control(
			'hotspot_tooltip_offset_x',
			[
				'label' => __( 'Offset X', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--tooltip-offset-x: {{SIZE}}%;',
				],
				'condition' => [
					'hotspot_tooltip_custom_properties' => 'yes',
				],
			]
		);
		$repeater->add_responsive_control(
			'hotspot_tooltip_offset_y',
			[
				'label' => __( 'Offset Y', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--tooltip-offset-y: {{SIZE}}%;',
				],
				'condition' => [
					'hotspot_tooltip_custom_properties' => 'yes',
				],
			]
		);
		
		$repeater->add_control(
			'hotspot_tooltip_position',
			[
				'label' => __( 'Position', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'right' => [
						'title' => __( 'Left', 'xstore-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'bottom' => [
						'title' => __( 'Top', 'xstore-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'left' => [
						'title' => __( 'Right', 'xstore-core' ),
						'icon' => 'eicon-h-align-right',
					],
					'top' => [
						'title' => __( 'Bottom', 'xstore-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
//				'selectors' => [
//					'{{WRAPPER}} {{CURRENT_ITEM}} .etheme-hotspot--tooltip-position' => 'right: initial;bottom: initial;left: initial;top: initial;{{VALUE}}: calc(100% + 5px );',
//				],
				'condition' => [
					'hotspot_tooltip_custom_properties' => 'yes',
				],
//				'render_type' => 'template',
			]
		);
		
		$repeater->add_responsive_control(
			'hotspot_tooltip_width',
			[
				'label' => __( 'Min Width', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--tooltip-min-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'hotspot_tooltip_custom_properties' => 'yes',
				],
			]
		);
		
		$repeater->add_responsive_control(
			'hotspot_tooltip_height',
			[
				'label' => __( 'Min Height', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--tooltip-min-height: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'hotspot_tooltip_custom_properties' => 'yes',
				],
			]
		);
		
		$repeater->add_control(
			'hotspot_tooltip_align',
			[
				'label' => __( 'Align', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
				'selectors_dictionary'  => [
					'left'          => 'start',
					'right'         => 'end',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--tooltip-align: {{VALUE}};',
				],
				'condition' => [
					'hotspot_tooltip_custom_properties' => 'yes',
				],
			]
		);
		
		// custom image position
//		$repeater->add_control(
//			'hotspot_tooltip_image',
//			[
//				'label' => __( 'Image position', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::CHOOSE,
//				'options' => [
//					'none' => [
//						'title' => __( 'None', 'xstore-core' ),
//						'icon' => 'eicon-ban',
//					],
//					'left' => [
//						'title' => __( 'Left', 'xstore-core' ),
//						'icon' => 'eicon-h-align-left',
//					],
//					'top' => [
//						'title' => __( 'Top', 'xstore-core' ),
//						'icon' => 'eicon-v-align-top',
//					],
//				],
//				'condition' => [
//					'hotspot_tooltip_content_type' => ['product', 'post']
//				],
//				'default' => 'top',
//			]
//		);
		
		$repeater->end_controls_tab();
		
		$repeater->end_controls_tabs();
		
		$this->add_control(
			'hotspot',
			[
				'label' => __( 'Hotspot', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ hotspot_label }}}',
				'default' => [
					[
						// Default #1 circle
					],
				],
				'frontend_available' => true,
			]
		);
		
		$this->add_control(
			'hotspot_animation',
			[
				'label' => __( 'Animation', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'soft-beat' => __( 'Soft Beat', 'xstore-core' ),
					'expand' => __( 'Expand', 'xstore-core' ),
					'shadow' => __( 'Shadow', 'xstore-core' ),
					'' => __( 'None', 'xstore-core' ),
				],
				'default' => 'shadow',
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'hotspot_delayed_animation',
			[
				'label' => __( 'Delayed Animation', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'condition' => [
					'hotspot_animation!' => '',
				],
			]
		);
		
		$this->add_control(
			'hotspot_animation_duration',
			[
				'label' => __( 'Duration (ms)', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 20000,
					],
				],
				'condition' => [
					'hotspot_animation!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}' => '--hotspot-animation-duration: {{SIZE}}ms;',
				],
			]
		);
		
		$this->end_controls_section();
		
		/**
		 * Tooltip Section
		 */
		$this->start_controls_section(
			'tooltip_section',
			[
				'label' => __( 'Tooltip', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'tooltip_position',
			[
				'label' => __( 'Position', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'top',
				'toggle' => false,
				'options' => [
					'right' => [
						'title' => __( 'Left', 'xstore-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'bottom' => [
						'title' => __( 'Top', 'xstore-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'left' => [
						'title' => __( 'Right', 'xstore-core' ),
						'icon' => 'eicon-h-align-right',
					],
					'top' => [
						'title' => __( 'Bottom', 'xstore-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
//				'selectors' => [
//					'{{WRAPPER}} .etheme-hotspot-tooltip' => '{{VALUE}}: calc(100% + var(--tooltip-space, 10px) );',
//				],
//				'frontend_available' => true,
			]
		);
		
//		$this->add_control(
//			'tooltip_position_fix_top',
//			[
//				'label' => esc_html__( 'Fix Top position', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::HIDDEN,
//				'selectors' => [
//					'{{WRAPPER}} .etheme-hotspot-tooltip' => $helper_reset.'bottom: 100%; left: 50%; transform: translateY(-50%);',
//				],
//                'condition' => [
//                    'tooltip_position' => ['top']
//                ]
//			]
//		);
//		$this->add_control(
//			'tooltip_position_fix_bottom',
//			[
//				'label' => esc_html__( 'Fix Bottom position', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::HIDDEN,
//				'selectors' => [
//					'{{WRAPPER}} .etheme-hotspot-tooltip' => $helper_reset.'top: 100%; left: 50%; transform: translateX(-50%);',
//				],
//				'condition' => [
//					'tooltip_position' => ['bottom']
//				]
//			]
//		);
//
//		$this->add_control(
//			'tooltip_position_fix_right',
//			[
//				'label' => esc_html__( 'Fix right position', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::HIDDEN,
//				'selectors' => [
//					'{{WRAPPER}} .etheme-hotspot-tooltip' => $helper_reset.'left: 100%; top: 50%; transform: translateY(-50%);',
//				],
//				'condition' => [
//					'tooltip_position' => ['right']
//				]
//			]
//		);
//
//		$this->add_control(
//			'tooltip_position_fix_left',
//			[
//				'label' => esc_html__( 'Fix right position', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::HIDDEN,
//				'selectors' => [
//					'{{WRAPPER}} .etheme-hotspot-tooltip' => $helper_reset.'right: 100%; top: 50%; transform: translateY(-50%);',
//				],
//				'condition' => [
//					'tooltip_position' => ['left']
//				]
//			]
//		);
		
//		$this->add_responsive_control(
//			'tooltip_position_x',
//			[
//				'label' => __( 'Position', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::CHOOSE,
//				'default' => 'center',
//				'toggle' => false,
//				'options' => [
//					'left' => [
//						'title' => __( 'Right', 'xstore-core' ),
//						'icon' => 'eicon-h-align-right',
//					],
//					'center' => [
//						'title' => __( 'Center', 'xstore-core' ),
//						'icon' => 'eicon-h-align-center',
//					],
//					'right' => [
//						'title' => __( 'Left', 'xstore-core' ),
//						'icon' => 'eicon-h-align-left',
//					],
//				],
//				'selectors_dictionary'  => [
//					'left'          => 'right: 100%;',
//					'center'        => 'left: 50%; transform: translateX(-50%);',
//					'right'         => 'right: 0;',
//				],
//				'selectors' => [
//					'{{WRAPPER}} .etheme-hotspot-tooltip' => 'top: initial;left: initial;bottom: initial;transform: none;right: initial;{{VALUE}}',
//				],
////				'frontend_available' => true,
//                'condition' => [
//                    'tooltip_position' => ['top', 'bottom']
//                ]
//			]
//		);
		
//		$this->add_responsive_control(
//			'tooltip_position_y',
//			[
//				'label' => __( 'Position', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::CHOOSE,
//				'default' => 'top',
//				'toggle' => false,
//				'options' => [
//					'top' => [
//						'title' => __( 'Top', 'xstore-core' ),
//						'icon' => 'eicon-v-align-top',
//					],
//					'middle' => [
//						'title' => __( 'Center', 'xstore-core' ),
//						'icon' => 'eicon-v-align-middle',
//					],
//					'bottom' => [
//						'title' => __( 'Bottom', 'xstore-core' ),
//						'icon' => 'eicon-v-align-bottom',
//					],
//				],
//				'selectors_dictionary'  => [
//					'top'          => 'top: 50%; --translateX: -50%;',
//					'middle'          => 'top: 50%; --translateX: -50%;',
//					'center'        => 'left: 50%; transform: translateX(-50%);',
//					'right'         => 'right: 0;',
//				],
//				'selectors' => [
//					'{{WRAPPER}} .etheme-hotspot-tooltip' => 'top: initial;left: initial;bottom: initial;transform: none;right: initial;{{VALUE}}',
//				],
////				'frontend_available' => true,
//				'condition' => [
//					'tooltip_position' => ['left', 'right']
//				]
//			]
//		);
//
//		$this->add_responsive_control(
//			'tooltip_offset_x',
//			[
//				'label' => __( 'Offset X', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::SLIDER,
//				'size_units' => [ '%' ],
//				'range' => [
//					'%' => [
//						'min' => -50,
//						'max' => 50,
//						'step' => 1
//					],
//				],
////				'default' => [
////					'unit' => '%',
////					'size' => '50',
////				],
//				'selectors' => [
//					'{{WRAPPER}} .etheme-hotspot-wrapper' => '--tooltip-offset-x: {{SIZE}}%;',
//				],
//			]
//		);
//
//		$this->add_control(
//			'tooltip_position_fix_x',
//			[
//				'label' => esc_html__( 'Fix X position', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::HIDDEN,
//				'selectors' => [
//					'{{WRAPPER}} .etheme-hotspot-tooltip' => 'left: 50%;',
//				],
//                'condition' => [
//                    'tooltip_offset_x!' => '',
//                    'tooltip_position' => ['bottom', 'top']
//                ]
//			]
//		);
//
//		$this->add_responsive_control(
//			'tooltip_offset_y',
//			[
//				'label' => __( 'Offset Y', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::SLIDER,
//				'size_units' => [ '%' ],
//				'range' => [
//					'%' => [
//						'min' => -50,
//						'max' => 50,
//						'step' => 1
//					],
//				],
////				'default' => [
////					'unit' => '%',
////					'size' => '50',
////				],
//				'selectors' => [
//					'{{WRAPPER}} .etheme-hotspot-wrapper' => '--tooltip-offset-y: {{SIZE}}%;',
//				],
//			]
//		);
//
//		$this->add_control(
//			'tooltip_position_fix_y',
//			[
//				'label' => esc_html__( 'Fix Y position', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::HIDDEN,
//				'selectors' => [
//					'{{WRAPPER}} .etheme-hotspot-tooltip' => 'top: 50%;',
//				],
//				'condition' => [
//					'tooltip_offset_y!' => '',
//					'tooltip_position' => ['left', 'right']
//				]
//			]
//		);
		
		$this->add_control(
			'tooltip_arrow',
			[
				'label' => __( 'Arrow', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'tooltip_trigger',
			[
				'label' => __( 'Trigger', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'hover' => __( 'Hover', 'xstore-core' ),
//					'click' => __( 'Click', 'xstore-core' ),
					'none' => __( 'None', 'xstore-core' ),
				],
				'default' => 'hover',
				'frontend_available' => true,
			]
		);
		
		
		$this->add_control(
			'tooltip_product_heading',
			[
				'label' => __( 'Product content', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'tooltip_image',
			[
				'label' => __( 'Image position', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
                    'none' => [
                        'title' => __( 'None', 'xstore-core' ),
                        'icon' => 'eicon-ban',
                    ],
					'left' => [
						'title' => __( 'Left', 'xstore-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'xstore-core' ),
						'icon' => 'eicon-v-align-top',
					],
				],
				'default' => 'top',
			]
		);
		
		$this->add_control(
			'tooltip_title',
			[
				'label' => __( 'Title', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'tooltip_price',
			[
				'label' => __( 'Price', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'tooltip_rating',
			[
				'label' => __( 'Rating', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'tooltip_meta',
			[
				'label' => __( 'Categories', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'tooltip_button',
			[
				'label' => __( 'Button', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'tooltip_animation',
			[
				'label' => __( 'Animation', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'fade' => __( 'Fade In/Out', 'xstore-core' ),
					'slide' => __( 'Slide By Direction', 'xstore-core' ),
					'scale' => __( 'Scale In', 'xstore-core' ),
				],
				'default' => 'fade',
				'condition' => [
					'tooltip_trigger!' => 'none',
				],
//				'frontend_available' => true,
			]
		);
		
//		$this->add_control(
//			'tooltip_animation_duration',
//			[
//				'label' => __( 'Duration (ms)', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::SLIDER,
//				'range' => [
//					'px' => [
//						'min' => 0,
//						'max' => 10000,
//					],
//				],
//				'selectors' => [
//					'{{WRAPPER}}' => '--tooltip-transition-duration: {{SIZE}}ms;',
//				],
//				'condition' => [
//					'tooltip_trigger!' => 'none',
//				],
//			]
//		);
		
		$this->end_controls_section();
		
		/**
		 * Section Style Hotspot
		 */
		$this->start_controls_section(
			'section_style_hotspot',
			[
				'label' => __( 'Hotspot', 'xstore-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->start_controls_tabs( 'tabs_hotspot_style' );
		
		$this->start_controls_tab(
			'tab_hotspot_normal',
			[
				'label' => __( 'Normal', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'style_hotspot_color',
			[
				'label' => __( 'Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--hotspot-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'style_hotspot_bg',
				'label' => __( 'Background', 'xstore-core' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .etheme-hotspot-item',
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'tab_hotspot_hover',
			[
				'label' => __( 'Hover', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'style_hotspot_color_hover',
			[
				'label' => __( 'Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-item:hover' => '--hotspot-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'style_hotspot_bg_hover',
				'label' => __( 'Background', 'xstore-core' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .etheme-hotspot-item:hover',
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->add_responsive_control(
			'style_hotspot_size',
			[
				'label' => __( 'Size', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'separator' => 'before',
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}}' => '--hotspot-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'style_typography',
				'selector' => '{{WRAPPER}} .etheme-hotspot-label',
//				'global' => [
//					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
//				],
			]
		);
		
		$this->add_responsive_control(
			'style_hotspot_width',
			[
				'label' => __( 'Min Width', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}}' => '--hotspot-min-width: {{SIZE}}{{UNIT}}',
				],
			]
		);
		
		$this->add_responsive_control(
			'style_hotspot_height',
			[
				'label' => __( 'Min Height', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}}' => '--hotspot-min-height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		
//		$this->add_control(
//			'style_hotspot_box_color',
//			[
//				'label' => __( 'Box Color', 'elementor-pro' ),
//				'type' => \Elementor\Controls_Manager::COLOR,
//				'selectors' => [
//					'{{WRAPPER}}' => '--hotspot-box-color: {{VALUE}};',
//				],
//				'global' => [
//					'default' => Global_Colors::COLOR_SECONDARY,
//				],
//			]
//		);
		
		$this->add_responsive_control(
			'style_hotspot_padding',
			[
				'label' => __( 'Padding', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}}' => '--hotspot-padding: {{SIZE}}{{UNIT}};',
				],
				'default' => [
					'unit' => 'px',
				],
			]
		);
		
		$this->add_control(
			'style_hotspot_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}}' => '--hotspot-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'unit' => 'px',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'style_hotspot_box_shadow',
				'selector' => '{{WRAPPER}} .etheme-hotspot-item',
				'condition' => [
					'hotspot_animation!' => 'shadow'
				]
			]
		);
		
		$this->add_control(
			'style_hotspot_animation_shadow_color',
			[
				'label' => __( 'Shadow color ', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}}' => '--hotspot-animation-shadow-color: {{VALUE}};',
				],
				'condition' => [
					'hotspot_animation' => 'shadow'
				]
			]
		);
		
		$this->add_control(
			'style_hotspot_animation_shadow_size',
			[
				'label' => __( 'Shadow Size', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'separator' => 'before',
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}}' => '--hotspot-animation-shadow-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'hotspot_animation' => 'shadow'
				]
			]
		);
		
		$this->end_controls_section();
		
		/**
		 * Section Style Tooltip
		 */
		$this->start_controls_section(
			'section_style_tooltip',
			[
				'label' => __( 'Tooltip', 'elementor-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'style_tooltip_text_color',
			[
				'label' => __( 'Text Color', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--tooltip-text-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'style_tooltip_bg',
				'label' => __( 'Background', 'xstore-core' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .etheme-hotspot-tooltip',
			]
		);
		
		$this->add_control(
			'style_tooltip_arrow_color',
			[
				'label' => __( 'Arrow Color', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--tooltip-arrow-color: {{VALUE}};',
				],
                'condition' => [
                    'tooltip_arrow' => 'yes'
                ]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'style_tooltip_typography',
				'selector' => '{{WRAPPER}} .etheme-hotspot-tooltip',
//				'global' => [
//					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
//				],
			]
		);
		
		$this->add_responsive_control(
			'style_tooltip_align',
			[
				'label' => __( 'Alignment', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'elementor-pro' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--tooltip-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'style_tooltip_heading',
			[
				'label' => __( 'Box', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_responsive_control(
			'style_tooltip_width',
			[
				'label' => __( 'Min-Width', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}}' => '--tooltip-min-width: {{SIZE}}{{UNIT}}',
				],
			]
		);
		
		$this->add_responsive_control(
			'style_tooltip_height',
			[
				'label' => __( 'Min-Height', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}}' => '--tooltip-min-height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		
		$this->add_responsive_control(
			'style_tooltip_padding',
			[
				'label' => __( 'Padding', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}}' => '--tooltip-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'style_tooltip_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--tooltip-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'style_tooltip_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}}' => '--tooltip-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'style_tooltip_box_shadow',
				'selector' => '{{WRAPPER}} .etheme-hotspot-tooltip',
			]
		);
		
		$this->add_control(
			'style_tooltip_image_heading',
			[
				'label' => __( 'Image', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
                'condition' => [
                    'tooltip_image!' => 'none'
                ]
			]
		);
		$this->add_control(
			'style_tooltip_image_max_width',
			[
				'label' => __( 'Max-width', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 400,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-tooltip-content .etheme-hotspot-content-image' =>
						'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'tooltip_image!' => 'none'
				]
			]
		);
		$this->add_control(
			'style_tooltip_image_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-tooltip-content' =>
						'--image-spacing: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'tooltip_image!' => 'none'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_title_heading',
			[
				'label' => __( 'Title', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'tooltip_title' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_title_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-tooltip-content .woocommerce-loop-product__title, {{WRAPPER}} .etheme-hotspot-tooltip-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'tooltip_title' => 'yes'
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'style_tooltip_title_typography',
				'selector' => '{{WRAPPER}} .etheme-hotspot-tooltip-content .woocommerce-loop-product__title, {{WRAPPER}} .etheme-hotspot-tooltip-title',
				'condition' => [
					'tooltip_title' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_title_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '7',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-tooltip-content .woocommerce-loop-product__title,  {{WRAPPER}} .etheme-hotspot-tooltip-title' =>
						'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'tooltip_title' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_product_meta_heading',
			[
				'label' => __( 'Product Categories', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'tooltip_meta' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_product_meta_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-tooltip-content .posted_in, {{WRAPPER}} .etheme-hotspot-tooltip-content .posted_in a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'tooltip_meta' => 'yes'
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'style_tooltip_product_meta_typography',
				'selector' => '{{WRAPPER}} .etheme-hotspot-tooltip-content .posted_in',
				'condition' => [
					'tooltip_meta' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_product_meta_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '7',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-tooltip-content .posted_in' =>
						'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'tooltip_meta' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_product_price_heading',
			[
				'label' => __( 'Product price', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'tooltip_price' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_product_price_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-tooltip-content .price' => 'color: {{VALUE}};',
				],
				'condition' => [
					'tooltip_price' => 'yes'
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'style_tooltip_product_price_typography',
				'selector' => '{{WRAPPER}} .etheme-hotspot-tooltip-content .price',
				'condition' => [
					'tooltip_price' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_product_price_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '7',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-tooltip-content .price' =>
						'margin-bottom: {{SIZE}}{{UNIT}};',
				],
                'condition' => [
					'tooltip_price' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_custom_content_heading',
			[
				'label' => __( 'Custom content', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'style_tooltip_custom_content_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-custom-content-inner' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'style_tooltip_custom_content_typography',
				'selector' => '{{WRAPPER}} .etheme-hotspot-custom-content-inner',
			]
		);
		
		$this->add_control(
			'style_tooltip_custom_content_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '7',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-custom-content-inner' =>
						'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'style_tooltip_button_heading',
			[
				'label' => __( 'Button', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'tooltip_button' => 'yes'
				]
			]
		);
		
		$this->start_controls_tabs( 'tabs_style_tooltip_button' );
		
		$this->start_controls_tab(
			'tab_style_tooltip_button_normal',
			[
				'label' => __( 'Normal', 'xstore-core' ),
				'condition' => [
					'tooltip_button' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_button_color',
			[
				'label' => __( 'Button Color', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-tooltip-content .button' => 'color: {{VALUE}};',
				],
				'condition' => [
					'tooltip_button' => 'yes'
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'style_tooltip_button_bg',
				'label' => __( 'Background', 'xstore-core' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .etheme-hotspot-tooltip-content .button',
				'condition' => [
					'tooltip_button' => 'yes'
				]
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'tab_style_tooltip_button_hover',
			[
				'label' => __( 'Hover', 'xstore-core' ),
				'condition' => [
					'tooltip_button' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_button_color_hover',
			[
				'label' => __( 'Button Color', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-tooltip-content .button:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'tooltip_button' => 'yes'
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'style_tooltip_button_bg_hover',
				'label' => __( 'Background', 'xstore-core' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .etheme-hotspot-tooltip-content .button:hover',
				'condition' => [
					'tooltip_button' => 'yes'
				]
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'style_tooltip_button_border',
				'selector' => '{{WRAPPER}} .etheme-hotspot-tooltip-content .button',
				'condition' => [
					'tooltip_button' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'style_tooltip_button_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-tooltip-content .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'unit' => 'px',
				],
				'condition' => [
					'tooltip_button' => 'yes'
				]
			]
		);
		
		$this->add_responsive_control(
			'style_tooltip_button_padding',
			[
				'label' => __( 'Padding', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .etheme-hotspot-tooltip-content .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
				],
				'default' => [
					'unit' => 'px',
				],
				'condition' => [
					'tooltip_button' => 'yes'
				]
			]
		);
		
		$this->end_controls_section();
		
	}
	
	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 4.0.6
	 * @access protected
	 */
	protected function render() {
	 
//	    if ( !\Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		    if ( function_exists( 'etheme_enqueue_style' ) ) {
			    etheme_enqueue_style( 'etheme-hotspot', true );
		    }
//	    }
		
		$settings = $this->get_settings_for_display();
		
		if ( empty( $settings['image']['url'] ) ) {
			return;
		}
		
//		$is_tooltip_direction_animation = 'e-hotspot--slide-direction' === $settings['tooltip_animation'] || 'e-hotspot--fade-direction' === $settings['tooltip_animation'];
//		$show_tooltip = 'none' === $settings['tooltip_trigger'];
		$sequenced_animation_class = 'yes' === $settings['hotspot_delayed_animation'] ? 'etheme-hotspot-animation-delayed' : '';
  
		$tooltip_position = !empty($settings['tooltip_position']) ? $settings['tooltip_position'] : 'bottom';
		$is_woocommerce = class_exists('WooCommerce');
        
        $this->add_render_attribute( 'wrapper', 'class', 'etheme-hotspot-wrapper' ); ?>
        
        <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
		
		    <?php \Elementor\Group_Control_Image_Size::print_attachment_image_html( $settings ); ?>
        
            <?php foreach ( $settings['hotspot'] as $key => $hotspot ) :
			
            $is_circle = ! $hotspot['hotspot_label'] && ! $hotspot['hotspot_icon']['value'];
//			$is_only_icon = ! $hotspot['hotspot_label'] && $hotspot['hotspot_icon']['value'];
            $hotspot_icon_position = !$hotspot['hotspot_icon_position'] ? 'left' : $hotspot['hotspot_icon_position'];
            $is_hotspot_link = ! empty( $hotspot['hotspot_link']['url'] );
            $hotspot_element_tag = $is_hotspot_link ? 'a' : 'div';
			
            // custom image position 
//			$hotspot_image_position = $hotspot['hotspot_tooltip_image'] ? $hotspot['hotspot_tooltip_image'] : $settings['tooltip_image'];
			$hotspot_image = $settings['tooltip_image'];
			$product_class = $hotspot_image == 'left' ? 'etheme-hotspot-product-content-inline' : '';
            
			$hotspot_repeater_setting_key = $this->get_repeater_setting_key( 'hotspot', 'hotspots', $key );
			$hotspot_tooltip_position = $hotspot['hotspot_tooltip_position'] ? $hotspot['hotspot_tooltip_position'] : $tooltip_position;
			
            $this->add_render_attribute(
                $hotspot_repeater_setting_key, [
                    'class' => [
                        'etheme-hotspot',
                        'elementor-repeater-item-' . $hotspot['_id'],
                        $settings['tooltip_trigger'] != 'none' ? 'etheme-hotspot-tooltip-animation-'.$settings['tooltip_animation'] : '',
                        $sequenced_animation_class,
//				            $hotspot_tooltip_position_x,
//				            $hotspot_tooltip_position_y,
//				            $is_hotspot_link ? 'e-hotspot--link' : '',
                    ],
                ]
            );
			
			$this->add_render_attribute(
				$hotspot_repeater_setting_key.'item', [
					'class' => [
						'etheme-hotspot-item',
						$settings['hotspot_animation'] ? 'etheme-hotspot-animation etheme-hotspot-animation-'.$settings['hotspot_animation'] : '',
                        $is_circle ? 'etheme-hotspot-item-default' : ''
					],
				]
			);
			
			if ( $is_hotspot_link ) {
				$this->add_link_attributes( $hotspot_repeater_setting_key, $hotspot['hotspot_link'] );
			}
	            
            ?>

            <div <?php echo $this->get_render_attribute_string( $hotspot_repeater_setting_key ); ?>>
			    <<?php echo $hotspot_element_tag; ?> <?php echo $this->get_render_attribute_string( $hotspot_repeater_setting_key.'item' ); ?>>
                    <?php
                    if ( !$is_circle ) {
                        if ( $hotspot_icon_position == 'left' && $hotspot['hotspot_icon']['value'] ) : ?>
                            <div class="etheme-hotspot-icon"><?php \Elementor\Icons_Manager::render_icon( $hotspot['hotspot_icon'] ); ?></div>
                        <?php endif; ?>
                        <?php if ( $hotspot['hotspot_label'] ) : ?>
                            <div class="etheme-hotspot-label"><?php echo $hotspot['hotspot_label']; ?></div>
                        <?php endif;
                        if ( $hotspot_icon_position == 'right' && $hotspot['hotspot_icon']['value'] ) : ?>
                            <div class="etheme-hotspot-icon"><?php \Elementor\Icons_Manager::render_icon( $hotspot['hotspot_icon'] ); ?></div>
                        <?php endif;
                    } ?></<?php echo $hotspot_element_tag; ?>>
                    
                    <?php if ( $hotspot['hotspot_tooltip_content_type'] != '' ) : ?>
                    
                        <?php
                        
                        $this->add_render_attribute(
                            $hotspot_repeater_setting_key.'tooltip', [
                                'class' => [
                                    'etheme-hotspot-tooltip',
                                    'etheme-hotspot-tooltip-'.$hotspot_tooltip_position,
                                    $settings['tooltip_arrow'] == 'yes' ? 'etheme-hotspot-arrow etheme-hotspot-arrow-'.$hotspot_tooltip_position : ''
                                ],
                            ]
                        ); ?>
                    
                        <div <?php echo $this->get_render_attribute_string( $hotspot_repeater_setting_key.'tooltip' ); ?>>
                            <div class="etheme-hotspot-tooltip-inner">
                                <?php
                                    switch ($hotspot['hotspot_tooltip_content_type']) {
                                        case 'product':
                                            if ( !$is_woocommerce) {
                                                esc_html_e('Install WooCommerce plugin to use this type', 'xstore');
                                            }
                                            else {
                                                echo '<div class="etheme-hotspot-tooltip-content '.$product_class.'">';
                                                    if ( $hotspot['product_id'] ) {
	                                                    $post_object = get_post( $hotspot['product_id'] );
	
	                                                    setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
	
                                                        if ( $hotspot_image != 'none' ) {
                                                            echo '<div class="etheme-hotspot-content-image">';
                                                                woocommerce_template_loop_product_thumbnail();
                                                            echo '</div>';
                                                        }
	
                                                        if ( $settings['tooltip_meta'] || $settings['tooltip_title'] || $settings['tooltip_price'] || $settings['tooltip_rating'] || $settings['tooltip_button'] ) :
                                                            echo '<div class="etheme-hotspot-product-content-inner">';
    //                                                            echo wc_get_product_category_list( $product->get_id(), ', ' )
    //                                                            woocommerce_template_single_meta();
    //                                                            echo wc_get_product_category_list( $hotspot['product_id'] );
    //                                                            var_dump(get_the_terms( $hotspot['product_id'], 'product_cat' )[0]);
                                                                if ( $settings['tooltip_meta'] ) :
                                                                    $term_list = (array) wp_get_post_terms( $hotspot['product_id'], 'product_cat' );
                                                                    if ( count( $term_list ) ) {
                                                                        $cat = $term_list[0];
                                                                        echo '<div class="posted_in"><a href="' . esc_url( get_term_link( $cat->term_id, 'product_cat' ) ) . '">' . $cat->name . '</a></div>';
                                                                    }
                                                                endif;
                                                                if ( $settings['tooltip_title'] ) {
                                                                    echo '<a href="'.get_permalink($hotspot['product_id']).'">';
                                                                        woocommerce_template_loop_product_title();
                                                                    echo '</a>';
                                                                }
                                                                if ( $settings['tooltip_price'] ) {
                                                                    woocommerce_template_loop_price();
                                                                }
                                                                if ( $settings['tooltip_rating'] ) { ?>
	                                                                <div class="rating-wrapper">
                                                                        <?php woocommerce_template_loop_rating(); ?>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if ( $settings['tooltip_button'] ) {
                                                                    woocommerce_template_loop_add_to_cart();
                                                                }
                                                                
                                                            echo '</div>';
                                                        endif;
                                                        wp_reset_postdata();
                                                    }
                                                    else {
                                                        if ( $hotspot_image != 'none' ) {
                                                            echo '<div class="etheme-hotspot-tooltip-content-image">';
                                                                echo wc_placeholder_img( 'woocommerce_thumbnail' );
                                                            echo '</div>';
                                                        }
	                                                    if ( $settings['tooltip_meta'] || $settings['tooltip_title'] || $settings['tooltip_rating'] ) : ?>
                                                            <div class="etheme-hotspot-product-content-inner">
                                                                <?php if ( $settings['tooltip_meta'] ) : ?>
                                                                    <div class="posted_in"><a href="#">Category</a></div>
                                                                <?php endif;
                                                                if ( $settings['tooltip_title'] ) : ?>
                                                                    <h2 class="<?php echo esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ); ?>"><?php esc_html_e('Product name', 'xstore-core'); ?></h2>
                                                                <?php endif; ?>
                                                                <?php
                                                                if ( $settings['tooltip_rating'] ) {
	                                                                echo wc_get_rating_html( 5, 1 );
                                                                }
                                                                ?>
                                                            </div>
                                                        <?php endif;
                                                    }
                                                echo '</div>'; // .etheme-hotspot-tooltip-content
                                            }
                                            break;
//                                        case 'post':
//                                            break;
                                        case 'custom':
	
	                                        $this->add_render_attribute( $hotspot_repeater_setting_key.'button', 'class', [
		                                        'elementor-button',
                                                'button',
	                                        ] );
	                                        
	                                        if ( ! empty( $hotspot['hotspot_tooltip_button_link']['url'] ) ) {
		                                        $this->add_link_attributes( $hotspot_repeater_setting_key.'button', $hotspot['hotspot_tooltip_button_link'] );
	                                        }
	                                        
                                            ?>
                                        
                                            <div class="etheme-hotspot-tooltip-content">
                                                
                                                <?php
                                                
                                                if ( $hotspot_image != 'none' ) {
	                                                echo '<div class="etheme-hotspot-content-image">';
	                                                    \Elementor\Group_Control_Image_Size::print_attachment_image_html( $hotspot, 'hotspot_tooltip_image' );
	                                                echo '</div>';
                                                }
                                                
                                                if ( $settings['tooltip_title'] ) : ?>
                                                    <h2 class="etheme-hotspot-tooltip-title"><?php echo $hotspot['hotspot_tooltip_title']; ?></h2>
                                                <?php endif; ?>
                                            
                                                <div class="etheme-hotspot-custom-content-inner">
                                                    <?php echo do_shortcode($hotspot['hotspot_tooltip_content']); ?>
                                                </div>
                                            
                                                <?php
	
                                                if ( $settings['tooltip_button'] && ! empty( $hotspot['hotspot_tooltip_button'] ) ) : ?>
    
                                                    <a <?php echo $this->get_render_attribute_string( $hotspot_repeater_setting_key.'button' ); ?>><?php echo $hotspot['hotspot_tooltip_button']; ?></a>
        
                                                <?php endif; ?>
                                                
                                            </div>
                                        
                                            <?php
                                            break;
                                        default;
                                    }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
            </div>
            
            <?php endforeach ?>
            
        </div>
        
		<?php
    }
}
