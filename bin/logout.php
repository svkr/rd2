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
logout-seite
<?php
$valueusername=$activeuser;
$valueislogin=0;
$valuelastlogout=date('Y-m-d H:i:s');
$db-> exec("UPDATE config SET username='$valueusername', islogin='$valueislogin', lastlogout='$valuelastlogout' WHERE username='$valueusername'");
if (getAutoBackup($activeuser) == 1) {
  doBackup("_auto");
}
header("Location: ./index.php");
?>
