<?php
class RecupCompetsTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Récupération de toutes les épreuves.';
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

		$last_execute = (int) $ping->GetPreference('LastRecupCompets');
		//$interval = (int) $ping->GetPreference('compets_interval');
		$interval = 86480;

      // Définition de la périodicité de la tâche (24h ici)
      	if( $time - $last_execute >=  $interval)  
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
		$orga = array('fede'=>$ping->getPreference('fede'), 'zone'=>$ping->GetPreference('zone'),'ligue'=>$ping->GetPreference('ligue'), 'dep'=>$ping->GetPreference('dep'));
		$ret_ops = new retrieve_ops;
		foreach($orga as $value)
		{
			$ret_ops->retrieve_compets($value,$type='I');
			$ret_ops->retrieve_compets($value,$type='E');
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
      $ping->SetPreference('LastRecupCompets', $time);
      $ping->Audit('','Ping','Compétitions récupérées');
      //$pong = cms_utils::get_module
      
   }

   public function on_failure($time = '')
   {
      $ping->Audit('','Ping','Pas de compétitions récupérées');
   }

}
?>
