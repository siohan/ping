<?php
#################################################################################
###           RECUPERATION DES PARTIES SPID                                   ###
#################################################################################
$path = dirname(dirname(__FILE__));
$absolute_path = str_replace('modules','',$path);
define('ROOT',dirname($absolute_path));
require_once(ROOT.'/config.php');
$message = '';
$link = mysqli_connect($config['db_hostname'],$config['db_username'],$config['db_password'],$config['db_name']) or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    $message = "Connection impossible";
echo $message;
    
}

//$now = trim($link->DBTimeStamp(time()), "'");

//on fait un tableau qui récapitule toutes les possibilités (F, Z etc...)
//on récupère les préférences...
$tab= array("Ping_mapi_pref_club_number", "Ping_mapi_pref_idAppli", "Ping_mapi_pref_serie","Ping_mapi_pref_motdepasse","Ping_mapi_pref_saison_en_cours", "Ping_mapi_pref_phase_en_cours","Ping_mapi_pref_ligue", "Ping_mapi_pref_zone","Ping_mapi_pref_dep","Ping_mapi_pref_nom_equipes","Ping_mapi_pref_jour_sit_mens");
foreach($tab as $value)
{
	

	$query = "SELECT sitepref_value FROM ".$config['db_prefix']."siteprefs WHERE sitepref_name LIKE '".$value."'";
	//echo $query;
	$result = $link->query($query); 
	//var_dump($result);
	if($result)
	{
		while ($row = mysqli_fetch_assoc($result)) 
		{
        		$$value = $row['sitepref_value'];
			//var_dump($row);
			//echo $$value."<br/>";
    		}
	}

}


$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".$config['db_prefix']."module_ping_joueurs WHERE licence = '".$licence."' AND actif = '1'";
$dbretour = $link->query($query);
$lignes = mysqli_num_rows($dbretour);
if ($dbretour && $lignes > 0)
{
    while ($row= $dbretour->FetchRow())
      	{
		$player = $row['player'];
		//return $player;
		$service = new retrieve_ops();
		$resultats = $service->retrieve_parties_spid2($licence);
		//var_dump($resultats);
	}
	
}
elseif(!$dbretour)
{
	//une erreur ds la requete
}
else
{
	//pas de résultats
}
	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('recup');

#
# EOF
#
?>