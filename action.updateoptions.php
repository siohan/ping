<?php
if (!isset($gCms)) exit;

if( !$this->CheckPermission( 'Ping Set Prefs' ) )
{
  return;
}
//$nom_equipes = strtoupper($params['nom_equipes']);
if(isset($params['club_number']) && $params['club_number'] !="" )
{
	$this->SetPreference('club_number', $params['club_number']);
	$club_number = $params['club_number'];
	$ligue = substr($club_number, 0,2);
	$ligue1 = "10".$ligue;
	//echo "la ligue est : ".$ligue;
	$dep = substr($club_number,2,2);
	//echo "le dep est :".$dep;
	//on en déduit le nom générique des équipes
	
		$this->SetPreference('ligue', $ligue1);//$params['ligue']);
		$this->SetPreference('zone', $params['zone']);
		$this->SetPreference('dep', $dep);//$params['dep']);
		$this->SetPreference('phase_en_cours', $params['phase_en_cours']);
		$this->SetPreference('saison_en_cours', $params['saison_en_cours']);
		$this->SetPreference('nom_equipes', $params['nom_equipes']);
		$this->SetPreference('populate_calendar', $params['populate_calendar']);
		$this->SetPreference('affiche_club_uniquement', $params['affiche_club_uniquement']);
		$this->SetPreference('spid_nombres', $params['spid_nombres']);
		$this->SetPreference('fftt_nombres', $params['fftt_nombres']);
		$this->SetPreference('spid_interval', $params['spid_interval']);
		$this->SetPreference('fftt_interval', $params['fftt_interval']);
		$this->SetMessage('Vos options ont été mises à jours');
		$this->Audit('', 'Ping',$params['club_number']);
		//$this->RedirectToAdminTab('joueurs');
		$this->Redirect($id,'retrieve_compets2',$returnid,array("message"=>"Options à jour"));//$this->Redirect($id,'delete_all','',array($message=>'Options Ok'));
	}
	
}
else
{
	//et le numéro de club alors !!
	
}

?>
