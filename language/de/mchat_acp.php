<?php

/**
* @version $Id: mchat_acp.php 187 2019-08-25 13:00:17Z Scanialady $
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
	// ACP configuration sections
	'MCHAT_SETTINGS_INDEX'							=> 'Einstellungen Index',
	'MCHAT_SETTINGS_CUSTOM'							=> 'Einstellungen separate Seite',
	'MCHAT_SETTINGS_ARCHIVE'						=> 'Einstellungen Archivseite',
	'MCHAT_SETTINGS_POSTS'							=> 'Einstellungen neuer Beitrag',
	'MCHAT_SETTINGS_MESSAGES'						=> 'Einstellungen Nachricht',
	'MCHAT_SETTINGS_PRUNE'							=> 'Einstellungen für Löschen (nur für Gründer einstellbar)',
	'MCHAT_SETTINGS_LOG'							=> 'Protokolleinstellungen (nur für Gründer einstellbar)',
	'MCHAT_SETTINGS_STATS'							=> 'Einstellungen für <em>Wer chattet</em>',

	'MCHAT_GLOBALUSERSETTINGS_EXPLAIN'				=> 'Einstellungen, für welche ein Benutzer <strong>KEINE</strong> Berechtigung zur Anpassung hat, werden angewendet wie unten eingestellt.<br />Neue Benutzerkonten werden die unten konfigurierten Starteinstellungen haben.<br /><br />Gehe zum <em>mChat im UCP</em>-Tab im Bereich Benutzerberechtigungen, um die Befugnisse zu einzustellen.<br />Gehe zum Formular <em>Voreinstellungen</em> im Bereich <em>Benutzer verwalten</em> um den Status der Einstellung eines jeden Benutzers zu sehen.',
	'MCHAT_GLOBALUSERSETTINGS_OVERWRITE'			=> 'Überschreibe Einstellungen für alle Benutzer',
	'MCHAT_GLOBALUSERSETTINGS_OVERWRITE_EXPLAIN'	=> 'Setzt die Einstellungen für <em>alle</em> Benutzerkonten wie oben definiert.',
	'MCHAT_GLOBALUSERSETTINGS_OVERWRITE_CONFIRM'	=> 'Bestätige überschreiben der mChat-Einstellungen für alle Benutzer',

	'MCHAT_ACP_USER_PREFS_EXPLAIN'					=> 'Unten sind alle mChat-Voreinstellungen der ausgewählten Benutzer aufgelistet. Einstellungen, für deren Anpassung die ausgewählten Benutzer keine Berechtigung haben, sind deaktiviert. Diese Einstellungen können geändert werden in der mChat Konfiguration <em>Globale Benutzereinstellungen</em>.',

	// ACP settings
	'MCHAT_ACP_CHARACTERS'							=> 'Zeichen',
	'MCHAT_ACP_MESSAGES'							=> 'Nachrichten',
	'MCHAT_ACP_SECONDS'								=> 'Sekunden',
	'MCHAT_ACP_HOURS'								=> 'Stunden',
	'MCHAT_ACP_DAYS'								=> 'Tage',
	'MCHAT_ACP_WEEKS'								=> 'Wochen',
	'MCHAT_ACP_GLOBALSETTINGS_TITLE'				=> 'mChat Globale Einstellungen',
	'MCHAT_ACP_GLOBALUSERSETTINGS_TITLE'			=> 'mChat Globale Benutzereinstellungen',
	'MCHAT_VERSION'									=> 'Version',
	'MCHAT_RULES'									=> 'Regeln',
	'MCHAT_RULES_EXPLAIN'							=> 'Gib deine Forenregeln hier ein. HTML-Code ist erlaubt. <em>Du bist dafür auf 255 Zeichen beschränkt.</em><br />Diese Nachricht kann übersetzt werden: bearbeite dafür die Sprachvariable MCHAT_RULES_MESSAGE in /ext/dmzx/mchat/language/XX/common.php.',
	'MCHAT_CONFIG_SAVED'							=> 'mChat-Konfiguration wurde aktualisiert',
	'MCHAT_AVATARS'									=> 'Avatare anzeigen',
	'MCHAT_AVATARS_EXPLAIN'							=> 'Wenn JA eingestellt ist, werden verkleinerte Benutzeravatare angezeigt.',
	'MCHAT_INDEX'									=> 'mChat auf dem Forenindex anzeigen',
	'MCHAT_INDEX_HEIGHT'							=> 'Seitenhöhe im Index',
	'MCHAT_INDEX_HEIGHT_EXPLAIN'					=> 'Die Höhe der Chat Box in Pixeln auf der Indexseite des Forums.<br><em>Die Einstellung ist begrenzt von 50 bis 1000 Pixel.</em>',
	'MCHAT_TOP_OF_FORUM'							=> 'Oben',
	'MCHAT_BOTTOM_OF_FORUM'							=> 'Unten',
	'MCHAT_REFRESH'									=> 'Aktualisierungsintervall',
	'MCHAT_REFRESH_EXPLAIN'							=> 'Die Anzahl Sekunden, bis die Nachrichten aktualisiert werden. <br><em>Die Einstellung ist begrenzt von 2 bis 3660 Sekunden. Standard ist 10.</em>',
	'MCHAT_LIVE_UPDATES'							=> 'Live-Aktualiserung von bearbeiteten und gelöschten Nachrichten',
	'MCHAT_LIVE_UPDATES_EXPLAIN'					=> 'Wenn ein Benutzer Nachrichten bearbeitet oder löscht, werden die Änderungen für alle live angezeigt, ohne dass sie die Seite aktualisieren müssen. Deaktiviere das, falls du Leistungsprobleme bekommst.',
	'MCHAT_PRUNE'									=> 'Aktiviere automatisches Leeren',
	'MCHAT_PRUNE_GC'								=> 'Intervall für Nachrichten-Löschaufgabe',
	'MCHAT_PRUNE_GC_EXPLAIN'						=> 'Die Zeit in Sekunden, die vergehen muss, ehe die nächste Löschung von Nachrichten ausgelöst wird. Hinweis: diese Einstellung steuert, <em>wann</em> Nachrichten geprüft werden, ob sie gelöscht werden können. Sie steuert <em>nicht</em>, <em>welche</em> Nachrichten gelöscht werden. <em>Standard ist 86400 Sekunden = 24 Stunden.</em>',
	'MCHAT_PRUNE_NUM'								=> 'Anzahl verbleibender Nachrichten nach dem Leeren',
	'MCHAT_PRUNE_NUM_EXPLAIN'						=> 'Verwende die Einstellung „Nachrichten“, um eine festgelegte Anzahl von Nachrichten zu behalten. Verwende „Stunden“, „Tage“ oder „Wochen“, und alle Nachrichten, die älter sind als die festgelegte Zeitperiode werden gelöscht.',
	'MCHAT_PRUNE_NOW'								=> 'Jetzt die Nachrichten löschen',
	'MCHAT_PRUNE_NOW_CONFIRM'						=> 'Löschen der Nachrichten bestätigen',
	'MCHAT_PRUNED'									=> '%1$d mChat Nachrichten wurden gelöscht.',
	'MCHAT_NAVBAR_LINK_COUNT'						=> 'Zeige die Anzahl der aktiven Chatsitzungen im Navbar-Link an',
	'MCHAT_MESSAGE_NUM_CUSTOM'						=> 'Anfängliche Anzahl von Nachrichten, die in der eigenen Chatseite angezeigt werden',
	'MCHAT_MESSAGE_NUM_CUSTOM_EXPLAIN'				=> '<em>Du bist eingeschränkt auf Einstellungen zwischen 5 und 50. Standard ist 10.</em>',
	'MCHAT_MESSAGE_NUM_INDEX'						=> 'Anfängliche Anzahl von Nachrichten, die auf der Indexseite angezeigt werden sollen',
	'MCHAT_MESSAGE_NUM_INDEX_EXPLAIN'				=> '<em>Du bist eingeschränkt auf Einstellungen zwischen 5 und 50. Standard ist 10.</em>',
	'MCHAT_MESSAGE_NUM_ARCHIVE'						=> 'Nachrichtenanzahl zur Anzeige auf der Archivseite',
	'MCHAT_MESSAGE_NUM_ARCHIVE_EXPLAIN'				=> 'Die maximale Anzahl an Nachrichten, die je Seite auf der Archivseite angezeigt werden sollen.<br><em>Du bist beschränkt auf Einstellungen zwischen 10 und 100. Standard ist 25.</em>',
	'MCHAT_ARCHIVE_SORT'							=> 'Nachrichten sortieren',
	'MCHAT_ARCHIVE_SORT_TOP_BOTTOM'					=> 'Sortiere Nachrichten immer von der ältesten zur neuesten',
	'MCHAT_ARCHIVE_SORT_BOTTOM_TOP'					=> 'Sortiere Nachrichten immer von der neuesten zur ältesten',
	'MCHAT_ARCHIVE_SORT_USER'						=> 'Nachrichtensortierung hängt ab von der Einstellung des Benutzers zu <em>Lokalisierung neuer Nachrichten</em>',
	'MCHAT_FLOOD_TIME'								=> 'Überflutungszeit',
	'MCHAT_FLOOD_TIME_EXPLAIN'						=> 'Die Zeit in Sekunden, die ein Benutzer warten muß, bis er eine neue Nachricht im mChat absenden kann.<br /><em>Begrenzt auf 0 bis 3600 Sekunden. Standard ist 0. Stelle 0 ein, um die Funktion zu deaktivieren</em>',
	'MCHAT_FLOOD_MESSAGES'							=> 'Überflutungs-Nachrichten',
	'MCHAT_FLOOD_MESSAGES_EXPLAIN'					=> 'Die anzahl der Nachrichten, welche ein Benutzer nacheinander senden kann, ehe erforderlich wird, dass ein anderer Benutzer im Chat postet.<br><em>Begrenzt auf 0 bis 100 Nachrichten. Standard ist 0. Stelle 0 ein, um die Funktion zu deaktivieren.</em>',
	'MCHAT_EDIT_DELETE_LIMIT'						=> 'Zeitbegrenzung für bearbeiten und löschen von Nachrichten',
	'MCHAT_EDIT_DELETE_LIMIT_EXPLAIN'				=> 'Nachrichten, die älter sind als die hier angegebene Anzahl Sekunden können nicht mehr durch den Verfasser bearbeitet oder gelöscht werden.<br />Benutzer mit <em>Berechtigung zum bearbeiten/löschen sowie mit Moderatorberechtigung sind ausgenommen</em> von dieser Begrenzung.<br />Um unbegrenzte Bearbeitung und Löschen zu erlauben, setze auf 0.',
	'MCHAT_MAX_MESSAGE_LENGTH'						=> 'Maximale Nachrichtenlänge',
	'MCHAT_MAX_MESSAGE_LENGTH_EXPLAIN'				=> 'Die maximal erlaubte Anzahl von Zeichen pro Nachricht.<br /><em>Dies ist begrenzt von 0 bis 1000. Standard ist 500. Stelle 0 ein, um die Funktion zu deaktivieren.</em>.',
	'MCHAT_MAX_INPUT_HEIGHT'						=> 'Maximale Höhe des Eingabefeldes',
	'MCHAT_MAX_INPUT_HEIGHT_EXPLAIN'				=> 'Das Eingabefeld wird nicht größer als diese Anzahl an Pixeln. <br><em>Dies ist begrenzt von 0 bis 1000. Standard ist 150. Stelle 0 ein, um mehrzeilige Nachrichten nicht zuzulassen.</em>',
	'MCHAT_CUSTOM_PAGE'								=> 'Aktiviere mChat-Seite',
	'MCHAT_CUSTOM_HEIGHT'							=> 'Höhe der separaten mChat-Seite',
	'MCHAT_CUSTOM_HEIGHT_EXPLAIN'					=> 'Die Höhe der Chat-Box in Pixeln auf der eigenen mChat Seite.<br><em>Die Einstellung ist begrenzt von 50 bis 1000 Pixel. Standard ist 350.</em>.',
	'MCHAT_BBCODES_DISALLOWED'						=> 'Nicht erlaubte BBCodes',
	'MCHAT_BBCODES_DISALLOWED_EXPLAIN'				=> 'Hier kann man BBCodes eintragen, die <strong>nicht</strong> in einer Nachricht verwendet werden dürfen.<br />Trenne BBCodes mit einem senkrechten Strich (pipe), zum Beispiel: <br />b|i|u|code|list|list=|flash|quote und/oder einem %1$scustom bbcode tag name%2$s',
	'MCHAT_STATIC_MESSAGE'							=> 'Permanente Nachricht',
	'MCHAT_STATIC_MESSAGE_EXPLAIN'					=> 'Hier kannst du eine permanente Nachricht für die Benutzer des mChats eingeben. HTML-Code ist erlaubt.<br />Wenn das Feld leer bleibt wird keine Nachricht angezeigt. <em>Die Nachricht kann maximal 255 Zeichen beinhalten.</em><br />Diese Nachricht kann auch übersetzt werden: bearbeite dafür die Sprachvariable MCHAT_STATIC_MESSAGE in /ext/dmzx/mchat/language/XX/common.php.',
	'MCHAT_TIMEOUT'									=> 'Ablauf der Benutzersitzung',
	'MCHAT_TIMEOUT_EXPLAIN'							=> 'Stelle einen Wert für die Zeit in Sekunden ein, nach der die Sitzung für einen Benutzer im mChat endet. Setze hier 0 für kein Timeout. Achtung - für einen Benutzer, der im mChat liest, endet dann die Sitzung nie! <br /><em>Diese Einstellung ist eingeschränkt durch die Einstellungen in deiner %1$sForenkonfiguration für Sitzungen%2$s, welche derzeit auf %3$d Sekunden eingestellt ist.</em>',
	'MCHAT_OVERRIDE_SMILIE_LIMIT'					=> 'Smilielimit überschreiben?',
	'MCHAT_OVERRIDE_SMILIE_LIMIT_EXPLAIN'			=> 'Setze auf Ja um die Smiliebegrenzung des Forums für Chatnachrichten zu überschreiben',
	'MCHAT_OVERRIDE_MIN_POST_CHARS'					=> 'Minimale Anzahl von Zeichen überschreiben?',
	'MCHAT_OVERRIDE_MIN_POST_CHARS_EXPLAIN'			=> 'Setze auf Ja um die Forumseinstellung für die minimale Anzahl von Zeichen für Chatnachrichten zu überschreiben',
	'MCHAT_LOG_ENABLED'								=> 'Füge Einträge zum Administratorprotokoll hinzu',
	'MCHAT_LOG_ENABLED_EXPLAIN'						=> 'Dies wirkt sich aus auf Bearbeitung, Löschung, Leerung, Verkürzung und Säuberung von Nachrichten.',

	'MCHAT_POSTS_AUTH_CHECK'						=> 'Erfordert Benutzerberechtigung',
	'MCHAT_POSTS_AUTH_CHECK_EXPLAIN'				=> 'Wenn dies auf Ja gesetzt wird, werden Benutzer, die keine Berechtigung für die Benutzung von mChat haben, auch keine Beitrags- oder Loginbenachrichtigungen auslösen.',

	'MCHAT_WHOIS_REFRESH'							=> '„Wer chattet“ Aktualisierungsintervall',
	'MCHAT_WHOIS_REFRESH_EXPLAIN'					=> 'Anzahl der Sekunden, ehe „Wer chattet“ aktualisiert.<br /><em>Du bist beschränkt auf Einstellungen von 10 bis 300 Sekunden. Standard ist 60.</em>',
	'MCHAT_SOUND'									=> 'Töne abspielen bei neuen, bearbeiteten und gelöschten Nachrichten',
	'MCHAT_PURGE'									=> 'Lösche jetzt alle Nachrichten',
	'MCHAT_PURGE_CONFIRM'							=> 'Bestätige die Löschung aller Nachrichten',
	'MCHAT_PURGED'									=> 'Alle mChat Nachrichten wurden erfolgreich gelöscht',

	'MCHAT_REPARSER_STATUS'							=> 'Nachrichten Reparser Status',
	'MCHAT_REPARSER_ACTIVE'							=> 'Aktiv',
	'MCHAT_REPARSER_FINISHED'						=> 'Beendet',

	// '%1$s' enthält 'Beiträge behalten' bzw. 'Beiträge löschen'
	'MCHAT_RETAIN_MESSAGES'							=> '%1$s und behalte mChat-Nachrichten',
	'MCHAT_DELETE_MESSAGES'							=> '%1$s und lösche mChat-Nachrichten',

	// Error reporting
	'TOO_LONG_MCHAT_BBCODE_DISALLOWED'				=> 'Der Wert für nicht erlaubte BBCodes ist zu lang.',
	'TOO_SMALL_MCHAT_CUSTOM_HEIGHT'					=> 'Der Wert für die Höhe der mChat-Seite ist zu klein.',
	'TOO_LARGE_MCHAT_CUSTOM_HEIGHT'					=> 'Der Wert für die Höhe der mChat-Seite ist zu groß.',
	'TOO_LONG_MCHAT_DATE'							=> 'Das eingegebene Datumsformat ist zu lang.',
	'TOO_SHORT_MCHAT_DATE'							=> 'Das eingegebene Datumsformat ist zu kurz.',
	'TOO_LARGE_MCHAT_FLOOD_TIME'					=> 'Der Wert für die Flood-Zeit ist zu groß.',
	'TOO_LARGE_MCHAT_FLOOD_MESSAGES'				=> 'Der Wert für die Flood-Nachrichten ist zu groß.',
	'TOO_SMALL_MCHAT_INDEX_HEIGHT'					=> 'Der Wert für die Höhe im Index ist zu klein.',
	'TOO_LARGE_MCHAT_INDEX_HEIGHT'					=> 'Der Wert für die Höhe im Index ist zu groß.',
	'TOO_LARGE_MCHAT_MAX_INPUT_HEIGHT'				=> 'Der Wert für die maximale Höhe des Eingabefeldes ist zu groß.',
	'TOO_SMALL_MCHAT_MESSAGE_NUM_ARCHIVE'			=> 'Die Anzahl der Nachrichten für die Anzeige auf der Archivseite ist zu klein.',
	'TOO_LARGE_MCHAT_MESSAGE_NUM_ARCHIVE'			=> 'Die Anzahl der Nachrichten für die Anzeige auf der Archivseite ist zu groß.',
	'TOO_SMALL_MCHAT_REFRESH'						=> 'Der Wert für die Aktualisierung ist zu klein.',
	'TOO_LARGE_MCHAT_REFRESH'						=> 'Der Wert für die Aktualisierung ist zu groß.',
	'TOO_SMALL_MCHAT_TIMEOUT'						=> 'Der Timeout-Wert für Benutzer ist zu klein.',
	'TOO_LARGE_MCHAT_TIMEOUT'						=> 'Der Timeout-Wert für Benutzer ist zu groß.',
	'TOO_SMALL_MCHAT_WHOIS_REFRESH'					=> 'Der Wert für <em>Wer chattet</em> ist zu klein.',
	'TOO_LARGE_MCHAT_WHOIS_REFRESH'					=> 'Der Wert für <em>Wer chattet</em> ist zu groß.',

	'MCHAT_30X_REMNANTS'							=> 'Die Installation wurde abgebrochen. <br />Es befinden sich übriggebliebene Module des mChat MOD für phpBB 3.0.x in der Datenbank. Die mChat Extension funktioniert nicht korrekt, wenn diese Module vorhanden sind.<br />Du musst unbedingt den mChat MOD vollständig deinstallieren, damit es möglich ist, die mChat Extension zu installieren. Besonders die Module mit den folgenden IDs müssen gelöscht werden aus der %1$smodules Tabelle: %2$s',
]);
