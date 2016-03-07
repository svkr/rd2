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
<form action="#" method="post">
<input type="hidden" name="doSaveFiles" />
<input type="submit" name="showFiles" value="<?php echo getlang("FilesBtnSave"); ?>" class="button" />
</form>
<table>
<tr><td <?php echo $colormissing; ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;<?php echo getlang("FilesNotFound"); ?> (!) / <?php echo getlang("FilesNotSaved"); ?></td></tr>
<tr><td <?php echo $colorequal; ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;<?php echo getlang("FilesFound"); ?> / <?php echo getlang("FilesEqual"); ?></td></tr>
<tr><td <?php echo $colordiff; ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;<?php echo getlang("FilesFound"); ?> / <?php echo getlang("FilesNotEqual"); ?> (!)</td></tr>
</table><br />
<table>
<tr align="center" <?php echo $colorbg; ?>>
<td><font class="bold"><?php echo getlang("FilesTblFile"); ?></font></td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("FilesTblSize"); ?></font></td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("FilesTblTimestamp"); ?></font></td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("FilesTblsha1"); ?></font></td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("FilesTblmd5"); ?></font></td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("FilesTblsaved"); ?></font></td>
<?php
if (isset($_REQUEST['doSaveFiles'])) {
  $db-> exec("DELETE FROM files");
}
$dir = new RecursiveDirectoryIterator('./');
$totalSize=0;
$Size=0;
$fileCount=0;
$files=array();
$index=0;
foreach (new RecursiveIteratorIterator($dir) as $file) {
  if (is_dir($file) == FALSE) {
    $files[$index++]=$file;
  }
}
sort($files, SORT_STRING);

foreach ($files as $file) {
  if (is_dir($file) == FALSE) {
    if (strstr($file->getFilename(), "rd2.content") == FALSE ) {
      $fileCount=$fileCount+1;
      $foundFile=new cFile();
      $foundFile->file=$file;
      $foundFile->saved="";
      $foundFile->size=$file->getSize();
      $foundFile->lastchange=date ("Y-m-d H:i:s", filemtime($file));
      $foundFile->md5=md5_file($file);
      $foundFile->sha1=sha1_file($file);

      if (isset($_REQUEST['doSaveFiles'])) {
        $db-> exec("INSERT OR REPLACE INTO files (saved, file, size, lastchange, md5, sha1) ".
                   "VALUES ('".date("Y-m-d H:i:s")."', '$foundFile->file', '$foundFile->size', '$foundFile->lastchange', '$foundFile->md5','$foundFile->sha1')");
      }

      $savedFile=new cFile();
      $savedFile->file=$file;
      $savedFile->saved="";
      $savedFile->size="";
      $savedFile->lastchange="";
      $savedFile->md5="";
      $savedFile->sha1="";

      $results = $db->query("SELECT saved, size, lastchange, md5, sha1 FROM files WHERE file='$file'");
      while ($row = $results->fetchArray()) {
        $savedFile->saved=$row['saved'];
        $savedFile->size=$row['size'];
        $savedFile->lastchange=$row['lastchange'];
        $savedFile->md5=$row['md5'];
        $savedFile->sha1=$row['sha1'];
    }

      $Size=$file->getSize();
      $Size=number_format($Size, 0, ',', '.');
      $color=$colormissing;
      if ($fileCount % 2 == 0) {
        echo "<tr ".$colorbgsecond.">";
      } else {
        echo "<tr ".$colorbgfirst.">";
      }
      if (empty($savedFile->size)) {
        $color=$colormissing;
      } else {
        if ($savedFile->file == $foundFile->file) {
          $color=$colorequal;;
        } else {
          $color=$colordiff;
        }
      }
      echo "<td $color>".$foundFile->file."</td><td>&nbsp;&nbsp;&nbsp;</td>";
      if (empty($savedFile->size)) {
        $color=$colormissing;
      } else {
        if ($savedFile->size == $foundFile->size) {
          $color=$colorequal;;
        } else {
          $color=$colordiff;
        }
      }
      echo "<td $color align=\"right\">".number_format($foundFile->size, 0, ',', '.')." B</td><td>&nbsp;&nbsp;&nbsp;</td>";
      if (empty($savedFile->lastchange)) {
        $color=$colormissing;
      } else {
        if ($savedFile->lastchange == $foundFile->lastchange) {
          $color=$colorequal;;
        } else {
          $color=$colordiff;
        }
      }
      echo "<td $color>".date("d.m.Y H:i:s", strtotime($foundFile->lastchange))."</td><td>&nbsp;&nbsp;&nbsp;</td>";
      if (empty($savedFile->sha1)) {
        $color=$colormissing;
      } else {
        if ($savedFile->sha1 == $foundFile->sha1) {
          $color=$colorequal;;
        } else {
          $color=$colordiff;
        }
      }
      echo "<td $color><font class=\"small\">".$foundFile->sha1."</font></td><td>&nbsp;&nbsp;&nbsp;</td>";

      if (empty($savedFile->md5)) {
        $color=$colormissing;
      } else {
        if ($savedFile->md5 == $foundFile->md5) {
          $color=$colorequal;;
        } else {
          $color=$colordiff;
        }
      }
      echo "<td $color><font class=\"small\">".$foundFile->md5."</font></td><td>&nbsp;&nbsp;&nbsp;</td>";
      $valuesaved="";
      if (empty($savedFile->saved) == FALSE) {
        $valuesaved=$savedFile->saved;
      }
      $formatedDate=$valuesaved;
      if (empty($formatedDate) == FALSE) {
        $formatedDate=date("d.m.Y H:i:s", strtotime($valuesaved));
      }
      echo "<td>".$formatedDate."</td>";
      echo "</tr>";
      $totalSize += $file->getSize();
    }
  }
}
$totalSize=number_format($totalSize, 0, ',', '.');
echo "<tr><td align=\"right\">".getlang("FilesTotalSize")."</td><td>&nbsp;&nbsp;&nbsp;</td><td><font class=\"bold\">".$totalSize." B</font></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
?>
</table>
<a href="#top"><font class="small"><?php echo getlang("miscToTop"); ?></font></a><br />
<p>
<?php echo getlang("FilesDisplay"); ?><br />
<font class="bold"><?php echo $fileCount;?></font> <?php echo getlang("FilesTotal"); ?><br />
<font class="bold"><?php echo countFiles();?></font> <?php echo getlang("FilesStored"); ?><br />
