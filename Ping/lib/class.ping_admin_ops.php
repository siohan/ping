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

public static function unable_player($licence)
  {
    $db = cmsms()->GetDb();

    //Now remove the entry
    $query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET actif ='0'  WHERE licence = ?";
    $db->Execute($query, array($licence));


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
		$result = $service->getJoueur("$licence2");
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
					}
				
				
				//$message.="<li>La licence est ok</li>";
			}//fin du else	!is_array
	
	//pas de bol la situation mensuelle est déjà présente
	
	
	
	
}

public static function retrieve_parties_spid($licence)
  {
	$db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	require_once(dirname(__FILE__).'/function.calculs.php');
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
					$type_ecart = CalculEcart($ecart_reel);
					$epreuve = $tab[epreuve];
					
					// de quelle compétition s'agit-il ? 
					//On a la date et le type d'épreuve
					//on peut donc en déduire le tour via le calendrier
					//et le coefficient pour calculer les points via la table type_competitons

					//1 - on récupére le tour s'il existe
					//on va fdonc chercher dans la table calendrier
					$query = "SELECT numjourn FROM ".cms_db_prefix()."module_ping_calendrier WHERE name_compet =? AND date_compet = ?";
					$resultat = $db->Execute($query, array($epreuve, $date_event));

						if ($resultat && $resultat->RecordCount()>0){
							$row = $resultat->FetchRow();
							$numjourn = $row[numjourn];
						}
						else
						{
							$numjourn = 0;
						}

					//2 - on récupère le coefficient de la compétition
					$coeff = coeff($epreuve);

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
					echo "la victoire est : ".$victoire."<br />";
					$points1 = CalculPointsIndivs($type_ecart, $victoire);
					echo "le coeff est : ".$coeff."<br />";
					echo "le type ecart est : ".$type_ecart."<br />";
					echo "les points 1 sont : ".$points1."<br />";
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
