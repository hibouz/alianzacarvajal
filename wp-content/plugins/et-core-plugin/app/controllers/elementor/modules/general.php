<?php
namespace ETC\App\Controllers\Elementor\Modules;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
/**
 * General options.
 *
 * @since      2.0.0
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor/Modules
 */
class General {


    function __construct(){
        // Add new controls to advanced tab globally
        add_action( "elementor/element/after_section_end", array( $this, 'add_parallax_controls_section'   ), 15, 3 );

        // Renders attributes for all Elementor Elements
        // add_action( 'elementor/frontend/section/before_render', array( $this, 'section_render_attributes' ) );
        // add_action( 'elementor/frontend/column/before_render' , array( $this, 'column_render_attributes' ) );
        add_action( 'elementor/frontend/widget/before_render' , array( $this, 'render_attributes' ) );

    }


    /**
     * Modify the render of section element
     *
     * @return void
     */
    public function section_render_attributes( $section ){
        $section->add_render_attribute( '_wrapper', 'class', 'etheme-parallax-widget');
        $section->add_render_attribute( '_wrapper', [ 'data-scroll-container' => ''] );
    }

    /**
     * Modify the render of column element
     *
     * @return void
     */
    public function column_render_attributes( $column ){
        $column->add_render_attribute( '_wrapper', [ 'data-scroll-section' => ''] );
    }


    /**
     * Add extra controls to advanced section
     *
     * @return void
     */
    public function add_parallax_controls_section( $widget, $section_id, $args ){

        if( in_array( $widget->get_name(), array('section') ) ){
            return;
        }

        // Hook element section
        $target_sections = array('section_custom_css');

        if( ! defined('ELEMENTOR_PRO_VERSION') ) {
            $target_sections[] = 'section_custom_css_pro';
        }

        if( ! in_array( $section_id, $target_sections ) ){
            return;
        }

        $widget->start_controls_section(
            'etheme_common_parallax_section',
            array(
                'label'     => __( 'Parallax Pro', 'xstore-core' ),
                'tab'       => Controls_Manager::TAB_ADVANCED
            )
        );

        $widget->add_control(
            'parallax_enabled',
            array(
                'label'        => __( 'Enable Parallax', 'xstore-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'xstore-core' ),
                'label_off'    => __( 'Off', 'xstore-core' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'separator'    => 'before'
            )
        );

        $widget->add_control(
            'parallax_speed',
            array(
                'label'      => __('Parallax Speed','xstore-core' ),
                'type'       => Controls_Manager::SLIDER,
                'default'   => array(
                    'size' => 8,
                ),
                'range' => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 10,
                        'step' => 0.1
                    )
                ),
                'condition' => array(
                    'parallax_enabled' => 'yes'
                )
            )
        );

        $widget->add_control(
            'parallax_direction',
            array(
                'label'   => __( 'Parallax Direction', 'xstore-core' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'horizontal'     => __( 'Horizontal', 'xstore-core' ),
                    'vertical'  => __( 'Vertical', 'xstore-core' ),
                ),
                'default'   => 'vertical',
                'condition' => array(
                    'parallax_enabled' => 'yes'
                )
            )
        );

        $widget->end_controls_section();
    }

    /**
     * Renders attributes
     *
     * @param  Widget_Base $widget Instance of widget
     *
     * @return void
     */
    public function render_attributes( $widget ){
        $settings = $widget->get_settings();

        // Add parallax attributes
        if( $this->setting_value( $settings, 'parallax_enabled', 'yes' ) ){
            $widget->add_render_attribute( '_wrapper', 
                [
                    'data-scroll'           => '',
                    'data-scroll-speed'     => $this->setting_value( $settings, 'parallax_speed' )['size'],
                    'data-scroll-direction' => $this->setting_value( $settings, 'parallax_direction' ),
                ]
            );            

            $widget->add_render_attribute( '_wrapper', 'class', 'etheme-parallarx-pice');
        }

    }

    private function setting_value( $settings, $key, $value = null ){
        if( ! isset( $settings[ $key ] ) ){
            return;
        }
        // Retrieves the setting value
        if( is_null( $value ) ){
            return $settings[ $key ];
        }
        // Validates the setting value
        return ! empty( $settings[ $key ] ) && $value == $settings[ $key ];
    }

}
