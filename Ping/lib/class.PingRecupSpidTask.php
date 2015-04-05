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
      if ( ($time - 30*60 ) >= $last_execute )//toutes les 24 heures  !!

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
	$query = "SELECT j.licence FROM ".cms_db_prefix()."module_ping_recup_parties AS rp, ".cms_db_prefix()."module_ping_joueurs AS j  WHERE j.licence = rp.licence AND j.actif = '1' ";
	$interval = $ping->GetPreference('spid_interval');
	$query.=" AND maj_spid < NOW()-INTERVAL ".$interval." DAY AND saison = ? ORDER BY maj_spid DESC ";
	$limit = $ping->GetPreference('spid_nombres');
	$query.= "LIMIT ".$limit;
	//$query = "SELECT CONCAT_WS(' ',nom,prenom) as player, licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif='1' LIMIT 2";
	$dbresult = $db->Execute($query,array($saison_courante));
	if($dbresult && $dbresult->RecordCount() > 0)
	{

		//on instancie la classe et on va commencer à boucler
		$service = new Service();

		while ($row= $dbresult->FetchRow())
		{
			$licence = $row['licence'];		
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