<?php
class PingTeamsTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Récupération des équipes.';
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

		$last_execute = (int) $ping->GetPreference('LastRecupTeams');
		$interval = (int) $ping->GetPreference('interval_equipes');
	

      // Définition de la périodicité de la tâche (24h ici)
      	if( $time - $last_execute >= $interval)  
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
				
			$service = new retrieve_ops();
			
				$types = array("F", "M", "U");	
				foreach($types as $value)
				{
					$retrieve_ops = $service->retrieve_teams($value);
				}	
			
		return true; 
		

   }

   public function on_success($time = '')
   {

      if (!$time)
      {
         $time = time();
      }
      
      $ping = cms_utils::get_module('Ping');
      $ping->SetPreference('LastRecupTeams', $time);
      $ping->Audit('','Ping','Equipes récupérées');
      //$pong = cms_utils::get_module
      
   }

   public function on_failure($time = '')
   {
      $ping->Audit('','Ping','Pas d\'équipes récupérées');
   }

}
?>
