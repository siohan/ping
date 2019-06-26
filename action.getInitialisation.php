<?php
if(!isset($gCms)) exit;
if(!$this->CheckPermission('Ping Set Prefs'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}
//debug_display($params, 'Parameters');

$stall= 1; //on est dans l'installation
//les différents statuts possibles : 
	//Undefined Par défaut
	//Ko l'install a échouée.
	//Ok l'install a réussie.
	
//les différentes étapes de l'install
	//step=1 Installation du compte et test de la connexion FFTT
	//step=2 On récupère le numéro du club, on déduit la ligue, la zone et le comité ? Oui !
	
	
	
if(isset($params['step']) && $params['step'] != '')
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
					$ret_ops->organismes();
					$this->SetMessage('La FFTT a acceptée votre identification');
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
		
		$comp_dep_eq = $ret_ops->retrieve_compets($departement,$type="E");
		$comp_dep_indivs = $ret_ops->retrieve_compets($departement,$type="I");
		$comp_ligue_eq = $ret_ops->retrieve_compets($ligue,$type="E");
		$comp_dep = $ret_ops->retrieve_compets($ligue,$type="I");
		$comp_fftt_eq = $ret_ops->retrieve_compets($idorga='100001',$type="E");
		$comp_fftt_indivs = $ret_ops->retrieve_compets($idorga='100001',$type="I");
		
		
		$this->RedirectToAdminTab('adherents');//>assign('compet_zone', $this->CreateLink($id, 'retrieve_compets', $returnid,$contents="récupérer les compétitons de zone",array("idorga"=>$zone,"stall"=>"1","step"=>"2") ));
		
		
	
	break;
	
}


echo $this->ProcessTemplate('initialisation.tpl');

#
#EOF
#
?>