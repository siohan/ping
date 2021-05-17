<?php
class PingClassementsTask implements CmsRegularTask 
{
	public function get_name()
	   {
	      return get_class();
	   }

	   public function get_description()
	   {
	      return 'Récupération des classements.';
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

	      $last_execute = (int) $ping->GetPreference('LastRecupClassements');
		
	      // Définition de la périodicité de la tâche (24h ici)
	      if( $time - $last_execute >= $ping->GetPreference('interval_classement'))  // hardcoded to weekly update
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
			$db = \CmsApp::get_instance()->GetDb();
	      	$ping = cms_utils::get_module('Ping');
	      	$saison = $ping->GetPreference('saison_en_cours');
			$query = "SELECT id FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ? AND maj_class+3600 < UNIX_TIMESTAMP()";
			$dbresult = $db->Execute($query, array($saison));
			if($dbresult && $dbresult->RecordCount() >0)
			{
				$ret_ops = new retrieve_ops;
				while($row = $dbresult->FetchRow())
				{
					$add_joueur = $ret_ops->retrieve_all_classements($row['id']);
				}
			}
	
	   }

	   public function on_success($time = '')
	   {

	      if (!$time)
	      {
	         $time = time();
	      }

	      $ping = cms_utils::get_module('Ping');
	      $ping->SetPreference('LastRecupClassements', $time);
	      
	      $ping->Audit('','Ping','Nouveaux classements récupérés');

	   }

	   public function on_failure($time = '')
	   {
	      $ping = cms_utils::get_module('Ping');
		$ping->Audit('','Ping','Pas de classements récupérés');
	   }

	}
?>