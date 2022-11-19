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
$l['setting_group_mybbfancybox'] = 'MyBB FancyBox Settings';
$l['setting_group_mybbfancybox_desc'] = 'Settings for MyBB FancyBox';

$l['setting_mybbfancybox_open_image_urls'] = 'Detect image URL links?';
$l['setting_mybbfancybox_open_image_urls_desc'] = 'YES (default) to automatically detect links to images in posts and enable them to be viewed in the MyBB FancyBox modal, NO to disable';

$l['setting_mybbfancybox_allowed_extensions'] = 'Allowed image extensions';
$l['setting_mybbfancybox_allowed_extensions_desc'] = 'Leave blank (default) to use the default image extensions (.jpg, .gif, .png, .jpeg, .bmp, .apng) or enter a comma separated list of extensions to allow.<br />(This setting has no affect if the above setting is set to NO)';

$l['setting_mybbfancybox_include_images_from_urls_into_gallery'] = 'Include images from URLs in the gallery?';
$l['setting_mybbfancybox_include_images_from_urls_into_gallery_desc'] = 'YES (default) to include detected images from URLs in posts in the gallery, NO to disable';

$l['setting_mybbfancybox_protect_images'] = 'Protect images?';
$l['setting_mybbfancybox_protect_images_desc'] = 'YES to disable right-click and use simple image protection, NO (default) to enable right-click';

$l['setting_mybbfancybox_watermark'] = 'Display watermark in images?';
$l['setting_mybbfancybox_watermark_desc'] = 'YES to enable watermark overlay for images, NO (default) to disable';

$l['setting_mybbfancybox_watermark_image'] = 'Path to watermark image';
$l['setting_mybbfancybox_watermark_image_desc'] = 'Define the path to your watermark image, default: images/mybbfancybox/watermark.png';

$l['setting_mybbfancybox_watermark_low_resolution_images'] = 'Display watermark for low resolution images?';
$l['setting_mybbfancybox_watermark_low_resolution_images_desc'] = 'YES to enable watermark overlay for small resolution images, NO (default) to disable<br />(This setting has no affect if the above setting is set to NO)';

$l['setting_mybbfancybox_watermark_resolutions'] = 'Low resolution image dimensions';
$l['setting_mybbfancybox_watermark_resolutions_desc'] = 'Enter the maximum dimensions in pixels that an image will be considered as low resolution<br />width|height eg. 300|300 (default)<br />(This setting has no affect if the above setting is set to NO)';

$l['setting_mybbfancybox_per_post_gallery'] = 'Per-post gallery?';
$l['setting_mybbfancybox_per_post_gallery_desc'] = 'YES (default) for each post to have its own gallery, NO for a global gallery for all posts on the page';

$l['setting_mybbfancybox_loop'] = 'Enable infinite gallery navigation?';
$l['setting_mybbfancybox_loop_desc'] = 'YES (default) to enable infinite navigation between images in the gallery, NO to disable';

$l['setting_mybbfancybox_infobar'] = 'Display image counter?';
$l['setting_mybbfancybox_infobar_desc'] = 'YES (default) to display image counter in the top left corner, NO to hide';

$l['setting_mybbfancybox_arrows'] = 'Display arrows for navigation?';
$l['setting_mybbfancybox_arrows_desc'] = 'YES (default) to display arrows at the edges of the screen for simple navigation between images, NO to hide';

$l['setting_mybbfancybox_rotate'] = 'Enable image rotation?';
$l['setting_mybbfancybox_rotate_desc'] = 'YES (default) to enable the rotation option, NO to disable';

$l['setting_mybbfancybox_thumbs'] = 'Display thumbnails sidebox?';
$l['setting_mybbfancybox_thumbs_desc'] = 'YES to automatically display thumbnails sidebox, NO (default) to hide';

$l['setting_mybbfancybox_minimize'] = 'Enable minimize gallery?';
$l['setting_mybbfancybox_minimize_desc'] = 'YES (default) to enable minimizing MyBB FancyBox galery, NO to disable';

// Buttons
$l['setting_mybbfancybox_buttons'] = 'Button Selection';
$l['setting_mybbfancybox_buttons_desc'] = 'Only selected buttons will display in the MyBB Fancybox modal';

$l['setting_mybbfancybox_buttons_slideshow'] = 'Slideshow';
$l['setting_mybbfancybox_buttons_fullscreen'] = 'Full Screen';
$l['setting_mybbfancybox_buttons_thumbs'] = 'Thumbnails';
$l['setting_mybbfancybox_buttons_share'] = 'Share';
$l['setting_mybbfancybox_buttons_download'] = 'Download';
$l['setting_mybbfancybox_buttons_zoom'] = 'Zoom';
$l['setting_mybbfancybox_buttons_close'] = 'Close';
