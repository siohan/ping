<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class retrieve_ops
{
  function __construct() {}


public function retrieve_parties_spid( $licence )
  {
	global $gCms;
	$db = cmsms()->GetDb();
	//echo "cool !";
	$ping = cms_utils::get_module('Ping');
	//require_once(dirname(__FILE__).'/function.calculs.php');
	//echo "glop2";
	$saison_courante = $ping->GetPreference('saison_en_cours');
	$now = trim($db->DBTimeStamp(time()), "'");
	$aujourdhui = date('Y-m-d');
	$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbretour = $db->Execute($query, array($licence));
	if ($dbretour && $dbretour->RecordCount() > 0)
	{
	    while ($row= $dbretour->FetchRow())
		{
		$player = $row['player'];
		$service = new Servicen();
		$page = "xml_partie";
		$var = "numlic=".$licence;
		$lien = $service->GetLink($page, $var);
		//echo "<a href=".$lien.">".$lien."</a>";
		$xml   = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		
		if($xml === FALSE)
		{
			//echo "le tableau renvoit une erreur";
			$array = 0;
			$lignes = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['resultat']);
			//echo "le nb de lignes est  :".$lignes;
		}

		//on compte le nb de résultats du spid présent ds la bdd pour le joueur
		$spid = ping_admin_ops::compte_spid($licence);
		//echo $spid." lignes dans le spid";
		
			if(!is_array($array))
			{

				$message = "Service coupé pour ".$player; 
				$status = 'Echec';
				$designation = $message;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
				
			}
			elseif($lignes <= $spid)
			{
				$message = "Résultats SPID à jour pour ".$player." : ".$spid." en base de données ".$lignes." en ligne."; 
				$status = 'Echec';
				$designation = $message;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
				
				if($lignes == $spid)
				{
					$query4 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_spid = ? WHERE licence = ? AND saison = ?";
					$dbresult4 = $db->Execute($query4,array($aujourdhui,$licence,$saison_courante));
				}
				
				
			}
			else
			{
				$i = 0;
				$compteur = 0;
				$a = 0;//ce compteur sert au parties non récupérées par sit mens vide
				//on va compter les erreurs
				$error = 0;//le compteur d'erreurs
				$query1 = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ? AND licence = ?";
				$dbresult1 = $db->Execute($query1, array($saison_courante, $licence));
			//	foreach($array as $cle =>$tab)
				foreach($xml as $cle=> $tab)
				{
					//var_dump($array);
					$compteur++;
					
					$dateevent = (isset($tab->date)?"$tab->date":"");//$tab['date'];
					//echo "le dateevent est : ".$dateevent;
					$chgt = explode("/",$dateevent);
					$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];
					$annee = '20'.$chgt[2];
					$date_mysql = $annee.'-'.$chgt[1].'-'.$chgt[0];
					
						if (substr($chgt[1], 0,1)==0)
						{
							$mois_event = substr($chgt[1], 1,1);
							//echo "la date est".$date_event;
						}
						else
						{
							$mois_event = $chgt[1];
						}
						//echo "le mois est : ".$mois_event;
					//on va vérifier si on a la situation mensuelle du joueur du club à jour pour le mois en question
					$retour_sit_mens = ping_admin_ops::get_sit_mens($licence,$mois_event,$saison_courante);
					/*
					if($retour_sit_mens==0)
					{
						$designation.="Situation du mois ".$mois_event." manquante pour ".$player;
						$a++;
						$error++;
					}
					else
					{
					*/	
						$nom = (isset($tab->nom)?"$tab->nom":"");//$tab['nom'];
						//echo "le nom est : ".$nom;
						//on adapte son nom d'abord
						$nom_global = ping_admin_ops::get_name($nom);//une fonction qui permet d'extraire le nom et le prénom
						$nom_reel1 = $nom_global[0];
						$nom_reel = addslashes($nom_global[0]);//le nom					
						$prenom_reel = $nom_global[1];//le prénom
						$annee_courante = date('Y');
					
						$classement = (isset($tab->classement)?"$tab->classement":"");//$tab['classement'];//classement fourni par le spid
						$cla = substr($classement, 0,1);
							//Avec le nom on va aller chercher la situation mensuelle de l'adversaire
							//on pourra la stocker pour qu'elle re-serve et l'utiliser pour affiner le calcul des points
							//d'abord on va chercher ds la bdd si l'adversaire y est déjà pour le mois et la saison en question
							$query4 = "SELECT points FROM ".cms_db_prefix()."module_ping_adversaires WHERE nom = ? AND prenom = ? AND mois = ? AND annee = ?";
							//echo $query4.'<br />';
							$dbresult4 = $db->Execute($query4, array($nom_reel1, $prenom_reel,$mois_event,$annee_courante));

								if($dbresult4 && $dbresult4->RecordCount()>0 && $dbresult4->RecordCount() <2)//ok on a un enregistrement qui correspond
								{
									$row4 = $dbresult4->FetchRow();
									$newclass = $row4['points'];
								}
								//deuxième cas : 
								//on n'a pas d'enregistrement et on est dans le mois courant et l'année courante : on va chercher les points avec la classe pour ensuite l'insérer ds la bdd
								elseif($dbresult4->RecordCount()==0 && $mois_event == date('n') && $annee == date('Y'))
								{
									//on va chercher la sit mens du pongiste
								

									$service = new Service();
									$resultat = $service->getJoueursByName("$nom_reel", $prenom ="$prenom_reel");
									//var_dump($resultat);
									if(is_array($resultat) && count($resultat)>0 && count($resultat)<2)
									{//on a bien un tableau avec au moins un élément : c'est ok !

										//on a un résultat ?
										//echo "Glop";
										//$compteur++;
										$licen = $resultat[0]['licence'];//on a bien un numéro de licence, on peut donc récupérer la situation mensuelle en cours
										//echo $licen.'<br />';
										$service = new Service();
										$resultat2 = $service->getJoueur("$licen");

										if(is_array($resultat2) && count($resultat2)>0)
										{
											$licence2 = $resultat2['licence'];
											$nom = $resultat2['nom'];
											//echo 'autre nom : '.$nom .' '.$prenom;
											$prenom = $resultat2['prenom'];
											$natio = $resultat2['natio'];
											$clglob = $resultat2['clglob'];
											$point = $resultat2['point'];
											$aclglob = $resultat2['aclglob'];
											$apoint = $resultat2['apoint'];
											$clnat = $resultat2['clnat'];
											$categ = $resultat2['categ'];
											$rangreg = $resultat2['rangreg'];
											$rangdep = $resultat2['rangdep'];
											$valcla = $resultat2['valcla'];
											$clpro = $resultat2['clpro'];
											$valinit = $resultat2['valinit'];
											$progmois = $resultat2['progmois'];
											$progann = $resultat2['progann'];
											$annee_courante = date('Y');
											//on insère le tout dans la bdd
											$query5 = "INSERT INTO ".cms_db_prefix()."module_ping_adversaires (id,datecreated, datemaj, mois, annee, phase, licence, nom, prenom, points, clnat, rangreg,rangdep, progmois) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
											//echo $query5;
											$dbresultat5 = $db->Execute($query5,array($now,$now,$mois_event, $annee_courante, $phase, $licence2, $nom, $prenom, $point, $clnat, $rangreg, $rangdep, $progmois));
												//On vérifie que l'insertion se passe bien
											$newclass = $point;
										}
										else
										{
											if($cla == 'N'){
												$newclassement = explode('-', $classement);
												$newclass = $newclassement[1];
											}
											else 
											{
												$newclass = $classement;
											}
										}


									}
									else
									{
										if(count($resultat)>1)//homonymie, etc...
										{
											$designation.="Homonymie pour ".$player;
											$error++;
										}
										//echo "Pas Glop";
										if($cla == 'N'){
										$newclassement = explode('-', $classement);
										$newclass = $newclassement[1];
										}
										else 
										{
											$newclass = $classement;
										}
									}//fin du if is_array($resultat)
								}
								else
								{
									//troisième cas : 
									//on n'a pas les points et on n'est pas dans le mois courant, on n'insère pas et on utilise le classement fourni
									if($cla == 'N')
									{
										$newclassement = explode('-', $classement);
										$newclass = $newclassement[1];
									}
									else 
									{
										$newclass = $classement;
									}
								}
						//on va calculer la différence entre le classement de l'adversaire et le classement du joueur du club
						$query = "SELECT points FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND saison = ?";
						$dbresult = $db->Execute($query, array($licence,$mois_event,$saison_courante));
						//si la situation mensuelle du joueur du club n'existe pas ?
						//alors on n'enregistre pas le résultat et on le signale
						
							if ($dbresult && $dbresult->RecordCount() == 0)
							{
								//$designation.="Ecart non calculé";
								$ecart = 0;
								$error++;
							}
						

						$row = $dbresult->FetchRow();
						$points = $row['points'];
						$ecart_reel = $points - $newclass;
					
						//on calcule l'écart selon la grille de points de la FFTT
						$type_ecart = ping_admin_ops::CalculEcart($ecart_reel);
					
						$epreuve = (isset($tab->epreuve)?"$tab->epreuve":"");//$tab['epreuve'];
					// le joueur participe à cette compétition ? (pour les epreuves individuelles uniquement)
						$query_epreuve = "SELECT indivs, idepreuve FROM ".cms_db_prefix()."module_ping_type_competitions AS tc WHERE tc.name = ?";
						$dbepreuve = $db->Execute($query_epreuve,array($epreuve));
				
						if($dbepreuve && $dbepreuve->RecordCount()>0)
						{
							$row = $dbepreuve->FetchRow();
							$indivs = $row['indivs'];
							$indivs3 = $row['indivs'];
							//$type_compet_temp = $row['code_compet'];
							$idepreuve_temp = $row['idepreuve'];
					
							if($indivs == 1) //on est bien dans une compet individuelles
							{
								//on est bien dans le cadre d'une compet individuelle
								$query_participe = "SELECT * FROM ".cms_db_prefix()."module_ping_participe WHERE licence = ? AND idepreuve = ? AND date_debut = ?";
								$dbparticipe = $db->Execute($query_participe,array($licence,$idepreuve_temp,$date_mysql));
						
								if($dbparticipe->RecordCount()==0)//le joueur n'est pas inscrit, on le fait
								{
									$query_participe2 = "INSERT INTO ".cms_db_prefix()."module_ping_participe (licence,idepreuve,date_debut) VALUES (?, ?, ?)";
									$dbparticipe2 = $db->Execute($query_participe2, array($licence,$idepreuve_temp,$date_mysql));
								}
							}
						}
										
						// de quelle compétition s'agit-il ? 
						//On a la date et le type d'épreuve
						//on peut donc en déduire le tour via le calendrier
						//et le coefficient pour calculer les points via la table type_competitons
						//1 - on récupère le coefficient de la compétition
						$coeff = ping_admin_ops::coeff($epreuve,$licence);// la licence en cas de critérium fédéral(2 coeffs distincts)
						//var_dump($coeff);
						$coeff_reel_tmp = $coeff[0];
						
						//2 - on récupére le tour s'il existe
						//on va fdonc chercher dans la table calendrier
						$query = "SELECT numjourn FROM ".cms_db_prefix()."module_ping_calendrier WHERE idepreuve = ? AND (date_debut = ? OR date_fin = ?)";
						$resultat = $db->Execute($query, array($idepreuve_temp, $date_mysql,$date_mysql));

						if ($resultat && $resultat->RecordCount()>0){
							$row = $resultat->FetchRow();
							$numjourn = $row['numjourn'];
						}
						else
						{
							$numjourn = 0;//on insère dans le calendrier ? Ben oui !						
							//le code existe déjà ou pas ?
							$idepreuve = $idepreuve_temp;
							//on oublie pas le tag !
							$tag = ping_admin_ops::create_tag($idepreuve_temp,$indivs, $date_mysql, $date_mysql);
							$querycal = "INSERT INTO ".cms_db_prefix()."module_ping_calendrier (id,idepreuve,date_debut,date_fin,numjourn,tag, saison) VALUES ('', ?, ?, ?, ?, ?, ?)";
							$req = $db->Execute($querycal,array($idepreuve_temp,$date_mysql,$date_mysql,$numjourn,$tag, $saison_courante));							
						}
				
				
				
						//fin du point 2

						$victoire = (isset($tab->victoire)?"$tab->victoire":"");//$tab['victoire'];

							if ($victoire =='V')
							{
								$victoire = 1;
							}
							else 
							{
								$victoire = 0;
							}

						//on peut désormais calculer les points 
						$points1 = ping_admin_ops::CalculPointsIndivs($type_ecart, $victoire);
						$pointres = $points1*$coeff_reel_tmp;
						$forfait = (isset($tab->forfait)?"$tab->forfait":"");//$tab['forfait'];

				
						$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (id, saison, datemaj, licence, date_event, epreuve, nom, numjourn,classement, victoire,ecart,type_ecart, coeff, pointres, forfait) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$i++;
						//echo $query;
						$dbresultat3 = $db->Execute($query3,array($saison_courante,$now, $licence, $date_event, $epreuve, $nom, $numjourn, $newclass, $victoire,$ecart_reel,$type_ecart, $coeff_reel_tmp,$pointres, $forfait));

						if(!$dbresultat3)
							{
								$message = $db->ErrorMsg(); 
								$status = 'Echec';
								$designation = $message;
								$action = "mass_action";
								ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
							}				

							//on met à jour la date de maj des résultats SPID
					
					
				//	}//fin du if si la sit mens du joueur du club est dûment renseignée
					//on détruit le nb d'erreur
					unset($error);
				}//fin du foreach
				
				$comptage = $i;
				$query4 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_spid = ?, spid = ?,spid_total = ? WHERE licence = ? AND saison = ?";
				$dbresult4 = $db->Execute($query4,array($aujourdhui,$comptage,$compteur,$licence,$saison_courante));
				
				$status = 'Parties SPID';
				$designation .= $comptage." parties Spid sur ".$compteur."  de ".$player;
				if($a >0)
				{
					$designation.= " ".$a." parties Spid non récupérées (situation mensuelle manquante)";
				}
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);

			}//fin du if !is_array
		}//fin du while
	}//fin du if dbretour >0









  }//fin de la fonction
##
##
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
	$aujourdhui = date('Y-m-d');
	$designation = "";
	$annee_courante = date('Y');
	$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbretour = $db->Execute($query, array($licence));
	if ($dbretour && $dbretour->RecordCount() > 0)
	{
	    while ($row= $dbretour->FetchRow())
		{
		$player = $row['player'];
		$service = new Servicen();
		$page = "xml_partie_mysql";
		$var = "licence=".$licence;
		$lien = $service->GetLink($page, $var);
		$xml = simplexml_load_string($lien,'SimpleXMLElement', LIBXML_NOCDATA);
		if($xml === FALSE)
		{
			$array = 0;
			$lignes = 0;
			$message = "Service coupé"; 
			$status = 'Echec';
			$designation.= $message;
			$action = "mass_action";
			ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['partie']);
		}
		
		$fftt = ping_admin_ops::compte_fftt($licence);
		//var_dump($result);
		//le service est-il ouvert ?
		/**/
		//on teste le resultat retourné     

			
			if($lignes <= $fftt)
			{
				$message = "Parties FFTT à jour pour ".$player." : ".$fftt." en base de données ".$lignes." en ligne."; 
				$status = 'Echec';
				$designation.= $message;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
				$aujourdhui = date('Y-m-d');
				$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_fftt = ? WHERE licence = ? AND saison = ?";
				$dbresult4 = $db->Execute($query, array($aujourdhui,$licence,$saison_courante));
				
				
			}
			else
			{	
				$i = 0;
				$compteur = 0;
				foreach($xml as $cle =>$tab)
				{
					$compteur++;

					$licence = (isset($tab->licence)?"$tab->licence":"");
					$advlic = (isset($tab->advlic)?"$tab->advlic":"");
					$vd = (isset($tab->vd)?"$tab->vd":"");

						if ($vd =='V')
						{
							$vd = 1;
						}
						else 
						{
							$vd = 0;
						}

					$numjourn = (isset($tab->numjourn)?"$tab->numjourn":"");

						if(is_array($numjourn))
						{
							$numjourn = '0';
						}

					$codechamp = (isset($tab->codechamp)?"$tab->codechamp":"");

					//on essaie de déterminer le nom de cette compet ?
					$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competition WHERE code_compet = ?";

					$dateevent = (isset($tab->date)?"$tab->date":"");
					$chgt = explode("/",$dateevent);
					//on va en déduire la saison
					if($chgt[1] < 7)
					{
						//on est en deuxième phase
						//on sait donc que l'année est la deuxième année
						$annee_debut = '20'.$chgt[2]-1;
						$annee_fin = '20'.$chgt[2];

					}
					elseif($chgt[1]>=7)
					{
						//on est en première phase
						$annee_debut = '20'.$chgt[2];
						$annee_fin = '20'.$chgt[2]+1;
					}
					$saison = $annee_debut."-".$annee_fin;
					$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];
					//echo "la date est".$date_event;

				//	$date_event = conv_date_vers_mysql($dateevent);
					$advsexe = (isset($tab->advsexe)?"$tab->advsexe":"");
					$advnompre = (isset($tab->advnompre)?"$tab->advnompre":"");
					$pointres = (isset($tab->pointres)?"$tab->pointres":"");
					$coefchamp = (isset($tab->coefchamp)?"$tab->coefchamp":"");
					$advclaof = (isset($tab->advclaof)?"$tab->advclaof":"");

				/**/	$query = "SELECT licence,advlic, numjourn, codechamp, date_event, coefchamp FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND advlic = ? AND numjourn = ? AND codechamp = ? AND date_event = ? AND coefchamp = ?";
					$dbresult = $db->Execute($query, array($licence, $advlic, $numjourn, $codechamp, $date_event, $coefchamp));

					if($dbresult  && $dbresult->RecordCount() == 0) 
					{
						$query = "INSERT INTO ".cms_db_prefix()."module_ping_parties (id, saison, licence, advlic, vd, numjourn, codechamp, date_event, advsexe, advnompre, pointres, coefchamp, advclaof) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$i++;
						//echo $query;
						$dbresultat = $db->Execute($query,array($saison,$licence, $advlic, $vd, $numjourn, $codechamp, $date_event, $advsexe, $advnompre, $pointres, $coefchamp, $advclaof));

							if(!$dbresultat)
							{
								$designation.=$db->ErrorMsg(); 
							}
					}
				}
				
				$comptage = $i;
				$query4 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_fftt = ?,fftt = ? WHERE licence = ? AND saison = ?";
				$dbresult4 = $db->Execute($query4, array($aujourdhui,$comptage,$licence,$saison));
				
				$status = 'Parties FFTT';
				$designation.= "Récupération FFTT de ".$comptage." parties sur ".$compteur."  de ".$player;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);

			}//fin du if !is_array
		}//fin du while
		//unset();

	}//fin du if dbretour >0









  }//fin de la fonction

//la fonction ci-dessous récupère la situation mensuelle pour une ou plusieurs personnes
//Attention de ne pas mettre de messages de sortie autre que ds le journal
public function retrieve_sit_mens($licence)
  {
	//on vérifie si la situation mensuelle a déjà été prise en compte
	global $gCms;
	$ping = cms_utils::get_module('Ping'); 
	$db = cmsms()->GetDb();
	$now = trim($db->DBTimeStamp(time()), "'");
	$mois_courant = date('n');//Mois au format 1, 2, 3 etc....
	$annee_courante = date('Y');
	$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
	$mois_reel = $mois_courant - 1;
	$mois_sm = $mois_francais["$mois_reel"];
	$mois_sit_mens = $mois_sm." ".$annee_courante;
	$message = "";
	$saison = $ping->GetPreference('saison_en_cours');
	$phase = $ping->GetPreference('phase_en_cours');
	$query = "SELECT licence, mois FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($licence,$mois_courant,$saison));
	
	if($dbresult->RecordCount() == 0)
	{
		//La situation mensuelle du mois en cours n'existe pas, on l'ajoute.
		$service = new Servicen();
		$page = "xml_joueur";
		$var = "licence=".$licence;
		$lien = $service->GetLink($page, $var);
		$xml = simplexml_load_string($lien,'SimpleXMLElement', LIBXML_NOCDATA);
		if($xml === FALSE)
		{
			$lignes = 0;
			$array = 0;
			$result = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			//var_dump($array);
			//$lignes = count($array['joueur']);
		}
		//$result = $service->getJoueur("$licence");
		//var_dump($result);

			if(!is_array($array))
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
			else
			{
				foreach($xml as $result)
				{
					$licence2 = (isset($result->licence)?"$result->licence":"");
					$nom = (isset($result->licence)?"$result->nom":"");
					$prenom = (isset($result->licence)?"$result->prenom":"");
					$natio = (isset($result->licence)?"$result->natio":"");
					$clglob = (isset($result->licence)?"$result->clglob":"");
					$point = (isset($result->licence)?"$result->point":"");
					$aclglob = (isset($result->licence)?"$result->aclglob":"");
					$apoint = (isset($result->licence)?"$result->apoint":"");
					$clnat = (isset($result->licence)?"$result->clnat":"");
					$categ = (isset($result->licence)?"$result->categ":"");
					$rangreg = (isset($result->licence)?"$result->rangreg":"");
					$rangdep = (isset($result->licence)?"$result->rangdep":"");
					$valcla = (isset($result->licence)?"$result->valcla":"");
					$clpro = (isset($result->licence)?"$result->clpro":"");
					$valinit = (isset($result->licence)?"$result->valinit":"");
					$progmois = (isset($result->licence)?"$result->progmois":"");
					$progann = (isset($result->licence)?"$result->progann":"");
				}
				$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_sit_mens (id,datecreated, datemaj, mois, annee, phase, licence, nom, prenom, points, clnat, rangreg,rangdep, progmois,saison) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				//echo $query;
				$dbresultat = $db->Execute($query2,array($now,$now,$mois_courant, $annee_courante, $phase, $licence2, $nom, $prenom, $point, $clnat, $rangreg, $rangdep, $progmois, $saison));

					if(!$dbresultat)
					{
						$message = $db->ErrorMsg(); 
						$status = 'Echec';
						$designation = $message;
						$action = "mass_action";
						ping_admin_ops::ecrirejournal($now,$status, $designation,$action);

					}
					else
					{
						$status = 'Ok';
						$designation = "Situation ok pour ".$nom." ".$prenom;
						$action = 'mass_action';
						ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
						//on met la table recup à jour pour le joueur
						//Attention s'il s'agit d'un ajout !!
						//on vérifie d'abord l'existence du joueur ds la bdd
						$query4 = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ?";
						$dbresult4 = $db->Execute($query4, array($licence2));
						if($dbresult4->RecordCount() == 0)
						{
							$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id, saison, datemaj, licence, sit_mens) VALUES ('', ?, ?, ?, ?)";
							$dbresult3 = $db->Execute($query3, array($saison,$now, $licence2, $mois_sit_mens));
							
						}
						else
						{
							$query3 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET datemaj = ? , sit_mens = ? WHERE licence = ?";
							$dbresult3 = $db->Execute($query3, array($now, $mois_sit_mens, $licence2));
						}

						
					}


				//$message.="<li>La licence est ok</li>";
			}//fin du else	!is_array
		
	}
	else
	{
		//La situation mensuelle existe déjà !
	}
	



  }


} // end of class

#
# EOF
#
?>
