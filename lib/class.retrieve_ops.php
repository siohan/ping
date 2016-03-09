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
	$designation = "";
	$saison_courante = $ping->GetPreference('saison_en_cours');
	$now = trim($db->DBTimeStamp(time()), "'");
	$aujourdhui = date('Y-m-d');
	$error = 0;//le compteur d'erreurs
	$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player,cat FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbretour = $db->Execute($query, array($licence));
	if ($dbretour && $dbretour->RecordCount() > 0)
	{
	    while ($row= $dbretour->FetchRow())
		{
		$player = $row['player'];
		$cat = $row['cat'];
		if(substr($cat,0,1) =='S' || substr($cat,0,1) =='V')
		{
			$senior = 1;
		}
		else
		{
			$senior = 0;
		}
		//echo "senior ?".$senior;
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
					$query4 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_spid = ?,spid_total = ? WHERE licence = ? AND saison = ?";
					$dbresult4 = $db->Execute($query4,array($aujourdhui,$lignes,$licence,$saison_courante));
				}
				
				
			}
			else
			{
				$i = 0;
				$compteur = 0;
				$a = 0;//ce compteur sert au parties non récupérées par sit mens vide
				//on va compter les erreurs
				
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
											$query5 = "INSERT INTO ".cms_db_prefix()."module_ping_adversaires (id,datecreated, datemaj, mois, annee, licence, nom, prenom, points, clnat, rangreg,rangdep, progmois) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
											//echo $query5;
											$dbresultat5 = $db->Execute($query5,array($now,$now,$mois_event, $annee_courante, $licence2, $nom, $prenom, $point, $clnat, $rangreg, $rangdep, $progmois));
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
								//$error++;
							}
						

						$row = $dbresult->FetchRow();
						$points = $row['points'];
						$ecart_reel = $points - $newclass;
						$coeff = "0.00";//on attribue une valeur par défaut
						//on calcule l'écart selon la grille de points de la FFTT
						$type_ecart = ping_admin_ops::CalculEcart($ecart_reel);
					
						$epreuve = (isset($tab->epreuve)?"$tab->epreuve":"");//$tab['epreuve'];
						//il faut maintenant récupérer le idepreuve et le coeff
						//echo $epreuve;
						$queryepreuve = "SELECT coefficient, idepreuve,indivs FROM ".cms_db_prefix()."module_ping_type_competitions WHERE name = ?";
						$dbepreuve = $db->Execute($queryepreuve, array($epreuve));
						
						if($dbepreuve && $dbepreuve->RecordCount()>0)
						{
							$row = $dbepreuve->FetchRow();


								if($epreuve == 'Critérium fédéral')
								{
									if($senior == 1)
									{
										$coeff ="1.25";

									}
									else
									{
										$coeff = "1.00";
									}
								}
								else
								{
									$coeff = $row['coefficient'];

								}
							$idepreuve = $row['idepreuve'];
							$indivs = $row['indivs'];
						}
						
						//var_dump($coeff);
						//2 - on récupére le tour s'il existe
						//on va fdonc chercher dans la table calendrier
						$query = "SELECT numjourn FROM ".cms_db_prefix()."module_ping_calendrier WHERE idepreuve = ? AND (date_debut = ? OR date_fin = ?)";
						$resultat = $db->Execute($query, array($idepreuve, $date_mysql,$date_mysql));

						if ($resultat && $resultat->RecordCount()>0)
						{
							$row = $resultat->FetchRow();
							$numjourn = $row['numjourn'];
						}
						else
						{
							$numjourn = 0;
							//on insère dans le calendrier ? Ben oui !						
							//le code existe déjà ou pas ?
							//on fait une préférence !!
							if($ping->GetPreference('inclusion_spid_calendar')=='Oui')
							{
								//$idepreuve = $idepreuve_temp;
								//on oublie pas le tag !
								$tag = ping_admin_ops::create_tag($idepreuve,$indivs, $date_mysql, $date_mysql);
								$querycal = "INSERT INTO ".cms_db_prefix()."module_ping_calendrier (id,idepreuve,date_debut,date_fin,numjourn,tag, saison) VALUES ('', ?, ?, ?, ?, ?, ?)";
								$req = $db->Execute($querycal,array($idepreuve,$date_mysql,$date_mysql,$numjourn,$tag, $saison_courante));
							}
														
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
						$service2 = new ping_admin_ops();
						$points1 = $service2->CalculPointsIndivs($type_ecart, $victoire);
						$pointres = $points1*$coeff;
						$forfait = (isset($tab->forfait)?"$tab->forfait":"");//$tab['forfait'];

				
						$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (id, saison, datemaj, licence, date_event, epreuve, nom, numjourn,classement, victoire,ecart,type_ecart, coeff, pointres, forfait) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$i++;
						//echo $query;
						$dbresultat3 = $db->Execute($query3,array($saison_courante,$now, $licence, $date_event, $epreuve, $nom, $numjourn, $newclass, $victoire,$ecart_reel,$type_ecart, $coeff,$pointres, $forfait));

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
				$query4 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_spid,spid_total = ? WHERE licence = ? AND saison = ?";
				$dbresult4 = $db->Execute($query4,array($aujourdhui,$compteur,$licence,$saison_courante));
				
				$status = 'Parties SPID';
				$designation.= $comptage." parties Spid sur ".$compteur."  de ".$player;
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
		if($xml === FALSE || !is_array($xml))
		{
			$array = 0;
			$lignes = 0;
			$message = "Service coupé ou pas de résultats disponibles"; 
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
			//var_dump($xml);
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			//var_dump($array);
			$lignes = count($array['joueur']);
		}
		

			if($lignes == 0)
			{
				//le service est coupé ou la licence est inactive
				$row= $dbresult->FetchRow();
				$nom = $row['nom'];
				$prenom = $row['prenom'];
				$message.="Licence introuvable ou service coupé pour ".$licence." ".$prenom;
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
 	function retrieve_compets ($idorga,$type = '')
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		
		if($type == 'E')
		{
			$indivs = 0;
		}
		else
		{
			$indivs = 1;
		}
		$page = "xml_epreuve";
		//echo $page;
		$var = "organisme=".$idorga."&type=".$type;
		//echo $var;
		$service = new Servicen();
		$lien = $service->GetLink($page, $var);
		//echo "le lien est : ".$lien;
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);

		if($xml === FALSE)
		{
			// Le service est coupé
			$array = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['epreuve']);
		}

		//var_dump($result);
		/**/
		//on va tester si la variable est bien un tableau   
			if(!is_array($array) || $lignes == 0)  {

				$ping->SetMessage("Le service est coupé ou il n'y a pas encore de résultats");
				$ping->RedirectToAdminTab('epreuves');
			}

		///on initialise un compteur général $i
		$i=0;
		//on initialise un deuxième compteur
		$compteur=0;
		foreach($xml as $cle =>$tab)
		{

			$i++;
			$idepreuve = (isset($tab->idepreuve)?"$tab->idepreuve":"");
			$idorga  = (isset($tab->idorga)?"$tab->idorga":"");
			$libelle = (isset($tab->libelle)?"$tab->libelle":"");
			// 1- on vérifie si cette épreuve est déjà dans la base
			$query = "SELECT name FROM ".cms_db_prefix()."module_ping_type_competitions WHERE name = ?";
			$dbresult = $db->Execute($query, array($libelle));

				if($dbresult  && $dbresult->RecordCount() == 0) 
				{
					$query1 = "SHOW TABLE STATUS LIKE '".cms_db_prefix()."module_ping_equipes' ";
					$dbresult = $db->Execute($query1);
					$row = $dbresult->FetchRow();
					$record_id = $row['Auto_increment'];
					$tag = ping_admin_ops::tag($record_id, $idepreuve, $indivs);
					$query = "INSERT INTO ".cms_db_prefix()."module_ping_type_competitions (id, name, indivs, idepreuve,tag, idorga) VALUES ('', ?, ?, ?, ?, ?)";
					//echo $query;
					$compteur++;
					$dbresultat = $db->Execute($query,array($libelle,$indivs,$idepreuve,$tag,$idorga));

					if(!$dbresultat)
					{
						$designation .= $db->ErrorMsg();			
					}

				}
				//fin du if $dbresult


		}// fin du foreach
		
	}
	
//Cette fonction récupère les divisions de chaque épreuve
	function retrieve_divisions ($idorga,$idepreuve,$type = '')
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$fede = '100001';
		$zone = $ping->GetPreference('zone');
		$ligue = $ping->GetPreference('ligue');
		$dep = $ping->GetPreference('dep');
		$saison = $ping->GetPreference('saison_en_cours');
		$indivs = 1; //par défaut car on récupère les épreuves individuelles seulement
		$type = 'I';
		$page="xml_division";
		//on instancie la classe service
		$service = new Servicen();


			$var = "organisme=".$idorga."&epreuve=".$idepreuve."&type=".$type;
				//echo $valeur;
				if($idorga == $fede) {$scope = 'F';}
				if($idorga == $zone) {$scope = 'Z';}
				if($idorga == $ligue) {$scope = 'L';}
				if($idorga == $dep) {$scope = 'D';}
				//
				$lien = $service->GetLink($page,$var);
				//var_dump($lien);
				$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
				if($xml === FALSE )
				{
					//le service est coupé
					$array = 0;
					$lignes = 0;
				}
				else
				{
					$array = json_decode(json_encode((array)$xml), TRUE);
					$lignes = count($array['division']);
				
					//echo "le nb de lignes est : ".$lignes;
					$i=0;
					//on initialise un deuxième compteur
					$compteur=0;
					foreach($xml as $value)
					{

						$i++;
						$iddivision = htmlentities($value->iddivision);
						$libelle = htmlentities($value->libelle);

						// 1- on vérifie si cette épreuve est déjà dans la base
						$query = "SELECT iddivision FROM ".cms_db_prefix()."module_ping_divisions WHERE iddivision = ? AND idorga = ? AND saison = ? AND idepreuve = ?";
						$dbresult = $db->Execute($query, array($iddivision, $idorga,$saison,$idepreuve));

							if($dbresult  && $dbresult->RecordCount() == 0) 
							{
								$query = "INSERT INTO ".cms_db_prefix()."module_ping_divisions (id, idorga, idepreuve,iddivision,libelle,saison,indivs,scope) VALUES ('', ?, ?, ?, ?, ?, ?, ?)";
								//echo $query;
								$compteur++;
								$dbresultat = $db->Execute($query,array($idorga,$idepreuve,$iddivision,$libelle,$saison,$indivs,$scope));

								if(!$dbresultat)
								{
									$designation .= $db->ErrorMsg();			
								}

							}


					}// fin du foreach
				unset($scope);
				}
			//}//fin du premier foreach
		
	}
	
	function retrieve_div_tours ($idepreuve,$iddivision)
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$saison = $ping->GetPreference('saison_en_cours');
		$page = "xml_result_indiv";
		$var ="epr=".$idepreuve."&res_division=".$iddivision;
		
			$var.="&action=poule";

		
		$service = new Servicen();
		$lien = $service->GetLink($page, $var);
		
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		if($xml === FALSE)
		{
			//le service est coupé
			$array = 0;
			$lignes = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['tour']);
		}
		//echo "le nb de lignes est : ".$lignes;
		$i = 0;
		foreach($xml as $value)
		{
			//$libelle = $tab['libelle'];
			//$lien = $tab['lien'];
			$libelle = htmlentities($value->libelle);
			//on va extraire le tour
			$tour1 = explode(" ",$libelle);
			$tour2 = trim($tour1[0],'T');

			$lien = htmlentities($value->lien);
			$tab1 = explode("&",$value->lien);

			$tableau = trim($tab1[2], 'cx_tableau=');

			if($tableau != '')
			{
				
				//On a récupéré les éléments, on peut faire l'insertion dans notre bdd
				//on va d'abord vérifier si ces éléments sont présents ou on créé un index sur la table
				$query = "INSERT INTO ".cms_db_prefix()."module_ping_div_tours (id, idepreuve,iddivision,libelle, tour, tableau, lien,saison) VALUES ('', ?, ?, ?, ?, ?, ?, ?)";
				$dbresult = $db->Execute($query, array($idepreuve,$iddivision,$libelle,$tour2, $tableau,$lien,$saison));
				if($dbresult)
				{
				$i++;
				
				//et si on continuait ?
				//reprendre les infos ci dessus pour les traiter !
				//on pourrait préparer les différents tags : poule, classement, partie.
				//on met à tjour la table divisions pour dire qu'on a bien uploadé
				$uploaded = 1;
				$query2 = "UPDATE ".cms_db_prefix()."module_ping_divisions SET uploaded = ? WHERE iddivision = ? AND saison = ?";
				$dbresult2 = $db->Execute($query2, array($uploaded, $iddivision, $saison));
				
				//on écrit dans le journal
				$status = 'Ok';
				$action = 'retrieve_div_tours';
				$designation = $i." tour(s) inséré(s) pour l\'épreuve ".$idepreuve;
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
				}
			}




		}
	}
	function retrieve_div_parties ($idepreuve,$iddivision,$tableau,$valeur)
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$saison = $ping->GetPreference('saison_en_cours');
		$page = "xml_result_indiv";
		$var ="epr=".$idepreuve."&res_division=".$iddivision;
		
			$var.="&action=partie";

		
		$service = new Servicen();
		$lien = $service->GetLink($page, $var);
		
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		if($xml === FALSE)
		{
			//le service est coupé
			$array = 0;
			$lignes = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['partie']);
		}
		//echo "le nb de lignes est : ".$lignes;
		if($lignes != 0)
		{
			
			foreach($xml as $value)
			{
				//$libelle = $tab['libelle'];
				//$lien = $tab['lien'];
				$libelle = htmlentities($value->libelle);
				$vain = htmlentities($value->vain);
				$perd = htmlentities($value->perd);
				$forfait = htmlentities($value->forfait);


				$query = "INSERT INTO ".cms_db_prefix()."module_ping_div_parties (id, idepreuve,iddivision,tableau,libelle, vain,perd,forfait, saison) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?)";
				//echo $query;
				$dbresult = $db->Execute($query, array($idepreuve,$iddivision,$tableau,$libelle, $vain, $perd, $forfait,$saison));


			}
			//la requete a fonctionné, on peut mettre le statut du tour a "uploadé"
			$query2 = "UPDATE ".cms_db_prefix()."module_ping_div_tours SET uploaded_parties = 1 WHERE id = ?";
			$dbresult2 = $db->Execute($query2,array($valeur));
		}
		
		
		
	}
	function retrieve_div_classement ($valeur)
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$saison = $ping->GetPreference('saison_en_cours');
		$now = trim($db->DBTimeStamp(time()), "'");
		$designation = '';
		//on fait la requete
		$query = "SELECT idepreuve, iddivision,tableau,tour FROM ".cms_db_prefix()."module_ping_div_tours WHERE id = ?";
		$dbresult = $db->Execute($query, array($valeur));
		$row = $dbresult->FetchRow();
		$idepreuve = $row['idepreuve'];
		$iddivision = $row['iddivision'];
		$tableau = $row['tableau'];
		$tour = $row['tour'];
		
		
		$page = "xml_result_indiv";
		$var ="epr=".$idepreuve."&res_division=".$iddivision."&cx_tableau=".$tableau;
		
			$var.="&action=classement";

		//echo $var;
		$service = new Servicen();
		$lien = $service->GetLink($page, $var);
		
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		if($xml === FALSE )
		{
			//le service est coupé
			$array = 0;
			$lignes = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['classement']);
		}
		//echo "le nb de lignes est : ".$lignes;
		if($lignes != 0)
		{
			
			foreach($xml as $value)
			{
				//$libelle = $tab['libelle'];
				//$lien = $tab['lien'];
				$rang = htmlentities($value->rang);
				$nom = htmlentities($value->nom);
				$clt = htmlentities($value->clt);
				$club = htmlentities($value->club);

				//on fait une conditionnelle pour récupérer la licence du joueur du club
				$nom_equipes = $ping->GetPreference('nom_equipes');
				//$club2 = stristr($nom_equipes,$club)
				if(stristr($nom_equipes,$club) === 'true')
				{
					
					//ça match !!
					$cool = 1;
					//on ecrit dans le journal
					$status = 'Ok';
					$designation.= $nom." finit à la place ".$rang;
					$action = 'Récup classement';
					ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
				}
				$points = htmlentities($value->points);

				//On a récupéré les éléments, on peut faire l'insertion dans notre bdd			
				//On fait une conditionnelle pour inclure uniquement les gens du club ?
				//il fait faire une nouvelle préférence



				$query = "INSERT INTO ".cms_db_prefix()."module_ping_div_classement (id, idepreuve,iddivision,tableau,tour,rang, nom,clt,club,points, saison) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				//echo $query;
				$dbresult = $db->Execute($query, array($idepreuve,$iddivision,$tableau,$tour,$rang, $nom, $clt, $club, $points,$saison));

				if(!$dbresult)
				{
					$designation .= $db->ErrorMsg();
				}
				
				
			}
			//la requete a fonctionné, on peut mettre le statut du tour a "uploadé"
			$query2 = "UPDATE ".cms_db_prefix()."module_ping_div_tours SET uploaded_classement = 1 WHERE id = ?";
			$dbresult2 = $db->Execute($query2,array($valeur));
			$designation.= 'récup tableau '.$tableau.' du tour '.$tour.' de l\'épreuve '.$idepreuve;
			$status = 'OK';
			$action = 'div_classement';
			ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
		}
		
		
		
	}
	function retrieve_poule_rencontres( $iddiv,$idpoule,$cal,$idepreuve='' )
	{
		global $gCms;
		$db = cmsms()->GetDb();
		//echo "la valeur de cal est :".$cal;
		$ping = cms_utils::get_module('Ping');
		//require_once(dirname(__FILE__).'/function.calculs.php');
		//echo "glop2";	
		$aujourdhui = date('Ymd');
		$aujourdhui = new DateTime( $aujourdhui );
		$aujourdhui = $aujourdhui->format('Ymd');
		//var_dump($aujourdhui);
		$saison = $ping->GetPreference('saison_en_cours');
		$service = new Servicen();
		$page = "xml_result_equ";
		$var = "auto=1&D1=".$iddiv."&cx_poule=".$idpoule;
		$lien = $service->GetLink($page, $var);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//echo "la valeur de cal est :".$cal;
		if($xml === FALSE)
		{
			//le service est coupé
			$array = 0;
			$lignes = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['tour']);
		}
		//echo "le nb de lignes est : ".$lignes;
		//$result = $service->getPouleRencontres($iddiv,$idpoule);

		$designation = '';
		//var_dump($result);
		/**/
		//on va tester la valeur de la variable $result
		//cela permet d'éviter de boucler s'il n'y a rien dans le tableau
		
		if(!is_array($array))
		{ 

				//le tableau est vide, il faut envoyer un message pour le signaler
				$designation.= "le service est coupé";
				//$this->SetMessage("$designation");
				//$this->RedirectToAdminTab('poules');
		}   
		else
		{
		$i=0;
			foreach($xml as $cle =>$tab)
			{

				
				$libelle = (isset($tab->libelle)?"$tab->libelle":"");
				//echo $libelle;
				$extraction = substr($libelle,-8);
				$date_extract = explode('/', $extraction);
				$annee_date = $date_extract[2] + 2000;
				$date_event = $annee_date."-".$date_extract[1]."-".$date_extract[0];
				
				
				//var_dump( $date_event);
				$equa = (isset($tab->equa)?"$tab->equa":"");
				$equb = (isset($tab->equb)?"$tab->equb":"");

				//on fait quelque transformations des infos recueillies
				preg_match_all('#[0-9]+#',$libelle,$extract);
				$tour = $extract[0][0];


				$uploaded = 0;
				$nom_equipes = $ping->GetPreference('nom_equipes');
				$cluba = strpos($equa,$nom_equipes);
				$clubb = strpos($equb,$nom_equipes);

					if ($cluba !== false || $clubb !== false)
					{
						$club = 1;
						$affichage = 1;
					}
					else
					{
						$club = 0;
					}

				$scorea = (isset($tab->scorea)?"$tab->scorea":"");
				$scoreb = (isset($tab->scoreb)?"$tab->scoreb":"");
				$lien = (isset($tab->lien)?"$tab->lien":"");

				//
				//on vérifie que le score a bien été saisi
				//si le score est saisi on obtient un string pour les variables scorea et scoreb
				//sinon il s'agit d'un array	

					if(is_array($scorea) && is_array($scoreb))
					{
						//le score n'est pas parvenu ou le match n'a pas été joué
						//On l'enregistre qd même
						$scorea = 0;
						$scoreb = 0;
						$update = 0;		
					}
				
				
				if($cal == 'cal')
				{
					//on récupère tout sans rien mettre à jour
					//on vérifie si l'enregistrement est déjà là
					$query = "SELECT id,lien, scorea, scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE iddiv =? AND idpoule = ? AND date_event = ? AND equa = ? AND equb = ?";
					$dbresult = $db->Execute($query, array($iddiv,$idpoule, $date_event,$equa,$equb));

					//il n'y a pas d'enregistrement auparavant, on peut continuer

						if($dbresult->RecordCount() == 0) 
						{
							$query1 = "INSERT INTO ".cms_db_prefix()."module_ping_poules_rencontres (id,saison,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							//echo $query;
							$i++;
							$uploaded = 0;
							$dbresultat = $db->Execute($query1,array($saison,$idpoule, $iddiv, $club, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien));

								if(!$dbresultat)
								{
									$designation.= $db->ErrorMsg();


								}
								
								//on prépare le tag
							$indivs = 0;//puisqu'on est dans un contexte d'équipes
							$tag = "{Ping action='par-equipes'";
							$tag.=" idepreuve='$idepreuve'";

								if(isset($date_event) && $date_event !='')
								{
									$tag.= " date_debut='$date_event'";
								}
								if(isset($date_event) && $date_event !='')
								{
									$tag.= " date_fin='$date_event'";
								}
							$tag.="}";
							//On fait l'inclusion ds la bdd
							// on vérifie d'abord que l'enregistrement n'est pas déjà en bdd
							$query2 = "SELECT numjourn, date_debut, date_fin, idepreuve FROM ".cms_db_prefix()."module_ping_calendrier WHERE  numjourn = ? AND date_debut = ? AND date_fin =? AND idepreuve = ? ";//AND scorea !=0 AND scoreb !=0";
							$dbresult2 = $db->Execute($query2, array($tour, $date_event, $date_event,$idepreuve));

								if ($dbresult2->RecordCount()==0)
								{



										$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_calendrier (id,date_debut,date_fin,idepreuve, numjourn,tag,saison) VALUES ( '', ?, ?, ?, ?, ?, ?)";
										$dbresult3 = $db->Execute($query3, array($date_event,$date_event,$idepreuve,$tour,$tag,$saison));

										if($dbresult3)
										{
											$designation.= $db->ErrorMsg();
										}
										// on insert aussi dans CGCalendar ?
										// Chiche !
										/*
										(mysqli): INSERT INTO demo_module_cgcalendar_events
										           (event_id, event_title, event_summary, event_details,
										            event_date_start, event_date_end, event_parent_id,
										             event_recur_period, event_date_recur_end, event_created_by,
										            event_recur_nevents, event_recur_interval, event_recur_weekdays,
										            event_recur_monthdays, event_allows_overlap,event_all_day,
										          event_create_date, event_modified_date)
										            VALUES (2,'N1 - Charleville-Mézières','','&lt;p&gt;Le match de la mort&lt;/p&gt;','2016-03-12 17:00:00',NULL,-1,'none',NULL,-101,-1,1,'','',1,0,NOW(),NOW())
										*/
								}
						}
							

				
				}	
				if( $cal == 'all')
				{
					//on récupère tous les derniers résultats
					//var_dump($aujourdhui);
					//echo $date_event
					$date2 = new DateTime( $date_event );
					$date2 = $date2->format('Ymd');
					if($date2 <= $aujourdhui)
					{
						//echo "on est dans le passé";
						$query = "SELECT id,lien, scorea, scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE iddiv =? AND idpoule = ? AND date_event = ? AND equa = ? AND equb = ?";
						$dbresult = $db->Execute($query, array($iddiv,$idpoule, $date_event,$equa,$equb));

						//il n'y a pas d'enregistrement auparavant, on peut continuer

							if($dbresult->RecordCount() == 0) 
							{
								$query1 = "INSERT INTO ".cms_db_prefix()."module_ping_poules_rencontres (id,saison,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
								//echo $query;
								$i++;
								$uploaded = 0;
								$dbresultat = $db->Execute($query1,array($saison,$idpoule, $iddiv, $club, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien));

									if(!$dbresultat)
									{
										$designation.= $db->ErrorMsg();


									}
										//on prépare le tag
									$indivs = 0;//puisqu'on est dans un contexte d'équipes
									$tag = "{Ping action='par-equipes'";
									$tag.=" idepreuve='$idepreuve'";

										if(isset($date_event) && $date_event !='')
										{
											$tag.= " date_debut='$date_event'";
										}
										if(isset($date_event) && $date_event !='')
										{
											$tag.= " date_fin='$date_event'";
										}
									$tag.="}";
										//On fait l'inclusion ds la bdd
										// on vérifie d'abord que l'enregistrement n'est pas déjà en bdd
										$query8 = "SELECT numjourn, date_debut, date_fin, idepreuve FROM ".cms_db_prefix()."module_ping_calendrier WHERE  numjourn = ? AND date_debut = ? AND date_fin =? AND idepreuve = ? ";//AND scorea !=0 AND scoreb !=0";
										$dbresult8 = $db->Execute($query8, array($tour, $date_event, $date_event,$idepreuve));

											if ($dbresult8->RecordCount()==0)
											{



													$query9 = "INSERT INTO ".cms_db_prefix()."module_ping_calendrier (id,date_debut,date_fin,idepreuve, numjourn,tag,saison) VALUES ( '', ?, ?, ?, ?, ?, ?)";
													$dbresult9 = $db->Execute($query9, array($date_event,$date_event,$idepreuve,$tour,$tag,$saison));

													if($dbresult9)
													{
														$designation.= $db->ErrorMsg();
													}
											}
								
							}
							elseif($dbresult->RecordCount() >0)
							{
								//il y a déjà un enregistrement, le score est-il à jour ?
								$update = 1;
								$row = $dbresult->FetchRow();
								$id = $row['id'];
								$scoreA = $row['scorea'];
								$scoreB = $row['scoreb'];

									if($scoreA ==0 && $scoreB ==0)
									{
										$query3 = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET scorea = ?, scoreb = ? WHERE id = ?";
										$dbresultA = $db->Execute($query3, array($scorea, $scoreb, $id));
										$i++;
										if(!$dbresultA)
										{
											$designation.= $db->ErrorMsg();
										}
									}
							}
					}
				}
				else
				{
					//pas de valeur pour la variable $cal
					$query1 = "SELECT id,lien, scorea, scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE iddiv =? AND idpoule = ? AND date_event = ? AND equa = ? AND equb = ?";
					$dbresult1 = $db->Execute($query1, array($iddiv,$idpoule, $date_event,$equa,$equb));
					echo "on est dans la merde !";
					//il n'y a pas d'enregistrement auparavant, on peut continuer

						if($dbresult1->RecordCount() == 0) 
						{
							$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_poules_rencontres (id,saison,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							//echo $query;
							$i++;
							$uploaded = 0;
							$dbresultat = $db->Execute($query2,array($saison,$idpoule, $iddiv, $club, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien));

								if(!$dbresultat)
								{
									$designation.= $db->ErrorMsg();


								}
									//on prépare le tag
								$indivs = 0;//puisqu'on est dans un contexte d'équipes
								$tag = "{Ping action='par-equipes'";
								$tag.=" idepreuve='$idepreuve'";

									if(isset($date_event) && $date_event !='')
									{
										$tag.= " date_debut='$date_event'";
									}
									if(isset($date_event) && $date_event !='')
									{
										$tag.= " date_fin='$date_event'";
									}
								$tag.="}";
								//On fait l'inclusion ds la bdd
								// on vérifie d'abord que l'enregistrement n'est pas déjà en bdd
								$query3 = "SELECT numjourn, date_debut, date_fin, idepreuve FROM ".cms_db_prefix()."module_ping_calendrier WHERE  numjourn = ? AND date_debut = ? AND date_fin =? AND idepreuve = ? ";//AND scorea !=0 AND scoreb !=0";
								$dbresult3 = $db->Execute($query3, array($tour, $date_event, $date_event,$idepreuve));

									if ($dbresult3->RecordCount()==0)
									{



											$query4 = "INSERT INTO ".cms_db_prefix()."module_ping_calendrier (id,date_debut,date_fin,idepreuve, numjourn,tag,saison) VALUES ( '', ?, ?, ?, ?, ?, ?)";
											$dbresult4 = $db->Execute($query4, array($date_event,$date_event,$idepreuve,$tour,$tag,$saison));

											if($dbresult4)
											{
												$designation.= $db->ErrorMsg();
											}
									}
						}
						elseif($dbresult1->RecordCount() >0)
						{
								//il y a déjà un enregistrement, le score est-il à jour ?
								$update = 1;
								$row = $dbresult1->FetchRow();
								$id = $row['id'];
								$scoreA = $row['scorea'];
								$scoreB = $row['scoreb'];

									if($scoreA ==0 && $scoreB ==0)
									{
										$query5 = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET scorea = ?, scoreb = ? WHERE id = ?";
										$dbresultA = $db->Execute($query5, array($scorea, $scoreb, $id));
										$i++;
										if(!$dbresultA)
										{
											$designation.= $db->ErrorMsg();
										}
									}
						}
				
				}

				}
			
			
			}//fin du foreach
		}//fin du if is_array($result)
		
	
} // end of class

#
# EOF
#
?>
