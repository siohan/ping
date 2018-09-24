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
      $interval = (int) $ping->GetPreference('spid_interval');
	

      // Définition de la périodicité de la tâche (24h ici)
      	if( $last_execute >= ($time - 900) ) return FALSE; // hardcoded to 15 minutes
      return TRUE;
      /*if ( ($time - 5*60 ) >= $last_execute && $interval < 365 )//toutes les 5 minutes !!

      {
         return TRUE;
      }
      
      return FALSE;
      */
      
   }


   public function execute($time = '')
   {

      $db = \CmsApp::get_instance()->GetDb();
      if (!$time)
      {
         $time = time();
      }

      $ping = \cms_utils::get_module('Ping');
      //on vérifie qu'on peut récupérer les résultats
      /*	if($this->GetPreference('spid_calcul') == 1 && date('j') >= 10)
	{
      */
	// Ce qu'il y a à exécuter ici
			
			$saison_courante = $ping->GetPreference('saison_en_cours');
			$now = trim($db->DBTimeStamp(time()), "'");
			$query = "SELECT DISTINCT j.licence, CONCAT_WS( ' ', j.nom, j.prenom) AS player, j.cat FROM ".cms_db_prefix()."module_ping_recup_parties AS rp, ".cms_db_prefix()."module_adherents_adherents AS j  WHERE j.licence = rp.licence AND j.actif = '1' ";
			$interval = 3;//$ping->GetPreference('spid_interval');
			$query.=" AND rp.maj_spid < NOW()-INTERVAL ".$interval." DAY ";
			//$query.=" OR maj_spid = '000-00-00' ";
			$query.=" ORDER BY rp.maj_spid ASC ";
			$limit = 5;
			$query.= "LIMIT ".$limit;
			//$query = "SELECT CONCAT_WS(' ',nom,prenom) as player, licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif='1' LIMIT 2";
			$dbresult = $db->Execute($query);
			if($dbresult && $dbresult->RecordCount() > 0)
			{

				//on instancie la classe et on va commencer à boucler
				$service = new retrieve_ops();

				while ($row= $dbresult->FetchRow())
				{
					$licence = $row['licence'];		
					$player = $row['player'];
					$cat = $row['cat'];


					$retrieve_ops = $service->retrieve_parties_spid2($licence, $player, $cat);
					sleep(1);

				}//fin du while

			}
/*	}
	else
	{
	
		$saison_courante = $ping->GetPreference('saison_en_cours');
		$now = trim($db->DBTimeStamp(time()), "'");
		$query = "SELECT DISTINCT j.licence, CONCAT_WS( ' ', j.nom, j.prenom) AS player, j.cat FROM ".cms_db_prefix()."module_ping_recup_parties AS rp, ".cms_db_prefix()."module_ping_joueurs AS j  WHERE j.licence = rp.licence AND j.actif = '1' ";
		$interval = 3;//ping->GetPreference('spid_interval');
		$query.=" AND rp.maj_spid < NOW()-INTERVAL ".$interval." DAY ";
		//$query.=" OR maj_spid = '000-00-00' ";
		$query.=" ORDER BY rp.maj_spid DESC ";
		$limit = 5;
		$query.= "LIMIT ".$limit;
		//$query = "SELECT CONCAT_WS(' ',nom,prenom) as player, licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif='1' LIMIT 2";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount() > 0)
		{

			//on instancie la classe et on va commencer à boucler
			$service = new retrieve_ops();

			while ($row= $dbresult->FetchRow())
			{
				$licence = $row['licence'];		
				


				$retrieve_ops = $service->retrieve_parties_spid($licence);
				sleep(1);

			}//fin du while

		}
	}
  */    
	
//echo "coucou";
      
      return TRUE; // Ou false si ça plante

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