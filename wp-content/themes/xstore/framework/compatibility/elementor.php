<?php
/**
 * Description
 *
 * @package    elementor.php
 * @since      8.0.0
 * @author     stas
 * @link       http://xstore.8theme.com
 * @license    Themeforest Split Licence
 */

defined( 'ABSPATH' ) || exit( 'Direct script access denied.' );

// compatibility with elementor header/footer builders
// rewritten due to a single post template error
function etheme_register_elementor_locations( $elementor_theme_manager ) {
	
	// the default locations
	$core_locations = $elementor_theme_manager->get_core_locations();
	
	// do not rewrite this locations
	unset($core_locations['archive']);
	unset($core_locations['single']);
	
	foreach ( $core_locations as $location => $settings ) {
		// rewrite locations to default
		$elementor_theme_manager->register_location( $location, $settings );
	}
	
	// previse rewritten all locations
	//$elementor_theme_manager->register_all_core_location();
}

add_action( 'elementor/theme/register_locations', 'etheme_register_elementor_locations' );

add_action( "elementor/theme/before_do_header", function() {
	ob_start();
	
	do_action( 'et_after_body', true )
	
	?>
	<div class="template-container">
	
	<?php
	/**
	 * Hook: etheme_header_before_template_content.
	 *
	 * @hooked etheme_top_panel_content - 10
	 * @hooked etheme_mobile_menu_content - 20
	 *
	 * @version 6.0.0 +
	 * @since 6.0.0 +
	 *
	 */
	do_action( 'etheme_header_before_template_content' );
	?>
	<div class="template-content">
	<div class="page-wrapper">
	<?php
	echo ob_get_clean();
} );

add_action( "elementor/theme/before_do_footer", function() {
	ob_start(); ?>
	</div> <!-- page wrapper -->
	
	</div> <!-- template-content -->
	
	<?php do_action('after_page_wrapper'); ?>
	</div> <!-- template-container -->
	<?php echo ob_get_clean();
});

add_action('wp', function () {
	if ( Elementor\Plugin::$instance->preview->is_preview_mode() ) {
	    // disable mega menu lazy load if in Elementor edit mode
		add_filter( 'menu_dropdown_ajax', '__return_false' );
		
	}
});

add_action( 'elementor/frontend/before_register_scripts', function() {
    $scripts = etheme_config_js_files();
    $scripts_2_register = array(
        'etheme_countdown',
        'etheme_animated_headline'
    );
	foreach ($scripts_2_register as $script){
		wp_register_script(
			$scripts[$script]['name'],
			get_template_directory_uri() . $scripts[$script]['file'],
			(isset($scripts[$script]['deps']) ? $scripts[$script]['deps'] : array('jquery', 'etheme')),
			(isset($scripts[$script]['version']) ? $scripts[$script]['version'] : ''),
			$scripts[$script]['in_footer']
		);
	}
//	wp_enqueue_script( 'etheme_countdown', get_template_directory_uri() . '/js/modules/ethemeCountdown.min.js', array( 'etheme'), false, true);
}, 99);
