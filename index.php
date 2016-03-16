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

if (isset($_REQUEST['prepareUpdate'])) {

  $upfile="./bin/rd2updatezip.zip";

  if (!file_exists($upfile)) {

    echo "abort... updatefile not exists";
    exit();

  }

  $zip=zip_open($upfile);
  if ($zip) {
    while ($zip_entry = zip_read($zip)) {
      if (zip_entry_open($zip, $zip_entry)) {
        if (zip_entry_name($zip_entry) == "bin/update.php") {
          file_put_contents("./bin/update.php", zip_entry_read($zip_entry, 4194304));
        }
      }
    }
  }

  include ('./bin/update.php');

  startUpdateProcess();

} else {

  include ('./bin/index.php');

}

?>
