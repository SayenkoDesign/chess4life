(function($) {
	$.fn.stylishparallax = function (opts) {
		var background = this;
		
		if( $(background).length && document.documentElement.clientWidth >= 1200 ) {
			var offset = 0;
			var navbarOffset = 0;
			var windowHeight = $(window).height();
			if( $('.navbar-fixed-top').length ) {
				navbarOffset = $('.navbar-fixed-top').outerHeight();
			}
			$(background).each(function() {
				$this = $(this);
				$parent = $this.parent();
				if( $parent.offset().top > 0 ) {
					offset = -Math.min($parent.offset().top, windowHeight) / 4;
				}
				if( 0 !== offset ) {
					$this.css('margin-top', offset);
				}
			});
			
			var raf = requestAnimationFrame || mozRequestAnimationFrame || webkitRequestAnimationFrame || msRequestAnimationFrame;
			var ticking = false;
			var $items = $(background);
			
			// do not call directly
			function stylish_parallax_background() {
				ticking = false;
				var st = window.scrollY;
				var translateY = 0;
				$items.each(function() {
					var $this = $(this);
					var $parent = $this.parent();
					var vh = document.documentElement.clientHeight;
					var ph = $parent.outerHeight();
					var ot = $parent.offset().top;
					if( st > Math.max( 0, ot - vh ) && st < ot + Math.max( vh, ph ) ) {
						translateY = st / 4;
						if( ot > vh ) {
							translateY = ( st - ot + vh ) / 4;
						}
						$this.css('transform', 'translate3d(0, ' + translateY + 'px, 0)');
					} else {
						$this.css('transform', 'translate3d(0, 0, 0)');
					}
				});
			}
			
			window.addEventListener('scroll', function() {
				if( ! ticking && raf ) {
					raf(stylish_parallax_background);
				}
				ticking = true;
			});
		}
	}
})(jQuery);