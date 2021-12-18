<?php
namespace ETC\App\Controllers\Elementor\General;

use ETC\App\Controllers\Shortcodes\Icon_Box as Icon_Box_Shortcodes;

/**
 * Icon Box widget.
 *
 * @since      2.1.3
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor
 */
class Icon_Box extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'icon_box';
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
		return __( 'Icon Box', 'xstore-core' );
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
		return 'eicon-icon-box eight_theme-element-icon';
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
		return [ 'icon','box','icon-box' ];
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
	 * Register Icon Box widget controls.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'settings',
			[
				'label' => __( 'General Settings', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'Content text', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
			]
		);

		$this->add_control(
			'align',
			[
				'label' 		=>	__( 'Align', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					''			=>	esc_html__('Default', 'xstore-core'),
					'start'		=>	esc_html__('Start', 'xstore-core') ,
					'center'	=>	esc_html__('Center', 'xstore-core') ,
					'end'		=>	esc_html__('End', 'xstore-core') ,
				],
			]
		);

		$this->add_control(
			'valign',
			[
				'label' 	=>	__( 'Vertical align', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::SELECT,
				'multiple' 	=>	false,
				'options' 	=>	[
					'center'  	=>	esc_html__('Center', 'xstore-core'), 
					'top'		=>	esc_html__('Top', 'xstore-core'),
					'bottom' 	=>	esc_html__('Bottom', 'xstore-core'), 
				],
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'position',
							'operator'  => '!=',
							'value' 	=> 'top'
						]
					]
				]
			]
		);

		$this->add_control(
			'content_spacing',
			[
				'label' => __( 'Spacing', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
				'default' => '10px',
			]
		);

		$this->add_control(
			'on_click',
			[
				'label' 	=>	__( 'On click action', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::SELECT,
				'multiple' 	=>	false,
				'options' 	=>	[
					'none'	=>	esc_html__('None', 'xstore-core'),
					'link'	=>	esc_html__('Open custom link', 'xstore-core'),
				],
			]
		);

		$this->add_control(
			'custom_link',
			[
				'label' => __( 'Custom Link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'on_click',
							'operator'  => '!=',
							'value' 	=> 'link'
						]
					]
				]
			]
		);

		$this->add_control(
			'type',
			[
				'label' 		=>	__( 'Icon library', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'svg'			=>	esc_html__( 'Icon', 'xstore-core' ),
					'image'			=>	esc_html__( 'Upload image', 'xstore-core' ),
				],
				'default'		=> 'svg',
			]
		);

		$this->add_control(
			'icon_type',
			[
				'label' 	=> __( 'Icon', 'xstore-core' ),
				'type' 		=> 'etheme-icon-control',
				'condition' => [ 'type' => 'svg' ],
			]
		);

		$this->add_control(
			'attach_image',
			[
				'label' => __( 'Image', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [ 'type' => 'image' ],
			]
		);

		$this->add_control(
			'img_size',
			[
				'label' 	=> __( 'Image size', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::TEXT,
				'condition' => [ 'type' => 'image' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'xstore-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'view',
			[
				'label' 	=>	__( 'View', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::SELECT,
				'multiple' 	=>	false,
				'options' 	=>	[
					'default'	=>	esc_html__( 'Default', 'xstore-core' ),
					'stacked'	=>	esc_html__( 'Stacked', 'xstore-core' ),
					'framed'	=>	esc_html__( 'Framed', 'xstore-core' ),
				],
			]
		);

		$this->add_control(
			'color',
			[
				'label' 	=> __( 'Icon color 01', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#555',
				'selectors' => [
					'{{WRAPPER}} .ibox-block .ibox-symbol .icon-image svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'color_hover',
			[
				'label' 	=> __( 'Icon color 01 (hover)', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#888',
				'selectors' => [
					'{{WRAPPER}} .ibox-block .ibox-symbol .icon-image svg path:hover' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bg_colour',
			[
				'label' 	=> __( 'Icon background color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#e1e1e1',
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'view',
							'operator'  => '!=',
							'value' 	=> 'default'
						]
					]
				]
			]
		);

		$this->add_control(
			'bg_color_hover',
			[
				'label' 	=> __( 'Icon background color (hover)', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#fafafa',
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'view',
							'operator'  => '!=',
							'value' 	=> 'default'
						]
					]
				]
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Icon size', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'type',
							'operator'  => '!=',
							'value' 	=> 'image'
						]
					]
				],
				'selectors' => [
					'{{WRAPPER}} .ibox-block .ibox-symbol .icon-image svg' => 'width: {{VALUE}}; height: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'position',
			[
				'label' 		=>	__( 'Position of the icon', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'left' 	=>	esc_html__('Left', 'xstore-core'), 
					'top'  	=>	esc_html__('Top', 'xstore-core'),
					'right'	=>	esc_html__('Right', 'xstore-core'), 
				],
			]
		);

		$this->add_control(
			'icon_advanced',
			[
				'label' => __( 'Icon advanced styles', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_spacing',
			[
				'label' 	=> __( 'Spacing', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'icon_paddings',
			[
				'label' => __( 'Paddings', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'padding_top',
			[
				'label' => __( 'Top', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'padding_right',
			[
				'label' => __( 'Right', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);
		
		$this->add_control(
			'padding_bottom',
			[
				'label' => __( 'Bottom', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);
		
		$this->add_control(
			'padding_left',
			[
				'label' => __( 'Left', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'icon_radius',
			[
				'label' => __( 'Border radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius_top_left',
			[
				'label' => __( 'Top left', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'border_radius_top_right',
			[
				'label' => __( 'Top right', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'border_radius_bottom_right',
			[
				'label' => __( 'Bottom right', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);	

		$this->add_control(
			'border_radius_bottom_left',
			[
				'label' => __( 'Bottom left', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'icon_border',
			[
				'label' => __( 'Borders', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'	=> ['view' => 'framed'],
			]
		);

		$this->add_control(
			'border_top',
			[
				'label' => __( 'Top', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
				'condition'	=> ['view' => 'framed'],
			]
		);

		$this->add_control(
			'border_right',
			[
				'label' => __( 'Right', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
				'condition'	=> ['view' => 'framed'],
			]
		);

		$this->add_control(
			'border_bottom',
			[
				'label' => __( 'Bottom', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
				'condition'	=> ['view' => 'framed'],
			]
		);

		$this->add_control(
			'border_left',
			[
				'label' => __( 'Left', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
				'condition'	=> ['view' => 'framed'],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'button_settings',
			[
				'label' => __( 'Button', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label' => __( 'Button text', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Button link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'btn_style',
			[
				'label' 		=>	__( 'Style', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'default'	=>	esc_html__('Default', 'xstore-core'),
					'active'	=>	esc_html__('Active', 'xstore-core'),
					'border'	=>	esc_html__('Border', 'xstore-core'),
					'white'		=>	esc_html__('White', 'xstore-core'),
					'black'		=>	esc_html__('Black', 'xstore-core'),
				],
			]
		);

		$this->add_control(
			'btn_size',
			[
				'label' 		=>	__( 'Size', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'default'	=>	esc_html__('Default', 'xstore-core'),
					'small'	=>	esc_html__('Small', 'xstore-core'),
					'large'	=>	esc_html__('Large', 'xstore-core'),
				],
			]
		);

		$this->add_control(
			'class',
			[
				'label' => __( 'Extra Class', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Icon Box widget output on the frontend.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$atts = array();
		foreach ( $settings as $key => $setting ) {
			if ( '_' == substr( $key, 0, 1) ) {
				continue;
			}

			if ( 'content' == $key ) {
				continue;
			}

//			if ( 'icon_type' == $key && $setting ) {
//				// icon svg code
//				$icon_type = ET_CORE_DIR . 'app/assets/icon-fonts/svg/' . $setting;
//				$icon_type = file_get_contents( $icon_type );
//				$icon_type = base64_encode( $icon_type );
//				$atts['svg'] = $icon_type;
//				continue;
//			}

			if ( 'attach_image' == $key && $setting ) {
				// image
				$atts['img'] = $setting['id'];
				continue;
			}

			if ( 'color' == $key && $setting || 'color_hover' == $key && $setting || 'size' == $key && $setting ) {
				// image
				continue;
			}

			if ( $setting ) {
				$atts[$key] = $setting;
			}
		}

		$Icon_Box_Shortcodes = Icon_Box_Shortcodes::get_instance();
		echo $Icon_Box_Shortcodes->icon_box_shortcode( $atts, $settings['content'] );

	}

}
