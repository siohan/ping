<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class retrieve_ops
{
  function __construct() {}


##
##
public function retrieve_parties_spid2( $licence, $player,$cat )
  {
	global $gCms;
	$db = cmsms()->GetDb();
	$adherents = cms_utils::get_module('adherents');
	$ping = cms_utils::get_module('Ping');
	$designation = "";
	$saison_courante = $ping->GetPreference('saison_en_cours');
	$now = trim($db->DBTimeStamp(time()), "'");
	$aujourdhui = date('Y-m-d');
	$mois_courant = date('m');
	$annee_courante = date('Y');
	#
	#
	#Première chose : si jour est inférieur à 10 on ne fait rien on quitte
	if(date('d') < 10)
	{
		$designation.= "Résultats spid disponible à partir du 10 de chq mois !";
		$error = 1;
	}
	else
	{
		$ping_admin_ops = new ping_admin_ops();
		$points = $ping_admin_ops->get_sit_mens($licence,$mois_courant,$annee_courante);

		if($points == FALSE)//la situation mensuelle du joueur du club n'est pas renseignée !!
		{
			//on va chercher la situation manquante
			$sitMens = $this->retrieve_sit_mens($licence); //on va la chercher si possible


		}
		//on compte le nb de résultats du spid présent ds la bdd pour le joueur
		$ping_admin_ops = new ping_admin_ops();
		$spid = $ping_admin_ops->compte_spid($licence);
		$spid_errors = $ping_admin_ops->compte_spid_errors($licence);
		//$error = 0;//le compteur d'erreurs

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
		var_dump($xml);
		$array_points = array();

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


		//echo $spid." lignes dans le spid";

			/*if(!is_array($array))
			{

				$message = "Service coupé pour ".$player; 
				$status = 'Echec';
				$designation = $message;
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);

			}
			*/
			if($lignes < $spid)
			{
				$message = "Résultats SPID à jour pour ".$player." : ".$spid." en base de données ".$lignes." en ligne."; 
				$status = 'Echec';
				$designation.= $message;
				$action = "mass_action";
				$ecrire_journal = $ping_admin_ops->ecrirejournal($now,$status, $designation,$action);

				$update_spid = $ping_admin_ops->update_recup_parties($licence);


			}
			else
			{
				$i = 0;
				$compteur = 0;// ce compteur compte le nb total d'itération dans la boucle
				$a = 0;//ce compteur sert au parties non récupérées par sit mens vide
				//on va compter les erreurs
				//on initialise un tableau pour éviter de faire des requetes redondantes
				$array_classement = array();
				//on va faire une nouvelle conditionnelle pour déterminer si on récupère les résultats du mois en cours seulement ou non
				$query1 = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ? AND licence = ? AND MONTH(date_event) = ? AND YEAR(date_event) = ?";
				$dbresult1 = $db->Execute($query1, array($saison_courante, $licence,$mois_courant, $annee_courante));
			//	foreach($array as $cle =>$tab)
			 //si le jour courant est inférieur est inférieur à 10 on a une erreur douce
				if(date('d') < 10)
				{
					$error = 1;
				}
				foreach($xml as $cle=> $tab)
				{
					//var_dump($array);

					$compteur++;
					$error = 0;//on instancie un compteur d'erreurs

					//on synthétise tous les éléments à récupérer
					//on fera un éventuel traitement ensuite
					$dateevent = (isset($tab->date)?"$tab->date":"");//$tab['date'];

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
					if($mois_event == $mois_courant && $annee == $annee_courante)
					{
						$nom = (isset($tab->nom)?"$tab->nom":"");//$tab['nom'];
						$classement = (isset($tab->classement)?"$tab->classement":"");
						$victoire = (isset($tab->victoire)?"$tab->victoire":"");
						$forfait = (isset($tab->forfait)?"$tab->forfait":"");
						$epreuve = (isset($tab->epreuve)?"$tab->epreuve":"");//$tab['epreuve'];
						//on va vérifier si on a la situation mensuelle du joueur du club à jour pour le mois en question

						//echo "<br />le nom est : ".$nom;
						//on adapte son nom d'abord
						$nom_global = ping_admin_ops::get_name($nom);//une fonction qui permet d'extraire le nom et le prénom
						$nom_reel1 = $nom_global[0];
						$nom_reel = addslashes($nom_global[0]);//le nom					
						$prenom_reel = $nom_global[1];//le prénom
						$annee_courante = date('Y');
						//echo "<br /> Le nom final est : ".$nom_reel;

						//classement fourni par le spid
						$cla = substr($classement, 0,1);
							//Avec le nom on va aller chercher la situation mensuelle de l'adversaire
							//on pourra la stocker pour qu'elle re-serve et l'utiliser pour affiner le calcul des points
							//d'abord on va chercher ds la bdd si l'adversaire y est déjà pour le mois et la saison en question
							$get_adv_pts = $ping_admin_ops->get_adv_pts($nom_reel1, $prenom_reel,$mois_event,$annee_courante);


							//deuxième cas : 
							//on n'a pas d'enregistrement et on est dans le mois courant et l'année courante : on va chercher les points avec la classe pour ensuite l'insérer ds la bdd
							if($get_adv_pts == FALSE)//l'adversaire n'est pas ds la table adversaires
							{
								//on va chercher la sit mens du pongiste
								// D'abord son numéro de licence
								$resultat = retrieve_ops::advlicence($nom_reel, $prenom =$prenom_reel);
								//var_dump($resultat);
								if($resultat === FALSE)
								{
									//pas de résultat, on prend le classement fourni par défaut : erreur douce
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
								else
								{
									$licence_adv = $resultat;//on a bien un numéro de licence, on peut donc récupérer la situation mensuelle en cours
									//echo "<br />".$licence_adv.'<br />';

									$insert_adv = retrieve_ops::retrieve_sit_mens($licence_adv, $ext='True');
									//var_dump($insert_adv);
									//
									if($insert_adv === FALSE)//pas de résultats !
									{
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
									else
									{
										$newclass = $insert_adv;
									}
								}
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

						$ecart_reel = $points - $newclass;
						//$coeff = "0.00";//on attribue une valeur par défaut
						//on calcule l'écart selon la grille de points de la FFTT
						$type_ecart = ping_admin_ops::CalculEcart($ecart_reel);


						//il faut maintenant récupérer le idepreuve et le coeff
						//echo $epreuve;
						$type_coeff = $ping_admin_ops->coeff($epreuve,$senior);
						if($type_coeff == FALSE)
						{
							$error++;
						}

					
						//2 - on récupére le tour s'il existe
						//on va fdonc chercher dans la table calendrier
						$idepreuve  = $ping_admin_ops->code_compet($epreuve);

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
								$tag = $ping_admin_ops->create_tag($idepreuve,$indivs, $date_mysql, $date_mysql);
								$querycal = "INSERT INTO ".cms_db_prefix()."module_ping_calendrier (id,idepreuve,date_debut,date_fin,numjourn,tag, saison) VALUES ('', ?, ?, ?, ?, ?, ?)";
								$req = $db->Execute($querycal,array($idepreuve,$date_mysql,$date_mysql,$numjourn,$tag, $saison_courante));
							}

						}
						//fin du point 2

						//$tab['victoire'];

							if ($victoire =='V')
							{
								$victoire = 1;
							}
							else 
							{
								$victoire = 0;
							}

						//on peut désormais calculer les points 

						$points1 = $ping_admin_ops->CalculPointsIndivs($type_ecart, $victoire);
						$pointres = $points1*$type_coeff;
						//$tab['forfait'];

						if($error >0)
						{
							$statut = 0;
						}
						else
						{
							$statut = 1;
						}
						$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (id, statut,saison, datemaj, licence, date_event, epreuve, nom, numjourn,classement, victoire,ecart,type_ecart, coeff, pointres, forfait) VALUES ('',?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$i++;
						//echo $query;
						$dbresultat3 = $db->Execute($query3,array($statut,$saison_courante,$now, $licence, $date_event, $epreuve, $nom, $numjourn, $newclass, $victoire,$ecart_reel,$type_ecart, $type_coeff,$pointres, $forfait));

						if(!$dbresultat3)
							{
								$message = $db->ErrorMsg(); 
								$status = 'Echec';
								$designation = $message;
								$action = "mass_action";
								ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
							}				

							//on met à jour la date de maj des résultats SPID
					//on détruit le nb d'erreur
					unset($error);
					}
				}//fin du foreach
				$comptage = $i;

				$status = 'Parties SPID';
				$designation.= $comptage." parties Spid sur ".$compteur."  de ".$player;
				if($a >0)
				{
					$designation.= " ".$a." parties Spid non récupérées (situation mensuelle manquante)";
				}
				$action = "mass_action";
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);


			}//fin du if !is_array
	//	}//fin du while
	}
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
	$aujourdhui = date('Y-m-d');
	$designation = "";
	$annee_courante = date('Y');
	$lignes = 0; //on instancie le nb de lignes 0 par défaut
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
			//var_dump($xml);
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
				$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_fftt = ? WHERE licence = ?";
				$dbresult4 = $db->Execute($query, array($aujourdhui,$licence));
				
				
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
					//$advnompre = mysqli_real_escape_string($link,(isset($tab->advnompre)?"$tab->advnompre":""));
					$advnompre =(isset($tab->advnompre)?"$tab->advnompre":"");
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
				//on met à jour la table où sont stocké les données récupérées
				$fftt = ping_admin_ops::compte_fftt($licence);
				
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
public function retrieve_sit_mens($licence, $ext="")
  {
	//on vérifie si la situation mensuelle a déjà été prise en compte
	global $gCms;
	$ping = cms_utils::get_module('Ping'); 
	$adherents = cms_utils::get_module('Adherents');
	$ping_admin_ops = new ping_admin_ops();
	$db = cmsms()->GetDb();
	$now = trim($db->DBTimeStamp(time()), "'");
	$mois_courant = date('n');//Mois au format 1, 2, 3 etc....
	$annee_courante = date('Y');
	$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
	$mois_reel = $mois_courant - 1;
	$mois_sm = $mois_francais["$mois_reel"];
	$mois_sit_mens = $mois_sm." ".$annee_courante;
	$message = "";
	$saison = $adherents->GetPreference('saison_en_cours');
	$phase = $adherents->GetPreference('phase_en_cours');
	//var_dump($ext);
	//La situation mensuelle du mois en cours n'existe pas, on l'ajoute.
	$service = new Servicen();
	$page = "xml_joueur";
	$var = "licence=".$licence;
	$lien = $service->GetLink($page, $var);
	$xml = simplexml_load_string($lien,'SimpleXMLElement', LIBXML_NOCDATA);
	//var_dump($xml);
	if($xml === FALSE)
	{
		$lignes = 0;
		$array = 0;
		$result = 0;
		//var_dump($xml);
		return FALSE;
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
			
			$message.="Licence introuvable ou service coupé pour ".$licence;
			$status = 'Echec';
			$designation = $message;
			$action = "mass_action";
			ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
			return FALSE;
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
				//$progmois = (isset($result->licence)?"$result->progmois":"");
				//$progann = (isset($result->licence)?"$result->progann":"");
				
				//on peut faire qqs traitements pour calculer les progressions par exemples
				$progmoisplaces = $aclglob - $clglob;//progression en termes de places
				$progmois = $point - $apoint;//progression du mois en termes de points
				$progann = $point - $valinit; //progression à l'année en termes de points
				
				
				if( $ext === 'True')
				{

					$query5 = "INSERT INTO ".cms_db_prefix()."module_ping_adversaires (id,datecreated, datemaj, mois, annee, licence, nom, prenom, points, clnat, rangreg,rangdep, progmois) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					//echo $query5;
					$dbresultat5 = $db->Execute($query5,array($now,$now,$mois_courant, $annee_courante, $licence2, $nom, $prenom, $point, $clnat, $rangreg, $rangdep, $progmois));
					//On vérifie que l'insertion se passe bien
					if(!$dbresultat5)
					{
						$designation = $db->ErrorMsg();
						//echo $db->ErrorMsg();
						$status = 'Ko computer';
						$action = 'mass_action';
						ping_admin_ops::ecrirejournal($now,$status, $designation,$action);

					}
					else
					{
						return $point;
					}
					
				}
				else
				{
					
					$add_sitMens = $ping_admin_ops->add_sit_mens($licence2, $nom, $prenom, $categ, $point,$apoint,$clglob, $aclglob, $clnat, $rangreg, $rangdep, $progmoisplaces, $progmois, $progann,$valinit, $valcla, $saison);
				
						return  $point;
				}
				
				
			}
			
			
			
		}
	
	



  }
 	function retrieve_compets ($idorga,$type)
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$ping_admin_ops = new ping_admin_ops();
		$db = cmsms()->GetDb(); 
		$now = trim($db->DBTimeStamp(time()), "'");
		
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

		//var_dump($xml);
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
			$query = "SELECT idepreuve FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idepreuve = ?";
			$dbresult = $db->Execute($query, array($idepreuve));

				if($dbresult)//  && $dbresult->RecordCount() == 0) 
				{
					if($dbresult->RecordCount() == 0)
					{
						$query1 = "SHOW TABLE STATUS LIKE '".cms_db_prefix()."module_ping_equipes' ";
						$dbresult = $db->Execute($query1);
						$row = $dbresult->FetchRow();
						$record_id = $row['Auto_increment'];
						$tag = $ping_admin_ops->tag($record_id, $idepreuve, $indivs);
						$query = "INSERT INTO ".cms_db_prefix()."module_ping_type_competitions (id, name, indivs, idepreuve,tag, idorga) VALUES ('', ?, ?, ?, ?, ?)";
						//echo $query;
						$compteur++;
						$dbresultat = $db->Execute($query,array($libelle,$indivs,$idepreuve,$tag,$idorga));

						if(!$dbresultat)
						{
							$designation .= $db->ErrorMsg();			
						}
						else
						{
							//on ajoute ds le journal !
							//on peut écrire ds le journal
							$message = $libelle; 
							$status = 'Ok';
							//$designation.= $message;
							$action = "retrieve_ops";
							$ping_admin_ops->ecrirejournal($now,$status, $message,$action);

						}
					}
					else
					{
						//on est dans le cas d'un update
						$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET name = ? WHERE idepreuve = ? AND idorga = ?";
						$dbresult = $db->Execute($query, array($libelle, $idepreuve, $idorga));
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
		$now = trim($db->DBTimeStamp(time()), "'");
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
				var_dump($xml);
				if($xml === FALSE )
				{
					//le service est coupé
					$array = 0;
					$lignes = 0;
				}
				else
				{
					$array = json_decode(json_encode((array)$xml), TRUE);
					
					if(isset($array['division']))
					{
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
							$query = "SELECT iddivision FROM ".cms_db_prefix()."module_ping_divisions WHERE iddivision = ? AND idorga = ? AND idepreuve = ? AND saison = ?";
							$dbresult = $db->Execute($query, array($iddivision, $idorga,$idepreuve, $saison));

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
									else
									{
										//on peut écrire ds le journal
										$message = $idepreuve." - >".$idorga."->".$libelle." - >".$iddivision; 
										$status = 'Ok';
										//$designation.= $message;
										$action = "retrieve_ops";
										ping_admin_ops::ecrirejournal($now,$status, $message,$action);
										
									}

								}

								unset($message);
						}// fin du foreach
						
					}
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
	function retrieve_poule_rencontres( $iddiv,$idpoule,$cal,$idepreuve)
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
		//var_dump($xml);
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
				$renc_prep = explode('&',$lien);
				$renc_id_prep = explode('=',$renc_prep['4']);
				$renc_id = $renc_id_prep['1'];

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
				
				
				if(isset($cal) && $cal == 'cal')
				{
					//on récupère tout sans rien mettre à jour
					//on vérifie si l'enregistrement est déjà là
					$query = "SELECT id,lien, scorea, scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE iddiv =? AND idpoule = ? AND date_event = ? AND equa = ? AND equb = ?";
					$dbresult = $db->Execute($query, array($iddiv,$idpoule, $date_event,$equa,$equb));

					//il n'y a pas d'enregistrement auparavant, on peut continuer

						if($dbresult->RecordCount() == 0) 
						{
							$query1 = "INSERT INTO ".cms_db_prefix()."module_ping_poules_rencontres (id,renc_id,saison,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien) VALUES ('',?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							//echo $query;
							$i++;
							$uploaded = 0;
							$dbresultat = $db->Execute($query1,array($renc_id,$saison,$idpoule, $iddiv, $club, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien));

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
										$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idepreuve = ?";
										$dbresult = $db->Execute($query, array($idepreuve));
										$row = $dbresult->FetchRow();
										$name = $row['name'];
										
										retrieve_ops::insert_cgcalendar($name,$tag,$date_event,$date_event);
										
			
								}
						}
						else
						{
							$i++;
						}
							

				
				}	
				if( isset($cal) && $cal == 'all')
				{
					//on récupère tous les derniers résultats
					//var_dump($aujourdhui);
					//echo $date_event
					$date2 = new DateTime( $date_event );
					$date2 = $date2->format('Ymd');
					if($date2 <= $aujourdhui)
					{
						//echo "on est dans le passé";
						$query = "SELECT id,lien, scorea, scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE saison LIKE ? AND iddiv =? AND idpoule = ? AND date_event <= ? AND equa = ? AND equb = ?";
						$dbresult = $db->Execute($query, array($saison,$iddiv,$idpoule, $date_event,$equa,$equb));

						//il n'y a pas d'enregistrement auparavant, on peut continuer

							
							if($dbresult->RecordCount() >0)
							{
								//il y a déjà un enregistrement, le score est-il à jour ?
								$update = 1;
								$i++;
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
				//	echo "on est dans la merde !";
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
		//	echo " le compteur est ".$i;
			if($i >0)
			{
				$query_cal = "UPDATE ".cms_db_prefix()."module_ping_equipes SET calendrier = 1 WHERE idpoule = ? AND iddiv = ?";
				$dbcal = $db->Execute($query_cal,array($idpoule,$iddiv));
			}
        }//fin du if is_array($result)
	function retrieve_all_classements( $iddiv,$idpoule, $record_id )
	{
		global $gCms;
		$db = cmsms()->GetDb();
		//echo "la valeur de cal est :".$cal;
		$ping = cms_utils::get_module('Ping');
		//require_once(dirname(__FILE__).'/function.calculs.php');
		//echo "glop2";	
		$saison = $ping->GetPreference('saison_en_cours');
		$designation = '';
		$now = trim($db->DBTimeStamp(time()), "'");
		$aujourdhui = date('Ymd');
		$aujourdhui = new DateTime( $aujourdhui );
		$aujourdhui = $aujourdhui->format('Ymd');
		$service = new Servicen();
		$page = 'xml_result_equ';
		$var = "action=classement&auto=1&D1=".$iddiv."&cx_poule=".$idpoule;
		$lien = $service->GetLink($page, $var);
		$xml = simplexml_load_string($lien,'SimpleXMLElement', LIBXML_NOCDATA);
		if($xml === FALSE)
		{
			$array = 0;//$ping->SetMessage("Le service est coupé");
			//$ping->RedirectToAdminTab('equipes');
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['classement']);
		}
		//var_dump($xml);//$result = $service->getPouleClassement($iddiv, $idpoule);
		//var_dump($result);

		//on vérifie que le resultat est bien un array

		//tt va bien, on continue
		//on supprime tt ce qui était ds la bdd pour cette poule
		if(!is_array($array))
		{
			$status = "Ko";
			$designation= "le service est coupé pour l'équipe ".$record_id;
			$action = 'retrieve_classement';
			ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
		}
		else
		{
			
	
			$query = "DELETE FROM ".cms_db_prefix()."module_ping_classement WHERE iddiv = ? AND idpoule= ?  AND saison = ? AND idequipe = ?";
			$dbresult = $db->Execute($query, array($iddiv, $idpoule,$saison,$record_id));
			
			if(!$dbresult)
			{
				echo $db->ErrorMsg();
			}
			$i=0;//on initialise un compteur 
			//on récupère le résultat et on fait le foreach
			foreach($xml as $cle =>$tab)
			{
				$poule = (isset($tab->poule)?"$tab->poule":"");
				$clt = (isset($tab->clt)?"$tab->clt":"");
				$equipe = (isset($tab->equipe)?"$tab->equipe":"");
				$joue = (isset($tab->joue)?"$tab->joue":"");
				$pts = (isset($tab->pts)?"$tab->pts":"");

				$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_classement (id,idequipe, saison, iddiv, idpoule, poule, clt, equipe, joue, pts) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				//echo $query2;
				$dbresultat = $db->Execute($query2, array($record_id,$saison, $iddiv, $idpoule,$poule, $clt, $equipe, $joue,$pts));

			
			}
			$designation.="Récupération du classement de la poule : ".$poule;
			$status = "Ok";
			
			
		}
		$action = 'getPouleclassement';
		ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
	}
	
	function insert_cgcalendar ($name,$tag,$date_debut,$date_fin)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		//on vérifie d'abord que l'événement n'est pas déjà ds la base
		$query = "SELECT event_title, event_date_start FROM ".cms_db_prefix()."module_cgcalendar_events WHERE event_title = ? AND event_date_start = ? AND event_date_end = ?";
		$dbresult = $db->Execute($query, array($name, $date_debut, $date_fin ));
		if($dbresult && $dbresult->RecordCount() == 0)
			{
				// on récupère id ds différentes tables
				//Tout d'abord celui de la table events
				$query1 = "SELECT id FROM ".cms_db_prefix()."module_cgcalendar_events_seq";
				$dbresult1 = $db->Execute($query1);
				$row = $dbresult1->FetchRow();
				$id_event = $row['id']+1;
				$query_cal = "INSERT INTO ".cms_db_prefix()."module_cgcalendar_events
				           (event_id, event_title, event_details, event_date_start, event_date_end)
				            VALUES (?, ?, ? , ?, ?)";
				$dbresult_cal = $db->Execute($query_cal, array($id_event,$name,$tag,$date_debut,$date_fin));
				//on insère aussi l'événement dans une categorie par défaut la générale donc 1
				$cat = 1;
				$query_cat = "INSERT INTO ".cms_db_prefix()."module_cgcalendar_events_to_categories (category_id, event_id) VALUES (?,?)";
				$dbresult_cat = $db->Execute($query_cat, array($cat,$id_event));
				//on modifie le events_seq
				$query = "UPDATE ".cms_db_prefix()."module_cgcalendar_events_seq SET id = id+1";
				$dbresult = $db->Execute($query);
			}
	}
	function retrieve_users ()
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$club_number = $ping->GetPreference('club_number');
		
		
			$page = "xml_licence_b";
			$service = new Servicen();
			//paramètres nécessaires 
			$var="club=".$club_number;
			$lien = $service->GetLink($page,$var);
			//echo $lien;
			//var_dump($lien);
			$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
			//var_dump($xml);
			if($xml === FALSE)
			{
				$array = 0;
				$lignes = 0;
			}
			else
			{
				$array = json_decode(json_encode((array)$xml), TRUE);
				$lignes = count($array['licence']);
			}
			//echo "le nb de lignes est : ".$lignes;
			if($lignes == 0)
			{
				$message = "Pas de lignes à récupérer !";
				$this->SetMessage("$message");
				//$this->RedirectToAdminTab('joueurs');
			}
			else
			{
				//on supprime l'existant ? Oui.
				$query2 = "DELETE FROM ".cms_db_prefix()."module_ping_joueurs";
				$dbresult2 = $db->Execute($query2);


					$i =0;//compteur pour les nouvelles inclusions
					$a = 0;//compteur pour les mises à jour
					foreach($xml as $tab)
					{
						//$licence = (isset($tab->licence)?"$tab->licence":"");
						$licence = (isset($tab->licence)?"$tab->licence":"");
						$nom = (isset( $tab->nom)?"$tab->nom":"");
						$prenom = (isset($tab->prenom)?"$tab->prenom": "");
						$nclub = (isset($tab->numclub)?"$tab->numclub":"");
						$actif = 0;
						$sexe = (!empty($tab->sexe)?"$tab->sexe":"");
						$type = (!empty($tab->type)?"$tab->type" :"");
						$certif = (!empty($tab->certif)?"$tab->certif":"");
						$validation = (!empty($tab->validation)?"$tab->validation":"");
						$echelon = (!empty($tab->echelon)?"$tab->echelon":"");

						$place = (!empty($tab->place)?"$tab->place":"");
						$point = (!empty($tab->point)?"$tab->point":"");
						$cat = (!empty($tab->cat)?"$tab->cat":"");


						//$designation = 'récupération des joueurs';

						$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
						$dbresult = $db->Execute($query, array($licence));

						if($dbresult  && $dbresult->RecordCount() == 0) 
						{
							$query = "INSERT INTO ".cms_db_prefix()."module_ping_joueurs (id, licence, nom, prenom,actif, sexe, type, certif, validation, echelon, place, point, cat) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							$dbresultat = $db->Execute($query,array($licence,$nom, $prenom,$actif, $sexe, $type, $certif, $validation, $echelon,$place,$point, $cat));
							$i++;

							if($dbresultat)
							{

								//on le pousse dans la table des récupération
								$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ? ";
								$dbresult = $db->Execute($query, array($licence));
								$count = $dbresult->RecordCount();
								if($count==0)//on est ok , pas d'enregistrement correspondant
								{
									//on fait la totale en récupérant toutes les données ?
									//où on laisse l'admin le faire ?
									//pour l'heure on fait le mini
									$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id,datemaj, licence, sit_mens,fftt,maj_fftt,spid,maj_spid,maj_total,spid_total) VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
									$dbresult2 = $db->Execute($query2, array($now,$licence,'Janvier 2000',0,0,0,0,0,0));

									//on teste la requete
									if(!$dbresult2)
									{
										//une erreur ? laquelle ?
										$message = $db->ErrorMsg();
										$status = 'Pb Joueur poussé';
										$action = 'push_player';
										ping_admin_ops::ecrirejournal($now,$status,$message,$action);


									}
									else //tout s'est bien passé
									{
										//on écrit dans le journal
										$status = 'Joueur poussé';
										$designation = 'joueur poussé : '.$licence;
										$action = 'push_player';
										ping_admin_ops::ecrirejournal($now,$status,$designation,$action);

									}

								}
								//on écrit dans le journal
								$status = 'Ok';
								$message = "Inclusion de ".$nom." ".$prenom;
								$action = "retrieve_users";
								ping_admin_ops::ecrirejournal($now,$status,$message,$action);
							}

						}
						else
						{
							//le joueur existe déjà , on fait un upgrade
							//on vérifie
							$a++;
							$query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET actif = ?,sexe = ?, type = ?, certif = ?, validation = ?, echelon = ?, place = ?, point = ?, cat = ? WHERE licence = ?";
							$dbresult = $db->Execute($query, array($actif,$sexe, $type, $certif,$validation, $echelon, $place, $point, $cat, $licence));
						}		


					}// fin du foreach
			//	$ping->Redirect($id,'retrieve',$returnid,$params = array("retrieve"=>"users","direction"=>"fftt"));

			
		}
	}//fin de la fonction
	function retrieve_users_fftt()
	{
		global $gCms;
		$adherents = new adherents();
		$ping = cms_utils::get_module('Ping');
		$saison = $ping->GetPreference ('saison_en_cours');
		$ping_ops = new ping_admin_ops();
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$aujourdhui = date('Y-m-d');
		$club_number = $adherents->GetPreference('club_number');
		//echo $club_number;
		
		
			$page = "xml_liste_joueur";
			$service = new Servicen();
			//paramètres nécessaires 
			
			$var = "club=".$club_number;
			$lien = $service->GetLink($page,$var);
			//echo $lien;
			$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
			//var_dump($xml);
			
			if($xml === FALSE)
			{
				$array = 0;
				$lignes = 0;
				return FALSE;
			}
			else
			{
				$array = json_decode(json_encode((array)$xml), TRUE);
				$lignes = count($array['joueur']);
			}
			//echo "le nb de lignes est : ".$lignes;
			if($lignes == 0)
			{
				$message = "Pas de lignes à récupérer !";
				//$this->SetMessage("$message");
				//$this->RedirectToAdminTab('joueurs');
			}
			else
			{
				//on supprime tt
				$query = "TRUNCATE TABLE ".cms_db_prefix()."module_ping_joueurs";
				$dbresult = $db->Execute($query);
				if($dbresult)
				{
					$i =0;//compteur pour les nouvelles inclusions
					$a = 0;//compteur pour les mises à jour
					$joueurs_ops = new ping_admin_ops();
					foreach($xml as $tab)
					{
						$licence = (isset($tab->licence)?"$tab->licence":"");
						$nom = (isset($tab->nom)?"$tab->nom":"");
						$prenom = (isset($tab->prenom)?"$tab->prenom":"");
						$club = (isset($tab->club)?"$tab->club":"");
						$nclub = (isset($tab->nclub)?"$tab->nclub":"");
						$clast = (isset($tab->clast)?"$tab->clast":"");
						$actif = 1;

						$insert = $joueurs_ops->add_joueur($actif, $licence, $nom, $prenom, $club, $nclub, $clast);
						$player_exists = $joueurs_ops->player_exists($licence);
						var_dump($player_exists);
						if($insert === TRUE && $player_exists === FALSE)
						{
							$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (saison, datemaj, licence, sit_mens, fftt, maj_fftt, spid, maj_spid) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
							$dbresult = $db->Execute($query, array($saison,$aujourdhui,$licence,'Janvier 2000', '0', '1970-01-01', '0', '1970-01-01'));
							
						}//$a++;
					 	

					}// fin du foreach
					
				}
				
			}
			//on redirige sur l'onglet joueurs
			
		
		
		
	}//fin de la fonction
	function advlicence ($nom,$prenom="")
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		//echo "le nom est : ".$nom;
		//echo "<br /> le prénom est : ".$prenom;
		$nom_final = str_replace(' ','%20',$nom);
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$saison = $ping->GetPreference('saison_en_cours');
		$page = "xml_liste_joueur";
		$var ="nom=".$nom_final."&prenom=".$prenom;
		$lignes = 0;
		
		//	$var.="&action=poule";

		
		$service = new Servicen();
		$lien = $service->GetLink($page, $var);
		//echo "<br />".$lien."<br />";
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
			$lignes = count($array['joueur']);
		}
		//echo "le nb de lignes est : ".$lignes;
		$i = 0;
		
		if($lignes >0 )//&& $lignes <2)//un seul joueur
		{
			foreach($xml as $tab)
			{
				$licence = (isset($tab->licence)?"$tab->licence":"");
				//echo "la licence est : <br />".$licence;
				$nom = (isset($tab->nom)?"$tab->nom":"");
				$prenom = (isset($tab->prenom)?"$tab->prenom":"");
				$club = (isset($tab->club)?"$tab->club":"");
				$nclub = (isset($tab->classement)?"$tab->classement":"");
				$clast = (isset($tab->clast)?"$tab->clast":"");
				
				
			}
			return $licence;
		}
		else
		{
			return FALSE;
		}
			
	}
	
	function retrieve_teams ($type)
	{
		global $gCms;
		$adherents = new adherents();
		$ping = cms_utils::get_module('Ping');
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$club_number = $adherents->GetPreference('club_number');
		//echo $club_number;
		$saison= $ping->GetPreference('saison_en_cours');
		$service = new Servicen();
		
			$page = "xml_equipe";
			$var = "numclu=".$club_number;

				if (isset($type) && $type == 'U')
				{
					//$result = $service->getEquipesByClub("$club_number");

					$chpt = "A"; //pour autres championnat
					$type_compet = 'U';//pour undefined
					$var.="";
				}
				elseif($type =='M')
				{

					$type_compet = '1';
					$var.="&type=M";
				}
				elseif($type == 'F')
				{
					$var.="&type=F";
					$type_compet = '1';

				}
				$lien = $service->GetLink($page,$var);
				$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
				//var_dump($xml);
				if($xml === FALSE)// || strlen($xml) <=1)
				{
					
					//$this->SetMessage("Le service est coupé");
					echo "une erreur est apparue ou déjà en bdd";
					$status = 'Echec';
					$designation='Pas d\'équipes à télécharger !';
					$action = "retrieve_teams";
					$message = $ping->ecrirejournal($now,$status, $designation,$action);
					
				}
				else
				{
					$array = json_decode(json_encode((array)$xml), TRUE);
					
						$i=0;
						//on initialise un deuxième compteur
						$compteur = 0;
						foreach($xml as $cle =>$tab)
						{

							$i++;
							$libequipe = (isset($tab->libequipe)?"$tab->libequipe":"");
							$idepreuve = (isset($tab->idepr)?"$tab->idepr":"");
							//on modifie le libellé des équipes pour extraire la phase
							$newphase = explode ("-",$libequipe);
							//echo "la phase est ".$newphase[1];
							$phase = substr($newphase[1], -1);
							$new_equipe = trim(html_entity_decode($newphase[0]));
							//echo "la phase est ".$phase;

							$libdivision = (isset($tab->libdivision)?"$tab->libdivision":"");
							$liendivision = (isset($tab->liendivision)?"$tab->liendivision":"");
							$tableau = parse_str($liendivision, $output);
							//echo $tableau;
							$idpoule = $output['cx_poule'];
							$iddiv = $output['D1'];
							$idorga = $output['organisme_pere'];





							//$type_compet = $type;


							$query = "SELECT saison, phase, libequipe,idpoule, iddiv FROM ".cms_db_prefix()."module_ping_equipes WHERE libequipe LIKE ? AND phase = ? AND iddiv = ? AND idpoule = ?";
							$dbresult = $db->Execute($query, array($new_equipe,$phase, $iddiv, $idpoule));

								if($dbresult->RecordCount() == 0) 
								{
									$ping_admin_ops = new ping_admin_ops();
									//On va essayer de créer un tag pour aider à afficher les équipes
									//On récupère le mast_insert_id d'abord
									$query1 = "SHOW TABLE STATUS LIKE '".cms_db_prefix()."module_ping_equipes' ";
									$dbresult1 = $db->Execute($query1);
									$row = $dbresult1->FetchRow();
									$record_id = $row['Auto_increment'];
									$tag = $ping_admin_ops->tag_equipe($record_id);
									$calendrier = 0;
									$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_equipes (id, saison, phase, libequipe, libdivision, liendivision, idpoule, iddiv, type_compet, tag, idepreuve, calendrier) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
									//echo $query2;
									$compteur++;
									$dbresultat = $db->Execute($query2,array($saison, $phase, $new_equipe, $libdivision, $liendivision, $idpoule, $iddiv, $type_compet, $tag,$idepreuve, $calendrier));

									if(!$dbresultat)
									{
										$designation = $db->ErrorMsg();	
										//echo $designation;		
									}

								}
								elseif(!$dbresult)
								{
									echo "une erreur est apparue ou déjà en bdd";
								}//fin du if $dbresult


						}// fin du foreach
				}
			//var_dump($xml);
			/*

			*/
			//on va tester si la variable est bien un tableau   
			/**/	

			///on initialise un compteur général $i
		
			
		
	}//fin de la fonction
	
	//pour les organismes
	function organismes()
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$designation = '';
		$tableau = array('F','Z','L','D');
		//on instancie la classe servicen
		$service = new Servicen();
		$page = "xml_organisme";
		foreach($tableau as $valeur)
		{
			$var = "type=".$valeur;
			//echo $var;
			$scope = $valeur;
			//echo "la valeur est : ".$valeur;
			$lien = $service->GetLink($page,$var);
			//echo $lien;
			$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
			if($xml === FALSE)
			{
				$designation.= "service coupé";
				$now = trim($db->DBTimeStamp(time()), "'");
				$status = 'Echec';
				$action = 'retrieve_ops';
				ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
			}
			else
			{
				$array = json_decode(json_encode((array)$xml), TRUE);
				///on initialise un compteur général $i
				$i=0;
				//on initialise un deuxième compteur
				$compteur=0;
			//	var_dump($xml);

					foreach($xml as $cle =>$tab)
					{

						$i++;
						$idorga = (isset($tab->id)?"$tab->id":"");
						$code  = (isset($tab->code)?"$tab->code":"");
						$libelle = (isset($tab->libelle)?"$tab->libelle":"");
						// 1- on vérifie si cette épreuve est déjà dans la base
						$query = "SELECT idorga FROM ".cms_db_prefix()."module_ping_organismes WHERE idorga = ?";
						$dbresult = $db->Execute($query, array($idorga));

							if($dbresult  && $dbresult->RecordCount() == 0) 
							{
								$query = "INSERT INTO ".cms_db_prefix()."module_ping_organismes (id, libelle, idorga, code, scope) VALUES ('', ?, ?, ?, ?)";
								//echo $query;
								$compteur++;
								$dbresultat = $db->Execute($query,array($libelle,$idorga,$code,$scope));

								if(!$dbresultat)
								{
									$designation.= $db->ErrorMsg();			
								}

							}
							


					}// fin du foreach

			}
			unset($scope);
			unset($var);
			unset($lien);
			unset($xml);
			sleep(1);
		}//fin du premier foreach
		

		$designation.= $compteur." organisme(s) récupéré(s)";
		$now = trim($db->DBTimeStamp(time()), "'");
		$status = 'Ok';
		$action = 'retrieve_ops';
		ping_admin_ops::ecrirejournal($now,$status,$designation,$action);

			
		
	}//fin de la fct pour les organismes
	function retrieve_detail_club ($club_number)
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$service = new Servicen();
		$page = "xml_club_detail";
		$var = "club=".$club_number;
		$lien = $service->GetLink($page,$var);
		//echo $lien;
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		/*
		if($xml === FALSE)
		{
			$designation.= "service coupé";
			$now = trim($db->DBTimeStamp(time()), "'");
			$status = 'Echec';
			$action = 'retrieve_ops';
			ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			///on initialise un compteur général $i
			$i=0;
			//on initialise un deuxième compteur
			$compteur=0;

				foreach($xml as $cle =>$tab)
				{

					$i++;
					$idclub = (isset($tab->idclub)?"$tab->idclub":"");
					$numero  = (isset($tab->numero)?"$tab->numero":"");
					$nomsalle = (isset($tab->nomsalle)?"$tab->nomsalle":"");
					$adressesalle1 = (isset($tab->adressesalle1)?"$tab->adressesalle1":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
		}
		*/
	}
	
	function calendrier( $iddiv,$idpoule,$idepreuve,$libequipe)
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
		//var_dump($xml);
		/**/
		//on va tester la valeur de la variable $result
		//cela permet d'éviter de boucler s'il n'y a rien dans le tableau
		
		if(!is_array($array))
		{ 

				//le tableau est vide, il faut envoyer un message pour le signaler
				$designation.= "le service est coupé";
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
			
				preg_match_all("/$libequipe/",$equa,$compa);
				preg_match_all("/$libequipe/",$equb,$compb);
		
				if((true === is_array($compa[0]) && count($compa[0]) > 0) || (true === is_array($compb[0]) && count($compb[0]) > 0))
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
				$renc_prep = explode('&',$lien);
				$renc_id_prep = explode('=',$renc_prep['4']);
				$renc_id = $renc_id_prep['1'];

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
				
				
			
					//on récupère tout sans rien mettre à jour
					//on vérifie si l'enregistrement est déjà là
					$query = "SELECT id,lien, scorea, scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE iddiv =? AND idpoule = ? AND date_event = ? AND equa = ? AND equb = ?";
					$dbresult = $db->Execute($query, array($iddiv,$idpoule, $date_event,$equa,$equb));

					//il n'y a pas d'enregistrement auparavant, on peut continuer

						if($dbresult->RecordCount() == 0) 
						{
							$query1 = "INSERT INTO ".cms_db_prefix()."module_ping_poules_rencontres (id,renc_id,saison,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien) VALUES ('',?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							//echo $query;
							$i++;
							$uploaded = 0;
							$dbresultat = $db->Execute($query1,array($renc_id,$saison,$idpoule, $iddiv, $club, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien));

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
										
										
			
								}
								// on insert aussi dans CGCalendar ?
								// Chiche !
								$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idepreuve = ?";
								$dbresult = $db->Execute($query, array($idepreuve));
								$row = $dbresult->FetchRow();
								$name = $row['name'];
								
								retrieve_ops::insert_cgcalendar($name,$tag,$date_event,$date_event);
						}
						elseif($dbresult->RecordCount() >0)
						{
								//il y a déjà un enregistrement, le score est-il à jour ?
								$update = 1;
								

									if($scoreA ==0 && $scoreB ==0)
									{
										$query5 = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET scorea = ?, scoreb = ? WHERE renc_id = ?";
										$dbresultA = $db->Execute($query5, array($scorea, $scoreb, $renc_id));
										$i++;
										if(!$dbresultA)
										{
											$designation.= $db->ErrorMsg();
										}
									}
						}
							

			}//fin du foreach	
				
        	}//fin du if is_array($result)
	}//fin de la fonction
} // end of class

#
# EOF
#
?>
