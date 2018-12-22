<?php

/**
 *
 * @package phpBB Extension - mChat - de language
 * @copyright (c) 2016 dmzx - http://www.dmzx-web.net
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
// ’ » “ ” …

$lang = array_merge($lang, [
	'MCHAT_PREFERENCES'				=> 'mChat Einstellungen',
	'MCHAT_NO_SETTINGS'				=> 'Du bist nicht berechtigt irgendwelche Einstellungen anzupassen.',

	'MCHAT_INDEX'					=> 'Auf dem Forenindex anzeigen',
	'MCHAT_SOUND'					=> 'Ton einschalten',	
	'MCHAT_WHOIS_INDEX'				=> 'Zeige <em>Wer chattet</em> unter dem Chat an',
	'MCHAT_STATS_INDEX'				=> 'Zeige <em>Wer chattet</em> im Statistikbereich an',
	'MCHAT_STATS_INDEX_EXPLAIN'		=> 'Zeige wer chattet unter dem <em>Wer ist online</em>-Bereich auf dem Forenindex.',
	'MCHAT_AVATARS'					=> 'Zeige Avatare im Chat',
	'MCHAT_CAPITAL_LETTER'			=> 'Erster Buchstabe als Grossbuchstabe in deinen Nachrichten',
	'MCHAT_POSTS'					=> 'Zeige neue Beiträge an (derzeit alle deaktiviert, können im ACP in den Allgemeinen Einstellungen von mChat aktiviert werden)',
	'MCHAT_DISPLAY_CHARACTER_COUNT'	=> 'Zeige die Anzahl der Zeichen beim Schreiben einer Nachricht an',
	'MCHAT_RELATIVE_TIME'			=> 'Zeige die relative Zeit für neue Nachrichten an',
	'MCHAT_RELATIVE_TIME_EXPLAIN'	=> 'Zeigt „gerade eben“, „vor einer Minute“ und so weiter für jede Nachricht an. Setze auf <em>Nein</em>, um immer das volle Datum zu sehen.',
	'MCHAT_MESSAGE_TOP'				=> 'Lokalisierung neuer Nachrichten',
	'MCHAT_MESSAGE_TOP_EXPLAIN'		=> 'Neue Nachrichten werden oben oder unten im Chat erscheinen.',
	'MCHAT_LOCATION'				=> 'Lokalisierung auf der Forenübersicht',
	'MCHAT_BOTTOM'					=> 'Unten',
	'MCHAT_TOP'						=> 'Oben',

	'MCHAT_POSTS_TOPIC'				=> 'Zeige neue Themen an',
	'MCHAT_POSTS_REPLY'				=> 'Zeige neue Antworten an',
	'MCHAT_POSTS_EDIT'				=> 'Zeige bearbeitete Beiträge an',
	'MCHAT_POSTS_QUOTE'				=> 'Zeige Zitatbeiträge an',
	'MCHAT_POSTS_LOGIN'				=> 'Zeige Benutzeranmeldungen an',	

	'MCHAT_DATE_FORMAT'				=> 'Datumsformat',
	'MCHAT_DATE_FORMAT_EXPLAIN'		=> 'Die verwendete Syntax ist identisch zur PHP <a href="http://www.php.net/date">date()</a> Funktion.',
	'MCHAT_CUSTOM_DATEFORMAT'		=> 'Eigenes…',
]);
