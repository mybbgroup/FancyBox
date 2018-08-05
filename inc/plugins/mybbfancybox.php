<?php

/**
 * MyBB FancyBox - plugin for MyBB 1.8.x forum software
 * 
 * @package MyBB Plugin
 * @author MyBB Group - Eldenroot & effone - <eldenroot@gmail.com>
 * @copyright 2018 MyBB Group <http://mybb.group>
 * @link <https://github.com/mybbgroup/MyBB_Fancybox>
 * @version 0.1
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
	return array(
		"name"			=> "MyBB FancyBox",
		"description"	=> "FancyBox JavaScript library for presenting images in a fancy way. Fully responsive, touch-enabled and customizable.",
		"website"		=> "https://github.com/mybbgroup/MyBB_Fancybox",
		"author"		=> "MyBB Group (Eldenroot & effone)",
		"authorsite"	=> "https://github.com/mybbgroup/MyBB_Fancybox",
		"version"		=> "0.2",
		"codename"		=> "",
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

	// update any children
	$db->update_query('themestylesheets', array(
		"attachedto" => $attachedto
	), "name='{$name}'");

	// now update/insert the master stylesheet
	$query = $db->simple_select('themestylesheets', 'sid', "tid='1' AND name='{$name}'");
	$sid = (int) $db->fetch_field($query, 'sid');

	if ($sid) {
		$db->update_query('themestylesheets', $thisStyleSheet, "sid='{$sid}'");
	} else {
		$sid = $db->insert_query('themestylesheets', $thisStyleSheet);
		$thisStyleSheet['sid'] = (int) $sid;
	}

	// now cache the actual files
	require_once MYBB_ROOT . "{$config['admin_dir']}/inc/functions_themes.php";

	if (!cache_stylesheet(1, $thisStyleSheet['cachefile'], $stylesheet))
	{
		$db->update_query("themestylesheets", array('cachefile' => "css.php?stylesheet={$sid}"), "sid='{$sid}'", 1);
	}

	// and update the CSS file list
	update_theme_stylesheet_list(1, false, true);
}

// Plugin activation
function mybbfancybox_activate()
	// Apply template changes
	{
	require_once MYBB_ROOT."/inc/adminfunctions_templates.php";
		// Apply required changes in postbit_attachments_thumbnails_thumbnail template (delete all content and add the new one)
		find_replace_templatesets('postbit_attachments_thumbnails_thumbnail', '#^(.*?)$#s', '<a href="attachment.php?aid={$attachment[\'aid\']}" data-fancybox="data-{$post[\'pid\']}" data-type="image" data-caption="<b>Filename:</b> {$attachment[\'filename\']} - <b>Size:</b> {$attachment[\'filesize\']} - <b>Uploaded:</b> {$attachdate} - <b>Views:</b> {$attachment[\'downloads\']}x"><img src="attachment.php?thumbnail={$attachment[\'aid\']}" class="attachment" alt="" title="Filename: {$attachment[\'filename\']}&#13Size: {$attachment[\'filesize\']}&#13Views: {$attachment[\'downloads\']}x &#13Uploaded: {$attachdate}" /></a>&nbsp;&nbsp;&nbsp;');
		// Apply required changes in headerinclude template
		find_replace_templatesets("headerinclude", "#" . preg_quote('{$stylesheets}') . "#i",'{$stylesheets}<link rel="stylesheet" href="/jscripts/fancybox/jquery.fancybox.min.css" type="text/css" media="screen" /><script type="text/javascript" src="/jscripts/fancybox/jquery.fancybox.min.js"></script><script type="text/javascript" src="/jscripts/mybbfancybox.js"></script>');
	}

	// Plugin deactivation
function mybbfancybox_deactivate()
	{
	require_once MYBB_ROOT."/inc/adminfunctions_templates.php";
		// Revert changes postbit_attachments_thumbnails_thumbnail template
		find_replace_templatesets('postbit_attachments_thumbnails_thumbnail', '#^(.*?)$#s', '<a href="attachment.php?aid={$attachment[\'aid\']}" target="_blank"><img src="attachment.php?thumbnail={$attachment[\'aid\']}" class="attachment" alt="" title="{$lang->postbit_attachment_filename} {$attachment[\'filename\']}&#13;{$lang->postbit_attachment_size} {$attachment[\'filesize\']}&#13;{$attachdate}" /></a>&nbsp;&nbsp;&nbsp;');
		// Revert changes in headerinclude template
		find_replace_templatesets("headerinclude", "#" . preg_quote('{$stylesheets}<link rel="stylesheet" href="/jscripts/fancybox/jquery.fancybox.min.css" type="text/css" media="screen" /><script type="text/javascript" src="/jscripts/fancybox/jquery.fancybox.min.js"></script><script type="text/javascript" src="/jscripts/mybbfancybox.js"></script>') . "#i",'{$stylesheets}');
	}

// Plugin uninstallation
function mybbfancybox_uninstall()
{
	global $db;
    require_once(MYBB_ROOT."admin/inc/functions_themes.php");
    // Remove mybbfancybox.css from the theme cache directories if it exists
	$query = $db->simple_select("themes", "tid");
	while($tid = $db->fetch_field($query, "tid"))
	{
		$css_file = MYBB_ROOT."cache/themes/theme{$tid}/mybbfancybox.css";
		if(file_exists($css_file))
			unlink($css_file);
	}

    update_theme_stylesheet_list("1");
}