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
<table>
<tr>
<td align="right">
<?php echo getlang("UsersUsername") ?>:
</td>
<td>
<input type="text" size="12" name="loginusername" />
</td>
</tr>
<tr>
<td align="right">
<?php echo getlang("UsersPassword") ?>:
</td>
<td>
<input type="password" size="12" name="loginpasswd" />
</td>
</tr>
<tr>
<td></td><td></td>
</tr>
<tr>
<td>
&nbsp;
</td>
<td>
<input type="hidden" name="showLogin" />
<input type="submit" name="doLogin" value="<?php echo getlang("UsersBtnLogin") ?>" class="button" />
</td>
</tr>
</table>
</form>

