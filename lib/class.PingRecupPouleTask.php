<?php
class PingRecupPouleTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Récupération des rencontres d\'une poule.';
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

      $last_execute = (int) $ping->GetPreference('LastRecupResults');
     
      
      // Définition de la périodicité de la tâche (24h ici)
      if  ($time - $last_execute >= 300 )//toutes les 24 heures  !!
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
	$saison_courante = $ping->GetPreference('saison_en_cours');
	$phase = $ping->GetPreference('phase_en_cours');
	$query = "SELECT eq.id,ren.eq_id, eq.iddiv, eq.idpoule,eq.idepreuve,eq.libequipe, eq.libdivision FROM ".cms_db_prefix()."module_ping_equipes AS eq LEFT JOIN ".cms_db_prefix()."module_ping_poules_rencontres AS ren ON eq.id = ren.eq_id WHERE eq.saison = ? AND eq.phase = ? GROUP BY eq.id HAVING ren.eq_id IS NULL";
	
	
	$dbresult = $db->Execute($query,array($saison_courante,$phase));
	if($dbresult && $dbresult->RecordCount() > 0)
	{

		//on instancie la classe et on va commencer à boucler
		$service = new retrieve_ops();
		$ping_ops = new ping_admin_ops;
		while ($row= $dbresult->FetchRow())
		{
			//on vérifie qu'il n'y a pas déjà d'enregistrement en bdd
			$retrieve_ops = $service->retrieve_poule_rencontres( $row['id'],$row['iddiv'],$row['idpoule'],$row['idepreuve']);
			$status = 'OK';
			$designation = 'Poule récupérée : '.$row['libequipe'].'- '.$row['libdivision'].' (CRON)';
			$action = 'Poules auto';
			$ping_ops->ecrirejournal($status, $designation, $action);
		}//fin du while
		return true; // Ou false si ça plante
	}
	else
	{
		return false;
	}
		
	
//echo "coucou";
      
      

   }

   public function on_success($time = '')
   {

      if (!$time)
      {
         $time = time();
      }
      
      $ping = cms_utils::get_module('Ping');
      $ping->SetPreference('LastRecupPoule', $time);
      $ping->Audit('','Ping','Récup Poule Ok');
      //$pong = cms_utils::get_module
      
   }

   public function on_failure($time = '')
   {
      $ping = cms_utils::get_module('Ping');
      $ping->Audit('','Ping','Pas de récup de poules');
   }

}
?>
