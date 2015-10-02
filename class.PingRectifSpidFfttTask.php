<?php
class PingRectifSpidFfttTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Correction Spid FFTT.';
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

      $last_execute = $ping->GetPreference('LastRectifSpidFftt');
      
      // Définition de la périodicité de la tâche 
      if ( ($time - 7*24*60*60 ) >= $last_execute )//7 jours
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
      
      return true; // Ou false si ça plante

   }

   public function on_success($time = '')
   {

      if (!$time)
      {
         $time = time();
      }
      
      $ping = cms_utils::get_module('Ping');
      $ping->SetPreference('LastRectifSpidFftt', $time);
      $ping->Audit('','Ping','Récup Spid Ok');
      
   }

   public function on_failure($time = '')
   {
      $ping->Audit('','Ping','Pas de correction Spid FFTT');
   }

}
?>