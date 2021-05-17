<?php
if( !isset($gCms) ) exit;
//on vérifie les droits de cet utilisateur
if(!$this->CheckPermission('Ping Use') && !$this->CheckPermission('Ping Set Prefs')){
	$message = "Vous n\'avez pas les autorisations pour accéder aux préférences";
	$this->SetMessage("$message");
	$this->RedirectToAdminTab('joueurs');
}

//debug_display($params, 'Parameters');
if(!empty($_POST))
{
	debug_display($_POST, 'Parameters');
	$this->SetPreference('phase_en_cours', $_POST['phase_en_cours']);
	$this->SetPreference('saison_en_cours', $_POST['saison_en_cours']);
	$this->SetPreference('populate_calendar', $_POST['populate_calendar']);
	$this->SetPreference('affiche_club_uniquement', $_POST['affiche_club_uniquement']);
	$this->SetPreference('interval_classement', $_POST['interval_classement']);
	$this->SetPreference('interval_joueurs', $_POST['interval_joueurs']);
	$this->SetPreference('interval_equipes', $_POST['interval_equipes']);
	$this->SetPreference('interval_feuille_parties', $_POST['interval_feuille_parties']);
	$this->SetPreference('details_rencontre_page', $_POST['details_rencontre_page']);

	$this->SetMessage('Vos options ont été mises à jours');
	//$this->Audit('', 'Ping',$club_number);
	//$this->RedirectToAdminTab('joueurs');

$this->RedirectToAdminTab('joueurs');
}
else
{
	require_once(dirname(__file__).'/include/prefs.php');
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('adminprefs.tpl'), null, null, $smarty);
	$tpl->assign('saison_en_cours', $this->GetPreference('saison_en_cours'));
	$tpl->assign('phase_en_cours', $this->GetPreference('phase_en_cours'));
	$tpl->assign('populate_calendar', $this->GetPreference('populate_calendar'));
	$tpl->assign('affiche_club_uniquement', $this->GetPreference('affiche_club_uniquement'));
	$tpl->assign('interval_classement', $this->GetPreference('interval_classement'));
	$tpl->assign('interval_joueurs', $this->GetPreference('interval_joueurs'));
	$tpl->assign('interval_equipes', $this->GetPreference('interval_equipes'));
	$tpl->display();
}

//on teste si le module Adhérents est présent et activé!


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

?>