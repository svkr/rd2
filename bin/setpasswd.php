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
if (isset($_REQUEST['setpasswd'])) {
    $valueoldpasswd=htmlspecialchars($_REQUEST['oldpasswd'], ENT_COMPAT, 'UTF-8');
    $valueloginpasswd=htmlspecialchars($_REQUEST['loginpasswd'], ENT_COMPAT, 'UTF-8');
    $valueloginpasswdrepeat=htmlspecialchars($_REQUEST['loginpasswdrepeat'], ENT_COMPAT, 'UTF-8');
    $doSave=true;
    if (empty($valueloginpasswd)) {
       echo wasBAD().getlang("UsersMsgPassEmpty").".<p>";
       $doSave=false;
    }
    if (strcmp($valueloginpasswd, $valueloginpasswdrepeat) !== 0) {
       echo wasBAD().getlang("UsersMsgPassNotEqual").".<p>";
       $doSave=false;
    }
    if (isPasswdOkay($activeuser, $valueoldpasswd) == FALSE) {
       echo wasBAD().getlang("UsersMsgPassWrong").".<p>";
       $doSave=false;
    }
    if ($doSave == true) {
      $valueusername=$activeuser;
      $valuesalt=getNewSalt();
      $valuepasswd=password_hash($valueloginpasswd.$valuesalt, PASSWORD_DEFAULT);
      $db-> exec("UPDATE config SET passwd='$valuepasswd', salt='$valuesalt' ".
                 "WHERE username='$valueusername'");
      echo wasGOOD().getlang("UsersMsgPassSet").".<p>";
    }
}
?>
<form action="#" method="post">
<table border="0">
<tr>
<td>&nbsp;&nbsp;&nbsp;<?php echo getlang("SettingsPasswordOld"); ?>:</td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="password" size="12" name="oldpasswd" /></td>
</tr>
<tr>
<td>&nbsp;&nbsp;&nbsp;<?php echo getlang("SettingsPasswordNew"); ?>:</td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="password" size="12" name="loginpasswd" /></td>
</tr>
<tr>
<td>&nbsp;&nbsp;&nbsp;<?php echo getlang("SettingsPasswordRepeat"); ?>:</td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="password" size="12" name="loginpasswdrepeat" /></td>
</tr>
<tr>
<td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="hidden" name="showSettings" />
<input type="submit" name="setpasswd" value="<?php echo getlang("SettingsBtnPasswordSet"); ?>" class="button" /></td>
</tr>

</table>
</form>
