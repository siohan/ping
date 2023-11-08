<?php
class PingResetSpidTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Reset SPID.';
   }

   
	public function test($time = '')
	{

      // Instantiation du module
      $ping = \cms_utils::get_module('Ping');

      // Récupération de la dernière date d'exécution de la tâche
      
      	if( date('d') == 10)  
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
		if(date('d') < 10)
		{	
			$saison_courante = $ping->GetPreference('saison_en_cours');
			$now = trim($db->DBTimeStamp(time()), "'");
			$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET spid = 0, spid_errors = 0, maj_spid = ? , pts_spid = 0";
			
			$dbresult = $db->Execute($query, array($now));
			if($dbresult && $dbresult->RecordCount() > 0)
			{				
				$month = date('m')-1;
				$day = '31';
				$year = date('Y');
				$date_echeance = $year.'-'.$month.'-'.$day;
				
				//on supprime tous les enregistrements ?
				$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE date_event < ?";
				$dbresult = $db->Execute($query, array($date_echeance));
				return TRUE; 
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
      $ping->SetPreference('LastResetSpid', $time);
      $ping->Audit('','Ping','Reset Spid Ok');
  }

   public function on_failure($time = '')
   {
      $ping = \cms_utils::get_module('Ping');
$ping->Audit('','Ping','Pas de reset SPID');
   }

}
?>
