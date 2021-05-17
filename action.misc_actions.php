<?php
set_time_limit(300);
if(!isset($gCms)) exit;
//on vérifie les permissions
if(!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db =& $this->GetDb();
global $themeObject;
$aujourdhui = date('Y-m-d');

$p_ops = new ping_admin_ops;
$ren_ops = new rencontres;
debug_display($params, 'Parameters');

if(isset($params['obj']) && $params['obj'] != '')
{
	$obj = $params['obj'];
}
else
{
	//redir
}
switch($obj)
{
	//Active ou désactive une présence
	case "is_home_club" :
		$db = cmsms()->GetDb();
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		$club_ops->isnot_home_club();
		$club_ops->is_home_club($record_id);
		
		$this->RedirectToAdminTab('clubs');
	break;
	//supprime la réponse d'un adhérent
	case "delete_pool" :
		
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
			$del_rep = $pools_ops->delete_pool($record_id);
		
		$this->RedirectToAdminTab('pools');
	break;
	
	//supprime la réponse d'un adhérent
	case "delete_patterns" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		
			$delete = $pat_ops->delete_patterns($record_id);
			if(true === $delete)
			{
				$del_rep = $pat_ops->delete_patterns_pattern($record_id);
			}
			
		
		$this->Redirect($id, 'defaultadmin', $returnid);
	break;
	//ajoute ou modifie une réponse
	case "delete_match" :
	
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		
		$del = $m_ops->delete_match($record_id);
		
		$this->RedirectToAdminTab('matches');
		
	case "countdown_ok" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		
		$del = $ren_ops->countdown_ok($record_id);
		
		$this->RedirectToAdminTab('rencontres');
	break;
	
	case "countdown_ko" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		
		$del = $ren_ops->countdown_ko($record_id);
		
		$this->RedirectToAdminTab('rencontres');
	break;
	
	case "affiche_ok" : 
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		
		$affiche= $ren_ops->affiche_ok($record_id);
		
		$this->RedirectToAdminTab('rencontres');
	break;
	
	case "affiche_ko" : 
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		
		$affiche= $ren_ops->affiche_ko($record_id);
		
		$this->RedirectToAdminTab('rencontres');
	break;
	
	case "delete_details_rencontre" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		$del_feuil = $ren_ops->delete_details_rencontre($record_id);
		if(true == $del_feuil)
		{
			$del_parties = $ren_ops->delete_rencontre_parties($record_id);
			$ren_ops->not_uploaded($record_id);
		}
		$this->Redirect($id, 'admin_details_rencontre', $returnid, array('record_id'=>$record_id));
	break;
	
}