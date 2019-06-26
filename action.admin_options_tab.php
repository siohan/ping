<?php
if( !isset($gCms) ) exit;
//on vérifie les droits de cet utilisateur
if(!$this->CheckPermission('Ping Use') && !$this->CheckPermission('Ping Set Prefs')){
	$message = "Vous n\'avez pas les autorisations pour accéder aux préférences";
	$this->SetMessage("$message");
	$this->RedirectToAdminTab('joueurs');
}
  // CreateFormStart sets up a proper form tag that will cause the submit to
  // return control to this module for processing.
//debug_display($params, 'Parameters');
require_once(dirname(__file__).'/include/prefs.php');
$mois_courant = date('m');
$annee_courante = date('Y');
//$version = $this->GetVersion('Ping');

//$smarty->assign('version', $version2);
$smarty->assign('recup_orga', $this->CreateLink($id, 'retrieve',$returnid,$contents='Récupérer les organismes',array("retrieve"=>"organismes")));

//$saisondropdown['.$saison_actuelle.'] = $saison_actuelle;
$smarty->assign('startform', $this->CreateFormStart ($id, 'updateoptions', $returnid));


$smarty->assign('endform', $this->CreateFormEnd ());
// Construire la liste dynamiquement avec une requete

$saison_encours = ($this->GetPreference('saison_reference')) ?  '2013-2014' : $this->GetPreference('saison_reference');
$smarty->assign('input_phase',$this->CreateInputText($id,'phase_en_cours',$this->GetPreference('phase_en_cours','1'),50,255));
//$smarty->assign('title_email_subject',$this->Lang('email_subject'));
$items = array();
$items['Oui'] = 'Oui';
$items['Non'] = 'Non';
$choix['Sans'] = '0';
$choix['Avec'] = '1';

$smarty->assign('input_saison_en_cours',$this->CreateInputDropdown($id,'saison_en_cours',$saisondropdown,-1,$this->GetPreference('saison_en_cours'),50,255));

//$smarty->assign('spid', $this->CreateInputDropdown($id,'spid',$choix,-1,$selectedvalue=$this->GetPreference('spid_calcul')));
$smarty->assign('input_populate_calendar',$this->CreateInputDropdown($id,'populate_calendar',$items,-1,$selectedvalue=$this->GetPreference('populate_calendar'),50,255));
$smarty->assign('input_affiche_club_uniquement',$this->CreateInputDropdown($id,'affiche_club_uniquement',$items,-1,$this->GetPreference('affiche_club_uniquement'),50,255));
$smarty->assign('submit', $this->CreateInputSubmit ($id, 'optionssubmitbutton', $this->Lang('submit')));

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
echo $this->ProcessTemplate ('adminprefs.tpl');

?>