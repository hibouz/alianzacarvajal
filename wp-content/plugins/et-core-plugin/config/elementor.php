<?php
/**
 *	Register routes 
 */
add_filter( 'etc/add/elementor/widgets', 'etc_elementor_widgets_routes' );
function etc_elementor_widgets_routes( $routes ) {

	// let's make it in alphabetical sorting 

	$check_function = function_exists( 'etheme_get_option' );

	$routes[] = array(
		'ETC\App\Controllers\Elementor\General\Banner', // +
		// 'ETC\App\Controllers\Elementor\General\Blog',
		'ETC\App\Controllers\Elementor\General\Blog_Carousel', // +
		// 'ETC\App\Controllers\Elementor\General\Blog_List',
		// 'ETC\App\Controllers\Elementor\General\Blog_Timeline',
	);

	if( $check_function ){

		if ( etheme_get_option( 'enable_brands', 1 ) ) {
			$routes[] = array(
				'ETC\App\Controllers\Elementor\General\Brands',
				// 'ETC\App\Controllers\Elementor\General\Brands_List',
			);
		}

	}

	$routes[] = array(
		// 'ETC\App\Controllers\Elementor\General\Carousel', //
		 'ETC\App\Controllers\Elementor\General\Categories',
		 'ETC\App\Controllers\Elementor\General\Categories_lists',
		// 'ETC\App\Controllers\Elementor\General\Category',
		'ETC\App\Controllers\Elementor\General\Contact_Form_7',
		'ETC\App\Controllers\Elementor\General\Custom_Products_Masonry',
		'ETC\App\Controllers\Elementor\General\Custom_Product_Categories_Masonry',
		'ETC\App\Controllers\Elementor\General\Custom_Posts_Masonry',
//		 'ETC\App\Controllers\Elementor\General\Fancy_Button',
		'ETC\App\Controllers\Elementor\General\Follow', // +
		'ETC\App\Controllers\Elementor\General\Google_Map',
		// 'ETC\App\Controllers\Elementor\General\Icon_Box',
		'ETC\App\Controllers\Elementor\General\Instagram', // +-
		// 'ETC\App\Controllers\Elementor\General\Looks',
		// 'ETC\App\Controllers\Elementor\General\Menu',
		// 'ETC\App\Controllers\Elementor\General\Mail_Chimp',
		'ETC\App\Controllers\Elementor\General\Menu_List', // +
	    'ETC\App\Controllers\Elementor\General\Portfolio',
		// 'ETC\App\Controllers\Elementor\General\Portfolio_Recent',
		'ETC\App\Controllers\Elementor\General\Products', // +
		'ETC\App\Controllers\Elementor\General\Product_Menu_Layout',
		// 'ETC\App\Controllers\Elementor\General\Scroll_Text',
		'ETC\App\Controllers\Elementor\General\Slider', // +
		// 'ETC\App\Controllers\Elementor\General\Special_Offer',
		'ETC\App\Controllers\Elementor\General\Team_Member', // +
		'ETC\App\Controllers\Elementor\General\Tabs',
		'ETC\App\Controllers\Elementor\General\Advanced_Tabs',
		'ETC\App\Controllers\Elementor\General\Testimonials'
	);

	$routes[] = array(
		// 'ETC\App\Controllers\Elementor\General\Title',
		// 'ETC\App\Controllers\Elementor\General\Twitter',
	);
	
	// new widgets
	$routes[] = array(
		'ETC\App\Controllers\Elementor\General\Countdown',
		'ETC\App\Controllers\Elementor\General\Text_Button',
		'ETC\App\Controllers\Elementor\General\Blockquote',
//		'ETC\App\Controllers\Elementor\General\Price_Table',
		'ETC\App\Controllers\Elementor\General\HotSpot',
//		'ETC\App\Controllers\Elementor\General\FlipBox',
//		'ETC\App\Controllers\Elementor\General\Animated_Headline',
	);

	return $routes;
}

/**
 *	Register modules 
 */
add_filter( 'etc/add/elementor/modules', 'etc_elementor_modules' );
function etc_elementor_modules( $modules ) {

	$modules['general'] = array(
		'class'	=>	'ETC\App\Controllers\Elementor\Modules\General',
		'class'	=>	'ETC\App\Controllers\Elementor\Modules\CSS',
	);

	return $modules;
}

/**
 *	Register controls 
 */
add_filter( 'etc/add/elementor/controls', 'etc_elementor_controls' );
function etc_elementor_controls( $controls ) {

	$controls['etheme-ajax-product'] = array(
		'class'	=>	'ETC\App\Controllers\Elementor\Controls\Ajax_Product',
	);

	return $controls;
}

// /**
//  *	Icon control
//  */
// add_filter( 'elementor/editor/localize_settings', 'dddddddddddddddddddddddd' );
// function dddddddddddddddddddddddd( $config ) {
// 	$config['schemes']['items']['color']['items']['1']['value'] = '#fff';
// 	write_log( $config['schemes'] );

// 	return $config;
// }

// add_action( 'elementor/widgets/widgets_registered', 'etc_check_color_scheme_update' );
// function etc_check_color_scheme_update() {

// 	// if ( get_option( 'etc_scheme_color', true ) ) {
// 	// 	write_log('sssssssssss');
// 	// 	$kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();
// 	// 	$kit = \Elementor\Plugin::$instance->documents->get( $kit_id );

// 	// 	$kit->add_repeater_row( 'custom_colors', [
// 	// 		'_id' => \Elementor\Utils::generate_random_string(),
// 	// 		'title' => 'New Color',
// 	// 		'color' => '#fff',
// 	// 	] );

// 	// 	update_option( 'etc_scheme_color', false );		
// 	// }

// 	$theme_color_scheme = array(
// 		"1" => "#111111",
// 		"2" => "#222222",
// 		"3" => "#333333",
// 		"4" => "#444444"
// 	);
// 	$schemes_manager = new \Elementor\Schemes_Manager();

// 	$scheme_obj = $schemes_manager->get_scheme('color');
// 	$scheme_obj->save_scheme($theme_color_scheme);

// }
