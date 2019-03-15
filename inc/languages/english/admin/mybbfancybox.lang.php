<?php

/**
 * MyBB FancyBox - plugin for MyBB 1.8.x forum software
 * 
 * @package MyBB Plugin
 * @author MyBB Group - Eldenroot & Wildcard - <eldenroot@gmail.com>
 * @copyright 2018 MyBB Group <http://mybb.group>
 * @link <https://github.com/mybbgroup/MyBB_Fancybox>
 * @license GPL-3.0
 * 
 */

// Plugin page (name + plugin description)
$l['mybbfancybox'] = 'MyBB Fancybox';
$l['mybbfancybox_description'] = 'FancyBox JavaScript library for presenting images in a fancy way. Fully responsive, touch-enabled and customizable.';

// Settings
$l['mybbfancybox_settings_group_title'] = 'MyBB Fancybox Settings';
$l['mybbfancybox_settings_group_description'] = 'Settings for MyBB FancyBox plugin';

$l['mybbfancybox_open_image_urls_title'] = 'Detect image URL links?';
$l['mybbfancybox_open_image_urls_description'] = 'YES (default) to automatically detect links to images in posts and enable them to be viewed in the MyBB Fancybox modal, NO to disable';

$l['mybbfancybox_allowed_extensions_title'] = 'Allowed image extensions';
$l['mybbfancybox_allowed_extensions_description'] = 'Leave blank (default) to use the default image extensions (.jpg, .gif, .png, .jpeg, .bmp, .apng) or enter a comma separated list of extensions to allow.<br />(This setting has no affect if the above setting is set to NO)';

$l['mybbfancybox_protect_images_title'] = 'Protect images?';
$l['mybbfancybox_protect_images_description'] = 'YES to disable right-click and use simple image protection, NO (default) to enable right-click';

$l['mybbfancybox_watermark_title'] = 'Display watermark in images?';
$l['mybbfancybox_watermark_description'] = 'YES to enable displaying a watermark in images (CSS class .watermark in mybbfancybox.css stylesheet is used), NO (default) to disable';

$l['mybbfancybox_watermark_exclude_low_resolution_images_title'] = 'Do not display watermark in small resolution images?';
$l['mybbfancybox_watermark_exclude_low_resolution_images_description'] = 'YES (default) to not add watermark into small resolution images, NO to disable';

$l['mybbfancybox_loop_title'] = 'Enable infinite gallery navigation?';
$l['mybbfancybox_loop_description'] = 'YES (default) to enable infinite navigation between images in gallery, NO to disable';

$l['mybbfancybox_infobar_title'] = 'Display image counter?';
$l['mybbfancybox_infobar_description'] = 'YES (default) to display image counter in the top left corner, NO to hide';

$l['mybbfancybox_arrows_title'] = 'Display arrows for navigation?';
$l['mybbfancybox_arrows_description'] = 'YES (default) to display arrows at the screen edges for simple navigation between images, NO to hide';

$l['mybbfancybox_thumbs_title'] = 'Display thumbnails sidebox?';
$l['mybbfancybox_thumbs_description'] = 'YES to automatically display thumbnails sidebox, NO (default) to hide';

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
