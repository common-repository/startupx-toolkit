(function( $ ){

	'use strict';

    const blockSliderx = ($scope, $) => {
        if( $scope.length > 0 ){
            $('.block--image-slider').each(function(){
                var id = $(this).data('selector');
                var selector = '#block_slider_'+id;
                var loop = ( $(this).data('loop') == 'yes' ) ? true: false ;
                var autoplay = ( $(this).data('autoplay') == 'yes' )? true: false;
				new Swiper(selector, {
					loop: loop,
                    autoplay: autoplay,
					pagination: {
						el: '.swiper-pagination-'+id,
                        type: "bullets",
                        clickable: true,
					},
					navigation: {
						nextEl: '.swiper-button-next-'+id,
						prevEl: '.swiper-button-prev-'+id,
					},
				});

            })
        }
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/sliderx.default', blockSliderx );
    });

})(jQuery);