<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

require_once(dirname(__FILE__).'/include/prefs.php');
$db = cmsms()->GetDb();
global $themeObject;
$idepreuve= '';
//debug_display($params, 'Parameters');

$phase_courante = $this->GetPreference('phase_en_cours');

$phase = (isset($params['phase']))?$params['phase']:$phase_courante;
$saison_en_cours = (isset($params['saison_en_cours']))?$params['saison_en_cours']:$this->GetPreference('saison_en_cours');


$query = "SELECT DISTINCT *, eq.id AS eq_id, phase, eq.tag as tag_equipe FROM ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.saison = ?";
$query.=" ORDER BY eq.phase DESC,eq.idepreuve ASC,eq.numero_equipe ASC";	
//echo $query;
$dbresult= $db->Execute($query, array($saison_en_cours));


	$rowarray= array();
	
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
				$onerow->horaire = $row['horaire'];
				$onerow->view= $this->createLink($id, 'admin_poules_tab3', $returnid, $themeObject->DisplayImage('icons/system/view.gif', $this->Lang('view_results'), '', '', 'systemicon'),array('active_tab'=>'equipes',"record_id"=>$row['eq_id'])) ;

				if($this->CheckPermission('Ping Delete'))
				{
					$onerow->deletelink= $this->CreateLink($id, 'delete', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['eq_id'], 'type_compet'=>'teams'), $this->Lang('delete_confirm'));
				}

				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
				
      			}
			
  		}
	
		
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		
		
		
		//
		$smarty->assign('form2start',
			$this->CreateFormStart($id,'mass_action',$returnid));
	$smarty->assign('form2end',
			$this->CreateFormEnd());
	$articles = array("Changer l'horaire"=>"change_horaire", "Supprimer"=>"delete_teams");

	$smarty->assign('actiondemasse',
			$this->CreateInputDropdown($id,'actiondemasse',$articles));
	$smarty->assign('submit_massaction',
			$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));
	
		echo $this->ProcessTemplate('teams.tpl');


#
# EOF
#
?>