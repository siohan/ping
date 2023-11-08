<?php
class PingPhaseSaisonTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Changement de phase ou de saison.';
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

		$last_execute = (int) $ping->GetPreference('LastRecupPhaseSaison');
		if($last_execute == 0)
		{
			$ping->SetPreference('LastRecupPhaseSaison', time());
			$last_execute = time();
		}
		$interval = (int) 604800;//tous les 15 jours
	

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
		$saison_en_cours = $ping->GetPreference('saison_en_cours');
		$phase_en_cours = $ping->GetPreference('phase_en_cours');
		
		if( date('m') >=1 && date('m') < 7)
		{
			//ici c'est pour le changement de phase
			if($phase_en_cours == '1')
			{
				$ping->SetPreference('phase_en_cours', 2);
				$ping->Audit('','Ping','Phase modifiée');
			}
		}
		elseif(date('m') >=7)
		{
			//ici c'est la saison et la phase qu'il faut changer
			
			$annee1 = date('Y');
			$annee2 = date('Y')+1;
			$saison = $annee1.'-'.$annee2;
			$ping->SetPreference('saison_en_cours', $saison);
			$ping->SetPreference('phase_en_cours', '1');
			$ping->Audit('','Ping','Saison et Phase modifiées');
			
		}
			

	} 

   public function on_success($time = '')
   {

      if (!$time)
      {
         $time = time();
      }
      
      $ping = cms_utils::get_module('Ping');
      $ping->SetPreference('LastRecupPhaseSaison', $time);
      $ping->Audit('','Ping','Saison et/ou phase modifiées');
      //$pong = cms_utils::get_module
      
   }

   public function on_failure($time = '')
   {
      $ping = cms_utils::get_module('Ping');
      $ping->Audit('','Ping','Pas de changement de phase et/ou de saison');
   }

}
?>
