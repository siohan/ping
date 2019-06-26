<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

require_once(dirname(__FILE__).'/include/prefs.php');
$db =& $this->GetDb();
global $themeObject;
$idepreuve= '';
//debug_display($params, 'Parameters');
$saison_courante = $this->GetPreference('saison_en_cours');
$phase_courante = $this->GetPreference('phase_en_cours');

$phase = (isset($params['phase']))?$params['phase']:$phase_courante;
$saison_en_cours = (isset($params['saison_en_cours']))?$params['saison_en_cours']:$saison_courante;
$smarty->assign('formstart',$this->CreateFormStart($id,'defaultadmin','', 'post', '',false,'',array('active_tab'=>'equipes')));


$query = "SELECT DISTINCT *, eq.id AS eq_id, phase, eq.tag as tag_equipe FROM ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.saison = ?";
$query.=" ORDER BY eq.phase DESC,eq.idepreuve ASC,eq.numero_equipe ASC";	
//echo $query;
$dbresult= $db->Execute($query, array($saison_en_cours));



		

	//echo $query;
	//$dbresult= $db->Execute($query,array($saison_courante,$idepreuve));
	$calendarImage = "<img title=\"Récupérer le calendrier\" src=\"{$module_dir}/images/calendrier.jpg\" class=\"systemicon\" alt=\"Récupérer le calendrier\" />";
	$podiumImage = "<img title=\"Récupérer le classement de la poule\" src=\"{$module_dir}/images/podium.jpg\" class=\"systemicon\" width=\"16\" height =\"12\" alt=\"Récupérer le classement\" />";
	//echo $query;
	$rowarray= array();
	$rowarray2= array();
	$rowclass = '';
	$array_chpt = array();

		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			while ($row= $dbresult->FetchRow())
      			{
				$onerow= new StdClass();
				$onerow->rowclass= $rowclass;

				$idepreuve = $row['idepreuve'];
				$onerow->eq_id= $row['eq_id'];
				$onerow->idpoule = $row['idpoule'];
				$onerow->iddiv = $row['iddiv'];
				$onerow->phase= $row['phase'];
				$onerow->libequipe=  $row['libequipe'];
				$onerow->libdivision= $row['libdivision'];
				$onerow->friendlyname= $row['friendlyname'];
				//$onerow->name= $row['name'];
				$onerow->idepreuve = $row['idepreuve'];
				$onerow->tag = $row['tag_equipe'];
				$yesimage = $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('download_poule_results'),'','','systemicon');
				$noimage = $themeObject->DisplayImage('icons/system/stop.gif', $this->Lang('download_poule_results'),'','','systemicon');
				$onerow->calendrier = $row['calendrier'];
				$onerow->view= $this->createLink($id, 'admin_poules_tab3', $returnid, $themeObject->DisplayImage('icons/system/view.gif', $this->Lang('view_results'), '', '', 'systemicon'),array('active_tab'=>'equipes','libequipe'=>$row['libequipe'],"record_id"=>$row['eq_id'],"idepreuve"=>$row['idepreuve'])) ;

				$onerow->editlink= $this->CreateLink($id, 'edit_team', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['eq_id']));
				$onerow->addnewlink = $this->CreateLink($id, 'edit_team',$returnid, $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('addmanually'), '', '', 'systemicon'), array('record_id'=>$row['eq_id']));

				if(!is_null($idepreuve))
				{
					//$calendrierimage = $themeObject->DisplayImage('icons/system/calendrier.jpg', $this->Lang('download_poule_results'),'','','systemicon');
					$onerow->retrieve_poule_rencontres= $this->CreateLink($id, 'retrieve_poule_rencontres',$returnid,$calendarImage, array('idpoule'=>$row['idpoule'], 'iddiv'=>$row['iddiv'], 'idepreuve'=>$row['idepreuve']));
					$onerow->classement = $this->CreateLink($id, 'getPouleClassement',$returnid,$podiumImage, array("iddiv"=>$row['iddiv'], "idpoule"=>$row['idpoule'], "record_id"=>$row['eq_id'], "idepreuve"=>$row['idepreuve']));

					$onerow2= new StdClass();
					$onerow2->rowclass= $rowclass;
					/*
					if(!in_array($idepreuve, $array_chpt))

					{
						array_push($array_chpt,$idepreuve);
						$onerow2->links_chpt = $this->CreateLink($id, 'retrieve_poule_rencontres', $returnid,$contents='Récupérer le calendriers', array("cal"=>"cal", "idepreuve"=>$idepreuve));
					}
					*/
				}
				else
				{
					$onerow->editlink= $this->CreateLink($id, 'edit_team', $returnid,$themeObject->DisplayImage('icons/system/warning.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['eq_id']));
				}

				if($this->CheckPermission('Ping Delete'))
				{
					$onerow->deletelink= $this->CreateLink($id, 'delete', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['eq_id'], 'type_compet'=>'teams'), $this->Lang('delete_confirm'));
				}

				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
				$rowarray2[]= $onerow2;
      			}
			//$tab_chpt = array_unique($array_chpt);
			//print_r($array_chpt);
			//var_dump($array_chpt);
  		}
		$yesimage = $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('download_poule_results'),'','','systemicon');
		$noimage = $themeObject->DisplayImage('icons/system/stop.gif', $this->Lang('download_poule_results'),'','','systemicon');
		$smarty->assign('yes', $yesimage);
		$smarty->assign('no', $noimage);
		$smarty->assign('retrieve_all',
				$this->CreateLink($id, 'retrieve_poule_rencontres', $returnid,$contents='Récupérer les calendriers', array("cal"=>"cal", "idepreuve"=>$idepreuve)));
		$smarty->assign('retrieve_calendriers',
				$this->CreateLink($id, 'retrieve_poule_rencontres', $returnid,$contents='Récupérer les dernières rencontres', array("cal"=>"all")));
		$smarty->assign('classements',
				$this->CreateLink($id, 'retrieve', $returnid,$contents='Récupérer tous les classements',array("retrieve"=>"classement_equipes")));
		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		$smarty->assign('donnees', $rowarray2);
		//$smarty->assign('tab_chpt', $tab_chpt);
		
		$smarty->assign('retrieve_teams',
			$this->CreateLink($id, 'retrieve', $returnid, $contents = "Equipes masculines", array("retrieve"=>"teams",'type'=>'M')));
		$smarty->assign('retrieve_teams_fem',
			$this->CreateLink($id, 'retrieve', $returnid, $contents = "Equipes féminines", array("retrieve"=>"teams",'type'=>'F')));
		$smarty->assign('retrieve_teams_autres',
				$this->CreateLink($id, 'retrieve', $returnid, $contents = "Autres équipes", array("retrieve"=>"teams",'type'=>'U')));
		$smarty->assign('edit_team',
				$this->CreateLink($id, 'edit_team',$returnid, $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('add'), '', '', 'systemicon')).$this->CreateLink($id, 'edit_team', $returnid, 
								  $this->Lang('addmanually'), 
								  array()));
	
		//echo $this->ProcessTemplate('teamscores.tpl');
	
		//echo $this->ProcessTemplate('teamscores.tpl');



echo $this->ProcessTemplate('teams.tpl');


#
# EOF
#
?>