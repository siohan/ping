<?php
class PingRecupRencontresTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Récupération des rencontres de championnat.';
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

      $last_execute = $ping->GetPreference('LastRecupRencontres');
      
      // Définition de la périodicité de la tâche (24h ici)
      if ( $time - $last_execute >= 900)//24*3600 )//tous les 15 minutes !!

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
	$db = cmsms()->GetDb();
    $ping = cms_utils::get_module('Ping');
	$ping_ops = new ping_admin_ops;
	$retrieve_ops = new retrieve_ops;
      
      // Ce qu'il y a à exécuter ici
	
	$saison = $ping->GetPreference('saison_en_cours');
	
	$query = "SELECT DISTINCT iddiv, idpoule,idepreuve, eq_id, equip_id1, equip_id2 FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE `date_event` < CURRENT_DATE() AND saison = ? AND (scorea = 0 AND scoreb = 0)";
	
	$dbresult = $db->Execute($query, array($saison));
	if($dbresult && $dbresult->RecordCount() > 0)
	{

		while ($row = $dbresult->FetchRow())
      	{			
			$iddiv = $row['iddiv'];
			$idpoule = $row['idpoule'];
			$idepreuve = $row['idepreuve'];
			$record_id = $row['eq_id'];
			$equip_id1 = (int)$row['equip_id1'];
			$equip_id2 = (int)$row['equip_id2'];
			if($equip_id1 >0 && $equip_id2 >0)
			{
				$retrieve = $retrieve_ops->retrieve_poule_rencontres($record_id,$iddiv, $idpoule, $idepreuve);
				$status = 'OK';
				$designation = 'Nouveaux scores par équipes (Auto)';
				$action = 'Rencontres auto';
			}
			else
			{
				$status = 'KO';
				$designation = 'La tâche de récupération des rencontres a  échoué';
				$action = 'Rencontres auto';
			}
			$ping_ops->ecrirejournal($status, $designation, $action);
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
      $ping->Audit('','Ping','Récup Rencontres Ok');
      //$pong = cms_utils::get_module
      
   }

   public function on_failure($time = '')
   {
      $ping = cms_utils::get_module('Ping');
      $ping->Audit('','Ping','Pas de récup de rencontres');
   }

}
?>
