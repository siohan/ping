<?php
if ( !isset($gCms) ) exit; 
//debug_display($params, 'Params');

$db = cmsms()->GetDb();	
global $themeObject;
if(!empty($this->GetPreference('details_rencontre_page')) )
{
	$cg_ops = new CMSMSExt;
	$alias_page = $this->GetPreference('details_rencontre_page');
	$landing_page = $cg_ops->resolve_alias_or_id($alias_page);
	
}

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


$pagenumber = 1;
if(isset($params['pagenumber']))
{
	$pagenumber = (int)$params['pagenumber'];
}
// calcule le nb de résultats à afficher en tout
$nb_items = (int) $ren_ops->nb_items_affiche($parms['saison'], $parms['phase'], $params['idepreuve']);

$inline = false;
//on calcule maintenant le nb de pages
$number = 4; //par défaut au cas où
if(isset($params['number']) && $params['number'] >0)
{
	$number = (int)$params['number'];
}
$start = $number*($pagenumber-1);
$pages = ceil($nb_items/$number);
$suiv = $this->create_url($id,'displayaffiche',$returnid, array("pagenumber"=>$pagenumber+1,"number"=>$number, "template"=>$template),  $inline=true);
$prec = $this->create_url($id,'displayaffiche',$returnid, array("pagenumber"=>$pagenumber-1,"number"=>$number, "template"=>$template),  $inline=true);
$first = $this->create_url($id,'default',$returnid, array("pagenumber"=>"1","number"=>$number, "template"=>$template),  $inline=true);
$last = $this->create_url($id,'default',$returnid, array("pagenumber"=>$pages,"number"=>$number,  "template"=>$template),  $inline=true);

$query = "SELECT id, libdivision,saison FROM ".cms_db_prefix()."module_ping_equipes WHERE saison LIKE ? AND phase = ?";
//des paramètres ?
if(isset($params['idepreuve']) )
{
	//on détermine s'il s'agit d'un tableau (avec présence virgule) ou pas
	//il faut aussi supprimer la phase (-1 ou -2)
	if(false !== strstr( $params['idepreuve'],","))
	{
		
		//var_dump($params['idepreuve']);
		
		$tab = explode(',', $params['idepreuve']);
		
		$epreuve = array();
		foreach($tab as $value)
		{
			
			$epreuve[] = strstr($value,'-',true);
			
			
		}
		
		$query.= " AND idepreuve IN (".implode(',',$epreuve).")";
	}
	else
	{
		$epreuve = explode('-', $params['idepreuve']);
		$query.= " AND idepreuve = ?";
		$parms['idepreuve'] = $epreuve[0];//$params['idepreuve'];
	}
}
$query.=" ORDER BY idepreuve DESC"; //pour que les équipes féminines soient mises en avant

if(isset($params['number']) && $params['number'] >0)
{
	$query.= " LIMIT ?, ?";
	$parms['start'] = $start;
	$parms['number'] = $params['number'];
}
$dbresult = $db->Execute($query,$parms);

if($dbresult) 
{
	if( $dbresult->RecordCount() >0)
	{
		$rowarray = array();
		while($row = $dbresult->FetchRow())
		{
			$next_match = $ren_ops->next_match($row['id']);
			//var_dump($next_match);
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
				$details = $eq_ops->details_equipe($row['id']);
				//var_dump($details);
				$onerow->renc_id = $next_match['renc_id'];
				$onerow->eq_id = $next_match['eq_id'];
				/*
				$onerow->saison = $details['saison'];
				$onerow->date_event = $next_match['date_event'];
				$onerow->affiche = $next_match['affiche'];
				* */
				$onerow->date_event = $next_match['date_event'];
				$pos = strpos($row['libdivision'], '_');
				if($pos == 3)
				{
					$onerow->libdivision = substr(str_replace('_', ' ',$row['libdivision']),4);
				}
				else
				{
					$onerow->libdivision = str_replace('_', ' ',$row['libdivision']);
				}
				$onerow->img1 = $img1;
				$onerow->img2 = $img2;
				$onerow->tour = $next_match['tour'];
				//$onerow->scorea = $next_match['scorea'];
				//$onerow->scoreb = $next_match['scoreb'];
				//$onerow->club = $next_match['club'];		
				$onerow->equa= $next_match['equa'];
				$onerow->equb= $next_match['equb'];
				$onerow->horaire= $next_match['horaire'];
				$rowarray[] = $onerow;
			}
			else
			{
				//echo "pas de résultats";
			}
		}
		$smarty->assign('items', $rowarray);
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('suiv', $suiv);
		$smarty->assign('prec', $prec);
		$smarty->assign('first', $first);
		$smarty->assign('last', $last);
		$smarty->assign('number', $number);
		$smarty->assign('pages', $pages);
		$smarty->assign('pagenumber', $pagenumber);
		$smarty->assign('landing_page', $landing_page);
		$smarty->assign('start', $start);
	}
	else
	{
		//echo "pas de résultats !";
	}
	
}

	
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();
