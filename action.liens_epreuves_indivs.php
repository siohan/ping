<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parms');
$db = cmsms()->GetDb();
global $themeObject;

if(isset($params['template']) && $params['template'] !="")
{
	$template = trim($params['template']);
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Résultats pour une épreuve individuelle');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template résultats pour une équipe introuvable');
        return;
    }
    $template = $tpl->get_name();
}

$page = $this->GetPreference('details_indivs');
	
	$cg_ops = new CMSMSExt;
	$landing_page = $cg_ops->resolve_alias_or_id($page);//'presence';
	$smarty->assign('landing_page', $landing_page);
	
$now = time();
$epreuves = new EpreuvesIndivs;
$club = $epreuves->nom_club();
$rowclass = "";
$nclub="%".$club."%";
//$query = "SELECT DISTINCT tc.idepreuve,tc.friendlyname, tc.saison FROM ".cms_db_prefix()."module_ping_type_competitions AS tc, ".cms_db_prefix()."module_ping_div_classement AS cla WHERE tc.idepreuve = cla.idepreuve AND tc.indivs= 1 AND tc.actif = 1 AND cla.club LIKE ? ORDER BY saison DESC,friendlyname ASC";
$query = "SELECT DISTINCT t.idepreuve, t.date_prevue,c.tour, c.club FROM `cms_module_ping_div_tours` t , `cms_module_ping_div_classement` c WHERE t.idepreuve = c.idepreuve AND t.iddivision = c.iddivision AND t.tour = c.tour AND c.club LIKE ? ORDER BY t.date_prevue DESC";
$dbresult= $db->Execute($query, array($nclub));
	
	$rowarray= array();
	
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			
    			while ($row= $dbresult->FetchRow())
      			{					
					$onerow = new StdClass();
					$onerow->rowclass = $rowclass;
					$onerow->idepreuve = $row['idepreuve'];
					$onerow->libelle = $epreuves->get_epr_name($row['idepreuve']);
					$onerow->date_prevue = $row['date_prevue'];
					$onerow->tour = $row['tour'];
					($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
					$rowarray[]= $onerow;									
      			}
      	}
      	$smarty->assign('itemsfound', $this->Lang('resultsfound'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
  		$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
		$tpl->display();
  		
  		
#
# EOF
#
?>
