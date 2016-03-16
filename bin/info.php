<?php
// rd2 - url shortener under your control
// Copyright (C) 2016  Sven Krug sven-krug@gmx.de
//
// This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 3 of the License.
//
// This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>.
?>
<?php
$devchangelog="";
$devchangelog=$devchangelog."0.10.0 (07.03.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-03-07 + Einträge - Suche auf Besitzer erweitert"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-03-07 + Einstellungen - Änderung des Login-Passwort ist nicht mehr ohne Kenntnis des aktuellen Passwort möglich"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-03-07 + Konfiguration - maximal erlaubte Länge für Bemerkungen lässt sich festlegen (1-65535, Standard 1024 Zeichen)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-03-07 + Nutzer - Passwörter der Nutzer lassen sich neu setzen"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-03-05 + Einträge - Sortiermöglichkeiten für Einträge auf alle Spalten erweitert"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-03-05 + fix: Einträge - Bemerkungen werden nun korrekt durchsucht. - Dadurch werden bereits gepeicherte Bemerkungen nicht mehr direkt lesbar angezeigt. Es handelt sich bei dem angezeiten Text um das base64-Format und kann entsprechend umgewandelt werden."."<br />";
$devchangelog=$devchangelog."&nbsp;"."<br />";
$devchangelog=$devchangelog."0.9.3 (02.03.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-03-02 + Einträge - Sortiermöglichkeiten hinzugefügt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-28 + Einstellungen - eigenen Prefix redirect für Nutzer entfernt"."<br />";
$devchangelog=$devchangelog."&nbsp;"."<br />";
$devchangelog=$devchangelog."0.9.2 (26.02.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-25 + Einträge - um Bemerkungen erweitert"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-24 + Sprachunterstützung - erweitert (Login, Update, Reset, Nutzer anlegen, Rück- und Zwischenmeldungen)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-24 + fix: Konfiguration - Versionsvergleich beim Update"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-21 + Sprachunterstützung - erweitert (Dateien, Nutzer, Konfiguration, Logs)"."<br />";
$devchangelog=$devchangelog."&nbsp;"."<br />";
$devchangelog=$devchangelog."0.9.1 (18.02.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-18 + fix: Konfiguration - Update-Prozess (Dateien wurden unter bestimmten Vorraussetzungen nicht ersetzt)"."<br />";
$devchangelog=$devchangelog."&nbsp;"."<br />";
$devchangelog=$devchangelog."0.9.0 (18.02.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-17 + Konfiguration - Gültigkeitsdauer Verifikations-Code und maximale Länge der Kurzform können angepasst werden"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-17 + Einträge - Suchmöglichkeit hinzugefügt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-14 + Konfiguration - Kurzform auf Standard 255 Zeichen gesetzt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-14 + Konfiguration - Gültigkeitsdauer Verifikations-Code für neue Nutzer auf Standard 10 Minuten gesetzt"."<br />";
$devchangelog=$devchangelog."<br />0.8.5 (14.02.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-14 + Konfiguration - Updateprozedur abgeändert (unabhängiger von Server-/Webspace-Konfiguration)"."<br />";
$devchangelog=$devchangelog."<br />0.8.4 (13.02.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-13 + Sprachunterstützung - erweitert (Einstellungen, Info, Sicherungen)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-13 + Sprachunterstützung - nun robust gegen fehlende Übersetzungen (uA durch fallback)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-13 + fix: Einträge - langer Link in der Content-Tabelle"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-13 + fix: Sprachunterstützung - keine Sprache bei ungültiger Random ID"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-13 + fix: Konfiguration - Versionsvergleich beim Update"."<br />";
$devchangelog=$devchangelog."<br />0.8.3 (11.02.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-11 + header 301"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-10 + Sprachunterstützung - erweitert (Eintrag hinzufügen und bearbeiten sowie Tabelle)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-10 + Versionierung angepasst"."<br />";
$devchangelog=$devchangelog."<br />Alpha 0.8.2.0 (09.02.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-09 + Update-Funktion hinzugefügt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-06 + Es wurde '?redirect=' durch '?rd=' ersetzt"."<br />";
$devchangelog=$devchangelog."<br />Alpha 0.8.1.0 (05.02.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-05 + alle Rückmeldungen wurden durch ".
                                                           "<font style=\"color: ".$colorwasGOOD."\">&#10004;</font>".
                                                      " und <font style=\"color: ".$colorwasBAD."\">&#10008;</font>".
                                                      " ergänzt und farbiger Text wurde ersetzt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-05 + Sprachunterstützung hinzugefügt (wird bereits auf das Menü angewendet)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-04 + nach GPL v3 angepasst"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-04 + Lang wird auf Format geprüft. Bei fehlendem Protokoll wird http gesetzt."."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-04 + optionale Nachricht auf der ersten Seite hinzugefügt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-04 + Infotext rechts neben Menü optional anpassbar"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-03 + Protokoll-Auswahl für Prefix redirect unter Config"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-03 + fix: Anzeige diverser Prefix redirect"."<br />";
$devchangelog=$devchangelog."<br />Alpha 0.8.0.0 (03.02.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-03 + globale Konfiguration unter 'Config' möglich"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-03 + Nutzung auch ohne Login/Anmeldung möglich."."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-03 + rd2prefix hinzugefügt"."<br />";
$devchangelog=$devchangelog."<br />Alpha 0.7.0.0 (02.02.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-01 + Nutzer mit Admin-Rechten können Besitzer eines Eintrages ändern"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-01 + Logeinträge können nun auch einzeln entfernt werden"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-01 + bei ungültigen Content-Eingaben werden die Felder nicht mehr geleert"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-02-01 + bei Erzeugung eines Verifikations-Codes (Nutzer anlegen) werden Codes älter 10 Minuten entfernt und sind somit ungültig"."<br />";
$devchangelog=$devchangelog."<br />Alpha 0.6.0.0 (01.02.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-31 + Verifikations-System für neue Nutzer hinzugefügt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-31 + Prüfung auf Systemvorraussetzungen hinzugefügt"."<br />";
$devchangelog=$devchangelog."<br />Alpha 0.5.0.0 (31.01.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-30 + Der Nutzer kann sich unter Settings eine neue Random ID erzeugen und nutzen."."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-30 + Einmal genutze Random ID für Nutzer werden nicht erneut erzeugt."."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-30 + Bereits verwendete zufällig erzeugte 'Kurz'-Inhalte werden nicht erneut erzeugt."."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-30 + Logeinträge lassen sich entfernen (alle)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-30 + Passwortwiederholung bei Anmeldung erforderlich"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-30 + fix: Umstellung der Minuten bei AutoLogout (von 0 auf größer) führt nicht mehr zu einem Logout"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-30 + fix: die Anzeige von Anmeldung führt nun keinen \"Leerversuch\" mehr durch"."<br />";
$devchangelog=$devchangelog."<br />Alpha 0.4.0.0 (30.01.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-29 + Logs hinzugefügt (nur unbekannter, gesperrter oder fehlerhafter Login sowie ungültige Anmeldeversuche werden erfasst)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-29 + Backups erhalten nun ein zusätzliche Kennung, ob sie manuell (_man) oder durch AutoBackup (_auto) erstellt wurden"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-29 + AutoBackup bei Logout ist für neue Nutzer nun standard deaktiviert"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-29 + AutoBackup bei Logout kann nun über die Nutzerverwaltung einzeln de-/aktiviert werden"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-29 + fix: AutoBackup bei Logout wurde unabhängig der Einstellungen erstellt"."<br />";
$devchangelog=$devchangelog."<br />Alpha 0.3.0.0 (28.01.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-27 + Multi-Nutzer-System hinzugefügt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-27 + AutoLogout nach x Minuten ist deaktivierbar"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-27 + AutoLogout bei Login von einer anderen IP-Adresse hinzugefügt (deaktivierbar)"."<br />";
$devchangelog=$devchangelog."<br />Alpha 0.2.0.0 (23.01.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-23 + Login ist an IP geknüpft (erneuter Login bei Wechsel erforderlich)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-23 + Prefix redirect hinzugefügt (Settings und Content)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-23 + Inhalt der Eingabemasken in Content bleiben auch bei Fehler (vorhanden/leer) erhalten"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-23 + Backups können gelöscht werden"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-23 + optische Gesamterscheinung durch kleinere Schrift geändert"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-23 + public wurde entfernt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-22 + auch .htaccess wird unter Files gelistet"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-22 + fix: falsches Datum (Spalte gespeichert) unter Files wenn noch nicht gespeichert"."<br />";
$devchangelog=$devchangelog."<br />Alpha 0.1.0.0 (22.01.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-22 + Abbruch und Meldung, falls Kurz leer, Eintrag bereits vorhanden oder Ablaufdatum ungültig ist"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-22 + abgelaufene (expire) Eintr&auml;ge in Content werden rot markiert"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-22 + es erfolgt keine Weiterleitung, wenn der Eintrag abgelaufen ist"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-22 + Eingabe Ablaufdatum in EU/EN-Format möglich"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-22 + Backups werden sortiert angezeigt (aktuellste oben)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-22 + Files werden sortiert angezeigt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-22 + Anzeige der sha1-Pr&uuml;fsumme unter Backups"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-22 + jedes angezeigte Datum Format angepasst"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-22 + komplette Ausgaben als UTF-8"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-21 + Abspeichern und Abgleich Files verf&uuml;gbar"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-20 + Settings hinzugef&uuml;gt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-20 + unter Settings kann AutoLogout-Timeout festgelegt werden"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-20 + unter Settings kann autom. Backup bei Logout de-/aktiviert werden"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-20 + Backups k&ouml;nnen heruntergeladen werden"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-20 + Content wird alphabetisch sortiert nach short angezeigt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-20 + Passwort setzen und Reset sind nun &uuml;ber Settings verf&uuml;gbar"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-20 + R&uuml;ckinfo, wenn Content entfernt wurde"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-20 + fix: Content wurde nicht entfernt"."<br />";
$devchangelog=$devchangelog."<br />Alpha 0.0.1.0 (19.01.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-19 + Login-Passwort kann ge&auml;ndert werden"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-19 + unter Files werden '.htaccess' nicht mehr angezeigt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-19 + bei einem Reset wird '.htaccess' nicht mehr entfernt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-18 + Komplette Neustrukturierung auf POST-only-Basis"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-18 + Alle Dateien (bisauf die index.php) befinden nun in Unterverzeichnissen. (Schutz durch .htaccess m&ouml;glich)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-18 + Optische Umstellung auf Button- statt Link-Optik-Element"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-18 + Automatische Abmeldung bei Inaktivit&auml;t."."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-18 + Anzeige, wenn Passwort beim Login falsch ist"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-18 + R&uuml;ckinfo, ob Backup erfolgreich war"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-18 + Hinweis und Umleitung auf Passwort-Seite, wenn noch kein Passwort gesetzt ist."."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-18 + unter Files werden 'rd2.config*' nicht mehr angezeigt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-17 + Reset mit Button und Checkbox statt \"Link-Dialog\"."."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-17 + Abbruch statt Passwortabfrage, wenn redirect nicht bekannt"."<br />";
$devchangelog=$devchangelog."<br />Alpha 0.0.0.1 (17.01.2016)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-17 + '?redirect=' hinzugef&uuml;gt (inkl. passwd)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-17 + Backup hinzugefuegt (auto-Backup bei Logout; Uebersicht und manuelles Backup im Menue;)"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-17 + Content (Tabelle und edit) zeigt redirectlink"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-17 + Log entfernt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-17 + 1000er-Trennzeichen unter Files"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-16 + interne Speicherung auf SQLite 3 umgestellt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-15 + Eintrag bearbeiten: Felder werden mit bereits vorhandenen Werten gef&uuml;llt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-15 + Log hinzugefuegt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-15 + Files hinzugefuegt"."<br />";
$devchangelog=$devchangelog."&nbsp;&nbsp;&nbsp;2016-01-15 + Redirect hinzugefuegt (Weiterl. wenn kein passwd; Hinweis, wenn passwd aber keine Weiterl.; )"."<br />";
?>
<?php
if (isset($_REQUEST['showChangelog'])) {
  echo $devchangelog;
  exit();
}
?>
<?php
$savedLastLogin=getLastLogin($activeuser);
$printLastLogin="";
if (empty($savedLastLogin) == FALSE) {
   $printLastLogin=date("d.m.Y H:i:s", strtotime($savedLastLogin));
}
$savedLastLogout=getLastLogout($activeuser);
$printLastLogout="";
if (empty($savedLastLogout) == FALSE) {
   $printLastLogout=date("d.m.Y H:i:s", strtotime($savedLastLogout));
}
$savedRandomID=getRandomIDFromUsername($activeuser);
?>
<table>
<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="right" class="mono"><?php echo getlang("InfoUser"); ?>:</td>
<td>&nbsp;</td>
<td><b><?php echo $activeuser; ?></b>
<?php
if (UserIsAdmin($activeuser)) {
  echo "<font size=\"-2\">(<font class=\"textred\">Admin</font>)</font>";
}
?></td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="right" class="mono"><?php echo getlang("InfoLastLogout"); ?>:</td>
<td>&nbsp;</td>
<td><?php echo $printLastLogout; ?></td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="right" class="mono"><?php echo getlang("InfoLastLogin"); ?>:</td>
<td>&nbsp;</td>
<td><?php echo $printLastLogin; ?></td>
</tr>
<tr>
<td>&nbsp;</td>
<td align="right" class="mono"><?php echo getlang("InfoRemember"); ?>:</td>
<td>&nbsp;</td>
<td><a href="index.php?id=<?php echo $savedRandomID; ?>" target="_new">link</a> <font class="small">(<?php echo $savedRandomID; ?>)</font><br /></td>
</tr>
</table>
<p>
<?php
//
$license=file_get_contents('./bin/license.html');
//
echo "<font class=\"bold\">rd2</font> ".$rd2Version."<br />";
echo "<font class=\"small\">Copyright (C) 2016 Sven Krug&nbsp;&nbsp;&nbsp;<a class=\"small\" href=\"http://www.dwizg.de\" target=\"_new\">dwizg.de</a></font>";
echo "<p>";
echo "<button title=\"anzeigen / verbergen\" type=\"button\" onclick=\"if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}\"><b>Changelog</b> ".getlang("InfoBtnShowHide")."</button>";
echo "<div id=\"spoiler\" style=\"display:none\">";
echo "<font face=\"courier new\">".$devchangelog."</font>";
echo "<br /><a href=\"#top\"><font class=\"small\">".getlang("miscToTop")."</a><br />";
echo "</div>";
echo "<p>";
echo "<font class=\"small\">";
echo getlang("LicenseRow1")."<br />";
echo getlang("LicenseRow2")."<br />";
echo getlang("LicenseRow3")."<br />";
echo "</font>";
echo "&nbsp;<br />";
echo "<button title=\"anzeigen / verbergen\" type=\"button\" onclick=\"if(document.getElementById('spoilerlicense') .style.display=='none') {document.getElementById('spoilerlicense') .style.display=''}else{document.getElementById('spoilerlicense') .style.display='none'}\"><b>License (GPL v3)</b> ".getlang("InfoBtnShowHide")."</button>";
echo "<div id=\"spoilerlicense\" style=\"display:none\">";
echo "<font face=\"courier new\">".$license."</font>";
echo "<a href=\"#top\"><font class=\"small\">".getlang("miscToTop")."</a><br />";
echo "</div>";
?>
