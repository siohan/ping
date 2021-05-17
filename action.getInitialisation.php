<?php
if(!isset($gCms)) exit;
if(!$this->CheckPermission('Ping Set Prefs'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}
//debug_display($params, 'Parameters');
//on instancie des variables par défaut
$db = cmsms()->GetDb();	
if(isset($params['step']) && $params['step'] !='')
{
	$step = $params['step'];
}	
$smarty->assign('step', $step);
$service = new Servicen;
$ret_ops = new retrieve_ops;
//echo $step;
switch($step)
{
	case "1" : //Ceci teste la connexion puis si succès envoie vers l'onglet configuration sinon retour onglet Compte
	
		
		$initialisation = $service->initialisationAPI();
		//var_dump($initialisation);

		if($initialisation === FALSE)
		{
			$smarty->assign('reussite', FALSE);
			$smarty->assign('lien',
					$this->CreateLink($id,'defaultadmin',$returnid, $contents='Revenir', array("active_tab"=>"compte")));
		}
		elseif($initialisation == '1')
		{
					//on récupère les organismes pour préparer le formulaire avec la zone
					$smarty->assign('reussite', true);
					$ret_ops->organismes();
					$this->SetMessage('La FFTT a acceptée votre identification');
					$this->SetPreference('connexion', true);
					$this->Redirect($id, 'add_edit_club_number', $returnid);
		}
		else
		{
					$smarty->assign('reussite', FALSE);
					$smarty->assign('lien',
					$this->CreateLink($id,'defaultadmin',$returnid, $contents='Revenir', array("active_tab"=>"compte")));
		}
	break;
	
	case "2" : 
		//on va récupérer les épreuves des différentes ligues, zones et comités
		//on a le numéro du club avec lequel on peut faire bcp de choses...
		//récupération des données utiles
		$club_number = $this->GetPreference('club_number');
		$ligue = substr($club_number, 0,2);
		$departement = substr($club_number, 2, 2);
		$ping_admin_ops = new ping_admin_ops();
		$chercher_ligue = $ping_admin_ops->chercher_ligue($ligue);
		$chercher_departement = $ping_admin_ops->chercher_departement($departement);	
		$retrieve_club_detail = $ret_ops->retrieve_detail_club($club_number);
		$this->SetPreference('ligue', $chercher_ligue);
		$this->SetPreference('dep', $chercher_departement);
		//on commence par les compets 
		
	break;
// LES EPREUVES	
	case "3" :
		$comp_dep_eq = $ret_ops->retrieve_compets($this->GetPreference('dep'),$type="E");
		$comp_dep_indivs = $ret_ops->retrieve_compets($this->GetPreference('dep'),$type="I");
		$comp_ligue_eq = $ret_ops->retrieve_compets($this->GetPreference('ligue'),$type="E");
		$comp_ligue_indivs = $ret_ops->retrieve_compets($this->GetPreference('ligue'),$type="I");	
		$comp_zone_eq = $ret_ops->retrieve_compets($this->GetPreference('zone'),$type="E");
		$comp_zone_indivs = $ret_ops->retrieve_compets($this->GetPreference('zone'),$type="I");
		
		$smarty->assign('comp_dep_eq', $comp_dep_eq);
		$smarty->assign('comp_dep_indivs', $comp_dep_indivs);
		$smarty->assign('comp_ligue_eq', $comp_ligue_eq);
		$smarty->assign('comp_ligue_indivs', $comp_ligue_indivs);
		$smarty->assign('comp_zone_eq', $comp_zone_eq);
		$smarty->assign('comp_zone_indivs', $comp_zone_indivs);
		
		
	break;
	
// LES 	EQUIPES
	case "4" : 
		$eq_masc = $ret_ops->retrieve_teams($type="M");
		$eq_fem = $ret_ops->retrieve_teams($type="F");
		$eq_undefined = $ret_ops->retrieve_teams($type="U");
		
		$smarty->assign('eq_masc', $eq_masc);
		$smarty->assign('eq_fem', $eq_fem);
		$smarty->assign('eq_undefined', $eq_undefined);
		
	
//LES CLASSEMENTS DES EQUIPES
	case "5" :
		$query = "SELECT id FROM ".cms_db_prefix()."module_ping_equipes";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount() >0)
		{
			while($row = $dbresult->FetchRow())
			{
				$ret_ops->retrieve_all_classements($row['id']);
			}
		}
		$query = "SELECT id, iddiv, idpoule, idepreuve FROM ".cms_db_prefix()."module_ping_equipes";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount() >0)
		{
			while($row = $dbresult->FetchRow())
			{
				$ret_ops->retrieve_poule_rencontres($row['id'], $row['iddiv'], $row['idpoule'], $row['idepreuve']);
			}
		}
	break;

	
	
//LES JOUEURS
	case "6" :
	
		$users = $ret_ops->retrieve_users();
		$service = new spid_ops;
		$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = '1' AND type = 'T'";
		$dbretour = $db->Execute($query);
		if ($dbretour && $dbretour->RecordCount() > 0)
		{
			   while ($row= $dbretour->FetchRow())
			   {
					$licence = $row['licence'];
					$service->create_spid_account($licence);
		       }
  		}
		
	break;
	
	case "7" ;
		$service = new retrieve_ops;
		if(date('d') >=10)
		{
			$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = '1' AND type = 'T'";
			$dbretour = $db->Execute($query);
			if ($dbretour && $dbretour->RecordCount() > 0)
			{
			   while ($row= $dbretour->FetchRow())
			   {
					$licence = $row['licence'];
					$service->retrieve_sit_mens($licence, $ext='false');
		       }
  			}
  			$smarty->assign('sit_mens', true);
  		}
  		else
  		{
  			$smarty->assign('sit_mens', false);
  		}
		
	break;
	
	
	
	case "countdown" :
		$query = "SELECT renc_id FROM ".cms_db_prefix()."module_ping_poules_rencontres  WHERE date_event >= CURRENT_DATE AND eq_id = 1 AND club = 1 ORDER BY date_event ASC LIMIT 1";
		$dbretour = $db->Execute($query);
		if ($dbretour && $dbretour->RecordCount() > 0)
		{
			   $ren_ops = new rencontres;
			   while ($row= $dbretour->FetchRow())
			   {
					
					$ren_ops->countdown_ok($row['renc_id']);
		       }
  		}
		//$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"countdown"));
	break;
}
$connect = $this->GetPreference('connexion');
$connexion = (isset($connect) ? $connect : false);
$smarty->assign('connexion',$connexion);

$comp_dep_eq = $this->GetPreference('comp_dep_eq');
//var_dump($comp_dep_eq);
$dep_eq = (isset($comp_dep_eq) ? $comp_dep_eq : false);
$smarty->assign('dep_eq',$dep_eq);


echo $this->ProcessTemplate('initialisation.tpl');

#
#EOF
#
?>