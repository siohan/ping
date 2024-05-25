<?php
class PingRecupDivClaTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Récupération des classements des épreuves individuelles.';
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

      $last_execute = (int) $ping->GetPreference('LastRecupDivCla');
      
      // Définition de la périodicité de la tâche (24h ici)
      if ( $time - $last_execute >= 900 )//tous les jours !!

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
      
	$renc_ops = new retrieve_ops;
	$query = "SELECT t.idepreuve, t.iddivision, t.tableau, t.tour FROM ".cms_db_prefix()."module_ping_type_competitions AS tc , ".cms_db_prefix()."module_ping_div_tours AS t WHERE tc.idepreuve = t.idepreuve AND tc.actif = 1 AND tc.indivs = 1 AND t.date_prevue < UNIX_TIMESTAMP()";//AND tc.suivi = 1
	$dbresult = $db->Execute($query);
	if($dbresult && $dbresult->RecordCount() > 0)
	{				
		while ($row = $dbresult->FetchRow())
      	{
			$renc_ops->retrieve_div_classement($row['idepreuve'],$row['iddivision'],$row['tableau'], $row['tour']);								
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
      $ping->SetPreference('LastRecupDivCla', $time);
      $ping->Audit('','Ping','Classements individuels récupérés');
      //$pong = cms_utils::get_module
      
   }

   public function on_failure($time = '')
   {
      $ping = cms_utils::get_module('Ping');
      $ping->Audit('','Ping','Pas de classements individuels récupérés');
   }

}
?>
