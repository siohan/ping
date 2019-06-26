<?php


class VerifAdherentsTask implements \CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Maj des adhérents';
   }

   
	public function test($time = '')
   {
	debug_to_log(__METHOD__);
      // Instantiation du module
      $ping = \cms_utils::get_module('Ping');

      // Récupération de la dernière date d'exécution de la tâche
      if (!$time)
      {
         $time = time();
      }

      $last_execute = (int) $ping->GetPreference('LastVerifAdherents');
      
	

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

      $adh_ops = \cms_utils::get_module('Adherents');
	$db = cmsms()->GetDb();
      if (!$time)
      {
         $time = time();
      }

      //$adh_ops = new adherents_spid;
        $mois = date('m');
	$annee = date('Y');
	if($mois >=1 && $mois <7) //2ème phase
	{
		
		$query = "SELECT licence FROM ".cms_db_prefix()."module_adherents_adherents WHERE YEAR(validation) < ?";
	}
	else //début de saison
	{
		$query = "SELECT licence FROM ".cms_db_prefix()."module_adherents_adherents WHERE YEAR(validation) <= ?";
	}
	$query.= " ORDER BY maj ASC LIMIT 5";
	$dbresult = $db->Execute($query, array($annee));
	if($dbresult && $dbresult->RecordCount() > 0)
	{

		//on instancie la classe et on va commencer à boucler
		
		$ops = new adherents_spid;
		while ($row= $dbresult->FetchRow())
		{
			$licence = $row['licence'];		
			$verif = $ops->infos_adherent_spid($licence);
			sleep(1);

		}//fin du while
		return TRUE;
	}
	else
	{
		return FALSE; // Ou false si ça plante
	}

      
      

   }

   public function on_success($time = '')
   {

      if (!$time)
      {
         $time = time();
      }
      
    $adh_ops = \cms_utils::get_module('Adherents');
      $adh_ops->SetPreference('LastVerifAdherents', $time);
      $adh_ops->Audit('','Adherents','Récup Adherents Ok');
      //$pong = cms_utils::get_module
      
   }

   public function on_failure($time = '')
   {
      $adh_ops = \cms_utils::get_module('Adherents');
	$adh_ops->Audit('','Adherents','Pas de récup ADHERENTS');
   }

}
?>