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
$service = new Servicen();
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

					$smarty->assign('reussite', TRUE);
					$smarty->assign('lien',
							$this->CreateLink($id,'defaultadmin',$returnid, $contents='Continuez', array("active_tab"=>"configuration", "stall"=>$stall, "step"=>"2")));
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
		//on prend donc les préférences obtenues précédemment
		$zone = $this->GetPreference('zone');
		$ligue = $this->GetPreference('ligue');
		$dep = $this->GetPreference('dep');
		$smarty->assign('compet_zone', $this->CreateLink($id, 'retrieve_compets', $returnid,$contents="récupérer les compétitons de zone",array("idorga"=>$zone,"stall"=>"1") ));
		
		
	
	break;
};





	



echo $this->ProcessTemplate('initialisation.tpl');
#
#EOF
#
?>