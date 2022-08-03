<?php
if (!isset($gCms)) exit;

//debug_display($params, 'Parameters');
$equipes_ops = new equipes_ping;
$ping_admin_ops = new ping_admin_ops();
$spid_ops = new spid_ops;
$ren = new rencontres;
require_once('include/prefs.php');
if (!$this->CheckPermission('Ping Delete'))
{
	$params = array('message'=>Lang('needpermission'), 'active_tab' => 'users');
	$this->Redirect($id, 'defaultadmin','', $params);
}
/* on fait un petit formulaire pour choisir quelle saison, on souhaite supprimer	*/
				
//var_dump($saisondropdown);				
					
	if (!empty($_POST))
	{				
		debug_display($_POST);
		if(!isset($_POST['saison']) || $_POST['saison'] == '')
		{
			
		}
		else
		{
			$saison = $_POST['saison'];
			/*
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_equipes WHERE saison = ?";
					$db->Execute($query, array($saison));
					* 
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ?";
					$db->Execute($query, array($saison));
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_parties WHERE saison = ?";
					$db->Execute($query, array($saison));
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_recup_parties";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_poules_rencontres WHERE saison = ?";
					$db->Execute($query, array($saison));
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_sit_mens WHERE saison = ?";
					$db->Execute($query, array($saison));";
													
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_recup";
					$db->Execute($query);
					
					
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_classement";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_feuilles_rencontres";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_rencontres_parties";
					$db->Execute($query);
					
			
				*/	
		}			
	}
	else
	{
		//on prépare un formulaire pour la suppression des données obsolètes
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('nettoyage.tpl'), null, null, $smarty);
		$tpl->assign('saisondropdown', $saisondropdown);
		$tpl->display();
	}
?>
