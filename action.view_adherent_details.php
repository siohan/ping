<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');

if (!$this->CheckPermission('Ping use'))
{
	$designation .=$this->Lang('needpermission');
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('joueurs');
}

	$db = cmsms()->GetDb();
	global $themeObject;
	$pg_ops = new ping_admin_ops;
	$j_ops = new joueurs;
	$spid = new spid_ops;
	$edit = 0;
	if(isset($params['record_id']) && $params['record_id'])
	{
		$record_id = $params['record_id'];
		
		
		$details = $j_ops->details_joueur($record_id);
		//var_dump($details);
		$edit = 1;
		$actif = $details['actif'];
		$licence = $details['licence'];
		$nom = $details['nom'];
		$prenom = $details['prenom'];
		$club = $details['club'];
		$nclub = $details['nclub'];
		$type = $details['type'];
		$sexe = $details['sexe'];
		$certif = $details['certif'];
		$date_validation = $details['validation'];
		
	}
	$smarty->assign('player', $details['nom'].' '.$details['prenom']);
	$next = $j_ops->next($details['nom'], $details['prenom']);
	if(false != $next){$smarty->assign('next', $next);}
	$previous = $j_ops->previous($details['nom'], $details['prenom']);
	if(false != $previous){$smarty->assign('previous', $previous);}
	$smarty->assign('actif', $actif);
	$validation = 0; //Par défaut, si type = T alors on montre les autres volets
	if($type == 'T'){ $validation = 1;}
	$smarty->assign('validation', $validation);
	
	$spid_account = $spid->has_spid_account($licence); 
	
	$pts_spid = 0;
	if(true == $spid_account)
	{
		//on va chercher tous les renseignements pour completer l'encart
		$details = $spid->details_recup($licence);
		$smarty->assign('details', $details);
	}
	//on prépare une navigation
	
	$query = "SELECT DISTINCT SUBSTRING(nom, 1,1) AS letter FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = 1 GROUP BY nom";
	$dbresult = $db->Execute($query);
	if($dbresult && $dbresult->RecordCount() >0)
	{
		$rowarray = array();
		while($row = $dbresult->FetchRow())
		{
			$onerow = new StdClass();
			$onerow->letter = $row['letter'];
			$rowarray[] = $onerow;
		}
	}
	
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
	//$smarty->assign('genid', $record_id);
	//echo $this->ProcessTemplate('navigation_joueurs.tpl');
	echo $this->ProcessTemplate('player_nav.tpl');
	
	//pour savoir si le membre est actif ou pas
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_is_active.tpl'), null, null, $smarty);	
	$tpl->assign('genid', $licence);
	$tpl->assign('actif', $actif);
	$tpl->display();
	
	//pour savoir si le membre a une licence tradi ou promotionnelle
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_is_tradi.tpl'), null, null, $smarty);	
	$tpl->assign('licence', $licence);
	$tpl->assign('type', $type);
	$tpl->display();
	
	//pour savoir la date de validation du joueur (certificat médical)
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_certif_date.tpl'), null, null, $smarty);	
	$tpl->assign('licence', $licence);
	$tpl->assign('validation', $validation);
	$tpl->assign('date_validation', $date_validation);
	$tpl->display();
	
	
	
	if ($validation == '1')
	{
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_spid_account.tpl'), null, null, $smarty);
		$tpl->assign('validation', $validation);	
		$tpl->assign('spid_account', $spid_account);
		$tpl->assign('licence', $licence);
		$tpl->assign('pts_spid', $pts_spid);
		$tpl->display();
		
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_spid_points.tpl'), null, null, $smarty);
		$tpl->assign('validation', $validation);	
		$tpl->assign('licence', $licence);
		$tpl->assign('pts_spid', $pts_spid);
		$tpl->display();
		
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_sit_mens.tpl'), null, null, $smarty);
		$tpl->assign('licence', $licence);
		$tpl->display();
		
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_sit_mens_points.tpl'), null, null, $smarty);
		$tpl->assign('licence', $licence);
		$tpl->display();
	}
	
#
#EOF
#
?>
