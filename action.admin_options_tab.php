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

$mois_courant = date('m');
$annee_courante = date('Y');

if($mois_courant >= 7)
{
	$annee_debut = $annee_courante;
	$annee_fin = $annee_courante +1;
}
else
{
	$annee_debut = $annee_courante -1;
	$annee_fin = $annee_courante;
}
$saison_actuelle = $annee_debut.'-'.$annee_fin;
//$saisondropdown['.$saison_actuelle.'] = $saison_actuelle;
$smarty->assign('startform', $this->CreateFormStart ($id, 'updateoptions', $returnid));
$smarty->assign('endform', $this->CreateFormEnd ());
$smarty->assign('title_club_number',$this->Lang('title_club_number'));
$smarty->assign('input_club_number',$this->CreateInputText($id,'club_number',$this->GetPreference('club_number',''),50,255));
// Construire la liste dynamiquement avec une requete
$listeligues = array("Bretagne"=>"1007", "Champagne"=>"1008");
$smarty->assign('input_ligue',$this->CreateInputDropdown($id, 'ligue', $listeligues,-1,$this->GetPreference('ligue'),50,255));

$listezones = array("Bretagne"=>"1007", "Champagne"=>"1008");
$listedeps = array("Finistère"=>"29", "Morbihan"=>"56");
$smarty->assign('input_zone',$this->CreateInputDropdown($id, 'zone', $listezones,-1,$this->GetPreference('zone'),50,255));
$smarty->assign('input_dep',$this->CreateInputDropdown($id, 'dep', $listedeps,-1,$this->GetPreference('dep'),50,255));
$saison_encours = ($this->GetPreference('saison_reference')) ?  '2013-2014' : $this->GetPreference('saison_reference');
//$smarty->assign('title_formsubmit_emailaddress',$this->Lang('formsubmit_emailaddress'));
$smarty->assign('input_phase',$this->CreateInputText($id,'phase_en_cours',$this->GetPreference('phase_en_cours','1'),50,255));
//$smarty->assign('title_email_subject',$this->Lang('email_subject'));
$items = array();
$items['Oui'] = 'Oui';
$items['Non'] = 'Non';
$saisondropdown = array();

$saisondropdown['2013-2014'] = '2013-2014';
$saisondropdown['2014-2015'] = '2014-2015';
$saisondropdown['2015-2016'] = '2015-2016';

$smarty->assign('input_saison_en_cours',$this->CreateInputDropdown($id,'saison_en_cours',$saisondropdown,-1,$this->GetPreference('saison_en_cours'),50,255));
$smarty->assign('input_nom_equipes', 
		$this->CreateInputText($id, 'nom_equipes', $this->GetPreference('nom_equipes', ''), 50,250));
$smarty->assign('jour_sit_mens',
		$this->CreateInputText($id,'jour_sit_mens', $this->GetPreference('jour_sit_mens', ''), 5, 7));
$smarty->assign('input_populate_calendar',$this->CreateInputDropdown($id,'populate_calendar',$items,-1,$this->GetPreference('populate_calendar'),50,255));
$smarty->assign('input_affiche_club_uniquement',$this->CreateInputDropdown($id,'affiche_club_uniquement',$items,-1,$this->GetPreference('affiche_club_uniquement'),50,255));
$valeurs_interval = array("1 jour"=>"1","2 jours"=>"2","3 jours"=>"3","Jamais"=>"365");
$valeurs_nombres_spid = array("25 joueurs"=>"25", "50 joueurs"=>"50", "75 joueurs"=>"75","100 joueurs"=>"100");
$valeurs_nombres_fftt = array("25 joueurs"=>"25", "50 joueurs"=>"50", "75 joueurs"=>"75","100 joueurs"=>"100");
$smarty->assign('input_spid_interval',
		$this->CreateInputDropdown($id, 'spid_interval',$valeurs_interval,-1,$this->GetPreference('spid_interval')));
$smarty->assign('input_spid_nombres',
		$this->CreateInputDropdown($id,'spid_nombres',$valeurs_nombres_spid,-1,$this->GetPreference('spid_nombres')));
$smarty->assign('input_fftt_interval',
		$this->CreateInputDropdown($id, 'fftt_interval',$valeurs_interval,-1,$this->GetPreference('fftt_interval')));
$smarty->assign('input_fftt_nombres',
		$this->CreateInputDropdown($id,'fftt_nombres',$valeurs_nombres_fftt,-1,$this->GetPreference('fftt_nombres')));
/*
$smarty->assign('sitmens_ok_only',
		$this->CreateInputDropdown($id,'sitmens_ok_only', $items,-1,$this->GetPreference('sitmens_ok_only'),50,255));
*/
$smarty->assign('submit', $this->CreateInputSubmit ($id, 'optionssubmitbutton', $this->Lang('submit')));

// Display the populated template
echo $this->ProcessTemplate ('adminprefs.tpl');

?>