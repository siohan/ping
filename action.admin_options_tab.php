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
if(isset($params['stall']) && $params['stall'] =="1" )
{
	$stall = $params['stall'];	
}
else
{
	$stall = '0';
}
$smarty->assign('stall', $this->CreateInputHidden($id,'stall',$value=$stall));
$smarty->assign('endform', $this->CreateFormEnd ());
// Construire la liste dynamiquement avec une requete
$tableau = array('Z','L','D');//on oublie la Fédé qui est tjs à 100001
foreach($tableau as $valeur)
{
	$query = "SELECT idorga, libelle FROM ".cms_db_prefix()."module_ping_organismes WHERE scope = ?";
	$dbresult = $db->Execute($query,array($valeur));
	while ($dbresult && $row = $dbresult->FetchRow())
	  {
		if($valeur =='L')
		{
			$listorga_L[$row['libelle']] = $row['idorga'];
		}
		elseif($valeur =='Z')
		{
			$listorga_Z[$row['libelle']] = $row['idorga']; 
		}
		else
		{
			$listorga_D[$row['libelle']] = $row['idorga']; 
		}
	    	
	  }
	
}

$smarty->assign('input_zone',$this->CreateInputDropdown($id, 'zone', $listorga_Z,-1,$this->GetPreference('zone'),50,255));
$saison_encours = ($this->GetPreference('saison_reference')) ?  '2013-2014' : $this->GetPreference('saison_reference');
$smarty->assign('input_phase',$this->CreateInputText($id,'phase_en_cours',$this->GetPreference('phase_en_cours','1'),50,255));
//$smarty->assign('title_email_subject',$this->Lang('email_subject'));
$items = array();
$items['Oui'] = 'Oui';
$items['Non'] = 'Non';
$choix['Sans'] = 'Sans';
$choix['Avec'] = 'Avec';

$smarty->assign('input_saison_en_cours',$this->CreateInputDropdown($id,'saison_en_cours',$saisondropdown,-1,$this->GetPreference('saison_en_cours'),50,255));

$smarty->assign('spid', $this->CreateInputDropdown($id,'spid',$choix,-1,$this->GetPreference('spid_calcul')));
$smarty->assign('input_populate_calendar',$this->CreateInputDropdown($id,'populate_calendar',$items,-1,$this->GetPreference('populate_calendar'),50,255));
$smarty->assign('input_affiche_club_uniquement',$this->CreateInputDropdown($id,'affiche_club_uniquement',$items,-1,$this->GetPreference('affiche_club_uniquement'),50,255));


$smarty->assign('submit', $this->CreateInputSubmit ($id, 'optionssubmitbutton', $this->Lang('submit')));

// Display the populated template
echo $this->ProcessTemplate ('adminprefs.tpl');

?>