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
  if (isset($_REQUEST['doBackup'])) {
    if (doBackup("_man") == TRUE ) {
      echo wasGOOD().getlang("BackupMsgBUdone").".<br />";
    } else {
      echo wasBAD().getlang("BackupMsgBUfail").".<br />";
    }
  }
  if (isset($_REQUEST['getdownload'])) {
    $valuefile=$_REQUEST['getdownload'];
    $dir=dirname($valuefile);
    $file=basename($valuefile);
    $type=mime_content_type($valuefile);
    $dir=$dir."/";
    makeDownload($file, $dir, $type);
  }
  if (isset($_REQUEST['delBackup'])) {
    if (isset($_REQUEST['checkdelBackup'])) {
      $file=basename($_REQUEST['delBackup']);
      $dir="./content/";
      if (file_exists($dir.$file)) {
        if (unlink($dir.$file)) {
          echo wasGOOD()."<font class=\"bold\">".$file."</font> ".getlang("BackupMsgBUdeleted").".<br />";
        }
      }
    } else {
      echo wasBAD().getlang("BackupMsgBUcheck").".<br />";
    }
  }
?>

<form action="#" method="post">
<input type="hidden" name="showBackup" />
<input type="submit" name="doBackup" value="<?php echo $lang['BackupBtnCreate']; ?>" class="button" />
</form>
<table>
<tr align="center"  <?php echo $colorbg; ?>>
<td><font class="bold"><?php echo $lang['BackupTimestamp']; ?></font></td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold">&nbsp;</font></td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo $lang['BackupFile']; ?></font></td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo $lang['BackupSize']; ?></font></td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo $lang['BackupSHA1']; ?></font></td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo $lang['BackupMD5']; ?></font></td></tr>
<?php
$dir = new RecursiveDirectoryIterator('./content/');
$totalSize=0;
$Size=0;
$bufiles=array();
$buindex=0;
$countColor=0;
foreach (new RecursiveIteratorIterator($dir) as $file) {
  if (is_dir($file) == FALSE) {
    $bufiles[$buindex++]=$file;
  }
}
sort($bufiles, SORT_STRING);
$bufiles=array_reverse($bufiles);
foreach ($bufiles as $file) {
  if (strstr($file->getFilename(), "rd2.content_") == TRUE ) {
    $countColor = $countColor + 1;
    $Size=$file->getSize();
    $Size=number_format($Size, 0, ',', '.');
         if ($countColor % 2 == 0) {
           echo "<tr ".$colorbgsecond.">";
         } else {
           echo "<tr ".$colorbgfirst.">";
         }
    echo "<td>".date ("d.m.Y H:i:s", filemtime($file))."</td><td>&nbsp;&nbsp;&nbsp;</td>".
         "<td nowrap>".
         "<form action=\"#\" method=\"post\" style=\"margin-bottom:0; float: right;\" />".
         "<input type=\"submit\" name=\"showBackup\" value=\"".getlang("BackupBtnDownload")."\" class=\"button\" />".
         "<input type=\"hidden\" name=\"getdownload\" value=\"".$file."\" />".
         "</form>".
         "<br />".
         "<form action=\"#\" method=\"post\" style=\"margin-bottom:0; float: right;\">".
         "<input type=\"checkbox\" name=\"checkdelBackup\" class=\"docheckbox\" />".
         "<input type=\"submit\" name=\"showBackup\" value=\"".getlang("BackupBtnRemove")."\" class=\"button\" />".
         "<input type=\"hidden\" name=\"delBackup\" value=\"".$file."\" />".
         "</form>".
         "</td><td>&nbsp;&nbsp;&nbsp;</td>".
         "<td><font class=\"small\">".$file->getFilename()."</font></td><td>&nbsp;&nbsp;&nbsp;</td>".
         "<td align=\"right\">".$Size." B</td><td>&nbsp;&nbsp;&nbsp;</td>".
         "<td><font class=\"small\">".sha1_file($file)."</font></td><td>&nbsp;&nbsp;&nbsp;</td>".
         "<td><font class=\"small\">".md5_file($file)."</font></td></tr>";
      $totalSize += $file->getSize();
    }
}
$totalSize=number_format($totalSize, 0, ',', '.');
echo "<tr><td></td><td></td><td></td><td></td><td align=\"right\">".getlang("BackupTotalSize").":</td><td>&nbsp;&nbsp;&nbsp;</td><td><font class=\"bold\">".$totalSize." B</font></td><td></td><td></td><td></td><td></td></tr>";
?>
</table>
<a href="#top"><font class="small"><?php echo getlang("miscToTop"); ?></font></a><br />
