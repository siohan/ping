<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
$db = cmsms()->GetDb();
global $themeObject;
$mois_courant = date('n');
$annee_courante = date('Y');

$mois_choisi = '';

$liste_mois_fr = array("Janvier", "Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre", "Décembre");
$phase = $this->GetPreference('phase_en_cours');
$saison_courante = (isset($params['saison']) ? $params['saison'] : $this->GetPreference('saison_en_cours'));
if(isset($params['template']) && $params['template'] !='')
{
	$template = $params['template'];
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Situation Mensuelle');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template situation mensuelle introuvable');
        return;
    }
    $template = $tpl->get_name();
} 
	
	if(isset($params['mois'] ) && $params['mois'] !='' && isset($params['annee']) && $params['annee'] !='') 
	{
		
		$mois_choisi = (int) $params['mois'];
		$annee = $params['annee'];	
		if($mois_choisi == 12)
		{
			$mois_suivant = 1;
			$mois_precedent = 11;
			$annee_suivante = $annee+1;
			$annee_precedente = $annee;
			$annee= $annee;
			
		}
		elseif($mois_choisi == 1)
		{
			$mois_precedent = 12;
			$mois_suivant = $mois_choisi + 1;
			$annee_precedente = $annee - 1;
			$annee_suivante = $annee;
			$annee= $annee;
		}
		else
		{
			$mois_precedent = $mois_choisi - 1;
			$mois_suivant = $mois_choisi + 1;
			$annee_precedente = $annee;
			$annee_suivante = $annee;
			$annee= $annee;
		}
			
		
	}
	else
	{
		//pas de mois choisi on prend par défaut
		
		if(date('d') < 10 )
		{
			if(date('n') == 1)//premier mois de l'année
			{
				//on est début janvier, on veut afficher la situation de décembre
				//pour les liens suivants
				$mois_choisi = 12;
				$annee = date('Y')-1;
				$mois_precedent = 11;
				$mois_suivant = 1;
				$annee_precedente = $annee_courante - 1;
				$annee_suivante = date('Y');
			}
			else
			{
				$mois_choisi = date('n')-1;
				$annee = date('Y');
				$mois_precedent = date('n')-2;
				$mois_suivant = date('n')-1;
				$annee_precedente = $annee_courante - 1;
				$annee_suivante = date('Y');
			}
			
		
		}
		else
		{
			if(date('n') == 1)//premier mois de l'année
			{
				//on est début janvier, on veut afficher la situation de décembre
				//pour les liens suivants
				$mois_choisi = 1;
				$annee = date('Y');
				$mois_precedent = 12;
				$mois_suivant = 2;
				$annee_precedente = $annee_courante - 1;
				$annee_suivante = date('Y');
			}
			else
			{
				$mois_choisi = date('n');
				$mois_suivant = $mois_choisi + 1;
				$mois_precedent = $mois_choisi - 1;
				$annee = date('Y');
				$annee_precedente = $annee;
				$annee_suivante = $annee;
			}
		}
		
		
	}	
	
	$smarty->assign('mois_courant', $mois_courant);
	$smarty->assign('mois_precedent',$mois_precedent);
	$smarty->assign('mois_suivant', $mois_suivant);
	$smarty->assign('annee_suivante', $annee_suivante);
	$smarty->assign('annee_precedente', $annee_precedente);
	
			


$jour = date('j');
//Faire une préférence pour ne pas afficher le mois pas encore en accès libre ?

$phase_courante = $this->GetPreference('phase');

$query = "SELECT sm.licence,sm.mois,sm.annee, sm.points,sm.datemaj, sm.clnat, sm.rangreg, sm.rangdep,sm.progann, sm.progmois,sm.clglob, CONCAT_WS(' ', j.nom, j.prenom) AS joueur FROM ".cms_db_prefix()."module_ping_sit_mens AS sm, ".cms_db_prefix()."module_ping_joueurs AS j WHERE sm.licence  = j.licence AND j.actif = '1' AND type='T' AND annee = ? AND mois = ?";
$parms['annee'] = $annee;
$parms['mois'] = $mois_choisi; 
	
	if(isset($params['sort']) )
	{
		
		if($params['sort'] == 'prog_mois')
		{
				$query.=" ORDER BY sm.progmois DESC";
		}
		if($params['sort'] == 'prog_ann')
		{
				$query.=" ORDER BY sm.progann DESC";
		}
	}

	

	if(isset($params['number']) && $params['number'] >0)
	{
		$query.= " LIMIT ?";
		$parms['number'] = $params['number'];
	}
	
	$dbresult = $db->Execute($query, $parms);

$rowclass= 'row1';
$rowarray= array ();

if ($dbresult && $dbresult->RecordCount() > 0)
{
    while ($row= $dbresult->FetchRow())
	{
	
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		
		$licence = $row['licence'];
		//$genid = $details_adh['genid'];
		$onerow->joueur= $row['joueur'];
		$onerow->points = $row['points'];
		$onerow->clglob = $row['clglob'];
		$onerow->clnat= $row['clnat'];
		$onerow->rangreg= $row['rangreg'];
		$onerow->rangdep= $row['rangdep'];
		$onerow->progmois= $row['progmois'];
		$onerow->progann= $row['progann'];
		$onerow->licence= $row['licence'];
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

}
//var_dump($annee);
$mois_def = $mois_choisi -1;
$mois_en_fr = $liste_mois_fr[$mois_def];
$smarty->assign('mois_choisi', $mois_en_fr);
$smarty->assign('mois_choisi_2', $mois_choisi);

$smarty->assign('pagetitle', 'La situation mensuelle de '.$mois_en_fr.' '.$annee);

$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();



#
# EOF
#
?>
