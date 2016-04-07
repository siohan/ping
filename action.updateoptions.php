<?php
if (!isset($gCms)) exit;

if( !$this->CheckPermission( 'Ping Set Prefs' ) )
{
  return;
}
//debug_display($params, 'Parameters');
if(isset($params['stall']) && $params['stall'] =="1")
{
	$stall = $params['stall'];
}
//$nom_equipes = strtoupper($params['nom_equipes']);
$this->SetPreference('club_number', $params['club_number']);
$this->SetPreference('ligue', $params['ligue']);
$this->SetPreference('zone', $params['zone']);
$this->SetPreference('dep', $params['dep']);
//pour la version 0.1 beta2 on proposera de déduire la ligue et le département auxquels le club appartient
//et on les mettra dans les préférences à créer également

$this->SetPreference('jour_sit_mens', $params['jour_sit_mens']);
$this->SetPreference('phase_en_cours', $params['phase_en_cours']);
$this->SetPreference('saison_en_cours', $params['saison_en_cours']);
$this->SetPreference('nom_equipes', strtoupper($params['nom_equipes']));
$this->SetPreference('populate_calendar', $params['populate_calendar']);
$this->SetPreference('affiche_club_uniquement', $params['affiche_club_uniquement']);
$this->SetPreference('spid_nombres', $params['spid_nombres']);
$this->SetPreference('fftt_nombres', $params['fftt_nombres']);
$this->SetPreference('spid_interval', $params['spid_interval']);
$this->SetPreference('fftt_interval', $params['fftt_interval']);
$this->SetMessage('Vos options ont été mises à jours');
$this->Audit('', 'Ping',$params['club_number']);
//$this->RedirectToAdminTab('joueurs');
if(isset($params['demo']) && $params['demo'] === true)
{
	//il faut supprimer toutes les données de toutes les tables sauf compétitions genre uninstall
	//mass_delete demo ?
	
}
if($stall == "1")
{
	$this->Redirect($id, 'getInitialisation', $returnid, array("stall"=>$stall, "step"=>"2"));
}
else
{
	$this->RedirectToAdminTab('joueurs');
}

?>
