<?php
#################################################################
#    Première étape de récupération des équipes                 #
#################################################################



if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');

$club_number = $this->GetPreference('club_number');
$saison = $this->GetPreference('saison_en_cours');
$designation = '';
if(!isset($club_number) && $club_number =='')
{
	$message = "Votre numéro de club n'est pas configuré !!";
	$this->SetMessage("$message");
	$this->RedirectToAdminTab('configuration');
}
$now = trim($db->DBTimeStamp(time()), "'");
//on instancie la classe service
$service = new Service();
$type = $params['type'];

	if (!isset($type))
	{
		$result = $service->getEquipesByClub("$club_number");
		$chpt = "A"; //pour autres championnat
	}
	else 
	{
		$result = $service->getEquipesByClub("$club_number", "$type");
		$chpt = "S"; //pour championnat seniors
	}

//var_dump($result);
/**/
//on va tester si la variable est bien un tableau   
	if(!is_array($result))  {
		
		$this->SetMessage("Le service est coupé");
		$this->RedirectToAdminTab('equipes');
	}

///on initialise un compteur général $i
$i=0;
//on initialise un deuxième compteur
$compteur=0;
foreach($result as $cle =>$tab)
{
	
	$i++;
	$libequipe = $tab[libequipe];
	$newphase = explode ("-",$libequipe);
	//echo "la phase est ".$newphase[1];
	$phase = substr($newphase[1], -1);
	$new_equipe = $newphase[0];
	//echo "la phase est ".$phase;
	
	$libdivision = $tab[libdivision];
	$liendivision = $tab[liendivision];
	$idpoule = $tab[idpoule];
	$iddiv = $tab[iddiv];
	
	
	$query = "SELECT phase, saison, liendivision FROM ".cms_db_prefix()."module_ping_equipes WHERE liendivision = ? AND phase = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($liendivision, $phase, $saison));
	if($dbresult  && $dbresult->RecordCount() == 0) {
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_equipes (id, saison, phase, libequipe, libdivision, liendivision, idpoule, iddiv) VALUES ('', ?, ?, ?, ?, ?, ?, ?)";
		//echo $query;
		$compteur++;
		$dbresultat = $db->Execute($query,array($saison, $phase, $new_equipe, $libdivision, $liendivision, $idpoule, $iddiv));
		
		if(!$dbresultat)
		{
			$designation .= $db->ErrorMsg();
			
			
		}

	}//fin du if $dbresult
	
	
}// fin du foreach

$designation .= "Récupération de ".$compteur." équipes";
if($compteur >0){
	$designation.="Indiquez le type de compétition des équipes récupérées.";
}
$status = 'Ok';
$action = 'retrieve_teams';
//ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('equipes');

#
# EOF
#

?>