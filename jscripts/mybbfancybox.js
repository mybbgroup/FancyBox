var MyBBFancybox = (function($, m) {
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
			'minimize', // this is needed for the new feature - display only when setting in ACP is enabled
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
	 * initialize Fancybox
	 *
	 * @return void
	 */
	function init() {
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
})(jQuery, MyBBFancybox || {});
