<?php
if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;

if (!isset($params["pollid"])) exit;
if (!isset($params["optionid"])) exit;

$db=$this->GetDb();
$q="SELECT * FROM ".cms_db_prefix()."module_polloptions WHERE id=?";
$p=array($params["optionid"]);
$result=$db->Execute($q,$p);
if (!$result || $result->RecordCount()<1) exit;
$option=$result->FetchRow();

$value="";
if (isset($params["submit"])) {
	if (strlen(trim($params["optionname"]))>1) {
	  
	  $q="UPDATE ".cms_db_prefix()."module_polloptions SET name=? WHERE id=?";
	  $p=array($params["optionname"],$params["optionid"]);
	  $result=$db->Execute($q,$p);

	  if (!$result) echo $db->ErrorMsg();

   	$this->Redirect($id,"editpoll",$returnid,array("module_messages"=>$this->Lang("optionupdated"),"pollid"=>$params["pollid"]));

	} else {
		echo $this->ShowErrors($this->Lang("optionnamerequired"));
		//Fallthrough to form
	}
} elseif (isset($params["cancel"])) {
  $this->Redirect($id,"editpoll",$returnid,array("pollid"=>$params["pollid"]));
}

$this->smarty->assign("module",$this);

//echo "<h3>".$this->Lang("editoption")."</h3>";
$this->smarty->assign("module",$this->CreateFormStart($id,"editoption",$returnid));
$this->smarty->assign("formstart", $this->CreateFormStart($id,"editoption",$returnid,"post","",false,"",array("pollid"=>$params["pollid"],"optionid"=>$params["optionid"])));
//echo $this->CreateInputHidden($id,"pollid",$params["pollid"]);
//echo $this->CreateInputHidden($id,"optionid",$params["optionid"]);
$this->smarty->assign("optionnameinput", $this->CreateInputTextWithLabel($id,"optionname",$option["name"],40,128,"",$this->Lang("optionname")));
//echo "<br/><br/>";
$this->smarty->assign("submit", $this->CreateInputSubmit($id,"submit",$this->Lang("save")));
$this->smarty->assign("cancel", $this->CreateInputSubmit($id,"cancel",$this->Lang("cancel")));
$this->smarty->assign("formend", $this->CreateFormEnd());
$this->smarty->assign("module", $this);
echo $this->ProcessTemplate("admineditoption.tpl")

?>