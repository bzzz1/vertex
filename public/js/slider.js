(function ($) {

	function runTimer() {
		timerId = setInterval(function() {
			current++;
			if (current == qty) {
				current = 0;
			}
			showCurrent(current, 'timer');
		}, 6000);
	}
	function showCurrent(id, isTimer) {
		$images.stop(true, false).hide();
		$indicators.attr('src', 'img/indicator-black.png');	

		$('.indicator-bar .indicator').eq(id).attr('src', 'img/indicator-red.png');
		$images.eq(id).fadeIn(1000);
		if (isTimer != 'timer') {
			clearInterval(timerId);
			runTimer();
		}	
	}
	/*----------------------------------------------*/
	
	// get number of total images in slider 	
	var $images = $('.slider .banner');
	var qty = $images.length;

	// Adding indicators bar
	$('.slider').append("<div class='indicator-bar' style='text-align: center; cursor: pointer; position: absolute; bottom: 10px; left: 47%'></div>");
	var $indicator = $("<img src='img/indicator-black.png' class='indicator' style='margin-left: 3px; margin-right: 3px'/>");
	for (var i=0; i<qty; i++) {
		$('.indicator-bar').append($indicator.clone().attr('data-id', i));
	}

	var $indicators = $('.indicator');
	var $arrows = $('.arrow-left, .arrow-right'); 
	var timerId;
	// set and current banner
	var current = 0;
	
	// initial show image and indicator
	$images.eq(current).show();
	$indicators.eq(current).attr('src', 'img/indicator-red.png');

	// manually positioning arrows
	// $arrows = $('.arrow-left, .arrow-right'); 
	// a = $('.arrow-left').height();	
	// b = $('.banner').height();
	// $arrows.css({top: b/2-a/2});

	// run slider
	// runTimer();

	/*------------------------------------------------
	| Events
	------------------------------------------------*/
	$('.slider').hover(
		function() {
			$arrows.show();
		}, function() {
			$arrows.hide();
	});
	
	$('.arrow-left').on('click', function() {
		current--;
		if (current < 0) {
			current = qty-1;
		}
		showCurrent(current);
	});

	$('.arrow-right').on('click', function() {
		current++;
		if (current == qty) {
			current = 0;
		}
		showCurrent(current);
	});

	$('.arrow-left').hover(
		function() {
			$(this).attr('src', 'img/arrow-left-hover.png');
		}, function() { 
			$(this).attr('src', 'img/arrow-left.png');
	});

	$('.arrow-right').hover(
		function() {
			$(this).attr('src', 'img/arrow-right-hover.png');
		}, function() { 
			$(this).attr('src', 'img/arrow-right.png');
	});

	$indicators.on('click', function() {
		$indicators.attr('src', 'img/indicator-black.png');
		current = $(this).data('id');
		showCurrent(current);
	});

	$indicators.hover(
		function() { 
			$(this).attr('src', 'img/indicator-red.png');	
		}, function() { 
			if ($(this).data('id') != current) {
				$(this).attr('src', 'img/indicator-black.png');	
			}
	});

})(jQuery);