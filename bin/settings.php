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
//schreiben
  if (isset($_REQUEST['saveSettings'])) {
    $oldRandomID=getRandomIDFromUsername($activeuser);
    $valueusername=$activeuser;
    $valueAutoLogoutTimeOut=htmlspecialchars($_REQUEST['AutoLogoutTimeOut'], ENT_COMPAT, 'UTF-8');
    if (isset($_REQUEST['logoutIfIPChanged'])) {
      $valueAutoLogoutIfIPChanged=htmlspecialchars($_REQUEST['logoutIfIPChanged'], ENT_COMPAT, 'UTF-8');
      if ($valueAutoLogoutIfIPChanged == "on") {
        $valueAutoLogoutIfIPChanged=1;
      } else {
        $valueAutoLogoutIfIPChanged="";
      }
    } else {
      $valueAutoLogoutIfIPChanged="";
    }
    $valueRandomID=htmlspecialchars($_REQUEST['RandomID'], ENT_COMPAT, 'UTF-8');
    $valueautologout=time() + ($valueAutoLogoutTimeOut * 60);
    $valuelanguage=htmlspecialchars($_REQUEST['language'], ENT_COMPAT, 'UTF-8');
    $db-> exec("UPDATE config SET autologouttimeout='$valueAutoLogoutTimeOut', randomid='$valueRandomID', autologoutifipchanged='$valueAutoLogoutIfIPChanged', autologout='$valueautologout', language='$valuelanguage' ".
               "WHERE username='$valueusername'");
    echo wasGOOD().getlang("SettingsMsgSaved").".<p>";
    $newRandomID=getRandomIDFromUsername($activeuser);
    if ($oldRandomID !== $newRandomID) {
      addToBlacklist("randomid", $newRandomID);
      echo wasGOOD()."&nbsp;&nbsp;&nbsp;<font class=\"bold\">".getlang("SettingsMsgIDChanged")."!</font><br />";
      echo getlang("SettingsMsgIDNew")." "."<font color=\"darkgreen\" class=\"bold\">".$newRandomID."</font>".".<br />".
           "<font class =\"small\"><font color=\"red\">".$oldRandomID."</font> ".getlang("SettingsMsgIDOld").".</font><p />";
      echo "<font class =\"small\"><a href=\"index.php?id=".$newRandomID."\" target=\"_top\">Weiterleitung</a> oder erneuter <a href=\"index.php\" target=\"_top\">Login</a></font><br />&nbsp;<p>";
    }
  }
?>
<?php
// lesen
$savedAutoLogoutTimeOut=getAutoLogoutTimeOut($activeuser);
$savedRandomID=getRandomIDFromUsername($activeuser);
$savedlogoutifipchanged=LogoutIfIPChanged($activeuser);
if ($savedlogoutifipchanged == 1) {
  $savedlogoutifipchanged =" checked=\"Yes\"";
} else {
  $savedlogoutifipchanged="";
}
$savedlanguage=getLanguageFromUsername($activeuser);
// neue ID?
$strRandomID=$savedRandomID;
if (isset($_REQUEST['newRandomID'])) {
  $strRandomID=getFreeRandomID();
}
?>
<form action="#" method="post">
<input type="hidden" name="showSettings" value="1" />
<table class="box"><tr><td>
&nbsp;&nbsp;&nbsp;<?php echo getlang("SettingsLanguage"); ?>:&nbsp;
<select name="language">
<?php
foreach ($languages as $key => $value) {
  if ($value["Enable"] == "1") {
    if ($key == $savedlanguage) {
      echo "<option value=\"".$key."\" selected>".$key." (".$value["Name"].") ".$value["Info"]."</option>";
    } else {
      echo "<option value=\"".$key."\">".$key." (".$value["Name"].") ".$value["Info"]."</option>";
    }
  }
}
?>
</select>
<br />
&nbsp;&nbsp;&nbsp;<font class="small">( <?php echo getlang("SettingsNotFinished"); ?> )</font>
</td></tr></table>
<p>
<table class="box"><tr><td>
&nbsp;&nbsp;&nbsp;<?php echo getlang("SettingsAutoLogoutAfter"); ?> <input type="number" name="AutoLogoutTimeOut" min="0" max="1440" style="width: 4em;" value="<?php echo $savedAutoLogoutTimeOut; ?>"/>
&nbsp;<?php echo getlang("SettingsMinutes"); ?> (0-1440). <?php echo getlang("SettingsAutoLogoutZero"); ?>.<br />
&nbsp;&nbsp;&nbsp;<font class="small">1 - 15 <?php echo getlang("SettingsAutoLogoutRecommend"); ?></font>
</td></tr></table>
<p>
<table class="box"><tr><td>
&nbsp;&nbsp;<input type="checkbox" name="logoutIfIPChanged" class="docheckbox" <?php echo $savedlogoutifipchanged; ?> /> <?php echo getlang("SettingsDiffIP"); ?>.<br />
&nbsp;&nbsp;&nbsp;<font class="small"><?php echo getlang("SettingsDiffIPRecommend"); ?></font>
</td></tr></table>
<p>
<table class="box"><tr><td>
&nbsp;&nbsp;&nbsp;<?php echo getlang("SettingsRandomID"); ?>: <input type="text" size="5" name="RandomID" value="<?php echo $strRandomID; ?>" READONLY />
<input type="submit" name="newRandomID" value="<?php echo getlang("SettingsRandomIDNew"); ?>" class="button" />
</td></tr></table>
<p>&nbsp;<br />
&nbsp;&nbsp;&nbsp;<input type="submit" name="saveSettings" value="<?php echo getlang("SettingsBtnSave"); ?>" class="button" />
</form>

