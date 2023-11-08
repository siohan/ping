<?php
if( !isset($gCms) ) exit;
//debug_display($params,'Parameters');
##############################################################################
###                    JOURNAL                                               ###
##############################################################################
$number = 0;
if(isset($params['number']) && $params['number'] >0)
{
	$number = (int) $params['number'];
}
$suivant = $number + 100;
$precedent = $number - 100;
$ping_ops = new ping_admin_ops;
$last = $ping_ops->last_element();
$all = $ping_ops->all_elements();
$nb_pages = ceil($all/100);
$page_actuelle = ($number/100)+1;
//echo $nb_pages;
//echo $last;
$smarty->assign('suivant',$suivant);
$smarty->assign('precedent',$precedent);
$smarty->assign('nb_pages', $nb_pages);
$smarty->assign('page_actuelle', $page_actuelle);

$db = cmsms()->GetDb();

global $themeObject;

$query= "SELECT id, datecreated, designation, status,action FROM ".cms_db_prefix()."module_ping_recup  ORDER BY id DESC LIMIT ?,100";
$dbresult= $db->Execute($query, array($number));
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
