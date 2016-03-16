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
<?php
// Content del
  if (isset($_REQUEST['ContentDelShort'])) {
    $valuedelshort=htmlspecialchars($_REQUEST['showContent'], ENT_COMPAT, 'UTF-8');
    removeContent($valuedelshort);
    echo wasGOOD()."<font class=\"bold\">".$valuedelshort."</font> ".getlang("ContentAddMsgRemoved").".<p>";
  }
// #ContentAdd
$isadded=false; // wird später genutzt, um die Felder anschließend nicht erneut zu füllen
if (isset($_REQUEST['ContentAdd'])) {
  $doaddcontent=true;
  $valueshort = htmlspecialchars($_REQUEST['addshort'], ENT_COMPAT, 'UTF-8');
  $valuelong = $_REQUEST['addlong'];
  $valueexpire = htmlspecialchars($_REQUEST['addexpire'], ENT_COMPAT, 'UTF-8');
  $valuecomment = htmlspecialchars($_REQUEST['addcomment'], ENT_COMPAT, 'UTF-8');
  $valuepasswd = htmlspecialchars($_REQUEST['addpasswd'], ENT_COMPAT, 'UTF-8');
  $valuesalt="";
  // long leer?
  if (empty($valuelong)) {
    echo wasBAD().getlang("ContentAddMsgEmpty").".<p>";
    $doaddcontent=false;
  } else {
    // long - Protokoll vorhanden?
    $parsedlong=parse_url($valuelong, PHP_URL_SCHEME);
    if (empty($parsedlong)) {
      $valuelong="http://".$valuelong;
    }
    // long gültig?
    if (!filter_var($valuelong, FILTER_VALIDATE_URL) === false) {
      // valid url
    } else {
      echo wasBAD().getlang("ContentAddMsgFormat").". [".$valuelong."]<p>";
      $doaddcontent=false;
    }
  }
  // short leer?
  if (empty($valueshort)) {
    $valueshort=getFreeRandomShort();
    addToBlacklist("short", $valueshort);
  }
  // short zu lang?
  if (strlen($valueshort) > getConfig("shortmaxlength")) {
      echo wasBAD().getlang("ContentAddMsgToLongShort")." ".getConfig("shortmaxlength").".<p>";
      $doaddcontent=false;
  }
  // bereits vorhanden?
  if (isset($_REQUEST['dontcheck']) == FALSE) {
    if (Contentexists($valueshort) == TRUE) {
      echo wasBAD()."<font class=\"bold\">".$valueshort."</font> ".getlang("ContentAddMsgExists").".<p>";
      $valueshort=getFreeRandomShort();
      addToBlacklist("s", $valueshort);
    }
  }
  // Datum gültig?
  if (empty($valueexpire) == FALSE) {
    if (strtotime($valueexpire)) {
        $valueexpire=date("Y-m-d H:i:s", strtotime($valueexpire));
    } else {
      echo wasBAD().getlang("ContentAddMsgDate").".<p>";
      $doaddcontent=false;
    }
  }
  // comment zu lang?
  if (strlen($valuecomment) > getConfig("commentmaxlength")) {
      echo wasBAD().getlang("ContentAddMsgToLongComment")." ".getConfig("commentmaxlength").".<p>";
      $doaddcontent=false;
  }
   // ein leeres passwd wird nicht gehasht, da "leer" später noch genutzt wird; ToDo: ggf. hash-Wert von leer statt nur leer nutzen;
   if (empty($valuepasswd) == FALSE) {
     $valuesalt=getNewSalt();
     $valuepasswd=password_hash($valuepasswd.$valuesalt, PASSWORD_DEFAULT);
   }
   if ($doaddcontent == true) {
     $valueadded=date('Y-m-d H:i:s');
     $valueactiveuser=$activeuser;
     $valueowner = getIDFromUsername(htmlspecialchars($_REQUEST['addowner'], ENT_COMPAT, 'UTF-8'));
     $valueip=getRealIpAddr();
     $valuelong=urlencode($valuelong);
     $valuecomment=urlencode($valuecomment);
     $db-> exec("INSERT OR REPLACE INTO content (short, long, passwd, salt, expire, added, owner, ip, comment) VALUES ('$valueshort', '$valuelong', '$valuepasswd', '$valuesalt', '$valueexpire', '$valueadded', '".$valueowner."', '$valueip', '$valuecomment')");
     //
     $savedrd2prefix=getConfig("rd2prefix");
     $savedrd2prefixprotocol=getConfig("rd2prefixprotocol");
     if ($savedrd2prefix == "") {
       $valueredirectlink=strtok("$_SERVER[REQUEST_URI]",'?')."?rd=".$valueshort;
       $valueredirectlinkstr=strtok("$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",'?')."?rd=".$valueshort;
     } else {
       $valueredirectlink=$savedrd2prefixprotocol.$savedrd2prefix.$valueshort;
       $valueredirectlinkstr=$valueredirectlink;
       if (!strstr($valueredirectlinkstr, "https://")) {
          $valueredirectlinkstr=str_replace("http://", "", $valueredirectlinkstr);
       }
     }
     echo wasGOOD()."<font class=\"bold\">".$valueshort."</font> ".getlang("ContentAddCreated").". [".urldecode($valuelong)."]<br />&nbsp;<br />";
     echo "=> &nbsp;&nbsp;&nbsp;".getlang("ContentAddShortUrl").": <font class=\"bold\">".$valueredirectlinkstr."</font>&nbsp;&nbsp;&nbsp;<a href=\"".$valueredirectlink."\" target=\"_new\"><font class=\"small\">".getlang("ContentAddOpenNewTab")."</a></font>";
     echo "<p>&nbsp;<p>";
     $isadded=true;
   }
}
?>
<?php
$valueaddlong="";
$valueaddpasswd="";
$valueaddexpire="";
$valueaddowner="";
if (isset($_REQUEST['ContentEditShort'])) {
  echo "<font class=\"bold\">".getlang("ContentEditAction").":</font><p>";
  $valueaddshort=$_REQUEST['ContentEditShort'];
  $results = $db->query("SELECT added, expire, passwd, long, owner, comment FROM content WHERE short='$valueaddshort'");
  while ($row = $results->fetchArray()) {
    $valueaddlong=$row['long'];
    $valueaddexpire=$row['expire'];
    $valueaddcomment=urlencode($row['comment']);
    $valueaddowner=$row['owner'];
  };
} else {
  echo "<font class=\"bold\">".getlang("ContentAddAction").":</font><p>";
}
echo "</td><td>";
echo "<table border=\"0\">";
// ### prepare
if (isset($_REQUEST['ContentEditShort'])) {

} else {
  $existsshort="";
  $existslong="";
  $existspasswd="";
  $existsexpire="";
  $existscomment="";
  if ($isadded==false) {
    if (isset($_REQUEST['addshort'])) { $existsshort=$_REQUEST['addshort']; }
    if (isset($_REQUEST['addlong'])) { $existslong=$_REQUEST['addlong']; }
    if (isset($_REQUEST['addpasswd'])) { $existspasswd=$_REQUEST['addpasswd']; }
    if (isset($_REQUEST['addexpire'])) { $existsexpire=$_REQUEST['addexpire']; }
    if (isset($_REQUEST['addcomment'])) { $existscomment=$_REQUEST['addcomment']; }
  }
}
// ### long
if (isset($_REQUEST['ContentEditShort'])) {
  echo "<tr>";
  echo "<td></td>";
  echo "<td><font class=\"bold\">".getlang("ContentAddLong")."</font>:</td>".
       "<td><input type=\"text\" size=\"19\" name=\"addlong\" value=\"".urldecode($valueaddlong)."\" />".
       " (".getlang("ContentAddRequired").") ".getlang("ContentAddExample")." '<font class=\"mono\">https://duckduckgo.com/</font>'</td></tr>";
} else {
  echo "<tr>";
  echo "<td>&nbsp;&nbsp;&nbsp;</td>";
  echo "<td><font class=\"bold\">".getlang("ContentAddLong")."</font>:</td>".
       "<td><input type=\"text\" size=\"19\" name=\"addlong\" value=\"".$existslong."\" />".
       " (".getlang("ContentAddRequired").") ".getlang("ContentAddExample")." '<font class=\"mono\">https://duckduckgo.com/</font>'</td></tr>";
  echo "<tr>";
}
// ### short
if (isset($_REQUEST['ContentEditShort'])) {
  echo "<tr>";
  echo "<td>&nbsp;&nbsp;&nbsp;</td>";
  echo "<td>".getlang("ContentAddShort").":</td>";
  //echo "<td><input type=\"text\" size=\"19\" name=\"addshort\" value=\"".$valueaddshort."\" READONLY /></td>".
  echo "<td>".$valueaddshort."<input type=\"hidden\" name=\"addshort\" value=\"".$valueaddshort."\"></td>".
       "</tr>";
} else {
  echo "<td>&nbsp;&nbsp;&nbsp;</td>";
  echo "<td><font class=\"small\">(optional)</font> ".getlang("ContentAddShort").":</td>".
       "<td><input type=\"text\" size=\"19\" name=\"addshort\" value=\"".$existsshort."\" />".
       " ".getlang("ContentAddExample")." '<font class=\"mono\">duck</font>'</td></tr>";
}
// ### passwd
if (isset($_REQUEST['ContentEditShort'])) {
  echo "<tr>";
  echo "<td>&nbsp;&nbsp;&nbsp;</td>";
  echo "<td><font class=\"small\">(optional)</font> ".getlang("ContentAddPassword").":</td>".
       "<td><input type=\"password\" size=\"19\" name=\"addpasswd\" />";
  if (passwdContent($valueaddshort) == TRUE) {
    echo "<font class=\"textredsmall\">&nbsp;".getlang("ContentAddPasswordExists")."!</font>";
  }
  echo "</td></tr>";
} else {
  echo "<tr>";
  echo "<td>&nbsp;&nbsp;&nbsp;</td>";
  echo "<td><font class=\"small\">(optional)</font> ".getlang("ContentAddPassword").":</td>".
       "<td><input type=\"password\" size=\"19\" name=\"addpasswd\" value=\"".$existspasswd."\" /></td></tr>";
}
// ### expire
if (isset($_REQUEST['ContentEditShort'])) {
  if (!empty($valueaddexpire)) {
  $valueaddexpire=date("d.m.Y H:i:s", strtotime($valueaddexpire));
  }
  echo "<td>&nbsp;&nbsp;&nbsp;</td>";
  echo "<td><font class=\"small\">(optional)</font> ".getlang("ContentAddExpire").":</td>".
       "<td><input type=\"text\" size=\"19\" name=\"addexpire\" value=\"".$valueaddexpire."\" />".
       " ".getlang("ContentAddExample")." '<font class=\"mono\"><i>".date('d.m.Y', strtotime(date('d-m-Y'). ' + 7 days'))."</i></font>' oder ".
       "'<font class=\"mono\"><i>".date('d.m.Y', strtotime(date('d-m-Y'). ' + 7 days'))." 20:00:00</i></font>' ".
       "[d.m.Y H:i:s]</td></tr>";
} else {
  echo "<tr>";
  echo "<td>&nbsp;&nbsp;&nbsp;</td>";
  echo "<td><font class=\"small\">(optional)</font> ".getlang("ContentAddExpire").":</td>".
       "<td><input type=\"text\" size=\"19\" name=\"addexpire\" value=\"".$existsexpire."\" />".
       " ".getlang("ContentAddExample")." '<font class=\"mono\"><i>".date('d.m.Y', strtotime(date('d-m-Y'). ' + 7 days'))."</i></font>' oder ".
       "'<font class=\"mono\"><i>".date('d.m.Y', strtotime(date('d-m-Y'). ' + 7 days'))." 20:00:00</i></font>' ".
       "[d.m.Y H:i:s]</font></td></tr>";
}
// ### comment
if (isset($_REQUEST['ContentEditShort'])) {
  echo "<td>&nbsp;&nbsp;&nbsp;</td>";
  echo "<td><font class=\"small\">(optional)</font> ".getlang("ContentAddComment").":</td>".
       "<td><input type=\"text\" size=\"19\" name=\"addcomment\" value=\"".$valueaddcomment."\" /></td>".
       "</tr>";
  echo "<tr>";
} else {
  echo "<td>&nbsp;&nbsp;&nbsp;</td>";
  echo "<td><font class=\"small\">(optional)</font> ".getlang("ContentAddComment").":</td>".
       "<td><input type=\"text\" size=\"19\" name=\"addcomment\" value=\"".$existscomment."\" /></td>".
       "</tr>";
}
// ### owner
if (isset($_REQUEST['ContentEditShort'])) {
  if (UserIsAdmin($activeuser)) {
    echo "<td>&nbsp;&nbsp;&nbsp;</td>";
    echo "<td>".getlang("ContentEditOwner").":</td>".
         "<td>".
         "<select name=\"addowner\">";
         $results = $db->query("SELECT id, username FROM config");
         while ($row = $results->fetchArray()) {
           if (empty($row['username']) == FALSE) {
             if ($row['id'] == $valueaddowner) {
               echo "<option value=\"".$row['username']."\" selected>".$row['username']."</option>";
             } else {
               echo "<option value=\"".$row['username']."\">".$row['username']."</option>";
             }
           }
         }
    echo "</select>".
         "</td></tr>";
    echo "</tr>";
  }
} else {

}
// ### Buttons - Start
  echo "<tr>".
       "<td>&nbsp;&nbsp;&nbsp;</td>".
       "<td>&nbsp;</td>".
       "<td>".
       "<table border=\"0\">".
       "<tr>".
       "<td>";

  echo "<form action=\"#\" method=\"post\" style=\"margin-bottom:0;\">";
  if ($activeuser == "#none#") {
    echo "<input type=\"hidden\" name=\"showContentAnonym\" />";
  } else {
    echo "<input type=\"hidden\" name=\"showContent\" />";
  }
       if (isset($_REQUEST['ContentEditShort'])) {
         echo "<input type=\"hidden\" name=\"dontcheck\" />";
       }
  echo "<input type=\"hidden\" name=\"ContentAdd\" />";
  if (isset($_REQUEST['ContentEditShort'])) {
    echo "<input type=\"submit\" name=\"Save\" value=\"".getlang("ContentEditBtnSave")."\" class=\"button\" />";
  } else {
    echo "<input type=\"submit\" name=\"Save\" value=\"".getlang("ContentAddBtnCreate")."\" class=\"button\" />";
  }
  echo "</form>".
       "</td>";
  if (isset($_REQUEST['ContentEditShort'])) {
    echo "<td><form action=\"#\" method=\"post\" style=\"margin-bottom:0;\">".
         "<input type=\"submit\" name=\"showContent\" value=\"".getlang("ContentEditBtnAbort")."\" class=\"button\" />".
         "</form>".
         "</td>";
    echo "<td><form action=\"#\" method=\"post\" style=\"margin-bottom:0;\">".
         "<input type=\"submit\" name=\"ContentDelShort\" value=\"".getlang("ContentEditBtnRemove")."\" class=\"button\" />".
         "<input type=\"hidden\" name=\"showContent\" value=\"".$valueaddshort."\" />".
         "</form>".
         "</td>";
  } else {
    echo "<input type=\"hidden\" name=\"addowner\" value=\"".$activeuser."\" />";
  }
  echo "</tr>".
       "</table>".
       "</td></tr>";
// ### Buttons - Ende
?>
</table>
</td></tr></table>

