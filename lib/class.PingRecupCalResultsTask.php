<?php
class PingRecupSpidTask implements CmsRegularTask
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
      $ping = cms_utils::get_module('Ping');

      // Récupération de la dernière date d'exécution de la tâche
      if (!$time)
      {
         $time = time();
      }

      $last_execute = $ping->GetPreference('LastRecupSpid');
      
      // Définition de la périodicité de la tâche (24h ici)
      if ( ($time - 24*60*60 ) >= $last_execute )//toutes les 24 heures  !!

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
	$db = $ping->GetDb();
	$saison_courante = $ping->GetPreference('saison_en_cours');
	$now = trim($db->DBTimeStamp(time()), "'");
	$query = "SELECT date_event, idpoule,iddiv, affiche, uploaded,scorea, scoreb  FROM ".cms_db_prefix()."module_ping_poules_rencontres  WHERE cal.type_comp = tc.code_compet AND `date_event` <= NOW() AND `date_event` > NOW() - INTERVAL 7 DAY  AND scorea = 0 AND scoreB = 0ORDER BY date_event DESC ";
	$interval = $ping->GetPreference('spid_interval');
	
	//$query = "SELECT CONCAT_WS(' ',nom,prenom) as player, licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif='1' LIMIT 2";
	$dbresult = $db->Execute($query,array($saison_courante));
	if($dbresult && $dbresult->RecordCount() > 0)
	{

		//on a deux cas
		// 1 - il s'agit de compétitons individuelles
		// 2 - Il s'agit de compétitons par équipes
		
		$service = new Service();

		while ($row= $dbresult->FetchRow())
		{
			$indivs = $row['indivs'];
			$type_compet = $row['code_compet'];
			
			if($indivs == 1)
			{
				//il s'agit d'une compétition individuelle
				//on récupère la liste des participant s à cette épreuve
			}
			else
			{
				//il s'agit d'une compétition par équipes
			}		
			//$player = $row['player'];


			ping_admin_ops::retrieve_parties_spid($licence);


		}//fin du while

	}
	
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
      $ping->SetPreference('LastRecupSpid', $time);
      $ping->Audit('','Ping','Récup Spid Ok');
      //$pong = cms_utils::get_module
      
   }

   public function on_failure($time = '')
   {
      $ping->Audit('','Ping','Pas de récup SPID');
   }

}
?>