<?php
class PingRefreshFfttTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return '';
   }

   public function test($time = '')
   {

      	// Instantiation du module
      	$ping = cms_utils::get_module('Ping');
	//$interval =  $ping->GetPreference('fftt_interval');

      // Récupération de la dernière date d'exécution de la tâche
      if (!$time)
      {
         $time = time();
      }

      $last_execute = (int) $ping->GetPreference('LastRecupFftt');
      
      // Définition de la périodicité de la tâche (24h ici)
      if( $time - $last_execute >= 24*3600 )  // hardcoded to daily update
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
	$db = cmsms()->GetDb();
	$saison = $ping->GetPreference('saison_en_cours');
	//$query = "SELECT j.licence FROM ".cms_db_prefix()."module_ping_recup_parties AS rp, ".cms_db_prefix()."module_ping_joueurs AS j WHERE j.licence = rp.licence AND j.actif='1' AND rp.maj_fftt < NOW()-INTERVAL 3 DAY AND rp.saison = ? ORDER BY rp.maj_fftt DESC LIMIT 25 ";
      	$query = "SELECT licence  FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = 1 AND type='T' LIMIT 30";//" < UNIX_TIMESTAMP() ORDER BY maj_fftt DESC LIMIT 25 ";
	$dbresult = $db->Execute($query);
	//on a donc les n licences pour faire la deuxième requete
	//on commence à boucler
	if($dbresult && $dbresult->RecordCount()>0)  //la requete est ok et il y a des résultats
	{
		//on instancie la classe Service
		
		
		$service = new spid_ops;

		while($row = $dbresult->FetchRow())
		{
			$licence = $row['licence'];
			$retrieve = $service->compte_fftt($licence);
			$retrieve_spid = $service->compte_spid($licence);
			sleep(1);
		}
		return true; // Ou false si ça plante	
	}
	else
	{
		return false;
	}
	//return true; // Ou false si ça plante
	
	
	

      

   }

   public function on_success($time = '')
   {

      if (!$time)
      {
         $time = time();
      }
      
      $ping = cms_utils::get_module('Ping');
      $ping->SetPreference('LastRecupFftt', $time);
      $ping->Audit('','Ping','Refresh Spid FFTT Ok');
      
   }

   public function on_failure($time = '')
   {
      $ping = cms_utils::get_module('Ping');
	$ping->Audit('','Ping','Refresh Spid FFTT KO');
   }

}
?>