<?php
class PingSitMensTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Récupération des situations mensuelles.';
   }

   public function test($time = '')
   {

		// Instantiation du module
		$ping = \cms_utils::get_module('Ping');

		// Récupération de la dernière date d'exécution de la tâche
		if (!$time)
		{
			$time = time();
		}

		$last_execute = (int) $ping->GetPreference('LastRecupSitMens');
		//$interval = (int) $ping->GetPreference('spid_interval');
	

      // Définition de la périodicité de la tâche (24h ici)
      	if( $time - $last_execute >=  30*24*3600 && date('d') >= 10)  
		{
			return true; 
		}
		else
		{
			 return false;
		}
      
   }

   public function execute($time = '')
   {

      if (!$time)
      {
         $time = time();
      }

      $ping = cms_utils::get_module('Ping');
      
      // Ce qu'il y a à exécuter ici
		$db = $ping->GetDb();
		$saison_courante = $ping->GetPreference('saison_en_cours');
		$jour = date('d');
		$mois = date('m');
		$query = "SELECT licence FROM  ".cms_db_prefix()."module_ping_joueurs   WHERE actif = '1' AND type='T' ";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount() > 0)
		{

			//on instancie la classe et on va commencer à boucler
			$service = new retrieve_ops();

			while ($row= $dbresult->FetchRow())
			{
				$licence = $row['licence'];		
				$retrieve_ops = $service->retrieve_sit_mens($licence, $ext="");	
			}
			return true; 
		}
		else
		{
			return false;
		}
	
      
      

   }

   public function on_success($time = '')
   {

      if (!$time)
      {
         $time = time();
      }
      
      $ping = cms_utils::get_module('Ping');
      $ping->SetPreference('LastRecupSitMens', $time);
      $ping->Audit('','Ping','Récup Situation Mensuelle Ok');
      //$pong = cms_utils::get_module
      
   }

   public function on_failure($time = '')
   {
      $ping->Audit('','Ping','Pas de situation mensuelle');
   }

}
?>
