<?php
if(!isset($gCms) ) exit;
debug_display($params, 'Parameters');
$db = cmsms()->GetDb();
$retourid = 'essai';
$cg_ops = new CGExtensions;
$ops = new adherents_spid;
$page = $cg_ops->resolve_alias_or_id($retourid);
$step = 0;
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
	case "0" :
	
	if(!empty($_POST))
	{
	
		$aujourdhui = date('Y-m-d ');
		$error = 0;
		$message = '';
		debug_display($_POST, 'Post params');	
		
		if (isset($_POST['club_number']) && $_POST['club_number'] !='')
		{
			$club_number = $_POST['club_number'];
		}
		else
		{
			$error++;
		}
		if (isset($_POST['zone']) && $_POST['zone'] !='')
		{
			$zone = $_POST['zone'];
		}
		else
		{
			$error++;
		}
		
				
		//on calcule le nb d'erreur
		if($error>0)
		{
			echo 'plusieurs erreurs !';
		}
		else // pas d'erreurs on continue
		{
			
			$ops = new adherents_spid;
			$verifyClub = $ops->VerifyClub($club_number);
			var_dump($verifyClub);

			if(true == $verifyClub)
			{	
				$this->SetPreference('club_number', $club_number);
				$this->SetPreference('zone', $zone);
				$this->SetPreference('connexion', true);
				$this->Audit('','Ping', "Test .$club_number.");
				$this->RedirectForFrontEnd($id, $returnid, 'start_demo', array("step"=>"1"),  $inline='true');	
			}
			else
			{
				$this->SetMessage('Le numéro de club est incorrect');
				$this->RedirectForFrontEnd($id, $returnid, 'essai',  $inline='true');
			}		
		}		
	}
	else
	{
		$orga_ops = new fftt_organismes;
		$liste_zones = $orga_ops->liste_zones();
		$smarty->assign('club_number', $this->GetPreference('club_number'));
		$smarty->assign('liste_zones', $liste_zones);
		$smarty->assign('zone', $this->GetPreference('zone'));
		echo $this->ProcessTemplate('start_demo.tpl');	
	}
	break;


	case "1" : //Ceci teste la connexion puis si succès envoie vers l'onglet configuration sinon retour onglet Compte
	
		
		$initialisation = $service->initialisationAPI();
		//var_dump($initialisation);

		if($initialisation === FALSE)
		{
			$smarty->assign('message', 'La connexion a échouée avec la passerelle de la FFTT');
			$smarty->assign('class_message', 'alert alert-danger');
			$smarty->assign('step', '0');
			//$smarty->assign('lien', $this->CreateLink($id,'defaultadmin',$returnid, $contents='Revenir', array("active_tab"=>"compte")));
		}
		elseif($initialisation == '1')
		{
			$smarty->assign('message', 'Connexion Ok avec la FFTT');
			$smarty->assign('class_message', 'green');
			$smarty->assign('step', '1');	//on récupère les organismes pour préparer le formulaire avec la zone
					
			//$this->SetMessage('La FFTT a acceptée votre identification');
			$this->SetPreference('connexion', true);
			//$this->RedirectForFrontEnd($id, $returnid,'start_demo', array("step"=>"2"),  $inline='true');
		}
		else
		{
			$smarty->assign('message', 'La connexion a échouée avec la passerelle de la FFTT');
			$smarty->assign('class_message', 'alert alert-danger');
			$smarty->assign('step', '0');
		}
	break;

	case "2" : 
		//on va récupérer les épreuves des différentes ligues, zones et comités
		//on a le numéro du club avec lequel on peut faire bcp de choses...
		//récupération des données utiles
		$query="TRUNCATE ".cms_db_prefix()."module_ping_equipes";
		$dbresult = $db->Execute($query);

		$query="TRUNCATE ".cms_db_prefix()."module_ping_joueurs";
		$dbresult = $db->Execute($query);

		$query="TRUNCATE ".cms_db_prefix()."module_ping_parties";
		$dbresult = $db->Execute($query);

		$query="TRUNCATE ".cms_db_prefix()."module_ping_parties_spid";
		$dbresult = $db->Execute($query);

		$query="TRUNCATE ".cms_db_prefix()."module_ping_recup_parties";
		$dbresult = $db->Execute($query);

		$query="TRUNCATE ".cms_db_prefix()."module_ping_poules_rencontres";
		$dbresult = $db->Execute($query);

		$query="TRUNCATE ".cms_db_prefix()."module_ping_sit_mens";
		$dbresult = $db->Execute($query);

		$query="TRUNCATE ".cms_db_prefix()."module_ping_adversaires";
		$dbresult = $db->Execute($query);

		$query="TRUNCATE ".cms_db_prefix()."module_ping_classement";
		$dbresult = $db->Execute($query);

		$query="TRUNCATE ".cms_db_prefix()."module_ping_feuilles_rencontres";
		$dbresult = $db->Execute($query);

		$query="TRUNCATE ".cms_db_prefix()."module_ping_rencontres_parties";
		$dbresult = $db->Execute($query);

		$query="TRUNCATE ".cms_db_prefix()."module_ping_joueurs";
		$dbresult = $db->Execute($query);

		$query = "DELETE FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idorga != '100001'";
		$dbresult = $db->Execute($query);
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
		
		$comp_dep_eq = $ret_ops->retrieve_compets($departement,$type="E");
		var_dump($comp_dep_eq);
		if($comp_dep_eq >0)
		{
				$this->SetPreference('comp_dep_eq', true);			
		}
		$this->RedirectForFrontEnd($id,$returnid,  'start_demo', array("step"=>"3"));
		

	// LES EPREUVES	
	case "3" :
		
		$comp_dep_indivs = $ret_ops->retrieve_compets($this->GetPreference('dep'),$type="I");
		if($comp_dep_indivs >0)
		{
			$this->SetPreference('comp_dep_indivs', true);		
		}
		$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"4"));
		
	break;
	
	case "4" :
		$comp_ligue_eq = $ret_ops->retrieve_compets($this->GetPreference('ligue'),$type="E");		
		$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"5"));
	break;
	
	case "5" :
		$comp_ligue_indivs = $ret_ops->retrieve_compets($this->GetPreference('ligue'),$type="I");
		$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"6"));
	break;
	
	case "6" :
		$comp_zone_eq = $ret_ops->retrieve_compets($this->GetPreference('zone'),$type="E");
		$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"7"));
	break;
	
	case "7" : 
		$comp_zone_indivs = $ret_ops->retrieve_compets($this->GetPreference('zone'),$type="I");
		$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"8"));
	break;
	
	// LES 	EQUIPES
	case "8" : 
		$eq_masc = $ret_ops->retrieve_teams($type="M");
		$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"9"));
	break;
	
	case "9" :
	$eq_fem = $ret_ops->retrieve_teams($type="F");
		$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"10"));
	break;
	
	case "10" :
	$eq_undefined = $ret_ops->retrieve_teams($type="U");
		$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"all_classements"));
	break;
	
	//LES CLASSEMENTS DES EQUIPES
	case "all_classements" :
		$query = "SELECT id FROM ".cms_db_prefix()."module_ping_equipes";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount() >0)
		{
			while($row = $dbresult->FetchRow())
			{
				$ret_ops->retrieve_all_classements($row['id']);
			}
		}
		$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"rencontres"));
	break;
	
	// LES RENCONTRES
	case "rencontres" :
	
		$query = "SELECT id, iddiv, idpoule, idepreuve FROM ".cms_db_prefix()."module_ping_equipes";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount() >0)
		{
			while($row = $dbresult->FetchRow())
			{
				$ret_ops->retrieve_poule_rencontres($row['id'], $row['iddiv'], $row['idpoule'], $row['idepreuve']);
			}
		}
		$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"players"));
	
	break;
	
	
	//LES JOUEURS
	case "players" :
		$users = $ret_ops->retrieve_users();
		$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"sit_mens"));
	break;
	
	case "sit_mens" ;
		$service = new retrieve_ops;
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
		$this->Redirect($id, 'getInitialisation', $returnid, array("step"=>"countdown"));
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
//echo $lien;
$connect = $this->GetPreference('connexion');
$connexion = (isset($connect) ? $connect : false);
$smarty->assign('connexion',$connexion);

$comp_dep_eq = $this->GetPreference('comp_dep_eq');
//var_dump($comp_dep_eq);
$dep_eq = (isset($comp_dep_eq) ? $comp_dep_eq : false);
$smarty->assign('dep_eq',$dep_eq);


echo $this->ProcessTemplate('demo.tpl');


#
#EOF
#
?>