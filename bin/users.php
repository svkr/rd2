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
&nbsp;<?php echo getlang("UsersTotal"); ?>: <font class="bold"><?php echo countUser(); ?></font><br />
<table>
<tr <?php echo $colorbg; ?>>
<td align="center"><font class="bold">username</font></td>
<td>&nbsp;</td>
<td align="center"><font class="bold">enable</font></td>
<td>&nbsp;</td>
<td align="center"><font class="bold">admin</font></td>
<td>&nbsp;</td>
<td align="center"><font class="bold">backup@logout</font></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<?php
$valueusername="";
$valueadmin="";
$valueenable="";
$results = $db->query("SELECT username, admin, enable, autobackup FROM config ORDER BY username COLLATE NOCASE ASC;");
while ($row = $results->fetchArray()) {
  $valueusername=$row['username'];
  $valueadmin=$row['admin'];
  $valueenable=$row['enable'];
  $valueautobackup=$row['autobackup'];
  echo "<tr>";
  echo "<form action=\"#\" method=\"post\">";
  // username
  if ($valueusername == $activeuser) {
    echo "<td><font class=\"textgreen\">".$valueusername."</font></td>";
  } else {
    echo "<td>".$valueusername."</td>";
  }
  echo "<td>&nbsp;</td>";
  // enable
  if ($valueenable == 1) {
    echo "<td align=\"center\"><input type=\"checkbox\" name=\"enable\" checked=\"Yes\" /></td>";
  } else {
    echo "<td align=\"center\"><input type=\"checkbox\" name=\"enable\" /></td>";
  }
  echo "<td>&nbsp;</td>";
  // admin
  if ($valueadmin == 1) {
    echo "<td align=\"center\"><input type=\"checkbox\" name=\"admin\" checked=\"Yes\" /></td>";
  } else {
    echo "<td align=\"center\"><input type=\"checkbox\" name=\"admin\" /></td>";
  }
  echo "<td>&nbsp;</td>";
  // backup@logout
  if ($valueautobackup == 1) {
    echo "<td align=\"center\"><input type=\"checkbox\" name=\"autobackup\" checked=\"Yes\" /></td>";
  } else {
    echo "<td align=\"center\"><input type=\"checkbox\" name=\"autobackup\" /></td>";
  }
  echo "<td>&nbsp;</td>";
  // save
  echo "<td align=\"center\">&nbsp;".
       "<input type=\"hidden\" name=\"showUsers\" />".
       "<input type=\"submit\" name=\"dosave\" value=\"".getlang("UsersBtnSave")."\" class=\"button\" />".
       "</td>";
  echo "<td>&nbsp;</td>";
  // del
  echo "<td align=\"center\">&nbsp;".
       "<form action=\"#\" method=\"post\">".
       "<input type=\"hidden\" name=\"showUsers\" />".
       "<input type=\"hidden\" name=\"username\" value=\"".$valueusername."\" />".
       "<input type=\"checkbox\" name=\"dodel\" class=\"docheckbox\" />".
       "<input type=\"submit\" name=\"del\" value=\"".getlang("UsersBtnRemove")."\" class=\"button\" />".
       "</form>";
       "</td>";
  echo "<td>&nbsp;</td>";
  // passwd
  echo "<td align=\"center\">&nbsp;".
       "<form action=\"#\" method=\"post\">".
       "<input type=\"hidden\" name=\"showUsers\" />".
       "<input type=\"hidden\" name=\"username\" value=\"".$valueusername."\" />".
       "<input type=\"checkbox\" name=\"doresetpasswd\" class=\"docheckbox\" />".
       "<input type=\"submit\" name=\"resetpasswd\" value=\"".getlang("UsersBtnResetPassword")."\" class=\"button\" />".
       "</form>";
       "</td>";
  echo "</form>";
  echo "</tr>";
};
?>
</table>
<a href="#top"><font class="small"><?php echo getlang("miscToTop"); ?></font></a><br />
&nbsp;
<p>
<u><?php echo getlang("UsersLegend"); ?></u>:<br />
<table>
<tr><td align="right"><font class="bold">username</font></td><td>&nbsp;->&nbsp;</td><td>&nbsp;</td>
<td><?php echo getlang("UsersLegUsername"); ?></td></tr>
<tr><td align="right"><font class="bold">enable</font></td><td>&nbsp;->&nbsp;</td><td align="center"><i><?php echo getlang("UsersInactive"); ?></i></td>
<td><?php echo getlang("UsersLegEnableOff"); ?></td></tr>
<tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="center"><i><?php echo getlang("UsersActive"); ?></i></td>
<td><?php echo getlang("UsersLegEnableOn"); ?> (<i><?php echo getlang("UsersLegDefault"); ?></i>)</td></tr>
<tr><td align="right"><font class="bold">admin</font></td><td>&nbsp;->&nbsp;</td><td align="center"><i><?php echo getlang("UsersInactive"); ?></i></td>
<td><?php echo getlang("UsersLegAdminOff"); ?> (<i><?php echo getlang("UsersLegDefault"); ?></i>)</td></tr>
<tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="center"><i><?php echo getlang("UsersActive"); ?></i></td>
<td><?php echo getlang("UsersLegAdminOn"); ?></td></tr>
<tr><td align="right"><font class="bold">backup@logout</font></td><td>&nbsp;->&nbsp;</td><td align="center"><i><?php echo getlang("UsersInactive"); ?></i></td>
<td><?php echo getlang("UsersLegAutoBUOff"); ?> (<i><?php echo getlang("UsersLegDefault"); ?></i>)</td></tr>
<tr><td align="right">&nbsp;</td><td>&nbsp;</td><td align="center"><i><?php echo getlang("UsersActive"); ?></i></td>
<td><?php echo getlang("UsersLegAutoBUOn"); ?></td></tr>
<tr><td align="right"><font class="bold">save</font></td><td>&nbsp;->&nbsp;</td><td align="center">&nbsp;</td>
<td><?php echo getlang("UsersLegSave"); ?></td></tr>
<tr><td align="right"><font class="bold">remove</font></td><td>&nbsp;->&nbsp;</td><td>&nbsp;</td>
<td><?php echo getlang("UsersLegRemove"); ?></td></tr>
</table>
