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
		"version"		=> "0.8",
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
	global $db, $config;

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
}

if (THIS_SCRIPT == 'showthread.php') {
	$plugins->add_hook('showthread_start', 'mybbfancybox_showthread_start');
}

function mybbfancybox_showthread_start()
{
	global $mybb, $templates, $headerinclude, $lang;

	if (!$lang->mybbfancybox) {
		$lang->load('mybbfancybox');
	}

	// Apply required changes in postbit_attachments_thumbnails_thumbnail template (replace all content)
	$templates->cache['postbit_attachments_thumbnails_thumbnail'] = '<a href="attachment.php?aid={$attachment[\'aid\']}" data-fancybox="data-{$post[\'pid\']}" data-type="image" data-caption="<b>{$lang->postbit_attachment_filename}</b> {$attachment[\'filename\']} - <b>{$lang->postbit_attachment_size}</b> {$attachment[\'filesize\']} - <b>{$lang->mybbfancybox_uploaded}</b> {$attachdate} - <b>Views:</b> {$attachment[\'downloads\']}x"><img src="attachment.php?thumbnail={$attachment[\'aid\']}" class="attachment" alt="" title="{$lang->postbit_attachment_filename} {$attachment[\'filename\']}&#13{$lang->postbit_attachment_size} {$attachment[\'filesize\']}&#13{$lang->mybbfancybox_uploaded} {$attachdate}&#13Views: {$attachment[\'downloads\']}x" /></a>&nbsp;&nbsp;&nbsp;';

	// Apply required changes in postbit_attachments_images_image template (replace all content)
	$templates->cache['postbit_attachments_images_image'] = '<a target="_blank" data-fancybox="data-{$attachment[\'pid\']}" data-type="image"><img src="attachment.php?aid={$attachment[\'aid\']}" class="attachment" alt="" title="{$lang->postbit_attachment_filename} {$attachment[\'filename\']}&#13{$lang->postbit_attachment_size} {$attachment[\'filesize\']}&#13{$lang->mybbfancybox_uploaded} {$attachdate}&#13Views: {$attachment[\'downloads\']}x" /></a>&nbsp;&nbsp;&nbsp;';

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
	});
	// -->
	</script>
EOF;

}