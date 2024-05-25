<?php
if(!isset($gCms)) exit;
//debug_display($params, 'Parameters');
$db = cmsms()->GetDb();
$epreuves = new EpreuvesIndivs;

$club = $epreuves->nom_club();

$nclub="%".$club."%";
$smarty->assign('club', $nclub);
$record_id = '';
$parms = array();
if(!isset($params['record_id']) || $params['record_id'] =='')//c'est le id de l'épreuve
{
	$message = 'Un pb est survenu';
}
else
{
	$record_id = (int) $params['record_id'];
	$smarty->assign('record_id', $record_id);
	$eq_ops = new EpreuvesIndivs;
	$details = $eq_ops->details_epreuve($record_id);
	//l'épreuve comptet-elle plusieurs tours ?
	$has_tours = $epreuves->has_tours($record_id);
	var_dump($has_tours);
	if($details['friendlyname'] !='')
	{
		$friendlyname = $details['friendlyname'];
		$smarty->assign('pagetitle', $friendlyname);
	}
	
		
	
}
if(isset($params['tableau']))
{
	$smarty->assign('tableau', $params['tableau']);
}

if(isset($params['template']) && $params['template'] !="")
{
	$template = trim($params['template']);
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Resultats Indivs');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template Individuelles introuvable');
        return;
    }
    $template = $tpl->get_name();
}
	$page = $this->GetPreference('details_indivs');
	
	$cg_ops = new CMSMSExt;
	$landing_page = $cg_ops->resolve_alias_or_id($page);//'presence';
	
	$smarty->assign('landing_page', $landing_page);
	$yes_club = true;	//

$i = 1;
//SELECT tc.idepreuve, divi.iddivision, divi.libelle FROM cms_module_ping_type_competitions AS tc , cms_module_ping_divisions AS divi WHERE tc.idepreuve = divi.idepreuve AND tc.idepreuve = 9985  AND tc.actif = 1 AND tc.suivi = 1
$query = "SELECT DISTINCT tableau, idepreuve, iddivision, tour FROM ".cms_db_prefix()."module_ping_div_classement WHERE idepreuve = ? AND club LIKE ?";
$query.=" GROUP BY tableau ASC ORDER BY tour ASC";
$dbresult= $db->Execute($query, array($record_id, $nclub));
$rowclass = '';
$rowarray = array();
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$i++;
		$onerow= new StdClass();
		//$onerow->idepreuve=  $row['idepreuve'];
		$onerow->libelle= $epreuves->get_table_name($row['idepreuve'],$row['iddivision']);
		$onerow->tour = $epreuves->get_tour($row['tableau']);
		$onerow->tableau= $row['tableau'];
		$onerow->valeur = $i;
		
		$query2 = "SELECT rang, nom, club FROM ".cms_db_prefix()."module_ping_div_classement WHERE idepreuve = ? AND tableau = ?";
		if(isset($params['tableau']) && $params['tableau'] == $row['tableau']) 
		{
			$dbresult2 = $db->Execute($query2, array($record_id, $row['tableau']));
			$yes_club = 0;
		}
		else
		{
			$query2.=" AND club LIKE ?";
			$dbresult2 = $db->Execute($query2, array($record_id, $row['tableau'], $nclub));
		} 
		
		//AND club LIKE '%fouesnant%'";
		
		$rowarray2 = array();
			
		if($dbresult2 && $dbresult2->RecordCount()>0)
		{
			while($row2 = $dbresult2->FetchRow())
			{
				$onerow2  = new StdClass();
				$onerow2->rowclass = $rowclass;
				$onerow2->rang = $row2['rang'];
				$onerow2->nom = $row2['nom'];
				$onerow2->club = $row2['club'];
				$rowarray2[] = $onerow2;
			}
			$smarty->assign('prods_'.$i,$rowarray2);
			$smarty->assign('itemscount_'.$i, count($rowarray2));
			unset($rowarray2);
		}
		$rowarray[]= $onerow;
	}
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
	$smarty->assign('yes_club', $yes_club);
}
else
{
	echo 'Pas encore de résultats';//pas de résultats ?
}

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
//$tpl->assign('titresecond', $titre);
$tpl->display();
#
#EOF
#
?>
