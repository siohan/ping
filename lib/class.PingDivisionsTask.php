<?php
class PingDivisionsTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Récupération des divisions des épreuves individuelles.';
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

      $last_execute = (int) $ping->GetPreference('LastRecupDivisions');
      $interval_divisions = (int) $ping->GetPreference('interval_divisions');
      
      // Définition de la périodicité de la tâche (24h ici)
      if ( $time - $last_execute >= 300 )//tous les jours !!

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
	
	
	$epr_ops = new EpreuvesIndivs;
	$renc_ops = new retrieve_ops;		
	$query = "SELECT idepreuve, idorga FROM ".cms_db_prefix()."module_ping_type_competitions WHERE actif = 1 AND suivi = 1 AND indivs = 1";
	$dbresult = $db->Execute($query);
	if($dbresult && $dbresult->RecordCount() > 0)
	{
		
		while ($row = $dbresult->FetchRow())
      	{			
			
				$renc_ops->retrieve_divisions ($row['idorga'],$row['idepreuve'],$type = 'I');
				
								
		}//fin du while	
		return true;	
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
      $ping->SetPreference('LastRecupDivisions', $time);
      $ping->Audit('','Ping','Divisions Ok');
      //$pong = cms_utils::get_module
      
   }

   public function on_failure($time = '')
   {
      $ping = cms_utils::get_module('Ping');
      $ping->Audit('','Ping','Pas de divisions récupérées');
   }

}
?>
