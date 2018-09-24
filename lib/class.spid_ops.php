<?php
class spid_ops
{
	function __construct() {}
	
	
	function add_spid($saison, $datemaj, $licence, $date_event,$epreuve, $nom,$classement, $victoire, $forfait)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (saison, datemaj, licence, date_event,epreuve, nom,classement, victoire, forfait) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array($saison_courante,$now, $licence, $date_event, $epreuve, $nom, $classement, $victoire, $forfait));

		if(!$dbresult)
		{
			$message = $db->ErrorMsg(); 
			$status = 'Echec';
			$designation = $message;
			$action = "mass_action";
			ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
		}
	}
}
?>