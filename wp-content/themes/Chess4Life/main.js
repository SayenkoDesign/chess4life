(function($) {
	var stylish_callbacks = function() {
		$(document).ready(function() {
			
			
			$('.navbar-nav .dropdown-menu').each(function() {
				$(this).css({
					'padding-left': $(this).parent().offset().left + 11,
				});
			});
			
			
			
			$('.panel-group .panel').on('show.bs.collapse', function() {
				$(this).addClass('active');
			});
			
			$('.panel-group .panel').on('hide.bs.collapse', function() {
				$(this).removeClass('active');
			});
			
			
			
			var raf = requestAnimationFrame || mozRequestAnimationFrame || webkitRequestAnimationFrame || msRequestAnimationFrame;
			
			var $navbar = $('.navbar');
			var offset, st;
			if( $('.page-header').length ) {
				offset = $('.page-header').outerHeight();
			} else if( $('.single .hentry .entry-header, .page .hentry .entry-header').length ) {
				offset = $('.single .hentry .entry-header, .page .hentry .entry-header').outerHeight();
			} else {
				offset = $(window).height();
			}
			var lastScrollTop = 0;
			var tick = false;
			
			function stylish_navbar() {
				tick = false;
				st = window.scrollY;
				if( st > 0 && st > lastScrollTop && $navbar.hasClass('navbar-inverse') ) {
					$navbar.removeClass('navbar-static-top');
					$navbar.removeClass('navbar-inverse');
					$navbar.addClass('navbar-fixed-top');
					$navbar.addClass('navbar-default');
				} else if( st <= 30 && st <= lastScrollTop && $navbar.hasClass('navbar-default') ) {
					$navbar.addClass('navbar-static-top');
					$navbar.addClass('navbar-inverse');
					$navbar.removeClass('navbar-fixed-top');
					$navbar.removeClass('navbar-default');
				}
				
				lastScrollTop = st;
			}
			
			window.addEventListener('scroll', function() {
				if( ! tick && raf ) {
					raf(stylish_navbar);
				} else {
					setTimeout(stylish_navbar, 16);
				}
				tick = true;
			});
			
			$('.navbar-toggle').click(function(event) {
				event.preventDefault();
				event.stopPropagation();
				if( $('.main-navigation').hasClass('in') ) {
					$('body').removeClass('navbar-open');
					$('.site').off('touchmove', stylish_prevent_touchscroll);
					$('.main-navigation').removeClass('in');
					$('.navbar-brand').removeClass('inverse');
					$('.navbar.expanded').removeClass('expanded');
					$('.social-nav').removeClass('open');
				} else {
					$('body').addClass('navbar-open');
					$('.site').on('touchmove', stylish_prevent_touchscroll);
					$('.main-navigation').addClass('collapsing');
					setTimeout(function() {
						$('.main-navigation').removeClass('collapsing');
						$('.main-navigation').addClass('in');
					}, 400)
					$('.navbar-brand').addClass('inverse');
					$('.navbar').addClass('expanded');
				}
			});
			
			$('.social-nav').click(function(event) {
				event.stopPropagation();
			});
			
			$('.main-navigation').click(function(event) {
				$('.social-nav').removeClass('open');
				event.stopPropagation();
			});
			
			$('body').click(function(event) {
				$('body').removeClass('navbar-open');
				$('.site').off('touchmove', stylish_prevent_touchscroll);
				$('.main-navigation').removeClass('in');
				$('.navbar-brand').removeClass('inverse');
				$('.navbar.expanded').removeClass('expanded');
				$('.social-nav').removeClass('open');
			});
			
			$('.navbar-nav .dropdown-menu').each(function() {
				$(this).css({
					'padding-left': $(this).parent().offset().left + 11,
				});
			});
			
			var $items, $item, index, fn;
			$('.navbar-nav .dropdown').mouseenter(function() {
				$items = $('.dropdown-menu > li', this);
				if($items.length > 0) {
					index = 0;
					fn = function() {
						$item = $($items[index]);
						$item.addClass('visible');
						
						if( ++index < $items.length ) {
							setTimeout(fn, 125);
						}
					};
					setTimeout(fn, 125);
				}
			});
			
			$('.navbar-nav .dropdown').mouseleave(function() {
				$('.dropdown-menu > li', this).removeClass('visible');
			});
			
			if( $(window).width() > 992 ) {
				var $images = $('.single.layout-full-width .hentry .entry-content img.aligncenter');
				
				if( $images.length ) {
					$images.each(function() {
						$image = $(this);
						$("<img/>").attr("src", $image.attr("src")).load(function() {
							if( this.width >= 920 ) {
								$image.addClass('alignpull');
							}
						});
					});
				}
			}
			
			if( $(window).width() > 1200 ) {
				var $images = $('.page.layout-full-width .hentry .entry-content img.aligncenter');
				
				if( $images.length ) {
					$images.each(function() {
						var $img = $(this);
						$("<img/>").attr("src", $img.attr("src")).load(function() {
							if( this.width >= 1110 ) {
								$img.addClass('alignpull');
							}
						});
					});
				}
			}
			
			if( typeof $.fn.fluidbox != 'undefined' ) {
				$('a[href$=".jpg"], a[href$=".jpeg"], a[href$=".png"], a[href$=".gif"]').fluidbox();
			}
			
			if( typeof $.fn.stylishparallax != 'undefined' && $(window).width() >= 1200 ) {
				$('.background-parallax').stylishparallax();
			}
			
			var header_anim = false;
			var $header_elements = $('.page .hentry .entry-header .container > *');
			
			var stylish_header_animation = function() {
				header_anim = false;
				
				$header_elements.each(function() {
					$(this).css({
						'opacity': ( 1 - window.scrollY / ( $(this).parent().parent().outerHeight() ) ),
						'transform': 'translate3d(0, ' + (window.scrollY / 2.5) + 'px, 0)',
					});
				});
			}
			
			window.addEventListener('scroll', function() {
				if( ! header_anim && raf ) {
					raf(stylish_header_animation);
				} else {
					setTimeout(stylish_header_animation, 17);
				}
				header_anim = true;
			});
			
			var intro_anim = false;
			var $intro_elements = $('.header-intro');
			
			var stylish_intro_animation = function() {
				if( $(window).width() < 1200 ) {
					return false;
				}
				
				intro_anim = false;
				
				$intro_elements.each(function() {
					$(this).css({
						'opacity': ( 1 - window.scrollY / ( $(this).parent().parent().outerHeight() ) ),
						'transform': 'translate3d(0, ' + (window.scrollY / 2.5) + 'px, 0)',
					});
					
					if( $(this).hasClass( 'header-intro-animate' ) ) {
						$(this).children(':first-child').css('padding-top', (window.scrollY / 10 + 100) + 'px');
						
						$(this).children('.text-tilt').css({
							'padding-top': (window.scrollY / 10 + 20) + 'px',
							'padding-bottom': (window.scrollY / 10 + 20) + 'px',
						});
						
						$(this).children(':last-child').children('span').css('padding-top', (window.scrollY / 10 + 20) + 'px');
					}
				});
			}
			
			window.addEventListener('scroll', function() {
				if( ! intro_anim && raf ) {
					raf(stylish_intro_animation);
				} else {
					setTimeout(stylish_intro_animation, 15);
				}
				intro_anim = true;
			});
			
			var text, html;
			
			$('.text-tilt').each(function() {
				$this = $(this);
				text = $this.html().split('');
				html = '';
				$(text).each(function() {
					html += this ;
				});
				$this.html(html);
			});
			
			$('.panel-group .panel .panel-collapse.in').parent().addClass('active');
			
			$('.panel-group .panel').on('show.bs.collapse', function() {
				$(this).addClass('active');
			});
			
			$('.panel-group .panel').on('hide.bs.collapse', function() {
				$(this).removeClass('active');
			});
			
			if( typeof $.fn.flexslider != 'undefined' ) {
				$('.custom-query-carousel').flexslider({
					animation: "slide",
					controlNav: false,
					itemWidth: 480,
					itemMargin: 0,
				});
			}
			
			var canvas = document.createElement("canvas");
		    canvas.width = 72;
		    canvas.height = 72;
		    //document.body.appendChild(canvas);
		    var ctx = canvas.getContext("2d");
		    ctx.fillStyle = "#ffffff";
		    ctx.font = "22px FontAwesome";
		    ctx.textAlign = "center";
		    ctx.textBaseline = "middle";
		    ctx.fillText("\uf067", 36, 36);
		    ctx.arc(36, 36, 34, 0, 2 * Math.PI, false);
		    ctx.lineWidth = 3;
		    ctx.strokeStyle = '#ffffff';
		    ctx.stroke();
		    var dataURL = canvas.toDataURL('image/png');
		    $('.gallery-icon a').css('cursor', 'url('+dataURL+') 36 36, auto');
		    
		    $('.social-nav .trigger').click(function() {
		    	$nav = $('.social-nav');
		    	if( $nav.hasClass('open') ) {
		    		$nav.removeClass('open');
		    	} else {
		    		$nav.addClass('open');
		    	}
		    });
		    
		    if( $(window).width() < 1200 ) {
		    	$('.entry-media').click(function(event) {
		    		if( $(this).is(':hover') ) {
		    			$(this).unbind('mouseenter mouseleave');
		    		} else {
		    			$(this).trigger('hover');
		    		}
		    	});
		    }
		    
		    if( typeof vc_js != 'undefined' ) {
			    vc_js();
			}
		});
		
		/*var map;
		
		function initialize() {
			var myLatlng = new google.maps.LatLng(40.6637998, -73.7174348);
			var mapOptions = {
				zoom: 13,
				center: myLatlng,
				scrollwheel: false,
				styles: [{"stylers":[{"saturation":-100},{"gamma":0.8},{"lightness":4},{"visibility":"on"}]},{"featureType":"landscape.natural","stylers":[{"visibility":"on"},{"color":"#5dff00"},{"gamma":4.97},{"lightness":-5},{"saturation":100}]}],
			};
			
			map = new google.maps.Map(document.getElementById('wpgmza_map'), mapOptions);
			
			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				title: 'Valley Stream, NY'
			});
		}
		
		if( typeof google != 'undefined' ) {
			google.maps.event.addDomListener(window, 'load', initialize);
		}*/
	}
	
	function stylish_prevent_touchscroll(event) {
		event.preventDefault();
	}
	
	if( stylish_main_js.ajax_load && $(window).width() >= 1200 ) {
		window.onpopstate = function(event) {
			event.preventDefault();
			event.stopPropagation();
			
			var link = $(location).attr('href');
			if( link.split('#').length == 1 ) {
				stylish_ajax_state( link, true );
			}
		}
	}
	
	function stylish_ajax_state( link, popstate ) {
		popstate = typeof popstate !== 'undefined' ? popstate : false;
		
		$.ajax({
			url: link,
			processData: true,
			dataType: 'html',
			success: function(data) {
				$('.ajax-mask').addClass('overlaid');
				
				setTimeout(function() {
					if( ! popstate && typeof history.pushState != 'undefined' ) {
						history.pushState( data, 'Page', link );
					}
					document.title = $(data).filter('title').text();
					$('style').remove();
					$(data).filter('style').each(function() {
						$(this).appendTo( 'head' );
					});
					var parser = new DOMParser();
					doc = parser.parseFromString(data, "text/html");
					var docClass = doc.body.getAttribute('class');
					document.body.setAttribute( 'class', docClass );
					
					$('body').addClass('doing-ajax');
					$('.main-navigation').addClass('no-transition');
					setTimeout(function() {
						$('.main-navigation').removeClass('no-transition');
					}, 250);
					$('#page').html('');
					$('html, body').scrollTop(0);
					$('#page').html( $(data).filter('#page').html() );
					
					$('body').waitForImages({
						finished: function() {
							stylish_callbacks();
							/*if( typeof initialize != 'undefined' ) {
								initialize();
							}*/
							window.current_url = $(location).attr('href');
							var home_url = stylish_main_js.home_url;
							$('a[href^="' + home_url + '"]').not('a[href$=".jpg"], a[href$=".jpeg"], a[href$=".png"], a[href$=".gif"]').off('click', stylish_ajax_pages );
							$('a[href^="' + home_url + '"]').not('a[href$=".jpg"], a[href$=".jpeg"], a[href$=".png"], a[href$=".gif"]').on('click', stylish_ajax_pages );
							$(window).trigger('load');
							
							$('.ajax-mask').removeClass('overlaid');
							$('body').removeClass('doing-ajax');
							$('body').addClass('ajax-done');
							setTimeout(function() {
								$('body').removeClass('ajax-done');
							}, 250);
							$('.navbar').removeClass('expanded');
							$('.navbar-brand').removeClass('inverse');
							$('.main-navigation').removeClass('in');
							$('.main-navigation').addClass('no-transition');
							setTimeout(function() {
								$('.main-navigation').removeClass('no-transition');
							}, 250);
						},
						waitForAll: true,
					});
				}, 600);
			},
		});
	}
	
	function stylish_ajax_pages(event) {
		event.preventDefault();
		event.stopPropagation();
		
		$this = $(this);
		var link = $this.attr('href');
		if( link != current_url && link.split('#').length == 1 ) {
			stylish_ajax_state( link );
			
			window.current_url = link;
		}
	}
	
	$('body').waitForImages({
		finished: function() {
			stylish_callbacks();
			
			if( stylish_main_js.ajax_load && $(window).width() >= 1200 ) {
				window.current_url = $(location).attr('href');
				var home_url = stylish_main_js.home_url;
				$('a[href^="' + home_url + '"]').not('a[href$=".jpg"], a[href$=".jpeg"], a[href$=".png"], a[href$=".gif"]').off('click', stylish_ajax_pages );
				$('a[href^="' + home_url + '"]').not('a[href$=".jpg"], a[href$=".jpeg"], a[href$=".png"], a[href$=".gif"]').on('click', stylish_ajax_pages );
				
				$('.ajax-mask').removeClass('overlaid');
				$('body').removeClass('doing-ajax');
				$('body').addClass('ajax-done');
				setTimeout(function() {
					$('body').removeClass('ajax-done');
				}, 250);
				$('.navbar').removeClass('expanded');
				$('.navbar-brand').removeClass('inverse');
				$('.main-navigation').removeClass('in');
				$('.main-navigation').addClass('no-transition');
				setTimeout(function() {
					$('.main-navigation').removeClass('no-transition');
				}, 250);
			} else {
				$('body').removeClass('doing-ajax');
			}
		},
		waitForAll: true,
	});
})(jQuery);