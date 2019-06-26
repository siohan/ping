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
	
	function add_competition($libelle, $indivs,$idepreuve, $tag, $idorga)
	{
		$db = cmsms()->GetDb();
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_type_competitions (name, indivs, idepreuve,tag, idorga) VALUES (?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query,array($libelle,$indivs,$idepreuve,$tag,$idorga));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function update_epreuve($epreuve, $codechamp, $coefchamp)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET coefficient = ?, code_compet = ? WHERE name LIKE ?";
		$dbresult = $db->Execute($query,array($coefchamp, $codechamp, $epreuve));
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