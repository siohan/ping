<?php
class PingDetailsRencontresTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Récupération des détails des rencontres.';
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

      $last_execute = (int) $ping->GetPreference('LastRecupRencontres');
      
      // Définition de la périodicité de la tâche (24h ici)
      if ( $time - $last_execute >= $ping->GetPreference('interval_feuille_parties') )//tous les jours !!

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
	$db = \CmsApp::get_instance()->GetDb();
    $ping = cms_utils::get_module('Ping');
	
	//$ren_ops = new rencontres;
      
      // Ce qu'il y a à exécuter ici
	
	$saison = $ping->GetPreference('saison_en_cours');
	
	$query = "SELECT renc_id  FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE saison LIKE ? AND `date_event` < CURRENT_DATE() AND uploaded = 0 ORDER BY club DESC";
	$dbresult = $db->Execute($query, array($saison));
	if($dbresult && $dbresult->RecordCount() > 0)
	{
		$retrieve_ops = new rencontres;
		while ($row = $dbresult->FetchRow())
      	{			
			$renc_id = $row['renc_id'];
			
			$del_feuil = $retrieve_ops->delete_details_rencontre($record_id);
			if(true == $del_feuil)
			{
				$del_parties = $retrieve_ops->delete_rencontre_parties($record_id);
				$retrieve_ops->not_uploaded($record_id);
			}
			
			$retrieve = $retrieve_ops->feuille_parties($renc_id);					
		}//fin du while	
		return true; // Ou false si ça plante
	}
	else
	{
		return false; // Ou false si ça plante
	}
	

   }

   public function on_success($time = '')
   {

      if (!$time)
      {
         $time = time();
      }
      
      $ping = cms_utils::get_module('Ping');
      $ping->SetPreference('LastRecupRencontres', $time);
      $ping->Audit('','Ping','Détails Rencontres Ok');
      //$pong = cms_utils::get_module
      
   }

   public function on_failure($time = '')
   {
      $ping = cms_utils::get_module('Ping');
      $ping->Audit('','Ping','Pas de détails de rencontres');
   }

}
?>