$(document).ready(function() {

	$('.post_body img').each(function() {
		var currentImage = $(this);
		if (currentImage.hasClass('smilie') == false && currentImage.parent().is('a') == false) {
			currentImage.wrap("<a title='Click to enlarge' target='_blank' data-fancybox data-type='image' href='" + currentImage.attr("src") + "'>");
		}
  });
  
	// Language ENG 
	$.fancybox.defaults.lang = 'en';
	$.fancybox.defaults.i18n.en = {
		CLOSE : 'Close',
		NEXT : 'Next',
		PREV : 'Previous',
		ERROR : 'The requested content cannot be loaded. <br/> Please try again later.',
		PLAY_START : 'Start slideshow',
		PLAY_STOP : 'Pause slideshow',
		FULL_SCREEN : 'Full screen',
		THUMBS : 'Thumbnails',
		DOWNLOAD : 'Download',
		SHARE : 'Share',
		ZOOM : 'Zoom'
};
	// FancyBox default settings
	$('[data-fancybox]').fancybox({
		slideClass : '', // CSS class
		loop : true, // Enable infinite gallery navigation
		protect: true, // Disable right-click and use simple image protection for images
		keyboard: true, // Enable keyboard navigation
		arrows: true, // Display navigation arrows at the screen edges
		infobar: true, // Should display counter at the top left corner
		thumbs : { // Thumbnails sidebox option
	    autoStart   : false, // Show/hide sidebar with thumbnails of images
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
});