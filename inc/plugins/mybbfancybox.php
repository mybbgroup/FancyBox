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
		"description"	=> "MyBB FancyBox plugin",
		"website"		=> "https://github.com/mybbgroup/MyBB_Fancybox",
		"author"		=> "MyBB Group (Eldenroot & effone)",
		"authorsite"	=> "https://github.com/mybbgroup/MyBB_Fancybox",
		"version"		=> "0.1",
		"codename"		=> "",
		"compatibility" => "18*"
	);
}

// Plugin activation
function mybbfancybox_activate()
{
require_once MYBB_ROOT."/inc/adminfunctions_templates.php";
	// Apply required changes in postbit_attachments_thumbnails_thumbnail template
	find_replace_templatesets("postbit_attachments_thumbnails_thumbnail",
    "#" . preg_quote('<a href="attachment.php?aid={$attachment[\'aid\']}" target="_blank"><img src="attachment.php?thumbnail={$attachment[\'aid\']}" class="attachment" alt="" title="{$lang->postbit_attachment_filename} {$attachment[\'filename\']}&#13;{$lang->postbit_attachment_size} {$attachment[\'filesize\']}&#13;{$attachdate}" /></a>&nbsp;&nbsp;&nbsp;') . "#i",'<a href="attachment.php?aid={$attachment[\'aid\']}" data-fancybox="data-{$post[\'pid\']}" data-type="image" data-caption="<b>Filename:</b> {$attachment[\'filename\']} - <b>Size:</b> {$attachment[\'filesize\']} - <b>Uploaded:</b> {$attachdate} - <b>Views:</b> {$attachment[\'downloads\']}x"><img src="attachment.php?thumbnail={$attachment[\'aid\']}" class="attachment" alt="" title="Filename: {$attachment[\'filename\']}&#13Size: {$attachment[\'filesize\']}&#13Views: {$attachment[\'downloads\']}x &#13Uploaded: {$attachdate}" /></a>&nbsp;&nbsp;&nbsp;');
	// Apply required changes in headerinclude template
	find_replace_templatesets("headerinclude","#" . preg_quote('{$stylesheets}') . "#i",'{$stylesheets}<link rel="stylesheet" href="/fancybox/jquery.fancybox.min.css" type="text/css" media="screen" /><script type="text/javascript" src="/fancybox/jquery.fancybox.min.js"></script><script type="text/javascript" src="/jscripts/mybbfancybox.js"></script>');
}

// Plugin deactivation
function mybbfancybox_deactivate()
{
require_once MYBB_ROOT."/inc/adminfunctions_templates.php";
	// Revert changes postbit_attachments_thumbnails_thumbnail template
	find_replace_templatesets("postbit_attachments_thumbnails_thumbnail","#" . preg_quote('<a href="attachment.php?aid={$attachment[\'aid\']}" data-fancybox="data-{$post[\'pid\']}" data-type="image" data-caption="<b>Filename:</b> {$attachment[\'filename\']} - <b>Size:</b> {$attachment[\'filesize\']} - <b>Uploaded:</b> {$attachdate} - <b>Views:</b> {$attachment[\'downloads\']}x"><img src="attachment.php?thumbnail={$attachment[\'aid\']}" class="attachment" alt="" title="Filename: {$attachment[\'filename\']}&#13Size: {$attachment[\'filesize\']}&#13Views: {$attachment[\'downloads\']}x &#13Uploaded: {$attachdate}" /></a>&nbsp;&nbsp;&nbsp;') . "#i",'<a href=\"attachment.php?aid={$attachment[\'aid\']}\" target=\"_blank\"><img src=\"attachment.php?thumbnail={$attachment[\'aid\']}" class=\"attachment\" alt=\"\" title=\"{$lang->postbit_attachment_filename} {$attachment[\'filename\']}&#13;{$lang->postbit_attachment_size} {$attachment[\'filesize\']}&#13;{$attachdate}\" /></a>&nbsp;&nbsp;&nbsp;');
	// Revert changes in headerinclude template
	find_replace_templatesets("headerinclude","#" . preg_quote('{$stylesheets}<link rel="stylesheet" href="/fancybox/jquery.fancybox.min.css" type="text/css" media="screen" /><script type="text/javascript" src="/fancybox/jquery.fancybox.min.js"></script><script type="text/javascript" src="/jscripts/mybbfancybox.js"></script>') . "#i",'{$stylesheets}');
}