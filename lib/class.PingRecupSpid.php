<?php
class PingRecupSpid implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Description de la tâche.';
   }

   public function test($time = '')
   {

      // Instantiation du module
      $test = cms_utils::get_module('Test');

      // Récupération de la dernière date d'exécution de la tâche
      if (!$time)
      {
         $time = time();
      }

      $last_execute = $test->GetPreference('MaVariableDeTestDeDerniereExecution');
      
      // Définition de la périodicité de la tâche (24h ici)
      if ( ($time - 24*60*60 ) >= $last_execute )
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

      $test = cms_utils::get_module('Ping');
      
      // Ce qu'il y a à exécuter ici
      
      return true; // Ou false si ça plante

   }

   public function on_success($time = '')
   {

      if (!$time)
      {
         $time = time();
      }
      
      $test = cms_utils::get_module('Ping');
      $test->SetPreference('MaVariableDeTestDeDerniereExecution', $time);
      $test->Audit('','Ping','Récup Spid Ok');
      
   }

   public function on_failure($time = '')
   {
      $test->Audit('','Ping','Pas de récup SPID');
   }

}
?>