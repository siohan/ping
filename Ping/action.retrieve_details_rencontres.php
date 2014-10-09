<?php
if( !isset($gCms) ) exit;

$lien = $params['lien'];

/**/
debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');

//$result = $service->getJoueurParties("07290229");

$now = trim($db->DBTimeStamp(time()), "'");
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_details_rencontres WHERE lien = ?";
$dbretour = $db->Execute($query, array($lien));

if ($dbretour && $dbretour->RecordCount() > 0)
	{
    		while ($row= $dbretour->FetchRow())
      		{
			$message = "Le détail de cette rencontre est déjà enregistrée...";
			$this->SetMessage("$message");
			$this->RedirectToAdminTab('poules');
			//return $player;
		}
	
	}
else 
	{
	// code...

		$service = new Service();
		$result = $service->getRencontre("$lien");

var_dump($result);


}
     
/*
		$i = 0;
		$compteur = 0;
		
		foreach($result as $cle =>$tab)
			{
				$compteur++;
				
				$dateevent = $tab[date];
				$chgt = explode("/",$dateevent);
				$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];
				//echo "la date est".$date_event;
				$nom = $tab[nom];
				$classement = $tab[classement];
				$cla = substr($classement, 0,1);
				
					if($cla == 'N'){
						$newclassement = explode('-', $classement);
						$newclass = $newclassement[1];
					}
					else {
						$newclass = $classement;
					}
					
				$epreuve = $tab[epreuve];
				$victoire = $tab[victoire];
				
	if ($victoire =='V'){
		$victoire = 1;
		}
	else 
		{$victoire = 0;}
	$forfait = $tab[forfait];
	
	
	$query = "SELECT licence, date_event,nom FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND date_event = ? AND nom = ?";
	//echo $query;
	$dbresult = $db->Execute($query, array($licence, $date_event,$nom));
	if($dbresult  && $dbresult->RecordCount() == 0) {
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (id, datemaj, licence, date_event, nom, classement, victoire, forfait) VALUES ('', ?, ?, ?, ?, ?, ?, ?)";
		$i++;
		//echo $query;
		$dbresultat = $db->Execute($query,array($now, $licence, $date_event, $nom, $newclass, $victoire, $forfait));
		
		if(!$dbresultat)
		{
			echo $db->sql.'<br/>'.$db->ErrorMsg(); 
		}
	}
	else { 
		echo "Partie déjà enregistrée";
	}
}
}//fin du if $dbretour
$comptage = $i;
$status = 'Parties SPID';
$designation = "Récupération spid de ".$comptage." parties sur ".$compteur."  de ".$player;
$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datemaj, status, designation, action) VALUES ('', ?, ?, ?, ?)";
$action = "retrieve_parties_spid";
$dbresult = $db->Execute($query, array($now, $status,$designation,$action));
if(!$dbresult)
{
	echo $db->sql.'<br/>'.$db->ErrorMsg(); 
}
$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET spid = ? WHERE licence = ?";
$dbresult = $db->Execute($query, array($compteur,$licence));
if(!$dbresult){
	echo $db->sql.'<br/>'.$db->ErrorMsg(); 
}
	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('joueurs');
*/
#
# EOF
#
?>