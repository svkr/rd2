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
// DB leer // fangen wir ab, falls noch keine DB vorhanden ist zB nach Reset oder Neu
$tmpcontentDB=file_get_contents($fileDB);
if (empty($tmpcontentDB) == FALSE) {  
  if (isLogin($activeuser)) {
    // AutoLogout
    $savedAutoLogoutTimeOut=getAutoLogoutTimeOut($activeuser);
    $savedautologout=getAutoLogout($activeuser);
    if ($savedAutoLogoutTimeOut !== 0) {      
      if (empty($savedautologout) == FALSE) {
        if ($savedautologout < time()) {
          $valueusername=$activeuser;
          $valuelastlogout=date('Y-m-d H:i:s');
          $db-> exec("UPDATE config SET islogin='0', lastlogout='$valuelastlogout' WHERE username='$valueusername'");
          echo " <font class=\"small\" color=\"red\">AutoLogout. Sie wurden automatisch abgemeldet.</font>";
        }
      }
    }
    // IP_wechsel
    $currentIP=getRealIpAddr();
    $savedIP=getLastLoginIP($activeuser);
    if (LogoutIfIPChanged($activeuser) == 1) {
      if (empty($savedIP) == FALSE) {
        if ($savedIP !== $currentIP) {
          $valueusername=$activeuser;
          $valuelastlogout=date('Y-m-d H:i:s');
          $db-> exec("UPDATE config SET islogin='0', lastlogout='$valuelastlogout' WHERE username='$valueusername'");
          echo " <font class=\"small\" color=\"red\">Login von einer anderen IP-Adresse. Sie wurden automatisch abgemeldet.</font>";
          $IPOkay=false;
        }
      }
    }

    $valueusername=$activeuser;
    $valueautologout=time() + ($savedAutoLogoutTimeOut * 60);
    $db-> exec("UPDATE config SET autologout='$valueautologout' WHERE username='$valueusername'");
    $valueautologout=date('H:i:s', $valueautologout);
    if ($savedAutoLogoutTimeOut == 0) {
      $valueautologout="";
    } else {
      $valueautologout="&nbsp;&nbsp;&nbsp;autom. Logout: ".$valueautologout;
    }
  }

}
?>
<a name="top"></a>
<form action="#" method="post">
<?php
if (empty($activeuser) || isLogin($activeuser) == FALSE) {
  if (isAllowContentAddAnonym() == true) {
  echo "<input type=\"submit\" name=\"showContentAnonym\" value=\"".getlang("MenuBtnEntryAdd")."\" class=\"buttonmenu\" />";
  echo " | ";
  }
  echo "<input type=\"submit\" name=\"showLogin\" value=\"".getlang("MenuBtnLogin")."\" class=\"buttonmenu\" />";
  echo " <input type=\"submit\" name=\"showUserAdd\" value=\"".getlang("MenuBtnUserAdd")."\" class=\"buttonmenu\" />";
  echo " |";
  echo " <font class=\"small\">".urldecode(getConfig("menutext"))."</font>";
} else {  
  if (UserIsAdmin($activeuser)) {
    $stringuser="<font class=\"boldsmall\">".$activeuser."</font> (<font class=\"textredsmall\">Admin</font>)";
  } else {
    $stringuser="<font class=\"boldsmall\">".$activeuser."</font>";
  }
  echo " <font class=\"small\">&nbsp;Nutzer: ".$stringuser.$valueautologout."</font><br />";
  echo " <input type=\"submit\" name=\"showContent\" value=\"".getlang("MenuBtnContent")."\" class=\"buttonmenu\" />";
  echo " <input type=\"submit\" name=\"showSettings\" value=\"".getlang("MenuBtnSettings")."\" class=\"buttonmenu\"  />";
  echo " <input type=\"submit\" name=\"showInfo\" value=\"".getlang("MenuBtnInfo")."\" class=\"buttonmenu\"  />";
  if (UserIsAdmin($activeuser)) {
    echo " |";
    echo " <input type=\"submit\" name=\"showBackup\" value=\"".getlang("MenuBtnBackup")."\" class=\"buttonmenu\"  />";
    echo " <input type=\"submit\" name=\"showFiles\" value=\"".getlang("MenuBtnFiles")."\" class=\"buttonmenu\"  />";
    echo " <input type=\"submit\" name=\"showUsers\" value=\"".getlang("MenuBtnUsers")."\" class=\"buttonmenu\"  />";
    echo " <input type=\"submit\" name=\"showConfig\" value=\"".getlang("MenuBtnConfig")."\" class=\"buttonmenu\"  />";
    echo " <input type=\"submit\" name=\"showLogs\" value=\"".getlang("MenuBtnLogs")."\" class=\"buttonmenu\"  />";
  }
  echo " |";
  echo " <input type=\"submit\" name=\"showLogout\" value=\"".getlang("MenuBtnLogout")."\" class=\"buttonmenu buttonmenubold\" />";
  echo " |";
  echo " <font class=\"small\">".urldecode(getConfig("menutext"))."</font>";
}
?>
</form>
