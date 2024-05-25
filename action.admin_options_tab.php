<?php
if( !isset($gCms) ) exit;
//on vérifie les droits de cet utilisateur
if(!$this->CheckPermission('Ping Use') && !$this->CheckPermission('Ping Set Prefs')){
	
	$this->SetMessage('Vous n\'avez pas les autorisations pour accéder aux préférences');
	$this->RedirectToAdminTab('joueurs');
}
$message = "";
//debug_display($params, 'Parameters');
if(!empty($_POST))
{
	//debug_display($_POST, 'Parameters');
	if( $_POST['saison_en_cours'] != $this->GetPreference('saison_en_cours'))
	{
		//changement de saison !!
		//on essaie de récupérer les organismes
		$ret_ops = new retrieve_ops;
		//on supprime aussi avant d'insérer
		$fftt = new fftt_organismes;
		$fftt->delete_organismes();
		$ret_ops->organismes();
		$message.=" Organismes récupérés !";
		
	}
	
	$this->SetPreference('phase_en_cours', $_POST['phase_en_cours']);
	$this->SetPreference('saison_en_cours', $_POST['saison_en_cours']);	
	$this->SetPreference('details_rencontre_page', $_POST['details_rencontre_page']);	
	$this->SetPreference('nettoyage_journal', $_POST['nettoyage_journal']);
	$this->SetPreference('chpt_default', $_POST['chpt_default']);
	$this->SetPreference('club_number', $_POST['club_number']);
	$this->SetPreference('fede',$_POST['fede']);
	$this->SetPreference('zone', $_POST['zone']);
	$this->SetPreference('ligue', $_POST['ligue']);
	$this->SetPreference('dep', $_POST['dep']);
	$this->SetPreference('details_indivs', $_POST['details_indivs']);
	$message.=" Ta config a été mise à jour";
	

	$this->SetMessage("$message");
	$this->RedirectToAdminTab('configuration');
}
else
{
	//require_once(dirname(__file__).'/include/prefs.php');
	$eq_ping = new EpreuvesIndivs;
	$orga = new fftt_organismes;
	$liste_epreuves = $eq_ping->liste_epreuves_equipes();
	$liste_phases = array("1"=>"1", "2"=>"2");
	$liste_zones = $orga->liste_zones();
	$liste_ligues = $orga->liste_ligues();
	$liste_deps = $orga->liste_deps();
	$liste_fede = $orga->liste_fede();
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('adminprefs.tpl'), null, null, $smarty);
	$tpl->assign('saison_en_cours', $this->GetPreference('saison_en_cours'));
	$tpl->assign('phase_en_cours', $this->GetPreference('phase_en_cours'));
	$tpl->assign('liste_phases', $liste_phases);	
	$tpl->assign('affiche_club_uniquement', $this->GetPreference('affiche_club_uniquement'));
	$tpl->assign('club_number', $this->GetPreference('club_number'));
	$tpl->assign('dep', $this->GetPreference('dep'));
	$tpl->assign('ligue', $this->GetPreference('ligue'));
	$tpl->assign('zone', $this->GetPreference('zone'));
	$tpl->assign('fede', $this->GetPreference('fede'));
	$tpl->assign('liste_fede', $liste_fede);
	$tpl->assign('liste_zones', $liste_zones);
	$tpl->assign('liste_ligues', $liste_ligues);
	$tpl->assign('liste_deps', $liste_deps);
	
	
	//pour le nettoyage des entrées du journal
	$tpl->assign('nettoyage_journal', $this->GetPreference('nettoyage_journal'));
	
	
	//pour le brûlage
	$tpl->assign('liste_epreuves', $liste_epreuves);
	$tpl->assign('chpt_default', $this->GetPreference('chpt_defaut'));
	$tpl->assign('details_rencontre_page', $this->GetPreference('details_rencontre_page'));
	$tpl->assign('details_indivs', $this->GetPreference('details_indivs'));
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
