<?php
######################################################################
###                   L'onglet de la situation mensuelle           ###
#                                                                  ###
# Auteur : Claude SIOHAN                                           ###
######################################################################
if( !isset($gCms) ) exit;
$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params,'Parameters');
$mois_courant = date('n');//Mois au format 1, 2, 3 etc....
$now = trim($db->DBTimeStamp(time()), "'");
$annee_courante = date('Y');
$jour = date('j');

$saison_courante = $this->GetPreference('saison_en_cours');
//echo "l'année courante est : ".$annee_courante;


$query = "SELECT *, sm.saison, sm.id,j.licence,sm.id,sm.mois,sm.points, sm.annee, CONCAT_WS(' ', j.nom, j.prenom) AS joueur, sm.progmois, sm.clnat, sm.rangreg, sm.rangdep  FROM ".cms_db_prefix()."module_ping_joueurs AS j, ".cms_db_prefix()."module_ping_sit_mens AS sm WHERE j.licence = sm.licence AND sm.mois = ? AND sm.annee = ? AND j.actif = '1' AND j.type = 'T'";

$query.=" ORDER BY joueur ASC,sm.id ASC";

$dbresult= $db->Execute($query, array($mois_courant, $annee_courante));//,$parms);

$rowclass= 'row1';
$rowarray= array ();

	if ($dbresult && $dbresult->RecordCount() > 0)
  	{
    		while ($row= $dbresult->FetchRow())
      		{
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->id= $row['id'];
			$onerow->licence= $row['licence'];
			$onerow->mois= $row['mois'];
			$onerow->annee= $row['annee'];
			$onerow->points= $row['points'];
			$onerow->clnat= $row['clnat'];
			$onerow->rangreg= $row['rangreg'];
			$onerow->rangdep= $row['rangdep'];
			$onerow->progmois= $row['progmois'];
			$onerow->joueur= $row['joueur'];
			$onerow->editlink= $this->CreateLink($id, 'retrieve', $returnid, $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('add-manually'), '', '', 'systemicon'),array('retrieve'=>'sit_mens','sel'=>$row['licence']));
			$onerow->sitmenslink= $this->CreateLink($id, 'retrieve_sit_mens', $returnid, 'Situation mensuelle', array('licence'=>$row['licence']));
			$onerow->getpartieslink= $this->CreateLink($id, 'retrieve_parties', $returnid, 'Parties disputées', array('licence'=>$row['licence']));
			if($this->CheckPermission('Ping Delete'))
			{
				$onerow->deletelink= $this->CreateLink($id, 'delete', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array("type_compet"=>"sit_mens", 'record_id'=>$row['id']), $this->Lang('delete_confirm'));
			}
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
      		}
  	}
$smarty->assign('jour',$jour);
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('retrieveallsitmens',
		$this->CreateLink($id,'retrieve', $returnid, $contents='Ajouter automatiquement les situations mensuelles',array("retrieve"=>"sit_mens_all") ,$warn_message='Attention, ce script peut-être long Merci de patienter'));
$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Récupérer situation mensuelle"=>"situation");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));
				  

echo $this->ProcessTemplate('allsitmens.tpl');


#
# EOF
#
?>