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
  $valueredirect=htmlspecialchars($_GET['rd'], ENT_COMPAT, 'UTF-8');
  if (Contentexists($valueredirect) == TRUE) {
    if (isExpire($valueredirect) == TRUE) {
      header("Location: index.php");
      exit();
    }
    if (passwdContent($valueredirect) == TRUE) {
//        exit();
    } else {
      $address=getlongContent($valueredirect);
      $address=urldecode($address);
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: ".$address);
      exit();
    }
  } else {
    header("Location: index.php");
    exit(); // existiert nicht
  }
?>
Bitte Passwort f&uuml;r '<font class="bold"><?php echo $_GET['rd']; ?></font>' eingeben:<p>
<form action="#" method="post">
<input type="password" name="passwd" />
<input type="hidden" name="redirect" value="<?php echo $_GET['rd']; ?>" />
<input type="submit" />
</form>
<?php
if (empty($_POST['passwd']) == FALSE) {
  $valueredirect=$_POST['rd'];
  if (isPasswdOkayContent($valueredirect, $_POST['passwd']) == TRUE) {
    $address=getlongContent($valueredirect);
    $address=urldecode($address);
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$address);
    exit();
  } else {
    exit(); // passwd falsch
  }
}
?>
