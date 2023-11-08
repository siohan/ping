<?php
class PingRecupFfttTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Récupération des parties FFTT.';
   }

   public function test($time = '')
   {

      	// Instantiation du module
      	$ping = cms_utils::get_module('Ping');
	//$interval =  $ping->GetPreference('fftt_interval');

      // Récupération de la dernière date d'exécution de la tâche
      if (!$time)
      {
         $time = time();
      }

      $last_execute = (int) $ping->GetPreference('LastRecupFftt');
      
      // Définition de la périodicité de la tâche 
      if( $time - $last_execute >= 3600 )  // Tous les 7 jours
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
        $spid_ops = new spid_ops;
	$ping_ops = new ping_admin_ops;
      	// Ce qu'il y a à exécuter ici
	//echo "coucou";
	//on récupère la saison en cours
	$db = cmsms()->GetDb();
	$saison = $ping->GetPreference('saison_en_cours');
	//$query = "SELECT j.licence FROM ".cms_db_prefix()."module_ping_recup_parties AS rp, ".cms_db_prefix()."module_ping_joueurs AS j WHERE j.licence = rp.licence AND j.actif='1' AND rp.maj_fftt < NOW()-INTERVAL 3 DAY AND rp.saison = ? ORDER BY rp.maj_fftt DESC LIMIT 25 ";
    $query = "SELECT licence  FROM ".cms_db_prefix()."module_ping_recup_parties WHERE maj_fftt < UNIX_TIMESTAMP() ORDER BY maj_fftt ASC LIMIT 5";
	$dbresult = $db->Execute($query);
	//on a donc les n licences pour faire la deuxième requete
	//on commence à boucler
	if($dbresult && $dbresult->RecordCount()>0)  //la requete est ok et il y a des résultats
	{
		//on instancie la classe Service
		
		
		$service = new retrieve_ops;

		while($row = $dbresult->FetchRow())
		{
			$licence = $row['licence'];
			$retrieve = $service->retrieve_parties_fftt($licence);
			//on envoie qqch au journal ?
			$player = $ping_ops->name($licence);
			$status = 'OK';
			$designation = $retrieve.' nouvelles parties fftt pour '.$player.'(Auto)';
			$action = 'FFTT Task';
			$ping_ops->ecrirejournal($status,$designation, $action);
			$maj_fftt = $spid_ops->compte_fftt($licence);
			$pts_fftt = $spid_ops->pts_fftt($licence);
			if(false != $pts_fftt)
			{
				$spid_ops->maj_pts_fftt($licence,$pts_fftt);
			}
		}
		return true; // Ou false si ça plante	
	}
	else
	{
		return false;
	}
	//return true; // Ou false si ça plante
	
	
	

      

   }

   public function on_success($time = '')
   {

      if (!$time)
      {
         $time = time();
      }
      
      $ping = cms_utils::get_module('Ping');
      $ping->SetPreference('LastRecupFftt', $time);
      $ping->Audit('','Ping','Récup FFTT Ok');
      
   }

   public function on_failure($time = '')
   {
      $ping = cms_utils::get_module('Ping');
	$ping->Audit('','Ping','Pas de récup FFTT');
   }

}
?>
