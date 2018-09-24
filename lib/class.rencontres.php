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

class rencontres
{
   function __construct() {}
	//détermine si le club joue en A ou B
	function club_en_A($renc_id)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT fk_id, joueurA FROM ".cms_db_prefix()."module_ping_rencontres_parties WHERE fk_id = ? LIMIT 1";
		$dbresult = $db->Execute($query, array($renc_id));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$row = $dbresult->FetchRow();
			$joueur = $row['joueurA'];
			$joueur_club = $this->est_joueur_du_club($joueur);
			if(FALSE === $joueur_club)
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
	}
	function vicdef_per_match($renc_id,$side)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT fk_id, joueurA, scoreA, joueurB, scoreB FROM ".cms_db_prefix()."module_ping_rencontres_parties WHERE fk_id = ?";
		$dbresult = $db->Execute($query, array($renc_id));
		if($dbresult && $dbresut->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$fk_id = $row['fk_id'];
				$joueurA = $row['joueurA'];
				$scoreA = $row['scoreA'];
				$joueurB = $row['fjoueurBk_id'];
				$scoreB = $row['scoreB'];
				if($side == 'A')
				{
					
				}
				else
				{
					
				}
			
			
			
			
			}
		}
	}
	//détermine quel joueur
	function est_joueur_du_club($joueur)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT licence, CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE CONCAT_WS(' ',nom, prenom) = ?";
		//echo $query2;
		$dbresult = $db->Execute($query, array($joueur));
		if($dbresult)
		{
		
			if($dbresult->RecordCount()>0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
	
		
		}
		else
		{
			//une erreur de requete
		}
	}
	//cette fonction va chercher le dernier match (renc_id) d'une equipe à afficher (pour xibo)
	public function derniere_rencontre($libequipe,$iddiv, $idpoule)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT renc_id FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE date_event <= NOW() AND iddiv = ? AND idpoule = ? AND (equa LIKE ? OR equb LIKE ?) ORDER BY date_event DESC LIMIT 1";
		$dbresult = $db->Execute($query, array($iddiv, $idpoule, $libequipe,$libequipe ));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$row = $dbresult->FetchRow();
			$renc_id = $row['renc_id'];
			return $renc_id;
		}
		else
		{
			return FALSE;
		}
	}
	//cette fonction va chercher les équipes et le score du dernier match d'une equipe à afficher (pour xibo)
	public function rencontre_score_adversaires($renc_id)
	{
		$db = cmsms()->GetDb();
		$res = array();
		$query = "SELECT equa, equb, scorea, scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE renc_id = ?";
		$dbresult = $db->Execute($query, array($renc_id ));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$res[] = $row['equa'];
				$res[] = $row['equb'];
				$res[] = $row['scorea'];
				$res[] = $row['scoreb'];
				return $res;
				
			}
			
		}
		else
		{
			return FALSE;
		}
	}
}//end of class
?>