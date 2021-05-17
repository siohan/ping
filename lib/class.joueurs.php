<?php
class Joueurs
{
   function __construct() {}

function details_joueur($licence)
{
	$db = cmsms()->GetDb();
	$query = "SELECT id, actif, licence, nom, prenom, club,nclub, sexe, type, certif, validation, cat, clast FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	$details = array();
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->fetchRow())
		{
			$details['id'] = $row['id'];
			$details['actif'] = $row['actif'];
			$details['licence'] = $row['licence'];
			$details['nom'] = $row['nom'];
			$details['prenom'] = $row['prenom'];
			$details['club'] = $row['club'];
			$details['nclub'] = $row['nclub'];
			$details['sexe'] = $row['sexe'];
			$details['type'] = $row['type'];
			$details['certif'] = $row['certif'];
			$details['validation'] = $row['validation'];
			//$details['echelon'] = $row['echelon'];
		//	$details['place'] = $row['place'];
		//	$details['points'] = $row['points'];
			$details['cat'] = $row['cat'];
		//	$details['maj'] = $row['maj'];
			$details['clast'] = $row['clast'];
			
		}
		return $details;
	}
}
function add_joueur($licence,$nom, $prenom,$actif, $sexe, $type, $certif, $validation, $cat, $clast)
{
	$db = cmsms()->GetDb();
	$query = "INSERT IGNORE  INTO ".cms_db_prefix()."module_ping_joueurs (licence, nom, prenom,actif, sexe, type, certif, validation, cat, clast) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";// ON DUPLICATE KEY UPDATE 
	$dbresult = $db->Execute($query,array($licence,$nom, $prenom,$actif, $sexe, $type, $certif, $validation, $cat, $clast));

	if($dbresult)
	{
		return true;
	}
	else
	{
		$query2 = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET type = ?, certif = ?, validation = ?, cat = ?, clast = ? WHERE licence = ? ";
		$dbresult2 = $db->Execute($query2, array($type, $certif, $validation, $cat, $clast, $licence));
		if($dbresult2)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
function activate($licence)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET actif = 1 WHERE licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function desactivate($licence)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET actif = 0 WHERE licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}

}
# end of class
?>