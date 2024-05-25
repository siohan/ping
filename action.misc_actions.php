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
$saison = $this->GetPreference('saison_en_cours');
$p_ops = new ping_admin_ops;
$ren_ops = new rencontres;
$retrieve = new retrieve_ops;
$sp_ops = new spid_ops;
$eq_ops = new EpreuvesIndivs;
//debug_display($params, 'Parameters');

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
	
	case "active_epreuve" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		$del = $eq_ops->active_epreuve($record_id);
		$this->RedirectToAdminTab('compets');
	break;
	
	case "desactive_epreuve" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		$del = $eq_ops->desactive_epreuve($record_id);
		$eq_ops->raz_divisions($record_id);
		$eq_ops->raz_tours($record_id);
		$eq_ops->raz_classements($record_id);
		$this->Redirect($id, 'defaultadmin', $returnid, array("__activetab"=>"compets", "indivs_suivies"=>"1"));
	break;
	
	case "delete_epreuve" :
	if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		$del = $eq_ops->delete_epreuve($record_id);
		$this->RedirectToAdminTab('compets');
	break;
	
	case "suivi_ok" :
	if(isset($params['record_id']) && $params['record_id'] != '')//id de l'épreuve
		{
			$record_id = $params['record_id'];
		}
		$eq_ops->active_epreuve($record_id);
		$suiv = $eq_ops->suivi_ok($record_id);
		
		$this->Redirect($id, 'view_indivs_details', $returnid, array('record_id'=>$record_id));
	break;
	
	case "suivi_ok2" :
	if(isset($params['record_id']) && $params['record_id'] != '')//id de l'épreuve
		{
			$record_id = $params['record_id'];
		}
		$eq_ops->active_epreuve($record_id);
		$suiv = $eq_ops->suivi_ok($record_id);
		
		$this->Redirect($id, 'defaultadmin', $returnid, array("__activetab"=>"compets", "indivs_suivies"=>"1"));
	break;
	
	case "suivi_ko" :
	if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		$suiv = $eq_ops->suivi_ko($record_id);
		$this->Redirect($id, 'view_indivs_details', $returnid, array('record_id'=>$record_id));
	break;
	//enlève le suivi depuis la page de toutes les compets admin_compets_indivs_tab
	case "suivi_ko2" :
	if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		$suiv = $eq_ops->suivi_ko($record_id);
		$this->Redirect($id, 'defaultadmin', $returnid, array("__activetab"=>"compets", "indivs_suivies"=>"1"));
	break;
	
	case "raz_epreuve" :
		//on efface toutes les données du'une compet individuelle
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = (int)$params['record_id'];			
		}
		$eq_ops->raz_divisions($record_id);
		$eq_ops->raz_tours($record_id);
		$eq_ops->raz_classements($record_id);
		$this->Redirect($id, 'view_indivs_details', $returnid, array('record_id'=>$record_id));
	break;
	
	case "raz_divisions" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = (int)$params['record_id'];			
		}
		$eq_ops->raz_divisions($record_id);
		$this->Redirect($id, 'view_indivs_details', $returnid, array('record_id'=>$record_id));
	break;
	
	case "raz_tours" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = (int)$params['record_id'];			
		}
		$eq_ops->raz_tours($record_id);
		$this->Redirect($id, 'view_indivs_details', $returnid, array('record_id'=>$record_id));
	break;
	
	case "raz_classements" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = (int)$params['record_id'];			
		}
		$eq_ops->raz_classements($record_id);
		$this->Redirect($id, 'view_indivs_details', $returnid, array('record_id'=>$record_id));
	break;
	
	//va récupérer les divisions de toutes les épreuves individuelles actives
	case "all_divisions" :
	{
		$db = cmsms()->GetDb();
		$query = "SELECT idepreuve, idorga, typepreuve FROM ".cms_db_prefix()."module_ping_type_competitions WHERE actif = 1";
		$dbresult = $db->Execute($query);
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{ 
				while ($row = $dbresult->FetchRow())
				{
					$retrieve->retrieve_divisions($row['idorga'], $row['idepreuve'],$row['typepreuve']);
				}
			}
		}
		$this->Redirect($id, 'defaultadmin', $returnid, array('__activetab'=>"compets", "indivs_suivies"=>"1"));
	}
	//récupère tous les tours depuis toutes les divisions
	case "all_tours" :
	{
		$db = cmsms()->GetDb();
		$query = "SELECT idepreuve, iddivision FROM ".cms_db_prefix()."module_ping_divisions";
		$dbresult = $db->Execute($query);
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{ 
				while ($row = $dbresult->FetchRow())
				{
					$retrieve->retrieve_div_tours($row['idepreuve'],$row['iddivision']);
				}
			}
		}
		$this->Redirect($id, 'defaultadmin', $returnid, array('__activetab'=>"compets", "indivs_suivies"=>"1"));
	}
	
	case "all_classements" :
	{
		$db = cmsms()->GetDb();
		$now = time();
		$query = "SELECT idepreuve, iddivision, tableau, tour  FROM ".cms_db_prefix()."module_ping_div_tours WHERE date_prevue < ? AND uploaded IS NULL";
		$dbresult = $db->Execute($query, array($now));
		while ($row = $dbresult->FetchRow())
		{
			$retrieve->retrieve_div_classement($row['idepreuve'],$row['iddivision'], $row['tableau'], $row['tour']);
		}
			
		//$this->Redirect($id, 'defaultadmin', $returnid, array('__activetab'=>"compets", "indivs_suivies"=>"1"));
	}
	
	case "set_uploaded" :
	{
		$db = cmsms()->GetDb();
		$query = "SELECT DISTINCT tableau FROM ".cms_db_prefix()."module_ping_div_classement";
		$dbresult = $db->Execute($query);
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					$eq_ops->set_uploaded($row['tableau']);
				}
			}
		}
		
	}
	break;
	
	//marque tous les tableaux d'une épreuve comme uploadé
	case "set_all_uploaded" :
	{
		$db = cmsms()->GetDb();
		$query = "SELECT DISTINCT tableau FROM ".cms_db_prefix()."module_ping_div_classement";
		$dbresult = $db->Execute($query);
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					$eq_ops->set_uploaded($row['tableau']);
				}
			}
		}
		
	}
	break;
	
	//on désactive toutes les compets passées n'ayant pas de joueurs du club dans les résultats
	case "deactive_epreuve" : 
	{
		$db = cmsms()->GetDb();
		$variable = $eq_ops->has_players();
		$ids = join("','",$variable); 
		//var_dump($variable);
		$now = time();
		$query = "SELECT idepreuve FROM ".cms_db_prefix()."module_ping_div_tours WHERE date_prevue < ? AND idepreuve NOT IN ('$ids')";
		$dbresult = $db->Execute($query, array($now));
		if($dbresult)
		{
			if($dbresult->RecordCount() >0)
			{
				while($row = $dbresult->FetchRow())
				{
					//ceci va supprimer toutes les divisions, tours et classements et désactiver l'épreuve
					$del_epr = $eq_ops->desactive_epreuve($row['idepreuve']);
				}
			}
		}
	}
	break;

}
