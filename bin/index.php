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
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//echo print_r($_REQUEST)."<p>";
?>
<?php
// check Requirement
$stopstart=false;
// SQLite
if (extension_loaded('sqlite3')) {
    //
}
else {
    echo "Fehlt: PHP SQLite3 support"."<br />";
    $stopstart=true;
}
// GD
if (extension_loaded('gd') && function_exists('gd_info')) {
    //
}
else {
    echo "Fehlt: PHP GD library"."<br />";
    $stopstart=true;
}
if ($stopstart==true) {
  echo "<p><font color=\"red\">Es werden nicht alle Systemvorraussetzungen erf&uuml;llt.</font><br />
        <b>rd2</b> kann nicht ausgef&uuml;hrt werden. Abbruch.";
  exit();
}
?>
<html>
<head>
<title>rd2</title>
<style>
* {
	font-family: Arial, Verdana, Sans-Serif;
	font-style: normal;
	font-size: 12px;
}
body {
	background: #F4F4F4;
}
.small {
	font-size: 10px;
}
.bold {
	font-weight: bold;
}
.boldsmall {
	font-weight: bold;
        font-size: 10px;
}
.mono {
	font-family: Monospace;
}
.monosmall {
	font-family: Monospace;
        font-size: 10px;
}
.textgreen {
	color: #006400;
}
.textred {
	color: #FF0000;
}
.textgreensmall {
	color: #006400;
        font-size: 10px;
}
.textredsmall {
	color: #FF0000;
        font-size: 10px;
}
input.button {
	font-family: Monospace;
        border-top-left-radius:6px;
        border-top-right-radius:6px;
        border-bottom-left-radius:6px;
        border-bottom-right-radius:6px;
	border: 1px solid #b7b5b5;
}
input.button:hover {
	box-shadow: 0 0 5px 0px #888888;
}
input.button:active {
	background: #D3D3D3;
}
input.buttonmenu {
	font-family: Monospace;
        border-top-left-radius:6px;
        border-top-right-radius:6px;
	border: 1px solid #b7b5b5;
	margin-left: 2px;
	margin-right: 2px;
}
input.buttonmenubold {
	font-weight: bold;
}
input.buttonmenu:hover {
	box-shadow: 0 0 5px 0px #888888;
}
input.buttonmenubold:hover {

}
input.buttonmenu:active {
	background: #D3D3D3;
}
input.buttonsort {
	font-family: Monospace;
	border: 0px solid #b7b5b5;
        color: #0000ff;
	background: #D3D3D3;
}
form.sortleft {
	width: 49%;
	float:left;
	text-align: right;
}
form.sortright {
	width: 49%;
	float:right;
	text-align: left;
}
.docheckbox {
	vertical-align: middle;
}
table.box {
	border: 1px solid #D3D3D3;
	margin-left: 10px;
	width: 600px;
}
td.content {
	padding-left: 3px;
	padding-right: 3px;
}
</style>
	<!--
	background: transparent;
	text-decoration:line-through;
	border: 2px solid #0167F6;
	-->
</head>
<body>
<?php
header('Content-Type: text/html; charset=UTF-8');
include ('./bin/functions.php');
include ('./bin/language.php');
?>
<?php
// DB leer
$tmpcontentDB=file_get_contents($fileDB);
if (empty($tmpcontentDB)) {
  createDB();
}
?>
<?php
ini_set ("session.use_cookies","0");
if (isset($_GET['id'])) {
  $valueid=htmlspecialchars($_GET['id'], ENT_COMPAT, 'UTF-8');
  if (!empty(getSessionIDFromRandomID($valueid))) {
    session_id();
    $activeuser=getUsernameFromRandomID($valueid);
    session_start();
    $lang=$languages[getLanguageFromUsername($activeuser)];
  } else {
    $lang=$languages[getConfig("language")];
  }
} else {
  $lang=$languages[getConfig("language")];
}
?>
<?php
// Menu
echo "<!-- Start Menue-->";
include('./bin/menu.php');
echo "<!-- Ende Menue-->";
?>
<?php
// keine Nutzer vorhanden? [oder gerade mein 1st User setzen]
if (countUser() == 0) {
  echo wasBAD().getlang("UsersMsgNone")."!<br />".getlang("UsersMsgFirst").".<p>";
  include ('./bin/useradd.php');
}
?>
<?php
echo "<!-- Start Inhalt-->";
// user

// #Login
if (isset($_REQUEST['showLogin'])) {
  echo ">> ".getlang("MenuBtnDescLogin")."<p>";
  include ('./bin/login.php');
  if (isset($_REQUEST['doLogin'])) {
    $valueloginpasswd=htmlspecialchars($_REQUEST['loginpasswd'], ENT_COMPAT, 'UTF-8');
    $valueloginusername=htmlspecialchars($_REQUEST['loginusername'], ENT_COMPAT, 'UTF-8');
    // Nutzer existiert?
    if (userExists($valueloginusername) == FALSE) {
      //echo "dev: Nutzername existiert nicht.";
      createLogEntry("Login", "Nutzer unbekannt", "Nutzer: >".$valueloginusername."<", "", "", "", "");
      exit();
    }
    if (isPasswdOkay($valueloginusername, $valueloginpasswd) == TRUE) {
      if (UserIsEnable($valueloginusername) == TRUE) {
        $_REQUEST['loginpasswd']="";
        $valueloginpasswd="";
        $valueusername=$valueloginusername;
        $valuelastlogin=date('Y-m-d H:i:s');
        $valuelastloginip=getRealIpAddr();
        $valueislogin=1;
        $valueautologout=time() + (1 * 60);
        $db-> exec("UPDATE config SET ".
                   "lastlogin='$valuelastlogin', islogin='$valueislogin', autologout='$valueautologout', lastloginip='$valuelastloginip' ".
                   "WHERE username='$valueloginusername'");
        $activeuser=$valueloginusername;
        header("Location: index.php?id=".getRandomIDFromUsername($valueloginusername));
      } else {
        createLogEntry("Login", "Nutzer gesperrt", "Nutzer: >".$valueloginusername."<", "", "", "", "");
        echo wasBAD()."<b><font class=\"bold\">".$valueloginusername."</font> ".getlang("UsersMsgLocked")."!<p>";
      }
    } else {
      createLogEntry("Login", "falsches Passwort", "Nutzer: >".$valueloginusername."<", "", "", "", "");
      echo wasBAD().getlang("UsersMsgWrong")."!<p>";
    }
  }
}
// #Logout
if (isset($_REQUEST['showLogout'])) {
  include ('./bin/logout.php');
}
// setPasswd
if (isset($_REQUEST['showSettings'])) {
  if (isLogin($activeuser) == FALSE || $IPOkay == FALSE) {
    exit();
  }
  echo ">> ".getlang("MenuBtnDescSettings")."<p>";
  echo "<b>".getlang("SettingsAction").":</b><p>";
  include ('./bin/settings.php');
  echo "&nbsp;<p>";
  echo "<b>".getlang("SettingsPasswordLogin").":</b><p>";
  include ('./bin/setpasswd.php');
}
// userAdd
if (isset($_REQUEST['showUserAdd'])) {
    echo ">> ".getlang("MenuBtnDescUserAdd")."<p>";
    $valiIDtoCheck="";
    include ('./bin/useradd.php');
}

// #Backup
if (isset($_REQUEST['showBackup']) || isset($_REQUEST['delBackup'])) {
  if (isLogin($activeuser) == FALSE || $IPOkay == FALSE || UserIsAdmin($activeuser) == FALSE) {
  exit();
  }
  echo ">> ".getlang("MenuBtnDescBackup")."<br />";
  echo "&nbsp;&nbsp;&nbsp;<font class=\"small\">(<font color=\"red\" class=\"small\">Bug</font>: Download startet unter Android nicht.)</font><p>";
  include ('./bin/backup.php');
}
// #Files
if (isset($_REQUEST['showFiles'])) {
  if (isLogin($activeuser) == FALSE || $IPOkay == FALSE || UserIsAdmin($activeuser) == FALSE) {
    exit();
  }
  echo ">> ".getlang("MenuBtnDescFiles")."<p>";
  include ('./bin/files.php');
}
// #Info
if (isset($_REQUEST['showInfo'])) {
  if (isLogin($activeuser) == FALSE || $IPOkay == FALSE) {
    exit();
  }
  echo ">> ".getlang("MenuBtnDescInfo")."<p>";
  include ('./bin/info.php');
}
// #Content
if (isset($_REQUEST['showContent'])) {
  if (isLogin($activeuser) == FALSE || $IPOkay == FALSE) {
    exit();
  }
  echo ">> ".getlang("MenuBtnDescEntryAdd")."<p>";
  include ('./bin/contentadd.php');
  echo "<p>&nbsp;<p>";
  include ('./bin/content.php');
}
// #Redirect
if (isset($_REQUEST['rd'])) {
  if (empty($_GET['rd']) == FALSE) {
        include ('./bin/redirect.php');
        exit();
  } else {
    header("Location: index.php");
  }
}
// Users
if (isset($_REQUEST['showUsers'])) {
  if (isLogin($activeuser) == FALSE || $IPOkay == FALSE || UserIsAdmin($activeuser) == FALSE) {
    exit();
  }
  echo ">> ".getlang("MenuBtnDescUsers")."<p>";
  if (isset($_REQUEST['dosave'])) {
    $valueusername=$_REQUEST['username'];
    if (isset($_REQUEST['admin'])) {
      $valueadmin=1;
    } else {
      $valueadmin=0;
    }
    if (isset($_REQUEST['enable'])) {
      $valueenable=1;
      $strislogin="";
    } else {
      $valueenable=0;
      $strislogin=", islogin='0'";
    }
    if (isset($_REQUEST['autobackup'])) {
      $valueautobackup=1;
    } else {
      $valueautobackup=0;
    }
    $db-> exec("UPDATE config SET ".
               "admin='$valueadmin', autobackup='$valueautobackup', enable='$valueenable'".$strislogin." ".
               "WHERE username='$valueusername'");
    echo wasGOOD()."<font class=\"bold\">".$valueusername."</font> ".getlang("UsersMsgSaved").".<p>";
  }
  if (isset($_REQUEST['del'])) {
    if (isset($_REQUEST['dodel'])) {
      $valueusername=$_REQUEST['username'];
      $db-> exec("DELETE FROM config ".
                 "WHERE username='$valueusername'");
      echo wasGOOD()."<font class=\"bold\">".$valueusername."</font> ".getlang("UsersMsgRemoved").".<p>";
    } else {
      echo wasBAD().getlang("UsersMsgCheck").".<p>";
    }
  }
  if (isset($_REQUEST['resetpasswd'])) {
    if (isset($_REQUEST['doresetpasswd'])) {
      $valueusername=$_REQUEST['username'];
      $valuesalt=getNewSalt();
      $newpasswd=getFreeRandomID().getFreeRandomID();
      $valuepasswd=password_hash($newpasswd.$valuesalt, PASSWORD_DEFAULT);
      $db-> exec("UPDATE config SET passwd='$valuepasswd', salt='$valuesalt' ".
                 "WHERE username='$valueusername'");
      echo wasGOOD().getlang("UsersMsgPassSet")." => <font class=\"bold\">".$newpasswd."</font><p>";
    } else {
      echo wasBAD().getlang("UsersMsgCheck").".<p>";
    }
  }

  include ('./bin/users.php');
}
// Config
if (isset($_REQUEST['showConfig'])) {
  if (isLogin($activeuser) == FALSE || $IPOkay == FALSE || UserIsAdmin($activeuser) == FALSE) {
    exit();
  }
  echo ">> ".getlang("MenuBtnDescConfig")."<p>";
  include ('./bin/config.php');
  echo "&nbsp;<p>";
  echo "<b>rd2 Update:</b><p>";
  include ('./bin/update.php');
  echo "&nbsp;<p>";
  echo "<b>rd2 ".getlang("ResetConfig").":</b><p>";
  include ('./bin/reset.php');
}
// Logs
if (isset($_REQUEST['showLogs'])) {
  if (isLogin($activeuser) == FALSE || $IPOkay == FALSE || UserIsAdmin($activeuser) == FALSE) {
    exit();
  }
  echo ">> ".getlang("MenuBtnDescLogs")."<p>";
  if (isset($_REQUEST['clearLogs']) && isset($_REQUEST['doclearLogs']) == FALSE) {
    echo wasBAD().getlang("LogsMsgCheck").".<p>";
  }
  if (isset($_REQUEST['doclearLogs'])) {
    $db-> exec("DELETE FROM logs");
    echo wasGOOD().getlang("LogsMsgClearAll").".<p>";
  }
  if (isset($_REQUEST['removeLogs'])) {
    if (isset($_REQUEST['toremove'])) {
      $toremove=$_REQUEST['toremove'];
      $removequery="DELETE FROM logs WHERE ";
      $countentry=0;
      foreach ($toremove as $entry) {
        if ($countentry > 0) {
          $removequery=$removequery." OR ";
        }
        $removequery=$removequery."id='".$entry."'";
        $countentry++;
      }
      $removequery=$removequery.";";
      $db-> exec($removequery);
      if ($countentry == 1) {
        echo wasGOOD().getlang("LogsMsgRemoveOne").".<p>";
      } else {
        echo wasGOOD().$countentry." ".getlang("LogsMsgRemoveMore").".<p>";
      }
    } else {
      echo getlang("LogsMsgNone").".<p>";
    }
  }
  include ('./bin/logs.php');
}
echo "<!-- Ende Inhalt-->";
// Leer
if (empty($_REQUEST) || isset($_REQUEST['showContentAnonym'])) {
  if (isAllowContentAddAnonym() == true) {
    echo "<p><font class=\"small\">".
         "&nbsp;&nbsp;&nbsp;".getlang("MenuBtnDescEntryAddWithoutLogin").
         "</font><p>";
    include ('./bin/contentadd.php');
  }
  if (getConfig("showwelcomemessage") == "1") {
    echo "<p>";
    $content=getConfig("welcomemessage");
    $content=urldecode($content);
    echo "<font class=\"small\">".$content."</font>";
  }
}
// #Reset
if (isset($_REQUEST['reset'])) {
  if (isset($_REQUEST['doreset'])) {
    if (isLogin($activeuser) == FALSE || $IPOkay == FALSE || UserIsAdmin($activeuser) == FALSE) {
      exit();
    }
    $dir = new RecursiveDirectoryIterator('./content/');
    foreach (new RecursiveIteratorIterator($dir) as $file) {
      if (is_dir($file) == FALSE) {
        if (strstr($file->getFilename(), ".htaccess") == FALSE) {
          unlink($file);
        }
      }
    }
  // ToDo: Start
  //header("Location: index.php"); // => "Cannot modify header information - headers already sent by"
  echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">"; // <= dirtyCode
  // ToDo: Ende
  } else {
    echo wasBAD().getlang("ResetMsgCheck").".<p>";
  }
}
?>
</body>
</html>
