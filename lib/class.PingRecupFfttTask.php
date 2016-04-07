<?php
class PingRecupFfttTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Récupération des parties FFTT.';
   }

   public function test($time = '')
   {

      // Instantiation du module
      $ping = cms_utils::get_module('Ping');

      // Récupération de la dernière date d'exécution de la tâche
      if (!$time)
      {
         $time = time();
      }

      $last_execute = $ping->GetPreference('LastRecupFftt');
      
      // Définition de la périodicité de la tâche (24h ici)
      if ( ($time - 30*60 ) >= $last_execute )//toutes les dix minutes
      {
         return TRUE;
      }
      
      return FALSE;
      
   }

   public function execute($time = '')
   {

      	if (!$time)
      	{
         	$time = time();
      	}

      	$ping = cms_utils::get_module('Ping');
      
      	// Ce qu'il y a à exécuter ici
	//echo "coucou";
	//on récupère la saison en cours
	$db = $ping->GetDb();
	$saison = $ping->GetPreference('saison_en_cours');
	$query = "SELECT j.licence FROM ".cms_db_prefix()."module_ping_recup_parties AS rp,".cms_db_prefix()."module_ping_joueurs AS j WHERE j.licence = rp.licence AND j.actif='1' AND rp.maj_fftt < NOW()-INTERVAL 3 DAY AND rp.saison = ? ORDER BY rp.maj_fftt DESC LIMIT 25 ";
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
			sleep(1);
		}
		
	}
	return true; // Ou false si ça plante
	
	
	

      

   }

   public function on_success($time = '')
   {

      if (!$time)
      {
         $time = time();
      }
      
      $ping = cms_utils::get_module('Ping');
      $ping->SetPreference('LastRecupFftt', $time);
      $ping->Audit('','Ping','Récup FFTT Ok');
      
   }

   public function on_failure($time = '')
   {
      $ping->Audit('','Ping','Pas de récup FFTT');
   }

}
?>