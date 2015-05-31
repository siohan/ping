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

class ping_admin_coeff
{
  protected function __construct() {}

  public static function coeff125($record_id)
  {
	//debug_display($params, 'Parameters');
    $db = cmsms()->GetDb();
    	$ping = cms_utils::get_module('Ping');
	require_once(dirname(__FILE__).'/function.calculs.php');
	
    //On récupère les infos de l'enregistrement
    $query = "SELECT * FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
    $dbresult = $db->Execute($query, array($record_id));

	$row = $dbresult->FetchRow();
	$victoire = $row['victoire'];
	$type_ecart = $row['type_ecart'];
	$points1 = CalculPointsIndivs($type_ecart,$victoire);
	$coeff = '1.25';
	$pointres = $points1*$coeff;
	
	

    $query = "UPDATE ".cms_db_prefix()."module_ping_parties_spid SET coeff = ?, pointres = ? WHERE id = ?";
    $dbresult = $db->Execute($query, array($coeff, $pointres, $record_id));
    
    
  }
} // end of class

#
# EOF
#
?>