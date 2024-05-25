<?php
if(!isset($gCms)) exit;
//debug_display($params, 'Parameters');
$db = cmsms()->GetDb();
$saison_en_cours = $this->GetPreference('saison_en_cours');
$saison = (isset($params['saison']))?$params['saison']:$saison_en_cours;
$record_id = '';
if(isset($params['record_id']) && $params['record_id'] !='')
{
	$renc_ops = new rencontres;
	$epr = new EpreuvesIndivs;
	$eq = new equipes_ping;
	$record_id = (int) $params['record_id'];// C'est le numéro de la rencontre
	//on récupère le résultat final pour affichage
	$details_renc = $renc_ops->details_rencontre($record_id);
	$scorea  =$details_renc['scorea'];
	$scoreb = $details_renc['scoreb'];
	$championnat = $details_renc['libelle'];
	$det_epr = $epr->details_epreuve($details_renc['idepreuve']);
	$eq_id = $details_renc['eq_id'];
	$details_eq = $eq->details_equipe($eq_id); //les détails de l'équipe du club concerné par cette rencontre (poule)
	$libdivision = $details_eq['libdivision'];
	$pos = strpos($libdivision, '_');
	//var_dump($pos);
	if($pos == 3)
	{
		//echo 'cool';
		$newlib = substr($libdivision, '4');
	}
	
	
	echo $newlib;
	$idepreuve = $det_epr['name'];
	$equa = $details_renc['equa'];
	$equb = $details_renc['equb'];
	$pagetitle = $equa.'/'.$equb.' - '.$idepreuve.' '.$championnat;
	$smarty->assign('equa', $equa);
	$smarty->assign('equb', $equb);
	$smarty->assign('pagetitle',$pagetitle); 
	$smarty->assign('scorea', $scorea);
	$smarty->assign('scoreb', $scoreb);
	
	$smarty->assign('championnat', $championnat);
	$smarty->assign('idepreuve', $idepreuve);
	//$smarty->assign('division', $details_renc['
}
else
{
	$message = 'Un pb est survenu';
}
if(isset($params['template']) && $params['template'] !="")
{
	$template = trim($params['template']);
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::feuille_rencontre');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template résultats pour une équipe introuvable');
        return;
    }
    $template = $tpl->get_name();
}


//le numéro de l'équipe est ok, on continue
//on va d'abord récupérer la feuille de match
$query = "SELECT id, fk_id, xja, xca, xjb, xcb FROM ".cms_db_prefix()."module_ping_feuilles_rencontres  WHERE fk_id = ? ORDER BY id ASC";
$dbresult= $db->Execute($query, array($record_id));
$lignes = $dbresult->RecordCount();
$rowarray = array();
$rowclass = 'row1';
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->id= $row['id'];
		$onerow->fk_id = $row['fk_id'];
		$onerow->xja = $row['xja'];
		$onerow->xca= $row['xca'];
		$onerow->xjb=  $row['xjb'];
		$onerow->xcb= $row['xcb'];
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
}
else
{
	//pas de résultats ? on télécharge celui-ci ?
	
}

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);


/**/

$query2 = "SELECT id, fk_id, joueurA, scoreA, joueurB, scoreB, detail FROM ".cms_db_prefix()."module_ping_rencontres_parties WHERE fk_id = ? ORDER BY id ASC";
$parms['fk_id'] = $record_id;

$dbresultat = $db->Execute($query2,$parms);
$rowarray2 = array();
$i = 0;
if($dbresultat && $dbresultat->RecordCount()>0)
{
	
	while($row2 = $dbresultat->FetchRow())
	{
		$i++;
		$id = $row2['id'];
		//$fk_id = $row2['idpoule'];
		//$iddiv = $row2['iddiv'];
		$onerow2 = new StdClass();
		$onerow2->rowclass =$rowclass;
		$onerow2->id = $row2['id'];
		$onerow2->fk_id = $row2['fk_id'];
		$onerow2->joueurA = $row2['joueurA'];
		$onerow2->scoreA = $row2['scoreA'];
		$onerow2->joueurB = $row2['joueurB'];
		$onerow2->scoreB = $row2['scoreB'];
		$onerow2->detail = $row2['detail'];
		$rowarray2[]  = $onerow2;
	}
	
	$smarty->assign('itemcount2', count($rowarray2));
	$smarty->assign('items2', $rowarray2);
}
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();
#
#EOF
#
?>
