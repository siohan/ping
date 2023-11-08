<?php
if( !isset($gCms) ) exit;
//on vérifie les droits de cet utilisateur
if(!$this->CheckPermission('Ping Use') && !$this->CheckPermission('Ping Set Prefs')){
	$message = "Vous n\'avez pas les autorisations pour accéder aux préférences";
	$this->SetMessage("$message");
	$this->RedirectToAdminTab('joueurs');
}

$ping_ops = new ping_admin_ops;
//debug_display($params, 'Parameters');
if(!empty($_POST))
{
	debug_display($_POST, 'Parameters');
	$interval_classement = $ping_ops->intervals('interval_classement', $_POST['unite_classement'], $_POST['nb_classement']);
	$interval_equipes = $ping_ops->intervals('interval_equipes', $_POST['unite_equipes'], $_POST['nb_equipes']);
	$interval_joueurs = $ping_ops->intervals('interval_joueurs', $_POST['unite_joueurs'], $_POST['nb_joueurs']);
	$interval_compets = $ping_ops->intervals('interval_compets', $_POST['unite_compets'], $_POST['nb_compets']);
	$interval_feuilles_parties = $ping_ops->intervals('interval_feuilles_parties', $_POST['unite_feuilles_parties'], $_POST['nb_feuilles_parties']);
	$interval_spid = $ping_ops->intervals('interval_spid', $_POST['unite_spid'], $_POST['nb_spid']);
	
	var_dump($interval_feuilles_parties);
	$this->SetPreference('interval_classement', $interval_classement);
	$this->SetPreference('interval_joueurs', $interval_joueurs);
	$this->SetPreference('interval_equipes', $interval_equipes);
	$this->SetPreference('interval_feuilles_parties', $interval_feuilles_parties);
	$this->SetPreference('interval_compets', $interval_compets);
	$this->SetPreference('interval_spid', $interval_spid);	
	$this->SetPreference('epreuv_tab', $_POST['epreuv_tab']);
	$this->SetPreference('compte_tab', $_POST['compte_tab']);
	$this->SetPreference('contacts_tab', $_POST['contacts_tab']);
	
	
	
	
	//pour le réglage des images
	
	
	if( isset($_POST['max_size']) && $_POST['max_size'] >0)
	{
		$this->SetPreference('max_size', (int) $_POST['max_size']);		
	}
		
	if( isset($_POST['max_width']) && $_POST['max_width'] >0)
	{
		$this->SetPreference('max_width', (int) $_POST['max_width']);		
	}
		
	if( isset($_POST['max_height']) && $_POST['max_height'] >0)
	{
		$this->SetPreference('max_height', (int) $_POST['max_height']);		
	}
	
	if( isset($_POST['allowed_extensions']) && $_POST['allowed_extensions'] !='')
	{
		$this->SetPreference('allowed_extensions', str_replace(' ', '', $_POST['allowed_extensions']));		
	}

	$this->SetMessage('Votre config a été mise à jour');
	//$this->Audit('', 'Ping',$club_number);
	//$this->RedirectToAdminTab('joueurs');

$this->Redirect($id, 'advanced_params', $returnid);
}
else
{
	require_once(dirname(__file__).'/include/prefs.php');
	$eq_ping = new EpreuvesIndivs;
	$orga = new fftt_organismes;
	$liste_epreuves = $eq_ping->liste_epreuves();
	$liste_phases = array("1"=>"1", "2"=>"2");
	
	$liste_unite = array('Minutes'=>'Minutes','Heures'=>'Heures', 'Jours'=>'Jours', 'Semaines'=>'Semaines', 'Mois'=>'Mois');
	$occurence = array('2629800', '604800', '86400', '3600', '60');
	
	$unite = '';
	
	
	$interval_classement = $ping_ops->intervalles($this->GetPreference('interval_classement'));
	$interval_joueurs = $ping_ops->intervalles($this->GetPreference('interval_joueurs'));
	$interval_equipes = $ping_ops->intervalles($this->GetPreference('interval_equipes'));
	$interval_compets = $ping_ops->intervalles($this->GetPreference('interval_compets'));
	$interval_feuilles_parties = $ping_ops->intervalles($this->GetPreference('interval_feuilles_parties'));
	$interval_spid = $ping_ops->intervalles($this->GetPreference('interval_spid'));
	//var_dump($interval_classement);
	//on crée une fonction pour gérer les différents intervalles de temps
	
	/*
	 * 
	$liste_zones = $orga->liste_zones();
	$liste_ligues = $orga->liste_ligues();
	$liste_deps = $orga->liste_deps();
	* */
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('advanced_params.tpl'), null, null, $smarty);
		
	$tpl->assign('epreuv_tab', $this->GetPreference('epreuv_tab'));
	$tpl->assign('compte_tab', $this->GetPreference('compte_tab'));
	$tpl->assign('contacts_tab', $this->GetPreference('contacts_tab'));
	$tpl->assign('interval_classement', $interval_classement);
	$tpl->assign('interval_joueurs', $interval_joueurs);
	$tpl->assign('interval_equipes', $interval_equipes);
	$tpl->assign('interval_spid', $interval_spid);
	$tpl->assign('liste_unite', $liste_unite);
	$tpl->assign('interval_compets', $interval_compets);
	$tpl->assign('interval_feuilles_parties', $interval_feuilles_parties);
	
	$tpl->assign('dep', $this->GetPreference('dep'));
	$tpl->assign('ligue', $this->GetPreference('ligue'));
	$tpl->assign('zone', $this->GetPreference('zone'));
	$tpl->assign('fede', $this->GetPreference('fede'));
	/*
	 * $tpl->assign('liste_zones', $liste_zones);
	$tpl->assign('liste_ligues', $liste_ligues);
	$tpl->assign('liste_deps', $liste_deps);
	* */
	
	
	//pour les photos
	$tpl->assign('max_size', $this->GetPreference('max_size'));
	$tpl->assign('max_width', $this->GetPreference('max_width'));
	$tpl->assign('max_height', $this->GetPreference('max_height'));
	$tpl->assign('allowed_extensions', $this->GetPreference('allowed_extensions'));
	//pour le brûlage
	
	
	$tpl->assign('details_rencontre_page', $this->GetPreference('details_rencontre_page'));
	$tpl->display();
}

//on teste si le module Adhérents est présent et activé!
$smarty->assign('display_mods', false);
$mod_messages = \cms_utils::get_module('CGBlog');
if (is_object($mod_messages) )
{
	$smarty->assign('display_mods', true);
	$smarty->assign('startformexport', $this->CreateFormStart ($id, 'admin_export_adherents', $returnid, array("obj"=>"export_members")));
	$smarty->assign('exportsubmit', $this->CreateInputSubmit ($id, 'exportsubmitbutton', 'Exporter les joueurs vers le module Adhérents'));
	$smarty->assign('endformexport', $this->CreateFormEnd ());
	
	//un autre formulaire d'export pour les convocations
	$smarty->assign('startformexport2', $this->CreateFormStart ($id, 'admin_export_compos', $returnid, array("obj"=>"export_epreuves")));
	$smarty->assign('exportsubmit2', $this->CreateInputSubmit ($id, 'exportsubmitbutton2', 'Exporter les épreuves'));
	$smarty->assign('endformexport2', $this->CreateFormEnd ());
	
	//formulaire d'exportation des équipes vers le module compositions
	//un autre formulaire d'export pour les convocations
	$smarty->assign('startformexport3', $this->CreateFormStart ($id, 'admin_export_compos', $returnid, array("obj"=>"export_epreuves")));
	$smarty->assign('exportsubmit3', $this->CreateInputSubmit ($id, 'exportsubmitbutton2', 'Exporter les équipes'));
	$smarty->assign('endformexport3', $this->CreateFormEnd ());
	// Display the populated template
	//echo $this->ProcessTemplate ('adminprefs.tpl');
}
?>
