<?php
if ( !isset($gCms) ) exit; 
//debug_display($params, 'Params');

$db = cmsms()->GetDb();	
global $themeObject;
$p_ops = new ping_admin_ops;
$ren_ops = new rencontres;
$eq_ops = new equipes_ping;
$seasons_list = $p_ops->seasons_list();
$smarty->assign('seasons_list', $seasons_list);
$liste_epreuves = $p_ops->liste_epreuves();
$smarty->assign('liste_epreuves', $liste_epreuves);
if(isset($params['template']) && $params['template'] !="")
{
	$template = $params['template'];
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Résultats Par Equipes');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template not found !');
        return;
    }
    $template = $tpl->get_name();
}
$parms = array();
$parms['saison'] = (isset($params['saison']) ? $params['saison'] : $this->GetPreference('saison_en_cours'));
$parms['phase'] = (isset($params['phase']) ? $params['phase'] : $this->GetPreference('phase_en_cours'));


$query = "SELECT id, libdivision FROM ".cms_db_prefix()."module_ping_equipes WHERE saison LIKE ? AND phase = ?";
//des paramètres ?
if(isset($params['idepreuve']) )
{
	//on détermine s'il s'agit d'un tableau (avec présence virgule) ou pas
	if(false !== strstr( $params['idepreuve'],","))
	{
		$tab = explode(',', $params['idepreuve']);
		$query.= " AND idepreuve IN (".implode(',',$tab).")";
	}
	else
	{
		$query.= " AND idepreuve = ?";
		$parms['idepreuve'] = $params['idepreuve'];
	}
}

if(isset($params['number']) && $params['number'] >0)
{
	$query.= " LIMIT ?";
	$parms['number'] = $params['number'];
}

$dbresult = $db->Execute($query,$parms);

if($dbresult) 
{
	if( $dbresult->RecordCount() >0)
	{
		while($row = $dbresult->FetchRow())
		{
			$next_match = $ren_ops->next_match($row['id']);
			//va chercher la prochaine journée de championnat, 
			//le id est le numéro de l'équipe en bdd
			if(false != $next_match)
			{
				//on va chercher les logos s'ils existent
				$equip_id1 = $next_match['equip_id1'];
				$eq1 = $eq_ops->idclub($equip_id1);//eq1 = le numéro du club
    			
				$img1= '';
				$dir = 'modules/Ping/images/logos/';

				$ext_list = array('.gif', '.jpg', '.png','.jpeg');
				
				foreach($ext_list as $ext)
				{
					if(true == file_exists($dir.$eq1.$ext))
					{
						$img1 = $eq1.$ext;
					}
				}
				$img2 = '';			
				$equip_id2 = $next_match['equip_id2'];
				$eq2 = $eq_ops->idclub($equip_id2);//eq2 = le numéro du club
    			
				
				$dir = 'modules/Ping/images/logos/';

				$ext_list = array('.gif', '.jpg', '.png','.jpeg');
				
				foreach($ext_list as $ext)
				{
					if(true == file_exists($dir.$eq2.$ext))
					{
						$img2 = $eq2.$ext;
					}
				}
				
				$onerow = new StdClass();
				$onerow->renc_id = $next_match['renc_id'];
				$onerow->eq_id = $next_match['eq_id'];
				$onerow->saison = $next_match['saison'];
				$onerow->date_event = $next_match['date_event'];
				$onerow->affiche = $next_match['affiche'];
				$onerow->libdivision = $row['libdivision'];
				$onerow->img1 = $img1;
				$onerow->img2 = $img2;
				$onerow->tour = $next_match['tour'];
				$onerow->scorea = $next_match['scorea'];
				$onerow->scoreb = $next_match['scoreb'];
				$onerow->club = $next_match['club'];		
				$onerow->equa= $next_match['equa'];
				$onerow->equb= $next_match['equb'];
				$onerow->horaire= $next_match['horaire'];
				$rowarray[] = $onerow;
			}
		}
		$smarty->assign('items', $rowarray);
		$smarty->assign('itemcount', count($rowarray));
	}
	
}

	
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();
//echo $this->ProcessTemplate('displayaffiche.tpl');