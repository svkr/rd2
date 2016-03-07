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
&nbsp;&nbsp;&nbsp;
<input type="hidden" name="showSettings" />
<input type="submit" name="reset" value="<?php echo getlang("ResetBtnReset") ?>" class="button" />
<input type="checkbox" name="doreset" value="1" class="docheckbox" />&nbsp;<font class="textred" ><?php echo getlang("ResetConfirm") ?>!</font><br />
</form>

