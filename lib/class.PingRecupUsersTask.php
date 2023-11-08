<?php
class PingRecupUsersTask implements CmsRegularTask 
{
	public function get_name()
	   {
	      return get_class();
	   }

	   public function get_description()
	   {
	      return 'Récupération des joueurs.';
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

	      $last_execute = (int) $ping->GetPreference('LastRecupUsers');
		
	      // Définition de la périodicité de la tâche (24h ici)
	      if( $time - $last_execute >= 7*24*3600)  // hardcoded to weekly update
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
	        $retrieve_ops = new retrieve_ops;
			$add_joueur = $retrieve_ops->retrieve_users();
	
	   }

	   public function on_success($time = '')
	   {

	      if (!$time)
	      {
	         $time = time();
	      }

	      $ping = cms_utils::get_module('Ping');
	      $ping->SetPreference('LastRecupUsers', $time);
	      $ping->Audit('','Ping','Nouveaux Joueurs récupérés');

	   }

	   public function on_failure($time = '')
	   {
	      $ping = cms_utils::get_module('Ping');
		$ping->Audit('','Ping','Pas de joueurs récupérés');
	   }

	}
?>
