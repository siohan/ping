<?php

if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
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
$query = "SELECT DISTINCT *, eq.id,comp.name, comp.code_compet FROM ".cms_db_prefix()."module_ping_equipes AS eq, ".cms_db_prefix()."module_ping_type_competitions AS comp WHERE eq.saison = ?  AND comp.code_compet = eq.type_compet";

	$query .=" ORDER BY eq.id ASC";
	//echo $query;
	$dbresult= $db->Execute($query,array($saison_courante));

	//echo $query;
	$rowarray= array ();
	
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			while ($row= $dbresult->FetchRow())
      			{
				$onerow= new StdClass();
				$onerow->rowclass= $rowclass;
				$code = $row['code_compet'];
				$onerow->id= $row['id'];
				$onerow->idpoule = $row['idpoule'];
				$onerow->iddiv = $row['iddiv'];
				//$onerow->equipe= $row['equipe'];
				$onerow->libequipe=  $row['libequipe'];
				$onerow->libdivision= $row['libdivision'];
				$onerow->friendlyname= $row['friendlyname'];
				$onerow->name= $row['name'];
				$onerow->type_compet = $row['code_compet'];
				//$onerow->view= $this->createLink($id, 'viewteamresult', $returnid, $themeObject->DisplayImage('icons/system/view.gif', $this->Lang('download_poule_results'), '', '', 'systemicon'),array('cle'=>$row['cle'])) ;
				$onerow->editlink= $this->CreateLink($id, 'edit_team', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['id']));
				
				
				if($code != 'U')
				{
					$onerow->retrieve_poule_rencontres= $this->CreateLink($id, 'retrieve_poule_rencontres', $returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('download_poule_results'), '', '', 'systemicon'), array('idpoule'=>$row['idpoule'], 'iddiv'=>$row['iddiv'], 'type_compet'=>$row['type_compet']));
					$onerow->classement = $this->CreateLink($id, 'getPouleClassement',$returnid,'Classement', array("iddiv"=>$row['iddiv'], "idpoule"=>$row['idpoule'], "record_id"=>$row['id'], "type_compet"=>$row['code_compet']));
				}
				
				if($this->CheckPermission('Ping Delete'))
				{
					$onerow->deletelink= $this->CreateLink($id, 'delete', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id'], 'type_compet'=>'teams'), $this->Lang('delete_confirm'));
				}
				
				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
      			}
  		}

		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
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