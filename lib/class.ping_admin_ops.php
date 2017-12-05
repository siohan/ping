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

class ping_admin_ops
{
   function __construct() {}

  public static function ecrirejournal($now,$status, $designation,$action)
  {
    $db = cmsms()->GetDb();
	
    //Now remove the article
    $query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status,designation, action) VALUES ('', ?, ?, ?, ?)";
    $db->Execute($query, array($now, $status, $designation,$action));
    
    
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
function random_serie($car) {
$string = "";
$chaine = "ABCDEFGHIJKLMOPQRSTUVWXYZ0123456789";
srand((double)microtime()*1000000);
for($i=0; $i<$car; $i++) {
$string .= $chaine[rand()%strlen($chaine)];
}
return $string;
}
public function CalculPointsIndivs($ecart,$victoire) {


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
			return $result;
		}
	}

}


public static function supp_spid($record_id)
  {
    $db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	$saison = $ping->GetPreference('saison_en_cours');
    	//on fait la maj dans la table recup_parties, donc on récupère le N° de licence
	$query2 = "SELECT licence FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
	$dbresult2 = $db->Execute($query2,array($record_id));
	$row2 = $dbresult2->FetchRow();
	$licence2 = $row2['licence'];
    	//Now remove the entry
    	$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
    	$result = $db->Execute($query, array($record_id));
		//si la requete fonctionne on met la table recup_parties à jour
		if($result)
		{
			$query3 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET spid = spid-1 WHERE licence = ? AND saison = ?";
			$db->Execute($query3, array($licence2, $saison));
		}
    



  }


public static function compte_spid($licence)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$ping_ops = new ping_admin_ops();
	$ping = cms_utils::get_module('Ping');
	$saison = $ping->GetPreference('saison_en_cours');
	$query = "SELECT count(*) AS spid FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($licence,$saison));
	$row = $dbresult->FetchRow();
	$nb = $row['spid'];
//	$ping_ops->maj_recup_parties($licence,$nb,$table='SPID');
	

}
public static function compte_spid_errors($licence)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$mois_courant = date('m');
	$ping = cms_utils::get_module('Ping');
	$ping_ops = new ping_admin_ops();
	$saison = $ping->GetPreference('saison_en_cours');
	$query = "SELECT count(*) AS spid_errors FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND saison = ? AND MONTH(date_event) = ? AND statut = 0";
	$dbresult = $db->Execute($query, array($licence,$saison,$mois_courant));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		$row = $dbresult->FetchRow();
		$spid_errors = $row['spid_errors'];
		$nb = $spid_errors;
		$ping_ops->maj_recup_parties($licence,$nb,$table='SPID_ERRORS');
		return $spid_errors;
	}
	

}
##
public static function compte_fftt($licence)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	$ping_ops = new ping_admin_ops();
	$saison = $ping->GetPreference('saison_en_cours');
	$query = "SELECT count(*) AS fftt FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($licence,$saison));
	$row = $dbresult->FetchRow();
	$nb = $row['fftt'];
	$ping_ops->maj_recup_parties($licence,$nb,$table='FFTT');
	//return $fftt;

}
##
public static function player_exists($licence)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	if($dbresult->RecordCount()>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
	public static function maj_recup_parties($licence,$nb,$table)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		
		$aujourdhui = date('Y-m-d');
		if($table == 'SPID')
		{
			$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_spid = ?, spid = ? WHERE licence= ?";
			$dbresult = $db->Execute($query, array($aujourdhui,$nb,$licence));			
		}
		elseif($table == 'FFTT')
		{
			$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_fftt = ?, fftt = ? WHERE licence= ?";
			$dbresult = $db->Execute($query, array($aujourdhui,$nb,$licence));
		}
		elseif($table == 'SIT')
		{
			$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET sit_mens = ? WHERE licence= ?";
			$dbresult = $db->Execute($query, array($nb,$licence));
		}
		elseif($table == 'SPID_ERRORS')
		{
			$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET spid_errors = ? WHERE licence= ?";
			$dbresult = $db->Execute($query, array($nb,$licence));
		}
		
		
		

	}
##
public static function search_player_licence($name)
{
	
//end of function
}

public static function get_name($nom)
{
	
	//il faut sélectionner les uppercase et non les vides
	$explosion = explode(' ',$nom);
	$compteur = count($explosion);
	$name = array();
	$prenom = array();
	//on fait qqs traitements pour les caractères accentués
	
	
	$i =0;
	foreach ($explosion as $testcase) {
	$i++;
	//on nettoie les caractères qui posent problème
	$testcase = strtr($testcase, array(
	        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
	        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
	        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
	        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
	        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
	        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
	        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
	        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
	    ));	
	  if (ctype_upper(str_replace("'","",$testcase)) || $testcase =="-" || $testcase =="'") {
	    $name[$i] = $testcase;
		//echo "La chaîne".$i." $testcase ne contient que des majuscules.\n";
	  } else {
	   // echo "La chaîne".$i." $testcase ne contient pas que des majuscules.\n";
		$prenom[$i] = $testcase;
	  }
	}
	
	$nom_final = implode(' ',$name);
	/*
	$nom_final = strtr($nom_final, array(
	        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
	        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
	        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
	        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
	        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
	        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
	        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
	        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
	    ));
	*/
	$prenom_final = implode(' ',$prenom);
	/*
	$prenom_final = strtr($prenom_final, array(
	        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
	        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
	        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
	        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
	        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
	        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
	        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
	        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
	    ));
	*/
	$result[0] = $nom_final;
	$result[1] = $prenom_final;
	return $result;	
//end of function
}
// cette fonction recherche les points de la situation mensuelle d'un joueur du club ds la bdd

/*
public static function array_code_compet($idepreuve,$date_debut,$date_fin)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	
		$query4 = "SELECT licence FROM ".cms_db_prefix()."module_ping_participe WHERE idepreuve = ? AND date_debut BETWEEN  ? AND ?";
		$dbresultat4 = $db->Execute($query4,array($idepreuve, $date_debut,$date_fin));
	
	
	$row4 = $dbresultat4->GetRows();
	$lignes = $dbresultat4->RecordCount();
	if($lignes >0)
	{
		
	
		//echo $lignes."<br />";
		//echo $row4[1][licence];
		$lic = array();
		$i=0;

		for($i=0;$i<=$lignes;$i++)
		{
			$tab[$i] = $row4[$i]['licence'];
		
			array_push($lic,$tab[$i]);
			//$licen = array();
			//$licen = substr(implode(", ", $lic), 0, -3);
			//$licen = implode(", ", $lic);
		}
		return $lic;
	}
//end of function

}
*/
public static function delete_teamresult($record_id)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    	$query = "DELETE FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE id = ?";
	$db->Execute($query, array($record_id));


  }

public static function display_on_frontend($id)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    	$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET affiche = '1' WHERE id = ?";
	$db->Execute($query, array($id));


  }

public static function do_not_display($record_id)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    	$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET affiche = '0' WHERE id = ?";
	$db->Execute($query, array($record_id));


  }

public static function CalculEcart($ecart)
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
function tag($id,$idepreuve,$indivs,$date_debut ='',$date_fin='')
{
	
			$db  = cmsms()->GetDb();
			$tag = "{Ping action='";
			
			if($indivs =='1')
			{
				$tag.="individuelles'";
			}
			else
			{
				$tag.="par-equipes'";
			}
			$tag.=" idepreuve='$idepreuve'";
			
				if(isset($date_debut) && $date_debut !='')
				{
					$tag.= " date_debut='$date_debut'";
				}
				if(isset($date_fin) && $date_fin !='')
				{
					$tag.= " date_fin='$date_fin'";
				}
			$tag.="}";
			
			$sqlarray = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET tag = ? WHERE id = ?";
			$db->Execute($sqlarray, array($tag,$id));
			//unset($tag);
			return $tag;
		

		
	
}
function create_tag($idepreuve,$indivs,$date_debut,$date_fin)
{
	
			$db  = cmsms()->GetDb();
			$tag = "{Ping action='";
			
			if($indivs =='1')
			{
				$tag.="individuelles'";
			}
			else
			{
				$tag.="par-equipes'";
			}
			$tag.=" idepreuve='$idepreuve'";
			
				if(isset($date_debut) && $date_debut !='')
				{
					$tag.= " date_debut='$date_debut'";
				}
				if(isset($date_fin) && $date_fin !='')
				{
					$tag.= " date_fin='$date_fin'";
				}
			$tag.="}";
			
			return $tag;
		

		
	
}

function tag_equipe($record_id)
{
	
			$db  = cmsms()->GetDb();
			$tag = "{Ping action='equipe'";			
			$tag.=" record_id='$record_id'";				
			$tag.="}";
			
			return $tag;		
	
}

public function coeff ($epreuve,$senior)
{
	$db  = cmsms()->GetDb();
	$query ="SELECT coefficient FROM ".cms_db_prefix()."module_ping_type_competitions WHERE name = ?";
		$dbretour = $db->Execute($query, array($epreuve));

			if ($dbretour && $dbretour->RecordCount() > 0)
		  	{
		    		while ($row= $dbretour->FetchRow())
		      		{
					if($epreuve == 'Critérium fédéral')
					{
						if($senior == 1)
						{
							$coefficient ="1.25";

						}
						else
						{
							$coefficient = "1.00";
						}
					}
					else
					{
						$coefficient = $row['coefficient'];
					}
				}
	
			}
			else
			{
				$coefficient === FALSE;
			}
			
	
	return $coefficient;		
	
}

public function coeff_ops($record_id, $coeff)
  {
	//debug_display($params, 'Parameters');
	
	global $gCms;
    	$db = cmsms()->GetDb();
    	//$ping = cms_utils::get_module('Ping');
	//require_once(dirname(__FILE__).'/function.calculs.php');
	//echo $record_id;
	//echo $coeff;
    	//On récupère les infos de l'enregistrement
    	$query = "SELECT * FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
	//echo $query;
    	$dbresult = $db->Execute($query, array($record_id));

		
	
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			
			$victoire = $row['victoire'];
			$ecart = $row['type_ecart'];
			echo $victoire;
			echo $ecart;
			$points1 = ping_admin_ops::CalculPointsIndivs($ecart,$victoire);
			//$coeff = '1.00';
			$pointres = $points1*$coeff;
			echo $coeff;
			echo $pointres;
                
                
                
    			$query3 = "UPDATE ".cms_db_prefix()."module_ping_parties_spid SET coeff = ?, pointres = ? WHERE id = ?";
    			$dbresult2 = $db->Execute($query3, array($coeff, $pointres, $record_id));
	        
				if(!$dbresult2)
				{
					$designation = $db->ErrorMsg();
					$status = 'Echec';
					$action = 'mass_delete update recup';
					$query4 = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, status, designation, action) VALUES ('', ?, ?, ?)";
					$dbresult3 = $db->Execute($query4, array($status, $designation, $action));
				}
                
		}//fin du while
  	


  }//fin de la fonction


public static function erase_spid ( $id, $coeff_fftt, $numjourn_fftt, $points_fftt)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_ping_parties_spid SET numjourn = ?, coeff = ?, pointres = ? WHERE id = ?";
	$db->Execute($query, array($numjourn_fftt, $coeff_fftt,$pointres_fftt));
}

public static function delete_journal($journalid)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    $query = "DELETE FROM ".cms_db_prefix()."module_ping_recup WHERE id = ?";
    $db->Execute($query, array($journalid));

    
  }
function get_adv_pts($nom_reel1,$prenom_reel,$mois_event,$annee_courante)
{
	$db = cmsms()->GetDb();
	$query = "SELECT points FROM ".cms_db_prefix()."module_ping_adversaires WHERE nom = ? AND prenom = ? AND mois = ? AND annee = ?";
	//echo $query4.'<br />';
	$dbresult = $db->Execute($query, array($nom_reel1, $prenom_reel,$mois_event,$annee_courante));
	$compteur = $dbresult->RecordCount();
	//echo " Le compteur est : ".$compteur;
	
	if($dbresult && $dbresult->RecordCount()>0 && $dbresult->RecordCount() <2)//ok on a un enregistrement qui correspond
	{
		$row = $dbresult->FetchRow();
		$newclass = $row['points'];
		
		return $newclass;
	}
	else
	{
		return FALSE;
	}
		
}

function update_recup_parties ($licence)
{
	$db = cmsms()->GetDb();
	$aujourdhui = date('Y-m-d');
	$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_spid = ? WHERE licence = ?";
	$dbresult = $db->Execute($query,array($aujourdhui,$licence));
}

function code_compet($epreuve)
{
	$db = cmsms()->GetDb();
	$query = "SELECT idepreuve FROM ".cms_db_prefix()."module_ping_type_competitions WHERE name = ?";
	$dbresult = $db->Execute($query, array($epreuve));
	$row = $dbresult->FetchRow();
	$idepreuve = $row['idepreuve'];
	
	return $idepreuve;
}
function chercher_ligue($ligue)
{
	$db = cmsms()->GetDb();
	
	$query = "SELECT idorga  FROM ".cms_db_prefix()."module_ping_organismes WHERE `scope` LIKE 'L' AND SUBSTRING(code, 2,2) = ?";
	$dbresult = $db->Execute($query, array($ligue));
	$row = $dbresult->FetchRow();
	$ligue = $row['idorga'];
	return $ligue;
}
function chercher_departement($departement)
{
	$db = cmsms()->GetDb();
	
	$query = "SELECT idorga  FROM ".cms_db_prefix()."module_ping_organismes WHERE `scope` LIKE 'D' AND SUBSTRING(code, 2,2) = ?";
	$dbresult = $db->Execute($query, array($departement));
	$row = $dbresult->FetchRow();
	$departement = $row['idorga'];
	return $departement;
}
function add_joueur($actif, $licence, $nom, $prenom, $club, $nclub, $clast)
{
	$db = cmsms()->GetDb();
	$query = "INSERT INTO ".cms_db_prefix()."module_ping_joueurs (actif, licence, nom, prenom, club, nclub, clast) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$dbresult = $db->Execute($query, array($actif, $licence, $nom, $prenom, $club, $nclub, $clast));
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}
#
#
#Les situations mensuelles
#
function add_sit_mens ($licence2, $nom, $prenom, $categ, $point,$apoint,$clglob, $aclglob, $clnat, $rangreg, $rangdep, $progmoisplaces, $progmois, $progann,$valinit, $valcla, $saison)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$now = trim($db->DBTimeStamp(time()), "'");
	$mois_courant = date('m');
	$annee_courante = date('Y');
	$query = "INSERT INTO ".cms_db_prefix()."module_ping_sit_mens (datemaj, mois, annee, licence, nom, prenom, categ,points, apoint,clglob, aclglob, clnat, rangreg, rangdep, progmoisplaces, progmois, progann, valinit, valcla,saison) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	//echo $query;
	$dbresult = $db->Execute($query,array($now,$mois_courant, $annee_courante, $licence2, $nom, $prenom, $categ, $point,$apoint,$clglob, $aclglob, $clnat, $rangreg, $rangdep, $progmoisplaces, $progmois, $progann,$valinit, $valcla, $saison));

	if($dbresult)
	{
		//on met la table récup à jour aussi
		
		$nb = $mois_courant.'/'.$annee_courante;
		$table = 'SIT';
		//$ping = new ping_admin_ops();
		$maj_recup = $this->maj_recup_parties($licence2, $nb,$table);
		$status = 'Ok';
		$designation = "Situation ok pour ".$nom." ".$prenom;
		$action = 'mass_action';
		$journal = $this->ecrirejournal($now,$status, $designation,$action);
		return true;

	}
	else
	{
		return false;
	}
}
public static function get_sit_mens($licence, $mois_event, $annee_courante)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$adherents = cms_utils::get_module('adherents');
	$ping = cms_utils::get_module('Ping');
	$saison = $ping->GetPreference('saison_en_cours');
	$query = "SELECT points FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND annee = ?";
	$dbresult = $db->Execute($query, array($licence,$mois_event,$annee_courante));
	//si la situation mensuelle du joueur du club n'existe pas ?
	//alors on n'enregistre pas le résultat et on le signale
		if ($dbresult && $dbresult->RecordCount() > 0)
		{
			$row = $dbresult->FetchRow();
			$retour_sit_mens = $row['points'];
			
		}
		else
		{
			$retour_sit_mens = FALSE;
		}
	return $retour_sit_mens;
//end of function
}
public static function sit_mens($licence)
{
	global $gCms;
	$db = cmsms()->GetDb();
	//$ping = cms_utils::get_module('Ping');
	$annee_courante = date('Y');
	$saison = $this->GetPreference('saison_en_cours');
	$query = "SELECT CONCAT_WS('/',mois, annee) AS sit_mens FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND annee = ? ORDER BY mois DESC limit 1";//SELECT CONCAT_WS('/',mois, annee) AS sit_mens, DATEDIFF(NOW(),datemaj)  FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND DATEDIFF(NOW(),datemaj) IS NOT NULL ORDER BY DATEDIFF(NOW(),datemaj) ASC LIMIT 1";
	//$db->debug=true;
	$dbresult = $db->Execute($query, array($licence,$annee_courante));
	//si la situation mensuelle du joueur du club n'existe pas ?
	//alors on n'enregistre pas le résultat et on le signale
		if ($dbresult && $dbresult->RecordCount() == 0)
		{
			//$designation.="Ecart non calculé";
			$retour_sit_mens = 0;
		}
		else
		{
			$row = $dbresult->FetchRow();
			$retour_sit_mens = $row['sit_mens'];
		}
	return $retour_sit_mens;
//end of function
}
public static function name($licence)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT CONCAT_WS(' ',nom, prenom) AS joueur FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";//SELECT CONCAT_WS('/',mois, annee) AS sit_mens, DATEDIFF(NOW(),datemaj)  FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND DATEDIFF(NOW(),datemaj) IS NOT NULL ORDER BY DATEDIFF(NOW(),datemaj) ASC LIMIT 1";
	//$db->debug=true;
	$dbresult = $db->Execute($query, array($licence));
	//si la situation mensuelle du joueur du club n'existe pas ?
	//alors on n'enregistre pas le résultat et on le signale
		if ($dbresult && $dbresult->RecordCount() == 0)
		{
			//$designation.="Ecart non calculé";
			$joueur = false;
		}
		else
		{
			$row = $dbresult->FetchRow();
			$joueur = $row['joueur'];
		}
	return $joueur;
}
public static function nb_participants($idepreuve, $saison)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$nb = 0;
	$query = "SELECT count(*) AS participants FROM ".cms_db_prefix()."module_ping_participe WHERE idepreuve = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($idepreuve, $saison));
	if($dbresult)
	{
		$row = $dbresult->FetchRow();
		$nb = $row['participants'];
		
	}
	return $nb;
}
public static function nb_participants_tableau($idepreuve,$idorga, $tour,$saison, $iddivision, $tableau)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$nb = 0;
	$query = "SELECT count(*) AS participants FROM ".cms_db_prefix()."module_ping_participe_tours WHERE idepreuve = ? AND iddivision = ? AND idorga = ? AND tour = ? AND  saison = ?";
	$dbresult = $db->Execute($query, array($idepreuve,$iddivision,$idorga, $tour, $saison));
	if($dbresult)
	{
		$row = $dbresult->FetchRow();
		$nb = $row['participants'];
		
	}
	return $nb;
}
public static function nom_division($idepreuve,$iddivision,$saison)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT libelle FROM ".cms_db_prefix()."module_ping_divisions WHERE iddivision = ? AND idepreuve = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($iddivision,$idepreuve, $saison));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		$row = $dbresult->FetchRow();
		$libelle = $row['libelle'];
	}
	return $libelle;
	
}
	function tableau($idepreuve, $iddivision, $tour)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$ping = cms_utils::get_module('Ping');
		$saison = $ping->GetPreference('saison_en_cours');
		$query = "SELECT tableau FROM ".cms_db_prefix()."module_ping_div_tours WHERE idepreuve = ? AND iddivision = ? AND tour = ? AND saison = ?";
		$dbresult = $db->Execute($query, array($idepreuve, $iddivision, $tour, $saison));
		if($dbresult)
		{
			$row = $dbresult->FetchRow();
			$tableau = $row['tableau'];
			return $tableau;
		}
	}
	function is_classement_uploaded($idepreuve,$iddivision,$tableau,$tour )
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$ping = cms_utils::get_module('Ping');
		$saison = $ping->GetPreference('saison_en_cours');
		$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_div_classement WHERE idepreuve = ? AND iddivision = ? AND tableau = ? AND tour = ? AND saison = ?";
		$dbresult = $db->Execute($query, array($idepreuve, $iddivision, $tableau, $tour, $saison));
		if($dbresult)
		{
			$row = $dbresult->FetchRow();
			$nb = $row['nb'];
			if($nb > 0)
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
	
	function has_affectations($idepreuve,$licence)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$ping = cms_utils::get_module('Ping');
		$saison = $ping->GetPreference('saison_en_cours');
		$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_participe_tours WHERE idepreuve = ? AND licence = ? AND saison = ?";
		$dbresult = $db->Execute($query, array($idepreuve, $licence, $saison));
		if($dbresult)
		{
			$row = $dbresult->FetchRow();
			$nb = $row['nb'];
			if($nb > 0)
			{
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
	public static function nom_compet($idepreuve)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "SELECT name FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idepreuve = ?";
		$dbresult = $db->Execute($query, array($idepreuve));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$row = $dbresult->FetchRow();
			$libelle = $row['name'];
		}
		return $libelle;

	}
	
} // end of class

#
# EOF
#
?>
