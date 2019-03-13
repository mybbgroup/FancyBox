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
		$('[data-fancybox]').fancybox({
			slideClass : '', // Watermark CSS class (leave empty or use "watermark" CSS class)
			loop : true, // Enable infinite gallery navigation
			protect: false, // Disable right-click and use simple image protection for images
			keyboard: true, // Enable keyboard navigation
			arrows: true, // Display navigation arrows at the screen edges
			infobar: true, // Display counter in the top left corner
			thumbs : { // Thumbnails sidebox option
			autoStart   : false, // Show or hide sidebar with thumbnails of images
			hideOnClose : true, // Automatically hide thumbnails box on close
			},
			
			buttons : [ //Buttons displayed in FancyBox - to hide any of them just comment them out
				'slideShow', // Slideshow button
				'fullScreen', // Full screen button
				'thumbs', // Thumbnails button
				'share', // Share button
				'download', // Download button
				'zoom', // Zoom button
				'close' // Close button
			]
		});
	}

	/**
	 * setup localization
	 *
	 * @return void
	 */
	function setup(l) {
		$.extend(lang, l || {});
	}

	m.setup = setup;

	$(init);
	return m;
})(jQuery, MyBBFancybox || {});
