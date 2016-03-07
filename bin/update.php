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
function startUpdateProcess() {
  echo "&nbsp;<p><b>rd2</b>-Update<br />";
  echo "&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;update is running...<p>";
  echo "trying to get maintenance...<br />";
  if (createMaintenance() == false) {
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;abort! no maintenance<p>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;you can try to update again<p />";
    exit();
  }
  echo "checking database...<br />";
  DBUpdate();
  echo "updating files...<br />";
  extractZip();
  echo "restore from maintenance...<br />";
  $upfile="./bin/rd2updatezip.zip";
  $result = file_get_contents('zip://'.$upfile.'#bin/index.php'); 
  if (file_put_contents("bin/index.php", $result) === FALSE) {
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;abort! can't restore /bin/index.php<p>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;you can try to update again<p />";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;call <a href=\"index.php?prepareUpdate\">index.php?prepareUpdate</a><p />";
    exit();
  }
  unlink($upfile);
  echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;update complete.<p><a href=\"index.php\" target=\"_self\"> back to mainpage</a><br />";
}
function createMaintenance() {
$htmlMaintenance="<html><head><title>rd2 - maintenance</title></head><body><b>rd2</b> - maintenance<p>please try again in a few minutes</body></html>";
if (file_put_contents("./bin/index.php", $htmlMaintenance) == TRUE) {
  return true;
} else{
  return false;
}
}
function extractZip() {
  $zip="";
        $zip = zip_open("./bin/rd2updatezip.zip");
        if ($zip) {
        while ($zip_entry = zip_read($zip)) {
          if (zip_entry_open($zip, $zip_entry)) {
            if (zip_entry_name($zip_entry) !== "bin/update.php" && 
                zip_entry_name($zip_entry) !== "bin/index.php" && 
                zip_entry_name($zip_entry) !== "index.php") {

              $content=zip_entry_read($zip_entry, 4194304); // 4MB
              if (!is_dir(zip_entry_name($zip_entry))) {
                $local = "";
                if (file_exists(zip_entry_name($zip_entry))) {
                  $local=file_get_contents(zip_entry_name($zip_entry));
                }
                if ($content !== $local) {
                  if (is_writable(zip_entry_name($zip_entry))) {
                     file_put_contents(zip_entry_name($zip_entry), $content);
                  } else {
                    echo "&nbsp;&nbsp;>error: no write permission [".zip_entry_name($zip_entry)."]<br />";
                  }
                }
              }
            }
          }
        }
      }
      zip_close($zip);
}
?>
<?php
if (!empty($_FILES["sourcefile"])) {
  echo "<table>";
  echo "&nbsp;&nbsp;&nbsp;<font class=\"mono\" >".$rd2Version."</font>&nbsp;&nbsp;".getlang("UpdateIsRunning");
  echo "</table>";
//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
// visuell & Form
//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
  $abort = false;
  $srcName = $_FILES["sourcefile"] ["name"];
  // leer
  if (empty($srcName)) {
    echo wasBAD().getlang("UpdateMsgFailFile")."."."<br />";
    $abort = true;
  }
  $srcType = $_FILES["sourcefile"] ["type"];
  $srcSize = $_FILES["sourcefile"] ["size"];
  $srcTmpName = $_FILES["sourcefile"] ["tmp_name"];
  if ($abort == false) {
    $srcSHA1 = sha1_file($srcTmpName);
  }
  $srcVersion = "";
  if (isset($_REQUEST['sourcesha1'])) {    
    if ($abort == false) {
      // SHA1
      $sourcesha1=htmlspecialchars($_REQUEST['sourcesha1'], ENT_COMPAT, 'UTF-8');
      if (!empty($sourcesha1)) {
        if ($sourcesha1 !== $srcSHA1) {
          echo wasBAD().getlang("UpdateMsgFailChecksum")." [".$srcSHA1."]"."<br />";
          $abort = true;
        }
      }
    }
    if ($abort == false) {
      // fileType
      if ($srcType !== "application/zip") {
        echo wasBAD().getlang("UpdateMsgFailType")."<br />";
        $abort = true;
      }
    }
    if ($abort == false) {
      // functions.php exists
      $zip="";
        $zip = zip_open($srcTmpName);
        if ($zip) {
        while ($zip_entry = zip_read($zip)) {
          if (zip_entry_open($zip, $zip_entry)) {
            if (zip_entry_name($zip_entry) == "bin/functions.php") {
              // get Version
              $contentfunc=zip_entry_read($zip_entry);
              $line = strtok($contentfunc, "\r\n");
              while ($line !== false) {
                # do something with $line
                $line = strtok( "\r\n" );
                if (strpos($line, "\$rd2Version=\"") !== false) {
                  $line = str_replace("\$rd2Version=\"" , "", $line);
                  $line = str_replace("\";" , "", $line);
                  $srcVersion = $line;
                }
              }
            }
          }
        }
      }
      zip_close($zip);
    }
    if ($abort == false) {
      if (empty($srcVersion)) {
        echo wasBAD().getlang("UpdateMsgFailContent")."<br />";
        $abort = true;
      }
    }
    if ($abort == false) {
      echo "&nbsp;&nbsp;&nbsp;<font class=\"mono\" >".$srcVersion."</font>&nbsp;&nbsp;".getlang("UpdateContain");

      $isNewer=false;
      $ARsrcVersion=explode(".", $srcVersion);
      $ARrd2Version=explode(".", $rd2Version);

      if ( intval($ARsrcVersion[0].$ARsrcVersion[1].$ARsrcVersion[2]) > intval($ARrd2Version[0].$ARrd2Version[1].$ARrd2Version[2]) ) {
        $isNewer=true;
      }

      if ($isNewer == true) {

	$srcData=file_get_contents($srcTmpName);
	file_put_contents("./bin/rd2updatezip.zip", $srcData);

	echo "<table>";
	echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        echo "<form action=\"#\" method=\"post\">";
        echo "<td>".
             "<font class=\"textredsmall\"> ".getlang("UpdateLine1")."!</font><font class=\"small\"> ".getlang("UpdateLine2").".</font><br />".
             "<input type=\"submit\" value=\"".getlang("UpdateBtnUpdate")."\" class=\"button\" />".
             "<input type=\"hidden\" name=\"prepareUpdate\" />".
             "</td></tr>";
        echo "</form>";
        echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        echo "<td>".
             "<form action=\"#\" method=\"post\">".
             "<input type=\"submit\" value=\"".getlang("UpdateBtnAbort")."\" class=\"button\" />".
             "<input type=\"hidden\" name=\"showConfig\" />".
             "</td>";
        echo "</form>";
        echo "</tr></table>";
      } else {
	echo "<table>";
	echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
	echo "<td>".getlang("UpdateUptodate").".".
             "</td></tr>";
	echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        echo "<form action=\"#\" method=\"post\">";
        echo "<td>";
        echo "<input type=\"submit\" value=\"".getlang("UpdateBtnAbort")."\" class=\"button\" />".
             "<input type=\"hidden\" name=\"showConfig\" />".
             "</td>";
        echo "</form>";
        echo "</tr></table>";
      }
    } else {
      // es sind Fehler aufgetreten
      echo "<form action=\"#\" method=\"post\">";
      echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" value=\"".getlang("UpdateBtnAbort")."\" class=\"button\" />".
           "<input type=\"hidden\" name=\"showConfig\" />";
      echo "</form>";
    }
  }
} else {
  if (isset($_REQUEST['showConfig'])) {    
    echo "<table>";
    if ( intval(getConfig("dbversion")) < intval($latestdbversion)) {
      DBUpdate();
      echo "<tr><td>&nbsp;&nbsp;&nbsp;<font class=\"mono\" >".wasGOOD().getlang("UpdateMsgFailFile").".</font></td></tr>";
      echo "<tr><td>&nbsp;</td></tr>";
    }
    echo "<tr><td>&nbsp;&nbsp;&nbsp;<font class=\"mono\" >".$rd2Version."</font>&nbsp;&nbsp;".getlang("UpdateIsRunning")."</td></tr>";
    echo "</table>";
    echo "<form action=\"#\" method=\"post\" enctype=\"multipart/form-data\">";
    echo "<table>";
    echo "<tr><td>&nbsp;&nbsp;&nbsp;</td><td align=\"right\">".getlang("UpdateFile").":</td><td><input type=\"file\" name=\"sourcefile\"></td></tr>";
    echo "<tr><td>&nbsp;&nbsp;&nbsp;</td><td align=\"right\">".getlang("UpdateSHA1").":</td><td><input type=\"text\" name=\"sourcesha1\" size=\"13\" />&nbsp;(".getlang("UpdateOptional").")</td></tr>";
    echo "<tr><td>&nbsp;&nbsp;&nbsp;</td><td align=\"right\"></td><td><input type=\"hidden\" Name=\"showConfig\" /><input type=\"submit\" value=\"".getlang("UpdateBtnUpload")."\" class=\"button\" /></td></tr>";
    echo "</table>";
    echo "</form>";
  }
}
//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
// DB-Updates
//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
function DBUpdate() {
  $fileDB="./content/rd2.content";
  $db=new SQLite3($fileDB);
  $updateisneed=true;
  while ($updateisneed == true) {
    // get running Version
    $runningVersion="";
    $results = $db->query("SELECT value FROM configrd2 WHERE key='dbversion'");
    while ($row = $results->fetchArray()) {
      $runningVersion=$row['value'];
    }
    // Update
    switch ($runningVersion) {
      case 2:
        $db-> exec("INSERT OR REPLACE INTO configrd2 (key, value) ".
                   "VALUES ('commentmaxlength', '1024')");
        $db-> exec("INSERT OR REPLACE INTO configrd2 (key, value) ".
                   "VALUES ('dbversion', '3')");
        break;
      case 1:
        $db-> exec("INSERT OR REPLACE INTO configrd2 (key, value) ".
                   "VALUES ('shortmaxlength', '255')");
        $db-> exec("INSERT OR REPLACE INTO configrd2 (key, value) ".
                   "VALUES ('veriexpire', '10')");
        $db-> exec("INSERT OR REPLACE INTO configrd2 (key, value) ".
                   "VALUES ('dbversion', '2')");
        break;
      default:
        $updateisneed=false;
        break;
    }
  }
}

?>







