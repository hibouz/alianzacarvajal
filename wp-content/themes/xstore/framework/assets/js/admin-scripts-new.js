jQuery(document).ready(function ($) {
    $('.et-button:not(.no-loader)').on('click', function () {
        $(this).addClass('loading');
    });

    $(
        '[href="https://wpml.org/?aid=46060&affiliate_key=YI8njhBqLYnp&dr"], ' +
        '[href="https://wpkraken.io/?ref=8theme"], ' +
        '[href="https://overflowcafe.com/am/aff/go/8theme"], ' +
        '[href="http://www.bluehost.com/track/8theme"], ' +
        '[href="https://yithemes.com/product-category/plugins/?refer_id=1028760]'
    ).attr('target', '_blank');

    $('[href="themes.php?page=install-required-plugins"]').remove();

    $(document).on('click', '.et_close-popup', function (e) {
        if ( $('body').hasClass('et_step-child_theme-step') && ! confirm('Your import process will be lost if you navigate away from this page.')){
            e.preventDefault();
            return;
        }

        $('.et_panel-popup').html('').removeClass('active auto-size');
        $('body').removeClass('et_panel-popup-on').removeClass('et_step-child_theme-step');
    });
});