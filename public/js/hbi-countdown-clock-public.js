(function( $ ) {
	'use strict';

	$(function() {
		
		$('#hbi-countdown-bin').on('click touch', function() {
			if( countdown_clock_vars.countdown_use_link == 1 && isValidURL( countdown_clock_vars.countdown_link_location) ) {
				window.open( countdown_clock_vars.countdown_link_location );
			}
		});
		
		$("#countdown-clock").flipcountdown({
			size:"sm",
			showHour:true,
			speedFlip:30,
			showMinute:true,
			showSecond:true,
			tzoneOffset: '6',
			beforeDateTime: countdown_clock_vars.countdown_date_time
		});
		
		
	});

})( jQuery );
