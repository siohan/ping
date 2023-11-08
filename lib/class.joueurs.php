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
			//$details['place'] = $row['place'];
			//$details['points'] = $row['points'];
			$details['cat'] = $row['cat'];
			//$details['maj'] = $row['maj'];
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

function next($nom, $prenom)
{
	$db = cmsms()->GetDb();
	$query = "SELECT licence, nom, prenom FROM ".cms_db_prefix()."module_ping_joueurs WHERE nom > ?  AND actif = '1' OR( nom >= ? AND prenom > ?) ORDER BY nom, prenom ASC LIMIT 1";//
	$dbresult = $db->Execute($query, array($nom, $nom,$prenom));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		$row = $dbresult->FetchRow();
		$licence = $row['licence'];
		return $licence;
	}
	else
	{
		return false;
	}
}
		function previous($nom, $prenom)
		{
			$db = cmsms()->GetDb();
			$query = "SELECT licence, nom, prenom FROM ".cms_db_prefix()."module_ping_joueurs WHERE nom < ?  AND actif = '1' OR(nom <= ? AND prenom < ?) ORDER BY nom DESC, prenom DESC LIMIT 1";//
			$dbresult = $db->Execute($query, array($nom, $nom,$prenom));
			if($dbresult && $dbresult->RecordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$licence = $row['licence'];
				return $licence;
			}
			else
			{
				return false;
			}
		}
		//pour récupérer la photo d'un joueur
		function get_picture($licence)
		{
			$ping = cms_utils::get_module('Ping');
			$ext = explode(',', $ping->GetPreference('allowed_extensions'));
			$separator = ".";
			foreach ($ext AS $value)
			{
			
				$img = $config['root_url']."/uploads/images/trombines/".$licence.$separator.$value;
				if (false!=file($img))
				{
					$photo = $config['root_url']."/uploads/images/trombines/".$licence.$separator.$value;
					return $photo;
				}
				else
				{
					return false;
				}
				
			}
			
		}
		//compte les victoires spid d'un joueur
		function victoires ($record_id, $saison)
		{
			$db = cmsms()->GetDb();
			$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND victoire = 1 AND saison = ?";
			$dbresult = $db->Execute($query, array($record_id, $saison));
			if($dbresult && $dbresult->RecordCount() >0)
			{
				$row = $dbresult->fetchRow();
				$victoires = $row['nb'];
				return $victoires;
			}
			else
			{
				return false;
			}
		}
		
		//compte le nb de parties disputées (spid)
		function parties_disputees ($record_id, $saison)
		{
			$db = cmsms()->GetDb();
			$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ?  AND saison = ?";
			$dbresult = $db->Execute($query, array($record_id, $saison));
			if($dbresult && $dbresult->RecordCount() >0)
			{
				$row = $dbresult->fetchRow();
				$parties_disputees = $row['nb'];
				return $parties_disputees;
			}
			else
			{
				return false;
			}
		}
		
		function victoires_normales($record_id, $saison)
		{
			$db = cmsms()->GetDb();
			$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ?  AND saison = ? AND ecart >= 0 AND victoire = 1";
			$dbresult = $db->Execute($query, array($record_id, $saison));
			if($dbresult && $dbresult->RecordCount() >0)
			{
				$row = $dbresult->fetchRow();
				$parties_disputees = $row['nb'];
				return $parties_disputees;
			}
			else
			{
				return false;
			}
		}
		
		function victoires_anormales($record_id, $saison)
		{
			$db = cmsms()->GetDb();
			$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ?  AND saison = ? AND ecart <= 0 AND victoire = 1";
			$dbresult = $db->Execute($query, array($record_id, $saison));
			if($dbresult && $dbresult->RecordCount() >0)
			{
				$row = $dbresult->fetchRow();
				$parties_disputees = $row['nb'];
				return $parties_disputees;
			}
			else
			{
				return false;
			}
		}
		
		function defaites_anormales($record_id, $saison)
		{
			$db = cmsms()->GetDb();
			$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ?  AND saison = ? AND ecart >= 0 AND victoire = 0";
			$dbresult = $db->Execute($query, array($record_id, $saison));
			if($dbresult && $dbresult->RecordCount() >0)
			{
				$row = $dbresult->fetchRow();
				$parties_disputees = $row['nb'];
				return $parties_disputees;
			}
			else
			{
				return false;
			}
		}
		
		function defaites_normales($record_id, $saison)
		{
			$db = cmsms()->GetDb();
			$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ?  AND saison = ? AND ecart <= 0 AND victoire = 0";
			$dbresult = $db->Execute($query, array($record_id, $saison));
			if($dbresult && $dbresult->RecordCount() >0)
			{
				$row = $dbresult->fetchRow();
				$parties_disputees = $row['nb'];
				return $parties_disputees;
			}
			else
			{
				return false;
			}
		}
		
		function meilleure_perf($record_id, $saison)
		{
			$db = cmsms()->GetDb();
			$query = "SELECT nom, classement, ecart, pointres FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ?  AND saison = ? ORDER BY pointres DESC LIMIT 1";
			$dbresult = $db->Execute($query, array($record_id, $saison));
			if($dbresult && $dbresult->RecordCount() >0)
			{
				//$data_array = array();
				while($row = $dbresult->fetchRow())
				{
					$data_array = $row['nom'].'_'.$row['classement'].'_'.$row['ecart'].'_'.$row['pointres'];
				}
				return $data_array;
			}
			else
			{
				return false;
			}
		}
		
		function spid_calcul($licence, $saison, $mois)
		{
			$db = cmsms()->GetDb();
			$query = "SELECT SUM(pointres) AS pts FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND saison = ? AND MONTH(date_event) = ?";
		$dbresult = $db->Execute($query, array($licence, $saison,$mois));

			if($dbresult && $dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					
					return $row['pts'];
					
				}
				
			}
			else
			{
				return false;
			}
		}
		
		function fftt_calcul($licence,$saison)
		{
			$db = cmsms()->GetDb();
			$query = "SELECT SUM(pointres) AS pts FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND saison = ? ";
		$dbresult = $db->Execute($query, array($licence, $saison));

			if($dbresult && $dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					
					return $row['pts'];
					
				}
				
			}
			else
			{
				return false;
			}
		}
}
# end of class
?>
