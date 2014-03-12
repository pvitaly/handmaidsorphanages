/**
 * This is the main javascript file for the handmaids theme.
 */

//WordPress uses the jQuery noconflict function so we can't use the $ symbol outside of
//our own functions
jQuery(document).ready(function($) {

    //ok to use $ jquery symbol here
	
	$(window).scroll(function() {
        if ($(this).scrollTop() != 0) {
            $('#backtotop').fadeIn();
        } else {
            $('#backtotop').fadeOut();
        }
    });

    $('#backtotop').click(function() {
        $('body,html').animate({scrollTop: 0}, 800);
    });

});