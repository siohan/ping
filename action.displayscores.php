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

//$parms['saison'] = (isset($params['saison']) ? $params['saison'] : $this->GetPreference('saison_en_cours'));
$parms['phase'] = $phase = (isset($params['phase']) ? $params['phase'] : $this->GetPreference('phase_en_cours'));

//the record_id stands for one particular team
if(isset($params['record_id']) && $params['record_id'] >0)//le record_id pour une équipe spécifique
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
	$details = $eq_ops->details_equipe($last_match['eq_id']);
	$onerow = new StdClass();
	$onerow->renc_id = $last_match['renc_id'];
	$onerow->eq_id = $last_match['eq_id'];
	$onerow->saison = $last_match['saison'];
	$onerow->date_event = $last_match['date_event'];
	$onerow->affiche = $last_match['affiche'];
	$libequipe = (isset($details['friendlyname'])?$details['friendlyname']:$details['libequipe']);
	$onerow->libequipe = $libequipe;
	$pos = strpos($details['libdivision'], '_');
	if($pos == 3)
	{
		$onerow->libdivision = substr(str_replace('_', ' ',$details['libdivision']),4);
	}
	elseif(false == $pos)
	{
		$onerow->libdivision = $details['libdivision'];
	}
	else
	{
		$onerow->libdivision = str_replace('_', ' ',$details['libdivision']);
	}
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
else //pas de numéro d'équipe précisé, on est ds le cas général
{
	$pagenumber = 1;
	if(isset($params['pagenumber']))
	{
		$pagenumber = (int)$params['pagenumber'];
	}
	
	$nb_items = $ren_ops->nb_items_affiche($parms['phase'], $params['idepreuve']);
	$inline = false;
	//on calcule maintenant le nb de pages
	$number = 100; //par défaut au cas où
	if(isset($params['number']) && $params['number'] >0)
	{
		$number = (int)$params['number'];
	}
	$start = $number*($pagenumber-1);
	$pages = ceil($nb_items/$number);
	$suiv = $this->create_url($id,'displayscores',$returnid, array("pagenumber"=>$pagenumber+1,"number"=>$number, "template"=>$template),  $inline=true);
	$prec = $this->create_url($id,'displayscores',$returnid, array("pagenumber"=>$pagenumber-1,"number"=>$number, "template"=>$template),  $inline=true);
	$first = $this->create_url($id,'displayscores',$returnid, array("pagenumber"=>"1","number"=>$number, "template"=>$template),  $inline=true);
	$last = $this->create_url($id,'displayscores',$returnid, array("pagenumber"=>$pages,"number"=>$number,  "template"=>$template),  $inline=true);
	
	$query = "SELECT id, libdivision, idepreuve, friendlyname FROM ".cms_db_prefix()."module_ping_equipes WHERE phase = ?";//saison = ? AND phase = ?";
	$parms['phase'] = $phase;
	if(isset($params['idepreuve']) )
{
	
	//$smarty->assign('idepreuve', $p_ops->nom_compet($last_match['idepreuve']));
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
		//$parms['idepreuve'] = $epreuve;
	}
	else
	{
		$epreuve = explode('-', $params['idepreuve']);
		$query.= " AND idepreuve = ?";
		$parms['idepreuve'] = trim($epreuve[0]);//$params['idepreuve'];
		
	}
}
	
	$smarty->assign('suiv', $suiv);
	$smarty->assign('prec', $prec);
	$smarty->assign('first', $first);
	$smarty->assign('last', $last);
	$smarty->assign('pagenumber', $pagenumber);
	$smarty->assign('number', $number);
	$smarty->assign('pages', $pages);
	$smarty->assign('landing_page', $landing_page);
	$query.=" LIMIT ?, ?";
	$parms['start'] = $start;
	$parms['number'] = $number;
	//echo $query;
	$dbresult = $db->Execute($query,$parms);//array($idepreuve));
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
				//on fait un timestamp de la date et de l'horaire pour comparer à $smarty.now dans les templates
				
				$horaire = $last_match['horaire'];
			
				if(false == empty($horaire)) // l'horaire contient une donnée
				{
					$hor = explode(':', $horaire);
					if($hor[1] == '00')
					{
						$hor[1] = (int) 0;
					}
					$hor[2] = (int) 0; //pour les secondes	
				}
				else
				{
					//pas d'horaire donné, on en fabrique un
					$hor[1] = (int) 0;
					$hor[2] = (int) 0;
				}
						
				$tab = explode('-', $last_match['date_event']);
				
				$month = $tab[1];
				//echo $month;
				$deadline = mktime($hor[0],$hor[1], 0, $tab[1],$tab[2],$tab[0]);
				
				$onerow = new StdClass();
				$onerow->renc_id = $last_match['renc_id'];
				$onerow->eq_id = $last_match['eq_id'];
				$onerow->saison = $last_match['saison'];
				$onerow->date_event = $last_match['date_event'];
				$onerow->affiche = $last_match['affiche'];
				$onerow->friendlyname = $row['friendlyname'];
				$onerow->deadline = $deadline;
				$pos = strpos($row['libdivision'], '_');
				
				if($pos == "3")
				{
					$onerow->libdivision = substr(str_replace('_', ' ',$row['libdivision']),4);
				}
				elseif(false === $pos)
				{
					$onerow->libdivision = str_replace('_', ' ',$row['libdivision']);
				}
				else
				{
					$onerow->libdivision = $row['libdivision'];
				}
				//var_dump($pos);
				
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
			else
			{
				//echo "pas de données !";
			}
		}
	}
	else
	{
		echo 'Erreur !';
	}
	
}
$smarty->assign('items', $rowarray);
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('landing_page', $landing_page);


$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();
