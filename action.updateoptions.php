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

$gettask = cms_utils::get_module('CGJobMgr');
$job = new cgjobmgr_job($gettask->GetName().' Recup FFTT',get_userid(FALSE));
$task = new cgjobmgr_iterativetask('recupfftt');

// Specify which function this task will call to actually do the work
$task->set_function(array('PingRecupFfttTask','recupfftt'));

// Add the task to the job
$job->add_task($task);
$job->save();


//et pour le spid
$gettask = cms_utils::get_module('CGJobMgr');
$job = new cgjobmgr_job($gettask->GetName().' Recup SPID',get_userid(FALSE));
$task = new cgjobmgr_iterativetask('recupspid');

// Specify which function this task will call to actually do the work
$task->set_function(array('PingRecupSpidTask','recupspid'));

// Add the task to the job
$job->add_task($task);
$job->save();

if(isset($params['demo']) && $params['demo'] === true)
{
	//il faut supprimer toutes les données de toutes les tables sauf compétitions genre uninstall
	//mass_delete demo ?
	
}

	$this->RedirectToAdminTab('joueurs');


?>
