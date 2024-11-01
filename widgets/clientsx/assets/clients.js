(function( $ ){

	'use strict';

    const clientxSlider = ($scope, $) => {
        if( $scope.length > 0 ){
            $('.block--clients-slider').each(function(){
                var id = $(this).data('selector');
                var selector = '#clients_slider_'+id;
                var loop = ( $(this).data('loop') == 'yes' ) ? true: false ;
                var autoplay = ( $(this).data('autoplay') == 'yes' )? true: false;
                var spacing = ( $(this).data('spacing') )? $(this).data('spacing') : 15;
				new Swiper(selector, {
					loop: loop,
                    spaceBetween: spacing,
                    slidesPerView: 6,
                    breakpoints: {
                        320: {
                          slidesPerView: 2,
                        },
                        768: {
                          slidesPerView: 3,
                        },
                        992: {
                          slidesPerView: 4,
                        },
                        992: {
                            slidesPerView: 6,
                        }
                    },
                    autoplay: autoplay,
					pagination: {
						el: '.swiper-pagination-'+id,
					},
					navigation: {
						nextEl: '.swiper-button-next-'+id,
						prevEl: '.swiper-button-prev-'+id,
					},
				});

            })
        }
    }

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/clientsx.default', clientxSlider );
    });

})(jQuery);