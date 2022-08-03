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
#$Id: News.module.php 2114 2005-11-04 21:51:13Z wishy $

class EpreuvesIndivs
{
   function __construct() {}
	
	//vérifie si une compétition existe déjà
	function epreuve_exists($code_compet)
	{
		$db= cmsms()->GetDb();
		$query = "SELECT COUNT(name) AS nb FROM ".cms_db_prefix()."module_ping_type_competitions WHERE code_compet = ?";
		$dbresult = $db->Execute($query, array($code_compet));
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
	//vérifie si une compet existe par le nom
	function epreuve_exists_by_name($libepr)
	{
		$db= cmsms()->GetDb();
		$query = "SELECT COUNT(name) AS nb FROM ".cms_db_prefix()."module_ping_type_competitions WHERE name LIKE ?";
		$dbresult = $db->Execute($query, array($libepr));
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
	//ajoute une nouvelle compétition
	function add_competition($libelle, $indivs,$idepreuve, $tag, $idorga, $saison)
	{
		$db = cmsms()->GetDb();
		$query = "INSERT IGNORE INTO ".cms_db_prefix()."module_ping_type_competitions (name, indivs, idepreuve,tag, idorga, saison) VALUES (?, ?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query,array($libelle,$indivs,$idepreuve,$tag,$idorga, $saison));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function update_epreuve($codechamp, $coefchamp)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET coefficient = ?  WHERE code_compet LIKE ?";
		$dbresult = $db->Execute($query,array($coefchamp, $codechamp));
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
	
	function desactive_epreuve($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET actif = 0  WHERE idepreuve = ?";
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


}//end of class
?>
