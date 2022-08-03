<?php

if( !isset($gCms) ) exit;

$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
//créations de liens de récupération des compétitions
//on récupère d'abord les préférences de zones, ligues et département
$smarty->assign('fede', '100001');
$smarty->assign('zone', $this->GetPreference('zone'));
$smarty->assign('ligue', $this->GetPreference('ligue'));
$smarty->assign('dep', $this->GetPreference('dep'));
$saison = $this->GetPreference('saison_en_cours');

$smarty->assign('zone_indivs', $this->CreateLink($id, 'retrieve_compets',$returnid,'Récupérer les compétitions individuelles', array("type"=>"I")));

$result= array ();
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions WHERE id >0";//indivs = '1' ORDER BY name ASC";

$dbresult= $db->Execute($query);
$ping_ops = new ping_admin_ops;

//echo $query;
$rowarray= array();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->id= $row['id'];
		$onerow->name= $row['name'];
		$onerow->tag= $row['tag'];
		$onerow->coefficient= $row['coefficient'];
		$onerow->indivs= $row['indivs'];
		$onerow->idepreuve = $row['idepreuve'];
		$onerow->actif = $row['actif'];
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
      }
  }

$smarty->assign('itemsfound', $this->Lang('resultsfound'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);


echo $this->ProcessTemplate('list_compet_indivs.tpl');


#
# EOF
#
?>
