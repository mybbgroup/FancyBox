<?php

/**
 * MyBB FancyBox - plugin for MyBB 1.8.x forum software
 *
 * @package MyBB Plugin
 * @author MyBB Group - Eldenroot & Wildcard - <eldenroot@gmail.com>
 * @copyright 2019 MyBB Group <http://mybb.group>
 * @link <https://github.com/mybbgroup/MyBB_Fancybox>
 * @license GPL-3.0
 *
 */

// Plugin page (name + plugin description)
$l['mybbfancybox'] = 'MyBB FancyBox';
$l['mybbfancybox_description'] = 'MyBB integration of FancyBox JavaScript library for presenting images in a fancy way. Fully responsive, touch-enabled, and customizable.';

// Settings
$l['mybbfancybox_settings_group_title'] = 'MyBB FancyBox Settings';
$l['mybbfancybox_settings_group_description'] = 'Settings for MyBB FancyBox';

$l['mybbfancybox_open_image_urls_title'] = 'Detect image URL links?';
$l['mybbfancybox_open_image_urls_description'] = 'YES (default) to automatically detect links to images in posts and enable them to be viewed in the MyBB FancyBox modal, NO to disable';

$l['mybbfancybox_allowed_extensions_title'] = 'Allowed image extensions';
$l['mybbfancybox_allowed_extensions_description'] = 'Leave blank (default) to use the default image extensions (.jpg, .gif, .png, .jpeg, .bmp, .apng) or enter a comma separated list of extensions to allow.<br />(This setting has no affect if the above setting is set to NO)';

$l['mybbfancybox_include_images_from_urls_into_gallery_title'] = 'Include images from URLs in the gallery?';
$l['mybbfancybox_include_images_from_urls_into_gallery_description'] = 'YES (default) to include detected images from URLs in posts in the gallery, NO to disable';

$l['mybbfancybox_protect_images_title'] = 'Protect images?';
$l['mybbfancybox_protect_images_description'] = 'YES to disable right-click and use simple image protection, NO (default) to enable right-click';

$l['mybbfancybox_watermark_title'] = 'Display watermark in images?';
$l['mybbfancybox_watermark_description'] = 'YES to enable watermark overlay for images, NO (default) to disable';

$l['mybbfancybox_watermark_image_title'] = 'Path to watermark image';
$l['mybbfancybox_watermark_image_description'] = 'Define the path to your watermark image, default: images/mybbfancybox/watermark.png';

$l['mybbfancybox_watermark_low_resolution_images_title'] = 'Display watermark for low resolution images?';
$l['mybbfancybox_watermark_low_resolution_images_description'] = 'YES to enable watermark overlay for small resolution images, NO (default) to disable<br />(This setting has no affect if the above setting is set to NO)';

$l['mybbfancybox_watermark_resolutions_title'] = 'Low resolution image dimensions';
$l['mybbfancybox_watermark_resolutions_description'] = 'Enter the maximum dimensions in pixels that an image will be considered as low resolution<br />width|height eg. 300|300 (default)<br />(This setting has no affect if the above setting is set to NO)';

$l['mybbfancybox_per_post_gallery_title'] = 'Per-post gallery?';
$l['mybbfancybox_per_post_gallery_description'] = 'YES (default) for each post to have its own gallery, NO for a global gallery for all posts on the page';

$l['mybbfancybox_loop_title'] = 'Enable infinite gallery navigation?';
$l['mybbfancybox_loop_description'] = 'YES (default) to enable infinite navigation between images in the gallery, NO to disable';

$l['mybbfancybox_infobar_title'] = 'Display image counter?';
$l['mybbfancybox_infobar_description'] = 'YES (default) to display image counter in the top left corner, NO to hide';

$l['mybbfancybox_arrows_title'] = 'Display arrows for navigation?';
$l['mybbfancybox_arrows_description'] = 'YES (default) to display arrows at the edges of the screen for simple navigation between images, NO to hide';

$l['mybbfancybox_thumbs_title'] = 'Display thumbnails sidebox?';
$l['mybbfancybox_thumbs_description'] = 'YES to automatically display thumbnails sidebox, NO (default) to hide';

$l['mybbfancybox_minimize_title'] = 'Enable minimize gallery?';
$l['mybbfancybox_minimize_description'] = 'YES (default) to enable minimizing MyBB FancyBox galery, NO to disable';

// Buttons
$l['mybbfancybox_buttons_title'] = 'Button Selection';
$l['mybbfancybox_buttons_description'] = 'Only selected buttons will display in the MyBB Fancybox modal';

$l['mybbfancybox_button_slideshow_title'] = 'Slideshow';
$l['mybbfancybox_button_fullscreen_title'] = 'Full Screen';
$l['mybbfancybox_button_thumbs_title'] = 'Thumbnails';
$l['mybbfancybox_button_share_title'] = 'Share';
$l['mybbfancybox_button_download_title'] = 'Download';
$l['mybbfancybox_button_zoom_title'] = 'Zoom';
$l['mybbfancybox_button_close_title'] = 'Close';
