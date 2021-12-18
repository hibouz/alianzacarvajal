<?php
/**
 * Description
 *
 * @package    lazyload.php
 * @since      8.0.0
 * @author     stas
 * @link       http://xstore.8theme.com
 * @license    Themeforest Split Licence
 */

defined( 'ABSPATH' ) || exit( 'Direct script access denied.' );

// remove lazy on email sent
add_action('woocommerce_email_before_order_table', function(){
	remove_filter( 'wp_get_attachment_image_attributes', 'etheme_lazy_attachment_attrs', 10, 3 );
});
add_action('woocommerce_email_after_order_table', function() {
	add_filter( 'wp_get_attachment_image_attributes', 'etheme_lazy_attachment_attrs', 10, 3 );
});
// woocommerce email header/footer
add_action( 'woocommerce_email_header', function(){
	remove_filter( 'wp_get_attachment_image_attributes', 'etheme_lazy_attachment_attrs', 10, 3 );
});
add_action('woocommerce_email_footer', function() {
	add_filter( 'wp_get_attachment_image_attributes', 'etheme_lazy_attachment_attrs', 10, 3 );
});

add_action( 'wp', 'etheme_lazy_attachment' );

if ( !function_exists('etheme_lazy_attachment')) {
	function etheme_lazy_attachment() {
		add_filter( 'wp_get_attachment_image_attributes', 'etheme_lazy_attachment_attrs', 10, 3 );
	}
}

// **********************************************************************//
// ! add LQIP attr
// **********************************************************************//

if ( !function_exists('etheme_lazy_attachment_attrs')) {
	function etheme_lazy_attachment_attrs( $attr, $attachment, $size ) {
		
		if ( strpos( $attr['class'], 'lazyload' ) !== false || isset( $_GET['vc_editable'] ) ) {
			return $attr;
		}
		
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return $attr;
		}
		
		if ( is_admin() ) {
			return $attr;
		}
		
		$type = get_theme_mod( 'images_loading_type_et-desktop', 'lazy' );
		
		switch ( $type ) {
			case 'lqip':
				// Set LQIP
				if ( $size == 'woocommerce_thumbnail' ) {
					$placeholder = wp_get_attachment_image_src( $attachment->ID, 'etheme-woocommerce-nimi' );
				} else {
					$placeholder = wp_get_attachment_image_src( $attachment->ID, 'etheme-nimi' );
				}

//			$placeholder = $placeholder[0];
			if ( strpos($attr['class'], 'attachment-shop_single') === false  ) {
				$attr['data-src'] = $attr['src'];
			}
				$attr['src']   = $placeholder[0];
				$attr['class'] .= ' lazyload lazyload-lqip et-lazyload-fadeIn';
				break;
			case 'lazy':
				// return $attr;
				$attr['class'] .= ' lazyload lazyload-simple et-lazyload-fadeIn';
				if ( ! isset( $attr['data-src'] ) ) {
					$attr['data-src'] = $attr['src'];
					// only for single product image zoom
//				$attr['data-l-src'] = $attr['src'];
//				if ( isset($attr['data-etheme-single-main']) ){
//					return $attr;
//				}
				}
//			else {
//				$attr['data-src']  = $attr['src'];
//			}
//			unset( $attr['src'] );
				$attr['src'] = etheme_placeholder_image( $size, $attachment->ID );
				break;
			default:
				return $attr;
				break;
		}

//	$attr['data-sizes']    = 'auto';
		
		// Set srcset
		if ( isset( $attr['srcset'] ) ) {
			$attr['data-srcset'] = $attr['srcset'];
			// $attr['srcset'] = $srcset;
			unset( $attr['srcset'] );
		}
		
		return $attr;
	}
}

if( ! function_exists( 'etheme_placeholder_image' ) ) {
	function etheme_placeholder_image( $size, $id = false) {
		
		$uploaded = get_theme_mod( 'preloader_images', '' );
		
		if( ! empty( $uploaded ) && is_array( $uploaded ) && ! empty( $uploaded['url'] ) && ! empty( $uploaded['id'] ) ) {
			return $uploaded['url'];
		}
		
		if ( !$id ) {
			return ETHEME_BASE_URI . 'images/lazy' . ( get_theme_mod( 'dark_styles', 0 ) ? '-dark' : '' ) . '.png';
		}
		
		// Get size from array
		if( is_array( $size) ) {
			$width = $size[0];
			$height = $size[1];
		} else {
			// Take it from the original image
			$image = wp_get_attachment_image_src($id, $size);
			$image = wp_get_attachment_image_src($id, $size);

			if ($image) {
				$width = $image[1];
				$height = $image[2];
			} else {
				$width = 1;
				$height = 1;
			}
		}
		
		$placeholder_size = etheme_get_placeholder_size( $width, $height );
		$width = $placeholder_size[0];
		$height = $placeholder_size[1];
		
		$placeholder_image = (int)get_option( 'xstore_placeholder_image', 0 );
		if ( $placeholder_image ) {
			
			if ( $width == $height ) {
				return wp_get_attachment_image_url( $placeholder_image, array(1,1) );
			}
			
			if ( apply_filters('et_lazy_load_intermediate_size', true) && !image_get_intermediate_size( $placeholder_image, array( absint( $width ), absint( $height ) ) ) ) {
				if ( function_exists( 'wpb_resize' ) ) {
					$image = wpb_resize( $placeholder_image, null, $width, $height, true);
					if ( isset($image['url'])) {
						return $image['url'];
					}
				}
				elseif ( defined('ELEMENTOR_PATH') ) {
					if ( ! class_exists( 'Group_Control_Image_Size' ) ) {
						require_once ELEMENTOR_PATH . '/includes/controls/groups/image-size.php';
					}
					return \Elementor\Group_Control_Image_Size::get_attachment_image_src(
						$placeholder_image,
						'image',
						array(
							'image' => array(
								'id' => $placeholder_image,
							),
							'image_custom_dimension' => array('width' => $width, 'height' => $height),
							'image_size' => 'custom',
							'hover_animation' => ' '
						)
					);
				}
			}
			return wp_get_attachment_image_url( $placeholder_image, $size );
		}
		
		return ETHEME_BASE_URI . 'images/lazy' . ( get_theme_mod( 'dark_styles', 0 ) ? '-dark' : '' ) . '.png';
	}
}


// **********************************************************************//
// Generate placeholder preview small size.
// **********************************************************************//
if( ! function_exists( 'etheme_get_placeholder_size' ) ) {
	function etheme_get_placeholder_size( $x0, $y0 ) {
		
		$x = $y = 100; // could be small but this one good for most images
		
		if( $x0 < $y0) {
			$y = ($x * $y0) / $x0;
		}
		
		if( $x0 > $y0) {
			$x = ($y * $x0) / $y0;
		}
		
		return array((int) ceil( $x ), (int) ceil( $y ) );
	}
}