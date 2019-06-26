<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
global $themeObject;

$saison_courante = (isset($params['saison'])?$params['saison']:$this->GetPreference('saison_en_cours'));
$phase = $this->GetPreference('phase_en_cours');
if(isset($params['template']) && $params['template'] != '')
{
	$template = $params['template'];
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Situation Mensuelle Live');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template situation provisoire introuvable');
        return;
    }
    $template = $tpl->get_name();
}
$mois_courant = date('n');
$jour_courant = date('j');

if($jour_courant < 10)
{
	$mois_courant = $mois_courant-1;
}


$query="SELECT CONCAT_WS(' ', j.nom, j.prenom) AS joueur, j.licence FROM ".cms_db_prefix()."module_ping_joueurs AS j  WHERE j.type='T' AND  j.actif='1' ";	
$dbresult = $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();

if ($dbresult && $dbresult->RecordCount()>0)	
	{
		while($row= $dbresult->FetchRow())
		{
			$licence = $row['licence'];
			$joueur = $row['joueur'];
			//on prend les points du dernier mois(le mois en cours)	
			$query2 = "SELECT points FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND saison = ?";
			$dbresult2 = $db->Execute($query2,array($licence,$mois_courant, $saison_courante));
			$row2 = $dbresult2->FetchRow();						
			$points_ref = $row2['points'];
			
			//on va maintenant calculer le total des points spid du mois en cours 
			//pour les ajouter ensuite aux points de la dernière situation mensuelle
			$query3 = "SELECT SUM(pointres) AS total FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND  MONTH(date_event) = ? AND saison = ? AND statut = '1'";
			$dbresult3 = $db->Execute($query3, array($licence,$mois_courant,$saison_courante));
			
				if( $dbresult3->RecordCount()>0)
				{
					$row3 = $dbresult3->FetchRow();
					$total = $row3['total'];
				}
				if(is_null($total))
				{
					$total = 0;
				}
			
			$somme = $points_ref+$total;
			
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->joueur= $row['joueur'];
			$onerow->clt= $points_ref;
			$onerow->somme= $somme;
			$onerow->bilan= $total;
			$onerow->details= $this->CreateFrontendLink($id, $returnid,'user_results_prov', $contents='Détails',array('licence'=>$row['licence'],'month'=>$mois_courant));
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
		}
	}
	
$smarty->assign('returnlink', 
		$this->CreateFrontendLink($id,$returnid, 'sit_mens_provisoire',$addtext='Retour'));
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template), null, null, $smarty);
$tpl->display();
//echo $this->ProcessTemplate('sitmens_prov.tpl');


#
# EOF
#
?>