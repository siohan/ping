<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db = cmsms()->GetDb();
//global $themeObject;
//require_once(dirname(__FILE__).'/include/prefs.php');
$licence = '';
$date_event = '';
$ok = 0;
$saison_courante = (isset($params['saison']))?$params['saison']:$this->GetPreference('saison_en_cours');
$mois_courant = date('n');
if(isset($params['template']) && $params['template'] !="")
{
	$template = $params['template'];
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Résultats par joueur');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template résultats par joueur introuvable');
        return;
    }
    $template = $tpl->get_name();
}
//echo 'la phase est : '.$phase;
	if(!isset($params['record_id']) && $params['record_id'] =='' )
	{
		echo "la licence est absente !";
		
	}
	else
	{
		$licence = $params['record_id'];
		$j_ops = new joueurs;
		$sum_spid = $j_ops->spid_calcul($licence,$saison_courante, $mois_courant);
		$smarty->assign('global', $sum_spid);
		$sum_fftt = $j_ops->fftt_calcul($licence,$saison_courante);
		$smarty->assign('global_fftt', $sum_fftt);
		$joueur = $j_ops->details_joueur($licence);
		$nom = $joueur['nom'].' '.$joueur['prenom'];
		$smarty->assign('nom', $nom);
		$parms = array();		


		$query3= "SELECT advnompre, advclaof,pointres, vd,date_event FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND saison = ? ORDER BY date_event ASC";
		$dbresult3 = $db->Execute($query3, array($licence, $saison_courante));
		
		$rowarray= array();
		$rowclass= 'row1';

		if ($dbresult3 && $dbresult3->RecordCount() > 0)
		{
		    while ($row= $dbresult3->FetchRow())
			{
	
				$onerow= new StdClass();
				$onerow->rowclass= $rowclass;
				$onerow->date_event= $row['date_event'];
				$onerow->advnompre= $row['advnompre'];
				//$onerow->nom= $row['nom'];
				$onerow->advclaof= $row['advclaof'];
				$onerow->vd= $row['vd'];
				//$onerow->coeff= $row['coeff'];
				$onerow->pointres= $row['pointres'];
				$rowarray[]= $onerow;
		      	}
		}
		
		
	}//fin du else (if $licence isset)

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

$query2= "SELECT nom, coeff,classement,pointres, victoire,date_event,epreuve,numjourn FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ? AND licence = ? ";
$query2.=" AND MONTH(date_event) = ?";
$query2.=" ORDER BY date_event ASC";
//echo $query2;
$dbresult2 = $db->Execute($query2, array( $saison_courante,$licence,$mois_courant));
		
	$rowarray2= array();
	$rowclass2 = 'row1';
	if ($dbresult2 && $dbresult2->RecordCount() > 0)
	{
		while ($row2= $dbresult2->FetchRow())
		{
			
			$onerow2= new StdClass();
			$onerow2->rowclass= $rowclass2;
			$onerow2->date_event= $row2['date_event'];
			$onerow2->nom= $row2['nom'];
			$onerow2->classement= $row2['classement'];
			$onerow2->victoire= $row2['victoire'];
			$onerow2->coeff= $row2['coeff'];
			$onerow2->pointres= $row2['pointres'];
			
			$rowarray2[]= $onerow2;
		}
	}
$smarty->assign('itemsfound2', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount2', count($rowarray2));
$smarty->assign('items2', $rowarray2);
//$smarty->assign('global', $global);
//echo $this->ProcessTemplate('user_results_prov.tpl');
$smarty->assign('pagetitle', 'Le détail des résultats de '.$nom);
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template), null, null, $smarty);
$tpl->display();
 
 

//echo $this->ProcessTemplate('user_results.tpl');


#
# EOF
#
?>
