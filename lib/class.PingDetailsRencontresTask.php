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
	
	$saison = $ping->GetPreference('saison_en_cours');
	$ping_ops = new ping_admin_ops;
	$eq_ops = new rencontres;
	$query = "SELECT renc_id, equip_id1, equip_id2  FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE saison LIKE ? AND `date_event` <= CURRENT_DATE()  ORDER BY club DESC"; // AND (scorea = 0 AND scoreb = 0)
	$dbresult = $db->Execute($query, array($saison));
	if($dbresult && $dbresult->RecordCount() > 0)
	{
		$renc_ops = new rencontres;
		//$details = $renc_ops->details_rencontre($row['renc_id']);
		while ($row = $dbresult->FetchRow())
      	{			
			$details = $renc_ops->details_rencontre($row['renc_id']);
			if($row['equip_id1'] >0 && $row['equip_id2'] >0)
			{
				$renc_id = $row['renc_id'];
				//on vérifie que la feuille a déjà été uploadé ou pas
				$is_really_uploaded = $eq_ops->is_really_uploaded($row['renc_id']);
				if(false == $is_really_uploaded)
				{
					
					$retrieve = $renc_ops->feuille_parties($renc_id);// insère la feuille de rencontre et les parties
					$uploaded = $renc_ops->is_uploaded($renc_id);
					$status = 'Ok';
					$designation = 'Détails rencontre Ok :'.$details['equa'].' /'.$details['equb'];
					$action = 'feuille_parties'; 
					$ping_ops->ecrirejournal($status, $designation,$action);
				}	
			}
			else
			{
				$uploaded = $renc_ops->is_uploaded($row['renc_id']);
			}
			
							
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
