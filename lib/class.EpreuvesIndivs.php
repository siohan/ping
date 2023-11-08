<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#


class EpreuvesIndivs
{
   function __construct() {}
	
	//retourne le detail d'une epreuve
	function details_epreuve($idepreuve)
	{
		$details = array();
		$db= cmsms()->GetDb();
		$query = "SELECT id, name, friendlyname, code_compet, coefficient, indivs, tag, idepreuve, idorga, actif, saison, suivi FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idepreuve = ?";
		$dbresult = $db->Execute($query, array($idepreuve));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
   			{
   				$details['id'] = $row['id'];
   				$details['name'] = $row['name'];
   				$details['friendlyname'] = $row['friendlyname'];
   				$details['code_compet'] = $row['code_compet'];
   				$details['coefficient'] = $row['coefficient'];
   				$details['indivs'] = $row['indivs'];
   				$details['tag'] = $row['tag'];
   				$details['idepreuve'] = $row['idepreuve'];
   				$details['idorga'] = $row['idorga'];
   				$details['actif'] = $row['actif'];
   				$details['saison'] = $row['saison'];
   				$details['suivi'] = $row['suivi'];   				
   			}
   			return $details;
   		}
   		else
   		{
			return false;
		}
		
	}
	
	//Le détail d'une epreuve par le nom de cette épreuve
	function details_epreuve_by_name($name, $saison)
	{
		$details = array();
		$db= cmsms()->GetDb();
		$query = "SELECT id, name, friendlyname, code_compet, coefficient, indivs, tag, idepreuve, idorga, actif, saison FROM ".cms_db_prefix()."module_ping_type_competitions WHERE name LIKE ? AND saison = ?";
		$dbresult = $db->Execute($query, array($name, $saison));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
   			{
   				$details['id'] = $row['id'];
   				$details['name'] = $row['name'];
   				$details['friendlyname'] = $row['friendlyname'];
   				$details['code_compet'] = $row['code_compet'];
   				$details['coefficient'] = $row['coefficient'];
   				$details['indivs'] = $row['indivs'];
   				$details['tag'] = $row['tag'];
   				$details['idepreuve'] = $row['idepreuve'];
   				$details['idorga'] = $row['idorga'];
   				$details['actif'] = $row['actif'];
   				$details['saison'] = $row['saison'];
   			}
   			return $details;
   		}
   		else
   		{
			return false;
		}
		
	}
	
	
	//vérifie si une compétition existe déjà avec l'id de l'épreuve
	function epreuve_exists($idepreuve)
	{
		$db= cmsms()->GetDb();
		$query = "SELECT COUNT(name) AS nb FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idepreuve = ?";
		$dbresult = $db->Execute($query, array($idepreuve));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$row = $dbresult->FetchRow();
			$nb = $row['nb'];
			if($nb >0)
			{
				return true;
			}
			else
			{
				return false;	
			}
		}
		else
		{
			return false;
		}
	}
	//vérifie si une compet existe ayant un idepreuve inférieur à celui proposé
	function epreuve_exists_by_name($libepr, $idorga, $idepreuve)
	{
		$db= cmsms()->GetDb();
		$query = "SELECT name, idepreuve, idorga FROM ".cms_db_prefix()."module_ping_type_competitions WHERE name LIKE ? AND idorga = ? AND idepreuve < ? ";
		$dbresult = $db->Execute($query, array($libepr, $idorga, $idepreuve));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$this->desactive_epreuve_id($idepreuve, $libepr, $idorga);
			}
		}
		else
		{
			return false;
		}
	}
	//détermine si une épreuve est une épreuve exclusivement féminine
	function is_feminine($idepreuve)
	{
		$db = cmsms()->getDb();
		$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idepreuve = ? AND name LIKE '%feminin%'";
		$dbresult = $db->Execute($query, array($idepreuve));
		if($dbresult)
		{
			if($dbresult->recordCount()>0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	//lors d'un ajout d'épreuve, on désactive les épreuves identiques avec un id inférieur
	function desactive_epreuve_id($idepreuve, $name, $idorga)
	{
		$db = cmsms()->getDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET actif = 0 AND suivi = 0 WHERE idepreuve < ? AND idorga = ? AND name LIKE ?";
		$dbresult = $db->Execute($query, array($idepreuve,$idorga, $name));
	}
	//ajoute une nouvelle compétition 
	function add_competition($libelle, $friendlyname, $indivs,$idepreuve, $idorga,$typepreuve, $saison, $suivi, $tag)
	{
		$db = cmsms()->GetDb();
		$query = "INSERT IGNORE INTO ".cms_db_prefix()."module_ping_type_competitions (name, friendlyname, indivs, idepreuve, idorga, typepreuve, saison, suivi, tag) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query,array($libelle, $friendlyname,$indivs,$idepreuve,$idorga,$typepreuve, $saison, $suivi, $tag));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return $db->ErrorMsg();
		}
	}
	
	function update_epreuve($epreuve,$codechamp, $coefchamp, $typepreuve, $saison)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET coefficient = ?, code_compet = ?, typepreuve = ?  WHERE name  LIKE ? AND saison = ?";
		$dbresult = $db->Execute($query,array($coefchamp, $codechamp, $typepreuve, $epreuve,$saison));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//modifie une épreuve depuis les données de l'API
	function update_epreuve_orig($idepreuve,$idorga, $libelle, $typepreuve, $tag)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET idorga = ?, name = ?, typepreuve = ?, tag = ?  WHERE idepreuve = ?";
		$dbresult = $db->Execute($query,array($idorga, $libelle, $typepreuve,$tag, $idepreuve));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function update_code($idepreuve, $libepr)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET idepreuve = ?  WHERE name LIKE ?";
		$dbresult = $db->Execute($query,array($idepreuve, $libepr));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//modifie une épreuve
	function maj_epreuve($libepr, $indivs,$idepreuve, $tag, $idorga, $saison)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET name = ?, saison = ?, tag = ?, idorga = ? WHERE idepreuve = ? ";
		$dbresult = $db->Execute($query,array($libepr, $saison,$tag, $idorga, $idepreuve));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function active_epreuve($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET actif = 1  WHERE idepreuve = ?";
		$dbresult = $db->Execute($query,array($idepreuve));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function desactive_epreuve($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET actif = 0 AND suivi = 0 WHERE idepreuve = ?";
		$dbresult = $db->Execute($query,array($idepreuve));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//supprime une épreuve
	function delete_epreuve($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_type_competitions  WHERE idepreuve = ?";
		$dbresult = $db->Execute($query,array($idepreuve));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//efface toutes les divisions d'une épreuve
	function raz_divisions($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_divisions  WHERE idepreuve = ?";
		$dbresult = $db->Execute($query,array($idepreuve));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//efface tous les tours (ou poules) d'une compétitions
	function raz_tours($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_div_tours  WHERE idepreuve = ?";
		$dbresult = $db->Execute($query,array($idepreuve));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//efface tous les classements d'une compétitions
	function raz_classements($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_div_classement  WHERE idepreuve = ?";
		$dbresult = $db->Execute($query,array($idepreuve));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	

	
	//récupère la liste des épreuves pour un dropdown
	function liste_epreuves()
	{
		$db = cmsms()->GetDb();
		$ping = \cms_utils::get_module('Ping');
		$saison = $ping->GetPreference('saison_en_cours');
		
		$query = "SELECT friendlyname, idepreuve FROM ".cms_db_prefix()."module_ping_type_competitions WHERE saison = ? ";//AND phase = ?
		$dbresult = $db->Execute($query, array($saison));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			$liste = array();
			while($row = $dbresult->FetchRow())
			{
				$liste[$row['idepreuve']] = $row['friendlyname'];
			}
			return $liste;
		}
		else
		{
			return false;
		}
	
	}
	
	//récupère la liste des épreuves par équipes pour un dropdown
	function liste_epreuves_equipes()
	{
		$db = cmsms()->GetDb();
		$ping = \cms_utils::get_module('Ping');
		$saison = $ping->GetPreference('saison_en_cours');
		
		$query = "SELECT friendlyname, idepreuve, orga FROM ".cms_db_prefix()."module_ping_type_competitions WHERE saison = ? AND indivs = 0 AND actif = 1 ";//AND phase = ?
		$dbresult = $db->Execute($query, array($saison));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			$liste = array();
			
			while($row = $dbresult->FetchRow())
			{
				
				$liste[$row['idepreuve']] = $row['friendlyname'];
			}
			return $liste;
		}
		else
		{
			return false;
		}
	
	}
	
	//récupère la liste des épreuves
	function liste_epreuves_res()
	{
		$db = cmsms()->GetDb();
		$ping = \cms_utils::get_module('Ping');
		$saison = $ping->GetPreference('saison_en_cours');
		
		$query = "SELECT name, idepreuve FROM ".cms_db_prefix()."module_ping_type_competitions WHERE saison = ? ";//AND phase = ?
		$dbresult = $db->Execute($query, array($saison));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			$liste = array();
			while($row = $dbresult->FetchRow())
			{
				$liste[] = $row['idepreuve'];
			}
			return $liste;
		}
		else
		{
			return false;
		}
	}
	//recherche une epreuve dans la saison courante à partir de son nom
	function search_epreuve($name)
	{
		$db = cmsms()->GetDb();
		$ping = \cms_utils::get_module('Ping');
		$saison_en_cours = $ping->GetPreference('saison_en_cours');
		$query = "SELECT idepreuve FROM ".cms_db_prefix()."module_ping_type_competitions WHERE name = ? AND saison = ?";
		$dbresult = $db->Execute($query, array($name, $saison_en_cours));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					$idepreuve = $row['idepreuve'];
					return $idepreuve;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	//met le suivi d'une épreuve individuelle à 1
	function suivi_ok($record_id)
	{
		$db = cmsms()->GetDb();
		
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET suivi = 1 WHERE idepreuve = ?";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					
					return true;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	//met le suivi d'une épreuve individuelle à 0
	function suivi_ko($record_id)
	{
		$db = cmsms()->GetDb();
		
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET suivi = 0 WHERE idepreuve = ?";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					
					return true;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	//calcule le nombre de joueurs du club présents dans les classements
	function nb_players_incla($idepreuve, $club)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_div_classement WHERE idepreuve = ? AND club LIKE ? ";
		$dbresult = $db->Execute($query, array($idepreuve, $club));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$nb = $row['nb'];
				return $nb;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	function nom_club()
	{
			$db = cmsms()->GetDb();
			$query = "SELECT villesalle FROM ".cms_db_prefix()."module_ping_coordonnees";
			$dbresult = $db->Execute($query);
					if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$ville = $row['villesalle'];
				return $ville;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	//compte le nb de divisions dans une épreuve
	function nb_divisions($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_divisions WHERE idepreuve = ?";
		$dbresult = $db->Execute($query, array($idepreuve));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$nb_div = $row['nb'];
				if($nb_div == 0)
				{
					return false;
				}
				else
				{
					return $nb_div;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	//compte le nb de tours (ou poules) dans une épreuve
	function nb_tours($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_div_tours WHERE idepreuve = ?";
		$dbresult = $db->Execute($query, array($idepreuve));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$nb_tours = $row['nb'];
				if($nb_tours == 0)
				{
					return false;
				}
				else
				{
					return $nb_tours;
				}
				
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	function nb_classements($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT count(DISTINCT tableau) AS nb FROM ".cms_db_prefix()."module_ping_div_classement WHERE idepreuve = ?";
		$dbresult = $db->Execute($query, array($idepreuve));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$nb_tours = $row['nb'];
				return $nb_tours;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	//vérifie si un tableau est bien présent dans la table classement
	function tableau_in_cla($idepreuve, $tableau)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_div_classement WHERE idepreuve = ? AND tableau = ?";
		$dbresult = $db->Execute($query, array($idepreuve, $tableau));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$nb_tours = $row['nb'];
				return $nb_tours;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	//récupère le nom du tableau pour affichage plus sympa en frontal
	function get_table_name($idepreuve,$iddivision)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT libelle FROM ".cms_db_prefix()."module_ping_divisions WHERE idepreuve = ? AND iddivision = ?";
		$dbresult = $db->Execute($query, array($idepreuve,$iddivision));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$libelle = $row['libelle'];
				return $libelle;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}//end of class
?>
