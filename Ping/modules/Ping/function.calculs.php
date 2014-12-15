<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Skeleton (c) 2008 
#      by Robert Allen (akrabat) and
#         Robert Campbell (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow displaying calendars,
#  and management and display of time based events.
# 
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin 
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE
if( !isset($gCms) ) exit;

function CalculEcart($ecart)
{
	if($ecart >=0 && $ecart < 25) { $ecart = 1; return $ecart; }
	elseif($ecart >=25 && $ecart < 50){ $ecart = 2; return $ecart; }
	elseif($ecart >=50 && $ecart < 100){ $ecart = 3; return $ecart; }
	elseif($ecart >=100 && $ecart < 150){ $ecart = 4; return $ecart; }
	elseif($ecart >=150 && $ecart < 200){ $ecart = 5; return $ecart; }
	elseif($ecart >=200 && $ecart < 300){ $ecart = 6; return $ecart; }
	elseif($ecart >=300 && $ecart < 400){ $ecart = 7; return $ecart; }
	elseif($ecart >=400 && $ecart < 500){ $ecart = 8; return $ecart; }
	elseif($ecart >=500){ $ecart = 9; return $ecart; }
		
	elseif($ecart > -25 && $ecart < 0){$ecart = -1; return $ecart; }
	elseif($ecart <= -25 && $ecart > -50){$ecart = -2; return $ecart; }
	elseif($ecart <= -50 && $ecart > -100){$ecart = -3; return $ecart; }
	elseif($ecart <= -100 && $ecart > -150){$ecart = -4; return $ecart; }
	elseif($ecart <= -150 && $ecart > -200){$ecart = -5; return $ecart; }
	elseif($ecart <= -200 && $ecart > -300){$ecart = -6; return $ecart; }
	elseif($ecart <= -300 && $ecart > -400){$ecart = -7; return $ecart; }
	elseif($ecart <= -400 && $ecart > -500){$ecart = -8; return $ecart; }
	elseif($ecart <= -500){$ecart = -9; return $ecart; }
}

function CalculPoints($ecart,$victoire,$locaux) {
$gCms = cmsms();	
if($locaux=='A') {
	
	if($ecart ==1)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			$result[0] = 6;
		        //$result[0] = GetPreference('vicNorm0_24');
			$result[1] = 1;
			
			return $result;
			 
		}
		else
		{
			$result = array();
			//$result[0] = GetPreference('defAnorm0_24');
			$result[0] = -5;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==2)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			//$result[0] = GetPreference('vicNorm25_49');
			$result[0] = 5.5;
			$result[1] = 1;
			
			return $result;
			
		}
		else
		{
			$result = array();
			//$result[0] = GetPreference('defAnorm25_49');
			$result[0] = -6;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==3)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			//$result[0] = GetPreference('vicNorm50_99');
			$result[0] = 5;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			//$result[0] = GetPreference('defAnorm50_99');
			$result[0] = -7;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==4)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
		//	$result[0] = GetPreference('vicNorm100_149');
			$result[0] = 4;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			//$result[0] = GetPreference('defAnorm100_149');
			$result[0] = -8;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==5)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			//$result[0] = GetPreference('vicNorm150_199');
			$result[0] = 3;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			//$result[0] = GetPreference('defAnorm150_199');
			$result[0] = -10;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==6)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			//$result[0] = GetPreference('vicNorm200_299');
			$result[0] = 2;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			//$result[0] = GetPreference('defAnorm200_299');
			$result[0] = -12.5;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==7)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			//$result[0] = GetPreference('vicNorm300_399');
			$result[0] = 1;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			//$result[0] = GetPreference('defAnorm300_399');
			$result[0] = -16;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==8)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			//$result[0] = GetPreference('vicNorm400_499');
			$result[0] = 0.5;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			//$result[0] = GetPreference('defAnorm400_499');
			$result[0] = -20;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==9)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			//$result[0] = GetPreference('vicNormPlus500');
			$result[0] = 0;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			//$result[0] = GetPreference('defAnormPlus500');
			$result[0] = -29;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==-1)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			$result[0] = 6;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			$result[0] = -5;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==-2)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			$result[0] = 7;
			$result[1] = 1;
			
			return $result;
			
		}
		else
		{
			$result = array();
			$result[0] = -4.5;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==-3)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			$result[0] = 8;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			$result[0] = -4;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==-4)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			$result[0] = 10;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			$result[0] = -3;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==-5)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			$result[0] = 13;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			$result[0] = -2;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==-6)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			$result[0] = 17;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			$result[0] = -1;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==-7)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			$result[0] = 22;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			$result[0] = -0.5;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==-8)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			$result[0] = 28;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			$result[0] = 0;
			$result[1] = 0;
			
			return $result;
		}
	}
	elseif($ecart ==-9)
	{
		if($victoire == 'ABCD')
		{
			$result = array();
			$result[0] = 40;
			$result[1] = 1;
			
			return $result;
		}
		else
		{
			$result = array();
			$result[0] = 0;
			$result[1] = 0;
		}
	}
}
elseif($locaux=='B'){
	if($ecart ==1)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 6;
		$result[1] = 1;
		
		return $result;
		 
	}
	else
	{
		$result = array();
		$result[0] = -5;
		$result[1] = 1;
		
		return $result;
	}
}
elseif($ecart ==2)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 5.5;
		$result[1] = 1;
		
		return $result;
		
	}
	else
	{
		$result = array();
		$result[0] = -6;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==3)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 5;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = -7;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==4)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 4;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = -8;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==5)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 3;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = -10;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==6)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 2;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = -12.5;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==7)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 1;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = -16;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==8)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 0.5;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = -20;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==9)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 0;
		$result[1] = 1;
		
		return $result;
		
	}
	else
	{
		$result = array();
		$result[0] = -29;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==-1)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 6;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = -5;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==-2)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 7;
		$result[1] = 1;
		
		return $result;
		
	}
	else
	{
		$result = array();
		$result[0] = -4.5;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==-3)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 8;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = -4;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==-4)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 10;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = -3;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==-5)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 13;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = -2;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==-6)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 17;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = -1;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==-7)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 22;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = -0.5;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==-8)
{
	if($victoire == 'WXYZ')
	{
		$result = array();
		$result[0] = 28;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = 0;
		$result[1] = 0;
		
		return $result;
	}
}
elseif($ecart ==-9)
{
	if($victoire == 'WXYZw')
	{
		$result = array();
		$result[0] = 40;
		$result[1] = 1;
		
		return $result;
	}
	else
	{
		$result = array();
		$result[0] = 0;
		$result[1] = 0;
		
		return $result;
	}
}
	
}
}	



function CalculPointsIndivs($ecart,$victoire) {

	
		if($ecart ==1)
	{
		if( $victoire == 1)
		{
			
			$result = 6;		
			return $result;
			 
		}
		else
		{
			
			$result = -5;
			
			
			return $result;
		}
	}
	elseif($ecart ==2)
	{
		if( $victoire ==1)
		{
			
			$result = 5.5;
			
			
			return $result;
			
		}
		else
		{
			
			$result = -6;
			
			
			return $result;
		}
	}
	elseif($ecart ==3)
	{
		if($victoire ==1)
		{
			
			$result = 5;			
			return $result;
		}
		else
		{
			
			$result = -7;			
			return $result;
		}
	}
	elseif($ecart ==4)
	{
		if( $victoire ==1)
		{
			
			$result = 4;
			
			
			return $result;
		}
		else
		{
			
			$result = -8;
			
			
			return $result;
		}
	}
	elseif($ecart ==5)
	{
		if( $victoire ==1)
		{
			
			$result = 3;
			
			
			return $result;
		}
		else
		{
			
			$result = -10;
			
			
			return $result;
		}
	}
	elseif($ecart ==6)
	{
		if( $victoire ==1)
		{
			
			$result = 2;
			
			
			return $result;
		}
		else
		{
			
			$result = -12.5;
			
			
			return $result;
		}
	}
	elseif($ecart ==7)
	{
		if( $victoire ==1)
		{
			
			$result = 1;			
			return $result;
		}
		else
		{
			
			$result = -16;			
			return $result;
		}
	}
	elseif($ecart ==8)
	{
		if( $victoire ==1)
		{
			
			$result = 0.5;			
			return $result;
		}
		else
		{
			
			$result = -20;			
			return $result;
		}
	}
	elseif($ecart ==9)
	{
		if( $victoire ==1)
		{
			
			$result = 0;			
			return $result;
		}
		else
		{
			
			$result = -29;		
			return $result;
		}
	}
	elseif($ecart ==-1)
	{
		if( $victoire ==1)
		{
			
			$result = 6;			
			return $result;
		}
		else
		{
			
			$result = -5;			
			return $result;
		}
	}
	elseif($ecart==-2)
	{
		if( $victoire ==1)
		{
			
			$result = 7;			
			return $result;
			
		}
		else
		{
			
			$result = -4.5;		
			return $result;
		}
	}
	elseif($ecart ==-3)
	{
		if( $victoire ==1)
		{
			
			$result = 8;			
			return $result;
		}
		else
		{
			
			$result = -4;
			
			
			return $result;
		}
	}
	elseif($ecart ==-4)
	{
		if( $victoire ==1)
		{
			
			$result = 10;			
			return $result;
		}
		else
		{
			
			$result = -3;			
			return $result;
		}
	}
	elseif($ecart ==-5)
	{
		if( $victoire ==1)
		{
			
			$result = 13;			
			return $result;
		}
		else
		{
			
			$result = -2;			
			return $result;
		}
	}
	elseif($ecart ==-6)
	{
		if( $victoire ==1)
		{
			
			$result = 17;			
			return $result;
		}
		else
		{
			
			$result = -1;			
			return $result;
		}
	}
	elseif($ecart ==-7)
	{
		if( $victoire ==1)
		{
			
			$result = 22;			
			return $result;
		}
		else
		{
			
			$result = -0.5;			
			return $result;
		}
	}
	elseif($ecart ==-8)
	{
		if( $victoire ==1)
		{
			
			$result = 28;			
			return $result;
		}
		else
		{
			
			$result = 0;			
			return $result;
		}
	}
	elseif($ecart ==-9)
	{
		if( $victoire ==1)
		{
			
			$result = 40;			
			return $result;
		}
		else
		{
			
			$result = 0;
			
		}
	}

}
function playerExists ($username,$pts){
	 $db  = cmsms()->GetDb();
	$query = 'SELECT * FROM '.cms_db_prefix().
	'module_ping_joueurs WHERE username = ?';
	$dbresult = $db->Execute($query,array( $username ));
	
	//1ere condition : pas de correspondance : le joueur n'existe pas : on l'insère 
	if($dbresult  && $dbresult->RecordCount() == 0) {
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_joueurs (id, username, pts) VALUES ('', ?, ?)";
		$dbresultat = $db->Execute($query,array($username,$pts));
	}
	/* Le joueur existe déjà */
	/* on va vérifier si le nombre de points correspond ou pas */
	if($dbresult && $dbresult->RecordCount() > 0) {
		$query = "SELECT * FROM ".cms_db_prefix()."module_ping_joueurs WHERE username = ? AND pts =?";
		$dbretour = $db->Execute($query, array($username,$pts));
	/* Le joueur existe et les points correspondent on ne fait rien*/	
		if($dbretour && $dbretour->RecordCount() > 0){
			}
			else{
				$query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET pts = ? WHERE username = ?";
				$result2 = $db->Execute($query, array($pts, $username));
			}
			// inscription ds la table des classements 
			$mois_courant = date("n");
			$saison = '2013-2014';
		//	$query = "INSERT INTO ".cms_db_prefix()."module_ping_clts (id, username, pts, mois,saison) VALUES ('',?,?,?,?)";
		//	$result3 = $db->Execute($query, array($username,$pts,$mois_courant, $saison));
		}
	}


function compet ($competition){
	$db  = cmsms()->GetDb();
$query ="SELECT coefficient FROM ".cms_db_prefix()."module_ping_competitions WHERE code_compet = ?";
$dbretour = $db->Execute($query, array($competition));
if ($dbretour && $dbretour->RecordCount() > 0)
  {
    while ($row= $dbretour->FetchRow())
      {
	$coeff = $row['coefficient'];
	return $coeff;
	}
	
}
}

function CherchePts ($joueur){
	$db  = cmsms()->GetDb();
	$query = "SELECT pts FROM ".cms_db_prefix()."module_ping_joueurs WHERE username = ?";	
	$dbretour = $db->Execute($query, array($joueur));
	if ($dbretour && $dbretour->RecordCount() > 0)
  		{
    			while ($row= $dbretour->FetchRow())
      			{
				$pts = $row['pts'];
				return $pts;
			}
	
		}
}

function nbjoueurs ($competition){
	$db  = cmsms()->GetDb();
$query ="SELECT joueurs, parties FROM ".cms_db_prefix()."module_ping_competitions WHERE code_compet = ?";
$dbretour = $db->Execute($query, array($competition));
if ($dbretour && $dbretour->RecordCount() > 0)
  {
    while ($row= $dbretour->FetchRow())
      {
	$result[] = $row['joueurs'];
	$result[] = $row['parties'];
	return $result;
	
	}
	
}
}

function dropdown ($competition){
	$db  = cmsms()->GetDb();
$query ="SELECT joueurs FROM ".cms_db_prefix()."module_ping_competitions WHERE code_compet = ?";
$dbretour = $db->Execute($query, array($competition));
if ($dbretour && $dbretour->RecordCount() > 0)
  {
    while ($row= $dbretour->FetchRow())
      {
	$joueurs = $row['joueurs'];
	return $joueurs;
	}
	
}
}

function random($car) {
$string = "";
$chaine = "abcdefghijklmnpqrstuvwxy";
srand((double)microtime()*1000000);
for($i=0; $i<$car; $i++) {
$string .= $chaine[rand()%strlen($chaine)];
}
return $string;
}

function coeff ($typeCompetition)
{
	$db  = cmsms()->GetDb();
	/*
	if(substr_count($typeCompetition,'-')>0)
	{
		$type_inter = explode('-',$typeCompetition,2);
		$type = $type_inter[0];
	}
	*/
		//	$type = $typeCompetition;
	

$query ="SELECT coefficient FROM ".cms_db_prefix()."module_ping_type_competitions WHERE name = ?";
$dbretour = $db->Execute($query, array($typeCompetition));

	if ($dbretour && $dbretour->RecordCount() > 0)
  	{
    		while ($row= $dbretour->FetchRow())
      		{
			$coeff = $row['coefficient'];
			return $coeff;
		}
	
	}
	else
	{
		$coeff = 0;
		return $coeff;
		//echo "coefficient introuvable !";
	}
}

function coeff_old ($cle){
	$db  = cmsms()->GetDb();
$query ="SELECT coefficient FROM ".cms_db_prefix()."module_ping_competitions AS comp, ".cms_db_prefix()."module_ping_rencontres AS ren WHERE comp.code_compet = ren.type_compet AND ren.cle =  ?";
$dbretour = $db->Execute($query, array($cle));
if ($dbretour && $dbretour->RecordCount() > 0)
  {
    while ($row= $dbretour->FetchRow())
      {
	$coeff = $row['coefficient'];
	return $coeff;
	}
	
}
else{
	echo "coefficient introuvable !";
}		
function dateversfr ($date){	   
	$datearr = explode('/', $date);
	$datefr = $datearr[2] . '-' . $datearr[1] . '-' . $datearr[0];
	return $datefr;
	}
}
function mois_francais($mois,$longueur){
	if(!isset($longueur) || $longueur ==''){
		$months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "juillet", "Aout", "Septembre", "Octobre", "Novembre", "décembre");
	}
	else
	{
		$months = array("Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "juil", "Aou", "Sep", "Oct", "Nov", "déc");
	}
	$month_to_display = $mois-1;
	$month_francais = $months["$month_to_display"];
	return $month_francais;
}



?>