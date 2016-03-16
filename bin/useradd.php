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
// htmlspecialchars nicht nötig, da...
// valusername wird später auf gültige Zeichen geprüft
// passwörter werden gehasht
$valusername="";
if (isset($_REQUEST['username'])) {
  $valusername=$_REQUEST['username'];
}
$valpasswd="";
if (isset($_REQUEST['passwd'])) {
  $valpasswd=$_REQUEST['passwd'];
}
$valpasswdrepeat="";
if (isset($_REQUEST['passwdrepeat'])) {
  $valpasswdrepeat=$_REQUEST['passwdrepeat'];
}
$valverification="";
$returnarray=createVeriEntry();
$veriEntry=$returnarray['entry'];
$veriCode=$returnarray['code'];
$veriPic=$returnarray['pic'];
// prepare abgeschlossen
?>
<?php
removeOldVeriEntrys();
if (isset($_REQUEST['userAdd'])) {
  $valverificationEntry=base64_decode(htmlspecialchars($_REQUEST['verificationEntry'], ENT_COMPAT, 'UTF-8'));
  $valverification=htmlspecialchars($_REQUEST['verification'], ENT_COMPAT, 'UTF-8');
  // leer?
  if (empty($valusername) || empty($valpasswd)) {
    if (empty($valusername)) {
      createLogEntry("Anmelden", "Nutzer leer", "", "", "", "", "");
    }
    if (empty($valpasswd)) {
      createLogEntry("Anmelden", "Passwort leer", "Nutzer: >".$valusername."<", "", "", "", "");
    }
    echo wasBAD().getlang("UsersAddMsgEmpty").".";
    removeVeriEntry($valverificationEntry);
    exit();
  }
  // check username: ungültige Zeichen    \\s -> Leerzeichen
  if (!preg_match('/([^A-Za-z0-9\s])/', $valusername))
  {
    //echo "Nutzername = okay<br>";
  } else {
    createLogEntry("Anmelden", "Nutzer enthält ungültige Zeichen", "Nutzer: >".$valusername."<", "", "", "", "");
    echo wasBAD().getlang("UsersAddMsgBadChars").".";
    removeVeriEntry($valverificationEntry);
    exit();
  }
  // Nutzer bereits vorhanden?
  if (userExists($valusername)) {
    createLogEntry("Anmelden", "Nutzer existiert bereits", "Nutzer: >".$valusername."<", "", "", "", "");
    echo wasBAD().getlang("UsersAddMsgUserExists").".";
    removeVeriEntry($valverificationEntry);
    exit();
  }
  // Passwort-Wiederholung identisch?
  if ($valpasswd !== $valpasswdrepeat) {
    createLogEntry("Anmelden", "Passwortwiederholung nicht identisch", "Nutzer: >".$valusername."<", "", "", "", "");
    echo wasBAD().getlang("UsersAddMsgNotEqual").".";
    removeVeriEntry($valverificationEntry);
    exit();
  }
  // Verifikation korrekt?
  if (isVeriCodeCorrect($valverificationEntry, $valverification) == false) {
    createLogEntry("Anmelden", "Verifikation ungültig", "Nutzer: >".$valusername."<", "", "", "", "");
    echo wasBAD().getlang("UsersAddMsgVerificationFail").".";
    removeVeriEntry($valverificationEntry);
    exit();
  }
  // Verifikation abgelaufen?
  if (isVeriCodeExpired($valverificationEntry)) {
    createLogEntry("Anmelden", "Verifikation abgelaufen", "Nutzer: >".$valusername."<", "", "", "", "");
    echo wasBAD().getlang("UsersAddMsgVerificationExpire").".";
    exit();
  }
  $admin=0;
  // erster user? dann admin
  if (countUser() == 0) {
    $admin=1;
  }
  $valueusername=$valusername;
  $valuesalt=getNewSalt();
  $valuepasswd=password_hash($valpasswd.$valuesalt, PASSWORD_DEFAULT);
  // sessionid
  session_start();
  session_regenerate_id();
  $valuesessionid=session_id();
  $valuerandomid=getFreeRandomID();
  addToBlacklist("ramdomid", $valuerandomid);
  $valueautologouttimeout=15;
  $valueautobackup=0;
  $valueenable=1;
  $valueautologoutifipchanged=1;
  $valueadded=date('Y-m-d H:i:s');
  $valuelanguage=getConfig("language");
  while (RandomIDexists(session_id()) == TRUE) {
    session_regenerate_id();
  }
  $db-> exec("INSERT OR REPLACE INTO config (username, passwd, salt, admin, sessionid, randomid, autologouttimeout, ".
             "autobackup, enable, autologoutifipchanged, added, language) ".
             "VALUES ('$valueusername', '$valuepasswd', '$valuesalt', '$admin', '$valuesessionid', '$valuerandomid', '$valueautologouttimeout', ".
                     "'$valueautobackup', '$valueenable', '$valueautologoutifipchanged', '$valueadded', '$valuelanguage')");
  // verficationimage leeren
  createVerificationImage("empty");
  removeVeriEntry($valverificationEntry);
  echo wasGOOD()."<font class=\"bold\">".$valueusername."</font> ".getlang("UsersAddMsgAdded").".";
  exit();
}
?>
<?php
// html-FORM
?>
<form action="#" method="post">
<table>
<tr>
<td align="right">
<?php echo getlang("UsersAddUser") ?>:
</td>
<td>
<input type="text" size="12" name="username" value="<?php echo $valusername; ?>" />
<font class="small"> <?php echo getlang("UsersAddRestrict") ?></font>
</td>
</tr>
<tr>
<td align="right">
<?php echo getlang("UsersAddPassword") ?>:
</td>
<td>
<input type="password" size="12" name="passwd" value="<?php echo $valpasswd; ?>" />
</td>
</tr>
<tr>
<td align="right">
<?php echo getlang("UsersAddPasswordRepeat") ?>:
</td>
<td>
<input type="password" size="12" name="passwdrepeat" value="<?php echo $valpasswd; ?>" />
</td>
</tr>
<tr>
<td></td><td></td>
</tr>
<tr>
<td align="right">
<?php echo getlang("UsersAddVerification") ?>:
</td>
<td>
<?php
for ($i=3; $i < rand(4, 16); $i++) {
 echo "&nbsp;&nbsp;";
}
?>
<img src="data:image/gif;base64,<?php echo $veriPic; ?>"><input type="hidden" name="verificationEntry" value="<?php echo base64_encode($veriEntry); ?>">
</td>
</tr>
<tr>
<td align="right">
<?php echo getlang("UsersAddVerificationEnter") ?>:
</td>
<td>
<input type="text" size="12" name="verification" value="<?php echo $valverification; ?>" />
</td>
</tr>
<tr>
<td></td><td></td>
</tr>
<tr>
<td>
&nbsp;
</td>
<td>
<input type="hidden" name="showUserAdd" />
<input type="submit" name="userAdd" value="<?php echo getlang("UsersAddBtnCreate") ?>" class="button" />
</td>
</tr>
</table>
</form>
