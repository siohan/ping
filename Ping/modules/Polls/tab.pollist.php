<?php

if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;

$showpolls = array();
$defaultpoll = $this->GetPreference("defaultpoll");
$db = $this->GetDb();
$q = "SELECT * FROM " . cms_db_prefix() . "module_polls";
$result = $db->Execute($q);
if ($result && $result->RecordCount() > 0) {
  while ($row = $result->FetchRow()) {
    
    $poll = array();
    $poll["id"] = $row["poll_id"];
    $poll["name"] = $this->CreateLink($id, "editpoll", $returnid, $row["name"], array("pollid" => $row["id"]));
    
    if ($row["closed"] == 0) {
      if ($row["id"] == $defaultpoll) {
        $image = "<img src='themes/OneEleven/images/icons/system/true.gif' class='systemicon' alt='" . $this->Lang("pollopen") . "'>";
        $poll["status"] = $this->Lang("open") . "&nbsp;" . $image;
      } else {
        $text = "<img src='themes/OneEleven/images/icons/system/true.gif' class='systemicon' alt='" . $this->Lang("closepoll") . "'>";
        $poll["status"] = $this->Lang("open") . "&nbsp;" . $this->CreateLink($id, "closepoll", $returnid, $text, array("pollid" => $row["id"]), $this->lang("confirmclosepoll"));
      }
    } else {
      $text = "<img src='themes/OneEleven/images/icons/system/false.gif' class='systemicon' alt='" . $this->Lang("openpoll") . "'>";
      $poll["status"] = $this->Lang("closed") . "&nbsp;" . $this->CreateLink($id, "openpoll", $returnid, $text, array("pollid" => $row["id"]), $this->lang("confirmopenpoll"));
    }
    
    if ($row["closed"] == 0) {
      if ($row["id"] == $defaultpoll) {
        $poll["default"] = "<img src='themes/OneEleven/images/icons/system/true.gif' alt='" . $this->Lang("defaultpoll") . "' class='systemicon'>";
      } else {
        $text = "<img src='themes/OneEleven/images/icons/system/false.gif' alt='" . $this->Lang("makedefaultpoll") . "' class='systemicon'>";
        $poll["default"] = $this->CreateLink($id, "activatepoll", $returnid, $text, array("pollid" => $row["id"]));
      }
    }
    
    $text = "<img src='themes/OneEleven/images/icons/system/edit.gif' alt='" . $this->Lang("editpoll") . "' class='systemicon'>";
    $poll["edit"] = $this->CreateLink($id, "editpoll", $returnid, $text, array("pollid" => $row["id"]));
    
    if ($row["id"] == $defaultpoll) {
      $poll["delete"] = "&nbsp;";
    } else {
      $text = "<img src='themes/OneEleven/images/icons/system/delete.gif' alt='Delete poll' class='systemicon'>";
      $poll["delete"] = $this->CreateLink($id, "deletepoll", $returnid, $text, array("pollid" => $row["id"]), $this->Lang("confirmdeletepoll"));
    }
   
    $poll["createtime"] = date("d/m/Y", $row["createtime"]);

    $poll["closetime"] = ($row["closed"] == 1 ? date("d/m/Y", $row["closetime"]) : "&nbsp;");

    //echo "<td class='pagepos'>";
    if ($row["closed"]) {
      $poll["duration"] = $this->Lang("pollranfor") . " ";
      $poll["duration"].=ceil((($row["closetime"] - $row["createtime"]) / (3600 * 24)));
      $poll["duration"].=" " . $this->Lang("days");
    } else {
      $poll["duration"] = $this->Lang("pollhasbeenrunningfor") . " ";
      $poll["duration"].=ceil(((time() - $row["createtime"]) / (3600 * 24)));
      $poll["duration"].=" " . $this->Lang("days");
    }
    
    $showpolls[]=$poll;
  }
} else {

}

$this->smarty->assign("polls", $showpolls);
$this->smarty->assign_by_ref("module", $this);

$themeObject = $this->_getthemeobj();

$addlink = $this->CreateLink($id, "addpoll", $returnid, $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang("addpoll")));

$addlink.=$this->CreateLink($id, "addpoll", $returnid, $this->Lang("addpoll"));
$this->smarty->assign("addlink", $addlink);


echo $this->ProcessTemplate("adminpolllist.tpl");
?>