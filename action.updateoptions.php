<?php
if (!isset($gCms)) exit;

if( !$this->CheckPermission( 'Ping Set Prefs' ) )
{
  return;
}
//$nom_equipes = strtoupper($params['nom_equipes']);
$this->SetPreference('club_number', $params['club_number']);
//pour la version 0.1 beta2 on proposera de déduire la ligue et le département auxquels le club appartient
//et on les mettra dans les préférences à créer également
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
$this->RedirectToAdminTab('joueurs');
//$this->RedirectToAdminTab('joueurs', array('message'=>'Full'));//$this->Redirect($id,'delete_all','',array($message=>'Options Ok'));
/*
$params = array('tab_message'=> 'optionsupdated', 'active_tab' => 'options');
$this->Redirect($id, 'options', '', $params);
*/
?>
