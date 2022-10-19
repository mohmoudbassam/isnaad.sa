(function ($) {
	"use strict";

	$(document).ready(function () {

		mh_megamenu.menu_item_mouseup();
		mh_megamenu.megamenu_status_update();
		mh_megamenu.update_megamenu_fields();

		$('.remove-mh-megamenu-background').manage_thumbnail_display();
		$('.mh-megamenu-background-image').css('display', 'block');
		$(".mh-megamenu-background-image[src='']").css('display', 'none');

		mh_media_frame_setup();

	});

	var mh_megamenu = {

		menu_item_mouseup: function () {
			$(document).on('mouseup', '.menu-item-bar', function (event, ui) {
				if (!$(event.target).is('a')) {
					setTimeout(mh_megamenu.update_megamenu_fields, 300);
				}
			});
		},

		megamenu_status_update: function () {

			$(document).on('click', '.edit-menu-item-mh-megamenu-check', function () {
				var parent_li_item = $(this).parents('.menu-item:eq( 0 )');

				if ($(this).is(':checked')) {
					parent_li_item.addClass('mh-megamenu');
				} else {
					parent_li_item.removeClass('mh-megamenu');
				}
				mh_megamenu.update_megamenu_fields();
			});
		},

		update_megamenu_fields: function () {
			var menu_li_items = $('.menu-item');

			menu_li_items.each(function (i) {

				var megamenu_status = $('.edit-menu-item-mh-megamenu-check', this);

				if (!$(this).is('.menu-item-depth-0')) {
					var check_against = menu_li_items.filter(':eq(' + (i - 1) + ')');


					if (check_against.is('.mh-megamenu')) {

						megamenu_status.attr('checked', 'checked');
						$(this).addClass('mh-megamenu');
					} else {
						megamenu_status.attr('checked', '');
						$(this).removeClass('mh-megamenu');
					}
				} else {
					if (megamenu_status.attr('checked')) {
						$(this).addClass('mh-megamenu');
					}
				}
			});
		}

	}

	$.fn.manage_thumbnail_display = function (variables) {
		var button_id;

		return this.click(function (e) {
			e.preventDefault();

			button_id = this.id.replace('mh-media-remove-', '');
			$('#edit-menu-item-megamenu-background-' + button_id).val('');
			$('#mh-media-img-' + button_id).attr('src', '').css('display', 'none');
		});
	}

	function mh_media_frame_setup() {
		var MHMediaFrame;
		var item_id;

		$(document.body).on('click.mhOpenMediaManager', '.mh-open-media', function (e) {

			e.preventDefault();

			item_id = this.id.replace('mh-media-upload-', '');

			if (MHMediaFrame) {
				MHMediaFrame.open();
				return;
			}

			MHMediaFrame = wp.media.frames.MHMediaFrame = wp.media({

				className: 'media-frame mh-media-frame',
				frame: 'select',
				multiple: false,
				library: {
					type: 'image'
				}
			});

			MHMediaFrame.on('select', function () {

				var media_attachment = MHMediaFrame.state().get('selection').first().toJSON();

				$('#edit-menu-item-megamenu-background-' + item_id).val(media_attachment.url);
				$('#mh-media-img-' + item_id).attr('src', media_attachment.url).css('display', 'block');

			});

			MHMediaFrame.open();
		});

	}

})(jQuery);