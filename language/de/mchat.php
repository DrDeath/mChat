<?php

/**
* @version $Id: mchat.php 169 2018-07-31 16:32:45Z Scanialady $
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
// ‚ ‘ ’ « » „ “ ” …

$lang = array_merge($lang, [
	'MCHAT_ADD'						=> 'Senden',
	'MCHAT_ARCHIVE'					=> 'Archiv',
	'MCHAT_ARCHIVE_PAGE'			=> 'mChat Archiv',
	'MCHAT_CUSTOM_PAGE'				=> 'mChat',
	'MCHAT_BBCODES'					=> 'BBCodes',
	'MCHAT_CUSTOM_BBCODES'			=> 'Eigene BBCodes',
	'MCHAT_DELCONFIRM'				=> 'Bist du sicher, dass du diese Nachricht löschen willst?',
	'MCHAT_EDIT'					=> 'Bearbeiten',
	'MCHAT_EDITINFO'				=> 'Bearbeite die Nachricht unten.',
	'MCHAT_NEW_CHAT'				=> 'Neue Chatnachricht!',
	'MCHAT_SEND_PM'					=> 'Sende private Nachricht',
	'MCHAT_LIKE'					=> 'Diese Nachricht gefällt mir',
	'MCHAT_LIKES'					=> 'gefällt diese Nachricht',
	'MCHAT_FLOOD'					=> 'Du kannst keine Nachricht so schnell nach deiner letzten Nachricht senden.',
	'MCHAT_FOE'						=> 'Diese Nachricht wurde von <strong>%1$s</strong> erstellt, welcher sich derzeit auf deiner Ignorierliste befindet.',
	'MCHAT_RULES'					=> 'Regeln',
	'MCHAT_WHOIS_USER'				=> 'IP whois für %1$s',
	'MCHAT_MESS_LONG'				=> 'Deine Nachricht ist zu lang. Bitte beschränke sie auf %1$d Zeichen.',
	'MCHAT_NO_CUSTOM_PAGE'			=> 'Die separate Seite für mChat ist derzeit nicht aktiviert.',
	'MCHAT_NO_RULES'				=> 'Die Seite mit den mChat-Regeln ist derzeit nicht aktiviert.',
	'MCHAT_NOACCESS_ARCHIVE'		=> 'Du hast keine Berechtigung das Archiv anzusehen.',
	'MCHAT_NOJAVASCRIPT'			=> 'Bitte aktiviere JavaScript, um mChat zu benutzen.',
	'MCHAT_NOMESSAGE'				=> 'Keine Nachrichten',
	'MCHAT_NOMESSAGEINPUT'			=> 'Du hast keine Nachricht eingegeben',
	'MCHAT_MESSAGE_DELETED'			=> 'Diese Nachricht wurde gelöscht.',
	'MCHAT_OK'						=> 'OK',
	'MCHAT_PAUSE'					=> 'Pausiert',
	'MCHAT_PERMISSIONS'				=> 'Ändere die Benutzerrechte',
	'MCHAT_REFRESHING'				=> 'Aktualisiere…',
	'MCHAT_RESPOND'					=> 'Antworte dem Benutzer',
	'MCHAT_SMILES'					=> 'Smilies',
	'MCHAT_TOTALMESSAGES'			=> 'Nachrichten gesamt: <strong>%1$d</strong>',
	'MCHAT_USESOUND'				=> 'Ton abspielen',
	'MCHAT_SOUND_ON'				=> 'Ton ist an',
	'MCHAT_SOUND_OFF'				=> 'Ton ist aus',
	'MCHAT_ENTER'					=> 'Benutze STRG + Enter für die alternative Aktion',
	'MCHAT_ENTER_SUBMIT'			=> 'Enter sendet die Nachricht',
	'MCHAT_ENTER_LINEBREAK'			=> 'Enter fügt eine neue Zeile hinzu',
	'MCHAT_COLLAPSE_TITLE'			=> [
		0 => 'mChat ausblenden',
		1 => 'mChat einblenden',
	],
	'MCHAT_WHO_IS_REFRESH_EXPLAIN'	=> 'Aktualisiert alle <strong>%1$d</strong> Sekunden',
	'MCHAT_MINUTES_AGO'				=> [
		0 => 'gerade eben',
		1 => 'vor %1$d Minute',
		2 => 'vor %1$d Minuten',
	],

	// These messages are formatted with JavaScript, hence {} and no %d
	'MCHAT_CHARACTER_COUNT'			=> '<strong>{current}</strong> Zeichen',
	'MCHAT_CHARACTER_COUNT_LIMIT'	=> '<strong>{current}</strong> verbraucht von {max} Zeichen',
	'MCHAT_MENTION'					=> ' @{username} ',
]);
