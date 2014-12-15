<?php
if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;

if (!isset($params["pollid"])) $this->Redirect($id,"defaultadmin");

if (isset($params["savepoll"])) {
	$db=$this->GetDb();
	
	$q="UPDATE ".cms_db_prefix()."module_polls SET name=?,poll_id=? WHERE id=?";
	$p=array($params["pollname"],$params["poll_id"],$params["pollid"]);
	$result=$db->Execute($q,$p);
	echo $this->ShowMessage($this->Lang("pollupdated"));
}



$db=$this->GetDb();	
$q="SELECT * FROM ".cms_db_prefix()."module_polls WHERE id=?";

$result=$db->Execute($q,array($params["pollid"]));
if (!$result || $result->RecordCount()==0) $this->Redirect($id,"defaultadmin");
$row=$result->FetchRow();

$this->smarty->assign("formstart",$this->CreateFormStart($id,"editpoll",$returnid,"post","",false,"",array("pollid"=>$params["pollid"])));
$this->smarty->assign("nameinput",$this->CreateInputTextWithLabel($id,"pollname",$row["name"],40,128,"",$this->Lang("pollname")));
$this->smarty->assign("idinput",$this->CreateInputTextWithLabel($id,"poll_id",$row["poll_id"],40,128,"",$this->Lang("pollid")));

$this->smarty->assign("submit",$this->CreateInputSubmit($id,"savepoll",$this->Lang("updatepoll")));

$this->smarty->assign("formend",$this->CreateFormEnd());

if (!isset($gCms) || !$this->VisibleToAdminUser()) exit;

$totalvote=$this->GetTotalVotes($params["pollid"]);


$db=$this->GetDb();
$q="SELECT * FROM ".cms_db_prefix()."module_polloptions WHERE pollid=?";
$p=array($params["pollid"]);
$result=$db->Execute($q,$p);
$showoptions=array();
if ($result && $result->RecordCount()>0) {
	//$rowclass="row1";
	while ($row=$result->FetchRow()) {
		$percent=0;
		if ($row["count"]>0) $percent= round(($row["count"]*100)/$totalvote);
    
		//echo "<tr class='$rowclass'>";
		//echo "<td>".$row["name"]."</td>";
    $option["name"]=$row["name"];
		//echo "<td class='pagepos'>".$row["count"]."</td>";
    $option["count"]=$row["count"];
		//echo "<td class='pagepos'>".$percent."%</td>";
    $option["percent"]=$percent.="%";
		//echo "<td class='pagepos'>";
	  $text="<img src='themes/default/images/icons/system/delete.gif' alt='".$this->Lang("deleteoption")."' class='systemicon'>";
    $option["delete"]=$this->CreateLink($id, "deleteoption",$returnid, $text, array("optionid"=>$row["id"],"pollid"=>$params["pollid"]),$this->Lang("confirmdeleteoption"));
    //echo "</td>";
    //echo "<td class='pagepos'>";
    $text="<img src='themes/default/images/icons/system/edit.gif' alt='".$this->Lang("editoption")."' class='systemicon'>";
    $option["edit"]=$this->CreateLink($id, "editoption",$returnid, $text, array("optionid"=>$row["id"],"pollid"=>$params["pollid"]));
		//echo "</td>";

		//echo "</td></tr>";
		//if ($rowclass=="row1") $rowclass="row2"; else $rowclass="row1";
    $showoptions[]=$option;

	}
} else {

}

$this->smarty->assign_by_ref("options",$showoptions);

$this->smarty->assign("module",$this);

$this->smarty->assign("addformstart", $this->CreateFormStart($id,"addoption",$returnid,"post","",false,"",array("pollid"=>$params["pollid"])));
$this->smarty->assign("addformsubmit", $this->CreateInputSubmit($id,"addoption",$this->Lang("addoption")));

$this->smarty->assign("resetformstart", $this->CreateFormStart($id,"resetpoll",$returnid,"post","",false,"",array("pollid"=>$params["pollid"])));

//echo $this->CreateInputSubmit($id,"resetpoll",$this->Lang("resetpoll"),"","",$this->Lang("confirmresetpoll"));
$this->smarty->assign("resetformsubmit", $this->CreateInputSubmit($id,"reset",$this->Lang("resetpoll"),"","",$this->Lang("confirmresetpoll")));

$this->smarty->assign("returnformstart", $this->CreateFormStart($id,"defaultadmin",$returnid));
$this->smarty->assign("returnformsubmit", $this->CreateInputSubmit($id,"return",$this->Lang("return")));
//echo $this->CreateInputSubmit($id,"return",$this->Lang("return"));

echo $this->ProcessTemplate("admineditpoll.tpl")

?>