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
  protected function __construct() {}

  public static function ecrirejournal($now,$status, $designation,$action)
  {
    $db = cmsms()->GetDb();
	
    //Now remove the article
    $query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status,designation, action) VALUES ('', ?, ?, ?, ?)";
    $db->Execute($query, array($now, $status, $designation,$action));
    
    
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

		}
	}

}

public static function unable_player($licence)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    $query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET actif ='0'  WHERE licence = ?";
    $db->Execute($query, array($licence));


  }

public static function supp_spid($record_id)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    $query = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
    $db->Execute($query, array($record_id));


  }

public static function masculin($licence)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    $query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET sexe ='M'  WHERE licence = ?";
    $db->Execute($query, array($licence));


  }

public static function feminin($licence)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    $query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET sexe ='F'  WHERE licence = ?";
    $db->Execute($query, array($licence));


  }

public static function delete_team_result($record_id)
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

public static function coeff ($typeCompetition)
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
	echo $query;
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

public static function duplicate($record_id)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT * FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	
}

public static function retrieve_sit_mens($licence)
  {
	//on vérifie si la situation mensuelle a déjà été prise en compte
	global $gCms;
	$db = cmsms()->GetDb();
	
	$mois_courant = date('n');//Mois au format 1, 2, 3 etc....
	$annee_courante = date('Y');
	$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
	$now = trim($db->DBTimeStamp(time()), "'");
	$mois_reel = $mois_courant - 1;
	$mois_sm = $mois_francais["$mois_reel"];
	$mois_sit_mens = $mois_sm." ".$annee_courante;
	
	$query = "SELECT licence, nom, prenom FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	
		//il faut instancier le service
		$service = new Service();
		$result = $service->getJoueur("$licence");
		//var_dump($result);
		
			if(!is_array($result))
			{
				//le service est coupé ou la licence est inactive
				$row= $dbresult->FetchRow();
				$nom = $row['nom'];
				$prenom = $row['prenom'];
				$message.="Licence introuvable ou service coupé pour ".$nom." ".$prenom;
				$status = 'Echec';
				$designation = $message;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
			}
			else{
				//tout va bien on peut continuer
				$licence = $result[licence];
				//	echo "la licence est $licence <br />";
				$nom = $result[nom];
				$prenom = $result[prenom];
				//echo "le deuxième appel est : ".$nom." ".$prenom. "<br />";
				$natio = $result[natio];
				$clglob = $result[clglob];
				$points = $result[point];
				$aclglob = $result[aclglob];
				$apoint = $result[apoint];
				$clnat = $result[clnat];
				$categ = $result[categ];
				$rangreg = $result[rangreg];
				$rangdep = $result[rangdep];
				$valcla = $result[valcla];
				$clpro = $result[clpro];
				$valinit = $result[valinit];
				$progmois = $result[progmois];
				$progann = $result[progann];
				
				$query = "INSERT INTO ".cms_db_prefix()."module_ping_sit_mens (id,datecreated, datemaj, mois, annee, phase, licence, nom, prenom, points, clnat, rangreg,rangdep, progmois) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				//echo $query;
				$dbresultat = $db->Execute($query,array($now,$now,$mois_courant, $annee_courante, $phase, $licence, $nom, $prenom, $points, $clnat, $rangreg, $rangdep, $progmois));

					if(!$dbresultat)
					{
						$message = $db->ErrorMsg(); 
						$status = 'Echec';
						$designation = $message;
						$action = "mass_action";
						ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
						
					}
					else {
						$status = 'Ok';
						$designation = "Situation ok pour ".$nom." ".$prenom;
						$action = 'mass_action';
						ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
						//on met la table recup à jour pour le joueur
						$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET datemaj = ? , sit_mens = ? WHERE licence = ?";
						$dbresult = $db->Execute($query, array($now, $mois_sit_mens, $licence));
					}
				
				
				//$message.="<li>La licence est ok</li>";
			}//fin du else	!is_array
	
	//pas de bol la situation mensuelle est déjà présente
	
	
	
	
   }

public static function retrieve_parties_spid( $licence )
  {
	global $gCms;
	$db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	//require_once(dirname(__FILE__).'/function.calculs.php');
	$saison_courante = $ping->GetPreference('saison_en_cours');
	$now = trim($db->DBTimeStamp(time()), "'");
	$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbretour = $db->Execute($query, array($licence));
	if ($dbretour && $dbretour->RecordCount() > 0)
	  {
	    while ($row= $dbretour->FetchRow())
	      {
		$player = $row['player'];
		$service = new Service();
		$result = $service->getJoueurPartiesSpid("$licence");
		//var_dump($result);
		//le service est-il ouvert ?
		/**/
		//on teste le resultat retourné     

			if(!is_array($result)){


				$message = "Service coupé"; 
				$status = 'Echec';
				$designation = $message;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
			}
			else{
				$i = 0;
				$compteur = 0;
				foreach($result as $cle =>$tab)
				{

					$compteur++;

					$dateevent = $tab[date];
					$chgt = explode("/",$dateevent);
					$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];

						if (substr($chgt[1], 0,1)==0){
							$mois_event = substr($chgt[1], 1,1);
							//echo "la date est".$date_event;
						}
						else
						{
							$mois_event = $chgt[1];
						}

					$nom = $tab[nom];
					$classement = $tab[classement];
					$cla = substr($classement, 0,1);

						if($cla == 'N'){
							$newclassement = explode('-', $classement);
							$newclass = $newclassement[1];
						}
						else {
							$newclass = $classement;
						}
					//on va calculer la différence entre le classement de l'adversaire et le classement du joueur du club
					$query = "SELECT points FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ?";
					$dbresult = $db->Execute($query, array($licence,$mois_event));

						if ($dbresult && $dbresult->RecordCount() == 0)
						{
							//$designation.="Ecart non calculé";
							$ecart = 0;
						}

					$row = $dbresult->FetchRow();
					$points = $row[points];
					$ecart_reel = $points - $newclass;
					
					//on calcule l'écart selon la grille de points de la FFTT
					$type_ecart = ping_admin_ops::CalculEcart($ecart_reel);
					$epreuve = $tab[epreuve];
					//echo $ecart_reel;
					// de quelle compétition s'agit-il ? 
					//On a la date et le type d'épreuve
					//on peut donc en déduire le tour via le calendrier
					//et le coefficient pour calculer les points via la table type_competitons
					
					//1 - on récupére le tour s'il existe
					//on va fdonc chercher dans la table calendrier
					$query = "SELECT numjourn FROM ".cms_db_prefix()."module_ping_calendrier WHERE date_debut = ? OR date_fin = ?";
					$resultat = $db->Execute($query, array($date_event, $date_event));

						if ($resultat && $resultat->RecordCount()>0){
							$row = $resultat->FetchRow();
							$numjourn = $row[numjourn];
						}
						else
						{
							$numjourn = 0;
						}
					
					$numjourn = 0;
					//2 - on récupère le coefficient de la compétition
					$coeff = ping_admin_ops::coeff($epreuve);
					
					
					//$pointres = $points*$coeff;
					//fin du point 2

					$victoire = $tab[victoire];

						if ($victoire =='V'){
							$victoire = 1;
						}
						else 
						{
							$victoire = 0;
						}

					//on peut désormais calculer les points 
					//echo "la victoire est : ".$victoire."<br />";
					$points1 = ping_admin_ops::CalculPointsIndivs($type_ecart, $victoire);
					//echo "le coeff est : ".$coeff."<br />";
					//echo "le type ecart est : ".$type_ecart."<br />";
					//echo "les points 1 sont : ".$points1."<br />";
					$pointres = $points1*$coeff;
					$forfait = $tab[forfait];


					$query = "SELECT licence, date_event,nom FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND date_event = ? AND nom = ?";
					//echo $query;
					$dbresult = $db->Execute($query, array($licence, $date_event,$nom));

					if($dbresult  && $dbresult->RecordCount() == 0) {
						$query = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (id, saison, datemaj, licence, date_event, epreuve, nom, numjourn,classement, victoire,ecart,type_ecart, coeff, pointres, forfait) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$i++;
						//echo $query;
						$dbresultat = $db->Execute($query,array($saison_courante,$now, $licence, $date_event, $epreuve, $nom, $numjourn, $newclass, $victoire,$ecart_reel,$type_ecart, $coeff,$pointres, $forfait));

						if(!$dbresultat)
							{
								$message = $db->ErrorMsg(); 
								$status = 'Echec';
								$designation = $message;
								$action = "mass_action";
								ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
							}


					}//fin du if recordCount() ligne 244

				}//fin du foreach

				$comptage = $i;
				$status = 'Parties SPID';
				$designation .= "Récupération spid de ".$comptage." parties sur ".$compteur."  de ".$player;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);

			}//fin du if !is_array
		}//fin du while

	}//fin du if dbretour >0









}//fin de la fonction

##
	public static function retrieve_indivs( $licence, $coefficient )
	  {
		global $gCms;
		$db = cmsms()->GetDb();
		$ping = cms_utils::get_module('Ping');
		//require_once(dirname(__FILE__).'/function.calculs.php');
		$saison_courante = $ping->GetPreference('saison_en_cours');
		$now = trim($db->DBTimeStamp(time()), "'");
		$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
		$dbretour = $db->Execute($query, array($licence));
		if ($dbretour && $dbretour->RecordCount() > 0)
		  {
		    while ($row= $dbretour->FetchRow())
		      {
			$player = $row['player'];
			$service = new Service();
			$result = $service->getJoueurPartiesSpid("$licence");
			//var_dump($result);
			//le service est-il ouvert ?
			/**/
			//on teste le resultat retourné     

				if(!is_array($result)){


					$message = "Service coupé"; 
					$status = 'Echec';
					$designation = $message;
					$action = "mass_action";
					ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
				}
				else{
					$i = 0;
					$compteur = 0;
					foreach($result as $cle =>$tab)
					{

						$compteur++;

						$dateevent = $tab[date];
						$chgt = explode("/",$dateevent);
						$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];

							if (substr($chgt[1], 0,1)==0){
								$mois_event = substr($chgt[1], 1,1);
								//echo "la date est".$date_event;
							}
							else
							{
								$mois_event = $chgt[1];
							}

						$nom = $tab[nom];
						$classement = $tab[classement];
						$cla = substr($classement, 0,1);

							if($cla == 'N'){
								$newclassement = explode('-', $classement);
								$newclass = $newclassement[1];
							}
							else {
								$newclass = $classement;
							}
						//on va calculer la différence entre le classement de l'adversaire et le classement du joueur du club
						$query = "SELECT points FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ?";
						$dbresult = $db->Execute($query, array($licence,$mois_event));

							if ($dbresult && $dbresult->RecordCount() == 0)
							{
								//$designation.="Ecart non calculé";
								$ecart = 0;
							}

						$row = $dbresult->FetchRow();
						$points = $row[points];
						$ecart_reel = $points - $newclass;

						//on calcule l'écart selon la grille de points de la FFTT
						$type_ecart = ping_admin_ops::CalculEcart($ecart_reel);
						$epreuve = $tab[epreuve];
						//echo $ecart_reel;
						// de quelle compétition s'agit-il ? 
						//On a la date et le type d'épreuve
						//on peut donc en déduire le tour via le calendrier
						//et le coefficient pour calculer les points via la table type_competitons

						//1 - on récupére le tour s'il existe
						//on va fdonc chercher dans la table calendrier
						$query = "SELECT numjourn FROM ".cms_db_prefix()."module_ping_calendrier WHERE date_debut = ? OR date_fin = ?";
						$resultat = $db->Execute($query, array($date_event, $date_event));

							if ($resultat && $resultat->RecordCount()>0){
								$row = $resultat->FetchRow();
								$numjourn = $row[numjourn];
							}
							else
							{
								$numjourn = 0;
							}

						$numjourn = 0;
						//2 - on récupère le coefficient de la compétition
						//Attention, s'il s'agit du critérium fédéral
						$coeff = ping_admin_ops::coeff($epreuve);
						if($coeff == '0' && $epreuve =='Critérium fédéral')
						{
							$coeff = $coefficient;
						}

						

						$victoire = $tab[victoire];

							if ($victoire =='V'){
								$victoire = 1;
							}
							else 
							{
								$victoire = 0;
							}

						//on peut désormais calculer les points 
						//echo "la victoire est : ".$victoire."<br />";
						$points1 = ping_admin_ops::CalculPointsIndivs($type_ecart, $victoire);
						//echo "le coeff est : ".$coeff."<br />";
						//echo "le type ecart est : ".$type_ecart."<br />";
						//echo "les points 1 sont : ".$points1."<br />";
						$pointres = $points1*$coeff;
						$forfait = $tab[forfait];


						$query = "SELECT licence, date_event,nom FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND date_event = ? AND nom = ?";
						//echo $query;
						$dbresult = $db->Execute($query, array($licence, $date_event,$nom));

						if($dbresult  && $dbresult->RecordCount() == 0) {
							$query = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (id, saison, datemaj, licence, date_event, epreuve, nom, numjourn,classement, victoire,ecart,type_ecart, coeff, pointres, forfait) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							$i++;
							//echo $query;
							$dbresultat = $db->Execute($query,array($saison_courante,$now, $licence, $date_event, $epreuve, $nom, $numjourn, $newclass, $victoire,$ecart_reel,$type_ecart, $coeff,$pointres, $forfait));

							if(!$dbresultat)
								{
									$message = $db->ErrorMsg(); 
									$status = 'Echec';
									$designation = $message;
									$action = "mass_action";
									ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
								}


						}//fin du if recordCount() ligne 244

					}//fin du foreach

					$comptage = $i;
					$status = 'Parties SPID';
					$designation .= "Récupération spid de ".$comptage." parties sur ".$compteur."  de ".$player;
					$action = "mass_action";
					ping_admin_ops::ecrirejournal($now,$status, $designation,$action);

				}//fin du if !is_array
			}//fin du while

		}//fin du if dbretour >0









	}//fin de la fonction

##

##
#   Retrieve parties FFTT

public static function retrieve_parties_fftt( $licence )
  {
	global $gCms;
	$db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	//require_once(dirname(__FILE__).'/function.calculs.php');
	$saison_courante = $ping->GetPreference('saison_en_cours');
	$now = trim($db->DBTimeStamp(time()), "'");
	$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbretour = $db->Execute($query, array($licence));
	if ($dbretour && $dbretour->RecordCount() > 0)
	  {
	    while ($row= $dbretour->FetchRow())
	      {
		$player = $row['player'];
		$service = new Service();
		$result = $service->getJoueurParties("$licence");
		//var_dump($result);
		//le service est-il ouvert ?
		/**/
		//on teste le resultat retourné     

			if(!is_array($result)){


				$message = "Service coupé"; 
				$status = 'Echec';
				$designation = $message;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
			}
			else{
				$i = 0;
				$compteur = 0;
				foreach($result as $cle =>$tab)
				{

					$compteur++;

					
					$licence = $tab[licence];
					$advlic = $tab[advlic];
					$vd = $tab[vd];

						if ($vd =='V'){
							$vd = 1;
						}
						else 
						{
							$vd = 0;
						}
					$numjourn = $tab[numjourn];
					
						if(is_array($numjourn))
						{
							$numjourn = '0';
						}
						
					$codechamp = $tab[codechamp];
					$dateevent = $tab[date];
					$chgt = explode("/",$dateevent);
					$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];
					/*
						if (substr($chgt[1], 0,1)==0)
						{
							$mois_event = substr($chgt[1], 1,1);
								//echo "la date est".$date_event;
						}
						else
						{
							$mois_event = $chgt[1];
						}
					*/	
					$advsexe = $tab[advsexe];
					$advnompre = $tab[advnompre];
					$pointres = $tab[pointres];
					$coefchamp = $tab[coefchamp];					
					$advclaof = $tab[advclaof];					
					
					$query = "SELECT licence,advlic, numjourn, codechamp, date_event, coefchamp FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND advlic = ? AND numjourn = ? AND codechamp = ? AND date_event = ? AND coefchamp = ?";
					//echo $query;
					$dbresult = $db->Execute($query, array($licence, $advlic, $numjourn, $codechamp, $date_event, $coefchamp));

					if($dbresult  && $dbresult->RecordCount() == 0) {
						$query = "INSERT INTO ".cms_db_prefix()."module_ping_parties (id, saison, licence, advlic, vd, numjourn, codechamp, date_event, advsexe, advnompre, pointres, coefchamp, advclaof) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$i++;
						//echo $query;
						$dbresultat = $db->Execute($query,array($saison_courante,$licence, $advlic, $vd, $numjourn, $codechamp, $date_event, $advsexe, $advnompre, $pointres, $coefchamp, $advclaof));

						if(!$dbresultat)
							{
								$message = $db->ErrorMsg(); 
								$status = 'Echec';
								$designation = $message;
								$action = "mass_action";
								ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
							}


					}//fin du if recordCount() ligne 244

				}//fin du foreach

				$comptage = $i;
				$status = 'Parties FFTT';
				$designation .= "Récupération FFTT de ".$comptage." parties sur ".$compteur."  de ".$player;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);

			}//fin du if !is_array
		}//fin du while

	}//fin du if dbretour >0









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

} // end of class

#
# EOF
#
?>
