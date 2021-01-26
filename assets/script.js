jQuery(document).ready(function() {

	var module = jQuery('.jmm-testimonials');
	var bullet = module.find('.carousel-indicators li');

	module.each(function(i) {
		var $mod = jQuery(this);
		var autoplay = $mod.attr('data-interval');

		if (typeof $mod.slide != 'undefined') {
			$mod.slide = null; //Mootools fix
		}

		if( parseInt(autoplay) > 0 ) {
			$mod.carousel({
				interval: autoplay,
				pause: 'hover'
			});
		} else {
			$mod.carousel({interval: false});
		}

		$mod.swipe({
			swipe: function(event, direction, distance, duration, fingerCount, fingerData) {
				if (direction == 'left') {
					$mod.carousel('next');
				}
				if (direction == 'right') {
					$mod.carousel('prev');
				}
			},
			allowPageScroll: 'vertical'
		});

		if( $mod.hasClass('indicators') ) {
			$mod.on('slide.bs.carousel', function(event) {
				var item = jQuery(event.relatedTarget);
				var item_id = item.attr('id');
				var indicator = jQuery(this).find('.carousel-indicators [aria-controls="' + item_id + '"]');
				item.attr('tabindex', '0').siblings().attr('tabindex', '-1');
				indicator.attr('aria-selected', 'true').attr('tabindex', '0').siblings().attr('aria-selected', 'false').attr('tabindex', '-1');
			});
		}
	});

	//keyboard support
	bullet.click(function() {
		jQuery(this).focus();
	});

	bullet.keydown(function (event) {
		//remove default action
		if ( event.which == 32 || event.which == 35 || event.which == 36 || event.which == 37 || event.which == 39 ) {
			event.preventDefault();
		}

		//remove effects
		jQuery(this).closest('.jmm-testimonials').removeClass('slide carousel-fade').addClass('slide-off');

	});

	bullet.keyup(function (event) {
		var $bullet = jQuery(this);
		var list = $bullet.parent().find('li');

		if (event.which == 39) { // Right arrow
			if( $bullet.is(':last-child') ) {
				list.first().click();
			} else {
				$bullet.next().click();
			}
		}
		if (event.which == 37) { // Left arrow
			if( $bullet.is(':first-child') ) {
				list.last().click();
			} else {
				$bullet.prev().click();
			}
		}
		
		if (event.which == 36) { // Home key
			list.first().focus().click();
		}

		if (event.which == 35) { // End key
			list.last().focus().click();
		}

		if (event.which == 32 || event.which == 13) { // Space or enter key
			$bullet.click();
		}

		//restore effects
		jQuery(this).closest('.jmm-testimonials').removeClass('slide-off').addClass('slide carousel-fade');

	});

});