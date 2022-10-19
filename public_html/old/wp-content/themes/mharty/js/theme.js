(function ($) {
    window.mh_load_init_event = false;

	jQuery.fn.reverse = [].reverse;
    
    jQuery.fn.closest_descendent = function( selector ) {
    var $found,
        $current_children = this.children();

        while ( $current_children.length ) {
            $found = $current_children.filter( selector );
            if ( $found.length ) {
                break;
            }
            $current_children = $current_children.children();
        }

        return $found;
    };
    
	$.mhc_simple_slider = function (el, options) {
		var settings = $.extend({
			slide: '.mh-slide', // slide class
			arrows: '.mhc-slider-arrows', // arrows container class
			prev_arrow: '.mhc-arrow-prev', // left arrow class
			next_arrow: '.mhc-arrow-next', // right arrow class
			controls: '.mhc-controllers a', // control selector
			control_active_class: 'mhc-active-control', // active control class name
			carousel_controls: '.mhc_carousel_item', // carousel control selector
			fade_speed: 500, // fade effect speed
			use_arrows: true, // use arrows?
			use_controls: true, // use controls?
			manual_arrows: '', // html code for custom arrows
			append_controls_to: '', // controls are appended to the slider element by default, here you can specify the element it should append to
			controls_below: false,
			controls_class: 'mhc-controllers', // controls container class name
			slideshow: false, // automattic animation?
			slideshow_speed: 7000, // automattic animation speed
			show_progress_bar: false, // show progress bar if automattic animation is active
			tabs_animation: false,
			use_carousel: false,
			previous_text: mh_theme.previous_text, // previous arrow text
			next_text: mh_theme.next_text // next arrow text
		}, options);

		var $mh_slider = $(el),
			$mh_slide = $mh_slider.closest_descendent( settings.slide ),
			mh_slides_number = $mh_slide.length,
			mh_fade_speed = settings.fade_speed,
			mh_active_slide = 0,
			$mh_slider_arrows,
			$mh_slider_prev,
			$mh_slider_next,
			$mh_slider_controls,
			$mh_slider_carousel_controls,
			mh_slider_timer,
			controls_html = '',
			carousel_html = '',
			$progress_bar = null,
			progress_timer_count = 0,
			$mhc_container = $mh_slider.find('.mhc_container'),
			mhc_container_width = $mhc_container.width();
            //is_rtl = $( 'body' ).hasClass( 'rtl' ),

		$mh_slider.mh_animation_running = false;

		$.data(el, "mhc_simple_slider", $mh_slider);

		$mh_slide.eq(0).addClass('mhc-active-slide');

		if (!settings.tabs_animation) {
			if (!$mh_slider.hasClass('mhc_bg_layout_dark') && !$mh_slider.hasClass('mhc_bg_layout_light')) {
				$mh_slider.addClass(mh_get_bg_layout_color($mh_slide.eq(0)));
			}
		}

		if (settings.use_arrows && mh_slides_number > 1) {
			if (settings.manual_arrows == '')
				$mh_slider.append('<div class="mhc-slider-arrows"><a class="mhc-arrow-prev" href="#">' + '<span>' + settings.previous_text + '</span>' + '</a><a class="mhc-arrow-next" href="#">' + '<span>' + settings.next_text + '</span>' + '</a></div>');
			else
				$mh_slider.append(settings.manual_arrows);

			$mh_slider_arrows = $(settings.arrows);
			$mh_slider_prev = $mh_slider.find(settings.prev_arrow);
			$mh_slider_next = $mh_slider.find(settings.next_arrow);

			$mh_slider_next.click(function () {
				if ($mh_slider.mh_animation_running) return false;

				$mh_slider.mh_slider_move_to('next');

				return false;
			});

			$mh_slider_prev.click(function () {
				if ($mh_slider.mh_animation_running) return false;

				$mh_slider.mh_slider_move_to('previous');

				return false;
			});
            
            // Swipe Support Using jquery-touch-mobile
            if(is_rtl){
                $mh_slider.find( settings.slide ).on( 'swiperight', function() {
                    $mh_slider.mh_slider_move_to( 'next' );
                });
                $mh_slider.find( settings.slide ).on( 'swipeleft', function() {
                    $mh_slider.mh_slider_move_to( 'previous' );
                });
            }
            else{
                // Swipe Support Using jquery-touch-mobile
                $mh_slider.find( settings.slide ).on( 'swipeleft', function() {
                    $mh_slider.mh_slider_move_to( 'next' );
                });
                $mh_slider.find( settings.slide ).on( 'swiperight', function() {
                    $mh_slider.mh_slider_move_to( 'previous' );
                });
            }
		}

		if (settings.use_controls && mh_slides_number > 1) {
			for (var i = 1; i <= mh_slides_number; i++) {
				controls_html += '<a href="#"' + (i == 1 ? ' class="' + settings.control_active_class + '"' : '') + '>' + i + '</a>';
			}

			controls_html =
				'<div class="' + settings.controls_class + '">' +
				controls_html +
				'</div>';

			if (settings.append_controls_to == '')
				$mh_slider.append(controls_html);
			else
				$(settings.append_controls_to).append(controls_html);

			if (settings.controls_below)
				$mh_slider_controls = $mh_slider.parent().find(settings.controls);
			else
				$mh_slider_controls = $mh_slider.find(settings.controls);
            
            mh_maybe_set_controls_color( $mh_slide.eq(0) );

			$mh_slider_controls.click(function () {
				if ($mh_slider.mh_animation_running) return false;

				$mh_slider.mh_slider_move_to($(this).index());

				return false;
			});
		}

		if (settings.use_carousel && mh_slides_number > 1) {
			for (var i = 1; i <= mh_slides_number; i++) {
				slide_id = i - 1;
				image_src = ($mh_slide.eq(slide_id).data('image') !== undefined) ? 'url(' + $mh_slide.eq(slide_id).data('image') + ')' : 'none';
				carousel_html += '<div class="mhc_carousel_item ' + (i == 1 ? settings.control_active_class : '') + '" data-slide-id="' + slide_id + '">' +
					'<div class="mhc_video_overlay" href="#" style="background-image: ' + image_src + ';">' +
					'<div class="mhc_video_overlay_hover"><a href="#" class="mhc_video_play"></a></div>' +
					'</div>' +
					'</div>';
			}

			carousel_html =
				'<div class="mhc_carousel">' +
				'<div class="mhc_carousel_items">' +
				carousel_html +
				'</div>' +
				'</div>';
			$mh_slider.after(carousel_html);

			$mh_slider_carousel_controls = $mh_slider.siblings('.mhc_carousel').find(settings.carousel_controls);
			$mh_slider_carousel_controls.click(function () {
				if ($mh_slider.mh_animation_running) return false;

				var $this = $(this);
				$mh_slider.mh_slider_move_to($this.data('slide-id'));

				return false;
			});
		}

		if (settings.slideshow && mh_slides_number > 1) {
			$mh_slider.hover(function () {
				$mh_slider.addClass('mh_slider_hovered');

				if (typeof mh_slider_timer != 'undefined') {
					clearInterval(mh_slider_timer);
				}
			}, function () {
				$mh_slider.removeClass('mh_slider_hovered');

				mh_slider_auto_rotate();
			});
		}

		mh_slider_auto_rotate();

		function mh_slider_auto_rotate() {
			if (settings.slideshow && mh_slides_number > 1 && !$mh_slider.hasClass('mh_slider_hovered')) {
				mh_slider_timer = setTimeout(function () {
					$mh_slider.mh_slider_move_to('next');
				}, settings.slideshow_speed);
			}
		}

		function mh_stop_video(active_slide) {
			var $mh_video, mh_video_src;

			// if there is a video in the slide, stop it when switching to another slide
			if (active_slide.has('iframe').length) {
				$mh_video = active_slide.find('iframe');
				mh_video_src = $mh_video.attr('src');

				$mh_video.attr('src', '');
				$mh_video.attr('src', mh_video_src);

			} else if (active_slide.has('video').length) {
				if (!active_slide.find('.mhc_section_video_bg').length) {
					$mh_video = active_slide.find('video');
					$mh_video[0].pause();
				}
			}
		}

		function mh_fix_slider_content_images() {
			var $this_slider = $mh_slider,
				$slide_image_container = $this_slider.find('.mhc-active-slide .mhc_slide_image'),
                $slide_video_container = $this_slider.find( '.mhc-active-slide .mhc_slide_video' ),
			    $slide = $slide_image_container.closest('.mhc_slide'),
				$slider = $slide.closest('.mhc_slider'),
				slide_height = $slider.innerHeight(),
				image_height = parseInt(slide_height * 0.8);

			$slide_image_container.find('img').css('maxHeight', image_height + 'px');

			if ($slide.hasClass('mhc_media_alignment_center')) {
				$slide_image_container.css('marginTop', '-' + parseInt($slide_image_container.height() / 2) + 'px');
			}
            $slide_video_container.css( 'marginTop', '-' + parseInt( $slide_video_container.height() / 2 ) + 'px' );

			$slide_image_container.find('img').addClass('active');
		}

		function mh_get_bg_layout_color($slide) {
			if ($slide.hasClass('mhc_bg_layout_dark')) {
				return 'mhc_bg_layout_dark';
			}

			return 'mhc_bg_layout_light';
		}
        
        function mh_maybe_set_controls_color( $slide ) {
            var next_slide_dot_color,
                $arrows,
                arrows_color;

            if ( typeof $mh_slider_controls !== 'undefined' && $mh_slider_controls.length ) {
                next_slide_dot_color = $slide.data( 'dots_color' ) || '';

                if ( next_slide_dot_color !== '' ) {
                    $mh_slider_controls.attr( 'style', 'background-color: ' + hex_to_rgba( next_slide_dot_color, '0.3' ) + ';' )
                    $mh_slider_controls.filter( '.mhc-active-control' ).attr( 'style', 'background-color: ' + hex_to_rgba( next_slide_dot_color ) + '!important;' );
                } else {
                    $mh_slider_controls.removeAttr( 'style' );
                }
            }

            if ( typeof $mh_slider_arrows !== 'undefined' && $mh_slider_arrows.length ) {
                $arrows      = $mh_slider_arrows.find( 'a' );
                arrows_color = $slide.data( 'arrows_color' ) || '';

                if ( arrows_color !== '' ) {
                    $arrows.css( 'color', arrows_color );
                } else {
                    $arrows.css( 'color', 'inherit' );
                }
            }
        }

        function hex_to_rgba( color, alpha ) {
            var color_16 = parseInt( color.replace( '#', '' ), 16 ),
                red      = ( color_16 >> 16 ) & 255,
                green    = ( color_16 >> 8 ) & 255,
                blue     = color_16 & 255,
                alpha    = alpha || 1,
                rgba;

            rgba = red + ',' + green + ',' + blue + ',' + alpha;
            rgba = 'rgba(' + rgba + ')';

            return rgba;
        }

		$mh_window.load(function () {
			mh_fix_slider_content_images();
		});

		$mh_window.resize(function () {
			if (mhc_container_width !== $mhc_container.width()) {
				mhc_container_width = $mhc_container.width();

				mh_fix_slider_content_images();
			}
		});

		$mh_slider.mh_slider_move_to = function (direction) {
			var $active_slide = $mh_slide.eq(mh_active_slide),
				$next_slide;

			$mh_slider.mh_animation_running = true;
            
            $mh_slider.removeClass('mh_slide_transition_to_next mh_slide_transition_to_previous').addClass('mh_slide_transition_to_' + direction );

				$mh_slider.find('.mhc-moved-slide').removeClass('mhc-moved-slide');

			if (direction == 'next' || direction == 'previous') {

				if (direction == 'next')
					mh_active_slide = (mh_active_slide + 1) < mh_slides_number ? mh_active_slide + 1 : 0;
				else
					mh_active_slide = (mh_active_slide - 1) >= 0 ? mh_active_slide - 1 : mh_slides_number - 1;

			} else {

				if (mh_active_slide == direction) {
					$mh_slider.mh_animation_running = false;
					return;
				}

				mh_active_slide = direction;
			}

			if (typeof mh_slider_timer != 'undefined')
				clearInterval(mh_slider_timer);

			$next_slide = $mh_slide.eq(mh_active_slide);
            
            if ( typeof $active_slide.find('video')[0] !== 'undefined' && typeof $active_slide.find('video')[0]['player'] !== 'undefined' ) {
                $active_slide.find('video')[0].player.pause();
            }

            if ( typeof $next_slide.find('video')[0] !== 'undefined' && typeof $next_slide.find('video')[0]['player'] !== 'undefined' ) {
                $next_slide.find('video')[0].player.play();
            }

            
            $mh_slider.trigger( 'simple_slider_before_move_to', { direction : direction, next_slide : $next_slide });

			$mh_slide.each(function () {
				$(this).css('zIndex', 1);
			});
            $active_slide.css( 'zIndex', 2 ).removeClass( 'mhc-active-slide' ).addClass('mhc-moved-slide');
			$next_slide.css({ 'display': 'block', opacity: 0 }).addClass('mhc-active-slide');

			mh_fix_slider_content_images();
 
            if ( settings.use_controls )
                $mh_slider_controls.removeClass( settings.control_active_class ).eq( mh_active_slide ).addClass( settings.control_active_class );

            if ( settings.use_carousel )
                $mh_slider_carousel_controls.removeClass( settings.control_active_class ).eq( mh_active_slide ).addClass( settings.control_active_class );
            

			if ( ! settings.tabs_animation ) {
                mh_maybe_set_controls_color( $next_slide );

                $next_slide.animate( { opacity : 1 }, mh_fade_speed );
                $active_slide.addClass( 'mh_slide_transition' ).css( { 'display' : 'list-item', 'opacity' : 1 } ).animate( { opacity : 0 }, mh_fade_speed, function(){
                    var active_slide_layout_bg_color = mh_get_bg_layout_color( $active_slide ),
                        next_slide_layout_bg_color = mh_get_bg_layout_color( $next_slide );

                    $(this).css('display', 'none').removeClass( 'mh_slide_transition' );

                    mh_stop_video( $active_slide );

                    $mh_slider
                        .removeClass( active_slide_layout_bg_color )
                        .addClass( next_slide_layout_bg_color );

                    $mh_slider.mh_animation_running = false;
                    $mh_slider.trigger( 'simple_slider_after_move_to', { next_slide : $next_slide } );
                } );
            } else {
                $next_slide.css( { 'display' : 'none', opacity : 0 } );

                $active_slide.addClass( 'mh_slide_transition' ).css( { 'display' : 'block', 'opacity' : 1 } ).animate( { opacity : 0 }, mh_fade_speed, function(){
                    $(this).css('display', 'none').removeClass( 'mh_slide_transition' );

                    $next_slide.css( { 'display' : 'block', 'opacity' : 0 } ).animate( { opacity : 1 }, mh_fade_speed, function() {
                        $mh_slider.mh_animation_running = false;   
                        $mh_slider.trigger( 'simple_slider_after_move_to', { next_slide : $next_slide } );
                    } );
                } );
            }

			mh_slider_auto_rotate();
		}
	}

	$.fn.mhc_simple_slider = function (options) {
		return this.each(function () {
			new $.mhc_simple_slider(this, options);
		});
	}

	var mh_hash_module_seperator = '||',
		mh_hash_module_param_seperator = '|';

	function process_mh_hashchange(hash) {
		if ((hash.indexOf(mh_hash_module_seperator, 0)) !== -1) {
			modules = hash.split(mh_hash_module_seperator);
			for (var i = 0; i < modules.length; i++) {
				var module_params = modules[i].split(mh_hash_module_param_seperator);
				var element = module_params[0];
				module_params.shift();
				if ($('#' + element).length) {
					$('#' + element).trigger({
						type: "mh_hashchange",
						params: module_params
					});
				}
			}
		} else {
			module_params = hash.split(mh_hash_module_param_seperator);
			var element = module_params[0];
			module_params.shift();
			if ($('#' + element).length) {
				$('#' + element).trigger({
					type: "mh_hashchange",
					params: module_params
				});
			}
		}
	}

	function mh_set_hash(module_state_hash) {
		module_id = module_state_hash.split(mh_hash_module_param_seperator)[0];
		if (!$('#' + module_id).length) {
			return;
		}

		if (window.location.hash) {
			var hash = window.location.hash.substring(1), //Puts hash in variable, and removes the # character
				new_hash = [];


			if ((hash.indexOf(mh_hash_module_seperator, 0)) !== -1) {
				modules = hash.split(mh_hash_module_seperator);
				var in_hash = false;
				for (var i = 0; i < modules.length; i++) {
					var element = modules[i].split(mh_hash_module_param_seperator)[0];
					if (element === module_id) {
						new_hash.push(module_state_hash);
						in_hash = true;
					} else {
						new_hash.push(modules[i]);
					}
				}
				if (!in_hash) {
					new_hash.push(module_state_hash);
				}
			} else {
				module_params = hash.split(mh_hash_module_param_seperator);
				var element = module_params[0];
				if (element !== module_id) {
					new_hash.push(hash);
				}
				new_hash.push(module_state_hash);
			}

			hash = new_hash.join(mh_hash_module_seperator);
		} else {
			hash = module_state_hash;
		}

		var yScroll = document.body.scrollTop;
		window.location.hash = hash;
		document.body.scrollTop = yScroll;
	}

	$.mhc_simple_carousel = function (el, options) {
		var settings = $.extend({
			slide_duration: 500,
		}, options);

		var $mh_carousel = $(el),
			$carousel_items = $mh_carousel.find('.mhc_carousel_items'),
			$the_carousel_items = $carousel_items.find('.mhc_carousel_item');

		$mh_carousel.mh_animation_running = false;

		$mh_carousel.addClass('container-width-change-notify').on('containerWidthChanged', function (event) {
			set_carousel_columns($mh_carousel);
			set_carousel_height($mh_carousel);
		});

		$carousel_items.data('items', $the_carousel_items.toArray());
		$mh_carousel.data('columns_setting_up', false);

		$carousel_items.prepend('<div class="mhc-slider-arrows"><a class="mhc-slider-arrow mhc-arrow-prev" href="#">' + '<span>' + mh_theme.previous_text + '</span>' + '</a><a class="mhc-slider-arrow mhc-arrow-next" href="#">' + '<span>' + mh_theme.next_text + '</span>' + '</a></div>');

		set_carousel_columns($mh_carousel);
		set_carousel_height($mh_carousel);

		$mh_carousel_next = $mh_carousel.find('.mhc-arrow-next');
		$mh_carousel_prev = $mh_carousel.find('.mhc-arrow-prev');

		$mh_carousel_next.click(function () {
			if ($mh_carousel.mh_animation_running) return false;

			$mh_carousel.mh_carousel_move_to('next');

			return false;
		});

		$mh_carousel_prev.click(function () {
			if ($mh_carousel.mh_animation_running) return false;

			$mh_carousel.mh_carousel_move_to('previous');

			return false;
		});
        
        // Swipe Support Using jquery-touch-mobile
        if(is_rtl){
            $mh_carousel.on( 'swiperight', function() {
                $mh_carousel.mh_carousel_move_to( 'next' );
            });
            $mh_carousel.on( 'swipeleft', function() {
                $mh_carousel.mh_carousel_move_to( 'previous' );
            });
        }
        else{
            $mh_carousel.on( 'swipeleft', function() {
                $mh_carousel.mh_carousel_move_to( 'next' );
            });
            $mh_carousel.on( 'swiperight', function() {
                $mh_carousel.mh_carousel_move_to( 'previous' );
            });
        }

		function set_carousel_height($the_carousel) {
			var carousel_items_width = $the_carousel_items.width(),
				carousel_items_height = $the_carousel_items.height();

			$carousel_items.css('height', carousel_items_height + 'px');
		}

		function set_carousel_columns($the_carousel) {
			var columns,
				$carousel_parent = $the_carousel.parents('.mhc_column'),
				carousel_items_width = $carousel_items.width(),
				carousel_item_count = $the_carousel_items.length;

			if ($carousel_parent.hasClass('mhc_column_4_4') || $carousel_parent.hasClass('mhc_column_3_4') || $carousel_parent.hasClass('mhc_column_2_3')) {
				if ($mh_window.width() < 768) {
					columns = 3;
				} else {
					columns = 4;
				}
			} else if ($carousel_parent.hasClass('mhc_column_1_2') || $carousel_parent.hasClass('mhc_column_3_8') || $carousel_parent.hasClass('mhc_column_1_3')) {
				columns = 3;
			} else if ($carousel_parent.hasClass('mhc_column_1_4')) {
				if ($mh_window.width() > 480 && $mh_window.width() < 980) {
					columns = 3;
				} else {
					columns = 2;
				}
			}

			if (columns === $carousel_items.data('columns')) {
				return;
			}

			if ($the_carousel.data('columns_setting_up')) {
				return;
			}

			$the_carousel.data('columns_setting_up', true);

			// store last setup column
			$carousel_items.removeClass('columns-' + $carousel_items.data('columns'));
			$carousel_items.addClass('columns-' + columns);
			$carousel_items.data('columns', columns);

			// kill all previous groups to get ready to re-group
			if ($carousel_items.find('.mh-carousel-group').length) {
				$the_carousel_items.appendTo($carousel_items);
				$carousel_items.find('.mh-carousel-group').remove();
			}

			// setup the grouping
			var the_carousel_items = $carousel_items.data('items'),
				$carousel_group = $('<div class="mh-carousel-group active">').appendTo($carousel_items);

			$the_carousel_items.data('position', '');
			if (the_carousel_items.length <= columns) {
				$carousel_items.find('.mhc-slider-arrows').hide();
			} else {
				$carousel_items.find('.mhc-slider-arrows').show();
			}

			for (position = 1, x = 0; x < the_carousel_items.length; x++, position++) {
				if (x < columns) {
					$(the_carousel_items[x]).show();
					$(the_carousel_items[x]).appendTo($carousel_group);
					$(the_carousel_items[x]).data('position', position);
					$(the_carousel_items[x]).addClass('position_' + position);
				} else {
					position = $(the_carousel_items[x]).data('position');
					$(the_carousel_items[x]).removeClass('position_' + position);
					$(the_carousel_items[x]).data('position', '');
					$(the_carousel_items[x]).hide();
				}
			}

			$the_carousel.data('columns_setting_up', false);

		} /* end set_carousel_columns() */

		$mh_carousel.mh_carousel_move_to = function (direction) {
			var $active_carousel_group = $carousel_items.find('.mh-carousel-group.active'),
				items = $carousel_items.data('items'),
				columns = $carousel_items.data('columns');

			$mh_carousel.mh_animation_running = true;

			var left = 0;
			$active_carousel_group.children().each(function () {
				$(this).css({
					'position': 'absolute',
					'left': left
				});
				left = left + $(this).outerWidth(true);
			});

			if (direction == 'next') {
				var $next_carousel_group,
					current_position = 1,
					next_position = 1,
					active_items_start = items.indexOf($active_carousel_group.children().first()[0]),
					active_items_end = active_items_start + columns,
					next_items_start = active_items_end,
					next_items_end = next_items_start + columns;

				$next_carousel_group = $('<div class="mh-carousel-group next" style="display: none;left: 100%;position: absolute;top: 0;">').insertAfter($active_carousel_group);
				$next_carousel_group.css({
					'width': $active_carousel_group.innerWidth()
				}).show();

				// this is an endless loop, so it can decide internally when to break out, so that next_position
				// can get filled up, even to the extent of an element having both and current_ and next_ position
				for (x = 0, total = 0;; x++, total++) {
					if (total >= active_items_start && total < active_items_end) {
						$(items[x]).addClass('changing_position current_position current_position_' + current_position);
						$(items[x]).data('current_position', current_position);
						current_position++;
					}

					if (total >= next_items_start && total < next_items_end) {
						$(items[x]).data('next_position', next_position);
						$(items[x]).addClass('changing_position next_position next_position_' + next_position);

						if (!$(items[x]).hasClass('current_position')) {
							$(items[x]).addClass('container_append');
						} else {
							$(items[x]).clone(true).appendTo($active_carousel_group).hide().addClass('delayed_container_append_dup').attr('id', $(items[x]).attr('id') + '-dup');
							$(items[x]).addClass('delayed_container_append');
						}

						next_position++;
					}

					if (next_position > columns) {
						break;
					}

					if (x >= (items.length - 1)) {
						x = -1;
					}
				}

				var sorted = $carousel_items.find('.container_append, .delayed_container_append_dup').sort(function (a, b) {
					var el_a_position = parseInt($(a).data('next_position'));
					var el_b_position = parseInt($(b).data('next_position'));
					return (el_a_position < el_b_position) ? -1 : (el_a_position > el_b_position) ? 1 : 0;
				});

				$(sorted).show().appendTo($next_carousel_group);

				var left = 0;
				$next_carousel_group.children().each(function () {
					$(this).css({
						'position': 'absolute',
						'left': left
					});
					left = left + $(this).outerWidth(true);
				});

				$active_carousel_group.animate({
					left: '-100%'
				}, {
					duration: settings.slide_duration,
					complete: function () {
						$carousel_items.find('.delayed_container_append').each(function () {
							left = $('#' + $(this).attr('id') + '-dup').css('left');
							$(this).css({
								'position': 'absolute',
								'left': left
							});
							$(this).appendTo($next_carousel_group);
						});

						$active_carousel_group.removeClass('active');
						$active_carousel_group.children().each(function () {
							position = $(this).data('position');
							current_position = $(this).data('current_position');
							$(this).removeClass('position_' + position + ' ' + 'changing_position current_position current_position_' + current_position);
							$(this).data('position', '');
							$(this).data('current_position', '');
							$(this).hide();
							$(this).css({
								'position': '',
								'left': ''
							});
							$(this).appendTo($carousel_items);
						});

						$active_carousel_group.remove();

					}
				});

				next_left = $active_carousel_group.width() + parseInt($the_carousel_items.first().css('marginRight').slice(0, -2));
				$next_carousel_group.addClass('active').css({
					'position': 'absolute',
					'top': 0,
					left: next_left
				});
				$next_carousel_group.animate({
					left: '0%'
				}, {
					duration: settings.slide_duration,
					complete: function () {
						$next_carousel_group.removeClass('next').addClass('active').css({
							'position': '',
							'width': '',
							'top': '',
							'left': ''
						});

						$next_carousel_group.find('.changing_position').each(function (index) {
							position = $(this).data('position');
							current_position = $(this).data('current_position');
							next_position = $(this).data('next_position');
							$(this).removeClass('container_append delayed_container_append position_' + position + ' ' + 'changing_position current_position current_position_' + current_position + ' next_position next_position_' + next_position);
							$(this).data('current_position', '');
							$(this).data('next_position', '');
							$(this).data('position', (index + 1));
						});

						$next_carousel_group.children().css({
							'position': '',
							'left': ''
						});
						$next_carousel_group.find('.delayed_container_append_dup').remove();

						$mh_carousel.mh_animation_running = false;
					}
				});

			} else if (direction == 'previous') {
				var $prev_carousel_group,
					current_position = columns,
					prev_position = columns,
					columns_span = columns - 1,
					active_items_start = items.indexOf($active_carousel_group.children().last()[0]),
					active_items_end = active_items_start - columns_span,
					prev_items_start = active_items_end - 1,
					prev_items_end = prev_items_start - columns_span;

				$prev_carousel_group = $('<div class="mh-carousel-group prev" style="display: none;left: 100%;position: absolute;top: 0;">').insertBefore($active_carousel_group);
				$prev_carousel_group.css({
					'left': '-' + $active_carousel_group.innerWidth(),
					'width': $active_carousel_group.innerWidth()
				}).show();

				// this is a loop
				for (x = (items.length - 1), total = (items.length - 1);; x--, total--) {

					if (total <= active_items_start && total >= active_items_end) {
						$(items[x]).addClass('changing_position current_position current_position_' + current_position);
						$(items[x]).data('current_position', current_position);
						current_position--;
					}

					if (total <= prev_items_start && total >= prev_items_end) {
						$(items[x]).data('prev_position', prev_position);
						$(items[x]).addClass('changing_position prev_position prev_position_' + prev_position);

						if (!$(items[x]).hasClass('current_position')) {
							$(items[x]).addClass('container_append');
						} else {
							$(items[x]).clone(true).appendTo($active_carousel_group).addClass('delayed_container_append_dup').attr('id', $(items[x]).attr('id') + '-dup');
							$(items[x]).addClass('delayed_container_append');
						}

						prev_position--;
					}

					if (prev_position <= 0) {
						break;
					}

					if (x == 0) {
						x = items.length;
					}
				}

				var sorted = $carousel_items.find('.container_append, .delayed_container_append_dup').sort(function (a, b) {
					var el_a_position = parseInt($(a).data('prev_position'));
					var el_b_position = parseInt($(b).data('prev_position'));
					return (el_a_position < el_b_position) ? -1 : (el_a_position > el_b_position) ? 1 : 0;
				});

				$(sorted).show().appendTo($prev_carousel_group);

				var left = 0;
				$prev_carousel_group.children().each(function () {
					$(this).css({
						'position': 'absolute',
						'left': left
					});
					left = left + $(this).outerWidth(true);
				});

				$active_carousel_group.animate({
					left: '100%'
				}, {
					duration: settings.slide_duration,
					complete: function () {
						$carousel_items.find('.delayed_container_append').reverse().each(function () {
							left = $('#' + $(this).attr('id') + '-dup').css('left');
							$(this).css({
								'position': 'absolute',
								'left': left
							});
							$(this).prependTo($prev_carousel_group);
						});

						$active_carousel_group.removeClass('active');
						$active_carousel_group.children().each(function () {
							position = $(this).data('position');
							current_position = $(this).data('current_position');
							$(this).removeClass('position_' + position + ' ' + 'changing_position current_position current_position_' + current_position);
							$(this).data('position', '');
							$(this).data('current_position', '');
							$(this).hide();
							$(this).css({
								'position': '',
								'left': ''
							});
							$(this).appendTo($carousel_items);
						});

						$active_carousel_group.remove();
					}
				});

				prev_left = (-1) * $active_carousel_group.width() - parseInt($the_carousel_items.first().css('marginRight').slice(0, -2));
				$prev_carousel_group.addClass('active').css({
					'position': 'absolute',
					'top': 0,
					left: prev_left
				});
				$prev_carousel_group.animate({
					left: '0%'
				}, {
					duration: settings.slide_duration,
					complete: function () {
						$prev_carousel_group.removeClass('prev').addClass('active').css({
							'position': '',
							'width': '',
							'top': '',
							'left': ''
						});

						$prev_carousel_group.find('.delayed_container_append_dup').remove();

						$prev_carousel_group.find('.changing_position').each(function (index) {
							position = $(this).data('position');
							current_position = $(this).data('current_position');
							prev_position = $(this).data('prev_position');
							$(this).removeClass('container_append delayed_container_append position_' + position + ' ' + 'changing_position current_position current_position_' + current_position + ' prev_position prev_position_' + prev_position);
							$(this).data('current_position', '');
							$(this).data('prev_position', '');
							position = index + 1;
							$(this).data('position', position);
							$(this).addClass('position_' + position);
						});

						$prev_carousel_group.children().css({
							'position': '',
							'left': ''
						});
						$mh_carousel.mh_animation_running = false;
					}
				});
			}
		}
	}

	$.fn.mhc_simple_carousel = function (options) {
		return this.each(function () {
			new $.mhc_simple_carousel(this, options);
		});
	}
	
	var $mhc_slider = $('.mhc_slider'),
		$mhc_tabs = $('.mhc_tabs'),
		$mhc_tabs_li = $mhc_tabs.find('.mhc_tabs_controls li'),
		$mhc_video_section = $('.mhc_section_video_bg'),
		$mhc_newsletter_button = $('.mhc_newsletter_button'),
		$mhc_filterable_portfolio = $('.mhc_filterable_portfolio'),
		$mhc_fullwidth_portfolio = $('.mhc_fullwidth_portfolio'),
		$mhc_gallery = $('.mhc_gallery'),
		$mhc_countdown_timer = $('.mhc_countdown_timer'),
		$mh_post_gallery = $('.mh_post_gallery'),
		$mh_lightbox_image = $('.mhc_lightbox_image'),
		$mhc_circle_counter = $('.mhc_circle_counter'),
		$mhc_number_counter = $('.mhc_number_counter'),
		$mhc_parallax = $('.mh_parallax_bg'),
		mh_is_mobile_device = navigator.userAgent.match( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/ ) !== null,
		mh_is_ipad = navigator.userAgent.match( /iPad/ ),
		$mh_container = $('.container'),
		mh_container_width = $mh_container.width(),
		mh_is_fixed_nav = $('body').hasClass('mh_fixed_nav'),
		$main_container_wrapper = $('#page-container.not-trans'),
		$mh_window = $(window),
		mhRecalculateOffset = false,
		mh_header_height,
		mh_header_modifier,
		mh_header_offset,
		mh_primary_header_top,
        is_rtl = $( 'body' ).hasClass( 'rtl' ),
        $mhc_shop = $( '.mhc_shop' ),
        $window_height = $(window).height(),
        $mhc_flickity_lightbox = $('.mhc_flickity_lightbox'),
        $mhc_flickity_continer = $('.mhc_flickity_continer'),
        mh_is_touch_screen = 'ontouchstart' in window || navigator.maxTouchPoints;
    
	$(document).ready(function () {
        
		var $mh_top_menu = $('ul.nav'),
			$mh_search_icon = $('.mh_search_icon'),
            mh_parent_item_holdtouch_limit = 300,
			mh_parent_item_holdtouch_start,
			mh_parent_item_click = true;
		
        
        $('.mhc_text_color_light').next('.mh-loveit-container').addClass('mhc_text_color_light');
        
		$mh_top_menu.find('li').hover(function () {
			if (!$(this).closest('li.mega-menu').length || $(this).hasClass('mega-menu')) {
				$(this).addClass('mh-show-dropdown');
				$(this).removeClass('mh-hover').addClass('mh-hover');
			}
		}, function () {
			var $this_el = $(this);

            $this_el.removeClass( 'mh-show-dropdown' );

			setTimeout(function () {
				if (!$this_el.hasClass('mh-show-dropdown')) {
                    $this_el.removeClass( 'mh-hover' );
				}
			}, 200);
		});
        
        
        //Adjust menu children for touch screen
		$mh_top_menu.find( '.menu-item-has-children > a' ).on( 'touchend', function(){
			var $mh_parent_menu = $( this ).parent( 'li' );
			// open submenu on 1st tap
			// open link on second tap
			if ( $mh_parent_menu.hasClass( 'mh-hover' ) ) {
				window.location = $( this ).attr( 'href' );
			} else {
				$mh_parent_menu.trigger( 'mouseenter' );

			}
		} );

		//promo box animation
	    $('.mh_button_fx').each(function () {
			$(this).mouseleave(function() {
           		$(this).find('.mhc_promo_button').toggleClass('mh-animate');
			});
		});
        
        //cart
        if ($('.mh-cart-info').length) {
            var $this_parent = $('div');
            $this_parent.on('mouseover','.mh-cart-info, .mh-cart-container',function(){
                $this_parent.addClass('mh-cart-hover');
            });
            
            $this_parent.on('mouseleave','.mh-cart-info, .mh-cart-container',function(){
                $this_parent.removeClass( 'mh-cart-hover' );
                
            });
            
            if ( mh_is_touch_screen ) {
                //Adjust cart icon for touch screen
                $( 'a.mh-cart-info' ).on( 'touchend', function(){
                    // open submenu on 1st tap
                    // open link on second tap
                    if ( $(this).parent('div').hasClass( 'mh-cart-hover' ) ) {
                        window.location = $( this ).attr( 'href' );
                    } else {
                        $(this).parent('div').trigger( 'mouseenter' );
                    }
                } );
            }            
        }
        
		//Add padding to footer if last section has buttom seperator
		if ($('.mhc_section:last').hasClass('bottom-separator')){
            $('#main-footer').css('paddingTop', '90px')
        }
		
		if ($('ul.mh_disable_top_tier').length) {
			$("ul.mh_disable_top_tier > li > ul").prev('a').attr('href', '#');
		}

		if (mh_is_fixed_nav) {
				mh_calculate_header_values();

				$main_container_wrapper.css('paddingTop', mh_header_height - 1);

				mh_change_primary_nav_position();
			}
		mh_transparent_nav();
		if (mh_is_mobile_device) {
			$('.mhc_section_video_bg').each(function () {
				var $this_el = $(this);

				$this_el.css('visibility', 'hidden').closest('.mhc_preload').removeClass('mhc_preload')
			});

			$('body').addClass('mh_mobile_device');

			if (!mh_is_ipad) {
				$('body').addClass('mh_mobile_device_not_ipad');
			}
		}

		$mh_search_icon.click(function () {
			var $this_el = $(this),
				$form = $this_el.siblings('.mh-search-form');

			if ($form.hasClass('mh-hidden')) {
				$form.css({
					'display': 'block',
					'opacity': 0
				}).animate({
					opacity: 1
				}, 500);
			} else {
				$form.animate({
					opacity: 0
				}, 500);
			}

			$form.toggleClass('mh-hidden');
		});

		if ($mhc_video_section.length) {
			$mhc_video_section.find('video').mediaelementplayer({
				pauseOtherPlayers: false,
				success: function (mediaElement, domObject) {
					mediaElement.addEventListener('loadeddata', function () {
						mhc_resize_section_video_bg($(domObject));
						mhc_center_video($(domObject));
					}, false);

					mediaElement.addEventListener('canplay', function () {
						$(domObject).closest('.mhc_preload').removeClass('mhc_preload');
					}, false);
				}
			});
		}
        
        //translate magnificPopup
        $.extend(true, $.magnificPopup.defaults, {
            tClose: mh_theme.mp_close,
            tLoading: mh_theme.mp_loading,
            gallery: {
            tPrev: mh_theme.mp_prev,
            tNext: mh_theme.mp_next,
            tCounter: mh_theme.mp_counter,
            },
            image: {
            tError: mh_theme.mp_error_image
            },
            ajax: {
            tError: mh_theme.mp_error_ajax
            }
        });

		if ($mh_post_gallery.length || $mhc_flickity_lightbox.length) {
            // Swipe Support for magnificPopup
			var magnificPopup = $.magnificPopup.instance;
            
            if(is_rtl){
                $( 'body' ).on( 'swipeleft', '.mfp-container', function() {
                    magnificPopup.prev();
                } );
                $( 'body' ).on( 'swiperight', '.mfp-container', function() {
                    magnificPopup.next();
                } );
            }
            else{
                $( 'body' ).on( 'swiperight', '.mfp-container', function() {
                    magnificPopup.prev();
                } );
                $( 'body' ).on( 'swipeleft', '.mfp-container', function() {
                    magnificPopup.next();
                } );
            }
            
			$mh_post_gallery.each(function () {
				$(this).magnificPopup({
					delegate: '.mhc_gallery_image a',
					type: 'image',
					removalDelay: 500,
					gallery: {
						enabled: true,
						navigateByImgClick: true
					},
					mainClass: 'mfp-fade',
					zoom: {
						enabled: true,
						duration: 500,
						opener: function (element) {
							return element.find('img');
						}
					}
                    ,
					callbacks: {
						afterClose: function() {
                            if($('body').hasClass('nice-scroll')){
                                    $('html').css('overflow-y', 'hidden');
                            }
                        }
					}
				});
			});
            // prevent attaching of any further actions on click
            $mh_post_gallery.find( 'a' ).unbind( 'click' );
            
            $mhc_flickity_lightbox.each(function () {
				$(this).magnificPopup({
					delegate: 'a',
					type: 'image',
					removalDelay: 500,
					gallery: {
						enabled: true,
						navigateByImgClick: true
					},
					mainClass: 'mfp-fade',
					zoom: {
						enabled: true,
						duration: 500,
						opener: function (element) {
							return element.find('img');
						}
					}
                    ,
					callbacks: {
						afterClose: function() {
                            if($('body').hasClass('nice-scroll')){
                                    $('html').css('overflow-y', 'hidden');
                            }
                        }
					}
				});
			});
		}

		if ($mh_lightbox_image.length) {
			$mh_lightbox_image.magnificPopup({
				type: 'image',
				removalDelay: 500,
				mainClass: 'mfp-fade',
				zoom: {
					enabled: true,
					duration: 500,
					opener: function (element) {
						return element.find('img');
					}
				},
				callbacks: {
					afterClose: function() {
                        if($('body').hasClass('nice-scroll')){
                            $('html').css('overflow-y', 'hidden');
                        }
					}
				}
			});
		}

		if ($mhc_slider.length) {
			$mhc_slider.each(function () {
				var $this_slider = $(this),
					mh_slider_settings = {
						fade_speed: 700,
						slide: ! $this_slider.hasClass( 'mhc_gallery' ) ? '.mhc_slide' : '.mhc_gallery_item'
					}

				if ($this_slider.hasClass('mhc_slider_no_arrows'))
					mh_slider_settings.use_arrows = false;

				if ($this_slider.hasClass('mhc_slider_no_pagination'))
					mh_slider_settings.use_controls = false;

				if ($this_slider.hasClass('mh_slider_auto')) {
					var mh_slider_autospeed_class_value = /mh_slider_speed_(\d+)/g;

					mh_slider_settings.slideshow = true;

					mh_slider_autospeed = mh_slider_autospeed_class_value.exec($this_slider.attr('class'));

					mh_slider_settings.slideshow_speed = mh_slider_autospeed[1];
				}

				if ($this_slider.parent().hasClass('mhc_video_slider')) {
					mh_slider_settings.controls_below = true;
					mh_slider_settings.append_controls_to = $this_slider.parent();
					setTimeout(function () {
						$('.mhc_preload').removeClass('mhc_preload');
					}, 500);
				}

				if ($this_slider.hasClass('mhc_slider_carousel'))
					mh_slider_settings.use_carousel = true;


				$this_slider.mhc_simple_slider(mh_slider_settings);

			});
		}

		$mhc_carousel = $('.mhc_carousel');
		if ($mhc_carousel.length) {
			$mhc_carousel.each(function () {
				var $this_carousel = $(this),
					mh_carousel_settings = {
						fade_speed: 1000
					};

				$this_carousel.mhc_simple_carousel(mh_carousel_settings);
			});
		}


		if ($mhc_fullwidth_portfolio.length) {

			function set_fullwidth_portfolio_columns($the_portfolio, carousel_mode) {
				var columns,
					$portfolio_items = $the_portfolio.find('.mhc_portfolio_items'),
					portfolio_items_width = $portfolio_items.width(),
					$the_portfolio_items = $portfolio_items.find('.mhc_portfolio_item'),
					portfolio_item_count = $the_portfolio_items.length;

				// calculate column breakpoints
				if (portfolio_items_width >= 1600) {
					columns = 5;
				} else if (portfolio_items_width >= 1024) {
					columns = 4;
				} else if (portfolio_items_width >= 768) {
					columns = 3;
				} else if (portfolio_items_width >= 480) {
					columns = 2;
				} else {
					columns = 1;
				}

				// set height of items
				portfolio_item_width = portfolio_items_width / columns;
				portfolio_item_height = portfolio_item_width * .75;

				if (carousel_mode) {
					$portfolio_items.css({
						'height': portfolio_item_height
					});
				}

				$the_portfolio_items.css({
					'height': portfolio_item_height
				});

				if (columns === $portfolio_items.data('columns')) {
					return;
				}

				if ($the_portfolio.data('columns_setting_up')) {
					return;
				}

				$the_portfolio.data('columns_setting_up', true);

				var portfolio_item_width_percentage = (100 / columns) + '%';
				$the_portfolio_items.css({
					'width': portfolio_item_width_percentage
				});

				// store last setup column
				$portfolio_items.removeClass('columns-' + $portfolio_items.data('columns'));
				$portfolio_items.addClass('columns-' + columns);
				$portfolio_items.data('columns', columns);

				if (!carousel_mode) {
					return $the_portfolio.data('columns_setting_up', false);
				}

				// kill all previous groups to get ready to re-group
				if ($portfolio_items.find('.mhc_carousel_group').length) {
					$the_portfolio_items.appendTo($portfolio_items);
					$portfolio_items.find('.mhc_carousel_group').remove();
				}

				// setup the grouping
				var the_portfolio_items = $portfolio_items.data('items'),
					$carousel_group = $('<div class="mhc_carousel_group active">').appendTo($portfolio_items);

				$the_portfolio_items.data('position', '');
				if (the_portfolio_items.length <= columns) {
					$portfolio_items.find('.mhc-slider-arrows').hide();
				} else {
					$portfolio_items.find('.mhc-slider-arrows').show();
				}

				for (position = 1, x = 0; x < the_portfolio_items.length; x++, position++) {
					if (x < columns) {
						$(the_portfolio_items[x]).show();
						$(the_portfolio_items[x]).appendTo($carousel_group);
						$(the_portfolio_items[x]).data('position', position);
						$(the_portfolio_items[x]).addClass('position_' + position);
					} else {
						position = $(the_portfolio_items[x]).data('position');
						$(the_portfolio_items[x]).removeClass('position_' + position);
						$(the_portfolio_items[x]).data('position', '');
						$(the_portfolio_items[x]).hide();
					}
				}

				$the_portfolio.data('columns_setting_up', false);

			}

			function mh_carousel_auto_rotate($carousel) {
				if ('on' === $carousel.data('auto-rotate') && $carousel.find('.mhc_portfolio_item').length > $carousel.find('.mhc_carousel_group .mhc_portfolio_item').length && !$carousel.hasClass('mh_carousel_hovered')) {

					mh_carousel_timer = setTimeout(function () {
						$carousel.find('.mhc-arrow-next').click();
					}, $carousel.data('auto-rotate-speed'));

					$carousel.data('mh_carousel_timer', mh_carousel_timer);
				}
			}

			$mhc_fullwidth_portfolio.each(function () {
				var $the_portfolio = $(this),
					$portfolio_items = $the_portfolio.find('.mhc_portfolio_items');

				$portfolio_items.data('items', $portfolio_items.find('.mhc_portfolio_item').toArray());
				$the_portfolio.data('columns_setting_up', false);

				if ($the_portfolio.hasClass('mhc_fullwidth_portfolio_carousel')) {
					$portfolio_items.prepend('<div class="mhc-slider-arrows"><a class="mhc-arrow-prev" href="#">' + '<span>' + mh_theme.previous_text + '</span>' + '</a><a class="mhc-arrow-next" href="#">' + '<span>' + mh_theme.next_text + '</span>' + '</a></div>');

					set_fullwidth_portfolio_columns($the_portfolio, true);

					mh_carousel_auto_rotate($the_portfolio);
                    
                    // Swipe Support
                    if(is_rtl){
                        $the_portfolio.on( 'swipeleft', function() {
				            $( this ).find( '.mhc-arrow-prev' ).click();
                        });
                        $the_portfolio.on( 'swiperight', function() {
                            $( this ).find( '.mhc-arrow-next' ).click();
                        });
                    }
                    else{
                        $the_portfolio.on( 'swiperight', function() {
                            $( this ).find( '.mhc-arrow-prev' ).click();
                        });
                        $the_portfolio.on( 'swipeleft', function() {
                            $( this ).find( '.mhc-arrow-next' ).click();
                        });
                    }

					$the_portfolio.hover(
						function () {
							$(this).addClass('mh_carousel_hovered');
							if (typeof $(this).data('mh_carousel_timer') != 'undefined') {
								clearInterval($(this).data('mh_carousel_timer'));
							}
						},
						function () {
							$(this).removeClass('mh_carousel_hovered');
							mh_carousel_auto_rotate($(this));
						}
					);

					$the_portfolio.data('carouseling', false);

					$the_portfolio.on('click', '.mhc-slider-arrows a', function (e) {
						var $the_portfolio = $(this).parents('.mhc_fullwidth_portfolio'),
							$portfolio_items = $the_portfolio.find('.mhc_portfolio_items'),
							$the_portfolio_items = $portfolio_items.find('.mhc_portfolio_item'),
							$active_carousel_group = $portfolio_items.find('.mhc_carousel_group.active'),
							slide_duration = 700,
							items = $portfolio_items.data('items'),
							columns = $portfolio_items.data('columns'),
							item_width = $active_carousel_group.innerWidth() / columns,
							original_item_width = (100 / columns) + '%';

						e.preventDefault();

						if ($the_portfolio.data('carouseling')) {
							return;
						}

						$the_portfolio.data('carouseling', true);

						$active_carousel_group.children().each(function () {
							$(this).css({
								'width': $(this).innerWidth() + 1,
								'position': 'absolute',
								'right': ($(this).innerWidth() * ($(this).data('position') - 1))
							});
						});

						if ($(this).hasClass('mhc-arrow-next')) {
							var $next_carousel_group,
								current_position = 1,
								next_position = 1,
								active_items_start = items.indexOf($active_carousel_group.children().first()[0]),
								active_items_end = active_items_start + columns,
								next_items_start = active_items_end,
								next_items_end = next_items_start + columns;

							$next_carousel_group = $('<div class="mhc_carousel_group next" style="display: none;right: 100%;position: absolute;top: 0;">').insertAfter($active_carousel_group);
							$next_carousel_group.css({
								'width': $active_carousel_group.innerWidth()
							}).show();

							// this is a loop
							for (x = 0, total = 0;; x++, total++) {
								if (total >= active_items_start && total < active_items_end) {
									$(items[x]).addClass('changing_position current_position current_position_' + current_position);
									$(items[x]).data('current_position', current_position);
									current_position++;
								}

								if (total >= next_items_start && total < next_items_end) {
									$(items[x]).data('next_position', next_position);
									$(items[x]).addClass('changing_position next_position next_position_' + next_position);

									if (!$(items[x]).hasClass('current_position')) {
										$(items[x]).addClass('container_append');
									} else {
										$(items[x]).clone(true).appendTo($active_carousel_group).hide().addClass('delayed_container_append_dup').attr('id', $(items[x]).attr('id') + '-dup');
										$(items[x]).addClass('delayed_container_append');
									}

									next_position++;
								}

								if (next_position > columns) {
									break;
								}

								if (x >= (items.length - 1)) {
									x = -1;
								}
							}

							sorted = $portfolio_items.find('.container_append, .delayed_container_append_dup').sort(function (a, b) {
								var el_a_position = parseInt($(a).data('next_position'));
								var el_b_position = parseInt($(b).data('next_position'));
								return (el_a_position < el_b_position) ? -1 : (el_a_position > el_b_position) ? 1 : 0;
							});

							$(sorted).show().appendTo($next_carousel_group);

							$next_carousel_group.children().each(function () {
								$(this).css({
									'width': item_width,
									'position': 'absolute',
									'right': (item_width * ($(this).data('next_position') - 1))
								});
							});

							$active_carousel_group.animate({
								right: '-100%'
							}, {
								duration: slide_duration,
								complete: function () {
									$portfolio_items.find('.delayed_container_append').each(function () {
										$(this).css({
											'width': item_width,
											'position': 'absolute',
											'right': (item_width * ($(this).data('next_position') - 1))
										});
										$(this).appendTo($next_carousel_group);
									});

									$active_carousel_group.removeClass('active');
									$active_carousel_group.children().each(function () {
										position = $(this).data('position');
										current_position = $(this).data('current_position');
										$(this).removeClass('position_' + position + ' ' + 'changing_position current_position current_position_' + current_position);
										$(this).data('position', '');
										$(this).data('current_position', '');
										$(this).hide();
										$(this).css({
											'position': '',
											'width': '',
											'right': ''
										});
										$(this).appendTo($portfolio_items);
									});

									$active_carousel_group.remove();

									mh_carousel_auto_rotate($the_portfolio);

								}
							});

							$next_carousel_group.addClass('active').css({
								'position': 'absolute',
								'top': 0,
								right: '100%'
							});
							$next_carousel_group.animate({
								right: '0%'
							}, {
								duration: slide_duration,
								complete: function () {
									setTimeout(function () {
										$next_carousel_group.removeClass('next').addClass('active').css({
											'position': '',
											'width': '',
											'top': '',
											'right': ''
										});

										$next_carousel_group.find('.delayed_container_append_dup').remove();

										$next_carousel_group.find('.changing_position').each(function (index) {
											position = $(this).data('position');
											current_position = $(this).data('current_position');
											next_position = $(this).data('next_position');
											$(this).removeClass('container_append delayed_container_append position_' + position + ' ' + 'changing_position current_position current_position_' + current_position + ' next_position next_position_' + next_position);
											$(this).data('current_position', '');
											$(this).data('next_position', '');
											$(this).data('position', (index + 1));
										});

										$next_carousel_group.children().css({
											'position': '',
											'width': original_item_width,
											'right': ''
										});

										$the_portfolio.data('carouseling', false);
									}, 100);
								}
							});

						} else {
							var $prev_carousel_group,
								current_position = columns,
								prev_position = columns,
								columns_span = columns - 1,
								active_items_start = items.indexOf($active_carousel_group.children().last()[0]),
								active_items_end = active_items_start - columns_span,
								prev_items_start = active_items_end - 1,
								prev_items_end = prev_items_start - columns_span;

							$prev_carousel_group = $('<div class="mhc_carousel_group prev" style="display: none;right: 100%;position: absolute;top: 0;">').insertBefore($active_carousel_group);
							$prev_carousel_group.css({
								'right': '-' + $active_carousel_group.innerWidth(),
								'width': $active_carousel_group.innerWidth()
							}).show();

							// this is a loop
							for (x = (items.length - 1), total = (items.length - 1);; x--, total--) {

								if (total <= active_items_start && total >= active_items_end) {
									$(items[x]).addClass('changing_position current_position current_position_' + current_position);
									$(items[x]).data('current_position', current_position);
									current_position--;
								}

								if (total <= prev_items_start && total >= prev_items_end) {
									$(items[x]).data('prev_position', prev_position);
									$(items[x]).addClass('changing_position prev_position prev_position_' + prev_position);

									if (!$(items[x]).hasClass('current_position')) {
										$(items[x]).addClass('container_append');
									} else {
										$(items[x]).clone(true).appendTo($active_carousel_group).addClass('delayed_container_append_dup').attr('id', $(items[x]).attr('id') + '-dup');
										$(items[x]).addClass('delayed_container_append');
									}

									prev_position--;
								}

								if (prev_position <= 0) {
									break;
								}

								if (x == 0) {
									x = items.length;
								}
							}

							sorted = $portfolio_items.find('.container_append, .delayed_container_append_dup').sort(function (a, b) {
								var el_a_position = parseInt($(a).data('prev_position'));
								var el_b_position = parseInt($(b).data('prev_position'));
								return (el_a_position < el_b_position) ? -1 : (el_a_position > el_b_position) ? 1 : 0;
							});

							$(sorted).show().appendTo($prev_carousel_group);

							$prev_carousel_group.children().each(function () {
								$(this).css({
									'width': item_width,
									'position': 'absolute',
									'right': (item_width * ($(this).data('prev_position') - 1))
								});
							});

							$active_carousel_group.animate({
								right: '100%'
							}, {
								duration: slide_duration,
								complete: function () {
									$portfolio_items.find('.delayed_container_append').reverse().each(function () {
										$(this).css({
											'width': item_width,
											'position': 'absolute',
											'right': (item_width * ($(this).data('prev_position') - 1))
										});
										$(this).prependTo($prev_carousel_group);
									});

									$active_carousel_group.removeClass('active');
									$active_carousel_group.children().each(function () {
										position = $(this).data('position');
										current_position = $(this).data('current_position');
										$(this).removeClass('position_' + position + ' ' + 'changing_position current_position current_position_' + current_position);
										$(this).data('position', '');
										$(this).data('current_position', '');
										$(this).hide();
										$(this).css({
											'position': '',
											'width': '',
											'right': ''
										});
										$(this).appendTo($portfolio_items);
									});

									$active_carousel_group.remove();
								}
							});

							$prev_carousel_group.addClass('active').css({
								'position': 'absolute',
								'top': 0,
								right: '-100%'
							});
							$prev_carousel_group.animate({
								right: '0%'
							}, {
								duration: slide_duration,
								complete: function () {
									setTimeout(function () {
										$prev_carousel_group.removeClass('prev').addClass('active').css({
											'position': '',
											'width': '',
											'top': '',
											'right': ''
										});

										$prev_carousel_group.find('.delayed_container_append_dup').remove();

										$prev_carousel_group.find('.changing_position').each(function (index) {
											position = $(this).data('position');
											current_position = $(this).data('current_position');
											prev_position = $(this).data('prev_position');
											$(this).removeClass('container_append delayed_container_append position_' + position + ' ' + 'changing_position current_position current_position_' + current_position + ' prev_position prev_position_' + prev_position);
											$(this).data('current_position', '');
											$(this).data('prev_position', '');
											position = index + 1;
											$(this).data('position', position);
											$(this).addClass('position_' + position);
										});

										$prev_carousel_group.children().css({
											'position': '',
											'width': original_item_width,
											'right': ''
										});
										$the_portfolio.data('carouseling', false);
									}, 100);
								}
							});
						}
					});

				} else {
					// setup fullwidth portfolio grid
					set_fullwidth_portfolio_columns($the_portfolio, false);
				}

			});	
			
		}
        
        function mh_audio_module_set() {
			if ( $( '.mhc_audio_module .mejs-audio' ).length || $( '.mh_audio_content .mejs-audio' ).length ) {
				$( '.mh_audio_container' ).each( function(){
					var $this_player = $( this ),
						$time_rail = $this_player.find( '.mejs-time-rail' ),
						$time_slider = $this_player.find( '.mejs-time-slider' );
					// remove previously added width and min-width attributes to calculate the new sizes accurately
					$time_rail.removeAttr( 'style' );
					$time_slider.removeAttr( 'style' );

					var $count_timer = $this_player.find( 'div.mejs-currenttime-container' ),
						player_width = $this_player.width(),
						controls_play_width = $this_player.find( '.mejs-play' ).outerWidth(),
						time_width = $this_player.find( '.mejs-currenttime-container' ).outerWidth(),
						volume_icon_width = $this_player.find( '.mejs-volume-button' ).outerWidth(),
						volume_bar_width = $this_player.find( '.mejs-horizontal-volume-slider' ).outerWidth(),
						new_time_rail_width;

					$count_timer.addClass( 'custom' );
					$this_player.find( '.mejs-controls div.mejs-duration-container' ).replaceWith( $count_timer );
					new_time_rail_width = player_width - ( controls_play_width + time_width + volume_icon_width + volume_bar_width + 65 );

					if ( 0 < new_time_rail_width ) {
						$time_rail.attr( 'style', 'min-width: ' + new_time_rail_width + 'px;' );
						$time_slider.attr( 'style', 'min-width: ' + new_time_rail_width + 'px;' );
					}
				});
			}
		}

		if ( $('.mhc_section_video').length ) {
			window._wpmejsSettings.pauseOtherPlayers = false;
		}

		if ($mhc_filterable_portfolio.length) {

			function mhc_filterable_portfolio_init() {
				$mhc_filterable_portfolio.each(function () {
					var $the_portfolio = $(this),
						$isrtl = true == is_rtl ? false : true, 
						$the_portfolio_items = $the_portfolio.find('.mhc_portfolio_items');

					$the_portfolio_items.imagesLoaded(function () {

						$the_portfolio.show(); //after all the content is loaded we can show the portfolio

						$the_portfolio_items.masonry({
							itemSelector: '.mhc_portfolio_item',
							columnWidth: $the_portfolio.find('.column_width').innerWidth(),
							gutter: $the_portfolio.find('.gutter_width').innerWidth(),
							transitionDuration: 0,
							isOriginLeft: $isrtl

						});

						set_filterable_grid_items($the_portfolio);

					});

					$the_portfolio.on('click', '.mhc_portfolio_filter a', function (e) {
						e.preventDefault();
						var category_slug = $(this).data('category-slug');
						$the_portfolio_items = $(this).parents('.mhc_filterable_portfolio').find('.mhc_portfolio_items');

						if ('all' == category_slug) {
							$the_portfolio.find('.mhc_portfolio_filter a').removeClass('active');
							$the_portfolio.find('.mhc_portfolio_filter_all a').addClass('active');
							$the_portfolio.find('.mhc_portfolio_item').removeClass('active');
							$the_portfolio.find('.mhc_portfolio_item').show();
							$the_portfolio.find('.mhc_portfolio_item').addClass('active');
                            
						} else {
                            
$the_portfolio.find('.mhc_portfolio_filter_all').removeClass('active');
							$the_portfolio.find('.mhc_portfolio_filter a').removeClass('active');
							$the_portfolio.find('.mhc_portfolio_filter_all a').removeClass('active');
							$(this).addClass('active');
                            $the_portfolio_items.find('.mhc_portfolio_item').hide();
							$the_portfolio_items.find('.mhc_portfolio_item').removeClass('active');
							$the_portfolio_items.find('.mhc_portfolio_item.project_category_' + $(this).data('category-slug')).show();
							$the_portfolio_items.find('.mhc_portfolio_item.project_category_' + $(this).data('category-slug')).addClass('active');
						}

						set_filterable_grid_items($the_portfolio);
						setTimeout(function () {
							set_filterable_portfolio_hash($the_portfolio);
						}, 500);
					});

					$(this).on('mh_hashchange', function (event) {
						var params = event.params;
						$the_portfolio = $('#' + event.target.id);

						if (!$the_portfolio.find('.mhc_portfolio_filter a[data-category-slug="' + params[0] + '"]').hasClass('active')) {
							$the_portfolio.find('.mhc_portfolio_filter a[data-category-slug="' + params[0] + '"]').click();
						}

						if (params[1]) {
							setTimeout(function () {
								if (!$the_portfolio.find('.mhc_portofolio_pagination a.page-' + params[1]).hasClass('active')) {
									$the_portfolio.find('.mhc_portofolio_pagination a.page-' + params[1]).addClass('active').click();
								}
							}, 300);
						}
					});
				});
			}
            
            // init portfolio if .load event was fired already, wait for the window load otherwise.
            if ( window.mh_load_init_event ) {
                mhc_filterable_portfolio_init();
            } else {
                $(window).load(function(){
                    mhc_filterable_portfolio_init();
                }); // End $(window).load()
            }

			function set_filterable_grid_items($the_portfolio) {
				var min_height = 0,
					$the_portfolio_items = $the_portfolio.find('.mhc_portfolio_items'),
					active_category = $the_portfolio.find('.mhc_portfolio_filter > a.active').data('category-slug'),
					masonry_data = Masonry.data($the_portfolio_items[0]),
                    $isrtl = true == is_rtl ? false : true;

				$the_portfolio_items.masonry('option', {
					'columnWidth': $the_portfolio.find('.column_width').innerWidth(),
					'gutter': $the_portfolio.find('.gutter_width').innerWidth(),
					'isOriginLeft': $isrtl
				});

				if (!$the_portfolio.hasClass('mhc_filterable_portfolio_fullwidth')) {
					$the_portfolio.find('.mhc_portfolio_item').css({
						minHeight: '',
						height: ''
					});
					$the_portfolio_items.masonry();
					if (masonry_data.cols > 1) {
						$the_portfolio.find('.mhc_portfolio_item').css({
							minHeight: '',
							height: ''
						});
						$the_portfolio.find('.mhc_portfolio_item').each(function () {
							if ($(this).outerHeight() > min_height)
								min_height = parseInt($(this).outerHeight()) + parseInt($(this).css('marginBottom').slice(0, -2)) + parseInt($(this).css('marginTop').slice(0, -2));
						});
						$the_portfolio.find('.mhc_portfolio_item').css({
							height: min_height,
							minHeight: min_height
						});
					}
				}

				if ('all' === active_category) {
					$the_portfolio_visible_items = $the_portfolio.find('.mhc_portfolio_item');
				} else {
					$the_portfolio_visible_items = $the_portfolio.find('.mhc_portfolio_item.project_category_' + active_category);
				}

				var visible_grid_items = $the_portfolio_visible_items.length,
					posts_number = $the_portfolio.data('posts-number'),
					pages = Math.ceil(visible_grid_items / posts_number);

				set_filterable_grid_pages($the_portfolio, pages);

				var visible_grid_items = 0;
				var _page = 1;
				$the_portfolio.find('.mhc_portfolio_item').data('page', '');
				$the_portfolio_visible_items.each(function (i) {
					visible_grid_items++;
					if (0 === parseInt(visible_grid_items % posts_number)) {
						$(this).data('page', _page);
						_page++;
					} else {
						$(this).data('page', _page);
					}
				});

				$the_portfolio_visible_items.filter(function () {
					return $(this).data('page') == 1;
				}).show();

				$the_portfolio_visible_items.filter(function () {
					return $(this).data('page') != 1;
				}).hide();

				$the_portfolio_items.masonry();
			}

			function set_filterable_grid_pages($the_portfolio, pages) {
				$pagination = $the_portfolio.find('.mhc_portofolio_pagination');

				if (!$pagination.length) {
					return;
				}

				$pagination.html('<ul></ul>');
				if (pages <= 1) {
					return;
				}

				$pagination_list = $pagination.children('ul');
				$pagination_list.append('<li class="prev" style="display:none;"><a href="#" data-page="prev" class="page-prev">' + mh_theme.prev + '</a></li>');
				for (var page = 1; page <= pages; page++) {
					var first_page_class = page === 1 ? ' active' : '',
						last_page_class = page === pages ? ' last-page' : '',
						hidden_page_class = page >= 5 ? ' style="display:none;"' : '';
					$pagination_list.append('<li' + hidden_page_class + ' class="page page-' + page + '"><a href="#" data-page="' + page + '" class="page-' + page + first_page_class + last_page_class + '">' + page + '</a></li>');
				}
				$pagination_list.append('<li class="next"><a href="#" data-page="next" class="page-next">' + mh_theme.next + '</a></li>');
			}

			$mhc_filterable_portfolio.on('click', '.mhc_portofolio_pagination a', function (e) {
				e.preventDefault();

				var to_page = $(this).data('page'),
					$the_portfolio = $(this).parents('.mhc_filterable_portfolio'),
					$the_portfolio_items = $the_portfolio.find('.mhc_portfolio_items');
				mhc_smooth_scroll($the_portfolio, false, 800);


				if ($(this).hasClass('page-prev')) {
					to_page = parseInt($(this).parents('ul').find('a.active').data('page')) - 1;
				} else if ($(this).hasClass('page-next')) {
					to_page = parseInt($(this).parents('ul').find('a.active').data('page')) + 1;
				}

				$(this).parents('ul').find('a').removeClass('active');
				$(this).parents('ul').find('a.page-' + to_page).addClass('active');

				var current_index = $(this).parents('ul').find('a.page-' + to_page).parent().index(),
					total_pages = $(this).parents('ul').find('li.page').length;

				$(this).parent().nextUntil('.page-' + (current_index + 3)).show();
				$(this).parent().prevUntil('.page-' + (current_index - 3)).show();

				$(this).parents('ul').find('li.page').each(function (i) {
					if (!$(this).hasClass('prev') && !$(this).hasClass('next')) {
						if (i < (current_index - 3)) {
							$(this).hide();
						} else if (i > (current_index + 1)) {
							$(this).hide();
						} else {
							$(this).show();
						}

						if (total_pages - current_index <= 2 && total_pages - i <= 5) {
							$(this).show();
						} else if (current_index <= 3 && i <= 4) {
							$(this).show();
						}

					}
				});

				if (to_page > 1) {
					$(this).parents('ul').find('li.prev').show();
				} else {
					$(this).parents('ul').find('li.prev').hide();
				}

				if ($(this).parents('ul').find('a.active').hasClass('last-page')) {
					$(this).parents('ul').find('li.next').hide();
				} else {
					$(this).parents('ul').find('li.next').show();
				}

				$the_portfolio.find('.mhc_portfolio_item').hide();
				$the_portfolio.find('.mhc_portfolio_item').filter(function (index) {
					return $(this).data('page') === to_page;
				}).show();

				$the_portfolio_items.masonry();

				setTimeout(function () {
					set_filterable_portfolio_hash($the_portfolio);
				}, 500);
			});

			function set_filterable_portfolio_hash($the_portfolio) {

				if (!$the_portfolio.attr('id')) {
					return;
				}

				var this_portfolio_state = [];
				this_portfolio_state.push($the_portfolio.attr('id'));
				this_portfolio_state.push($the_portfolio.find('.mhc_portfolio_filter > a.active').data('category-slug'));
                if ($the_portfolio.find('.mhc_portofolio_pagination a.active').length) {
					this_portfolio_state.push($the_portfolio.find('.mhc_portofolio_pagination a.active').data('page'));
				} else {
					this_portfolio_state.push(1);
				}

				this_portfolio_state = this_portfolio_state.join(mh_hash_module_param_seperator);

				mh_set_hash(this_portfolio_state);
			}
		} /*  end if ( $mhc_filterable_portfolio.length ) */
        
        if ($mhc_flickity_continer.length) {
            var $isrtl = true == is_rtl ? true : false;
            //@todo bug (empty cell) when wrapAround & lazyLoad are used together.
			 $mhc_flickity_continer.each(function () {
                var $flickity = $(this).find('.mhc_flickity');
              // $the_gallery_items_container.imagesLoaded(function () {
                    //after all the content is loaded we can show the gallery
                    $flickity.show();
                    $flickity.flickity({
                            cellAlign: $flickity.data('align'),
                            rightToLeft: $isrtl,
                            imagesLoaded: true,
                            freeScroll: true,
                            wrapAround: $flickity.data('infinite') == 'on' ? true : false,
                            //lazyLoad: $flickity.data('lazyload') == 'on' ? 1 : false,
                            setGallerySize: $flickity.data('setsize') == 'on' ? true : false,
                            autoPlay: $flickity.data('auto') == 'on' && $flickity.data('speed') !== '' ? $flickity.data('speed') : false,
                            prevNextButtons: $flickity.data('arrows') == 'on' ? true : false,
                            pageDots: $flickity.data('pagination') == 'on' ? true : false,
                            arrowShape: 'M75.1,92.3a4,4,0,0,1,0,5.6,3.9,3.9,0,0,1-5.5,0L24.9,52.8a4,4,0,0,1,0-5.6L69.5,2.2a3.9,3.9,0,0,1,5.5,0,4,4,0,0,1,0,5.6L34.4,50,75.1,92.3h0Z',
                    });
                });
          // });
        } //end $mhc_flickity.length

		if ($mhc_gallery.length) {

			function set_gallery_grid_items($the_gallery) {
				var $the_gallery_items_container = $the_gallery.find('.mhc_gallery_items'),
					$the_gallery_items = $the_gallery_items_container.find('.mhc_gallery_item'),
					total_grid_items = $the_gallery_items.length,
					posts_number = $the_gallery_items_container.data('per_page'),
					pages = Math.ceil(total_grid_items / posts_number),
					$isrtl = true == is_rtl ? false : true;

				$the_gallery_items_container.masonry('option', {
					'columnWidth': $the_gallery.find('.column_width').innerWidth(),
					'gutter': $the_gallery.find('.gutter_width').innerWidth(),
					'isOriginLeft': $isrtl
				});

				set_gallery_grid_pages($the_gallery, pages);

				var total_grid_items = 0;
				var _page = 1;
				$the_gallery_items.data('page', '');
				$the_gallery_items.each(function (i) {
					total_grid_items++;
					if (0 === parseInt(total_grid_items % posts_number)) {
						$(this).data('page', _page);
						_page++;
					} else {
						$(this).data('page', _page);
					}

				});

				var visible_items = $the_gallery_items.filter(function () {
					return $(this).data('page') == 1;
				}).show();

				$the_gallery_items.filter(function () {
					return $(this).data('page') != 1;
				}).hide();

				$the_gallery_items_container.masonry();
			}

			function set_gallery_grid_pages($the_gallery, pages) {
				$pagination = $the_gallery.find('.mhc_gallery_pagination');

				if (!$pagination.length) {
					return;
				}

				$pagination.html('<ul></ul>');
				if (pages <= 1) {
					$pagination.hide();
					return;
				}

				$pagination_list = $pagination.children('ul');
				$pagination_list.append('<li class="prev" style="display:none;"><a href="#" data-page="prev" class="page-prev">«</a></li>');
				for (var page = 1; page <= pages; page++) {
					var first_page_class = page === 1 ? ' active' : '',
						last_page_class = page === pages ? ' last-page' : '',
						hidden_page_class = page >= 5 ? ' style="display:none;"' : '';
					$pagination_list.append('<li' + hidden_page_class + ' class="page page-' + page + '"><a href="#" data-page="' + page + '" class="page-' + page + first_page_class + last_page_class + '">' + page + '</a></li>');
				}
				$pagination_list.append('<li class="next"><a href="#" data-page="next" class="page-next">»</a></li>');
			}

			function set_gallery_hash($the_gallery) {

				if (!$the_gallery.attr('id')) {
					return;
				}

				var this_gallery_state = [];
				this_gallery_state.push($the_gallery.attr('id'));

				if ($the_gallery.find('.mhc_gallery_pagination a.active').length) {
					this_gallery_state.push($the_gallery.find('.mhc_gallery_pagination a.active').data('page'));
				} else {
					this_gallery_state.push(1);
				}

				this_gallery_state = this_gallery_state.join(mh_hash_module_param_seperator);

				mh_set_hash(this_gallery_state);
			}

			$mhc_gallery.each(function () {
				var $the_gallery = $(this);

				if ($the_gallery.hasClass('mhc_gallery_grid')) {
					$the_gallery.imagesLoaded(function () {

						$the_gallery.show(); //after all the content is loaded we can show the gallery

						$the_gallery.find('.mhc_gallery_items').masonry({
							itemSelector: '.mhc_gallery_item',
							columnWidth: $the_gallery.find('.column_width').innerWidth(),
							gutter: $the_gallery.find('.gutter_width').innerWidth(),
							transitionDuration: 0
						});

						set_gallery_grid_items($the_gallery);
					});

					$the_gallery.on('mh_hashchange', function (event) {
						var params = event.params;
						$the_gallery = $('#' + event.target.id);

						if (page_to = params[0]) {
							setTimeout(function () {
								if (!$the_gallery.find('.mhc_gallery_pagination a.page-' + page_to).hasClass('active')) {
									$the_gallery.find('.mhc_gallery_pagination a.page-' + page_to).addClass('active').click();
								}
							}, 300);
						}
					});
                }

			});

			$mhc_gallery.data('paginating', false);
			$mhc_gallery.on('click', '.mhc_gallery_pagination a', function (e) {
				e.preventDefault();

				var to_page = $(this).data('page'),
					$the_gallery = $(this).parents('.mhc_gallery'),
					$the_gallery_items_container = $the_gallery.find('.mhc_gallery_items'),
					$the_gallery_items = $the_gallery_items_container.find('.mhc_gallery_item');

				if ($the_gallery.data('paginating')) {
					return;
				}

				$the_gallery.data('paginating', true);

				if ($(this).hasClass('page-prev')) {
					to_page = parseInt($(this).parents('ul').find('a.active').data('page')) - 1;
				} else if ($(this).hasClass('page-next')) {
					to_page = parseInt($(this).parents('ul').find('a.active').data('page')) + 1;
				}

				$(this).parents('ul').find('a').removeClass('active');
				$(this).parents('ul').find('a.page-' + to_page).addClass('active');

				var current_index = $(this).parents('ul').find('a.page-' + to_page).parent().index(),
					total_pages = $(this).parents('ul').find('li.page').length;

				$(this).parent().nextUntil('.page-' + (current_index + 3)).show();
				$(this).parent().prevUntil('.page-' + (current_index - 3)).show();

				$(this).parents('ul').find('li.page').each(function (i) {
					if (!$(this).hasClass('prev') && !$(this).hasClass('next')) {
						if (i < (current_index - 3)) {
							$(this).hide();
						} else if (i > (current_index + 1)) {
							$(this).hide();
						} else {
							$(this).show();
						}

						if (total_pages - current_index <= 2 && total_pages - i <= 5) {
							$(this).show();
						} else if (current_index <= 3 && i <= 4) {
							$(this).show();
						}

					}
				});

				if (to_page > 1) {
					$(this).parents('ul').find('li.prev').show();
				} else {
					$(this).parents('ul').find('li.prev').hide();
				}

				if ($(this).parents('ul').find('a.active').hasClass('last-page')) {
					$(this).parents('ul').find('li.next').hide();
				} else {
					$(this).parents('ul').find('li.next').show();
				}

				$the_gallery_items.hide();
				var visible_items = $the_gallery_items.filter(function (index) {
					return $(this).data('page') === to_page;
				}).show();

				$the_gallery_items_container.masonry();
				$the_gallery.data('paginating', false);

				setTimeout(function () {
					set_gallery_hash($the_gallery);
				}, 100);

				$('html, body').animate({
					scrollTop: $the_gallery.offset().top - 200
				}, 200);
			});

		} /*  end if ( $mhc_gallery.length ) */

		function mh_countdown_timer(timer) {
			var gmt_offset = timer.data('gmt-offset') * 3600000;

			var end_date = new Date(timer.data('end-date')).getTime();
			end_date = end_date + gmt_offset;

			var current_date = new Date(),
				month_names = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
			current_date = (month_names[current_date.getMonth()]) + ' ' + current_date.getDate() + ' ' + current_date.getFullYear() + ' ' + current_date.getHours() + ':' + current_date.getMinutes() + ':' + current_date.getSeconds();
			current_date = new Date(current_date).getTime() + gmt_offset;

			var seconds_left = (end_date - current_date) / 1000;

			days = parseInt(seconds_left / 86400);
			days = days > 0 ? days : 0;
			seconds_left = seconds_left % 86400;

			hours = parseInt(seconds_left / 3600);
			hours = hours > 0 ? hours : 0;

			seconds_left = seconds_left % 3600;

			minutes = parseInt(seconds_left / 60);
			minutes = minutes > 0 ? minutes : 0;

			seconds = parseInt(seconds_left % 60);
			seconds = seconds > 0 ? seconds : 0;

			if (days == 0) {
				if (!timer.find('.days > .value').parent('.section').hasClass('zero')) {
					timer.find('.days > .value').html('000').parent('.section').addClass('zero').next().addClass('zero');
				}
			} else {
				days_slice = days.toString().length >= 3 ? days.toString().length : 3;
				timer.find('.days > .value').html(('000' + days).slice(-days_slice));
			}

			if (days == 0 && hours == 0) {
				if (!timer.find('.hours > .value').parent('.section').hasClass('zero')) {
					timer.find('.hours > .value').html('00').parent('.section').addClass('zero').next().addClass('zero');
				}
			} else {
				timer.find('.hours > .value').html(('0' + hours).slice(-2));
			}

			if (days == 0 && hours == 0 && minutes == 0) {
				if (!timer.find('.minutes > .value').parent('.section').hasClass('zero')) {
					timer.find('.minutes > .value').html('00').parent('.section').addClass('zero').next().addClass('zero');
				}
			} else {
				timer.find('.minutes > .value').html(('0' + minutes).slice(-2));
			}

			if (days == 0 && hours == 0 && minutes == 0 && seconds == 0) {
				if (!timer.find('.seconds > .value').parent('.section').hasClass('zero')) {
					timer.find('.seconds > .value').html('00').parent('.section').addClass('zero');
				}
			} else {
				timer.find('.seconds > .value').html(('0' + seconds).slice(-2));
			}
		}

		function mh_countdown_timer_labels(timer) {
			if (timer.closest('.mhc_column_3_8').length || timer.children('.mhc_countdown_timer_container').width() <= 250) {
				timer.find('.hours .label').html(timer.find('.hours').data('short'));
				timer.find('.minutes .label').html(timer.find('.minutes').data('short'));
				timer.find('.seconds .label').html(timer.find('.seconds').data('short'));
			}
		}

		if ($mhc_countdown_timer.length) {
			$mhc_countdown_timer.each(function () {
				var timer = $(this);
				mh_countdown_timer_labels(timer);
				mh_countdown_timer(timer);
				setInterval(function () {
					mh_countdown_timer(timer);
				}, 1000);
			});

		}

		if ($mhc_tabs.length) {
			$mhc_tabs.mhc_simple_slider({
				use_controls: false,
				use_arrows: false,
				slide: '.mhc_all_tabs > div',
				tabs_animation: true
			}).on('mh_hashchange', function (event) {
				var params = event.params;
				var $the_tabs = $('#' + event.target.id);
				var active_tab = params[0];
				if (!$the_tabs.find('.mhc_tabs_controls li').eq(active_tab).hasClass('mhc_tab_active')) {
					$the_tabs.find('.mhc_tabs_controls li').eq(active_tab).click();
				}
			});

			$mhc_tabs_li.click(function () {
				var $this_el = $(this),
					$tabs_container = $this_el.closest('.mhc_tabs').data('mhc_simple_slider');

				if ($tabs_container.mh_animation_running) return false;

				$this_el.addClass('mhc_tab_active').siblings().removeClass('mhc_tab_active');

				$tabs_container.data('mhc_simple_slider').mh_slider_move_to($this_el.index());

				if ($this_el.closest('.mhc_tabs').attr('id')) {
					var tab_state = [];
					tab_state.push($this_el.closest('.mhc_tabs').attr('id'));
					tab_state.push($this_el.index());
					tab_state = tab_state.join(mh_hash_module_param_seperator);
					mh_set_hash(tab_state);
				}

				return false;
			});
		}

		if ($mhc_circle_counter.length) {

			window.mhc_circle_counter_init = function($the_counter, animate) {
				if ( 0 === $the_counter.width() ) {
					return;
				}
                
				$the_counter.easyPieChart({
                    //easing: 'easeInOutCirc',
					animate: {
						duration: 1800,
						enabled: true
					},
					size: 0 !== $the_counter.width() ? $the_counter.width() : 10,
					barColor: $the_counter.data('bar-bg-color'),
					trackColor: $the_counter.data('bar-bg-color'),
					trackAlpha: 0.2,
					scaleColor: false,
					lineWidth: $the_counter.data('bar-width'),
                    lineCap: $('body').hasClass('mh_rounded_corners') ||  $('body').hasClass('mh_capsule_corners') ? 'round' : 'butt',
					onStart: function () {
						$(this.el).find('.percent p').css({ 'visibility' : 'visible' });
					},
					onStep: function (from, to, percent) {
						$(this.el).find('.percent-value').text( Math.round( parseInt( percent ) ) );
					},
					onStop: function (from, to) {
						$(this.el).find('.percent-value').text( $(this.el).data('number-value') );
					}
				});
			}

            window.mhc_reinit_circle_counters = function( $mhc_circle_counter ) {
				$mhc_circle_counter.each(function(){
					var $the_counter = $(this);
					window.mhc_circle_counter_init($the_counter, false);

					$the_counter.on('containerWidthChanged', function( event ){
						$the_counter = $( event.target );
						$the_counter.find('canvas').remove();
						$the_counter.removeData('easyPieChart' );
						window.mhc_circle_counter_init($the_counter, true);
					});

				});
			}
			window.mhc_reinit_circle_counters( $mhc_circle_counter );
		}

		if ($mhc_number_counter.length) {
            window.mhc_reinit_number_counters = function( $mhc_number_counter ) {
                $mhc_number_counter.each(function () {
                    var $this_counter = $(this);
                    $this_counter.easyPieChart({
                        //easing: 'easeInOutCirc',
                        animate: {
                            duration: 2400,
                            enabled: true
                        },
                        size: 0,
                        trackColor: false,
                        scaleColor: false,
                        lineWidth: 0,
                        onStart: function () {
                            $(this.el).find('.percent p').css({
                                'visibility': 'visible'
                            });
                        },
                        onStep: function (from, to, percent) {
                            if (percent != to)
                                $(this.el).find('.percent-value').text(Math.round(parseInt(percent)));
                        },
                        onStop: function (from, to) {
                            $(this.el).find('.percent-value').text($(this.el).data('number-value'));
                        }
                    });
                });
            }
			window.mhc_reinit_number_counters( $mhc_number_counter );
		}
        
        if ( $mhc_shop.length ) {
			$mhc_shop.each( function() {
				var $this_el = $(this),
					icon     = $this_el.data('icon') || '';

				if ( icon === '' ) {
					return true;
				}

				$this_el.find( '.mh_overlay' ).attr( 'data-icon', icon ).addClass( 'mhc_data_icon' );
			} );
		}

		function mh_apply_parallax() {
			var $this = $(this),
				element_top = $this.offset().top,
				window_top = $mh_window.scrollTop(),
				y_pos = (((window_top + $mh_window.height()) - element_top) * 0.3),
				main_position;

			main_position = 'translate(0, ' + y_pos + 'px)';

			$this.find('.mh_parallax_bg').css({
				'-webkit-transform': main_position,
				'-moz-transform': main_position,
				'-ms-transform': main_position,
				'transform': main_position
			});
		}

		function mh_parallax_set_height() {
			var $this = $(this),
				bg_height;

			bg_height = ($mh_window.height() * 0.3 + $this.innerHeight());

			$this.find('.mh_parallax_bg').css({
				'height': bg_height
			});
		}

		$('.mhc_toggle_title').click( function(){
			var $this_heading         = $(this),
				$module               = $this_heading.closest('.mhc_toggle'),
				$section              = $module.parents( '.mhc_section' ),
				$content              = $module.find('.mhc_toggle_content'),
				$accordion            = $module.closest( '.mhc_accordion' ),
				is_accordion          = $accordion.length,
				is_accordion_toggling = $accordion.hasClass( 'mhc_accordion_toggling' ),
				window_offset_top     = $(window).scrollTop(),
                fixed_header_height   = 0,
                $accordion_active_toggle,
                module_offset;

			if ( is_accordion ) {
				if ( $module.hasClass('mhc_toggle_open') || is_accordion_toggling ) {
					return false;
				}

				$accordion.addClass( 'mhc_accordion_toggling' );
				$accordion_active_toggle = $module.siblings('.mhc_toggle_open');
			}

			if ( $content.is( ':animated' ) ) {
				return;
			}

			$content.slideToggle( 700, function() {
				if ( $module.hasClass('mhc_toggle_close') ) {
					$module.removeClass('mhc_toggle_close').addClass('mhc_toggle_open');
				} else {
					$module.removeClass('mhc_toggle_open').addClass('mhc_toggle_close');
				}

				if ( $section.hasClass( 'mhc_section_parallax' ) && !$section.children().hasClass( 'mhc_parallax_css') ) {
					$.proxy( mh_parallax_set_height, $section )();
				}
			} );

			if ( is_accordion ) {
				$accordion_active_toggle.find('.mhc_toggle_content').slideToggle( 700, function() {
					$accordion_active_toggle.removeClass( 'mhc_toggle_open' ).addClass('mhc_toggle_close');
					$accordion.removeClass( 'mhc_accordion_toggling' );
                    
                    module_offset = $module.offset();

                    // Calculate height of fixed nav
                    if ( $('#wpadminbar').length ) {
                        fixed_header_height += $('#wpadminbar').height();
                    }

                    if ( $('#top-header').length ) {
                        fixed_header_height += $('#top-header').height();
                    }

                    if ( $('#main-header').length) {
                        //fix for accordion jump when vertical nav is active
                        if ($('body').hasClass('mh_vertical_nav')) {
                            fixed_header_height += 0;
                        }else{
                           fixed_header_height += $('#main-header').height(); 
                        }
                    }

                    // Compare accordion offset against window's offset and adjust accordingly
                    if ( ( window_offset_top + fixed_header_height ) > module_offset.top ) {
                        $('html, body').animate({ scrollTop : ( module_offset.top - fixed_header_height - 50 ) });
                    }
                    
				} );
			}
		} );

		var $mh_contact_container = $('.mhc_contact_form_container');
        if ($mh_contact_container.length) {
            $mh_contact_container.each(function () {
                var $this_contact_container = $(this),
                    $mh_contact_form = $this_contact_container.find('form'),
                    $mh_contact_submit = $this_contact_container.find('input.mhc_contact_submit'),
                    $mh_inputs = $mh_contact_form.find('input[type=text],textarea'),
                    mh_email_reg = /^[\w-]+(\.[\w-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)*?\.[a-z]{2,6}|(\d{1,3}\.){3}\d{1,3})(:\d{4})?$/,
                    redirect_url = typeof $this_contact_container.data('redirect_url') !== 'undefined' ? $this_contact_container.data('redirect_url') : '';

                $mh_inputs.live('focus', function () {
                    if ($(this).val() === $(this).siblings('label').text()) {
                        $(this).val('');
                    }
                }).live('blur', function () {
                    if ('' === $(this).val()) {
                        $(this).val($(this).siblings('label').text());
                    }
                });

                $mh_contact_form.on('submit', function (event) {
                    var $this_contact_form = $(this),
                        $this_inputs = $this_contact_form.find('input[type=text],textarea'),
                        this_mh_contact_error = false,
                        $mh_contact_message = $this_contact_form.closest('.mhc_contact_form_container').find('.mhc-contact-message'),
                        mh_message = '',
                        mh_fields_message = '',
                        $this_contact_container = $this_contact_form.closest('.mhc_contact_form_container'),
                        $captcha_field = $this_contact_form.find('.mhc_contact_captcha'),
                        form_unique_id = typeof $this_contact_container.data('form_unique_num') !== 'undefined' ? $this_contact_container.data('form_unique_num') : 0,
                        inputs_list = [];
                    mh_message = '<ul>';

                    $this_inputs.removeClass('mh_contact_error');

                    $this_inputs.each(function () {
                        var $this_el = $(this),
                            this_val = $this_el.val(),
                            this_label = $this_el.siblings('label').text(),
                            field_type = typeof $this_el.data('field_type') !== 'undefined' ? $this_el.data('field_type') : 'text',
                            required_mark = typeof $this_el.data('required_mark') !== 'undefined' ? $this_el.data('required_mark') : 'not_required',
                            original_id = typeof $this_el.data('original_id') !== 'undefined' ? $this_el.data('original_id') : '',
                            default_value;

                        // add current field data into array of inputs
                        if (typeof $this_el.attr('id') !== 'undefined') {
                            inputs_list.push({
                                'field_id': $this_el.attr('id'),
                                'original_id': original_id,
                                'required_mark': required_mark,
                                'field_type': field_type,
                                'field_label': this_label
                            });
                        }

                        // add error message for the field if it is required and empty
                        if ('required' === required_mark && ('' === this_val || this_label === this_val)) {
                            $this_el.addClass('mh_contact_error');
                            this_mh_contact_error = true;

                            default_value = this_label;

                            if ('' === default_value) {
                                default_value = mh_theme.captcha;
                            }

                            mh_fields_message += '<li>' + default_value + '</li>';
                        }

                        // add error message if email field is not empty and fails the email validation
                        if ('email' === field_type && '' !== this_val && this_label !== this_val && !mh_email_reg.test(this_val)) {
                            $this_el.addClass('mh_contact_error');
                            this_mh_contact_error = true;

                            if (!mh_email_reg.test(this_val)) {
                                mh_message += '<li>' + mh_theme.invalid + '</li>';
                            }
                        }
                    });

                    // check the captcha value if required for current form
                    if ($captcha_field.length && '' !== $captcha_field.val()) {
                        var first_digit = parseInt($captcha_field.data('first_digit')),
                            second_digit = parseInt($captcha_field.data('second_digit'));

                        if (parseInt($captcha_field.val()) !== first_digit + second_digit) {

                            mh_message += '<li>' + mh_theme.wrong_captcha + '</li>';
                            this_mh_contact_error = true;

                            // generate new digits for captcha
                            first_digit = Math.floor((Math.random() * 15) + 1);
                            second_digit = Math.floor((Math.random() * 15) + 1);

                            // set new digits for captcha
                            $captcha_field.data('first_digit', first_digit);
                            $captcha_field.data('second_digit', second_digit);

                            // regenerate captcha on page
                            $this_contact_form.find('.mhc_contact_captcha_quiz').empty().append(first_digit + ' + ' + second_digit);
                        }

                    }

                    if (!this_mh_contact_error) {
                        var $href = $(this).attr('action'),
                            form_data = $(this).serializeArray();

                        form_data.push({
                            'name': 'mhc_contact_email_fields_' + form_unique_id,
                            'value': JSON.stringify(inputs_list)
                        });

                        $this_contact_container.fadeTo('fast', 0.2).load($href + ' #' + $this_contact_form.closest('.mhc_contact_form_container').attr('id'), form_data, function (responseText) {
                            if (!$(responseText).find('.mhc_contact_error_text').length) {

                                // redirect if redirect URL is not empty and no errors in contact form
                                if ('' !== redirect_url) {
                                    window.location.href = redirect_url;
                                }
                            }

                            $this_contact_container.fadeTo('fast', 1);
                        });
                    }

                    mh_message += '</ul>';

                    if ('' !== mh_fields_message) {
                        if (mh_message != '<ul></ul>') {
                            mh_message = '<p class="mh_normal_padding">' + mh_theme.contact_error + '</p>' + mh_message;
                        }

                        mh_fields_message = '<ul>' + mh_fields_message + '</ul>';

                        mh_fields_message = '<p>' + mh_theme.fill_message + '</p>' + mh_fields_message;

                        mh_message = mh_fields_message + mh_message;
                    }

                    if (mh_message != '<ul></ul>') {
                        $mh_contact_message.html(mh_message);

                        // If parent of this contact form uses parallax
                        if ($this_contact_container.parents('.mhc_section_parallax').length) {
                            $this_contact_container.parents('.mhc_section_parallax').each(function () {
                                var $parallax_element = $(this),
                                    $parallax = $parallax_element.children('.mh_parallax_bg'),
                                    is_true_parallax = (!$parallax.hasClass('mhc_parallax_css'));

                                if (is_true_parallax) {
                                    $mh_window.trigger('resize');
                                }
                            });
                        }
                    }

                    event.preventDefault();
                });
            });
        }

		$('.mhc_video .mhc_video_overlay, .mhc_video_wrap .mhc_video_overlay').click(function () {
			var $this = $(this),
				$video_image = $this.closest('.mhc_video_overlay');

			$video_image.fadeTo(500, 0, function () {
				var $image = $(this);

				$image.css('display', 'none');
			});

			return false;
		});

		function mh_fix_video_wmode(video_wrapper) {
			$(video_wrapper).each(function () {
				var $this_el = $(this).find('iframe'),
					src_attr = $this_el.attr('src'),
					wmode_character = src_attr.indexOf('?') == -1 ? '?' : '&amp;',
					this_src = src_attr + wmode_character + 'wmode=opaque';

				$this_el.attr('src', this_src);
			});
		}

		function mhc_resize_section_video_bg($video) {
			$element = typeof $video !== 'undefined' ? $video.closest('.mhc_section_video_bg') : $('.mhc_section_video_bg');

			$element.each(function () {
				var $this_el = $(this),
					ratio = (typeof $this_el.attr('data-ratio') !== 'undefined') ? $this_el.attr('data-ratio') : $this_el.find('video').attr('width') / $this_el.find('video').attr('height'),
					$video_elements = $this_el.find('.mejs-video, video, object').css('margin', 0),
					$container = $this_el.closest('.mhc_section_video').length ? $this_el.closest('.mhc_section_video') : $this_el.closest('.mhc_slides'),
					body_width = $container.width(),
					container_height = $container.innerHeight(),
					width, height;

				if (typeof $this_el.attr('data-ratio') == 'undefined')
					$this_el.attr('data-ratio', ratio);

				if (body_width / container_height < ratio) {
					width = container_height * ratio;
					height = container_height;
				} else {
					width = body_width;
					height = body_width / ratio;
				}

				$video_elements.width(width).height(height);
			});
		}

		function mhc_center_video($video) {
			$element = typeof $video !== 'undefined' ? $video : $('.mhc_section_video_bg .mejs-video');

			$element.each(function () {
				var $video_width = $(this).width() / 2;
				var $video_width_negative = 0 - $video_width;
				$(this).css("margin-left", $video_width_negative);

				if (typeof $video !== 'undefined') {
					if ($video.closest('.mhc_slider').length && !$video.closest('.mhc_first_video').length)
						return false;
				}
			});
		}

		function mh_calculate_header_values() {
			var $top_header = $('#top-header'),
				secondary_nav_height = $('body').hasClass('mh_secondary_nav_above') && $top_header.length && $top_header.is(':visible') ? $top_header.innerHeight() : 0,
				admin_bar_height = $('#wpadminbar').length ? $('#wpadminbar').innerHeight() : 0,
                $slide_menu_container = $( '.mh_app_nav_left .mh-app-nav' );
            
            mh_header_height = $('#main-header').innerHeight() + secondary_nav_height - 1,
            mh_header_modifier = mh_header_height <= 90 ? mh_header_height - 29 : mh_header_height - 56,
            mh_header_offset = mh_header_modifier + admin_bar_height - 114;
			mh_primary_header_top = secondary_nav_height + admin_bar_height -1;
            
            if ( $slide_menu_container.length && ! $( 'body' ).hasClass( 'mh-app-nav-active' ) ) {
				$slide_menu_container.css( { left: '-' + $slide_menu_container.innerWidth() + 'px', 'display' : 'none' } );
			}
		}

		function mh_fix_slider_height() {
				if (!$mhc_slider.length) return;

				$mhc_slider.each(function () {
					var $slide = $(this).find('.mhc_slide'),
						$slide_container = $slide.find('.mhc_container'),
						max_height = 0;

					$slide_container.css('min-height', 0);

					$slide.each(function () {
						var $this_el = $(this),
							height = $this_el.innerHeight();

						if (max_height < height)
							max_height = height;
					});

					$slide_container.css('min-height', max_height);
				});
			} //mh_fix_slider_height();
        
        // Add conditional class to prevent unwanted dropdown nav
		function mh_fix_nav_direction() {
			window_width = $(window).width();
			$('.nav li.mh-reverse-direction-nav').removeClass( 'mh-reverse-direction-nav' );
			$('.nav li.no-mega-menu li ul').each(function(){
				var $dropdown       = $(this),
					dropdown_width  = $dropdown.width(),
					dropdown_offset = $dropdown.offset(),
					$parents        = $dropdown.parents('.nav > li');
				if ( is_rtl && (dropdown_offset.left < ( dropdown_width )) ) {
                    $parents.addClass( 'mh-reverse-direction-nav' );
                    
                } else if ( dropdown_offset.left > ( window_width - dropdown_width ) ) {
                    $parents.addClass( 'mh-reverse-direction-nav' );
                    
                }
                
			});
		} //mh_fix_nav_direction
        mh_fix_nav_direction();

		var $comment_form = $('#commentform');

		mhc_form_placeholders_init($comment_form);
		mhc_form_placeholders_init($('.mhc_newsletter_form'));

		$comment_form.submit(function () {
			mhc_remove_placeholder_text($comment_form);
		});

		function mhc_form_placeholders_init($form) {
			$form.find('input:text, textarea').each(function (index, domEle) {
				var $mh_current_input = jQuery(domEle),
					$mh_comment_label = $mh_current_input.siblings('label'),
					mh_comment_label_value = $mh_current_input.siblings('label').text();
				if ($mh_comment_label.length) {
					$mh_comment_label.hide();
					if ($mh_current_input.siblings('span.required')) {
						mh_comment_label_value += $mh_current_input.siblings('span.required').text();
						$mh_current_input.siblings('span.required').hide();
					}
					$mh_current_input.val(mh_comment_label_value);
				}
			}).bind('focus', function () {
				var mh_label_text = jQuery(this).siblings('label').text();
				if (jQuery(this).siblings('span.required').length) mh_label_text += jQuery(this).siblings('span.required').text();
				if (jQuery(this).val() === mh_label_text) jQuery(this).val("");
			}).bind('blur', function () {
				var mh_label_text = jQuery(this).siblings('label').text();
				if (jQuery(this).siblings('span.required').length) mh_label_text += jQuery(this).siblings('span.required').text();
				if (jQuery(this).val() === "") jQuery(this).val(mh_label_text);
			});
		}

		// remove placeholder text before form submission
		function mhc_remove_placeholder_text($form) {
			$form.find('input:text, textarea').each(function (index, domEle) {
				var $mh_current_input = jQuery(domEle),
					$mh_label = $mh_current_input.siblings('label'),
					mh_label_value = $mh_current_input.siblings('label').text();

				if ($mh_label.length && $mh_label.is(':hidden')) {
					if ($mh_label.text() == $mh_current_input.val())
						$mh_current_input.val('');
				}
			});
		}

		mh_duplicate_menu($('#mh-top-navigation ul.nav'), $('#mh-top-navigation .mobile_nav'), 'mobile_menu', 'mh_mobile_menu');


		$('.mhc_fullwidth_menu ul.nav').each(function (i) {
			i++;
			mh_duplicate_menu($(this), $(this).parents('.mhc_row').find('div .mobile_nav'), 'mobile_menu' + i, 'mh_mobile_menu');
		});

		$('.mhc_fullwidth_menu').each(function () {
			var this_menu = $(this),
				bg_color = this_menu.data('bg_color');
			if (bg_color) {
				this_menu.find('.fullwidth-menu-nav ul ul').css({
					'background-color': bg_color
				});
			}
		});


		if ($('#mh-secondary-nav').length) {
			$('#mh-top-navigation #mobile_menu').append($('#mh-secondary-nav').clone().html());
		}

		$mhc_newsletter_button.click(function (event) {
			if ($(this).closest('.mhc_login_form').length || $(this).closest('.mhc_feedburner_form').length) {
				return;
			}

			event.preventDefault();

			var $newsletter_container = $(this).closest('.mhc_newsletter'),
				$firstname = $newsletter_container.find('input[name="mhc_signup_firstname"]'),
				$lastname = $newsletter_container.find('input[name="mhc_signup_lastname"]'),
				$email = $newsletter_container.find('input[name="mhc_signup_email"]'),
				list_id = $newsletter_container.find('input[name="mhc_signup_list_id"]').val(),
				$result = $newsletter_container.find('.mhc_newsletter_result').hide(),
				service = $(this).closest('.mhc_newsletter_form').data('service') || 'mailchimp';

			$firstname.removeClass('mhc_signup_error');
			$lastname.removeClass('mhc_signup_error');
			$email.removeClass('mhc_signup_error');

			mhc_remove_placeholder_text($(this).closest('.mhc_newsletter_form'));

			if ($firstname.val() == '' || $email.val() == '' || list_id === '') {
				if ($firstname.val() == '') $firstname.addClass('mhc_signup_error');

				if ($email.val() == '') $email.addClass('mhc_signup_error');

				if ($firstname.val() == '')
					$firstname.val($firstname.siblings('.mhc_contact_form_label').text());

				if ($lastname.val() == '')
					$lastname.val($lastname.siblings('.mhc_contact_form_label').text());

				if ($email.val() == '')
					$email.val($email.siblings('.mhc_contact_form_label').text());

				return;
			}

			$.ajax({
				type: "POST",
				url: mh_theme.ajaxurl,
				dataType: "json",
				data: {
					action: 'mhc_submit_subscribe_form',
					mh_script_nonce: mh_theme.mh_script_nonce,
					mh_list_id: list_id,
					mh_firstname: $firstname.val(),
					mh_lastname: $lastname.val(),
					mh_email: $email.val(),
					mh_service: service
				},
				success: function (data) {
					if (data) {
						if (service == 'mailchimp') {
							if (data.error) {
								$result.html(data.error).show();
							}
							if (data.success) {
								$newsletter_container.find('.mhc_newsletter_form > p').hide();
								$result.html(data.success).show();
							}
						} else {
							$newsletter_container.find('.mhc_newsletter_form > p').hide();
							$result.html(data).show();
						}
					} else {
						$result.html(mh_theme.subscription_failed).show();
					}
				}
			});
		});

		function mh_change_primary_nav_position() {
			var $body = $('body');
			
			if (!$body.hasClass('mh_vertical_nav') && ($body.hasClass('mh_fixed_nav'))) {
				$('#main-header').css('top', mh_primary_header_top);
			}

		}
		
		function mh_transparent_nav() {		
					if ($('body').hasClass('page-template-page-template-trans') && !$('body').hasClass('mh_vertical_nav') && $(window).width() > 980) {
						$('#mh-main-area').css('marginTop', '-' + parseInt($('#main-header').outerHeight()) + 'px');
						$('#mh-main-area').css({
							opacity: 1,
							width: '100%',
							display: 'inline-block',
						}, 300);
					} else 
						if ($('body').hasClass('page-template-page-template-trans') && !$('body').hasClass('mh_vertical_nav') && $(window).width() < 980) {
						$('#mh-main-area').css('marginTop', '0' + 'px');
//						$('#mh-main-area').css({
//							opacity: 1
//						}, 300);
					}
		}
        
        window.mh_reinint_waypoint_modules = function() {
            if ( $.fn.waypoint ) {
                var $mhc_circle_counter = $( '.mhc_circle_counter' ),
                    $mhc_number_counter = $( '.mhc_number_counter' ),
                    $mhc_animation_scrollout = $('.mhc_animation_scrollout'),
                    $mhc_video_background = $( '.mhc_section_video_bg video' );

                $( '.mhc_counter_container, .mh-waypoint' ).waypoint( {
                    offset: '75%',
                    handler: function() {
                        $(this.element).addClass( 'mh-animated' );
                    }
                } );
                
                // to make sure element become visible when it's on the bottom of page
                $( '.mhc_counter_container, .mh-waypoint' ).waypoint( {
                    offset: 'bottom-in-view',
                    handler: function() {
                        $(this.element).addClass( 'mh-animated' );
                    }
                } );

                if ( $mhc_circle_counter.length ) {
                    $mhc_circle_counter.each(function(){
                        var $this_counter = $(this);
                        if ( ! $this_counter.is( ':visible' ) ) {
                            return;
                        }
                        $this_counter.waypoint({
                            offset: '65%',
                            handler: function() {
                                
                                if ( $this_counter.data( 'PieChartHasLoaded' ) ) {
                                    return;
                                }
                                $this_counter.data('easyPieChart').update( $this_counter.data('number-value') );
                                $this_counter.data( 'PieChartHasLoaded', true );
                                
                            }
				        });

                        // to make sure animation applied when element is on the bottom of page
                        $this_counter.waypoint({
                            offset: 'bottom-in-view',
                            handler: function() {
                                if ( $this_counter.data( 'PieChartHasLoaded' ) ) {
                                    return;
                                }
                                $this_counter.data('easyPieChart').update( $this_counter.data('number-value') );
                                $this_counter.data( 'PieChartHasLoaded', true );
                            }
                        });
                    });
                }

                if ( $mhc_number_counter.length ) {
                    $mhc_number_counter.each(function(){
                        var $this_counter = $(this);
                        $this_counter.waypoint({
                            offset: '75%',
                            handler: function() {
                                $this_counter.data('easyPieChart').update( $this_counter.data('number-value') );
                            }
                        });
                        
                        
                        // to make sure animation applied when element is on the bottom of page
						$this_counter.waypoint({
                            offset: 'bottom-in-view',
                            handler: function() {
								$this_counter.data('easyPieChart').update( $this_counter.data('number-value') );
				            }
				        });
				    });
				}

                if (mh_is_fixed_nav) {
                    //#main-content
                    $('#mh-top-navigation').waypoint({
                        offset: function () {
                            if (mhRecalculateOffset) {
                                mh_calculate_header_values();
                                mhRecalculateOffset = true;
                            }

                            return mh_header_offset;
                        },
                        handler: function (direction) {
                            if ( $(window).width() > 767 && !mh_is_mobile_device) {
                                if (direction === 'down') {
                                    $('#main-header').addClass('mh-fixed-header');
                                    $('#main-header').removeClass('transparent');
                                } else {
                                    $('#main-header').removeClass('mh-fixed-header');
                                    $('#main-header').addClass('transparent');
                                }
                            }
                        }
                    });
                }
                
                //fadeOut on scroll down
                if ( $mhc_animation_scrollout.length && $(window).width() > 767 && !mh_is_mobile_device) {
                    $mhc_animation_scrollout.each(function(){
                        var $this_scrollout = $(this),
                            headerheight = $('mhc_title_container').height();
                        if ( ! $this_scrollout.is( ':visible' ) ) {
                            return;
                        }
                        $this_scrollout.waypoint({
                            offset: (headerheight),
                            handler: function (direction) {
                                if (direction === 'down') {
                                    $this_scrollout.addClass('mh-animated');
                                } else {
                                    $this_scrollout.removeClass('mh-animated');
                                }
                            }
                        });
                    });
                }
                
                if ( $mhc_video_background.length ) {
                    $mhc_video_background.each( function(){
                        var $this_video_background = $(this),
                            $video_background_wrapper = $this_video_background.closest( '.mhc_section_video_bg' ),
                            this_video_player = this.player;

                        // Entering video's top viewport
                        $video_background_wrapper.waypoint({
                            offset: '100%',
                            handler : function( direction ) {
                                if ( $this_video_background.is(':visible') && direction === 'down' ) {
                                    this_video_player.play();
                                } else if ( $this_video_background.is(':visible') && direction === 'up' ) {
                                    this_video_player.pause();
                                }
                            }
                        });

                        // Entering video's bottom viewport
                        $video_background_wrapper.waypoint({
                            offset: '-50%',
                            handler : function( direction ) {
                                if ( $this_video_background.is(':visible') && direction === 'up' ) {
                                    this_video_player.play();
                                } else if ( $this_video_background.is(':visible') && direction === 'down' ) {
                                    this_video_player.pause();
                                }
                            }
                        });
                    });
                }

            } // end if ( $.fn.waypoint )
        } // mh_reinint_waypoint_modules
        
        // Save container width on page load for reference
		$mh_container.data( 'previous-width', $mh_container.width() );
		
		$(window).resize(function () {
			var window_width = $mh_window.width(),
                mh_container_previous_width = $mh_container.data('previous-width'),
                containerWidthChanged       = mh_container_previous_width !== window_width,
                $slide_menu_container       = $( '.mh-app-nav' );
                
                mhc_resize_section_video_bg();
                mhc_center_video();
                $window_height = $(window).height();
                mh_fix_nav_direction();
                mh_fix_slider_height();

                if ($('.mhc_blog_grid').length)
                    $('.mhc_blog_grid').masonry();
            
                 if ($('.mh_magazine_grid').length)
				     $('.mh_magazine_grid_container').masonry();

                setTimeout(function () {
                    mh_transparent_nav();
                }, 200);
            
                // Update container width data for future resizing reference
				$mh_container.data('previous-width', window_width );
            
            if ( $slide_menu_container.length && ! $( 'body' ).hasClass( 'mh-app-nav-active' ) ) {
				$slide_menu_container.css( { left: '-' + $slide_menu_container.innerWidth() + 'px' } );

			}
			
			if (mh_is_fixed_nav && containerWidthChanged) {
				setTimeout(function () {
					var $top_header = $('#top-header'),
						secondary_nav_height = $('body').hasClass('mh_secondary_nav_above') && $top_header.length && $top_header.is(':visible') ? $top_header.innerHeight() : 0;

					$main_container_wrapper.css('paddingTop', $('#main-header').innerHeight() + secondary_nav_height - 1);

					mh_change_primary_nav_position();
				}, 200);
	}

			if ($('#wpadminbar').length && mh_is_fixed_nav && window_width >= 740 && window_width <= 782) {
				mh_calculate_header_values();

				mh_change_primary_nav_position();
			}

			$mhc_fullwidth_portfolio.each(function () {
				set_container_height = $(this).hasClass('mhc_fullwidth_portfolio_carousel') ? true : false;
				set_fullwidth_portfolio_columns($(this), set_container_height);
			});

			if (containerWidthChanged) {
				$('.container-width-change-notify').trigger('containerWidthChanged');

				setTimeout(function () {
					$mhc_filterable_portfolio.each(function () {
						set_filterable_grid_items($(this));
					});
					$mhc_gallery.each(function () {
						if ($(this).hasClass('mhc_gallery_grid')) {
							set_gallery_grid_items($(this));
						}
					});
				}, 100);

				mh_container_width = $mh_container.width();

				mhRecalculateOffset = true;

				if ($mhc_circle_counter.length) {
					$mhc_circle_counter.each(function () {
						var $this_counter = $(this);
				        if ( ! $this_counter.is( ':visible' ) ) {
							return;
						}

						$this_counter.data('easyPieChart').update( $this_counter.data('number-value') );
					});
				}
			}
            
            if ($('.mh-promo').length) {
                $('#top-header').css('min-height', $('.mh-promo').innerHeight());
                 if ($('#top-header').hasClass('mh-promo-closing')) {
                    $('#top-header').css('min-height', 0);
                }
            }
            
            mh_audio_module_set();
		}); //end $(window).resize

		$(window).ready(function () {
            if ($.fn.fitVids) {
				$('.mhc_slide_video').fitVids();
				$('#main-content').fitVids({
					customSelector: "iframe[src^='http://www.hulu.com'], iframe[src^='http://www.dailymotion.com'], iframe[src^='http://www.funnyordie.com'], iframe[src^='https://embed-ssl.ted.com'], iframe[src^='http://embed.revision3.com'], iframe[src^='https://flickr.com'], iframe[src^='http://blip.tv'], iframe[src^='http://www.collegehumor.com']"
				});
			}

			mh_fix_video_wmode('.fluid-width-video-wrapper');

			mh_fix_slider_height();
            
             $( 'section.mhc_fullscreen' ).each( function(){
				var $this_section = $( this );

				$.proxy( mh_calc_fullscreen_section, $this_section )();

				$mh_window.on( 'resize', $.proxy( mh_calc_fullscreen_section, $this_section ) );
			});

			//fullwidth search
			if ($('.mh-full-search-overlay').length){
				var $searchOverlay = $('.mh-full-search-overlay'),
					$searchInput = $searchOverlay.find('.search-input'),
					escKey = 27;

				function newSearch() {
					$searchOverlay.toggleClass('show');
					setTimeout(function () {
						$searchInput.val('');
					}, 350);
				}
                
                function clearSearch() {
					$searchOverlay.toggleClass('show');
					setTimeout(function () {
						$searchInput.val('');
					}, 350);
				}

				$('.mh-full-search-trigger').click(function (e) {
					e.preventDefault();
					$searchOverlay.toggleClass('show');
					$searchInput.focus();
				});

				$searchOverlay.click(function (e) {
					if (!$(e.target).hasClass('search-input')) {
						newSearch();
					}
				});

				$(document).keydown(function (e) {
					if (e.which === escKey) {
						if ($searchOverlay.hasClass('show')) {
							clearSearch();
						}
					}
				});
            }
			
        }); // end $(window).ready
		
		function mh_window_load_options() {
            
            mh_fix_fullscreen_section();
            mh_force_match_heights();
            
            // recalculate fullscreen section sizes on load
            $( 'section.mhc_fullscreen' ).each( function(){
                var $this_section = $( this );

                $.proxy( mh_calc_fullscreen_section, $this_section )();
            });


            $('.chosen-container').addClass('chosen-rtl'); //checkthis for RTL
            
			if ($('.mhc_blog_grid').length) {
				var $isrtl = true == is_rtl ? false : true;
				$('.mhc_blog_grid').masonry({
					itemSelector: '.mhc_post',
					isOriginLeft: $isrtl,
				});
			}
            
           if ($('.mh_magazine_grid').length) {
                    var $isrtl = true == is_rtl ? false : true;
                $('.mh_magazine_grid').each(function(){
                    var $grid = $(this);
                    $grid.imagesLoaded(function () {
                        $grid.show(); //after all the content is loaded we can show the gallery
                        $('.mh_magazine_grid_container').masonry({
                            columnWidth: '.mh_magazine_grid_sizer',
                            itemSelector: '.mh_magazine_grid_item',
                            percentPosition: true,
                            isOriginLeft: $isrtl,
                            transitionDuration: 0,
                        });
                    });
                });
           }
            
			setTimeout(function () {
				$('.mhc_preload').removeClass('mhc_preload');
			}, 500);

			if ($.fn.hashchange) {
				$(window).hashchange(function () {
					var hash = window.location.hash.substring(1);
					process_mh_hashchange(hash);
				});
				$(window).hashchange();
			}

			if ($('p.demo_store').length) {
				$('#footer-bottom').css('margin-bottom', $('p.demo_store').innerHeight());
			}

			if ($mhc_parallax.length && !mh_is_mobile_device) {
				$mhc_parallax.each(function () {
					if ($(this).hasClass('mhc_parallax_css')) {
						return;
					}

					var $this_parent = $(this).parent();

					$.proxy(mh_parallax_set_height, $this_parent)();

					$.proxy(mh_apply_parallax, $this_parent)();

					$mh_window.on('scroll', $.proxy(mh_apply_parallax, $this_parent));
					$mh_window.on('resize', $.proxy(mh_parallax_set_height, $this_parent));
					$mh_window.on('resize', $.proxy(mh_apply_parallax, $this_parent));

					$this_parent.find('.mh-learn-more .heading-more').click(function () {
						setTimeout(function () {
							$.proxy(mh_parallax_set_height, $this_parent)();
						}, 300);
					});
				});
			}

			if ($('.mhc_audio_module .mejs-audio').length || $('.mh_audio_content .mejs-audio').length) {
				$('.mhc_audio_module .mejs-audio, .mh_audio_content .mejs-audio').each(function () {
					$count_timer = $(this).find('div.mejs-currenttime-container').addClass('custom');
					$(this).find('.mejs-controls div.mejs-duration-container').replaceWith($count_timer);
				});
			}
            
            mh_audio_module_set();
            
			window.mh_reinint_waypoint_modules();
            
            if ( $( '.mh_audio_content' ).length ) {
				$( window ).trigger( 'resize' );
            }
        } // end mh_window_load_options

        if ( window.mh_load_init_event ) {
            mh_window_load_options();
        } else {
            $( window ).load( function() {
                mh_window_load_options();
            } );
        }

        
		// Fix if a browser doesn't allow map & parallax because of CSS 3D transform
		if ( $('.mhc_section_parallax').length && $('.mhc_map').length ) {
			$('body').addClass( 'parallax-map-fix' );
		}

		function mhc_smooth_scroll($target, $top_section, $speed) {
			var $window_width = $(window).width();

			if ($('body').hasClass('mh_fixed_nav') && $window_width > 980) {
				$menu_offset = $('#top-header').outerHeight() + $('#main-header').outerHeight() - 1;
			} else {
				$menu_offset = -1;
			}
			if ($('#wpadminbar').length && $window_width > 600) {
				$menu_offset += $('#wpadminbar').outerHeight();
			}

			//fix sidenav scroll to top
			if ($top_section) {
				$scroll_position = 0;
			} else {
				$scroll_position = $target.offset().top - $menu_offset;
			}

			$('html, body').animate({
				scrollTop: $scroll_position
			}, $speed);
		}

		$('a[href*="#"]:not([href="#"])').click(function () {
            
        var $this_link = $( this ),
				has_closest_smooth_scroll_disabled = $this_link.closest( '.mh_smooth_scroll_disabled' ).length,
				has_closest_woocommerce_tabs = ( $this_link.closest( '.woocommerce-tabs' ).length && $this_link.closest( '.tabs' ).length ),
				has_closest_eab_cal_link = $this_link.closest( '.eab-shortcode_calendar-navigation-link' ).length,
				has_acomment_reply = $this_link.hasClass( 'acomment-reply' ),
				disable_scroll = has_closest_smooth_scroll_disabled || has_closest_woocommerce_tabs || has_closest_eab_cal_link || has_acomment_reply;
            
        
        if ( ( location.pathname.replace( /^\//,'' ) == this.pathname.replace( /^\//,'' ) && location.hostname == this.hostname ) && ! ( $( this ).closest( '.woocommerce-tabs' ).length && $( this ).closest( '.tabs' ).length ) ) {
                
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				if (target.length) {
					mhc_smooth_scroll(target, false, 800);

					if (!$('#main-header').hasClass('mh-fixed-header') && $('body').hasClass('mh_fixed_nav') && $(window).width() > 980) {
						setTimeout(function () {
							mhc_smooth_scroll(target, false, 100);
						}, 500);
					}

					return false;
				}
			}
		});

		if ($('.mhc_section').length > 1 && $('.mhc_side_nav_page').length) {
			var $i = 0;

			$('#main-content').append('<ul class="mhc_side_nav"></ul>');

			$('.mhc_section').each(function () {
				if ($(this).height() > 0) {
					$active_class = $i == 0 ? 'active' : '';
					$('.mhc_side_nav').append('<li class="side_nav_item"><a href="#" id="side_nav_item_id_' + $i + '" class= "' + $active_class + '">' + $i + '</a></li>');
					$(this).addClass('mhc_scroll_' + $i);
					$i++;
				}
			});

			$side_nav_offset = ($i * 20 + 40) / 2;
			$('ul.mhc_side_nav').css('marginTop', '-' + parseInt($side_nav_offset) + 'px');
			$('.mhc_side_nav').addClass('mh-visible');

			$('.mhc_side_nav a').click(function () {
				$top_section = ($(this).text() == "0") ? true : false;
				$target = $('.mhc_scroll_' + $(this).text());

				mhc_smooth_scroll($target, $top_section, 800);

				if (!$('#main-header').hasClass('mh-fixed-header') && $('body').hasClass('mh_fixed_nav') && $(window).width() > 980) {
					setTimeout(function () {
						mhc_smooth_scroll($target, $top_section, 100);
					}, 500);
				}

				return false;
			});

			$(window).scroll(function () {
				$add_offset = ($('body').hasClass('mh_fixed_nav')) ? 20 : -90;

				if ($('#wpadminbar').length && $(window).width() > 600) {
					$add_offset += $('#wpadminbar').outerHeight();
				}

				$side_offset = ($('body').hasClass('mh_vertical_nav')) ? $('#top-header').height() + $add_offset + 60 : $('#top-header').height() + $('#main-header').height() + $add_offset;

				for (var $i = 0; $i <= $('.side_nav_item a').length - 1; $i++) {
					if ($(window).scrollTop() + $(window).height() == $(document).height()) {
						$last = $('.side_nav_item a').length - 1;
						$('.side_nav_item a').removeClass('active');
						$('a#side_nav_item_id_' + $last).addClass('active');
					} else {
						if ($(this).scrollTop() >= $('.mhc_scroll_' + $i).offset().top - $side_offset) {
							$('.side_nav_item a').removeClass('active');
							$('a#side_nav_item_id_' + $i).addClass('active');
						}

					}
				} //end for
			});
		}

		if ($('.mhc_scroll_top').length) {
			$(window).scroll(function () {
				if ($(this).scrollTop() > 800) {
					$('.mhc_scroll_top').show().removeClass('mh-hidden').addClass('mh-visible');
				} else {
					$('.mhc_scroll_top').removeClass('mh-visible').addClass('mh-hidden');
				}
			});

			//Click event to scroll top
			$('.mhc_scroll_top').click(function () {
				$('html, body').animate({
					scrollTop: 0
				}, 800);
			});
		}
        
        
        //promo bar
        if ($('.mh-promo').length) {
             var $top_header = $('#top-header');
            
            $top_header.css('min-height', $('.mh-promo').innerHeight());
            if (mh_is_fixed_nav && $('body').hasClass('mh_secondary_nav_above')) {
                $('#main-header').css('top', $('.mh-promo').innerHeight()); 
            }
            
            if ($('.mh-promo[data-once]').length && !Cookies.get( 'MHPromoBar' )) {
                
                $('.mh-promo').show();
                 
                $('.mh-promo-close').click(function () {
                    $top_header.addClass('mh-promo-closing');
                    if ($top_header.hasClass('mh-has-promo-only')) {
                        $('#main-header').css('top', 0);
                        if (mh_is_fixed_nav) {
                            $main_container_wrapper.css('paddingTop', $('#main-header').innerHeight());
                        }
                        $top_header.css('min-height', 0);
                        $top_header.css('height', 0);
                    }
                    
                    //@todo add option to setb the expiry duration.
                    $('#main-header').css('top', mh_primary_header_top); 
                    $top_header.css('min-height', 0);
                    $('.mh-promo').hide();
                });
                
             } else if ($('.mh-promo[data-once]').length && Cookies.get( 'MHPromoBar')){
                 //do not show the bar
                 
             } else {
        
                $( ".mh-promo" ).show();
                 
                $('.mh-promo-close').click(function () {
                    $top_header.addClass('mh-promo-closing');
                    if ($top_header.hasClass('mh-has-promo-only')) {
                        $('#main-header').css('top', 0);
                        if (mh_is_fixed_nav) {
                            $main_container_wrapper.css('paddingTop', $('#main-header').innerHeight());
                        }
                        $top_header.css('min-height', 0);
                        $top_header.css('height', 0);
                    }
                    $('#main-header').css('top', mh_primary_header_top); 
                    $top_header.css('min-height', 0);
                    $('.mh-promo').hide();
                });
                 
             }
        }
        

		//quick-form
        if ($('.mh_quick_form').length) {
            var $mhquickform = $('.mh_quick_form'),
                escKey = 27;

            $('.mh_quick_form_button').click(function () {
                $mhquickform.toggleClass('show');
            });
            
            $('.mh_quick_form').on( 'click', '.mh_quick_form_close', function() {
                if ( $mhquickform.hasClass( 'show' ) ) {
                   $mhquickform.toggleClass('show');
                }
            });

            $(document).keydown(function (e) {
                if (e.which === escKey) {
                    if ($mhquickform.hasClass('show')) {
                        $mhquickform.toggleClass('show');
                    }
                }
            });
        } //if .mh_quick_form').length
	});

		//niceScroll
    if( !$('body').hasClass('mhc-preview') && $('body').hasClass('mh_nicescroll') && $(window).width() > 767 && !mh_is_mobile_device) {
        $('html').niceScroll({
            scrollspeed: 60,
            mousescrollstep: 40,
            cursorwidth: 12,
            cursorborder: 0,
            cursorcolor: '#cccccc',
            cursorborderradius: $('body').hasClass('mh_rounded_corners') ||  $('body').hasClass('mh_capsule_corners') ? 10 : 0,
            autohidemode: false,
            horizrailenabled: false,
            cursorminheight: 60,
            zindex: 100000,
            background: 'rgba(220, 220, 220, 0.30)',
        });

        $('body').removeClass('mh_nicescroll').addClass('nice-scroll');
    }
    
    window.mh_duplicate_menu = function( menu, append_to, menu_id, menu_class ){
        append_to.each(function () {
            var $this_menu = $(this),
                $cloned_nav;

            menu.clone().attr('id', menu_id).removeClass().attr('class', menu_class).appendTo($this_menu);
            $cloned_nav = $this_menu.find('> ul');
            $cloned_nav.find('.menu_slide').remove();
            $cloned_nav.find('li:first').addClass('mh_first_mobile_item');

            $cloned_nav.find('a').on( 'click', function(){
				$( '#mh_mobile_nav_menu .mobile_menu_bar' ).trigger( 'click' );
			});

            $this_menu.on('click', function () {
                if ($(this).hasClass('closed')) {
                    $(this).removeClass('closed').addClass('opened');
                    $cloned_nav.slideDown(500);
                } else {
                    $(this).removeClass('opened').addClass('closed');
                    $cloned_nav.slideUp(500);
                }
                return false;
            });

            $this_menu.on('click', 'a', function (event) {
                event.stopPropagation();
            });
        });
    }
    
    function mh_toggle_slide_menu( force_state ) {
        var $slide_menu_container = $( '.mh_app_nav_left .mh-app-nav' ),
            is_menu_opened = $slide_menu_container.hasClass( 'mh-app-nav-opened' ),
            set_to = typeof force_state !== 'undefined' ? force_state : 'auto',
            slide_container_width = $slide_menu_container.innerWidth();

        if ( 'auto' !== set_to && ( ( is_menu_opened && 'open' === set_to ) || ( ! is_menu_opened && 'close' === set_to ) ) ) {
            return;
        }

        if ( is_menu_opened ) {
            $slide_menu_container.css( { left: '-' + slide_container_width + 'px' } );

            // hide the menu after animation completed
            setTimeout( function() {
                $slide_menu_container.css( { 'display' : 'none' } );
            }, 700 );
        } else {
            $slide_menu_container.css( { 'display' : 'block' } );
            // add some delay to make sure css animation applied correctly
            setTimeout( function() {
                $slide_menu_container.css( { left: '0' } );
            }, 50 );
        }
        $slide_menu_container.toggleClass( 'mh-app-nav-opened' );
        $( 'body' ).toggleClass( 'mh-app-nav-active' );
    }
    if ( $( 'body' ).hasClass( 'mh_app_nav_left' ) ) {
        $( '#main-header' ).on( 'click', '.app-nav-trigger', function() {
            mh_toggle_slide_menu();
        });
        $( '.mh-app-nav' ).on( 'click', '.app-nav-close', function() {
            if ( $( 'body' ).hasClass( 'mh-app-nav-active' ) ) {
            mh_toggle_slide_menu('close');
            }
        });
        
         if ( mh_is_touch_screen ) {
            // open slide menu on swipe right
            $mh_window.on( 'swiperight', function( event ) {
                var window_width = parseInt( $mh_window.width() ),
                    swipe_start = parseInt( event.swipestart.coords[0] ); // horizontal coordinates of the swipe start

                // if swipe started from the right edge of screen then open slide menu
                if ( 30 >= swipe_start ) {
                    mh_toggle_slide_menu( 'open' );

                }
            });

            // close slide menu on swipe left
            $mh_window.on( 'swipeleft', function( event ){
                if ( $( 'body' ).hasClass( 'mh-app-nav-active' ) ) {
                    mh_toggle_slide_menu( 'close' );
                }
            });
        }
    }
    if ( $( 'body' ).hasClass( 'mh_app_nav_overlay' ) ) {
        $( '#page-container' ).on( 'click', '.app-nav-trigger, .app-nav-close', function() {
            var $menu_container = $( '.mh_app_nav_overlay .mh-app-nav' );
              //top_bar_height = $menu_container.find( '.mh_slide_menu_top' ).innerHeight();

            $menu_container.toggleClass( 'mh-app-nav-opened' );
            $( 'body' ).toggleClass( 'mh-app-nav-active' );

            if ( $menu_container.hasClass( 'mh-app-nav-opened' ) ) {
                $menu_container.addClass( 'mh-app-nav-animated' );

                // adjust the padding in fullscreen menu
                //$menu_container.css( { 'padding-top': top_bar_height + 20 } );
            } else {
                setTimeout( function() {
                    $menu_container.removeClass( 'mh-app-nav-animated' );
                }, 1000 );
            }
        });
    }
    
    window.mh_fix_fullscreen_section = function() {
		var $mh_window = $(window);

		$( 'section.mhc_fullscreen' ).each( function(){
			var $this_section = $( this );

			$.proxy( mh_calc_fullscreen_section, $this_section )();

			$mh_window.on( 'resize', $.proxy( mh_calc_fullscreen_section, $this_section ) );
		});
	}
    
     window.mh_force_match_heights = function() {
        var $mh_window = $(window);
        $('.mhc_force_fullwidth').each(function(){
            //vertically center
            if($(this).hasClass('column-match-heights') && window.innerWidth > 981){
              var $column_class = $(this).hasClass('mh_section_specialty') ? '.mhc_row_inner' : '.mhc_row';
                $(this).find($column_class).each(function(){
                    var columnHeight = 0;
                    
                    $(this).find('.mhc_column > div, .mhc_column > img').each(function(){
                       var $padding = parseInt($(this).css('padding-top'));
                        
					   ($(this).height() + ($padding*2) > columnHeight) ? columnHeight = $(this).height() + ($padding*2)  : columnHeight = columnHeight;
				    });
                    
                    $(this).find('.mhc_column > div').each(function(){
                        if(! $(this).hasClass('mhc_gallery')){
		    	 	       if($(this).length > 0){
		    	 		      $(this).css('height',columnHeight);
		    	 	       } else {
		    	 		      $(this).css('min-height',columnHeight);
		    	 	       }
                        }
                    });
                });
            } 
        });
    } // end forceFullwidthMatchHeights
    
    $(window).load(function() {
        $('#mh-main-area').animate({
            opacity: 1
        }, 500);
        if($('body').hasClass('chrome')){
            //(bug) fix for chrome white page until resized
            $("html,body").animate({scrollTop: 1}, 0);
        }
    });
    
})(jQuery);