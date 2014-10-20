<?php
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
/*
$maClasse = 'class.Service.php';
$service = new $maClasse();
*/
$now = trim($db->DBTimeStamp(time()), "'");
$saison = $this->GetPreference('saison_en_cours');
$club_number = $this->GetPreference('club_number');
$designation = '';
if(!isset($club_number) || $club_number ==''){
	$this->SetMessage('Le numéro de club n\'est pas défini !');
	$this->RedirectToAdminTab('configuration');
}
$service = new Service();
//$result = $service->getLicencesByClub("$club_number");
$result = $service->getJoueursByClub("$club_number");

//var_dump($result);
if (!is_array($result)){
	$this->SetMessage('Service coupé');
	$this->RedirectToAdminTab('joueurs');
}
/**/
$i =0;
foreach($result as $cle =>$tab)
{
	$licence = $tab[licence];
	$nom = $tab[nom];
	$prenom = $tab[prenom];
	$actif = 1;	
	//$designation = 'récupération des joueurs';
	
	$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	
	if($dbresult  && $dbresult->RecordCount() == 0) {
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_joueurs (id, licence, nom, prenom,actif) VALUES ('', ?, ?, ?, ?)";
		$dbresultat = $db->Execute($query,array($licence,$nom, $prenom,$actif));
		$i++;
		if(!$dbresultat)
		{
			$designation.= $db->ErrorMsg();
		}
		
		
		
		//on réalise aussi une inclusion dans la table des situations mensuelles
		$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ?";
		$dbresult = $db->Execute($query, array($licence));
		
		if($dbresult->RecordCount()==0){
			$sit_mens = 'Janvier 2000';
			$fftt = 0;
			$spid = 0;
			$query ="INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id,saison,datemaj,licence, sit_mens, fftt, spid) VALUES ('', ?, ?, ?, ?, ?, ?)";
			$result = $db->Execute($query, array($saison, $now, $licence, $sit_mens, $fftt, $spid));
			
		}
	
		
	}
	
	
	
	
	
}// fin du foreach


	$designation.= "Inclusion de  ".$i." joueurs";
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('joueurs');
/**/
#
# EOF
#
?>