<?php
if (!isset($gCms)) exit;

if( !$this->CheckPermission( 'Ping Set Prefs' ) )
{
  return;
}
//debug_display($params, 'Parameters');


$this->SetPreference('phase_en_cours', $params['phase_en_cours']);
$this->SetPreference('saison_en_cours', $params['saison_en_cours']);
$this->SetPreference('populate_calendar', $params['populate_calendar']);
$this->SetPreference('affiche_club_uniquement', $params['affiche_club_uniquement']);

$this->SetMessage('Vos options ont été mises à jours');
//$this->Audit('', 'Ping',$club_number);
//$this->RedirectToAdminTab('joueurs');

$this->RedirectToAdminTab('joueurs');


?>
