<?php

namespace ETC\App\Controllers\Elementor\General;

use ETC\App\Traits\Elementor;
use ETC\App\Controllers\Shortcodes\Fancy_Button as Fancy_Button_Shortcode;

/**
 * Fancy button widget.
 *
 * @since      2.1.3
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor
 */
class Fancy_Button extends \Elementor\Widget_Base {
	
	use Elementor;
	
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 * @since  2.1.3
	 * @access public
	 *
	 */
	public function get_name() {
		return 'et_fancy_button';
	}
	
	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 * @since  2.1.3
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Fancy button', 'xstore-core' );
	}
	
	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 * @since  2.1.3
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'eight_theme-elementor-icon et-elementor-fancy-button';
	}
	
	/**
	 * Get widget keywords.
	 *
	 * @return array Widget keywords.
	 * @since  2.1.3
	 * @access public
	 *
	 */
	public function get_keywords() {
		return [ 'et_fancy_button', 'Fancy button' ];
	}
	
	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 * @since  2.1.3
	 * @access public
	 *
	 */
	public function get_categories() {
		return [ 'eight_theme_general' ];
	}
	
	
	/**
	 * Register Fancy button widget controls.
	 *
	 * @since  2.1.3
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'settings',
			[
				'label' => __( 'General Settings', 'xstore-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'on_click',
			[
				'label'   => __( 'On click action', 'xstore-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'link'  => esc_html__( 'Open custom link', 'xstore-core' ),
					'popup' => esc_html__( 'Open promo popup', 'xstore-core' ),
				],
				'default' => 'link'
			]
		);
		
		$this->add_control(
			'link',
			[
				'label'       => __( 'Custom Link', 'xstore-core' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'xstore-core' ),
				'default'     => [
					'url' => '#',
				],
				'condition'   => [ 'on_click' => 'link' ]
			]
		);
		
		$this->add_control(
			'link_title',
			[
				'label' => __( 'Button Text', 'xstore-core' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Button text', 'xstore-core'),
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'content_settings',
			[
				'label' => __( 'Content Settings', 'xstore-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'on_click',
							'operator' => '=',
							'value'    => 'popup'
						],
					]
				]
			]
		);
		
		$this->add_control(
			'staticblock',
			[
				'label'       => __( 'Choose prebuilt static blocks', 'xstore-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'options'     => Elementor::get_static_blocks(),
				'conditions'  => [
					'terms' => [
						[
							'name'     => 'on_click',
							'operator' => '=',
							'value'    => 'popup'
						],
					]
				]
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'icon_settings',
			[
				'label' => __( 'Icon/Image', 'xstore-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'add_icon',
			[
				'label'        => __( 'Add icon ?', 'xstore-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'position',
			[
				'label' 		=>	__( 'Position', 'xstore-core' ),
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
				'default'		=> 'left',
				'conditions' => [
					'terms' => [
						[
							'name'     => 'add_icon',
							'operator' => '=',
							'value'    => 'true'
						],
						[
							'name'     => 'link_title',
							'operator' => '!=',
							'value'    => ''
						],
					]
				]
			]
		);
		
		$this->add_control(
			'type',
			[
				'label'     => __( 'Icon library', 'xstore-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => [
					'icon'  => esc_html__( 'Icon', 'xstore-core' ),
					'image' => esc_html__( 'Upload image', 'xstore-core' ),
				],
				'default'   => 'icon',
				'condition' => [ 'add_icon' => 'true' ],
			]
		);
		
		$this->add_control(
			'icon', [
				'label'      => esc_html__( 'Icon', 'xstore-core' ),
				'type'       => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'add_icon',
							'operator' => '=',
							'value'    => 'true'
						],
						[
							'name'     => 'type',
							'operator' => '=',
							'value'    => 'icon'
						],
					]
				]
			]
		);
		
		$this->add_control(
			'image',
			[
				'label'      => __( 'Image', 'xstore-core' ),
				'type'       => \Elementor\Controls_Manager::MEDIA,
				'default'    => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'type',
							'operator' => '=',
							'value'    => 'image'
						],
						[
							'name'     => 'add_icon',
							'operator' => '=',
							'value'    => 'true'
						],
					]
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default' => 'thumbnail',
				'separator' => 'none',
				'conditions' => [
					'terms' => [
						[
							'name'     => 'type',
							'operator' => '=',
							'value'    => 'image'
						],
						[
							'name'     => 'add_icon',
							'operator' => '=',
							'value'    => 'true'
						],
					]
				]
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'icon_style_section',
			[
				'label' => __( 'Icon/Image', 'xstore-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition'   => [ 'add_icon' => 'true' ]
			]
		);
		
		$this->add_control(
			'icon_size',
			[
				'label'		 =>	esc_html__( 'Icon size', 'xstore-core' ),
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
					'{{WRAPPER}} .button-wrap a i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [ 'type' => 'icon' ],
			]
		);
		
		$this->add_control(
			'icon_spacing',
			[
				'label'		 =>	esc_html__( 'Spacing', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' 		=> [
						'min' 	=> 0,
						'max' 	=> 30,
						'step' 	=> 1
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .button-wrap .icon-pos-top > i' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .button-wrap .icon-pos-right > i' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .button-wrap .icon-pos-left > i' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'link_title',
							'operator' => '!=',
							'value'    => ''
						],
					]
				]
			]
		);
		
		$this->start_controls_tabs( 'tabs_icon_colors' );
		
		$this->start_controls_tab(
			'tab_icon_color_normal',
			[
				'label' => __( 'Normal', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'icon_color',
			[
				'label'      => __( 'Icon color', 'xstore-core' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'condition'   => [ 'type' => 'icon' ],
				'selectors' => [
					'{{WRAPPER}} .button-wrap a > i' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'icon_bg_color',
			[
				'label'      => __( 'Icon background color', 'xstore-core' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'condition'   => [ 'type' => 'icon' ],
				'selectors' => [
					'{{WRAPPER}} .button-wrap a > i' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'icon_padding',
			[
				'label' => esc_html__('Padding', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'separator' => 'before',
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .button-wrap a > i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'   => [ 'type' => 'icon' ]
			]
		);
		
		$this->add_control(
			'icon_border_radius',
			[
				'label' => __( 'Border Radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .button-wrap a > i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'selector' => '{{WRAPPER}} .button-wrap a > i',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_css_filters',
				'selector' => '{{WRAPPER}} .button-wrap a img',
				'separator' => 'before',
				'condition'   => [ 'type' => 'image' ]
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'tab_icon_color_hover',
			[
				'label' => __( 'Hover', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'icon_color_hover',
			[
				'label'      => __( 'Icon color', 'xstore-core' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'condition'   => [ 'type' => 'icon' ],
				'selectors' => [
					'{{WRAPPER}} .button-wrap a:hover > i' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'icon_bg_color_hover',
			[
				'label'      => __( 'Icon background color', 'xstore-core' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'condition'   => [ 'type' => 'icon' ],
				'selectors' => [
					'{{WRAPPER}} .button-wrap a:hover > i' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'icon_border_radius_hover',
			[
				'label' => __( 'Border Radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .button-wrap a:hover > i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'icon_border_hover',
				'selector' => '{{WRAPPER}} .button-wrap a:hover > i',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_css_filters_hover',
				'selector' => '{{WRAPPER}} .button-wrap a:hover img',
				'separator' => 'before',
				'condition'   => [ 'type' => 'image' ]
			]
		);
		
		$this->add_control(
			'image_hover_transition',
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
					'{{WRAPPER}} .button-wrap a img' => 'transition-duration: {{SIZE}}s',
				],
				'condition'   => [ 'type' => 'image' ]
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'button_style',
			[
				'label' => __( 'Button', 'xstore-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'btn_style_custom',
			[
				'label'        => __( 'Custom Styles ?', 'xstore-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		
		$this->add_control(
			'btn_style',
			[
				'label'   => __( 'Style', 'xstore-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'default'  => esc_html__( 'Default', 'xstore-core' ),
					'active'   => esc_html__( 'Active', 'xstore-core' ),
					'bordered' => esc_html__( 'Bordered', 'xstore-core' ),
					'white'    => esc_html__( 'Light', 'xstore-core' ),
					'black'    => esc_html__( 'Dark', 'xstore-core' ),
					'custom'   => esc_html__( 'Custom', 'xstore-core' ),
				],
				'default' => 'custom',
				'conditions' => [
					'terms' => [
						[
							'name'     => 'btn_style_custom',
							'operator' => '!=',
							'value'    => 'yes'
						],
					]
				]
			]
		);
		
		$this->add_control(
			'btn_size',
			[
				'label'   => __( 'Size', 'xstore-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'small'   => esc_html__( 'Small', 'xstore-core' ),
					'medium'  => esc_html__( 'Medium', 'xstore-core' ),
					'big'     => esc_html__( 'Large', 'xstore-core' ),
					'custom'  => esc_html__( 'Custom', 'xstore-core' ),
				],
				'default' => 'medium'
			]
		);
		
		$this->add_control(
			'full_width',
			[
				'label'        => __( 'Make full width ?', 'xstore-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default'      => '',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .button-wrap a',
				'conditions' => [
					'terms' => [
						[
							'name'     => 'link_title',
							'operator' => '!=',
							'value'    => ''
						],
					]
				]
			]
		);
		
		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__('Padding', 'xstore-core'),
				'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
				'separator' => 'before',
				'size_units' => ['px', 'em', '%'],
				'default' => [
					'top' => 10,
					'right' => 20,
					'bottom' => 15,
					'left' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .button-wrap a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [ 'btn_size' => 'custom' ],
			]
		);
		
		$this->start_controls_tabs( 'tabs_border' );
		
		$this->start_controls_tab(
			'tab_border_normal',
			[
				'label' => __( 'Normal', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'color',
			[
				'label'     => __( 'Button color', 'xstore-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button-wrap a' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'btn_style',
							'operator' => '=',
							'value'    => 'custom'
						],
					]
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .button-wrap a',
				'conditions' => [
					'terms' => [
						[
							'name'     => 'btn_style',
							'operator' => '=',
							'value'    => 'custom'
						],
					]
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .button-wrap a',
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'     => 'btn_style',
							'operator' => '=',
							'value'    => 'custom'
						],
					]
				]
			]
		);
		
		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .button-wrap a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'btn_style',
							'operator' => '=',
							'value'    => 'custom'
						],
					]
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .button-wrap a',
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'tab_border_hover',
			[
				'label' => __( 'Hover', 'xstore-core' ),
			]
		);
		
		$this->add_control(
			'color_hover',
			[
				'label'     => __( 'Button color', 'xstore-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'btn_style',
							'operator' => '=',
							'value'    => 'custom'
						],
					]
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background_hover',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .button-wrap a:hover',
				'conditions' => [
					'terms' => [
						[
							'name'     => 'btn_style',
							'operator' => '=',
							'value'    => 'custom'
						],
					]
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border_hover',
				'selector' => '{{WRAPPER}} .button-wrap a:hover',
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'     => 'btn_style',
							'operator' => '=',
							'value'    => 'custom'
						],
					]
				]
			]
		);
		
		$this->add_control(
			'border_radius_hover',
			[
				'label' => __( 'Border Radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .button-wrap a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'btn_style',
							'operator' => '=',
							'value'    => 'custom'
						],
					]
				]
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_hover',
				'selector' => '{{WRAPPER}} .button-wrap a:hover',
			]
		);
		
		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->end_controls_section();
		
	}
	
	/**
	 * Render Fancy button widget output on the frontend.
	 *
	 * @since  2.1.3
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$this->add_render_attribute( 'button', 'class', 'btn flex flex-nowrap justify-content-center align-items-center' );
		
		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'button', $settings['link'] );
			$this->add_render_attribute( 'button', 'title', $settings['link_title'] );
		}
		
		if ( $settings['btn_style'] != '' ) {
			$this->add_render_attribute( 'button', 'class', ( ( $settings['btn_style'] == 'custom' ) ? ' style-' : '' ) . $settings['btn_style'] );
		}
		
		if ( $settings['btn_size'] != '' ) {
			$this->add_render_attribute( 'button', 'class', ( ( $settings['btn_size'] == 'custom' ) ? ' size-' : '' ) . $settings['btn_size'] );
		}
		
		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}
		
		if ( ! isset( $settings['icon_rendered'] ) && ! \Elementor\Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon_rendered'] = 'fa fa-star';
		}
		
		if ( $settings['add_icon'] ) {
			$this->add_render_attribute( 'i', 'class', $settings['icon'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
			$this->add_render_attribute( 'button', 'class', 'icon-pos-' . $settings['position'] );
			
			if ( $settings['position'] && $settings['position'] == 'top' ) {
				$this->add_render_attribute( 'button', 'class', 'flex-col' );
			}
			
			$icon_attributes = $this->get_render_attribute_string( 'icon' );
			
			$migrated = isset( $settings['__fa4_migrated']['icon'] );
			$is_new   = ! isset( $settings['icon_rendered'] ) && \Elementor\Icons_Manager::is_migration_allowed();
			
			ob_start();
			
			if ( $settings['type'] == 'icon' ) {
				
				if ( $is_new || $migrated ) {
					?><i><?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );?></i><?php
				} elseif ( ! empty( $settings['icon'] ) ) {
					?><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i><?php
				}
				
			} else {
				if ( $settings['image']['id'] == '' ) {
					$this->add_render_attribute( 'button', 'class', 'elementor-icon' );
				} ?>
				<i class="icon-image">
					<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
				</i>
			<?php }
			
			$settings['icon'] = ob_get_clean();
			
		}
		
		else {
			$settings['icon'] = '';
		}
		
		$settings['button_link_html'] = sprintf(
			'<a %s>%s %s %s</a>',
			$this->get_render_attribute_string( 'button' ),
			( ( $settings['position'] != 'right' ) ? $settings['icon'] : '' ),
			!empty($settings['link_title']) ? '<span>' . $settings['link_title'] . '</span>' : '',
			( ( $settings['position'] == 'right' ) ? $settings['icon'] : '' )
		);
		
		$atts = array(
			'on_click'         => $settings['on_click'],
			'button_link_html' => $settings['button_link_html'],
			'staticblocks'     => true,
			'staticblock'      => $settings['staticblock'],
			'add_icon'         => $settings['add_icon'],
			'full_width' => $settings['full_width'],
			'type'             => $settings['type'],
			'is_preview'       => ( \Elementor\Plugin::$instance->editor->is_edit_mode() ? true : false ),
			'is_elementor'     => true
		);
		
		$Fancy_Button_Shortcode = Fancy_Button_Shortcode::get_instance();
		echo $Fancy_Button_Shortcode->fancy_button_shortcode( $atts, '' );
		
	}
	
}