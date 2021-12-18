<?php
namespace ETC\App\Controllers;

use ETC\App\Controllers\Base_Controller;

/**
 * Import controller.
 *
 * @since      1.4.4
 * @package    ETC
 * @subpackage ETC/Controller
 */
class General extends Base_Controller {

	function hooks() {
		// Allow HTML in term (category, tag) descriptions
		foreach ( array( 'pre_term_description' ) as $filter ) {
			remove_filter( $filter, 'wp_filter_kses' );
		}

		foreach ( array( 'term_description' ) as $filter ) {
			remove_filter( $filter, 'wp_kses_data' );
		}

		add_filter( 'style_loader_src', array( $this, 'etheme_remove_cssjs_ver' ), 10, 2 );
		add_filter( 'script_loader_src', array( $this, 'etheme_remove_cssjs_ver' ), 10, 2 );
		add_action( 'init', array( $this, 'etheme_disable_emojis' ) );
		// Add button to adminbar panel
		add_action( 'admin_bar_menu', array( $this, 'top_bar_menu' ), 100 );
	}

	function etheme_remove_cssjs_ver( $src ) {
		if ( function_exists( 'etheme_get_option' ) && etheme_get_option( 'cssjs_ver', 0 ) ) {

            // ! Do not do it for revslider and essential-grid.
			if ( strpos( $src, 'revslider' ) || strpos( $src, 'essential-grid' ) ) return $src;

			if( strpos( $src, '?ver=' ) ) $src = remove_query_arg( 'ver', $src );
		}
		return $src;   
	}

	function etheme_disable_emojis() {
		if ( function_exists( 'etheme_get_option' ) && etheme_get_option( 'disable_emoji', 0 ) ) {
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		}
	}

	function top_bar_menu( $wp_admin_bar ) {
		if ( ! defined( 'ETHEME_CODE_IMAGES' ) || ! current_user_can('manage_options') ) {
           return;
        }

		$xstore_branding_settings = get_option( 'xstore_white_label_branding_settings', array() );

        $result = true;

        if ( class_exists('Etheme_System_Requirements') ) {
            $system = new \Etheme_System_Requirements();
            $system->system_test();
            $result = $system->result();
        } elseif( defined('ETHEME_CODE') && is_user_logged_in() && current_user_can('administrator') ) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once( apply_filters('etheme_file_url', ETHEME_CODE . 'system-requirements.php') );

            $system = new \Etheme_System_Requirements();
            $system->system_test();
            $result = $system->result();
        }

        $theme_activated = etheme_is_activated();
        $is_admin = is_admin();

        $info = '<span class="awaiting-mod mtips mtips-right" style="position: relative;min-width: 16px;height: 16px;margin: 0px 0 0 7px;background: #fff;line-height: 1;display: inline-block;width: 10px;height: 10px;min-width: unset;">';
        $info .= '<span class="dashicons dashicons-warning" style="width: auto;height: auto;font-size: 20px;font-family: dashicons;line-height: 1;border-radius: 50%;color: var(--et_admin_orange-color, #f57f17);position: absolute;top: -5px;left: -5px;"></span>';
        if ( $is_admin ) {
	        $info .= '<span class="mt-mes" style="line-height: 1; margin-top: -13px; border-radius: 3px;">' . __( 'Upgrade Your System Requirements', 'xstore-core' ) . '</span>';
        }
        $info .= '</span>';
		
		$is_update_support = 'active';
		$support_day_left = 0;
		if (
			$theme_activated
			&& (
				! isset($xstore_branding_settings['control_panel']['hide_updates'])
				|| $xstore_branding_settings['control_panel']['hide_updates'] != 'on'
			)
		){
			if (! class_exists('ETheme_Version_Check') && defined('ETHEME_CODE') && is_user_logged_in() ){
				require_once( apply_filters('etheme_file_url', ETHEME_CODE . 'version-check.php') );
			}
			$check_update = new \ETheme_Version_Check(false);
			$is_update_available = $check_update->is_update_available();
//			if ( method_exists( $check_update, 'get_support_status' ) ) {
//				$is_update_support = $check_update->get_support_status();
//			}
//			if ( method_exists( $check_update, 'get_support_day_left' ) ) {
//				$support_day_left = $check_update->get_support_day_left();
//			}
			$is_update_support = 'active';
		} else {
			$is_update_available = false;
		}
		if ($theme_activated && $is_update_support !='active' && $result){
			if ($is_update_support == 'expire-soon'){
				$info = '<span class="awaiting-mod mtips mtips-right" style="position: relative;min-width: 16px;height: 16px;margin: 0px 0 0 7px;background: #fff;line-height: 1;display: inline-block;width: 10px;height: 10px;min-width: unset;"><span class="dashicons dashicons-warning" style="width: auto;height: auto;font-size: 20px;font-family: dashicons;line-height: 1;border-radius: 50%;color: #f57f17;position: absolute;top: -5px;left: -5px;"></span>{{et_info}}</span>';
				if ( $is_admin ) {
					$info = str_replace( '{{et_info}}', '<span class="mt-mes" style="line-height: 1; margin-top: -13px; border-radius: 3px;">' . __( 'Support Expired in', 'xstore-core' ) . ' ' . $support_day_left . ' ' . _nx( 'Day', 'Days', $support_day_left, 'Support day/days left', 'xstore-core' ) . '</span>', $info );
				}
			} else {
				$info = '<span class="awaiting-mod mtips mtips-right" style="position: relative;min-width: 16px;height: 16px;margin: 0px 0 0 7px;background: #fff;line-height: 1;display: inline-block;width: 10px;height: 10px;min-width: unset;"><span class="dashicons dashicons-warning" style="width: auto;height: auto;font-size: 20px;font-family: dashicons;line-height: 1;border-radius: 50%;color: #c62828;position: absolute;top: -5px;left: -5px;"></span>{{et_info}}</span>';
				if ( $is_admin ) {
					$info = str_replace( '{{et_info}}', '<span class="mt-mes" style="line-height: 1; margin-top: -13px; border-radius: 3px;">' . __( 'Support Expired', 'xstore-core' ) . '</span>', $info );
				}
			}
		} elseif ($theme_activated && $is_update_available && $result ){
			$info = '<span class="awaiting-mod mtips mtips-right" style="position: relative;min-width: 16px;height: 16px;margin: 0px 0 0 7px;background: #fff;line-height: 1;display: inline-block;width: 10px;height: 10px;min-width: unset;"><span class="dashicons dashicons-warning" style="width: auto;height: auto;font-size: 20px;font-family: dashicons;line-height: 1;border-radius: 50%;color: var(--et_admin_green-color, #489C33);position: absolute;top: -5px;left: -5px;"></span>{{et_info}}</span>';
			if ( $is_admin ) {
				$info = str_replace( '{{et_info}}', '<span class="mt-mes" style="line-height: 1; margin-top: -13px; border-radius: 3px;">' . __( 'Update Available', 'xstore-core' ) . '</span>', $info );
			}
		} elseif(!$theme_activated){
			//$info = '<span class="awaiting-mod mtips mtips-right" style="position: relative;min-width: 16px;height: 16px;margin: 0px 0 0 7px;background: #fff;line-height: 1;display: inline-block;width: 10px;height: 10px;min-width: unset;"><span class="dashicons dashicons-warning" style="width: auto;height: auto;font-size: 20px;font-family: dashicons;line-height: 1;border-radius: 50%;color: #c62828;position: absolute;top: -5px;left: -5px;"></span>{{et_info}}</span>';
			$info = '<span class="awaiting-mod mtips mtips-right" style="position: relative;min-width: 16px;height: 16px;margin: 0px 0 0 7px;background: #fff;line-height: 1;display: inline-block;width: 10px;height: 10px;min-width: unset;"><span class="dashicons dashicons-warning" style="width: auto;height: auto;font-size: 20px;font-family: dashicons;line-height: 1;border-radius: 50%;color: #f57f17;position: absolute;top: -5px;left: -5px;"></span>{{et_info}}</span>';
			if ( $is_admin ) {
				$info = str_replace( '{{et_info}}', '<span class="mt-mes" style="line-height: 1; margin-top: -13px; border-radius: 3px;">' . __( 'Theme Isn\'t Registered', 'xstore-core' ) . '</span>', $info );
			}
		}
		
		if ( !$is_admin ) {
			$info = str_replace( array('{{et_info}}', 'mtips-right', 'mtips '), array('','',''), $info);
		}
		
		$title_logo = ETHEME_CODE_IMAGES . 'wp-icon.svg';
		$title_text = 'XStore';
		
		if ( count($xstore_branding_settings) ) {
			if ( $xstore_branding_settings['control_panel']['icon'] ) {
				$title_logo = $xstore_branding_settings['control_panel']['icon'];
			}
			if ( $xstore_branding_settings['control_panel']['label'] ) {
				$title_text = $xstore_branding_settings['control_panel']['label'];
			}
		}

		$title = '
            <span class="ab-label"><img class="et-logo" style="vertical-align: -4px; margin-right: 5px; max-width: 18px;" src="' . $title_logo . '" alt="xstore"><span>' . $title_text . '</span>' . ( ( !$theme_activated || ! $result || $is_update_available ) ? $info : '' ) . '</span>
        ';

        $new_label = '<span style="margin-left: 3px; background: var(--et_admin_green-color, #489c33); letter-spacing: 1px; display: inline-block; text-transform: lowercase; border-radius: 3px; color: #fff; padding: 3px 2px 2px 3px; text-transform: uppercase; font-size: 8px; line-height: 1;">'.esc_html__('new', 'xstore-core').'</span>';
		$hot_label = '<span style="margin-left: 3px; background: var(--et_admin_main-color, #A4004F); letter-spacing: 1px; display: inline-block; text-transform: lowercase; border-radius: 3px; color: #fff; padding: 3px 2px 2px 3px; text-transform: uppercase; font-size: 8px; line-height: 1;">'.esc_html__('hot', 'xstore-core').'</span>';
		
		$show_pages = array(
			'welcome',
			'system_requirements',
			'demos',
			'plugins',
			'customize',
			'generator',
			'email_builder',
			'sales_booster',
			'custom_fonts',
			'social',
			'support',
			'changelog',
			'sponsors'
		);
		
		if ( count($xstore_branding_settings) && isset($xstore_branding_settings['control_panel'])) {
			$show_pages_parsed = array();
			foreach ( $show_pages as $show_page ) {
				if ( isset($xstore_branding_settings['control_panel']['page_'.$show_page]))
					$show_pages_parsed[] = $show_page;
			};
			$show_pages = $show_pages_parsed;
		}
		
        $args = array(
            'id'    => 'et-top-bar-menu',
            'title' => $title,
            'href'  => admin_url( 'admin.php?page=et-panel-welcome' ),
        );
        
        $wp_admin_bar->add_node( $args );
		
		if ( in_array('welcome', $show_pages) ) {
			$wp_admin_bar->add_node( array(
				'parent' => 'et-top-bar-menu',
				'id'     => 'et-panel-welcome',
				'title'  => esc_html__( 'Dashboard', 'xstore-core' ).' '. (($theme_activated && $is_update_support !='active' && $result) ? $info : ''),
				'href'   => admin_url( 'admin.php?page=et-panel-welcome' ),
			) );
		}

		if ( in_array('system_requirements', $show_pages) ) {
			$wp_admin_bar->add_node( array(
				'parent' => 'et-top-bar-menu',
				'id'     => 'et-panel-system-requirements',
				'title'  => esc_html__( 'Server Requirements', 'xstore-core' ) . ' ' . ( (! $result ) ? $info : '' ),
				'href'   => admin_url( 'admin.php?page=et-panel-system-requirements' ),
			) );
		}

        if ( ! $theme_activated && ! class_exists( 'Kirki' ) ) {
            // $wp_admin_bar->add_node( array(
            //     'parent' => 'et-top-bar-menu',
            //     'id'     => 'et-setup-wizard',
            //     'title'  => esc_html__( 'Customization', 'xstore-core' ),
            //     'href'   => admin_url( 'themes.php?page=xstore-setup' ),
            // ) );
        } elseif( ! $theme_activated ){
	        if ( in_array('customize', $show_pages) ) {
		        $wp_admin_bar->add_node( array(
			        'parent' => 'et-top-bar-menu',
			        'id'     => 'et-panel-options',
			        'title'  => esc_html__( 'Theme Options', 'xstore-core' ),
			        'href'   => wp_customize_url(),
		        ) );
	        }
        }
        // @check
        // elseif( ! class_exists( 'Kirki' ) ){
	       //  if ( in_array('plugins', $show_pages) ) {
		      //   $wp_admin_bar->add_node( array(
			     //    'parent' => 'et-top-bar-menu',
			     //    'id'     => 'et-panel-plugins',
			     //    'title'  => esc_html__( 'Plugin Installer', 'xstore-core' ) . $new_label,
			     //    'href'   => admin_url( 'admin.php?page=et-panel-plugins' ),
		      //   ) );
	       //  }
        // } 
        else {
	        if ( in_array('demos', $show_pages) ) {
		        $wp_admin_bar->add_node( array(
			        'parent' => 'et-top-bar-menu',
			        'id'     => 'et-panel-demos',
			        'title'  => esc_html__( 'Import Demos', 'xstore-core' ),
			        'href'   => admin_url( 'admin.php?page=et-panel-demos' ),
		        ) );
	        }
	        if ( in_array('plugins', $show_pages) ) {
		        $wp_admin_bar->add_node( array(
			        'parent' => 'et-top-bar-menu',
			        'id'     => 'et-panel-plugins',
			        'title'  => esc_html__( 'Plugin Installer', 'xstore-core' ) . $hot_label,
			        'href'   => admin_url( 'admin.php?page=et-panel-plugins' ),
		        ) );
	        }
	        if ( in_array('generator', $show_pages) ) {
		        $wp_admin_bar->add_node( array(
			        'parent' => 'et-top-bar-menu',
			        'id'     => 'et-panel-generator',
			        'title'  => esc_html__( 'Files Generator', 'xstore-core' ), //. $new_label,
			        'href'   => admin_url( 'admin.php?page=et-panel-generator' ),
		        ) );
	        }
            if ( $theme_activated && in_array('customize', $show_pages) ) {
	            $wp_admin_bar->add_node( array(
	                'parent' => 'et-top-bar-menu',
	                'id'     => 'et-panel-options',
	                'title'  => esc_html__( 'Theme Options', 'xstore-core' ),
	                'href'   => wp_customize_url(),
	            ) );
	        }
	        if ( in_array('customize', $show_pages) ) {
		        $wp_admin_bar->add_node( array(
			        'parent' => 'et-top-bar-menu',
			        'id'     => 'et-panel-header-builder',
			        'title'  => esc_html__( 'Header Builder', 'xstore-core' ),
			        'href'   => admin_url( '/customize.php?autofocus[panel]=header-builder' ),
		        ) );
		        if ( get_option( 'etheme_single_product_builder', false ) ) {
			        $wp_admin_bar->add_node( array(
				        'parent' => 'et-top-bar-menu',
				        'id'     => 'et-panel-single-product-builder',
				        'title'  => esc_html__( 'Single Product Builder', 'xstore-core' ),
				        'href'   => admin_url( '/customize.php?autofocus[panel]=single_product_builder' ),
			        ) );
		        } else {
			        $wp_admin_bar->add_node( array(
				        'parent' => 'et-top-bar-menu',
				        'id'     => 'et-panel-single-product-builder',
				        'title'  => esc_html__( 'Single Product Builder', 'xstore-core' ),
				        'href'   => admin_url( '/customize.php?autofocus[section]=single_product_builder' ),
			        ) );
		        }
	        }
        }
		
        if ( class_exists('WooCommerce') ) {
	        if ( in_array( 'email_builder', $show_pages ) ) {
		        $wp_admin_bar->add_node( array(
			        'parent' => 'et-top-bar-menu',
			        'id'     => 'et-panel-email-builder',
			        'title'  => esc_html__( 'Built-in Email Builder', 'xstore-core' ). $hot_label,
			        'href'   => admin_url( 'admin.php?page=et-panel-email-builder' ),
		        ) );
	        }
	        if ( in_array( 'sales_booster', $show_pages ) ) {
		        $wp_admin_bar->add_node( array(
			        'parent' => 'et-top-bar-menu',
			        'id'     => 'et-panel-sales-booster',
			        'title'  => esc_html__( 'Sales Booster', 'xstore-core' )  . $new_label,
			        'href'   => admin_url( 'admin.php?page=et-panel-sales-booster' ),
		        ) );
	        }
        }

        if ( $theme_activated ) {
	
	        if ( in_array('social', $show_pages) ) {
		        $wp_admin_bar->add_node( array(
			        'parent' => 'et-top-bar-menu',
			        'id'     => 'et-panel-social',
			        'title'  => esc_html__( 'Authorization APIs', 'xstore-core' ),
			        'href'   => admin_url( 'admin.php?page=et-panel-social' ),
		        ) );
	        }
	
	        if ( in_array('custom_fonts', $show_pages) ) {
		        $wp_admin_bar->add_node( array(
			        'parent' => 'et-top-bar-menu',
			        'id'     => 'et-panel-custom-fonts',
			        'title'  => esc_html__( 'Custom Fonts', 'xstore-core' ),
			        'href'   => admin_url( 'admin.php?page=et-panel-custom-fonts' ),
		        ) );
	        }
	
	        if ( in_array('support', $show_pages) ) {
		        $wp_admin_bar->add_node( array(
			        'parent' => 'et-top-bar-menu',
			        'id'     => 'et-panel-support',
			        'title'  => esc_html__( 'Tutorials & Support', 'xstore-core' ),
			        'href'   => admin_url( 'admin.php?page=et-panel-support' ),
		        ) );
	        }
	    }
	}
}