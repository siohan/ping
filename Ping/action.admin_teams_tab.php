<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
$saison_courante = $this->GetPreference('saison_en_cours');


$smarty->assign('id', $this->Lang('id'));
$smarty->assign('equipe', 'Equipes');
$smarty->assign('tour', 'Tour');
$smarty->assign('score', 'Score');
$smarty->assign('adversaires', 'Adversaires');

$result= array ();
$query = "SELECT *, eq.id,comp.name FROM ".cms_db_prefix()."module_ping_equipes AS eq, ".cms_db_prefix()."module_ping_type_competitions AS comp WHERE eq.saison = ?  AND (comp.code_compet = eq.type_compet OR eq.type_compet IS NULL) ";

	$query .=" ORDER BY eq.id ASC";
	$dbresult= $db->Execute($query,array($saison_courante));

	//echo $query;
	$rowarray= array ();
	
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			while ($row= $dbresult->FetchRow())
      			{
				$onerow= new StdClass();
				$onerow->rowclass= $rowclass;
				$onerow->id= $row['id'];
				//$onerow->equipe= $row['equipe'];
				$onerow->libequipe=  $row['libequipe'];
				$onerow->libdivision= $row['libdivision'];
				$onerow->friendlyname= $row['friendlyname'];
				$onerow->name= $row['name'];
				//$onerow->view= $this->createLink($id, 'viewteamresult', $returnid, $themeObject->DisplayImage('icons/system/view.gif', $this->Lang('download_poule_results'), '', '', 'systemicon'),array('cle'=>$row['cle'])) ;
				$onerow->editlink= $this->CreateLink($id, 'edit_team', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['id']));
				$onerow->retrieve_poule_rencontres= $this->CreateLink($id, 'retrieve_poule_rencontres', $returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('download_poule_results'), '', '', 'systemicon'), array('idpoule'=>$row['idpoule'], 'iddiv'=>$row['iddiv'], 'type_compet'=>$row['type_compet']));
				$onerow->deletelink= $this->CreateLink($id, 'delete_team', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_confirm'));
				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
      			}
  		}
		$smarty->assign('itemsfound', $this->Lang('sheetsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		$smarty->assign('retrieve_teams',
		$this->CreateLink($id, 'retrieve_teams', $returnid, $contents = "Récupération des équipes (championnat seniors)", array('type'=>'M')));
		$smarty->assign('retrieve_teams_autres',
				$this->CreateLink($id, 'retrieve_teams', $returnid, $contents = "Récupération des équipes"));



echo $this->ProcessTemplate('teamscores.tpl');


#
# EOF
#
?>