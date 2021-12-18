<?php
namespace ETC\App\Controllers\Elementor\General;

use ETC\App\Traits\Elementor;
use ETC\App\Controllers\Shortcodes\Products as Products_Shortcode;
use ETC\Views\Elementor as View;

/**
 * Advanced tabs widget.
 *
 * @since      2.3.3
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor
 */
class Advanced_Tabs extends \Elementor\Widget_Base {
	
	use Elementor;
	
	/**
	 * Get widget name.
	 *
	 * @since 2.3.3
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'et-advanced-tabs';
	}
	
	/**
	 * Get widget title.
	 *
	 * @since 2.3.3
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Ajax Product Tabs', 'xstore-core' );
	}
	
	/**
	 * Get widget icon.
	 *
	 * @since 2.3.3
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eight_theme-elementor-icon et-elementor-product-tabs';
	}
	
	/**
	 * Get widget keywords.
	 *
	 * @since 2.3.3
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords(){
		return [ 'product', 'tabs', 'product-tabs'];
	}
	
	/**
	 * Get widget categories.
	 *
	 * @since 2.3.3
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['eight_theme_general'];
	}
	
	/**
	 * Register general tabs widget controls.
	 *
	 * @since 2.3.3
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'et_section_tabs_settings',
			[
				'label' => esc_html__( 'General', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'et_tab_horizontal_style',
			[
				'label' => esc_html__( 'Style', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'label_block' => false,
				'options' => [
					'horizontal-style-1' => esc_html__( 'Underline', 'xstore-core' ),
					'horizontal-style-2' => esc_html__( 'Overline', 'xstore-core' ),
					'horizontal-style-3' => esc_html__( 'Bordered', 'xstore-core' ),
					'horizontal-style-4' => esc_html__( 'Bullets', 'xstore-core' ),
					'horizontal-style-5' => esc_html__( 'Inline with background', 'xstore-core' ),
				],
				'default'   => 'horizontal-style-1',
			]
		);
		
		$this->add_control(
			'et_tabs_position',
			[
				'label' 		=>	__( 'Position', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::CHOOSE,
				'label_block' => false,
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
				'default'		=> 'center',
				'conditions' => [
					'terms'  => [
						[
							'name'      => 'et_tab_horizontal_style',
							'operator'  => '!in',
							'value'     => ['horizontal-style-5'],
						]
					]
				]
			]
		);
		
		$this->add_responsive_control(
			'et_tabs_spacer_margin',
			[
				'label' => esc_html__('Tab Spacer', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => .5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:not(:last-child):not(.skip)' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms'  => [
						[
							'name'      => 'et_tab_horizontal_style',
							'operator'  => '!in',
							'value'     => ['horizontal-style-3'],
						]
					]
				]
			]
		);
		
		$this->add_responsive_control(
			'et_tabs_spacer_padding',
			[
				'label' => esc_html__('Tab Spacer', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs.horizontal-style-3 .et-tabs-nav > ul li:not(.skip)' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'et_tab_horizontal_style',
							'operator' => 'in',
							'value'    => ['horizontal-style-3']
						]
					]
				]
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'et_section_tabs_content_settings',
			[
				'label' => esc_html__('Content', 'xstore-core'),
			]
		);
		
		$this->add_control(
			'et_tabs_icon',
			[
				'label' => esc_html__( 'Enable Icon', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'return_value' => 'yes',
			]
		);
		
		$this->add_control(
			'et_tabs_icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'et-tab-inline-icon',
				'label_block' => false,
				'options' => [
					'et-tab-top-icon' 	 => esc_html__('Above', 'xstore-core'),
					'et-tab-inline-icon' => esc_html__('Next to title', 'xstore-core'),
				],
				'condition' => ['et_tabs_icon' => 'yes'],
			]
		);
		
		$this->add_control(
			'et_tabs_title',
			[
				'label' => esc_html__( 'Show title', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'return_value' => 'yes',
			]
		);
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->start_controls_tabs(
			'settings'
		);
		
		$repeater->start_controls_tab(
			'settings_tab',
			[
				'label' => esc_html__( 'Tab', 'xstore-core' ),
			]
		);
		
//		$repeater->add_control(
//			'tabs_settings_header',
//			[
//				'label' => esc_html__( 'Tab Settings', 'xstore-core' ),
//				'type' => \Elementor\Controls_Manager::HEADING,
//				'separator' => 'before',
//			]
//		);
		
		$repeater->add_control(
			'et_tabs_tab_show_as_default', [
				'label' => esc_html__('Set as Default', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'inactive',
				'return_value' => 'active-default',
			]
		);
		
		$repeater->add_control(
			'et_tabs_icon_type', [
				'label' => esc_html__('Icon Type', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'none' => [
						'title' => esc_html__('None', 'xstore-core'),
						'icon' => 'fa fa-ban',
					],
					'icon' => [
						'title' => esc_html__('Icon', 'xstore-core'),
						'icon' => 'fa fa-gear',
					],
					'image' => [
						'title' => esc_html__('Image', 'xstore-core'),
						'icon' => 'fa fa-picture-o',
					],
				],
				'default' => 'icon',
			]
		);
		
		$repeater->add_control(
			'et_tabs_tab_title_icon', [
				'label' => esc_html__('Icon', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-home',
					'library' => 'fa-solid',
				],
				'condition'	=> ['et_tabs_icon_type' => 'icon']
			]
		);
		
		$repeater->add_control(
			'et_tabs_tab_title_image', [
				'label' => esc_html__('Image', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition'	=> ['et_tabs_icon_type' => 'image']
			]
		);
		
		$repeater->add_control(
			'et_tabs_tab_title', [
				'label' => esc_html__('Tab Title', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Tab Title', 'xstore-core'),
			]
		);
		
		$repeater->end_controls_tab();
		
		$repeater->start_controls_tab(
			'settings_product_content_section_tab',
			[
				'label' => esc_html__('Content', 'xstore-core')
			]
		);
		
		$repeater->add_control(
			'et_tabs_content_title', [
				'label' => esc_html__('Content Title', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$repeater->add_responsive_control(
			'et_tab_content_title_position',
			[
				'label' => esc_html__( 'Content Title Position', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min'  => -40,
						'max'  => 40,
						'step' => 1
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav ul .et-content-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$repeater->add_control(
			'product_settings',
			[
				'label' => esc_html__( 'Products Settings', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$repeater->add_control(
			'type',
			[
				'label'         =>  esc_html__( 'Product Type', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SELECT,
				'options'       =>  [
					'slider'   =>  esc_html__('Slider', 'xstore-core'),
					'grid'  =>  esc_html__('Grid', 'xstore-core'),
					'list'  =>  esc_html__('List', 'xstore-core')
				],
				'default'       => 'slider'
			]
		);
		
		$repeater->add_control(
			'style',
			[
				'label'         =>  esc_html__( 'Product Layout', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SELECT,
				'options'       =>  [
					'default'   =>  esc_html__('Grid', 'xstore-core'),
					'advanced'  =>  esc_html__('List', 'xstore-core')
				],
				'condition'     => ['type' => 'slider' ],
				'default'       => 'default'
			]
		);
		
		$repeater->add_control(
			'product_view',
			[
				'label'         =>  esc_html__( 'Product View', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SELECT,
				'options'       =>  [
					''         	=>  esc_html__('Inherit', 'xstore-core'),
					'default'   =>  esc_html__('Default', 'xstore-core'),
					'mask3'     =>  esc_html__('Buttons on hover middle', 'xstore-core'),
					'mask'      =>  esc_html__('Buttons on hover bottom', 'xstore-core'),
					'mask2'     =>  esc_html__('Buttons on hover right', 'xstore-core'),
					'info'      =>  esc_html__('Information mask', 'xstore-core'),
					'booking'   =>  esc_html__('Booking', 'xstore-core'),
					'light'     =>  esc_html__('Light', 'xstore-core'),
					'Disable'   =>  esc_html__('Disable', 'xstore-core'),
				]
			]
		);
		
		$repeater->add_control(
			'product_view_color',
			[
				'label'         =>  esc_html__( 'Product View Color', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SELECT,
				'options'       =>  [
					''          =>  esc_html__('Default', 'xstore-core'),
					'white' 		=>  esc_html__('White', 'xstore-core'),
					'dark'  		=>  esc_html__('Dark', 'xstore-core'),
					'transparent'   =>  esc_html__('Transparent', 'xstore-core'),
				]
			]
		);
		
		$repeater->add_control(
			'product_img_hover',
			[
				'label'         =>  esc_html__( 'Image Hover Effect', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SELECT,
				'options'       =>  [
					''          =>  esc_html__( 'Default', 'xstore-core' ),
					'disable'   =>  esc_html__( 'Disable', 'xstore-core' ),
					'swap'      =>  esc_html__( 'Swap', 'xstore-core' ),
					'slider'    =>  esc_html__( 'Images Slider', 'xstore-core' ),
				],
				'condition'     => ['product_view' => array( '', 'default', 'mask3', 'mask', 'mask2', 'info', 'booking', 'light', 'Disable' ) ]
			]
		);
		
		$repeater->add_control(
			'show_counter',
			[
				'label'         =>  esc_html__( 'Show Sale Countdown', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SWITCHER,
				'return_value'  =>  'yes',
				'default'       =>  'yes',
			]
		);
		
		$repeater->add_control(
			'show_stock',
			[
				'label'         =>  esc_html__( 'Show Stock Count Bar', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SWITCHER,
				'return_value'  =>  'yes',
				'default'       =>  'yes',
			]
		);
		
		$repeater->add_control(
			'slider_settings',
			[
				'label' => esc_html__( 'Slider Settings', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'     => ['type' => array( 'slider' ) ]
			]
		);
		
		$repeater->add_control(
			'no_spacing',
			[
				'label'         =>  esc_html__( 'Remove Space Between Products', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SWITCHER,
				'return_value'  =>  'yes',
				'default'       =>  '',
				'condition'     => ['type' => array( 'slider' ) ]
			]
		);
		
		$repeater->add_control(
			'slider_autoplay',
			[
				'label' 		=> esc_html__( 'Autoplay', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> '',
				'condition'     => ['type' => array( 'slider' ) ]
			]
		);
		
		$repeater->add_control(
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
		
		$repeater->add_control(
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
		
		$repeater->add_control(
			'slider_loop',
			[
				'label' 		=> esc_html__( 'Infinite Loop', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'return_value' 	=> 'true',
				'default' 		=> 'true',
				'condition'     => ['type' => array( 'slider' ) ]
			]
		);
		
		$repeater->add_control(
			'slider_speed',
			[
				'label' 		=> esc_html__( 'Transition Speed', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::NUMBER,
				'description' 	=> esc_html__( 'Duration of transition between slides. In milliseconds.', 'xstore-core' ),
				'default' 		=> '300',
				'condition'     => ['type' => array( 'slider' ) ]
			]
		);
		
		$repeater->add_responsive_control(
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
		
		$repeater->add_control(
			'columns',
			[
				'label' 	=>	esc_html__( 'Columns', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::NUMBER,
				'default' 	=>	4,
				'min' => 0,
				'max' => 6,
				'condition'     => ['type' => array( 'grid', 'list' ) ]
			]
		);
		
		$repeater->add_control(
			'navigation',
			[
				'label' 		=> esc_html__( 'Navigation', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SELECT,
				'options'		=> [
					'' 			=>  esc_html__( 'Off', 'xstore-core' ),
					'btn'	=>	esc_html__( 'Btn', 'xstore-core' ),
					'lazy'	=>	esc_html__( 'Lazy', 'xstore-core' ),
				],
				'description' => esc_html__('Lazy type works only on live page not preview', 'xstore-core'),
				'condition'     => ['type' => array( 'grid', 'list' ) ]
			]
		);
		
		$repeater->add_control(
			'per_iteration',
			[
				'label' 	=>	esc_html__( 'Products per view', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::NUMBER,
				'default' 	=>	4,
				'min' => 0,
				'conditions' 	=> [
					'relation' 	=> 'and',
					'terms' 	=> [
						[
							'name' 		=> 'type',
							'operator'  => 'in',
							'value' 	=> array( 'grid', 'list' )
						],
						[
							'name' 		=> 'navigation',
							'operator'  => 'in',
							'value' 	=> array( 'btn', 'lazy' )
						],
					]
				],
			]
		);
		
		$repeater->end_controls_tab();
		
		$repeater->start_controls_tab(
			'settings_product_data_section_tab',
			[
				'label' => esc_html__( 'Data', 'xstore-core' ),
			]
		);
		
		$repeater->add_control(
			'products',
			[
				'label'         =>  esc_html__( 'Products Type', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SELECT,
				'options'       =>  [
					''                  =>  esc_html__('All', 'xstore-core'),
					'featured'          =>  esc_html__('Featured', 'xstore-core'),
					'sale'              =>  esc_html__('Sale', 'xstore-core'),
					'recently_viewed'   =>  esc_html__('Recently viewed', 'xstore-core'),
					'bestsellings'      =>  esc_html__('Bestsellings', 'xstore-core'),
				],
			]
		);
		
		$repeater->add_control(
			'orderby',
			[
				'label'         =>  esc_html__( 'Order By', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SELECT,
				'description'  => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s. Default by Date', 'xstore-core' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				'options'       =>  [
					'date'          =>  esc_html__( 'Date', 'xstore-core' ),
					'ID'            =>  esc_html__( 'ID', 'xstore-core' ),
					'postesc_html__in'      =>  esc_html__( 'As IDs provided order', 'xstore-core' ),
					'author'        =>  esc_html__( 'Author', 'xstore-core' ),
					'title'         =>  esc_html__( 'Title', 'xstore-core' ),
					'modified'      =>  esc_html__( 'Modified', 'xstore-core' ),
					'rand'          =>  esc_html__( 'Random', 'xstore-core' ),
					'comment_count' =>  esc_html__( 'Comment count', 'xstore-core' ),
					'menu_order'    =>  esc_html__( 'Menu order', 'xstore-core' ),
					'price'         =>  esc_html__( 'Price', 'xstore-core' ),
				],
				'default'       => 'date'
			]
		);
		
		$repeater->add_control(
			'order',
			[
				'label'         =>  esc_html__( 'Order Way', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SELECT,
				'description'   => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s. Default by ASC', 'xstore-core' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				'options'       =>  [
					'ASC'       =>  esc_html__( 'Ascending', 'xstore-core' ),
					'DESC'      =>  esc_html__( 'Descending', 'xstore-core' ),
				],
				'default'       => 'ASC'
			]
		);
		
		$repeater->add_control(
			'hide_out_stock',
			[
				'label'         =>  esc_html__( 'Hide Out Of Stock Products', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SWITCHER,
				'return_value'  =>  'yes',
				'default'       =>  '',
			]
		);
		
		$repeater->add_control(
			'ids',
			[
				'label' 		=> esc_html__( 'Products', 'xstore-core' ),
				'label_block' 	=> true,
				'type' 			=> 'etheme-ajax-product',
				'multiple' 		=> true,
				'placeholder' 	=> 'Type product name',
				'data_options' 	=> [
					'post_type' => array( 'product_variation', 'product' ),
				],
			]
		);
		
		$repeater->add_control(
			'taxonomies',
			[
				'label'         =>  esc_html__( 'Categories', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::SELECT2,
				'description'   =>  esc_html__( 'Enter categories.', 'xstore-core' ),
				'label_block'   => 'true',
				'multiple'  =>  true,
				'options'       => Elementor::get_terms('product_cat'),
			]
		);
		
		$repeater->add_control(
			'limit',
			[
				'label'         =>  esc_html__( 'Limit', 'xstore-core' ),
				'type'          =>  \Elementor\Controls_Manager::TEXT,
				'default'         =>  '12',
			]
		);
		
		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();
		
		$this->add_control(
			'et_tabs_tab',
			[
				'label' => esc_html__( 'Tab Title', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					['et_tabs_tab_title' => esc_html__('Tab Title 1', 'xstore-core')],
					['et_tabs_tab_title' => esc_html__('Tab Title 2', 'xstore-core')],
					['et_tabs_tab_title' => esc_html__('Tab Title 3', 'xstore-core')],
				],
				'title_field' => '{{et_tabs_tab_title}}',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'et_section_tabs_style_settings',
			[
				'label' => esc_html__('Tabs Style', 'xstore-core'),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'et_tabs_border',
				'label' => esc_html__('Border', 'xstore-core'),
				'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-nav',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'et_section_tabs_tab_style_settings',
			[
				'label' => esc_html__('Tab Style', 'xstore-core'),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'et_tabs_tab_title_typography',
				'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:not(.skip)',
			]
		);
		
		$this->add_responsive_control(
			'et_tabs_tab_icon_size_horizontal',
			[
				'label' => esc_html__('Icon Size', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['et_tabs_icon' => 'yes'],
			]
		);
		
		$this->add_responsive_control(
			'et_tabs_tab_icon_gap_horizontal',
			[
				'label' => esc_html__('Icon Gap', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .et-tab-inline-icon .et-tab-title:not(:only-child)' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .et-tab-top-icon .et-tab-title:not(:only-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['et_tabs_icon' => 'yes'],
			]
		);
		
		$this->add_responsive_control(
			'et_tabs_tab_padding',
			[
				'label' 				=> esc_html__('Padding', 'xstore-core'),
				'type' 					=>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' 			=> ['px', 'em', '%'],
				'selectors'				=> [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:not(.skip)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'et_tabs_tab_margin',
			[
				'label' => esc_html__('Margin', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:not(.skip)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->start_controls_tabs('et_tabs_header_tabs');
		$this->start_controls_tab( 'et_tabs_header_normal',
			[
				'label' => esc_html__('Normal', 'xstore-core')
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'et_tabs_tab_bgtype',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:not(.skip)'
			]
		);
		
		$this->add_control(
			'et_tabs_tab_text_color',
			[
				'label' => esc_html__('Text Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:not(.skip)' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'et_tabs_tab_icon_color_horizontal',
			[
				'label' => esc_html__('Icon Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li i' => 'color: {{VALUE}};',
				],
				'condition' => ['et_tabs_icon' => 'yes'],
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'et_tabs_header_hover',
			[
				'label' => esc_html__('Hover', 'xstore-core')
			]
		);
		
		$this->add_control(
			'et_tabs_tab_color_hover',
			[
				'label' => esc_html__('Tab Background Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:not(.skip):hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'et_tabs_tab_bgtype_hover',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:not(.skip):hover'
			]
		);
		
		$this->add_control(
			'et_tabs_tab_text_color_hover',
			[
				'label' => esc_html__('Text Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:not(.skip):hover' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'et_tabs_tab_divider_color_hover',
			[
				'label' => esc_html__( 'Divider Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:after' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'et_tabs_tab_icon_color_hover_horizontal',
			[
				'label' => esc_html__('Icon Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:not(.skip):hover > i' => 'color: {{VALUE}};'
				],
				'condition' => ['et_tabs_icon' => 'yes'],
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'et_tabs_header_active',
			[
				'label' => esc_html__('Active', 'xstore-core')
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'et_tabs_tab_bgtype_active',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active:not(.skip),{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active-default:not(.skip)'
			]
		);
		
		$this->add_control(
			'et_tabs_tab_text_color_active',
			[
				'label' => esc_html__('Text Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active:not(.skip),
					{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul .active-default .et-tab-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'et_tabs_tab_icon_color_active_horizontal',
			[
				'label' => esc_html__('Icon Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active > i,
					{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active-default > i' => 'color: {{VALUE}};',
				],
				'condition' => ['et_tabs_icon' => 'yes'],
			]
		);
		
		$this->add_control(
			'et_tabs_tab_divider_show_active',
			[
				'label' => esc_html__( 'Hide Divider', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active .et-tab-title:after,
					{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:after' => 'opacity: 0 !important',
				],
			]
		);
		
		$this->add_control(
			'et_tabs_tab_divider_color_active',
			[
				'label' => esc_html__( 'Divider Color', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active .et-tab-title:after' => 'background-color: {{VALUE}};',
				],
				'condition' => ['et_tabs_tab_divider_show' => ''],
			]
		);
		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->add_control(
			'content_title_control_heading',
			[
				'label' => esc_html__( 'Content Title', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'et_content_title_bg_tab_bgtype',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.et-content-title'
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'et_content_title_typography',
				'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.et-content-title',
			]
		);
		
		$this->add_control(
			'et_content_title_text_color',
			[
				'label' => esc_html__('Content Title Color', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.et-content-title span' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'et_section_tabs_tab_content_style_settings',
			[
				'label' => esc_html__('Content Style', 'xstore-core'),
				'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'adv_tabs_content_bgtype',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-content > div'
			]
		);
		
		$this->add_responsive_control(
			'et_tabs_content_padding',
			[
				'label' => esc_html__('Padding', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-content > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'et_tabs_content_margin',
			[
				'label' => esc_html__('Margin', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-content > div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'et_tabs_content_border',
				'label' => esc_html__('Border', 'xstore-core'),
				'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-content > div',
			]
		);
		$this->add_responsive_control(
			'et_tabs_content_border_radius',
			[
				'label' => esc_html__('Border Radius', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-content > div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'et_tabs_content_shadow',
				'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-content > div',
				'separator' => 'before',
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
				'condition' => ['hide_buttons' => '']
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
					'nav-bar' 			=>	esc_html__( 'Nav Bar', 'xstore-core' ),
					'middle' 			=>	esc_html__( 'Middle', 'xstore-core' ),
					'middle-inside' 	=>	esc_html__( 'Middle Inside', 'xstore-core' ),
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
					'{{WRAPPER}} .et-advance-tabs, {{WRAPPER}} .et-advance-tabs .swiper-entry' => '--arrow-size: {{SIZE}}{{UNIT}};',
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
							'value' 	=> 'nav-bar'
						],
						[
							'name' 		=> 'navigation_position',
							'operator'  => '=',
							'value' 	=> 'nav-bar'
						]
					]
				],
				'selectors' => [
					'{{WRAPPER}} .et-advance-tabs .et-tabs-nav' => '--arrow-space: {{SIZE}}{{UNIT}};',
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
		
		$this->add_control(
			'default_color',
			[
				'label' 	=> esc_html__( 'Pagination Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#e1e1e1',
				'condition' => ['pagination_type' => ['bullets', 'lines' ]],
			]
		);
		
		$this->add_control(
			'active_color',
			[
				'label' 	=> esc_html__( 'Pagination Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#222',
				'condition' => ['pagination_type' => ['bullets', 'lines' ]],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'slider_style_section',
			[
				'label' => esc_html__( 'Slider Style', 'xstore-core' ),
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
					'{{WRAPPER}} .et-advance-product-tabs .swiper-custom-left,
					{{WRAPPER}} .et-advance-product-tabs .swiper-custom-right' => 'color: {{VALUE}};',
				]
			]
		);
		
		$this->add_control(
			'advanced_arrows_bg_color',
			[
				'label' 	=> esc_html__( 'Nav Background Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-product-tabs .swiper-custom-left,
					{{WRAPPER}} .et-advance-product-tabs .swiper-custom-right' => 'background-color: {{VALUE}};',
				]
			]
		);
		
		$this->add_control(
			'advanced_arrows_border_color',
			[
				'label' 	=> esc_html__( 'Nav Border Color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-product-tabs .swiper-custom-left,
					{{WRAPPER}} .et-advance-product-tabs .swiper-custom-right' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .et-advance-product-tabs .swiper-custom-left:hover,
					{{WRAPPER}} .et-advance-product-tabs .swiper-custom-right:hover' => 'color: {{VALUE}};',
				]
			]
		);
		
		$this->add_control(
			'advanced_arrows_bg_color_hover',
			[
				'label' 	=> esc_html__( 'Nav Background', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-product-tabs .swiper-custom-left:hover,
					{{WRAPPER}} .et-advance-product-tabs .swiper-custom-right:hover' => 'background-color: {{VALUE}};',
				]
			]
		);
		
		$this->add_control(
			'advanced_arrows_br_color_hover',
			[
				'label' 	=> esc_html__( 'Nav Border', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .et-advance-product-tabs .swiper-custom-left:hover,
					{{WRAPPER}} .et-advance-product-tabs .swiper-custom-right:hover' => 'border-color: {{VALUE}};',
				]
			]
		);
		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->end_controls_section();
		
		
	}
	
	/**
	 * Render general tabs widget output on the frontend.
	 *
	 * @since 2.3.3
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		
		if ( $settings['et_tabs_position'] == 'left' ) {
			$settings['et_tabs_position'] = 'end';
		}
		elseif ( $settings['et_tabs_position'] == 'right') {
			$settings['et_tabs_position'] = 'flex-end';
		}
		
		$this->add_render_attribute(
			'et_tab_wrapper',
			[
				'id' => "et-advance-tabs-{$this->get_id()}",
				'class' => ['et-advance-tabs', 'et-advance-product-tabs', 'et-tabs-horizontal', $settings['et_tab_horizontal_style']],
				'data-tabid' => $this->get_id(),
			]
		);
		
		if ( 'yes' === $settings['et_tabs_icon'] ) {
			$this->add_render_attribute('et_tab_ul', 'class', esc_attr( $settings['et_tabs_icon_position'] ) );
		}
		
		$this->add_render_attribute('et_tab_ul', 'class', esc_attr( $settings['et_tabs_position'] ) );
		
		if ( function_exists('etheme_enqueue_style')) {
			etheme_enqueue_style( 'et-advance-tabs', true );
		}
		
		$view = new View;
		$Products_Shortcode = Products_Shortcode::get_instance();
		
		$view->advanced_tabs(
			array(
				'settings'  	 		=> $settings,
				'et_tab_wrapper' 		=> $this->get_render_attribute_string('et_tab_wrapper'),
				'et_tab_ul'  			=> $this->get_render_attribute_string('et_tab_ul'),
				'Products_Shortcode'  	=> $Products_Shortcode,
				'_wid'  				=> $this->get_id(),
				'is_preview'  			=> ( \Elementor\Plugin::$instance->editor->is_edit_mode() ? true : false ),
			)
		);
		
	}
	
}