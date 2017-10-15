<?php
class equipes
{
   function __construct() {}

   function delete_team($record_id)
   {
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_ping_equipes WHERE id = ?"; 
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
   }
   function delete_classement ($record_id)
   {
		$db = cmsms()->GetDb();
		$query = "SELECT id, iddiv, idpoule, saison FROM ".cms_db_prefix()."module_ping_equipes WHERE id = ?";
		$result = $db->Execute($query, array($record_id));
		if($result)
		{
			//on récupère tous les renseignements nécessaires
			while($row = $result->FetchRow())
			{
				$iddiv = $row['iddiv'];
				$idpoule = $row['idpoule'];
				$saison = $row['saison'];
				$this->del_class($iddiv, $idpoule, $saison);
				$this->del_poule_rencontres($iddiv, $idpoule, $saison);
			}
			
			
		}
   }
   function del_class($iddiv,$idpoule,$saison)
   {
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_ping_classement WHERE iddiv = ? AND idpoule = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($iddiv, $idpoule, $saison));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function del_poule_rencontres($iddiv,$idpoule, $saison)
{
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE iddiv = ? AND idpoule = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($iddiv,$idpoule,$saison));
}

} // end of class

#
# EOF
#
?>
