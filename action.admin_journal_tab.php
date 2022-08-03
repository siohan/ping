<?php
if( !isset($gCms) ) exit;
//debug_display($params,'Parameters');
##############################################################################
###                    JOURNAL                                               ###
##############################################################################


$db = cmsms()->GetDb();
global $themeObject;

$query= "SELECT id, datecreated, designation, status,action FROM ".cms_db_prefix()."module_ping_recup  ORDER BY id DESC LIMIT 100";
$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();

	if ($dbresult && $dbresult->RecordCount() > 0)
  	{
		while ($row= $dbresult->FetchRow())
      	{
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->id= $row['id'];
			$onerow->datecreated= $row['datecreated'];
			$onerow->designation= $row['designation'];
			$onerow->action= $row['action'];
			//$onerow->select = $this->CreateInputCheckbox($id,'sel[]',$row['id']);
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
      	}
  	}

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

echo $this->ProcessTemplate('journal.tpl');


#
# EOF
#
?>
