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
 
 /**
  * 3rd party JavaScript library is used - FancyBox - http://fancyapps.com/fancybox/3/ created by Jānis Skarnelis
  * FancyBox is licenced under GPLv3 licence and is free for all non-commercial applications, for commercial applications the paid licence is required!
  * Visit official website https://fancyapps.com/fancybox/3/ or GitHub project site https://github.com/fancyapps/fancybox for more information
 */
 
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.
 * If not, see <http://www.gnu.org/licenses/>.
 */

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.");
}

// Plugin information
function mybbfancybox_info()
{
	global $lang;

	if (!$lang->mybbfancybox) {
		$lang->load('mybbfancybox');
	}

	return array(
		"name"			=> $lang->mybbfancybox,
		"description"	=> $lang->mybbfancybox_description,
		"website"		=> "https://github.com/mybbgroup/MyBB_Fancybox",
		"author"		=> "MyBB Group (Eldenroot & Wildcard)",
		"authorsite"	=> "https://github.com/mybbgroup/MyBB_Fancybox",
		"version"		=> "0.9.0dev",
		"codename"		=> "mybbfancybox",
		"compatibility" => "18*"
	);
}

function mybbfancybox_is_installed()
{
	global $db;

	$query = $db->simple_select('themestylesheets', 'sid', "name='mybbfancybox.css'");
	return ($db->num_rows($query) > 0);
}

// Plugin installation
function mybbfancybox_install()
{
	global $db, $config, $lang;

	if (!$lang->mybbfancybox) {
		$lang->load('mybbfancybox');
	}

	// Add stylesheet to the master template so it becomes inherited
	$stylesheet = @file_get_contents(MYBB_ROOT.'inc/plugins/mybbfancybox/mybbfancybox.css');
	$attachedto = '';

	$name = 'mybbfancybox.css';
	$thisStyleSheet = array(
		'name' => $name,
		'tid' => 1,
		'attachedto' => $db->escape_string($attachedto),
		'stylesheet' => $db->escape_string($stylesheet),
		'cachefile' => $name,
		'lastmodified' => TIME_NOW,
	);

	// Update any children theme
	$db->update_query('themestylesheets', array(
		"attachedto" => $attachedto
	), "name='{$name}'");

	// Now update/insert the master stylesheet
	$query = $db->simple_select('themestylesheets', 'sid', "tid='1' AND name='{$name}'");
	$sid = (int) $db->fetch_field($query, 'sid');

	if ($sid) {
		$db->update_query('themestylesheets', $thisStyleSheet, "sid='{$sid}'");
	} else {
		$sid = $db->insert_query('themestylesheets', $thisStyleSheet);
		$thisStyleSheet['sid'] = (int) $sid;
	}

	// Now cache the actual files
	require_once MYBB_ROOT . "{$config['admin_dir']}/inc/functions_themes.php";

	if (!cache_stylesheet(1, $thisStyleSheet['cachefile'], $stylesheet))
	{
		$db->update_query("themestylesheets", array('cachefile' => "css.php?stylesheet={$sid}"), "sid='{$sid}'", 1);
	}

	// And update the CSS file list
	update_theme_stylesheet_list(1, false, true);
	
	// Add plugin settings into ACP
	// Add plugin settings group
	$setting_group = array(
		'name'			=> 'mybbfancybox',
		'title'			=> $lang->mybbfancybox_settings_group_title,
		'description'	=> $lang->mybbfancybox_settings_group_description,
		'disporder'		=> '1',
		'isdefault'		=> 'no'
	);
	$db->insert_query('settinggroups', $setting_group);
	$gid = (int) $db->insert_id();
	
	// Open image URLs settings
	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_open_image_urls',
		'title'			=> $lang->mybbfancybox_open_image_urls_title,
		'description'	=> $lang->mybbfancybox_open_image_urls_description,
		'optionscode'	=> 'yesno',
		'value'			=> '1',
		'disporder'		=> '1',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);

	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_allowed_extensions',
		'title'			=> $lang->mybbfancybox_allowed_extensions_title,
		'description'	=> $lang->mybbfancybox_allowed_extensions_description,
		'optionscode'	=> 'text',
		'value'			=> '',
		'disporder'		=> '2',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);
	
	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_include_images_from_urls_into_gallery', // issue GitHub #49
		'title'			=> $lang->mybbfancybox_include_images_from_urls_into_gallery_title,
		'description'	=> $lang->mybbfancybox_include_images_from_urls_into_gallery_description,
		'optionscode'	=> 'yesno',
		'value'			=> '1',
		'disporder'		=> '3',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);
	
	// FancyBox basic settings - lines #37-48 in mybbfancybox.js in /jscripts folder
	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_protect_images',
		'title'			=> $lang->mybbfancybox_protect_images_title,
		'description'	=> $lang->mybbfancybox_protect_images_description,
		'optionscode'	=> 'yesno', // false or true value
		'value'			=> '0',
		'disporder'		=> '4',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);

	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_watermark', // displayed only the previous setting (protect images) is enabled
		'title'			=> $lang->mybbfancybox_watermark_title,
		'description'	=> $lang->mybbfancybox_watermark_description,
		'optionscode'	=> 'yesno', // CSS class watermark or leave blank to disable (protect images must be enable to use that!)
		'value'			=> '0',
		'disporder'		=> '5',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);

	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_watermark_exclude_low_resolution_images', // displayed only the previous setting (watermark) is enabled
		'title'			=> $lang->mybbfancybox_watermark_exclude_low_resolution_images_title,
		'description'	=> $lang->mybbfancybox_watermark_exclude_low_resolution_images_description,
		'optionscode'	=> 'yesno', // Exclude low resolution images from adding watermark
		'value'			=> '1',
		'disporder'		=> '6',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);

	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_watermark_resolutions', //  displayed only if the previous setting (watermark exclude...) is set to YES
		'title'			=> $lang->mybbfancybox_watermark_resolutions_title,
		'description'	=> $lang->mybbfancybox_watermark_resolutions_description,
		'optionscode'	=> 'text',
		'value'			=> '300|300', // Instead of using hard-coded values would be better to add a custom box max width X height px
		'disporder'		=> '7',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);

	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_loop',
		'title'			=> $lang->mybbfancybox_loop_title,
		'description'	=> $lang->mybbfancybox_loop_description,
		'optionscode'	=> 'yesno', // false or true value
		'value'			=> '1',
		'disporder'		=> '8',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);

	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_infobar',
		'title'			=> $lang->mybbfancybox_infobar_title,
		'description'	=> $lang->mybbfancybox_infobar_description,
		'optionscode'	=> 'yesno', // false or true value
		'value'			=> '1',
		'disporder'		=> '9',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);

	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_arrows',
		'title'			=> $lang->mybbfancybox_arrows_title,
		'description'	=> $lang->mybbfancybox_arrows_description,
		'optionscode'	=> 'yesno', // false or true value
		'value'			=> '1',
		'disporder'		=> '10',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);

	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_thumbs',
		'title'			=> $lang->mybbfancybox_thumbs_title,
		'description'	=> $lang->mybbfancybox_thumbs_description,
		'optionscode'	=> 'yesno', // false or true value
		'value'			=> '0',
		'disporder'		=> '11',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);
	
	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_minimize',
		'title'			=> $lang->mybbfancybox_minimize_title,
		'description'	=> $lang->mybbfancybox_minimize_description,
		'optionscode'	=> 'yesno', // enable or disable feature; CSS is already added into mybbfancybox.css; we need just to load an extra JS + delete commented minimize button in config file (GitHub issue #32)
		'value'			=> '1',
		'disporder'		=> '12',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);

	$buttonSetting = <<<EOF
php
<select multiple name=\"upsetting[mybbfancybox_buttons][]\" size=\"7\">
	<option value=\"slideShow\" ".(is_array(unserialize(\$setting['value'])) ? (\$setting['value'] != "" && in_array("slideShow", unserialize(\$setting['value'])) ? "selected=\"selected\"":""):"").">{$lang->mybbfancybox_button_slideshow_title}</option>
	<option value=\"fullScreen\" ".(is_array(unserialize(\$setting['value'])) ? (\$setting['value'] != "" && in_array("fullScreen", unserialize(\$setting['value'])) ? "selected=\"selected\"":""):"").">{$lang->mybbfancybox_button_fullscreen_title}</option>
	<option value=\"thumbs\" ".(is_array(unserialize(\$setting['value'])) ? (\$setting['value'] != "" && in_array("thumbs", unserialize(\$setting['value'])) ? "selected=\"selected\"":""):"").">{$lang->mybbfancybox_button_thumbs_title}</option>
	<option value=\"share\" ".(is_array(unserialize(\$setting['value'])) ? (\$setting['value'] != "" && in_array("share", unserialize(\$setting['value'])) ? "selected=\"selected\"":""):"").">{$lang->mybbfancybox_button_share_title}</option>
	<option value=\"download\" ".(is_array(unserialize(\$setting['value'])) ? (\$setting['value'] != "" && in_array("download", unserialize(\$setting['value'])) ? "selected=\"selected\"":""):"").">{$lang->mybbfancybox_button_download_title}</option>
	<option value=\"zoom\" ".(is_array(unserialize(\$setting['value'])) ? (\$setting['value'] != "" && in_array("zoom", unserialize(\$setting['value'])) ? "selected=\"selected\"":""):"").">{$lang->mybbfancybox_button_zoom_title}</option>
	<option value=\"close\" ".(is_array(unserialize(\$setting['value'])) ? (\$setting['value'] != "" && in_array("close", unserialize(\$setting['value'])) ? "selected=\"selected\"":""):"").">{$lang->mybbfancybox_button_close_title}</option>
</select>

EOF;

	// Settings for buttons - lines #50-58 in mybbfancybox.js in /jscripts folder
	$mybbfancybox_setting = array(
		'name'			=> 'mybbfancybox_buttons',
		'title'			=> $lang->mybbfancybox_buttons_title,
		'description'	=> $lang->mybbfancybox_buttons_description,
		'optionscode'	=> $db->escape_string($buttonSetting),
		'value'			=> $db->escape_string(serialize(array('slideShow', 'fullScreen', 'thumbs', 'share', 'download', 'zoom', 'close'))),
		'disporder'		=> '13',
		'gid'			=> $gid
	);
	$db->insert_query('settings', $mybbfancybox_setting);
	
	// Rebuild settings
	rebuild_settings();
}

// Plugin uninstallation
function mybbfancybox_uninstall()
{
	global $db;

	$where = "name='mybbfancybox.css'";

	// Find the master and any children
	$query = $db->simple_select('themestylesheets', 'tid,name', $where);

	// Delete them all from the server
	while ($styleSheet = $db->fetch_array($query)) {
		@unlink(MYBB_ROOT."cache/themes/{$styleSheet['tid']}_{$styleSheet['name']}");
		@unlink(MYBB_ROOT."cache/themes/theme{$styleSheet['tid']}/{$styleSheet['name']}");
	}

	// Then delete them from the database
	$db->delete_query('themestylesheets', $where);

	// Now remove them from the CSS file list
	require_once MYBB_ADMIN_DIR."inc/functions_themes.php";
	update_theme_stylesheet_list(1, false, true);
	
	// Delete plugin settings in ACP
	$db->write_query("DELETE FROM ".TABLE_PREFIX."settings WHERE name IN ('mybbfancybox_open_image_urls','mybbfancybox_allowed_extensions','mybbfancybox_include_images_from_urls_into_gallery','mybbfancybox_protect_images','mybbfancybox_watermark','mybbfancybox_watermark_exclude_low_resolution_images','mybbfancybox_watermark_resolutions','mybbfancybox_loop','mybbfancybox_infobar','mybbfancybox_arrows','mybbfancybox_thumbs','mybbfancybox_minimize','mybbfancybox_buttons')");
	$db->write_query("DELETE FROM ".TABLE_PREFIX."settinggroups WHERE name = 'mybbfancybox'");
	
	// Rebuild settings
	rebuild_settings();
}

mybbfancybox_init();

function mybbfancybox_init()
{
	global $mybb, $plugins;

	if (defined('IN_ADMINCP')) {
		$plugins->add_hook('admin_config_settings_change', 'mybbfancybox_admin_config_settings_change');
	}

	// Open image URL link in posts
	// Check ACP settings
	if ($mybb->settings['mybbfancybox_open_image_urls'] == '1') {
		// Add hook
		$plugins->add_hook("parse_message_end","mybbfancybox_post");
	}

	if (THIS_SCRIPT == 'showthread.php') {
		// Add hook
		$plugins->add_hook('showthread_start', 'mybbfancybox_showthread_start');
	}
}

function mybbfancybox_showthread_start()
{
	global $mybb, $templates, $headerinclude, $lang;

	if (!$lang->mybbfancybox) {
		$lang->load('mybbfancybox');
	}

	// Apply required changes in postbit_attachments_thumbnails_thumbnail template (replace all content)
	$templates->cache['postbit_attachments_thumbnails_thumbnail'] = '<a href="attachment.php?aid={$attachment[\'aid\']}" data-fancybox="data-{$post[\'pid\']}" data-type="image" data-caption="<b>{$lang->postbit_attachment_filename}</b> {$attachment[\'filename\']} - <b>{$lang->postbit_attachment_size}</b> {$attachment[\'filesize\']} - <b>{$lang->mybbfancybox_uploaded}</b> {$attachdate} - <b>{$lang->mybbfancybox_views}</b> {$attachment[\'downloads\']}{$lang->mybbfancybox_views_symbol_after}"><img src="attachment.php?thumbnail={$attachment[\'aid\']}" class="attachment" alt="" title="{$lang->postbit_attachment_filename} {$attachment[\'filename\']}&#13{$lang->postbit_attachment_size} {$attachment[\'filesize\']}&#13{$lang->mybbfancybox_uploaded} {$attachdate}&#13{$lang->mybbfancybox_views} {$attachment[\'downloads\']}{$lang->mybbfancybox_views_symbol_after}" /></a>&nbsp;&nbsp;&nbsp;';

	// Apply required changes in postbit_attachments_images_image template (replace all content)
	$templates->cache['postbit_attachments_images_image'] = '<a target="_blank" data-fancybox="data-{$attachment[\'pid\']}" data-type="image"><img src="attachment.php?aid={$attachment[\'aid\']}" class="attachment" alt="" title="{$lang->postbit_attachment_filename} {$attachment[\'filename\']}&#13{$lang->postbit_attachment_size} {$attachment[\'filesize\']}&#13{$lang->mybbfancybox_uploaded} {$attachdate}&#13{$lang->mybbfancybox_views} {$attachment[\'downloads\']}{$lang->mybbfancybox_views_symbol_after}" /></a>&nbsp;&nbsp;&nbsp;';

	$watermark = '';
	if ($mybb->settings['mybbfancybox_watermark']) {
		$watermark = 'watermark';
	}

	foreach (array(
		//'mybbfancybox_watermark_exclude_low_resolution_images' => '?',
		'mybbfancybox_protect_images' => 'protect',
		'mybbfancybox_loop' => 'loop',
		'mybbfancybox_infobar' => 'infobar',
		'mybbfancybox_arrows' => 'arrows',
		'mybbfancybox_thumbs' => 'thumbs',
	) as $key => $var) {
		$$var = $mybb->settings[$key] ? 'true' : 'false';
	}

	$buttonArray = (array) unserialize($mybb->settings['mybbfancybox_buttons']);

	if (!empty($buttonArray) &&
		count($buttonArray) > 0) {
		$buttons = "'".implode("','", $buttonArray)."'";
	}

	$buttons = "\n\t\tbuttons: [ {$buttons} ],";

	$headerinclude .= <<<EOF


	<link rel="stylesheet" href="{$mybb->asset_url}/jscripts/fancybox/jquery.fancybox.min.css" type="text/css" media="screen" />
	<script type="text/javascript" src="{$mybb->asset_url}/jscripts/fancybox/jquery.fancybox.min.js"></script>
	<script type="text/javascript" src="{$mybb->asset_url}/jscripts/mybbfancybox.js"></script>
	<script type="text/javascript">
	<!--
	MyBBFancybox.setup({
		clickToEnlarge: "{$lang->mybbfancybox_click_to_enlarge}",
		CLOSE: "{$lang->mybbfancybox_close}",
		NEXT: "{$lang->mybbfancybox_next}",
		PREV: "{$lang->mybbfancybox_prev}",
		ERROR: "{$lang->mybbfancybox_error}",
		PLAY_START: "{$lang->mybbfancybox_play_start}",
		PLAY_STOP: "{$lang->mybbfancybox_play_stop}",
		FULL_SCREEN: "{$lang->mybbfancybox_full_screen}",
		THUMBS: "{$lang->mybbfancybox_thumbs}",
		DOWNLOAD: "{$lang->mybbfancybox_download}",
		SHARE: "{$lang->mybbfancybox_share}",
		ZOOM: "{$lang->mybbfancybox_zoom}",
		MINIMIZE: "{$lang->mybbfancybox_minimize}",
	}, {
		protect: {$protect},
		slideClass: "{$watermark}",
		loop: {$loop},
		infobar: {$infobar},
		arrows: {$arrows},
		thumbs: {$thumbs},{$buttons}
	});
	// -->
	</script>
EOF;

}

// If enabled, then make a black magic
// ...muahahaha... -wc
function mybbfancybox_post($message)
{
	// Only parse allowed extensions once
	static $allowedExtensions = null;

	global $mybb, $post;

	// If null, then it has not yet been built
	if ($allowedExtensions === null) {
		// Set to an empty array so we don't try to build it again if setting is blank/errored
		$allowedExtensions = array();

		// Get all of the allowed image extensions from the plugin setting
		$userExts = explode(',', $mybb->settings['mybbfancybox_allowed_extensions']);

		// Remove all empty array elements (eg. 'jpg,,png')
		$userExts = array_filter($userExts);

		// Trim all array elements (eg. 'jpg, png, gif ,')
		$allowedExtensions = array_map('trim', $userExts);
	}

	// Grab the allowed extensions
	$exts = $allowedExtensions;
	$regx = '';

	// If the setting value isn't empty, use it to build a custom regular expression
	if (is_array($exts) && !empty($exts)) {
		// No separator for the first extension
		$sep = '';
		foreach ($exts as $ext) {
			// Special case for APNG
			if ($ext === 'apng') {
				$regx .= $sep.'apng:\/\/[^ ]+';
				continue;
			}

			// Add this extension to the list w/separator (if applicable)
			$regx .= $sep.$ext;

			// Add a separator after the first extension
			$sep = '|';
		}
	}

	// Default
	if (!$regx) {
		$regx = 'png|gif|jpeg|bmp|jpg|apng:\/\/[^ ]+';
	}

	// Search for image extension in URL link
	$find = '/(.*)href="(.*)('.$regx.')"([^>])*?>([^<]*)?<\/a>/';

	// Open image URL link in MyBB FancyBox modal window 
	$replace = '$1href="$2$3" data-fancybox="data-'.$post['pid'].'" data-type="image" data-caption="$5"$4>$5</a>';

	$message = preg_replace($find, $replace, $message);
	return $message;
}

function mybbfancybox_admin_config_settings_change()
{
    global $mybb;

    if (isset($mybb->input['upsetting']['mybbfancybox_open_image_urls'])) {
		$mybb->input['upsetting']['mybbfancybox_buttons'] = serialize($mybb->input['upsetting']['mybbfancybox_buttons']);
	}
}
