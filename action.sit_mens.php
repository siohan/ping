<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/include/prefs.php');
$db = cmsms()->GetDb();
global $themeObject;
$mois_courant = date('n');
$annee_courante = date('Y');
$mois_choisi = '';
//$adh_ops = new Asso_adherents;

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

	if($params['mois'] !='' )
	{
		$mois_choisi = (int) $params['mois'];		
	}
	else
	{
		//pas de mois choisi on prend par défaut
		if(date('d') < 10 )
		{
			if(date('n') == 1)
			{
				//on est début janvier, on veut afficher la situation de décembre
				//pour les liens suivants
				$mois_choisi = 12;
			}
			else
			{
				$mois_choisi = date('n') -1;
			}

		}
		else
		{
			$mois_choisi = date('n');
		} 
	}	
	
	//pour les liens précédent et suivant :	
	if(date('d') < 10 )
	{
			if($mois_choisi == 1)
			{
				//on est début janvier, on veut afficher la situation de décembre
				//pour les liens suivants
				$mois_suivant = 1;
				$mois_precedent = 11;
				
			}
			elseif($mois_choisi == 12)
			{
				$mois_suivant = 12;
				$mois_precedent = 11;
			}
			else
			{
				$mois_precedent = $mois_choisi - 1;
				$mois_suivant = $mois_choisi +1;
			}
	}
	else
	{
			if($mois_choisi == 1)
			{
				//on est début janvier, on veut afficher la situation de décembre
				//pour les liens suivants
				$mois_suivant = 2;
				$mois_precedent = 12;
				
			}
			elseif($mois_choisi == 12)
			{
				$mois_suivant = 1;
				$mois_precedent = 11;
			}
			else
			{
				$mois_precedent = $mois_choisi - 1;
				$mois_suivant = $mois_choisi +1;
			}
			//$mois_precedent = $mois_choisi - 1;
			//$mois_suivant = $mois_choisi +1;
	} 
	

	$smarty->assign('mois_precedent',$mois_precedent);
	$smarty->assign('mois_suivant', $mois_suivant);
	
			


$jour = date('j');
//Faire une préférence pour ne pas afficher le mois pas encore en accès libre ?

$phase_courante = $this->GetPreference('phase');

$query = "SELECT sm.licence,sm.mois, sm.points, sm.clnat, sm.rangreg, sm.rangdep,sm.progann, sm.progmois,sm.clglob, CONCAT_WS(' ', j.nom, j.prenom) AS joueur FROM ".cms_db_prefix()."module_ping_sit_mens AS sm, ".cms_db_prefix()."module_ping_joueurs AS j WHERE sm.licence  = j.licence AND j.actif = '1' AND type='T'";//" WHERE annee = ? AND mois = ?";

	if(isset($params['mois']) && $params['mois'] >0)
	{
		$query.=" AND sm.mois = ?";
		$parms['mois'] = $mois_choisi;
	
	}
	else
	{
		$query.=" AND sm.mois = ?";
		$parms['mois'] = $mois_choisi;
	}
	
	$query.=" AND sm.saison = ?";
	$parms['saison'] = $saison_courante;
	
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
	
	//echo $query;
	$dbresult = $db->Execute($query, $parms);

$rowclass= 'row1';
$rowarray= array ();

if ($dbresult && $dbresult->RecordCount() > 0)
{
    while ($row= $dbresult->FetchRow())
	{
	
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		//on va chercher l'image du joueur (définie ds le module adhérents)
		//$details_adh = $adh_ops->details_adherents($row['licence']);
		$genid = $details_adh['genid'];
		$onerow->joueur= $row['joueur'];
		$onerow->points = $row['points'];
		$onerow->clglob = $row['clglob'];
		$onerow->clnat= $row['clnat'];
		$onerow->rangreg= $row['rangreg'];
		$onerow->rangdep= $row['rangdep'];
		$onerow->progmois= $row['progmois'];
		$onerow->progann= $row['progann'];
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
}
$mois_def = $mois_choisi -1;
$mois_en_fr = $liste_mois_fr[$mois_def];
$smarty->assign('mois_choisi', $mois_en_fr);

$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();



#
# EOF
#
?>
