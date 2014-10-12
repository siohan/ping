<?php
if (!isset($gCms)) exit;

if( !$this->CheckPermission( 'Modify Site Preferences' ) )
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
/*
$this->SetPreference('formsubmit_emailaddress', $params['formsubmit_emailaddress']);
$this->SetPreference('email_subject',$params['email_subject']);
$this->SetTemplate('email_template',$params['email_template']);
$this->SetPreference('allowed_upload_types',
		     $params['allowed_upload_types']);
$this->SetPreference('hide_summary_field',
		     (isset($params['hide_summary_field'])?'1':'0'));
$this->SetPreference('allow_summary_wysiwyg',
		     (isset($params['allow_summary_wysiwyg'])?'1':'0'));
$this->SetPreference('expired_searchable',
		     (isset($params['expired_searchable'])?'1':'0'));
$this->SetPreference('expiry_interval', $params['expiry_interval']);
$this->SetPreference('fesubmit_status', $params['fesubmit_status']);
$this->SetPreference('fesubmit_redirect', trim($params['fesubmit_redirect']));
$this->SetPreference('detail_returnid',(int)$params['detail_returnid']);
*/

$this->SetMessage('Vos options ont été mises à jours');
$this->RedirectToAdminTab('configuration');
/*
$params = array('tab_message'=> 'optionsupdated', 'active_tab' => 'options');
$this->Redirect($id, 'options', '', $params);
*/
?>
