<?php
if (!function_exists("cmsms") || !$this->VisibleToAdminUser()) exit;

if (!isset($params["pollid"])) exit;

$value="";

if (isset($params["submit"])) {
	if (strlen($params["optionname"])>1) {
	  $db=$this->GetDb();
	  $newid=$db->GenID(cms_db_prefix()."module_polloptions_seq");
	  $q="INSERT INTO ".cms_db_prefix()."module_polloptions (id,pollid,name,count) VALUES (?,?,?,?)";
	  $p=array($newid,$params["pollid"],$params["optionname"],0);
	  $result=$db->Execute($q,$p);

	  if (!$result) echo $db->ErrorMsg();

   	$this->Redirect($id,"editpoll",$returnid,array("module_messages"=>$this->Lang("optionadded"),"pollid"=>$params["pollid"]));

	} else {
		echo $this->ShowErrors($this->Lang("optionnamerequired"));
		//Fallthrough to form
	}
} elseif (isset($params["cancel"])) {
  $this->Redirect($id,"editpoll",$returnid,array("pollid"=>$params["pollid"]));
}

echo "<h3>".$this->Lang("addnewoption")."</h3>";
echo $this->CreateFormStart($id,"addoption",$returnid);
echo $this->CreateInputHidden($id,"pollid",$params["pollid"]);
echo $this->CreateInputTextWithLabel($id,"optionname",$value,40,128,"",$this->Lang("optionname"));
echo "<br/><br/>";
echo $this->CreateInputSubmit($id,"submit",$this->Lang("add"));
echo $this->CreateInputSubmit($id,"cancel",$this->Lang("cancel"));
echo $this->CreateFormEnd();


?>