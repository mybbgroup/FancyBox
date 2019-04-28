/**
 * MyBB FancyBox integration
 *
 * @param  Object jQuery
 * @param  Object MyBBFancyBox
 * @return Object MyBBFancyBox
 */
var MyBBFancyBox = (function($, m) {
	"use strict";

	var lang = {
		clickToEnlarge: "Click to enlarge",
		CLOSE: 'Close',
		NEXT: 'Next',
		PREV: 'Previous',
		ERROR: 'The requested content cannot be loaded.<br/>Please try again later.',
		PLAY_START: 'Start slideshow',
		PLAY_STOP: 'Pause slideshow',
		FULL_SCREEN: 'Full screen',
		THUMBS: 'Thumbnails',
		DOWNLOAD: 'Download',
		SHARE: 'Share',
		ZOOM: 'Zoom',
		MINIMIZE: 'Minimize',
	},
	options = {
		slideClass: '',
		loop: true,
		protect: false,
		keyboard: true,
		arrows: true,
		infobar: true,
		thumbs: {
			autoStart: false,
			hideOnClose: true,
		},
		buttons: [
			'minimize',
			'slideShow',
			'fullScreen',
			'thumbs',
			'share',
			'download',
			'zoom',
			'close',
		],
	};

	/**
	 * initialize FancyBox
	 *
	 * @return void
	 */
	function init() {
		if (options.buttons.indexOf("minimize") !== -1) {
			// Create templates for minimize and maximize buttons
			$.fancybox.defaults.btnTpl.minimize = '<button data-fancybox-minimize class="fancybox-button fancybox-button--minimise" title="{{MINIMIZE}}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 445 445"><g fill="#010002"><path d="M440.3 4.7a15.9 15.9 0 0 0-22.5 0L286 136.5V47.7a16 16 0 0 0-31.7 0V175l1.2 6 3.3 5 .1.2h.2l5 3.4 6 1.2h127.2a16 16 0 0 0 0-31.8h-88.8L440.3 27.2a16 16 0 0 0 0-22.5zM180.9 255.5l-6-1.2H47.6a16 16 0 0 0 0 31.8h88.7L4.7 417.8A15.9 15.9 0 1 0 27 440.3L159 308.5v88.8a16 16 0 0 0 31.8 0V270.2l-1.2-6a16 16 0 0 0-8.6-8.7z"/></g></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 381.4 381.4"><path d="M380.1 9.8c-1.6-3.9-4.7-7-8.5-8.6L365.5 0h-159a16 16 0 0 0 0 31.8h120.6L31.8 327V206.6a15.9 15.9 0 0 0-31.8 0v159l1.2 6 3.3 5 .1.1.2.1 5 3.4 6 1.2h159a16 16 0 0 0 0-31.8H54.3L349.6 54.3v120.5a16 16 0 0 0 31.8 0v-159l-1.3-6z" fill="#010002"/></svg></button>';

			// Add click event for minimize button
			$(document).on('click', '[data-fancybox-minimize]', function() {
				var fb = $.fancybox.getInstance();

				if (fb) {
					fb.$refs.container.toggleClass('minimized');
				}
			});
		}

		$('.post_body img').each(function() {
			var currentImage = $(this);
			var pid = currentImage.parents('.post_body.scaleimages').attr('id');
			if (currentImage.hasClass('smilie') == false && currentImage.parent().is('a') == false) {
				currentImage.wrap("<a title='" + lang.clickToEnlarge + "' target='_blank' data-fancybox='" + pid + "' data-type='image' href='" + currentImage.attr("src")  + "'>");
			}
		});

		// Load default language ENG (English)
		$.fancybox.defaults.lang = 'en';
		$.fancybox.defaults.i18n.en = lang;

		// FancyBox default settings
		$('[data-fancybox]').fancybox(options);
	}

	/**
	 * setup localization
	 *
	 * @return void
	 */
	function setup(l, o) {
		$.extend(lang, l || {});
		$.extend(options, o || {});
	}

	m.setup = setup;

	$(init);
	return m;
})(jQuery, MyBBFancyBox || {});
