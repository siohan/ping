<?php
class PingRecupSpidTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Récuperation du SPID.';
   }

   
	public function test($time = '')
   {

      // Instantiation du module
      $ping = \cms_utils::get_module('Ping');

      // Récupération de la dernière date d'exécution de la tâche
      if (!$time)
      {
         $time = time();
      }

      $last_execute = (int) $ping->GetPreference('LastRecupSpid');
      //$interval = (int) $ping->GetPreference('spid_interval');
	

      // Définition de la périodicité de la tâche (24h ici)
      	if( $time - $last_execute >=  24*3600)  
	{
		return true; // hardcoded to 15 minutes
	}
	else
	{
		 return false;
	}
     
     
      
      
   }


   public function execute($time = '')
   {

      $db = \CmsApp::get_instance()->GetDb();
      if (!$time)
      {
         $time = time();
      }

      $ping = \cms_utils::get_module('Ping');
     
	// Ce qu'il y a à exécuter ici
		if(date('d') >= 10)
		{	
			$saison_courante = $ping->GetPreference('saison_en_cours');
			$now = trim($db->DBTimeStamp(time()), "'");
			$query = "SELECT DISTINCT j.licence, CONCAT_WS( ' ', j.nom, j.prenom) AS player, j.cat, rp.maj_spid FROM ".cms_db_prefix()."module_ping_recup_parties AS rp, ".cms_db_prefix()."module_ping_joueurs AS j  WHERE j.licence = rp.licence AND j.actif = '1' ";
			$query.=" AND rp.maj_spid < UNIX_TIMESTAMP() ";
			$query.=" ORDER BY rp.maj_spid ASC ";
			$limit = 15;
			$query.= "LIMIT ".$limit;
			//$query = "SELECT CONCAT_WS(' ',nom,prenom) as player, licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif='1' LIMIT 2";
			$dbresult = $db->Execute($query);
			if($dbresult && $dbresult->RecordCount() > 0)
			{

				//on instancie la classe et on va commencer à boucler
				$service = new retrieve_ops;
				$spid_ops = new spid_ops;
				$ping_ops = new ping_admin_ops;

				while ($row= $dbresult->FetchRow())
				{
					$licence = $row['licence'];		
					$player = $row['player'];
					$cat = $row['cat'];

			
						$retrieve_ops = $service->retrieve_parties_spid2($licence, $player, $cat);
						$status = 'OK';
						$designation = $retrieve_ops.' nouvelles parties spid pour '.$player.'(Auto)';
						$action = 'Spid Task';
						$ping_ops->ecrirejournal($status,$designation, $action);
						$spid_ops->compte_spid($licence);
						$spid_ops->compte_spid_errors($licence);
						$calcul_pts_spid = $spid_ops->compte_spid_points($licence);
						$spid_ops->maj_points_spid($licence,$calcul_pts_spid);
						
				}//fin du while
				return TRUE; // Ou false si ça plante
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}

				

      
      

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
      $ping = \cms_utils::get_module('Ping');
$ping->Audit('','Ping','Pas de récup SPID');
   }

}
?>
