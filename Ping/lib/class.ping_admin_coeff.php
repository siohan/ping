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

  public static function changeCoeff($now,$status, $designation,$action)
  {
    $db = cmsms()->GetDb();
	
    //Now remove the article
    $query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status,designation, action) VALUES ('', ?, ?, ?, ?)";
    $db->Execute($query, array($now, $status, $designation,$action));
    
    
  }
} // end of class

#
# EOF
#
?>