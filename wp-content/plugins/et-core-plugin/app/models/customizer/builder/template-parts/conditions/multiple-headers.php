<?php if ( ! defined( 'ABSPATH' ) ) exit( 'No direct script access allowed' );
/**
 * The template for displaying multiple templates of Wordpress customizer
 *
 * @since   1.4.6
 * @version 1.0.3
 */

$builder = isset( $_POST['builder'] ) ? $_POST['builder'] : 'header';
if ( $builder == 'header' ) {
	$headers = get_option('et_multiple_headers', false);

	$texts['new-template']             = esc_html__( 'Create New Header', 'xstore-core' );
	$texts['new-template-placeholder'] = esc_html__( 'Name your header', 'xstore-core' );
	$texts['default-condition']        = esc_html__( 'Entire Site by Default', 'xstore-core' );
} elseif( $builder == 'single-product' ){
	$headers = get_option('et_multiple_single_product', false);

	$texts['new-template']             = esc_html__( 'Create New Template', 'xstore-core' );
	$texts['new-template-placeholder'] = esc_html__( 'Name your template', 'xstore-core' );
	$texts['default-condition']        = esc_html__( 'All products by Default', 'xstore-core' );
}

$headers = json_decode($headers, true);

if ( ! is_array($headers) ) {
    $headers = array();
}

$is_rtl = is_rtl();

$_i = 0;
?>

<ul>
	<?php foreach ($headers as $key => $value): ?>
		<?php 
		$_i++;
		$title = ( $value['title'] == 'Default' ) ? $value['title'] . ' ' . $builder : $value['title'];
		?>
		<li data-header="<?php echo $key; ?>" class="<?php echo ( $_i == count($headers) ) ? 'last': ''; ?>">
			<div class="et_header-left">
				<span class="et_header-title">
                    <b><?php echo $title; ?></b>
                    <?php if ($value['title'] != 'Default'): ?>
                        <input type="text" class="et_title-editor hidden" value="<?php echo $title; ?>">
                        <span class="no-title et_header-action et_button et_button-darktext et_header-edit-name" data-action="edit-name"><span class="dashicons dashicons-edit"></span></span>
                        <span class="no-title et_header-action et_button et_button-darktext et_header-save-name hidden" data-action="save-name"><span class="dashicons dashicons-yes"></span></span>
                    <?php endif; ?>
                </span>
				<span class="et_header-conditions text-nowrap">
					<?php
						$Etheme_Customize_Builder = new Etheme_Customize_header_Builder();

						if ( $builder == 'header' ) {
							$conditions = $Etheme_Customize_Builder->get_json_option('et_multiple_conditions');
						} elseif( $builder == 'single-product' ){
							$conditions = $Etheme_Customize_Builder->get_json_option('et_multiple_single_product_conditions');
						}

						
						$titles = $Etheme_Customize_Builder->condition_default_select_data();
						$i = 0;
						foreach ( $conditions as $k => $v ) {
							if ( $i > 1 ) {
								echo '...'; break;
							}
							if ( $key == $v['header'] ) {

								echo '<span class="et_header-condition">';

									if ( $builder == 'header' ) {
										echo $titles[$v['primary']]['title'];
									} else {
										if ( is_array( $v['primary'] ) ) {
											$post_type = get_post_type_object($v['primary']['post_type']);
											echo $post_type->label . '/' . $v['primary']['title'];
										} elseif ( ! empty( $v['primary'] ) )  {
											echo '/'. $titles[$v['primary']]['title'];
										}
									}

									if ( isset( $v['secondary'] ) ) {
										if ( is_array( $v['secondary'] ) ) {
											$post_type = get_post_type_object($v['secondary']['post_type']);
											echo '/' . $post_type->label . '/' . $v['secondary']['title'];
										} elseif ( ! empty( $v['secondary'] ) )  {
											echo '/'. $titles[$v['secondary']]['title'];
										}
									}
									if ( isset( $v['third'] ) && ! empty( $v['third'] ) ) {
											$atts	          = array();
											$atts['selected'] = $v['third'];

											if ( $builder == 'header' ) {
												$atts['data']     = $v['secondary'];
											} else {
												$atts['data']     = $v['primary'];
											}

											$selected = $Etheme_Customize_Builder->condition_select_data($atts);	
										echo '/'. $selected[0]['text'];
									}
								echo "<br></span>";
								$i++;
							} 
							if( $value['title'] == 'Default' ) {
								echo '<span class="et_header-condition">' . $texts['default-condition'] . '</span>';
								break;
							}
						}
					?>
				</span>
			</div>
			<span class="et_header-actions">
				<?php if ( $value['title'] != 'Default' ): ?>
					<span class="et_header-action et_button et_button-darktext et_header-edit" data-action="edit" data-action-text="<?php echo esc_attr('Edit', 'xstore-core'); ?>"><span class="dashicons dashicons-edit"></span></span>
                    <span class="et_separator">|</span>
                    <span class="et_header-action et_button et_button-darktext et_header-copy" data-action="copy" data-action-text="<?php echo esc_attr('Duplicate', 'xstore-core'); ?>"><span class="dashicons dashicons-admin-page"></span></span>
                    <span class="et_header-action et_button et_button-green et_header-save hidden" data-action="save" data-action-text="<?php echo esc_attr('Save', 'xstore-core'); ?>" data-saving-text="<?php echo esc_attr('saving', 'xstore-core'); ?>..."><span class="dashicons dashicons-yes"></span></span>

					<?php if ( $builder == 'header' ): ?>
						<span class="et_separator">|</span>
						<span class="et_button et_button-lightgrey mtips mtips-<?php echo ( $is_rtl ? 'right' : 'left'); ?> desktop" data-device="desktop"><span class="dashicons dashicons-desktop"></span><span class="mt-mes"><?php esc_html_e('Edit Desktop','xstore-core'); ?></span></span>
						<span class="et_separator">|</span>
						<span class="et_button et_button-lightgrey mtips mtips-<?php echo ( $is_rtl ? 'right' : 'left'); ?> mobile" data-device="mobile"><span class="dashicons dashicons-smartphone"></span><span class="mt-mes"><?php esc_html_e('Edit Mobile','xstore-core'); ?></span></span>
					<?php elseif ( $builder == 'single-product' ) : ?>
						<span class="et_separator">|</span>
			            <span class="et_button et_button-lightgrey mtips mtips-<?php echo ( $is_rtl ? 'right' : 'left'); ?> show-builder"><span class="dashicons dashicons-schedule"></span><span class="mt-mes"><?php esc_html_e( 'Build Product', 'xstore-core' ); ?></span></span>
					<?php endif; ?>

					<span class="et_header-action et_button et_button-darktext et_header-remove" data-action="remove" data-action-text="<?php echo esc_attr('Remove', 'xstore-core'); ?>"><span class="dashicons dashicons-trash"></span></span>
                <?php else : ?>
                    <span class="et_header-action et_button et_button-darktext et_header-copy" data-action="copy_default" data-action-text="<?php echo esc_attr('Duplicate', 'xstore-core'); ?>"><span class="dashicons dashicons-admin-page"></span></span>
				<?php endif; ?>
			</span>
		</li>
	<?php endforeach; ?>
</ul>

<div class="add-new-section">
	<div class="et_new-multiple-holder hidden">
		<input class="et_add-new-multiple" placeholder="<?php echo $texts['new-template-placeholder']; ?>" name="et_add-new-header" type="text">
		<span class="et_button et_button-lg et_button-green et_header-action et_header-add" data-action="add"><?php esc_html_e('Create', 'xstore-core'); ?></span>
	</div>
	<span class="et_call-new-header et_button et_button-lg et_button-grey"><?php echo $texts['new-template']; ?></span>
</div>