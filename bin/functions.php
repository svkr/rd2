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

$rd2Version="0.10.0";
$rd2VersionPrefix="";
$rd2Build="603071";

$colormissing="bgcolor=\"#FFDB58\"";
$colorequal="bgcolor=\"#90EE90\"";
$colordiff="bgcolor=\"#FF3333\"";
$colorbg="bgcolor=\"#D3D3D3\"";
$colorbgfirst="bgcolor=\"#ECECEC\"";
$colorbgsecond="bgcolor=\"#E3E3E3\"";
$colordiffonly="#FF3333";
$colorequalonlytext="#006400";
$colorwasGOOD="#017f01";
$colorwasBAD="#FF3333";

$fileDB="./content/rd2.content";
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open($fileDB);
    }
}
$db=new SQLite3($fileDB);

$userrd2="#rd2#";
$usernone="#none#";
$IPOkay=true;
$activeuser=$usernone;
$latestdbversion=3;

// -- -- -- -- --
// SQLite
// -- -- -- -- --
function createDB() {
  global $db, $userrd2, $latestdbversion;
  $db-> exec("CREATE TABLE config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT,
    added TEXT,
    passwd TEXT,
    salt TEXT,
    admin TEXT,
    sessionid TEXT,
    randomid TEXT,
    enable TEXT,
    islogin TEXT,
    lastlogin TEXT,
    lastloginip TEXT,
    lastlogout TEXT,
    autologout TEXT,
    autologouttimeout TEXT,
    autologoutifipchanged TEXT,
    autobackup TEXT,
    language TEXT)");
  $db-> exec("CREATE TABLE content (
    short TEXT PRIMARY KEY,
    long TEXT,
    passwd TEXT,
    salt TEXT,
    added TEXT,
    ip TEXT,
    expire TEXT,
    comment TEXT,
    owner TEXT)");
  $db-> exec("CREATE TABLE files (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    saved TEXT,
    file  TEXT,
    size TEXT,
    lastchange TEXT,
    md5 TEXT,
    sha1 TEXT)");
  $db-> exec("CREATE TABLE logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    timestamp TEXT,
    kat  TEXT,
    entry TEXT,
    ip TEXT,
    arg1 TEXT,
    arg2 TEXT,
    arg3 TEXT,
    arg4 TEXT,
    arg5 TEXT)");
  $db-> exec("CREATE TABLE blacklist (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    added TEXT,
    type TEXT,
    entry  TEXT)");
  $db-> exec("CREATE TABLE verification (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    entry TEXT,
    code TEXT,
    added TEXT,
    pic TEXT)");
  $db-> exec("CREATE TABLE configrd2 (
    key TEXT PRIMARY KEY,
    value TEXT)");
  // set Default
    $valueusername=$userrd2;
    $defaultAutoLogoutTimeOut=15;
    setConfig("allowcontentaddanonym", "1");
    setConfig("rd2prefix", "");
    setConfig("rd2prefixprotocol", "http://");
    setConfig("showwelcomemessage", "0");
    setConfig("welcomemessage", "");
    setConfig("menutext", "");
    setConfig("language", "DE");
    setConfig("shortmaxlength", "255");
    setConfig("commentmaxlength", "1024");
    setConfig("veriexpire", "10");
    setConfig("dbversion", $latestdbversion);
}
function isDBempty() {
  global $fileDB;
  $tmpcontentDB=file_get_contents($fileDB);
  if (empty($tmpcontentDB)) {
    return true;
  } else {
    return false;
  }
}
function countContent() {
  global $db;
  $results = $db->query("SELECT COUNT(*) FROM content");
  while ($row = $results->fetchArray()) {
    foreach ($row as $line) {
      return $line;
    }
  }
}
function countContentUser($username) {
  global $db;
  $results = $db->query("SELECT COUNT(*) FROM content WHERE owner='".getIDFromUsername($username)."'");
  while ($row = $results->fetchArray()) {
    foreach ($row as $line) {
      return $line;
    }
  }
}
function doBackup($ext) {
  global $fileDB, $rd2Version;
  if (copy($fileDB, './content/rd2.content_backup-'.date('Ymd-His')."-".$rd2Version.$ext) == FALSE) {
    return false;
  } else {
    return true;
  }
}
function Contentexists($short) {
  global $db;
  $returnvalue=false;
  $results = $db->query("SELECT short FROM content WHERE short='$short'");
  while ($row = $results->fetchArray()) {
    if (empty($row['short']) == FALSE) {
      $returnvalue=true;
    }
  }
  return $returnvalue;
}
function passwdContent($short) {
  global $db;
  $returnvalue=false;
  $results = $db->query("SELECT passwd FROM content WHERE short='$short'");
  while ($row = $results->fetchArray()) {
    if (empty($row['passwd']) == FALSE) {
      $returnvalue=true;
    }
  }
  return $returnvalue;
}
function getlongContent($short) {
  global $db;
  $returnvalue="";
  $results = $db->query("SELECT long FROM content WHERE short='$short'");
  while ($row = $results->fetchArray()) {
    if (empty($row['long']) == FALSE) {
      $returnvalue=$row['long'];
    }
  }
  return $returnvalue;
}
function isPasswdOkayContent($short, $passwd) {
  global $db;
  $returnvalue=false;
  $results = $db->query("SELECT passwd, salt FROM content WHERE short='$short'");
  while ($row = $results->fetchArray()) {
    $returnvalue = password_verify($passwd.$row['salt'], $row['passwd']);
  }
  return $returnvalue;
}
function removeContent($short) {
  global $db;
  $db->query("DELETE FROM content WHERE short='$short'");
}
// -- -- -- -- --
// Settings
// -- -- -- -- --
function getAutoLogoutTimeOut($username) {
  global $db;
  $returnvalue=0;
  $results = $db->query("SELECT autologouttimeout FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    if (empty($row['autologouttimeout']) == FALSE) {
      $returnvalue=$row['autologouttimeout'];
    }
  }
  return $returnvalue;
}
function getAutoBackup($username) {
  global $db;
  $returnvalue=1;
  $results = $db->query("SELECT autobackup FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
      $returnvalue=$row['autobackup'];
  }
  return $returnvalue;
}
function LogoutIfIPChanged($username) {
  global $db;
  $returnvalue=false;
  $results = $db->query("SELECT autologoutifipchanged FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    if ($row['autologoutifipchanged'] == 1) {
      $returnvalue=true;
    }
  }
  return $returnvalue;
}
function getRedirectPrefix($user) {
  global $db;
  $returnvalue=1;
  $results = $db->query("SELECT redirectprefix FROM config WHERE username='$user'");
  while ($row = $results->fetchArray()) {
      $returnvalue=$row['redirectprefix'];
  }
  return $returnvalue;
}
// -- -- -- -- --
// User
// -- -- -- -- --
function countUser() {
  global $db;
  $results = $db->query("SELECT COUNT(*) FROM config");
  while ($row = $results->fetchArray()) {
    foreach ($row as $line) {
      return $line;
    }
  }
}
function userExists($username) {
  global $db;
  $returnvalue=false;
  $results = $db->query("SELECT username FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    if (empty($row['username']) == FALSE) {
      if ($row['username'] == $username) {
        $returnvalue=true;
      }
    }
  }
  return $returnvalue;
}
function islogin($username) {
  global $db;
  $returnvalue=false;
  $results = $db->query("SELECT islogin FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    if ($row['islogin'] == 1) {
      $returnvalue=true;
    }
  }
  return $returnvalue;
}
function containspasswd($username) {
  global $db;
  $returnvalue=false;
  $results = $db->query("SELECT passwd FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    if (empty($row['passwd']) == FALSE) {
      $returnvalue=true;
    }
  }
  return $returnvalue;
}
function isPasswdOkay($username, $userpasswd) {
  global $db;
  $returnvalue=false;
  $results = $db->query("SELECT passwd, salt FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    $returnvalue = password_verify($userpasswd.$row['salt'], $row['passwd']);
  }
  return $returnvalue;
}
function getAutoLogout($username) {
  global $db;
  $returnvalue="";
  $results = $db->query("SELECT autologout FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    $returnvalue = $row['autologout'];
  }
  return $returnvalue;
}
function getLastLogin($username) {
  global $db;
  $returnvalue="";
  $results = $db->query("SELECT lastlogin FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    $returnvalue = $row['lastlogin'];
  }
  return $returnvalue;
}
function getLastLogout($username) {
  global $db;
  $returnvalue="";
  $results = $db->query("SELECT lastlogout FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    $returnvalue = $row['lastlogout'];
  }
  return $returnvalue;
}
function getLastLoginIP($username) {
  global $db;
  $returnvalue="";
  $results = $db->query("SELECT lastloginip FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    $returnvalue = $row['lastloginip'];
  }
  return $returnvalue;
}
function getUsernameFromSessionID($sessid) {
  global $db;
  $returnvalue="";
  $results = $db->query("SELECT username FROM config WHERE sessionid='$sessid'");
  while ($row = $results->fetchArray()) {
    if (empty($row['username']) == FALSE) {
      $returnvalue=$row['username'];
    }
  }
  return $returnvalue;
}
function getUsernameFromRandomID($id) {
  global $db;
  $returnvalue="";
  $results = $db->query("SELECT username FROM config WHERE randomid='$id'");
  while ($row = $results->fetchArray()) {
    if (empty($row['username']) == FALSE) {
      $returnvalue=$row['username'];
    }
  }
  return $returnvalue;
}
function getSessionIDFromRandomID($id) {
  global $db;
  $returnvalue="";
  $results = $db->query("SELECT sessionid FROM config WHERE randomid='$id'");
  while ($row = $results->fetchArray()) {
    if (empty($row['sessionid']) == FALSE) {
      $returnvalue=$row['sessionid'];
    }
  }
  return $returnvalue;
}
function getRandomIDFromSessionID($id) {
  global $db;
  $returnvalue="";
  $results = $db->query("SELECT randomid FROM config WHERE sessionid='$id'");
  while ($row = $results->fetchArray()) {
    if (empty($row['randomid']) == FALSE) {
      $returnvalue=$row['randomid'];
    }
  }
  return $returnvalue;
}
function getRandomIDFromUsername($username) {
  global $db;
  $returnvalue="";
  $results = $db->query("SELECT randomid FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    if (empty($row['randomid']) == FALSE) {
      $returnvalue=$row['randomid'];
    }
  }
  return $returnvalue;
}
function RandomIDexists($id) {
  global $db;
  $returnvalue=false;
  // config
  $results = $db->query("SELECT randomid FROM config WHERE randomid='$id'");
  while ($row = $results->fetchArray()) {
    if (empty($row['randomid']) == FALSE) {
      $returnvalue=true;
    }
  }
  // blacklist
  $results = $db->query("SELECT entry FROM blacklist WHERE type='randomid' AND entry='$id'");
  while ($row = $results->fetchArray()) {
    if (empty($row['entry']) == FALSE) {
      $returnvalue=true;
    }
  }
  return $returnvalue;
}
function RandomSHORTexists($id) {
  global $db;
  $returnvalue=false;
  // content
  if (Contentexists($returnvalue) == true) {
    $returnvalue=true;
  }
  // blacklist
  $results = $db->query("SELECT entry FROM blacklist WHERE type='short' AND entry='$id'");
  while ($row = $results->fetchArray()) {
    if (empty($row['entry']) == FALSE) {
      $returnvalue=true;
    }
  }
  return $returnvalue;
}
function getFreeRandomID() {
  global $db;
  $returnvalue=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 5);
  while (RandomIDexists($returnvalue) == true) {
    $returnvalue=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 5);
  }
  return $returnvalue;
}
function getFreeRandomShort() {
  global $db;
  $returnvalue=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 5);
  while (RandomSHORTexists($returnvalue) == true) {
    $returnvalue=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 5);
  }
  return $returnvalue;
}
function getNewSalt() {
  $length=8;
  $cryptostrong=false;
  $bytes = openssl_random_pseudo_bytes($length, $cryptostrong);
  $hex   = bin2hex($bytes);
  return $hex;
}
function addToBlacklist($type, $entry) {
  global $db;
  $valueadded=date("Y-m-d H:i:s");
  $db-> exec("INSERT OR REPLACE INTO blacklist (added, type, entry) ".
             "VALUES ('$valueadded', '$type', '$entry')");
}
function UserIsAdmin($username) {
  global $db;
  $returnvalue=false;
  $results = $db->query("SELECT admin FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    if ($row['admin'] == 1) {
      $returnvalue=true;
    }
  }
  return $returnvalue;
}
function UserIsEnable($username) {
  global $db;
  $returnvalue=false;
  $results = $db->query("SELECT enable FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    if ($row['enable'] == 1) {
      $returnvalue=true;
    }
  }
  return $returnvalue;
}
function getIDFromUsername($username) {
  global $db;
  $returnvalue="0";
  $results = $db->query("SELECT id FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    if (empty($row['id']) == FALSE) {
      $returnvalue=$row['id'];
    }
  }
  return $returnvalue;
}
function getUsernameFromID($id) {
  global $db, $usernone;
  if ($id == "0") {
    return $usernone;
  }
  $returnvalue=$id;
  $results = $db->query("SELECT username FROM config WHERE id='$id'");
  while ($row = $results->fetchArray()) {
    if (empty($row['username']) == FALSE) {
      $returnvalue=$row['username'];
    }
  }
  return $returnvalue;
}
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function getLanguageFromUsername($username) {
  global $db;
  $returnvalue=getConfig("language");
  $results = $db->query("SELECT language FROM config WHERE username='$username'");
  while ($row = $results->fetchArray()) {
    if (empty($row['language']) == FALSE) {
      $returnvalue=$row['language'];
    }
  }
  return $returnvalue;
}
function getlang($key) {
  global $lang;
  $returnvalue="";
  if (!$returnvalue = $lang[$key]) {
    // not found in user-lang
    if (!$returnvalue = $lang[getConfig("language")]) {
      // not found in rd2-lang
      $returnvalue="[no translation]";
    } else {
      // found in rd2-lang
      $returnvalue="[".$returnvalue."]";
    }
  }
  return $returnvalue;
}
// -- -- -- -- --
// Content
// -- -- -- -- --
function isExpire($short) {
  $excontent=getExpire($short);
  if (empty($excontent)) {
    return false;
  }
  $exdate=date($excontent);
      if ($exdate < date("Y-m-d H:i:s")) {
        return true;
      }
  return false;
}
function getExpire($short) {
  global $db;
  $returnvalue="";
  $results = $db->query("SELECT expire FROM content WHERE short='$short'");
  while ($row = $results->fetchArray()) {
    $returnvalue = $row['expire'];
  }
  return $returnvalue;
}
// -- -- -- -- --
// Files
// -- -- -- -- --
function makeDownload($file, $dir, $type) {
  header('Content-Description: File Transfer');
  header('Content-Type: '.$type);
  header('Content-Disposition: attachment; filename='.$file);
  header('Content-Transfer-Encoding: binary');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
  header('Content-Length: ' . filesize($valuefile));
  ob_clean();
  flush();
  readfile($dir."/".$file);
}

class cFile {
  var $saved="";
  var $file="";
  var $size="0";
  var $lastchange="";
  var $md5="";
  var $sha1="";
  function cFile() {
    //
  }
  function getsavedFile($db) {
    $results = $db->query("SELECT saved, size, laschange, md5, sha FROM files WHERE file='$file'");
    while ($row = $results->fetchArray()) {
      $saved=$row['saved'];
      $size=$row['size'];
      $lastchange=$row['lastchange'];
      $md5=$row['md5'];
      $sha1=$row['sha1'];

    }
  }
  function saveFile($db) {
    $valuesaved=date('Y-m-d H:i:s');
    $db-> exec("INSERT OR REPLACE INTO files (saved, file, size, lastchange, md5, sha1) ".
               "VALUES ('$saved', '$file', '$size', '$lastchange', '$md5','$sha1')");
  }
}
function countFiles() {
  global $db;
  $results = $db->query("SELECT COUNT(*) FROM files");
  while ($row = $results->fetchArray()) {
    foreach ($row as $line) {
      return $line;
    }
  }
}
// -- -- -- -- --
// Logs
// -- -- -- -- --
function createLogEntry($kat, $entry, $arg1, $arg2, $arg3, $arg4, $arg5) {
  global $db;
  $valuetimestamp=date("Y-m-d H:i:s");
  $valueip=getRealIpAddr();
  $db-> exec("INSERT INTO logs (timestamp, kat, entry, ip, arg1, arg2, arg3, arg4, arg5) ".
             "VALUES ('$valuetimestamp', '$kat', '$entry', '$valueip', '$arg1', '$arg2', '$arg3', '$arg4', '$arg5')");
}
function countLogs() {
  global $db;
  $results = $db->query("SELECT COUNT(*) FROM logs");
  while ($row = $results->fetchArray()) {
    foreach ($row as $line) {
      return $line;
    }
  }
}
// -- -- -- -- --
// Config
// -- -- -- -- --
function setConfig($key, $value) {
  global $db;
  $db-> exec("INSERT OR REPLACE INTO configrd2 (key, value) ".
             "VALUES ('$key', '$value')");
}
function getConfig($key) {
  global $db;
  $returnvalue="";
  $results = $db->query("SELECT value FROM configrd2 WHERE key='$key'");
  while ($row = $results->fetchArray()) {
    $returnvalue=$row['value'];
  }
  return $returnvalue;
}
function isAllowContentAddAnonym() {
  global $db;
  $returnvalue=false;
  $results = $db->query("SELECT value FROM configrd2 WHERE key='allowcontentaddanonym'");
  while ($row = $results->fetchArray()) {
    if ($row['value'] == 1) {
      $returnvalue=true;
    }
  }
  return $returnvalue;
}
// -- -- -- -- --
// Captcha
// -- -- -- -- --
function getVerificationID() {
  $returnvalue=substr(str_shuffle("0123456789"), 0, 6);
  return $returnvalue;
}
function isVeriCodeCorrect($entry, $code) {
  global $db;
  $returnvalue=false;
  $results = $db->query("SELECT code FROM verification WHERE entry='$entry'");
  while ($row = $results->fetchArray()) {
    if ($row['code'] == $code) {
      $returnvalue=true;
    }
  }
  return $returnvalue;
}
function isVeriCodeExpired($entry) {
  global $db;
  $returnvalue=true;
  $results = $db->query("SELECT added FROM verification WHERE entry='$entry'");
  while ($row = $results->fetchArray()) {
    if ($row['added'] !== "") {
      $dateadded=date('Y-m-d H:i:s', strtotime($row['added']));
      $dateexpire=date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' - '.getConfig("veriexpire").' minutes'));
      if ($dateadded > $dateexpire) {
        $returnvalue=false;
      }
    }
  }
  return $returnvalue;
}
function removeVeriEntry($entry) {
  global $db;
  $db-> exec("DELETE FROM verification WHERE entry='$entry'");
}
function removeOldVeriEntrys() {
  global $db;
  $deletebefore=date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' - 1 days'));
  $db-> exec("DELETE FROM verification WHERE added<'$deletebefore'");
}
function createVeriEntry() {
  global $db;
  $veriEntry=date('YmdHis').getVerificationID();
  $veriCode=getVerificationID();
  $veriadded=date('Y-m-d H:i:s');
  $veriPic=createVerificationImage($veriCode);
  $db-> exec("INSERT OR REPLACE INTO verification (entry, code, added, pic) ".
             "VALUES ('$veriEntry', '$veriCode', '$veriadded', '$veriPic')");
  $returnarray=array();
  $returnarray['entry']=$veriEntry;
  $returnarray['code']=$veriCode;
  $returnarray['pic']=$veriPic;
  return $returnarray;
}
function createVerificationImage($strvalue) {
  $returnvalue="";
  // Set your string somehow
  $string = $strvalue;
  // Set font size
  $font_size = 4;
  // Create image width dependant on width of the string
  $width  = imagefontwidth($font_size)*strlen($string);
  // Set height to that of the font
  $height = imagefontheight($font_size);
  // Create the image pallette
  $img = imagecreate($width,$height);
  // Grey background
  //$bg    = imagecolorallocate($img, 25, 25, 25);
  $bg    = imagecolorallocate($img, 244, 244, 244);
  // White font color
  //$color = imagecolorallocate($img, 255, 255, 255);
  $color = imagecolorallocate($img, 0, 0, 0);
  // Length of the string
  $len = strlen($string);
  // Y-coordinate of character, X changes, Y is static
  $ypos = 0;
  // Loop through the string
  for($i=0;$i<$len;$i++){
      // Position of the character horizontally
      $xpos = $i * imagefontwidth($font_size);
      // Draw character
      imagechar($img, $font_size, $xpos, $ypos, $string, $color);
      // Remove character from string
      $string = substr($string, 1);
  }
  // Return the image
  ob_start();
  imagegif($img);
  $contents =  ob_get_contents();
  ob_end_clean();
  $base64 = base64_encode($contents);
  // Remove image
  imagedestroy($img);
  return $base64;
}
// -- -- -- -- --
// Sonstiges
// -- -- -- -- --
function wasGOOD() {
  global $colorwasGOOD;
  $returnvalue="<font style=\"font-size: 24px; color: ".$colorwasGOOD."\" >&#10004;</font>";
  return $returnvalue;
}
function wasBAD() {
  global $colorwasBAD;
  $returnvalue="<font style=\"font-size: 20px; color: ".$colorwasBAD."\" >&#10008;</font>";
  return $returnvalue;
}
// -- -- -- -- --
//  [...]
// -- -- -- -- --
/**
 * Recursively delete a directory
 *
 * @param string $dir Directory name
 * @param boolean $deleteRootToo Delete specified top-level directory as well
 */
function unlinkRecursive($dir, $deleteRootToo)
{
    if(!$dh = @opendir($dir))
    {
        return;
    }
    while (false !== ($obj = readdir($dh)))
    {
        if($obj == '.' || $obj == '..')
        {
            continue;
        }
        if (!@unlink($dir . '/' . $obj))
        {
            unlinkRecursive($dir.'/'.$obj, true);
        }
    }
    closedir($dh);
    if ($deleteRootToo)
    {
        @rmdir($dir);
    }
    return;
}
?>

