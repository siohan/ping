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
$smarty->assign('startform', $this->CreateFormStart ($id, 'updateoptions', $returnid));
$smarty->assign('endform', $this->CreateFormEnd ());
$smarty->assign('title_club_number',$this->Lang('title_club_number'));
$smarty->assign('input_club_number',$this->CreateInputText($id,'club_number',$this->GetPreference('club_number',''),50,255));
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
$smarty->assign('input_saison_en_cours',$this->CreateInputDropdown($id,'saison_en_cours',$saisondropdown,-1,$this->GetPreference('saison_en_cours'),50,255));
$smarty->assign('input_nom_equipes', 
		$this->CreateInputText($id, 'nom_equipes', $this->GetPreference('nom_equipes', ''), 50,250));
$smarty->assign('jour_sit_mens',
		$this->CreateInputText($id,'jour_sit_mens', $this->GetPreference('jour_sit_mens', ''), 5, 7));
$smarty->assign('input_populate_calendar',$this->CreateInputDropdown($id,'populate_calendar',$items,-1,$this->GetPreference('populate_calendar'),50,255));
$smarty->assign('input_affiche_club_uniquement',$this->CreateInputDropdown($id,'affiche_club_uniquement',$items,-1,$this->GetPreference('affiche_club_uniquement'),50,255));
$valeurs_interval = array("1 jour"=>"1","2 jours"=>"2");
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