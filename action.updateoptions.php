<?php
if (!isset($gCms)) exit;

if( !$this->CheckPermission( 'Ping Set Prefs' ) )
{
  return;
}
debug_display($params, 'Parameters');

$adherents = new adherents();
$club_number = $adherents->GetPreference('club_number');

$ligue = substr($club_number, 0,2);
$departement = substr($club_number, 2, 2);
$ping_admin_ops = new ping_admin_ops();
$chercher_ligue = $ping_admin_ops->chercher_ligue($ligue);
$chercher_departement = $ping_admin_ops->chercher_departement($departement);
$service = new retrieve_ops();
$retrieve_club_detail = $service->retrieve_detail_club($club_number);
$this->SetPreference('ligue', $chercher_ligue);

$this->SetPreference('zone', $params['zone']);

$this->SetPreference('dep', $chercher_departement);
if($params['spid'] == 'Sans')
{
	$spid_calcul = 0;
}
else
{
	$spid_calcul = 1;
}
//pour la version 0.1 beta2 on proposera de déduire la ligue et le département auxquels le club appartient
//et on les mettra dans les préférences à créer également


$this->SetPreference('phase_en_cours', $params['phase_en_cours']);
$this->SetPreference('saison_en_cours', $params['saison_en_cours']);
$this->SetPreference('populate_calendar', $params['populate_calendar']);
$this->SetPreference('affiche_club_uniquement', $params['affiche_club_uniquement']);
$this->SetPreference('spid_calcul', $spid_calcul);
$this->SetMessage('Vos options ont été mises à jours');
$this->Audit('', 'Ping',$club_number);
//$this->RedirectToAdminTab('joueurs');
/*
$gettask = cms_utils::get_module('CGJobMgr');
$job = new cgjobmgr_job($gettask->GetName().' Recup FFTT',get_userid(FALSE));
$task = new cgjobmgr_iterativetask('recupfftt');

// Specify which function this task will call to actually do the work
$task->set_function(array('recupfftt_task','recup_fftt'));

// Add the task to the job
$job->add_task($task);
$job->save();
*/
if(isset($params['demo']) && $params['demo'] === true)
{
	//il faut supprimer toutes les données de toutes les tables sauf compétitions genre uninstall
	//mass_delete demo ?
	
}

	$this->RedirectToAdminTab('joueurs');


?>
