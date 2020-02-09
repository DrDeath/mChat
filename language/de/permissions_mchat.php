<?php

/**
*
* @version $Id: permissions_mchat.php 174 2018-10-05 22:57:20Z Scanialady $
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
// Some characters for use
//  ‚ ‘ ’ « » „ “ ” …

$lang = array_merge($lang, [
	'ACL_U_MCHAT_USE'						=> 'Kann mChat benutzen',
	'ACL_U_MCHAT_VIEW'						=> 'Kann mChat sehen',
	'ACL_U_MCHAT_EDIT'						=> 'Kann eigene mChat-Nachrichten bearbeiten',
	'ACL_U_MCHAT_DELETE'					=> 'Kann eigene mChat-Nachrichten löschen',
	'ACL_U_MCHAT_MODERATOR_EDIT'			=> 'Kann jedermanns Nachrichten bearbeiten',
	'ACL_U_MCHAT_MODERATOR_DELETE'			=> 'Kann jedermanns Nachrichten löschen',
	'ACL_U_MCHAT_IP'						=> 'Kann IP-Adressen sehen',
	'ACL_U_MCHAT_PM'						=> 'Kann Private Nachrichten benutzen',
	'ACL_U_MCHAT_LIKE'						=> 'Kann Nachrichten liken',
	'ACL_U_MCHAT_QUOTE'						=> 'Kann Nachrichten zitieren',
	'ACL_U_MCHAT_FLOOD_IGNORE'				=> 'Kann Flood-Intervall ignorieren',
	'ACL_U_MCHAT_ARCHIVE'					=> 'Kann das Archiv sehen',
	'ACL_U_MCHAT_BBCODE'					=> 'Kann BBCodes benutzen',
	'ACL_U_MCHAT_SMILIES'					=> 'Kann Smilies benutzen',
	'ACL_U_MCHAT_URLS'						=> 'Kann automatisch geparste URLs senden',
	
	'ACL_U_MCHAT_AVATARS'					=> 'Kann anpassen <em>Avatare anzeigen</em>',
	'ACL_U_MCHAT_CAPITAL_LETTER'			=> 'Kann anpassen <em>Erster Buchstabe groß</em>',
	'ACL_U_MCHAT_CHARACTER_COUNT'			=> 'Kann anpassen <em>Zeige Zeichenanzahl an</em>',
	'ACL_U_MCHAT_DATE'						=> 'Kann anpassen <em>Datumsformat</em>',
	'ACL_U_MCHAT_INDEX'						=> 'Kann anpassen <em>Anzeige auf der Forenübersicht</em>',
	'ACL_U_MCHAT_LOCATION'					=> 'Kann anpassen <em>Lokalisierung von mChat auf der Indexseite</em>',
	'ACL_U_MCHAT_MESSAGE_TOP'				=> 'Kann anpassen <em>Lokalisierung neuer mChat-Nachrichten</em>',
	'ACL_U_MCHAT_POSTS'						=> 'Kann anpassen <em>Neue Beiträge anzeigen</em>',
	'ACL_U_MCHAT_RELATIVE_TIME'				=> 'Kann anpassen <em>Relative Zeit anzeigen</em>',
	'ACL_U_MCHAT_SOUND'						=> 'Kann anpassen <em>Töne abspielen</em>',
	'ACL_U_MCHAT_WHOIS_INDEX'				=> 'Kann anpassen <em>„Wer chattet“-Anzeige unter dem Chat</em>',
	'ACL_U_MCHAT_STATS_INDEX'				=> 'Kann anpassen <em>„Wer chattet“-Anzeige im Statistikbereich</em>',

	'ACL_A_MCHAT'							=> 'Kann mChat-Einstellungen verwalten',
]);
