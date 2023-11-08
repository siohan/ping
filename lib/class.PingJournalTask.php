<?php
class PingJournalTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Suppression des entrées du journal.';
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

      $net = (int) $ping->GetPreference('nettoyage_journal');
      $time_net = $net*24*3600;
      $last_execute = (int) $ping->GetPreference('LastRecupJournal');
      if($last_execute = 0)
      {
		  $last_execute = time();
	  }
      
      // Définition de la périodicité de la tâche (tous les x jours)
      if( $time - $last_execute >= $time_net)
      {
         return TRUE;
      }
      else
      {
		   return FALSE;
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
		$net = (int) $ping->GetPreference('nettoyage_journal');
		$time_net = $net*24*3600;
		//var_dump($time_net);

		$query = "DELETE FROM ".cms_db_prefix()."module_ping_recup WHERE (datecreated + ?) <= ?";
		$dbresult = $db->Execute($query,array($time_net,$time));
		if($dbresult && $dbresult->RecordCount() > 0)
		{
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
      $ping->Audit('','Ping','Nettoyage journal ok');
      $ping->SetPreference('LastRecupJournal', $time);
      
   }

   public function on_failure($time = '')
   {
      $ping = cms_utils::get_module('Ping');
      $ping->Audit('','Ping','journal non nettoyé');
   }

}
?>
