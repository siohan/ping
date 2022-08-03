<?php
class recupfftt_task 
{
	protected function __construct() {}
      	function recup_fftt()
	{
		$ping = cms_utils::get_module('Ping');
      		ignore_user_abort(true);
	      	// Ce qu'il y a à exécuter ici
		//echo "coucou";
		//on récupère la saison en cours
		$db = $ping->GetDb();
		$saison = $ping->GetPreference('saison_en_cours');
		$query = "SELECT j.licence FROM ".cms_db_prefix()."module_ping_recup_parties AS rp,".cms_db_prefix()."module_ping_joueurs AS j WHERE j.licence = rp.licence AND j.actif='1' AND rp.maj_fftt < NOW()-INTERVAL 3 DAY AND rp.saison = ? ORDER BY rp.maj_fftt DESC LIMIT 3 ";
	      	$dbresult = $db->Execute($query, array($saison));
		//on a donc les n licences pour faire la deuxième requete
		//on commence à boucler
		if($dbresult && $dbresult->RecordCount()>0)  //la requete est ok et il y a des résultats
		{
			//on instancie la classe Service
		
		
			$service = new retrieve_ops();

			while($row = $dbresult->FetchRow())
			{
				$licence = $row['licence'];
				$retrieve = $service->retrieve_parties_fftt($licence);
			}
		 return true;
		}
		else
		{
			return false;
		}
	}
	
	//return true; // Ou false si ça plante  
}
?>