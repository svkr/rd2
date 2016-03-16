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
$checkAllowContentAddAnonym="";
// schreiben
if (isset($_REQUEST['saveConfig'])) {
  $saveAllowContentAddAnonym="0";
  if (isset($_REQUEST['AllowContentAddAnonym'])) {
    $saveAllowContentAddAnonym="1";
  }
  $saverd2prefix=htmlspecialchars($_REQUEST['rd2prefix'], ENT_COMPAT, 'UTF-8');
  $saverd2prefixprotocol=htmlspecialchars($_REQUEST['rd2prefixprotocol'], ENT_COMPAT, 'UTF-8');
  $saveshowwelcomemessage="0";
  if (isset($_REQUEST['showWelcomeMessage'])) {
    $saveshowwelcomemessage="1";
  }
  $savewelcomemessage=urlencode($_REQUEST['WelcomeMessage']);
  $savemenutext=urlencode($_REQUEST['MenuText']);
  $savelanguage=htmlspecialchars($_REQUEST['language'], ENT_COMPAT, 'UTF-8');
  $saveshortmaxlength=htmlspecialchars($_REQUEST['ShortMaxLength'], ENT_COMPAT, 'UTF-8');
  $savecommentmaxlength=htmlspecialchars($_REQUEST['CommentMaxLength'], ENT_COMPAT, 'UTF-8');
  $saveveriexpire=htmlspecialchars($_REQUEST['VeriExpire'], ENT_COMPAT, 'UTF-8');
  setConfig("allowcontentaddanonym", $saveAllowContentAddAnonym);
  setConfig("rd2prefix", $saverd2prefix);
  setConfig("rd2prefixprotocol", $saverd2prefixprotocol);
  setConfig("showwelcomemessage", $saveshowwelcomemessage);
  setConfig("welcomemessage", $savewelcomemessage);
  setConfig("menutext", $savemenutext);
  setConfig("language", $savelanguage);
  setConfig("shortmaxlength", $saveshortmaxlength);
  setConfig("commentmaxlength", $savecommentmaxlength);
  setConfig("veriexpire", $saveveriexpire);

  echo wasGOOD().getlang("ConfigMsgSaved").".<p>";
}
// lesen
if (isAllowContentAddAnonym() == true) {
  $checkAllowContentAddAnonym=" checked=\"Yes\"";
}
$savedrd2prefix=getConfig("rd2prefix");
$savedrd2prefixprotocol=getConfig("rd2prefixprotocol");
$checkshowWelcomeMessage="";
if (getConfig("showwelcomemessage") == "1") {
  $checkshowWelcomeMessage=" checked=\"Yes\"";
}
$savedwelcomemessage=urldecode(getConfig("welcomemessage"));
$savedmenutext=urldecode(getConfig("menutext"));
$savedlanguage=getConfig("language");
$savedshortmaxlength=getConfig("shortmaxlength");
$savedcommentmaxlength=getConfig("commentmaxlength");
$savedveriexpire=getConfig("veriexpire");
?>
<form action="#" method="post">
<table class="box"><tr><td>
&nbsp;&nbsp;&nbsp;<?php echo getlang("ConfigLanguage"); ?>:&nbsp;
<select name="language">
<?php
foreach ($languages as $key => $value) {
  if ($value["Enable"] == "1") {
    if ($key == $savedlanguage) {
      echo "<option value=\"".$key."\" selected>".$key." (".$value["Name"].") ".$value["Info"]."</option>";
    } else {
      echo "<option value=\"".$key."\">".$key." (".$value["Name"].") ".$value["Info"]."</option>";
    }
  }
}
?>
</select>
<br />
&nbsp;&nbsp;&nbsp;<font class="small">( noch nicht komplett / not finished yet )</font>
</td></tr></table>
<p>
<table class="box"><tr><td>
&nbsp;&nbsp;<input type="checkbox" name="AllowContentAddAnonym" <?php echo $checkAllowContentAddAnonym; ?> class="docheckbox" />
<?php echo getlang("ConfigAddWithoutLogin"); ?>
</td></tr></table>
<p>
<table class="box"><tr><td>
&nbsp;&nbsp;&nbsp;<?php echo getlang("ConfigLengthShort"); ?>: <input type="number" name="ShortMaxLength" min="5" max="2000" style="width: 4em;" value="<?php echo $savedshortmaxlength; ?>"/>
&nbsp;<?php echo getlang("ConfigChars"); ?> (5-2000)<br />
</td></tr></table>
<p>
<table class="box"><tr><td>
&nbsp;&nbsp;&nbsp;<?php echo getlang("ConfigLengthComment"); ?>: <input type="number" name="CommentMaxLength" min="1" max="65535" style="width: 5em;" value="<?php echo $savedcommentmaxlength; ?>"/>
&nbsp;<?php echo getlang("ConfigChars"); ?> (1-65535)<br />
</td></tr></table>
<p>
<table class="box"><tr><td>
&nbsp;&nbsp;&nbsp;<?php echo getlang("ConfigVerificationExpire"); ?>: <input type="number" name="VeriExpire" min="1" max="1440" style="width: 4em;" value="<?php echo $savedveriexpire; ?>"/>
&nbsp;<?php echo getlang("ConfigMinutes"); ?> (1-1440)<br />
</td></tr></table>
<p>
<table class="box"><tr><td>
&nbsp;&nbsp;&nbsp;<?php echo getlang("ConfigPrefixredirect"); ?>:&nbsp;
<?php
echo "<select name=\"rd2prefixprotocol\">";

if ($savedrd2prefixprotocol == "http://") {
  echo "<option value=\"http://\" selected>http://</option>";
} else {
  echo "<option value=\"http://\">http://</option>";
}
if ($savedrd2prefixprotocol == "https://") {
  echo "<option value=\"https://\" selected>https://</option>";
} else {
  echo "<option value=\"https://\">https://</option>";
}
echo "</select>";
?>
<input type="text" name="rd2prefix" value="<?php echo $savedrd2prefix; ?>" /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class="small">( <?php echo getlang("ConfigReplacement"); ?> '<?php echo strtok("$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]",'?')."?rd="; ?>' )</font>
</td></tr></table>
<p>
<table class="box"><tr><td>
&nbsp;&nbsp;&nbsp;<?php echo getlang("ConfigMenuString"); ?> <font class="small">( <?php echo getlang("ConfigHTML"); ?> )</font><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="MenuText" rows="1" cols="45"><?php echo $savedmenutext; ?></textarea><br />
</td></tr></table>
<p>
<table class="box"><tr><td>
&nbsp;&nbsp;<input type="checkbox" name="showWelcomeMessage" <?php echo $checkshowWelcomeMessage; ?> class="docheckbox" />
<?php echo getlang("ConfigMessageStartpage"); ?> <font class="small">( <?php echo getlang("ConfigHTML"); ?> )</font><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="WelcomeMessage" rows="1" cols="45"><?php echo $savedwelcomemessage; ?></textarea><br />
</td></tr></table>
<p>
&nbsp;<br />
<input type="hidden" name="showConfig" />
&nbsp;&nbsp;&nbsp;<input type="submit" name="saveConfig" value="<?php echo getlang("ConfigBtnSaveConf"); ?>" class="button" />
</form>
