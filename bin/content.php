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
$searchfor="";
if (isset($_REQUEST['doSearch'])) {
  $searchfor=htmlspecialchars($_REQUEST['searchFor'], ENT_COMPAT, 'UTF-8');
}
?>
<form action="#" method="post">
<?php echo getlang("ContentSearchFor"); ?>&nbsp;*:&nbsp;
<input type="text" name="searchFor" value="<?php echo $searchfor; ?>" size=12 />&nbsp;
<input type="hidden" name="showContent" />
<input type="submit" name="doSearch" value="<?php echo getlang("ContentBtnSearch"); ?>" class="button" />
<?php
if (isset($_REQUEST['doSearch'])) {
  echo "<p /> ".getlang("ContentSearchResult")." <font class=\"bold\">".$searchfor."</font>:";
}
?>
</form>
<table>
<tr align="center" <?php echo $colorbg; ?>>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td class="content">&nbsp;<br /><font class="bold"><?php echo getlang("ContentShort"); ?></font>&nbsp;*<br />
<form action="#" method="post" class="sortleft"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="shortASC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25B2;" /></form>
<form action="#" method="post" class="sortright"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="shortDESC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25BC;" /></form></td>
<td>&nbsp;</td>
<td class="content">&nbsp;<br /><font class="bold"><?php echo getlang("ContentEdited"); ?></font><br />
<form action="#" method="post" class="sortleft"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="editedASC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25B2;" /></form>
<form action="#" method="post" class="sortright"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="editedDESC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25BC;" /></form></td>
<td>&nbsp;</td>
<td class="content">&nbsp;<br /><font class="bold"><?php echo getlang("ContentExpire"); ?></font><br />
<form action="#" method="post" class="sortleft"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="expireASC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25B2;" /></form>
<form action="#" method="post" class="sortright"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="expireDESC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25BC;" /></form></td>
<td>&nbsp;</td>
<td class="content">&nbsp;<br /><font class="bold"><?php echo getlang("ContentPasswordisset"); ?></font><br />
<form action="#" method="post" class="sortleft"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="passwdASC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25B2;" /></form>
<form action="#" method="post" class="sortright"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="passwdDESC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25BC;" /></form></td>
<td>&nbsp;</td>
<td class="content">&nbsp;<br /><font class="bold"><?php echo getlang("ContentShortUrl"); ?></font><br />&nbsp;<br />
<form action="#" method="post" class="sortleft"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="urlshortASC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25B2;" /></form>
<form action="#" method="post" class="sortright"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="urlshortDESC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25BC;" /></form></td>
<td>&nbsp;</td>
<?php
if (UserIsAdmin($activeuser)) {
  echo "<td class=\"content\">&nbsp;<br /><font class=\"bold\">".getlang("ContentOwner")."</font>&nbsp;*<br />";
  echo '<form action="#" method="post" class="sortleft"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="ownerASC" />';
  echo '<input type="submit" name="showContent" class="buttonsort" value="&#x25B2;" /></form>';
  echo '<form action="#" method="post" class="sortright"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="ownerDESC" />';
  echo '<input type="submit" name="showContent" class="buttonsort" value="&#x25BC;" /></form></td>';
  echo "<td>&nbsp;</td>";
}
?>
<td class="content">&nbsp;<br /><font class="bold"><?php echo getlang("ContentComment"); ?></font>&nbsp;*<br />&nbsp;<br />
<form action="#" method="post" class="sortleft"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="commentASC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25B2;" /></form>
<form action="#" method="post" class="sortright"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="commentDESC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25BC;" /></form></td>
<td>&nbsp;</td>
<td class="content">&nbsp;<br /><font class="bold"><?php echo getlang("ContentLong"); ?></font>&nbsp;*<br />&nbsp;<br />
<form action="#" method="post" class="sortleft"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="urllongASC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25B2;" /></form>
<form action="#" method="post" class="sortright"><input type="hidden" name="showContent" /><input type="hidden" name="orderBy" value="urllongDESC" />
<input type="submit" name="showContent" class="buttonsort" value="&#x25BC;" /></form></td>
</tr>
<?php
  if (UserIsAdmin($activeuser)) {
    echo "&nbsp;".getlang("ContentTotal").": <font class=\"bold\">".countContent()."</font> (".countContentUser($activeuser)." ".getlang("ContentOwn").")<br />";
  } else {
    echo "&nbsp;".getlang("ContentTotal").": <font class=\"bold\">".countContentUser($activeuser)."</font><br />";
  }
  $orderby="editedDESC"; // Default
  if (isset($_REQUEST['orderBy'])) {
    $orderby=htmlspecialchars($_REQUEST['orderBy'], ENT_COMPAT, 'UTF-8');
  }
  // Sort - Start
  switch ($orderby) {
    case "shortASC":
      $strorderby="ORDER BY short ASC";
      break;
    case "shortDESC":
      $strorderby="ORDER BY short DESC";
      break;
    case "editedASC":
      $strorderby="ORDER BY DATETIME(added) ASC";
      break;
    case "editedDESC":
      $strorderby="ORDER BY DATETIME(added) DESC";
      break;
    case "expireASC":
      $strorderby="ORDER BY DATETIME(expire) ASC";
      break;
    case "expireDESC":
      $strorderby="ORDER BY DATETIME(expire) DESC";
      break;
    case "passwdASC":
      $strorderby="ORDER BY passwd ASC";
      break;
    case "passwdDESC":
      $strorderby="ORDER BY passwd DESC";
      break;
    case "urlshortASC":
      $strorderby="ORDER BY short ASC";
      break;
    case "urlshortDESC":
      $strorderby="ORDER BY short DESC";
      break;
    case "ownerASC":
      $strorderby="ORDER BY owner ASC";
      break;
    case "ownerDESC":
      $strorderby="ORDER BY owner DESC";
      break;
    case "commentASC":
      $strorderby="ORDER BY comment ASC";
      break;
    case "commentDESC":
      $strorderby="ORDER BY comment DESC";
      break;
    case "urllongASC":
      $strorderby="ORDER BY long ASC";
      break;
    case "urllongDESC":
      $strorderby="ORDER BY long DESC";
      break;
  }
  // Sort - Ende
  if (UserIsAdmin($activeuser)) {
    // Admin
    if (isset($_REQUEST['doSearch'])) {
      $searchfor=htmlspecialchars($_REQUEST['searchFor'], ENT_COMPAT, 'UTF-8');
      $results = $db->query("SELECT short, added, expire, passwd, long, comment, owner FROM content WHERE (".
				"short LIKE '%$searchfor%' OR ".
				"long LIKE '%".urlencode($searchfor)."%' OR ".
				"comment LIKE '%".urlencode($searchfor)."%' OR ".
				"owner LIKE '%".getIDFromUsername($searchfor)."%'".
				") ".$strorderby);
    } else {
      $results = $db->query("SELECT short, added, expire, passwd, long, comment, owner FROM content ".$strorderby);
    }
  // non-Admin
  } else {
    if (isset($_REQUEST['doSearch'])) {
      $results = $db->query("SELECT short, added, expire, passwd, long, comment FROM content WHERE (".
				"owner='".getIDFromUsername($activeuser)."' AND (".
					"short LIKE '%$searchfor%' OR ".
					"long LIKE '%".urlencode($searchfor)."%'".
				")) ".$strorderby);
    } else {
      $results = $db->query("SELECT short, added, expire, passwd, long, comment FROM content WHERE owner='".getIDFromUsername($activeuser)."' ".$strorderby);
    }
  }
  $countRows=0;
  while ($row = $results->fetchArray()) {
    $countRows = $countRows + 1;
    $trbgcolor="";
    if ($countRows % 2 == 0) {
      $trbgcolor=$colorbgsecond;
    } else {
      $trbgcolor=$colorbgfirst;
    }
    if (isset($_REQUEST['ContentEditShort'])) {
      if ($_REQUEST['showContent'] == $row['short']) {
        $trbgcolor="bgcolor=\"#E0FFFF\"";
      }
    }
    echo "<tr align=\"center\" ".$trbgcolor.">";
    echo "<form action=\"#\" method=\"post\"><td>
          <input type=\"hidden\" name=\"showContent\" value=\"".$row['short']."\" />
          <input type=\"hidden\" name=\"ContentEditShort\" value=\"".$row['short']."\" />
          <input type=\"submit\" name=\"doedit\" value=\"".getlang("ContentBtnEdit")."\" class=\"button\" />
          </td></form>
          <td>&nbsp;</td>";
    echo "<td class=\"content\">".$row['short']."</td>";
    echo "<td>&nbsp;</td>";
    echo "<td class=\"content\">".date("d.m.Y H:i:s", strtotime($row['added']))."</td>";
    echo "<td>&nbsp;</td>";
    if (empty($row['expire'])) {
      echo "<td>".$row['expire']."</td>";
    } else {
      $exdate=date($row['expire']);
      if ($exdate < date("Y-m-d H:i:s")) {
        echo "<td class=\"content\"><font class=\"textred\">".date("d.m.Y H:i:s", strtotime($row['expire']))."</font></td>";
      } else {
        echo "<td class=\"content\">".date("d.m.Y H:i:s", strtotime($row['expire']))."</td>";
      }
    }
    echo "<td>&nbsp;</td>";
    if (empty($row['passwd']) == TRUE) {
      echo "<td class=\"content\">".getlang("miscNo")."</td>";
    } else {
      echo "<td class=\"content\">".getlang("miscYes")."</td>";
    }
    echo "<td>&nbsp;</td>";
    $savedrd2prefix=getConfig("rd2prefix");
    $savedrd2prefixprotocol=getConfig("rd2prefixprotocol");
    $valueredirectlink=strtok("$_SERVER[REQUEST_URI]",'?')."?rd=".$row['short'];
    $valueredirectlinkstr=strtok("$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",'?')."?rd=".$row['short'];
    if ($savedrd2prefix == "") {
      echo "<td class=\"content\"><font size=\"-1\"><a href=\"".$valueredirectlink."\" target=\"_new\">$valueredirectlinkstr</a><br /><font class=\"textredsmall\">Prefix ".getlang("ContentNotSet")."</font></font></td>";
    } else {
      if ($savedrd2prefixprotocol == "https://") {
        echo "<td class=\"content\"><a href=\"".$savedrd2prefixprotocol.$savedrd2prefix.$row['short']."\" target=\"_new\">".$savedrd2prefixprotocol.$savedrd2prefix.$row['short']."</a></td>";
      } else {
        echo "<td class=\"content\"><a href=\"".$savedrd2prefixprotocol.$savedrd2prefix.$row['short']."\" target=\"_new\">".$savedrd2prefix.$row['short']."</a></td>";
      }
    }
    echo "<td>&nbsp;</td>";
    if (UserIsAdmin($activeuser)) {
      if ($activeuser == getUsernameFromID($row['owner'])) {
        echo "<td class=\"content\">".getUsernameFromID($row['owner'])."</td>";
        echo "<td>&nbsp;</td>";
      } else {
        if ($row['owner'] == 0) {
          echo "<td class=\"content\"><font class=\"textgreen\">"."( anonym )"."</font></td>";
        } else {
          $resultid=getUsernameFromID($row['owner']);
          if ($resultid == $row['owner'] ) {
            echo "<td class=\"content\"><font class=\"textred\">".$resultid."</font></td>";
          } else {
            echo "<td class=\"content\"><font class=\"textgreen\">".$resultid."</font></td>";
          }
        }
        echo "<td>&nbsp;</td>";
      }
    }
    echo "<td class=\"content\"><font class=\"small\">".$row['comment']."</font></td>";
    echo "<td>&nbsp;</td>";
    echo "<td class=\"content\"><font class=\"small\"><a href=\"".urldecode($row['long'])."\" target=\"_new\">".urldecode($row['long'])."</a></font></td>";
    echo "</tr>";
  };
?>
</table>
<a href="#top"><font class="small"><?php echo getlang("miscToTop"); ?></font></a>

