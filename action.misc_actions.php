<?php
set_time_limit(300);
if(!isset($gCms)) exit;
//on vérifie les permissions
if(!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db = cmsms()->GetDb();
global $themeObject;
$aujourdhui = date('Y-m-d');

$p_ops = new ping_admin_ops;
$ren_ops = new rencontres;
$retrieve = new retrieve_ops;
$sp_ops = new spid_ops;
$eq_ops = new EpreuvesIndivs;
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
	
	case "refresh_spid" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$licence = $params['record_id'];
		}
		$retrieve->retrieve_parties_spid2( $licence );
		$maj = $sp_ops->compte_spid_points($licence);
		$pts = $sp_ops->maj_points_spid($licence, $maj);
	
		$this->Redirect($id, 'view_adherent_details', $returnid, array('record_id'=>$licence));
	break;
	
	case "refresh_sit_mens" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		$retrieve->retrieve_sit_mens( $record_id );
		$this->Redirect($id, 'view_adherent_details', $returnid, array('record_id'=>$record_id));
	break;
	
	case "refresh_fftt" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$licence = $params['record_id'];
		}
		$retrieve->retrieve_parties_fftt( $licence );
		$pts_fftt = $sp_ops->pts_fftt($licence);
		$maj = $sp_ops->maj_pts_fftt($licence,$pts_fftt);
		$this->Redirect($id, 'view_adherent_details', $returnid, array('record_id'=>$licence));
	break;
	
	case "desactive_epreuve" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		$del = $eq_ops->desactive_epreuve($record_id);
		$this->RedirectToAdminTab('compets');
}
