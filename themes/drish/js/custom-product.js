jQuery( document ).ready(function( $ ) {
    jQuery( '#example3' ).sliderPro({
        width: 700,
        height: 580,
        autoHeight: true,
        fade: true,
        arrows: true,
        buttons: false,
        fadeFullScreen: true,
        shuffle: true,
        orientation: 'horizontal',
        thumbnailPosition: 'right',
        breakpoints: {
            2000: {
                thumbnailsPosition: 'bottom',
                thumbnailWidth: 172,
                thumbnailArrows: true,
                thumbnailHeight: 130

            },

        },
        thumbnailArrows: true,
        autoplay: false
    });

    $('nav#menu').mmenu({
        extensions	: [ 'effect-slide-menu', 'pageshadow' ],
        searchfield	: true,
        counters	: true,
        navbar 		: {
            title		: 'Menu'
        },
        navbars		: [
            {
                position	: 'top',
                content		: [ 'searchfield' ]
            }, {
                position	: 'top',
                content		: [
                    'prev',
                    'title',
                    'close'
                ]
            }
        ]
    });


    $( "#selectmenu-7").selectmenu();
    $( "#selectmenu-8").selectmenu();
    $( "#selectmenu-9").selectmenu();
    $( "#selectmenu-10").selectmenu();
    $('.bxslider-pro').bxSlider({
        minSlides: 1,
		infiniteLoop: false,
        maxSlides: 4,
		speed: 500,
		useCSS: true,
		responsive: true,
        slideMargin: 10,
        nextText: ' ',
        prevText: ' '
    });
	$('.bxslider-pros').bxSlider({
		infiniteLoop: false,
		speed: 500,
		useCSS: true,
		responsive: true,
        slideMargin: 10,
        nextText: ' ',
        prevText: ' '
    });

});