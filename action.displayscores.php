<?php
if ( !isset($gCms) ) exit; 
//debug_display($params, 'Parms');
$db = cmsms()->GetDb();	
global $themeObject;

if(!empty($this->GetPreference('details_rencontre_page')) )
{
	$cg_ops = new CMSMSExt;
	$alias_page = $this->GetPreference('details_rencontre_page');
	$landing_page = $cg_ops->resolve_alias_or_id($alias_page);
	
}
$smarty->assign('rows_number', '10');//valeur par défaut pour les data-rows
//var_dump($landing_page);
$p_ops = new ping_admin_ops;
$eq_ops = new equipes_ping;

$seasons_list = $p_ops->seasons_list();
$ren_ops = new rencontres;
$smarty->assign('seasons_list', $seasons_list);
$liste_epreuves = $p_ops->liste_epreuves();
$smarty->assign('liste_epreuves', $liste_epreuves);
$parms = array();
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
$idepreuve = (isset($params['idepreuve']) ? $params['idepreuve'] : '8985');

$rowarray = array();
$parms = array();
$parms['saison'] = (isset($params['saison']) ? $params['saison'] : $this->GetPreference('saison_en_cours'));
$parms['phase'] = (isset($params['phase']) ? $params['phase'] : $this->GetPreference('phase_en_cours'));
//the record_id stands for one particular team
if(isset($params['record_id']) && $params['record_id'] >0)
{
	$last_match = $ren_ops->last_match($params['record_id']);
	$equip_id1 = $last_match['equip_id1'];
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
	$equip_id2 = $last_match['equip_id2'];
	
	$eq2 = $eq_ops->idclub($equip_id2);//eq1 = le numéro du club
	
	
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
	$onerow->renc_id = $last_match['renc_id'];
	$onerow->eq_id = $last_match['eq_id'];
	$onerow->saison = $last_match['saison'];
	$onerow->date_event = $last_match['date_event'];
	$onerow->affiche = $last_match['affiche'];
	$onerow->libdivision = $row['libdivision'];
	$onerow->idepreuve = $p_ops->nom_compet($last_match['idepreuve']);
	$onerow->tour = $last_match['tour'];
	$onerow->scorea = $last_match['scorea'];
	$onerow->scoreb = $last_match['scoreb'];
	$onerow->img1 = $img1;
	$onerow->img2 = $img2;
	$onerow->club = $last_match['club'];		
	$onerow->equa= $last_match['equa'];
	$onerow->equb= $last_match['equb'];
	$onerow->horaire= $last_match['horaire'];
	$onerow->uploaded =$ren_ops->is_really_uploaded($last_match['renc_id']);
	$rowarray[] = $onerow;
}
else
{
	$query = "SELECT id, libdivision, idepreuve FROM ".cms_db_prefix()."module_ping_equipes WHERE saison= ? AND phase = ?";
	
	if(isset($params['idepreuve']))
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
			$idepreuve = $p_ops->nom_compet($params['idepreuve']);
			$smarty->assign('idepreuve', $idepreuve);
			
		}
	}
	else
	{
		$parms['idepreuve'] = $idepreuve;
	}
	
	if(isset($params['number']) && $params['number'] >0)
	{
		$query.= " LIMIT ?";
		$parms['number'] = $params['number'];
		$smarty->assign('rows_number', $params['number']); //pour les data-rows
	}
	$dbresult = $db->Execute($query,$parms);


	if($dbresult && $dbresult->RecordCount() >0)
	{
		while($row = $dbresult->FetchRow())
		{
			$last_match = $ren_ops->last_match($row['id']);
			
			if(false != $last_match)
			{
				$equip_id1 = $last_match['equip_id1'];
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
				$equip_id2 = $last_match['equip_id2'];
				$eq2 = $eq_ops->idclub($equip_id2);//eq1 = le numéro du club
	
	
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
				$onerow->renc_id = $last_match['renc_id'];
				$onerow->eq_id = $last_match['eq_id'];
				$onerow->saison = $last_match['saison'];
				$onerow->date_event = $last_match['date_event'];
				$onerow->affiche = $last_match['affiche'];
				$onerow->libdivision = $row['libdivision'];
				$onerow->idepreuve = $p_ops->nom_compet($last_match['idepreuve']);
				$onerow->tour = $last_match['tour'];
				$onerow->scorea = $last_match['scorea'];
				$onerow->scoreb = $last_match['scoreb'];
				$onerow->img1 = $img1;
				$onerow->img2 = $img2;
				$onerow->club = $last_match['club'];		
				$onerow->equa= $last_match['equa'];
				$onerow->equb= $last_match['equb'];
				$onerow->horaire= $last_match['horaire'];
				$onerow->uploaded = $ren_ops->is_really_uploaded($last_match['renc_id']);
				$rowarray[] = $onerow;
			}
		}
	}
	else
	{
		echo 'pas de résultats';
	}
}
$smarty->assign('items', $rowarray);
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('landing_page', $landing_page);


$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();
