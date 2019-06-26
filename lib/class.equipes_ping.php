<?php
class equipes_ping
{
   function __construct() {}
//récupère tous les éléments d'une equipe de ping une équipe
   function details_equipe($record_id)
{
	$db = cmsms()->GetDb();
	$query = "SELECT id, saison, phase, numero_equipe, libequipe, libdivision, friendlyname, liendivision, idpoule, iddiv, type_compet, tag, idepreuve, calendrier FROM ".cms_db_prefix()."module_ping_equipes WHERE id = ?"; 
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		$detail = array();
		while($row = $dbresult->FetchRow())
		{
			$details['id'] = $row['id'];
			$details['saison'] = $row['saison'];
			$details['phase'] = $row['phase'];
			$details['numero_equipe'] = $row['numero_equipe'];
			$details['libequipe'] = $row['libequipe'];
			$details['libdivision'] = $row['libdivision'];
			$details['friendlyname'] = $row['friendlyname'];
			$details['liendivision'] = $row['liendivision'];
			$details['idpoule'] = $row['idpoule'];
			$details['iddiv'] = $row['iddiv'];
			$details['type_compet'] = $row['type_compet'];
			$details['idepreuve'] = $row['idepreuve'];
			$details['tag'] = $row['tag'];
			$details['calendrier'] = $row['calendrier'];
		}
		return $details;
	}
	else
	{ 
		return false;
	}
}
//ajoute une équipe
function add_team($saison, $phase, $numero_equipe,$new_equipe, $libdivision, $liendivision, $idpoule, $iddiv, $type_compet, $tag,$idepreuve, $calendrier)
{
	$db =cmsms()->GetDb();
	$query = "INSERT INTO ".cms_db_prefix()."module_ping_equipes (saison, phase,numero_equipe, libequipe, libdivision, liendivision, idpoule, iddiv, type_compet, tag, idepreuve, calendrier) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$dbresult = $db->Execute($query,array($saison, $phase, $numero_equipe,$new_equipe, $libdivision, $liendivision, $idpoule, $iddiv, $type_compet, $tag,$idepreuve, $calendrier));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
// supprime une équipe
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
