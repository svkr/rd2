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
<input type="checkbox" name="doclearLogs" class="docheckbox">
<input type="hidden" name="showLogs" />
<input type="submit" name="clearLogs" value="<?php echo getlang("LogsBtnRemoveAll"); ?>" class="button" />
</form>
<form action="#" method="post">
<input type="hidden" name="showLogs" />
<input type="submit" name="removeLogs" value="<?php echo getlang("LogsBtnRemoveSel"); ?>" class="button" />
<p>
&nbsp;<?php echo getlang("LogsTotal"); ?>: <font class="bold"><?php echo countLogs(); ?></font><br />
<table>
<tr align="center" <?php echo $colorbg; ?>>
<td><font class="bold">&nbsp;</font></td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("LogsTblTimestamp"); ?></font></td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("LogsTblIP"); ?></font></td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("LogsTblCat"); ?></font>
</td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("LogsTblEvent"); ?></font></td>
<td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("LogsTblArg1"); ?></font></td>
<td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("LogsTblArg2"); ?></font></td>
<td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("LogsTblArg3"); ?></font></td>
<td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("LogsTblArg4"); ?></font></td>
<td><td>&nbsp;&nbsp;&nbsp;</td>
<td><font class="bold"><?php echo getlang("LogsTblArg5"); ?></font></td>
</tr>
<?php
$results = $db->query("SELECT id, timestamp, kat, entry, ip, arg1, arg2, arg3, arg4, arg5 FROM logs ORDER BY DATETIME(timestamp) DESC");
$countDays=1;
$lastDate=date('2016-01-01');
while ($row = $results->fetchArray()) {
  $tsDate=date("Y-m-d", strtotime($row['timestamp']));
  if ($lastDate !== $tsDate) {
    $countDays=$countDays + 1;
    $lastDate=$tsDate;
  }
  if ($countDays % 2 == 0) {
    $strColortr=$colorbgfirst;
  } else {
    $strColortr=$colorbgsecond;
  }
  echo "<tr ".$strColortr.">";
  echo "<td><input type=\"checkbox\" name=\"toremove[]\" value=\"".$row['id']."\" /></td>";
  echo "<td>&nbsp;</td>";
  echo "<td>".date("d.m.Y H:i:s", strtotime($row['timestamp']))."</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>".$row['ip']."</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>".$row['kat']."</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>".$row['entry']."</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>".$row['arg1']."</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>".$row['arg2']."</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>".$row['arg3']."</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>".$row['arg4']."</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>".$row['arg5']."</td>";
  echo "</tr>";
};
?>
</table>
<a href="#top"><font class="small"><?php echo getlang("miscToTop"); ?></font></a><br />
</form>
