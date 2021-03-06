<?php

/**
* @version $Id: info_acp_mchat.php 169 2018-07-31 16:32:45Z Scanialady $
* @package phpBB Extension - mChat [German]
* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
* @copyright (c) 2016 kasimi - https://kasimi.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ‚ ‘ ’ « » „ “ ” …

$lang = array_merge($lang, [
	// Module titles
	'ACP_CAT_MCHAT'					=> 'mChat',
	'ACP_CAT_MCHAT_USER_CONFIG'		=> 'mChat im UCP',
	'ACP_MCHAT_GLOBALSETTINGS'		=> 'Globale Einstellungen',
	'ACP_MCHAT_GLOBALUSERSETTINGS'	=> 'Globale Benutzereinstellungen',

	// Log entries (%1$s is replaced with the user name who triggered the event)
	'LOG_MCHAT_CONFIG_UPDATE'		=> '<strong>mChat-Konfiguration geändert</strong><br />» %1$s',
	'LOG_MCHAT_TABLE_PRUNED'		=> '<strong>mChat-Nachrichten beschnitten: %2$d</strong>',
	'LOG_MCHAT_TABLE_PURGED'		=> '<strong>mChat-Nachrichten bereinigt</strong><br />» %1$s',
	'LOG_DELETED_MCHAT'				=> '<strong>mChat-Nachricht gelöscht</strong><br />» %1$s',
	'LOG_EDITED_MCHAT'				=> '<strong>mChat-Nachricht bearbeitet</strong><br />» %1$s',
]);
