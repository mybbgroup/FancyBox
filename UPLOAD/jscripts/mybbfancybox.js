/**
 * MyBB FancyBox integration
 *
 * @param  Object jQuery
 * @param  Object MyBBFancyBox
 * @return Object MyBBFancyBox
 */
var MyBBFancyBox = (function ($, m) {
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
			perpostgallery: true,
			slideClass: '',
			closeExisting: true,
			loop: true,
			protect: false,
			keyboard: true,
			arrows: true,
			rotate: true,
			infobar: true,
			thumbs: {
				autoStart: false,
				hideOnClose: true,
			},
			buttons: [
				'slideShow',
				'fullScreen',
				'thumbs',
				'share',
				'download',
				'zoom',
				'minimize',
				'close',
			],
		};

	/**
	 * initialize FancyBox
	 *
	 * @return void
	 */
	function init() {

		if (options.buttons && options.buttons.indexOf("minimize") !== -1) {
			// Add click event for minimize button
			$(document).on('click', '[data-fancybox-minimize]', function () {
				var fb = $.fancybox.getInstance();

				if (fb) {
					fb.$refs.container.toggleClass('minimized');
				}
			});
		}

		$('.post_body img').each(function () {
			var currentImage = $(this);
			if (currentImage.hasClass('smilie') == false && currentImage.parent().is('a') == false) {
				var pid = currentImage.parents('.post_body.scaleimages').attr('id').split('_')[1];
				var gallerystr = options.perpostgallery ? ('data-' + pid) : 'gallery';
				currentImage.wrap("<a title='" + lang.clickToEnlarge + "' target='_blank' data-fancybox='" + gallerystr + "' data-type='image' href='" + currentImage.attr("src") + "'>");
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

var RotateImage = function (instance) {
	this.instance = instance;

	this.init();
};

$.extend(RotateImage.prototype, {
	$button_left: null,
	$button_right: null,
	transitionanimation: true,

	init: function () {
		var self = this;

		self.$button_right = $('<button data-rotate-right class="fancybox-button fancybox-button--rotate" title="Rotate to right">' +
				'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
				'  <path d="M11.074,9.967a4.43,4.43,0,1,1-4.43-4.43V8.859l5.537-4.43L6.644,0V3.322a6.644,6.644,0,1,0,6.644,6.644Z" transform="translate(10.305 1) rotate(30)"/>' +
				'</svg>' +
				'</button>')
			.prependTo(this.instance.$refs.toolbar)
			.on('click', function (e) {
				self.rotate('right');
			});

		self.$button_left = $('<button data-rotate-left class="fancybox-button fancybox-button--rotate" title="Rotate to left">' +
				'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
				'  <path d="M11.074,6.644a4.43,4.43,0,1,0-4.43,4.43V7.752l5.537,4.43-5.537,4.43V13.289a6.644,6.644,0,1,1,6.644-6.644Z" transform="translate(21.814 15.386) rotate(150)"/>' +
				'</svg>' +
				'</button>')
			.prependTo(this.instance.$refs.toolbar)
			.on('click', function (e) {
				self.rotate('left');
			});
	},

	rotate: function (direction) {
		var self = this;
		var image = self.instance.current.$image[0];
		var angle = parseInt(self.instance.current.$image.attr('data-angle')) || 0;

		if (direction == 'right') {
			angle += 90;
		} else {
			angle -= 90;
		}

		if (!self.transitionanimation) {
			angle = angle % 360;
		} else {
			$(image).css('transition', 'transform .3s ease-in-out');
		}

		self.instance.current.$image.attr('data-angle', angle);

		$(image).css('webkitTransform', 'rotate(' + angle + 'deg)');
		$(image).css('mozTransform', 'rotate(' + angle + 'deg)');
	}
});

$(document).on('onInit.fb', function (e, instance) {
	if (!!instance.opts.rotate) {
		instance.Rotate = new RotateImage(instance);
	}
});
