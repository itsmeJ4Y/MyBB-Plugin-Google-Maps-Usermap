<?php
/***************************************************************************
 *
 * Usermap-System für MyBB
 * Copyright: © 2008-2013 Online - Urbanus / Website: http://www.Online-Urbanus.be
 *
 * Copyright: © 2016 Jockl
 * http://forum.mybboard.de/user-2693.html
 * Copyright: © 2019 itsmeyJAY - Version 1.4.5
 * http://forum.mybb.de/user-10220.html
 *
 * Übersetzt in Deutsch: 27.10.2009 von BeeJayZZZR http://www.zzr-forum.de
 * (Übersetzung modifiziert nach UTF8 - ohne Stückliste von Jockl)
 * Übersetzung modifiziert: 12.04.2019 für Version 1.4.5 von Gerti & Schnapsnase https://mybb.de
 *
 ***************************************************************************/

/***************************************************************************
 *
 * Dieses Programm basiert auf dem GPLed-Mod namens "skunkmap" Version 1.1 hergestellt vom King Butter
 * NCAAbbs SkunkWorks Team <http://www.ncaabbs.com>, der am 22. Mai 2007 auf der MyBB Mods-Seite veröffentlicht wurde 
 *
 * Also, ich besonderer Dank an den/die Hersteller dieses Plugins!
 *
 ***************************************************************************/

/***************************************************************************
 *
 * Dieses Programm ist freie Software: Du kannst es weitergeben und/oder ändern.
 * es unter den Bedingungen der GNU General Public License, wie sie von der Firma
 * die Free Software Foundation, entweder Version 3 der Lizenz, oder
 * (nach Ihrer Wahl) jede spätere Version.
 *
 * Dieses Programm wird in der Hoffnung verteilt, dass es nützlich sein wird,
 * aber OHNE JEGLICHE GARANTIE; auch ohne die implizite Garantie von
 * MARKTFÄHIGKEIT oder Tauglichkeit für einen bestimmten Zweck. Siehe die
 * GNU General Public License für weitere Details.
 *
 * Du solltest zusammen mit diesem Programm eine Kopie der GNU General Public License erhalten haben.
 * Wenn nicht, siehe <http://www.gnu.org/licenses/>.
 *
 ***************************************************************************/

$l['usermap'] = "Benutzerkarte";
$l['save'] = "Speichern";

$l['can_manage_usermap'] = "Kann Benutzerkarte bearbeiten";

$l['can_view_usermap'] = "Kann Benutzerkarte sehen?";
$l['can_add_usermap_pin'] = "Kann eine PIN in Benutzerkarte erstellen?";

$l['admin_log_config_usermap_add_place'] = "Erstellte Landkarten #{1} ({2})";
$l['admin_log_config_usermap_edit_place'] = "Geänderte Benutzer-Orte #{1} ({2})";
$l['admin_log_config_usermap_delete_place'] = "Gelöschte Benutzerorte #{1} ({2})";
$l['admin_log_config_usermap_order_places'] = "Sortierte Benutzer-Orte";

$l['admin_log_config_usermap_add_pinimg'] = "Erstelltes PIN-Bild #{1} ({2})";
$l['admin_log_config_usermap_edit_pinimg'] = "Geändertes PIN-Bild #{1} ({2})";
$l['admin_log_config_usermap_delete_pinimg'] = "Gelöschtes PIN-Bild #{1} ({2})";

$l['nav_manage_places'] = "Bearbeite Landkarte";
$l['nav_add_place'] = "Erstelle Landkarte";
$l['nav_edit_place'] = "Ändere Landkarte";
$l['nav_manage_pinimgs'] = "Bearbeite PIN-Bilder";
$l['nav_add_pinimg'] = "Erstelle PIN-Bild";
$l['nav_edit_pinimg'] = "Ändere PIN-Bild";

$l['nav_manage_places_desc'] = "Hier kannst du die Benutzerkarten-Orte in Deinem Forum bearbeiten.";
$l['nav_add_place_desc'] = "Hier kannst du einen Benutzerkarten-Ort/Platz erstellen.";
$l['nav_edit_place_desc'] = "Hier kannst du einen Benutzerkarten-Ort/Platz ändern.";
$l['nav_manage_pinimgs_desc'] = "Hier kannst du die Benutzerkarten-PIN-Bilder in Deinem Forum bearbeiten.";
$l['nav_add_pinimg_desc'] = "Hier kannst du ein Benutzerkarten-PIN-Bild hinzufügen.";
$l['nav_edit_pinimg_desc'] = "Hier kannst du ein Benutzerkarten-PIN-Bild bearbeiten.";

$l['places'] = "Karten";
$l['order'] = "Sortieren";
$l['save_order'] = "Sortierung speichern";
$l['no_places'] = "Es gibt keine Karten.";

$l['place_name'] = "Kartenname";
$l['place_lat'] = "Breitengrad (Latitude)";
$l['place_lon'] = "Längengrad (Longitude)";
$l['place_zoom'] = "Zoomfaktor";
$l['place_displayorder'] = "Anzeigesortierung";
$l['place_default'] = "Standardkarte";

$l['error_missing_name'] = "Kein Name für diesen Ort/Platz angegeben";
$l['error_missing_lat'] = "Kein Breitengrad (latitude) für diesen Orte/Platz angegeben";
$l['error_missing_lon'] = "Kein Längengrad (longitude) für diesen Ort/Platz angegeben";
$l['error_missing_zoom'] = "Kein Zoomfaktor für diesen Ort/Platz angegeben";
$l['error_missing_displayorder'] = "Keine Anzeigereihenfolge für diesen Ort/Platz angegeben";
$l['error_missing_default'] = "Keine Voreinstellung für diesen Ort/Platz angegeben";
$l['error_missing_order'] = "Keine Reihenfolge- bzw. Sortierungs-Information angegeben";
$l['placedoesntexist'] = "Der gewählte Ort/Platz existiert nicht.";

$l['delete_place_confirmation'] = "Möchtest du den Ort wirklich löschen?";

$l['added_place'] = "Der Ort/Platz wurde erfolgreich hinzugefügt.";
$l['edited_place'] = "Der Ort/Platz wurde erfolgreich bearbeitet.";
$l['deleted_place'] = "Der Ort/Platz wurde erfolgreich gelöscht.";
$l['ordered_places'] = "Die Anzeigereihenfolge der Orte/Plätze wurde erfolgreich geändert.";

$l['pinimgs'] = "PIN-Bilder";
$l['no_pinimgs'] = "Es existieren keine PIN-Bilder.";

$l['pinimg_name'] = "Name PIN-Bild";
$l['pinimg_file'] = "PIN-Bild";
$l['pinimg_default'] = "Voreingestelltes PIN-Bild";

$l['error_missing_pinimg_name'] = "Es wurde kein Name für das PIN-Bild angegeben";
$l['error_missing_pinimg_file'] = "Es wurde kein PIN-Bild zur Benutzung hochgeladen.";
$l['error_missing_pinimg_default'] = "Es wurde kein PIN-Bild zur Voreinstellung ausgewählt.";
$l['not_writable'] = "Dem Verzeichnis fehlen die Schreibrechte CHMOD 777:<br />\n{1}";
$l['error_uploadfailed'] = "Fehler beim hochladen des Bildes aufgetreten.";
$l['pinimgdoesntexist'] = "Ausgewähltes PIN-Bild nicht gefunden.";

$l['delete_pinimg_confirmation'] = "Möchtest du das PIN-Bild wirklich löschen?";

$l['added_pinimg'] = "Das PIN-Bild wurde erfolgreich hinzugefügt.";
$l['edited_pinimg'] = "Das PIN-Bild wurde erfolgreich bearbeitet.";
$l['deleted_pinimg'] = "Das PIN-Bild wurde erfolgreich gelöscht.";

$l['usermap_plugin_desc'] = "Fügt Ihrem MyBB Forum eine Google-Map hinzu. User können hier einen PIN für Ihren Wohnsitz einstellen.<br /><i>Unterstützung von <a href=\"https://www.mybb.de/forum/user-2693.html\" target=\"_blank\" rel=\"noopener\">Jockl</a> (bis V 1.4.4)</i>. <br /><i>Unterstützung von <a href=\"//https://www.mybb.de/forum/user-10220.html\" target=\"_blank\" rel=\"noopener\">itsmeJAY</a> (ab V 1.4.5)</i>";
$l['usermap_plugin_link'] = "https://www.mybboard.de/erweiterungen/18x/plugins-neueseiten/usermap2/";

$l['setting_group_usermap'] = "Usermap Optionen";
$l['setting_group_usermap_desc'] = "Hier findest Du die Einstellungen, um das Usermap-Plugin zu konfigurieren. Bei Fragen zum benötigen API-Schlüssel bitte die im ACP angegebenen Links verwenden bzw. im MyBB-Forum \"https://mybb.de\" fragen.";

$l['setting_usermap_apikey'] = "API-Schlüssel für \"Maps JavaScript\"";
$l['setting_usermap_apikey_desc'] = "Nachstehend den benötigten API-Schlüssel für das Maps Javascript <i>(Darstellung der interaktiven Karte)</i>, welchen Du in einem Google-Maps-Konto generieren musst, eintragen..<br /><b>Wichtig:</b> Soweit noch nicht vorhanden, musst Du bei Google ein <a href=\"https://tinyurl.com/y48cdkow\" target=\"_blank\" rel=\"noopener\">Konto</a> einrichten. Der monatliche <a href=\"https://tinyurl.com/y3p9zps5\" target=\"_blank\" rel=\"noopener\">Freibetrag</a> <i>(Stand: 04/2019)</i> reicht für ein MyBB-Forum vollkommen aus.<br /><b>Hinweis:</b> Gebe in Deinem Google-Maps-Konto <i>(unter API-Einschränkung)</i> nur den/die Schlüsseln die API-Einschränkungen:<br />\"Maps JavaScript API\", \"Geocoding API\", \"Places API\", \"Maps Elevation API\" und \"Maps Embed API\" frei. Alle Informationen zum Bezug eines API-Schlüssels findest Du <a href=\"https://cloud.google.com/maps-platform/maps/?hl=de\" target=\"_blank\" rel=\"noopener\">\"hier\"</a> und <a href=\"https://agentur-blueline.de/blog/google-maps-api-key-anleitung\" target=\"_blank\" rel=\"noopener\">hier</a>";

$l['setting_usermap_apikeytwo'] = "API-Schlüssel für \"Geocoding\"";
$l['setting_usermap_apikeytwo_desc'] = "Nachstehend den Schlüssel für Geocoding <i>(Umwandlung von Adressen in geografische Koordinaten oder umgekehrt > erforderlich um einen Marker bzw. PIN in der Karte zu setzen)</i> eintragen.<br /><b>Tipp:</b> Manchmal kann es ausreichend sein, den vorstehenden Schlüssel <i>(aus Maps JavaScript)</i> einzutragen. Wenn es nicht funktioniert sollte, musst Du einen gesonderte Schlüssel in Deinem GoogleMaps-Konto generieren.";

$l['setting_usermap_apikeythree'] = "API-Schlüssel für \"Elevation\"";
$l['setting_usermap_apikeythree_desc'] = "Nachstehend <i>(bei Bedarf)</i> den erforderlichen API-Schlüssel für Elevation <i>(um die Höhendaten definierter Standorte abzufragen)</i> eintragen. Den Schlüssel musst Du in Deinem GoogleMaps-Konto generieren.<br /><b>Tipp:</b> Manchmal kann es ausreichend sein, einen der vorstehenden Schlüssel <i>(aus Maps JavaScript oder Geocoding)</i> einzutragen. Wenn es nicht funktionieren sollte, musst Du einen gesonderte Schlüssel in Deinem GoogleMaps-Konto generieren.";

$l['setting_usermap_width'] = "Breite der Usermap";
$l['setting_usermap_width_desc'] = "Passe die Breite der Usermap an. Die Einheit ist Pixel";

$l['setting_usermap_height'] = "Höhe der Usermap";
$l['setting_usermap_height_desc'] = "Passe die Höhe der Usermap an. Die Einheit ist Pixel";

$l['setting_usermap_profile'] = "Zeige Usermap PIN im User-Profil";
$l['setting_usermap_profile_desc'] = "Zeigt im User-Profil eines Users einen Link zum Usermap-PIN, wenn aktiviert. Wird Gästen nicht angezeigt.";

$l['setting_usermap_postbit'] = "Link zum Usermap-Pin im Postbit";
$l['setting_usermap_postbit_desc'] = "Zeigt im Postbit eines Users einen Link zum Usermap-PIN, wenn aktiviert. Wird Gästen nicht angezeigt.";

$l['setting_usermap_count_pins'] = "Zeige, wie viel User einen PIN in der Usermap gesetzt haben";
$l['setting_usermap_count_pins_desc'] = "Wird in der Usermap angezeigt, wenn mindestens ein User-PIN vorhanden ist. Wird Gästen nicht angezeigt.";

$l['setting_usermap_elevation'] = "Höhe des User-Wohnortes";
$l['setting_usermap_elevation_desc'] = "Wird unterhalb des Avatars in der Usermap angezeigt, wenn aktiviert. Nicht verfügbar für die sog. <i>zusätzlichen Plätze</i> (siehe unten)";

$l['setting_usermap_elevation_unit'] = "Maßeinheit der Höhe";
$l['setting_usermap_elevation_unit_desc'] = "wähle zwischen 'Meter' und 'Feet' (Fuß)";

$l['setting_usermap_add_places_yesno'] = "Möchtest Du der Usermap sogenannte \"zusätzliche Orte/Plätze\" von besonderem Interesse hinzufügen?";
$l['setting_usermap_add_places_yesno_desc'] = "Wenn gewünscht, kannst Du diese im nachfolgendem Textfeld eintragen.";

$l['setting_usermap_add_places'] = "Füge zusätzliche Orte/Plätze von besonderem Interesse der Usermap hinzu";
$l['setting_usermap_add_places_desc'] = "Füge die Orte/Plätze, wie nachstehend erläutert, hinzu und verwende für jeden Ort/Platz eine neue Zeile (siehe Beispiele im Textfeld).<br />
<br />
Achte bitte darauf nur folgendes Format zu verwenden: <strong>[Name des Ortes/Plates, Latitude-Wert, Longitude-Wert, z-index]</strong><br />
<ul><li><strong>Name des Ortes/Platzes:</strong> String. Du kannst HTML, CSS, URLs und img-tags verwennden (siehe u.a. Beispiele)</li>
<li><strong>Latitude-value:</strong> float-Zahl (wie man sie von Goolge-Maps gemeldet bekommt)</li>
<li><strong>Longitude-value:</strong> float-Zahl (wie man sie von Goolge-Maps gemeldet bekommt)</li>
<li><strong>z-index:</strong> Integer-Zahl (z-index wird benötigt, wenn man PINs hat, die auf der Usermap sehr eng zusammen liegen. Der z-index gibt dann die Tiefenreihenfolge der PINs an.)</li>
<li>Solltest Du die Höhenlage der/des Orte/s / Platzes anzeigen wollen, musst Du diese/n selbst ermitteln und den Wert bei <strong>Name des Ortes/Platzes</strong> hinzufügen.</li></ul>";
$l['setting_usermap_add_places_guests'] = "Zeige die sogenannten \"zusätzlichen Orte/Plätze\" den Gästen?";
$l['setting_usermap_add_places_guests_desc'] = "Wenn nicht, können Gäste die zusätzlichen Orte/Plätze nicht sehen.";

$l['setting_usermap_add_places_icon'] = "Möchtest Du als PIN für die zusätzlichen Orte/Plätze das Google-Maps Info Icon verwenden?";
$l['setting_usermap_add_places_icon_desc'] = "Wenn nicht, kannst Du nachfolgend ein eigenes PIN-Bild für diese Orte/Plätze verwenden.";

$l['setting_usermap_add_places_icon_own'] = "Hier kannst Du den Dateinamen des eigenen PIN-Bildes für die zusätzlichen Orte/Plätze angeben";
$l['setting_usermap_add_places_icon_own_desc'] = "Setze den Namen des Bildes in die folgende Zeile eine. Das PNG-File muss im Verzeichnis: \"./images/pinimgs/\" zur Verfügung stehen.";
?>