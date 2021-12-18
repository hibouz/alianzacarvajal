<?php

/**
 *
 * @package     XStore theme
 * @author      8theme
 * @version     1.0.1
 * @since       3.2.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Don't duplicate me!
if ( ! class_exists( 'Etheme_Sales_Booster_Backend' ) ) {
	
	
	/**
	 * Main Etheme_Sales_Booster_Backend class
	 *
	 * @since       3.2.2
	 */
	class Etheme_Sales_Booster_Backend {
		
		/**
		 * Projects.
		 *
		 * @var array
		 * @since 3.2.2
		 */
		private $settings = [],
			$dir_url,
			$settings_name,
			$icons;
		
		/**
		 * Class Constructor. Defines the args for the actions class
		 *
		 * @return      void
		 * @version 1.0.0
		 * @since 3.2.2
		 * @access      public
		 */
		public function __construct() {
			
            $this->dir_url = ET_CORE_URL . 'app/models/sales-booster';
            
            $this->settings_name = 'xstore_sales_booster_settings';
            
            $this->settings = (array)get_option( $this->settings_name, array() );
            
            $this->icons = array(
                'simple' => array(
                    'et_icon-delivery'        => esc_html__( 'Delivery', 'xstore-core' ),
                    'et_icon-coupon'          => esc_html__( 'Coupon', 'xstore-core' ),
                    'et_icon-calendar'        => esc_html__( 'Calendar', 'xstore-core' ),
                    'et_icon-compare'         => esc_html__( 'Compare', 'xstore-core' ),
                    'et_icon-checked'         => esc_html__( 'Checked', 'xstore-core' ),
                    'et_icon-chat'            => esc_html__( 'Chat', 'xstore-core' ),
                    'et_icon-phone'           => esc_html__( 'Phone', 'xstore-core' ),
                    'et_icon-whatsapp'        => esc_html__( 'Whatsapp', 'xstore-core' ),
                    'et_icon-exclamation'     => esc_html__( 'Exclamation', 'xstore-core' ),
                    'et_icon-gift'            => esc_html__( 'Gift', 'xstore-core' ),
                    'et_icon-heart'           => esc_html__( 'Heart', 'xstore-core' ),
                    'et_icon-message'         => esc_html__( 'Message', 'xstore-core' ),
                    'et_icon-internet'        => esc_html__( 'Internet', 'xstore-core' ),
                    'et_icon-account'         => esc_html__( 'Account', 'xstore-core' ),
                    'et_icon-sent'            => esc_html__( 'Sent', 'xstore-core' ),
                    'et_icon-home'            => esc_html__( 'Home', 'xstore-core' ),
                    'et_icon-shop'            => esc_html__( 'Shop', 'xstore-core' ),
                    'et_icon-shopping-bag'    => esc_html__( 'Bag', 'xstore-core' ),
                    'et_icon-shopping-cart'   => esc_html__( 'Cart', 'xstore-core' ),
                    'et_icon-shopping-cart-2' => esc_html__( 'Cart 2', 'xstore-core' ),
                    'et_icon-burger'          => esc_html__( 'Burger', 'xstore-core' ),
                    'et_icon-star'            => esc_html__( 'Star', 'xstore-core' ),
                    'et_icon-time'            => esc_html__( 'Time', 'xstore-core' ),
                    'et_icon-size'            => esc_html__( 'Size', 'xstore-core' ),
                    'et_icon-more'            => esc_html__( 'More', 'xstore-core' ),
                    'none'                    => esc_html__( 'None', 'xstore-core' ),
                ),
            );
            
            $this->load_scripts();
			
		}
		
		/**
		 * Load css/js for section.
		 *
		 * @return void
		 * @version 1.0.0
		 * @since 3.2.2
		 *
		 */
		public function load_scripts() {
			
			global $pagenow;
			
			$screen    = get_current_screen();
			$screen_id = $screen ? $screen->id : '';
			
			if ( strpos($screen_id, 'et-panel-sales-booster') ) {
				
				wp_enqueue_script( 'jquery-color' );
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker' );
				
				wp_enqueue_media();
				
				wp_enqueue_style( 'xstore_sales_booster_admin_css', $this->dir_url . '/assets/css/style.css' );
				wp_enqueue_script( 'xstore_sales_booster_admin_js', $this->dir_url . '/assets/js/script.js', array('wp-color-picker') );
				
				$config = array(
					'ajaxurl'          => admin_url( 'admin-ajax.php' ),
					'resetOptions'     => __( 'All your settings will be reset to default values. Are you sure you want to do this ?', 'xstore-core' ),
					'pasteYourOptions' => __( 'Please, paste your options there.', 'xstore-core' ),
					'loadingOptions'   => __( 'Loading options', 'xstore-core' ) . '...',
					'ajaxError'        => __( 'Ajax error', 'xstore-core' ),
					'audioPlaceholder' => ET_CORE_URL . 'app/models/sales-booster/images/audio.png',
				);
				
				wp_localize_script( 'xstore_sales_booster_admin_js', 'XStoreSalesBoosterConfig', $config );
				
			}
		}
		
		/**
		 * Load wp ajax actions.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function load_actions() {
			
			add_action( 'wp_ajax_sales_booster_search_product', array( $this, 'search_product' ) );
			
			add_action( 'wp_ajax_sales_booster_search_category', array( $this, 'search_category' ) );
			
			add_action( 'wp_ajax_sales_booster_save_settings', array( $this, 'save_settings' ) );
		}
		
		/**
		 * Section content html.
		 *
		 * @return void
		 * @version 1.0.0
		 * @since 3.2.2
		 *
		 */
		public function sales_booster_page() {
			
			ob_start();
			?>

            <h2 class="etheme-page-title etheme-page-title-type-2"><?php echo '🚀&nbsp;&nbsp;' . esc_html__( 'Sales Booster', 'xstore-core' ); ?></h2>
            <p class="et-message et-info">
				<?php echo '<strong>' . esc_html__( 'Welcome to the Sales Booster panel!', 'xstore-core' ) . '</strong> &#127881'; ?>
            </p>
            <ul class="et-filters et-tabs-filters">
                <li class="active" data-tab="fake_sale_popup">
                    1. <?php echo esc_html__( 'Fake Sale Popup', 'xstore-core' ); ?></li>
                <li data-tab="progress_bar">2. <?php echo esc_html__( 'Progress Bar', 'xstore-core' ); ?></li>
                <li data-tab="request_quote">3. <?php echo esc_html__( 'Request a quote', 'xstore-core' ); ?></li>
            </ul>
			<?php
			$tab_content      = 'fake_sale_popup';
			$settings_enabled = get_option( $this->settings_name . '_' . $tab_content, false );
			?>
            <div class="et-tabs-content active" data-tab-content="<?php echo esc_attr( $tab_content ); ?>">
                <div class="tab-preview">
                    <img src="<?php echo $this->dir_url . '/images/' . $tab_content . '.jpg'; ?>" alt="">
                    <div>
                        <h4><?php echo esc_html__( 'Enable Fake Sale Popup', 'xstore-core' ) . ':'; ?></h4>
                        <label class="et-panel-option-switcher<?php if ( $settings_enabled ) { ?> switched<?php } ?>"
                               for="<?php echo esc_attr( $this->settings_name ) . '_' . $tab_content; ?>">
                            <input type="checkbox" id="<?php echo esc_attr( $this->settings_name ) . '_' . $tab_content; ?>"
                                   name="<?php echo esc_attr( $this->settings_name ) . '_' . $tab_content; ?>"
                                   <?php if ( $settings_enabled ) { ?>checked<?php } ?>>
                            <span></span>
                        </label>
                    </div>
                </div>
                <br/>
                <br/>
				<?php if ( $settings_enabled ): ?>
                    <form class="xstore-panel-settings" method="post">

                        <div class="xstore-panel-settings-inner">
							
							<?php $this->multicheckbox_field_type( $tab_content,
								'elements',
								esc_html__( 'Elements', 'xstore-core' ),
								'Use this option to enable/disable popup elements.',
								array(
									'image'    => esc_html__( 'Image', 'xstore-core' ),
									'title'    => esc_html__( 'Title', 'xstore-core' ),
									'price'    => esc_html__( 'Price', 'xstore-core' ),
									'time'     => esc_html__( 'Time ago (hours, mins)', 'xstore-core' ),
									'location' => esc_html__( 'Location', 'xstore-core' ),
									'button'   => esc_html__( 'Button', 'xstore-core' ),
									'close'    => esc_html__( 'Close', 'xstore-core' ),
								),
								array(
									'image',
									'title',
									'time',
									'location',
									'button',
									'close',
								)
							); ?>
							
							<?php $this->input_text_field_type( $tab_content,
								'bag_icon',
								esc_html__( 'Bag emoji icon', 'xstore-core' ),
								esc_html__( 'Write emoji icon, 1 (to leave default one) or leave empty to remove it', 'xstore-core' ),
								false,
								1 ); ?>
							
							<?php $this->select_field_type( $tab_content,
								'products_type',
								esc_html__( 'Show product source', 'xstore-core' ),
								false,
								array(
//                                        'recently_viewed' => esc_html__('Recently viewed', 'xstore-core'),
									'featured'     => esc_html__( 'Featured', 'xstore-core' ),
									'sale'         => esc_html__( 'On sale', 'xstore-core' ),
									'bestsellings' => esc_html__( 'Bestsellings', 'xstore-core' ),
									'random'       => esc_html__( 'Random', 'xstore-core' ),
								),
								'random' ); ?>
							
							<?php $this->switcher_field_type( $tab_content,
								'hide_outofstock_products',
								esc_html__( 'Hide out of stock products', 'xstore-core' ),
								false,
								false ); ?>
							
							<?php $this->switcher_field_type( $tab_content,
								'play_sound',
								esc_html__( 'Sound notification', 'xstore-core' ),
								esc_html__( 'Modern browsers recently changed their policy to let users able to disable auto play audio so this option is not working correctly now. ', 'xstore-core' ) .
								'<a href="https://developers.google.com/web/updates/2017/09/autoplay-policy-changes" target="_blank">' . esc_html__( 'More details', 'xstore-core' ) . '</a>' ); ?>
							
							<?php $this->upload_field_type( $tab_content,
								'sound_file',
								esc_html__( 'Custom audio file', 'xstore-core' ),
								false,
								'audio' ); ?>
							
							<?php $this->switcher_field_type( $tab_content,
								'show_on_mobile',
								esc_html__( 'Show on mobile', 'xstore-core' ),
								false,
								true ); ?>
							
							<?php $this->textarea_field_type( $tab_content,
								'locations',
								esc_html__( 'Locations description', 'xstore-core' ),
								'{{{Washington D.C., USA 🇺🇸}}}; {{{London, UK 🇬🇧}}}; {{{New Delhi, India 🇮🇳}}}',
								'{{{Washington D.C., USA 🇺🇸}}}; {{{London, UK 🇬🇧}}}; {{{Madrid, Spain 🇪🇸}}}; {{{Berlin, Germany 🇩🇪}}}; {{{New Delhi, India 🇮🇳}}}; {{{Ottawa, Canada 🇨🇦}}}; {{{Paris, France 🇫🇷}}}; {{{Rome, Italy 🇮🇹}}}; {{{Dhaka, Bangladesh 🇧🇩}}}; {{{Kiev, Ukraine 🇺🇦}}}; {{{Islamabad, Pakistan 🇵🇰}}}; {{{Athens, Greece 🇬🇷}}}; {{{Brasilia, Brazil 🇧🇷}}}; {{{Lima, Peru 🇵🇪}}}; {{{Ankara, Turkey 🇹🇷}}}; {{{Colombo, Sri Lanka 🇱🇰}}}; {{{Warsaw, Poland 🇵🇱}}}; {{{Amsterdam, Netherlands 🇳🇱}}}; {{{Mexico City, Mexico 🇲🇽}}}; {{{Canberra, Australia 🇦🇺}}}'); ?>
							
							<?php $this->slider_field_type( $tab_content,
								'repeat_every',
								esc_html__( 'Repeat every x seconds', 'xstore-core' ),
								false,
								3,
								300,
								15,
								1,
								's' ); ?>
							
							<?php $this->select_field_type( $tab_content,
								'animation_type',
								esc_html__( 'Popup animation', 'xstore-core' ),
								false,
								array(
									'slide_right' => esc_html__( 'Slide right', 'xstore-core' ),
									'slide_up'    => esc_html__( 'Slide up', 'xstore-core' ),
								) ); ?>

                        </div>

                        <button class="et-button et-button-green no-loader"
                                type="submit"><?php echo esc_html__( 'Save changes', 'xstore-core' ); ?></button>
                    </form>
				<?php endif; ?>
            </div>
			<?php
			$tab_content      = 'progress_bar';
			$settings_enabled = get_option( $this->settings_name . '_' . $tab_content, false); ?>
            <div class="et-tabs-content" data-tab-content="<?php echo esc_attr( $tab_content ); ?>">
                <div class="tab-preview">
                    <img src="<?php echo $this->dir_url . '/images/' . $tab_content . '.jpg'; ?>" alt="">
                    <h4><?php echo esc_html__( 'Enable Progress Bar', 'xstore-core' ) . ':'; ?></h4>
                    <label class="et-panel-option-switcher<?php if ( $settings_enabled ) { ?> switched<?php } ?>"
                           for="<?php echo esc_attr( $this->settings_name ) . '_' . $tab_content; ?>">
                        <input type="checkbox" id="<?php echo esc_attr( $this->settings_name ) . '_' . $tab_content; ?>"
                               name="<?php echo esc_attr( $this->settings_name ) . '_' . $tab_content; ?>"
                               <?php if ( $settings_enabled ) { ?>checked<?php } ?>>
                        <span></span>
                    </label>
                </div>
                <br/>
                <br/>
				<?php if ( $settings_enabled ): ?>
                    <form class="xstore-panel-settings" method="post">
                        <div class="xstore-panel-settings-inner">
							
							<?php $this->textarea_field_type( $tab_content,
								'message_text',
								esc_html__( 'Progress message text', 'xstore-core' ),
								esc_html__( 'Write your text for progress bar using {{et_price}} to replace with scripts', 'xstore-core' ),
								get_theme_mod('booster_progress_content_et-desktop', esc_html__( 'Spend {{et_price}} to get free shipping', 'xstore-core' ) ) ); ?>
							
							<?php $this->icons_select_field_type( $tab_content,
								'process_icon',
								esc_html__( 'Process icon', 'xstore-core' ),
								false,
								$this->icons['simple'],
								get_theme_mod('booster_progress_icon_et-desktop', 'et_icon-delivery' ) ); ?>
							
							<?php $this->select_field_type( $tab_content,
								'process_icon_position',
								esc_html__( 'Process icon position', 'xstore-core' ),
								false,
								array(
									'before' => esc_html__( 'Before', 'xstore-core' ),
									'after'  => esc_html__( 'After', 'xstore-core' ),
								),
								get_theme_mod('booster_progress_icon_position_et-desktop', 'before' ) ); ?>
							
							<?php $this->input_text_field_type( $tab_content,
								'price',
								esc_html__( 'Price {{Et_price}} For Count', 'xstore-core' ),
								esc_html__( 'Enter only numbers. Do not enter currency symbol!', 'xstore-core' ),
								false,
								get_theme_mod('booster_progress_price_et-desktop', '350' ) ); ?>
							
							<?php $this->textarea_field_type( $tab_content,
								'message_success_text',
								esc_html__( 'Success message text', 'xstore-core' ),
								false,
								get_theme_mod('booster_progress_content_success_et-desktop', esc_html__( 'Congratulations! You\'ve got free shipping.', 'xstore-core' ) ) ); ?>
							
							<?php $this->icons_select_field_type( $tab_content,
								'success_icon',
								esc_html__( 'Success icon', 'xstore-core' ),
								false,
								$this->icons['simple'],
								get_theme_mod('booster_progress_success_icon_et-desktop', 'et_icon-star' ) ); ?>
							
							<?php $this->select_field_type( $tab_content,
								'success_icon_position',
								esc_html__( 'Success icon position', 'xstore-core' ),
								false,
								array(
									'before' => esc_html__( 'Before', 'xstore-core' ),
									'after'  => esc_html__( 'After', 'xstore-core' ),
								),
								get_theme_mod('booster_progress_success_icon_position_et-desktop', 'before' ) ); ?>
                        </div>
                        <button class="et-button et-button-green no-loader"
                                type="submit"><?php echo esc_html__( 'Save changes', 'xstore-core' ); ?></button>
                    </form>
				<?php endif; ?>
            </div>
			<?php
			$tab_content      = 'request_quote';
			$settings_enabled = get_option( $this->settings_name . '_' . $tab_content, false); ?>
            <div class="et-tabs-content" data-tab-content="<?php echo esc_attr( $tab_content ); ?>">
                <div class="tab-preview">
                    <img src="<?php echo $this->dir_url . '/images/' . $tab_content . '.jpg'; ?>" alt="">
                    <h4><?php echo esc_html__( 'Enable Request a quote', 'xstore-core' ) . ':'; ?></h4>
                    <label class="et-panel-option-switcher<?php if ( $settings_enabled ) { ?> switched<?php } ?>"
                           for="<?php echo esc_attr( $this->settings_name ) . '_' . $tab_content; ?>">
                        <input type="checkbox" id="<?php echo esc_attr( $this->settings_name ) . '_' . $tab_content; ?>"
                               name="<?php echo esc_attr( $this->settings_name ) . '_' . $tab_content; ?>"
						       <?php if ( $settings_enabled ) { ?>checked<?php } ?>>
                        <span></span>
                    </label>
                </div>
                <br/>
                <br/>
				<?php if ( $settings_enabled ): ?>
                    <form class="xstore-panel-settings" method="post">
                        <div class="xstore-panel-settings-inner">
	
	                        <?php $this->switcher_field_type( $tab_content,
		                        'show_all_pages',
		                        esc_html__( 'Show on all pages', 'xstore-core' ),
		                        false,
		                        false ); ?>
	
	                        <?php $this->switcher_field_type( $tab_content,
		                        'show_as_button',
		                        esc_html__( 'Show as button on Single Product', 'xstore-core' ),
		                        false,
		                        false ); ?>
							
							<?php $this->upload_field_type( $tab_content,
								'icon',
								esc_html__( 'Custom Image/SVG', 'xstore-core' ),
								false ); ?>
							
							<?php $this->input_text_field_type( $tab_content,
								'label',
								esc_html__( 'Custom label', 'xstore-core' ),
								false,
								false,
								esc_html__('Ask an expert', 'xstore-core') ); ?>
							
							<?php $this->textarea_field_type( $tab_content,
								'popup_content',
								esc_html__( 'Popup content', 'xstore-core' ),
								esc_html__( 'Enter static block shortcode or custom html', 'xstore-core' ),
                                false ); ?>
							
							<?php $this->input_text_field_type( $tab_content,
								'popup_dimensions_custom_width',
								esc_html__( 'Custom popup width', 'xstore-core' ),
								false,
								false,
								'' ); ?>
							
							<?php $this->input_text_field_type( $tab_content,
								'popup_dimensions_custom_height',
								esc_html__( 'Custom popup height', 'xstore-core' ),
								false,
								false,
								'' ); ?>
							
							<?php $this->colorpicker_field_type( $tab_content,
                                'popup_background_color',
                                esc_html__( 'Popup background color', 'xstore-core' ),
                                esc_html__('Choose the background color of the request a quote popup.', 'xstore-core'),
                                '#fff' ); ?>
							
							<?php $this->upload_field_type( $tab_content,
								'popup_background_image',
								esc_html__( 'Background image', 'xstore-core' ),
								esc_html__('Choose the background image of the request a quote popup.', 'xstore-core') ); ?>
							
							<?php $this->select_field_type( $tab_content,
								'popup_background_repeat',
								esc_html__( 'Background repeat', 'xstore-core' ),
								false,
								array(
									'no-repeat'     => esc_html__( 'No repeat', 'xstore-core' ),
									'repeat'         => esc_html__( 'Repeat All', 'xstore-core' ),
									'repeat-x' => esc_html__( 'Repeat-X', 'xstore-core' ),
									'repeat-y'       => esc_html__( 'Repeat-Y', 'xstore-core' ),
								),
								'no-repeat' ); ?>
	
	                        <?php $this->select_field_type( $tab_content,
		                        'popup_background_position',
		                        esc_html__( 'Background position', 'xstore-core' ),
		                        false,
		                        array(
			                        'left top'     => esc_html__( 'Left top', 'xstore-core' ),
			                        'left center'         => esc_html__( 'Left center', 'xstore-core' ),
			                        'left bottom'         => esc_html__( 'Left bottom', 'xstore-core' ),
			                        'right top'         => esc_html__( 'Right top', 'xstore-core' ),
			                        'right center'         => esc_html__( 'Right center', 'xstore-core' ),
			                        'right bottom'         => esc_html__( 'Right bottom', 'xstore-core' ),
			                        'center top'         => esc_html__( 'Center top', 'xstore-core' ),
			                        'center center'         => esc_html__( 'Center center', 'xstore-core' ),
			                        'center bottom'         => esc_html__( 'Center bottom', 'xstore-core' ),
		                        ),
		                        'center center' ); ?>
							
							<?php $this->select_field_type( $tab_content,
								'popup_background_size',
								esc_html__( 'Background size', 'xstore-core' ),
								false,
								array(
									'cover'     => esc_html__( 'Cover', 'xstore-core' ),
									'contain'         => esc_html__( 'Contain', 'xstore-core' ),
									'auto' => esc_html__( 'Auto', 'xstore-core' ),
								),
								'cover' ); ?>
							
							<?php $this->colorpicker_field_type( $tab_content,
								'popup_color',
								esc_html__( 'Popup text color', 'xstore-core' ),
								'Choose the color of the request a quote popup.',
								'#000' ); ?>
                        
                        
                        </div>
                        <button class="et-button et-button-green no-loader"
                                type="submit"><?php echo esc_html__( 'Save changes', 'xstore-core' ); ?></button>
                    </form>
				<?php endif; ?>
            </div>
			
			<?php
			echo ob_get_clean();
		}
		
		/**
		 * Description of the function.
		 *
		 * @param string $section
		 * @param string $setting
		 * @param string $setting_title
		 * @param string $setting_descr
		 * @param array  $options
		 * @param string $default
		 * @return void
		 *
		 * @version 1.0.0
		 * @since 3.2.2
		 *
		 */
		public function select_field_type( $section = '', $setting = '', $setting_title = '', $setting_descr = '', $options = array(), $default = '' ) {
			
			$settings = $this->settings;
			
			if ( isset( $settings[ $section ][ $setting ] ) ) {
				$selected_value = $settings[ $section ][ $setting ];
			} else {
				$selected_value = $default;
			}
			
			ob_start(); ?>

            <div class="xstore-panel-option xstore-panel-option-select">
                <div class="xstore-panel-option-title">

                    <h4><?php echo esc_html( $setting_title ); ?>:</h4>
					
					<?php if ( $setting_descr ) : ?>
                        <p class="description"><?php echo esc_html( $setting_descr ); ?></p>
					<?php endif; ?>

                </div>
                <div class="xstore-panel-option-select">
                    <select name="<?php echo $setting; ?>" id="<?php echo $setting; ?>">
						<?php foreach ( $options as $key => $value ) { ?>
                            <option value="<?php echo $key; ?>"
								<?php echo ( $key == $selected_value ) ? 'selected' : ''; ?>>
								<?php echo $value; ?></option>
						<?php } ?>
                    </select>
                </div>
            </div>
			
			<?php echo ob_get_clean();
		}
		
		/**
		 * Description of the function.
		 *
		 * @param string $section
		 * @param string $setting
		 * @param string $setting_title
		 * @param string $setting_descr
		 * @param array  $options
		 * @param string $default
		 * @return void
		 *
		 * @version 1.0.0
		 * @since 1.0.0
		 *
		 */
		public function icons_select_field_type( $section = '', $setting = '', $setting_title = '', $setting_descr = '', $options = array(), $default = '' ) {
			
			$settings = $this->settings;
			
			if ( isset( $settings[ $section ][ $setting ] ) ) {
				$selected_value = $settings[ $section ][ $setting ];
			} else {
				$selected_value = $default;
			}
			
			ob_start(); ?>

            <div class="xstore-panel-option xstore-panel-option-icons-select">
                <div class="xstore-panel-option-title">

                    <h4><?php echo esc_html( $setting_title ); ?>:</h4>
					
					<?php if ( $setting_descr ) : ?>
                        <p class="description"><?php echo esc_html( $setting_descr ); ?></p>
					<?php endif; ?>

                </div>
                <div class="xstore-panel-option-select">
                    <select name="<?php echo $setting; ?>" id="<?php echo $setting; ?>">
						<?php foreach ( $options as $key => $value ) { ?>
                            <option value="<?php echo $key; ?>"
								<?php echo ( $key == $selected_value ) ? 'selected' : ''; ?>>
								<?php echo $value; ?></option>
						<?php } ?>
                    </select>
                    <div class="<?php echo esc_attr( $setting ); ?>_preview xstore-panel-option-icon-preview">
                        <i class="et-icon <?php echo str_replace( 'et_icon', 'et', $selected_value ); ?>"></i>
                    </div>
                </div>
            </div>
			
			<?php echo ob_get_clean();
		}
		
		/**
		 * Upload field type.
		 *
		 * @param string $section
		 * @param string $setting
		 * @param string $setting_title
		 * @param string $setting_descr
		 * @param string $type
		 * @return void
		 *
		 * @version 1.0.0
		 * @since 3.2.2
		 *
		 */
		public function upload_field_type( $section = '', $setting = '', $setting_title = '', $setting_descr = '', $type = 'image' ) {
			
			$settings = $this->settings;
			
			ob_start(); ?>
            <div class="xstore-panel-option xstore-panel-option-upload">
                <div class="xstore-panel-option-title">

                    <h4><?php echo esc_html( $setting_title ); ?>:</h4>
					
					<?php if ( $setting_descr ) : ?>
                        <p class="description"><?php echo esc_html( $setting_descr ); ?></p>
					<?php endif; ?>

                </div>
                <div class="xstore-panel-option-input">
                    <div class="<?php echo esc_attr( $setting ); ?>_preview xstore-panel-option-file-preview">
						<?php
						if ( ! empty( $settings[ $section ][ $setting ] ) ) {
							$url = $settings[ $section ][ $setting ];
							if ( $type == 'audio' ) {
								$url = $this->dir_url . '/images/audio.png';
							}
							echo '<img src="' . esc_url( $url ) . '" />';
						}
						?>
                    </div>
                    <div class="file-upload-container">
                        <div class="upload-field-input">
                            <input type="text" id="<?php echo esc_html( $setting ); ?>"
                                   name="<?php echo esc_html( $setting ); ?>"
                                   value="<?php echo ( isset( $settings[ $section ][ $setting ] ) ) ? esc_html( $settings[ $section ][ $setting ] ) : ''; ?>"/>
                        </div>
                        <div class="upload-field-buttons">
                            <input type="button"
                                   data-title="<?php esc_html_e( 'Login Screen Background Image', 'xstore-core' ); ?>"
                                   data-button-title="<?php esc_html_e( 'Use File', 'xstore-core' ); ?>"
                                   data-option-name="<?php echo esc_html( $setting ); ?>"
                                   class="et-button et-button-dark-grey no-loader button-upload-file button-default"
                                   value="<?php esc_html_e( 'Upload', 'xstore-core' ); ?>"
                                   data-file-type="<?php echo esc_attr( $type ); ?>"/>
                            <input type="button"
                                   data-option-name="<?php echo esc_html( $setting ); ?>"
                                   class="et-button et-button-semiactive no-loader button-remove-file button-default <?php echo ( ! isset( $settings[ $section ][ $setting ] ) || '' === $settings[ $section ][ $setting ] ) ? 'hidden' : ''; ?>"
                                   value="<?php esc_html_e( 'Remove', 'xstore-core' ); ?> "/>
                        </div>
                    </div>
                </div>
            </div>
			<?php echo ob_get_clean();
		}
		
		/**
		 * Textarea field type.
		 *
		 * @param string $section
		 * @param string $setting
		 * @param string $setting_title
		 * @param string $setting_descr
		 * @param string $default
		 * @return void
		 *
		 * @since 3.2.2
		 *
		 */
		public function textarea_field_type( $section = '', $setting = '', $setting_title = '', $setting_descr = '', $default = '' ) {
			global $allowedposttags;
			
			$settings = $this->settings;
			
			if ( isset( $settings[ $section ][ $setting ] ) ) {
				$value = $settings[ $section ][ $setting ];
			} else {
				$value = $default;
			}
			
			ob_start(); ?>

            <div class="xstore-panel-option xstore-panel-option-code-editor">
                <div class="xstore-panel-option-title">

                    <h4><?php echo esc_html( $setting_title ); ?>:</h4>
					
					<?php if ( $setting_descr ) : ?>
                        <p class="description"><?php echo $setting_descr; ?></p>
					<?php endif; ?>

                </div>
                <div class="xstore-panel-option-input">
                    <textarea id="<?php echo $setting; ?>" name="<?php echo $setting; ?>"
                              style="width: 100%; height: 120px;"
                              class="regular-textarea"><?php echo wp_kses( $value, $allowedposttags ); ?></textarea>
                </div>
            </div>
			
			<?php echo ob_get_clean();
		}
		
		/**
		 * Description of the function.
		 *
		 * @param string $section
		 * @param string $setting
		 * @param string $setting_title
		 * @param string $setting_descr
		 * @param int    $min
		 * @param int    $max
		 * @param int    $default
		 * @param int    $step
		 * @param string $postfix
		 * @return void
		 *
		 * @version 1.0.0
		 * @since 3.2.2
		 *
		 */
		public function slider_field_type( $section = '', $setting = '', $setting_title = '', $setting_descr = '', $min = 0, $max = 50, $default = 12, $step = 1, $postfix = '' ) {
			$settings = $this->settings;
			
			if ( isset( $settings[ $section ][ $setting ] ) ) {
				$value = $settings[ $section ][ $setting ];
			} else {
				$value = $default;
			}
			
			
			ob_start(); ?>

            <div class="xstore-panel-option xstore-panel-option-slider">
                <div class="xstore-panel-option-title">

                    <h4><?php echo esc_html( $setting_title ); ?>:</h4>
					
					<?php if ( $setting_descr ) : ?>
                        <p class="description"><?php echo esc_html( $setting_descr ); ?></p>
					<?php endif; ?>

                </div>
                <div class="xstore-panel-option-input">
                    <input type="range" id="<?php echo $setting; ?>" name="<?php echo $setting; ?>"
                           min="<?php echo $min; ?>" max="<?php echo $max; ?>" value="<?php echo esc_attr( $value ); ?>"
                           step="<?php echo $step; ?>">
                    <span class="value"
					      <?php if ( $postfix ) { ?>data-postfix="<?php echo $postfix; ?>" <?php } ?>><?php echo esc_attr( $value ); ?></span>
                </div>
            </div>
			
			<?php echo ob_get_clean();
		}
		
		/**
		 * Input [text] field type.
		 *
		 * @param string $section
		 * @param string $setting
		 * @param string $setting_title
		 * @param string $setting_descr
		 * @param string $placeholder
		 * @param string $default
		 * @return void
		 *
		 * @version 1.0.0
		 * @since 3.2.2
		 *
		 */
		public function input_text_field_type( $section = '', $setting = '', $setting_title = '', $setting_descr = '', $placeholder = '', $default = '' ) {
			
			$settings = $this->settings;
			
			if ( isset( $settings[ $section ][ $setting ] ) ) {
				$value = $settings[ $section ][ $setting ];
			} else {
				$value = $default;
			}
			
			ob_start(); ?>

            <div class="xstore-panel-option xstore-panel-option-input">
                <div class="xstore-panel-option-title">

                    <h4><?php echo esc_html( $setting_title ); ?>:</h4>
					
					<?php if ( $setting_descr ) : ?>
                        <p class="description"><?php echo esc_html( $setting_descr ); ?></p>
					<?php endif; ?>

                </div>
                <div class="xstore-panel-option-input">
                    <input type="text" id="<?php echo $setting; ?>" name="<?php echo $setting; ?>"
                           placeholder="<?php echo esc_attr( $placeholder ); ?>"
                           value="<?php echo $value; ?>">
                </div>
            </div>
			
			<?php echo ob_get_clean();
		}
		
		/**
		 * Switcher field type.
		 *
		 * @param string $section
		 * @param string $setting
		 * @param string $setting_title
		 * @param string $setting_descr
		 * @param bool   $default
		 *
		 * @return void
         *
		 * @version 1.0.0
		 * @since 3.2.2
		 *
		 */
		public function switcher_field_type( $section = '', $setting = '', $setting_title = '', $setting_descr = '', $default = false ) {
			
			$settings = $this->settings;
			
			if ( isset( $settings[ $section ][ $setting ] ) && $settings[ $section ][ $setting ] ) {
				$value = true;
			} else {
				$value = $default;
			}
			
			ob_start(); ?>

            <div class="xstore-panel-option xstore-panel-option-switcher">
                <div class="xstore-panel-option-input">
                    <h4>
                        <label for="<?php echo $setting; ?>">
							<?php echo esc_html( $setting_title ); ?>:
                            <input class="screen-reader-text" id="<?php echo $setting; ?>"
                                   name="<?php echo $setting; ?>"
                                   type="checkbox"
								<?php echo ( $value ) ? 'checked' : ''; ?>>
                            <span class="switch"></span>
                        </label>
                    </h4>
                </div>
                <div class="xstore-panel-option-title">
					<?php if ( $setting_descr ) : ?>
                        <p class="description"><?php echo $setting_descr; ?></p>
					<?php endif; ?>
                </div>
            </div>
			
			<?php echo ob_get_clean();
		}
		
		/**
		 * Description of the function.
		 *
		 * @param string $section
		 * @param string $setting
		 * @param string $setting_title
		 * @param string $setting_descr
		 * @param string $default
		 * @return void
		 *
		 * @since 3.2.4
		 *
		 */
		public function colorpicker_field_type( $section = '', $setting = '', $setting_title = '', $setting_descr = '', $default = '' ) {
			
			$settings = $this->settings;
			
			if ( isset( $settings[ $section ][ $setting ] ) ) {
				$value = $settings[ $section ][ $setting ];
			} else {
				$value = $default;
			}
			
			ob_start(); ?>

            <div class="xstore-panel-option xstore-panel-option-color">
                <div class="xstore-panel-option-title">

                    <h4><?php echo esc_html( $setting_title ); ?>:</h4>
					
					<?php if ( $setting_descr ) : ?>
                        <p class="description"><?php echo esc_html( $setting_descr ); ?></p>
					<?php endif; ?>

                </div>
                <div class="xstore-panel-option-input">
                    <input type="text" data-alpha="true" id="<?php echo $setting; ?>" name="<?php echo $setting; ?>"
                           class="color-field color-picker"
                           value="<?php echo esc_attr($value); ?>"
                            data-default="<?php echo esc_attr($default); ?>">
                </div>
            </div>
			
			<?php echo ob_get_clean();
		}
		
		/**
		 * Multicheckbox field type.
		 *
		 * @param string $section
		 * @param string $setting
		 * @param string $setting_title
		 * @param string $setting_descr
		 * @param array  $elements
		 * @param array  $default_elements
		 * @return void
		 *
		 * @version 1.0.0
		 * @since 3.2.2
		 *
		 */
		public function multicheckbox_field_type( $section = '', $setting = '', $setting_title = '', $setting_descr = '', $elements = array(), $default_elements = array() ) {
			
			$settings = $this->settings;
			
			ob_start(); ?>

            <div class="xstore-panel-option xstore-panel-option-multicheckbox">
                <div class="xstore-panel-option-title">

                    <h4><?php echo esc_html( $setting_title ); ?>:</h4>
					
					<?php if ( $setting_descr ) : ?>
                        <p class="description"><?php echo esc_html( $setting_descr ); ?></p>
					<?php endif; ?>

                </div>

                <div class="xstore-panel-option-input">
					<?php foreach ( $elements as $key => $val ) {
						$key_origin = $key;
						$key        = $section . '_' . $key; ?>
                        <label for="<?php echo esc_attr( $key ); ?>">
                            <input id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>"
                                   type="checkbox"
								<?php echo ( ( ! isset( $settings[ $section ] ) && in_array( $key_origin, $default_elements ) )
								             || ( isset( $settings[ $section ][ $key ] ) && $settings[ $section ][ $key ] ) ) ? 'checked' : ''; ?>>
							<?php echo esc_attr( $val ); ?>
                        </label>
					<?php } ?>
                </div>
            </div>
			
			<?php echo ob_get_clean();
		}
		
		/**
		 * Save settings
		 *
		 * @since   3.2.2
		 * @version 1.0.0
		 */
		function save_settings() {
			$all_settings          = $this->settings;
			$local_settings        = isset( $_POST['settings'] ) ? $_POST['settings'] : array();
			$local_settings_key    = isset( $_POST['type'] ) ? $_POST['type'] : 'fake_sale_popup';
			$updated               = false;
			$local_settings_parsed = array();
			
			foreach ( $local_settings as $setting ) {
				$local_settings_parsed[ $local_settings_key ][ $setting['name'] ] = stripslashes( $setting['value'] );
			}
			
			$all_settings = array_merge( $all_settings, $local_settings_parsed );
			
			update_option( $this->settings_name, $all_settings );
			$updated = true;
			
			$response = array(
				'msg'  => '<h4 style="margin-bottom: 15px;">' . ( ( $updated ) ? esc_html__( 'Settings successfully saved!', 'xstore-core' ) : esc_html__( 'Settings saving error!', 'xstore-core' ) ) . '</h4>',
				'icon' => ( $updated ) ? '<img src="' . ETHEME_BASE_URI . ETHEME_CODE . 'assets/images/success-icon.png" alt="installed icon" style="margin-top: 15px;"><br/><br/>' : '',
			);
			
			wp_send_json( $response );
		}
		
	}
	
	$Etheme_Sales_Booster_Backend = new Etheme_Sales_Booster_Backend();
	$Etheme_Sales_Booster_Backend->load_actions();
}
